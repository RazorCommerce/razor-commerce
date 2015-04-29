<?php
defined('C5_EXECUTE') or die("Access Denied.");

$th = Loader::helper('text');
$nh = Loader::helper('navigation');
$c = Page::getCurrentPage();
$cart_page = Page::getByPath('/cart');
$cart_url = $nh->getCollectionURL( $cart_page );
$dh = Core::make('helper/date');

?>

<?php if( $showHeader ) { ?>
  <h2>Product List</h2>
<?php } ?>

<?php
if( count($products)) {
  foreach ( $products as $product ) {
    $title = $th->entities( $product->getCollectionName() );
    $url = $nh->getLinkToCollection($product);
    $description = $product->getCollectionDescription();
    $description = $controller->truncateSummaries ? $th->wordSafeShortText($description, $controller->truncateChars) : $description;
    $description = $th->entities($description);
    $product_image_url = false;
    $product_image = $product->getAttribute('product_image');
    if ( is_object( $product_image )) {
      $product_image_url = $product_image->getThumbnailURL('product_medium_thumbnail');
    }

    $price_regular = '$' . number_format( $product->getAttribute('price_regular'), 2);
?>

  <div class="col-md-3 grid-product">

    <!-- open link to product -->
    <a href="<?php print $url ?>">

      <!-- image -->
      <?php if ( $product_image_url ): ?>
        <div class="ccm-block-page-list-page-entry-thumbnail">
          <img src="<?php print $product_image_url; ?>" class="img-responsive" />
        </div>
      <?php endif; ?>
      <div class="product-name"><?php echo $title; ?></div>
      <div class="product-description"><?php echo $description ?></div>
      <div class="price-regular"><?php print $price_regular; ?></div>

    <!-- close link to product -->
    </a>

    <!-- add to cart -->
    <div class="add-to-cart">
      <a href="<?php print $cart_url . '/add/' . $product->getCollectionID(); ?>" class="btn btn-success">Add to Cart</a>
    </div>

  </div>

<?php } } elseif( $showEmptyNotice ) { ?>

  <!-- no products -->
  <div class="col-md-12 grid-product">
    <div class="empty">No products currently found.</div>
  </div>

<?php } ?>
