<?php
namespace Concrete\Package\Razor\Controller\SinglePage\Dashboard\Razor;
use \Concrete\Core\Page\Controller\DashboardPageController;
use \Razor\Core\Setting\Setting;
use \Concrete\Core\Page\PageList;
use \Page;
use \Razor\Core\Shipping\Shipping as ShippingClass;

class Settings extends DashboardPageController {

  public function on_start() {

    $this->requireAsset('css', 'razor_css');
    $this->set('pageTitle', 'Razor Commerce Settings');

    // load fields
    $this->settings = array(
      // 'collect_customer_addresses',
      // 'enable_anonymous_checkout',
      'store_location',
    );
  }

  public function view() {
    $setting = new Setting;
    $settingCID = $setting->getSettingCollectionID();
    $this->set( 'settingCID', $settingCID );
  }

  public function save() {
    if( !$this->post() ) {
      $this->redirect('/dashboard/razor/settings');
    }
    $setting = new Setting;
    $data = $this->post();
    foreach( $this->settings as $settingHandle ) {
      $value = $data['akID'][ $setting->getSettingAKID( $settingHandle ) ]['value'];
      $setting->set( $settingHandle, $value );
    }
    $this->redirect('/dashboard/razor/settings');
  }

}
