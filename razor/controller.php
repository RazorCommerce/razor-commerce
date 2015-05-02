<?php

namespace Concrete\Package\Razor;
use Package;
use BlockType;
use \Concrete\Core\Page\Single as SinglePage;
use Page;
use PageType;
use PageTemplate;
use PageList;
use Concrete\Core\Page\Type\PublishTarget\Type\Type as PublishTargetType;
use Loader;
use Events;
use Core;
use Config;
use Concrete\Core\Config\ConfigStore;
use Concrete\Core\Attribute\Key\CollectionKey as AttributeKey;
use Concrete\Core\Attribute\Key\Category as AttributeKeyCategory;
use Concrete\Core\Attribute\Set as AttributeSet;
use Concrete\Core\Attribute\Type as AttributeType;
use \Razor\Core\Order\Cart\Cart;
use Concrete\Core\Page\Theme\Theme;
use \Razor\Core\Field\Field;
use \Razor\Core\Install\Install;
use \Razor\Core\Product\Install\Fields as InstallProductFields;
use \Razor\Core\Install\Fields as InstallFields;
use \Razor\Core\Product\Product;
use \Razor\Core\Payment\Payment;
use \Razor\Core\Shipping\Shipping;
use \Razor\Core\Extension\Extension;

class Controller extends Package {

  protected $pkgHandle = 'razor';
  protected $appVersionRequired = '5.7.3.9';
  protected $pkgVersion = '0.9.2.1';
  protected $pkgAutoloaderRegistries = array( 'src' => '\Razor\Core' );
  public $pkg;

  /**
	 * @var array all of the single pages for razor commerce
	 */
	protected $single_pages = array(
    '/cart',
    '/checkout',
    '/dashboard/razor',
    '/dashboard/razor/products',
    '/dashboard/razor/customers',
    '/dashboard/razor/migrate',
    '/dashboard/razor/migrate/import',
    '/dashboard/razor/migrate/export',
    '/dashboard/razor/orders',
    '/dashboard/razor/payment',
    '/dashboard/razor/products',
    '/dashboard/razor/settings',
    '/dashboard/razor/shipping',
    '/dashboard/razor/tax',
  );

  public function getPackageDescription() {
    return t("Razor commerce system for Concrete5. For developers and shop owners that are sharp like a razor!");
  }

  public function getPackageName() {
    return t("Razor Commerce");
  }

  public function on_start() {

    $pkg = Package::getByHandle( $this->pkgHandle );

    $this->add_events();
    $cart = Cart::getCurrentCart();
    $shop = Page::getByPath('/shop');
    define( 'SHOP_CID', $shop->getCollectionID() );
    $terms = Page::getByPath('/terms');
    define( 'TERMS_CID', $terms->getCollectionID() );

    // add scripts
    $al = \Concrete\Core\Asset\AssetList::getInstance();
    $al->register('javascript', 'razor_js', 'assets/js/razor.js', array(), 'razor');
    $al->register('javascript', 'razor_cart', 'assets/js/cart.js', array(), 'razor');
    $al->register('javascript', 'razor_checkout', 'assets/js/checkout.js', array(), 'razor');
    $al->register('javascript', 'razor_product_composer', 'assets/js/product_composer.js', array(), 'razor');
    $al->register('javascript', 'fs_stepper_js', 'assets/stepper/jquery.fs.stepper.js', array(), 'razor');
    $al->register(
      'javascript',
      'jquery_validate',
      'http://cdn.jsdelivr.net/jquery.validation/1.13.1/jquery.validate.js',
      array( 'local' => false ),
      'razor'
    );

    $al->register('css', 'razor_checkout', 'assets/css/checkout.css', array(), 'razor');
    $al->register('css', 'razor_cart', 'assets/css/cart.css', array(), 'razor');
    $al->register('css', 'razor_product_composer', 'assets/css/product_composer.css', array(), 'razor');
    $al->register('css', 'fs_stepper_css', 'assets/stepper/jquery.fs.stepper.css', array(), 'razor');
    $al->register('css', 'razor_css', 'assets/css/razor.css', array(), 'razor');
  }

  public function deletePages() {
    $pl = new PageList();
    $pl->filterByPageTypeHandle( array( 'catalog', 'product' ));
    $pages = $pl->getResults();
    foreach( $pages as $page ) {
      $page->delete();
    }

  }

  public function install() {
    $pkg = parent::install();
    $this->pkg = $pkg;

    $install = new Install();

    $blockSetInstall = new \Razor\Core\Install\BlockSet( $this->pkg );
    $this->add_block_types();
    $this->add_single_pages();
    $this->add_page_types();
    $this->add_pagetype_default_blocks();
    $this->add_attribute_types();
    $this->add_fields();
    $this->add_pages();
    $this->install_extensions();
  }

