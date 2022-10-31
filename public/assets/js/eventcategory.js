var table

$(document).ready(function() {
    dataEventcategory();

    function dataEventcategory() {
        table = $('#eventcategory-table').DataTable({
            "processing": true,
            "serverSide": true,
            "columns": [
                { "title": 'ID' },
                { "title": 'Name' },
                { "title": 'Code' },
                { "title": 'Option', "className": "text-center" },
            ],
            "dom": "<'row'<'col-sm-6 'f><'col-sm-5'l><'col-sm-1'B>>" +
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
                },
                // {
                //     text: '<i onclick="showModalAdd()" class="fas fa-plus"></i>',
                //     className: 'btn btn-warning'
                // },
            ],
            "order": [],
            "ajax": {
                "url": base_url + "/api/eventcategory/data",
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
                },
                {
                    "targets": [3],
                    "orderable": false,
                    "className": "col-sm-2 text-center",
                },
            ],
        });

        $('#eventcategory-table tbody').on('click', 'button', function() {
            var data = table.row($(this).parents('tr')).data();
            $('#eventcategory-name').attr('value', data[1]);
            $('#eventcategory-code').attr('value', data[2]);

        });

    }

});

// Add Function //
function showModalAdd() {
    $('#myModal_add').modal('show');

}

$("#button-add-eventcategory").click(function(e) {

    var dataSend = {
        name: $("#eventcategory-name-add").val(),
        code: $("#eventcategory-code-add").val(),
    }

    if (
        dataSend.name == '' ||
        dataSend.code == '' ) {

        if (dataSend.name == '') {
            $('#eventcategory-name-add').addClass('is-invalid');
        }
        if (dataSend.code == '') {
            $('#eventcategory-code-add').addClass('is-invalid');
        }
        alertify.error('Pastikan form sudah terisih dengan baik');

    } else {

        $.ajax({
            type: "POST",
            url: base_url + "/api/eventcategory/save",
            dataType: 'json',
            async: false,
            data: dataSend,
            headers: {
                "Authorization": "Bearer " + token,
            },
            success: function(e) {
                if (e.status.message == "OK") {
                    alertify.success('Data berhasil di simpan');
                    $('#myModal_add').modal('hide');
                    table.ajax.reload();
                    tableDetail.ajax.reload();
                    //$(".needs-validation").closest('form').find("input[type=text], textarea").val("");

                } else {
                    alertify.error('Error Internal');
                }

            }
        });
    }

});
// End Add Function //

// -- Validate -- //
// ADD Validate //
function validateEventcategoryNameAdd(name) {
    var EventcategoryName = document.getElementById(name).value;
    if (EventcategoryName != '') {
        $('#eventcategory-name-add').removeClass('is-invalid');
        $('#eventcategory-name-add').addClass('is-valid');
        $('#button-add-eventcategory').removeClass('disabled')
    } else {
        $('#eventcategory-name-add').removeClass('is-valid');
        $('#eventcategory-name-add').addClass('is-invalid');
        $('#button-add-eventcategory').addClass('disabled')
    }
}

function validateEventcategoryCodeAdd(name) {
    var EventcategoryCode = document.getElementById(name).value;
    if (EventcategoryCode != '') {
        $('#eventcategory-code-add').removeClass('is-invalid');
        $('#eventcategory-code-add').addClass('is-valid');
        $('#button-add-eventcategory').removeClass('disabled')
    } else {
        $('#eventcategory-code-add').removeClass('is-valid');
        $('#eventcategory-code-add').addClass('is-invalid');
        $('#button-add-eventcategory').addClass('disabled')
    }
}

// END Add Validate //
// -- End Validate -- //

// Delete Function //
function delete_eventcategory(id, name) {

    alertify.confirm(
        "Are you sure you want to delete kategory " + name  + "?",
        function() {

            $.ajax({
                type: "POST",
                url: base_url + "/api/eventcategory/delete",
                dataType: 'json',
                async: false,
                data: {
                    id: id
                },
                headers: {
                    "Authorization": "Bearer " + token,
                },
                success: function(e) {

                    if (e.status.message == "OK") {
                        alertify.success('Delete success!');
                        table.ajax.reload();
                    } else {
                        alertify.error('Error Internal');
                    }

                }
            });
        },
        function() {
            alertify.error("Cancel");
        }
    ).setHeader('Confirm Action');
}
// End Delete Function //

// Edit Function //
function edit_eventcategory(id, id) {

    $('#myModal_edit').modal('show');

    var name = $("#" + id).attr("name");
    var code = $("#" + id).attr("code");

    $('#eventcategory-name-edit').val(name);
    $('#eventcategory-code-edit').val(code);
    
    $("#button-edit-eventcategory").attr("id", id);
}

$("#button-edit-eventcategory").click(function(e) {

    var dataSend = {
        id: $("#button-edit-eventcategory").attr("id"),
        name: $("#eventcategory-name-edit").val(),
        code: $("#eventcategory-code-edit").val(),
    }

    if (
        dataSend.name == '' ||
        dataSend.code == '') {

        
        if (dataSend.name == '') {
            $('#eventcategory-name-edit').addClass('is-invalid');
        }
        if (dataSend.code == '') {
            $('#eventcategory-code-edit').addClass('is-invalid');
        }
        alertify.error('Pastikan form sudah terisih dengan baik');

    } else {
        $.ajax({
            type: "POST",
            url: base_url + "/api/eventcategory/update",
            dataType: 'json',
            async: false,
            data: dataSend,
            headers: {
                "Authorization": "Bearer " + token,
            },
            success: function(e) {
                if (e.status.message == "OK") {
                    alertify.success('Data berhasil di simpan');
                    $('#myModal_edit').modal('hide');
                    table.ajax.reload();
                    tableDetail.ajax.reload();
                    //$(".needs-validation").closest('form').find("input[type=text], textarea").val("");
                } else {
                    alertify.error('Error Internal');
                }

            }
        });

    }


});
// End Edit FUnction //

// Edit Valaidation //
function validateEventcategoryNameEdit(name) {
    var val = document.getElementById(name).value;
    if (val != '') {
        $('#eventcategory-name-edit').removeClass('is-invalid');
        $('#eventcategory-name-edit').addClass('is-valid');
        $('#button-edit-eventcategory').removeClass('disabled')
    } else {
        $('#eventcategory-name-edit').removeClass('is-valid');
        $('#eventcategory-name-edit').addClass('is-invalid');
        $('#button-edit-eventcategory').addClass('disabled')
    }
}

function validateEventcategoryCodeEdit(name) {
    var val = document.getElementById(name).value;
    if (val != '') {
        $('#eventcategory-code-edit').removeClass('is-invalid');
        $('#eventcategory-code-edit').addClass('is-valid');
        $('#button-edit-eventcategory').removeClass('disabled')
    } else {
        $('#eventcategory-code-edit').removeClass('is-valid');
        $('#eventcategory-code-edit').addClass('is-invalid');
        $('#button-edit-eventcategory').addClass('disabled')
    }
}
// End Edit Validation //