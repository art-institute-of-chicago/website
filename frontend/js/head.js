// Contents to be minified and placed inline in the document header
// Doc: https://code.area17.com/a17/fe-boilerplate/wikis/js-head

// go go
(function(d) {

  // set up a master object
  var A17 = window.A17 || {},
      de = d.documentElement,
      w = window,
      h = d.getElementsByTagName('head')[0],
      s, a;

  // test for HTML5 vs HTML4 support, cutting the mustard
  A17.browserSpec = (typeof d.querySelectorAll && 'addEventListener' in w && w.history.pushState && d.implementation.hasFeature('http://www.w3.org/TR/SVG11/feature#BasicStructure', '1.1')) ? 'html5' : 'html4';

  // testing for object fit support
  A17.objectFit = ('objectFit' in de.style);

  // expose A17
  window.A17 = A17;

  // add class names
  de.className = de.className.replace(/\bno-js\b/,' js '+A17.browserSpec+(A17.objectFit ? ' objectFit' : ' no-objectFit'));

  // disable all the stylesheets, except the html4css one
  function disableSS() {
    if (/in/.test(d.readyState)) {
      setTimeout(disableSS,9);
    } else {
      for(var i = 0; i < d.styleSheets.length; i++){
        var ss = d.styleSheets[i];
        if (ss.title !== 'html4css') {
          ss.disabled = true;
        }
      }
    }
  }

  // FF < 3.6 didn't have document.readyState - hacky shim for it
  function disableSSff3() {
    if (!d.readyState && d.addEventListener) {
      if (d.body) {
        setTimeout(function(){
          d.readyState = 'complete';
        },500);
      } else {
        setTimeout(disableSSff3,9);
      }
    }
  }

  if(A17.browserSpec === 'html4'){
    // if an old browser - sort the page out for showing the html4css
    s = d.createElement('link');
    s.rel  = 'stylesheet';
    s.title = 'html4css';
    s.href = '/dist/styles/html4css.css';
    h.appendChild(s);
    s = d.createElement('script');
    s.src = '//legacypicturefill.s3.amazonaws.com/legacypicturefill.min.js';
    h.appendChild(s);
    disableSSff3();
    disableSS();
  } else {
    s = d.createElement('script');
    s.src = '//cdnjs.cloudflare.com/ajax/libs/picturefill/3.0.3/picturefill.min.js';
    h.appendChild(s);
  }
})(document);
