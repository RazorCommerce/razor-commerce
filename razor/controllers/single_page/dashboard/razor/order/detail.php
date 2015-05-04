<?php

namespace Concrete\Package\Razor\Controller\SinglePage\Dashboard\Razor\Order;

use \Concrete\Core\Page\Controller\DashboardPageController;
use Razor\Core\Order\Order;

class Detail extends DashboardPageController {

  public function view( $orderID = false ) {
    if( !$orderID ) {
      $this->redirect( 'dashboard/razor/order' );
    }

    $this->set('pageTitle', 'Order #' . $orderID . ' Detail');



    $order = Order::getByID( $orderID );
    $customer = $order->getCustomer();

    $this->set( 'order', $order );
    $this->set( 'customer', $customer );
  }

}
