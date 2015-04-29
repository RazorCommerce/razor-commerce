<?php

namespace Razor\Core\Customer;

use \Razor\Core\Customer\Account\Account as CustomerAccount;
use \Razor\Core\Customer\Location as CustomerLocation;
use User;
use UserInfo;
use Package;
use Loader;
use Page;

class Customer {

  public $id;
  public $email;
  public $ui; // user info object

  // returns the CustomerAccount if available
  public function getAccount() {
    $ca = new CustomerAccount();
    $ca->load( $this );
    return $ca;
  }

  // returns the CustomerLocation object if available
  public function getLocation() {
    $cl = new CustomerLocation();
    $cl->load( $this );
    return $cl;
  }

}
