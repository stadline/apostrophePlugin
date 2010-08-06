<?php // Known as selectMultiple for historic reasons, but we use it for both single and multiple select now that ?>
<?php // we have a need for cropping which requires a pause in both cases anyway. ?>
<?php use_helper('I18N') ?>
<?php use_javascript("/apostrophePlugin/js/plugins/jquery.jCrop.min.js") ?>
<?php use_javascript("/apostrophePlugin/js/aCrop.js") ?>
<?php use_stylesheet("/apostrophePlugin/css/Jcrop/jquery.Jcrop.css") ?>
<div class="a-media-select">
<?php $type = aMediaTools::getAttribute('type') ?>
<?php if (!$type): ?>
<?php $type = "media item" ?>
<?php endif ?>
	<h3><?php echo $label ?></h3>

	<div id="a-media-selection-list-caption">
	  <h4><?php echo __("Preview your selected image%plural% here.", array('%plural%' => aMediaTools::isMultiple() ? 's':' '), 'apostrophe') ?></h4>
	</div>
	<div id="a-media-selection-wrapper">
		<ul id="a-media-selection-list" style="min-height:<?php echo ($thumbHeight = aMediaTools::getSelectedThumbnailHeight()) ? $thumbHeight + 10 : 85 ?>px;">
		<?php include_partial("aMedia/multipleList", array("items" => $items)) ?>
		</ul>

		<?php echo jq_sortable_element("#a-media-selection-list", array("url" => "aMedia/multipleOrder")) ?>
	 	<br class="c"/>

		<div class="a-crop-workspace">
		  <ul id="a-media-selection-preview">
		  	<?php include_partial("aMedia/multiplePreview", array("items" => $items)) ?>
		  </ul>
		  <ul class="a-controls a-media-crop-controls">
				<li><?php echo jq_link_to_function(__("Crop", null, 'apostrophe'), "aCrop.setCrop('".url_for('aMedia/crop')."')", array("class"=>"a-btn save")) ?></li>
		 	  <li><?php echo jq_link_to_function(__("Cancel", null, 'apostrophe'), "aCrop.resetCrop()", array("class"=>"a-btn icon a-cancel event-default")) ?></li>
		  </ul>
		</div>
	</div>
	<ul class="a-controls a-media-slideshow-controls">
		<li><?php echo link_to(__(aMediaTools::isMultiple() ? "Save Slideshow" : "Save Selection", null, 'apostrophe'), "aMedia/selected", array("class"=>"a-btn save big")) ?></li>
 	  <li><?php echo link_to(__("Cancel", null, 'apostrophe'), "aMedia/selectCancel", array("class"=>"a-btn icon a-cancel big")) ?></li>
	</ul>
</div>
</div>
<br class="c"/>