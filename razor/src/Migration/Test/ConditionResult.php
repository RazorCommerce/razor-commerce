<?php

namespace Razor\Core\Migration\Test;

defined('C5_EXECUTE') or die(_("Access Denied."));

class ConditionResult {

  public $pass = false;

  public function setResult( $result ) {
    if( $result ) {
      $this->pass = true;
    }
  }

  public function setMessage( $message ) {
    $this->message = $message;
  }

  public function getMessage() {
    return $this->message;
  }

  public function pass() {
    if( $this->pass ) {
      return true;
    }
    return false;
  }

  public function fail() {
    if( !$this->pass ) {
      return true;
    }
    return false;
  }

}
