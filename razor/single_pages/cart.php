<?php

defined('C5_EXECUTE') or die("Access Denied.");

$args = array(
  'cart' => $cart,
  'checkout_url' => $this->url('/checkout'),
  'shipping_enabled' => $shipping_enabled,
  'shipping_methods' => $shipping_methods
);
Loader::packageElement( 'cart/full-cart', 'razor', $args );
?>
