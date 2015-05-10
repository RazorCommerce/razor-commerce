<?php

namespace Concrete\Package\Razor\Controller\SinglePage\Dashboard\Razor\Product;
use \Concrete\Core\Page\Controller\DashboardPageController;
use Razor\Core\Product\Product;
use Razor\Core\Product\Option\Option as ProductOption;
use Razor\Core\Product\ProductOption as ProductProductOption;

class Option extends DashboardPageController {

  public function view( $productID ) {
    $product = Product::getByID( $productID );
    $option = new ProductOption;
    $allOptions = $option->getAll();
    if( $product ) {
      $currentOptions = $product->option()->getAll();
      $this->set('currentOptions', $currentOptions);
      foreach( $allOptions as $option ) {
        $ppo = new ProductProductOption( $product );
        $option->assigned = false;
        if( $ppo->hasOption( $option )) {
          $option->assigned = true;
        }
      }
    } else {
      $this->set('currentOptions', false);
    }
    $this->set('allOptions', $allOptions);
  }

  public function add( $productID, $optionID = false ) {
    $editOption = ProductOption::getByID( $optionID );
    $this->set('editOption', $editOption);
    $this->set('mode', 'add');
  }


  public function edit( $productID, $optionID ) {
    $editOption = ProductOption::getByID( $optionID );
    $this->set('editOption', $editOption);
    $this->set('mode', 'edit');
  }

  public function remove( $productID, $productOptionID ) {
    $product = Product::getByID( $productID );
    $productOption = ProductOption::getByID( $productOptionID );
    $product->option()->remove( $productOption );
  }

  public function save() {
    $data = $this->post();
    if( !isset($data['save_settings'])) {
      $this->redirect( '/dashboard/product/option/' );
    }

    $productID = $data['productID'];
    $poID = $data['poID'];

    // add new ProductOption
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
    if( $mode == 'add' ) {
      $product = Product::getByID( $productID );
      $productProductOption = $product->option()->add( $productOption );
    } else {
      $product = Product::getByID( $productID );
      $productProductOption = $product->option()->get( $productOption );
      $values = $data['values'];
      $values = str_replace(' ', '', $values);
      $values = explode( ',', $values );
      foreach( $values as $value ) {
        $productOption->value()->add( $value );
      }
    }
  }

}
