<?php

namespace Razor\Core\Payment\Method;
use \Razor\Core\Payment\Method\Stripe\Stripe;
use \Razor\Core\Payment\Method\Invoice\Invoice;
use \Razor\Core\Extension\Extension;

class Method {

  public function install() {

  }

  public function uninstall() {

  }

  public function getByHandle( $handle ) {
    // replace this switch with camel case calling of the class
    switch( $handle ) {
      case "stripe":
        $method = new Stripe();
        break;
      case "invoice":
        $method = new Invoice();
        break;
    }
    return $method;
  }

  public function getHandle() {
    return 'payment_method';
  }

  public function getName() {
    return 'Generic Payment Method';
  }

  public function getDescription() {
    return 'PaymentMethod base class.';
  }

  public function form() {
    return 'Use this generic PaymentMethod.';
  }

}
