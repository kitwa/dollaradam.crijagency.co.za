(function ($) {
  $(function () {

    $('.sidenav').sidenav();

  }); // end of document ready
})(jQuery); // end of jQuery name space

// function model(){
//   $(document).ready(function(){
//     $('.modal').modal();
//   });

// }
$(document).ready(function () {
  $('.carousel').carousel({
    // shift: 50
  });
});

$('.carousel.carousel-slider').carousel({
  fullWidth: true,
  indicators:	true
});



$(document).ready(function(){
  $('.modal').modal();
});
   



document.addEventListener("DOMContentLoaded", function() {
  var enbaleNotificationsIcons = document.querySelectorAll('.enable-notifications');
  if('Notification' in window) {
  for(var i = 0; i < enbaleNotificationsIcons.length; i++){
    enbaleNotificationsIcons[i].style.display = 'inline-block';
    enbaleNotificationsIcons[i].addEventListener('click', permissionNotification);
  }
  }
});


function permissionNotification() {
  Notification.requestPermission(function(result){ 
    console.log('User Choice', result); 
    if(result !== 'granted'){

      console.log('says no');
    }else{
      //hide
      displayConfirmNotification();
    }
  })

  function displayConfirmNotification() {
    if('serviceWorker' in navigator){  
      var options = {
        body: 'welcome to ujisha notification systems.',
        icon: 'images/icons/icon-96x96.png',
        //dir: 'ltr',
        //lang: 'en-US',
        vibrate: [100, 50, 200],
        badge: 'images/icons/icon-96x96.png',
        tag: 'ujisha-notification-cofirmed',
        renotify: true,
        actions: [
          {action: 'confirm', title: 'Okay', icon:'images/icons/icon-96x96.png'},
          {action: 'cancel', title: 'Supprimer', icon:'images/icons/icon-96x96.png'}
        ]         
      }
      navigator.serviceWorker.ready
        .then(function(swreg){
          swreg.showNotification('suceesfully subscribed', options);
        });
    }

  }
}



