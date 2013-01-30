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

$("#homeImgs").backstretch(["./img/home_img/image_1.jpg", "./img/home_img/image_2.jpg", "./img/home_img/image_3.jpg", "./img/home_img/image_4.jpg", "./img/home_img/image_5.jpg", "./img/home_img/image_6.jpg"], {
		fade : 750,
		duration : 50000
	});

});//end ready handler
