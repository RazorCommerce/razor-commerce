<?php
  $vars = array(
    'payment_methods' => $payment_methods,
    'checkout' => $checkout,
    'order' => $order,
    'cart' => $cart,
    'displayMode' => $displayMode,
    'complete' => $complete,
  );
  Loader::packageElement('checkout/form', 'razor', $vars );
?>
