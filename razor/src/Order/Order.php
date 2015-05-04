<?php

namespace Razor\Core\Order;
use Loader;
use \Razor\Core\Order\Item as OrderItem;
use \Razor\Core\Order\Shipping as OrderShipping;

// handling of each cart item, shopping cart is made up of items
class Order {

  public $orderID;
  public $customerID;
  public $orderDate;
  public $shippable; // does the order have any shippable products
  protected $subtotal;
  protected $taxTotal;
  protected $shippingTotal;
  protected $total;
  protected $tax; // array of taxes applied to this order
  protected $shipping; // OrderShipping object
  protected $status;
  protected $items; // array of order items

  public function getOrderID() {
    return $this->orderID;
  }

  public function getItems() {
    return $this->items;
  }

  public function isShippable( $text = false ) {
    if( $text ) {
      if( $this->shippable ) {
        return "Yes";
      } else {
        return "No";
      }
    }
    return $this->shippable;
  }

  public function getItemList() {
    $db = Loader::db();
    $items = array();
    $orderItemQuery = $db->GetAll("select orderItemID from RazorOrderItems where orderID = ?",
      array( $this->orderID )
    );
    foreach( $orderItemQuery as $orderItemRecord ) {
      $items[] = OrderItem::getByID( $orderItemRecord['orderItemID'] );
    }
    return $items;
  }

  public function addItem( $productID, $quantity, $priceEach ) {
    $item = new Item();
    $item->add( $this->orderID, $productID, $quantity, $priceEach );
    $this->items = $this->getItemList();
  }

  // set OrderShipping object and calculate cost of shipping
  public function setShipping( $shippingMethodHandle ) {
    $db = Loader::db();
    $os = new OrderShipping( $shippingMethodHandle, $this );
    $os->calculateCost();
    $this->shipping = $os;
    $shippingReference = array(
      'method' => $os->getMethodHandle(),
      'cost' => $os->getCost(),
    );
    $shippingReference = json_encode( $shippingReference );
    $db->query("update RazorOrders set shippingTotal = ?, shipping = ? where orderID = ?",
      array( $os->getCost(), $shippingReference, $this->orderID )
    );
  }

  // $taxes is array of tax objects applicable to order
  public function applyTaxes( $taxes ) {
    $db = Loader::db();
    $taxTotal = 0;
    if( count( $taxes )) {
      $this->tax = $taxes;
      foreach( $taxes as $tax ) {
        $taxTotal += $this->subtotal * ( $tax->rate / 100 );
      }
      $this->taxTotal = $taxTotal;
    } else {
      $this->taxTotal = 0.00;
      $this->tax = false;
    }
    $taxReference = json_encode( $this->tax );
    $db->query("update RazorOrders set taxTotal = ?, tax = ? where orderID = ?",
      array( $this->taxTotal, $taxReference, $this->orderID )
    );
  }

  public function getTaxTotal() {
    return number_format( $this->taxTotal, 2 );
  }

  public function getTax() {
    if( !$this->tax ) {
      return false;
    }
    $taxDecoded = json_decode( $this->tax );
    $taxes = array();
    foreach( $taxDecoded as $taxRow ) {
      $taxes[] = \Razor\Core\Tax\Tax::getByID( $taxRow->id );
    }
    return $taxes;
  }

  public function getSubtotal() {
    return number_format( $this->subtotal, 2 );
  }

  public function getOrderDate() {
    return $this->orderDate;
  }

  // add new order
  public static function add( $customerID, $orderDate, $status ) {
    $db = Loader::db();
    $db->query("insert into RazorOrders (customerID, orderDate, status) values (?, ?, ?)",
      array( $customerID, $orderDate, $status )
    );
    $orderID = $db->Insert_ID();
    $order = self::getByID( $orderID );
    return $order;
  }

  public function getShipping() {
    if( is_object( $this->shipping )) {
      return $this->shipping;
    }
    return false;
  }

  public function getShippingCost() {
    if( is_object( $this->shipping )) {
      return number_format( $this->shipping->getCost(), 2 );
    }
    return 0.00;
  }

  public function getCustomer() {
    $customer = \Razor\Core\Customer\Customer::getByID( $this->customerID );
    return $customer;
  }

  // returns order
  public static function getByID( $orderID ) {
    $db = Loader::db();
    $order = new Order();
    $orderQuery = $db->query("select orderID, customerID, orderDate, subtotal,
      taxTotal, shippingTotal, total, tax, shipping, status
      from RazorOrders where orderID = ? ",
      array( $orderID )
    );
    $orderRecord = $orderQuery->fetchRow();
    $order->orderID = $orderID;
    $order->customerID = $orderRecord['customerID'];
    $order->orderDate = $orderRecord['orderDate'];
    $order->subtotal = $orderRecord['subtotal'];
    $order->taxTotal = $orderRecord['taxTotal'];
    $order->shippingTotal = $orderRecord['shippingTotal'];
    $order->total = $orderRecord['total'];
    $order->tax = $orderRecord['tax'];
    $order->shipping = $order->decodeShippingReference( $orderRecord['shipping'] );
    $order->status = $orderRecord['status'];
    $order->items = $order->getItemList();
    return $order;
  }

  public function decodeShippingReference( $shippingReference ) {
    $shipping = json_decode( $shippingReference );
    $os = new OrderShipping( $shipping->method, $this );
    $os->setCost( $shipping->cost );
    return $os;
  }

  // get the order total
  public function getTotal() {
    return number_format( $this->total, 2 );
  }

  // calculates then updates order total
  public function updateTotal() {
    $db = Loader::db();
    $this->calculateSubtotal();
    $this->calculateTotal();
    $db->query("update RazorOrders set subtotal = ?, total = ? where orderID = ?",
      array( $this->subtotal, $this->total, $this->orderID )
    );
  }

  // update order status
  public function updateStatus( $status ) {
    $db = Loader::db();
    $db->query("update RazorOrders set status = ? where orderID = ?",
      array( $status, $this->orderID )
    );
  }

  // calculate order item subtotal
  public function calculateSubtotal() {
    $order_items = $this->getItemList( $this->orderID );
    $this->subtotal = 0.00;
    if( count( $order_items )) {
      foreach( $order_items as $item ) {
        $this->subtotal += $item->priceTotal;
      }
    }
    return number_format( $this->subtotal, 2);
  }

  // calculate order total
  public function calculateTotal() {
    $this->total = $this->subtotal + $this->taxTotal;

    // add shipping cost if applicable
    if( is_object( $this->shipping )) {
      $this->total += $this->shipping->getCost();
    }
  }

  public function getStatus() {
    return $this->status;
  }

}
