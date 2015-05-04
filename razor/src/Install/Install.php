<?php

namespace Razor\Core\Install;

use Razor\Core\Install\Fields as InstallFields;
use Razor\Core\Install\Composer as InstallComposer;
use Razor\Core\Install\Image as InstallImage;
use Razor\Core\Install\Settings as InstallSettings;

class Install {

  public function __construct( $pkg ) {

    $installer = new InstallImage();

    $installFields = new InstallFields( $pkg );
    $installFields->install();

    $installComposer = new InstallComposer();
    $installComposer->setupComposer();
    
    $installSettings = new InstallSettings;
    $installSettings->defaults();

  }

}
