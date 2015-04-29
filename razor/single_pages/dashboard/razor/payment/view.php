<?php

use \Razor\Core\Field\Field;
use \Core;

$form = Core::make('helper/form');

?>

<div class="row">
  <div class="col-md-12">
    <form action="<?php print $this->url('/dashboard/razor/payment/save'); ?>" method="post">
      <fieldset>
        <legend>Stripe API Settings</legend>
        <div class="form-group">
          <?php print $form->label('stripe_mode', 'Stripe Mode'); ?>
          <?php Field::render( 'stripe_mode', 'collection', $page->getCollectionID() ); ?>
        </div>
        <div class="form-group">
          <?php print $form->label('stripe_test_secret_key', 'Test Secret Key'); ?>
          <?php Field::render( 'stripe_test_secret_key', 'collection', $page->getCollectionID() ); ?>
        </div>
        <div class="form-group">
          <?php print $form->label('stripe_test_publishable_key', 'Test Publishable Key'); ?>
          <?php Field::render( 'stripe_test_publishable_key', 'collection', $page->getCollectionID() ); ?>
        </div>
        <div class="form-group">
          <?php print $form->label('stripe_live_secret_key', 'Live Secret Key'); ?>
          <?php Field::render( 'stripe_live_secret_key', 'collection', $page->getCollectionID() ); ?>
        </div>
        <div class="form-group">
          <?php print $form->label('stripe_live_publishable_key', 'Live Publishable Key'); ?>
          <?php Field::render( 'stripe_live_publishable_key', 'collection', $page->getCollectionID() ); ?>
        </div>
      </fieldset>

      <div class="ccm-dashboard-form-actions-wrapper">
        <div class="ccm-dashboard-form-actions">
          <?php print $form->submit('save_settings', 'Save', array('class' => 'btn btn-primary pull-right') ); ?>
        </div>
      </div>

    </form>
  </div>
</div>
