require("./bootstrap");


var chat = document.getElementById('chat-messages');
var chat_user = 0;
function render_sended(msg)
{
    return `
    <div class="chat-message-right pb-4">
        <div>
            <img src="https://bootdey.com/img/Content/avatar/avatar1.png"
                class="rounded-circle mr-1" alt="Chris Wood" width="40" height="40">
            <div class="text-muted small text-nowrap mt-2">2:33 am</div>
        </div>
        <div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3">
            <div class="font-weight-bold mb-1">You</div>
            ${msg['message']}
        </div>
    </div>
    `;
}

function render_recived(msg)
{
    return `
    <div class="chat-message-left pb-4">
        <div>
            <img src="https://bootdey.com/img/Content/avatar/avatar3.png"
                class="rounded-circle mr-1" alt="Sharon Lessman" width="40"
                height="40">
            <div class="text-muted small text-nowrap mt-2">2:34 am</div>
        </div>
        <div class="flex-shrink-1 bg-light rounded py-2 px-3 ml-3">
            <div class="font-weight-bold mb-1">User</div>
            ${msg['message']}
        </div>
    </div>
    `;
}
function append_message(msg){
    if(msg['mfrom'] == me)
    {
        chat.innerHTML += render_sended(msg);
    }else{
        chat.innerHTML += render_recived(msg);
    }
}
function message_recived(msg)
{
    console.log("mesage_received");
    console.log(msg['mfrom'] == chat_user);
    if(msg['mfrom'] == me)
    {
        if(msg["mto"] == chat_user)
        {
            append_message(msg);
        }
    }else{
        if(msg['mfrom'] == chat_user)
        {
            append_message(msg);
        }
    }
}

$(document).ready(function() {
    $(".users").click(function() {
        var uid = $(this).data("user");
        $.get("/user/" + uid, function(data, status) {
            chat_user = data.user.id;
            $("#chat_user").html(data.user.name);
        });
    });
    $("#msg_send").click(function(){
        var msg = $("#msg").val();
        $.post("/send", {id:chat_user, message:msg}, function(data) {
            console.log(data);
            message_recived(data);
        });
    });
});

window.Echo.private(chanal).listen(".message", (e) => {
    console.log(e);
    message_recived(e['message']);
});
console.log(window.Echo.private(chanal));