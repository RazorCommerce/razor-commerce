<?php
namespace Concrete\Package\Razor\Block\Cart;
use \Concrete\Core\Block\BlockController;
use \Razor\Core\Order\Cart\Cart as CartObject;
use \Razor\Core\Order\Order as Order;
use \Razor\Core\Order\Item as OrderItem;
use \Razor\Core\Tax\Tax;
use \Razor\Core\Shipping\Shipping;
use \Razor\Core\Shipping\Method\Method as ShippingMethod;
use \Razor\Core\Customer\Account\Account as CustomerAccount;
use \Concrete\Core\Page\Controller\PageController;
use \Config;
use \Loader;
use \User;
use \Page;
use \Events;

/**
 * The controller for the content block.
 *
 * @package Razor
 * @subpackage Cart
 * @author Joel Milne <joel@goldhat.ca>
 * @copyright  Copyright (c) 2003-2012 GoldHat Development Group. (http://www.goldhat.ca)
 *
 */
	class Controller extends BlockController {

		protected $btTable = 'btCart';
		protected $btInterfaceWidth = "600";
		protected $btInterfaceHeight = "465";
		protected $btCacheBlockRecord = true;
		protected $btCacheBlockOutput = true;
		protected $btCacheBlockOutputOnPost = true;
		protected $btCacheBlockOutputForRegisteredUsers = false;
		protected $btCacheBlockOutputLifetime = 0; //until manually updated or cleared
		protected $btDefaultSet = 'commerce';

		public function on_start() {
			$this->currentCart = CartObject::getCurrentCart();
	    $this->requireAsset('javascript', 'fs_stepper_js');
	    $this->requireAsset('css', 'fs_stepper_css');
	    $this->requireAsset('javascript', 'razor_js');
	    $this->requireAsset('css', 'razor_css');

	    // get all shipping methods enabled
	    $shipping = new Shipping();
	    $shipping_methods = $shipping->getMethods();
	    $this->set( 'shipping_methods', $shipping_methods );
		}

		public function getBlockTypeDescription() {
			return t("Displays a shopping cart.");
		}

		public function getBlockTypeName() {
			return t("Cart");
		}

    public function view() {

			// set shipping
	    $this->currentCart->setShipping( 'flat_rate' );

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

		public function add() {

		}

		public function edit() {

		}

	}

?>
