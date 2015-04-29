<?php
namespace Concrete\Package\Razor\Block\CatalogList;
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

		protected $btTable = 'btCatalogList';
		protected $btInterfaceWidth = "600";
		protected $btInterfaceHeight = "465";
		protected $btCacheBlockRecord = true;
		protected $btCacheBlockOutput = true;
		protected $btCacheBlockOutputOnPost = true;
		protected $btCacheBlockOutputForRegisteredUsers = false;
		protected $btCacheBlockOutputLifetime = 0; //until manually updated or cleared
		protected $btDefaultSet = 'commerce';

		public function getBlockTypeDescription() {
			return t("Product catalog list.");
		}

		public function getBlockTypeName() {
			return t("Catalog List");
		}

    public function view() {
			$pl = new PageList();
			$pl->filterByPageTypeHandle('catalog');

			$parentCID = Page::getCurrentPage()->getCollectionID();
			$pl->filterByParentID( $parentCID );

			$catalogs = $pl->getResults();
    	$this->set( 'catalogs', $catalogs );
    }

		public function add() {
		}

		public function edit() {
		}

		public function composer() {
		}

		public function export(\SimpleXMLElement $blockNode) {
			$data = $blockNode->addChild('data');
			$data->addAttribute('table', $this->btTable);
			$record = $data->addChild('record');
			$cnode = $record->addChild('catalog_list');
			$node = dom_import_simplexml($cnode);
			$no = $node->ownerDocument;
			$content = LinkAbstractor::export($this->content);
			$cdata = $no->createCDataSection($content);
			$node->appendChild($cdata);
		}

		function save($args) {
			$args = array();
			parent::save($args);
		}

	}

?>
