<?php

namespace Razor\Core\Product;

use Database;
use \Concrete\Core\Search\ItemList\Database\AttributedItemList;

defined('C5_EXECUTE') or die(_("Access Denied."));

class ProductList extends AttributedItemList {

  protected function getAttributeKeyClassName() {
    return '\\Concrete\\Package\\Razor\\Core\\Attribute\\Key\\ProductKey';
  }

}
