importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');

firebase.initializeApp({
    apiKey: "AIzaSyAtaC_WTOAw-xK0eyFaJ3UlMIZhLt9aQyY",
    projectId: "datappk",
    messagingSenderId: "14733152780",
    appId: "1:14733152780:web:bafb8bdc2d1e381e291429"
});
  
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function({data:{title,body,icon}}) {
    return self.registration.showNotification(title,{body,icon});
});