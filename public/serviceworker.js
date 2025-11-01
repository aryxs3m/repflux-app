var staticCacheName = "pwa-v" + new Date().getTime();
var filesToCache = [
    '/offline',
    '/favicon.ico',
    '/logos/pwa.png',
    '/logos/logo-white-blur.png',
    '/logos/repflux_logo_transparent.png',
    '/fonts/filament/filament/inter/index.css?v=4.1.10.0',
    '/css/filament/filament/app.css?v=4.1.10.0',
    '/js/filament/actions/actions.js?v=4.1.10.0',
    '/js/filament/notifications/notifications.js?v=4.1.10.0',
    '/js/filament/schemas/schemas.js?v=4.1.10.0',
    '/js/filament/support/support.js?v=4.1.10.0',
    '/js/filament/tables/tables.js?v=4.1.10.0',
    '/js/filament/filament/echo.js?v=4.1.10.0',
    '/js/filament/forms/components/markdown-editor.js?v=4.1.10.0',
    '/js/filament/widgets/components/chart.js?v=4.1.10.0',
    '/js/app/components/apexcharts.js?v=4.1.10.0',
];

// Cache on install
self.addEventListener("install", event => {
    this.skipWaiting();
    event.waitUntil(
        caches.open(staticCacheName)
            .then(cache => {
                return cache.addAll(filesToCache);
            })
    )
});

// Clear cache on activate
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames
                    .filter(cacheName => (cacheName.startsWith("pwa-")))
                    .filter(cacheName => (cacheName !== staticCacheName))
                    .map(cacheName => caches.delete(cacheName))
            );
        })
    );
});

// Serve from Cache
self.addEventListener("fetch", event => {
    event.respondWith(
        caches.match(event.request)
            .then(response => {
                return response || fetch(event.request);
            })
            .catch(() => {
                return caches.match('offline');
            })
    )
});
