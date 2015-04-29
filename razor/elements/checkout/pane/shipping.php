<?php
use \Razor\Core\Checkout\Pane\Pane as CheckoutPane;
use \Razor\Core\Field\Field;

$form = Core::make('helper/form');
?>

<div class="row shipping-pane">

  <div class="col-xs-12 shipping-address-choice">
    <?php
      print $form->label('shipping_copy_billing', 'Ship to Different Address?');
      print $form->checkbox( 'shipping_copy_billing', 'Ship to Different Address?');
    ?>
  </div>

  <div class="col-xs-12">
    <div class="shipping-address-form-wrap">
      <h3>Shipping Address</h3>
      <div class="row">
        <?php Field::render('shipping_address', 'user'); ?>
      </div>
    </div>
  </div>
</div>
