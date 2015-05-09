<?php
namespace Concrete\Package\Razor\Controller\SinglePage\Dashboard\Razor\Product;
use \Concrete\Core\Page\Controller\DashboardPageController;

use \Concrete\Package\Razor\Src\Attribute\Key\ProductKey;
use Razor\Core\Product\Product;
use Razor\Core\Product\ProductOption as ProductProductOption;
use Razor\Core\Product\Option\Option as ProductOption;

class Option extends DashboardPageController {

  public function on_start() {
    // $this->set('pageTitle', 'Product Options');

    $product = Product::getByID( 1 );

    if( $product ) {
      $currentOptions = $product->option()->getAll();
      $this->set('currentOptions', $currentOptions);
    } else {
      $this->set('currentOptions', false);
    }

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

  public function add( $productID, $optionID = false ) {

    // get data
    $editOption = ProductOption::getByID( $optionID );
    $this->set('editOption', $editOption);

  }

  public function save() {
    $data = $this->post();

    if( isset($data['save_settings'])) {

      $poID = $data['poID'];

      // add existing ProductOption to Product
      if( !$poID ) {
        $poData = array(
          'poHandle' => uncamelcase( $data['name'] ),
          'poName' => $data['name'],
          'poType' => 'select',
          'poValueDefault' => $data['default']
        );
        $productOption = ProductOption::add( $poData );

        $values = $data['values'];
        $values = str_replace(' ', '', $values);
        $values = explode( ',', $values );
        foreach( $values as $value ) {
          $productOption->value()->add( $value );
        }


      } else {
        $productOption = ProductOption::getByID( $poID );
      }

      $product = Product::getByID(1);
      $productProductOption = $product->option()->add( $productOption );

      // $handle = uncamelcase( $data['name'] );

      var_dump('<br /><br /><br /><br />');
      var_dump( $data );
      var_dump( $product );
      var_dump( $productOption );
      var_dump( $productProductOption );

    }

    // $this->redirect( '/dashboard/product/option/edit/1/' . $poID );
  }


  public function edit( $productID, $optionHandle ) {

  }

}
