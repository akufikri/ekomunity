// Your web app's Firebase configuration
const firebaseConfig = {
    apiKey: "AIzaSyAtaC_WTOAw-xK0eyFaJ3UlMIZhLt9aQyY",
    authDomain: "datappk.firebaseapp.com",
    projectId: "datappk",
    storageBucket: "datappk.appspot.com",
    messagingSenderId: "14733152780",
    appId: "1:14733152780:web:bafb8bdc2d1e381e291429",
    measurementId: "G-2Z3W5XVW5Q"
  };
// Initialize Firebase
firebase.initializeApp(firebaseConfig);

const messaging = firebase.messaging();

function initFirebaseMessagingRegistration() {
    
    messaging.requestPermission().then(function () {
        return messaging.getToken()
    }).then(function(token) {
    
        console.log(token)
        $("input[name=fcm_token]").val(token)


    }).catch(function (err) {
        console.log('Token Error :: '+err);
    });
    
}

initFirebaseMessagingRegistration();

messaging.onMessage(function(payload){
    
    console.log('Message received. ', payload);
    
    Swal.fire({
      position: "top-end",
      icon: "info",
      title: payload.notification.title,
      text: payload.notification.body,
      showConfirmButton: false,
      timer: 3500
    });

});