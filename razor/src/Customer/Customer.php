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

  public static function getByID( $customerID ) {
    $customer = new Customer;
    $customer->id = $customerID;
    $customer->ui = UserInfo::getByID( $customerID );
    $customer->email = $customer->ui->uEmail;
    return $customer;
  }

  public function getCustomerID() {
    return $this->id;
  }

  public function getBillingAddress() {
    return $this->ui->getAttribute('billing_address');
  }

  public function getShippingAddress() {
    return $this->ui->getAttribute('shipping_address');
  }

  public function getPhone() {
    return $this->ui->getAttribute('phone');
  }

  public function getFirstName() {
    return $this->ui->getAttribute('first_name');
  }

  public function getLastName() {
    return $this->ui->getAttribute('last_name');
  }

  public function getEmail() {
    return $this->email;
  }

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
