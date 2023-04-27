$(document).ready(function() {
    $('#btl-table').DataTable({
        lengthMenu: [
            [50, -1],
            [50,100],
        ],
        rowGroup: {
            dataSrc: [0]
        },
        dom: "<'row'<'col-sm-4'f><'col-sm-8 button-export'B>>",
        buttons: [{
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
            },

        ],
        processing: true,
        serverSide: true,
        ajax: {
            url: base_url + "/api/report/btl",
            headers: {
                "Authorization": "Bearer " + token,
            },
            type: "POST",
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                const myJSON = JSON.parse(XMLHttpRequest.responseText)
                if (myJSON.error == "invalid_token") {
                    localStorage.removeItem("token");
                    location.href = base_url;
                }
            }
        },
        order: [
            [0, 'asc']
        ],

        columnDefs: [{
                targets: [0],
                visible: false
            },
            {
                targets: [1],
                orderable: false,
                className: "text-right",
            },
            {
                targets: [2],
                orderable: false,
                className: "text-left",
            },
            {
                targets: [3, 4, 5, 6, 7,8],
                orderable: false,
                className: "text-center",
            }
        ]
    });

    var oldValue = null;
    $(document).on('dblclick', '.editable', function() {
        oldValue = $(this).html();

        $(this).removeClass('editable'); // to stop from making repeated request
        if (oldValue.search("Rp.") < 0) {
            oldValue = oldValue.replace(",", "");
            oldValue = oldValue.replace(".", "");
            $(this).html('<input type="text" class="form-control update" value="' + oldValue + '" />');

        } else {
            oldValue = oldValue.replace("Rp.", "");
            oldValue = oldValue.replace(",", "");
            oldValue = oldValue.replace(".", "");
            oldValue = oldValue.replace(".", "");
            oldValue = oldValue.replace(",", "");
            $(this).html('<input type="text" class="form-control update" value="' + oldValue + '" />');

        }
        $(this).find('.update').focus();
        // oldValue = $(this).html();

        // $(this).removeClass('editable'); // to stop from making repeated request

        // $(this).html('<input type="text" class="form-control update" value="' + oldValue + '" />');
        // $(this).find('.update').focus();

        // oldValue = $(this).html();

        // $(this).removeClass('editable'); // to stop from making repeated request
        //  console.log("data ", oldValue)

        // if (oldValue.search("Rp.") < 0) {
        //     oldValue = oldValue.replace(",", "");
        //     oldValue = oldValue.replace(".", "");
        //     $(this).html('<input type="text" class="form-control update" value="' + oldValue + '" />');

        // } else {
        //     oldValue = oldValue.replace("Rp.", "");
        //     oldValue = oldValue.replace(",", "");
        //     oldValue = oldValue.replace(".", "");
        //     oldValue = oldValue.replace(".", "");
        //     oldValue = oldValue.replace(",", "");
        //     $(this).html('<input type="text" class="form-control update" value="' + oldValue + '" />');

        // }
        // $(this).find('.update').focus();
    });
    var newValue = null;
 

    $(document).on('blur', '.update', function() {
        var elem = $(this);
        newValue = $(this).val();
        var empId = $(this).parent().attr('id');
        var colName = $(this).parent().attr('name');

        if (newValue != oldValue) {

            var dataSend = {
                empId: empId,
                colName: colName,
                newValue: newValue,
            }
            
            if(colName=="target"){
                checkVal = Number.isInteger(newValue)
                if (!isNaN(newValue)){
                    alertify.success('Data berhasil diupdate');
                    $(elem).parent().addClass('editable');
                    $(elem).parent().html(newValue);

                }else{
                    $(elem).parent().addClass('editable');
                    $(elem).parent().html(oldValue);
                    alertify.error('Hanya bisa di isi angka');
                }
            }else{
                    $(elem).parent().addClass('editable');
                // $(elem).parent().html(newValue);

                    newValue = newValue.replace(",", "");
                    newValue = newValue.replace(".", "");
                    $(elem).parent().html("Rp." + formatRupiah(newValue));
              
            }
                // $.ajax({
                // 	url : 'updateData.php',
                // 	method : 'post',
                // 	data : 
                // 	{
                // 		empId    : empId,
                // 		colName  : colName,
                // 		newValue : newValue,
                // 	},
                // 	success : function(respone)
                // 	{
           
            // 	}
            // });
        } else {
            if(colName=="butget"){
                    $(elem).parent().addClass('editable');
                    $(this).parent().html("Rp." + formatRupiah(newValue));
              
            }else{
                $(elem).parent().addClass('editable');
                $(this).parent().html(newValue);
            }
         
        }
    });
    // "lengthMenu": [
    //     [50, -1],
    //     [50,100],
    // ],
    // "processing": true,
    // "serverSide": true,
    // // "columns": [
    // //     { "title": 'Group' },
    // //     { "title": 'Name' },
    // // ],
    // // "dom": "<'row'<'col-sm-6 'l><'col-sm-5'f><'col-sm-1'B>>" +
    // //     "<'row'<'col-sm-12'tr>>" +
    // //     "<'row'<'col-sm-8'i><'col-sm-4'p>>",
    // // "buttons": [{
    // //         extend: 'excel',
    // //         text: '<i class="fas fa-file-excel"></i>',
    // //         className: 'btn btn-success',
    // //         exportOptions: {
    // //             modifier: {
    // //                 search: 'applied',
    // //                 order: 'applied'
    // //             }
    // //         }
    // //     },
    // //     {
    // //         extend: 'pdf',
    // //         text: '<i class="fas fa-file-pdf"></i>',
    // //         className: 'btn btn-danger'
    // //     },
    // //     {
    // //         text: '<i onclick="showModalAdd()" class="fas fa-plus"></i>',
    // //         className: 'btn btn-warning'
    // //     },
    // // ],
    // "order": [
    //     [1, 'asc']
    // ],
    // "rowsGroup": {
    //     "dataSrc": [0]
    // },

    // "ajax": {
    //     "url": base_url + "/reportbtl",
    //     "type": "POST",
    //     "headers": {
    //         "Authorization": "Bearer " + token,
    //     },
    //     "error": function(XMLHttpRequest, textStatus, errorThrown) {
    //         console.log(XMLHttpRequest);
    //         // if (XMLHttpRequest.status == 500) {
    //         //     localStorage.removeItem("token");
    //         //     location.href = base_url;
    //         // }
    //     }
    // },

    // "columnDefs": [{
    //     "targets": [0],
    //     "visible": false

    // }],


    function formatRupiah(angka) {

        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split('.'),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        // rupiah = split[1] != undefined ? rupiah + '.' + split[1] : rupiah;
        return rupiah
    }


});