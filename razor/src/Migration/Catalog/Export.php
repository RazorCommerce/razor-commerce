<?php

namespace Razor\Core\Migration\Catalog;

use Concrete\Core\Backup\ContentExporter;
use Concrete\Core\File\Importer as FileImporter;
use Concrete\Core\File\StorageLocation\StorageLocation;
use Loader;
use Page;
use \PageType;
use \PageTemplate;
use \SimpleXMLElement;

class Export extends ContentExporter {

  // export catalog objects
  public function exportCatalogs() {
    $db = Loader::db();
    $pt = PageType::getByHandle('catalog');
    $xml = new SimpleXMLElement("<razor></razor>");
    $xml->addAttribute('version', '1.0');
    $catalogs = $xml->addChild('catalogs');
    $r = $db->Execute('select Pages.cID from Pages
      where ptID = ? and cIsTemplate = 0 and cFilename is null or cFilename = ""
      order by cID asc', array( $pt->getPageTypeID() ));
    while( $row = $r->FetchRow() ) {
      $catalog = $catalogs->addChild('catalog');
      $page = Page::getByID( $row['cID'], 'RECENT' );
      $catalog->addChild( 'name', Loader::helper('text')->entities( $page->getCollectionName() ));
      $catalog->addChild( 'path', $page->getCollectionPath() );
    }
    print $xml->asXML();
  }

  // export a single catalog
  public function exportCatalogPage( $catalogID ) {
    $xml = new SimpleXMLElement("<concrete5-cif></concrete5-cif>");
    $xml->addAttribute('version', '1.0');
    $pages = $xml->addChild("pages");

    $db = Loader::db();
    $r = $db->Execute('select Pages.cID from Pages where cID = ?', array( $catalogID ));
    while($row = $r->FetchRow()) {
      $pc = Page::getByID($row['cID'], 'RECENT');
        if ($pc->getPageTypeHandle() == STACKS_PAGE_TYPE) {
          continue;
        }
      $pc->export( $pages );
    }

    $xml->asXml( 'application/files/razor/migrate/export/catalog/catalog.xml' );
    $fi = new FileImporter();
    $productFile = $fi->import( 'application/files/razor/migrate/export/catalog/catalog.xml' );
  }

  // export all products
  public function exportCatalogPageBatch() {
    $pt = PageType::getByHandle('catalog');
    $xml = new SimpleXMLElement("<concrete5-cif></concrete5-cif>");
    $xml->addAttribute('version', '1.0');
    $pages = $xml->addChild("pages");

    $db = Loader::db();
    $r = $db->Execute('select Pages.cID from Pages
      where ptID = ? and cIsTemplate = 0 and cFilename is null or cFilename = ""
      order by cID asc', array( $pt->getPageTypeID() ));
    while($row = $r->FetchRow()) {
      $pc = Page::getByID($row['cID'], 'RECENT');
        if ($pc->getPageTypeHandle() == STACKS_PAGE_TYPE) {
          continue;
        }
      $pc->export( $pages );
    }

    $xml->asXml( 'application/files/razor/migrate/export/catalog/catalog.xml' );
    $fi = new FileImporter();
    $file = $fi->import( 'application/files/razor/migrate/export/catalog/catalog.xml' );
  }

}
