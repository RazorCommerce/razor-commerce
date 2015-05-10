<?php

$form = Core::make('helper/form');

?>

<div class="row">

  <div class="col-md-4">

    <a href="<?php print $this->url('dashboard/razor/product/option/add/' . $pID ); ?>" class="btn btn-success">Add New Product Option</a>

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
              <a href="<?php print $this->url('dashboard/razor/product/option/edit/' . $pID ) . '/' . $option->getProductOptionID(); ?>" class="btn btn-default">Edit</a>
              <a href="<?php print $this->url('dashboard/razor/product/option/remove/' . $pID ) . '/' . $option->getProductOptionID(); ?>" class="btn btn-default">Remove</a>
            <?php } else { ?>
              <a href="<?php print $this->url('dashboard/razor/product/option/add/' . $pID ) . '/' . $option->getProductOptionID(); ?>" class="btn btn-default">Add</a>
            <?php } ?>
          </td>
        </tr>
      <?php endforeach; endif; ?>

    </table>

  </div>

  <div class="col-md-8">
    <?php if( $editOption ): ?>

      <form action="<?php print $this->url('/dashboard/razor/product/option/save'); ?>" method="post">

        <?php print $form->hidden( 'pID', $pID ); ?>
        <?php print $form->hidden( 'poID', $editOption->getProductOptionID() ); ?>
        <?php print $form->hidden( 'mode', $mode ); ?>

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

      </form>

    <?php endif; ?>

  </div>


</div>
