
function move(event)
{
	event.preventDefault();
	$('#map').load('/map/' + $(this).attr('id') + '.html?isAjax');
}

jQuery(document).ready(function($)
{
	$('#moveUp').click(move);
	$('#moveDown').click(move);
	$('#moveLeft').click(move);
	$('#moveRight').click(move);
});