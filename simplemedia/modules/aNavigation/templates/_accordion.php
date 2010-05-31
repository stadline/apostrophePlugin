<ul class="nav-level-depth-<?php echo $nest?>" id="a-tab-navigation-<?php echo $name ?>-<?php echo $nest ?>">
<?php foreach($nav as $item): ?>

<li class="<?php echo $item['class']?>" id="a-tab-nav-item-<?php echo $name ?>-<?php echo $item['id']?>">
<?php echo link_to($item['title'], aTools::urlForPage($item['slug'])) ?>
<?php if(isset($item['children']) && $nest < $maxDepth): ?>
<?php include_partial('aNavigation/accordion', array('nav' => $item['children'], 'draggable' => $draggable, 'maxDepth' => $maxDepth + 1, 'name' => $name, 'nest' => $nest+1)) ?>
<?php endif ?>
</li>
<?php endforeach ?>
</ul>


<?php if ($draggable): ?>


  <script type="text/javascript">
  //<![CDATA[
  $(document).ready(
    function() 
    {
      $("#a-tab-navigation-<?php echo $name ?>-<?php echo $nest ?>").sortable(
      { 
        delay: 100,
        update: function(e, ui) 
        { 
          var serial = jQuery("#a-tab-navigation-<?php echo $name ?>-<?php echo $nest ?>").sortable('serialize', {key:'a-tab-nav-item[]'});
          var options = {"url":<?php echo json_encode(url_for('a/sortNav').'?page=' . $item['id']); ?>,"type":"POST"};
          options['data'] = serial;
          $.ajax(options);     
        }
      });
    });
  //]]>
  </script>
<?php endif ?>