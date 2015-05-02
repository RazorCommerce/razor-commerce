<?php

namespace Razor\Core\Order;

use Concrete\Core\Search\ItemList\Database\AttributedItemList;
use Pagerfanta\Adapter\DoctrineDbalAdapter;
use Concrete\Core\Search\Pagination\Pagination;
use \Razor\Core\Order\Order;
use \Razor\Core\Order\Item as OrderItem;


defined('C5_EXECUTE') or die(_("Access Denied."));

class OrderList extends AttributedItemList {

  protected function getAttributeKeyClassName() {
    return '\\Concrete\\Core\\Attribute\\Key\\ColletionKey';
  }

  public function getResult( $queryRow ) {
    $o = Order::getByID( $queryRow['orderID'] );
    return $o;
  }

  protected function createPaginationObject() {
    $adapter = new DoctrineDbalAdapter($this->deliverQueryObject(), function ($query) {
      $query->select('count(distinct o.orderID)')->setMaxResults(1);
      });
    $pagination = new Pagination($this, $adapter);
    return $pagination;
  }

  public function getTotalResults() {
    $query = $this->deliverQueryObject();
    return $query->select('count(distinct o.orderID)')->setMaxResults(1)->execute()->fetchColumn();
  }

  public function createQuery() {
    $this->query->select('o.orderID')
      ->from('RazorOrders', 'o')
      ->join('o', 'Users', 'u', 'o.customerID = u.uID');
  }

  public function filterByCustomer( $customerID ) {
    $this->query->where('u.uID = ' . $customerID);
  }

}
