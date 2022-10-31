$(document).ready(function() {
    $.fn.dataTable.ext.errMode = 'none';

    $.ajax({
        type: "GET",
        url: base_url + "/datacategory",
        dataType: 'json',
        async: false,
        headers: {
            "Authorization": "Bearer " + token,
        },
        success: function(e) {
            var html = ""
            e.forEach((data, i) => {
                $("#title-category-" + i).html(data.name)
                $("#table-category-data-" + i).css({ "width": "100%" });


            });
        }
    });
    var totaldata1 = 0
    var totaldata2 = 0
    var totaldata3 = 0
    var totaldataPending = 0
    var totaldataApprove = 0
    var totaldataRejected = 0
    var totaldataRunning = 0
    var totaldataDone = 0
    var totaldataDraft = 0
    var table0 = $('#table-category-data-0').DataTable({
        lengthMenu: [
            [50, -1],
            [50, 'All'],
        ],

        dom: "<'row'<'col-sm-4'><'col-sm-8 button-export'>>",
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
            url: base_url + "/api/report/doc/event/category",
            headers: {
                "Authorization": "Bearer " + token,
            },
            data: function(e) {
                e.tahun = tahun,
                    e.bulan = bulan,
                    e.documentid = documentid,
                    e.categoryid = 1,

                    e.officeid = $(".filter-office").val()
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

        createdRow: function(row, data, dataIndex) {

            totaldata1 = totaldata1 + parseInt(data[18]);

            if (data[17] == 1 || data[17] == "1") {

                totaldataPending = totaldataPending + 1;

            } else if (data[17] == 2 || data[17] == "2") {

                totaldataApprove = totaldataApprove + 1;
            } else if (data[17] == 3 || data[17] == "3") {

                totaldataRejected = totaldataRejected + 1;
            } else if (data[17] == 4 || data[17] == "4") {

                totaldataRunning = totaldataRunning + 1;
            } else if (data[17] == 5 || data[17] == "5") {

                totaldataDone = totaldataDone + 1;
            } else if (data[17] == 0 || data[17] == "0") {

                totaldataDraft = totaldataDraft + 1;
            }
            let number = totaldata1;
            let nf = new Intl.NumberFormat('en-ID');
            nf.format(number);


            $("#total-01").html("Rp." + nf.format(number))
            $("#total-data-pending").html(totaldataPending + " Event")
            $("#total-data-approve").html(totaldataApprove + " Event")
            $("#total-data-rejected").html(totaldataRejected + " Event")
            $("#total-data-running").html(totaldataRunning + " Event")
            $("#total-data-done").html(totaldataDone + " Event")
            $("#total-data-draft").html(totaldataDraft + " Event")

        },
        columnDefs: [{
                targets: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16],
                orderable: false,
                className: "text-center",
            }

        ]
    });
    var table1 = $('#table-category-data-1').DataTable({
        lengthMenu: [
            [50, -1],
            [50, 'All'],
        ],

        dom: "<'row'<'col-sm-4'><'col-sm-8 button-export'>>",
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
            url: base_url + "/api/report/doc/event/category",
            headers: {
                "Authorization": "Bearer " + token,
            },
            data: function(e) {
                e.tahun = tahun,
                    e.bulan = bulan,
                    e.documentid = documentid,
                    e.categoryid = 2,

                    e.officeid = $(".filter-office").val()
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
        createdRow: function(row, data, dataIndex) {
            totaldata2 = totaldata2 + parseInt(data[18]);

            if (data[17] == 1 || data[17] == "1") {

                totaldataPending = totaldataPending + 1;

            } else if (data[17] == 2 || data[17] == "2") {

                totaldataApprove = totaldataApprove + 1;
            } else if (data[17] == 3 || data[17] == "3") {

                totaldataRejected = totaldataRejected + 1;
            } else if (data[17] == 4 || data[17] == "4") {

                totaldataRunning = totaldataRunning + 1;
            } else if (data[17] == 5 || data[17] == "5") {

                totaldataDone = totaldataDone + 1;
            } else if (data[17] == 0 || data[17] == "0") {

                totaldataDraft = totaldataDraft + 1;
            }


            let number = totaldata2;
            let nf = new Intl.NumberFormat('en-ID');
            nf.format(number);

            $("#total-02").html("Rp." + nf.format(number))
            $("#total-data-pending").html(totaldataPending + " Event")
            $("#total-data-approve").html(totaldataApprove + " Event")
            $("#total-data-rejected").html(totaldataRejected + " Event")
            $("#total-data-running").html(totaldataRunning + " Event")
            $("#total-data-done").html(totaldataDone + " Event")
            $("#total-data-draft").html(totaldataDraft + " Event")

        },
        columnDefs: [{
                targets: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16],
                orderable: false,
                className: "text-center",
            }

        ]
    });
    var table2 = $('#table-category-data-2').DataTable({
        lengthMenu: [
            [50, -1],
            [50, 'All'],
        ],

        dom: "<'row'<'col-sm-4'><'col-sm-8 button-export'>>",
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
            url: base_url + "/api/report/doc/event/category",
            headers: {
                "Authorization": "Bearer " + token,
            },
            data: function(e) {
                e.tahun = tahun,
                    e.bulan = bulan,
                    e.documentid = documentid,
                    e.categoryid = 3,

                    e.officeid = $(".filter-office").val()
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
        createdRow: function(row, data, dataIndex) {
            totaldata3 = totaldata3 + parseInt(data[18]);

            if (data[17] == 1 || data[17] == "1") {

                totaldataPending = totaldataPending + 1;

            } else if (data[17] == 2 || data[17] == "2") {

                totaldataApprove = totaldataApprove + 1;
            } else if (data[17] == 3 || data[17] == "3") {

                totaldataRejected = totaldataRejected + 1;
            } else if (data[17] == 4 || data[17] == "4") {

                totaldataRunning = totaldataRunning + 1;
            } else if (data[17] == 5 || data[17] == "5") {

                totaldataDone = totaldataDone + 1;
            } else if (data[17] == 0 || data[17] == "0") {

                totaldataDraft = totaldataDraft + 1;
            }


            $("#total-03").html(totaldata3)
            let number = totaldata3;
            let nf = new Intl.NumberFormat('en-ID');
            nf.format(number);

            $("#total-03").html("Rp." + nf.format(number))
            $("#total-data-pending").html(totaldataPending + " Event")
            $("#total-data-approve").html(totaldataApprove + " Event")
            $("#total-data-rejected").html(totaldataRejected + " Event")
            $("#total-data-running").html(totaldataRunning + " Event")
            $("#total-data-done").html(totaldataDone + " Event")
            $("#total-data-draft").html(totaldataDraft + " Event")

        },
        columnDefs: [{
                targets: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16],
                orderable: false,
                className: "text-center",
            }

        ]
    });

    var oldValue = null;
    $(document).on('dblclick', '.editable', function() {
        oldValue = $(this).html();
        $(this).removeClass('editable'); // to stop from making repeated request
        $(this).html('<input type="text" class="form-control update" value="' + oldValue + '" />');
        $(this).find('.update').focus();
    });
    var newValue = null;
    $(document).on('blur', '.update', function() {
        var elem = $(this);
        newValue = $(this).val();
        var empId = $(this).parent().attr('id');
        var colName = $(this).parent().attr('name');
        var targetActualProspect = $(this).parent().attr('target_actual_prospect');
        var targetProspect = $(this).parent().attr('target_prospect');

        if (newValue != oldValue) {

            if (colName == "target_prospect") {
                empId = empId.replace("id_target_prospect_", "");
            } else if (colName == "target_actual_prospect") {
                empId = empId.replace("id_target_actual_prospect_", "");
            }
            var dataSend = {
                eventID: empId,
                columnName: colName,
                value: newValue,
            }

            checkVal = Number.isInteger(newValue)

            if (!isNaN(newValue)) {
                $.ajax({
                    url: base_url + "/api/report/doc/event/updatecolumn",
                    method: 'POST',
                    data: dataSend,
                    async: false,
                    headers: {
                        "Authorization": "Bearer " + token,
                    },
                    success: function(respone) {
                        alertify.success('Data berhasil diupdate');

                        if (colName == "target_actual_prospect") {
                            if (parseInt(newValue) == 0) {
                                $("#presentase_prospect_" + empId).html("0%");
                            } else {

                                if (targetProspect < newValue) {
                                    var pre = Math.round((parseInt(newValue) * 100) / parseInt(targetProspect));
                                    if(pre >= 100){
                                        $("#presentase_prospect_" + empId).html("100%");
                                    }else{
                                        $("#presentase_prospect_" + empId).html(pre+"%");
                                    }
                                } else {
                                    var pre = Math.round((parseInt(newValue) * 100) / parseInt(targetProspect));
                                    $("#presentase_prospect_" + empId).html(pre + "%");
                                }

                            }
                            $(elem).parent().attr("target_actual_prospect", newValue);
                            $(elem).parent().attr("target_prospect", targetProspect);
                            $("#id_target_prospect_" + empId).attr("target_actual_prospect", newValue);
                            $(elem).parent().addClass('editable');
                            $(elem).parent().html(newValue);


                        } else if (colName == "target_prospect") {

                            if (parseInt(newValue) == 0) {
                                $("#presentase_prospect_" + empId).html("0%");

                            } else {

                                if (targetActualProspect > newValue) {
                                    var pre = Math.round((parseInt(targetActualProspect) * 100) / parseInt(newValue));
                                    if(pre >= 100){
                                        $("#presentase_prospect_" + empId).html("100%");
                                    }else{
                                        $("#presentase_prospect_" + empId).html(pre+"%");
                                    }
                                } else {
                                    
                                    var pre = Math.round((parseInt(targetActualProspect) * 100) / parseInt(newValue));
                                    $("#presentase_prospect_" + empId).html(pre + "%");

                                }

                            }
                            $(elem).parent().attr("target_actual_prospect", targetActualProspect);
                            $(elem).parent().attr("target_prospect", newValue);
                            $(elem).parent().addClass('editable');
                            $(elem).parent().html(newValue);
                            $("#id_target_actual_prospect_" + empId).attr("target_prospect", newValue);


                        } else {
                            $(elem).parent().addClass('editable');
                            $(elem).parent().html(newValue);
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
            } else {
                $(elem).parent().addClass('editable');
                $(elem).parent().html(oldValue);
                alertify.error('Hanya bisa di isi angka');


            }

        } else {
            $(elem).parent().addClass('editable');
            $(this).parent().html(newValue);
        }
    });

    $('.filter-office').select2({
        placeholder: 'Dealear',
        allowClear: true,
        ajax: {
            url: base_url + "/off",
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


    $('.filter-office').on("change", function(e) {
        var val = $(this).val();
        table0.ajax.reload();
        table1.ajax.reload();
        table2.ajax.reload();

        if (table0.data().count() === 0) {
            totaldata1 = 0 //always alerts this even if there are child rows
            totaldata2 = 0 //always alerts this even if there are child rows
            totaldata3 = 0 //always alerts this even if there are child rows
            totaldataPending = 0
            totaldataApprove = 0
            totaldataRejected = 0
            totaldataRunning = 0
            totaldataDone = 0
            totaldataDraft = 0
            $("#total-data-pending").html(totaldataPending + " Event")
            $("#total-data-approve").html(totaldataApprove + " Event")
            $("#total-data-rejected").html(totaldataRejected + " Event")
            $("#total-data-running").html(totaldataRunning + " Event")
            $("#total-data-done").html(totaldataDone + " Event")
            $("#total-data-draft").html(totaldataDraft + " Event")
            $("#total-01").html("Rp." + totaldata1)
            $("#total-02").html("Rp." + totaldata2)
            $("#total-03").html("Rp." + totaldata3)
        } else {
            totaldata1 = 0 //always alerts this even if there are child rows
            totaldata2 = 0 //always alerts this even if there are child rows
            totaldata3 = 0 //always alerts this even if there are child rows
            totaldataPending = 0
            totaldataApprove = 0
            totaldataRejected = 0
            totaldataRunning = 0
            totaldataDone = 0
            totaldataDraft = 0
            $("#total-data-pending").html(totaldataPending + " Event")
            $("#total-data-approve").html(totaldataApprove + " Event")
            $("#total-data-rejected").html(totaldataRejected + " Event")
            $("#total-data-running").html(totaldataRunning + " Event")
            $("#total-data-done").html(totaldataDone + " Event")
            $("#total-data-draft").html(totaldataDraft + " Event")
            $("#total-01").html("Rp." + totaldata1)
            $("#total-02").html("Rp." + totaldata2)
            $("#total-03").html("Rp." + totaldata3)
        }
        if (val != 0) {

            // $("#table-detail-office").css({ "display": "inline" });
            $('#parent-menu-edit').removeClass('is-invalid');
            $('#parent-menu-edit').addClass('is-valid');
        }
        if (val == null) {
            // $("#table-detail-office").css({ "display": "none" });
            $('#parent-menu-edit').addClass('is-invalid');
            $('#parent-menu-edit').removeClass('is-valid');
        }
    });






});



function getFormUpload(eventid, days, dateStart, tanggal) {
    $('#modal_upload_report').modal('show');
    var html = "";
    var tanggalStart = parseInt(tanggal)

    $.ajax({
        url: base_url + "/api/report/doc/event/activity",
        type: 'POST',
        dataType: 'json',
        headers: {
            "Authorization": "Bearer " + token,
        },
        data: {
            tanggal: parseInt(tanggal),
            startdate: dateStart,
            days: days,
            eventid: eventid
        },
        success: function(e) {
            // dataUpload.push(e);

            e.forEach(function(item, key) {
                var images = "";
                var deletetext = "";
                if (item.images != null) {
                    images = '<img class="img-thumbnail" alt="200x200"  width="200" src="' + item.images + '" data-holder-rendered="true" />';
                    deletetext = '<a href="#" class="text-danger p-2 d-inline-block" data-toggle="tooltip" onclick="delete_image(\'show_image_' + eventid + `--` + item.date + '_delete\')" data-placement="top" title="Delete"><i class="fas fa-trash-alt"></i></a>';
                }
                html += '<tr>' +
                    ' <th scope="row">' + (key + 1) + '</th>' +
                    ' <td>' +
                    ' <div>' +
                    '     <input class="form-control" placeholder="Date Event" value="' + item.date + '" type="text" readonly="">' +
                    ' </div>' +
                    '</td>' +
                    '<td>' +
                    '     <div>' +
                    '      <input class="form-control upload-foto-report" onchange="loadFile(event)" id="input_show_image_' + eventid + `--` + item.date + '"  type="file" placeholder="Enter Description" rows="2">' +
                    '  </div>' +
                    '  </td>' +

                    '  <td>' +
                    '   <div id="show_image_' + eventid + `--` + item.date + '">' +
                    '      ' + images +
                    '   </div>' +
                    ' </td>' +
                    ' <td>' +
                    '  <div class="text-center" id="show_image_' + eventid + `--` + item.date + '_delete">' +
                    '    ' + deletetext +
                    '     </div>' +
                    ' </td>' +
                    '</tr>';

            })
            $("#datail_form").html(html);

            // grid["aku"] = 10000

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


}

function delete_image(id) {

    idshow = id.replace("_delete", "");
    idinput = "input_" + id.replace("_delete", "");

    $("#" + idshow).html("")
    $("#" + id).html("")
    $("#" + idinput).val("");


    $.ajax({
        url: base_url + "/api/report/doc/event/deletefile",
        dataType: 'json',
        headers: {
            "Authorization": "Bearer " + token,
        },
        data: {
            id: id
        },
        type: 'post',
        success: function(e) {
            // if (e.status.message == "OK") {
            //     alertify.success('Upload File Success');
            // } else {
            //     alertify.error('Error Internal');
            // }
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
    // $path_to_file = '/project/folder/file_to_delete';
    // if(unlink($path_to_file)) {
    //     echo 'deleted successfully';
    // }
    // else {
    //     echo 'errors occured';
    // }
    // delete file
}

function loadFile(event) {
    console.log(event.target.files[0]);
    id = event.target.id
    valuee = $("#" + event.target.id).val();
    var tmppath = URL.createObjectURL(event.target.files[0]);
    $("#" + id.replace("input_", "")).html('<img class="img-thumbnail" alt="200x200"  width="200" src="' + tmppath + '" data-holder-rendered="true" />');
    $("#" + id.replace("input_", "") + "_delete").html('<a href="#" class="text-danger p-2 d-inline-block" data-toggle="tooltip" onclick="delete_image(\'' + id.replace("input_", "") + "_delete" + ' \')" data-placement="top" title="Delete"><i class="fas fa-trash-alt"></i></a>');


    var file_data = $('#' + id).prop('files')[0];
    var form_data = new FormData();
    form_data.append('berkas', file_data);
    form_data.append('id', id);

    $.ajax({
        url: base_url + "/api/report/doc/event/upload",
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        headers: {
            "Authorization": "Bearer " + token,
        },
        data: form_data,
        type: 'post',
        success: function(e) {
            if (e.status.message == "OK") {
                alertify.success('Upload File Success');
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
}

function showModalAdd() {
    $('#myModal_add').modal('show');
};