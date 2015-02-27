/**
 * Created by TT on 2/20/2015.
 */
$(document).ready(function(){
    $("#signInBtn").on("click",function(){
        $.ajax({
            type:"POST",
            dataType:"json",
            data:$("#login-form").serialize()+"&api_key="+publicKey,
            url:"/api/users/login",
            success:function(resp) {
                if ( resp.redirect !== undefined ) {
                    window.location.href = resp.redirect;
                }
                if ( resp.message ) {
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