/**
 * Created by TT on 2/20/2015.
 */
$(document).ready(function(){
    $("#signInBtn").on("click",function(){
        $.ajax({
            type:"PUT",
            dataType:"json",
            data:$("#forgot-form").serialize()+"&api_key="+publicKey,
            url:"/api/users/forgot",
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