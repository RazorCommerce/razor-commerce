<?php
namespace Concrete\Package\Razor\Attribute\ComposerMenu;
use Loader;
use \Concrete\Core\Foundation\Object;
use \Concrete\Core\Attribute\DefaultController;

class Controller extends DefaultController  {

	public function form() {}

	public function composer() {
		$this->requireAsset('javascript', 'razor_product_composer');
		$this->requireAsset('css', 'razor_product_composer');
	}


}
