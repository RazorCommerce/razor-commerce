<?php

namespace Razor\Core\Install;

use Razor\Core\Install\Fields as InstallFields;
use Razor\Core\Install\Composer as InstallComposer;
use Razor\Core\Install\Image as InstallImage;

class Install {

  public function __construct( $pkg ) {

    $installer = new InstallImage();
    $installFields = new InstallFields( $pkg );
    $installFields->install();
    $installComposer = new InstallComposer();
    $installComposer->setupComposer();

  }

}
