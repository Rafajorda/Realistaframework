

    function validate_register() {
        var username_exp = /^(?=.{5,}$)(?=.*[a-zA-Z0-9]).*$/;
        var mail_exp = /^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/;
        var pssswd_exp = /^(?=.{8,}$)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$/;
        var error = false;

        if (document.getElementById('username_reg').value.length === 0) {
            document.getElementById('error_username_reg').innerHTML = "Tienes que escribir el usuario";
            error = true;
        } else {
            if (document.getElementById('username_reg').value.length < 5) {
                document.getElementById('error_username_reg').innerHTML = "El username tiene que tener 5 caracteres como minimo";
                error = true;
            } else {
                if (!username_exp.test(document.getElementById('username_reg').value)) {
                    document.getElementById('error_username_reg').innerHTML = "No se pueden poner caracteres especiales";
                    error = true;
                } else {
                    document.getElementById('error_username_reg').innerHTML = "";
                }
            }
        }

        if (document.getElementById('email_reg').value.length === 0) {
            document.getElementById('error_email_reg').innerHTML = "Tienes que escribir un correo";
            error = true;
        } else {
            if (!mail_exp.test(document.getElementById('email_reg').value)) {
                document.getElementById('error_email_reg').innerHTML = "El formato del mail es invalido";
                error = true;
            } else {
                document.getElementById('error_email_reg').innerHTML = "";
            }
        }

        if (document.getElementById('passwd1_reg').value.length === 0) {
            document.getElementById('error_passwd1_reg').innerHTML = "Tienes que escribir la contraseña";
            error = true;
        } else {
            if (document.getElementById('passwd1_reg').value.length < 8) {
                document.getElementById('error_passwd1_reg').innerHTML = "La password tiene que tener 8 caracteres como minimo";
                error = true;
            } else {
                if (!pssswd_exp.test(document.getElementById('passwd1_reg').value)) {
                    document.getElementById('error_passwd1_reg').innerHTML = "Debe de contener minimo 8 caracteres, mayusculas, minusculas y simbolos especiales";
                    error = true;
                } else {
                    document.getElementById('error_passwd1_reg').innerHTML = "";
                }
            }
        }

        if (document.getElementById('passwd2_reg').value.length === 0) {
            document.getElementById('error_passwd2_reg').innerHTML = "Tienes que repetir la contraseña";
            error = true;
        } else {
            if (document.getElementById('passwd2_reg').value.length < 8) {
                document.getElementById('error_passwd2_reg').innerHTML = "La password tiene que tener 8 caracteres como minimo";
                error = true;
            } else {
                if (document.getElementById('passwd2_reg').value === document.getElementById('passwd1_reg').value) {
                    document.getElementById('error_passwd2_reg').innerHTML = "";
                } else {
                    document.getElementById('error_passwd2_reg').innerHTML = "La password's no coinciden";
                    error = true;
                }
            }
        }

        if (error == true) {
            return 0;
        }
    }

    function register() {
        console.log("me registre"); 
        if (validate_register() != 0) {

            console.log("me registre"); 
            // var data = $('#register__form').serialize();


            var username = document.getElementById('username_reg').value;
            var passwd1 = document.getElementById('passwd1_reg').value;
    
            var email = document.getElementById('email_reg').value;

            ajaxPromise(friendlyURL("?module=login&op=register"), 'POST', 'JSON', {'username': username, 'password': passwd1, 'email': email})
                .then(function(result) {
                    if (result == "error_email") {
                        document.getElementById('error_email_reg').innerHTML = "El email ya esta en uso, asegurate de no tener ya una cuenta"
                    } else if (result == "error_user") {
                        document.getElementById('error_username_reg').innerHTML = "El usuario ya esta en uso, intentalo con otro"
                    } else {
                        toastr.success("Registery succesfully");
                        setTimeout(window.location.href = 'login', 1000);
                                
                    }
                }).catch(function(textStatus) {
                    if (console && console.log) {
                        console.log("La solicitud ha fallado: " + textStatus);
                    }
                });
    }
    }

    function click_register() {
        $("#register").keypress(function(e) {
            var code = (e.keyCode ? e.keyCode : e.which);
            if (code == 13) {
                console.log("potato");
                e.preventDefault();
                register();
            }
        });
    }

    function button_register() {
        $('#register').on('click', function(e) {
            console.log("potato");
            e.preventDefault();
            register();
        });
    }

    // ------------------- RECOVER PASSWORD ------------------------ //
    function load_form_recover_password(){
        $(".login-wrap").hide();
        $(".forget_html").show();
        $('html, body').animate({scrollTop: $(".forget_html")});
        click_recover_password();
    }

    function click_recover_password(){
        $(".forget_html").keypress(function(e) {
            var code = (e.keyCode ? e.keyCode : e.which);
            if(code==13){
                e.preventDefault();
                send_recover_password();
            }
        });

        $('#button_recover').on('click', function(e) {
            e.preventDefault();
            send_recover_password();
        }); 
    }

    function validate_recover_password(){
        var mail_exp = /^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/;
        var error = false;

        if(document.getElementById('email_forg').value.length === 0){
            document.getElementById('error_email_forg').innerHTML = "Tienes que escribir un correo";
            error = true;
        }else{
            if(!mail_exp.test(document.getElementById('email_forg').value)){
                document.getElementById('error_email_forg').innerHTML = "El formato del mail es invalido"; 
                error = true;
            }else{
                document.getElementById('error_email_forg').innerHTML = "";
            }
        }
        
        if(error == true){
            return 0;
        }
    }

    function send_recover_password(){
        if(validate_recover_password() != 0){
            var data = $('#recover_email_form').serialize();
            $.ajax({
                url: friendlyURL('?module=login&op=send_recover_email'),
                dataType: 'json',
                type: "POST",
                data: data,
            }).done(function(data) {
                if(data == "error"){		
                    $("#error_email_forg").html("The email doesn't exist");
                } else{
                    toastr.options.timeOut = 3000;
                    toastr.success("Email sended");
                    setTimeout('window.location.href = friendlyURL("?module=login")', 3000);
                }
            }).fail(function( textStatus ) {
                console.log('Error: Recover password error');
            });    
        }
    }

    function load_form_new_password(){
        token_email = localStorage.getItem('token_email');
        localStorage.removeItem('token_email');
        $.ajax({
            url: friendlyURL('?module=login&op=verify_token'),
            dataType: 'json',
            type: "POST",
            data: {token_email: token_email},
        }).done(function(data) {
            if(data == "verify"){
                click_new_password(token_email); 
            }else {
                console.log("error");
            }
        }).fail(function( textStatus ) {
            console.log("Error: Verify token error");
        });    
    }

    function click_new_password(token_email){
        $(".recover_html").keypress(function(e) {
            var code = (e.keyCode ? e.keyCode : e.which);
            if(code==13){
                e.preventDefault();
                send_new_password(token_email);
            }
        });

        $('#button_set_pass').on('click', function(e) {
            e.preventDefault();
            send_new_password(token_email);
        }); 
    }

    function validate_new_password(){
        var error = false;

        if(document.getElementById('pass_rec').value.length === 0){
            document.getElementById('error_password_rec').innerHTML = "You have to write a password";
            error = true;
        }else{
            if(document.getElementById('pass_rec').value.length < 8){
                document.getElementById('error_password_rec').innerHTML = "The password must be longer than 8 characters";
                error = true;
            }else{
                document.getElementById('error_password_rec').innerHTML = "";
            }
        }

        if(document.getElementById('pass_rec_2').value != document.getElementById('pass_rec').value){
            document.getElementById('error_password_rec_2').innerHTML = "Passwords don't match";
            error = true;
        }else{
            document.getElementById('error_password_rec_2').innerHTML = "";
        }

        if(error == true){
            return 0;
        }
    }

    function send_new_password(token_email){
        if(validate_new_password() != 0){
            var data = {token_email: token_email, password : $('#pass_rec').val()};
            $.ajax({
                url: friendlyURL("?module=login&op=new_password"),
                type: "POST",
                dataType: "JSON",
                data: data,
            }).done(function(data) {
                if(data == "done"){
                    toastr.options.timeOut = 3000;
                    toastr.success('New password changed');
                    setTimeout('window.location.href = friendlyURL("?module=login")', 3000);
                } else {
                    toastr.options.timeOut = 3000;
                    toastr.error('Error seting new password');
                }
            }).fail(function(textStatus) {
                console.log("Error: New password error");
            });    
        }
    }

