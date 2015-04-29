<?php
namespace Concrete\Package\Razor\Controller\SinglePage\Dashboard\Razor;
use \Concrete\Core\Page\Controller\DashboardPageController;
use \Concrete\Core\User\UserList;
use \Razor\Core\Product\ProductList;
use \Razor\Core\Customer\Customer;
use \Razor\Core\Customer\CustomerList;

class Customers extends DashboardPageController {

  public function on_start() {

  }

  public function view() {
    $cl = new CustomerList();
    $users = $cl->getResults();
    $this->set('cl', $cl);
    $this->set('users', $users);
  }

}
