$(function(){
	'use strict';

	//dashboard
	$(".toggle-info").click(function(){

		$(this).toggleClass(".selected").parent().next(".panel-body").fadeToggle(100);

		if($(this).hasClass(".selected"))
		{
			$(this).html("<i class='fa fa-minus fa-lg'></i>"); 
		}
		else
		{
			$(this).html("<i class='fa fa-plus fa-lg'></i>");
		}
	});



	//apper password
	var passfield = $(".password");
	$(".show-pass").hover(function(){

		passfield.attr('type', 'text');

	},function(){

		passfield.attr('type', 'password');

	});

	//confirmation message on button
	$('.confirm').click(function(){
		return confirm("are you sure?");
		
	});

   //category view option
   $('.cat h3').click(function(){

   	$(this).next('.full-view').fadeToggle(200);

   });	

   $('.option span').click(function(){

   	$(this).addClass('active').siblings('span').removeClass('active');
   	if ($(this).data('view') === 'full')
   	{
   		$('.cat .full-view').fadeIn(200);
   	}
   	else
   	{
   		$('.cat .full-view').fadeOut(200);
   	}

   });


});





