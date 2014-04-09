/*
 * PROHD Wallet Manager Base
 *
 * @author Matt Nischan
 * @link http://www.darkshadowindustries.com/
 * @copyright Copyright &copy; 2011 Matt Nischan
 */
 
 
 /*
 * phdInlineInput
 * Presents a textbox with a submit checkmark in place of a link
 */
(function($)
{

	// Methods
	var methods = {
		
		init : function( options )
		{
			return this.each(function() {
			
				var $this = $(this);
				
				// Settings
				defaults = {
					'submitImage'	: './images/tick-small.png',
					'cancelImage'	: './images/cross-small.png',
					'inputName'		: 'phdInputName',
					'label'			: false,
					'getUrl'		: 'mainPage/index',
					'submitUrl'		: 'mainPage/index',
					'inputSize'		: 10,
					'inputMax'		: 3
				};
				
				$this.data('settings', defaults);
				
				var data = $this.data();

				// If options exist, lets merge them
				// with our default settings
				if ( options ) 
				{ 
					$.extend( data.settings, options );
				}
				
				var htmlContent = {
					'label' : '<label class="phdInlineInputLabel" style="line-height: 22px"></label>',
					'value' : '<a href="javascript:void();" class="phdInlineInputValue">Loading...</a>',
					'input' : '<input type="text" style="font-size: 10px; height: 10px" size="'+data.settings.inputSize+'" name="'+ data.settings.inputName +'" class="phdInlineInputBox">',
					'submitButton' : '<input type="image" src="' + data.settings.submitImage + '" alt="submit" class="phdInlineInputSubmitButton" style="vertical-align: middle">',
					'cancelButton' : '<input type="image" src="' + data.settings.cancelImage + '" alt="submit" class="phdInlineInputCancelButton" style="vertical-align: middle">',
					'errors' : '<span class="phdInlineInputErrors" style="color: red"></span>'
				}
				
				if (data.settings.label != false)
				{
					htmlContent.label = '<label class="phdInlineInputLabel" style="line-height: 22px">'+ data.settings.label +': </label>';
				}
				
				// Initialize the display and get the initial value
				$this.html(htmlContent.label+htmlContent.value+htmlContent.input+htmlContent.submitButton+htmlContent.cancelButton+htmlContent.errors);
				$this.children('.phdInlineInputBox').hide();
				$this.children('.phdInlineInputSubmitButton').hide();
				$this.children('.phdInlineInputCancelButton').hide();
				$this.children('.phdInlineInputErrors').hide();
				$this.children('.phdInlineInputValue').load('./index.php?r='+data.settings.getUrl);
				
				// Create the click event for clicking on the loaded value
				$this.children('.phdInlineInputValue').click(
					function()
					{
						$(this).hide();
						$(this).fadeOut();
						
						$(this).parent().children('.phdInlineInputBox').fadeIn();
						$(this).parent().children('.phdInlineInputSubmitButton').fadeIn();
						$(this).parent().children('.phdInlineInputCancelButton').fadeIn();

					}
				);
				
				// Create the click event for clicking on the cancel button
				$this.children('.phdInlineInputCancelButton').click(
					function()
					{
						$(this).parent().children('.phdInlineInputBox').hide();
						$(this).parent().children('.phdInlineInputSubmitButton').hide();
						$(this).parent().children('.phdInlineInputCancelButton').hide();
						$(this).parent().children('.phdInlineInputErrors').hide();
						$(this).parent().children('.phdInlineInputBox').val('')
						$(this).parent().children('.phdInlineInputValue').fadeIn();
					}
				);
				
				// Create the click event for clicking on the loaded value
				$this.children('.phdInlineInputSubmitButton').click(
					function()
					{
					button = $(this);
						$.ajax({
							url: './index.php?r='+$(this).parent().data('settings').submitUrl,
							type: "POST",
							data: ({input : $(this).parent().children('.phdInlineInputBox').val()}),
							success: function(data)
							{
								location.reload();
							},
							error: function(data)
							{
								button.parent().children('.phdInlineInputErrors').html(data.responseText);
								button.parent().children('.phdInlineInputErrors').fadeIn();
							}
						});
					}
				);
				
			});
		}
	};
	
	// Method logic
	$.fn.phdInlineInput = function( method ) 
	{
		// Method calling logic
		if ( methods[method] ) {
		  return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ));
		} else if ( typeof method === 'object' || ! method ) {
		  return methods.init.apply( this, arguments );
		} else {
		  $.error( 'Method ' +  method + ' does not exist on jQuery.phdInlineInput' );
		}    
	};
}
)(jQuery);

