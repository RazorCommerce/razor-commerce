<?php

namespace Razor\Core\Customer;

use \Concrete\Core\User\UserList;
use User;
use UserInfo;
use Package;
use Loader;
use Page;

class CustomerList extends UserList {

  public function __construct() {
    parent::__construct();
  }

}
