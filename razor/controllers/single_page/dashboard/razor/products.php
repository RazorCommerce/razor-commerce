<?php
namespace Concrete\Package\Razor\Controller\SinglePage\Dashboard\Razor;
use \Concrete\Core\Page\Controller\DashboardPageController;
use \Concrete\Core\Page\PageList;
use \Razor\Core\Product\ProductList;
use \Razor\Core\Product\Product;
use \Razor\Core\Product\Type\Type as ProductType;
use \Razor\Core\Extension\Extension;

class Products extends DashboardPageController {

  public function on_start() {

  }

  public function view() {
    $pl = new PageList();
    $pl->filterByPageTypeHandle('product');
    $products = $pl->getResults();
    $this->set('pl', $pl);
    $this->set('products', $products);
  }

  public function add() {

    /*
    $productType = new ProductType();
    $productType->installDefault();
    $ext = new Extension();
    $ext->register('product_type', 'donation', '\Razor\Core\Product\Type\Donation');
    $pts = $productType->getByHandle('donation');
    */

  }

}
