<?php

namespace Razor\Core\Order\Cart;
use \Razor\Core\Order\Order;
use \Session;
use \User;
use \Loader;

class Cart {

  // when user logs in this function is called and if an anonymous cart existed we convert it to their user id
  public static function convertAnonymousCart() {
    $db = Loader::db();
    $u = new User();
    $customerID = $u->uID;

    // get anonymous order
    $anonymousOrder = self::getAnonymousCart();

    // if no anonymous order or if cart empty, no need to convert
    if( !$anonymousOrder || count( $anonymousOrder->items ) < 1 ) {
      return false;
    }

    // check for existing cart order attached to customerID
    // if we find one we mark it replaced because we want to use the anonymous cart
    $customerOrder = self::getCustomerCart( $customerID );
    if( $customerOrder ) {
      $db->query("update RazorOrders set customerID = ?, status = 'replaced' where orderID = ?",
        array( $customerID, $customerOrder->orderID )
      );
    }

    // update anonymous cart
    $db->query("update RazorOrders set customerID = ?, status = 'cart' where orderID = ?",
      array( $customerID, $anonymousOrder->orderID )
    );
  }

  // get customer cart if available
  public function getCustomerCart( $customerID ) {
    $db = Loader::db();
    $orderID = $db->GetOne("select orderID from RazorOrders where customerID = ? and status = 'cart'",
      array( $customerID )
    );
    if( $orderID ) {
      return Order::getByID( $orderID );
    }
    return false;
  }

  // get anonymous cart if there is one for the current session
  public function getAnonymousCart() {
    $db = Loader::db();
    $sid = Session::getId();
    $orderID = $db->GetOne("select orderID from RazorOrders where customerID = ? and status = 'cart'",
      array( $sid )
    );
    if( $orderID ) {
      return Order::getByID( $orderID );
    }
    return false;
  }



  // returns current cart object
  public static function getCurrentCart() {
    $db = Loader::db();
    $u = new User();
    $orderDate = date('Y-m-d');
    if( $u->isRegistered() ) {
      $customerID = $u->uID;
      $orderID = $db->GetOne("select orderID from RazorOrders where customerID = ? and status = 'cart'",
        array( $customerID )
      );
      if( $orderID ) {
        $order = Order::getByID( $orderID );
      } else {
        $order = Order::add( $customerID, $orderDate, 'cart' );
      }
    } else {
      $sid = Session::getId();
      $orderID = $db->GetOne("select orderID from RazorOrders where customerID = ? and status = 'cart'",
        array( $sid )
      );
      if( $orderID ) {
        $order = Order::getByID( $orderID );
      } else {
        $order = Order::add( $sid, $orderDate, 'cart' );
      }
    }
    return $order;
  }

  // set timestamp when cart created
  public function setCreatedTimestamp() {

  }

  // get timestamp when cart created
  public function getCreatedTimestamp() {

  }

  // set timestamp when cart last updated
  public function setUpdatedTimestamp() {

  }

  // get timestamp when cart last updated
  public function getUpdatedTimestamp() {

  }

  // if cart expires we archive it
  public function expireCart() {
    $cartCreatedTS = $this->getCreatedTimestamp();
    $cartUpdatedTS = $this->getUpdatedTimestamp();
    $cartLife = $cartCreatedTS - $cartUpdatedTS;
    if( $cartLife > 60000 ) {
      $this->archive();
    }
  }

  // create a new cart
  public function create() {

  }

  // update cart after changes
  public function update() {

  }

  // remove all items from cart
  public function clear() {

  }

  // set cart status to archived
  public function archive() {

  }

}
