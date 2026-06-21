/**
 * Align footer brand-column social icons to the horizontal center of the logo image.
 */
(function () {
  'use strict';

  var brandSelector = '.llp-site-footer .llp-footer-col--brand';
  var logoSelector = '.wp-block-image img, .llp-footer-logo img';
  var socialSelector = '.wp-block-social-links, ul.llp-footer-social';

  function alignFooterSocialToLogo() {
    var brand = document.querySelector(brandSelector);
    if (!brand) {
      return;
    }

    var logo = brand.querySelector(logoSelector);
    var social = brand.querySelector(socialSelector);
    if (!logo || !social) {
      return;
    }

    social.style.marginLeft = '';

    var logoRect = logo.getBoundingClientRect();
    var socialRect = social.getBoundingClientRect();

    if (logoRect.width === 0 || socialRect.width === 0) {
      return;
    }

    var logoCenter = logoRect.left + logoRect.width / 2;
    var socialCenter = socialRect.left + socialRect.width / 2;
    var offset = logoCenter - socialCenter;

    if (Math.abs(offset) <= 0.5) {
      return;
    }

    social.style.marginLeft = offset + 'px';
  }

  function scheduleAlign() {
    window.requestAnimationFrame(alignFooterSocialToLogo);
  }

  function init() {
    scheduleAlign();

    var brand = document.querySelector(brandSelector);
    if (!brand) {
      return;
    }

    var logo = brand.querySelector(logoSelector);
    if (logo && !logo.complete) {
      logo.addEventListener('load', scheduleAlign, { once: true });
    }

    var resizeTimer;
    window.addEventListener('resize', function () {
      window.clearTimeout(resizeTimer);
      resizeTimer = window.setTimeout(scheduleAlign, 100);
    });

    if (typeof ResizeObserver !== 'undefined' && logo) {
      new ResizeObserver(scheduleAlign).observe(logo);
    }
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
