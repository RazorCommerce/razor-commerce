<?php

use \Razor\Core\Field\Field;
use \Core;
use \Package;

$form = Core::make('helper/form');

?>

<form class="ccm-dashboard-content-form" action="<?php print $this->url('/dashboard/razor/settings/save'); ?>" method="post">

  <fieldset>

    <!--

    <legend>Checkout Settings</legend>

    <div class="checkbox" style="margin-left: 20px;">
      <?php // Field::render( 'collect_customer_addresses', 'collection', $settingCID ); ?>
    </div>

    <div class="checkbox" style="margin-left: 20px;">
      <?php // Field::render( 'enable_anonymous_checkout', 'collection', $settingCID ); ?>
    </div>

    -->

    <div style="margin-top: 15px;">
      <?php print $form->label('store_location', 'Store Location'); ?>
      <?php Field::render( 'store_location', 'collection', $settingCID ); ?>
    </div>

    <div class="ccm-dashboard-form-actions-wrapper">
      <div class="ccm-dashboard-form-actions">
        <?php print $form->submit('save_settings', 'Save', array('class' => 'pull-right btn btn-success') ); ?>
      </div>
    </div>

  </fieldset>

</form>
