$(document).ready(function() {
	$(document).on('click', '#pagination-link', function(e) {
		e.preventDefault();
		$.ajax({
			url: $(this).attr('href'),
			type: 'GET',
			success: result => {
				container.loadHTML(result);
			}
		});
		e.stopImmediatePropagation();
		return false;
	});
});