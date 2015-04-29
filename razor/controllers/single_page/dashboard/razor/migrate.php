<?php
namespace Concrete\Package\Razor\Controller\SinglePage\Dashboard\Razor;
use \Concrete\Core\Page\Controller\DashboardPageController;
use \Razor\Core\Migration\Migration;

class Migrate extends DashboardPageController {

  public function on_start() {
    $this->requireAsset('css', 'razor_css');
  }

  public function view() {

  }

}
