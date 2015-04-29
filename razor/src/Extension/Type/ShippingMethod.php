<?php

namespace Razor\Core\Extension\Type;

class ShippingMethod {

  public function getConfig() {
    return 'commerce.shipping_method';
  }

  public function install( $handle, $namespace ) {
    $shippingMethod = new $namespace();
    $shippingMethod->install();
  }

  public function uninstall( $handle, $namespace ) {
    return false;
  }

}
