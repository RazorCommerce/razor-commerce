<?php

namespace Razor\Core\Product;

use \Concrete\Core\Foundation\Object;
use Database;
use Razor\Core\Product\Product;
use \Concrete\Package\Razor\Src\Attribute\Key\ProductKey;
use \Concrete\Package\Razor\Src\Attribute\Value\ProductValue;

defined('C5_EXECUTE') or die(_("Access Denied."));

class ProductOption extends Object {

  public function __construct( $product ) {
    $this->product = $product;
  }

  public function add( $productOption ) {
    $db = Database::get();
    $db->query("insert into RazorProductProductOptions (pID, poID)
      values (?, ?)",
      array( $this->product->getProductID(), $productOption->getProductOptionID() )
    );
    $productOption = new ProductOption( $this->product );
    $productOption = $productOption->get( $productOption );
    return $productOption;
  }

  public function get( $productOption ) {
    return "ProductProductOption->get";
  }

}
