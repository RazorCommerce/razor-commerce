<?php

namespace Razor\Core\Migration\Type;

use Database;
use Concrete\Core\Foundation\Object;

defined('C5_EXECUTE') or die(_("Access Denied."));

class Type extends Object {

  public function getHandle() {
    return "migration_handle";
  }

  public function getName() {
    return "Migration Handle";
  }

  public function getDescription() {
    return "Migration type for migrating (import or export) data.";
  }

  public function getImportNodeName() {
    return false;
  }

  public function conditions() {

  }

  public function test() {

  }

  public function execute() {

  }

}
