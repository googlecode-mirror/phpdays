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
});
