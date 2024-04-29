function protecturl() {
    var accesstoken = localStorage.getItem('accesstoken');
    var refreshtoken =localStorage.getItem('refreshtoken');
    ajaxPromise('module/login/ctrl/ctrl_login.php?op=controluser', 'POST', 'JSON', { 'accesstoken': accesstoken })
        .then(function(data) {
            if (data == "Correct_User") {
                console.log("CORRECTO-->El usario coincide con la session");
            } else if (data == "Wrong_User") {
                console.log("INCORRCTO--> Estan intentando acceder a una cuenta");
                logout_auto();
            }
        })
        .catch(function() { console.log("ANONYMOUS_user") });

    ajaxPromise('module/login/ctrl/ctrl_login.php?op=expires', 'POST', 'JSON', { 'accesstoken': accesstoken, 'refreshtoken': refreshtoken })
        .then(function(data) {
            if (data == "Correct_User") {
                console.log("CORRECTO-->El usario coincide con la session(expires)");
            } else if (data == "Wrong_User") {
                console.log("INCORRCTO--> Estan intentando acceder a una cuenta(expires)");
                logout_auto();
            }
        })
        .catch(function() { console.log("ANONYMOUS_user") });


}

function control_activity() {
    var token = localStorage.getItem('accesstoken');
    console.log("holiwi token"+token);
    if (token) {
        ajaxPromise('module/login/ctrl/ctrl_login.php?op=actividad', 'POST', 'JSON')
            .then(function(response) {
                if (response == "inactivo") {
                    console.log("usuario INACTIVO");
                    logout_auto();
                } else {
                    console.log("usuario ACTIVO");
                }
            });
    } else {
        console.log("No hay usario logeado");
    }
}

// function refresh_token() {
//     var token = localStorage.getItem('accesstoken');
//     if (token) {
//         ajaxPromise('module/login/ctrl/ctrl_login.php?op=refresh_token', 'POST', 'JSON', { 'token': token })
//             .then(function(data_token) {
//                 console.log("Refresh token correctly");
//                 localStorage.setItem("token", data_token);
//                 //load_menu();
//             });
//     }
// }

function refresh_cookie() {
    ajaxPromise('module/login/ctrl/ctrl_login.php?op=refresh_cookie', 'POST', 'JSON')
        .then(function(response) {
            console.log("Refresh cookie correctly");
        });
}

function logout_auto() {
    ajaxPromise('module/login/ctrl/ctrl_login.php?op=logout', 'POST', 'JSON')
    .then(function(data) {
        localStorage.removeItem('accesstoken');
        localStorage.removeItem('refreshtoken');
        remove_filterslogout();

        toastr.warning("Se ha cerrado la cuenta por seguridad!!");
        setTimeout('window.location.href = "index.php?module=ctrl_login&op=login-register_view";', 2000);
    }).catch(function() {
        console.log('Something has occured');
    });
   
}

function remove_filterslogout() {
    localStorage.removeItem('filters');
    localStorage.removeItem('filter_m2');
    localStorage.removeItem('filter_m2MAX');
    localStorage.removeItem('filter_m2MIN');
    localStorage.removeItem('filter_ahorro');
    localStorage.removeItem('filter_type');
    localStorage.removeItem('filter_category');
    localStorage.removeItem('filter_operation');
    localStorage.removeItem('filter_city');
    localStorage.removeItem('filtrosshop');
    localStorage.removeItem('filter_pricemin');
    localStorage.removeItem('filter_pricemax');
    localStorage.removeItem('order');
    localStorage.removeItem('currentPage');
    
    }

$(document).ready(function() {
    setInterval(function() { control_activity() }, 60000); //10min= 600000
    protecturl();
    // setInterval(function() { refresh_token() }, 60000);
    setInterval(function() { refresh_cookie() }, 60000);
});