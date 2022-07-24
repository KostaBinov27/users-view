jQuery(document).ready(function($){
    var table = $('#userTable').DataTable({
        "pageLength": 10,
        "order": [[ 0, "asc" ]],
        "bLengthChange": false,
        "aoColumns": [
            null,
            null,
            { "bSortable": false },
        ],
        "language": {
            "search": "Filter:"
        }
    });
});
