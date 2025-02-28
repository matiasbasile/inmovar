if (window.addEventListener) {
    window.addEventListener("message", onMessage, false);
}

// Resize iframe
function onMessage(event) {
    var iframe = window.document.getElementById('chatIframe');
    if (event.data.includes("resize")) {
        iframe.className = "expanded-height";
        document.body.classList.add("chat-window-active");
    } else if (event.data.includes("close")) {
        iframe.className = "collapsed-height";
        document.body.classList.remove("chat-window-active");
    }
}

// Append iframe dinamyc
function init() {
    var iframe = document.createElement('iframe');
    iframe.src = "chat.php?domain=" + window.location.hostname;
    iframe.id = "chatIframe";
    iframe.allowFullscreen = true;
    iframe.title = "Chat web";
    iframe.className = "collapsed-height";
    iframe.style = "z-index: 1999999; background-color: transparent; border: none; width: 82px; height: 86px; max-width: 370px; position: fixed; right: 10px; bottom: 20px;"
    document.body.appendChild(iframe);


    //Add style file to import iframe classes
    var link = document.createElement("link");
    link.href = "css/iframe.css";
    link.type = "text/css";
    link.rel = "stylesheet";
    link.media = "screen,print";

    document.head.appendChild(link);
}
init();