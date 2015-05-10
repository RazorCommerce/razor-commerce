<?php

namespace Razor\Core\Product;

use \Concrete\Core\Foundation\Object;
use Database;
use Razor\Core\Product\Product;
use Razor\Core\Product\Option\Option;
use \Concrete\Package\Razor\Src\Attribute\Key\ProductKey;
use \Concrete\Package\Razor\Src\Attribute\Value\ProductValue;

defined('C5_EXECUTE') or die(_("Access Denied."));

class ProductOption extends Object {

  public function __construct( $product ) {
    $this->product = $product;
  }

  public function hasOption( $productOption ) {
    if( $this->get( $productOption )) {
      return true;
    }
    return false;
  }

  public function add( $productOption ) {

    $ppo = new ProductOption( $this->product );
    $ppo = $ppo->get( $productOption );
    if( $ppo ) {
      return $ppo;
    }

    $db = Database::get();
    $db->query("insert into RazorProductProductOptions (pID, poID)
      values (?, ?)",
      array( $this->product->getProductID(), $productOption->getProductOptionID() )
    );
    $ppo = new ProductOption( $this->product );
    $ppo = $ppo->get( $productOption );
    return $ppo;

  }

  public function update() {

  }

  public function getAll() {
    $db = Database::get();
    $r = $db->Execute('select poID from RazorProductProductOptions where pID = ?', array( $this->product->getProductID() ));
    $options = array();
    while ($row = $r->FetchRow()) {
      $po = new Option;
      $po = $po->getByID( $row['poID'] );
      $ppo = $this->get( $po );
      $options[] = $ppo;
    }
    return $options;
  }

  public function get( $productOption ) {
    $db = Database::get();
    $data = $db->GetRow('select * from RazorProductProductOptions where pID = ? and poID = ?',
    array( $this->product->getProductID(), $productOption->getProductOptionID() ));
    if( empty( $data ) ) {
      return false;
    }
    $ppo = new ProductOption( $this->product );
    $ppo->setPropertiesFromArray( $data );
    $ppo->productOption = $productOption;
    return $ppo;
  }

  public function render( $type = false ) {
    $this->renderPrepare();
    if( !count($this->poValues)) {
      return false;
    }
    $output = '';
    $output .= '<select name="product-option-' . $this->akID . '">';
    foreach( $this->poValues as $optionValue ) {
      $output .= '<option value="' . $optionValue->povKey . '">';
      $output .= $optionValue->povValue;
      $output .= '</option>';
    }
    $output .= '</select>';
    return $output;
  }

  public function renderPrepare() {
    if( !$this->poValues ) {
      $this->poValues = $this->productOption->getValues();
    }
    if( !$this->poValueDefault ) {
      $this->poValueDefault = $this->productOption->getValueDefault();
    }
    if( !$this->poRenderDefault ) {
      $this->poRenderDefault = $this->productOption->getRenderDefault();
    }
  }

  public function getOptionName() {
    return $this->productOption->getOptionName();
  }

  public function remove( $productOption ) {
    $db = Database::get();
    $db->Execute('delete from RazorProductProductOptions where pID = ? and poID = ?',
      array( $this->product->getProductID(), $productOption->getProductOptionID() ));
  }

  public function updateValues( $valueKeys ) {
    $db = Database::get();
    $values = implode ( ",", $valueKeys );
    $r = $db->Execute('update RazorProductProductOptions set poValues = ? where pID = ? and poID = ?',
      array( $values, $this->product->getProductID(), $this->productOption->getProductOptionID() ));
  }

  public function updateDefaultValue( $defaultValue ) {
    $db = Database::get();
    $r = $db->Execute('update RazorProductProductOptions set poValueDefault = ? where pID = ? and poID = ?',
      array( $defaultValue, $this->product->getProductID(), $this->productOption->getProductOptionID() ));
  }

  public function getValuesAsList() {
    if( isset( $this->poValues )) {
      $valueKeys = explode( ',', $this->poValues );
      $valueList = array();
      foreach( $valueKeys as $valueKey ) {
        $valueList[] = $this->productOption->value()->getByKey( $valueKey )->getValue();
      }
      return implode( ', ', $valueList );
    }
    return $this->productOption->getValuesAsList();
  }

  public function getValueDefault() {
    if( isset( $this->poValueDefault )) {
      return $this->poValueDefault;
    }
    return $this->productOption->getValueDefault();
  }

}
