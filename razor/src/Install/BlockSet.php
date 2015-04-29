<?php

namespace Razor\Core\Install;

use Concrete\Core\Block\BlockType\Set as BlockTypeSet;
use Loader;

class BlockSet {

  public function __construct( $pkg ) {
    $this->run_install( $pkg );
  }

  protected function run_install( $pkg ) {
    $db = Loader::db();
    BlockTypeSet::add( 'commerce', 'Commerce', $pkg );
    $db->Execute('update BlockTypeSets set btsDisplayOrder = 1 where btsHandle != "commerce"');
  }

}