/*
 * phdInlineSelect
 * Presents a select with a submit checkmark in place of a link
 */
(function($)
{

	// Methods
	var methods = {
		
		init : function( options )
		{
			return this.each(function() {
			
				var $this = $(this);
				
				// Settings
				defaults = {
					'submitImage'	: './images/tick-small.png',
					'cancelImage'	: './images/cross-small.png',
					'inputName'		: 'phdInputName',
					'label'			: false,
					'getUrl'		: 'mainPage/index',
					'submitUrl'		: 'mainPage/index',
					'listUrl'		: 'mainPage/index',
				};
				
				$this.data('settings', defaults);
				
				var data = $this.data();

				// If options exist, lets merge them
				// with our default settings
				if ( options ) 
				{ 
					$.extend( data.settings, options );
				}
				
				var htmlContent = {
					'label' : '<label class="phdInlineSelectLabel" style="line-height: 22px"></label>',
					'value' : '<a href="javascript:void();" class="phdInlineSelectValue">Loading...</a>',
					'input' : '<select style="font-size: 10px; name="'+ data.settings.inputName +'" class="phdInlineSelectBox"></select>',
					'submitButton' : '<input type="image" src="' + data.settings.submitImage + '" alt="submit" class="phdInlineSelectSubmitButton" style="vertical-align: middle">',
					'cancelButton' : '<input type="image" src="' + data.settings.cancelImage + '" alt="submit" class="phdInlineSelectCancelButton" style="vertical-align: middle">',
					'errors' : '<span class="phdInlineSelectErrors" style="color: red"></span>'
				}
				
				if (data.settings.label != false)
				{
					htmlContent.label = '<label class="phdInlineSelectLabel" style="line-height: 22px">'+ data.settings.label +': </label>';
				}
				
				// Initialize the display and get the initial value
				$this.html(htmlContent.label+htmlContent.value+htmlContent.input+htmlContent.submitButton+htmlContent.cancelButton+htmlContent.errors);
				$this.children('.phdInlineSelectBox').hide();
				$this.children('.phdInlineSelectSubmitButton').hide();
				$this.children('.phdInlineSelectCancelButton').hide();
				$this.children('.phdInlineSelectErrors').hide();

				var selectBox = $this.children('.phdInlineSelectBox');
				$.ajax({
					url: './index.php?r='+data.settings.listUrl,
					dataType: 'json',
					success: function(data)
					{
						$.each(data, function(index, value)
						{
							selectBox.append('<option value='+value.val+'>'+value.display+'</option>');
						});
					},
				});
				
				var selectValue = $this.children('.phdInlineSelectValue');
				$.ajax({
					url: './index.php?r='+data.settings.getUrl,
					dataType: 'json',
					success: function(data)
					{
						$.each(data, function(index, value)
						{
							selectValue.html(value.display);
							selectValue.parent().children('.phdInlineSelectBox').val(value.val);
						});
					},
				});			
				
				// Create the click event for clicking on the loaded value
				$this.children('.phdInlineSelectValue').click(
					function()
					{
						$(this).hide();
						$(this).fadeOut();
						
						$(this).parent().children('.phdInlineSelectBox').fadeIn();
						$(this).parent().children('.phdInlineSelectSubmitButton').fadeIn();
						$(this).parent().children('.phdInlineSelectCancelButton').fadeIn();
						$(this).parent().children('.phdInlineSelectCancelButton').data('previousValue', $(this).parent().children('.phdInlineSelectBox').val());

					}
				);
				
				// Create the click event for clicking on the cancel button
				$this.children('.phdInlineSelectCancelButton').click(
					function()
					{
						$(this).parent().children('.phdInlineSelectBox').hide();
						$(this).parent().children('.phdInlineSelectSubmitButton').hide();
						$(this).parent().children('.phdInlineSelectCancelButton').hide();
						$(this).parent().children('.phdInlineSelectErrors').hide();
						$(this).parent().children('.phdInlineSelectValue').fadeIn();
						
						$(this).parent().children('.phdInlineSelectBox').val($(this).data('previousValue'));
					}
				);
				
				// Create the click event for clicking on the loaded value
				$this.children('.phdInlineSelectSubmitButton').click(
					function()
					{
					button = $(this);
						$.ajax({
							url: './index.php?r='+$(this).parent().data('settings').submitUrl,
							type: "POST",
							data: ({input : $(this).parent().children('.phdInlineSelectBox').val()}),
							success: function(data)
							{
								location.reload();
							},
							error: function(data)
							{
								button.parent().children('.phdInlineSelectErrors').html(data.responseText);
								button.parent().children('.phdInlineSelectErrors').fadeIn();
							}
						});
					}
				);
				
			});
		}
	};
	
	// Method logic
	$.fn.phdInlineSelect = function( method ) 
	{
		// Method calling logic
		if ( methods[method] ) {
		  return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ));
		} else if ( typeof method === 'object' || ! method ) {
		  return methods.init.apply( this, arguments );
		} else {
		  $.error( 'Method ' +  method + ' does not exist on jQuery.phdInlineInput' );
		}    
	};
}
)(jQuery);
    
