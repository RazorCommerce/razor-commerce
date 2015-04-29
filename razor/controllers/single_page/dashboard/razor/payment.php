<?php
namespace Concrete\Package\Razor\Controller\SinglePage\Dashboard\Razor;
use \Concrete\Core\Page\Controller\DashboardPageController;
use \Razor\Core\Field\Field;
use \Page;

class Payment extends DashboardPageController {

  public function on_start() {
    $this->requireAsset('css', 'razor_css');
    $this->set('pageTitle', 'Payment Type Settings');

    // load fields
    $fieldHandles = array(
      'stripe_mode',
      'stripe_test_secret_key',
      'stripe_test_publishable_key',
      'stripe_live_secret_key',
      'stripe_live_publishable_key',
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
    $page = Page::getByPath( '/dashboard/razor/payment' );
    $this->set( 'page', $page );
  }

  public function save() {
    $page = Page::getByPath( '/dashboard/razor/payment' );
    $this->set( 'page', $page );
    if( !$this->post() ) {
      $this->redirect('/dashboard/razor/payment');
    }
    $data = $this->post();
    foreach( $this->fields as $field ) {
      $value = $data['akID'][ $field->id ];
      Field::update( $field->id, $value['value'], 'collection', $page );
    }
    $this->redirect('/dashboard/razor/payment');
  }

}
