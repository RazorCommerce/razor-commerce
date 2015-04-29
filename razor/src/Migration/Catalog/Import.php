<?php

namespace Razor\Core\Migration\Catalog;
use \Concrete\Core\Backup\ContentImporter;
use Package;
use Page;
use PageType;
use Loader;

class Import extends ContentImporter {

  public function importCatalogTest( $xml ) {
    $count = count( $xml->catalogs->catalog );
    $exists = 0;
    $shop = Page::getByID( SHOP_CID, 'RECENT' );
    $page = Page::getByPath( $shop->getCollectionPath() . $product->path );
    foreach ( $xml->catalogs->catalog as $catalog ) {
      if( is_object($page) && !$page->isError() ) {
        $exists++;
      }
    }
    $new = $count - $exists;
    $test = array(
      'count' => $count,
      'exists' => $exists,
      'new' => $new,
    );
    return $test;
  }

  // import catalog objects
  public function importCatalog( $xml ) {
    $db = Loader::db();
    $shop = Page::getByID( SHOP_CID, 'RECENT' );

    $pt = PageType::getByHandle('catalog');
    $pkg = Package::getByHandle('razor');

    $created = 0;
    $updated = 0;

    foreach ( $xml->catalogs->catalog as $catalog ) {
      $data = array();
      $page = Page::getByPath( $shop->getCollectionPath() . $catalog->path );

      if (!is_object($page) || ($page->isError())) {
        $data['pkgID'] = $pkg->getPackageID();

        // determine parent path
        $lastSlash = strrpos((string)$catalog->path, '/');
        $parentPath = substr((string)$catalog->path, 0, $lastSlash);
        if (!$parentPath) {
          $parent = $shop;
        } else {
          $parent = Page::getByPath( $shop->getCollectionPath() . $parentPath );
          if (!is_object($parent) || ($parent->isError())) {
            $parent = $shop;
          }
        }

        // add catalog page
        $data['cHandle'] = substr((string)$catalog->path, $lastSlash + 1);
        $page = $parent->add( $pt, $data );

        $created++;
      }

      // update name
      $args['cName'] = $catalog->name;
      $page->update($args);

      // add image
      if( $catalog->image ) {
        $imageFID = $db->GetOne('select fID from FileVersions where fvFilename = ?', array( $catalog->image ) );
        $page->setAttribute( 'catalog_image', $imageFID );
      }

      $updated++;
    }

    // return result
    $result = array(
      'created' => $created,
      'updated' => $updated,
      'errors' => false,
      'message' => false,
    );

    return $result;
  }

  // import product pages using core importer
  // this will import multiple pages if multiple pages are defined in the export file
  public function importCatalogPage() {
    $sx = simplexml_load_file( 'application/files/razor/migrate/export/catalog/catalog.xml' );
    $this->importPageStructure( $sx );
    $this->importPageContent( $sx );
  }

}