/*
 * phdInlineSelect
 * Presents a select with a submit checkmark in place of a link
 */
(function($)
{
    // Methods
    var methods = {
		
        init : function( options )
        {
            return this.each(function() {
			
                var $this = $(this);

                // Settings
                defaults = {
                    'url'       : 'replaceThis.php',
                    'minDays'   : 14,
                    'tickColor' : '#DDD'
                };

                $this.data('settings', defaults);

                var data = $this.data();
                var headerOffset = 20;

                // If options exist, lets merge them
                // with our default settings
                if ( options ) 
                { 
                    $.extend( data.settings, options );
                }
                
                //Create the basic elements
                $this.css('position','relative');
                $this.css('z-index','0');
                //$this.append('<div id="industry-job-calendar-canvas" style="position: absolute; top: -20px; z-index: 1"></div>');
                $this.append('<table id="industry-job-calendar-table" style="position: relative; z-index: 0; width: 906px;"></table>');
                $('#industry-job-calendar-table').append('<div id="industry-job-calendar-canvas" style="position: absolute; top: -20px; z-index: 1"></div>');
                
                //Load the JSON data containing the job calendar
                $.ajax({
                    url: data.settings.url,
                    dataType: 'json',
                    success: function(data){
                        
                        //Grab the table object
                        calTable = $('#industry-job-calendar-table');
                        calTable.width($this.width());
                        
                        var furthestDate = 0;
                        
                        for (var i = 0; i < data.length; i++)
                        {   
  
                            //Odd and even
                            if ((i%2) != 0)
                            {
                                 calTable.append('<tr class="odd"><td><div class="industry-job-calendar-row" id="jobid-'+[i]+'">'+data[i].outputTypeID+'</div></td></tr>');
                            }
                            else
                            {
                                calTable.append('<tr><td><div class="industry-job-calendar-row" id="jobid-'+[i]+'">'+data[i].outputTypeID+'</div></td></tr>');
                            }
                            
                            //Convert the sql dates into js timestamps
                            var startTime = mysqlToDate(data[i].beginProductionTime);
                            var endTime = mysqlToDate(data[i].endProductionTime);
                            
                            //Current date
                            var now = new Date();
                            var curDate = new Date(Date.UTC(now.getUTCFullYear(),now.getUTCMonth(),now.getUTCDate()));
                            
                            //Set the maximum end time
                            if (endTime > furthestDate)
                            {
                                furthestDate = endTime;
                            }
                        }
                        
                        //Furthest date sanity
                        var furthestUTC = new Date(Date.UTC(furthestDate.getUTCFullYear(), furthestDate.getUTCMonth(), furthestDate.getUTCDate()));
                        furthestDate = new Date(furthestUTC.getTime() + (1000 * 60 * 60 * 24));
                        var numDays = (furthestDate.getTime() - curDate.getTime()) / (1000 * 60 * 60 * 24);
                        
                        if (numDays < 14)
                        {
                            numDays = 14;
                            furthestDate = new Date(curDate.getTime() + (1000 * 60 * 60 * 24 * numDays));
                        }
                        
                        //Canvas
                        var width = $this.width();
                        var height = $('#industry-job-calendar-table').height();
                        var offset = 20;

                        var paper = Raphael("industry-job-calendar-canvas", width, height + offset);
                        var days = numDays;

                        var interval = width / days;
                        var cursor = interval;
                        var dayCursor = curDate;
                        i = 0;
                        while (cursor < width )
                        {
                            i++;
                            rounded = Math.round(cursor);
                            var l = paper.path("M"+rounded+" "+offset+"L"+rounded+" "+(height + offset));
                            l.attr({
                               stroke: '#333',
                               'stroke-width': '.5',
                               'stroke-opacity': '.1'
                            });
                            
                            
                            paper.text((cursor - (interval /2)),10,dayCursor.getUTCDate());

                            cursor += interval;
                            dayCursor = new Date(dayCursor.getTime() + (1000 * 60 * 60 * 24));
                        }
                        i++;
                        paper.text((cursor - (interval /2)),10,dayCursor.getUTCDate());
                        
                        //Width and margin calcs
                        for (i = 0; i < data.length; i++)
                        {
                            //Convert the sql dates into js timestamps
                            var startTime = mysqlToDate(data[i].beginProductionTime);
                            var endTime = mysqlToDate(data[i].endProductionTime);
                            
                            //Calculate our object margins
                            var containerWidth = $this.width() - 6;
                            var pixelWidth = (furthestDate.getTime() - curDate.getTime()) / containerWidth;
                            
                            var marginLeft = 0;
                            if (startTime > curDate)
                            {
                                marginLeft = (startTime.getTime() - curDate.getTime()) / pixelWidth;
                            }
                            else
                            {
                                startTime = curDate;
                            }
                            var divWidth = (endTime.getTime() - startTime.getTime()) / pixelWidth;
                            
                            $('#jobid-'+[i]).css('margin-left',marginLeft);
                            $('#jobid-'+[i]).html('<img src="http://image.eveonline.com/Type/'+data[i].outputTypeID+'_32.png" class="industry-calendar-icon">');
                            if (divWidth < 26)
                            {
                                $('#jobid-'+[i]).css('width', divWidth);
                            }
                            else
                            {
                                $('#jobid-'+[i]).animate({'width': divWidth}, 1500);
                            } 
                        }       
                    }
                });
                
            });
        }
    };
        
	
	// Method logic
	$.fn.phdIndustryCalendar = function( method ) 
	{
		// Method calling logic
		if ( methods[method] ) {
		  return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ));
		} else if ( typeof method === 'object' || ! method ) {
		  return methods.init.apply( this, arguments );
		} else {
		  $.error( 'Method ' +  method + ' does not exist on jQuery.phdInlineInput' );
		}    
	};
}
)(jQuery);
    
    
/**
 * pdhIndustryCalendar
 */
