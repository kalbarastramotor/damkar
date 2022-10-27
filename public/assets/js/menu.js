var table;
$(document).ready(function() {
    dataUsers();

    function dataUsers() {
        table = $('#menu-table').DataTable({
            "processing": true,
            "serverSide": true,
            "columns": [
                { "title": 'Status' },
                { "title": 'No' },
                { "title": 'Name' },
                { "title": 'Code' },
                { "title": 'Url' },
                { "title": 'Publish' },
                { "title": 'Option' },
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
                },
                {
                    text: '<i onclick="showModalAdd()" class="fas fa-plus"></i>',
                    className: 'btn btn-warning'
                },
            ],
            "order": [],
            "ajax": {
                "url": base_url + "/api/menu/data",
                "type": "POST",
                "data": {
                    status: 1
                },
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
            "createdRow": function(row, data, dataIndex) {
                if (data[0] == 0 || data[0] == "0") {
                    $(row).addClass('table-danger');
                }
            },
            "columnDefs": [{
                "targets": [],
                "orderable": false,
            }, {
                "targets": [0],
                "visible": false,
                "orderable": false,
            }, ],
        });
    }
});




function lock_menu(menuid, status, detail) {
    alertify.confirm(
        "Are you sure you want to " + (((status == 1) ? "Lock" : "Unlock")) + " this menu ?",
        function() {
            $.ajax({
                type: "POST",
                url: base_url + "/api/menu/lock",
                dataType: 'json',
                async: false,
                data: {
                    menuid: menuid,
                    status: (status == 1) ? 0 : 1,
                },
                headers: {
                    "Authorization": "Bearer " + token,
                },
                success: function(e) {

                    if (e.status.message == "OK") {
                        if (status == 1) {
                            alertify.success('Lock Success');
                        } else {
                            alertify.success('Unlock Success');
                        };

                        if (detail) {
                            tableDetail.ajax.reload();
                        } else {
                            table.ajax.reload();
                        }
                    } else {
                        alertify.error('Error Internal');
                    }

                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    const myJSON = JSON.parse(XMLHttpRequest.responseText)

                    if (myJSON.error == "invalid_token") {
                        alertify.error('Session anda selesai');
                        localStorage.removeItem("token");
                        location.href = base_url;
                    }
                }
            });
        },
        function() {
            alertify.error("Cancel");
        }
    ).setHeader('Confirm Action');
}




