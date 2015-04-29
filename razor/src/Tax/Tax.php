<?php

namespace Razor\Core\Tax;
use Loader;
use \stdClass;

// handling of taxes
class Tax {

  public function getByRegion( $country, $state ) {
    $db = Loader::db();
    $taxResult = $db->GetAll("select taxID, name, country, region, rate from RazorTax where
      country = ? and region = ?
      ", array( $country, $state ) );
    $taxes = array();
    if( count( $taxResult )) {
      foreach( $taxResult as $taxRow ) {
        $tax = new Tax();
        $tax->id = $taxRow['taxID'];
        $tax->name = $taxRow['name'];
        $tax->country = $taxRow['country'];
        $tax->region = $taxRow['region'];
        $tax->rate = $taxRow['rate'];
        $taxes[] = $tax;
      }
    }
    return $taxes;
  }

  public function getAll() {
    $db = Loader::db();
    $taxResult = $db->GetAll("select taxID, name, country, region, rate from RazorTax");
    $taxes = array();
    if( count( $taxResult )) {
      foreach( $taxResult as $taxRow ) {
        $tax = new Tax();
        $tax->id = $taxRow['taxID'];
        $tax->name = $taxRow['name'];
        $tax->country = $taxRow['country'];
        $tax->region = $taxRow['region'];
        $tax->rate = $taxRow['rate'];
        $taxes[] = $tax;
      }
    }
    return $taxes;
  }

  public function deleteAll() {
    $db = Loader::db();
    $db->query("delete from RazorTax");
  }

  public function add( $data ) {
    $db = Loader::db();
    $db->query("insert into RazorTax (name, country, region, rate) values (?, ?, ?, ?)",
      array( $data['name'], $data['country'], $data['region'], $data['rate'] )
    );
  }

}
