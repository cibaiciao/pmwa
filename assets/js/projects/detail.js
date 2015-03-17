/**
 * Created by TriNguyen on 3/8/15.
 */

function getSummaryByPriority() {
    return $.ajax({
        type:"GET",
        dataType:"json",
        data:"api_key="+publicKey+"&id="+project_id+"&type=priority",
        url:"/api/projects/summary",
        success:function(resp) {

            $("#priority").html(resp.data);
        }
    });
}

function getSummaryByAssignee() {
    return $.ajax({
        type:"GET",
        dataType:"json",
        data:"api_key="+publicKey+"&id="+project_id+"&type=assignee",
        url:"/api/projects/summary",
        success:function(resp) {
            $("#assignee").html(resp.data);
        }
    });
}

function getSummaryByStatus() {
    return $.ajax({
        type:"GET",
        dataType:"json",
        data:"api_key="+publicKey+"&id="+project_id+"&type=status",
        url:"/api/projects/summary",
        success:function(resp) {
            $("#status").html(resp.data);
        }
    });
}

function getSummaryBySize() {
    return $.ajax({
        type:"GET",
        dataType:"json",
        data:"api_key="+publicKey+"&id="+project_id+"&type=size",
        url:"/api/projects/summary",
        success:function(resp) {
            $("#size").html(resp.data);
        }
    });
}

function getSummaryByType() {
    return $.ajax({
        type:"GET",
        dataType:"json",
        data:"api_key="+publicKey+"&id="+project_id+"&type=type",
        url:"/api/projects/summary",
        success:function(resp) {
            $("#type").html(resp.data);
        }
    });
}


$(document).ready(function(){
    getSummaryByPriority();
    getSummaryByAssignee();
    getSummaryByStatus();
    getSummaryBySize();
    getSummaryByType();

});