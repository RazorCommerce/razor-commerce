<?php
use \Razor\Core\Checkout\Pane\Pane as CheckoutPane;
use \Core;

$nh = Loader::helper('navigation');
$terms_page = Page::getByID( TERMS_CID );
$terms_url = $nh->getCollectionURL( $terms_page );

$form = Core::make('helper/form');
?>

<div class="row confirmation-pane">
  <div class="col-xs-8 terms-wrap">
    <?php
      print $form->label('terms', 'I Agree to the <a href="' . $terms_url . '">Terms &amp; Conditions</a>');
      print $form->checkbox( 'terms', array(1) );
    ?>
  </div>
  <div class="col-xs-4">
    <?php print $form->submit('pay_button', 'Make Payment', array('class' => 'btn-primary') ); ?>
  </div>
</div>
