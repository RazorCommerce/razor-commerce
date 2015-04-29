<?php

namespace Razor\Core\Checkout;
use Loader;
use Core;
use \Razor\Core\Checkout\Pane\Pane as CheckoutPane;
use \Razor\Core\Order\Order;
use \Razor\Core\Order\Item as OrderItem;
use \Razor\Core\Payment\Payment;
use \Razor\Core\Payment\Method\Method as PaymentMethod;
use \Razor\Core\Field\Field;
use User;
use UserInfo;

// main checkout class
class Checkout {

  public $panes = array(); // checkout panes

  public function __construct() {
    $this->registerPanes();
  }

  public function registerPanes() {
    $this->panes = array( 'customer', 'billing', 'shipping', 'payment', 'confirmation' );
  }

  // process the checkout form after validation passed
  public function processCheckoutForm( $data ) {

    $orderID = $data['order_id'];
    $amount = $data['amount'];
    $order = Order::getByID( $orderID );

    // get or make user account
    $u = new User();
    $userExists = $u->isLoggedIn();
    if( !$userExists ) {
      $ui = $this->addUserAccount( $data );
    } else {
      $ui = UserInfo::getByID( $u->getUserID() );
    }

    // save user field data
    foreach( $data['akID'] as $key => $value ) {
      Field::update( $key, $value['value'], 'user');
    }

    // process payment
    $payment_type = $data['payment_type'];
    $payment_method = PaymentMethod::getByHandle( $payment_type );
    $charge = $payment_method->process( $order, $ui, $data );

    // record payment
    $typeReference = json_encode( $charge );
    Payment::add( $orderID, $payment_type, $amount, $typeReference );

    // update order status
    $order = Order::getByID( $orderID );
    $order->updateStatus('checkout_complete');

    // redirect user to finish page
    return true;
  }

  public function processInvoicePayment( $data ) {
    $payment = new stdClass();
    $payment->typeReference = array();
    return $payment;
  }

  public function validateCheckoutForm( $data ) {
    $validation = Core::make('helper/validation/form');
    $validation->setData( $data );
    return $validation->test();
  }

  public function addUserAccount( $data ) {
    $userData['uName'] = $data['email'];
    $userData['uEmail'] = $data['email'];
    $userData['uPassword'] = '123456';
    $userData['uPasswordConfirm'] = '123456';
    $ui = UserInfo::register( $userData );
    return $ui;
  }

}
