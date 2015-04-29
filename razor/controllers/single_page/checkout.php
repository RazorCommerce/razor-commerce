<?php
namespace Concrete\Package\Razor\Controller\SinglePage;
use \Razor\Core\Payment\Payment;
use \Razor\Core\Order\Cart\Cart as CartObject;
use \Razor\Core\Order\Order as Order;
use \Razor\Core\Order\Item as OrderItem;
use \Razor\Core\Field\Field;
use \Razor\Core\Tax\Tax;
use \Concrete\Core\Attribute\Key\CollectionKey as AttributeCollectionKey;
use \Concrete\Core\Page\Controller\PageController;
use Core;
use Config;
use Loader;
use User;
use Page;
use Events;
use Session;
use \Razor\Core\Checkout\Checkout as CheckoutObject;

class Checkout extends PageController {

  public $currentCart;

  public function on_start() {
    $this->currentCart = CartObject::getCurrentCart();
    $this->set('cart', $this->currentCart);
    $this->set('order', $this->currentCart);
    $this->set('displayMode', 'full');

    $checkout = new CheckoutObject();
    $this->set('checkout', $checkout);

    Session::set('rcID', '/checkout');

    $this->requireAsset('css', 'fs_stepper_css');
    $this->requireAsset('css', 'razor_cart');
    $this->requireAsset('css', 'razor_checkout');
    $this->requireAsset('css', 'razor_css');

    $this->requireAsset('javascript', 'razor_js_paths');
    $this->requireAsset('javascript', 'fs_stepper_js');
    $this->requireAsset('javascript', 'jquery_validate');

    // payment setup
    $payment_methods = Payment::getMethods();
    foreach( $payment_methods as $payment_method ) {
      $payment_method->setup( $this );
    }
    $this->set( 'payment_methods', $payment_methods );

    $this->requireAsset('javascript', 'razor_cart');
    $this->requireAsset('javascript', 'razor_checkout');
    $this->requireAsset('javascript', 'razor_js');

  }

  public function view() {
    if( !count( $this->currentCart->getItems() )) {
      $this->redirect('/cart');
    }
  }

  // handle checkout payment
  public function pay() {
    $data = $this->post();
    if( !$data ) {
      $this->redirect('/checkout');
    }

    $checkout = new CheckoutObject();
    $validated = $checkout->validateCheckoutForm( $data );
    if( $validated ) {
      $complete = $checkout->processCheckoutForm( $data );
    }

    // if checkout complete
    if( $complete ) {
      $this->redirect('/checkout/complete');
    }
  }

  // checkout complete page
  public function complete() {
    $this->set('complete', true);
  }

  public function set_customer_location( $country, $state ) {

    // get taxes
    $taxClass = new Tax();
    $taxes = $taxClass->getByRegion( $country, $state );
    $this->currentCart->applyTaxes( $taxes );
    $this->currentCart->updateTotal();
    $order = $this->currentCart;
    $totals = array(
      'subtotal' => $order->getSubtotal(),
      'taxTotal' => $order->getTaxTotal(),
      'shippingTotal' => $order->getShippingCost(),
      'total' => $order->getTotal(),
    );
    $data = array(
      'totals' => $totals,
      'taxes' => $taxes,
    );
    print json_encode( $data );
    exit;
  }

  // get attribute fields for javascript validation
  public function get_field() {
    $fields = array(
      'first_name',
      'last_name',
      'phone',
      'billing_address',
      'shipping_address',
    );
    $fieldJSON = array();
    foreach( $fields as $handle ) {
      $field = new Field( false, 'user' );
      $fieldJSON[ $handle ] = $field->getByHandle( $handle );
    }
    print json_encode( $fieldJSON );
    exit;
  }

  // ajax callback used by product composer setup
  // this was originally in /shop controller, now moved here temporarily
  // need to move somewhere else, such as /ajax?
  public function get_composer_field() {
    $db = Loader::db();
    $fieldJSON = array();

    // product_type field
    $ak = AttributeCollectionKey::getByHandle('product_type');
    $query = $db->GetAll("select * from atSelectOptions where akID = ? ",
      array( $ak->getAttributeKeyID() )
    );
    $options = array();
    foreach( $query as $selectOption ) {
      $key = strtolower( $selectOption['value'] );
      $key = str_replace(' ', '_', $key);
      $selectOption['key'] = $key;
      $options[ $selectOption['ID'] ] = $selectOption;
    }
    $fieldJSON['product_type']['ak'] = $ak;
    $fieldJSON['product_type']['values'] = $options;

    // is_virtual field
    $ak = AttributeCollectionKey::getByHandle('is_virtual');
    $fieldJSON['is_virtual']['ak'] = $ak;

    // is_downloadable field
    $ak = AttributeCollectionKey::getByHandle('is_downloadable');
    $fieldJSON['is_downloadable']['ak'] = $ak;

    print json_encode( $fieldJSON );
    exit;
  }

}
