<?php

namespace Razor\Core\Product\Type;
use Loader;
use Package;

class Type {

  public $pkg;

  public function __construct() {
    $this->pkg = Package::getByHandle('razor');
  }

  public static function getByHandle( $handle ) {
    $productType = new Type();
    $productTypes = $productType->pkg->getConfig()->get('commerce.product_types');
    $productTypeClass = $productTypes[ $handle ];
    $productType = new $productTypeClass;
    return $productType;
  }

  public function getAll() {
    $productTypeList = $this->pkg->getConfig()->get('commerce.product_types');
    $productTypes = array();
    foreach ( $productTypeList as $handle => $namespace ) {
      if( $namespace ) {
        $productTypes[] = $this->getByHandle( $handle );
      }
    }
    return $productTypes;
  }

  public function install() {
  }

  public function uninstall() {
  }

}
