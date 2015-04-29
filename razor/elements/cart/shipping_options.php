<?php

$form = Core::make('helper/form');
$shippingSettings = Page::getByPath( '/dashboard/razor/shipping' );

?>

<div class="col-md-3 cart-shipping-options">
  <form action="" method="post">
    <h3>Shipping Options</h3>
    <p>Please select a shipping method for your order below.</p>
    <?php
      if( count($shipping_methods)) {
        foreach( $shipping_methods as $sm ) :
    ?>
      <div class="shipping-method shipping-method-<?php print $sm->getHandle(); ?>" data-shipping-method="<?php print $sm->getHandle(); ?>">
        <h4><?php print $sm->getName(); ?></h4>
        <p><?php print $sm->getDescription(); ?><p>
        <p><?php print '$' . number_format( $sm->calculateCost(), 2); ?></p>
      </div>
    <?php
        endforeach;
      } else {
    ?>
      <div class="no-shipping-options">There are no shipping options available for your order!</div>
    <?php } ?>
  </form>
</div>
