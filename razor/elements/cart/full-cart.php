<?php

use \Page;

$form = Core::make('helper/form');
$cartPage = Page::getByPath( '/cart' );

?>

<!-- cart items table -->
<div id="cart">
  <form action="<?php print $cartPage->getCollectionLink() . '/update'; ?>" method="post">
    <table class="cart-items">

      <tr>
        <th class="cart-header remove">&nbsp;</th>
        <th class="cart-header product">Product</th>
        <th class="cart-header price">Price</th>
        <th class="cart-header quantity">Quantity</th>
        <th class="cart-header total">Total</th>
      </tr>

      <?php
        if( count( $cart->getItems() ) ) {
          foreach( $cart->getItems() as $item ):
          $product = Page::getByID( $item->productID );
      ?>
        <tr>
          <td class="cart-col remove"><a href="<?php print $cartPage->getCollectionLink() . '/remove/' . $item->orderItemID; ?>" class="fa-close fa"></a></td>
          <td class="cart-col product"><a href="<?php print $product->getCollectionLink(); ?>"><?php print $product->getCollectionName(); ?></a></td>
          <td class="cart-col price">$<?php print number_format( $item->priceEach, 2 ); ?></td>
          <td class="cart-col quantity">
            <?php
              $inputAt = array(
                'min' => 1,
                'max' => 100000,
              );
              print $form->text( 'product[' . $item->orderItemID . ']', number_format( $item->quantity, 0 ), $inputAt ); ?></td>
          <td class="cart-col total">$<?php print number_format( $item->priceTotal, 2 ); ?></td>
        </tr>
      <?php endforeach; } else { ?>
        <tr>
          <td class="cart-empty" style="text-align: center;" colspan="5">Your cart is currently empty. Please continue shopping.</td>
        </tr>
      <?php } ?>
      <tr>
        <td colspan="5" class="update-cart"><?php print $form->submit( 'update_cart', 'Update Cart', array('class' => 'btn-primary') ); ?></td>
      </tr>
    </table>

    <div class="cart-footer">
      <h2 class="cart-total-header">Cart Totals</h2>
      <?php Loader::packageElement( 'cart/footer-table', 'razor', array( 'cart' => $cart )); ?>
      <div class="checkout-button-wrap">
        <a href="<?php print $checkout_url; ?>" class="btn btn-success" role="button">Continue to Checkout</a>
      </div>
    </div>
  </form>
</div>
<!-- / cart items table -->

<!-- shipping options -->
<?php
  if( $shipping_enabled ) {
    Loader::packageElement( 'cart/shipping_options', 'razor', array( 'shipping_methods' => $shipping_methods ));
  }
?>
