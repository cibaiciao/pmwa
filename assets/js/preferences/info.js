/**
 * Created by TT on 2/21/2015.
 */
$(document).ready(function(){

    $.ajax({
        type:"GET",
        dataType:"json",
        data:$("#info-form").serialize()+"&api_key="+publicKey,
        url:"/api/users/info",
        beforeSend:function() {
          $("#fname,#lname,#changeBtn").attr("disabled","disabled");
        },
        success:function(resp) {
            $("#fname").val(resp.fname || '');
            $("#lname").val(resp.lname || '');
        },
        error:function(resp) {
            if ( resp ) {
                var responseJSON = resp.responseJSON;
                $("#info-msg").text(responseJSON.message).removeClass().removeClass().addClass("alert alert-"+responseJSON.type);
            }
        },
        complete:function() {
            $("#fname,#lname,#changeBtn").removeAttr("disabled");
        }
    });

    $("#changeBtn").on("click",function(){
        $.ajax({
            type:"PUT",
            data:$("#info-form").serialize()+"&api_key="+publicKey,
            dataType:"json",
            url:"/api/users/info",
            success:function(resp) {
                if ( resp.message ) {
                    $("#info-msg").text(resp.message).removeClass().removeClass().addClass("alert alert-"+resp.type);
                }
            },
            error:function(resp) {
                if ( resp ) {
                    var responseJSON = resp.responseJSON;
                    $("#info-msg").text(responseJSON.message).removeClass().removeClass().addClass("alert alert-"+responseJSON.type);
                }
            }

        });
    });
});