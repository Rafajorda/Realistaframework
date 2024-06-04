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
function friendlyURL(url) {
    if(url !==undefined){
    var link = "";
    url = url.replace("?", "");
    url = url.split("&");
    cont = 0;
    for (var i = 0; i < url.length; i++) {
    	cont++;
        var aux = url[i].split("=");
        if (cont == 2) {
        	link += "/" + aux[1] + "/";	
        }else{
        	link += "/" + aux[1];
        }
    }
    return link;
    }
}


//================LOAD-HEADER================
function load_menu() {
    var accesstoken = localStorage.getItem('accesstoken');
    if (accesstoken) {
        ajaxPromise(friendlyURL("?module=login&op=data_user"), 'POST', 'JSON', { 'accesstoken': accesstoken })
            .then(function(data) {
                console.log("data user  ",data[0]);
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
                $('<img src="' + data[0].avatar + '"alt="Robot">').appendTo('.log-icon');
                $('<p></p>').attr({ 'id': 'user_info' }).appendTo('#des_inf_user')
                    .html(
                        '<a id="logout"><i id="icon-logout" class="fa-solid fa-right-from-bracket"></i></a>' +
                        '<a>' + data[0].username + '<a/>'

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
        $('<a href="friendlyURL("?module=login&op=login")"><i id="col-ico" class="fa-solid fa-user fa-2xl"></i></a>').appendTo('.log-icon');
    }
}
function load_content() {
    let path = window.location.pathname.split('/');
    console.log(path);
    if(path[2] === 'recover'){
        window.location.href = friendlyURL("?module=login&op=recover_view");
        localStorage.setItem("token_email", path[3]);
    }else if (path[2] === 'verify') {
        ajaxPromise(friendlyURL("?module=login&op=verify_email"), 'POST', 'JSON', {token_email: path[3]})
        .then(function(data) {
            toastr.options.timeOut = 3000;
            toastr.success('Email verified');
            setTimeout(window.location.href = friendlyURL("?module=home"), 3000);
        })
        .catch(function() {
          console.log('Error: verify email error');
        });
    
    }else if (path[2] === 'view') {
        $(".login-wrap").show();
        $(".forget_html").hide();
    }else if (path[2] === 'recover_view') {
        load_form_new_password();
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
    ajaxPromise(friendlyURL("?module=login&op=logout"), 'POST', 'JSON')
        .then(function(data) {
            localStorage.removeItem('accesstoken');
            localStorage.removeItem('refreshtoken');
            window.location.href = friendlyURL("?module=home");
        }).catch(function() {
            console.log('Something has occured');
        });
}
//================show cart================

function show_cart(){

    var token = localStorage.getItem('accesstoken');

    if(token){
        $('#boton_cart').show();
    }
}
function click_cart(){
    $(document).on('click', '#boton_cart', function() {
        window.location.href = friendlyURL("?module=cart");
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
            loginButton.innerHTML = '<a href="login">Login</a>';
        }
    }
}
function click_log_icon() {
    $(document).on('click', '.log-icon', function() {
        
        window.location.href = friendlyURL("?module=profile");
       
    });

}

function count_cart(accesstoken){
    if (!accesstoken) {
        
        accesstoken = localStorage.getItem('accesstoken');
    }
    
    ajaxPromise(friendlyURL("?module=cart&op=count"),'POST','JSON', {'accesstoken':accesstoken })
    
        .then(function(data) {
            document.getElementById('cart-count').innerText = data;
        })
        .catch(function(error) {
            console.error('Error fetching data:', error);
           
        });

   
}
//________________________________________________________________________________

$(document).ready(function() {
    $('#boton_cart').hide();
    load_content();
     load_menu();
     friendlyURL();
     click_logout();
     change_button();
     click_log_icon();
   // click_shop();
   show_cart();
    click_cart();
    count_cart();
   
});