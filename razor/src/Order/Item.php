<?php

namespace Razor\Core\Order;
use Loader;

// handling of each cart item, shopping cart is made up of items
class Item {

  public $orderItemID;
  public $orderID;
  public $productID;
  public $quantity;
  public $priceEach;
  public $priceTotal;

  public static function getByID( $orderItemID ) {
    $db = Loader::db();
    $orderItemQuery = $db->query("select orderItemID, orderID, productID, quantity, priceEach, priceTotal
      from RazorOrderItems where orderItemID = ?",
      array( $orderItemID )
    );
    $orderItemRecord = $orderItemQuery->fetchRow();
    if( !$orderItemRecord ) {
      return false;
    }
    $item = new Item();
    $item->orderItemID = $orderItemID;
    $item->orderID = $orderItemRecord['orderID'];
    $item->productID = $orderItemRecord['productID'];
    $item->quantity = $orderItemRecord['quantity'];
    $item->priceEach = $orderItemRecord['priceEach'];
    $item->priceTotal = $orderItemRecord['priceTotal'];
    return $item;
  }

  // get single order item by id
  public static function getByOrderProduct( $orderID, $productID ) {
    $db = Loader::db();
    $orderItemQuery = $db->query("select orderItemID from RazorOrderItems where orderID = ? and productID = ?",
      array( $orderID, $productID )
    );
    $orderItemRecord = $orderItemQuery->fetchRow();
    if( !$orderItemRecord ) {
      return false;
    }
    return Item::getByID( $orderItemRecord['orderItemID'] );
  }

  // add item to order
  public function add( $orderID, $productID, $quantity, $priceEach ) {
    $db = Loader::db();
    $existingItem = $this->getByOrderProduct( $orderID, $productID );
    if( $existingItem ) {
      $newQuantity = $existingItem->quantity + $quantity;
      self::changeQuantity( $orderID, $productID, $newQuantity );
    } else {
      $priceTotal = $priceEach * $quantity;
      $db->query("insert into RazorOrderItems (orderID, productID, quantity, priceEach, priceTotal) values (?, ?, ?, ? ,?)",
        array( $orderID, $productID, $quantity, $priceEach, $priceTotal )
      );
    }
  }

  // remove item from order
  public function remove() {
    $db = Loader::db();
    $db->query("delete from RazorOrderItems where orderItemID = ?",
      array( $this->orderItemID )
    );
  }

  // change item quantity
  public function changeQuantity( $quantity ) {
    $db = Loader::db();
    $priceTotal = $this->priceEach * $quantity;
    $this->priceTotal = $priceTotal;
    $this->quantity = $quantity;
    $db->query("update RazorOrderItems set quantity = ?, priceTotal = ? where orderItemID = ?",
      array( $quantity, $priceTotal, $this->orderItemID )
    );
  }

}
