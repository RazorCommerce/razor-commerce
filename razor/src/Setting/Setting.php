<?php

namespace Razor\Core\Setting;

use Concrete\Core\Attribute\Key\CollectionKey as AttributeCollectionKey;
use Page;

define('SETTINGS_PATH', '/dashboard/razor');

class Setting {

  public function __construct() {
    $this->sp = Page::getByPath( SETTINGS_PATH );
  }

  public function get( $settingHandle ) {
    return $this->sp->getAttribute( $settingHandle );
  }

  public function set( $settingHandle, $value ) {
    $this->sp->setAttribute( $settingHandle, $value );
  }

  public function getSettingName( $settingHandle ) {
    $ak = AttributeCollectionKey::getByHandle( $settingHandle );
    return $ak->getAttributeKeyDisplayName();
  }
  
  public function setDefaults() {
    $defaults = $this->getDefaults();
    foreach( $defaults as $settingHandle => $value ) {
      $this->set( $settingHandle, $value );
    }
  }

  public function getDefaults() {
    $defaults = array(
      'enable_shipping' => true,
      'enable_flat_rate_shipping' => true,
      'flat_rate_shipping_cost_per_order' => 15.00,
      'enable_free_shipping' => false,
      'free_shipping_minimum_order' => null,
      'enable_pickup_shipping' => false,
      'pickup_shipping_location' => null,
    )
    return $defaults;
  }

}
