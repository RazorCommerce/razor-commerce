<?php
namespace Concrete\Package\Razor\Controller\SinglePage\Dashboard\Razor;
use \Concrete\Core\Page\Controller\DashboardPageController;
use \Concrete\Core\User\UserList;

use \Razor\Core\Order\OrderList;

class Order extends DashboardPageController {

  public function view( $customerID = false ) {
    $ol = new OrderList();

    if( $customerID ) {
      $ol->filterByCustomer( $customerID );
    }

    $paginator = $ol->getPagination();
    $pagination = $paginator->renderDefaultView();
    $this->set( 'orders', $paginator->getCurrentPageResults() );
    $this->set( 'pagination', $pagination );
    $this->set( 'paginator', $paginator );
  }

}
