<?php

namespace Razor\Core\Migration;

use \Razor\Core\Migration\Product\Export as ProductExport;
use \Razor\Core\Migration\Product\Import as ProductImport;
use \Razor\Core\Migration\Catalog\Export as CatalogExport;
use \Razor\Core\Migration\Catalog\Import as CatalogImport;

class Migration {

  public $instance;
  public $type;
  public $object;
  public $update;
  public $test;
  public $result;

  // test an import
  public function importTest( $object, $xml ) {
    if( $object == 'product' ) {
      $pi = new ProductImport();
      $this->test = $pi->importProductTest( $xml );
    }
    if( $object == 'catalog' ) {
      $pi = new CatalogImport();
      $this->test = $pi->importCatalogTest( $xml );
    }
  }

  // execute an import
  public function import( $object, $xml ) {
    if( $object == 'product' ) {
      $pi = new ProductImport();
      $this->result = $pi->importProduct( $xml );
    }

    if( $object == 'catalog' ) {
      $pi = new CatalogImport();
      $this->result = $pi->importCatalog( $xml );
    }
  }

}
