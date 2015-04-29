<?php

namespace Razor\Core\Migration\File;

use FileImporter;
use Loader;
use \ZipArchive;

class Import {

  public function importTest() {
    $test = array(
      'count' => 9,
      'exists' => 4,
      'new' => 5,
    );
    return $test;
  }

  public function import( $file_version ) {

    define( 'DIR_FILES', DIR_APPLICATION . '/files/' );
    define( 'DIR_COMMERCE_IMPORT', DIR_FILES . 'commerce/import/' );

    // extraction
    $zipFileResource = $file_version->getFileResource();
    $zipFile = DIR_FILES . $zipFileResource->getPath();
    $zip = new ZipArchive;

    if ( $zip->open( $zipFile ) === TRUE ) {
      $zip->extractTo( DIR_COMMERCE_IMPORT );
      $zip->close();
    }

    // import
    $created = 0;
    if ( is_dir( DIR_COMMERCE_IMPORT )) {
      $fh = new FileImporter();
      $files = Loader::helper('file')->getDirectoryContents( DIR_COMMERCE_IMPORT );
      foreach( $files as $filename ) {
        $f = $fh->import( DIR_COMMERCE_IMPORT . $filename, $filename );
        $created++;
      }
    }

    // result
    $result = array(
      'created' => $created,
      'updated' => $created,
      'errors' => false,
      'message' => false,
    );
    return $result;
  }

}
