var table
function initMapAdd() {
    const myLatlng = { lat: -0.3235072, lng: 110.2813883 };
    const map_add = new google.maps.Map(document.getElementById("map_add"), {
        zoom: 8,
        center: myLatlng,
        search: true,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        mapTypeControlOptions: {
            style: google.maps.MapTypeControlStyle.DEFAULT
        }
    });

    let infoWindow = new google.maps.InfoWindow({
        content: "Click the map to get Lat/Lng!",
        position: myLatlng,
    });
   

    infoWindow.open(map_add);
    // Configure the click listener.
    map_add.addListener("click", (mapsMouseEvent) => {
        // Close the current InfoWindow.
        getLatLong = mapsMouseEvent.latLng.toJSON();

        $("#add-map-lat").val(getLatLong.lat);
        if(getLatLong.lat!=""){
            $('#add-map-lat').removeClass('is-invalid');
            $('#add-map-lat').addClass('is-valid');
        }
        $("#add-map-long").val(getLatLong.lng);
        if(getLatLong.lng!=""){
            $('#add-map-long').removeClass('is-invalid');
            $('#add-map-long').addClass('is-valid');
        }
        infoWindow.close();
        // Create a new InfoWindow.
        infoWindow = new google.maps.InfoWindow({
            position: mapsMouseEvent.latLng,
        });
        infoWindow.setContent(
            JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2)
        );
        infoWindow.open(map_add);

    });

    /// 
    
}

$(document).ready(function() {

    table = $('#office-table').DataTable({
        "lengthMenu": [
            [25, 50, -1],
            [25, 50,100],
        ],
        "processing": true,
        "serverSide": true,
        "columns": [
            { "title": 'No' },
            { "title": 'Code' },
            { "title": 'Name' },
            { "title": 'Phone' },
            { "title": 'Province' },
            { "title": 'City' },
            { "title": 'Address' },
            { "title": 'Option', "className": "text-center" },
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
            "url": base_url + "/api/office/data",
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
                "targets": [],
                "orderable": false,
            },
            {
                "targets": [7],
                "orderable": false,
                "className": "col-sm-2 text-center",
            },
            {
                "targets": [8],
                "visible": false
            },
        ],
        "createdRow": function(row, data, dataIndex) {
            if (data[8] == 0 || data[8] == "0") {
                $(row).addClass('table-danger');
            }
        },
    });

    $('#office-table tbody').on('click', 'button', function() {
        var data = table.row($(this).parents('tr')).data();
        $('#dealer-name').attr('value', data[2]);
        $('#dealer-code').attr('value', data[1]);
        $('#dealer-address').attr('value', data[7]);
        $('#dealer-province').attr('value', data[5]);
        $('#dealer-city').attr('value', data[6]);
        $('#dealer-map').attr('value', data[2]);

    });

  
});

