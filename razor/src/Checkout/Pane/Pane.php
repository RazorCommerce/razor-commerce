<?php

namespace Razor\Core\Checkout\Pane;
use Loader;
use Core;
use \Razor\Core\Checkout\Checkout as Checkout;
use \Razor\Core\Order\Order;
use \Razor\Core\Order\Item as OrderItem;

class Pane {

  public $key;
  public $class;
  public $order; // order weight of this pane

  public function __construct() {
    $this->key = $this->getPaneKey();
    $this->class = $this->classFromKey( $this->key );
  }

  public function getPaneKey() {
    return t("pane");
  }

  public function classFromKey( $key ) {
    $class = str_replace( '_', '', $key );
    $class = ucwords( $class );
    return str_replace( ' ', '', $class );
  }

  // get a checkout pane
  public static function getByKey( $key ) {
    $className = self::classFromKey( $key );
    $paneClass = '\Razor\Core\Checkout\Pane\\' . $className;
    return new $paneClass;
  }

}
