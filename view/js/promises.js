function ajaxPromise(sUrl, sType, sTData, sData = undefined) {
    
    return new Promise((resolve, reject) => {
        $.ajax({
            url: sUrl,
            type: sType,
            dataType: sTData,
            data: sData
        }).done((data) => {
            resolve(data);
        }).fail((jqXHR, textStatus, errorThrow) => {
            console.error('Ajax request failed:', textStatus, errorThrow);
           console.log('Complete jqXHR object:', jqXHR);
            reject(errorThrow);
        }); 
    });
};


//================LOAD-HEADER================
function load_menu() {
    var token = localStorage.getItem('accesstoken');
    if (token) {
        ajaxPromise('module/login/ctrl/ctrl_login.php?op=data_user', 'POST', 'JSON', { 'token': token })
            .then(function(data) {
                $('#user_info').empty();
                if (data.type_user == "client") {
                    console.log("Client loged");
                    $('.opc_CRUD').empty();
                    $('.opc_exceptions').empty();
                } else {
                    console.log("Admin loged");
                    $('.opc_CRUD').show();
                    $('.opc_exceptions').show();
                }
                $('.log-icon').empty();
                $('#user_info').empty();
                $('<img src="' + data.avatar + '"alt="Robot">').appendTo('.log-icon');
                $('<p></p>').attr({ 'id': 'user_info' }).appendTo('#des_inf_user')
                    .html(
                        '<a id="logout"><i id="icon-logout" class="fa-solid fa-right-from-bracket"></i></a>' +
                        '<a>' + data.username + '<a/>'

                    )

            }).catch(function() {
                console.log("Error al cargar los datos del user");
            });
    } else {
        console.log("No hay token disponible");
        $('.opc_CRUD').empty();
        $('.opc_exceptions').empty();
        $('#user_info').hide();
        $('.log-icon').empty();
        $('<a href="index.php?module=ctrl_login&op=login-register_view"><i id="col-ico" class="fa-solid fa-user fa-2xl"></i></a>').appendTo('.log-icon');
    }
}


//================CLICK-LOGIUT================
function click_logout() {
    $(document).on('click', '#logout', function() {
        localStorage.removeItem('total_prod');
        toastr.success("Logout succesfully");
        setTimeout('logout();', 1000);
    });

}

//================LOG-OUT================
function logout() {
    ajaxPromise('module/login/ctrl/ctrl_login.php?op=logout', 'POST', 'JSON')
        .then(function(data) {
            localStorage.removeItem('accesstoken');
            localStorage.removeItem('refreshtoken');
            window.location.href = "index.php?module=ctrl_home&op=list";
        }).catch(function() {
            console.log('Something has occured');
        });
}





function change_button() {
    var token = localStorage.getItem('accesstoken');
    var loginButton = document.querySelector('.login-button-menu');
    if (token) {    
        if (loginButton) {
            $('.log-icon').show();
            loginButton.innerHTML = '<a id="logout">Logout</a>';
            //click_logout();   
        }
    } else {
     
        if (loginButton) {
            $('.log-icon').hide();
            loginButton.innerHTML = '<a href="index.php?page=login">Login</a>';
        }
    }
}





$(document).ready(function() {
     load_menu();
    click_logout();
    change_button();
   // click_shop();
});