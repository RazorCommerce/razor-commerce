<?php

namespace Razor\Core\Shipping\Method;
use \Razor\Core\Shipping\Shipping;
use \Razor\Core\Shipping\Method\Method as ShippingMethod;

class FlatRate extends ShippingMethod {

  public function getHandle() {
    return 'flat_rate';
  }

  public function getName() {
    return 'Flat Rate Shipping';
  }

  public function getDescription() {
    return 'Flat rate shipping cost for the order.';
  }

  public function available( $order ) {
    $enabled = \Razor\Core\Setting\Setting::get('enable_flat_rate_shipping');
    if( !$enabled ) {
      return false;
    }
    return true;
  }

  public function calculateCost() {
    return \Razor\Core\Setting\Setting::get('flat_rate_shipping_cost_per_order');
  }

}
