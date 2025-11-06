/**
 * Perfect Scrollbar Passive Event Fix
 * Fixes the "Added non-passive event listener" warning
 * by patching addEventListener before perfect-scrollbar loads
 */

(function() {
    'use strict';
    
    // Store original addEventListener
    const originalAddEventListener = EventTarget.prototype.addEventListener;
    
    // List of scroll-blocking events that should be passive
    const scrollBlockingEvents = ['wheel', 'mousewheel', 'touchstart', 'touchmove'];
    
    // Override addEventListener
    EventTarget.prototype.addEventListener = function(type, listener, options) {
        // Check if this is a scroll-blocking event
        if (scrollBlockingEvents.includes(type)) {
            // Normalize options
            let opts = options;
            
            if (typeof options === 'boolean') {
                opts = {
                    capture: options,
                    passive: true
                };
            } else if (typeof options === 'object' && options !== null) {
                opts = Object.assign({}, options, {
                    passive: options.passive !== undefined ? options.passive : true
                });
            } else {
                opts = {
                    passive: true
                };
            }
            
            // Call original with modified options
            return originalAddEventListener.call(this, type, listener, opts);
        }
        
        // For non-scroll-blocking events, use original behavior
        return originalAddEventListener.call(this, type, listener, options);
    };
    
    // Restore original addEventListener when needed
    window.restoreEventListener = function() {
        EventTarget.prototype.addEventListener = originalAddEventListener;
    };
    
    console.log('✅ Perfect Scrollbar passive event fix applied');
})();
