const container = $('#container');
const doc = $(document);
container.loadHTML = function(data) {
	$(this).fadeOut(400, 'linear');
	setTimeout(function() {
		container
			.html(data)
			.fadeIn(900);
	}, 400);
};

let loaded_scripts = [];

function message(msg = '', mode = 'info') {
	const message = '<div class="alert alert-' + mode + '">'
		+ msg
		+ '</div>';
	$('#message-pane').html(message);
}

function disableLink(event) {
	event.preventDefault();
	event.stopImmediatePropagation();
}

function loadScript(script) {
	for(let i in loaded_scripts) {
		if(loaded_scripts[i] == script) {
			return;
		}
	}
	loaded_scripts[loaded_scripts.length] = script;
	$.getScript('assets/js/' + script);
}

function toggleSpinner(s) {
	const spinner = $('#spinner');
	if(s) {
		spinner.css('display', 'block');
	}
	else {
		spinner.css('display', 'none');
	}
}