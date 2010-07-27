<?php use_helper('a') ?>
<?php $page = aTools::getCurrentNonAdminPage() ?>
	
<?php if (has_slot('a-footer')): ?>
  <?php include_slot('a-footer') ?>
<?php else: ?>
  <?php a_slot('footer', 'aRichText', array(
		'global' => true,
		'edit' => isset($page) ? true : false,
	)) ?>
<?php endif ?>

<?php // Feel free to shut this off in app.yml or override the footer partial in your app ?>
<?php if (sfConfig::get('app_a_credit', true)): ?>
<div class="a-attribution">Built with <a href="http://www.apostrophenow.com/">Apostrophe</a></div>
<?php endif ?>
