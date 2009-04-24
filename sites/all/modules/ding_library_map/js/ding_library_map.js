Drupal.dingLibraryMap = function(mapId, options)
{
	this.mapId = mapId;
	
	this.getMap = function()
	{
		return Drupal.gmap.getMap(this.mapId);
	}
	
	this.info = function(mapId, options)
	{
		this.fullDayNames = options.fullDayNames;
		this.shortDayNames = options.shortDayNames;
		
		this.init = function()
		{
			
			$('.gmap-'+this.mapId+'-gmap').after(
			'<div id="library-info" style="display: none;">'+
				'<div class="frame">'+
					'<div class="inner">'+
					  '<h3 class="name"></h3>'+
					  '<div class="address">'+
							'<div class="street"></div>'+
							'<div><span class="postal-code"></span> <span class="city"></span></div>'+
					  '</div>'+
					  '<dl class="opening-hours">'+
					  '</dl>'+
					'</div>'+
				'</div>'+
			'</div>');
			
			var info = this;
			this.getMap().bind('mouseovermarker', function(object)
			{
				info.show(object);
			});
		};
	
		this.show = function(object)
		{
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
					sectionDays = this.shortDayNames[sectionDays.shift()]+'-'+this.shortDayNames[sectionDays.pop()]; //use short day names if section spans more than one day
				} else {
					sectionDays = this.fullDayNames[sectionDays.shift()]; //use full day name for section spanning a single day
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
			point = this.getMap().map.fromLatLngToContainerPixel(object.marker.getLatLng());
			$('#library-info').css({ 'left': (point.x-5)+'px', 'top': (point.y- $('#library-info').outerHeight())+'px' }).show();		
		};
		
		this.init();
	};
	
	this.resize = function(mapId)
	{	
			
		this.init = function()
		{
			$('.gmap-'+this.mapId+'-gmap').after(
				'<a class="resize expand" href="#">'+
					'Expand map'+
				'</a>');
				
			var resize = this;		
			$('a.resize').toggle(function(event)
			{
				resize.resize(450);
				$(event.target).toggleClass('expand').toggleClass('contract');			
			}, function(event)
			{
				resize.resize(200);
				$(event.target).toggleClass('expand').toggleClass('contract');						
			});
		};
	
		this.resize = function(size)
		{
			var resize = this;		
			var center = this.getMap().map.getCenter();
			$('.gmap-'+this.mapId+'-gmap').animate({ 'height' : size+'px' }, 1000, 'swing', function()
			{
				resize.getMap().map.checkResize();				
				resize.getMap().map.panTo(center);				
			});
		};
		
		this.init();
	};
	
	this.info(mapId, options);
	this.resize(mapId, options);
			
}