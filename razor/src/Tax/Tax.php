<?php

namespace Razor\Core\Tax;

use Concrete\Core\Foundation\Object;
use Loader;

class Tax extends Object {

  public static function getByID( $taxID ) {
    $db = Loader::db();
    $tax = new Tax();
    $row = $db->getRow("select * from RazorTax where taxID = ? ", array( $taxID ));
    $tax->setPropertiesFromArray( $row );
    return $tax;
  }

  public function getTaxID() {
    return $this->taxID;
  }

  public function getTaxName() {
    return $this->name;
  }

  public function getCountry() {
    return $this->country;
  }

  public function getRegion() {
    return $this->region;
  }

  public function getRate() {
    return $this->rate;
  }

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
