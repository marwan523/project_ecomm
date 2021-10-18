$(function(){
	'use strict';


/*switch between login and sign up*/
	$('.login-page h1 span').click(function(){
		$(this).addClass('selected').siblings().removeClass('selected');
		$('.login-page form').hide();
		$('.' + $(this).data('class')).fadeIn(100)
	});
	//dashboard

	//TRIGGER THE SELECT BOX
	 /*("select").selectBoxIt();
	$('[placeholder]').focus(function(){

		$(this).attr('data-text', $(this).attr('placeholder'));
		$(this).attr('placeholder', '');
	})
	.blur(function(){
		$(this).attr('placeholder', $(this).attr('data-text'));

	});*/

	//add asterrisk on required field

	$('input').each(function()
	{
		if ($(this).attr('required') === 'required')
		{
			$(this).after('<span class="asterisk">*</span>');

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

	/**/
	$('.live-name').keyup(function ()
	{
		$('.live-preview .caption h3').text($(this).val());
	});
   //category view option
$(".x").click(function(){
  $(".x").hide();
});


});

