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


function refreshContent() {
    jQuery.ajax({
        'type': 'GET',
        'url': document.location.href,
        'cache': false,
        'success':function(html){
            $('.cards_content--wrap').html(html);
        }       
    });       
}


$(function ($) {

    // Работа с формами в модальниках
    $(document).on('submit', '.cards_plan_ajax_form', function() {
        
        var obj = $(this);

        $.ajax({
            'type': 'POST',
            'url': obj.attr('action'),
            'data': obj.serialize(),
            'dataType': 'json',
            'cache': false,
            'success':function(json){

                if (json.status == 'error') {
                    obj.closest('.modal-content').html(json.html);
                } else if (json.status == 'ok') {

                    obj.closest('.modal').modal('hide');

                    refreshContent();

                }
            }       
        });

        return false;
    })

    // Удаление элементов через AJAX
    $(document).on('click', '.cards_plan_ajax_delete', function() {

        if (confirm('Точно?')) {

            var obj = $(this);

            $.ajax({
                'type': 'POST',
                'url': obj.attr('href'),
                'dataType': 'json',
                'cache': false,
                'success':function(json){
                    if (json.status == 'error')
                        alert(json.message);

                    obj.closest('.modal').modal('hide');

                    refreshContent();
                }       
            });
        }

        return false;
    });



    // Ссылки через AJAX
    $(document).on('click', '.cards_plan_ajax_link', function() {

        $.ajax({
            'type': 'GET',
            'url': $(this).attr('href'),
            'cache': false,
            'success':function(){
                refreshContent();
            }       
        });

        return false;
    });



});
