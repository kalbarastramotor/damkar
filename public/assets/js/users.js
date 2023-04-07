var table

$(document).ready(function() {
    $('.filter-jabatan').select2({
        placeholder: 'Jabatan',
        allowClear: true,
        ajax: {
            url: base_url + "/api/role/optionrole",
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

    table = $('#user-table').DataTable({
        "processing": true,
        "serverSide": true,
        "columns": [
            { "title": 'No' },
            { "title": 'Name' },
            { "title": 'Email' },
            { "title": 'Phone' },
            { "title": 'Dealer' },
            { "title": 'Jabatan' },
            { "title": 'Status' },
            { "title": 'Option' },
        ],
        "dom": "<'row'<'col-sm-6 'l><'col-sm-5'f><'col-sm-1'B>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-8'i><'col-sm-4'p>>",
        "buttons": [{
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i>',
                className: 'btn btn-success'
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
            "url": base_url + "/api/users/data",
            "type": "POST",
            "headers": {
                "Authorization": "Bearer " + token,
            },
            "data": function(e) {
                e.jabatan = $(".filter-jabatan").val()
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
            }
        ],
        "createdRow": function(row, data, dataIndex) {
            if (data[8] == 1 || data[8] == "1") {
                $(row).addClass('table-danger');
            }
        },
    });
});
$('.filter-jabatan').on("change", function(e) {
    table.ajax.reload();
});

function showModalAdd() {
    $('#myModal_Add').modal({ backdrop: 'static', keyboard: false });
    $('#myModal_Add').modal('show');

    $('#password-users-add').removeClass('is-invalid');
    $('#re-password-users-add').removeClass('is-invalid');
    $('#gender-users-add').removeClass('is-invalid');
    $('#name-users-add').removeClass('is-invalid');
    $('#phone-users-add').removeClass('is-invalid');
    $('#email-users-add').removeClass('is-invalid');

    $('.show-gender-add').select2({
        placeholder: 'Gender',
        allowClear: true,
        dropdownParent: $('#myModal_Add'),
        ajax: {
            dropdownParent: $('#myModal_Add'),
            url: base_url + "/api/users/gender",
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

function lock_user(id, banned) {
    alertify.confirm(
        "Are you sure you want to " + (((banned == 1) ? "Unlock" : "Lock")) + "  this user ?",
        function() {

            $.ajax({
                type: "POST",
                url: base_url + "/api/users/lock",
                dataType: 'json',
                async: false,
                data: {
                    userid: id,
                    banned: (banned == 1) ? 0 : 1,
                },
                headers: {
                    "Authorization": "Bearer " + token,
                },
                success: function(e) {

                    if (e.status.message == "OK") {
                        if (banned == 1) {
                            alertify.success('Unlock Success');
                        } else {
                            alertify.success('Lock Success');
                        };
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


function reset_password(userid) {
    $('#myModal_change_password').modal({ backdrop: 'static', keyboard: false });
    $('#myModal_change_password').modal('show');

    $('#button-update-password').attr('userid', userid);

}

$("#button-set-role-users").click(function(e) {

    var dataSend = {
        userid: $("#button-set-role-users").attr("userid"),
        roleid: $("#id-set-user-role").val(),
        area: ($("#id-set-user-area").val()).join(),
    }
  

    if (dataSend.roleid == null || dataSend.roleid == "") {
        alertify.error('Pastikan sudah memilih role');
        return false;
    }
    $.ajax({
        type: "POST",
        url: base_url + "/api/users/setroleuser",
        dataType: 'json',
        async: false,
        data: dataSend,
        headers: {
            "Authorization": "Bearer " + token,
        },
        success: function(e) {
            console.log(e);
            if (e.status.message == "OK") {
                alertify.success('Data berhasil di simpan');
                $('#myModal_change_access').modal('hide');
                table.ajax.reload();
            } else {
                alertify.error('Error Internal');
            }
        }
    });
});

function change_access(userid, roleid, role_name) {
    $('#myModal_change_access').modal({ backdrop: 'static', keyboard: false });
    $('#myModal_change_access').modal('show');

    $('#button-set-role-users').attr('userid', userid);
    var vals =[ ];

    $.ajax({
        type: "POST",
        url: base_url + "/api/role/userarea",
        dataType: 'json',
        async: false,
        data: {
            userid:userid
        },
        headers: {
            "Authorization": "Bearer " + token,
        },
        success: function(e) {
            console.log(e);
            if(e.length > 0){
                vals = e
            }
            // if (e.status.message == "OK") {
            //     alertify.success('Data berhasil di simpan');
            //     $('#myModal_change_access').modal('hide');
            //     table.ajax.reload();
            // } else {
            //     alertify.error('Error Internal');
            // }
        }
    });

    $('.show-access-update').select2({
        placeholder: 'Select Role',
        allowClear: true,
        dropdownParent: $('#myModal_change_access'),
        ajax: {
            dropdownParent: $('#myModal_change_access'),
            url: base_url + "/api/role/optionrole",
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
    var $optionshowrole = $("<option selected='selected'></option>").val(roleid).text(role_name);
    $(".show-access-update").append($optionshowrole).trigger('change');

    $('.show-area-update').select2({
        placeholder: 'Select Area',
        maximumSelectionSize: 10,
        multiple: true,
        allowClear: true,
        dropdownParent: $('#myModal_change_access'),
        ajax: {
            dropdownParent: $('#myModal_change_access'),
            url: base_url + "/api/officegroup/select",
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
  

    

    $(".show-area-update").val('');
    $(".show-area-update").trigger("change"); 
    vals.forEach(function(e){
        var $optionshowrole = $("<option selected='selected'></option>").val(e.id).text(e.text);

        console.log('====================================');
        console.log(e.id);
        console.log($optionshowrole);
        console.log('====================================');
        $(".show-area-update").append($optionshowrole).trigger("change"); 
    });

    
    // $(".show-area-update").val(vals).trigger("change"); 

}


$("#button-add-users").click(function(e) {

    var dataSend = {
        name: $("#name-users-add").val(),
        email: $("#email-users-add").val(),
        phone: $("#phone-users-add").val(),
        gender: ($("#gender-users-add").val() == null) ? '' : $("#gender-users-add").val(),
        password: $("#password-users-add").val(),
    }
    if (
        dataSend.name == '' ||
        dataSend.email == '' ||
        dataSend.phone == '' ||
        dataSend.gender == '' ||
        dataSend.password == '') {
        if (dataSend.name == '') {
            $('#name-users-add').addClass('is-invalid');
        }
        if (dataSend.email == '') {
            $('#email-users-add').addClass('is-invalid');
        }
        if (dataSend.phone == '') {
            $('#phone-users-add').addClass('is-invalid');
        }
        if (dataSend.gender == '') {
            $('#gender-users-add').addClass('is-invalid');
        }
        if (dataSend.password == '') {
            $('#password-users-add').addClass('is-invalid');
            $('#re-password-users-add').addClass('is-invalid');
        }
        alertify.error('Pastikan form sudah terisih dengan baik');
        return false;
    } else {

        $.ajax({
            type: "POST",
            url: base_url + "/api/users/save",
            dataType: 'json',
            async: false,
            data: dataSend,
            headers: {
                "Authorization": "Bearer " + token,
            },
            success: function(e) {
                if (e.status.message == "OK") {
                    alertify.success('Data berhasil di simpan');
                    $('#myModal_Add').modal('hide');
                    table.ajax.reload();

                    $('#password-users-add').removeClass('is-invalid');
                    $('#re-password-users-add').removeClass('is-invalid');
                    $('#gender-users-add').removeClass('is-invalid');
                    $('#name-users-add').removeClass('is-invalid');
                    $('#phone-users-add').removeClass('is-invalid');
                    $('#email-users-add').removeClass('is-invalid');

                    $(".needs-validation").closest('form').find("input[type=text], textarea").val("");


                } else {
                    alertify.error('Error Internal');
                }

            }
        });
    }

});


$("#button-set-office").click(function(e) {

    var dataSend = {
        userid: $("#button-set-office").attr("userid"),
        officeid: $("#id-set-dealer-user").val(),
    }
    if (dataSend.officeid == null || dataSend.officeid == "") {
        alertify.error('Pastikan sudah memilih dealer');
        return false;
    }

    $.ajax({
        type: "POST",
        url: base_url + "/api/users/setofficeuser",
        dataType: 'json',
        async: false,
        data: dataSend,
        headers: {
            "Authorization": "Bearer " + token,
        },
        success: function(e) {
            if (e.status.message == "OK") {
                alertify.success('Data berhasil di simpan');
                $('#myModal_change_office').modal('hide');
                table.ajax.reload();
                $(".needs-validation").closest('form').find("input[type=text], textarea").val("");

            } else {
                alertify.error('Error Internal');
            }

        }
    });
});


function validateAddName(name) {
    var val = document.getElementById(name).value;
    if (val != '') {
        $('#name-users-add').removeClass('is-invalid');
        $('#name-users-add').addClass('is-valid');
        $('#button-add-users').removeClass('disabled')
    } else {
        $('#name-users-add').removeClass('is-valid');
        $('#name-users-add').addClass('is-invalid');
        $('#button-add-users').addClass('disabled')
    }
}

function ChangeVerifyPassword(id) {
    var pw = document.getElementById(id).value;
    if (pw == "") {
        $('#' + id).removeClass('is-valid');
        $('#' + id).addClass('is-invalid');
        document.getElementById("message-password-update").innerHTML = "**Fill the password please!";
        $('#message-password-update').attr('style', 'color:#ed5555');
        $('#button-update-password').addClass('disabled')
        return false;
    }

    //minimum password length validation
    if (pw.length < 8) {
        $('#' + id).removeClass('is-valid');
        $('#' + id).addClass('is-invalid');
        document.getElementById("message-password-update").innerHTML = "**Password length must be atleast 8 characters";
        $('#message-password-update').attr('style', 'color:#ed5555');
        $('#button-update-password').addClass('disabled')
        return false;
    }

    //maximum length of password validation
    if (pw.length > 15) {
        $('#' + id).removeClass('is-valid');
        $('#' + id).addClass('is-invalid');
        document.getElementById("message-password-update").innerHTML = "**Password length must not exceed 15 characters";
        $('#message-password-update').attr('style', 'color:#ed5555');
        $('#button-update-password').addClass('disabled')
        return false;
    } else {
        $('#' + id).removeClass('is-invalid');
        $('#' + id).addClass('is-valid');
        document.getElementById("message-password-update").innerHTML = "**Password is good"
        $('#message-password-update').attr('style', 'color:#28b765');
        $('#button-update-password').removeClass('disabled')
    }
}

function ChangeReverifyPassword(id) {
    var pw = document.getElementById(id).value;
    var pasword = document.getElementById("password-users-update").value;
    if (pw == "") {
        $('#' + id).removeClass('is-valid');
        $('#' + id).addClass('is-invalid');
        document.getElementById("message-repassword-update").innerHTML = "**Fill the password please!";
        $('#message-repassword-update').attr('style', 'color:#ed5555');
        $('#button-update-password').addClass('disabled')
        return false;
    }

    //minimum password length validation
    if (pw.length < 8) {
        $('#' + id).removeClass('is-valid');
        $('#' + id).addClass('is-invalid');
        document.getElementById("message-repassword-update").innerHTML = "**Password length must be atleast 8 characters";
        $('#message-repassword-update').attr('style', 'color:#ed5555');
        $('#button-update-password').addClass('disabled')
        return false;
    }

    //maximum length of password validation
    if (pw.length > 15) {
        $('#' + id).removeClass('is-valid');
        $('#' + id).addClass('is-invalid');
        document.getElementById("message-repassword-update").innerHTML = "**Password length must not exceed 15 characters";
        $('#message-repassword-update').attr('style', 'color:#ed5555');
        $('#button-update-password').addClass('disabled')
        return false;
    } else {
        if (pw != pasword) {
            $('#' + id).removeClass('is-valid');
            $('#' + id).addClass('is-invalid');
            document.getElementById("message-repassword-update").innerHTML = "**Passwords do NOT match!";
            $('#message-repassword-update').attr('style', 'color:#ed5555');
            $('#button-update-password').addClass('disabled')
        } else {

            $('#' + id).removeClass('is-invalid');
            $('#' + id).addClass('is-valid');
            document.getElementById("message-repassword-update").innerHTML = "**Password is good"
            $('#message-repassword-update').attr('style', 'color:#28b765');
            $('#button-update-password').removeClass('disabled')
        }
    }
}


$("#button-update-password").click(function(e) {

    var dataSend = {
        userid: $("#button-update-password").attr("userid"),
        password: $("#password-users-update").val(),
    }
    console.log(dataSend);
    if (dataSend.password == null || dataSend.password == "") {
        alertify.error('Pastikan password sudah benar');
        return false;
    } else if (dataSend.password != $("#re-password-users-update").val()) {
        alertify.error('Pastikan Re-passwors sudah benar');
        $('#re-password-users-update').addClass('is-invalid');
        document.getElementById("message-repassword-update").innerHTML = "**Fill the password please!";
        $('#message-repassword-update').attr('style', 'color:#ed5555');
        $('#button-update-password').addClass('disabled')
        return false;

    }

    $.ajax({
        type: "POST",
        url: base_url + "/api/users/changepassword",
        dataType: 'json',
        async: false,
        data: dataSend,
        headers: {
            "Authorization": "Bearer " + token,
        },
        success: function(e) {
            if (e.status.message == "OK") {
                alertify.success('Data berhasil di simpan');
                $('#myModal_change_password').modal('hide');
                table.ajax.reload();
                $(".needs-validation").closest('form').find("input[type=text], textarea").val("");

            } else {
                alertify.error('Error Internal');
            }

        }
    });
});


function verifyPassword(id) {
    var pw = document.getElementById(id).value;
    if (pw == "") {
        $('#' + id).removeClass('is-valid');
        $('#' + id).addClass('is-invalid');
        document.getElementById("message-password").innerHTML = "**Fill the password please!";
        $('#message-password').attr('style', 'color:#ed5555');
        $('#button-add-users').addClass('disabled')
        return false;
    }

    //minimum password length validation
    if (pw.length < 8) {
        $('#' + id).removeClass('is-valid');
        $('#' + id).addClass('is-invalid');
        document.getElementById("message-password").innerHTML = "**Password length must be atleast 8 characters";
        $('#message-password').attr('style', 'color:#ed5555');
        $('#button-add-users').addClass('disabled')
        return false;
    }

    //maximum length of password validation
    if (pw.length > 15) {
        $('#' + id).removeClass('is-valid');
        $('#' + id).addClass('is-invalid');
        document.getElementById("message-password").innerHTML = "**Password length must not exceed 15 characters";
        $('#message-password').attr('style', 'color:#ed5555');
        $('#button-add-users').addClass('disabled')
        return false;
    } else {
        $('#' + id).removeClass('is-invalid');
        $('#' + id).addClass('is-valid');
        document.getElementById("message-password").innerHTML = "**Password is good"
        $('#message-password').attr('style', 'color:#28b765');
        $('#button-add-users').removeClass('disabled')
    }
}

function ReverifyPassword(id) {
    var pw = document.getElementById(id).value;
    var pasword = document.getElementById("password-users-add").value;
    if (pw == "") {
        $('#' + id).removeClass('is-valid');
        $('#' + id).addClass('is-invalid');
        document.getElementById("message-repassword").innerHTML = "**Fill the password please!";
        $('#message-repassword').attr('style', 'color:#ed5555');
        $('#button-add-users').addClass('disabled')
        return false;
    }

    //minimum password length validation
    if (pw.length < 8) {
        $('#' + id).removeClass('is-valid');
        $('#' + id).addClass('is-invalid');
        document.getElementById("message-repassword").innerHTML = "**Password length must be atleast 8 characters";
        $('#message-repassword').attr('style', 'color:#ed5555');
        $('#button-add-users').addClass('disabled')
        return false;
    }

    //maximum length of password validation
    if (pw.length > 15) {
        $('#' + id).removeClass('is-valid');
        $('#' + id).addClass('is-invalid');
        document.getElementById("message-repassword").innerHTML = "**Password length must not exceed 15 characters";
        $('#message-repassword').attr('style', 'color:#ed5555');
        $('#button-add-users').addClass('disabled')
        return false;
    } else {
        if (pw != pasword) {
            $('#' + id).removeClass('is-valid');
            $('#' + id).addClass('is-invalid');
            document.getElementById("message-repassword").innerHTML = "**Passwords do NOT match!";
            $('#message-repassword').attr('style', 'color:#ed5555');
            $('#button-add-users').addClass('disabled')
        } else {

            $('#' + id).removeClass('is-invalid');
            $('#' + id).addClass('is-valid');
            document.getElementById("message-repassword").innerHTML = "**Password is good"
            $('#message-repassword').attr('style', 'color:#28b765');
            $('#button-add-users').removeClass('disabled')
        }
    }
}


function ValidatePhone(id) {
    var email = document.getElementById(id).value;
    var mailformat = /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im;
    if (email.match(mailformat)) {
        $('#' + id).removeClass('is-invalid');
        $('#' + id).addClass('is-valid');
        document.getElementById("message-phone-add").innerHTML = "**Valid phone!"
        $('#message-phone-add').attr('style', 'color:#28b765');
        $('#button-add-users').removeClass('disabled')
    } else {
        $('#' + id).removeClass('is-valid');
        $('#' + id).addClass('is-invalid');
        document.getElementById("message-phone-add").innerHTML = "**You have entered an invalid phone!"
        $('#message-phone-add').attr('style', 'color:#ed5555');
        $('#button-add-users').addClass('disabled')
    }
}

function ValidateEmail(id) {
    var email = document.getElementById(id).value;
    var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if (email.match(mailformat)) {
        $('#' + id).removeClass('is-invalid');
        $('#' + id).addClass('is-valid');
        document.getElementById("message-email").innerHTML = "**Valid email address!"
        $('#message-email').attr('style', 'color:#28b765');
        $('#button-add-users').removeClass('disabled')
    } else {
        $('#' + id).removeClass('is-valid');
        $('#' + id).addClass('is-invalid');
        document.getElementById("message-email").innerHTML = "**You have entered an invalid email address!"
        $('#message-email').attr('style', 'color:#ed5555');
        $('#button-add-users').addClass('disabled')
    }
}


function ValidateEmailEdit(id) {
    var email = document.getElementById(id).value;
    var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if (email.match(mailformat)) {
        $('#' + id).removeClass('is-invalid');
        $('#' + id).addClass('is-valid');
        document.getElementById("message-email-edit").innerHTML = "**Valid email address!"
        $('#message-email-edit').attr('style', 'color:#28b765');
        $('#button-update-users').removeClass('disabled')
    } else {
        $('#' + id).removeClass('is-valid');
        $('#' + id).addClass('is-invalid');
        document.getElementById("message-email-edit").innerHTML = "**You have entered an invalid email address!"
        $('#message-email-edit').attr('style', 'color:#ed5555');
        $('#button-update-users').addClass('disabled')
    }
}

function ValidatePhoneEdit(id) {
    var email = document.getElementById(id).value;
    var mailformat = /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im;
    if (email.match(mailformat)) {
        $('#' + id).removeClass('is-invalid');
        $('#' + id).addClass('is-valid');
        document.getElementById("message-phone-edit").innerHTML = "**Valid phone!"
        $('#message-phone-edit').attr('style', 'color:#28b765');
        $('#button-update-users').removeClass('disabled')
    } else {
        $('#' + id).removeClass('is-valid');
        $('#' + id).addClass('is-invalid');
        document.getElementById("message-phone-edit").innerHTML = "**You have entered an invalid phone!"
        $('#message-phone-edit').attr('style', 'color:#ed5555');
        $('#button-update-users').addClass('disabled')
    }
}


function validateAddNameEdit(name) {
    var val = document.getElementById(name).value;
    if (val != '') {
        $('#name-users-edit').removeClass('is-invalid');
        $('#name-users-edit').addClass('is-valid');
        $('#button-update-users').removeClass('disabled')
    } else {
        $('#name-users-edit').removeClass('is-valid');
        $('#name-users-edit').addClass('is-invalid');
        $('#button-update-users').addClass('disabled')
    }
}

// function validateAddName(name) {
//     var val = document.getElementById(name).value;
//     if (val != '') {
//         $('#name-users-add').removeClass('is-invalid');
//         $('#name-users-add').addClass('is-valid');
//         $('#button-add-users').removeClass('disabled')
//     } else {
//         $('#name-users-add').removeClass('is-valid');
//         $('#name-users-add').addClass('is-invalid');
//         $('#button-add-users').addClass('disabled')
//     }
// }


$('#id-set-dealer-user').on("change", function(e) {
    var val = $(this).val();
    if (val != 0) {
        $('#id-set-dealer-user').removeClass('is-invalid');
        $('#id-set-dealer-user').addClass('is-valid');
    }
    if (val == null) {
        $('#id-set-dealer-user').addClass('is-invalid');
        $('#id-set-dealer-user').removeClass('is-valid');
    }
});
$('#id-set-user-role').on("change", function(e) {
    var val = $(this).val();
    if (val != 0) {
        $('#id-set-user-role').removeClass('is-invalid');
        $('#id-set-user-role').addClass('is-valid');
    }
    if (val == null) {
        $('#id-set-user-role').addClass('is-invalid');
        $('#id-set-user-role').removeClass('is-valid');
    }
});


function edit_user(userid, id) {
    $('#myModal_edit').modal({ backdrop: 'static', keyboard: false });
    $('#myModal_edit').modal('show');



    var name = $("#" + id).attr("name");
    var email = $("#" + id).attr("email");
    var phone = $("#" + id).attr("phone");
    var gender = $("#" + id).attr("gender");
    var nameGender = (gender == 2) ? "WANITA" : (gender == 0) ? "UNKNOWN" : "PRIA";
    $('#name-users-edit').val(name);
    $('#email-users-edit').val(email);
    $('#phone-users-edit').val(phone);

    $('#phone-users-edit').val(phone);

    $('.show-gender-edit').select2({
        placeholder: 'Gender',
        allowClear: true,
        dropdownParent: $('#myModal_edit'),
        ajax: {
            dropdownParent: $('#myModal_edit'),
            url: base_url + "/api/users/gender",
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

    var $optionshowoffice = $("<option selected='selected'></option>").val(gender).text(nameGender);
    $(".show-gender-edit").append($optionshowoffice).trigger('change');
    $('#button-update-users').attr('userid', userid);
}

function change_office(userid, officeid, officename) {
    $('#myModal_change_office').modal({ backdrop: 'static', keyboard: false });
    $('#myModal_change_office').modal('show');

    $('#button-set-office').attr('userid', userid);

    $('.show-office-update').select2({
        placeholder: 'Select Dealer',
        allowClear: true,
        dropdownParent: $('#myModal_change_office'),
        ajax: {
            dropdownParent: $('#myModal_change_office'),
            url: base_url + "/api/office/option",
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
    var $optionshowoffice = $("<option selected='selected'></option>").val(officeid).text(officename);
    $(".show-office-update").append($optionshowoffice).trigger('change');

}




$("#button-update-users").click(function(e) {

    var dataSend = {
        userid: $("#button-update-users").attr("userid"),
        name: $("#name-users-edit").val(),
        name: $("#name-users-edit").val(),
        email: $("#email-users-edit").val(),
        phone: $("#phone-users-edit").val(),
        gender: ($("#gender-users-edit").val() == null || $("#gender-users-edit").val() == 0) ? '' : $("#gender-users-edit").val(),
    }
    if (
        dataSend.name == '' ||
        dataSend.email == '' ||
        dataSend.gender == '' ||
        dataSend.phone == '') {
        if (dataSend.name == '') {
            $('#name-users-edit').addClass('is-invalid');
        }
        if (dataSend.email == '') {
            $('#email-users-edit').addClass('is-invalid');
        }
        if (dataSend.phone == '') {
            $('#phone-users-edit').addClass('is-invalid');
        }
        if (dataSend.gender == '') {
            $('#gender-users-edit').addClass('is-invalid');
        }


        alertify.error('Pastikan form sudah terisih dengan baik');
        return false;
    } else {
        $.ajax({
            type: "POST",
            url: base_url + "/api/users/update",
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
                    $(".needs-validation").closest('form').find("input[type=text], textarea, select").val("");

                } else {
                    alertify.error('Error Internal');
                }

            }
        });
    }

});

$(".close-form-add").click(function(e) {
    $('#password-users-add').removeClass('is-invalid');
    $('#re-password-users-add').removeClass('is-invalid');
    $('#gender-users-add').removeClass('is-invalid');
    $('#name-users-add').removeClass('is-invalid');
    $('#phone-users-add').removeClass('is-invalid');
    $('#email-users-add').removeClass('is-invalid');
})