<?php

namespace Razor\Core\Shipping\Method;
use \Razor\Core\Shipping\Method\FlatRate;
use \Razor\Core\Shipping\Method\FreeShipping;
use \Razor\Core\Shipping\Method\Pickup;
use Loader;

class Method {

  public function getByHandle( $handle ) {
    // replace this switch with camel case calling of the class
    switch( $handle ) {
      case "flat_rate":
        $method = new FlatRate();
        break;
      case "free_shipping":
        $method = new FreeShipping();
        break;
      case "pickup":
        $method = new Pickup();
        break;
    }
    return $method;
  }

  public function getHandle() {
    return 'shipping_method';
  }

  public function getName() {
    return 'Generic Shipping Method';
  }

  public function getDescription() {
    return 'ShippingMethod base class.';
  }

  public function calculateCost() {
    return 1.00;
  }

  public function available() {
    return true;
  }

  public function install() {
    return false;
  }

  public function uninstall() {
    return false;
  }

}
