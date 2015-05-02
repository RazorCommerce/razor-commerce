<div class="ccm-dashboard-content-full">
  <table class="ccm-search-results-table">
    <thead>
      <tr>
        <th><span><?php echo t('User ID')?></span></th>
        <th><span><?php echo t('Username')?></span></th>
        <th><span><?php echo t('Orders')?></span></th>
      </tr>
    </thead>
    <tbody>
      <?php
        if( count($users)) :
        foreach( $users as $u ) :
      ?>
        <tr>
          <td><?php print $u->getUserID(); ?></td>
          <td><?php print $u->getUserName(); ?></td>
          <td><a class="btn btn-default" href="<?php print $this->url( '/dashboard/razor/orders/' . $u->getUserID() ); ?>">View Orders<a></td>
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