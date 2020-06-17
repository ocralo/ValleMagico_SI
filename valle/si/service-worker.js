console.log('Hello from service-worker.js');

importScripts('https://storage.googleapis.com/workbox-cdn/releases/4.3.1/workbox-sw.js');


// Precarga la app
self.__precacheManifest = [].concat(self.__precacheManifest || [])

// //Eliminar los warnings
// workbox.precaching.suppressWarnings()
// //Toma el precatch manifest (js, css, indext.html) y los va a guardar detrás de escena.
// workbox.precaching.precacheAndRoute(self.__precacheManifest, {})


workbox.core.setCacheNameDetails({
    prefix: 'Valle-magico-Cache',
    suffix: 'v1',
    precache: 'precache-cache',
    runtime: 'runtime-cache'
});


const staticCache = 'my-cache-static-v1'
const dynamicCache = 'my-cache-dynamic-v1'

workbox.core.setCacheNameDetails({
    precache: staticCache,
    runtime: dynamicCache
});
workbox.core.cacheNames.precache

console.log(workbox.core.cacheNames.precache)

workbox.routing.registerRoute(
    /\.(?:js|css)$/,// Todos los archivos con extensión js o css
    workbox.strategies.cacheFirst({
        cacheName: workbox.core.cacheNames.precache, // nombre de la cache donde queremos guardar el recurso
    })
);

workbox.routing.registerRoute(
    /^http?.*/,
    workbox.strategies.staleWhileRevalidate()
);
