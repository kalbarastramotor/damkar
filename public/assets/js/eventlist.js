var table

$(document).ready(function() {
    dataEventlist();

    function dataEventlist() {
        table = $('#eventlist-table').DataTable({
            "processing": true,
            "serverSide": true,
            "columns": [
                { "title": 'ID' },
                { "title": 'Name Event' },
                { "title": 'Start Date' },
                { "title": 'End Date' },
                { "title": 'Category' },
                { "title": 'Butget' },
                { "title": 'Event Status' },
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
                "url": base_url + "/api/eventlist/data",
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

        $('#eventlist-table tbody').on('click', 'button', function() {
            var data = table.row($(this).parents('tr')).data();
            $('#eventlist-name').attr('value', data[1]);
            $('#eventlist-cover').attr('value', data[2]);

        });

    }

});

// Add Function //
function showModalAdd() {
    $('#myModal_add').modal('show');

}

$("#button-add-eventlist").click(function(e) {

    var dataSend = {
        date_start: $("#eventlist-start-date-add").val(),
        date_end: $("#eventlist-end-date-add").val(),
        name: $("#eventlist-name-add").val(),
        categoryid: $("#eventlist-categoryid-add").val(),
        location_lat: $("#eventlist-location-lat-add").val(),
        location_long: $("#eventlist-location-long-add").val(),
        month: $("#eventlist-month-add").val(),
        year: $("#eventlist-year-add").val(),
        target_visitor: $("#eventlist-target-visitor-add").val(),
        target_sell: $("#eventlist-target-sell-add").val(),
        butget: $("#eventlist-butget-add").val(),
        cover: $("#eventlist-cover-add").val(),
        description: $("#eventlist-description-add").val(),
    }

    if (
        dataSend.date_start == '' ||
        dataSend.date_end == '') {

        if (dataSend.date_start == '') {
            $('#eventlist-start-date-add').addClass('is-invalid');
        }
        if (dataSend.date_end == '') {
            $('#eventlist-end-date-add').addClass('is-invalid');
        }
        alertify.error('Pastikan form sudah terisih dengan baik');

    } else {

        $.ajax({
            type: "POST",
            url: base_url + "/api/eventlist/save",
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

    var eventlistCategory = $("#" + eventid).attr("categoryid");
    var $newOptionPublish = $("<option selected='selected'></option>").val(1).text("Roadshow");
    if (eventlistCategory == 0) {
        $newOptionPublish = $("<option selected='selected'></option>").val(0).text("Exibition");
    }
    if (eventlistCategory == 2) {
        $newOptionPublish = $("<option selected='selected'></option>").val(2).text("Showroom");
    } else {
        $newOptionPublish = $("<option selected='selected'></option>").val(1).text("Roadshow");
    }

    $(".show-publish-categoryid").append($newOptionPublish).trigger('change');

});
// End Add Function //

// -- Validate -- //
// ADD Validate //
function validateEventlistNameAdd(name) {
    var EventlistName = document.getElementById(name).value;
    if (EventlistName != '') {
        $('#eventlist-name-add').removeClass('is-invalid');
        $('#eventlist-name-add').addClass('is-valid');
        $('#button-add-eventlist').removeClass('disabled')
    } else {
        $('#eventlist-name-add').removeClass('is-valid');
        $('#eventlist-name-add').addClass('is-invalid');
        $('#button-add-eventlist').addClass('disabled')
    }
}

function validateEventlistCategoryAdd(name) {
    var EventcategoryCategory = document.getElementById(name).value;
    if (EventcategoryCategory != '') {
        $('#eventlist-categoryid-add').removeClass('is-invalid');
        $('#eventlist-categoryid-add').addClass('is-valid');
        $('#button-add-eventlist').removeClass('disabled')
    } else {
        $('#eventlist-categoryid-add').removeClass('is-valid');
        $('#eventlist-categoryid-add').addClass('is-invalid');
        $('#button-add-eventlist').addClass('disabled')
    }
}

// END Add Validate //
// -- End Validate -- //

// Delete Function //
function delete_eventcategory(id, name) {

    alertify.confirm(
        "Are you sure you want to delete kategory " + name + "?",
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
    //console.log(name);

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