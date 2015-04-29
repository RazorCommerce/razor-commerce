<?php
use \Razor\Core\Checkout\Pane\Pane as CheckoutPane;
use \Razor\Core\Field\Field;
$pane = CheckoutPane::getByKey( 'billing' );

?>

<div class="row billing-pane">
  <div class="col-xs-12">
    <h3>Billing Address</h3>
    <div class="row">
      <?php Field::render('billing_address', 'user'); ?>
    </div>
  </div>
</div>
