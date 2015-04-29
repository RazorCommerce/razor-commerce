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
  <h2>Product Categories</h2>
<?php } ?>

<?php
if( count($catalogs)) {
  foreach ( $catalogs as $catalog ) {
    $title = $th->entities( $catalog->getCollectionName() );
    $url = $nh->getLinkToCollection( $catalog );
    $catalog_image_url = false;
    $catalog_image = $catalog->getAttribute('catalog_image');
    if ( is_object( $catalog_image )) {
      $catalog_image_url = $catalog_image->getThumbnailURL('product_medium_thumbnail');
    }
?>
  <div class="col-md-3 grid-catalog">

    <!-- open link to catalog -->
    <a href="<?php print $url ?>">

      <!-- image -->
      <?php if ( $catalog_image_url ): ?>
        <div class="ccm-block-page-list-page-entry-thumbnail">
          <img src="<?php print $catalog_image_url; ?>" class="img-responsive" />
        </div>
      <?php endif; ?>
      <div class="catalog-name"><?php echo $title; ?></div>

    <!-- close link to catalog -->
    </a>

  </div>

<?php } } elseif( $showEmptyNotice ) { ?>

  <!-- no products -->
  <div class="col-md-12 grid-catalog">
    <div class="empty">No product categories currently found.</div>
  </div>

<?php } ?>
