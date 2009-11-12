/**
 * @author Anton Danilchenko <happy@phpdays.org>
 */
$(document).ready(function(){
    CURRENT_LANGUAGE = 'ru';
    // include files
    $.include('/static/js/i10n.js');
    // add rounded corners
    $('.rounded').goocorners(6, [1,1,1,1]);
    $('.rounded_down').goocorners(4, [0,0,1,1]);
    $('.rounded_top').goocorners(4, [1,1,0,0]);
    // language panel (over on logo)
    $('.logo').mouseover(function(){
      $('div.language').fadeIn("normal");
    });
    $('#menu').mouseleave(function(){
      $('div.language').fadeOut("normal");
    });
    $('#menu>a:not(:first)').mouseover(function(){
      $('div.language').fadeOut("normal");
    });
});