(function($){
 
    /**
     * Globals
     */
    var globals = {
        
        table       : '<table class="industry-job-calendar-table" style="position: relative; z-index: 0;"></table>',
        canvas      : '<div class="industry-job-calendar-canvas" style="position: absolute; top: -20px; left: 3px; z-index: 1"></div>',
        row         : '<tr><td><div class="industry-job-calendar-row" id=""></div></td></tr>',
        icon        : '<img src="" class="industry-calendar-icon">',
        headerOffset: 20
    }
    

    /**
     * Internal functions
     */
    var internal = {
        
        mysqlToDate: function(mysqlDate) {
            
            // Split timestamp into [ Y, M, D, h, m, s ]
            var t = mysqlDate.split(/[- :]/);

            // Apply each element to the Date function
            return new Date(Date.UTC(t[0], t[1]-1, t[2], t[3], t[4], t[5]));
            
        },
        
        isOdd: function(num) {
            if (num%2 != 0) {return true;}
            else {return false;}
        },
        
        animate: function(divRow, divWidth) {
            divRow.animate({'width': divWidth}, 1500);
        },
        
        startLayout: function($this){
            
            //Create the basic elements
            $this.css('position','relative');
            $this.css('z-index','0');
            $this.append(globals.table);
            $('.industry-job-calendar-table').append(globals.canvas);
            
        },
        
        getData: function($this, callback){
            
            var passThis = $this;
            //Fetch the json data
            $.ajax({
                url: $this.data().settings.url,
                dataType: 'json',
                success: function(data){
                    callback(passThis, data);
                }
            });
        },
        
        populateTable: function($this, results){
            
            //Initialize some variables
            var calTable = $this.children('.industry-job-calendar-table');
            var calRow;
            var now = new Date();
            var currentDate = new Date(Date.UTC(now.getUTCFullYear(),now.getUTCMonth(),now.getUTCDate()));
            var startDate;
            var endDate;
            var maxDate = 0;
            
            //Iterate over the JSON results to populate the table and get our maximum date
            for (var i = 0; i < results.length; i++)
            {   
                //Add the base row layout to the table   
                calTable.append('<tr><td><div class="industry-job-calendar-row" id="'+results[i].jobID+'"></div></td></tr>');
                
                //Get our new object and create the icon
                calRow = $('#'+results[i].jobID);
                calRow.html(globals.icon);
                calRow.children('.industry-calendar-icon').attr('src', 'http://image.eveonline.com/Type/'+results[i].outputTypeID+'_32.png');
                
                //Create the tooltip
                $('body').append('<div class="industry-calendar-tooltip" id=ic-tooltip-'+results[i].jobID+'> \
                	<img class="industry-calendar-tooltip-icon" src="http://image.eveonline.com/Type/'+results[i].outputTypeID+'_32.png"> \
                	<h1>'+results[i].typeName+'</h1>\
                	<p>Started: '+results[i].beginProductionTime+'</p>\
                	<p>Ends: '+results[i].endProductionTime+'</p></div>');
                
                //Odd and even
                if (internal.isOdd(i))
                {
                     calRow.closest('tr').addClass('odd');
                }

                //Convert the sql dates into js timestamps
                startDate = internal.mysqlToDate(results[i].beginProductionTime);
                endDate = internal.mysqlToDate(results[i].endProductionTime);

                //Set the maximum end time
                if (endDate > maxDate)
                {
                    maxDate = endDate;
                }
            }

            //Turn our maximum date/time into just a date
            var maxDateUTC = new Date(Date.UTC(maxDate.getUTCFullYear(), maxDate.getUTCMonth(), maxDate.getUTCDate()));
            
            //Add one day to our maximum date to get a nice extra day at the end of the display
            maxDate = new Date(maxDateUTC.getTime() + (1000 * 60 * 60 * 24));
            
            //Get the total number of days between now and the final maximum date
            var numDays = (maxDate.getTime() - currentDate.getTime()) / (1000 * 60 * 60 * 24);
            
            //If the number of days is less than our minimum, set it to our minimum
            if (numDays < $this.data().settings.minDays)
            {
                numDays = $this.data().settings.minDays;
                maxDate = new Date(currentDate.getTime() + (1000 * 60 * 60 * 24 * numDays));
            }
            
            //Add our date variables to the local data
            var dates = {
                maxDate: maxDate,
                numDays: numDays,
                currentDate: currentDate
            };
            $this.data('dates', dates);
        },
        
        drawCanvas: function($this){
            
            //Initialize our variables
            var width = $this.width() - 6;
            var height = $this.children('.industry-job-calendar-table').height();
            var offset = globals.headerOffset;
            
            var canvasDiv = $this.children('.industry-job-calendar-table').children('.industry-job-calendar-canvas')[0];

            //Create the canvas
            var paper = Raphael(canvasDiv, width, height + offset);

            //Set our intervals and inital values
            var interval = width / $this.data().dates.numDays;
            var cursor = interval;
            var dayCursor = $this.data().dates.currentDate;
            var rounded;
            
            //Draw our canvas objects
            i = 0;
            while (cursor < width )
            {
                i++;
                
                //Draw our vertical lines
                rounded = Math.round(cursor);
                var l = paper.path("M"+rounded+" "+offset+"L"+rounded+" "+(height + offset));
                l.attr({
                   stroke: '#333',
                   'stroke-width': '.5',
                   'stroke-opacity': '.1'
                });

                //Draw our date numbers
                paper.text((cursor - (interval /2)),10,dayCursor.getUTCDate());

                //Update our line and date cursors
                cursor += interval;
                dayCursor = new Date(dayCursor.getTime() + (1000 * 60 * 60 * 24));
            }
            
            //Draw the final number
            i++;
            paper.text((cursor - (interval /2)),10,dayCursor.getUTCDate());
        },
        
        drawBars: function($this, results){
            
            //Initialize some variables
            var startDate;
            var endDate;
            var curDate = $this.data().dates.currentDate;
            var maxDate = $this.data().dates.maxDate;
            var containerWidth = $this.width() - 6;
            var pixelWidth;
            var marginLeft;
            var divWidth;
            var divRow;
            var animations = new Array();
            
            //Iterate through the JSON results
            for (i = 0; i < results.length; i++)
            {
                //Get our current object
                divRow = $('#'+results[i].jobID);
                
                //Convert the sql dates into js timestamps
                startDate = internal.mysqlToDate(results[i].beginProductionTime);
                endDate = internal.mysqlToDate(results[i].endProductionTime);

                //Calculate our object margins
                pixelWidth = (maxDate.getTime() - curDate.getTime()) / containerWidth;

                marginLeft = 0;
                if (startDate > curDate)
                {
                    marginLeft = (startDate.getTime() - curDate.getTime()) / pixelWidth;
                }
                else
                {
                    startDate = curDate;
                }
                divWidth = (endDate.getTime() - startDate.getTime()) / pixelWidth;

                divRow.css('margin-left',marginLeft);
                if (divWidth < 26)
                {
                    divRow.css('width', divWidth);
                }
                else
                {  
                    var jobID = results[i].jobID;
                    (function(jobID, i, divWidth, containerWidth){
                        setTimeout(function(){
                            $('#'+jobID).animate({'width': divWidth}, (2000 * (divWidth / containerWidth)));
                        }, (i+1) * 200);
                    })(jobID, i, divWidth, containerWidth);
                } 
            }
            
            //Add the tooltips
            var tooltipTimeout;
            $('.industry-job-calendar-row').hover(function(e) {
            	$this = $(this);
            	offset = $this.offset();
            	event = e;
            	tooltipTimeout = setTimeout(function() {
            	
            		//Get the tooltip object
            		tooltip = $('#ic-tooltip-'+$this.attr('id'));
            		
            		//Get our tooltip positioning
            		bottom = offset.top - tooltip.height() - 15;
            		left = e.pageX - (tooltip.width() / 2);
            		if (left < 5)
            		{
            			left = 5;
            		}
            	
            		//Position and fade in our tooltip
            		tooltip.css('left', left+'px');
            		tooltip.css('top', bottom+'px');
            		tooltip.fadeIn();
            		
            	}, 300);
           	}, function() {
           		clearTimeout(tooltipTimeout);
           		$('#ic-tooltip-'+$this.attr('id')).fadeOut();
           	});
        }     
    };
    
    /**
     * Plugin methods
     */
    var methods = {
      
        init: function(options) {
            
            return this.each(function(){
                
                //Global this
                var $this = $(this);
                
                // Settings
                defaults = {
                    'url'           : '',
                    'minDays'       : 14,
                    'tickColor'     : '#DDD',
                    'tickOpacity'   : 1.0
                };
                $this.data('settings', defaults);
                var data = $this.data();
                
                // Merge the options specified with our default settings
                if ( options ) 
                { 
                    $.extend( data.settings, options );
                }
   
   
                //Initialization logic
                internal.startLayout($this);
                internal.getData($this, function($this, results){
                   internal.populateTable($this, results);
                   internal.drawCanvas($this);
                   internal.drawBars($this, results);
                });
                 
            });
        }
      
    };
    
    /**
     * Main magic function
     */
    $.fn.phdIndustryCalendarRef = function( method ) 
    {
        // Method calling logic
        if ( methods[method] ) {
            return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ));
        } else if ( typeof method === 'object' || ! method ) {
            return methods.init.apply( this, arguments );
        } else {
            $.error( 'Method ' +  method + ' does not exist on jQuery.phdIndustryCalendar' );
        }    
    };
    
})(jQuery);

function mysqlToDate(mysqlDate)
{
    // Split timestamp into [ Y, M, D, h, m, s ]
    var t = mysqlDate.split(/[- :]/);

    // Apply each element to the Date function
    return new Date(Date.UTC(t[0], t[1]-1, t[2], t[3], t[4], t[5]));
}

function utcTime()
{
    // create Date object for current location
    d = new Date();
   
    // convert to msec
    // add local time zone offset
    // get UTC time in msec
    utc = d.getTime() + (d.getTimezoneOffset() * 60000);
    
    return utc;
}
    
