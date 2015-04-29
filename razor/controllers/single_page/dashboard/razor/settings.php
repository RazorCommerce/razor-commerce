<?php
namespace Concrete\Package\Razor\Controller\SinglePage\Dashboard\Razor;
use \Concrete\Core\Page\Controller\DashboardPageController;
use \Razor\Core\Field\Field;
use \Concrete\Core\Page\PageList;
use \Page;
use \Razor\Core\Shipping\Shipping as ShippingClass;

class Settings extends DashboardPageController {

  public function on_start() {
    
    $this->requireAsset('css', 'razor_css');
    $this->set('pageTitle', 'Razor Commerce Settings');

    // load fields
    $fieldHandles = array(
      // 'collect_customer_addresses',
      // 'enable_anonymous_checkout',
      'store_location',
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
    $page = Page::getByPath( '/dashboard/razor/settings' );
    $this->set( 'page', $page );
  }

  public function save() {
    $page = Page::getByPath( '/dashboard/razor/settings' );
    $this->set( 'page', $page );
    if( !$this->post() ) {
      $this->redirect('/dashboard/razor/settings');
    }
    $data = $this->post();
    foreach( $this->fields as $field ) {
      $value = $data['akID'][ $field->id ];
      Field::update( $field->id, $value['value'], 'collection', $page);
    }
    $this->redirect('/dashboard/razor/settings');
  }

}
