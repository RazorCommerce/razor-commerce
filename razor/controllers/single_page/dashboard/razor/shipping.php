<?php
namespace Concrete\Package\Razor\Controller\SinglePage\Dashboard\Razor;
use \Concrete\Core\Page\Controller\DashboardPageController;
use \Razor\Core\Field\Field;
use \Concrete\Core\Page\PageList;
use \Page;

use \Razor\Core\Shipping\Shipping as ShippingClass;

class Shipping extends DashboardPageController {

  public $shipping;
  public $fields;

  public function on_start() {
    $this->requireAsset('css', 'razor_css');
    $this->set('pageTitle', 'Shipping Settings');
    $this->shipping = new ShippingClass();

    // load fields
    $fieldHandles = array(
      'enable_shipping',
      'enable_flat_rate_shipping',
      'flat_rate_shipping_cost_per_order',
      'enable_free_shipping',
      'free_shipping_minimum_order',
      'enable_pickup_shipping',
      'pickup_shipping_location',
    );
    $fields = array();
    foreach( $fieldHandles as $fieldHandle ) {
      $f = new Field();
      $field = $f->getByHandle( $fieldHandle );
      $fields[] = $field;
    }
    $this->fields = $fields;
  }

  public function view() {
    $sp = Page::getByPath( '/dashboard/razor/shipping' );
    $this->set( 'page', $sp );
  }

  public function save() {
    $sp = Page::getByPath( '/dashboard/razor/shipping' );
    $this->set( 'page', $sp );
    // save user field data
    if( !$this->post() ) {
      $this->redirect('/dashboard/razor/shipping');
    }
    $data = $this->post();
    foreach( $this->fields as $field ) {
      $value = $data['akID'][ $field->id ];
      Field::update( $field->id, $value['value'], 'collection', $sp);
    }
    $this->redirect('/dashboard/razor/shipping');
  }

}
