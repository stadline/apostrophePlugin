<?php use_helper('a') ?>
<?php $page = aTools::getCurrentPage() ?>
	
<div id="a-subnav" class="subnav">
	<div class="subnav-wrapper">
		<?php // echo a_navcolumn(false) ?>
		<?php include_component('aNavigation', 'tabs', array('root' => $page->slug, 'active' => $page->slug, 'name' => 'subnav', 'draggable' => true, 'drag_icon' => true)) # Top Level Navigation ?>
	</div>
</div>