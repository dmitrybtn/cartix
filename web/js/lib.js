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


function refreshPlan() {
    var plan = $('.cards_layout_plan');

        jQuery.ajax({
            'type': 'GET',
            'url': plan.attr('data-refresh'),
            'cache': false,
            'success':function(html){
                plan.replaceWith(html);                
            }       
        });

}

function refreshContent() {

    jQuery.ajax({
        'type': 'GET',
        'url': document.location.href,
        'cache': false,
        'success':function(html){
            $('#cards_content').html(html);
        }       
    });    

    
}


$(function ($) {

	var env = findBootstrapEnvironment();

	if (env == 'lg' || env == 'md') {


        $('#cards_content').addClass('cards_content-desktop');


        if (sessionStorage.getItem('scroll-plan') != null)
            $('#cards_layout_plan').scrollTop(sessionStorage.getItem('scroll-plan'));


        $(window).on('unload', function() {
            sessionStorage.setItem('scroll-plan', $('#cards_layout_plan').scrollTop());
        });

	}


    // Работа с формами в модальниках
    $(document).on('submit', '.cards_plan_transfer--modal form', function() {
        
        var self = $(this);

        jQuery.ajax({
            'type': 'POST',
            'url': self.attr('action'),
            'data': self.serialize(),
            'dataType': 'json',
            'cache': false,
            'success':function(json){
                // self.closest('.modal').modal('hide');
                // $.fn.yiiListView.update('order_list');

                if (json.status == 'error') {
                    self.closest('.modal-content').html(json.html);
                } else if (json.status == 'ok') {

                    self.closest('.modal').modal('hide');

                    refreshPlan();
                    refreshContent();

                }

                
            }       
        });



        return false;
    })



    // Плавная прокрутка текста при работе с планом
    $('.cards_layout_plan--link').click(function() {
        
        var link = $(this)
        var target = link.attr('data-target');
        var coords = $(target).position().top;

        $('#cards_layout_plan--nav').removeClass('cards_layout_plan--nav-spy');

        $('#cards_content').animate({
            scrollTop: $('#cards_content').scrollTop() + coords
        }, {
            duration: 400,
            easing: "swing",
            complete: function() {
                
                $('.cards_layout_plan--nav li').removeClass('active');

                link.parent().addClass("active");

                $('#cards_layout_plan--nav').addClass('cards_layout_plan--nav-spy');                
            }
        });
       

        return false;
    })



});
