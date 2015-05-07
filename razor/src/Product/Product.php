<?php

namespace Razor\Core\Product;

use Concrete\Core\Foundation\Object;
use Razor\Core\Extension\Extension;
use Razor\Core\Product\Page as ProductPage;
use Loader;
use Database;
use \Concrete\Package\Razor\Src\Attribute\Key\ProductKey;
use \Concrete\Package\Razor\Src\Attribute\Value\ProductValue;

defined('C5_EXECUTE') or die(_("Access Denied."));

class Product extends Object {

  public static function getByID( $pID ) {
    $db = Database::get();
    $data = $db->GetRow('select * from RazorProduct where pID = ?', $pID);
    $product = new Product();
    $product->setPropertiesFromArray( $data );
    return $product;
  }

  public function option() {
    $ppo = new \Razor\Core\Product\ProductOption( $this );
    return $ppo;
  }

  /*
   * Attribute Handling Methods
   */

  public function setAttribute($ak, $value) {
    if (!is_object($ak)) {
      $ak = ProductKey::getByHandle($ak);
    }
    $ak->setAttribute($this, $value);
  }

  public function getProductID() {
    return $this->pID;
  }

  public function getAttribute( $ak, $displayMode = false ) {
    if ( !is_object( $ak )) {
      $ak = ProductKey::getByHandle( $ak );
    }
    if ( is_object( $ak )) {
      $av = $this->getAttributeValueObject( $ak );
      if ( is_object( $av )) {
        return $av->getValue( $displayMode );
      }
    }
  }

  public function getAttributeValueObject($ak, $createIfNotFound = false) {
    $db = Database::get();
    $av = false;
    $v = array( $this->getProductID(), $ak->getAttributeKeyID() );
    $avID = $db->GetOne("select avID from RazorProductAttributeValues where pID = ? and akID = ?", $v);
    if ($avID > 0) {
      $av = ProductValue::getByID($avID);
      if (is_object($av)) {
        $av->setProduct($this);
        $av->setAttributeKey($ak);
      }
    }

    if ( $createIfNotFound ) {
      $cnt = 0;
      if ( is_object($av)) {
        $cnt = $db->GetOne("select count(avID) from RazorProductAttributeValues where avID = ?", $av->getAttributeValueID());
      }

      if ((!is_object($av)) || ($cnt > 1)) {
        $av = $ak->addAttributeValue();
      }
    }

    return $av;
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
