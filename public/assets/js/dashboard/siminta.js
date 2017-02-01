
/*====================================
 Free To Use For Personal And Commercial Usage
Author: http://binarytheme.com
 Share Us if You Like our work 
 Enjoy Our Codes For Free always.
 ======================================*/

 $(function () {

    $("a[name=edit-img]").on('click', function(){
        $("#myModal").modal({show: true});
        var id = $(this).attr('rel');
        var nome = $(this).parents("div[class=thumbnail]").children("img").attr('alt');
        var src = $(this).parents('div[class=thumbnail]').children('img').attr('src');
        var action = $("#myModal form").attr('action');

        $("#myModal form").attr('action', action+'/'+id);
        $("#myModal input[name=name]").val(nome);
        $("#myModal img").attr('src', src);
        $("#myModal img").attr('alt', nome);
        $("#myModal img").attr('title', nome);
    });

    // tooltip demo
    $('.tooltip-demo').tooltip({
        selector: "[data-toggle=tooltip]",
        container: "body"
    })

    // popover demo
    $("[data-toggle=popover]")
    .popover()
    ///calling side menu

    $('#side-menu').metisMenu();

    //Dropzone.autoDiscover = false;

    ///pace function for showing progress

    /*function load(time) {
        var x = new XMLHttpRequest()
        x.open('GET', "" + time, true);
        x.send();
    };

    load(20);
    load(100);
    load(500);
    load(2000);
    load(3000);*/
    //setTimeout(function () {
        Pace.ignore(function () {
            /*load(3100);*/
        });
    //}, 4000);

Pace.on('hide', function () {
    // console.log('done');
});
paceOptions = {
    elements: true
};


});

//Loads the correct sidebar on window load, collapses the sidebar on window resize.
$(function() {
    $(window).bind("load resize", function() {
        // console.log($(this).width());
        if ($(this).width() < 768) {
            $('div.sidebar-collapse').addClass('collapse')
        } else {
            $('div.sidebar-collapse').removeClass('collapse')
        }
    })
})
