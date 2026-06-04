import './main.css';

/**
 * Single product tabs: parent inline script targets `.tab-content` / `data-tab-content`,
 * but markup uses `.tab-panel` / `data-tab-panel`. Wire clicks here (child bundle loads after parent).
 */
function initSingleProductTabs() {
  document.querySelectorAll('[data-product-tabs]').forEach((root) => {
    const buttons = root.querySelectorAll('.tab-btn[data-tab]');
    const panels = root.querySelectorAll('.tab-panel[data-tab-panel]');

    if (!buttons.length || !panels.length) {
      return;
    }

    function activateTab(tabId) {
      panels.forEach((panel) => {
        const id = panel.getAttribute('data-tab-panel');
        if (id === tabId) {
          panel.classList.remove('hidden');
        } else {
          panel.classList.add('hidden');
        }
      });

      buttons.forEach((btn) => {
        const id = btn.getAttribute('data-tab');
        const isActive = id === tabId;
        if (isActive) {
          btn.classList.remove('font-medium', 'text-text-secondary');
          btn.classList.add(
            'font-semibold',
            'text-primary',
            'border-b-2',
            'border-primary',
            '-mb-px',
          );
        } else {
          btn.classList.add('font-medium', 'text-text-secondary', 'hover:text-primary', 'transition-colors');
          btn.classList.remove(
            'font-semibold',
            'text-primary',
            'border-b-2',
            'border-primary',
            '-mb-px',
          );
        }
      });
    }

    buttons.forEach((btn) => {
      btn.addEventListener('click', (e) => {
        e.preventDefault();
        const tabId = btn.getAttribute('data-tab');
        if (tabId) {
          activateTab(tabId);
        }
      });
    });
  });
}

const PROGRESS_FILL_SELECTOR =
  '.ncs-product-card__progress-fill[data-progress], .ncs-progress__fill[data-progress], [data-progress].ncs-product-card__progress-fill, [data-progress].ncs-progress__fill';

/**
 * Animate a single progress fill from data-progress (cards ship at width: 0%).
 */
function applyProgressFill(fill) {
  const raw = fill.getAttribute('data-progress');
  if (raw === null || raw === '') {
    return;
  }
  const progress = parseFloat(raw, 10);
  if (Number.isNaN(progress)) {
    return;
  }
  const clamped = Math.min(100, Math.max(0, progress));
  setTimeout(() => {
    fill.style.width = `${clamped}%`;
  }, 100);
}

/**
 * Initialize progress fills within a root element (document or subtree).
 */
function initProgressInRoot(root) {
  if (!root || typeof root.querySelectorAll !== 'function') {
    return;
  }
  root.querySelectorAll(PROGRESS_FILL_SELECTOR).forEach(applyProgressFill);
}

/** Progress bars site-wide (single product, listing AJAX via nera:content:loaded). */
function initSingleProductProgressBars() {
  initProgressInRoot(document);
}

/**
 * Advanced filter grid: load more / filter replace DOM without nera:content:loaded.
 */
function initAdvancedFilterProgressObserver() {
  const grid = document.getElementById('advanced-filter-grid');
  if (!grid) {
    return;
  }

  initProgressInRoot(grid);

  const observer = new MutationObserver(() => {
    initProgressInRoot(grid);
  });

  observer.observe(grid, { childList: true, subtree: true });
}

function closeActiveGalleryLightboxes() {
  const gallery = document.querySelector('.product-gallery');
  if (!gallery) {
    return;
  }

  /** Fullscreen lightbox overlay (direct child of .product-gallery, after the main .group block) */
  const lightboxShell = gallery.querySelector(':scope > div.fixed.inset-0');
  if (!lightboxShell) {
    return;
  }

  const closeBtn =
    lightboxShell.querySelector('button[aria-label="Close lightbox"]') ||
    lightboxShell.querySelector('button.absolute.top-4.right-4');
  if (closeBtn) {
    closeBtn.click();
  }

  const escapeEvent = new KeyboardEvent('keydown', { key: 'Escape', code: 'Escape', bubbles: true });
  document.dispatchEvent(escapeEvent);
  window.dispatchEvent(escapeEvent);

  requestAnimationFrame(() => {
    if (!document.querySelector('.nera-ticket-dialog-overlay-active')) {
      document.body.style.overflow = '';
    }
  });
}

function initTicketDialogModalExclusivity() {
  document.addEventListener('nera:ticket-dialog:open', () => {
    closeActiveGalleryLightboxes();
  });

  document.addEventListener(
    'click',
    (event) => {
      const trigger = event.target.closest('.nera-ticket-trigger');
      if (!trigger) {
        return;
      }

      closeActiveGalleryLightboxes();
    },
    true,
  );
}

function initLiveLifeFrontend() {
  initTicketDialogModalExclusivity();
  initSingleProductTabs();
  initSingleProductProgressBars();
  initAdvancedFilterProgressObserver();
}

document.addEventListener('nera:content:loaded', initSingleProductProgressBars);

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initLiveLifeFrontend);
} else {
  initLiveLifeFrontend();
}
