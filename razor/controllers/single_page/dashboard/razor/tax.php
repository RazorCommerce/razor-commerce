<?php
namespace Concrete\Package\Razor\Controller\SinglePage\Dashboard\Razor;
use \Concrete\Core\Page\Controller\DashboardPageController;
use \Razor\Core\Shipping\Shipping as ShippingClass;
use \Razor\Core\Tax\Tax as TaxObject;
use \Razor\Core\Field\Field;
use \Concrete\Core\Page\PageList;
use \Page;


class Tax extends DashboardPageController {

  public function on_start() {
    $this->requireAsset('css', 'razor_css');
    $this->set('pageTitle', 'Tax Settings');
  }

  public function view() {
    $taxObj = new TaxObject();
    $taxes = $taxObj->getAll();
    $this->set( 'taxes', $taxes );
  }

  public function save() {
    $data = $this->post();

    $count = count( $data['tax_name'] );
    $index = 0;
    $taxes = array();
    while( $count >= $index ) {

      if( $data['tax_name'][$index] == 'xyz' ||
        $data['tax_name'][$index] == '' ||
        $data['tax_country'][$index] == '' ||
        $data['tax_rate'][$index] == 0 ) {
        $index++;
        continue;
      }

      $tax['name'] = $data['tax_name'][ $index ];
      $tax['country'] = $data['tax_country'][ $index ];
      $tax['region'] = $data['tax_region'][ $index ];
      $tax['rate'] = $data['tax_rate'][ $index ];
      $taxes[] = $tax;
      $index++;
    }
    // empty all taxes then add all taxes sent
    $taxObj = new TaxObject();
    $taxObj->deleteAll();

    foreach( $taxes as $tax ) {
      $taxObj->add( $tax );
    }

    $this->redirect('/dashboard/razor/tax');
  }

}
