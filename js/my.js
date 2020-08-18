$(document).ready(function() {
    var oTable = $('#repositories').dataTable( {
        "processing": true,
        "ajax": {
            url: "_getData.php",
            type: "GET",
            datasrc: 'data'
        },
        "order": [[ 6, "desc" ]], // col 6 is stars
        columns: [
            { data: 'id'},
            { data: 'name' ,
                render : function(data, type, row) {
                    return '<a target="_blank" href="detail.php?repo_id=' + row.id +  '">'+data+'</a>'
                }
            },
            { data: 'html_url' },
            { data: 'created_at'},
            { data: 'pushed_at' },
            { data: 'description' },
            { data: 'stargazers_count' }
        ],
    } );
} );
