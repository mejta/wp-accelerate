import 'intersection-observer';

window.addEventListener('load', function() {
  function lazyload(entries) {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const element = entry.target;

        if (element.getAttribute('data-src')) {
          element.setAttribute('src', element.getAttribute('data-src'));
          element.removeAttribute('data-src');
        }

        if (element.getAttribute('data-srcset')) {
          element.setAttribute('srcset', element.getAttribute('data-srcset'));
          element.removeAttribute('data-srcset');
        }
      }
    });
  }

  document
    .querySelectorAll('iframe[data-src],img[data-src]')
    .forEach(element => new IntersectionObserver(lazyload).observe(element));
});
