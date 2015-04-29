<?php

namespace Razor\Core\Extension\Type;

class PaymentMethod {

  public function getConfig() {
    return 'commerce.payment_method';
  }

  public function install( $handle, $namespace ) {
    $paymentMethod = new $namespace();
    $paymentMethod->install();
  }

  public function uninstall( $handle, $namespace ) {
    return false;
  }

}
