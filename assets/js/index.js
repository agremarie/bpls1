doc.ready(() => {
	doc.on('click', '#nav-btn', function(e) {
		disableLink(e);
		$.get($(this).attr('href'), result => {
			container.loadHTML(result);
		});
	});
});