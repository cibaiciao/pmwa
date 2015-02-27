/**
 * Created by TT on 2/20/2015.
 */
$(document).ready(function(){

    $.ajax({
        type:"GET",
        dataType:"json",
        data:"api_key="+publicKey,
        url:"/api/teams/index",
        success:function(resp) {
            $("#teams").html(resp.data);
        },
        error:function(resp) {
            if ( resp ) {
                var responseJSON = resp.responseJSON;
                $("#info-msg").text(responseJSON.message).removeClass().removeClass().addClass("alert alert-"+responseJSON.type);
            }
        }

    });

});