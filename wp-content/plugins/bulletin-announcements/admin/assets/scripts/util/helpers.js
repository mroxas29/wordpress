const helpers = {
  IsIEBrowser: function() {
    let ua = window.navigator.userAgent;

    // test values
    // IE 10
    //ua = 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; Trident/6.0)';
    // IE 11
    //ua = 'Mozilla/5.0 (Windows NT 6.3; Trident/7.0; rv:11.0) like Gecko';
    // IE 12 / Spartan
    //ua = 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.71 Safari/537.36 Edge/12.0';

    let msie = ua.indexOf('MSIE ');
    if (msie > 0) {
      // IE 10 or older => return version number
      return parseInt(ua.substring(msie + 5, ua.indexOf('.', msie)), 10);
    }

    let trident = ua.indexOf('Trident/');
    if (trident > 0) {
      // IE 11 => return version number
      let rv = ua.indexOf('rv:');
      return parseInt(ua.substring(rv + 3, ua.indexOf('.', rv)), 10);
    }

    let edge = ua.indexOf('Edge/');
    if (edge > 0) {
      // IE 12 => return version number
      return parseInt(ua.substring(edge + 5, ua.indexOf('.', edge)), 10);
    }
    return false;
  },
  docLocalStorage: {
    getItem: function(skey) {
      if (!skey) {
        return null;
      }

      try {
        return localStorage.getItem(skey);
      }
      catch (e) {
        return null;
      }
    },
    setItem: function(skey, vEnd) {
      let sExpires = [];
      const now = new Date();
      const setTime = now.getTime() + vEnd;
      if (vEnd) {
        switch (vEnd.constructor) {
          case Number:
            sExpires = vEnd === Infinity ? {expires: new Date('Fri, 31 Dec 9999 23:59:59 GMT')} : {expires: new Date(setTime).toString()};
            break;
          case String:
            sExpires = {expires: vEnd};
            break;
          case Date:
            sExpires = {expires: vEnd.toUTCString()};
            break;
        }
      }
      localStorage.setItem(skey, JSON.stringify(sExpires));
      return true;
    },
    removeItem: function(sKey) {
      if (!sKey) {
        return null;
      }

      try {
        return localStorage.removeItem(sKey);
      }
      catch (e) {
        return null;
      }
    },
    checkExpiryItem: function(sKey) {
      const object = JSON.parse(localStorage.getItem(sKey));
      if (!object){
        return false;
      }

      const now = new Date().getTime();
      const expiryTime = new Date(object.expires).getTime();

      if (now > expiryTime) {
        localStorage.removeItem(sKey);
        return true;
      }
    }
  },
  getParameterByName: (name, url) => {
    if (!url) url = window.location.href;
    name = name.replace(/[[\]]/g, '\\$&');
    const regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
      results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
  },
  getParameters: (url) => {
    if (!url) url = window.location.href;
    if (url.indexOf('?') !== -1) {
      const params = url.split('?')[1];

      try {
        return JSON.parse('{"' + decodeURI(params.replace(/&/g, ',').replace(/=/g,':')) + '"}');
      } catch (e) {
        return {};
      }
    } else {
      return {};
    }
  },
  pushStateHistory: function(subfix = '', replace = false) {
    let path = '';

    if (replace) {
      path = subfix;
    } else {
      path = location.protocol + '//' + location.host + location.pathname;
      path += subfix;
    }

    history.pushState({path: path}, '', path);
  },
  equalHeightElements: function(container, clr, gapDelta) {
    clr = (typeof clr !== 'undefined' ? clr : false);
    gapDelta = (typeof gapDelta !== 'undefined' ? gapDelta : 10);
    let currentTallest = 0,
      currentRowStart = 0,
      rowDivs = [],
      el,
      currentDiv,
      topPosition = 0;
    const c = jQuery(container).filter(':visible');
    if (c.length <= 1) {
      return false;
    }
    if (!clr) {
      c.css('min-height', 0);
    } else {
      c.removeAttr('style');
    }
    c.each(function() {
      el = jQuery(this);
      topPosition = el.offset().top;
      if ((currentRowStart < (topPosition + gapDelta)) && (currentRowStart > (topPosition - gapDelta))) {
        rowDivs.push(el);
        currentTallest = (currentTallest < el.outerHeight()) ? (el.outerHeight()) : (currentTallest);
      } else {
        for (currentDiv = 0; currentDiv < rowDivs.length; currentDiv++) {
          rowDivs[currentDiv].css('min-height', currentTallest + 'px');
        }
        rowDivs.length = 0; // empty the array
        currentRowStart = topPosition;
        currentTallest = el.outerHeight();
        rowDivs.push(el);
      }
      for (currentDiv = 0; currentDiv < rowDivs.length; currentDiv++) {
        rowDivs[currentDiv].css('min-height', currentTallest + 'px');
      }
    });
    return true;
  },
};

export default helpers;
