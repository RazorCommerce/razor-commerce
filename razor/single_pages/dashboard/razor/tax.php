<?php

use \Razor\Core\Field\Field;
use \Core;

$form = Core::make('helper/form');

?>


<form action="<?php print $this->url('/dashboard/razor/tax/save'); ?>" method="post">

  <div class="ccm-dashboard-content-full">
    <table id="tax-table" class="ccm-search-results-table">
      <thead>
        <tr>
          <th><span><?php echo t('Tax Name')?></span></th>
          <th><span><?php echo t('Country')?></span></th>
          <th><span><?php echo t('Region')?></span></th>
          <th><span><?php echo t('Rate')?></span></th>
          <th>&nbsp;</th>
        </tr>
      </thead>
      <tbody>
        <?php
          if( $next = count($taxes)) :
          foreach( $taxes as $index => $tax ) :
        ?>
          <tr class="tax-row">
            <td><?php print $form->text( 'tax_name['.$index.']', $tax->name ); ?></td>
            <td><?php print $form->text( 'tax_country['.$index.']', $tax->country ); ?></td>
            <td><?php print $form->text( 'tax_region['.$index.']', $tax->region ); ?></td>
            <td><?php print $form->number( 'tax_rate['.$index.']', $tax->rate ); ?></td>
            <td><a class="btn btn-default tax-row-remove" href="#">Remove</a></td>
          </tr>
        <?php endforeach; endif; ?>

        <?php print $form->hidden( 'next', $next + 1 ); ?>

        <tr class="tax-row">
          <td><?php print $form->text( 'tax_name[' . $next . ']' ); ?></td>
          <td><?php print $form->text( 'tax_country[' . $next . ']' ); ?></td>
          <td><?php print $form->text( 'tax_region[' . $next . ']' ); ?></td>
          <td><?php print $form->number( 'tax_rate[' . $next . ']' ); ?></td>
          <td><a class="btn btn-default tax-row-remove" href="#">Remove</a></td>
        </tr>

        <tr class="tax-row template">
          <td><?php print $form->text( 'tax_name[xyz]' ); ?></td>
          <td><?php print $form->text( 'tax_country[xyz]' ); ?></td>
          <td><?php print $form->text( 'tax_region[xyz]' ); ?></td>
          <td><?php print $form->number( 'tax_rate[xyz]' ); ?></td>
          <td><a class="btn btn-default tax-row-remove" href="#">Remove</a></td>
        </tr>

      </tbody>
    </table>

    <div class="col-md-12 text-right tax-row-add-add-wrapper">
      <a href="#" id="tax-row-add" class="btn btn-success">Add Tax Row</a>
    </div>

  </div>

  <div class="ccm-dashboard-form-actions-wrapper">
    <div class="ccm-dashboard-form-actions">
      <?php print $form->submit('save_settings', 'Save', array('class' => 'btn btn-primary pull-right') ); ?>
    </div>
  </div>

</form>

<script type="text/javascript">
  $( document ).ready(function() {

    // add row
    $('#tax-row-add').click( function() {

      var next = $('#next');
      var taxRow = $('#tax-table tr:last').clone(true);

      taxRow.find('#tax_name\\[xyz\\]').attr( 'id', '#tax_name[' + next.val() + ']' );
      taxRow.find('#tax_country\\[xyz\\]').attr( 'id', '#tax_country[' + next.val() + ']' );
      taxRow.find('#tax_region\\[xyz\\]').attr( 'id', '#tax_region[' + next.val() + ']' );
      taxRow.find('#tax_rate\\[xyz\\]').attr( 'id', '#tax_rate[' + next.val() + ']' );
      taxRow.removeClass('template');

      $('#tax-table tr:last').after( taxRow );

      next.val( next.val() + 1 );

      return false;

    });

    // remove row
    $('.tax-row-remove').click( function() {
      $(this).parents('tr').remove();
      return false;
    });

  });
</script>

<style>
#tax-table tr.template {
  display: none;
}
.tax-row-add-add-wrapper {
  margin: 25px 0;
}
<style>
