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

  public function getByHandle( $poHandle ) {
    $db = Database::get();
    $data = $db->GetRow('select * from RazorProductOptions where poHandle = ?', $poHandle);
    $option = new Option();
    $option->setPropertiesFromArray( $data );
    return $option;
  }

  public function getByID( $poID ) {
    $db = Database::get();
    $data = $db->GetRow('select * from RazorProductOptions where poID = ?', $poID);
    $option = new Option();
    $option->setPropertiesFromArray( $data );
    return $option;
  }

  public function getAll() {
    $db = Database::get();
    $r = $db->Execute('select poID from RazorProductOptions');
    $options = array();
    while ($row = $r->FetchRow()) {
      $po = new Option;
      $po = $po->getByID( $row['poID'] );
      $options[] = $po;
    }
    return $options;
  }

  public static function add( $data ) {
    $db = Database::get();
    $db->query("insert into RazorProductOptions (poHandle, poName, poType, poValueDefault, poRenderDefault) values (?, ?, ?, ?, ?)",
      array( $data['poHandle'], $data['poName'], $data['poType'], $data['poValueDefault'], $data['poRenderDefault'] )
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

  public function getValuesAsList() {
    $values = $this->getValues();
    $valueList = '';
    foreach( $values as $value ) {
      $valueList .= $value->getValue() . ', ';
    }
    $valueList = substr( $valueList, 0, -2 );
    return $valueList;
  }

  public function getValueDefault() {
    return $this->poValueDefault;
  }

  public function getRenderDefault() {
    return $this->poRenderDefault;
  }

  public function parseListValues() {
    $values = str_replace( ' ', '', $this->pakProductOptionValues);
    $values = explode(',', $values);
    $this->values = $values;
  }

  public function getOptionName() {
    return $this->poName;
  }

}
