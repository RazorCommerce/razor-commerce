<?php

$form = Core::make('helper/form');

?>

<?php print $form->hidden( 'stripe-publishable-key', $publishableKey ); ?>

<div class="payment-field credit-card-number">
  <?php print $form->label('credit-card-number', 'Card Number'); ?>
  <input type="text" class="form-control credit-card-number" size="20" data-stripe="number"/>
</div>

<div class="row">
  <div class="col-xs-4 payment-field credit-card-cvc">
    <?php print $form->label('credit-card-cvc', 'CVC'); ?>
    <input name="credit-card-cvc" type="text" class="form-control credit-card-cvc" size="4" data-stripe="cvc"/>
  </div>
  <div class="col-xs-4 payment-field credit-card-expiry-month">
    <?php print $form->label('credit-card-expiry', 'Expiration Month (MM)'); ?>
    <input name="credit-card-expiry-month" type="text" class="form-control credit-card-expiry-month" size="2" data-stripe="exp-month"/>
  </div>
  <div class="col-xs-4 payment-field credit-card-expiry-year">
    <?php print $form->label('credit-card-expiry', 'Expiration Year (YYYY)'); ?>
    <input name="credit-card-expiry-year" type="text" class="form-control credit-card-expiry-year" size="4" data-stripe="exp-year"/>
  </div>
</div>
