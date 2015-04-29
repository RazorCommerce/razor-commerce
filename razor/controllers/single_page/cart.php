<?php
namespace Concrete\Package\Razor\Controller\SinglePage;
use \Razor\Core\Order\Cart\Cart as CartObject;
use \Razor\Core\Order\Order as Order;
use \Razor\Core\Order\Item as OrderItem;
use \Razor\Core\Tax\Tax;
use \Razor\Core\Shipping\Shipping;
use \Razor\Core\Shipping\Method\Method as ShippingMethod;
use \Razor\Core\Customer\Account\Account as CustomerAccount;
use \Concrete\Core\Page\Controller\PageController;
use Config;
use Loader;
use User;
use Page;
use Events;

class Cart extends PageController {

  public $currentCart;

  public function on_start() {

    $this->currentCart = CartObject::getCurrentCart();
    $this->requireAsset('javascript', 'fs_stepper_js');
    $this->requireAsset('javascript', 'razor_cart');
    $this->requireAsset('javascript', 'razor_js');
    $this->requireAsset('css', 'razor_cart');
    $this->requireAsset('css', 'fs_stepper_css');
    $this->requireAsset('css', 'razor_css');

    // get all shipping methods enabled
    $shipping = new Shipping();
    $shipping_enabled = $shipping->is_enabled();
    $this->set( 'shipping_enabled', $shipping_enabled );

    if( $shipping_enabled ) {
      $shipping_methods = $shipping->getAvailableMethods( $this->currentCart );
      $this->set( 'shipping_methods', $shipping_methods );
    }
  }

  public function view() {

    // get customer location
    $customer = new CustomerAccount();
    $billing_address = $customer->ui->getAttribute('billing_address');
    $country = $billing_address->country;
    $state = $billing_address->state_province;

    // set tax
    $taxClass = new Tax();
    $taxes = $taxClass->getByRegion( $country, $state );
    $this->currentCart->applyTaxes( $taxes );
    $this->currentCart->updateTotal();
    $this->set( 'cart', $this->currentCart );
  }

  // add item to cart
  public function add( $productID, $quantity = 1 ) {
    $price = Page::getByID( $productID )->getCollectionAttributeValue('price_regular');
    $this->currentCart->addItem( $productID, $quantity, $price );
    $this->currentCart->updateTotal();
    $this->redirect('/cart');
  }

  public function remove( $orderItemID ) {
    $orderItem = OrderItem::getByID( $orderItemID );
    $orderItem->remove();
    $this->currentCart->updateTotal();
    $this->redirect('/cart');
  }

  public function update() {
    $data = $this->post();
    if( !$data ) {
      $this->redirect('/cart');
    }
    // update each line item
    foreach( $this->currentCart->getItems() as $item ) {
      $quantity = $data['product'][ $item->orderItemID ];
      $item->changeQuantity( $quantity );
    }
    $this->currentCart->updateTotal();
    $this->view();
  }

  public function set_shipping( $shipping_method ) {
    $this->currentCart->setShipping( $shipping_method );
    $this->currentCart->updateTotal();
    $order = $this->currentCart;
    $totals = array(
      'subtotal' => $order->getSubtotal(),
      'taxTotal' => $order->getTaxTotal(),
      'shippingTotal' => $order->getShippingCost(),
      'total' => $order->getTotal(),
    );
    $data = array(
      'totals' => $totals
    );
    print json_encode( $data );
    exit;
  }

}
