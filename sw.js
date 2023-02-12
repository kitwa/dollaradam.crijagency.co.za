
// var CACHE_STATIC_CONTENT = 'staticContent 1.3';
// var CACHE_DYNAMIC_CONTENT = 'dynamicContent 1.3';
// self.addEventListener('install', function(event) {
//     console.log('[service worker] Installing ...', event);
//     event.waitUntil(
//         caches.open(CACHE_STATIC_CONTENT)
//             .then(function(cache){
//                 cache.addAll(['/', 'index.php', 'search.php', 'publier.php', 'home.php', 'articles.php', 'signin.php', 'signup.php', 'offline.html']);

//                 // cache.add('/');
//                 // cache.add('index.php');
//                 // cache.add('search.php');
//                 // cache.add('publier.php');
//             })
//     )
    
// });

// self.addEventListener('activate', function(event) {
//     console.log('[service worker] activating ...', event);
//     event.waitUntil(
//         caches.keys()
//             .then(function(keyList){
//                 return Promise.all(keyList.map(function(key){
//                     if(key !== CACHE_STATIC_CONTENT && key !== CACHE_DYNAMIC_CONTENT){
//                         console.log('removeoooooooooooo', key);
//                         return caches.delete(key);
//                     }
//                 }));
//             })
//     );
//     return self.clients.claim();    
// });

// self.addEventListener('fetch', function(event){
//     console.log('[Service worker] fetching...', event);
//     event.respondWith(
//         caches.match(event.request)    
//             .then(function(response){
//                 console.log(response);
//                 if(response){                
//                     return response;
//                 }else {
//                     return fetch(event.request)
//                     .then(function(res){
//                        return caches.open(CACHE_DYNAMIC_CONTENT)
//                             .then(function(cache){
//                                 cache.put(event.request.url, res.clone());
//                                 return res;
//                             })
//                     })
//                     .catch(function(err){
//                         return caches.open(CACHE_STATIC_CONTENT)
//                             .then(function(cache){
//                                return cache.match('offline.html'); 
//                             })
//                     }); 
//                 }
//             })
//     );
//     // event.respondWith(fetch(event.request));
// })

// self.addEventListener('notificationclick', function(event){
//     var notification = event.notification;
//     var action = event.action;
//     if(action === 'confirm'){
//         console.log('confirm chosen');
//         notification.close();
//     }else{
//         console.log(action);
//         notification.close(); 
//     }
// });

// self.addEventListener('notificationclose', function(event){
//     console.log('notification was closed', event);
// })