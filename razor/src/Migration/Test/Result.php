<?php

namespace Razor\Core\Migration\Test;

use Database;
use Concrete\Core\Foundation\Object as Object;

defined('C5_EXECUTE') or die(_("Access Denied."));

class Result {

  public function __construct() {
    $this->results = array();
    $this->pass = false;
  }

  public function addConditionResult( $condition, $conditionResult ) {
    $this->results[] = $conditionResult;
    if( $condition->isRequired() && !$conditionResult->pass() ) {
      $this->fail = true;
    }

  }

  public function pass() {
    if( $this->pass ) {
      return true;
    }
    return false;
  }

  public function calculateImportCounts( $xml, $migrationType ) {
    $total = 0;
    $new = 0;
    $update = 0;

    foreach( $xml->{ $migrationType->getImportNodeParentName() }->children() as $import ) {
      if( $import->getName() == $migrationType->getImportNodeName() ) {
        $total++;

        // if $type->itemExists( $import ) { $update++; } else { $new++; }

      }
    }

    $this->counts = array( 'total' => $total, 'new' => $new, 'update' => $update );
  }

}
