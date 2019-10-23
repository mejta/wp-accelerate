if ('IntersectionObserver' in window) {
  handleLazyLoad();
} else {
  import('intersection-observer').then(handleLazyLoad);
}

function handleLazyLoad() {
  window.addEventListener('load', function() {
    function lazyload(attr) {
      return function(entries) {
        entries.forEach(entry => {
          if (entry.isIntersecting && entry.target.getAttribute(`data-${attr}`)) {
            entry.target.setAttribute(attr, entry.target.getAttribute(`data-${attr}`));
            entry.target.removeAttribute(`data-${attr}`);
          }
        });  
      };
    }

    function lazyloadBackgroundImage(entries) {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.setAttribute('style', entry.target.getAttribute('style').replace('--lazyload-background-image', 'background-image'));
        }
      });
    }
    
    document
      .querySelectorAll('source[data-srcset],img[data-srcset]')
      .forEach(element => new IntersectionObserver(lazyload('srcset')).observe(element));
    
    document
      .querySelectorAll('iframe[data-src],source[data-src],img[data-src]')
      .forEach(element => new IntersectionObserver(lazyload('src')).observe(element));

    document
      .querySelectorAll('[style*="--lazyload-background-image"]')
      .forEach(element => new IntersectionObserver(lazyloadBackgroundImage).observe(element));
  });
}