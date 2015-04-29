<?php
namespace Concrete\Package\Razor\Controller\SinglePage\Dashboard\Razor;
use \Concrete\Core\Page\Controller\DashboardPageController;
use \Concrete\Core\User\UserList;

use \Razor\Core\Order\OrderList;

class Orders extends DashboardPageController {

  public function view( $customerID = false ) {
    $ol = new OrderList();

    if( $customerID ) {
      $ol->filterByCustomer( $customerID );
    }

    $orders = $ol->getResults();
    $this->set('ol', $ol);
    $this->set('orders', $orders);
  }

}
