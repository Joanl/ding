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
									'opening_hours' => $node->field_opening_hours[0],
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
		  <dl class="opening-hours">
		  </dl>
		</div>
	</div>
</div>
<a class="resize expand" href="#">
	<?php print t('Expand map') ?>
</a>

<script type="text/javascript">
	var fullDayNames = {	'mon': '<?php echo t('Monday') ?>',
			 									'tue': '<?php echo t('Tuesday') ?>',
												'wed': '<?php echo t('Wednesday') ?>',
												'thu': '<?php echo t('Thursday') ?>',
												'fri': '<?php echo t('Friday') ?>',
												'sat': '<?php echo t('Saturday') ?>',
												'sun': '<?php echo t('Sunday') ?>' };
	var shortDayNames = {	'mon': '<?php echo t('Mon') ?>',
 		 										'tue': '<?php echo t('Tue') ?>',
				 								'wed': '<?php echo t('Wed') ?>',
				 								'thu': '<?php echo t('Thu') ?>',
				 								'fri': '<?php echo t('Fri') ?>',
				 								'sat': '<?php echo t('Sat') ?>',
				 								'sun': '<?php echo t('Sun') ?>' };
								
	$(document).ready(function()
	{
		map = Drupal.gmap.getMap('<?php echo $mapId ?>');
		map.bind('mouseovermarker', function(object)
		{
			console.log(object);
			//Add address attributes
			attributes = ['name', 'street', 'postal-code', 'city'];
			for (i in attributes)
			{
				$('#library-info .'+attributes[i]).text(object[attributes[i]]);
			}
			
			//Add opening hours
			section = $('#library-info .opening-hours').empty(); 
			days = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun']; //collection of weekdays to use for iteration
			day = 0; //current day index
			while (day < days.length) //iterate until end of week
			{
				sectionDays = [days[day]]; //add current day to to section
				startTime = object.opening_hours[days[day]+'_start'];
				endTime = object.opening_hours[days[day]+'_end'];
				
				nextDay = day + 1;
				while ((startTime != null) && (endTime != null) && 
								(startTime == object.opening_hours[days[nextDay]+'_start']) &&
								(endTime == object.opening_hours[days[nextDay]+'_end'])) {
					sectionDays.push(days[nextDay]); //if following days have same hours as current day then add these days to section
					nextDay++;
				}
				
				if (sectionDays.length > 1) {
					sectionDays = shortDayNames[sectionDays.shift()]+'-'+shortDayNames[sectionDays.pop()]; //use short day names if section spans more than one day
				} else {
					sectionDays = fullDayNames[sectionDays.shift()]; //use full day name for section spanning a single day
				}
				
				startTime = (startTime != null) ? startTime.substr(0, startTime.lastIndexOf(':')) : '';
				endTime = (endTime != null) ? endTime.substr(0, endTime.lastIndexOf(':')) : '';
				
				//add section to opening hours container
				section.append('<dt>'+sectionDays+'</dt>');
				section.append(	'<dd>'+
													startTime +' - '+endTime+
												'</dd>');
				
				day = nextDay; //step to day after last day in current section
			}
			
			$('#library-info').removeClass('open').removeClass('closed').addClass(object.state);
			
			//Position and show info
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
			$('.gmap-library_map-gmap').animate({ 'height' : '400px' }, 1000, 'swing', function()
			{
				Drupal.gmap.getMap('<?php echo $mapId ?>').map.checkResize();				
			});
			$(event.target).toggleClass('expand').toggleClass('contract');
			return false;
		}, function(event)
		{
			$('.gmap-library_map-gmap').animate({ 'height' : '200px' }, 1000, 'swing', function()
			{
				Drupal.gmap.getMap('<?php echo $mapId ?>').map.checkResize();							
			});
			$(event.target).toggleClass('expand').toggleClass('contract');
			return false;
		});
	});
</script>