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

  $("#append-messages").append("<div class='message-body'><div class='chatbox-message-container message-visitor right'><div class='msg-header'><div class='name'>Tú</div></div><div class='chatbox-element'><div class='text-message'><p>" + message + "</p></div></div></div></div>");
  $('#user-input').val('');

  const response = fetch('https://chatgpt.varcreative.com.ar/api/get_result', { 
    method: 'POST', 
    headers: { 'Content-Type': 'application/json' }, 
    body: JSON.stringify({"prompt": message}) 
  })
  .then((response) => response.json())
  .then((data) => {

    window.enviando_mensaje = 0;
    
    if (Array.isArray(data.result)) {
      // Es un Array
      for(let i = 0; i < data.result.length; i++) {
        let d = data.result[i];
        if (typeof d === 'object') {
          console.log(d);
          if (typeof d.nombre != "undefined") {
            $("#append-messages").append("<div class='message-body'><div class='chatbox-message-container message-robot left'><div class='msg-header'><div class='name'>Tú</div></div><div class='chatbox-element'><div class='text-message'><p>" + d + "</p></div></div></div></div>");  
          }
        } else if (typeof d === 'string') {
          $("#append-messages").append("<div class='message-body'><div class='chatbox-message-container message-robot left'><div class='msg-header'><div class='name'>Tú</div></div><div class='chatbox-element'><div class='text-message'><p>" + d + "</p></div></div></div></div>");  
        }
      }
    } else {
      // Es un String
      var d = String(data.result);
      $("#append-messages").append("<div class='message-body'><div class='chatbox-message-container message-robot left'><div class='msg-header'><div class='name'>Tú</div></div><div class='chatbox-element'><div class='text-message'><p>" + d + "</p></div></div></div></div>");
    }

    setTimeout(() => {
      var c = $("#messages-window").prop("scrollHeight");
      $("#messages-window").scrollTop(c);
    }, 300);

  });
}


$(document).ready(function(e){

  if (localStorage.getItem("id") !== null && localStorage.getItem("id") !== undefined) {

    /*
    if (localStorage.getItem("messages") !== null) {
      $(".message-body").html(localStorage.getItem("messages"));

    } else {
      localStorage.setItem("messages", "<div class='message-body'><div class='chatbox-message-container left'><div class='msg-header'><div class='name'>Juan</div></div><div class='chatbox-element'><div class='text-message'><p>¡Hola! Soy Juan, ¿En que puedo ayudarte?</p></div></div></div></div>")
    }
    */

    $(".change_user_name").html(localStorage.getItem("name"));    
  }


});