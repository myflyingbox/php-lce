<?php

namespace Lce;

use Lce\Exception\ConnectionErrorException;
use Lce\Exception\NotLceException;
use Lce\Exception\UnknownEnvironmentException;
use Lce\Exception\LceException;

class Connection {
  
  public $login, $version, $env;
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
    $this->login=$login;
    $this->password=$password;
    $this->version=$version;    
  }

  public function get($resource = NULL, $id = NULL, $action = NULL, $format = NULL, $params = NULL) {
    $uri = $this->base_uri($resource, $id, $action, $format);
    $response = $this->request('get', $uri, $params, $format);
    return $response;
  }
  
  public function post($resource, $params) {
    $uri = $this->base_uri($resource);
    $response = $this->request('post', $uri, $params);
    return $response;
  }  

  public function server() {
    return $this->servers[$this->env];
  }  

  private function request($method, $uri, $params = NULL, $format = NULL){
    $method = constant('\Httpful\Http::'.strtoupper($method));
    try {

      $template = \Httpful\Request::init($method)
        ->authenticateWith($this->login, $this->password);

      if(!$format || $format == 'json'){
        $template = $template->expectsJson()->sendsJson();      
      }


      if($params && !empty($params)){
        if($method == \Httpful\Http::GET){
          $uri = $uri."?".http_build_query($params);
        } else {
          $template = $template->body($params);
        }
      }
      
      $template = $template->uri($uri);      
      $response = $template->send();
      
#      if(!$response->headers['lce-env']) throw new NotLceException($uri." | This server does not provide the lce.io API.");
      if($response->hasErrors()) throw LceException::build($uri, $response);
      if(!$format || $format == 'json'){
      
        if(isset($response->body->count)) $count = $response->body->count;
        if(isset($response->body->page)) $page = $response->body->page;
        if(isset($response->body->per_page)) $per_page = $response->body->per_page;
        if(isset($count) && isset($page) && isset($per_page)){
          $data = new PaginatedArray($response->body->data, $page, $per_page, $count);          
        } else {
          $data = $response->body->data;
        }
      } else {
        $data = $response->body;
      }
      return $data;
    } catch (\Httpful\Exception\ConnectionErrorException $e) {
      throw new ConnectionErrorException($uri.' | '.$e->getMessage());
    }      
  }
  
  private function base_uri($resource = NULL, $id = NULL, $action = NULL, $format = NULL) {
    $uri = $this->server();
    if($resource) $uri .= '/v'.$this->version.'/'.$resource;
    if($id) $uri .= '/'.$id;
    if($action) $uri .= '/'.$action;
    if($format) $uri .= '.'.$format;
    return $uri;
  }
  

}
