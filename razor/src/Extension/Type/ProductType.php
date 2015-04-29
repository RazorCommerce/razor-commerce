<?php

namespace Razor\Core\Extension\Type;

class ProductType {

  public function getConfig() {
    return 'commerce.product_types';
  }

  public function install( $handle, $namespace ) {
    $productType = new $namespace();
    $productType->install();
  }

  public function uninstall( $handle, $namespace ) {
    return false;
  }

}
