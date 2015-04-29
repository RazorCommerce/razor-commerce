<?php defined('C5_EXECUTE') or die("Access Denied."); ?>

<fieldset>
    <legend><?php echo t('Icon')?></legend>
    <div class="form-group select-icon-type" style="margin-right: 35px;">
      <?php echo $form->select( 'iconType', $iconTypes, $iconType );?>
    </div>
</fieldset>

<script type="text/javascript">
$(function() {

});
</script>

<style type="text/css">

</style>
