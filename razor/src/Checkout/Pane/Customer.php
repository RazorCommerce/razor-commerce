<?php

namespace Razor\Core\Checkout\Pane;

use \Razor\Core\Checkout\Pane\Pane as CheckoutPane;
use \Razor\Core\Account\Account;

// customer pane
class Customer extends CheckoutPane {

  public function getPaneKey() {
    return t("customer");
  }

}
