/**
 * Created by tnguyen on 4/3/2015.
 */

function getComments() {
    return $.ajax({
        type:"GET",
        data:"projectid="+projectid+"&taskid="+taskid+"&api_key="+publicKey,
        url:"/api/projects/tasks",
    });
}

$(document).ready(function(){

});
