<?php

namespace Lce;

class PaginatedArray extends \ArrayObject {
  var $current_page, $per_page, $total_count;
  
  function __construct($input, $current_page, $per_page, $total_count) {
    $this->current_page = $current_page;
    $this->per_page = $per_page;
    $this->total_count = $total_count;
    parent::__construct($input);
  }
  
  function total_page(){
    return ceil($this->total_count/$this->per_page);
  }
  
  function next_page(){
    $next_page = $this->current_page+1;
    if($next_page <= $this->total_page()){
      return $next_page;
    } else {
      return false;    
    }
  }
  function previous_page(){
    $previous_page = $this->current_page-1;
    if($previous_page > 0){
      return $previous_page;
    } else {
      return false;    
    }
  }      
       
}
