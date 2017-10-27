$(document).ready(function(){

	//decare variables 
	var $mainNav = $("header nav");

		$mainNav.waypoint(function(e, direction){

		if(direction==="down"){
			//if the scroll direction is down then fix the nav ul to the top of the screen
   			$(this).find('ul').addClass('sticky');

		}else{
			//if the scroll direction is up then position the nav ul back in the document flow
			$(this).find('ul').removeClass('sticky');

		}

	});	


$("#bgImgs").backstretch([siteinfo.imagePath+"home_img/image_1.jpg", siteinfo.imagePath+"home_img/image_2.jpg", siteinfo.imagePath+"home_img/image_3.jpg", siteinfo.imagePath+"home_img/image_4.jpg", siteinfo.imagePath+"home_img/image_5.jpg", siteinfo.imagePath+"home_img/image_6.jpg"], {
		fade : 750,
		duration : 50000
	});
//==================== CAMPSITE PAGE ========================//

if($('#booking').length !== 0){

$( "#from" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 1,
      onClose: function( selectedDate ) {
        $( "#to" ).datepicker( "option", "minDate", selectedDate );
       	var start = $('#from').datepicker('getDate');
	    var end   = $('#to').datepicker('getDate');
	    var $calculatedDays   = (end - start)/1000/60/60/24;
	    parseInt($calculatedDays);
	   ($("input.days")).val($calculatedDays);
      }
    });
    $( "#to" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 1,
      onClose: function( selectedDate ) {
        $( "#from" ).datepicker( "option", "maxDate", selectedDate );
	    var start = $('#from').datepicker('getDate');
	    var end   = $('#to').datepicker('getDate');
	    var $calculatedDays   = (end - start)/1000/60/60/24;
	    parseInt($calculatedDays);
	   ($("input.days")).val($calculatedDays);
      }
    });


/*$('#calDays').click(function(){
	// alert('clicked');
    var start = $('#from').datepicker('getDate');
    var end   = $('#to').datepicker('getDate');
    var $calculatedDays   = (end - start)/1000/60/60/24;
    parseInt($calculatedDays);
   ($("input.days")).val($calculatedDays);
   //alert($("input.days").val());
});*/

};// end if

//==================== MAP GUFF ========================//

	$('.map-hov').hover(function(){
		$(this).css({opacity:1});
	},function(){
		$('.map-hov').not('.mapsel').css({opacity:0});
	});

	$('.map-hov').click(function(e){
		e.preventDefault();


		$('.map-hov').removeClass('mapsel');
		$(this).addClass('mapsel');

		
		$('.map-hov').css({opacity:0});
		$(this).css({opacity:1});


		if ($(window).width() > 740) { // jQuery media query

			var region = $(this).attr('title'), // REGION TITLE VAR
				dsplRegion = $(this).attr('data-location'),
				box = $('.box'),
				box2 = $('.box2'),
				box3 = $('.box3'),
				box3a = $('.box3 a'),
				box3R = box3.find("[data-location='" + dsplRegion + "']");


			box2.stop(true, true).animate({width:0,opacity:0},100,function(){ // hide everything
				box3a.hide();
				$('.top5 span').html(region); // DISPLAY REGION TITLE
				$('.box3 #'+ dsplRegion).show(); // show appropriate campsites for region
				box3R.show(function(){
					box2.show().animate({width:"100%",opacity:1},100,function(){ //animate box open
						box3.animate({opacity:1},100); // fade in content
					});
				});
			});

		}//window size

	});//.click

	if ($(window).width() < 740) { // jQuery media query

		$('.box3 a').hide(); // hide all a tags in box3
		$('.box3 .greenbutton').show(); // show all "visit all campsites" buttons

		var regionElmt = $('.box3 .greenbutton'); // visit campsites button
		var regionName = []; // this is an empty array for now

		for (var i=0;i<regionElmt.length;i++){ // loop through the buttons
				regionName.push(regionElmt[i]); // and return the results to the empty array
			}	

		for (var i=0;i<regionName.length;i++){ // loop through the array with button results
				$(regionName[i]).html($(regionName[i]).attr('data-name')); // spit the button name into the appropriat button html
			}

	}// jQuery media query end



//==================== CHECKOUT PAGE SELECT TAG EXCITEMENT =====================//
	
	$('select').change(function(){
		$('.opt').removeClass('sel');

		var seloptstr = $('option:selected').html(),//gets select tag label name
			seloptlc = seloptstr.toLowerCase(),//changes it to lowercase
			optclass = ".opt" + seloptlc;//adds '.opt' on the front to match div class

		$(optclass).addClass('sel');
	});

// ============================== EXCERPT =====================================//

	// add class "excerpt" to p tag
	$('.excerpt').text(function() {
	    return $(this).text().substring(0, 200) + "...";
	});

// ============================== BOOKING LABEL =====================================//
	
	$(window).ready(function() {
		if ($('.wrapper').hasClass('camppage')) {
			$('.qtyppl').html("people");
		} else if($('.wrapper').hasClass('gearpage')){
			$('.qtyppl').html("qty");
		}
	});

/*========================== Rotating Slideshow  ============================*/
		
		/*------------------Declare variables--------------------*/
											 
		var currentIndex = 0,
		dissolveSpeed = 1000,
		$images = $(".rotator img"),
		$imageWrapper = $(".rotator"),
		numImages = $images.length,
		delay  = 4000;
		 
		/*------------------ Initialisation -------------------*/
	
		//initialise images
		$images.parent().css("position","relative");
	 	$images.css("position","absolute").hide().eq(currentIndex).fadeIn(dissolveSpeed);
		
		/*------------------ Timer Functionality --------------------*/
		startSlideshow();
		
		function startSlideshow(){
			
			interval = setInterval(function(){
			
				var newIndex;
				newIndex = currentIndex+1;
				changeImage(newIndex%numImages);
				
			}, delay);
		
		}
		
		function stopSlideshow(){
			
			clearInterval(interval);
			
		}
		
		/*------------------ Slideshow Pause on hover and restart on hover off --------------------*/
		
		$imageWrapper.hover(function(){
			
				stopSlideshow();
			
			},function(){
				
				var newIndex;
				newIndex = currentIndex+1;
				changeImage(newIndex%numImages);
				startSlideshow();
				
			});
		
		
		/*------------------ Change Image function --------------------*/
	 
		
		function changeImage(newIndex){
			
				//fade out current image
				$images.eq(currentIndex).stop(true, true).fadeOut(dissolveSpeed);
				
				//update the current index
				currentIndex = newIndex;
				
				//fade in the next image
				$images.eq(currentIndex).stop(true, true).fadeIn(dissolveSpeed);
			
		};

		/*------------------ highest Image function --------------------*/

		var highest = null;
		var hi = 0;
		$images.each(function(){
		  var h = $(this).height();
		  if(h > hi){
		     hi = h;
		     highest = $(this);  
		  }

		  $imageWrapper.height(hi + 20).width(290);
		  console.log(hi);    
		});






});//end ready handler