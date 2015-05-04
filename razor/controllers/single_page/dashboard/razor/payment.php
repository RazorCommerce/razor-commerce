<?php
namespace Concrete\Package\Razor\Controller\SinglePage\Dashboard\Razor;
use \Concrete\Core\Page\Controller\DashboardPageController;
use \Razor\Core\Setting\Setting;
use \Razor\Core\Field\Field;
use \Page;

class Payment extends DashboardPageController {

  public function on_start() {
    $this->requireAsset('css', 'razor_css');
    $this->set('pageTitle', 'Payment Settings');
    $this->settings = array(
      'stripe_mode',
      'stripe_test_secret_key',
      'stripe_test_publishable_key',
      'stripe_live_secret_key',
      'stripe_live_publishable_key',
    );
  }

  public function view() {
    $setting = new Setting;
    $settingCID = $setting->getSettingCollectionID();
    $this->set( 'settingCID', $settingCID );
  }

  public function save() {
    if( !$this->post() ) {
      $this->redirect('/dashboard/razor/payment');
    }
    $setting = new Setting;
    $data = $this->post();
    foreach( $this->settings as $settingHandle ) {
      $value = $data['akID'][ $setting->getSettingAKID( $settingHandle ) ]['value'];
      $setting->set( $settingHandle, $value );
    }
    $this->redirect('/dashboard/razor/payment');
  }

}