// $("#edit_menu").click(function(e) {
function edit_menu(menuid, id) {

    $('#myModal_edit').modal({ backdrop: 'static', keyboard: false });
    $('#myModal_edit').modal('show');

    var menuName = $("#" + id).attr("menu_name");
    var menuCode = $("#" + id).attr("menu_code");
    var menuUrl = $("#" + id).attr("menu_url");
    var menuParentID = $("#" + id).attr("menu_parentid");

    $('#name-menu-edit').val(menuName);
    $('#code-menu-edit').val(menuCode);
    $('#url-menu-edit').val(menuUrl);

    $('#button-update-menu').attr('menuid', menuid);



    $('.show-parent-edit').select2({
        placeholder: 'Parent menu',
        allowClear: true,
        dropdownParent: $('#myModal_edit'),
        ajax: {
            dropdownParent: $('#myModal_edit'),
            url: base_url + "/api/menu/optionparent",
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

    $.ajax({
        type: "POST",
        url: base_url + "/getdatamenu",
        dataType: 'json',
        async: false,
        data: {
            menuid: menuParentID,
        },
        headers: {
            "Authorization": "Bearer " + token,
        },
        success: function(e) {
            var $newOption = $("<option selected='selected'></option>").val(menuParentID).text(e.name);
            $(".show-parent-edit").append($newOption).trigger('change');
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            const myJSON = JSON.parse(XMLHttpRequest.responseText)

            if (myJSON.error == "invalid_token") {
                alertify.error('Session anda selesai');
                localStorage.removeItem("token");
                location.href = base_url;
            }
        }
    });


    $('.show-publish-menu-edit').select2({
        placeholder: 'Publish / Unpublish',
        allowClear: true,
        dropdownParent: $('#myModal_edit'),
        ajax: {
            dropdownParent: $('#myModal_edit'),
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

    var menuStatus = $("#" + id).attr("menu_status");
    var $newOptionPublish = $("<option selected='selected'></option>").val(1).text("PUBLISH");
    if (menuStatus == 0) {
        $newOptionPublish = $("<option selected='selected'></option>").val(0).text("UNPUBLISH");
    } else {
        $newOptionPublish = $("<option selected='selected'></option>").val(1).text("PUBLISH");
    }

    $(".show-publish-menu-edit").append($newOptionPublish).trigger('change');

}

function detail_menu(menuid, title) {
    $('#myModal_detail').modal({ backdrop: 'static', keyboard: false });
    $('#myModal_detail').modal('show');
    $("#myModalLabel").text('DETAIL MENU ' + title);
    tableDetail = $('#detail-menu-table').DataTable({
        "processing": true,
        "serverSide": true,
        "columns": [
            { "title": 'Status' },
            { "title": 'No' },
            { "title": 'Name' },
            { "title": 'Code' },
            { "title": 'Url' },
            { "title": 'Publish' },
            { "title": 'Option' },
        ],
        "dom": "<'row'<'col-sm-6 'l><'col-sm-6'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-8'i><'col-sm-4'p>>",

        "order": [],
        "ajax": {
            "url": base_url + "/api/menu/data",
            "type": "POST",
            "headers": {
                "Authorization": "Bearer " + token,
            },
            "data": {
                status: 2,
                parent: menuid,
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
        "createdRow": function(row, data, dataIndex) {
            if (data[0] == 0 || data[0] == "0") {
                $(row).addClass('table-danger');
            }
        },
        "columnDefs": [{
            "targets": [],
            "orderable": false,
        }, {
            "targets": [0],
            "visible": false,
            "orderable": false,
        }, ],
    });
}

// add 


function showModalAdd() {
    $('#myModal_add').modal('show');

    $('.show-parent').select2({
        placeholder: 'Parent menu',
        allowClear: true,
        dropdownParent: $('#myModal_add'),
        ajax: {
            dropdownParent: $('#myModal_add'),
            url: base_url + "/api/menu/optionparent",
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
    $('.show-publish-menu').select2({
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

}


function validateMenuNameUpdate(name) {
    var val = document.getElementById(name).value;
    if (val != '') {
        $('#name-menu-edit').removeClass('is-invalid');
        $('#name-menu-edit').addClass('is-valid');
        $('#button-update-menu').removeClass('disabled')
    } else {
        $('#name-menu-edit').removeClass('is-valid');
        $('#name-menu-edit').addClass('is-invalid');
        $('#button-update-menu').addClass('disabled')
    }
}

function validateMenuCodeUpdate(name) {
    var val = document.getElementById(name).value;
    if (val != '') {
        $('#code-menu-edit').removeClass('is-invalid');
        $('#code-menu-edit').addClass('is-valid');
        $('#button-update-menu').removeClass('disabled')
    } else {
        $('#code-menu-edit').removeClass('is-valid');
        $('#code-menu-edit').addClass('is-invalid');
        $('#button-update-menu').addClass('disabled')
    }
}


function validateMenuUrlUpdate(name) {
    var val = document.getElementById(name).value;
    if (val != '') {
        $('#url-menu-edit').removeClass('is-invalid');
        $('#url-menu-edit').addClass('is-valid');
        $('#button-update-menu').removeClass('disabled')
    } else {
        $('#url-menu-edit').removeClass('is-valid');
        $('#url-menu-edit').addClass('is-invalid');
        $('#button-update-menu').addClass('disabled')
    }
}

$('#parent-menu-edit').on("change", function(e) {
    var val = $(this).val();
    if (val != 0) {
        $('#parent-menu-edit').removeClass('is-invalid');
        $('#parent-menu-edit').addClass('is-valid');
    }
    if (val == null) {
        $('#parent-menu-edit').addClass('is-invalid');
        $('#parent-menu-edit').removeClass('is-valid');
    }
});



$("#button-update-menu").click(function(e) {

    var dataSend = {
        menuid: $("#button-update-menu").attr("menuid"),
        menu_name: $("#name-menu-edit").val(),
        menu_code: $("#code-menu-edit").val(),
        menu_url: $("#url-menu-edit").val(),
        menu_parent: ($("#parent-menu-edit").val() == null) ? '' : $("#parent-menu-edit").val(),
        menu_status: ($("#menu-publish-edit").val() == null) ? '' : $("#menu-publish-edit").val(),
    }

    if (
        dataSend.menu_name == '' ||
        dataSend.menu_code == '' ||
        dataSend.menu_url == '' ||
        dataSend.menu_parent == '' ||
        dataSend.menu_status == '') {

        if (dataSend.menu_name == '') {
            $('#name-menu-edit').addClass('is-invalid');
        }
        if (dataSend.menu_code == '') {
            $('#code-menu-edit').addClass('is-invalid');
        }
        if (dataSend.menu_url == '') {
            $('#url-menu-edit').addClass('is-invalid');
        }
        if (dataSend.menu_parent == '') {
            $('#parent-menu-edit').addClass('is-invalid');
        }
        if (dataSend.menu_status == '') {
            $('#menu-publish-edit').addClass('is-invalid');
        }
        alertify.error('Pastikan form sudah terisih dengan baik');

    } else {


        $.ajax({
            type: "POST",
            url: base_url + "/api/menu/save",
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
                    $(".needs-validation").closest('form').find("input[type=text], textarea").val("");

                } else {
                    alertify.error('Error Internal');
                }

            }
        });
    }

});



$("#button-add-menu").click(function(e) {

    var dataSend = {
        menu_name: $("#name-menu-add").val(),
        menu_code: $("#code-menu-add").val(),
        menu_url: $("#url-menu-add").val(),
        menu_parent: ($("#menu-parent-add").val() == null) ? '' : $("#menu-parent-add").val(),
        menu_status: ($("#menu-publish-add").val() == null) ? '' : $("#menu-publish-add").val(),
    }

    if (
        dataSend.menu_name == '' ||
        dataSend.menu_code == '' ||
        dataSend.menu_url == '' ||
        dataSend.menu_parent == '' ||
        dataSend.menu_status == '') {

        if (dataSend.menu_name == '') {
            $('#name-menu-add').addClass('is-invalid');
        }
        if (dataSend.menu_code == '') {
            $('#code-menu-add').addClass('is-invalid');
        }
        if (dataSend.menu_url == '') {
            $('#url-menu-add').addClass('is-invalid');
        }
        if (dataSend.menu_parent == '') {
            $('#menu-parent-add').addClass('is-invalid');
        }
        if (dataSend.menu_status == '') {
            $('#menu-publish-add').addClass('is-invalid');
        }
        alertify.error('Pastikan form sudah terisih dengan baik');

    } else {

        $.ajax({
            type: "POST",
            url: base_url + "/api/menu/save",
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
                    $(".needs-validation").closest('form').find("input[type=text], textarea").val("");

                } else {
                    alertify.error('Error Internal');
                }

            }
        });
    }

});


function validateMenuNameAdd(name) {
    var val = document.getElementById(name).value;
    if (val != '') {
        $('#name-menu-add').removeClass('is-invalid');
        $('#name-menu-add').addClass('is-valid');
        $('#button-add-menu').removeClass('disabled')
    } else {
        $('#name-menu-add').removeClass('is-valid');
        $('#name-menu-add').addClass('is-invalid');
        $('#button-add-menu').addClass('disabled')
    }
}

function validateMenuCodeAdd(name) {
    var val = document.getElementById(name).value;
    if (val != '') {
        $('#code-menu-add').removeClass('is-invalid');
        $('#code-menu-add').addClass('is-valid');
        $('#button-add-menu').removeClass('disabled')
    } else {
        $('#code-menu-add').removeClass('is-valid');
        $('#code-menu-add').addClass('is-invalid');
        $('#button-add-menu').addClass('disabled')
    }
}


function validateMenuUrlAdd(name) {
    var val = document.getElementById(name).value;
    if (val != '') {
        $('#url-menu-add').removeClass('is-invalid');
        $('#url-menu-add').addClass('is-valid');
        $('#button-add-menu').removeClass('disabled')
    } else {
        $('#url-menu-add').removeClass('is-valid');
        $('#url-menu-edit').addClass('is-invalid');
        $('#button-add-menu').addClass('disabled')
    }
}


$('#menu-parent-add').on("change", function(e) {
    var val = $(this).val();
    if (val != 0) {
        $('#menu-parent-add').removeClass('is-invalid');
        $('#menu-parent-add').addClass('is-valid');
    }
    if (val == null) {
        $('#menu-parent-add').addClass('is-invalid');
        $('#menu-parent-add').removeClass('is-valid');
    }
});


$('#menu-publish-add').on("change", function(e) {
    var val = $(this).val();
    if (val != 0) {
        $('#menu-publish-add').removeClass('is-invalid');
        $('#menu-publish-add').addClass('is-valid');
    }
    if (val == null) {
        $('#menu-publish-add').addClass('is-invalid');
        $('#menu-publish-add').removeClass('is-valid');
    }
});


var tableDetail;
$(".close-detail-data").click(function(e) {
    tableDetail.destroy();
})