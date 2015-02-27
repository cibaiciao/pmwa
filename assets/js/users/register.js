/**
 * Created by TT on 2/20/2015.
 */
$(document).ready(function(){
    $("#registerBtn").on("click",function(){
        $.ajax({
            type:"POST",
            dataType:"json",
            data:$("#register-form").serialize()+"&api_key="+publicKey,
            url:"/api/users/register",
            success:function(resp) {
                if ( resp.redirect !== undefined ) {
                    window.location.href = resp.redirect;
                }
                if ( resp.message !== undefined ) {
                    $("#global-msg").text(resp.message).removeClass().addClass("alert alert-"+resp.type);
                }

            },
            error:function(resp) {
                if ( resp ) {
                    var responseJSON = resp.responseJSON;
                    $("#global-msg").text(responseJSON.message).removeClass().addClass("alert alert-"+responseJSON.type);
                }
            }
        });
    });
});