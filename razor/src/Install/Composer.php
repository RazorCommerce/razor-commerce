<?php

namespace Razor\Core\Install;

use Razor\Core\Field\Composer as ComposerObj;

class Composer {

  public function setupComposer() {

    /*
     * Catalog
     */
    $composer = new ComposerObj( 'catalog' );
    $composer->addLayoutSet( 'Catalog Basics', 'Enter the basic details of your catalog.' );
    $composer->addProperty( 'name', array( 'control_name' => 'Catalog Name', 'required' => true ));
    $composer->addProperty( 'publish_target', array( 'control_name' => 'Catalog Parent', 'required' => true ));
    $composer->addField( 'catalog_image' );

    /*
     * Product
     */
    $composer = new ComposerObj( 'product' );

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

}
