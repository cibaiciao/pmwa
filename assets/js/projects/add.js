/**
 * Created by TT on 2/20/2015.
 */
$(document).ready(function(){
    $( ".date" ).datepicker({
        dateFormat:"yy-mm-dd"
    });

    $("#btn").on("click",function(){
        $.ajax({
            type:"POST",
            dataType:"json",
            data:$("#form").serialize()+"&api_key="+publicKey,
            url:"/api/projects/add",
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