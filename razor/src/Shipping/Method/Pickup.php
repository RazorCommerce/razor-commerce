<?php

namespace Razor\Core\Shipping\Method;
use \Razor\Core\Shipping\Shipping;
use \Razor\Core\Shipping\Method\Method as ShippingMethod;

class Pickup extends ShippingMethod {

  public function getHandle() {
    return 'pickup';
  }

  public function getName() {
    return t( 'Pickup' );
  }

  public function getDescription() {
    return t( 'Pickup at store.' );
  }

  public function available( $order ) {
    $enabled = Shipping::setting('enable_pickup_shipping');
    if( !$enabled ) {
      return false;
    }
    return true;
  }

  public function calculateCost() {
    return 0.00;
  }

}
