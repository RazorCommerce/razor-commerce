var invoicePaymentHandler = {

  validationAdd: function() {
  },

  validationRemove: function() {
  },

  process: function() {
    var form = $('#checkout-form');
    form.unbind().submit();
    form.submit();
  }

}
