<div class="row cart-summary">

	<div class="col-md-11 .col-md-offset-1">
		<h3><?php print t('Order Summary'); ?></h3>
	</div>
	
	<!-- cart items table -->
	<div id="cart" class="col-md-11 .col-md-offset-1">
	  <table class="cart-items">
	    <tr>
	      <th class="cart-header product"><?php print t('Product'); ?></th>
	      <th class="cart-header price"><?php print t('Price'); ?></th>
	      <th class="cart-header quantity"><?php print t('Quantity'); ?></th>
	      <th class="cart-header total"><?php print t('Total'); ?></th>
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
	    <h4 class="pull-right"><?php print t('Cart Totals'); ?></h4>
	    <?php Loader::packageElement( 'cart/footer-table', 'razor', array( 'cart' => $cart )); ?>
	  </div>
	</div>
	<!-- / cart items table -->
	
	<div class="col-md-11 .col-md-offset-1" style="margin-top: 30px;">
		<div class="fa fa-arrow-circle-left pull-right">
		  <a href="">
		    <?php print t('Return to Cart'); ?>
		  </a>
		</div>
	</div>

</div>