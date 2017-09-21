/**
* Función encargada de validar email
* @param Strning email
* @return true | false
*/
function validarEmail(email)
{
    var expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if ( !expr.test(email) )
    {
        return false;
    }else
    {
        return true;
    }
}
/**
* Función encargada de permitir el ingreso de solo valores númericos
* utilizar: $("selector").keydown(function(e){
                inputNumberOnly(e);
              });
*/
function inputNumberOnly( e ){
  // Permitir: backspace, delete, tab, escape, enter and
    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
         // Permitir: Ctrl+A, Command+A
        (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
         // Permitir: home, end, left, right, down, up
        (e.keyCode >= 35 && e.keyCode <= 40)) {
             //let it happen, don't do anything
             return;
    }
    // Verificar que lo digitado es un número
    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
        e.preventDefault();
    }
}

$(function() {
    $('#side-menu').metisMenu();
});
//Loads the correct sidebar on window load,
//collapses the sidebar on window resize.
// Sets the min-height of #page-wrapper to window size
$(function() {
    $(window).bind("load resize", function() {
        topOffset = 50;
        width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 768) {
            $('div.navbar-collapse').addClass('collapse');
            topOffset = 100; // 2-row-menu
        } else {
            $('div.navbar-collapse').removeClass('collapse');
        }
        height = ((this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height) - 1;
        height = height - topOffset;
        if (height < 1) height = 1;
        if (height > topOffset) {
            $("#page-wrapper").css("min-height", (height) + "px");
        }
    });
    var url = window.location;
    var element = $('ul.nav a').filter(function() {
        return this.href == url || url.href.indexOf(this.href) == 0;
    }).addClass('active').parent().parent().addClass('in').parent();
    if (element.is('li')) {
        element.addClass('active');
    }
});
