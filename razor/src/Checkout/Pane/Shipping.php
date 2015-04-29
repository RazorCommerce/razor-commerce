<?php

namespace Razor\Core\Checkout\Pane;
use \Razor\Core\Account\Account;

// shipping pane
class Shipping extends Pane {

  public function getPaneKey() {
    return t("shipping_address");
  }

}
