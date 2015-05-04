<?php

?>

<div class="ccm-dashboard-content-full">

  <table class="ccm-search-results-table">
    <thead>
      <tr>
        <th><span><?php echo t('Importers')?></span></th>
        <th>&nbsp;</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Product Import</td>
        <td><a class="btn btn-primary" href="<?php print $this->url('dashboard/razor/migrate/import/product'); ?>">Run</a></td>
      </tr>
      <tr>
        <td>Catalog Import</td>
        <td><a class="btn btn-primary" href="<?php print $this->url('dashboard/razor/migrate/import/catalog'); ?>">Run</a></td>
      </tr>
      <tr>
        <td>File Import</td>
        <td><a class="btn btn-primary" href="<?php print $this->url('dashboard/razor/migrate/import/file'); ?>">Run</a></td>
      </tr>
      <tr>
        <td>Tax Import</td>
        <td><a class="btn btn-primary" href="<?php print $this->url('dashboard/razor/migrate/import/tax_import'); ?>">Run</a></td>
      </tr>
      <tr>
        <td>Settings Import</td>
        <td><a class="btn btn-primary" href="<?php print $this->url('dashboard/razor/migrate/import/setting_import'); ?>">Run</a></td>
      </tr>
    </tbody>
  </table>

</div>
