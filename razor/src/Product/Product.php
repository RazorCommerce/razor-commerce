<?php

namespace Razor\Core\Product;

use Concrete\Core\Foundation\Object;
use Razor\Core\Extension\Extension;
use Razor\Core\Product\Page as ProductPage;
use Loader;


defined('C5_EXECUTE') or die(_("Access Denied."));

class Product extends Object {

  public static function getByID( $productID ) {
    $product = new Product();
    $productPage = ProductPage::getByID( $productID );
    $product->loadRequiredFields( $productPage );
    return $product;
  }

  public static function getByPath( $productPath ) {
    $product = new Product();
    $productPage = ProductPage::getByPath( $productPath );
    if( !$productPage->isError()) {
      $product->loadRequiredFields( $productPage );
      return $product;
    }
    return false;
  }

  public function getProductPage() {
    return ProductPage::getByID( $this->id );
  }

  protected function loadRequiredFields( $productPage ) {

    $this->id = $productPage->getCollectionID();

    // get product type
    $product_type_select = $productPage->getAttribute('product_type');
    $product_type_option = $product_type_select->get(0);
    $product_type_value = $product_type_option->getSelectAttributeOptionValue();
    $this->type = strtolower( str_replace(' ', '_', $product_type_value ));

    $this->is_virtual = $productPage->getAttribute('is_virtual');
    $this->is_downloadable = $productPage->getAttribute('is_downloadable');
    $this->price_regular = $productPage->getAttribute('price_regular');
    $this->price_special = $productPage->getAttribute('price_special');
    $this->sku = $productPage->getAttribute('sku');
  }

  // return product price, default is regular price set $type to "special" to retrieve special price
  public function getPrice( $type = 'regular' ) {
    if( $type == 'special' ) {
      return $price_special;
    }
    return $price_regular;
  }

  public function is_shippable() {
    if( $this->is_virtual ) {
      return false;
    }
    return true;
  }

  public function is_virtual() {
    if( $this->is_virtual ) {
      return true;
    }
    return false;
  }

  public function is_downloadable() {
    if( $this->is_downloadable ) {
      return true;
    }
    return false;
  }

  public function getType() {
    return $this->type;
  }

  public function getSKU() {
    return $this->sku;
  }

  public function installDefaultTypes() {
    $ext = new Extension();
    $defaults = array(
      'standard' => '\Razor\Core\Product\Type\Standard',
      // 'dynamic'  => 'Razor\Core\Product\Type\Dynamic',
    );
    foreach ( $defaults as $handle => $namespace ) {
      $ext->register('product_type', $handle, $namespace);
    }
  }

}
