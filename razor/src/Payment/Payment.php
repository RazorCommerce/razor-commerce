<?php

namespace Razor\Core\Payment;
use Loader;
use Core;
use Package;
use \Razor\Core\Payment\Method\Method as PaymentMethod;
use \Razor\Core\Checkout\Checkout;
use \Razor\Core\Order\Order;
use \Razor\Core\Extension\Extension;

// class to handle payments
class Payment {

  public static function getByID( $paymentID ) {
    $db = Loader::db();
    $payment = new Payment();
    $query = $db->query("select paymentID from RazorPayments where paymentID = ? ",
      array( $paymentID )
    );
    $record = $query->fetchRow();
    $payment->paymentID = $paymentID;
    return $payment;
  }

  // add payment
  public static function add( $orderID, $type, $amount, $typeReference = false ) {
    $db = Loader::db();
    $paymentDate = date('Y-m-d');
    $typeReference = json_encode( $typeReference );
    $db->query("insert into RazorPayments (orderID, amount, paymentDate, type, typeReference) values (?, ?, ?, ?, ?)",
      array( $orderID, $amount, $paymentDate, $type, $typeReference )
    );
    $paymentID = $db->Insert_ID();
    return $paymentID;
  }

  public static function getMethods() {
    $pkg = Package::getByHandle('razor');
    $payment_method_handles = $pkg->getConfig()->get('commerce.payment_method');
    $payment_methods = array();
    if( count($payment_method_handles)) {
      foreach( $payment_method_handles as $pmh ) {
        $payment_methods[] = new $pmh();
      }
    }
    return $payment_methods;
  }

  public function installDefaultMethods() {
    $ext = new Extension();
    $defaults = array(
      'stripe' => '\Razor\Core\Payment\Method\Stripe\Stripe',
      'invoice' => '\Razor\Core\Payment\Method\Invoice\Invoice',
    );
    foreach ( $defaults as $handle => $namespace ) {
      $ext->register('payment_method', $handle, $namespace);
    }
  }

}
