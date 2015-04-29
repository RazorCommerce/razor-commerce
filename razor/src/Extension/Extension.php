<?php

namespace Razor\Core\Extension;
use Package;

class Extension {

  public function register( $type, $handle, $namespace ) {
    $pkg = Package::getByHandle('razor');
    $eo = $this->getByHandle( $type );
    $config = $eo->getConfig();
    $registered = $pkg->getConfig()->get( $config );
    $registered[ $handle ] = $namespace;
    $pkg->getConfig()->save( $config, $registered );
    $eo->install( $handle, $namespace );
  }

  public function deregister( $type, $handle ) {
    $pkg = Package::getByHandle('razor');
    $eo = $this->getByHandle( $type );
    $config = $eo->getConfig();
    $registered = $pkg->getConfig()->get( $config );
    $pkg->getConfig()->save( $config . '.' . $handle, false );
    $eo->uninstall( $handle, $namespace );
  }

  public function getByHandle( $handle ) {
    $object = false;
    if( $handle == 'product_type' ) {
      $object = new \Razor\Core\Extension\Type\ProductType;
    }
    if( $handle == 'payment_method' ) {
      $object = new \Razor\Core\Extension\Type\PaymentMethod;
    }
    if( $handle == 'shipping_method' ) {
      $object = new \Razor\Core\Extension\Type\ShippingMethod;
    }
    return $object;
  }

}
