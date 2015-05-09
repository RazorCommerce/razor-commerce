<?php
namespace Application\Controller\SinglePage\Dashboard\Razor\Product;
use \Concrete\Core\Page\Controller\DashboardPageController;

use \Concrete\Package\Razor\Src\Attribute\Key\ProductKey;
use Razor\Core\Product\Product;
use Razor\Core\Product\ProductOption as ProductProductOption;
use Razor\Core\Product\Option\Option as ProductOption;

class Option extends DashboardPageController {

  public function on_start() {
    $product = Product::getByID( 1 );

    $currentOptions = $product->option()->getAll();
    $this->set('currentOptions', $currentOptions);

    $option = new ProductOption;
    $allOptions = $option->getAll();

    foreach( $allOptions as $option ) {
      $ppo = new ProductProductOption( $product );
      $option->assigned = false;
      if( $ppo->hasOption( $option )) {
        $option->assigned = true;
      }
    }
    $this->set('allOptions', $allOptions);
  }

  public function view() {





  }

  public function add( $optionID ) {

    // get data
    $data = $this->post();

    if( isset($data['save_settings'])) {

      $this->set('data', $data);
      $handle = uncamelcase( $data['name'] );

    }

    $editOption = ProductOption::getByID( $optionID );
    $this->set('editOption', $editOption);

  }


  public function edit( $optionHandle ) {

  }

}
