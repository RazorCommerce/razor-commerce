<?php

$product = Page::getCurrentPage();
$cart_page = Page::getByPath('/cart');
$nh = Loader::helper('navigation');
$cart_url = $nh->getCollectionURL( $cart_page );

?>

<?php
  if( $product->getAttribute('enable_custom_donation') ) {
?>
  <label>Enter your donation amount</label>
  <input type="text" name="custom_donation" />
<?php } ?>

<?php
  if( $donation_amounts = $product->getAttribute('set_donation_amounts') ) {
    $donation_amounts = str_replace( ' ', '', $donation_amounts);
    $donation_amounts = explode( ',', $donation_amounts );
    foreach( $donation_amounts as $da ) {
?>

  <div class="set-donation-amount" style="float:left; max-width:33%; " data-donation-amount="<?php print $da; ?>"><?php print '$' . number_format( $da, 2 ); ?></div>

<?php } } ?>

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
