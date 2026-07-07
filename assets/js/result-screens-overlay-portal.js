/**
 * Portal lty-rs-overlay to document.body so it escapes #content's stacking context.
 * Must run before lty-result-screens.js DOMContentLoaded (synchronous footer load).
 */
(function () {
  'use strict';

  var overlay = document.querySelector('.lty-rs-overlay');
  if (!overlay || overlay.parentElement === document.body) {
    return;
  }

  document.body.appendChild(overlay);
})();
