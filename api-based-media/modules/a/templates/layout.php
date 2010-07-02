<?php // This is a copy of apostrophePlugin/modules/a/templates/layout.php ?>
<?php // It also makes a fine site-wide layout, which gives you global slots on non-page templates ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<?php use_helper('a') ?>
	<?php $page = aTools::getCurrentPage() ?>

<head>
	<?php include_http_metas() ?>
	<?php include_metas() ?>
	<?php include_title() ?>
	<?php // 1.3 and up don't do this automatically (no common filter) ?>
	<?php include_javascripts() ?>
  <?php include_stylesheets() ?>
	<link rel="shortcut icon" href="/favicon.ico" />
		
</head>

<?php // body_class allows you to set a class for the body element from a template ?>
<body class="<?php if (has_slot('body_class')): ?><?php include_slot('body_class') ?><?php endif ?>">

  <?php // Everyone gets this now, but internally it determines which controls you should ?>
  <?php // actually see ?>
  
  <?php include_partial('a/globalTools') ?>

	<div id="a-wrapper">
    <?php // Note that just about everything can be suppressed or replaced by setting a ?>
    <?php // Symfony slot. Use them - don't write zillions of layouts or do layout stuff ?>
    <?php // in the template (except by setting a slot). To suppress one of these slots ?>
    <?php // completely in one line of code, just do: slot('a-whichever', '') ?>
      
    <?php if (has_slot('a-search')): ?>
      <?php include_slot('a-search') ?>
    <?php else: ?>
      <?php include_partial('a/search') ?>
    <?php endif ?>
    
    <?php if (has_slot('a-header')): ?>
      <?php include_slot('a-header') ?>
    <?php else: ?>
      <div id="a-header">
        <?php if (has_slot('a-logo')): ?>
          <?php include_slot('a-logo') ?>
        <?php else: ?>
          <?php a_slot("logo", 'aImage', array("global" => true, "width" => 125, "flexHeight" => true, "resizeType" => "s", "link" => "/", "defaultImage" => "/apostrophePlugin/images/cmstest-sample-logo.png")) ?>
        <?php endif ?>
      </div>
    <?php endif ?>

    <?php if (has_slot('a-tabs')): ?>
      <?php include_slot('a-tabs') ?>
    <?php else: ?>
		  <?php include_component('a', 'tabs') # Top Level Navigation ?>
		<?php endif ?>

    <?php if (has_slot('a-subnav')): ?>
      <?php include_slot('a-subnav') ?>
    <?php elseif ($page): ?>
		  <?php include_component('a', 'subnav') # Subnavigation ?>
		<?php endif ?>

		<div id="a-content">
			<?php echo $sf_data->getRaw('sf_content') ?>
		</div>
	
	  <?php include_partial('a/footer') ?>
	</div>

</body>
</html>