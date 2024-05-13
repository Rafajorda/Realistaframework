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
// function click_logout() {
//     $(document).on('click', '#logout', function() {
//         localStorage.removeItem('total_prod');
//         toastr.success("Logout succesfully");
//         setTimeout('logout();', 1000);
//     });

// }

//================LOG-OUT================
// function logout() {
//     ajaxPromise('module/login/ctrl/ctrl_login.php?op=logout', 'POST', 'JSON')
//         .then(function(data) {
//             localStorage.removeItem('accesstoken');
//             localStorage.removeItem('refreshtoken');
//             window.location.href = "index.php?module=ctrl_home&op=list";
//         }).catch(function() {
//             console.log('Something has occured');
//         });
// }





// function change_button() {
//     var token = localStorage.getItem('accesstoken');
//     var loginButton = document.querySelector('.login-button-menu');
//     if (token) {    
//         if (loginButton) {
//             $('.log-icon').show();
//             loginButton.innerHTML = '<a id="logout">Logout</a>';
//             //click_logout();   
//         }
//     } else {
     
//         if (loginButton) {
//             $('.log-icon').hide();
//             loginButton.innerHTML = '<a href="index.php?page=login">Login</a>';
//         }
//     }
// }
//________________________________________________________________________________

// function load_ahorro() {
//     ajaxPromise(friendlyURL("?module=home&op=ahorrov "), 'POST', 'JSON',)
//         .then(function(data) {
//             // $('#ahorro_vivienda').append('<option value = "0">ahorro_vivienda</option>');
//             // for (row in data) {
//             //     $('#ahorro_vivienda').append('<option value = "' + data[row].idahorro + '">' + data[row].nameahorro + '</option>');
//             // }
//             console.log(data);
//         }).catch(function() {
//             console.log("Fail load ahorro_vivienda");
//         });
// }

// //__________________________________________________________________________________
// function load_ahorro_type(data) {
//     console.log("ahorro",data);
//     if (data == undefined || (data && data.ahorro === "0") ) {
//         ajaxPromise(friendlyURL("?module=search&op=type_ahorro_vivienda"), 'POST', 'JSON',data)
//             .then(function(data) {
//                 $('#type_vivienda').empty();
//                 $('#type_vivienda').append('<option value = "0">tipo</option>');
//                 for (row in data) {
//                     $('#type_vivienda').append('<option value = "' + data[row].idtipo + '">' + data[row].nametipo + '</option>');
//                 }
//             }).catch(function(data) {
//                 console.log('Fail load pepito');
//             });
//     } else {
//         ajaxPromise(friendlyURL("?module=search&op=type_ahorro_vivienda"), 'POST', 'JSON', data)
//             .then(function(data) {
//                 $('#type_vivienda').empty();
//                 $('#type_vivienda').append('<option value = "0">types</option>');
//                 for (row in data) {
//                     $('#type_vivienda').append('<option value = "' + data[row].idtipo + '">' + data[row].nametipo + '</option>');
//                 }
//             }).catch(function(data) {
//                 console.log('Fail load type');
//             });
//     }
// }
// function launch_search() {
   
//     load_ahorro();
//    // load_ahorro_type();
//     $('#ahorro_vivienda').on('change', function() {
//         let ahorro = $(this).val();
//         console.log(ahorro);
//         if (ahorro === 0) {
//             load_ahorro_type(ahorro);
//         } else {
//             load_ahorro_type({ahorro});
//         }
//     });
// }


// function autocomplete() {
//     let timer;

//     $("#autocom").on(" keyup focus input", function() {
//         clearTimeout(timer);
//         let sdata = { complete: $(this).val() };

//         if ($('#ahorro_vivienda').val() != "0") {
//             sdata.ahorro = $('#ahorro_vivienda').val();
//             if ($('#type_vivienda').val() != "0") {
//                 sdata.type = $('#type_vivienda').val();
//             }
//         } else if ($('#type_vivienda').val() != "0") {
//             sdata.type = $('#type_vivienda').val();
//         }

//         timer = setTimeout(function() {
//             ajaxPromise("?module=search&op=autocomplete", 'POST', 'JSON', sdata)
//                 .then(function(data) {
//                     $('#search_vivienda').empty();
//                     if (data.length > 0) {
//                         let uniqueCities = new Set();
//                         data.forEach(function(row) {
//                             uniqueCities.add({ name: row.namecity, id: row.idcity });
//                         });
//                         uniqueCities.forEach(function(city) {
//                             $('<div></div>').appendTo('#search_vivienda')
//                                 .html(city.name)
//                                 .attr({ 'class': 'searchElement', 'id': city.id })
//                                 .on('click', function() {
//                                     $('#autocom').val(city.name);
//                                     $('#autocom').data('cityid', city.id);
//                                     $('#search_vivienda').fadeOut(900);
//                                 });
//                         });
//                         $('#search_vivienda').fadeIn(100);
//                     } else {
//                         $('#search_vivienda').fadeOut(1000);
//                     }
//                 })
//                 .catch(function() {
//                     $('#search_vivienda').fadeOut(500);
//                 });
//         }, 500);
//     });

//     $(document).on('click scroll', function(event) {
//         if (!$(event.target).closest('#search_vivienda').length) {
//             $('#search_vivienda').fadeOut(1000);
//         }
//     });
// }



// function btn_search() {
//     $('#search-btn').on('click', function() {
//         var search = [];

//         if ($('#autocom').val() == "") {
//           //  search.push({ "city": '0' });
         
//           if($('#ahorro_vivienda').val()!=0){
//             search.push([ "ahorro", $('#ahorro_vivienda').val() ]);
//           } 
//           if($('#type_vivienda').val()!=0){
//             search.push([ "tipo", $('#type_vivienda').val() ]);
//           }
//         } else {
//             search.push([ "city", $('#autocom').data('cityid') ]);
//             if($('#ahorro_vivienda').val()!=0){
//             search.push([ "ahorro", $('#ahorro_vivienda').val() ]);
//             }
//             if($('#type_vivienda').val()!=0){
//             search.push(["tipo", $('#type_vivienda').val() ]);
//             }
//         }

//         localStorage.removeItem('filters');
//         localStorage.removeItem('type_filter');
//         localStorage.removeItem('category_filter');
//         localStorage.removeItem('order');
        

//         localStorage.setItem('search', JSON.stringify(search));

//         window.location.href = 'shop';
//     });
// }


$(document).ready(function() {
    // load_menu();
     friendlyURL();
    // click_logout();
    // change_button();
   // click_shop();
});