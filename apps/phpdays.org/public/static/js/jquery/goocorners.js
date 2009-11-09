/**
 * jQuery GooCorners 0.2 - fast crossbrowser rounded corners.
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
jQuery.fn.goocorners = function(size, options) {
  // set radius
  radius = (typeof(size)=='number') ? size : 0;
  // set corners position
  tl = ((typeof(options)!='undefined' && options[0]) ? true : false);
  tr = ((typeof(options)!='undefined' && options[1]) ? true : false);
  bl = ((typeof(options)!='undefined' && options[2]) ? true : false);
  br = ((typeof(options)!='undefined' && options[3]) ? true : false);
  style = {
    'display':   'block',
    'height':    '1px',
    'overflow':  'hidden',
    'font-size': '1px',
    'position':  'relative',
    'margin':    0,
    'padding':   0
  }

  // detect browsers
  var webkit  = (document.body.style.WebkitBorderRadius !== undefined);
  var mozilla = (document.body.style.MozBorderRadius !== undefined);
  /*** TEST: use generated corners only! ***/
  webkit = mozilla = false;
  // add corners for each element
  return this.each(function(i, e){
      var $e = jQuery(e);
      if (webkit)
          roundWebkit($e);
      else if (mozilla)
          roundMozilla($e);
      else
          roundOthers($e);
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
    style['background-color'] = e.css('background-color');
    // change original element properties
    var marginTop    = parseInt(e.css('margin-top'))     || 0;
    var marginBottom = parseInt(e.css('margin-bottom'))  || 0;
    var borderWidth  = parseInt(e.css('borderTopWidth')) || 0;
    var borderColor  = rgb2hex(e.css('borderTopColor'));
    e.css('margin-top',     (marginTop+radius)+'px');
    e.css('margin-bottom',  (marginBottom+radius)+'px');
    e.css('padding-top',    '0px');
    e.css('padding-bottom', '0px');
    /* @fixme: with fixed height - incorrect setted corners */
    e.css('height', 'auto');
    // set raduius
    var radiusTL=0, radiusTR=0, radiusBL=0, radiusBR=0;
    var paddingLeft  = parseInt(e.css('padding-left'))  || 0;
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
    cornersTop    = (radiusTL || radiusTR)
      ? getCorners(radiusTL, radiusTR, paddingLeft, paddingRight, -1*radius, borderWidth, borderColor).reverse()
      : [];
    cornersBottom = (radiusBL || radiusBR)
      ? getCorners(radiusBL, radiusBR, paddingLeft, paddingRight, 1, borderWidth, borderColor)
      : [];
    var content =
      tagBeforeContent + cornersTop.join('') + '</div>'
      + e.html() +
      tagAfterContent + cornersBottom.join('') + '</div>';
    e.html(content);
  }

  function getCorners(left, right, marginLeft, marginRight, top, borderWidth, borderColor) {
    // style for current element only
    var style = {};
    jQuery.extend(style, this.style);
    if (borderWidth>0 && top<0)
      top--;
    // change original style
    var corners = new Array;
    var level = left || right;
    var first = true;
    // with borders
    if (borderWidth>0) {
      left--;
      right--;
    }
    for (i=level+1; i>0; i--) {
      if (borderWidth>0) {
        style['border-right'] = style['border-left'] = (borderWidth)+'px solid '+borderColor;
      }
      // first line
      if (borderWidth>0) {
        if (first) {
          style['border-top'] = borderWidth+'px solid '+borderColor;
          style['height'] = '0px';
          first = false;
        } else {
          style['height'] = this.style['height'];
          delete style['border-top'];
        }
        // 2nd line
        if (i==level-1) {
          style['border-right'] = style['border-left'] = (borderWidth+1)+'px solid '+borderColor;
        }
      }
      // not show 2nd line
      if (i==level) {
        left  = (left>0 ? left-1 : 0);
        right = (right>0 ? right-1 : 0);
        continue;
      }
      // additional parameters
      style['top']          = top+'px';
      style['margin-left']  = (left-marginLeft)+'px';
      style['margin-right'] = (right-marginRight)+'px';
      // insert line
      corners[i] = '<b style="' + join(style) + '"></b>';
      // before last line
      if (i==2) {
        left++;
        right++;
      }
      // insert additional line after last line
      if (borderWidth>0 && i==1) {
        if ('transparent'==style['background-color'])
          style['background-color'] = 'white';
        // erace border
        style['margin-left']  = (left-marginLeft-1)+'px';
        style['margin-right'] = (right-marginRight-1)+'px';
        // insert additional line
        corners[0] = '<b style="' + join(style) + '"></b>';
      }
      left  = (left>0 ? left-1 : 0);
      right = (right>0 ? right-1 : 0);
    }
    return corners;
  }

  /** Join associative array to string */
  function join(array) {
    var string = '';
    var delimiter ='; ';
    for (element in array)
      string += element + ': ' + array[element] + delimiter;
    return string;
  }

  function rgb2hex(c) {
    var x = 255;
    var hex = '';
    var i;
    var regexp=/([0-9]+)[, ]+([0-9]+)[, ]+([0-9]+)/;
    var array=regexp.exec(c);
    for(i=1;i<4;i++) hex += ('0'+parseInt(array[i]).toString(16)).slice(-2);
    return '#'+hex;
  }
}