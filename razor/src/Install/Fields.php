<?php

namespace Razor\Core\Install;

use \Razor\Core\Field\Field;
use \Razor\Core\Shipping\Shipping;

class Fields {

  public $pkg;

  public function __construct( $pkg ) {
    $this->pkg = $pkg;
  }

  public function install() {
    // stripe payment fields
    $field = new Field( $this->pkg );
    $field->addSet( 'stripe_payment_settings', 'Stripe Payment Settings' );

    $field->add( 'stripe_mode', 'Stripe Mode', 'select' );
    $field->set( 'stripe_payment_settings' );
    $field = new Field( $this->pkg );
    $field->getByHandle('stripe_mode');
    $field->selectValue( 'Testing Mode' );
    $field->selectValue( 'Live Mode' );
    $field->add( 'stripe_test_secret_key', 'Test Secret Key' );
    $field->set( 'stripe_payment_settings' );
    $field->add( 'stripe_test_publishable_key', 'Test Publishable Key' );
    $field->set( 'stripe_payment_settings' );
    $field->add( 'stripe_live_secret_key', 'Live Secret Key' );
    $field->set( 'stripe_payment_settings' );
    $field->add( 'stripe_live_publishable_key', 'Live Publishable Key' );
    $field->set( 'stripe_payment_settings' );

    // stripe customer id
    $field = new Field( $this->pkg, 'user' );
    $field->addSet( 'stripe_customer', 'Stripe Customer' );
    $field->add( 'stripe_customer_id', 'Stripe Customer ID' );

    // checkout settings
    $field = new Field( $this->pkg );
    $field->addSet( 'razor_general_settings', 'Razor General Settings' );

    /*
    $field->add( 'collect_customer_addresses', 'Collect Customer Addresses', 'boolean' );
    $field->set( 'razor_general_settings' );
    $field->add( 'enable_anonymous_checkout', 'Enable Anonymous Checkout', 'boolean' );
    $field->set( 'razor_general_settings' );
    */

    $field->add( 'store_location', 'Store Location' );
    $field->set( 'razor_general_settings' );

    // shipping fields
    $shipping = new Shipping();
    $shipping->install_fields();

  }

}
