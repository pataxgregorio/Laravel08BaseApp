var staticCacheName = "pwa-v" + new Date().getTime();
var filesToCache = [
    '/css/app.css',
    '/css/bootstrap.min.css',
    '/css/all-landing.css',
    '/css_datatable/bootstrap.min.css',
    '/css_bootstrap/bootstrap-theme.min.css',
    '/css_datatable/responsive.bootstrap.min.css',    
    '/banderas/us.png',
    '/banderas/es.png',    
    '/intro-img.svg',
    '/js_datatable/jquery-3.5.1.js',
    '/js_bootstrap/bootstrap.min.js',
    '/js_delete/sweetalert.min.js',
    '/indexdDB/indexdDB.min.js',
    '/manifest.json',
    '/js/app.js',
    '/images/icons/icon-72x72.png',
    '/images/icons/icon-96x96.png',
    '/images/icons/icon-128x128.png',
    '/images/icons/icon-144x144.png',
    '/images/icons/icon-152x152.png',
    '/images/icons/icon-192x192.png',
    '/images/icons/icon-384x384.png',
    '/images/icons/icon-512x512.png',    
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