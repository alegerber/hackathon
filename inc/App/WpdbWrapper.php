<?php

namespace MDBHC;

class WpdbWrapper {

  private $wpdb;
  private $executionTime;
  
  function __construct($wpdb) {
    $this->wpdb = $wpdb;

    $this->executionTime = new ExecutionTime($wpdb);
  }

  public function __call($name, $arguments) 
  {
    //if(in_array($name, ['query','insert','update', 'replace', 'select'], true)) {
    if('query' === $name) {
      $this->executionTime->start();
      $return = $this->wpdb->$name(...$arguments);
      $this->executionTime->stop();
    } else {
      $return = $this->wpdb->$name(...$arguments);
    }
    return $return;
  }

  public static function activate() 
  {
    if(!isset($GLOBALS["wpdb_backup"])){
      global $wpdb;
      $GLOBALS["wpdb_backup"] = $wpdb;
    } else {
      $wpdb = $GLOBALS["wpdb_backup"];
    }

    $GLOBALS["wpdb"] = new self($wpdb);
  }

  public static function deactivate() 
  {
    $GLOBALS["wpdb"] = $this->wpdb;
  }
}