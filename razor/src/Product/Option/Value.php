<?php

namespace Razor\Core\Product\Option;

use \Concrete\Core\Foundation\Object;
use Database;
use Razor\Core\Product\Product;
use \Concrete\Package\Razor\Src\Attribute\Key\ProductKey;
use \Concrete\Package\Razor\Src\Attribute\Value\ProductValue;

defined('C5_EXECUTE') or die(_("Access Denied."));

class Value extends Object {

  protected $poID;

  public function setPOID( $poID ) {
    $this->poID = $poID;
  }

  public function getPOID() {
    return $this->poID;
  }

  public static function getByID( $povID ) {
    $db = Database::get();
    $data = $db->GetRow('select * from RazorProductOptionValues where povID = ?', $povID);
    $value = new Value();
    $value->setPropertiesFromArray( $data );
    return $value;
  }

  public function getByKey( $key ) {
    $db = Database::get();
    $data = $db->GetRow('select * from RazorProductOptionValues where poID = ? and povKey = ?',
    array( $this->poID, $key ));
    $value = new Value();
    $value->setPropertiesFromArray( $data );
    return $value;
  }

  public function getValue() {
    return $this->povValue;
  }

  public function getKey() {
    return $this->povKey;
  }

  public function makeKey( $value ) {
    $th = \Core::make('helper/text');
    return $th->handle( $value );
  }

  public function add( $value, $isDefault = false, $key = false ) {
    $db = Database::get();
    if( !$key ) {
      $key = $this->makeKey( $value );
    }
    $existing = $this->getByKey( $key )->getPOID();
    if( isset( $existing )) {
      return false;
    }
    $db->query("insert into RazorProductOptionValues (poID, povKey, povValue, povIsDefault) values (?, ?, ?, ?)",
      array( $this->poID, $key, $value, $isDefault )
    );
    $povID = $db->Insert_ID();
    $value = new Value();
    $value = $value->getByID( $povID );
    return $value;
  }

}
