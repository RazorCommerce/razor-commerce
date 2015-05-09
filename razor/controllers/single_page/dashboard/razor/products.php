<?php
namespace Concrete\Package\Razor\Controller\SinglePage\Dashboard\Razor;
use \Concrete\Core\Page\Controller\DashboardPageController;
use \Concrete\Core\Page\PageList;
use Razor\Core\Product\Product;
use Razor\Core\Product\Type\Type as ProductType;

class Products extends DashboardPageController {

  public function view() {
    $pl = new PageList();
    $pl->filterByPageTypeHandle('product');
    $paginator = $pl->getPagination();
    $pagination = $paginator->renderDefaultView();
    $this->set( 'products', $paginator->getCurrentPageResults() );
    $this->set( 'pagination', $pagination );
    $this->set( 'paginator', $paginator );
  }

}
