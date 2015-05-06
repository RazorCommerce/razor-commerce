<?php

namespace Razor\Core\Product\Option;

use \Concrete\Core\Foundation\Object;
use Database;
use Razor\Core\Product\Product;
use \Concrete\Package\Razor\Src\Attribute\Key\ProductKey;
use \Concrete\Package\Razor\Src\Attribute\Value\ProductValue;

defined('C5_EXECUTE') or die(_("Access Denied."));

class Option extends Object {

  // list of options for given product
  public function getByProduct( $product ) {
    $db = Database::get();
    $r = $db->Execute('select * from RazorProductAttributeValues av
      left join RazorProductAttributeKeys ak on av.akID = ak.akID
      where av.pID = ? and ak.pakProductOption = 1
      ', array( $product->getProductID() ));
    $options = array();
    while ($row = $r->FetchRow()) {
      $option = new Option();
      $option->setPropertiesFromArray( $row );
      $option->parseListValues();
      $option->default = $option->pakProductOptionDefault;
      $options[] = $option;
    }
    return $options;
  }

  public function getByAKID( $akID ) {

  }

  public function parseListValues() {
    $values = str_replace( ' ', '', $this->pakProductOptionValues);
    $values = explode(',', $values);
    $this->values = $values;
  }

  public function getValues() {
    return $this->values;
  }

  public function getDefault() {
    return $this->default;
  }

  public function render() {
    $output = '';
    $output .= '<select name="product-option-' . $this->akID . '">';
    foreach( $this->values as $value ) {
      $output .= '<option value="' . $value . '">';
      $output .= $value;
      $output .= '</option>';
    }
    $output .= '</select>';
    return $output;
  }

}
