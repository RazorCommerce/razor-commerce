<?php

$product = Page::getCurrentPage();
$cart_page = Page::getByPath('/cart');
$nh = Loader::helper('navigation');
$cart_url = $nh->getCollectionURL( $cart_page );
$product_image_url = false;
$product_image = $product->getAttribute('product_image');
if ( is_object( $product_image )) {
  $product_image_url = $product_image->getThumbnailURL('product_full_thumbnail');
}

?>

<div class="row">
  <div class="col-xs-12 product">

    <?php if ( $product_image_url ): ?>
      <div class="col-xs-4 product-col product-col-left">
        <div class="thumbnail">
          <img src="<?php print $product_image_url; ?>" class="img-responsive" />
        </div>
      </div>
    <?php endif; ?>

    <div class="col-xs-4 product-col product-col-right">
      <h2><?php print $product->getCollectionName() ?></h2>
      <div class="regular-price">

        <?php if( $sale_price = $product->getAttribute('sale_price') ) { ?>
          <div class="sale-price">
            Sale Price: <?php print '$' . number_format( $sale_price, 2); ?>
          </div>
        <?php } ?>

        <?php if( $sale_price = $product->getAttribute('sale_price') ) {
            print 'Regular Price: ';
          }
          print '$' . number_format( $product->getAttribute('price_regular'), 2);
        ?>
      </div>

      <div class="add-to-cart">
        <a href="<?php print $cart_url . '/add/' . $product->getCollectionID(); ?>" class="btn btn-success">Add to Cart</a>
      </div>

      <?php if( $sku = $product->getAttribute('sku') ) { ?>
        <div class="sku">SKU <?php print $sku; ?></div>
      <?php } ?>

      <div class="summary-description">
        <?php print $product->getAttribute('summary_description'); ?>
      </div>

      </div>
    </div>

    <div class="col-xs-12 product">
      <div class="full-description">
        <?php print $product->getAttribute('full_description'); ?>
      </div>
      <div class="add-to-cart">
        <a href="<?php print $cart_url . '/add/' . $product->getCollectionID(); ?>" class="btn btn-default">Add to Cart</a>
      </div>
    </div>

  </div>
</div>
