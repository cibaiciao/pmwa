$(document).ready(function(){
    $("#changeBtn").on("click",function(){
        $.ajax({
            type:"PUT",
            data:$("#info-form").serialize()+"&api_key="+publicKey,
            dataType:"json",
            url:"/api/users/password",
            success:function(resp) {
                if ( resp.message ) {
                    $("#password-msg").text(resp.message).removeClass().addClass("alert alert-"+resp.type);
                }
                $("#current_password,#new_password,#new_password_confirm").val("");
            },
            error:function(resp) {
                if ( resp ) {
                    var responseJSON = resp.responseJSON;
                    $("#password-msg").text(responseJSON.message).removeClass().addClass("alert alert-"+responseJSON.type);
                }
            },
            complete:function() {

            }


        });
    });
});