<?php if ($options['arrows'] && (count($items) > 1)): ?>
<ul id="a-slideshow-controls-<?php echo $id ?>" class="a-slideshow-controls">
	<li class="a-slideshow-controls-previous a-btn a-arrow-left icon nobg">Previous</li>
	<li class="a-slideshow-controls-next a-btn a-arrow-right icon nobg">Next</li>
</ul>
<?php endif ?>

<?php if (count($items)): ?>
	<ul id="a-slideshow-<?php echo $id ?>" class="a-slideshow">
	<?php $first = true; $n=0; foreach ($items as $item): ?>
	  <?php $dimensions = aDimensions::constrain(
	    $item->width, 
	    $item->height,
	    $item->format, 
	    array("width" => $options['width'],
	      "height" => $options['flexHeight'] ? false : $options['height'],
	      "resizeType" => $options['resizeType'])) ?>
	  <?php $embed = str_replace(
	    array("_WIDTH_", "_HEIGHT_", "_c-OR-s_", "_FORMAT_"),
	    array($dimensions['width'], 
	      $dimensions['height'], 
	      $dimensions['resizeType'],
	      $dimensions['format']),
	    $item->getEmbedCode('_WIDTH_', '_HEIGHT_', '_c-OR-s_', '_FORMAT_', false)) ?>

	  <li class="a-slideshow-item" id="a-slideshow-item-<?php echo $id ?>-<?php echo $n ?>" <?php echo ($first)? 'style="display:list-item;"':''; ?>>
			<?php include_partial('aSlideshowSlot/slideshowItem', array('item' => $item, 'id' => $id, 'embed' => $embed, 'n' => $n,  'options' => $options)) ?>
		</li>
	<?php $first = false; $n++; endforeach ?>
	</ul>
<?php endif ?>

<?php if (count($items) > 1): ?>
<script type="text/javascript" charset="utf-8">
//<![CDATA[
	$(document).ready(function() {
      <?php // Clear any interval timer left running by a previous slot variant ?>
      if (window.aSlideshowIntervalTimeouts !== undefined)
      {
        if (window.aSlideshowIntervalTimeouts['<?php echo "a-$id" ?>'])
        {
          clearTimeout(window.aSlideshowIntervalTimeouts['<?php echo "a-$id" ?>']);
        } 
      }
      else
      {
        window.aSlideshowIntervalTimeouts = {};
      }
			var position = 0;
			var img_count = <?php echo count($items)-1 ?>;
			var slideshowItems = $('#a-slideshow-<?php echo $id ?> .a-slideshow-item');
			$('.a-context-media-show-item').hide();
			$('#a-slideshow-item-<?php echo $id ?>-'+position).show();

			var intervalEnabled = <?php echo ($options['interval'])? 1:0; ?>;
		slideshowItems.attr('title', 'Click For Next Image');
	
		$('#a-slideshow-<?php echo $id ?>').bind('showImage', function(e, num){
			position = num;
			slideshowItems.hide();
			$('#a-slideshow-item-<?php echo $id ?>-'+position).fadeIn('slow');
		});
		
	  slideshowItems.find('.a-slideshow-image').click(function(event) {
			event.preventDefault();
			next();
	  });

		$('#a-slideshow-controls-<?php echo $id ?> .a-slideshow-controls-previous').click(function(event){
			event.preventDefault();
			intervalEnabled = false;
			previous();
		});

		$('#a-slideshow-controls-<?php echo $id ?> .a-slideshow-controls-next').click(function(event){
			event.preventDefault();
			intervalEnabled = false;
			next();
		});

		$('.a-slideshow-controls li').hover(function(){
			$(this).css('background-position','0 -20px');		
		},function(){
			$(this).css('background-position','0 0');					
		})

	  function previous() 
	  {
		  var oldItem = $('#a-slideshow-item-<?php echo $id ?>-'+position);

	  	if (position >= 0)
			{
				position--;
				if ( position < 0 ) { position = img_count; }

				var newItem = $('#a-slideshow-item-<?php echo $id ?>-'+position);
				newItem.parents('.a-slideshow').css('height',newItem.height());
				newItem.fadeIn('slow');			
				oldItem.hide();
			}
			interval();
	  }
 
	  function next()
	  {
  	  var oldItem = $('#a-slideshow-item-<?php echo $id ?>-'+position);

	  	if (position <= img_count)
	  	{
	  		position++;
	  		if ( position == img_count+1 ) { position = 0; }

				var newItem = $('#a-slideshow-item-<?php echo $id ?>-'+position);
				newItem.parents('.a-slideshow').css('height',newItem.height());
	  		newItem.fadeIn('slow');			
	  		oldItem.hide();
	  	}
	  	interval();
	  }
	  
		var intervalTimeout = null;
	  function interval()
	  {
	    if (intervalTimeout)
	    {
	      clearTimeout(intervalTimeout);
	    }
	    if (intervalEnabled)
	    {
	  	  intervalTimeout = setTimeout(next, <?php echo $options['interval'] ?> * 1000);
	  	  window.aSlideshowIntervalTimeouts['<?php echo "a-$id" ?>'] = intervalTimeout;
	  	}
	  }
	  interval();
	
	});
//]]>
</script>
<?php elseif (count($items) == 1): ?>
<script type="text/javascript" charset="utf-8">
  <?php // Make sure a single-image slideshow is not hidden entirely ?>
	$(document).ready(function() {
     $('#a-slideshow-item-<?php echo $id ?>-0').show();
	});
</script>
<?php endif ?>