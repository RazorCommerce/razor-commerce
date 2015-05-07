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

  public static function getByID( $povID ) {
    $db = Database::get();
    $data = $db->GetRow('select * from RazorProductOptionValues where povID = ?', $povID);
    $value = new Value();
    $value->setPropertiesFromArray( $data );
    return $value;
  }

  public function add( $value, $isDefault = false, $key = false ) {
    $db = Database::get();
    if( !$key ) {
      $th = \Core::make('helper/text');
      $key = $th->handle( $value );
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