function delete_dealer(id, name) {

    alertify.confirm(
        "Are you sure you want to delete this " + name + "?",
        function() {

            $.ajax({
                type: "POST",
                url: base_url + "/api/office/delete",
                dataType: 'json',
                async: false,
                data: {
                    officeid: id
                },
                headers: {
                    "Authorization": "Bearer " + token,
                },
                success: function(e) {

                    if (e.status.message == "OK") {
                        alertify.success('Data berhasil di hapus');
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

function initMap(la,lo) {
    const myLatlng = { lat: parseFloat(la), lng: parseFloat(lo) };
  
    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 8,
        center: myLatlng,
        search: true,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        mapTypeControlOptions: {
            style: google.maps.MapTypeControlStyle.DEFAULT
        }
    });

    let infoWindow = new google.maps.InfoWindow({
        content: JSON.stringify(myLatlng, null, 2),
        position: myLatlng,
    });
   

    infoWindow.open(map);
    // Configure the click listener.
    map.addListener("click", (mapsMouseEvent) => {
        // Close the current InfoWindow.
        getLatLong = mapsMouseEvent.latLng.toJSON();

        $("#update-map-lat").val(getLatLong.lat);
        if(getLatLong.lat!=""){
            $('#update-map-lat').removeClass('is-invalid');
            $('#update-map-lat').addClass('is-valid');
        }
        $("#update-map-long").val(getLatLong.lng);
        if(getLatLong.lng!=""){
            $('#update-map-long').removeClass('is-invalid');
            $('#update-map-long').addClass('is-valid');
        }
        infoWindow.close();
        // Create a new InfoWindow.
        infoWindow = new google.maps.InfoWindow({
            position: mapsMouseEvent.latLng,
        });
        infoWindow.setContent(
            JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2)
        );
        infoWindow.open(map);

    });
}

function getMap(officeid,lat,long){
    $('#myModal-maps').modal({ backdrop: 'static', keyboard: false });
    $('#myModal-maps').modal('show');

    $("#update-map-lat").val(lat);
    $("#update-map-long").val(long);
    $("#button-update-map").attr("officeid",officeid);

    initMap(lat,long)

}

$("#button-update-map").click(function(e) {
    var dataSend= {
        office_lat: $("#update-map-lat").val(),
        office_long: $("#update-map-long").val(),
    }
    var errorLog = new Array();

    if(dataSend.office_lat=="" || dataSend.office_long==""){
        $('#update-map-lat').addClass('is-invalid');
        $('#update-map-long').removeClass('is-invalid');
        errorLog.push('all');
    }else if(dataSend.office_lat==""){
        $('#update-map-lat').addClass('is-invalid');
        errorLog.push('lat');

    }else if(dataSend.office_long==""){
        $('#update-map-long').removeClass('is-invalid');
        errorLog.push('long');
    }
    if(errorLog.length > 0){
        alertify.error('Please insert latitude & longitude');
    }else{
        $.ajax({
            type: "POST",
            url: base_url + "/api/office/updatemaps/"+$('#button-update-map').attr("officeid"),
            dataType: 'json',
            data: dataSend,
            headers: {
                "Authorization": "Bearer " + token,
            },
            success: function(e) {
                if (e.status.message == "OK") {
                    alertify.success('Data berhasil di update');
                    $('#myModal-maps').modal('hide');
                    table.ajax.reload();
                    

                } else {
                    alertify.error('Error Internal');
                }

            },
            error:function(e){
                alertify.error('Error Internal');
            }
        });
    }
   

})

$('#update-map-long').on("keyup", function(e) {
    var val = $('#update-map-long').val();

    if (val >= 0 || val!="") {
        $('#update-map-long').removeClass('is-invalid');
        $('#update-map-long').addClass('is-valid');
    }
    if (val == null || val=="") {
        $('#update-map-long').addClass('is-invalid');
        $('#update-map-long').removeClass('is-valid');
    }
});

$('#update-map-lat').on("keyup", function(e) {
    var val = $('#update-map-lat').val();
    if (val >= 0 || val!="") {
        $('#update-map-lat').removeClass('is-invalid');
        $('#update-map-lat').addClass('is-valid');
    }
    if (val == null || val=="") {
        $('#update-map-lat').addClass('is-invalid');
        $('#update-map-lat').removeClass('is-valid');
    }
});


function lookup(arg){
var id = arg.getAttribute('id');
var value = arg.value;
console.log('====================================');
console.log(value);
console.log('====================================');

// do your stuff
}

function showModalAdd() {
    $('#myModal_add').modal({ backdrop: 'static', keyboard: false });
    $('#myModal_add').modal('show');


    // $(PostCodeid).autocomplete({
    //     source: function (request, response) {
    //         geocoder.geocode({
    //             'address': request.term
    //         }, function (results, status) {
    //             response($.map(results, function (item) {
    //                 return {
    //                     label: item.formatted_address,
    //                     value: item.formatted_address,
    //                     lat: item.geometry.location.lat(),
    //                     lon: item.geometry.location.lng()
    //                 };
    //             }));
    //         });
    //     },
    //     select: function (event, ui) {
    //         $('.search_addr').val(ui.item.value);
    //         $('.search_latitude').val(ui.item.lat);
    //         $('.search_longitude').val(ui.item.lon);
    //         var latlng = new google.maps.LatLng(ui.item.lat, ui.item.lon);
    //         marker.setPosition(latlng);
    //         initialize();
    //     }
    // });

    initMapAdd();
    $('.show-pic').select2({
        placeholder: 'PIC / Penanggung Jawab',
        allowClear: true,
        dropdownParent: $('#myModal_add'),
        ajax: {
            dropdownParent: $('#myModal_add'),
            url: base_url + "/datalist",
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

    $('.show-province').select2({
        placeholder: 'Provinsi',
        allowClear: true,
        dropdownParent: $('#myModal_add'),
        ajax: {
            dropdownParent: $('#myModal_add'),
            url: base_url + "/api/province",
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

    $('.show-city').select2({
        placeholder: 'Kota',
        allowClear: true,
        dropdownParent: $('#myModal_add'),
        ajax: {
            dropdownParent: $('#myModal_add'),
            url: base_url + "/api/city",
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

$("#button-add-office").click(function(e) {
    var dataSend = {
        office_code: $("#dealer-code-add").val(),
        office_name: $("#dealer-name-add").val(),
        office_phone: $("#dealer-phone-add").val(),
        office_province: ($("#dealer-province-add").val() == null) ? '' : $("#dealer-province-add").val(),
        office_city: ($("#dealer-city-add").val() == null) ? '' : $("#dealer-city-add").val(),
        office_address: $("#dealer-address-add").val(),
        office_lat: $("#add-map-lat").val(),
        office_long: $("#add-map-long").val(),
    }
  

    if (
        dataSend.office_code == '' ||
        dataSend.office_name == '' ||
        dataSend.office_phone == '' ||
        dataSend.office_province == '' ||
        dataSend.office_city == '' ||
        dataSend.office_address == '' ||
        dataSend.office_lat == '' || 
        dataSend.office_long == ''  
        ) {

        if (dataSend.office_code == '') {
            $('#dealer-code-add').addClass('is-invalid');
        }
        if (dataSend.office_name == '') {
            $('#dealer-name-add').addClass('is-invalid');
        }
        if (dataSend.office_phone == '') {
            $('#dealer-phone-add').addClass('is-invalid');
        }
        if (dataSend.office_province == '') {
            $('#dealer-province-add').addClass('is-invalid');
        }
        if (dataSend.office_city == '') {
            $('#dealer-city-add').addClass('is-invalid');
        }
        if (dataSend.office_address == '') {
            $('#dealer-address-add').addClass('is-invalid');
        }
        if (dataSend.office_lat == '') {
            $('#add-map-lat').addClass('is-invalid');
        }
        if (dataSend.office_long == '') {
            $('#add-map-long').addClass('is-invalid');
        }
        alertify.error('Pastikan form sudah terisih dengan baik');

    } else {
        $.ajax({
            type: "POST",
            url: base_url + "/api/office/save",
            dataType: 'json',
            async: false,
            data: dataSend,
            headers: {
                "Authorization": "Bearer " + token,
            },
            success: function(e) {
                if (e.status.message == "OK") {
                    alertify.success('Data berhasil di simpan');
                    table.ajax.reload();
                    $('#myModal_add').modal('hide');

                } else {
                    alertify.error('Error Internal');
                }

            }
        });
    }

});
// js validate


// update

function validateDealerCodeUpdate(name) {
    // var ok = 0;
    var dealerName = document.getElementById(name).value;
    if (dealerName != '') {
        $('#dealer-code-update').removeClass('is-invalid');
        $('#dealer-code-update').addClass('is-valid');
        $('#button-update-office').removeClass('disabled')

    } else {
        $('#dealer-code-update').removeClass('is-valid');
        $('#dealer-code-update').addClass('is-invalid');
        $('#button-update-office').addClass('disabled')
    }
}

function validateDealerNameUpdate(name) {
    // var ok = 0;
    var dealerName = document.getElementById(name).value;
    if (dealerName != '') {
        $('#dealer-name-update').removeClass('is-invalid');
        $('#dealer-name-update').addClass('is-valid');
        $('#button-update-office').removeClass('disabled')

    } else {
        $('#dealer-name-update').removeClass('is-valid');
        $('#dealer-name-update').addClass('is-invalid');
        $('#button-update-office').addClass('disabled')
    }
}


function validateDealerPhoneUpdate(name) {
    // var ok = 0;
    var dealerName = document.getElementById(name).value;
    if (dealerName != '') {
        $('#dealer-phone-update').removeClass('is-invalid');
        $('#dealer-phone-update').addClass('is-valid');
        $('#button-update-office').removeClass('disabled')

    } else {
        $('#dealer-phone-update').removeClass('is-valid');
        $('#dealer-phone-update').addClass('is-invalid');
        $('#button-update-office').addClass('disabled')
    }
}


function validateDealerAddressUpdate(name) {
    // var ok = 0;
    var dealerName = document.getElementById(name).value;
    if (dealerName != '') {
        $('#dealer-address-update').removeClass('is-invalid');
        $('#dealer-address-update').addClass('is-valid');
        $('#button-update-office').removeClass('disabled')

    } else {
        $('#dealer-address-update').removeClass('is-valid');
        $('#dealer-address-update').addClass('is-invalid');
        $('#button-update-office').addClass('disabled')
    }
}


$('#dealer-province-update').on("change", function(e) {
    var val = $(this).val();
    if (val != 0) {
        $('#dealer-province-update').removeClass('is-invalid');
        $('#dealer-province-update').addClass('is-valid');
    }
    if (val == null) {
        $('#dealer-province-update').addClass('is-invalid');
        $('#dealer-province-update').removeClass('is-valid');
    }
});

 

$('#dealer-city-update').on("change", function(e) {
    var val = $(this).val();
    if (val != 0) {
        $('#dealer-city-update').removeClass('is-invalid');
        $('#dealer-city-update').addClass('is-valid');
    }
    if (val == null) {
        $('#dealer-city-update').addClass('is-invalid');
        $('#dealer-city-update').removeClass('is-valid');
    }
});

 

// add 
$('#dealer-pic-add').on("change", function(e) {
    var val = $(this).val();
    if (val != 0) {
        $('#dealer-pic-add').removeClass('is-invalid');
        $('#dealer-pic-add').addClass('is-valid');
    }
    if (val == null) {
        $('#dealer-pic-add').addClass('is-invalid');
        $('#dealer-pic-add').removeClass('is-valid');
    }
});


$('#dealer-province-add').on("change", function(e) {
    var val = $(this).val();
    if (val != 0) {
        $('#dealer-province-add').removeClass('is-invalid');
        $('#dealer-province-add').addClass('is-valid');
    }
    if (val == null) {
        $('#dealer-province-add').addClass('is-invalid');
        $('#dealer-province-add').removeClass('is-valid');
    }
});

$('#dealer-city-add').on("change", function(e) {
    var val = $(this).val();
    if (val != 0) {
        $('#dealer-city-add').removeClass('is-invalid');
        $('#dealer-city-add').addClass('is-valid');
    }
    if (val == null) {
        $('#dealer-city-add').addClass('is-invalid');
        $('#dealer-city-add').removeClass('is-valid');
    }
});


$('#button-update-office').click(function() {

    var dataSend = {
        office_code: $("#dealer-code-update").val(),
        office_name: $("#dealer-name-update").val(),
        office_phone: $("#dealer-phone-update").val(),
        office_province: ($("#dealer-province-update").val() == null) ? '' : $("#dealer-province-update").val(),
        office_city: ($("#dealer-city-update").val() == null) ? '' : $("#dealer-city-update").val(),
        office_address: $("#dealer-address-update").val(), 
        office_id: $("#button-update-office").attr("officeid")
    }

    if (
        dataSend.office_code == '' ||
        dataSend.office_name == '' ||
        dataSend.office_phone == '' ||
        dataSend.office_province == '' ||
        dataSend.office_city == '' ||
        dataSend.office_address == '' 
        ) {

        if (dataSend.office_code == '') {
            $('#dealer-code-update').addClass('is-invalid');
        }
        if (dataSend.office_name == '') {
            $('#dealer-name-update').addClass('is-invalid');
        }
        if (dataSend.office_phone == '') {
            $('#dealer-phone-update').addClass('is-invalid');
        }
        if (dataSend.office_province == '') {
            $('#dealer-province-update').addClass('is-invalid');
        }
        if (dataSend.office_city == '') {
            $('#dealer-city-update').addClass('is-invalid');
        }
        if (dataSend.office_address == '') {
            $('#dealer-address-update').addClass('is-invalid');
        }
    
        alertify.error('Pastikan form sudah terisih dengan baik');

    } else {
        $.ajax({
            type: "POST",
            url: base_url + "/api/office/update",
            dataType: 'json',
            async: false,
            data: dataSend,
            headers: {
                "Authorization": "Bearer " + token,
            },
            success: function(e) {
                if (e.status.message == "OK") {
                    alertify.success('Data berhasil di simpan');
                    table.ajax.reload();
                    $('#myModal').modal('hide');

                } else {
                    alertify.error('Error Internal');
                }

            }
        });
    }


});


// validate add 


function validateDealerNameAdd(name) {
    var dealerName = document.getElementById(name).value;
    if (dealerName != '') {
        $('#dealer-name-add').removeClass('is-invalid');
        $('#dealer-name-add').addClass('is-valid');
        $('#button-add-office').removeClass('disabled')

    } else {
        $('#dealer-name-add').removeClass('is-valid');
        $('#dealer-name-add').addClass('is-invalid');
        $('#button-add-office').addClass('disabled')
    }
}


function validateDealerCodeAdd(name) {
    var dealerName = document.getElementById(name).value;
    if (dealerName != '') {
        $('#dealer-code-add').removeClass('is-invalid');
        $('#button-add-office').removeClass('disabled')
        $('#dealer-code-add').addClass('is-valid');

    } else {
        $('#dealer-code-add').removeClass('is-valid');
        $('#button-add-office').addClass('disabled')
        $('#dealer-code-add').addClass('is-invalid');
    }
}

function validateDealerPhoneAdd(name) {
    var dealerName = document.getElementById(name).value;
    if (dealerName != '') {
        $('#dealer-phone-add').removeClass('is-invalid');
        $('#button-add-office').removeClass('disabled')
        $('#dealer-phone-add').addClass('is-valid');

    } else {
        $('#dealer-phone-add').removeClass('is-valid');
        $('#button-add-office').addClass('disabled')
        $('#dealer-phone-add').addClass('is-invalid');
    }
}


function validateDealerAddressAdd(name) {
    var dealerName = document.getElementById(name).value;
    if (dealerName != '') {
        $('#dealer-address-add').removeClass('is-invalid');
        $('#button-add-office').removeClass('disabled')
        $('#dealer-address-add').addClass('is-valid');

    } else {
        $('#dealer-address-add').removeClass('is-valid');
        $('#button-add-office').addClass('disabled')
        $('#dealer-address-add').addClass('is-invalid');
    }
}

function validateDealerMapAdd(name) {
    var dealerName = document.getElementById(name).value;
    if (dealerName != '') {
        $('#dealer-map-add').removeClass('is-invalid');
        $('#button-add-office').removeClass('disabled')
        $('#dealer-map-add').addClass('is-valid');

    } else {
        $('#dealer-map-add').removeClass('is-valid');
        $('#button-add-office').addClass('disabled')
        $('#dealer-map-add').addClass('is-invalid');
    }
}
// lock
function edit_dealer(officeid,id){


   
    $('#myModal').modal({ backdrop: 'static', keyboard: false });
    $('#myModal').modal('show');

    $("#dealer-code-update").val($("#"+id).attr('office_code'));
    $("#dealer-name-update").val($("#"+id).attr('office_name'));
    $("#dealer-phone-update").val($("#"+id).attr('office_phone'));
    $("#dealer-address-update").val($("#"+id).attr('office_address'));

    $("#dealer-code-update").val($("#"+id).attr('office_code'));
    $("#dealer-code-update").val($("#"+id).attr('office_code'));
    $("#dealer-code-update").val($("#"+id).attr('office_code'));

    $("#button-update-office").attr("officeid",officeid)
    $('.pic-update').select2({
        placeholder: 'PIC / Penanggung Jawab',
        allowClear: true,
        dropdownParent: $('#myModal'),
        ajax: {
            dropdownParent: $('#myModal'),
            url: base_url + "/datalist",

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
                        more: true
                    }
                };
            },
            cache: true
        }
    });
    $newOptionPublish = $("<option selected='selected'></option>").val($("#"+id).attr('office_address')).text($("#"+id).attr('office_address'));
    $(".pic-update").append($newOptionPublish).trigger('change');

    $('.province-update').select2({
        placeholder: 'Provinsi',
        allowClear: true,
        dropdownParent: $('#myModal'),
        ajax: {
            dropdownParent: $('#myModal'),
            url: base_url + "/api/province",
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

    $provinceUpdate = $("<option selected='selected'></option>").val($("#"+id).attr('office_province')).text($("#"+id).attr('office_province_name'));
    $(".province-update").append($provinceUpdate).trigger('change');

    $('.city-update').select2({
        placeholder: 'Kota',
        allowClear: true,
        dropdownParent: $('#myModal'),
        ajax: {
            dropdownParent: $('#myModal'),
            url: base_url + "/api/city",
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


    $cityUpdate = $("<option selected='selected'></option>").val($("#"+id).attr('office_city')).text($("#"+id).attr('office_city_name'));
    $(".city-update").append($cityUpdate).trigger('change');
}
function lock_office(id,status,name){
    alertify.confirm(
        "Are you sure you want to lock this " + name + "?",
        function() {

            $.ajax({
                type: "POST",
                url: base_url + "/api/office/lock",
                dataType: 'json',
                async: false,
                data: {
                    officeid: id,
                    status: (status==0 ) ? 1 :0
                },
                headers: {
                    "Authorization": "Bearer " + token,
                },
                success: function(e) {

                    if (e.status.message == "OK") {
                        alertify.success('Data berhasil di lock');
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