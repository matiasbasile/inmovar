<?php 
// TODO: include config file
$domain = $_GET["domain"];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <base href="/templates/lacomunidad/gpt/"/>
    <meta charset="utf-8">    
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.5.0.js"></script>   
</head>

<body id="bodyIframe" style="display: block;">
  <div id="widget">
    <div id="converse-chat" class="widget">
      <div id="pop-up-message" class="pop-up" style="">
        <div id="pop-up-message-circle" class="pop-up-circle centerelement bubble">
          <div id="container-style" class="container-style">
            <p id="pop-up-message-icon" class="pop-up-icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="50" height="64" fill="white" class="icon" viewBox="0 0 16 16">
                <path d="M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                <path d="m2.165 15.803.02-.004c1.83-.363 2.948-.842 3.468-1.105A9.06 9.06 0 0 0 8 15c4.418 0 8-3.134 8-7s-3.582-7-8-7-8 3.134-8 7c0 1.76.743 3.37 1.97 4.6a10.437 10.437 0 0 1-.524 2.318l-.003.011a10.722 10.722 0 0 1-.244.637c-.079.186.074.394.273.362a21.673 21.673 0 0 0 .693-.125zm.8-3.108a1 1 0 0 0-.287-.801C1.618 10.83 1 9.468 1 8c0-3.192 3.004-6 7-6s7 2.808 7 6c0 3.193-3.004 6-7 6a8.06 8.06 0 0 1-2.088-.272 1 1 0 0 0-.711.074c-.387.196-1.24.57-2.634.893a10.97 10.97 0 0 0 .398-2z"/>
              </svg>
            </p>
          </div>
          <div class="unread-msgs">
              <a href="#">0</a>
          </div>
        </div>
      </div>
      <div id="chat-container" class="chat-container" style="display: none;">
        <div class="chat-window">
          <div class="main-message-text">
            <div class="topbar" id="topbar">
              <div>
                <div class="topbar-title-container">
                  <div class="topbar-text">
                    <div class="topbar-title">Juan</div>
                      <div class="topbar-subtitle">
                        <div><span class="icon-status online"></span> Disponible ahora </div>
                      </div>
                    </div>
                  </div>
                  <div id="topbar-close" class="topbar-close">
                    <svg xmlns="http://www.w3.org/2000/svg" id="chat-window-close" width="32" height="32" fill="currentColor" class="bi bi-x icon-cancelar" viewBox="0 0 16 16">
                      <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                    </svg>
                  </div>
                </div>
              </div>
              <div>



              <div id="messages-window" class="messages-window">
                <div class="chatbox-body">
                  <div id="append-messages">
                    <div class="message-body">
                      <div class="chatbox-message-container message-robot left">
                        <div class="msg-header"><div class="name">Juan</div></div>
                        <div class="chatbox-element">
                          <div class="text-message"><p>¡Hola! Soy Juan, ¿En que puedo ayudarte?</p></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="footer chat-input">
                <form id="userInputForm" name="userInputForm" novalidate="novalidate" onsubmit="return false;">
                  <div class="input-container input-height">
                    <input type="text" name="message" id="user-input" required="required" placeholder="Escribe un mensaje..." data-emoji-picker="true" autocomplete="off">
                    <span class="input-box"></span>
                    <span title="Insertar Emoji" id="emoji" class="icon-emoticons emojis-button-insert">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-emoji-smile" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path d="M4.285 9.567a.5.5 0 0 1 .683.183A3.498 3.498 0 0 0 8 11.5a3.498 3.498 0 0 0 3.032-1.75.5.5 0 1 1 .866.5A4.498 4.498 0 0 1 8 12.5a4.498 4.498 0 0 1-3.898-2.25.5.5 0 0 1 .183-.683zM7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5zm4 0c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5z"/>
                      </svg>
                    </span>
                    <span title="Enviar" class="send-message-button">
                      <button type="submit" value="Enviar" id="send">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-send" viewBox="0 0 16 16">
                          <path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z"/>
                        </svg>
                      </button>
                    </span>
                  </div>
                  <div class="credits"><a target="_blank" class="powered-by"><span>Varcreative</span><!-- logo --></a></div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <div id="emojis-popup" class="chat-emojis-popup"><?php include "includes/emojis.php" ?>/div>
      </div>
    </div>
  </div>   
  <script src="js/moment.js"></script>
  <script src="js/chatgpt.js?v=<?php echo date("YmdHis") ?>"></script>
  <script src="https://chatserver.varcreative.com/socket.io/socket.io.js"></script>
</body>

</html>