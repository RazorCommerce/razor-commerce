<?php
defined('C5_EXECUTE') or die("Access Denied.");
Loader::packageElement('cart/full-cart', 'razor', array( 'cart' => $cart, 'checkout_url' => $this->url('/checkout') ) );
?>
