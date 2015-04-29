<?php

namespace Razor\Core\Product\Install;
use \Razor\Core\Field\Field;
use \Razor\Core\Field\Composer;
use Concrete\Core\Tree\Type\Topic as TreeTypeTopic;
use \Config;

// install fields
class Fields {

  public $pkg;

  public function __construct( $pkg ) {
    $this->pkg = $pkg;
  }

  public function composer() {

    /*
     * Catalog
     */
    $composer = new Composer( 'catalog' );
    $composer->addLayoutSet( 'Catalog Basics', 'Enter the basic details of your catalog.' );
    $composer->addProperty( 'name', array( 'control_name' => 'Catalog Name', 'required' => true ));
    $composer->addProperty( 'publish_target', array( 'control_name' => 'Catalog Parent', 'required' => true ));
    $composer->addField( 'catalog_image' );

    /*
     * Product
     */
    $composer = new Composer( 'product' );

    // product basics
    $composer->addLayoutSet( 'Product Basics', 'Enter the basic details of your product.' );
    $composer->addField( 'composer_menu' );
    $composer->addField( 'product_type' );
    $composer->addField( 'is_virtual' );
    $composer->addProperty( 'name', array( 'control_name' => 'Product Name', 'required' => true ));
    $composer->addProperty( 'publish_target', array( 'control_name' => 'Product Catalog', 'required' => true ));
    // $composer->addField( 'is_downloadable' );

    // product general
    $composer->addLayoutSet( 'Product General', 'General settings for the product.' );
    $composer->addField( 'price_regular' );
    $composer->addField( 'sku' );
    $composer->addField( 'product_image' );
    $composer->addField( 'summary_description' );
    $composer->addField( 'full_description' );

    // shipping
    $composer->addLayoutSet( 'Shipping', 'Shipping details for the product.' );
    $composer->addField( 'shipping_weight' );
    $composer->addField( 'shipping_length' );
    $composer->addField( 'shipping_width' );
    $composer->addField( 'shipping_height' );
    // $composer->addField( 'shipping_class' );

    // downloadable
    /*
    $composer->addLayoutSet( 'Downloadable', 'Downloadable product settings.' );
    $composer->addField( 'download_file' );
    $composer->addField( 'download_limit' );
    $composer->addField( 'download_expiry' );
    $composer->addField( 'download_type' );
    */

    // sale pricing
    $composer->addLayoutSet( 'Sale Pricing', 'Sale price settings.' );
    $composer->addField( 'sale_price' );
    /*
    $composer->addField( 'sale_price_start' );
    $composer->addField( 'sale_price_end' );
    */

    // taxes
    /*
    $composer->addLayoutSet( 'Taxes', 'Tax settings.' );
    $composer->addField( 'tax_class' );
    $composer->addField( 'tax_status' );
    */


  }

  public function install() {
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

  }

}
