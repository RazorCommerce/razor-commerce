<table class="cart-footer-table">
  <tr class="row-subtotal">
    <td class="footer-table-label row-subtotal-label">Subtotal</td>
    <td class="footer-table-data row-subtotal-data">$<span class="subtotal-number"><?php print number_format( $cart->getSubtotal(), 2 ); ?></span></td>
  </tr>
  <tr class="row-shipping">
    <td class="footer-table-label row-shipping-label">Shipping and Handling</td>
    <td class="footer-table-data row-shipping-data">$<span class="shipping-number"><?php print number_format( $cart->getShippingCost(), 2 ); ?></span></td>
  </tr>
  <tr class="row-taxes">
    <td class="footer-table-label row-tax-label">Taxes</td>
    <td class="footer-table-data row-tax-data">$<span class="tax-number"><?php print number_format( $cart->getTaxTotal(), 2 ); ?></span></td>
  </tr>
  <tr class="row-total">
    <td class="footer-table-label row-total-label">Total</td>
    <td class="footer-table-data row-total-data">$<span class="total-number"><?php print number_format( $cart->getTotal(), 2 ); ?></span></td>
  </tr>
</table>
