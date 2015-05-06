<?php

namespace Razor\Core\Install;

use Razor\Core\Install\Fields as InstallFields;
use Razor\Core\Install\Composer as InstallComposer;
use Razor\Core\Install\Image as InstallImage;
use Razor\Core\Install\Settings as InstallSettings;
use Concrete\Core\Attribute\Key\Category as AttributeKeyCategory;
use Concrete\Core\Attribute\Type as AttributeType;

class Install {

  public function __construct( $pkg ) {

    $installer = new InstallImage();

    $installFields = new InstallFields( $pkg );
    $installFields->install();

    $installComposer = new InstallComposer();
    $installComposer->setupComposer();

    $installSettings = new InstallSettings;
    $installSettings->defaults();

    $this->installAttributeKeys( $pkg );

  }

  public function installAttributeKeys( $pkg ) {

    //create custom attribute category for products
    $cpAKC = AttributeKeyCategory::getByHandle('product');
    if ( !is_object($cpAKC) ) {
      $cpAKC = AttributeKeyCategory::add( 'product', AttributeKeyCategory::ASET_ALLOW_SINGLE, $pkg );
      $cpAKC->associateAttributeKeyType( AttributeType::getByHandle('text') );
      $cpAKC->associateAttributeKeyType( AttributeType::getByHandle('textarea') );
      $cpAKC->associateAttributeKeyType( AttributeType::getByHandle('number') );
      $cpAKC->associateAttributeKeyType( AttributeType::getByHandle('address') );
      $cpAKC->associateAttributeKeyType( AttributeType::getByHandle('boolean') );
      $cpAKC->associateAttributeKeyType( AttributeType::getByHandle('date_time') );
    }

  }

}
