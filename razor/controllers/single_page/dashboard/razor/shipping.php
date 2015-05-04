<?php
namespace Concrete\Package\Razor\Controller\SinglePage\Dashboard\Razor;
use \Concrete\Core\Page\Controller\DashboardPageController;
use \Razor\Core\Field\Field;
use \Razor\Core\Setting\Setting;
use \Concrete\Core\Page\PageList;
use \Page;

use \Razor\Core\Shipping\Shipping as ShippingClass;

class Shipping extends DashboardPageController {

  public $shipping;
  public $settings;

  public function on_start() {

    $this->requireAsset('css', 'razor_css');
    $this->set('pageTitle', 'Shipping Settings');
    $this->shipping = new ShippingClass();
    $this->settings = array(
      'enable_shipping',
      'enable_flat_rate_shipping',
      'flat_rate_shipping_cost_per_order',
      'enable_free_shipping',
      'free_shipping_minimum_order',
      'enable_pickup_shipping',
      'pickup_shipping_location',
    );
  }

  public function view() {
    $setting = new Setting;
    $settingCID = $setting->getSettingCollectionID();
    $this->set( 'settingCID', $settingCID );
  }

  public function save() {
    if( !$this->post() ) {
      $this->redirect('/dashboard/razor/shipping');
    }
    $setting = new Setting;
    $data = $this->post();
    foreach( $this->settings as $settingHandle ) {
      $value = $data['akID'][ $setting->getSettingAKID( $settingHandle ) ]['value'];
      $setting->set( $settingHandle, $value );
    }
    $this->redirect('/dashboard/razor/shipping');
  }

}
