<?php

namespace Razor\Core\Product\Attribute;

use \Concrete\Core\Attribute\Type as AttributeType;
use Database;
use CacheLocal;
use Package;
use \Concrete\Core\Attribute\Value\ValueList as AttributeValueList;
use Razor\Core\Product\Attribute\Value as ProductAttributeValue;
use \Concrete\Core\Attribute\Key\Key as AttributeKey;

defined('C5_EXECUTE') or die(_("Access Denied."));

class Key extends AttributeKey {

  public function getAttributes($pID, $method = 'getValue') {
    $db = Database::get();
    $values = $db->GetAll("select akID, avID from RazorProductAttributeValues where pID = ?", array( $pID ));
    $avl = new AttributeValueList();
    foreach($values as $val) {
      $ak = StoreProductKey::getByID($val['akID']);
      if (is_object($ak)) {
        $value = $ak->getAttributeValue($val['avID'], $method);
        $avl->addAttributeValue($ak, $value);
      }
    }
    return $avl;
  }

  public function load($akID) {
    parent::load( $akID );
    $db = Database::get();
    $row = $db->GetRow("select * from RazorProductAttributeKeys where akID = ?", array($akID));
    $this->setPropertiesFromArray($row);
  }

  public function getAttributeValue($avID, $method = 'getValue') {
    $av = StoreProductAttributeValue::getByID($avID);
    $av->setAttributeKey($this);
    return $av->{$method}();
  }

  public static function getByID($akID) {
    $ak = new StoreProductKey();
    $ak->load($akID);
    if ($ak->getAttributeKeyID() > 0) {
        return $ak;
    }
  }

  public static function getByHandle( $akHandle ) {
    $db = Database::get();
    $q = "SELECT ak.akID
        FROM AttributeKeys ak
        INNER JOIN AttributeKeyCategories akc ON ak.akCategoryID = akc.akCategoryID
        WHERE ak.akHandle = ?
        AND akc.akCategoryHandle = 'commerce_product'";
    $akID = $db->GetOne($q, array($akHandle));
    if ($akID > 0) {
        $ak = StoreProductKey::getByID($akID);
    }
    if ($ak === -1) {
        return false;
    }
    return $ak;
  }


  public static function getList() {
    return parent::getList('commerce_product');
  }

  protected function saveAttribute($product, $value = false) {
    $av = $product->getAttributeValueObject($this, true);
    parent::saveAttribute($av, $value);
    $db = Database::get();
    $v = array($product->getProductID(), $this->getAttributeKeyID(), $av->getAttributeValueID());
    $db->Replace('RazorProductAttributeValues', array(
        'pID' => $product->getProductID(),
        'akID' => $this->getAttributeKeyID(),
        'avID' => $av->getAttributeValueID()
    ), array('pID', 'akID'));
    unset($av);
  }

  public static function add($type, $args, $pkg = false) {
    $ak = parent::add('commerce_product', $type, $args, $pkg);

    extract($args);

    $v = array($ak->getAttributeKeyID());
    $db = Database::get();
    $db->Execute('REPLACE INTO RazorProductAttributeKeys (akID) VALUES (?)', $v);

    $nak = new StoreProductKey();
    $nak->load($ak->getAttributeKeyID());
    return $ak;
  }

  public function update($args) {
    $ak = parent::update($args);
    extract($args);
    $v = array($ak->getAttributeKeyID());
    $db = Database::get();
    $db->Execute('REPLACE INTO RazorProductAttributeKeys (akID) VALUES (?)', $v);
  }

  public function delete() {
    parent::delete();
    $db = Database::get();
    $r = $db->Execute('select avID from RazorProductAttributeValues where akID = ?', array($this->getAttributeKeyID()));
    while ($row = $r->FetchRow()) {
        $db->Execute('delete from AttributeValues where avID = ?', array($row['avID']));
    }
    $db->Execute('delete from RazorProductAttributeValues where akID = ?', array($this->getAttributeKeyID()));
  }

}
