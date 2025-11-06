// Service Worker - DISABLED MODE
console.log('SW: Loaded in disabled mode');

self.addEventListener('install', (e) => {
    console.log('SW: Install - skipping');
    self.skipWaiting();
});

self.addEventListener('activate', (e) => {
    console.log('SW: Activate - clearing caches');
    e.waitUntil(
        caches.keys().then(keys => 
            Promise.all(keys.map(k => caches.delete(k)))
        ).then(() => self.registration.unregister())
    );
});

self.addEventListener('fetch', () => {});
