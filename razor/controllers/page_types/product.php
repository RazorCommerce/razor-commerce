<?php

namespace Razor\Core\Controller\PageType;

use Concrete\Core\Page\Controller\PageTypeController;

class Product extends PageTypeController {
    public function on_start() {
      $this->requireAsset('css', 'razor_css');
    }
}
