/**
 * jQuery GooCorners 0.1 - fast crossbrowser rounded corners.
 *
 * Fixme:
 *  - if element with fixed height - incorrect set corners
 *  - not show border color (see http://www.cssplay.co.uk/boxes/snazzy.html)
 *  - disabled mozilla/webkit corners (need enable after tests)
 *  - optimize speed - use one array returned from `getCorners()` to generate top and bottom corners
 *  - pass options array and parse it (now it radius size)
 *
 * @author Anton Danilchenko <happy@phpdays.org>
 * Licensed MIT
 */
jQuery.fn.goocorners = function(options) {
    radius = 6;
    tl = true;
    tr = true;
    bl = true;
    br = true;
    style = 'display: block; height: 1px; overflow: hidden; font-size:1px; position: relative; margin: 0; padding: 0;';

    // detect browsers
    var webkit  = (document.body.style.WebkitBorderRadius !== undefined);
    var mozilla = (document.body.style.MozBorderRadius !== undefined);
    /*** TEST: use generated corners only! ***/
    webkit = mozilla = false;
    // add corners for each element
    return this.each(function(i, e){
        var $e = jQuery(e);
        // change original element properties
        var marginTop = parseInt($e.css('margin-top')) || 0;
        var marginBottom = parseInt($e.css('margin-bottom')) || 0;
        $e.css('margin-top', (marginTop+radius)+'px');
        $e.css('margin-bottom', (marginBottom+radius)+'px');
        $e.css('padding-top', '0px');
        $e.css('padding-bottom', '0px');
        /* @fixme: with fixed height - incorrect setted corners */
        $e.css('height', 'auto');
        // save original style
        var oldstyle = style;
        style += 'background-color: ' + $e.css('background-color') + ';';
        if (webkit)
            roundWebkit($e);
        else if (mozilla)
            roundMozilla($e);
        else
            roundOthers($e);
        // restore original style
        style = oldstyle;
    });

    function roundWebkit(e) {
        var radius = '' + this.radius + 'px ' + this.radius + 'px';
        if (this.tl) e.css('WebkitBorderTopLeftRadius', radius);
        if (this.tr) e.css('WebkitBorderTopRightRadius', radius);
        if (this.bl) e.css('WebkitBorderBottomLeftRadius', radius);
        if (this.br) e.css('WebkitBorderBottomRightRadius', radius);
    }

    function roundMozilla(e) {
        var radius = '' + this.radius + 'px';
        if (this.tl) e.css('-moz-border-radius-topleft', radius);
        if (this.tr) e.css('-moz-border-radius-topright', radius);
        if (this.bl) e.css('-moz-border-radius-bottomleft', radius);
        if (this.br) e.css('-moz-border-radius-bottomright', radius);
    }

    function roundOthers(e) {
        var radiusTL=0, radiusTR=0, radiusBL=0, radiusBR=0;
        var paddingLeft  = parseInt(e.css('padding-left')) || 0;
        var paddingRight = parseInt(e.css('padding-right')) || 0;
        var tagBeforeContent = '<div style="font-size: 1px; height: 1px;">';
        var tagAfterContent  = '<div style="font-size: 1px; height: 1px; clear: both;">';
        // top
        if (this.tl && this.tr)
            radiusTL = radiusTR = this.radius;
        else if (this.tl)
            radiusTL = this.radius;
        else if (this.tr)
            radiusTR = this.radius;
        // bottom
        if (this.bl && this.br)
            radiusBL = radiusBR = this.radius;
        else if (this.bl)
            radiusBL = this.radius;
        else if (this.br)
            radiusBR = this.radius;
        cornersTop    = getCorners(radiusTL, radiusTR, paddingLeft, paddingRight, -1*radius).reverse();
        cornersBottom = getCorners(radiusBL, radiusBR, paddingLeft, paddingRight, 1);
        var content =
            tagBeforeContent + cornersTop.join('') + '</div>'
            + e.html() +
            tagAfterContent + cornersBottom.join('') + '</div>';
        e.html(content);
    }

    function getCorners(left, right, marginLeft, marginRight, top) {
        var corners = new Array;
        var level = left || right;
        for (i=level+1; i>0; i--) {
            // after first line
            if (i==level) {
                left  = (left>0 ? left-1 : 0);
                right = (right>0 ? right-1 : 0);
                continue;
            }
            corners[i] = '<b style="' + this.style + ' top: ' + top + 'px; margin-left: ' + (left-marginLeft) + 'px; margin-right: ' + (right-marginRight) + 'px' + '"></b>';
            // before last line
            if (i==2) {
                left++;
                right++;
            }
            left  = (left>0 ? left-1 : 0);
            right = (right>0 ? right-1 : 0);
        }
        return corners;
    }
}