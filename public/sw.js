const CACHE_NAME = "berita-desa-v1";
const URLS_TO_CACHE = [
    "/",
    "/assets/logo/Logo_Kabupaten_Malang.png",
    "/assets/css/app.css",
    "/assets/js/app.js",
    "/offline.html",
];

self.addEventListener("install", (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            return cache.addAll(URLS_TO_CACHE);
        })
    );
    self.skipWaiting();
});

self.addEventListener("activate", (event) => {
    event.waitUntil(
        caches.keys().then((cacheNames) =>
            Promise.all(
                cacheNames.map((cacheName) => {
                    if (cacheName !== CACHE_NAME) {
                        return caches.delete(cacheName);
                    }
                })
            )
        )
    );
    return self.clients.claim();
});

self.addEventListener("fetch", (event) => {
    if (event.request.method !== "GET") return;

    event.respondWith(
        caches.match(event.request).then((cachedResponse) => {
            return (
                cachedResponse ||
                fetch(event.request)
                    .then((response) => {
                        if (
                            response.status === 200 &&
                            event.request.url.startsWith(location.origin)
                        ) {
                            const responseClone = response.clone();
                            caches.open(CACHE_NAME).then((cache) => {
                                cache.put(event.request, responseClone);
                            });
                        }
                        return response;
                    })
                    .catch(() => {
                        if (event.request.destination === "document") {
                            return caches.match("/offline.html");
                        }
                    })
            );
        })
    );
});
