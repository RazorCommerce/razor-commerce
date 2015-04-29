<?php

$mainCols = 12;

/*
 * Available Vars
 * $checkoutOrder
 * $payment_methods
 * $cart
 * $checkout
 */

?>

<?php if( !$complete ) { ?>

  <h1>Checkout</h1>

  <div class="row">

    <?php if( $displayMode == 'full' ) :
        $mainCols = 8;
    ?>
      <div class="col-xs-4">
        <?php Loader::packageElement('cart/order_summary', 'razor', array('cart' => $cart) ); ?>
      </div>
    <?php endif; ?>

    <div class="col-xs-<?php print $mainCols; ?>">
      <div class="checkout-wrap">
        <?php Loader::packageElement('checkout/pane/customer', 'razor', array('order' => $order) ); ?>
        <?php Loader::packageElement('checkout/pane/billing', 'razor'); ?>
        <?php Loader::packageElement('checkout/pane/shipping', 'razor'); ?>
        <?php Loader::packageElement('checkout/pane/payment', 'razor', array('payment_methods' => $payment_methods)); ?>
        <?php Loader::packageElement('checkout/pane/confirmation', 'razor'); ?>
        </form>
      </div>
    </div>
  </div>

<?php } else { ?>

  <h1>Checkout Complete</h1>
  <p>Your order has been successfully processed. Please check your email for an order confirmation and this was your first order at our store you'll also receive customer account details by email.</p>

<?php } ?>
