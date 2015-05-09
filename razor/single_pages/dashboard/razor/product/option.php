<?php

$form = Core::make('helper/form');

?>

<h1>Product Options</h1>

<form action="<?php print $this->url('/dashboard/razor/product/option'); ?>" method="post">

  <?php print $form->hidden( 'pID', 1 ); ?>
  <?php print $form->hidden( 'atHandle', 'textarea' ); ?>

  <div class="row">
    <div class="col-md-4">
      <h3>All Available Product Options</h3>
      <?php foreach( $allOptions as $option ): ?>
        <div>
          <?php print $option->getOptionName(); ?>
          <?php if( $option->assigned ) { ?>
            <a href="<?php print $this->url('dashboard/razor/product/option/edit/') . '/' . $option->getProductOptionID(); ?>" class="btn btn-default">Edit</a>
          <?php } else { ?>
            <a href="<?php print $this->url('dashboard/razor/product/option/add/') . '/' . $option->getProductOptionID(); ?>" class="btn btn-default">Add</a>
          <?php } ?>
        </div>
      <?php endforeach; ?>
    </div>
    <div class="col-md-4">
      <h3>Current Product Options</h3>
      <?php foreach( $currentOptions as $option ): ?>
        <div>
          <?php print $option->getOptionName(); ?>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <div class="row">

    <div class="col-md-6">

      <h2>Configure Product Option</h2>

      <?php if( $editOption ): ?>
        <div class="form-group">
          <?php print $form->label( 'name', 'Name' ); ?>
          <?php print $form->text( 'name', $editOption->getOptionName() ); ?>
        </div>

        <div class="form-group">
          <?php print $form->label( 'values', 'Values' ); ?>
          <?php print $form->textarea( 'values', $editOption->getValuesAsList() ); ?>
        </div>

        <div class="form-group">
          <?php print $form->label( 'default', 'Default' ); ?>
          <?php print $form->text( 'default', $editOption->getValueDefault() ); ?>
        </div>
      <?php endif; ?>

    </div>

    <div class="ccm-dashboard-form-actions-wrapper">
      <div class="ccm-dashboard-form-actions">
        <?php print $form->submit('save_settings', 'Save', array('class' => 'btn btn-primary pull-right') ); ?>
      </div>
    </div>

  </div>
</form>
