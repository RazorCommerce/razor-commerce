<?php

namespace Razor\Core\Checkout\Payment;

use Concrete\Core\Search\ItemList\Database\AttributedItemList as DatabaseItemList;
use Loader;
use \Razor\Core\Payment\Payment;

class PaymentList extends DatabaseItemList {

  protected function getAttributeKeyClassName() {
    return '\\Concrete\\Core\\Attribute\\Key\\UserKey';
  }

  public function getResult( $queryRow ) {
    $o = Payment::getByID( $queryRow['paymentID'] );
    return $o;
  }

  protected function createPaginationObject() {
    $adapter = new DoctrineDbalAdapter($this->deliverQueryObject(), function ($query) {
      $query->select('count(distinct p.paymentID)')->setMaxResults(1);
      });
    $pagination = new Pagination($this, $adapter);
    return $pagination;
  }

  public function getTotalResults() {
    $query = $this->deliverQueryObject();
    return $query->select('count(distinct p.paymentID')->setMaxResults(1)->execute()->fetchColumn();
  }

  public function createQuery() {
    $this->query->select('p.paymentID')
      ->from('RazorPayments', 'p');
  }

}
