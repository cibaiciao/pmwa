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

function getTaskList() {
    return $.ajax({
        type:"GET",
        dataType:"json",
        data:"api_key="+publicKey+"&id="+project_id+"&key="+key+"&assignee="+assignee+"&priority="+priority+"&status="+status+"&type="+type+"&size="+size+"&unresolved="+unresolved,
        url:"/api/projects/tasks",
        success:function(resp) {
            $("#tasks").html(resp.data);
        }
    });
}

function filter() {
    var searchCriteria = $(".search"), i,name;

    for(i=0;i<searchCriteria.length;i++) {
        name = searchCriteria[i].name;
        value = searchCriteria[i].value;
        switch ( name ) {
            case 'key':
                key  =  value;
                break;
            case 'assignee':
                assignee = value;
                break;
            case 'priority':
                priority = value;
                break;
            case 'status':
                status = value;
                break;
            case 'type':
                type = value;
                break;
            case 'size':
                size = value;
                break;
        }
    }

    getTaskList();
}

function exportCSV() {

}

$(document).ready(function(){
    if ( $("#summary").length > 0 ) {
        getSummaryByPriority();
        getSummaryByAssignee();
        getSummaryByStatus();
        getSummaryBySize();
        getSummaryByType();
    }
    if ( $("#task-list").length > 0 ) {
        getTaskList();
    }

});