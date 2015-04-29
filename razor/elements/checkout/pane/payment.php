<?php

$form = Core::make('helper/form');
print $form->hidden( 'payment_type', 'stripe' );

?>

<div class="row payment-pane">
  <div class="col-xs-12 payment-type-selection">
    <!-- payment methods -->
    <?php
      if( count($payment_methods)) {
        foreach( $payment_methods as $pm ) {
    ?>
      <div class="payment-option" data-payment_type="<?php print $pm->getHandle(); ?>"><?php print $pm->getName(); ?></div>
    <?php } } ?>
  </div>

  <div class="col-xs-12 payment-type-form">
    <?php
      if( count($payment_methods)) {
        foreach( $payment_methods as $pm ) {
    ?>
        <div class="payment-type payment-pane-<?php print $pm->getHandle(); ?>">
          <?php print $pm->form() ?>
        </div>
    <?php } } ?>
  </div>

</div>
