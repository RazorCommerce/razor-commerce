<?php

namespace Razor\Core\Migration\Test;

use Database;
use Concrete\Core\Foundation\Object;
use Razor\Core\Migration\Test as MigrationTest;
use \Razor\Core\Migration\Test\Result as TestResult;

defined('C5_EXECUTE') or die(_("Access Denied."));

class Test extends Object {

  public function run() {

    $this->result = new TestResult();

    // test each condition
    foreach( $this->conditions as $condition ) {
      $condition->setXML( $this->xml );
      $conditionResult = $condition->test();
      $this->result->addConditionResult( $condition, $conditionResult );
    }

    // set pass true if no fails
    if( !$this->result->fail ) {
      $this->result->pass = true;
    }

    // calculate counts
    $this->result->calculateImportCounts( $this->xml, $this->type );

  }

  public function setType( $type ) {
    $this->type = $type;
  }

  public function setConditions( $conditions ) {
    $this->conditions = $conditions;
  }

  public function setXML( $xml ) {
    $this->xml = $xml;
  }

}
