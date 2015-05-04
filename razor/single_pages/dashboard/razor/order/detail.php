<div class="row">

  <div class="col-md-6">
    <h3>Order Details</h3>
    <table class="table striped">
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
    </table>
  </div>

  <!-- Customer -->
  <div class="col-md-6">
    <h3>Customer Details</h3>
    <table class="table striped">
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
    <h3>Order Items</h3>
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

  <!-- Taxes -->
  <div class="col-md-12">
    <h3>Taxes</h3>
    <table class="table striped">
      <tr>
        <th class=""><?php print t('Tax ID'); ?></th>
        <th class=""><?php print t('Name'); ?></th>
        <th class=""><?php print t('Country'); ?></th>
        <th class=""><?php print t('Region'); ?></th>
        <th class=""><?php print t('Rate'); ?></th>
      </tr>

      <?php
        if( count( $order->getTax() ) ) {
          foreach( $order->getTax() as $tax ):
      ?>
        <tr>
          <td class=""><?php print $tax->getTaxID(); ?></td>
          <td class=""><?php print $tax->getTaxName(); ?></td>
          <td class=""><?php print $tax->getCountry(); ?></td>
          <td class=""><?php print $tax->getRegion(); ?></td>
          <td class=""><?php print $tax->getRate(); ?></td>
        </tr>
      <?php endforeach; } else { ?>
        <tr>
          <td class="cart-empty" style="text-align: center;" colspan="5"><?php print t('No taxes applied to this order.'); ?></td>
        </tr>
      <?php } ?>

    </table>
  </div>

  <!-- Shipping -->
  <div class="col-md-12">
    <h3>Shipping</h3>
    <table class="table striped">
      <tr>
        <th class=""><?php print t('Shipping Method'); ?></th>
        <th class=""><?php print t('Description'); ?></th>
        <th class=""><?php print t('Cost'); ?></th>
      </tr>

      <?php
        if( $sm = $order->getShipping()->getMethod() ) {
      ?>
        <tr>
          <td class=""><?php print $sm->getName(); ?></td>
          <td class=""><?php print $sm->getDescription(); ?></td>
          <td><?php print '$' . number_format( $order->getShippingCost(), 2 ); ?></td>
        </tr>
      <?php } else { ?>
        <tr>
          <td class="cart-empty" style="text-align: center;" colspan="5"><?php print t('No shipping method set for this order.'); ?></td>
        </tr>
      <?php } ?>

    </table>
  </div>

</div>
