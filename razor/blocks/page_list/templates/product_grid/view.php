<?php
defined('C5_EXECUTE') or die("Access Denied.");
$th = Loader::helper('text');
$nh = Loader::helper('navigation');
$c = Page::getCurrentPage();
$cart_page = Page::getByPath('/cart');
$cart_url = $nh->getCollectionURL( $cart_page );
$dh = Core::make('helper/date'); /* @var $dh \Concrete\Core\Localization\Service\Date */
?>

<?php if ( $c->isEditMode() && $controller->isBlockEmpty()) { ?>
  <div class="ccm-edit-mode-disabled-item"><?php echo t('Empty Page List Block.')?></div>
<?php } else { ?>

<div class="row ccm-block-page-list-wrapper container product-grid-wrap">

    <?php if ($pageListTitle): ?>
      <div class="ccm-block-page-list-header">
        <h5><?php echo $pageListTitle?></h5>
      </div>
    <?php endif; ?>

    <div class="row ccm-block-page-list-pages">

    <?php foreach ($pages as $page):

  		// Prepare data for each page being listed...
      $buttonClasses = 'ccm-block-page-list-read-more';
      $entryClasses = 'ccm-block-page-list-page-entry';
  		$title = $th->entities($page->getCollectionName());
  		$url = $nh->getLinkToCollection($page);
  		$target = ($page->getCollectionPointerExternalLink() != '' && $page->openCollectionPointerExternalLinkInNewWindow()) ? '_blank' : $page->getAttribute('nav_target');
  		$target = empty($target) ? '_self' : $target;
  		$description = $page->getCollectionDescription();
  		$description = $controller->truncateSummaries ? $th->wordSafeShortText($description, $controller->truncateChars) : $description;
  		$description = $th->entities($description);
      $thumbnail = $page->getAttribute('thumbnail');

		?>

      <div class="col-md-3 grid-product <?php echo $entryClasses?>">

        <!-- open link to product -->
        <a href="<?php print $url ?>">

          <!-- thumbnail -->
          <?php if ( is_object( $thumbnail )): ?>
            <div class="ccm-block-page-list-page-entry-thumbnail">
                <?php
                $img = Core::make('html/image', array($thumbnail));
                $tag = $img->getTag();
                $tag->addClass('img-responsive');
                print $tag;
                ?>
            </div>
          <?php endif; ?>

          <!-- name -->
          <div class="product-name"><?php echo $title; ?></div>

          <!-- description -->
          <div class="product-description"><?php echo $description ?></div>

          <!-- price -->
          <?php print '$' . number_format( $page->getAttribute('price_regular'), 2); ?>

        <!-- close link to product -->
        </a>

        <!-- add to cart -->
        <div class="add-to-cart">
          <a href="<?php print $cart_url . '/add/' . $page->getCollectionID(); ?>" class="btn btn-success">Add to Cart</a>
        </div>

      </div>

	<?php endforeach; ?>
    </div>

    <?php if (count($pages) == 0): ?>
        <div class="ccm-block-page-list-no-pages"><?php echo $noResultsMessage?></div>
    <?php endif;?>

</div><!-- end .ccm-block-page-list -->


<?php if ($showPagination): ?>
    <?php echo $pagination;?>
<?php endif; ?>

<?php } ?>
