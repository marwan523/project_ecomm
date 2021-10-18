
$(".x").click(function(){
  $(".x").hide();
});

$('.live-name').keyup(function ()
{
	$('.live-preview .caption h3').text($(this).val());
});



$('.live-desc').keyup(function ()
{
	$('.live-preview .caption p').text($(this).val());
});

$('.live-price').keyup(function ()
{
	$('.live-preview .price-tag').text( '$' + $(this).val());
});
/* Edit by using data class */
/*

$('.live').keyup(function ()
{
	$($(this).data('class')).text($(this).val());
});*/
