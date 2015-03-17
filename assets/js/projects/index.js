/**
 * Created by TriNguyen on 3/5/15.
 */

$(document).ready(function(){
    $.ajax({
        type:"GET",
        dataType:"json",
        data:"api_key="+publicKey,
        url:"/api/projects/index",
        success:function(resp) {
            $("#project").html(resp.data);
        },
        error:function(resp) {
            if ( resp ) {
                var responseJSON = resp.responseJSON;
                $("#info-msg").text(responseJSON.message).removeClass().removeClass().addClass("alert alert-"+responseJSON.type);
            }
        }

    });
});