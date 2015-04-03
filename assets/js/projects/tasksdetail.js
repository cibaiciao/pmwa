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
            getComments();
        }
    });
}

$(document).ready(function(){
    getComments();


});
