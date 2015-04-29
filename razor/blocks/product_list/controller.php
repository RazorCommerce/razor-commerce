<?php
namespace Concrete\Package\Razor\Block\ProductList;
use \Concrete\Core\Block\BlockController;
use \Concrete\Core\Page\PageList;
use \Page;
use \Loader;

/**
 * The controller for the content block.
 *
 * @package Razor
 * @subpackage Catalog
 * @author Joel Milne <joel@goldhat.ca>
 * @copyright  Copyright (c) 2003-2012 GoldHat Development Group. (http://www.goldhat.ca)
 * @license    http://www.goldhat.ca/license/     MIT License
 *
 */
	class Controller extends BlockController {

		protected $btTable = 'btProductList';
		protected $btInterfaceWidth = "600";
		protected $btInterfaceHeight = "465";
		protected $btCacheBlockRecord = true;
		protected $btCacheBlockOutput = true;
		protected $btCacheBlockOutputOnPost = true;
		protected $btCacheBlockOutputForRegisteredUsers = false;
		protected $btCacheBlockOutputLifetime = 0; //until manually updated or cleared
		protected $btDefaultSet = 'commerce';

		public function getBlockTypeDescription() {
			return t("Product list.");
		}

		public function getBlockTypeName() {
			return t("Product List");
		}

    public function view() {
			$pl = new PageList();
			$pl->filterByPageTypeHandle('product');

			$parentCID = Page::getCurrentPage()->getCollectionID();
			$pl->filterByParentID( $parentCID );
			// $pl->filterByPath($path, $includeAllChildren = true)

			$products = $pl->getResults();
    	$this->set( 'products', $products );
    }

		public function add() {
		}

		public function edit() {
		}

		public function composer() {
		}

		function save($args) {
			$args = array();
			parent::save($args);
		}

	}

?>
