/**
 * Created by tnguyen on 4/3/2015.
 */

function getComments() {
    return $.ajax({
        type:"GET",
        data:"id="+id+"&taskid="+taskid+"&api_key="+publicKey,
        url:"/api/projects/tasks",
        success:function(resp) {
            $("#comment-list").html(resp.data);
        }
    });
}

$(document).ready(function(){
    getComments();
});
