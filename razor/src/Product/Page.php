<?php

namespace Razor\Core\Product;

use Concrete\Core\Foundation\Object;
use Page as C5Page;

defined('C5_EXECUTE') or die(_("Access Denied."));

class Page extends Object {

  public static function getByID( $id ) {
    return Page::getByID( $id );
  }

}
