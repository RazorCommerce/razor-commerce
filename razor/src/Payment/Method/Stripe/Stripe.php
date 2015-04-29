<?php

namespace Razor\Core\Payment\Method\Stripe;
use \Razor\Core\Payment\Method\Method as PaymentMethod;
use Page;
use Loader;

class Stripe extends PaymentMethod {

  protected $mode;
  protected $test_secret_key;
  protected $test_publishable_key;
  protected $live_secret_key;
  protected $live_publishable_key;

  public function __construct() {
    $this->init();
  }

  public function getSecretKey() {
    if( $this->mode == 'live' ) {
      return $this->live_secret_key;
    }
    return $this->test_secret_key;
  }

  public function getPublishableKey() {
    if( $this->mode == 'live' ) {
      return $this->live_publishable_key;
    }
    return $this->test_publishable_key;
  }

  public function setup( $controller ) {
    // register assets
    $al = \Concrete\Core\Asset\AssetList::getInstance();
    $al->register('javascript', 'payment_method_stripe', 'src/Payment/Method/Stripe/stripe.js', array(), 'razor');
    $al->register(
      'javascript',
      'stripe_api',
      'https://js.stripe.com/v2/',
      array( 'local' => false ),
      'razor'
    );
    $controller->requireAsset('javascript', 'stripe_api');
    $controller->requireAsset('javascript', 'payment_method_stripe');
  }

  public function init() {
    $stripeSettings = Page::getByPath('/dashboard/razor/payment');
    $this->mode = 'test';
    $mode = $stripeSettings->getAttribute('stripe_mode');
    if( $mode == 'Live Mode' ) {
      $this->mode = 'live';
    }
    $this->test_secret_key = $stripeSettings->getAttribute('stripe_test_secret_key');
    $this->test_publishable_key = $stripeSettings->getAttribute('stripe_test_publishable_key');
    $this->live_secret_key = $stripeSettings->getAttribute('stripe_live_secret_key');
    $this->live_publishable_key = $stripeSettings->getAttribute('stripe_live_publishable_key');
  }

  public function getHandle() {
    return 'stripe';
  }

  public function getName() {
    return 'Credit Card';
  }

  public function getDescription() {
    return 'Pay by Credit Card. Processing by Stripe Payments.';
  }

  // create stripe customer
  protected function createStripeCustomer( $token ) {
    require_once('/api/stripe-php-2.1.1/init.php');
    \Stripe\Stripe::setApiKey( $this->test_secret_key );
    $customer = \Stripe\Customer::create(array(
      "source" => $token,
      "description" => "Razor Commerce Customer")
    );
    return $customer;
  }

  // use stripe payment gateway to process payment
  public function process( $order, $ui, $data ) {
    require_once('/api/stripe-php-2.1.1/init.php');
    \Stripe\Stripe::setApiKey( $this->test_secret_key );

    $token = $data['stripe_token'];
    $stripeCustomer = $this->createStripeCustomer( $token );
    $ui->setAttribute( 'stripe_customer_id', $stripeCustomer->id );

    try {
      $charge = \Stripe\Charge::create(array(
        "amount" => $data['amount'] * 100,
        "currency" => "usd",
        "customer" => $stripeCustomer->id
      ));
      $charge->typeReference = array(
        'chargeID' => $charge->id
      );
    } catch(\Stripe\Error\Card $error) {
      return $error;
    }

    return $charge;
  }

  public function form() {
    $publishableKey = $this->getPublishableKey();
    return Loader::packageElement('checkout/payment/method/stripe', 'razor', array('publishableKey' => $publishableKey) );
  }

}
