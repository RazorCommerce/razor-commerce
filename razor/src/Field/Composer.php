<?php

namespace Razor\Core\Field;
use Concrete\Core\Attribute\Key\CollectionKey as AttributeCollectionKey;
use Concrete\Core\Page\Type\Composer\Control\Type\Type as ComposerControlType;
use PageType;

class Composer {

  public $pageTypeHandle;
  public $layoutSet; // composer layout set

  public function __construct( $pageTypeHandle ) {
    $this->pageTypeHandle = $pageTypeHandle;
  }

  public function setLayoutSet( $layoutSetName ) {
    $this->layoutSet = $this->getLayoutSet( $layoutSetName );
  }

  // add field to composer layout set
  public function addField( $fieldHandle, $required = false, $args = array() ) {
    $akid = AttributeCollectionKey::getByHandle( $fieldHandle );
    $ctca = ComposerControlType::getByHandle('collection_attribute');
    $control = $ctca->getPageTypeComposerControlByIdentifier( $akid->getAttributeKeyID() );
    $control->addToPageTypeComposerFormLayoutSet( $this->layoutSet )
      ->updateFormLayoutSetControlRequired( $required );
  }

  public function addProperty( $propertyName, $args = array() ) {
    $cct = ComposerControlType::getByHandle('core_page_property');
    $control = $cct->getPageTypeComposerControlByIdentifier( $propertyName );

    // set control name
    if( array_key_exists( 'control_name', $args )) {
      $control->setPageTypeComposerControlName( $args['control_name'] );
    }

    // add control
    $composerFLS = $control->addToPageTypeComposerFormLayoutSet( $this->layoutSet );

    // set required
    if( array_key_exists( 'required', $args )) {
      $composerFLS->updateFormLayoutSetControlRequired( $args['required'] );
    }
  }

  // pseudo-code, check if we need the block or BlockType, and how to get block id
  public function addBlock( $blockTypeHandle ) {
    $bt = BlockType::getByHandle( $blockTypeHandle );
    $cct = ComposerControlType::getByHandle('block');
    $control = $ctca->getPageTypeComposerControlByIdentifier( $bt->getBlockID() );

    // add control
    $composerFLS = $control->addToPageTypeComposerFormLayoutSet( $this->layoutSet );
  }

  // add composer layout set
  public function addLayoutSet( $name, $description ) {
    $pt = PageType::getByHandle( $this->pageTypeHandle );
    $this->layoutSet = $pt->addPageTypeComposerFormLayoutSet( $name, $description );
  }

  // get composer layout set by name
  public function getLayoutSet( $layoutSetName ) {
    $clsID = $db->GetCol('select ptComposerFormLayoutSetID from PageTypeComposerFormLayoutSets where ptComposerFormLayoutSetName = ?', array( $layoutSetName ));
    $cls = ComposerLayoutSet::getByID( $clsID[0] );
    if ( is_object( $cls )) {
      return $cls;
    }
    return false;
  }

}
