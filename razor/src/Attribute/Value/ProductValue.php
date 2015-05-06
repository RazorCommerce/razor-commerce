<?php
namespace Razor\Core\Attribute\Value;

use Database;
use \Concrete\Core\Attribute\Value\Value as AttributeValue;

defined('C5_EXECUTE') or die(_("Access Denied."));

class ProductValue extends AttributeValue {

  public function setProduct( $product ) {
    $this->product = $product;
  }

  public static function getByID($avID) {
    $cav = new ProductValue();
    $cav->load($avID);
    if ($cav->getAttributeValueID() == $avID) {
        return $cav;
    }
  }

  public function delete() {
    $db = Database::get();
    $db->Execute('delete from RazorProductAttributeValues where pID = ? and akID = ? and avID = ?', array(
        $this->product->getProductID(),
        $this->attributeKey->getAttributeKeyID(),
        $this->getAttributeValueID()
    ));

    $num = $db->GetOne('select count(avID) from RazorProductAttributeValues where avID = ?', array( $this->getAttributeValueID() ));
    if ($num < 1) {
      parent::delete();
    }
  }
}
