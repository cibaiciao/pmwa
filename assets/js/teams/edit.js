/**
 * Created by TT on 2/20/2015.
 */

function cancelInvitation(that) {
    var userid = $(that).data("userid");

    $.ajax({
        type:"DELETE",
        dataType:"json",
        url:"/api/teams/"+team_id+"/users",
        data:"api_key="+publicKey+"&user_id="+userid,
        success:function(resp) {
            if ( resp.redirect ) {
                window.location.href = resp.redirect;
                return false;
            }

            if ( resp.message ) {
                if ( resp.message ) {
                    $("#info-user-msg").text(resp.message).removeClass().removeClass().addClass("alert alert-"+resp.type);
                }
            }

            if ( resp.status ) {
                getUser();
            }
        },
        error:function(resp) {
            if ( resp ) {
                var responseJSON = resp.responseJSON;
                $("#info-user-msg").text(responseJSON.message).removeClass().removeClass().addClass("alert alert-"+responseJSON.type);
            }
        }
    });
}

function changeUserStatus(that) {
    var userteamid = $(that).data("userteamid");

    $.ajax({
        type:"PUT",
        dataType:"json",
        url:"/api/teams/"+team_id+"/users",
        data:"api_key="+publicKey+"&userteamid="+userteamid+"&type=status",
        success:function(resp) {
            if ( resp.redirect ) {
                window.location.href = resp.redirect;
                return false;
            }

            if ( resp.message ) {
                if ( resp.message ) {
                    $("#info-user-msg").text(resp.message).removeClass().removeClass().addClass("alert alert-"+resp.type);
                }
            }

            if ( resp.status ) {
                getUser();
            }
        },
        error:function(resp) {
            if ( resp ) {
                var responseJSON = resp.responseJSON;
                $("#info-user-msg").text(responseJSON.message).removeClass().removeClass().addClass("alert alert-"+responseJSON.type);
            }
        }
    })
}

function changeUserRole(that) {
    var userteamid = $(that).data("userteamid");

    $.ajax({
        type:"PUT",
        dataType:"json",
        url:"/api/teams/"+team_id+"/users",
        data:"api_key="+publicKey+"&userteamid="+userteamid+"&value="+that.value+"&type=role",
        success:function(resp) {
            if ( resp.redirect ) {
                window.location.href = resp.redirect;
                return false;
            }

            if ( resp.message ) {
                if ( resp.message ) {
                    $("#info-user-msg").text(resp.message).removeClass().removeClass().addClass("alert alert-"+resp.type);
                }
            }

            if ( resp.status ) {
                getUser();
            }
        },
        error:function(resp) {
            if ( resp ) {
                var responseJSON = resp.responseJSON;
                $("#info-user-msg").text(responseJSON.message).removeClass().removeClass().addClass("alert alert-"+responseJSON.type);
            }
        }
    })
}

var getUser = (function() {
    return $.ajax({
        type:"GET",
        dataType:"json",
        data:"api_key="+publicKey,
        url:"/api/teams/"+team_id+"/users",
        success:function(resp) {
            if ( resp.redirect ) {
                window.location.href = resp.redirect;
                return false;
            }

            if ( resp.data ) {
                $("#user-list").html(resp.data);
            }
        },
        error:function(resp) {
            if ( resp ) {
                var responseJSON = resp.responseJSON;
                $("#info-user-msg").text(responseJSON.message).removeClass().removeClass().addClass("alert alert-"+responseJSON.type);
            }
        }
    });
});


$(document).ready(function(){





    $.ajax({
        type:"GET",
        dataType:"json",
        data:"api_key="+publicKey+"&"+$("#form").serialize(),
        url:"/api/teams/get",
        beforeSend:function() {
          $("#name,#status,#btn").attr("disabled","disabled");
        },
        success:function(resp) {
            $("#name").val(resp.name);
            $("#status").val(resp.status);
        },
        error:function(resp) {
            if ( resp ) {
                var responseJSON = resp.responseJSON;
                $("#info-msg").text(responseJSON.message).removeClass().removeClass().addClass("alert alert-"+responseJSON.type);
            }
        },
        complete:function() {
            $("#name,#status,#btn").removeAttr("disabled");

            if ( !isOwner ) {
                $("input,select,#btn,#inviteBtn").attr("disabled","disabled");
            }
        }
    });


    getUser();



    $("#btn").on("click",function(){
        $.ajax({
            type:"PUT",
            dataType:"json",
            data:$("#form").serialize()+"&api_key="+publicKey,
            url:"/api/teams/edit",
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

    $("#inviteBtn").on("click",function(){
        $.ajax({
            type:"POST",
            dataType:"json",
            url:"/api/teams/"+team_id+"/users",
            data:$("#invite").serialize()+"&api_key="+publicKey,
            success:function(resp) {
                if ( resp.redirect ) {
                    window.location.href = resp.redirect;
                    return false;
                }

                if ( resp.message ) {
                    $("#info-user-msg").text(resp.message).removeClass().removeClass().addClass("alert alert-"+resp.type);
                }
                if ( resp.status ) {
                    getUser();
                    $("#email").val("");
                }


            },
            error:function(resp) {
                if ( resp ) {
                    var responseJSON = resp.responseJSON;
                    $("#info-user-msg").text(responseJSON.message).removeClass().removeClass().addClass("alert alert-"+responseJSON.type);
                }
            }
        });
    });
});