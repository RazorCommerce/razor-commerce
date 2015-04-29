<?php

namespace Razor\Core\Migration\Product;
use Concrete\Core\Backup\ContentImporter;
use Page;
use PageType;
use Package;
use Loader;

class Import extends ContentImporter {

  public function importProductTest( $xml ) {
    $count = count( $xml->products->product );
    $exists = 0;
    $shop = Page::getByID( SHOP_CID, 'RECENT' );
    $page = Page::getByPath( $shop->getCollectionPath() . $product->path );

    foreach ( $xml->products->product as $product ) {
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

  // import product objects
  public function importProduct( $xml ) {
    $db = Loader::db();

    $shop = Page::getByID( SHOP_CID, 'RECENT' );
    $pt = PageType::getByHandle('product');
    $pkg = Package::getByHandle('razor');

    $created = 0;
    $updated = 0;

    foreach ( $xml->products->product as $product ) {
      $data = array();
      $page = Page::getByPath( $shop->getCollectionPath() . $product->path );
      if (!is_object($page) || ($page->isError())) {
        $data['pkgID'] = $pkg->getPackageID();

        // determine parent path
        $lastSlash = strrpos((string)$product->path, '/');
        $parentPath = substr((string)$product->path, 0, $lastSlash);
        if (!$parentPath) {
          $parent = $shop;
        } else {
          $parent = Page::getByPath( $shop->getCollectionPath() . $parentPath );
          if (!is_object($parent) || ($parent->isError())) {
            $parent = $shop;
          }
        }

        // add product page
        $data['cHandle'] = substr((string)$product->path, $lastSlash + 1);
        $page = $parent->add( $pt, $data );

        $created++;
      }

      /*
       * Doing Updates
       */

      // update name
      $args['cName'] = $product->name;
      $page->update($args);

      // update product attributes
      $page->setAttribute( 'price_regular', $product->price );
      $page->setAttribute( 'sku', $product->sku );

      // add image
      if( $product->image ) {
        $imageFID = $db->GetOne('select fID from FileVersions where fvFilename = ?', array( $product->image ) );
        $page->setAttribute( 'product_image', $imageFID );
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
  public function importProductPage() {
    $sx = simplexml_load_file( 'application/files/razor/migrate/export/product/product.xml' );
    $this->importPageStructure( $sx );
    $this->importPageContent( $sx );
  }


}
