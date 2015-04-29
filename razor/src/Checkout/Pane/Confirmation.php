<?php

namespace Razor\Core\Checkout\Pane;

// payment pane
class Confirmation extends Pane {

  public function getPaneKey() {
    return t("confirmation");
  }

}
