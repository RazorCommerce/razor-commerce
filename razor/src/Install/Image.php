<?php

namespace Razor\Core\Install;

use Concrete\Core\File\Image\Thumbnail\Type\Type as ThumbnailType;

class Image {

  public function __construct() {
    $this->install_thumbnail_types();
  }

  public function install_thumbnail_types() {

    $thumbnail_types = array(
      'product_full' => array( 'name'  => 'Product Full', 'width' => 600 ),
      'product_full_thumbnail' => array( 'name'  => 'Product Full Thumbnail', 'width' => 600, 'height' => 600 ),
      'product_medium' => array( 'name'  => 'Product Medium', 'width' => 300 ),
      'product_medium_thumbnail' => array( 'name'  => 'Product Medium Thumbnail', 'width' => 300, 'height' => 300 ),
      'product_small' => array( 'name'  => 'Product Small', 'width' => 150 ),
      'product_small_thumbnail' => array( 'name'  => 'Product Small Thumbnail', 'width' => 150, 'height' => 150 ),
    );

    foreach( $thumbnail_types as $handle => $type ) {
      $thumbnailType = new ThumbnailType();
      $thumbnailType->requireType();
      $thumbnailType->setHandle( $handle );
      $thumbnailType->setName( $type['name'] );
      $thumbnailType->setWidth( $type['width'] );
      if( isset( $type['height'] )) {
        $thumbnailType->setHeight( $type['height'] );
      }
      $thumbnailType->save();
    }

  }

}
