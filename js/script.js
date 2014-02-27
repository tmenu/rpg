
function move(event)
{
	event.preventDefault();

	$.ajax({
		url: '/map/' + $(this).attr('id') + '.html?isAjax',
		dataType: 'json',
		success: function(data)
		{
			if (data['fight']) {
				window.location = '/fight.html';
			}
			else if (data['lvlup']) {
				window.location = '/map.html';
			}
			else {
				$('#map').html( data.map );
			}
		},
		error: function()
		{
			alert('Error!');
		}
	});
}

jQuery(document).ready(function($)
{
	$('#moveUp').click(move);
	$('#moveDown').click(move);
	$('#moveLeft').click(move);
	$('#moveRight').click(move);
});