{{--
=================================================================
Overflow Detector - Development Use Only
=================================================================
Include this partial ONLY in development environment
to detect elements causing horizontal scroll.

Usage in your Blade layout:
@include('partials.overflow-detector')
=================================================================
--}}

@if(config('app.debug'))
<script>
/**
 * Horizontal Overflow Detector
 * Auto-detects elements wider than viewport within .bc-skin
 */
(function() {
  'use strict';

  function detectOverflow() {
    const vw = window.innerWidth;
    const offenders = [];
    const bcSkin = document.querySelector('.bc-skin');

    if (!bcSkin) {
      console.warn('⚠️ .bc-skin not found');
      return [];
    }

    bcSkin.querySelectorAll('*').forEach(function(el) {
      const rect = el.getBoundingClientRect();
      if (rect.width - vw > 0.5) {
        offenders.push({
          element: el,
          width: Math.round(rect.width),
          overflow: Math.round(rect.width - vw),
          tag: el.tagName.toLowerCase(),
          classes: el.className || '(no class)',
          id: el.id || '(no id)'
        });
        el.style.outline = '2px dashed red';
        el.style.outlineOffset = '-2px';
      }
    });

    if (offenders.length > 0) {
      console.group('🔴 Horizontal Overflow Detected!');
      console.warn(`Found ${offenders.length} element(s):`);
      console.table(offenders.map(o => ({
        Tag: o.tag,
        Classes: o.classes,
        Width: `${o.width}px`,
        Overflow: `+${o.overflow}px`
      })));
      console.groupEnd();
    } else {
      console.info('✅ No overflow detected');
    }

    return offenders;
  }

  // Auto-run
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => setTimeout(detectOverflow, 500));
  } else {
    setTimeout(detectOverflow, 500);
  }

  // Expose globally
  window.detectOverflow = detectOverflow;

  console.info('🔍 Overflow detector active. Run detectOverflow() anytime.');
})();
</script>
@endif