  public function uninstall() {
    $this->deletePages();
    $this->deleteDBTables();
    parent::uninstall();
  }

  public function deleteDBTables() {
    $db = Loader::db();
    $db->Execute('drop table if exists RazorOrders');
    $db->Execute('drop table if exists RazorOrderItems');
    $db->Execute('drop table if exists RazorPayments');
    $db->Execute('drop table if exists RazorTax');
  }

  protected function install_extensions() {

    $ext = new Extension();

    // product types
    $productType = new Product();
    $productType->installDefaultTypes();

    // payment methods
    $payment = new Payment();
    $payment->installDefaultMethods();

    // shipping methods
    $shipping = new Shipping();
    $shipping->installDefaultMethods();
  }

  public function add_pages() {
    $shop_page = Page::getByPath('/shop');

    if( $shop_page->isError() ) {
      $pt = PageType::getByHandle('catalog');
      $ptemplate = PageTemplate::getByHandle('full');
      $data = array(
        'cHandle' => 'shop',
        'cName' => 'Shop',
        'pkgID' => $this->pkg->getPackageID(),
      );
      $homepage = Page::getByID( HOME_CID );
      $homepage->add( $pt, $data, $ptemplate );
    }

    $this->add_terms_conditions_page();
  }

  // add terms and conditions page
  public function add_terms_conditions_page() {
    $termsPage = Page::getByPath( '/terms' );
    if( $termsPage->isError() ) {
      $pt = PageType::getByHandle('page');
      $ptemplate = PageTemplate::getByHandle('full');
      $data = array(
        'cHandle' => 'terms',
        'cName' => 'Terms',
      );
      $homepage = Page::getByID( HOME_CID );
      $terms_page = $homepage->add( $pt, $data, $ptemplate );
    }
  }

  public function add_block_types() {
    BlockType::installBlockType( 'catalog_list', $this->pkg );
    BlockType::installBlockType( 'product_list', $this->pkg );
    BlockType::installBlockType( 'product', $this->pkg );
    BlockType::installBlockType( 'catalog_menu', $this->pkg );
    BlockType::installBlockType( 'checkout', $this->pkg );
    BlockType::installBlockType( 'cart', $this->pkg );
    BlockType::installBlockType( 'commerce_icon', $this->pkg );
  }

  public function add_events() {

    // on_user_login
    Events::addListener('on_user_login', array('Razor\Core\Order\Cart\Cart', 'convertAnonymousCart'));

  }

  // add blocks to pages
  public function add_pagetype_default_blocks() {

    $nh = Loader::helper('navigation');

    /*
     * Product PageType Default
     */

    // Add Blocks to Product PageType Default
    $pt_product = PageType::getByHandle( 'product' );
    $pt_full = PageTemplate::getByHandle('full');
    $product_default_full = $pt_product->getPageTypePageTemplateDefaultPageObject( $pt_full );

    // Add product block to product pagetype default
    $bt = BlockType::getByHandle('product');
    $block_data = array();
    $product_default_full->addBlock( $bt, 'Main', $block_data);

    /*
     * Catalog PageType Default
     */

    // get pagetype default
    $pt_catalog = PageType::getByHandle('catalog');
    $pt_full = PageTemplate::getByHandle('full');
    $catalog_default_full = $pt_catalog->getPageTypePageTemplateDefaultPageObject( $pt_full );

    // Add 2-col layout
    $bt = BlockType::getByHandle('core_area_layout');
    $block_data = array(
     'gridType' => 'TG',
     'arLayoutMaxColumns' => 12,
     'themeGridColumns' => 2,
     'span' => array( 8, 4 ),
    );
    $block = $catalog_default_full->addBlock( $bt, 'Main', $block_data );
    $alo = $block->instance->getAreaLayoutObject();
    $alc = $alo->getAreaLayoutColumns();
    $colLeft = 'Main : ' . $alc[0]->arLayoutColumnDisplayID;
    $colRight = 'Main : ' . $alc[1]->arLayoutColumnDisplayID;

    // Add catalog menu block
    $bt = BlockType::getByHandle('catalog_menu');
    $block_data = array();
    $catalog_default_full->addBlock( $bt, $colRight, $block_data );

    // Catalog list
    $bt = BlockType::getByHandle('catalog_list');
    $block_data = array();
    $catalog_default_full->addBlock( $bt, $colLeft, $block_data);

    // Product list
    $bt = BlockType::getByHandle('product_list');
    $block_data = array();
    $catalog_default_full->addBlock( $bt, $colLeft, $block_data);

    $catalog_default_url = $nh->getCollectionURL( $catalog_default_full );
    $file = file_get_contents( $catalog_default_url );

  }

