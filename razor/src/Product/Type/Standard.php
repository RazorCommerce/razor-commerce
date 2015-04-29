<?php

namespace Razor\Core\Product\Type;
use \Razor\Core\Product\Type\Type as ProductType;
use \Razor\Core\Field\Field;
use Loader;
use Page;

class Standard extends ProductType {

  public function fields() {
    return false;
  }

  public function install() {
    $field = new Field();
    $field->getByHandle( 'product_type' );
    $field->selectValue( 'Standard Product' );
  }

}
