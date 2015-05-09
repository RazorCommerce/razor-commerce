<?php

$form = Core::make('helper/form');

?>

  <div class="row">
    <div class="col-md-4">

      <a href="<?php print $this->url('dashboard/razor/product/option/add/') . '/1/'; ?>" class="btn btn-success">Add New Product Option</a>

      <h3>Existing Product Options</h3>

      <table class="table striped">

        <?php if( count($allOptions) ) :
          foreach( $allOptions as $option ):
        ?>
          <tr>
            <td>
              <?php print $option->getOptionName(); ?>
            </td>
            <td>
              <?php if( $option->assigned ) { ?>
                <a href="<?php print $this->url('dashboard/razor/product/option/edit/') . '/1/' . $option->getProductOptionID(); ?>" class="btn btn-default">Edit</a>
              <?php } else { ?>
                <a href="<?php print $this->url('dashboard/razor/product/option/add/') . '/1/' . $option->getProductOptionID(); ?>" class="btn btn-default">Add</a>
              <?php } ?>
            </td>
          </tr>
        <?php endforeach; endif; ?>

      </table>

    </div>

  </div>

<?php if( $editOption ): ?>

  <form action="<?php print $this->url('/dashboard/razor/product/option/save'); ?>" method="post">

    <?php print $form->hidden( 'poID', $editOption->getProductOptionID() ); ?>
    <?php print $form->hidden( 'mode', $mode ); ?>

    <div class="row"
      <div class="col-md-6">

          <h2>Configure Product Option</h2>

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

      </div>

      <div class="ccm-dashboard-form-actions-wrapper">
        <div class="ccm-dashboard-form-actions">
          <?php print $form->submit('save_settings', 'Save', array('class' => 'btn btn-primary pull-right') ); ?>
        </div>
      </div>

    </div>
  </form>

<?php endif; ?>
