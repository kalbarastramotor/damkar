$(document).ready(function() {
    $('#table-category-data-cabang').DataTable({
        dom: "",
        processing: true,
        serverSide: true,
        ajax: {
            url: base_url + "/api/report/doc/event/cabang",
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

        columnDefs: [{
                targets: [],
                orderable: false,
                className: "text-center",
            }

        ]
    });
    $.ajax({
        type: "GET",
        url: base_url + "/dashboarddata",
        dataType: 'json',
        async: false,
        headers: {
            "Authorization": "Bearer " + token,
        },
        success: function(e) {
            e.forEach((element, index) => {
                if (index == 0) {
                    $("#total_1").html(element.total + '  <span class="text-success fw-medium font-size-14 align-middle"> <i class="mdi mdi-run-fast"></i>2.6 running </span>');
                } else if (index == 1) {
                    $("#total_2").html(element.total + '  <span class="text-success fw-medium font-size-14 align-middle"> <i class="mdi mdi-run-fast"></i>2.6 running </span>');
                } else if (index == 2) {
                    $("#total_3").html(element.total + '  <span class="text-success fw-medium font-size-14 align-middle"> <i class="mdi mdi-run-fast"></i>2.6 running </span>');
                }
            });

        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            const myJSON = JSON.parse(XMLHttpRequest.responseText)
            if (myJSON.error == "invalid_token") {
                localStorage.removeItem("token");
                location.href = base_url;
            }
        }
    });
});
var marker;
function initialize() {
   

    var infoWindow = new google.maps.InfoWindow;
    var latlng = new google.maps.LatLng(-0.3235072, 110.2813883);
    var mapOptions = {
        zoom: 8,
        center: latlng,
        search: true,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        mapTypeControlOptions: {
            style: google.maps.MapTypeControlStyle.DEFAULT
        }
    };
    var peta = new google.maps.Map(document.getElementById('googleMap'), mapOptions);
    var bounds = new google.maps.LatLngBounds();

  

    $.ajax({
        url: base_url + "/marker",
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        headers: {
            "Authorization": "Bearer " + token,
        },
        type: 'GET',
        success: function(e) {
            e.forEach(element => {
                 addMarker(element.lat, element.lng, element,element.icon);

            });
          
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


    // // Proses membuat marker 
    function addMarker(lat, lng, info, icon) {
      
        var lokasi = new google.maps.LatLng(lat, lng);
        bounds.extend(lokasi);
      
        var marker = new google.maps.Marker({
            map: peta,
            icon:  {
                url: icon, // url
                scaledSize: new google.maps.Size(50, 50), // scaled size
            },
            position: lokasi
        });
        // peta.fitBounds(bounds);
        bindInfoWindow(marker, peta, infoWindow, info);
    }
    // Menampilkan informasi pada masing-masing marker yang diklik
    function bindInfoWindow(marker, peta, infoWindow, info) {
        google.maps.event.addListener(marker, 'click', function() {
            $('#myModalMap').modal({ backdrop: 'static', keyboard: false });
            $('#myModalMap').modal('show');

            $("#dashboard-dealer-name").text(info.office_name);
            $("#dashboard-area").text(info.office_group);

            var dataSend = {
                officeid:info.officeid
            }
            $.ajax({
                url: base_url + "/api/report/clickmaps",
                method: 'POST',
                data: dataSend,
                async: false,
                headers: {
                    "Authorization": "Bearer " + token,
                },
                success: function(response) {
                    $("#dashboard-exhibiton").text(response.exhibiton+" EVENT");
                    $("#dashboard-roadshow").text(response.roadshow+" EVENT");
                    $("#dashboard-showroom").text(response.showroom+" EVENT");

                    $("#dashboard-inprogress").text(response.inprogress+" EVENT");
                    $("#dashboard-running").text(response.running+" EVENT");
                    $("#dashboard-done").text(response.showroom+" EVENT");

                    $("#dashboard-actual_visitor").text(response.visitor+" EVENT");
                    $("#dashboard-target_actual_prospect").text(response.prospek+" EVENT");
                    $("#dashboard-actual_sell").text(response.deal+" EVENT");
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
        });
    }
}

window.addEventListener( 'load', initialize);
// google.maps.event.addDomListener(window, 'load', initialise);


// });

function getChartColorsArray(r) {
    if (null !== document.getElementById(r)) {
        var e = document.getElementById(r).getAttribute("data-colors");
        return (e = JSON.parse(e)).map(function(r) {
            var e = r.replace(" ", "");
            if (-1 == e.indexOf("--")) return e;
            var t = getComputedStyle(document.documentElement).getPropertyValue(e);
            return t || void 0
        })
    }
}
var barchartColors = getChartColorsArray("mini-1"),
    options1 = {
        series: [{
            data: [25, 66, 41, 89, 63, 25, 44, 23, 40, 40, 54, 41]
        }],
        fill: {
            colors: barchartColors,
            opacity: 1
        },
        chart: {
            type: "bar",
            height: 50,
            sparkline: {
                enabled: !0
            }
        },
        plotOptions: {
            bar: {
                columnWidth: "65%",
                borderRadius: 4
            }
        },
        labels: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
        xaxis: {
            crosshairs: {
                width: 1
            }
        },
        tooltip: {
            fixed: {
                enabled: !1
            },
            x: {
                show: !1
            },
            y: {
                title: {
                    formatter: function(r) {
                        return ""
                    }
                }
            },
            marker: {
                show: !1
            }
        }
    },
    chart1 = new ApexCharts(document.querySelector("#mini-1"), options1);
chart1.render();
options1 = {
    series: [{
        data: [56, 20, 80, 40, 75, 41, 25, 66, 41, 89, 63, 25]
    }],
    fill: {
        colors: barchartColors = getChartColorsArray("mini-2"),
        opacity: 1
    },
    chart: {
        type: "bar",
        height: 50,
        sparkline: {
            enabled: !0
        }
    },
    plotOptions: {
        bar: {
            columnWidth: "65%",
            borderRadius: 4
        }
    },
    labels: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
    xaxis: {
        crosshairs: {
            width: 1
        }
    },
    tooltip: {
        fixed: {
            enabled: !1
        },
        x: {
            show: !1
        },
        y: {
            title: {
                formatter: function(r) {
                    return ""
                }
            }
        },
        marker: {
            show: !1
        }
    }
};
(chart1 = new ApexCharts(document.querySelector("#mini-2"), options1)).render();
options1 = {
    series: [{
        data: [59, 63, 35, 75, 50, 66, 25, 66, 41, 40, 54, 41]
    }],
    fill: {
        colors: barchartColors = getChartColorsArray("mini-3"),
        opacity: 1
    },
    chart: {
        type: "bar",
        height: 50,
        sparkline: {
            enabled: !0
        }
    },
    plotOptions: {
        bar: {
            columnWidth: "65%",
            borderRadius: 4
        }
    },
    labels: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
    xaxis: {
        crosshairs: {
            width: 1
        }
    },
    tooltip: {
        fixed: {
            enabled: !1
        },
        x: {
            show: !1
        },
        y: {
            title: {
                formatter: function(r) {
                    return ""
                }
            }
        },
        marker: {
            show: !1
        }
    }
};
(chart1 = new ApexCharts(document.querySelector("#mini-3"), options1)).render();
options1 = {
    series: [{
        data: [45, 36, 40, 64, 41, 66, 41, 89, 63, 25, 44, 20]
    }],
    fill: {
        colors: barchartColors = getChartColorsArray("mini-4"),
        opacity: 1
    },
    chart: {
        type: "bar",
        height: 50,
        sparkline: {
            enabled: !0
        }
    },
    plotOptions: {
        bar: {
            columnWidth: "65%",
            borderRadius: 4
        }
    },
    labels: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
    xaxis: {
        crosshairs: {
            width: 1
        }
    },
    tooltip: {
        fixed: {
            enabled: !1
        },
        x: {
            show: !1
        },
        y: {
            title: {
                formatter: function(r) {
                    return ""
                }
            }
        },
        marker: {
            show: !1
        }
    }
};
(chart1 = new ApexCharts(document.querySelector("#mini-4"), options1)).render();
options1 = {
    chart: {
        type: "area",
        height: 360,
        toolbar: {
            show: !1
        }
    },
    series: [{
        name: "Incomes",
        data: [0, 20, 35, 45, 35, 55, 65, 50, 65, 75, 60, 75]
    }, {
        name: "Expenses",
        data: [15, 9, 17, 32, 25, 68, 80, 68, 84, 94, 74, 62]
    }],
    stroke: {
        curve: "straight",
        width: ["4", "4"]
    },
    grid: {
        xaxis: {
            lines: {
                show: !0
            }
        },
        yaxis: {
            lines: {
                show: !0
            }
        }
    },
    colors: barchartColors = getChartColorsArray("sales-report"),
    xaxis: {
        categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Now", "Des"]
    },
    legend: {
        show: !1
    },
    fill: {
        type: "gradient",
        gradient: {
            shadeIntensity: 1,
            inverseColors: !1,
            opacityFrom: .4,
            opacityTo: .1,
            stops: [30, 100, 100, 100]
        }
    },
    dataLabels: {
        enabled: !1
    },
    tooltip: {
        fixed: {
            enabled: !1
        },
        x: {
            show: !1
        },
        y: {
            title: {
                formatter: function(r) {
                    return ""
                }
            }
        },
        marker: {
            show: !1
        }
    }
};
// new ApexCharts(document.querySelector("#sales-report"), options1).render();