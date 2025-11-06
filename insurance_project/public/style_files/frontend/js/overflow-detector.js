/**
 * ============================================================
 * Horizontal Overflow Detector (Development Tool)
 * ============================================================
 *
 * Detects and highlights elements causing horizontal scroll
 * within .bc-skin scope. Use in development only!
 *
 * Usage:
 * 1. Include this script in your page
 * 2. Open browser console
 * 3. Culprits will be outlined in red
 * 4. Check console for detailed list
 *
 * To run manually:
 * detectOverflow();
 */

(function() {
  'use strict';

  window.detectOverflow = function() {
    const viewportWidth = window.innerWidth;
    const offenders = [];

    // Check all elements within .bc-skin
    const bcSkin = document.querySelector('.bc-skin');
    if (!bcSkin) {
      console.warn('⚠️ No .bc-skin element found');
      return;
    }

    const elements = bcSkin.querySelectorAll('*');

    elements.forEach(function(el) {
      const rect = el.getBoundingClientRect();

      // Element exceeds viewport width by more than 0.5px (floating point tolerance)
      if (rect.width - viewportWidth > 0.5) {
        offenders.push({
          element: el,
          width: Math.round(rect.width),
          overflow: Math.round(rect.width - viewportWidth),
          tag: el.tagName.toLowerCase(),
          classes: el.className || '(no class)',
          id: el.id || '(no id)'
        });

        // Visual highlight
        el.style.outline = '2px dashed red';
        el.style.outlineOffset = '-2px';
      }
    });

    // Report results
    if (offenders.length > 0) {
      console.group('🔴 Horizontal Overflow Detected!');
      console.warn(`Found ${offenders.length} element(s) causing horizontal scroll:`);
      console.table(offenders.map(o => ({
        Tag: o.tag,
        Classes: o.classes,
        ID: o.id,
        Width: `${o.width}px`,
        Overflow: `+${o.overflow}px`
      })));
      console.log('Elements are outlined in RED on the page');
      console.groupEnd();

      return offenders;
    } else {
      console.info('✅ No horizontal overflow detected!');
      return [];
    }
  };

  // Auto-run on load
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', function() {
      setTimeout(window.detectOverflow, 500);
    });
  } else {
    setTimeout(window.detectOverflow, 500);
  }

  // Re-run on resize (debounced)
  let resizeTimer;
  window.addEventListener('resize', function() {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(window.detectOverflow, 300);
  });

  console.info('🔍 Overflow detector loaded. Run detectOverflow() manually anytime.');
})();
