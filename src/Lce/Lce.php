<?php

namespace Lce;

use Lce\Exception\ConnectionErrorException;
use Lce\Exception\LceException;

class Lce {
  
  const VERSION = '0.0.1-dev';
  public $login, $server, $version;
  private $password;
  
  public function __construct($login, $password, $server = 'https://test.lce.io', $version = '1') {
    $this->login=$login;
    $this->password=$password;
    $this->server=$server;    
    $this->version=$version;    
  }

  public function check() {    
    try {
      return $this->get() == true;
    } catch (LceException $e) {
      error_log($e->getMessage());
    }      
  }

  public function products() {    
    echo $this->get('products');
  }

  public function __toString() {
    return 'php-lce '.$this::VERSION.' connecting to '.$this->server.' with '.$this->login."\n";
  }  

  private function get($resource = NULL) {
    $uri = $this->base_uri($resource);
    try {
      $response = \Httpful\Request::get($uri)
        ->authenticateWith($this->login, $this->password)
        ->expectsJson()
        ->send();        
      if($response->hasErrors()){
        throw LceException::build($uri, $response);
      } else {
        return $response;
      }
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
