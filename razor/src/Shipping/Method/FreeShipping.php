<?php

namespace Razor\Core\Shipping\Method;
use \Razor\Core\Shipping\Shipping;
use \Razor\Core\Shipping\Method\Method as ShippingMethod;

class FreeShipping extends ShippingMethod {

  public function getHandle() {
    return 'free_shipping';
  }

  public function getName() {
    return 'Free Shipping';
  }

  public function getDescription() {
    return 'Free shipping.';
  }

  public function available( $order ) {
    $enabled = \Razor\Core\Setting\Setting::get('enable_free_shipping');
    if( !$enabled ) {
      return false;
    }
    $minimumOrder = \Razor\Core\Setting\Setting::get('free_shipping_minimum_order');
    $orderTotal = $order->getSubtotal();
    if( $orderTotal >= $minimumOrder ) {
      return true;
    }
    return false;
  }

  public function calculateCost() {
    return 0.00;
  }

}
