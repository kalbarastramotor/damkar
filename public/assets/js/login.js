function login() {
    var next = true
    if ($("#username").val() == "" && $("#password-input").val() == "") {
        alertify.error('Please Input Username & Password ');
        next = false
    } else if ($("#username").val() == "") {
        alertify.error('Please Input Username');
        next = false
    } else if ($("#password-input").val() == "") {
        alertify.error('Please Input Password');
        next = false
    }

    var dataSend = {
        grant_type: 'password',
        username: $("#username").val(),
        password: $("#password-input").val(),
    }
    if (next) {
        $.ajax({
            type: "POST",
            url: base_url + "/login",
            headers: {
                Authorization: "Basic dGVzdGNsaWVudDp0ZXN0c2VjcmV0"
            },
            data: dataSend,
            success: function(result) {
                if (result.error == "invalid_role") {
                    alertify.error('You don`t have role');
                } else {
                    alertify.success('Login berhasil');
                    localStorage.setItem("token", result["access_token"]);

                    setTimeout(function() {
                        location.href = base_url + '/dashboard';
                    }, 3000);
                }

            },
            error: function(result) {

                if (result.responseJSON.error == "invalid_grant") {
                    alertify.error('Please check username & password ');
                } else if (result.responseJSON.error == "invalid_role") {
                    alertify.error('You don`t have role');
                }

            }
        });
    }
}