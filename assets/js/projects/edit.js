/**
 * Created by TT on 2/20/2015.
 */

$(document).ready(function(){
    $( ".date" ).datepicker({
        dateFormat:"yy-mm-dd"
    });

    $.ajax({
        type:"GET",
        dataType:"json",
        data:"api_key="+publicKey+"&id="+project_id,
        url:"/api/projects/get",
        beforeSend:function() {
            $("#name,#key,#description,#deadline,#btn").attr("disabled","disabled");
        },
        success:function(resp) {
            $("#name").val(resp.name);
            $("#key").val(resp.key);
            $("#description").val(resp.description);
            $("#deadline").val($.trim(resp.deadline.replace("00:00:00","")));
        },
        error:function(resp) {
            if ( resp ) {
                var responseJSON = resp.responseJSON;
                $("#info-msg").text(responseJSON.message).removeClass().removeClass().addClass("alert alert-"+responseJSON.type);
            }
        },
        complete:function() {
            $("#name,#description,#deadline,#btn").removeAttr("disabled");
        }
    });

    $("#btn").on("click",function(){
        $.ajax({
            type:"PUT",
            dataType:"json",
            data:$("#form").serialize()+"&api_key="+publicKey,
            url:"/api/projects/edit",
            success:function(resp) {
                if ( resp.redirect !== undefined ) {
                    window.location.href = resp.redirect;
                }
                if ( resp.message !== undefined ) {
                    $("#info-msg").text(resp.message).removeClass().addClass("alert alert-"+resp.type);
                }
            },
            error:function(resp) {
                if ( resp ) {
                    var responseJSON = resp.responseJSON;
                    $("#info-msg").text(responseJSON.message).removeClass().addClass("alert alert-"+responseJSON.type);
                }
            }
        });
    });
});