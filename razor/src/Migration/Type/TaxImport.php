<?php

namespace Razor\Core\Migration\Type;

use Razor\Core\Migration\Type\Type as MigrationType;
use Razor\Core\Migration\Test\Condition as TestCondition;
use Concrete\Core\Foundation\Object;
use Razor\Core\Tax\Tax;

defined('C5_EXECUTE') or die(_("Access Denied."));

class TaxImport extends MigrationType {

  public function getHandle() {
    return "tax_import";
  }

  public function getName() {
    return "Tax Import";
  }

  public function getImportNodeName() {
    return "tax";
  }

  public function getImportNodeParentName() {
    return "taxes";
  }

  public function getDescription() {
    return "Import tax settings.";
  }

  public function conditions() {
    $conditions = array();

    $tc = new TestCondition();
    $tc->setName( 'Taxes' );
    $tc->setRequired( true );
    $tc->setMessage( 'No taxes found');
    $tc->setTest( 'Razor\Core\Migration\Type\TaxImport', 'hasTaxes' );
    $conditions[] = $tc;

    $tc = new TestCondition();
    $tc->setName('Taxes');
    $tc->setRequired( true );
    $tc->setMessage = 'You suck dick and I won\'t let you import shit bitch!';
    $tc->setTest('Razor\Core\Migration\Type\TaxImport', 'failer');
    $conditions[] = $tc;

    return $conditions;
  }

  public function failer() {
    return true;
  }

  public function hasTaxes( $data ) {
    $count = count( $data->taxes->children() );
    if( !count ) {
      return false;
    }
    foreach( $data->taxes->children() as $child ) {
      if( $child->getName() != 'tax' ) {
        return false;
      }
    }
    return true;
  }

  public function test() {

  }

  public function execute( $xml ) {
    $taxObj = new Tax;
    $taxObj->deleteAll();
    foreach ( $xml->taxes->tax as $tax ) {
      $data = array(
        'name' => $tax->name,
        'country' => $tax->country,
        'region' => $tax->region,
        'rate' => $tax->rate
      );
      $taxObj->add( $data );
    }
  }

}
