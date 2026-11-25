/**
 * Checkout: DNA Payments Lightbox cancel notice.
 *
 * The DNA gateway opens its Lightbox without a `cancelled` handler, so closing it
 * leaves checkout silent. Wrap DNAPayments.configure() just before the gateway calls
 * it and add one that shows a standard WooCommerce checkout error notice.
 */
(function ($) {
  'use strict';

  var params = window.liveLifeDnaCancel || {};
  var FLAG = '__liveLifeCancelNotice';

  function showNotice() {
    var $form = $('form.checkout');
    if (!$form.length || !params.message) {
      return;
    }
    $('.woocommerce-NoticeGroup-checkout, .woocommerce-error, .woocommerce-message').remove();
    var $li = $('<li></li>').text(params.message);
    var $group = $('<div class="woocommerce-NoticeGroup woocommerce-NoticeGroup-checkout"></div>')
      .append($('<ul class="woocommerce-error" role="alert"></ul>').append($li));
    $form.prepend($group);
    $('html, body').animate({ scrollTop: $group.offset().top - 100 }, 600);
  }

  function wrapConfigure() {
    var dna = window.DNAPayments;
    if (!dna || typeof dna.configure !== 'function' || dna.configure[FLAG]) {
      return;
    }
    var original = dna.configure;
    var wrapped = function (config) {
      if (config && typeof config === 'object') {
        config.events = config.events || {};
        var previous = config.events.cancelled;
        config.events.cancelled = function () {
          if (typeof previous === 'function') {
            previous.apply(this, arguments);
          }
          showNotice();
        };
      }
      return original.apply(this, arguments);
    };
    wrapped[FLAG] = true;
    dna.configure = wrapped;
  }

  // The DNA library replaces window.DNAPayments once it loads, so re-wrap on every attempt.
  document.addEventListener('click', function (event) {
    if (event.target && event.target.closest && event.target.closest('#place_order')) {
      wrapConfigure();
    }
  }, true);
  document.addEventListener('submit', function (event) {
    if (event.target && event.target.matches && event.target.matches('form.checkout')) {
      wrapConfigure();
    }
  }, true);
})(jQuery);
