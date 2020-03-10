$(document).ready(() => {
	$('.nav-link:not(.dropdown-toggle)').click(function(e) {
		disableLink(e);;
		$('.active').removeClass('active');
		$(this).addClass('active');
		$.ajax({
			url: $(this).attr('href'),
			type: 'GET',
			success: result => {
				container.loadHTML(result);
				loadScript($(this).attr('data-script') + '.js');
			}
		});
	});
});