// ------------------- LOGIN ------------------------ //
    function login() {
        if (validate_login() != 0) {  
            var  username =document.getElementById('username_log').value;
            var  passwd= document.getElementById('passwd_log').value;
        // console.log(formData);
            ajaxPromise(friendlyURL("?module=login&op=login"), 'POST', 'JSON',{'username': username, 'password': passwd})
                .then(function(result) {
                    console.log(result+ " result");
                    if (result === "error_user") {
                        document.getElementById('error_username_log').innerHTML = "El usario no existe,asegurase de que lo a escrito correctamente"
                    } else if (result === "error_passwd") {
                        document.getElementById('error_passwd_log').innerHTML = "La contraseña es incorrecta"
                    }else if (result === "3_fails"){
                        //document.getElementById('error_passwd_log').innerHTML = "ha fallado mucho, se le ha enviado un codigo"
                        toastr.error("Ha fallado mucho, ingrese el codigo enviado a su email");
                       
                       // console.log("3 fallos");
                        ajaxPromise(friendlyURL("?module=login&op=OTPTOKEN"), 'POST', 'JSON',{'username': username})
                        .then(function(OTPres) {
                            localStorage.setItem("OTPUSER",OTPres);
                            $(".login-form").hide();
                            $(".OTP_html").show();
                        }).catch(function(textStatus) {
                            if (console && console.log) {
                                console.log("La solicitud ha fallado1: " + textStatus);
                            }
                        });

                    }else {
                    localStorage.setItem("accesstoken", result[0]);
                    localStorage.setItem("refreshtoken", result[1]);
                        toastr.success("Loged succesfully");
                        console.log("access"+result[0]);
                        console.log("refresh"+result[1]);
                        if (localStorage.getItem('redirect_like')) {
                        setTimeout( window.location.href = friendlyURL("?module=shop") , 1000);
                        } else {
                        setTimeout( window.location.href = friendlyURL("?module=home") , 1000);
                        }
                    }
                }).catch(function(textStatus) {
                    if (console && console.log) {
                        console.log("La solicitud ha fallado: " + textStatus);
                    }
                });
        }
    }
    function validate_login() {
        var error = false;

        if (document.getElementById('username_log').value.length === 0) {
            document.getElementById('error_username_log').innerHTML = "Tienes que escribir el usuario";
            error = true;
        } else {
            if (document.getElementById('username_log').value.length < 5) {
                document.getElementById('error_username_log').innerHTML = "El usuario tiene que tener 5 caracteres como minimo";
                error = true;
            } else {
                document.getElementById('error_username_log').innerHTML = "";
            }
        }

        if (document.getElementById('passwd_log').value.length === 0) {
            document.getElementById('error_passwd_log').innerHTML = "Tienes que escribir la contraseña";
            error = true;
        } else {
            document.getElementById('error_passwd_log').innerHTML = "";
        }

        if (error == true) {
            return 0;
        }
    }

    function key_login() {
        $("#login").keypress(function(e) {
            var code = (e.keyCode ? e.keyCode : e.which);
            if (code == 13) {
                e.preventDefault();
                login();
            }
        });
    }

    function button_login() {
        $('#login').on('click', function(e) {
            e.preventDefault();
            login();
        });
    }
    function press_recover(){
        $('#psforget').on('click', function(e) {
            
                $(".forget_html").show();    
                $(".login-form").hide();
        
        });
    }
    function press_recoverback(){
        $('#button_forgetb').on('click', function(e) {
            console.log("botoncito");
        $(".forget_html").hide();    
        $(".login-form").show();
    });
    }
    function press_OTP(){
        $(".OTP_html").keypress(function(e) {
            var code = (e.keyCode ? e.keyCode : e.which);
            if(code==13){
                e.preventDefault();
                OTP_verify();
            }
        });
    
        $('#button_OTP').on('click', function(e) {
            e.preventDefault();
            OTP_verify();
        }); 

    }
    function OTP_verify(){
        OTPuser = localStorage.getItem('OTPUSER');
         OTPcode = document.getElementById('code').value;
       // localStorage.removeItem('OTPUSER');
       ajaxPromise(friendlyURL("?module=login&op=OTP_verify"), 'POST', 'JSON',{'OTPuser': OTPuser,'OTPcode':OTPcode})
                        .then(function(data) {
                            if(data=="verify"){
                                toastr.success('count reactivated');
                                $(".login-form").show();
                                $(".OTP_html").hide();
                            }else{
                                toastr.error('WRONG code');
                            }
                        }).catch(function(textStatus) {
                            if (console && console.log) {
                                console.log("La solicitud ha fallado1: " + textStatus);
                            }
                        });
       
    }
   

    $(document).ready(function() {
        $('#register').on('submit', function(e) {
            e.preventDefault(); // Prevent page reload
            register(); // Call your registration function
        });
    $(".forget_html").hide();
    $(".OTP_html").hide();
        press_recover();
        press_OTP();
        press_recoverback();
        key_login();
        button_login();
        // likebutton();
        click_recover_password();
        click_register();
        button_register();
    });