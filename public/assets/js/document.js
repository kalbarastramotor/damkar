var table;

$(document).ready(function() {
    var d = new Date();
    var year = d.getFullYear();





    table = $('#doc-table').DataTable({
        "lengthMenu": [
            [25, 50, -1],
            [25, 50, 'All'],
        ],
        "processing": true,
        "serverSide": true,
        "serverMethod": "POST",
        "columns": [
            { "title": 'No' },
            { "title": 'Document Number' },
            { "title": 'Year' },
            { "title": 'Month' },
            { "title": 'Budget' },
            { "title": 'Alokasi' },
            { "title": 'Event Target' },
            { "title": 'Action' },
        ],
        "dom": "<'row'<'col-sm-12 button-export'B>>",
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
                text: ' <select class="filter-year form-control"  style="width:100%" id="pilih-tahun"></select>',
                className: 'col-md-2 class-select2'
            },

        ],
        "order": [],
        "ajax": {
            "url": base_url + "/api/report/doc/data",
            "type": "POST",
            "data": function(data) {
                data.year = $('#pilih-tahun').val()
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
        "columnDefs": [{
            "targets": [0, 1, 2, 3, 4, 5],
            "orderable": false,
        }],
    });
    $('.filter-year').select2({
        placeholder: 'Tahun',
        allowClear: true,
        ajax: {
            url: base_url + "/api/filter/year",
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

    var $newOptionYear = $("<option selected='selected'></option>").val(parseInt(year)).text(year);
    $(".filter-year").append($newOptionYear).trigger('change');

    $('.filter-month').select2({
        placeholder: 'Bulan',
        allowClear: true,
        ajax: {
            url: base_url + "/api/filter/month",
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


    $('#pilih-tahun').change(function() {
        table.draw();
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
    });

    var newValue = null;
    $(document).on('blur', '.update', function() {
        var elem = $(this);
        newValue = $(this).val();
        var empId = $(this).parent().attr('id');
        var colName = $(this).parent().attr('name');

        if (newValue != oldValue) {

            var dataSend = {
                documentid: empId,
                column: colName,
                value: newValue,
            }
            $.ajax({
                url: base_url + "/api/report/doc/updatecolumn",
                method: 'POST',
                data: dataSend,
                async: false,
                headers: {
                    "Authorization": "Bearer " + token,
                },
                success: function(respone) {
                    $(elem).parent().addClass('editable');
                    if (colName == "budget") {
                        newValue = newValue.replace(",", "");
                        newValue = newValue.replace(".", "");
                        $(elem).parent().html("Rp." + formatRupiah(newValue));
                    } else {
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
            newValue = newValue.replace(",", "");
            newValue = newValue.replace(".", "");

            if (colName == "budget") {
                $(this).parent().html("Rp." + formatRupiah(newValue));
            } else {
                $(this).parent().html(newValue);
            }
        }
    });

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

function generate_document(year, month) {
    var dataSend = {
        nomerdoc: '000' + month,
        year: year,
        month: month,
        budget: 0,
        target: 0
    }
    $.ajax({
        type: "POST",
        url: base_url + "/api/report/doc/save",
        dataType: 'json',
        async: false,
        data: dataSend,
        headers: {
            "Authorization": "Bearer " + token,
        },
        success: function(e) {
            console.log(e)
            if (e.status.message == "OK") {
                alertify.success('Data berhasil di simpan');
                table.ajax.reload();
            } else {
                alertify.error('Error Internal');
            }

        }
    });
}