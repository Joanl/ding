<?php
// $Id$

/**
 * @file ding_library_map.tpl.php
 * Library location, map, etc.
 */
drupal_add_css(drupal_get_path('module', 'ding_library_map') .'/css/ding_library_map.css', 'module');
drupal_add_js(drupal_get_path('module', 'ding_library_map') .'/js/gmap_unbind.js', 'module');


//setup map
$mapId = 'library_map';
$map = array('id' => $mapId, 'type' => 'map', 'zoom' => 11, 'minzoom' => 9, 'maxzoom' => 14, 'height' => '200px', 'width' => '100%', 'controltype' => 'Small', 'longitude' => '12.573448', 'latitude' => '55.680908', 'behavior' => array('extramarkerevents' => 1));

//add markers for libraries
foreach ($nodes as $node)
{
	$marker = array('latitude' => $node->location['latitude'], 
									'longitude' => $node->location['longitude'], 
									'markername' => 'ding_library_map_open',
									'name' => $node->title,
									'street' => $node->location['street'], 
									'city' => $node->location['city'], 
									'postal-code' => $node->location['postal_code'],
									'state' => 'open', 
									'url' => url('node/'.$node->nid),
									'text' => FALSE);
	$map['markers'][] = $marker;
}

?>
<?php echo theme('gmap', $map) ?>
<div id="library-info" style="display: none;">
	<div class="frame">
		<div class="inner">
		  <h3 class="name"></h3>
		  <div class="address">
				<div class="street"></div>
				<div><span class="postal-code"></span> <span class="city"></span></div>		
		  </div>
		  <div class="office-hours">
		  </div>
		</div>
	</div>
</div>
<a class="resize expand" href="#">
	<?php print t('Expand map') ?>
</a>

<script type="text/javascript">
	$(document).ready(function()
	{
		map = Drupal.gmap.getMap('<?php echo $mapId ?>');
		map.bind('mouseovermarker', function(object)
		{
			$('#library-info').removeClass('open').removeClass('closed').addClass(object.state);
			attributes = ['name', 'street', 'postal-code', 'city'];
			for (i in attributes)
			{
				$('#library-info .'+attributes[i]).text(object[attributes[i]]);
			}
			point = Drupal.gmap.getMap('<?php echo $mapId ?>').map.fromLatLngToContainerPixel(object.marker.getLatLng());
			$('#library-info').css({ 'left': (point.x-5)+'px', 'top': (point.y- $('#library-info').outerHeight())+'px' }).show();						
		});
		$('#library-info').bind('mouseleave', function()
		{
			$('#library-info').hide();
		});		
		map.bind('click', function(object) {
			//TODO: Remove default binding for click event
			window.location = object.url;
		});
		
		$('.block-ding_library_map .resize').toggle(function(event)
		{
			$('.gmap-library_map-gmap').animate({ 'height' : '400px' }, 1500, 'swing');
			Drupal.gmap.getMap('<?php echo $mapId ?>').map.checkResize();
			$(event.target).toggleClass('expand').toggleClass('contract');
			return false;
		}, function(event)
		{
			$('.gmap-library_map-gmap').animate({ 'height' : '200px' }, 1500, 'swing');
			Drupal.gmap.getMap('<?php echo $mapId ?>').map.checkResize();			
			$(event.target).toggleClass('expand').toggleClass('contract');
			return false;
		});
	});
</script>