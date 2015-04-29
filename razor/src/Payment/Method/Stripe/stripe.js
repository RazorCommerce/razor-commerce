var stripePaymentHandler = {

  validationAdd: function() {
    $("input.credit-card-number").rules( 'add', 'required' );
    $("input.credit-card-cvc").rules( 'add', 'required' );
    $("input.credit-card-expiry-month").rules( 'add', 'required' );
    $("input.credit-card-expiry-year").rules( 'add', 'required' );
  },

  validationRemove: function() {
    $("input.credit-card-number").rules( 'remove' );
    $("input.credit-card-cvc").rules( 'remove' );
    $("input.credit-card-expiry-month").rules( 'remove' );
    $("input.credit-card-expiry-year").rules( 'remove' );
  },

   process: function() {
     var form = $('#checkout-form');
     var pkey = $('#stripe-publishable-key').val();
     Stripe.setPublishableKey( pkey );
     Stripe.card.createToken( form, this.submitHandler );
   },

   submitHandler: function( status, response ) {
     var form = $('#checkout-form');
     if ( response.error ) {
       $('.payment-errors').text(response.error.message);
       $('#pay_button').prop('disabled', false);
       return false;
     } else {
       var token = response.id;
       $('#stripe_token').val( token );
       $('form').unbind().submit();
       form.submit();
     }
   }

}
