function findBootstrapEnvironment() {
    var envs = ['xs', 'sm', 'md', 'lg'];

    var $el = $('<div>');
    $el.appendTo($('body'));

    for (var i = envs.length - 1; i >= 0; i--) {
        var env = envs[i];

        $el.addClass('hidden-'+env);
        if ($el.is(':hidden')) {
            $el.remove();
            return env;
        }
    }
}

$(function ($) {

	var env = findBootstrapEnvironment();

	if (env == 'lg' || env == 'md') {

		var content = $('#content');

		content.addClass('content-desktop');
		content.scrollspy({target: '#card_layout_nav'});
	}

});
