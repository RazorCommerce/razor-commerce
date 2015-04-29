<?php

use \Page;
use \Loader;

$nh = Loader::helper('navigation');
$shop_page = Page::getByPath('/shop');
$shop_url = $nh->getCollectionURL( $shop_page );
$page =  Page::getCurrentPage();

?>

<a href="<?php print $shop_url . '/cart/add/' . $page->getCollectionID();?>"><?php print $content; ?></a>
