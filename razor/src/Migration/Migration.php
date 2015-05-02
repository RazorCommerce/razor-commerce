<?php

namespace Razor\Core\Migration;

use \Razor\Core\Migration\Test\Test as MigrationTest;
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
  public $xml;

  public function setType( $handle ) {
    switch( $handle ) {
      case "tax_import":
        $this->type = new \Razor\Core\Migration\Type\TaxImport();
        break;
    }
  }

  public function setXML( $xml ) {
    $this->xml = $xml;
  }

  public function getXML() {
    return $this->xml;
  }

  public function test() {
    $this->test = new MigrationTest();
    $this->test->setXML( $this->xml );
    $conditions = $this->type->conditions();
    $this->test->setConditions( $conditions );
    $this->test->setType( $this->type );
    $this->test->run();
  }

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

  // new execute method to replace import()
  public function execute() {
    $this->type->execute( $this->xml );
  }

}
