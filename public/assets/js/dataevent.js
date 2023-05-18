var table;
function initMapsSearch(){
    const myLatlng = { lat: -0.3235072, lng: 110.2813883 };
    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 8,
        center: myLatlng,
        search: true,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        mapTypeControlOptions: {
            style: google.maps.MapTypeControlStyle.DEFAULT
        }
    });
    const input = document.getElementById("pac-input");
    const searchBox = new google.maps.places.SearchBox(input);

    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
    // Bias the SearchBox results towards current map's viewport.
    map.addListener("bounds_changed", () => {
        searchBox.setBounds(map.getBounds());
    });

    let markers = [];

  // Listen for the event fired when the user selects a prediction and retrieve
  // more details for that place.
    searchBox.addListener("places_changed", () => {
        const places = searchBox.getPlaces();
        if (places.length == 0) {
         return;
        }

        // Clear out the old markers.
        markers.forEach((marker) => {
        marker.setMap(null);
        });
        markers = [];

        // For each place, get the icon, name and location.
        const bounds = new google.maps.LatLngBounds();

        places.forEach((place) => {
            if (!place.geometry || !place.geometry.location) {
                console.log("Returned place contains no geometry");
                return;
            }

            const icon = {
                url: place.icon,
                size: new google.maps.Size(71, 71),
                origin: new google.maps.Point(0, 0),
                anchor: new google.maps.Point(17, 34),
                scaledSize: new google.maps.Size(25, 25),
            };

            // Create a marker for each place.
            markers.push(
                new google.maps.Marker({
                map,
                // icon,
                title: place.name,
                position: place.geometry.location,
                })
            );
            if (place.geometry.viewport) {
                // Only geocodes have viewport.
                bounds.union(place.geometry.viewport);
            } else {
                bounds.extend(place.geometry.location);
            }
        });
        map.fitBounds(bounds);
       
        
    });

    let infoWindow = new google.maps.InfoWindow({
        content: "Click the map to get Lat/Lng!",
        position: myLatlng,
    });
    infoWindow.open(map);

    map.addListener("click", (mapsMouseEvent) => {
        getLatLong = mapsMouseEvent.latLng.toJSON();

        $("#eventlist-location-lat-add").val(getLatLong.lat);
        if(getLatLong.lat!=""){
            $('#eventlist-location-lat-add').removeClass('is-invalid');
            $('#eventlist-location-lat-add').addClass('is-valid');
        }
        $("#eventlist-location-long-add").val(getLatLong.lng);
        if(getLatLong.lng!=""){
            $('#eventlist-location-long-add').removeClass('is-invalid');
            $('#eventlist-location-long-add').addClass('is-valid');
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

    })
}
function initMap() {
    const myLatlng = { lat: -0.3235072, lng: 110.2813883 };
    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 8,
        center: myLatlng,
        search: true,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        mapTypeControlOptions: {
            style: google.maps.MapTypeControlStyle.DEFAULT
        }
    });
    // Create the initial InfoWindow.
    let infoWindow = new google.maps.InfoWindow({
        content: "Click the map to get Lat/Lng!",
        position: myLatlng,
    });

    infoWindow.open(map);
    // Configure the click listener.
    map.addListener("click", (mapsMouseEvent) => {
        // Close the current InfoWindow.
        getLatLong = mapsMouseEvent.latLng.toJSON();

        $("#eventlist-location-lat-add").val(getLatLong.lat);
        if(getLatLong.lat!=""){
            $('#eventlist-location-lat-add').removeClass('is-invalid');
            $('#eventlist-location-lat-add').addClass('is-valid');
        }
        $("#eventlist-location-long-add").val(getLatLong.lng);
        if(getLatLong.lng!=""){
            $('#eventlist-location-long-add').removeClass('is-invalid');
            $('#eventlist-location-long-add').addClass('is-valid');
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

function initMapEdit(la,lo) {
    const myLatlng = { lat: la, lng: lo };
    const map = new google.maps.Map(document.getElementById("map_update"), {
        zoom: 8,
        center: myLatlng,
        search: true,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        mapTypeControlOptions: {
            style: google.maps.MapTypeControlStyle.DEFAULT
        }
    });
    const input = document.getElementById("pac-input-edit");
    const searchBox = new google.maps.places.SearchBox(input);

    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
    // Bias the SearchBox results towards current map's viewport.
    map.addListener("bounds_changed", () => {
        searchBox.setBounds(map.getBounds());
    });

    let markers = [];

  // Listen for the event fired when the user selects a prediction and retrieve
  // more details for that place.
    searchBox.addListener("places_changed", () => {
        const places = searchBox.getPlaces();
        if (places.length == 0) {
         return;
        }

        // Clear out the old markers.
        markers.forEach((marker) => {
        marker.setMap(null);
        });
        markers = [];

        // For each place, get the icon, name and location.
        const bounds = new google.maps.LatLngBounds();

        places.forEach((place) => {
            if (!place.geometry || !place.geometry.location) {
                console.log("Returned place contains no geometry");
                return;
            }

            const icon = {
                url: place.icon,
                size: new google.maps.Size(71, 71),
                origin: new google.maps.Point(0, 0),
                anchor: new google.maps.Point(17, 34),
                scaledSize: new google.maps.Size(25, 25),
            };

            // Create a marker for each place.
            markers.push(
                new google.maps.Marker({
                map,
                icon,
                title: place.name,
                position: place.geometry.location,
                })
            );
            if (place.geometry.viewport) {
                // Only geocodes have viewport.
                bounds.union(place.geometry.viewport);
            } else {
                bounds.extend(place.geometry.location);
            }
        });
        map.fitBounds(bounds);
       
        
    });

    let infoWindow = new google.maps.InfoWindow({
        content: "Click the map to get Lat/Lng!",
        position: myLatlng,
    });
    infoWindow.open(map);

    map.addListener("click", (mapsMouseEvent) => {
        getLatLong = mapsMouseEvent.latLng.toJSON();

        $("#eventlist-location-lat-update").val(getLatLong.lat);
        if(getLatLong.lat!=""){
            $('#eventlist-location-lat-update').removeClass('is-invalid');
            $('#eventlist-location-lat-update').addClass('is-valid');
        }
        $("#eventlist-location-long-update").val(getLatLong.lng);
        if(getLatLong.lng!=""){
            $('#eventlist-location-long-update').removeClass('is-invalid');
            $('#eventlist-location-long-update').addClass('is-valid');
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

    })

    // const myLatlng = { lat: la, lng: lo };
    // const map_update = new google.maps.Map(document.getElementById("map_update"), {
    //     zoom: 8,
    //     center: myLatlng,
    //     search: true,
    //     mapTypeId: google.maps.MapTypeId.ROADMAP,
    //     mapTypeControlOptions: {
    //         style: google.maps.MapTypeControlStyle.DEFAULT
    //     }
    // });
    // // Create the initial InfoWindow.
    // let infoWindow = new google.maps.InfoWindow({
    //     content: JSON.stringify(myLatlng, null, 2),
    //     position: myLatlng,
    // });

    // infoWindow.open(map_update);
    // // Configure the click listener.
    // map_update.addListener("click", (mapsMouseEvent) => {
    //     // Close the current InfoWindow.
    //     getLatLong = mapsMouseEvent.latLng.toJSON();

    //     $("#eventlist-location-lat-update").val(getLatLong.lat);
    //     if(getLatLong.lat!=""){
    //         $('#eventlist-location-lat-update').removeClass('is-invalid');
    //         $('#eventlist-location-lat-update').addClass('is-valid');
    //     }
    //     $("#eventlist-location-long-update").val(getLatLong.lng);
    //     if(getLatLong.lng!=""){
    //         $('#eventlist-location-long-update').removeClass('is-invalid');
    //         $('#eventlist-location-long-update').addClass('is-valid');
    //     }
    //     infoWindow.close();
    //     // Create a new InfoWindow.
    //     infoWindow = new google.maps.InfoWindow({
    //         position: mapsMouseEvent.latLng,
    //     });
    //     infoWindow.setContent(
    //         JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2)
    //     );
    //     infoWindow.open(map_update);


    // });
}



$(document).ready(function() {

    flatpickr("#eventlist-start-date-add", { enableTime: !0, dateFormat: "Y-m-d H:i" });
    flatpickr("#eventlist-end-date-add", { enableTime: !0, dateFormat: "Y-m-d H:i" });
    // $.fn.dataTable.ext.errMode = 'none';
    $('.filter-event').select2({
        placeholder: 'Dealear',
        allowClear: true,
        ajax: {
            url: base_url + "/eventstatus",
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
    $('.filter-category').select2({
        placeholder: 'Category',
        allowClear: true,
        ajax: {
            url: base_url + "/categoryoption",
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
    $('.filter-bulan').select2({
        placeholder: 'Bulan',
        allowClear: true,
        ajax: {
            url: base_url + "/bulan",
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
    table = $('#table-event-data').DataTable({
        lengthMenu: [
            [15, 25, 50,100],
            [15, 25, 50,100],
        ],

        dom: "<'row'<'col-sm-6'l><'col-sm-5'f><'col-sm-1'B>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-8'i><'col-sm-4'p>>",
        buttons: [{
                text: '<span onclick="showModalAdd()">Tambah <i  class="fas fa-plus"></i></span>',
                className: 'btn btn-warning'
            },

        ],
        processing: true,
        serverSide: true,
        "ajax": {
            "url": base_url + "/api/event/data",
            "type": "POST",
            "headers": {
                "Authorization": "Bearer " + token,
            },
            "data": function(e) {
                e.officeid = $(".filter-office").val(),
                    e.status = $(".filter-event").val(),
                    e.categoryid = $(".filter-category").val(),
                    e.year = $(".filter-year").val(),
                    e.month = $(".filter-bulan").val()
            }  ,
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
            "targets": [0, 2, 3, 4, 5, 6, 7],
            "className": "text-center",
        }, {
            "targets": [0, 1, 2, 3, 4, 7, 8],
            "orderable": false,
        }],
    });

});




$('.filter-office').on("change", function(e) {
    table.ajax.reload();
});
$('.filter-category').on("change", function(e) {
    table.ajax.reload();
});

$('#button-download-report').click(function(e) {


    
    officeid =  ($('.filter-office').val() == undefined ) ? '0': $('.filter-office').val();
    statusEvent =  ($('.filter-event').val() == undefined ) ? '0': $('.filter-event').val();
    category =  ($('.filter-category').val() == undefined ) ? '0': $('.filter-category').val();
    year =  ($('.filter-year').val() == undefined ) ? '0': $('.filter-year').val();
    bulan =  ($('.filter-bulan').val() == undefined ) ? '0': $('.filter-bulan').val();

    urldownload = base_url + "/lpj_activity/"+officeid+'/'+statusEvent+'/'+category+'/'+year+'/'+bulan+'/'+userid+'/'+rolecode+'/'+area;
    window.location.href = urldownload
    // alert(urldownload);
});

$('.filter-event').on("change", function(e) {
    
  
    table.ajax.reload();
});
$('.filter-year').on("change", function(e) {
    table.ajax.reload();
});
$('.filter-bulan').on("change", function(e) {
    table.ajax.reload();
});

function delete_event(id){
    alertify.confirm(
        "Are you sure you want to delete this event ?",
        function() {

            $.ajax({
                type: "POST",
                url: base_url + "/api/event/delete",
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
function detail_event(id) {
    $('#myModal_detail').modal({ backdrop: 'static', keyboard: false });
    $('#myModal_detail').modal('show');
    // alert(id);
    $.ajax({
        url: base_url + "/api/event/eventbyid",
        dataType: 'json',
        headers: {
            "Authorization": "Bearer " + token,
        },
        data: {
            id: id
        },
        type: 'post',
        success: function(e) {

            $("#id-dealer-code").text(e.data.office_code);
            $("#id-dealer-name").text(e.data.office_name);
            $("#id-event-name").text(e.data.name);
            $("#id-target-visitor").text(e.data.target_visitor);
            $("#id-target-sell").text(e.data.target_sell);

            $("#id-target-riding").text(e.data.target_riding);
            $("#id-actual-riding").text(e.data.actual_riding);
            

            $("#id-actual-sell").text(e.data.actual_sell);
            $("#id-actual-visitor").text(e.data.actual_visitor);


            $("#id-target-prospect-text").text(e.data.target_prospect);
            $("#id-target-actual-text").text(e.data.target_actual_prospect);

            if(parseInt(e.data.target_actual_prospect) == 0){
                $("#id-target-actual-persen").text("0%");   
            }else{
                var pre = Math.round((parseInt(e.data.target_actual_prospect) * 100) / parseInt(e.data.target_prospect));
                if(pre >= 100){
                    $("#id-target-actual-persen").text("100%");
                }else{
                    $("#id-target-actual-persen").text(pre+"%");
                }
            }


            $("#id-event-days").text(e.data.days + " Hari");
            $("#id-event-kategori").text(e.data.category_name);

            let number = e.data.butget;
            let nf = new Intl.NumberFormat('en-ID');
            nf.format(number);


            $("#id-event-biaya").html("Rp." + nf.format(number))

            $("#id-event-durasi").text(e.data.durasi);
            $("#id-event-status").html(e.data.status_event);
            $("#id-created-by").text(e.data.users.fullname);
            $("#id-event-action").html(e.data.action);
            $("#id-event-action-history").html(e.data.action_history);
            $("#id-event-cover").html('<a href="' + base_url+'/uploads/cover/'+e.data.cover+ '" target="_blank"><img class="img-thumbnail" alt="200x200"  width="200" src="' + base_url+'/uploads/cover/'+e.data.cover+ '" data-holder-rendered="true" /></a>');

            htmlDetail = "";
            e.detail.forEach(element => {
                htmlDetail += element.posisi;
            });

            $("#data-image").html(htmlDetail);

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

function getFormUpload(eventid, days, dateStart, tanggal) {
    $('#modal_upload_report').modal({ backdrop: 'static', keyboard: false });
    $('#modal_upload_report').modal('show');
    var html = "";
    var tanggalStart = parseInt(tanggal)
    $.ajax({
        url: base_url + "/api/event/eventbyid",
        type: 'POST',
        dataType: 'json',
        headers: {
            "Authorization": "Bearer " + token,
        },
        data: {
            id: eventid
        },
        success: function(e) {
            
            $("#id-target-visitor-report").text(e.data.target_visitor);
            $("#id-actual-visitor-report").text(e.data.actual_visitor);
            $("#id-actual-visitor-report").attr("eventid",eventid);
            $("#id-actual-visitor-report").attr("name","actual_visitor");

            $("#id-target-sell-report").text(e.data.target_sell);
            $("#id-actual-sell-report").text(e.data.actual_sell);
            $("#id-actual-sell-report").attr("eventid",eventid);
            $("#id-actual-sell-report").attr("name","actual_sell");


            $("#id-target-riding-report").text(e.data.target_riding);
            $("#id-target-riding-report").text(e.data.target_riding);
            $("#id-target-riding-report").attr("eventid",eventid);
            $("#id-target-riding-report").attr("name","target_riding");

            $("#id-actual-riding-report").text(e.data.actual_riding);
            $("#id-actual-riding-report").text(e.data.actual_riding);
            $("#id-actual-riding-report").attr("eventid",eventid);
            $("#id-actual-riding-report").attr("name","actual_riding");

            $("#target_prospect").text(e.data.target_prospect);
            $("#target_prospect").attr("eventid",eventid);
            $("#target_prospect").attr("name","target_prospect");

            $("#target_actual_prospect").text(e.data.target_actual_prospect);
            $("#target_actual_prospect").attr("eventid",eventid);
            $("#target_actual_prospect").attr("name","target_actual_prospect");


            if(parseInt(e.data.target_actual_prospect) == 0){
                $("#target_actual_prospect_persen").text("0%");   
            }else{
                var pre = Math.round((parseInt(e.data.target_actual_prospect) * 100) / parseInt(e.data.target_prospect));
                if(pre >= 100){
                    $("#target_actual_prospect_persen").text("100%");
                }else{
                  $("#target_actual_prospect_persen").text(pre+"%");
                }
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

function rejected(id) {
    $('#exampleModal').modal({ backdrop: 'static', keyboard: false });
    $('#exampleModal').modal('show');
    $('#button-reject').attr('eventid',id);
}

function show_history_status(id){
    $('#historyStatus').modal({ backdrop: 'static', keyboard: false });
    $('#historyStatus').modal('show');

    $.ajax({
        url: base_url + "/api/report/doc/event/history",
        dataType: 'json',
        headers: {
            "Authorization": "Bearer " + token,
        },
        data:{
            eventid:id
        },
        type: 'post',
        success: function(e) {
           var html;
           no =0;
           e.forEach((v,i) => {
            no++;
                html +='<tr>'+
                    '<th scope="row">'+(no)+'</th>'+
                    '<td>'+v.create_time+'</td>'+
                    '<td>'+v.userid+'</td>'+
                    '<td>'+v.notes+'</td>'+
                    '<td>'+v.status+'</td>'+
                '</tr>';
           });
           
           if(e.length==0){
            $("#detail-history-event").html('<tr><td style="text-align: center" colspan="5">No data</td></tr>');
           }else{
            $("#detail-history-event").html(html);

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

$("#button-reject").click(function(e) {
    var dataSend = {
        notes: $("#reject-note").val(),
        eventid: $("#button-reject").attr("eventid"),
        status: $("#button-reject").attr("status")
    }
    $('#spinner-div').show();
    $.ajax({
        url: base_url + "/api/report/doc/event/status",
        dataType: 'json',
        headers: {
            "Authorization": "Bearer " + token,
        },
        data:dataSend,
        type: 'post',
        success: function(e) {
            if (e.status.message == "OK") {
                alertify.success('Rejected');
            } else {
                alertify.error('Error Internal');
            }
            detail_event( $("#button-reject").attr("eventid"));
            table.ajax.reload();

            $('#exampleModal').modal('hide');

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

})

$(document).on('dblclick', '.editable', function() {
    oldValue = $(this).html();

    $(this).removeClass('editable'); // to stop from making repeated request
    $(this).html('<input type="text" class="form-control update" value="' + oldValue + '" />');
    $(this).find('.update').focus();
});

$(document).on('blur', '.update', function() {
    var elem = $(this);
    newValue = $(this).val();
    var empId = $(this).parent().attr('id');
    var eventid = $(this).parent().attr('eventid');
    var colName = $(this).parent().attr('name');

    
    // var targetActualProspect = $("#target_actual_prospect").parent().attr('target_actual_prospect');
    var targetActualProspect = $("#target_actual_prospect").text();
    var targetProspect = $("#target_prospect").text();
 
    if (newValue != oldValue) {

        if (colName == "target_prospect") {
            empId = empId.replace("id_target_prospect_", "");
        } else if (colName == "target_actual_prospect") {
            empId = empId.replace("id_target_actual_prospect_", "");
        }
        var dataSend = {
            eventID: eventid,
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
                            $("#target_actual_prospect_persen").html("0%");
                        } else {

                            if (targetProspect < newValue) {
                                var pre = Math.round((parseInt(newValue) * 100) / parseInt(targetProspect));
                                if(pre >= 100){
                                    $("#target_actual_prospect_persen").html("100%");
                                }else{
                                    $("#target_actual_prospect_persen").html(pre+"%");
                                }
                            
                            } else {
                                var pre = Math.round((parseInt(newValue) * 100) / parseInt(targetProspect));
                                if(pre >= 100){
                                    $("#target_actual_prospect_persen").html("100%");
                                }else{
                                    $("#target_actual_prospect_persen").html(pre+"%");
                                }
                            }

                        }
                        $(elem).parent().attr("target_actual_prospect", newValue);
                        $(elem).parent().attr("target_prospect", targetProspect);
                        $("#id_target_prospect_" + empId).attr("target_actual_prospect", newValue);
                        $(elem).parent().addClass('editable');
                        $(elem).parent().html(newValue);


                    } else if (colName == "target_prospect") {

                        if (parseInt(newValue) == 0) {
                            $("#target_actual_prospect_persen").html("0%");

                        } else {

                            if (targetActualProspect > newValue) {
                                var pre = Math.round((parseInt(targetActualProspect) * 100) / parseInt(newValue));
                                if(pre >= 100){
                                    $("#target_actual_prospect_persen").html("100%");
                                }else{
                                    $("#target_actual_prospect_persen").html(pre+"%");
                                }
                            } else {
                                
                                var pre = Math.round((parseInt(targetActualProspect) * 100) / parseInt(newValue));
                                if(pre >= 100){
                                    $("#target_actual_prospect_persen").html("100%");
                                }else{
                                    $("#target_actual_prospect_persen").html(pre+"%");
                                }
                            }

                        }
                        $(elem).parent().attr("target_actual_prospect", targetActualProspect);
                        $(elem).parent().attr("target_prospect", newValue);
                        $(elem).parent().addClass('editable');
                        $(elem).parent().html(newValue);
                        $("#id_target_actual_prospect_").attr("target_prospect", newValue);


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

// start button request event
function request_approve(id) {
    $('#modal-request-approve').modal({ backdrop: 'static', keyboard: false });
    $('#modal-request-approve').modal('show');
    $('#button-request').attr('eventid',id);

}


$("#button-request").click(function(e) {
    var dataSend = {
        notes: $("#request-note").val(),
        eventid: $("#button-request").attr("eventid"),
        status: $("#button-request").attr("status")
    }
    $('#spinner-div').show();
    $.ajax({
        url: base_url + "/api/report/doc/event/status",
        dataType: 'json',
        headers: {
            "Authorization": "Bearer " + token,
        },
        data:dataSend,
        type: 'post',
        success: function(e) {
            if (e.status.message == "OK") {
                $('#spinner-div').hide();
                alertify.success('Requested');

            } else {
                alertify.error('Error Internal');
            }
            detail_event( $("#button-request").attr("eventid"));
            table.ajax.reload();
            $('#modal-request-approve').modal('hide');

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

})

// stop button request event


// start button approve event
function approve(id) {
    $('#modal-approve').modal({ backdrop: 'static', keyboard: false });
    $('#modal-approve').modal('show');
    $('#button-approve').attr('eventid',id);

}


$("#button-approve").click(function(e) {
    var dataSend = {
        notes: $("#approve-note").val(),
        eventid: $("#button-approve").attr("eventid"),
        status: $("#button-approve").attr("status")
    }
    $('#spinner-div').show();
    $.ajax({
        url: base_url + "/api/report/doc/event/status",
        dataType: 'json',
        headers: {
            "Authorization": "Bearer " + token,
        },
        data:dataSend,
        type: 'post',
        success: function(e) {
            if (e.status.message == "OK") {
                $('#spinner-div').hide();
                alertify.success('Approved');
            } else {
                alertify.error('Error Internal');
            }
            detail_event( $("#button-approve").attr("eventid"));
            table.ajax.reload();

            $('#modal-approve').modal('hide');

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

})

// stop button approve event


function showModalAdd() {
    $('#myModal_add').modal({ backdrop: 'static', keyboard: false });
    $('#myModal_add').modal('show');
    $("#buat-search-box-maps").append('<input id="pac-input" class="controls form-control" type="text" placeholder="Cari Lokasi anda"/>');

    // initMap();
    initMapsSearch();
   

    // window.initMap = initMap;
    // window.addEventListener('load', initMap);
    $('.filter-office-add').select2({
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
    if(role['rolecode']=="staff"){
        $editoffice = $("<option selected='selected'></option>").val(office['officeid']).text(office['office_name']);
        $(".filter-office-add").append($editoffice).trigger('change');
        $("#dealer-show").attr("style","display:none;")
    }
    $('.filter-category-add').select2({
        placeholder: 'Category',
        allowClear: true,
        ajax: {
            dropdownParent: $('#myModal_add'),
            url: base_url + "/categoryoption",
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
    // $path_to_file = '/project/folder/file_to_delete';
    // if(unlink($path_to_file)) {
    //     echo 'deleted successfully';
    // }
    // else {
    //     echo 'errors occured';
    // }
    // delete file
}

// function UploadCover(event) {

// }

function loadFile(event) {
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


function loadFileCover(event) {
    id = event.target.id
    valuee = $("#" + event.target.id).val();
    var tmppath = URL.createObjectURL(event.target.files[0]);
    $("#display_cover").html('<img class="img-thumbnail" alt="200x200"  width="100%" src="' + tmppath + '" data-holder-rendered="true" />');
    $("#" + event.target.id).removeClass('is-invalid');
    $("#" + event.target.id).addClass('is-valid');
}

$("#button-add-eventlist").click(function(e) {

    var form_data = new FormData();
    var file_data = $('#eventlist-cover-add').prop('files')[0];
    var dataSend = {
        date_start: $("#eventlist-start-date-add").val(),
        date_end: $("#eventlist-end-date-add").val(),
        name: $("#eventlist-name-add").val(),
        categoryid: ($("#eventlist-categoryid-add").val()  == null) ? '' : $("#eventlist-categoryid-add").val(),
        officeid: ($("#eventlist-officeid-add").val()  == null) ? '' : $("#eventlist-officeid-add").val(),
        location_lat: $("#eventlist-location-lat-add").val(),
        location_long: $("#eventlist-location-long-add").val(),
        target_visitor: $("#eventlist-target-visitor-add").val(),
        target_sell: $("#eventlist-target-sell-add").val(),
        butget: $("#eventlist-butget-add").val(),
        description: $("#eventlist-description-add").val(),
        location: $("#eventlist-location-add").val(),
        file : (file_data == undefined ) ? '': file_data
        
    }

    form_data.append('name', dataSend.name);
    form_data.append('date_start', dataSend.date_start);
    form_data.append('date_end', dataSend.date_end);
    form_data.append('categoryid', dataSend.categoryid);
    form_data.append('officeid', dataSend.officeid);
    form_data.append('location_lat', dataSend.location_lat);
    form_data.append('location_long', dataSend.location_long);
    form_data.append('target_visitor', dataSend.target_visitor);
    form_data.append('target_sell', dataSend.target_sell);
    form_data.append('butget', dataSend.butget);
    form_data.append('description', dataSend.description);
    form_data.append('location', dataSend.location);
    form_data.append('cover', file_data);

    var errorLog = new Array();
    // if (dataSend.date_start == '' || dataSend.date_end == '') {

        if (dataSend.date_start == '') {
            $('#eventlist-start-date-add').addClass('is-invalid');
            errorLog.push('eventlist-start-date-add')
        }
        if (dataSend.date_end == '') {
            $('#eventlist-end-date-add').addClass('is-invalid');
            errorLog.push('eventlist-end-date-add')

        }
        if (dataSend.name == '') {
            $('#eventlist-name-add').addClass('is-invalid');
            errorLog.push('eventlist-name-add')

        }
        if (dataSend.categoryid == '') {
            $('#eventlist-categoryid-add').addClass('is-invalid');
            errorLog.push('eventlist-categoryid-add')

        }
        if (dataSend.officeid == '') {
            $('#eventlist-officeid-add').addClass('is-invalid');
            errorLog.push('eventlist-officeid-add')
        }
        if (dataSend.location_lat == '') {
            $('#eventlist-location-lat-add').addClass('is-invalid');
            errorLog.push('eventlist-location-lat-add')
        }
        if (dataSend.location_long == '') {
            $('#eventlist-location-long-add').addClass('is-invalid');
            errorLog.push('eventlist-location-long-add')
        }
        if (dataSend.target_visitor == '') {
            $('#eventlist-target-visitor-add').addClass('is-invalid');
            errorLog.push('eventlist-target-visitor-add')
        }
        if (dataSend.target_sell == '') {
            $('#eventlist-target-sell-add').addClass('is-invalid');
            errorLog.push('eventlist-target-sell-add')
        }
        if (dataSend.butget == '') {
            $('#eventlist-butget-add').addClass('is-invalid');
            errorLog.push('eventlist-butget-add')
        }
        if (dataSend.description == '') {
            $('#eventlist-description-add').addClass('is-invalid');
            errorLog.push('eventlist-description-add')
        }
        if (dataSend.location == '') {
            $('#eventlist-location-add').addClass('is-invalid');
            errorLog.push('eventlist-location-add')
        }
        if (dataSend.file == '') {
            $('#eventlist-cover-add').addClass('is-invalid');
            errorLog.push('eventlist-cover-add')
        }
  
        
        if(errorLog.length > 0){
             alertify.error('Pastikan form sudah terisih dengan baik');
        } else {

            $.ajax({
                type: "POST",
                url: base_url + "/api/eventlist/save",
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                headers: {
                    "Authorization": "Bearer " + token,
                },
                success: function(e) {
                    if (e.status.message == "OK") {
                        alertify.success('Data berhasil di simpan');
                        $('#myModal_add').modal('hide');
                        table.ajax.reload();
                        
                        // reset validation gui
                        $('#eventlist-start-date-add').removeClass('is-invalid');
                        $('#eventlist-start-date-add').removeClass('is-valid');

                        $('#eventlist-end-date-add').removeClass('is-invalid');
                        $('#eventlist-end-date-add').removeClass('is-valid');
                        
                        $('#eventlist-name-add').removeClass('is-invalid');
                        $('#eventlist-name-add').removeClass('is-valid');
                        
                        $('#eventlist-categoryid-add').removeClass('is-invalid');
                        $('#eventlist-categoryid-add').removeClass('is-valid');

                        $('#eventlist-officeid-add').removeClass('is-invalid');
                        $('#eventlist-officeid-add').removeClass('is-valid');

                        $('#eventlist-location-lat-add').removeClass('is-invalid');
                        $('#eventlist-location-lat-add').removeClass('is-valid');

                        $('#eventlist-location-long-add').removeClass('is-invalid');
                        $('#eventlist-location-long-add').removeClass('is-valid');
                        
                        $('#eventlist-target-visitor-add').removeClass('is-invalid');
                        $('#eventlist-target-visitor-add').removeClass('is-valid');
                        
                        $('#eventlist-target-sell-add').removeClass('is-invalid');
                        $('#eventlist-target-sell-add').removeClass('is-valid');
                        
                        $('#eventlist-butget-add').removeClass('is-invalid');
                        $('#eventlist-butget-add').removeClass('is-valid');

                        $('#eventlist-cover-add').removeClass('is-invalid');
                        $('#eventlist-cover-add').removeClass('is-valid');
                    
                        $('#eventlist-description-add').removeClass('is-invalid');
                        $('#eventlist-description-add').removeClass('is-valid');


                        $('#eventlist-location-add').removeClass('is-invalid');
                        $('#eventlist-location-add').removeClass('is-valid');

                        $('#display_cover').html('');
                        // reset validation gui

                        $(".needs-validation").closest('form').find("input[type=text],input[type=number],input[type=file],select, textarea").val("");


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

    // var eventlistCategory = $("#" + eventid).attr("categoryid");
    // var $newOptionPublish = $("<option selected='selected'></option>").val(1).text("Roadshow");
    // if (eventlistCategory == 0) {
    //     $newOptionPublish = $("<option selected='selected'></option>").val(0).text("Exibition");
    // }
    // if (eventlistCategory == 2) {
    //     $newOptionPublish = $("<option selected='selected'></option>").val(2).text("Showroom");
    // } else {
    //     $newOptionPublish = $("<option selected='selected'></option>").val(1).text("Roadshow");
    // }

    // $(".show-publish-categoryid").append($newOptionPublish).trigger('change');

});


$('#eventlist-start-date-add').on("change", function(e) {
    var val = $(this).val();
    if (val != 0) {
        $('#eventlist-start-date-add').removeClass('is-invalid');
        $('#eventlist-start-date-add').addClass('is-valid');
    }
    if (val == null) {
        $('#eventlist-start-date-add').addClass('is-invalid');
        $('#eventlist-start-date-add').removeClass('is-valid');
    }
});

$('#eventlist-end-date-add').on("change", function(e) {
    var val = $(this).val();
    if (val != 0) {
        $('#eventlist-end-date-add').removeClass('is-invalid');
        $('#eventlist-end-date-add').addClass('is-valid');
    }
    if (val == null) {
        $('#eventlist-end-date-add').addClass('is-invalid');
        $('#eventlist-end-date-add').removeClass('is-valid');
    }
});

function validatNameAdd(name) {
    var val = document.getElementById(name).value;
    if (val != 0) {
        $('#eventlist-name-add').removeClass('is-invalid');
        $('#eventlist-name-add').addClass('is-valid');
    }
    if (val == null || val == "") {
        $('#eventlist-name-add').addClass('is-invalid');
        $('#eventlist-name-add').removeClass('is-valid');
    }
}

$('#eventlist-location-long-add').on("change", function(e) {
    var val = $(this).val();
    if (val != 0) {
        $('#eventlist-location-long-add').removeClass('is-invalid');
        $('#eventlist-location-long-add').addClass('is-valid');
    }
    if (val == null) {
        $('#eventlist-location-long-add').addClass('is-invalid');
        $('#eventlist-location-long-add').removeClass('is-valid');
    }
});
$('#eventlist-target-visitor-add').on("keyup", function(e) {
    var val = $('#eventlist-target-visitor-add').val();
    if (val >= 0) {
        $('#eventlist-target-visitor-add').removeClass('is-invalid');
        $('#eventlist-target-visitor-add').addClass('is-valid');
    }
    if (val == null || val=="") {
        $('#eventlist-target-visitor-add').addClass('is-invalid');
        $('#eventlist-target-visitor-add').removeClass('is-valid');
    }
});
$('#eventlist-target-sell-add').on("keyup", function(e) {
    var val = $("#eventlist-target-sell-add").val();
   
    if (val >= 0) {
        $('#eventlist-target-sell-add').removeClass('is-invalid');
        $('#eventlist-target-sell-add').addClass('is-valid');
    }
    if (val == null || val=="") {
        $('#eventlist-target-sell-add').addClass('is-invalid');
        $('#eventlist-target-sell-add').removeClass('is-valid');
    }
});
$('#eventlist-butget-add').on("keyup", function(e) {
    var val = $("#eventlist-butget-add").val();
    if (val >= 0) {
        $('#eventlist-butget-add').removeClass('is-invalid');
        $('#eventlist-butget-add').addClass('is-valid');
    }
    if (val == null || val=="") {
        $('#eventlist-butget-add').addClass('is-invalid');
        $('#eventlist-butget-add').removeClass('is-valid');
    }
});


$('#eventlist-description-add').on("keyup", function(e) {
    var val = $("#eventlist-description-add").val();
    if (val != "") {
        $('#eventlist-description-add').removeClass('is-invalid');
        $('#eventlist-description-add').addClass('is-valid');
    }
    if (val == null || val=="") {
        $('#eventlist-description-add').addClass('is-invalid');
        $('#eventlist-description-add').removeClass('is-valid');
    }
});


$('#eventlist-location-add').on("keyup", function(e) {
    var val = $("#eventlist-location-add").val();
    if (val != "") {
        $('#eventlist-location-add').removeClass('is-invalid');
        $('#eventlist-location-add').addClass('is-valid');
    }
    if (val == null || val=="") {
        $('#eventlist-location-add').addClass('is-invalid');
        $('#eventlist-location-add').removeClass('is-valid');
    }
});


$('#eventlist-categoryid-add').on("change", function(e) {
    var val = $("#eventlist-categoryid-add").val();
    if (val != 0) {
        $('#eventlist-categoryid-add').removeClass('is-invalid');
        $('#eventlist-categoryid-add').addClass('is-valid');
    }
    if (val == null) {
        $('#eventlist-categoryid-add').addClass('is-invalid');
        $('#eventlist-categoryid-add').removeClass('is-valid');
    }
});


$('#eventlist-officeid-add').on("change", function(e) {
    var val = $("#eventlist-officeid-add").val();
    if (val != 0) {
        $('#eventlist-officeid-add').removeClass('is-invalid');
        $('#eventlist-officeid-add').addClass('is-valid');
    }
    if (val == null) {
        $('#eventlist-officeid-add').addClass('is-invalid');
        $('#eventlist-officeid-add').removeClass('is-valid');
    }
});

$('#eventlist-month-add').on("change", function(e) {
    var val = $("#eventlist-month-add").val();
    if (val != 0) {
        $('#eventlist-month-add').removeClass('is-invalid');
        $('#eventlist-month-add').addClass('is-valid');
    }
    if (val == null) {
        $('#eventlist-month-add').addClass('is-invalid');
        $('#eventlist-month-add').removeClass('is-valid');
    }
});

$('#eventlist-year-add').on("change", function(e) {
    var val = $("#eventlist-year-add").val();
    if (val != 0) {
        $('#eventlist-year-add').removeClass('is-invalid');
        $('#eventlist-year-add').addClass('is-valid');
    }
    if (val == null) {
        $('#eventlist-year-add').addClass('is-invalid');
        $('#eventlist-year-add').removeClass('is-valid');
    }
});
 
//  start edit show 


function edit_event(id) {

    flatpickr("#eventlist-start-date-update", { enableTime: !0, dateFormat: "Y-m-d H:i" });
    flatpickr("#eventlist-end-date-update", { enableTime: !0, dateFormat: "Y-m-d H:i" });



    $('#myModal_edit').modal({ backdrop: 'static', keyboard: false });
    $('#myModal_edit').modal('show');

    $('.filter-office-update').select2({
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
    $('.filter-category-update').select2({
        placeholder: 'Category',
        allowClear: true,
        ajax: {
            dropdownParent: $('#myModal_add'),
            url: base_url + "/categoryoption",
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
        url: base_url + "/api/event/eventbyid",
        dataType: 'json',
        headers: {
            "Authorization": "Bearer " + token,
        },
        data: {
            id: id
        },
        type: 'post',
        success: function(e) {


            $("#eventlist-start-date-update").val(e.data.date_start);
            $("#eventlist-end-date-update").val(e.data.date_end);
            $("#eventlist-name-update").val(e.data.name);
            $("#eventlist-location-lat-update").val(e.data.location_lat);
            $("#eventlist-location-long-update").val(e.data.location_long);
            $("#eventlist-target-visitor-update").val(e.data.target_visitor);
            $("#eventlist-target-sell-update").val(e.data.target_sell);
            $("#eventlist-butget-update").val(e.data.butget);
            $("#eventlist-description-update").html(e.data.description);
            $("#eventlist-description-update").val(e.data.description);
            $("#eventlist-location-update").html(e.data.location);
            $("#eventlist-location-update").val(e.data.location);

            $("#buat-search-box-maps-edit").append('<input id="pac-input-edit" class="controls form-control" type="text"  placeholder="Cari Lokasi anda"/>');

            initMapEdit(parseFloat(e.data.location_lat),parseFloat(e.data.location_long));

        
            $editcategory = $("<option selected='selected'></option>").val(e.data.categoryid).text(e.data.category_name);
            $(".filter-category-update").append($editcategory).trigger('change');

            $editoffice = $("<option selected='selected'></option>").val(e.data.officeid).text(e.data.office_name);
            $(".filter-office-update").append($editoffice).trigger('change');

            $("#display_cover_update").html('<img class="img-thumbnail" alt="200x200"  width="200" src="' + base_url+'/uploads/cover/'+e.data.cover+ '" data-holder-rendered="true" />');

            $("#button-update-eventlist").attr("eventid",e.data.eventid)


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


     // var eventlistCategory = $("#" + eventid).attr("categoryid");
    // var $newOptionPublish = $("<option selected='selected'></option>").val(1).text("Roadshow");
    // if (eventlistCategory == 0) {
    //     $newOptionPublish = $("<option selected='selected'></option>").val(0).text("Exibition");
    // }
    // if (eventlistCategory == 2) {
    //     $newOptionPublish = $("<option selected='selected'></option>").val(2).text("Showroom");
    // } else {
    //     $newOptionPublish = $("<option selected='selected'></option>").val(1).text("Roadshow");
    // }

   
  
   
}


$("#button-update-eventlist").click(function(e) {

    var form_data = new FormData();
    var file_data = $('#eventlist-cover-update').prop('files')[0];
    var dataSend = {
        date_start: $("#eventlist-start-date-update").val(),
        date_end: $("#eventlist-end-date-update").val(),
        name: $("#eventlist-name-update").val(),
        categoryid: ($("#eventlist-categoryid-update").val()  == null) ? '' : $("#eventlist-categoryid-update").val(),
        officeid: ($("#eventlist-officeid-update").val()  == null) ? '' : $("#eventlist-officeid-update").val(),
        location_lat: $("#eventlist-location-lat-update").val(),
        location_long: $("#eventlist-location-long-update").val(),
        target_visitor: $("#eventlist-target-visitor-update").val(),
        target_sell: $("#eventlist-target-sell-update").val(),
        butget: $("#eventlist-butget-update").val(),
        location: $("#eventlist-location-update").val(),
        description: $("#eventlist-description-update").val(),
        eventid: $("#button-update-eventlist").attr("eventid"),
        file : (file_data == undefined ) ? '': file_data
        
    }

    form_data.append('name', dataSend.name);
    form_data.append('date_start', dataSend.date_start);
    form_data.append('date_end', dataSend.date_end);
    form_data.append('categoryid', dataSend.categoryid);
    form_data.append('officeid', dataSend.officeid);
    form_data.append('location_lat', dataSend.location_lat);
    form_data.append('location_long', dataSend.location_long);
    form_data.append('target_visitor', dataSend.target_visitor);
    form_data.append('target_sell', dataSend.target_sell);
    form_data.append('butget', dataSend.butget);
    form_data.append('description', dataSend.description);
    form_data.append('location', dataSend.location);
    form_data.append('cover', file_data);


    var errorLog = new Array();

        if (dataSend.date_start == '') {
            $('#eventlist-start-date-update').addClass('is-invalid');
            errorLog.push('eventlist-start-date-update')
        }
        if (dataSend.date_end == '') {
            $('#eventlist-end-date-update').addClass('is-invalid');
            errorLog.push('eventlist-end-date-update')

        }
        if (dataSend.name == '') {
            $('#eventlist-name-update').addClass('is-invalid');
            errorLog.push('eventlist-name-update')

        }
        if (dataSend.categoryid == '') {
            $('#eventlist-categoryid-update').addClass('is-invalid');
            errorLog.push('eventlist-categoryid-update')

        }
        if (dataSend.officeid == '') {
            $('#eventlist-officeid-update').addClass('is-invalid');
            errorLog.push('eventlist-officeid-update')
        }
        if (dataSend.location_lat == '') {
            $('#eventlist-location-lat-update').addClass('is-invalid');
            errorLog.push('eventlist-location-lat-update')
        }
        if (dataSend.location_long == '') {
            $('#eventlist-location-long-update').addClass('is-invalid');
            errorLog.push('eventlist-location-long-update')
        }
        if (dataSend.target_visitor == '') {
            $('#eventlist-target-visitor-update').addClass('is-invalid');
            errorLog.push('eventlist-target-visitor-update')
        }
        if (dataSend.target_sell == '') {
            $('#eventlist-target-sell-update').addClass('is-invalid');
            errorLog.push('eventlist-target-sell-update')
        }
        if (dataSend.butget == '') {
            $('#eventlist-butget-update').addClass('is-invalid');
            errorLog.push('eventlist-butget-update')
        }
        if (dataSend.description == '') {
            $('#eventlist-description-update').addClass('is-invalid');
            errorLog.push('eventlist-description-update')
        }
        if (dataSend.location == '') {
            $('#eventlist-location-update').addClass('is-invalid');
            errorLog.push('eventlist-location-update')
        }
     
        
        if(errorLog.length > 0){
             alertify.error('Pastikan form sudah terisih dengan baik');
        } else {


       
            $.ajax({
                type: "POST",
                url: base_url + "/api/eventlist/update/"+dataSend.eventid,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                headers: {
                    "Authorization": "Bearer " + token,
                },
                success: function(e) {
                   
                    if (e.status.message == "OK") {
                        alertify.success('Update Data berhasil di simpan');
                        $('#myModal_edit').modal('hide');
                        table.ajax.reload();
                        
                        // reset validation gui
                        $('#eventlist-start-date-update').removeClass('is-invalid');
                        $('#eventlist-start-date-update').removeClass('is-valid');

                        $('#eventlist-end-date-update').removeClass('is-invalid');
                        $('#eventlist-end-date-update').removeClass('is-valid');
                        
                        $('#eventlist-name-update').removeClass('is-invalid');
                        $('#eventlist-name-update').removeClass('is-valid');
                        
                        $('#eventlist-categoryid-update').removeClass('is-invalid');
                        $('#eventlist-categoryid-update').removeClass('is-valid');

                        $('#eventlist-officeid-update').removeClass('is-invalid');
                        $('#eventlist-officeid-update').removeClass('is-valid');

                        $('#eventlist-location-lat-update').removeClass('is-invalid');
                        $('#eventlist-location-lat-update').removeClass('is-valid');

                        $('#eventlist-location-long-update').removeClass('is-invalid');
                        $('#eventlist-location-long-update').removeClass('is-valid');
                        
                        $('#eventlist-target-visitor-update').removeClass('is-invalid');
                        $('#eventlist-target-visitor-update').removeClass('is-valid');
                        
                        $('#eventlist-target-sell-update').removeClass('is-invalid');
                        $('#eventlist-target-sell-update').removeClass('is-valid');
                        
                        $('#eventlist-butget-update').removeClass('is-invalid');
                        $('#eventlist-butget-update').removeClass('is-valid');

                        $('#eventlist-cover-update').removeClass('is-invalid');
                        $('#eventlist-cover-update').removeClass('is-valid');
                    
                        $('#eventlist-description-update').removeClass('is-invalid');
                        $('#eventlist-description-update').removeClass('is-valid');


                        $('#eventlist-location-update').removeClass('is-invalid');
                        $('#eventlist-location-update').removeClass('is-valid');

                        $('#display_cover_update').html('');
                        // reset validation gui

                        $(".needs-validation").closest('form').find("input[type=text],input[type=number],input[type=file],select, textarea").val("");


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
                    }else{
                        alertify.error('Error Internal');

                    }
                }
            });
        }

   

});


// end edit show

