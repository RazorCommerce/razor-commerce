<?php

use \Page;
use \Loader;

$nh = Loader::helper('navigation');
$shop_page = Page::getByPath('/shop');
$shop_url = $nh->getCollectionURL( $shop_page );
$product = Page::getCurrentPage();

?>

<?php print '$' . number_format( $product->getAttribute('price_regular'), 2 ); ?>
