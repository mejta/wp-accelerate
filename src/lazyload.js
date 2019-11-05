require('intersection-observer');

window.addEventListener('load', function() {
  function replaceAttribute(attr, element) {
    if (element.getAttribute(`data-${attr}`)) {
      element.setAttribute(attr, element.getAttribute(`data-${attr}`));
      element.removeAttribute(`data-${attr}`);
    }
  }

  function lazyload(attr) {
    return function(entries) {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          replaceAttribute(attr, entry.target);
        }
      });  
    };
  }

  document
    .querySelectorAll('source[data-srcset],img[data-srcset]')
    .forEach(element => new IntersectionObserver(lazyload('srcset')).observe(element));
  
  document
    .querySelectorAll('iframe[data-src],source[data-src],img[data-src]')
    .forEach(element => new IntersectionObserver(lazyload('src')).observe(element));

  document
    .querySelectorAll('[data-style]')
    .forEach(element => new IntersectionObserver(lazyload('style')).observe(element));
});
