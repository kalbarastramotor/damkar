<?php
function get_percentage($total, $number)
{
  if ( $total > 0 ) {
    if($number > $total)
    {
        return 100;
    }else{
        return round(($number * 100) / $total);

    }
  } else {
    return 0;
  }
}

function dataEventStatus($status){
    $data = array();
    $data['1'] =  'Pending';
    $data['2'] =  'Approved';
    $data['3'] =  'Rejected';
    $data['4'] =  'Running';
    $data['5'] =  'Done';
    $data['0'] =  'Draft';
    return $data[$status];
}

function global_css(){
    return array(
        array(
            "assets"=>"/css/bootstrap.min.css",
            "id"=>"bootstrap-style"
        ),
        array(
            "assets"=>"/css/icons.min.css",
            "id"=>""
        ),
        array(
            "assets"=>"/css/app.min.css",
            "id"=>"app-style"
        ),
        array(
            "assets"=>"/libs/alertifyjs/build/css/alertify.min.css",
            "id"=>""
        ),
        array(
            "assets"=>"/libs/alertifyjs/build/css/themes/default.min.css",
            "id"=>""
        ),
    );
}
function gridjscss(){
    return array(
        array(
            "assets"=>"/libs/gridjs/theme/mermaid.min.css",
            "id"=>""
        )
    );
}
function mapsjs(){
    return array("https://maps.googleapis.com/maps/api/js?key=AIzaSyAMjkDiBVQh9IpPrn0EVe5eUvLD44lYvds&libraries=places");
}

function datatablescss(){
    return array(
        array(
            "assets"=>"/css/bootstrap.min.css",
            "id"=>""
        ), 
        array(
            "assets"=>"/css/datatables.min.css",
            "id"=>""
        ),
        array(
            "assets"=>"/css/rowGroup.dataTables.min.css",
            "id"=>""
        ),
        array(
            "assets"=>"/css/select2.min.css",
            "id"=>""
        )
    );
}
function flatpickr_css(){
    return array(
        array(
            "assets"=>"/libs/flatpickr/flatpickr.min.css",
            "id"=>""
        )
    );
}
function datatablesjs_js(){
    return array(
        "/js/datatables/datatables.min.js",
        "/js/datatables/dataTables.rowGroup.min.js",
        "/js/datatables/dataTables.buttons.min.js",
        "/js/datatables/jszip.min.js",
        "/js/datatables/pdfmake.min.js",
        "/js/datatables/vfs_fonts.js",
        "/js/datatables/buttons.html5.min.js",
        "/js/select2/select2.min.js"
    );

  
}
function global_js(){
    return array(
        "/libs/bootstrap/js/bootstrap.bundle.min.js",
        "/libs/metismenujs/metismenujs.min.js",
        "/libs/simplebar/simplebar.min.js",
        "/libs/eva-icons/eva.min.js",
        "/js/app.js",
        "/js/jquery-3.6.0.min.js",
        "/libs/alertifyjs/build/alertify.min.js"
    );
}

function apexcharts_js(){
    return array(
        "/libs/apexcharts/apexcharts.min.js",
    );
}

function todo_js(){
    return array(
        "/js/pages/todo.init.js",
    );
}

function flatpickr_js(){
    return array(
        "/libs/flatpickr/flatpickr.min.js",
    );
}

function gridjs_js(){
    return array(
        "/libs/gridjs/gridjs.umd.js",
        "/js/pages/gridjs.init.js",
    );
}
function successJsonResponse($id){
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(
        array(
            "status"=> array(
                "error_code"=>  0,
                "message"=>  "OK"
            ),
            "data"=>  array(
                "last_id"=>$id
            ),
        
        )
    );
}
function successJsonResponseAll($data){
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(
        array(
            "status"=> array(
                "error_code"=>  0,
                "message"=>  "OK"
            ),
            "data"=> $data
        )
    );
}
function failedJsonResponse($err){
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(
        array(
                "status"=> array(
                    "error_code"=>  0,
                    "message"=>  "ERROR"
                ),
           
                "data"=>  array(
                    "error"=>$err
                ),
            )
    );
}

function errorJsonResponse($err,$message){
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(
        array(
                "status"=> array(
                    "error_code"=>  0,
                    "message"=>  $message
                ),
           
                "data"=>  array(
                    "error"=>$err
                ),
            )
    );
}

function Pwd(){
    $pwd = shell_exec('pwd');
    return $pwd;
}
?>