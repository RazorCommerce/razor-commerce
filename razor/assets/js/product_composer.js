var $tabsMarkup = '<div id="tab-menu"></div>';
var $tabs = [];
var $tabsBuilt = false;
var $productTypeField;
var $isVirtualField;
var $isDownloadableField;
var $productType = '';
var $productTypeSelected;

function product_composer_init() {
  console.log('doing it!');
  getAttributeField();
  make_fieldsets();
  build_tab_menu();
  tab_control();
  control_setup();
}

function selectionHandlerGroupedProduct() {
  $('.tab-control').show();
  $('.tab-control[data-key="shipping"]').hide();
}

function selectionHandlerVariableProduct() {
  $('.tab-control').show();
}

function getAttributeField() {
  $.get( CCM_DISPATCHER_FILENAME + "/checkout/get_composer_field", function(data, status){
    var $field = JSON.parse( data );

    $productTypeField = $field.product_type;
    $selector = '#akID\\[' + $productTypeField.ak.akID + '\\]\\[atSelectOptionID\\]1';
    $productType = $( $selector );
    $productTypeSelected = $productType.val();

    $isVirtualField = $field.is_virtual;
    $isVirtualCheckbox = $( '#akID\\[' + $isVirtualField.ak.akID + '\\]\\[value\\]' );

    $isDownloadableField = $field.is_downloadable;
    $isDownloadableCheckbox = $( '#akID\\[' + $isDownloadableField.ak.akID + '\\]\\[value\\]' );

    productChange();
  });
}

// make fieldsets
function make_fieldsets() {

  $tabs = [];

  // hide all fieldsets initially
  $cfs = $('form .ccm-ui > fieldset');

  // loop through fieldsets
  $cfs.each( function() {
    $title = $('legend', this).html();
    $key = $title.replace(' ', '_');
    $key = $key.toLowerCase();
    $( this ).attr( 'id', $key );

    // hide every tab other than basics
    if( $key != 'product_basics' ) {
      $tabs.push( '<div class="tab-control ' + $key + '" data-key="' + $key + '">' + $title + '</div>' );
      $( this ).addClass('tab');
      $( this ).hide();
    }
  });
}

// build tab menu
function build_tab_menu() {

  console.log('building tab menu');

  $productBasics = $( '#product_basics' );
  $productBasics.after( $tabsMarkup );
  var $tabMenu = $('#tab-menu');

  $.each( $tabs, function() {
    $tabMenu.append( this );
  });

  $tabsBuilt = true;
}

// change product type
function productChange() {

  // product type change
  $productType.change( function() {
    $productTypeSelected = $(this).val();
    var $selectionKey = $productTypeField.values[$productTypeSelected].key;

    if( $selectionKey == 'standard_product' ) {
      selectionHandlerStandardProduct();
    }

    if( $selectionKey == 'variable_product' ) {
      // selectionHandlerVariableProduct();
    }

    if( $selectionKey == 'grouped_product' ) {
      // selectionHandlerGroupedProduct();
    }
  });

  // is downloadable
  $isDownloadableCheckbox.click( function() {
    var checked = $(this).prop( "checked" );
    if( checked ) {
      $('.tab-control.downloadable').show();
    } else {
      $('.tab-control.downloadable').hide();
    }
  });

  // is virtual
  $isVirtualCheckbox.click( function() {
    var checked = $(this).prop( "checked" );
    if( checked ) {
      $('.tab-control.shipping').hide();
    } else {
      $('.tab-control.shipping').show();
    }
  });

}

function selectionHandlerStandardProduct() {
  console.log( 'selectionHandlerStandardProduct' );
}


// show tab when tab control clicked
function tab_control() {
  $('#tab-menu .tab-control').click( function() {
    $fsKey = $(this).data('key');
    $('fieldset.tab').hide();
    $('#tab-menu .tab-control').removeClass('active');
    $('fieldset#' + $fsKey).show();
    $(this).addClass('active');
  });
}

// hide composer field and title for product basics
function control_setup() {
  $('fieldset#product_basics legend:first').hide();
  $('fieldset#product_basics .help-block:first').hide();
  $('fieldset#product_basics .form-group:first').hide();
  $('fieldset#product_basics .form-group').each( function( index ) {
    if( index == 1 ) { $(this).addClass('product-type'); }
    if( index == 2 ) { $(this).addClass('is-virtual'); }
    // if( index == 3 ) { $(this).addClass('is-downloadable'); }
    if( index == 3 ) { $(this).addClass('product-name'); }
    if( index == 4 ) { $(this).addClass('product-catalog'); }
  });
}
