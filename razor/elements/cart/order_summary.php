<h3>Order Summary</h3>

<!-- cart items table -->
<div id="cart">
  <table class="cart-items">
    <tr>
      <th class="cart-header product">Product</th>
      <th class="cart-header price">Price</th>
      <th class="cart-header quantity">Quantity</th>
      <th class="cart-header total">Total</th>
    </tr>

    <?php
      if( count( $cart->getItems() )) {
        foreach( $cart->getItems() as $item ):
        $product = Page::getByID( $item->productID );
    ?>
      <tr>
        <td class="cart-col product"><a href="<?php print $product->getCollectionLink(); ?>"><?php print $product->getCollectionName(); ?></a></td>
        <td class="cart-col price">$<?php print number_format( $item->priceEach, 2 ); ?></td>
        <td class="cart-col quantity"><?php print number_format( $item->quantity, 0 ); ?></td>
        <td class="cart-col total">$<?php print number_format( $item->priceTotal, 2 ); ?></td>
      </tr>
    <?php endforeach; } ?>
  </table>
  <div class="cart-footer">
    <h2 class="cart-total-header">Cart Totals</h2>
    <?php Loader::packageElement( 'cart/footer-table', 'razor', array( 'cart' => $cart )); ?>
  </div>
</div>
<!-- / cart items table -->
