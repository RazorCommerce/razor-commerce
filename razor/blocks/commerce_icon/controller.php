<?php
namespace Concrete\Package\Razor\Block\CommerceIcon;
use \Concrete\Core\Block\BlockController;
use Page;

/**
 * The controller for the content block.
 *
 * @package Razor
 * @subpackage Interface
 * @author Joel Milne <joel@goldhat.ca>
 * @copyright  Copyright (c) 2003-2012 GoldHat Development Group. (http://www.goldhat.ca)
 *
 */
	class Controller extends BlockController {

		protected $btTable = 'btCommerceIcon';
		protected $btInterfaceWidth = "400";
		protected $btInterfaceHeight = "320";
		protected $btCacheBlockRecord = true;
		protected $btCacheBlockOutput = true;
		protected $btCacheBlockOutputOnPost = true;
		protected $btCacheBlockOutputForRegisteredUsers = false;
		protected $btCacheBlockOutputLifetime = 0; //until manually updated or cleared
		protected $btDefaultSet = 'commerce';

		public function on_start() {
	    $this->requireAsset('css', 'font-awesome');
		}

		public function getBlockTypeDescription() {
			return t("Displays a commerce icon with link such as cart or checkout.");
		}

		public function getBlockTypeName() {
			return t("Commerce Icon");
		}

    public function view() {

			switch( $this->iconType ) {
				case 'checkout':
					$checkoutPage = Page::getByPath( '/checkout' );
					$url = $checkoutPage->getCollectionLink();
					$icon = 'fa-credit-card';
					$text = 'Checkout';
					break;
				case 'cart_add':
					$product = Page::getCurrentPage();
					$cartPage = Page::getByPath( '/cart' );
					$url = $cartPage->getCollectionLink() . '/add/' . $product->getCollectionID() ;
					$icon = 'fa-shopping-cart';
					$text = 'Add to Cart';
					break;
				case 'shopping':
					$shopPage = Page::getByPath( '/shop' );
					$url = $shopPage->getCollectionLink();
					$icon = 'fa-shopping-cart';
					$text = 'Continue Shopping';
					break;
				case 'cart':
					$cartPage = Page::getByPath( '/cart' );
					$url = $cartPage->getCollectionLink();
					$icon = 'fa-shopping-cart';
					$text = 'Cart';
					break;

			}

			// pass settings
			$this->set( 'url', $url );
			$this->set( 'icon', $icon );
			$this->set( 'text', $text );
		}

		public function add() {
			$this->edit();
		}

		public function edit() {
			$iconTypes = array(
				'cart' => 'Cart Link',
				'checkout' => 'Checkout Link',
				'cart_add' => 'Add to Cart',
				'shopping' => 'Continue Shopping',
			);
			$this->set('iconTypes', $iconTypes);
		}

		public function save( $args ){
	    parent::save( $args );
    }

	}

?>
