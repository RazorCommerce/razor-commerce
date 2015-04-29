<?php
namespace Concrete\Package\Razor\Block\Product;
use \Razor\Core\Order\Cart\Cart as CartObject;
use \Razor\Core\Checkout\Checkout as CheckoutObject;
use \Razor\Core\Payment\Payment;
use \Concrete\Core\Block\BlockController;
use \Concrete\Core\Editor\LinkAbstractor;
use Session;

/**
 * The controller for the content block.
 *
 * @package Blocks
 * @subpackage Product
 * @author Joel Milne <joel@goldhat.ca>
 * @copyright  Copyright (c) 2003-2012 GoldHat Development Group. (http://www.goldhat.ca)
 * @license    http://www.goldhat.ca/license/     MIT License
 *
 */
	class Controller extends BlockController {

		protected $btTable = 'btProduct';
		protected $btInterfaceWidth = "600";
		protected $btInterfaceHeight = "465";
		protected $btCacheBlockRecord = true;
		protected $btCacheBlockOutput = true;
		protected $btCacheBlockOutputForRegisteredUsers = false;
		protected $btCacheBlockOutputLifetime = 0; //until manually updated or cleared
		protected $btDefaultSet = 'commerce';

		public function getBlockTypeDescription() {
			return t("Product basic details.");
		}

		public function getBlockTypeName() {
			return t("Product");
		}

		public function on_start() {

			// this should all be set from the donation package, called from the PageType library class
			$this->currentCart = CartObject::getCurrentCart();
	    $this->set('cart', $this->currentCart);
	    $this->set('order', false);
	    $this->set('displayMode', 'minimal');

	    $checkout = new CheckoutObject();
	    $this->set('checkout', $checkout);

	    Session::set('rcID', '/checkout');

	    $this->requireAsset('css', 'fs_stepper_css');
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

	    $this->requireAsset('javascript', 'razor_js');
		}

    public function view() {

    }

		public function add() {

		}

		public function edit() {

		}

		public function composer() {

		}

		public function save( $args ) {
			parent::save($args);
		}

	}

?>
