var Cart = {

  init: function() {
    Cart.shippingMethodSelection();

    $('.cart-col.quantity input').stepper();
  },

  shippingMethodSelection: function() {
    $('.cart-shipping-options .shipping-method').click( function() {
      $(this).siblings().removeClass('active');
      $(this).addClass('active');
      var shippingMethod = $(this).data('shipping-method');
      $.get( CCM_DISPATCHER_FILENAME + "/cart/set_shipping/" + shippingMethod, function(data, status){
        var json = JSON.parse( data );
        Cart.updateCartTotals( json.totals );
      });
    });
  },

  updateCartTotals: function( totals ) {
    $('.subtotal-number').html( totals.subtotal );
    $('.tax-number').html( totals.taxTotal );
    $('.shipping-number').html( totals.shippingTotal );
    $('.total-number').html( totals.total );
  },

}

$( document ).ready(function() {
  Cart.init();
});

  
