<?php

use \Razor\Core\Field\Field;
use \Core;

$form = Core::make('helper/form');

?>

<form class="ccm-dashboard-content-form" action="<?php print $this->url('/dashboard/razor/shipping/save'); ?>" method="post">

  <fieldset>

    <div class="form-group">
      <?php Field::render( 'enable_shipping', 'collection', $settingCID ); ?>
    </div>

    <div class="form-group">
      <legend>Flat Rate Shipping</legend>
      <div class="checkbox" style="margin-left: 20px;">
        <?php Field::render( 'enable_flat_rate_shipping', 'collection', $settingCID ); ?>
      </div>
    </div>

    <div class="form-group">
      <?php print $form->label('flat_rate_shipping_cost_per_order', 'Cost Per Order'); ?>
      <?php Field::render( 'flat_rate_shipping_cost_per_order', 'collection', $settingCID ); ?>
    </div>

    <div class="form-group">
      <legend>Free Shipping</legend>
      <div class="checkbox" style="margin-left: 20px;">
        <?php Field::render( 'enable_free_shipping', 'collection', $settingCID ); ?>
      </div>
    </div>

    <div class="form-group">
      <?php print $form->label('free_shipping_minimum_order', 'Minimum Order'); ?>
      <?php Field::render( 'free_shipping_minimum_order', 'collection', $settingCID ); ?>
    </div>

    <div class="form-group">
      <legend>Pickup Shipping</legend>
      <div class="checkbox" style="margin-left: 20px;">
        <?php Field::render( 'enable_pickup_shipping', 'collection', $settingCID ); ?>
      </div>
    </div>

    <div class="form-group">
      <?php print $form->label('pickup_shipping_location', 'Pickup Location'); ?>
      <?php Field::render( 'pickup_shipping_location', 'collection', $settingCID ); ?>
    </div>

    <div class="ccm-dashboard-form-actions-wrapper">
      <div class="ccm-dashboard-form-actions">
        <?php print $form->submit('save_settings', 'Save', array('class' => 'btn btn-success pull-right') ); ?>
      </div>
    </div>

  </fieldset>

</form>
