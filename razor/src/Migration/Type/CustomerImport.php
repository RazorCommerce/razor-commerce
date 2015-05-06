<?php

namespace Razor\Core\Migration\Type;

use Razor\Core\Migration\Type\Type as MigrationType;
use Razor\Core\Migration\Test\Condition as TestCondition;
use Razor\Core\Customer\Customer;

class CustomerImport extends MigrationType {

  public function getHandle() {
    return "customer_import";
  }

  public function getName() {
    return "Customer Import";
  }

  public function getImportNodeParentName() {
    return "customers";
  }

  public function getImportNodeName() {
    return "customer";
  }

  public function getDescription() {
    return "Import commerce customers.";
  }

  public function conditions() {
    $conditions = array();

    $tc = new TestCondition();
    $tc->setName( 'Has Customers' );
    $tc->setRequired( true );
    $tc->setMessage( 'No customers found.');
    $tc->setTest( 'Razor\Core\Migration\Type\CustomerImport', 'hasCustomers' );
    $conditions[] = $tc;

    return $conditions;
  }

  public function hasCustomers( $data ) {
    $count = count( $data->customers->children() );
    if( !count ) {
      return false;
    }
    return true;
  }

  public function test() {

  }

  public function execute( $xml ) {
    $customerObj = new Customer;
    foreach ( $xml->customers->customer as $customer ) {    
      $data['email'] = $customer->email;
      $customerObj::add( $data );
    }
  }

}
