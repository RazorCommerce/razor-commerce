<div class="row">

  <div class="col-md-4">
    <table class="table striped">
      <tr>
        <th colspan="2" class="text-center">
          <h4>Order Details</h4>
        </th>
      </tr>
      <tr>
        <td>Order ID</td>
        <td><?php print $order->getOrderID(); ?></td>
      </tr>
      <tr>
        <td>Order Status</td>
        <td><?php print $order->getStatus(); ?></td>
      </tr>
      <tr>
        <td>Order Date</td>
        <td><?php print $order->getOrderDate(); ?></td>
      </tr>
      <tr>
        <td>Shippable</td>
        <td><?php print $order->isShippable( true ); ?></td>
      </tr>
      <tr>
        <td>Order Subtotal</td>
        <td><?php print '$' . number_format( $order->getSubtotal(), 2 ); ?></td>
      </tr>
      <tr>
        <td>Tax Total</td>
        <td><?php print '$' . number_format( $order->getTaxTotal(), 2 ); ?></td>
      </tr>
      <tr>
        <td>Shipping Cost</td>
        <td><?php print '$' . number_format( $order->getShippingCost(), 2 ); ?></td>
      </tr>
      <tr>
        <td>Order Grand Total</td>
        <td><?php print '$' . number_format( $order->getTotal(), 2 ); ?></td>
      </tr>
      <tr>
        <td>Taxes</td>
        <td><?php var_dump( $order->getTax() ); ?></td>
      </tr>
      <tr>
        <td>Shipping</td>
        <td><?php var_dump( $order->getShipping() ); ?></td>
      </tr>
    </table>
  </div>

  <!-- Customer -->
  <div class="col-md-4">
    <table class="table striped">
      <tr>
        <th colspan="2" class="text-center">
          <h4>Customer Details</h4>
        </th>
      </tr>
      <tr>
        <td>Customer ID</td>
        <td><?php print $customer->getCustomerID(); ?></td>
      </tr>
      <tr>
        <td>Email</td>
        <td><?php print $customer->getEmail(); ?></td>
      </tr>
      <tr>
        <td>First Name</td>
        <td><?php print $customer->getFirstName(); ?></td>
      </tr>
      <tr>
        <td>Last Name</td>
        <td><?php print $customer->getLastName(); ?></td>
      </tr>
      <tr>
        <td>Phone</td>
        <td><?php print $customer->getPhone(); ?></td>
      </tr>
      <tr>
        <td>Billing Address</td>
        <td><?php print $customer->getBillingAddress(); ?></td>
      </tr>
      <tr>
        <td>Shipping Address</td>
        <td><?php print $customer->getShippingAddress(); ?></td>
      </tr>
    </table>
  </div>

  <!-- Order Items -->
  <div class="col-md-12">
    <table class="table striped">
      <tr>
        <th class="cart-header product"><?php print t('Product ID'); ?></th>
        <th class="cart-header product"><?php print t('Name'); ?></th>
        <th class="cart-header price"><?php print t('Price'); ?></th>
        <th class="cart-header quantity"><?php print t('Quantity'); ?></th>
        <th class="cart-header total"><?php print t('Total'); ?></th>
      </tr>

      <?php
        if( count( $order->getItems() ) ) {
          foreach( $order->getItems() as $item ):
          $product = Page::getByID( $item->productID );
      ?>
        <tr>
          <td class="cart-col product"><?php print $product->getCollectionID(); ?></td>
          <td class="cart-col product"><?php print $product->getCollectionName(); ?></td>
          <td class="cart-col price">$<?php print number_format( $item->priceEach, 2 ); ?></td>
          <td class="cart-col quantity"><?php print number_format( $item->quantity, 0 ); ?></td>
          <td class="cart-col total">$<?php print number_format( $item->priceTotal, 2 ); ?></td>
        </tr>
      <?php endforeach; } else { ?>
        <tr>
          <td class="cart-empty" style="text-align: center;" colspan="5"><?php print t('No order items.'); ?></td>
        </tr>
      <?php } ?>

    </table>
  </div>

</div>

<?php

var_dump( $order );
var_dump( $customer );

?>
