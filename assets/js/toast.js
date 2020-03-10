$(document).ready(() => {
	$('[data-dismiss="toast"]').on('click', function(e) {
		e.preventDefault();
		const target = $(this).attr('data-target');
		$(target).toast('hide');
		e.stopImmediatePropagation();
	});
});

function hideToast() {
	$('#message-toast').toast('hide');
}