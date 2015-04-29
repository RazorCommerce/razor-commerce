<?php

namespace Razor\Core\Order;
use \Razor\Core\Shipping\Method\Method as ShippingMethod;
use Loader;

class Shipping {

  protected $shipping_method; // shipping method object
  protected $order; // order object
  protected $cost; // order shipping cost

  public function __construct( $shippingMethodHandle, $order ) {
    $this->shipping_method = ShippingMethod::getByHandle( $shippingMethodHandle );
    $this->order = $order;
  }

  public function getMethodHandle() {
    return $this->shipping_method->getHandle();
  }

  public function calculateCost() {
    $this->cost = $this->shipping_method->calculateCost( $this->order );
  }

  public function getCost() {
    return $this->cost;
  }

  public function setCost( $cost ) {
    $this->cost = $cost;
  }

}
