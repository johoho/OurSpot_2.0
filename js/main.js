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

<<<<<<< HEAD
		
=======

>>>>>>> Contact Page & Campsite Page html added
		$('.map-hov').css({opacity:0});
		$(this).css({opacity:1});



		$('.sound').remove();
		$('#dummy').append(' <embed class="sound" src="Pop.aiff" hidden="true" autostart="true" loop="false" />');
		// setTimeout(function(){
  // 			$('.sound').remove();
		// }, 2000);

	var region = $(this).attr('title') // REGION TITLE VAR

	$('.box3').animate({opacity:0},
		function(){
		$('.top5 span').html(region); // DISPLAY REGION TITLE
		});

	if($('.open').length < 1){
	$('.box2').show().animate({width:"100%",height:'100%'},100);
	}


	$('.box3').animate({opacity:1});

	$('.box').addClass('open');

	});//.click


//==================== MAP GUFF END =====================//

<<<<<<< HEAD
});//end ready handler
=======
});//end ready handler
>>>>>>> Contact Page & Campsite Page html added
