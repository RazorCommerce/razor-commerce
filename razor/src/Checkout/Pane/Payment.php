<?php

namespace Razor\Core\Checkout\Pane;
use \Razor\Core\Payment\Payment as PaymentClass;
use \Razor\Core\Checkout\Payment\Method\Method as PaymentMethod;

// payment pane
class Payment extends Pane {

  public function getPaneKey() {
    return t("payment");
  }

  public function __construct() {
    $this->key = $this->getPaneKey();
    $this->class = $this->classFromKey( $this->key );
  }

  public function loadPaymentMethods() {
    return PaymentClass::getMethods();
  }

}
