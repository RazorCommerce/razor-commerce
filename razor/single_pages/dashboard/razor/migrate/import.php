<?php

$fm = Core::make('helper/concrete/file_manager');

?>

<!-- select import data -->
<?php if ( $mode == 'select' ) : ?>
  <form action="<?php print $this->url( '/dashboard/razor/migrate/import/' . $object ); ?>" method="post">
    <div class="migration-select">
      <label>Choose Import File</label>
      <?php print $fm->file('file', 'file', 'Select Import File'); ?>
    </div>
    <div class="ccm-dashboard-form-actions-wrapper">
      <div class="ccm-dashboard-form-actions">
        <?php print $form->submit('save_settings', 'Start Import', array('class' => 'btn btn-primary pull-right') ); ?>
      </div>
    </div>
  </form>
<?php endif; ?>

<!-- test result -->
<?php if ( $mode == 'test' ) : ?>
  <form action="<?php print $this->url('/dashboard/razor/migrate/import/' . $object . '/execute'); ?>" method="post">
    <?php print $form->hidden( 'file', $file_id ); ?>
    <div class="migration-test">
      <h3>Import Test</h3>
      <p>Based on the test of the planned import the following objects will be processed during migrate execution.</p>

      <?php if( isset($test) && !is_object($test)) : ?>
        <ul>
          <li>Total Objects: <?php print $test['count']; ?></li>
          <li>Object to Update: <?php print $test['exists']; ?></li>
          <li>Objects to Create: <?php print $test['new']; ?></li>
        </ul>
      <?php endif; ?>

    </div>
    <div class="ccm-dashboard-form-actions-wrapper">
      <div class="ccm-dashboard-form-actions">
        <?php print $form->submit('save_settings', 'Execute Import', array('class' => 'btn btn-primary pull-right') ); ?>
      </div>
    </div>
  </form>
<?php endif; ?>

<!-- execute result -->
<?php if ( $mode == 'execute' ) : ?>
  <div class="migration-result">
    <h3>Import Result</h3>
    <p>Import completed.</p>
    <ul>
      <li>Created Objects: <?php print $result['created']; ?></li>
      <li>Updated Objects: <?php print $result['updated']; ?></li>
    </ul>
  </div>
  <a class="btn btn-default" href="<?php print $this->url('/dashboard/razor/migrate'); ?>">Return to Migrate Dashboard</a>
<?php endif; ?>
