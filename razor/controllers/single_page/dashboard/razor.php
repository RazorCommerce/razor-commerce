<?php
namespace Concrete\Package\Razor\Controller\SinglePage\Dashboard;
use \Concrete\Core\Page\Controller\DashboardPageController;
use \Loader;
use \Page;

class Razor extends DashboardPageController {

  public $pages;

  public function on_start() {
    $this->requireAsset('css', 'razor_css');
    $this->pages = array(
      'products', 'orders', 'customers', 'migrate', 'payment',  'shipping', 'tax', 'settings'
    );
  }

  public function view() {

    $nh = Loader::helper('navigation');

    $url = array();
    foreach( $this->pages as $pageHandle ) {
      $page = Page::getByPath( '/dashboard/razor/' . $pageHandle );
      $url[ $pageHandle ] = $nh->getCollectionURL( $page );
    }
    $this->set( 'url', $url );

  }

}
