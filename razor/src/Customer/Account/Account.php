<?php

namespace Razor\Core\Customer\Account;
use \Razor\Core\Order\Order;
use \Session;
use \User;
use \UserInfo;
use \Loader;

class Account {

  public $id;
  public $email;
  public $user; // c5 user object
  public $ui; // c5 user information object

  public function __construct() {
    $this->user = new User();
    $this->id = $this->user->uID;
    $this->ui = UserInfo::getByID( $this->id );
    $this->email = $this->user_info->uEmail;
  }

  public function load( $customer ) {
    $account = new Account();
    return $account;
  }

}
