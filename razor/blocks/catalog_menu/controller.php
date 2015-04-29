<?php
namespace Concrete\Package\Razor\Block\CatalogMenu;
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

		protected $btTable = 'btCatalogMenu';
		protected $btInterfaceWidth = "600";
		protected $btInterfaceHeight = "465";
		protected $btCacheBlockRecord = true;
		protected $btCacheBlockOutput = true;
		protected $btCacheBlockOutputOnPost = true;
		protected $btCacheBlockOutputForRegisteredUsers = false;
		protected $btCacheBlockOutputLifetime = 0; //until manually updated or cleared
		protected $btDefaultSet = 'commerce';

		public function getBlockTypeDescription() {
			return t("Product catalog menu.");
		}

		public function getBlockTypeName() {
			return t("Catalog Menu");
		}

    public function view() {
			$pl = new PageList();
			$pl->filterByPageTypeHandle('catalog');
			$pages = $pl->getResults();
			$shop_page = Page::getByPath('/shop');
			$shop_page_id = $shop_page->getCollectionID();
			$tree = $this->generatePageTree( $pages, $shop_page_id );
    	$this->set( 'catalogMenu', $tree );
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
			$cnode = $record->addChild('content');
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

		public function generatePageTree( $pages, $parent = 0, $depth = 0){
			$nh = Loader::helper('navigation');
			if( $depth > 1000 ) return ''; // Make sure not to have an endless recursion
		  $tree = '<ul>';
		  for( $i = 0, $ni = count( $pages ); $i < $ni; $i++ ) {
		    if( $pages[$i]->cParentID == $parent ) {
		      $tree .= '<li>';
					$tree .= '<a href="' . $nh->getCollectionURL( $pages[$i] ) . '">' . $pages[$i]->getCollectionName() . '</a>';
		      $tree .= $this->generatePageTree( $pages, $pages[$i]->cID, $depth + 1 );
		      $tree .= '</li>';
		    }
		  }
		  $tree .= '</ul>';
		  return $tree;
		}

	}

?>
