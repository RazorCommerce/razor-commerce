<?php

namespace Concrete\Package\Razor\Controller\SinglePage\Dashboard\Razor\Product;
use \Concrete\Core\Page\Controller\DashboardPageController;
use Razor\Core\Product\Product;
use Razor\Core\Product\Option\Option as ProductOption;
use Razor\Core\Product\ProductOption as ProductProductOption;

class Option extends DashboardPageController {

  public function view( $pID ) {
    $this->setProductOptions( $pID );
  }

  public function add( $pID, $optionID = false ) {
    $this->setProductOptions( $pID );
    $editOption = ProductOption::getByID( $optionID );
    $this->set('editOption', $editOption);
    $this->set('mode', 'add');
  }


  public function edit( $pID, $optionID ) {
    $this->setProductOptions( $pID );
    $editOption = ProductOption::getByID( $optionID );
    $this->set('editOption', $editOption);
    $this->set('mode', 'edit');
  }

  public function remove( $pID, $productOptionID ) {
    $this->setProductOptions( $pID );
    $product = Product::getByID( $pID );
    $productOption = ProductOption::getByID( $productOptionID );
    $product->option()->remove( $productOption );
  }

  private function saveEdit( $product, $productOption, $data ) {
    $productProductOption = $product->option()->get( $productOption );
    $values = $data['values'];
    $values = str_replace(' ', '', $values);
    $values = explode( ',', $values );
    foreach( $values as $value ) {
      $productOption->value()->add( $value );
    }
    $productProductOption->updateDefault( $data['default'] );
     $this->redirect( '/dashboard/razor/product/option/edit/' . $product->getProductID() . '/' . $productOption->getProductOptionID() );
  }

  public function save() {
    $data = $this->post();
    $pID = $data['pID'];
    $poID = $data['poID'];
    $mode = $data['mode'];
    $product = Product::getByID( $pID );

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
      $product = Product::getByID( $pID );
      $productProductOption = $product->option()->add( $productOption );
    } else {
      $this->saveEdit( $product, $productOption, $data );
    }

    $this->redirect( '/dashboard/razor/product/option/' . $pID );
  }

  private function setProductOptions( $pID ) {
    $product = Product::getByID( $pID );
    $this->set('pID', $pID);
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

}
