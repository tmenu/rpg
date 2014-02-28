
function move(event)
{
	event.preventDefault();

	$.ajax({
		url: '/map/' + $(this).attr('id') + '.html?isAjax',
		dataType: 'json',
		success: function(data)
		{
			if (data.fight) {
				window.location = '/fight.html';
			}
			else if (data.lvlup) {
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

function attack(event)
{
	event.preventDefault();

	$.ajax({
		url: '/attack.html?isAjax',
		dataType: 'json',
		success: function(data)
		{
			$('#fight').html( data.battle );
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

	$('body').on('click', '#attack', attack);
	$('body').on('click', '#continue', attack);
	//$('#defense').click(continuee);
});