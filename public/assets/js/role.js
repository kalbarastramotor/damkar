var table
    //document.getElementById('edittime').value = Date();
$(document).ready(function() {
    dataRole();

    function dataRole() {
        table = $('#role-table').DataTable({
            "processing": true,
            "serverSide": true,
            "columns": [
                { "title": 'ID' },
                { "title": 'Name' },
                { "title": 'Routes' },
                { "title": 'Publish' },
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
                {
                    text: '<i onclick="showModalAdd()" class="fas fa-plus"></i>',
                    className: 'btn btn-warning'
                },
            ],
            "order": [],
            "ajax": {
                "url": base_url + "/api/role/data",
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
                    "targets": [4],
                    "orderable": false,
                    "className": "col-sm-2 text-center",
                },
            ],
        });

        $('#role-table tbody').on('click', 'button', function() {
            var data = table.row($(this).parents('tr')).data();
            $('#role-name').attr('value', data[1]);
            $('#role-routes').attr('value', data[2]);
            $('#role-publish').attr('value', data[3]);

        });

    }

});

function delete_role(id, name) {

    alertify.confirm(
        "Are you sure you want to delete role for " + name + "?",
        function() {

            $.ajax({
                type: "POST",
                url: base_url + "/api/role/delete",
                dataType: 'json',
                async: false,
                data: {
                    roleid: id
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

function showModalAdd() {

    $('#role-publish-add').select2({
        placeholder: 'Publish / Unpublish',
        allowClear: true,
        dropdownParent: $('#myModal_add'),
        ajax: {
            dropdownParent: $('#myModal_add'),
            url: base_url + "/api/menu/optionpublish",
            headers: {
                "Authorization": "Bearer " + token,
            },
            data: function(params) {
                var query = {
                    search: params.term,
                    type: 'select2',
                    page: params.page || 1,
                    auth: true,
                }
                return query;
            },

            dataType: 'json',
            delay: 250,
            selectOnClose: false,
            minimumResultsForSearch: 2,
            processResults: function(data, params) {
                params.page = params.page || 1;
                return {
                    results: data,
                    pagination: {
                        more: false
                    }
                };
            },
            cache: true
        }
    });
    $('#myModal_add').modal('show');
}

$("#button-add-role").click(function(e) {
    var dataSend = {
        name: $("#role-name-add").val(),
        routes: $("#role-routes-add").val(),
        publish: $("#role-publish-add").val(),
    }
})

$("#button-add-role").click(function(e) {
    var dataSend = {
        name: $("#role-name-add").val(),
        routes: $("#role-routes-add").val(),
        publish: $("#role-publish-add").val(),
    }

    if (
        dataSend.name == '' ||
        dataSend.routes == '' ||
        dataSend.publish == '') {

        if (dataSend.name == '') {
            $('#role-name-add').addClass('is-invalid');
        }
        if (dataSend.routes == '') {
            $('#role-routes-add').addClass('is-invalid');
        }
        if (dataSend.publish == '') {
            $('#role-publish-add').addClass('is-invalid');
        }
        alertify.error('Pastikan data sudah terisih dengan baik');

    } else {
        $.ajax({
            type: "POST",
            url: base_url + "/api/role/save",
            dataType: 'json',
            async: false,
            data: dataSend,
            headers: {
                "Authorization": "Bearer " + token,
            },
            success: function(e) {
                if (e.status.message == "OK") {
                    alertify.success('Data Role berhasil di simpan');
                    $('#myModal_add').modal('hide');
                    table.ajax.reload();

                } else {
                    alertify.error('Error Internal');
                }

            }
        });
    }

});
// js validate

// validate add 

function validateRoleNameAdd(name) {
    var roleName = document.getElementById(name).value;
    if (roleName != '') {
        $('#role-name-add').removeClass('is-invalid');
        $('#role-name-add').addClass('is-valid');
        $('#button-add-role').removeClass('disabled')

    } else {
        $('#role-name-add').removeClass('is-valid');
        $('#role-name-add').addClass('is-invalid');
        $('#button-add-role').addClass('disabled')
    }
}

function validateRoleRoutesAdd(name) {
    var roleName = document.getElementById(name).value;
    if (roleName != '') {
        $('#role-routes-add').removeClass('is-invalid');
        $('#role-routes-add').addClass('is-valid');
        $('#button-add-role').removeClass('disabled')

    } else {
        $('#role-routes-add').removeClass('is-valid');
        $('#role-routes-add').addClass('is-invalid');
        $('#button-add-role').addClass('disabled')
    }
}

function validateRolePublishAdd(name) {
    var roleName = document.getElementById(name).value;
    if (roleName != '') {
        $('#role-publish-add').removeClass('is-invalid');
        $('#role-publish-add').addClass('is-valid');
        $('#button-add-role').removeClass('disabled')

    } else {
        $('#role-publish-add').removeClass('is-valid');
        $('#role-publish-add').addClass('is-invalid');
        $('#button-add-role').addClass('disabled')
    }
}

// END VALIDATE ADD //


// detail role 
var tableDetail;
$(".close-detail-data").click(function(e) {
    tableDetail.destroy();
})

function detail_role(roleid, title) {
    $('#myModal_detail').modal({ backdrop: 'static', keyboard: false });
    $('#myModal_detail').modal('show');
    $("#myModalLabel_detail").text('DETAIL MENU ' + title);
    tableDetail = $('#detail-role-table').DataTable({
        lengthMenu: [
            [50, -1],
            [50, 'All'],
        ],
        rowGroup: {
            dataSrc: [0]
        },
        dom: "",
        processing: true,
        serverSide: true,
        ajax: {
            url: base_url + "/api/role/menu/data",
            headers: {
                "Authorization": "Bearer " + token,
            },
            data: {
                roleid: roleid,
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
            // {
            //     targets: [3, 4, 5, 6, 7],
            //     orderable: false,
            //     className: "text-center",
            // }
        ]
    });
}

// UPDATE //

function update_role(roleid, id) {
    $('#myModal_update').modal('show');

    var name = $("#" + id).attr("name");
    var routes = $("#" + id).attr("routes");
    var publish = $("#" + id).attr("publish");

    $('#role-name-update').val(name);
    $('#role-routes-update').val(routes);
    $('#role-publish-update').val(publish);
    //console.log(name);



    $('.show-role-publish-update').select2({
        placeholder: 'Publish / Unpublish',
        allowClear: true,
        dropdownParent: $('#myModal_update'),
        ajax: {
            dropdownParent: $('#myModal_update'),
            url: base_url + "/api/menu/optionpublish",
            headers: {
                "Authorization": "Bearer " + token,
            },
            data: function(params) {
                var query = {
                    search: params.term,
                    type: 'select2',
                    page: params.page || 1,
                    auth: true,
                }
                return query;
            },

            dataType: 'json',
            delay: 250,
            selectOnClose: false,
            minimumResultsForSearch: 2,
            processResults: function(data, params) {
                params.page = params.page || 1;
                return {
                    results: data,
                    pagination: {
                        more: false
                    }
                };
            },
            cache: true
        }
    });

    var $newOptionPublish = $("<option selected='selected'></option>").val(1).text("PUBLISH");
    if (publish == 0) {
        $newOptionPublish = $("<option selected='selected'></option>").val(0).text("UNPUBLISH");
    } else {
        $newOptionPublish = $("<option selected='selected'></option>").val(1).text("PUBLISH");
    }

    $(".show-role-publish-update").append($newOptionPublish).trigger('change');


    $("#button-update-role").attr("roleid", roleid);
}



function validateRoleNameUpdate(name) {
    // var ok = 0;
    var roleName = document.getElementById(name).value;
    if (roleName != '') {
        $('#role-name-update').removeClass('is-invalid');
        $('#role-name-update').addClass('is-valid');
        $('#button-update-role').removeClass('disabled')

    } else {
        $('#role-name-update').removeClass('is-valid');
        $('#role-name-update').addClass('is-invalid');
        $('#button-update-role').addClass('disabled')
    }
}

function validateRoleRoutesUpdate(name) {
    // var ok = 0;
    var roleName = document.getElementById(name).value;
    if (roleName != '') {
        $('#role-routes-update').removeClass('is-invalid');
        $('#role-routes-update').addClass('is-valid');
        $('#button-update-role').removeClass('disabled')

    } else {
        $('#role-routes-update').removeClass('is-valid');
        $('#role-routes-update').addClass('is-invalid');
        $('#button-update-role').addClass('disabled')
    }
}

// END VALIDATE UPDATE //
function checklistMenu(idrole, menuid) {
    var dataSend = {
        roleid: idrole,
        menuid: menuid
    }
    $.ajax({
        type: "POST",
        url: base_url + "/api/role/menu/add",
        dataType: 'json',
        async: false,
        data: dataSend,
        headers: {
            "Authorization": "Bearer " + token,
        },
        success: function(e) {

            if (e.status.message == "OK") {

                alertify.success('Data berhasil di simpan');
                $('#myModal_update').modal('hide');
                tableDetail.ajax.reload();
            } else {
                console.log('====================================');
                console.log(e);
                console.log('====================================');
                alertify.error('Error Internal');
            }

        }
    });


}
$('#button-update-role').click(function() {

    var dataSend = {
        roleid: $("#button-update-role").attr("roleid"),
        name: $("#role-name-update").val(),
        routes: $("#role-routes-update").val(),
        publish: ($("#role-publish-update").val() == null) ? '' : $("#role-publish-update").val(),
    }

    console.log('====================================');
    console.log(dataSend);
    console.log('====================================');
    if (
        dataSend.name == '' ||
        dataSend.routes == '' ||
        dataSend.publish == '') {


        if (dataSend.name == '') {
            $('#role-name-update').addClass('is-invalid');
        }
        if (dataSend.routes == '') {
            $('#role-routes-update').addClass('is-invalid');
        }
        if (dataSend.publish == '') {
            $('#role-publish-update').addClass('is-invalid');
        }
        alertify.error('Pastikan form sudah terisih dengan baik');

    } else {
        $.ajax({
            type: "POST",
            url: base_url + "/api/role/update",
            dataType: 'json',
            async: false,
            data: dataSend,
            headers: {
                "Authorization": "Bearer " + token,
            },
            success: function(e) {
                if (e.status.message == "OK") {

                    alertify.success('Data berhasil di simpan');
                    $('#myModal_update').modal('hide');
                    table.ajax.reload();
                } else {
                    alertify.error('Error Internal');
                }

            }
        });

    }


});