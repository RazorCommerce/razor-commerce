<?php

namespace Razor\Core\Install;

use Razor\Core\Field\Field;

class Fields {

  public $pkg;

  public function __construct( $pkg ) {
    $this->pkg = $pkg;
  }

  public function install() {

    $field = new Field( $this->pkg, 'user' );

    // customer contact fields
    $field->addSet( 'customer_contact', 'Customer Contact' );
    $field->add( 'first_name', 'First Name' );
    $field->set( 'customer_contact' );
    $field->add( 'last_name', 'Last Name' );
    $field->set( 'customer_contact' );
    $field->add( 'phone', 'Phone' );
    $field->set( 'customer_contact' );

    // customer addresses
    $field->addSet( 'customer_address', 'Customer Address' );
    $field->add( 'billing_address', 'Billing Address', 'address' );
    $field->set( 'customer_address' );
    $field->add( 'shipping_address', 'Shipping Address', 'address' );
    $field->set( 'customer_address' );

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

    $field = new Field( $this->pkg );
    $field->addSet( 'product_required', 'Product Required' );

    // product type
    $field->add( 'composer_menu', 'Composer Menu', 'composer_menu' );
    $field->set( 'product_required' );
    $field->add( 'product_type', 'Product Type', 'select' );
    $field->set( 'product_required' );

    // virtual
    $field->add( 'is_virtual', 'Virtual', 'boolean' );
    $field->set( 'product_required' );

    // downloadable
    /* $field->add( 'is_downloadable', 'Downloadable', 'boolean' );
    $field->set( 'product_required' ); */

    // prices
    $field->add( 'price_regular', 'Regular Price', 'number' );
    $field->set( 'product_required' );

    // product image
    $field->add( 'product_image', 'Product Image', 'image_file' );
    $field->set( 'product_required' );

    // sku
    $field->add( 'sku', 'SKU' );
    $field->set( 'product_required' );

    // descriptions
    $field->add( 'summary_description', 'Summary Description', 'textarea', false, array('akTextareaDisplayMode' => 'rich_text' ));
    $field->set( 'product_required' );
    $field->add( 'full_description', 'Full Description', 'textarea', false, array('akTextareaDisplayMode' => 'rich_text' ));
    $field->set( 'product_required' );

    // shipping fields
    $field = new Field( $this->pkg );
    $field->addSet( 'product_shipping', 'Shipping' );

    // weight
    $field->add( 'shipping_weight', 'Weight', 'number' );
    $field->set( 'product_shipping' );

    // dimensions
    $field->add( 'shipping_length', 'Length', 'number' );
    $field->set( 'product_shipping' );
    $field->add( 'shipping_width', 'Width', 'number' );
    $field->set( 'product_shipping' );
    $field->add( 'shipping_height', 'Height', 'number' );
    $field->set( 'product_shipping' );

    // shipping class
    /*
    $field->add( 'shipping_class', 'Shipping Class', 'select' );
    $field->set( 'product_shipping' );
    $field->getByHandle( 'shipping_class' );
    $field->selectValue( 'No Shipping' );
    $field->selectValue( 'Free Shipping' );
    */

    // downloadable
    /*
    $field = new Field( $this->pkg );
    $field->addSet( 'product_downloadable', 'Product Downloadable' );
    $field->add( 'download_file', 'Download File' );
    $field->set( 'product_downloadable' );
    $field->add( 'download_limit', 'Download Limit', 'number' );
    $field->set( 'product_downloadable' );
    $field->add( 'download_expiry', 'Expiry Date' );
    $field->set( 'product_downloadable' );
    $field->add( 'download_type', 'File Type' );
    $field->set( 'product_downloadable' );
    */

    // sale pricing
    $field = new Field( $this->pkg );
    $field->addSet( 'sale_pricing', 'Product Sale Pricing' );
    $field->add( 'sale_price', 'Sale Price' );
    /*
    $field->add( 'sale_price_start', 'Start Date' );
    $field->add( 'sale_price_end', 'End Date' );
    */

    // taxes
    /*
    $field = new Field( $this->pkg );
    $field->addSet( 'taxes', 'Product Taxes' );
    $field->add( 'tax_status', 'Tax Status' );
    $field->add( 'tax_class', 'Tax Class' );
    */

    // catalog fields
    $field = new Field( $this->pkg );
    $field->addSet( 'catalog_basics', 'Catalog Basics' );
    $field->add( 'catalog_image', 'Catalog Image', 'image_file' );
    $field->set( 'catalog_basics' );

    // shipping fields
    $field = new Field( $this->pkg );
    $field->addSet( 'razor_shipping_settings', 'Razor Shipping Settings' );

    $field->add( 'enable_shipping', 'Enable Shipping', 'boolean' );
    $field->set( 'razor_shipping_settings' );

    $field->add( 'enable_flat_rate_shipping', 'Enable Flat Rate Shipping', 'boolean' );
    $field->set( 'razor_shipping_settings' );

    $field->add( 'enable_free_shipping', 'Enable Free Shipping', 'boolean' );
    $field->set( 'razor_shipping_settings' );

    $field->add( 'flat_rate_shipping_cost_per_order', 'Cost Per Order', 'number' );
    $field->set( 'razor_shipping_settings' );

    $field->add( 'free_shipping_minimum_order', 'Minimum Order', 'number' );
    $field->set( 'razor_shipping_settings' );

    $field->add( 'enable_pickup_shipping', 'Enable Pickup Shipping', 'boolean' );
    $field->set( 'razor_shipping_settings' );

    $field->add( 'pickup_shipping_location', 'Pickup Location' );
    $field->set( 'razor_shipping_settings' );

  }

}
