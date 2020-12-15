window.onload = () => $('*').scrollLeft(0)
window.onscroll = () => {
    $('.show-on-scroll').each(function() {
        const $el = $(this)
        if (isElementInViewport(this)) $el.addClass('is-visible')
        else $el.removeClass('is-visible')
    })
}

// Functions

function isElementInViewport(el) {
  if (typeof jQuery === "function" && el instanceof jQuery) el = el[0];
  const rect = el.getBoundingClientRect();
  return (
    (rect.top <= 0
      && rect.bottom >= 0)
    ||
    (rect.bottom >= (window.innerHeight || document.documentElement.clientHeight) &&
      rect.top <= (window.innerHeight || document.documentElement.clientHeight))
    ||
    (rect.top >= 0 &&
      rect.bottom <= (window.innerHeight || document.documentElement.clientHeight))
  );
}
