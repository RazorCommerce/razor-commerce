<?php

namespace Razor\Core\Payment\Method\Invoice;
use \Razor\Core\Payment\Method\Method as PaymentMethod;

class Invoice extends PaymentMethod {

  public function construct() {

  }

  public function getHandle() {
    return 'invoice';
  }

  public function getName() {
    return 'Invoice';
  }

  public function getDescription() {
    return 'Send me an invoice';
  }

  public function form() {
    return '<div class="invoice-me">Send me an invoice.</div>';
  }

  public function setup( $controller ) {
    // register assets
    $al = \Concrete\Core\Asset\AssetList::getInstance();
    $al->register('javascript', 'payment_method_invoice', 'src/Payment/Method/Invoice/invoice.js', array(), 'razor');
    $controller->requireAsset('javascript', 'payment_method_invoice');
  }

  public function process( $order, $ui, $data ) {
    return true;
  }

}
