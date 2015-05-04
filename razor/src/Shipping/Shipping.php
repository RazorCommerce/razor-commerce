<?php

namespace Razor\Core\Shipping;
use \Razor\Core\Shipping\Method\Method as ShippingMethod;
use \Razor\Core\Field\Field;
use \Razor\Core\Extension\Extension;
use Loader;
use Package;
use Page;

class Shipping {

  public function save_shipping_methods( $shippingMethods ) {
    $pkg = Package::getByHandle('razor');
    $pkg->getConfig()->save( 'commerce.shipping_methods', $shippingMethods );
  }

  public function getAvailableMethods( $order ) {
    $allMethods = $this->getMethods();
    $availableMethod = array();
    foreach( $allMethods as $sm ) {
      $available = $sm->available( $order );
      if( $available ) {
        $availableMethod[] = $sm;
      }
    }
    return $availableMethod;
  }

  public static function getMethods() {
    $pkg = Package::getByHandle('razor');
    $shipping_method_handles = $pkg->getConfig()->get('commerce.shipping_method');
    $shipping_methods = array();
    if( count($shipping_method_handles)) {
      foreach( $shipping_method_handles as $smh ) {
        $shipping_methods[] = new $smh();
      }
    }
    return $shipping_methods;
  }

  public function installDefaultMethods() {
    $ext = new Extension();
    $defaults = array(
      'flat_rate' => '\Razor\Core\Shipping\Method\FlatRate',
      'free_shipping' => '\Razor\Core\Shipping\Method\FreeShipping',
      'pickup' => '\Razor\Core\Shipping\Method\Pickup',
    );
    foreach ( $defaults as $handle => $namespace ) {
      $ext->register('shipping_method', $handle, $namespace);
    }
  }

  public function is_enabled() {
    return Shipping::setting('enable_shipping');
  }

  public static function setting( $settingHandle ) {
    $settings = Page::getByPath('/dashboard/razor/shipping');
    return $settings->getAttribute( $settingHandle );
  }

}
