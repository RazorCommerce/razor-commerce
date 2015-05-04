<?php

namespace Razor\Core\Install;

use Razor\Core\Setting\Setting;

class Settings {

  public function defaults() {
    $setting = new Setting();
    $setting->setDefaults();
  }

}
