<?php

namespace Razor\Core\Migration\Type;

use Razor\Core\Migration\Type\Type as MigrationType;
use Razor\Core\Migration\Test\Condition as TestCondition;
use Razor\Core\Setting\Setting;


class SettingImport extends MigrationType {

  public function getHandle() {
    return "setting_import";
  }

  public function getName() {
    return "Setting Import";
  }

  public function getImportNodeParentName() {
    return "settings";
  }

  public function getDescription() {
    return "Import commerce settings.";
  }

  public function conditions() {
    $conditions = array();

    $tc = new TestCondition();
    $tc->setName( 'Taxes' );
    $tc->setRequired( true );
    $tc->setMessage( 'No taxes found');
    $tc->setTest( 'Razor\Core\Migration\Type\SettingImport', 'hasSettings' );
    $conditions[] = $tc;

    return $conditions;
  }

  public function hasSettings( $data ) {
    $count = count( $data->settings->children() );
    if( !count ) {
      return false;
    }
    return true;
  }

  public function test() {

  }

  public function execute( $xml ) {
    $settingObj = new Setting;
    foreach ( $xml->settings->children() as $setting ) {
      $settingHandle = $setting->getName();
      $value = (string) $setting;
      $settingObj->set( $settingHandle, $value);
    }
  }

}
