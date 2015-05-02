<?php

namespace Razor\Core\Migration\Test;

use Concrete\Core\Foundation\Object as Object;
use Razor\Core\Migration\Test\ConditionResult as TestConditionResult;

defined('C5_EXECUTE') or die(_("Access Denied."));

class Condition extends Object {

  public function test() {
    $tcr = new TestConditionResult();
    $result = call_user_func_array( array( $this->test['namespace'], $this->test['function'] ), array( $this->xml ) );
    $tcr->setResult( $result );
    $tcr->setMessage( $this->getMessage() );
    return $tcr;
  }

  public function setXML( $xml ) {
    $this->xml = $xml;
  }

  public function setName( $name ) {
    $this->name = $name;
  }

  public function getName() {
    return $this->name;
  }

  public function setMessage() {
    $this->message = $message;
  }

  public function getMessage() {
    return $this->message;
  }

  public function setRequired( $required ) {
    $this->required = $required;
  }

  public function isRequired() {
    return $this->required;
  }

  public function setTest( $namespace, $function ) {
    $this->test = array();
    $this->test['namespace'] = $namespace;
    $this->test['function'] = $function;
  }

}
