<?php

namespace Lce;

use Lce\Exception\ConnectionErrorException;
use Lce\Exception\NotLceException;
use Lce\Exception\UnknownEnvironmentException;
use Lce\Exception\LceException;
use Lce\Resource\Product;
use Lce\Resource\Quote;

class Lce {
  
  const VERSION = '0.0.1-dev';
  public $login, $server, $version, $env;
  public $servers = array(
    "development" => "http://localhost:9000",
    "staging" => "https://test.lce.io",
    "production" => "https://api.lce.io"
  );
  private $password;
  
  public function __construct($login, $password, $env = 'staging', $version = '1') {
    if(!array_key_exists($env, $this->servers)){
      throw new UnknownEnvironmentException($env." is not a valid environment. Use \"staging\" or \"production\".");
    }
    $this->env=$env;    
    $this->server=$this->servers[$this->env];        
    $this->login=$login;
    $this->password=$password;
    $this->version=$version;    
  }

  public function check($throw_exceptions = false) {    
    try {
      return $this->get() == true;
    } catch (LceException $e) {
      error_log($e->getMessage());    
      if($throw_exceptions===true) throw $e;
    }      
  }

  public function products() {    
    $products = $this->get('products');
    foreach($products as $key => $product){
      $products[$key] = new Product($product);
    }
    return $products;
  }

  public function quote($params) {        
    $quote = $this->post('quotes',array('quote' => $params));
    $quote = new Quote($quote);
    return $quote;
  }

  public function __toString() {
    return 'php-lce '.$this::VERSION.' connecting to '.$this->server.' with '.$this->login."\n";
  }  

  private function get($resource = NULL) {
    $uri = $this->base_uri($resource);
    $response = $this->request('get', $uri);
    return $response;
  }
  
  private function post($resource, $params) {
    $uri = $this->base_uri($resource);
    $response = $this->request('post', $uri, $params);
    return $response;
  }  

  private function request($method, $uri, $params = NULL){
    $method = constant('\Httpful\Http::'.strtoupper($method));
    try {

      $template = \Httpful\Request::init($method)
        ->uri($uri)
        ->authenticateWith($this->login, $this->password)
        ->expectsJson()
        ->sendsJson();

      if($params && !empty($params)){
        $template = $template->body($params);
      }
      
      $response = $template->send();
      
#      if(!$response->headers['lce-env']) throw new NotLceException($uri." | This server does not provide the lce.io API.");
      if($response->hasErrors()) throw LceException::build($uri, $response);
      return $response->body->data;
    } catch (\Httpful\Exception\ConnectionErrorException $e) {
      throw new ConnectionErrorException($uri.' | '.$e->getMessage());
    }      
  }
  
  private function base_uri($resource = NULL) {
    $uri = $this->server;
    if($resource) $uri .= '/v'.$this->version.'/'.$resource;
    return $uri;
  }
  

}
