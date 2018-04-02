/*导出*/
var export_Status = false;

function exportFile(){
    if(!export_Status){
        $('.table').tableExport({formats:['xlsx','xls','csv','txt']});
        export_Status = true;
    } 
}