  public function add_attribute_types() {
    // add attribute type price
    $at_price = AttributeType::getByHandle('price');
    if ( !is_object( $at_price )) {
      $at_price = AttributeType::add('price', 'Price', $this->pkg);
    }

    // add attribute type composer menu
    $at_cm = AttributeType::getByHandle('composer_menu');
    if ( !is_object( $at_cm )) {
      $at_cm = AttributeType::add('composer_menu', 'Composer Menu', $this->pkg);
    }

    // associate attribute types with category
    $akc = AttributeKeyCategory::getByHandle('collection');
    $akc->associateAttributeKeyType( $at_price );
    $akc->associateAttributeKeyType( $at_cm );
  }

  // add fields using Field API
  public function add_fields() {

    $field = new Field( $this->pkg, 'user' );

    // customer contact fields
    $field->addSet( 'customer_contact', 'Customer Contact' );
    $field->add( 'first_name', 'First Name' );
    $field->set( 'customer_contact' );
    $field->add( 'last_name', 'Last Name' );
    $field->set( 'customer_contact' );
    $field->add( 'phone', 'Phone' );
    $field->set( 'customer_contact' );

    // customer addresses
    $field->addSet( 'customer_address', 'Customer Address' );
    $field->add( 'billing_address', 'Billing Address', 'address' );
    $field->set( 'customer_address' );
    $field->add( 'shipping_address', 'Shipping Address', 'address' );
    $field->set( 'customer_address' );

    // product fields
    $pfi = new InstallProductFields( $this->pkg );
    $pfi->install();
    $pfi->composer();

    // other fields
    $f = new InstallFields( $this->pkg );
    $f->install();

  }

  public function add_page_types() {

    $pt_catalog = PageType::getByHandle('catalog');
    if( !is_object( $pt_catalog )) {

      // catalog pt
      $data = array(
        'name' => 'Catalog',
        'handle' => 'catalog',
        'ptLaunchInComposer' => true,
        'ptIsFrequentlyAdded' => true,
        'defaultTemplate' => PageTemplate::getByHandle('full'),
        'allowedTemplates' => 'C',
        'templates' => array(
            PageTemplate::getByHandle('full')
          ),
      );
      $pt = PageType::add( $data, $this->pkg );

      // configured publishing target
      $publishTarget = PublishTargetType::getByHandle('page_type')->configurePageTypePublishTarget( $pt, array(
        'ptID' => $pt->getPageTypeID()
      ));
      $pt->setConfiguredPageTypePublishTargetObject( $publishTarget );
    }

    // product pt
    $pt_catalog = $pt;
    $pt_product = PageType::getByHandle('product');
    if( !is_object( $pt_product )) {
      $data = array(
        'name' => 'Product',
        'handle' => 'product',
        'ptLaunchInComposer' => true,
        'ptIsFrequentlyAdded' => true,
        'defaultTemplate' => PageTemplate::getByHandle('full'),
        'allowedTemplates' => 'C',
        'templates' => array(
            PageTemplate::getByHandle('full')
          ),
      );
      $pt = PageType::add( $data, $this->pkg );

      // configured publishing target
      $publishTarget = PublishTargetType::getByHandle('page_type')->configurePageTypePublishTarget( $pt, array(
        'ptID' => $pt_catalog->getPageTypeID()
      ));
      $pt->setConfiguredPageTypePublishTargetObject( $publishTarget );
    }

  }

  /**
	 * adds all single pages if they do not exist
	 * @return void
	 */
	public function add_single_pages() {
		foreach( $this->single_pages as $pageHandle ) {
			if( Page::getByPath( $pageHandle )->getCollectionID() <= 0 ) {
        $sp = SinglePage::add( $pageHandle, $this->pkg );
      }
      if( $pageHandle == '/dashboard/razor/migrate/import' || $pageHandle == '/dashboard/razor/migrate/export' ) {
        $page = Page::getByPath( $pageHandle );
        $page->setAttribute( 'exclude_nav', true );
      }
      if( $pageHandle == '/dashboard/razor') {
        $pageDashRazor = Page::getByPath( $pageHandle );
        $pageDashRazor->updateCollectionName('Commerce');
        $pageDashRazor->updateDisplayOrder(0);
        $pageDashFiles = Page::getByPath( '/dashboard/files' );
        $pageDashFiles->updateDisplayOrder(1);
        $pageDash = Page::getByPath( '/dashboard' );
        $pageDash->rescanChildrenDisplayOrder();
      }
		}
 	}

}