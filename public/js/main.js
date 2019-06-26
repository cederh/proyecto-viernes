// (function(){
    
    // Establecemos el tamaño de la ventana
    $(document).ready(function(){
       sleep(1500); 
       var first_mesagge = document.getElementById('first-message');
       first_mesagge.style.display = "inline-block";
    });
    // if (screen.width < 768) {
        var height = $(window).height();
        // var chat = document.getElementById("chat-container");
        // chat.height = height;
        $('#chat-container').height(height);
    // }

    // funcion para hacer una pausa en ms
    function sleep(milliseconds) {
        var start = new Date().getTime();
        for (var i = 0; i < 1e7; i++) {
            if ((new Date().getTime() - start) > milliseconds) {
                break;
            }
        }
    }

    function send_keyboard(e){
        var keyboard = (document.all) ? e.keyCode : e.which;
        if (keyboard == 13) {
            send();
        }
    }

    //  Función para enviar el mensaje
    function send() {

        // Obtenemos la fecha

        var today =  new Date();
        var time = document.createTextNode(today.getHours() + ':' + today.getMinutes());
        
        var message =  document.getElementById('message-form');
        // Accedemos al chat-list
        var message_list = document.getElementById('chat-message-list');
        // Creamos nuestro message-row
        var message_row = document.createElement('div');
        message_row.setAttribute('class', 'message-row you-message');

        var message_content = document.createElement('div');
        message_content.setAttribute('class', 'message-content');

        var message_text = document.createElement('div');
        message_text.setAttribute('class', 'message-text');

        var message_time = document.createElement('div');
        message_time.setAttribute('class', 'message-time');

        // Creamos un nodo de texto para mostrar en el chat
        var text = document.createTextNode(message.value);
        // preparamos el mensaje para enviarlo mediante AJAX
        var message_send = 'message='+message.value;

        message_text.appendChild(text);
        message_time.appendChild(time);
        message_content.appendChild(message_text);
        message_content.appendChild(message_time);
        message_row.appendChild(message_content);

        // Agregamos el nuevo mensaje
        message_list.appendChild(message_row);

        // Hacemos scroll en el message_list

        message_list.scrollTop = message_list.scrollHeight - message_list.clientHeight;

        // Limpiamos el input mensaje
        message.value = '';

        // Realizamos nuestra pericion AJAX
        var petition = new XMLHttpRequest();

        // petition.open('POST', 'http://192.168.0.101/proyecto-viernes/Conversation');
        petition.open('POST', 'http://localhost/proyecto-viernes/Conversation');
        // Establecemos el header de como queremos envier nuestra peticion
        petition.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        petition.onload = function(){

        var other_text = document.createTextNode(petition.responseText);
        
        // Creamos nuestro message-row

        var other_time = document.createTextNode(today.getHours() + ':' + today.getMinutes());
        
        var other_message =  document.getElementById('message-form');
        // Accedemos al chat-list
        var other_message_list = document.getElementById('chat-message-list');
        // Creamos nuestro message-row
        var other_message_row = document.createElement('div');
        other_message_row.setAttribute('class', 'message-row other-message');

        var other_message_content = document.createElement('div');
        other_message_content.setAttribute('class', 'message-content');

        var other_message_image = document.createElement('img');
        other_message_image.setAttribute("src", "img/viernes.png");

        var other_message_text = document.createElement('div');
        other_message_text.setAttribute('class', 'message-text');

        var other_message_time = document.createElement('div');
        other_message_time.setAttribute('class', 'message-time');

        other_message_text.appendChild(other_text);
        other_message_time.appendChild(other_time);
        other_message_content.appendChild(other_message_image);
        other_message_content.appendChild(other_message_text);
        other_message_content.appendChild(other_message_time);
        other_message_row.appendChild(other_message_content);

        sleep(1000);

        // Agregamos el nuevo mensaje
        other_message_list.appendChild(other_message_row);

        // Hacemos scroll en el message_list
        message_list.scrollTop = message_list.scrollHeight - message_list.clientHeight;
        }

        petition.send(message_send);


    }

    function load_history(){
        // Realizamos nuestra pericion AJAX
        var petition = new XMLHttpRequest();

        // petition.open('POST', 'http://192.168.0.101/proyecto-viernes/Conversation/history');
        petition.open('POST', 'http://localhost/proyecto-viernes/Conversation/history');

        petition.send();

        petition.onload = function(){
            var history = (petition.responseText);
            var chat_list = document.getElementById('chat-message-list');

            chat_list.innerHTML = history;



        }
    }

    

    
// }())