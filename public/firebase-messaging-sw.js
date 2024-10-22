importScripts('https://www.gstatic.com/firebasejs/10.3.1/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/10.3.1/firebase-messaging-compat.js');

/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
*/
firebase.initializeApp({
    apiKey: "AIzaSyCV40NBKT5wBipNfY3Lmmd7KyPdOcD7vfA",
    authDomain: "laravel-chat-7638b.firebaseapp.com",
    databaseURL: "https://laravel-chat-7638b-default-rtdb.firebaseio.com",
    projectId: "laravel-chat-7638b",
    storageBucket: "laravel-chat-7638b.appspot.com",
    messagingSenderId: "355479155427",
    appId: "1:355479155427:web:75bf251a49566a0bcc8bd6"
});


// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();


// self.addEventListener('install', (event) => {
//     event.waitUntil(self.skipWaiting());
// });

// self.addEventListener('activate', (event) => {
//     event.waitUntil(self.clients.claim());
// });

// messaging.setBackgroundMessageHandler(function (payload) {
//     console.log("Message received.", payload);

//     const title = "Hello world is awesome";
//     const options = {
//         body: "Your notificaiton message .",
//         icon: "/firebase-logo.png",
//     };

//     return self.registration.showNotification(
//         title,
//         options,
//     );
// });

// Give the service worker access to Firebase Messaging.
// Note that you can only use Firebase Messaging here, other Firebase libraries
// are not available in the service worker.
// importScripts('https://www.gstatic.com/firebasejs/10.3.1/firebase-app.js');
// importScripts('https://www.gstatic.com/firebasejs/10.3.1/firebase-messaging.js');

// // Initialize the Firebase app in the service worker by passing in
// // your app's Firebase config object.
// // https://firebase.google.com/docs/web/setup#config-object
// var firebaseConfig = {
//     apiKey: "AIzaSyCV40NBKT5wBipNfY3Lmmd7KyPdOcD7vfA",
//     authDomain: "laravel-chat-7638b.firebaseapp.com",
//     projectId: "laravel-chat-7638b",
//     storageBucket: "laravel-chat-7638b.appspot.com",
//     messagingSenderId: "355479155427",
//     appId: "1:355479155427:web:75bf251a49566a0bcc8bd6"
// };

// // Initialize Firebase
// firebase.initializeApp(firebaseConfig);


// const messaging = firebase.messaging();
// messaging.setBackgroundMessageHandler(function (payload) {
//     console.log("Message received.", payload);

//     const title = "Hello world is awesome";
//     const options = {
//         body: "Your notificaiton message .",
//         icon: "/firebase-logo.png",
//     };

//     return self.registration.showNotification(
//         title,
//         options,
//     );
// });


// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
// const messaging = firebase.messaging();

// messaging.setBackgroundMessageHandler(function(payload) {
//     console.log('[firebase-messaging-sw.js] Received background message ', payload);
//     // Customize notification here
//     const {title, body} = payload.notification;
//     const notificationOptions = {
//         body,
//     };

//     return self.registration.showNotification(title,
//         notificationOptions);
// });
