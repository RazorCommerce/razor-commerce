<?php
defined('C5_EXECUTE') or die("Access Denied.");
$class = 'ccm-block-content-editor-composer';
$form = Loader::helper('form');
?>

<div class="control-group">
	<label class="control-label"><?php echo $label?></label>
	<?php if($description): ?>
	<i class="fa fa-question-circle launch-tooltip" title="" data-original-title="<?php echo $description?>"></i>
	<?php endif; ?>
	<div class="controls">
		<?php
		print $form->textarea($view->field('content'), $controller->getContentEditMode(), array(
			'class' => $class
		));
		?>
	</div>
</div>

<script type="text/javascript">
var CCM_EDITOR_SECURITY_TOKEN = "<?php echo Loader::helper('validation/token')->generate('editor')?>";

$(function() {
	$('.<?php echo $class?>').redactor({
		'plugins': ['concrete5'],
        'minHeight': 380
	});
});
</script>