<?php
namespace Concrete\Package\Razor\Controller\SinglePage\Dashboard\Razor\Migrate;
use \Concrete\Core\Page\Controller\DashboardPageController;
use \Razor\Core\Migration\Migration;
use \Concrete\Core\File\File;
use \Razor\Core\Migration\File\Import as FileImport;

class Import extends DashboardPageController {

  public $xml;

  public function on_start() {
    $this->requireAsset('css', 'razor_css');
  }

  public function view( $object, $mode = 'select' ) {
    $this->set( 'object', $object );

    $migrate = new Migration();

    // process import file selection
    if( $mode == 'select' && $this->post() ) {
      $data = $this->post();
      $file_id = $data['file'];
      if( $file_id ) {
        $file = File::getByID( $file_id );
        $file_version = $file->getRecentVersion();
        if( $object == 'file' ) {
          $filePath = $file_version->getRelativePath();
          $fi = new FileImport;
          $test = $fi->importTest();
          $mode = 'test';
          $this->set( 'test', $test );
        } else {
          $file_contents = $file_version->getFileContents();
          $this->xml = simplexml_load_string( $file_contents );
          if( $object == 'tax_import' || $object == 'setting_import' ) {
            $migrate->setType( $object );
            $migrate->setXML( $this->xml );
            $migrate->test();
            $this->set( 'test', $migrate->test );
          } else {
            $test = $migrate->importTest( $object, $this->xml );
            $this->set( 'test', $test);
          }
          $mode = 'test';
        }
        $this->set( 'file_id', $file_id );
      }
    }

    // do migration
    if( $mode == 'execute' && $this->post() ) {
      $data = $this->post();
      $file_id = $data['file'];
      $file = File::getByID( $file_id );
      $file_version = $file->getRecentVersion();
      if( $object == 'file' ) {
        $fi = new FileImport;
        $result = $fi->import( $file_version );
        $this->set( 'result', $result );
      } else {
        $file_contents = $file_version->getFileContents();
        $this->xml = simplexml_load_string( $file_contents );
        if( $object == 'tax_import' || $object == 'setting_import' ) {
          $migrate->setType( $object );
          $migrate->setXML( $this->xml );
          $migrate->execute();
        } else {
          $migrate->import( $object, $this->xml );
        }
        $this->set( 'result', $migrate->result );
      }
    }

    // set mode
    $this->set( 'mode', $mode );

  }

}
