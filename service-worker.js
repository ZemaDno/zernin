const CACHE_NAME = 'site-cache-v1';
const urlsToCache = [
  '/',
  '/index.html',
  '/supercomputers.html',
  '/modern.html',
  '/forma1.php',
  '/styles.css',
  '/1_1.jpg',
  '/1_2.jpg',
  '/1_3.jpg',
  '/2_1.jpg',
  '/2_2.jpg',
  '/2_3.jpg',
  '/3_1.jpg',
  '/3_2.jpg',
  '/3_3.jpg'
];

self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(cache => cache.addAll(urlsToCache))
  );
});

self.addEventListener('fetch', event => {
  event.respondWith(
    caches.match(event.request)
      .then(response => response || fetch(event.request))
  );
});