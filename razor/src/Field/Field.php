<?php

namespace Razor\Core\Field;

use Concrete\Core\Attribute\Key\Key as AttributeKey;
use Concrete\Core\Attribute\Key\Category as AttributeKeyCategory;
use Concrete\Core\Attribute\Set as AttributeSet;
use Concrete\Core\Attribute\Type as AttributeType;
use Concrete\Core\Attribute\Key\CollectionKey as AttributeCollectionKey;
use Concrete\Core\Attribute\Key\FileKey as AttributeFileKey;
use Concrete\Core\Attribute\Key\UserKey as AttributeUserKey;

use Concrete\Attribute\Select\Controller as Select;

use User;
use UserInfo;
use Package;
use Loader;
use Page;

class Field {

  public $id;
  public $ak; // attribute key object
  public $handle; // field handle
  public $name; // field name
  public $type; // field type
  public $isSearchable = true; // field is searchable
  public $category; // field category (collection, user, file)
  public $package; // package reference

  public function __construct( $package = false, $category = 'collection' ) {
    $this->package = $package;
    $this->category = $category;
  }

  // adapted function from Concrete\Attribute\Select\Option::add() because it seems impossible to load that class contained in the select controller file
  public function selectValue( $value ) {
    $db = Loader::db();
		$th = Loader::helper('text');
		// this works because displayorder starts at zero. So if there are three items, for example, the display order of the NEXT item will be 3.
		$displayOrder = $db->GetOne('select count(ID) from atSelectOptions where akID = ?', array( $this->id ));

		$v = array( $this->id, $displayOrder, $th->sanitize( $value ) );
		$db->Execute('insert into atSelectOptions (akID, displayOrder, value) values (?, ?, ?)', $v);
  }

  public function getByHandle( $handle ) {
    $atClass = $this->getAttributeCategoryClass();
    $field = $atClass->getByHandle( $handle );
    $this->ak = $field;
    $this->id = $field->akID;
    $this->handle = $field->akHandle;
    $this->name = $field->akName;
    $this->type = $field->atHandle;
    $this->isSearchable = $field->akIsSearchable;
    return $this;
  }

  // render current field, or field handle passed
  public static function render( $handle, $category = 'collection', $objectID = false ) {

    if( $category == 'collection' ) {
      self::renderCollectionField( $handle, $objectID );
    }

    if( $category == 'user' ) {
      self::renderUserField( $handle );
    }

  }

  public static function update( $key, $value, $category = 'collection', $collection = false ) {
    if( $category == 'collection' ) {
      self::updateCollectionField( $key, $value, $collection );
    }
    if( $category == 'user' ) {
      self::updateUserField( $key, $value );
    }
  }

  public function updateCollectionField( $key, $value, $collection ) {
    if( $collection ) {
      $field = AttributeCollectionKey::getByID( $key );
      $collection->setAttribute( $field, $value );
    }
  }

  public function updateUserField( $key, $value ) {
    $u = new User();
    $ui = UserInfo::getByID( $u->getUserID() );
    if( $ui ) {
      $field = AttributeUserKey::getByID( $key );
      $ui->setAttribute( $field, $value );
    }
  }

  // render collection field
  public function renderCollectionField( $handle, $cID ) {
    $u = new User();
    $page = Page::getByID( $cID );
    $fieldValue = false;
    $field = AttributeCollectionKey::getByHandle( $handle );
    $fieldValue = $page->getAttributeValueObject( $field );
    print $field->render('form', $fieldValue, true);
  }

  // render user field
  public function renderUserField( $handle ) {
    $u = new User();
    $ui = UserInfo::getByID( $u->getUserID() );
    $fieldValue = false;
    $field = AttributeUserKey::getByHandle( $handle );
    if( $u->isLoggedIn() ) {
      $fieldValue = $ui->getAttributeValueObject( $field );
    }
    print $field->render('form', $fieldValue, true);
  }

  public function getAttributeCategoryClass() {
    switch( $this->category ) {
      case 'collection':
        $atClass = new AttributeCollectionKey;
        break;
      case 'user':
        $atClass = new AttributeUserKey;
        break;
      case 'file':
        $atClass = new AttributeFileKey;
        break;
    }
    return $atClass;
  }

  // add field to field category already loaded
  public function add( $handle, $name, $type = 'text', $isSearchable = true, $args = false ) {

    // build the field object
    $this->handle = $handle;
    $this->name = $name;
    $this->type = $type;
    $this->isSearchable = $isSearchable;

    // get field category class and check if field already exists
    $atClass = $this->getAttributeCategoryClass( $this->category );
    $ak = $atClass->getByHandle( $handle );
    if( is_object( $ak )) {
      return false;
    }

    // field options
    $fullArgs = array(
      'akHandle' => $this->handle,
      'akName' => $this->name,
      'isSearchable' => $this->isSearchable,
    );

    if( $args ) {
      $fullArgs = array_merge( $fullArgs, $args );
    }

    // add field and return field object
    $ak = $atClass::add( $type, $fullArgs, $this->package );
    return $this;
  }

  // add a field set
  public function addSet( $handle, $name ) {
    $set = AttributeSet::getByHandle( $handle );
    $akc = AttributeKeyCategory::getByHandle( $this->category );
    if ( !is_object( $set )) {
      $set = $akc->addSet( $handle, $name, $this->package );
    }
    return $set;
  }

  // add field to fieldset(s)
  public function set( $setHandle ) {
    $set = AttributeSet::getByHandle( $setHandle );
    $akc = AttributeKeyCategory::getByHandle( $this->category );
    $ak = $akc->getAttributeKeyByHandle( $this->handle );
    if ( !is_object( $ak )) {
      return false;
    }
    $set->addKey( $ak );
    return true;
  }

  // add field to composer
  public function composer( $composer ) {

  }

}
