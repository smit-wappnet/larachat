require("./bootstrap");


var chat = document.getElementById('chat-messages');
var chat_user = 0;
var message_send_id = 0;
function render_sended(msg) {
    return `
    <div class="chat-message-right pb-4" id="${msg['tid']}">
        <div>
            <img src="https://bootdey.com/img/Content/avatar/avatar1.png"
                class="rounded-circle mr-1" alt="Chris Wood" width="40" height="40">
            <div class="text-muted small text-nowrap mt-2">2:33 am</div>
        </div>
        <div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3">
            <div class="font-weight-bold mb-1">You</div>
            ${msg['message']}
        </div>
        <div class='d-flex align-items-end p-2'>
            <i class="bi bi-check ${(msg['tid']? 'text-warning' :'text-success')} status_check"></i>
        </div>
    </div>
    `;
}

function render_recived(msg) {
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
function append_message(msg) {
    if (msg['mfrom'] == me || msg['tid'] !== undefined) {
        chat.innerHTML += render_sended(msg);
    } else {
        chat.innerHTML += render_recived(msg);
    }
}
function message_recived(msg) {
    if (msg['mfrom'] == me || msg['tid'] !== undefined) {
        console.log("Sended msg");
        if (msg["mto"] == chat_user) {
            append_message(msg);
        }
    } else {
        if (msg['mfrom'] == chat_user) {
            append_message(msg);
        }
    }
}

$(document).ready(function () {
    var uid = $(".users").first().data("user");
    $.get("/user/" + uid, function (data, status) {
        chat_user = data.user.id;
        $("#chat-messages").html("");
        $("#chat_user").html(data.user.name);
        data.messages.forEach(message => {
            console.log(message);
            append_message(message);
        });
    });
    $(".users").click(function () {
        var uid = $(this).data("user");
        $("#chat-messages").html("");
        $.get("/user/" + uid, function (data, status) {
            chat_user = data.user.id;
            $("#chat_user").html(data.user.name);
            data.messages.forEach(message => {
                console.log(message);
            });
        });
    });
    $("#msg_send").click(function () {
        if (chat_user == 0) {
            alert("Select Any User to Chat");
            return;
        }
        var msg = $("#msg").val();
        var post_data = { mto: chat_user, message: msg, tid: 'tid_' + message_send_id };
        message_send_id += 1;
        $.ajax({
            url: '/send',
            method: 'POST',
            data: post_data,
            beforeSend: function () {
                message_recived(post_data);
            },
            success: function (data) {
                var tid = data['tid'];
                $("#" + tid).attr("id", "msg_" + data['id']);
                $("#msg_" + data['id']).find(".status_check").removeClass('text-warning').addClass('text-success');
            },
            error: function () {
                $("#" + tid).find(".status_check").removeClass('text-warning').addClass('text-success');
            }
        });
    });
});

window.Echo.private(chanal).listen(".message", (e) => {
    console.log(e);
    message_recived(e['message']);
});
console.log(window.Echo.private(chanal));