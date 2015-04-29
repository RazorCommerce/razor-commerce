<?php

$nh = Loader::helper('navigation');

?>

<div class="ccm-dashboard-content-full">
  <table class="ccm-search-results-table">
    <thead>
      <tr>
        <th><span><?php echo t('Name')?></span></th>
        <th><span><?php echo t('Created')?></span></th>
        <th><span><?php echo t('SKU')?></span></th>
        <th><span><?php echo t('Price')?></span></th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php
        if( count($products)) :
        foreach( $products as $p ) :
          $p->url = $nh->getCollectionURL( $p );
      ?>
        <tr>
          <td><?php print $p->getCollectionName(); ?></td>
          <td><?php print $p->getCollectionDatePublic(); ?></td>
          <td><?php print $p->getAttribute('sku'); ?></td>
          <td><?php print '$' . number_format( $p->getAttribute('price_regular'), 2 ); ?></td>
          <td><a class="btn btn-primary" href="<?php print $p->url; ?>">View</a></td>
        </tr>
      <?php endforeach; endif; ?>
    </tbody>
  </table>
</div>
