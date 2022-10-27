var table
$(document).ready(function() {

    table = $('#category-table').DataTable({

        "processing": true,
        "serverSide": true,
        "columns": [
            { "title": 'No' },
            { "title": 'Name' },
            { "title": 'Code' },

        ],
        "dom": "<'row'<'col-sm-6 'l><'col-sm-5'f><'col-sm-1'B>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-8'i><'col-sm-4'p>>",
        "buttons": [{
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i>',
                className: 'btn btn-success',
                exportOptions: {
                    modifier: {
                        search: 'applied',
                        order: 'applied'
                    }
                }
            },
            {
                extend: 'pdf',
                text: '<i class="fas fa-file-pdf"></i>',
                className: 'btn btn-danger'
            }
        ],
        "order": [],
        "ajax": {
            "url": base_url + "/api/category/data",
            "type": "POST",
            "headers": {
                "Authorization": "Bearer " + token,
            },
            "error": function(XMLHttpRequest, textStatus, errorThrown) {
                const myJSON = JSON.parse(XMLHttpRequest.responseText)
                if (myJSON.error == "invalid_token") {
                    alertify.error('Session anda selesai');

                    localStorage.removeItem("token");
                    location.href = base_url;
                }
            }
        },
        "columnDefs": [{
                "targets": [0],
                "orderable": false,
                "className": "col-sm-2 text-center",
            }, {
                "targets": [],
                "orderable": false,
            },
            {
                "targets": [2],
                "visible": false
            },
        ],

    });

});