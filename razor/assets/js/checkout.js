var Checkout = {

  shipping_copy: $('#shipping_copy_billing'),
  fields: false,

  init: function() {
    Checkout.getAttributeFields();
    Checkout.addressColumns();
    Checkout.showShipping();
    Checkout.setCustomerLocation();
    Checkout.shippingToggle();
    Checkout.customerLoginToggle();
    Checkout.paymentTypeClick();
    
    // set default active payment method - this should be set based on what is user chose as default, for now it's always Stripe
    $('.payment-option-stripe').addClass('active');
  },

  /* Apply Taxes to Checkout */
  setCustomerLocation: function() {
    $('.ccm-attribute-address-state-province select').change( function() {
      var state = $(this).val();
      var country = $('.ccm-attribute-address-country select').val();
      var region = { c: country, s: state };
      $.get( CCM_DISPATCHER_FILENAME + "/checkout/set_customer_location/" + country + "/" + state, function(data, status){
        var json = JSON.parse( data );
        Cart.updateCartTotals( json.totals );
      });
    });
  },

  getAttributeFields: function() {
    $.get( CCM_DISPATCHER_FILENAME + "/checkout/get_field/", function(data, status){
      fields = JSON.parse( data );
      Checkout.setupValidation( fields );
      var paymentType = $('#payment_type').val();
      Checkout.paymentTypeSelect( paymentType );
      return fields;
    });
  },

  addShippingAddressValidation: function() {
    $("#akID\\[" + fields.shipping_address.id + "\\]\\[address1\\]").rules( 'add', 'required');
    $("#akID\\[" + fields.shipping_address.id + "\\]\\[city\\]").rules( 'add', 'required');
    $("#akID\\[" + fields.shipping_address.id + "\\]\\[country\\]").rules( 'add', 'required');
    $("#akID\\[" + fields.shipping_address.id + "\\]\\[postal_code\\]").rules( 'add', 'required');
  },

  removeShippingAddressValidation: function() {
    $("#akID\\[" + fields.shipping_address.id + "\\]\\[address1\\]").rules( 'remove' );
    $("#akID\\[" + fields.shipping_address.id + "\\]\\[city\\]").rules( 'remove' );
    $("#akID\\[" + fields.shipping_address.id + "\\]\\[country\\]").rules( 'remove' );
    $("#akID\\[" + fields.shipping_address.id + "\\]\\[postal_code\\]").rules( 'remove' );
  },

  customerLoginToggle: function() {
    $('.customer-login-toggle').click( function() {
      $('.customer-login-form-wrap').toggle();
    });
  },

  setupValidation: function() {
    var checkoutForm = $('#checkout-form');
    checkoutForm.validate({
      onsubmit: false
    });
    checkoutForm.submit( Checkout.processPayment );

    // add shipping address validation
    if( this.shipping_copy.prop('checked') == true ) {
      Checkout.addShippingAddressValidation();
    }

    $("#akID\\[" + fields.first_name.id + "\\]\\[value\\]").rules( "add", { required: true });
    $("#akID\\[" + fields.last_name.id + "\\]\\[value\\]").rules( "add", { required: true });
    $("#akID\\[" + fields.phone.id + "\\]\\[value\\]").rules( "add", { required: true });

    // address validation
    $("#akID\\[" + fields.billing_address.id + "\\]\\[address1\\]").rules( "add", { required: true });
    $("#akID\\[" + fields.billing_address.id + "\\]\\[city\\]").rules( "add", { required: true });
    $("#akID\\[" + fields.billing_address.id + "\\]\\[country\\]").rules( "add", { required: true });
    $("#akID\\[" + fields.billing_address.id + "\\]\\[postal_code\\]").rules( "add", { required: true });
    $('#payment_type').rules( "add", { required: true });
    $("#email").rules( "add", { required: true });
    $("#terms").rules( "add", { required: true });
  },

  // toggle the shipping address pane
  shippingToggle: function() {
    this.shipping_copy.click( function() {
      shippingAddressPane = $('.shipping-address-form-wrap');
      shippingAddressPane.toggle();
      if( Checkout.shipping_copy.prop('checked') == true ) {
        Checkout.addShippingAddressValidation();
      } else {
        Checkout.removeShippingAddressValidation();
      }
    });
  },

  showShipping: function() {
    if( this.shipping_copy.prop('checked') == true ) {
      shippingAddressPane = $('.shipping-address-form-wrap');
      shippingAddressPane.show();
    }
  },

  paymentTypeClick: function() {
    $( ".payment-option" ).click( function() {
      $( ".payment-option" ).removeClass('active');
      var paymentType = $(this).data('payment_type');
      Checkout.paymentTypeSelect( paymentType );
      $( this ).addClass('active');
    });
  },

  paymentTypeSelect: function( paymentType ) {

    // remove validation from every payment type (would be better if we just removed active one)
    $( ".payment-option" ).each( function() {
      var paymentType = $(this).data('payment_type');
      var paymentHandlerObject = paymentType + 'PaymentHandler';
      var paymentHandler = window[ paymentHandlerObject ];
      paymentHandler.validationRemove();
    });

    // add validation for selected payment type
    var paymentHandlerObject = paymentType + 'PaymentHandler';
    var paymentHandler = window[ paymentHandlerObject ];
    paymentHandler.validationAdd();

    $('#payment_type').val( paymentType );
    var selectedPaymentSelector = '.payment-type' + '.payment-pane-' + paymentType;
    var selectedPayment =  $( selectedPaymentSelector );
    var paymentPanes = $('.payment-type');
    paymentPanes.hide();
    selectedPayment.show();
  },

  processPayment: function( event ) {
    event.preventDefault();
    var form = $('#checkout-form');
    var validator = form.validate();
    var isValid = validator.form();
    if( !isValid ) {
      return false;
    }

    // disable pay button to avoid duplication
    $('#pay_button').prop('disabled', true);

    // check payment type
    var paymentType = $('#payment_type').val();
    var paymentHandlerObject = paymentType + 'PaymentHandler';
    var paymentHandler = window[ paymentHandlerObject ];

    paymentHandler.process();
  },

  addressColumns: function() {
    // add class to address fields for 2-col
    $('.ccm-attribute-address-line').addClass('col-xs-6');
  }

};

$( document ).ready(function() {
  Checkout.init();
});