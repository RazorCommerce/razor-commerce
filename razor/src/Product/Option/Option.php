<?php

namespace Razor\Core\Product\Option;

use \Concrete\Core\Foundation\Object;
use Database;
use Razor\Core\Product\Product;
use \Concrete\Package\Razor\Src\Attribute\Key\ProductKey;
use \Concrete\Package\Razor\Src\Attribute\Value\ProductValue;

defined('C5_EXECUTE') or die(_("Access Denied."));

class Option extends Object {

  public function getProductOptionID() {
    return $this->poID;
  }

  public function getByID( $poID ) {
    $db = Database::get();
    $data = $db->GetRow('select * from RazorProductOptions where poID = ?', $poID);
    $option = new Option();
    $option->setPropertiesFromArray( $data );
    return $option;
  }

  public static function add( $data ) {
    $db = Database::get();
    $db->query("insert into RazorProductOptions (poHandle, poType, poName, poRenderDefault) values (?, ?, ?, ?)",
      array( $data['poHandle'], $data['poType'], $data['poName'], $data['poRenderDefault'] )
    );
    $poID = $db->Insert_ID();
    $option = new Option();
    $option = $option->getByID( $poID );
    return $option;
  }

  public function value() {
    $value = new \Razor\Core\Product\Option\Value;
    $value->setPOID( $this->poID );
    return $value;
  }

  public function getValues( $defaults = false ) {
    $db = Database::get();
    $r = $db->Execute('select povID from RazorProductOptionValues where poID = ?', array( $this->poID ));
    $values = array();
    while ($row = $r->FetchRow()) {
      $value = new \Razor\Core\Product\Option\Value;
      $values[] = $value->getByID( $row['povID'] );
    }
    return $values;
  }



  // list of options for given product
  public function getByProduct( $product ) {
    $db = Database::get();
    $r = $db->Execute('select * from RazorProductOptions po
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
