<?php

use \User;
use \UserInfo;

?>

<div class="ccm-dashboard-content-full">
  <table class="ccm-search-results-table">
    <thead>
      <tr>
        <th><span><?php echo t('Order ID')?></span></th>
        <th><span><?php echo t('Order Date')?></span></th>
        <th><span><?php echo t('Customer')?></span></th>
        <th class="text-right"><span><?php echo t('Total')?></span></th>
        <th>&nbsp;</th>
      </tr>
    </thead>
    <tbody>
      <?php
        if( count($orders)) :
        foreach( $orders as $o ) :
          $o->customer = User::getByUserID( $o->customerID );
          $o->customerName = $o->customer->getUserName();
      ?>
        <tr>
          <td><?php print $o->getOrderID(); ?></td>
          <td><?php print $o->orderDate; ?></td>
          <td><a href="<?php print $this->url( 'dashboard/users/search/view/' . $o->customerID ); ?>"><?php print $o->customerName; ?></a></td>
          <td class="text-right"><?php print '$' . number_format( $o->getTotal(), 2 ); ?></td>
          <td>
            <a class="btn btn-default">View Order Details</a>
          </td>
        </tr>
      <?php endforeach; endif; ?>
    </tbody>
  </table>

  <div class="col-md-12 text-center">
    <?php
      if( $paginator->getTotalPages() > 1 ) {
        print $pagination;
      }
    ?>
  </div>

</div>
