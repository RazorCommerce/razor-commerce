<?php

namespace Razor\Core\Migration\Product;

use Concrete\Core\Backup\ContentExporter;
use Concrete\Core\File\Importer as FileImporter;
use Concrete\Core\File\StorageLocation\StorageLocation;
use Loader;
use Page;
use \PageType;
use \SimpleXMLElement;

class Export extends ContentExporter {

  // export product objects
  public function exportProducts() {
    $db = Loader::db();
    $pt = PageType::getByHandle('product');
    $xml = new SimpleXMLElement("<razor></razor>");
    $xml->addAttribute('version', '1.0');
    $products = $xml->addChild('products');
    $r = $db->Execute('select Pages.cID from Pages
      where ptID = ? and cIsTemplate = 0 and cFilename is null or cFilename = ""
      order by cID asc', array( $pt->getPageTypeID() ));
    while( $row = $r->FetchRow() ) {
      $product = $products->addChild('product');
      $page = Page::getByID( $row['cID'], 'RECENT' );
      $product->addChild( 'name', Loader::helper('text')->entities( $page->getCollectionName() ));
      $product->addChild( 'path', $page->getCollectionPath() );
    }
    print $xml->asXML();
  }

  // export a single product
  public function exportProductPage( $productID ) {
    $xml = new SimpleXMLElement("<concrete5-cif></concrete5-cif>");
    $xml->addAttribute('version', '1.0');
    $pages = $xml->addChild("pages");

    $db = Loader::db();
    $r = $db->Execute('select Pages.cID from Pages where cID = ?', array( $productID ));
    while($row = $r->FetchRow()) {
      $pc = Page::getByID($row['cID'], 'RECENT');
        if ($pc->getPageTypeHandle() == STACKS_PAGE_TYPE) {
          continue;
        }
      $pc->export( $pages );
    }

    $xml->asXml( 'application/files/razor/migrate/export/product/product.xml' );
    $fi = new FileImporter();
    $productFile = $fi->import( 'application/files/razor/migrate/export/product/product.xml' );
  }

  // export all products
  public function exportProductPageBatch() {
    $pt = PageType::getByHandle('product');
    $xml = new SimpleXMLElement("<concrete5-cif></concrete5-cif>");
    $xml->addAttribute('version', '1.0');
    $pages = $xml->addChild("pages");

    $db = Loader::db();
    $r = $db->Execute('select Pages.cID from Pages
      where ptID = ? and cIsTemplate = 0 and cFilename is null or cFilename = ""
      order by cID asc', array( $ptID ));
    while($row = $r->FetchRow()) {
      $pc = Page::getByID($row['cID'], 'RECENT');
        if ($pc->getPageTypeHandle() == STACKS_PAGE_TYPE) {
          continue;
        }
      $pc->export( $pages );
    }

    $xml->asXml( 'application/files/razor/migrate/export/product/product.xml' );
    $fi = new FileImporter();
    $file = $fi->import( 'application/files/razor/migrate/export/product/product.xml' );
  }

}
