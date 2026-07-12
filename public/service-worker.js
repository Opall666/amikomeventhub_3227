const CACHE_NAME = 'amikom-event-v1';
const ASSETS_TO_CACHE = [
    '/',
    '/images/icons/icon-192x192.png',
    '/images/icons/icon-512x512.png',
    'https://cdn.tailwindcss.com',
    'https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap',
    'https://fonts.gstatic.com'
];

// 1. Install Event: Simpan aset ke cache saat pertama kali dibuka
self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME).then(cache => {
            return cache.addAll(ASSETS_TO_CACHE);
        })
    );
});

// 2. Activate Event: Hapus cache lama jika ada versi baru
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames
                    .filter(name => name !== CACHE_NAME)
                    .map(name => caches.delete(name))
            );
        })
    );
});

// 3. Fetch Event: Sajikan dari cache jika offline, atau ambil dari internet jika online
self.addEventListener('fetch', event => {
    event.respondWith(
        caches.match(event.request).then(response => {
            return response || fetch(event.request);
        })
    );
});