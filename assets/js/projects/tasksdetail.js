/**
 * Created by tnguyen on 4/3/2015.
 */

function getComments() {
    return $.ajax({
        type:"GET",
        data:"id="+id+"&taskid="+taskid+"&api_key="+publicKey,
        url:"/api/projects/comments",
        success:function(resp) {
            $("#comment-list").html(resp.data);
        }
    });
}

function addComment(btn) {
    $.ajax({
        type:"POST",
        data:"id="+id+"&taskid="+taskid+"&api_key="+publicKey+"&"+$("#commentForm").serialize(),
        url:"/api/projects/comments",
        success:function(resp) {
            $("#comment").val("");
        },
        complete:function() {
            getComments();
        }
    });
}

function editTask(btn) {
    $.ajax({
        type:"PUT",
        dataType:"json",
        data:$("#form").serialize()+"&api_key="+publicKey,
        url:"/api/projects/tasks",
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
}

$(document).ready(function(){
    getComments();


});
