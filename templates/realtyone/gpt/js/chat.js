window.addEventListener("resize", resizeChatBody)

$("#pop-up-message").click(function() {
  $(this).addClass("hidden");
  $(this).css("display", "none")
  $("#chat-container").addClass("visible");
  $("#chat-container").removeAttr("style");
  window.parent.postMessage("resize", "*");

  setTimeout(() => {
    var c = $("#messages-window").prop("scrollHeight");
    $("#messages-window").scrollTop(c);
  }, 300);

});

function resizeChatBody() {
  var e = window.innerHeight - (document.getElementById("topbar").offsetHeight + document.getElementById("userInputForm").offsetHeight + 25);
  t = document.getElementById("messages-window");
  t.style.height = e + "px", t.style.maxHeight = e + "px"
}

$("#topbar-close").click(function() {
  $("#body-main").removeClass("chat-window-active");
  $("#pop-up-message").removeClass("hidden");
  $("#pop-up-message").removeAttr("style");
  $("#chat-container").css("display", "none");
  $("#chat-container").addClass("hidden");
  window.parent.postMessage("close", "*");
});

$("#emoji").click(function() {
  $("#emojis-popup").addClass("visible");
});

// Hide emoji-popup when click in chat
$("#topbar, #messages-window").click(function() {
  if ($("#emojis-popup").hasClass("visible")) {
    $("#emojis-popup").removeClass("visible");
  }
});

//Input user
$("#send").click(function() {
  enviar_mensaje();
});

$("#user-input").on("keydown", function(event) {
  if(event.which == 13) enviar_mensaje();
});

//Click in emoji
$("#emojis-popup").click(function(e) {
  var emoji = $(e.target).data("emoji");
  $("#emojis-popup").removeClass("visible");
  var message = $('input[type="text"]').val() + emoji;
  $('input[type="text"]').val(message);
});

function enviar_mensaje() {

  if (window.enviando_mensaje == 1) return false;

  window.enviando_mensaje = 1;

  var message = $('#user-input').val();
  if (message == '') return false;

  fetch('https://chatserver.varcreative.com/web_message', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({
      "id": 0,
      "id_user": localStorage.getItem("id"),
      "text": message,
      "direction": 1,
      "type": "text",
      "type_id": 1,    
      "timestamp": moment().unix(),   
    }),
  })
  .then((response) => response.json())
  .then((r) => {
    window.enviando_mensaje = 0;
    $("#append-messages").append("<div class='message-body'><div class='chatbox-message-container message-visitor right'><div class='msg-header'><div class='name'>Tú</div></div><div class='chatbox-element'><div class='text-message'><p>" + message + "</p></div></div></div></div>");
    
    let messages = (localStorage.getItem("messages") == null) ? "" : localStorage.getItem("messages");
    messages += "<div class='message-body'><div class='chatbox-message-container message-visitor right'><div class='msg-header'><div class='name'>Tú</div></div><div class='chatbox-element'><div class='text-message'><p>" + message + "</p></div></div></div></div>";
    localStorage.setItem('messages', messages);

    setTimeout(() => {
      var c = $("#messages-window").prop("scrollHeight");
      $("#messages-window").scrollTop(c);
    }, 300);

    $('#user-input').val('');
  })
  .catch((err) => {
    window.enviando_mensaje = 0;
    alert ("Hubo un error. Intente nuevamente en unos minutos.");
  });

}


$(document).ready(function(e){

  console.log("llega");
  console.log(localStorage.getItem("id"));

  if (localStorage.getItem("id") !== null && localStorage.getItem("id") !== undefined) {


    if (localStorage.getItem("messages") !== null) {
      $(".message-body").html(localStorage.getItem("messages"));

    } else {
      localStorage.setItem("messages", "<div class='message-body'><div class='chatbox-message-container left'><div class='msg-header'><div class='name'>Juan</div></div><div class='chatbox-element'><div class='text-message'><p>¡Hola! Soy Juan, ¿En que puedo ayudarte?</p></div></div></div></div>")
    }

    $(".register-user-window").toggleClass("dn");
    $(".main-message-text").toggleClass("dn");    
    $(".change_user_name").html(localStorage.getItem("name"));    
  }


  $(".register-user-window button").click(function(e){

    $(e.currentTarget).prop('disabled', true);

    $(".register-user-window input").removeClass("error");
    var name = $("#register-user-name").val();
    var phone = $("#register-user-phone").val();

    if (name == "" || name == 0) {
      $(e.currentTarget).prop('disabled', false);
      $("#register-user-name").addClass("error");
      $("#register-user-name").focus();
      return false;
    }

    if (phone == "" || phone == 0) {
      $(e.currentTarget).prop('disabled', false);
      $("#register-user-phone").addClass("error");
      $("#register-user-phone").focus();
      return false;
    }

    fetch('https://chatserver.varcreative.com/contacts', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        "id": 0,
        "name": name,
        "telephone": phone,
        "origin": "web",            
      }),
    })
    .then((response) => response.json())
    .then((r) => {
      localStorage.setItem('id', r.id);
      localStorage.setItem('name', name);
      $(".register-user-window").toggleClass("dn");
      $(".main-message-text").toggleClass("dn");
    })
    .catch((err) => {
      $(e.currentTarget).prop('disabled', false);
      alert ("Hubo un error. Intente nuevamente en unos minutos.");
    });

  });
  // Create the main socket
  window.socket = io("https://chatserver.varcreative.com");

  window.socket.on('receive_message', (msg)=>{
    if (localStorage.getItem("id") == msg.id_user) {
      $("#append-messages").append("<div class='message-body'><div class='chatbox-message-container left'><div class='msg-header'><div class='name'>Juan</div></div><div class='chatbox-element'><div class='text-message'><p>" + msg.original_text + "</p></div></div></div></div>");
    
      let messages = (localStorage.getItem("messages") == null) ? "" : localStorage.getItem("messages");
      messages += "<div class='message-body'><div class='chatbox-message-container left'><div class='msg-header'><div class='name'>Juan</div></div><div class='chatbox-element'><div class='text-message'><p>" + msg.original_text + "</p></div></div></div></div>";
      localStorage.setItem('messages', messages);

      setTimeout(() => {
        var c = $("#messages-window").prop("scrollHeight");
        $("#messages-window").scrollTop(c);
      }, 300);
    }
  });

});

