    function loadvivienda() {

        if (!localStorage.getItem('currentPage')) {
           
            localStorage.setItem('currentPage', '1');
        }
        var urlParams = new URLSearchParams(window.location.search);
        var viviendaID = urlParams.get('viviendaID');
            
        let filtroshome = JSON.parse(localStorage.getItem('filtershome'))||undefined;
     
        let filtroshop = JSON.parse(localStorage.getItem('filtrosshop'))||undefined;
        let filtrosearch = JSON.parse(localStorage.getItem('search'))||undefined;


       if (viviendaID) {
      
        loadDetails(viviendaID);
        
    } else  if(filtroshome!=undefined){
        localStorage.setItem('currentPage', '1');
              pagination(filtroshome); 
           

        }else if(filtroshop!==undefined &&  filtroshop.length !== 0 ){
            console.log("shoploadvivienda");

        pagination(filtroshop);

     

        }else if(filtrosearch!==undefined &&  filtrosearch.length !== 0 ){
            console.log("searchloadvivienda");
           pagination(filtrosearch);

        }else{
            pagination();
          
        }
        }

//_______________________________________________________________________________________________________________________

function ajaxForSearch(url,send, total_prod, items_page = 3) {  
    if (typeof total_prod === 'undefined') {
        total_prod = 0; // Set default value if not provided
     }
     console.log("total prod", total_prod);   
   // total_prod =0;
    ajaxPromise(url, send, 'JSON', { 'total_prod': total_prod, 'items_page': items_page })
        .then(function(data) {
            console.log("ajaxforsearch1",data);
            $('#content_shop_vivienda').empty();
            $('.date_vivienda' && '.date_img').empty();
                         
            // Mejora para que cuando no hayan resultados en los filtros aplicados
            if (data == "error") {
                $('<div></div>').appendTo('#content_shop_vivienda')
                    .html(
                        '<h3>¡No se encuentran resultados con los filtros aplicados!</h3>'
                    );
            } else {   
                data.forEach(function(item) {
                    var firstImageUrl = item.imgimages.split(':')[0];
                    var like = 0; // Default value
                    likes(item.idvivienda, function(likeValue) {
                        like = likeValue;
                        var likeButtonHTML = "";
                        if (like === 0) {
                            likeButtonHTML = "<button class='likeButton' id='" + item.idvivienda + "'><img src='view/img/icon/like.png' alt='Icono de like' width='50' height='50'></button> &nbsp;"; 
                        } else if (like === 1) {
                            likeButtonHTML = "<button class='likeButton' id='" + item.idvivienda + "'><img src='view/img/icon/likefull.png' alt='Icono de like' width='50' height='50'></button> &nbsp;"; 
                        }
                        
                        console.log("hola likes", like); 
                        $('<div></div>').attr({ 'id': item.idvivienda, 'class': 'list_content_shop' }).appendTo('#content_shop_vivienda')
                            .html(
                                "<div class='list_product'>" +
                                    "<div class='img-container'>" +
                                        "<div class='container'>" +
                                            "<div class='row text-left pad-row'>" +
                                                "<div class='col-md-3 col-sm-3 col-xs-6'>" +
                                                    "<img src=" + firstImageUrl + " alt='Your Image' class='img-responsive bigger-image'>" +
                                                "</div>" +                                
                                                "<div class='col-md-5 col-sm-5 col-xs-6 col-xs-offset-0'>"+
                                                    "<div class='panel panel-danger'>" +
                                                        "<div class='panel-heading'>" +
                                                            "<h4>" + item.nameviv + "</h4>" +
                                                        "</div>" +
                                                             "<div class='panel-body'>" +
                                                                "<ul class='plan'>" +
                                                                    "<li>" + item.namecat + " " + item.nametipo + " " + item.nameop + "</li>" +
                                                                    "<li>" + item.nameahorro + "</li>" +
                                                                    "<li class='row'>" +
                                                                    "<div class='col-md-9'>" +
                                                                    "</div>" +
                                                                    "<div class='col-md-3 text-right'>" +
                                                                        "<strong>" + item.price + "</strong> <i class='fa fa-euro'></i>" +
                                                                    "</div>" +
                                                                    "<div class='col-md-3 text-right'>" +
                                                                        "<td style='padding-right: 200px;'>"+
                                                                        likeButtonHTML+
                                                                        "</td>" +
                                                                    "</div>" +
                                                                    "</li>" +
                                                                "</ul>" +
                                                            "</div>" +
                                                            "<div class='panel-footer'>" +
                                                                "<button id='" + item.idvivienda + "' class='more_info_list button add golist' >More Info</button>" +
                                                            "</div>" +
                                                        "</div>" +
                                                    "</div>" +
                                                "</div>" +
                                            "</div>" +
                                        "</div>"
                            );
                    });
                });
            }

            setTimeout(function() {
                console.log("antes de mapa");
                mapBox_all(data);
            }, 100);
        })
        .catch(function() {
            // window.location.href = "index.php?module=ctrl_exceptions&op=503&type=503&lugar=Function ajaxForSearch SHOP";
        });
}

function likes(idvivienda, callback) {
    if (localStorage.getItem('accesstoken')) {
        console.log("entre a lo de likes " + idvivienda);
        var accesstoken = localStorage.getItem('accesstoken');
        ajaxPromise(friendlyURL("?module=shop&op=likes"), 'POST', 'JSON',{'accesstoken': accesstoken, 'idvivienda': idvivienda})
            .then(function(data1) { 
                console.log(data1 + " aqui data 1 likes");
                var like = 0;
                if(data1 == 1) {
                    like = 1;
                }
                callback(like);
            })
            .catch(function() {
                console.log('Something has occurred in likes');
                callback(like);
            });
    } else {
        var like = 0; // Default value
        callback(like);
    }
}
function likebutton(){
    $(document).on("click", ".likeButton", function() {
        var idvivienda = this.getAttribute('id');
        var $likeButton = $(this);  
        if(localStorage.getItem('accesstoken')){

            accesstoken = localStorage.getItem('accesstoken');
            ajaxPromise(friendlyURL("?module=shop&op=likes"), 'POST', 'JSON',{'accesstoken': accesstoken, 'idvivienda': idvivienda})
            .then(function(data) {
                if(data==0){

                    ajaxPromise(friendlyURL("?module=shop&op=addlike"), 'POST', 'JSON',{'accesstoken': accesstoken, 'idvivienda': idvivienda})
                    .then(function(data1) {
                        $likeButton.html("<img src='view/img/icon/likefull.png' alt='Icono de like' width='50' height='50'>");

                    }).catch(function() {
                        console.log('Something has occurred in likes');
               
                    });
                }else if(data==1){

                    ajaxPromise(friendlyURL("?module=shop&op=deletelike"), 'POST', 'JSON',{'accesstoken': accesstoken, 'idvivienda': idvivienda})
                    .then(function(data2) {
                        $likeButton.html("<img src='view/img/icon/like.png' alt='Icono de like' width='50' height='50'>");

                    }).catch(function() {
                        console.log('Something has occurred in likes');
                       
                    });
                }

            })
            .catch(function() {
                console.log('Something has occurred in likes');
                
            });
        }else{           
            setTimeout(function(){ 
                window.location.href =friendlyURL("?module=login");
              }, 1000); 
        }
    });


}

function ajaxForSearch2(url, send, filtros, total_prod = 0, items_page = 3) {
    console.log("patata", filtros, total_prod, items_page);

    ajaxPromise(url, send, 'JSON', { 'filtros': filtros, 'total_prod': total_prod, 'items_page': items_page })
        .then(function(data) {
            console.log("promise", data);
            $('#content_shop_vivienda').empty();
            $('.date_vivienda' && '.date_img').empty();

            if (data == "error") {
                $('<div></div>').appendTo('#content_shop_vivienda')
                    .html('<h3>¡No se encuentran resultados con los filtros aplicados!</h3>');
            } else {
                // Iterate over each item in the data
                data.forEach(function(item) {
                    var firstImageUrl = item.imgimages.split(':')[0];
                    var like = 0; // Default value

                    // Call the likes function to get the like status for the current item
                    likes(item.idvivienda, function(likeValue) {
                        like = likeValue; // Update the like status

                        // Create the HTML content with the appropriate like button
                        var likeButtonHTML = "";
                        if (like === 0) {
                            likeButtonHTML = "<button class='likeButton' id='" + item.idvivienda + "'><img src='view/img/icon/like.png' alt='Icono de like' width='50' height='50'></button> &nbsp;";
                        } else if (like === 1) {
                            likeButtonHTML = "<button class='likeButton' id='" + item.idvivienda + "'><img src='view/img/icon/likefull.png' alt='Icono de like' width='50' height='50'></button> &nbsp;";
                        }

                        // Append the item HTML to the content shop div
                        $('<div></div>').attr({ 'id': item.idvivienda, 'class': 'list_content_shop' }).appendTo('#content_shop_vivienda')
                            .html(
                                "<div class='list_product'>" +
                                "<div class='img-container'>" +
                                "<div class='container'>" +
                                "<div class='row text-left pad-row'>" +
                                "<div class='col-md-3 col-sm-3 col-xs-6'>" +
                                "<img src=" + firstImageUrl + " alt='Your Image' class='img-responsive bigger-image'>" +
                                "</div>" +
                                "<div class='col-md-5 col-sm-5 col-xs-6 col-xs-offset-0'>" +
                                "<div class='panel panel-danger'>" +
                                "<div class='panel-heading'>" +
                                "<h4>" + item.nameviv + "</h4>" +
                                "</div>" +
                                "<div class='panel-body'>" +
                                "<ul class='plan'>" +
                                "<li>" + item.namecat + " " + item.nametipo + " " + item.nameop + "</li>" +
                                "<li>" + item.nameahorro + "</li>" +
                                "<li class='row'>" +
                                "<div class='col-md-9'>" +
                                "</div>" +
                                "<div class='col-md-3 text-right'>" +
                                "<strong>" + item.price + "</strong> <i class='fa fa-euro'></i>" +
                                "</div>" +
                                "<div class='col-md-3 text-right'>" +
                                "<td style='padding-right: 200px;'>" +
                                likeButtonHTML +
                                "</td>" +
                                "</div>" +
                                "</li>" +
                                "</ul>" +
                                "</div>" +
                                "<div class='panel-footer'>" +
                                "<button id='" + item.idvivienda + "' class='more_info_list button add golist' >More Info</button>" +
                                "</div>" +
                                "</div>" +
                                "</div>" +
                                "</div>" +
                                "</div>"
                            );
                    });
                });
            }

            setTimeout(function() {
                console.log("antes de mapa");
                mapBox_all(data);
            }, 100);
        })
        .catch(function() {
            $('#content_shop_vivienda').empty();
            $('<div></div>').appendTo('#content_shop_vivienda')
                .html('<h1>No hay viviendas con estos filtros</h1>');
        });
}


    function clicks() {
            $(document).on("click", ".golist", function() {
                var idvivienda = this.getAttribute('id');
                loadDetails(idvivienda);
                
            });
        }
//_____________________________details block_____________________________________________________
  
    function loadDetails(idvivienda) {
        ajaxPromise(friendlyURL("?module=shop&op=details"),'POST','JSON', { 'idvivienda': idvivienda })
        //ajaxPromise('module/shop/ctrl/ctrl_shop.php?op=details_vivienda&id=' + idvivienda, 'GET', 'JSON')
            .then(function(data) {
                console.log("details", data);
                $('.details-shop').empty();
                $('#content_shop_vivienda').empty();
                $('.date_vivienda').empty();
                $('.date_img_dentro').empty();
                $('#container-date-img').empty();
                $('.date_img').empty();
                $('.date_vivienda_dentro').empty();
                $('.div-filters').empty();
                $('.mapd').empty();
                $('.containerinshop').empty();
                $('.container_shop').empty();
                $('.title_content').empty();
    
                if (data && data[0].imgimages) {
                    if ($('.date_img').hasClass('slick-initialized')) {
                        $('.date_img').slick('unslick');
                    }
    
                    $('.date_img').empty();
    
                    console.log('Image URLs:', data[0].imgimages);
    
                    var ImageUrls = data[0].imgimages.split(':'); // Split the imgimages string
                    ImageUrls.forEach(function(ImageUrl) { // Loop through each ImageUrl
                        $('<div><img src="' + ImageUrl + '"></div>').appendTo('.date_img');
                    });
                }
                var cartButtonHTML = "<span class='cart_button' data-idvivienda='" + data[0].idvivienda + "'><img src='view/img/icon/cart.png' alt='Cart Icon'></span>";
            if (data[0].stock <= 0) {
                cartButtonHTML = "<span class='cart_button no-stock' data-idvivienda='" + data[0].idvivienda + "' disabled>No Stock</span>";
            }
    
                $('<div></div>').attr({ 'id': data[0].idvivienda, class: 'date_vivienda_dentro' }).appendTo('.date_vivienda')
                    .html(
                        "<div class='list_product_details'>" +
                        "<div class='product-info_details'>" +
                        "<div class='product-content_details'>" +
                        //"<span class='cart_button' id='cart_details'><img src=view/img/icon/cart.png alt='Cart Icon'></span>"+
                        //"<span class='cart_button' data-idvivienda='" + data[0].idvivienda + "'><img src=view/img/icon/cart.png alt='Cart Icon'></span>" +
                        cartButtonHTML+
                        "<h1><b>" + data[0].nameviv + "</b></h1>" +
                        "<hr class=hr-shop>" +
                        "<table id='table-shop'>" +
                        "<tr>" +
                        "<td style='padding-right: 200px;'>" +
                        " <img src= view/img/icon/cityic.png  alt= Icono de ciudad width=50 height=50> &nbsp;" + data[0].namecity +
                        "</td>" +
                        "<td style='padding-right: 200px;'>" +
                        " <img src= view/img/icon/houseic.png  alt= Icono de categoria width=50 height=50> &nbsp;" + data[0].namecat +
                        "</td>" +
                        "<td style='padding-right: 200px;'>" +
                        " <img src= view/img/icon/squareic.png  alt= Icono de ciudad width=50 height=50> &nbsp;" + data[0].superficie + " m2" +
                        "</td>" +
                        "</tr>" +
                        "<tr>" +
                        "<td>" +
                        " <img src= view/img/icon/cityic.png  alt= Icono de tipo width=50 height=50> &nbsp;" + data[0].nametipo +
                        "</td>" +
                        "<td>" +
                        " <img src= view/img/icon/sellic.png  alt= Icono de operacion width=50 height=50> &nbsp;" + data[0].nameop +
                        "</td>" +
                        "<td>" +
                        " <img src= view/img/icon/energyic.png  alt= Icono de ahorro energetico width=50 height=50> &nbsp;" + data[0].nameahorro +
                        "</td>" +
                        "</tr>" +
                        "</table>" +
                        "<hr class=hr-shop>" +
                        "<h3><b>" + "More Information:" + "</b></h3>" +
                        "<div class='buttons_details'>" +
                        "<a class='button add' href='#'>BUY</a>" +
                        "<span class='button' id='price_details'>" + data[0].price + "<i class='fa-solid fa-euro-sign'></i> </span>" +
                        "<a class='details__heart' id='" + data[0].idvivienda + "'><i id=" + data[0].idvivienda + " class='fa-solid fa-heart fa-lg'></i></a>" +
                        "<div id='mapd'></div>" +
                        "</div>" +
                        "</div>" +
                        "</div>" +
                        "</div>"
                    );
    
                $('.date_img').slick({
                    infinite: true,
                    speed: 300,
                    slidesToShow: 3,
                    adaptiveHeight: true,
                    autoplay: true,
                    autoplaySpeed: 1500,
                    dots: true,
                    prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                    nextArrow: '<button type="button" class="slick-next">Next</button>'
                });
    
                setTimeout(function() {
                    mapBox(data[0]);
                }, 100);
    
                $('.results').empty();
    
                loadrelated(data[0].ahorro, data[0].idvivienda);
    
                
                likes(data[0].idvivienda, function(likeValue) {
                    var likeButtonHTML = "";
                    if (likeValue === 0) {
                        likeButtonHTML = "<button class='likeButton' id='" + data[0].idvivienda + "'><img src='view/img/icon/like.png' alt='Icono de like' width='50' height='50'></button> &nbsp;";
                    } else if (likeValue === 1) {
                        likeButtonHTML = "<button class='likeButton' id='" + data[0].idvivienda + "'><img src='view/img/icon/likefull.png' alt='Icono de like' width='50' height='50'></button> &nbsp;";
                    }
    
                    
                    $('.date_img').after(likeButtonHTML);
                });
    
                document.documentElement.scrollTop = 0;
            })
            .catch(function(error) {
                console.error('Error fetching data:', error);
               
            });
    }
    

    function loadrelated(ahorro,idvivienda){
          //  var ahorro = ahorro;
            var viviendas = 0;

             ajaxPromise(friendlyURL("?module=shop&op=count_ahorro_related"), 'POST', 'JSON', { 'ahorro': ahorro, 'idvivienda': idvivienda })
        .then(function(data) {
            var total_viviendas = data[0].contador;
           viviendas_related(0, ahorro, total_viviendas,idvivienda);
            $(document).on("click", '.load_more_button', function() {
                viviendas = viviendas + 2;
                $('.more_casa__button').empty();
                  viviendas_related(viviendas, ahorro, total_viviendas,idvivienda);
            });
            }).catch(function() {
                console.log('error total_items');
            });
        }

//____________________________________________________________________________________________________________________
function moreInfoClickHandler(event) {
    let detailsLoading = false;
    if (!detailsLoading) {
        detailsLoading = true;
        var idvivienda = this.id;
        $('.date_img').empty();
        loadDetails(idvivienda);
    //    $(this).off(event); // Unbind the click event after execution
    }
}

$(document).ready(function() {
    $('.results').on("click", ".more_info_list", moreInfoClickHandler);
});

function viviendas_related(loadeds = 0, ahorro, total_viviendas, idvivienda) {
    let viviendas = 2;
    let loaded = loadeds;
    let type = ahorro;
    let total_vivienda = total_viviendas;

    ajaxPromise(friendlyURL("?module=shop&op=ahorro_related"), 'POST', 'JSON', { 'type': type, 'loaded': loaded, 'viviendas': viviendas, 'idvivienda': idvivienda })
        .then(function(data) {
            if (loaded == 0) {
                $('<div></div>').attr({ 'id': 'title_content', class: 'title_content' }).appendTo('.results')
                    .html(
                        '<h2 class="cat">Viviendas related</h2>'
                    );
                for (row in data) {
                    if (data[row].idvivienda != undefined) {
                        let imgC = data[row].imgimages.split(':');
                        $('<div></div>').attr({ 'id': data[row].idvivienda, 'class': 'more_info_list', 'data-loaded': 'true' }).appendTo('.title_content')
                            .html(
                                "<li class='portfolio-item'>" +
                                "<div class='item-main'>" +
                                " <div class='portfolio-title'>" +
                                " <h4>" + data[row].nameviv + "</h4>" +
                                "</div>" +
                                "<div class='portfolio-image'>" +
                                "<img src = " + imgC[0] + " alt='imagen casa' </img> " +
                                "</div>" +
                                "<h5>" + data[row].nameahorro + "  " + data[row].namecat + "</h5>" +
                                "</div>" +
                                "</li>"
                            );
                    }
                }
                $('<div></div>').attr({ 'id': 'more_casa__button', 'class': 'more_casa__button' }).appendTo('.title_content')
                    .html(
                        '<button class="load_more_button" id="load_more_button">LOAD MORE</button>'
                    );
            }
            if (loaded >= 2) {
                if (data.length < 2) {
                    if (idvivienda) {
                        ajaxPromise("?module=shop&op=extra_vivienda", 'POST', 'JSON', { 'ahorro' :ahorro, 'idvivienda': idvivienda })
                            .then(function(extraData) {
                                if (extraData.length > 0) {
                                    let imgC = extraData[0].imgimages.split(':');
                                    $('<div></div>').attr({ 'id': extraData[0].idvivienda, 'class': 'more_info_list', 'data-loaded': 'true' }).appendTo('.title_content')
                                        .html(
                                            "<li class='portfolio-item'>" +
                                            "<div class='item-main'>" +
                                            "<div class='portfolio-title'>" +
                                            "<h4>" + extraData[0].nameviv + "</h4>" +
                                            "</div>" +
                                            "<div class='portfolio-image'>" +
                                            "<img src = " + imgC[0] + " alt='imagen car' </img> " +
                                            "</div>" +
                                            "<h5>" + extraData[0].nameahorro + "  " + extraData[0].namecat + "</h5>" +
                                            "</div>" +
                                            "</li>"
                                        );
                                }
                            }).catch(function() {
                                console.log("error fetching extra vivienda");
                            });
                    }
                }
                for (row in data) {
                    if (data[row].idvivienda != undefined && $('.more_info_list[id="' + data[row].idvivienda + '"]').length === 0) {
                        let imgC = data[row].imgimages.split(':');
                        $('<div></div>').attr({ 'id': data[row].idvivienda, 'class': 'more_info_list', 'data-loaded': 'true' }).appendTo('.title_content')
                            .html(
                                "<li class='portfolio-item'>" +
                                "<div class='item-main'>" +
                                " <div class='portfolio-title'>" +
                                " <h4>" + data[row].nameviv + "</h4>" +
                                "</div>" +
                                "<div class='portfolio-image'>" +
                                "<img src = " + imgC[0] + " alt='imagen car' </img> " +
                                "</div>" +
                                "<h5>" + data[row].nameahorro + "  " + data[row].namecat + "</h5>" +
                                "</div>" +
                                "</li>"
                            );
                    }
                }
                var viv = total_vivienda - 2;
                if (viv <= loaded) {
                    $('.more_casa__button').empty().hide();
                } else {
                    $('.more_casa__button').empty();
                    $('<div></div>').attr({ 'id': 'more_casa__button', 'class': 'more_casa__button' }).appendTo('.title_content')
                                            .html(
                                                '<button class="load_more_button" id="load_more_button">LOAD MORE</button>'
                                            )
                                    }
                                }
                            }).catch(function() {
                                console.log("error cars_related");
                            }).finally(function() {
                                detailsLoading = false;
                            });
}

    //_____________________________________________________________________________________________________________

    function print_filters() {
        // Fetch options for each dropdown
        fetchCategories();
        fetchTypes();
        fetchOperations();
        fetchCities();
        fetchAhorro();
    
    
        $('<div class="div-filters"></div>').appendTo('.filters')
                .html('<select class="filter_type" id="selectfilter"></select>' +
                    '<select class="filter_category" id="selectfilter"></select>' +
                    '<select class="filter_operation" id="selectfilter"></select>' +
                    '<select class="filter_city" id="selectfilter"></select>' +
                    ' <div>Ahorro energetico</div>'+
                    '<div class="filter_ahorro"></div>' +
                    '<div style="display: flex;">' +
                    '<div style="margin-right: 10px;">' +
                    '<input type="range" class="filter_m2MIN" min="0" max="10000" step="10" value="0" style="width: 150px;">' +
                    '<span class="m2MIN-value">0</span> m2 MIN' +
                    '</div>' +
                    '<div>' +
                    '<input type="range" class="filter_m2" min="0" max="10000" step="10" value="0" style="width: 150px;">' +
                    '<span class="m2-value">0</span> m2 MAX' +
                    '</div>' +
                    '<div>' +
                    '<input type="range" class="filter_pricemin" min="0" max="1000000" step="1000" value="0" style="width: 150px;">' +
                    '<span class="pricemin-value">0</span> price min' +
                    '</div>' +
                    '<div>' +
                    '<input type="range" class="filter_pricemax" min="0" max="1000000" step="1000" value="0" style="width: 150px;">' +
                    '<span class="pricemax-value">0</span> price max' +
                    '</div>' +
                    '<select class="orderby" id="selectfilter">'+
                    '<option value="0">ordenar</option>' +
                    '<option value="1">mas caro</option>' +
                    '<option value="2">mas barato</option>' +
                    '<option value="3">mas m2</option>' +
                    '<option value="4">menos m2</option>' +
                    '<option value="5">visitas</option>' +

                    
                    '</select>' +
                    
                    '<div id="overlay">' +
                    '<div class= "cv-spinner" >' +
                     '<span class="spinner"></span>' +
                    '</div >' +
                    '</div > ' +
                    '</div>' +
                    '</div>' +
                    '<p> </p>' +
                    
                    '<button class="filter_button button_spinner btn" id="Button_filter" style="display: inline-block; margin-right: 10px;">Filter</button>' +
                    '<button class="filter_remove btn" id="Remove_filter"style="display: inline-block;">Remove</button>'
                );


                    $('.filter_m2').on('input', function() {
                    
                        $('.m2-value').text($(this).val());
                    });
                    
                    $('.filter_m2MIN').on('input', function() {
                    
                        $('.m2MIN-value').text($(this).val());
                    });

                    $('.filter_pricemin').on('input', function() {
                    
                        $('.pricemin-value').text($(this).val());
                    });
                    
                    $('.filter_pricemax').on('input', function() {
                    
                        $('.pricemax-value').text($(this).val());
                    });



                   
            
        }
        
    //-----------------------FETCH--------------------------------------------------------------------------------------------------

    function fetchCategories() {
        ajaxPromise("?module=home&op=category", 'GET', 'JSON')
            .then(function(response) {
                $('.filter_category').append($('<option>', {
                    value: '0',
                    text: 'Select category'
                }));
                response.forEach(function(category) {
                    $('.filter_category').append($('<option>', {
                        value: category.idcat,
                        text: category.namecat
                    }));
                });
            })
            .catch(function(error) {
                console.error('Error fetching categories:', error);
            });
        }

    function fetchTypes() {
    
    //filterValue =localStorage.getItem('filter_type');
    // console.log("filtervalue:" +filterValue);
    ajaxPromise("?module=home&op=type", 'GET', 'JSON')
            .then(function(response) {
                $('.filter_type').append($('<option>', {
                    value: '0',
                    text: 'Select type'
                }));
                response.forEach(function(type) {
                    $('.filter_type').append($('<option>', {
                        value: type.idtipo,
                        text: type.nametipo
                    }));
                
                });

                
                // if (filterValue !== null) {
                //     $('.filter_type').val(filterValue);

                // }
            
            })
            .catch(function(error) {
                console.error('Error fetching types:', error);
            });
        }

    function fetchAhorro() {
    
        ajaxPromise("?module=home&op=carrusel", 'GET', 'JSON')
            .then(function(response) {
                $('.filter_ahorro').append('<input type="radio" name="filter_ahorro" value="0" id="ahorro_0" ><label for="ahorro_0"style= "margin-right: 10px;">No</label>');
                response.forEach(function(type) {
                    $('<input>').attr({
                        type: 'radio',
                        id: 'ahorro_' + type.idahorro,
                        name: 'filter_ahorro',
                        value: type.idahorro
                        
                    }).appendTo('.filter_ahorro');

                    $('<label>').attr('for', 'ahorro_' + type.idahorro ).text(type.nameahorro).appendTo('.filter_ahorro');
                    $('<label>').attr('style', 'margin-right: 10px;').appendTo('.filter_ahorro');
                
                });
            })
            .catch(function(error) {
                console.error('Error fetching ahorro options:', error);
            });
        }

    function fetchOperations() {
        ajaxPromise("?module=home&op=operation", 'GET', 'JSON')
            .then(function(response) {
                $('.filter_operation').append($('<option>', {
                    value: '',
                    text: 'Select operation'
                }));
                response.forEach(function(operation) {
                    $('.filter_operation').append($('<option>', {
                        value: operation.idop,
                        text: operation.nameop
                    }));
                });
            })
            .catch(function(error) {
                console.error('Error fetching operations:', error);
            });
        }

    function fetchCities() {
        ajaxPromise("?module=home&op=city", 'GET', 'JSON')
            .then(function(response) {
                $('.filter_city').append($('<option>', {
                    value: '',
                    text: 'Select city'
                }));
                response.forEach(function(city) {
                    $('.filter_city').append($('<option>', {
                        value: city.idcity,
                        text: city.namecity
                    }));
                });
            })
            .catch(function(error) {
                console.error('Error fetching cities:', error);
            });
        }

    //----------------------------------------------------------------------------------------------------------------------------------

    function filter_button() {
        //Filtro tipo
        $('.filter_type').change(function () {
            if(this.value ==0){
                localStorage.removeItem('filter_type');
            }else{
                localStorage.setItem('filter_type', this.value);
            }
        });
            if (localStorage.getItem('filter_type')) {
                $('.filter_type').val(localStorage.getItem('filter_type'));
                
            }


            $('.orderby').change(function () {
                if(this.value ==0){
                    localStorage.removeItem('order');
                }else{
                    localStorage.setItem('order', this.value);
                }
            });
                if (localStorage.getItem('order')) {
                    $('.orderby').val(localStorage.getItem('order'));
                    
                }
            //ahorro radio 
        $(document).on('change', '.filter_ahorro input[type="radio"]', function() {
            var selectedValue = $(this).val();
            if (selectedValue === '0') {
                localStorage.removeItem('filter_ahorro');
            } else {
                localStorage.setItem('filter_ahorro', selectedValue);
            }
        });
            

            //Filtro categoria
        $('.filter_category').change(function () {
            if(this.value ==0){
                localStorage.removeItem('filter_category');
            }else{
                localStorage.setItem('filter_category', this.value);
            }
        });
            if (localStorage.getItem('filter_category')) {
                $('.filter_category').val(localStorage.getItem('filter_category'));
            }

        //filtro ciudad
        $('.filter_city').change(function () {
            if(this.value ==0){
                localStorage.removeItem('filter_city');
            }else{
                localStorage.setItem('filter_city', this.value);
            }
        });
            if (localStorage.getItem('filter_city')) {
                $('.filter_city').val(localStorage.getItem('filter_city'));
            }
        //filtro operacion
        $('.filter_operation').change(function () {
            if(this.value ==0){
                localStorage.removeItem('filter_operation');
            }else{
                localStorage.setItem('filter_operation', this.value);
            }
        });
            if (localStorage.getItem('filter_operation')) {
                $('.filter_operation').val(localStorage.getItem('filter_operation'));
            }

        //filtro metros cuadrados
        $('.filter_m2').change(function () {
            localStorage.setItem('filter_m2', this.value);
        });
            if (localStorage.getItem('filter_m2')) {
                $('.filter_m2').val(localStorage.getItem('filter_m2'));
            }
        
         $('.filter_m2MIN').change(function () {
            localStorage.setItem('filter_m2MIN', this.value);
            });
                if (localStorage.getItem('filter_m2MIN')) {
                    $('.filter_m2MIN').val(localStorage.getItem('filter_m2MIN'));
                }

        //filtro precios
        $('.filter_pricemin').change(function () {
            localStorage.setItem('filter_pricemin', this.value);
        });
            if (localStorage.getItem('filter_pricemin')) {
                $('.filter_pricemin').val(localStorage.getItem('filter_pricemin'));
            }
        
         $('.filter_pricemax').change(function () {
            localStorage.setItem('filter_pricemax', this.value);
            });
                if (localStorage.getItem('filter_pricemax')) {
                    $('.filter_pricemax').val(localStorage.getItem('filter_pricemax'));
                }






        $(document).on('click', '.filter_button', function () {
            var filter = [];
            var filterb = [];

            if (localStorage.getItem('filter_type')) {
                    filter.push(['tipo', localStorage.getItem('filter_type')])
                    filterb.push(['tipo', localStorage.getItem('filter_type')])
                }
                if (localStorage.getItem('filter_category')) {
                    filter.push(['categoria', localStorage.getItem('filter_category')])
                    filterb.push(['categoria', localStorage.getItem('filter_category')])
                }
                if (localStorage.getItem('filter_operation')) {
                    filter.push(['operation', localStorage.getItem('filter_operation')])
                    filterb.push(['operation', localStorage.getItem('filter_operation')])
                }
                if (localStorage.getItem('filter_city')) {
                    filter.push(['city', localStorage.getItem('filter_city')])
                    filterb.push(['city', localStorage.getItem('filter_city')])
                }
                if (localStorage.getItem('filter_ahorro')) {
                    filter.push(['ahorro', localStorage.getItem('filter_ahorro')])
                    filterb.push(['ahorro', localStorage.getItem('filter_ahorro')])
                }
                if (localStorage.getItem('filter_m2')) {
                    filter.push(['superficie', localStorage.getItem('filter_m2')])
                }
                if (localStorage.getItem('filter_m2MIN')) {
                    filter.push(['superficieMIN', localStorage.getItem('filter_m2MIN')])
                }
                if (localStorage.getItem('filter_pricemin')) {
                    filter.push(['pricemin', localStorage.getItem('filter_pricemin')])
                }
                if (localStorage.getItem('filter_pricemax')) {
                    filter.push(['pricemax', localStorage.getItem('filter_pricemax')])
                }
                if (localStorage.getItem('order')) {
                    filter.push(['order', localStorage.getItem('order')])
                }
                localStorage.setItem('currentPage', '1');
                localStorage.setItem('filtrosshop', JSON.stringify(filter));
                localStorage.setItem('busqueda', JSON.stringify(filterb));
            
                
                location.reload();

                
            });
        }

    function remove_filters() {
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
        location.reload();
        }
    
    function highlightFilters() {
        var filtrosshop = JSON.parse(localStorage.getItem('filtrosshop'));
        var filtroshome = JSON.parse(localStorage.getItem('filtershome'));
        var filtrosearch = JSON.parse(localStorage.getItem('search'));
              
           
                
                console.log("filtrospatata",filtroshome);

    if (filtrosshop && filtrosshop.length > 0) {
        filtrosshop.forEach(function(filter) {
            var filterType = filter[0];
            var filterValue = filter[1];
            switch (filterType) {

                case 'tipo':
                    setTimeout(function() {
                        $('.filter_type').val(filterValue);
                    }, 100);

                        console.log('Set tipo value:', $('.filter_type').val());
                            break;
                            
                        case 'categoria':
                            setTimeout(function() {
                                $('.filter_category').val(filterValue);
                            }, 100);
                                console.log("categoria  existe"+localStorage.getItem('filter_category'));
                            break;

                        case 'operation':
                            setTimeout(function() {
                                $('.filter_operation').val(filterValue);
                            }, 100);
                                console.log("operation existe"+localStorage.getItem('filter_operation'));
                            break;

                        case 'city':
                            setTimeout(function() {
                                $('.filter_city').val(filterValue);
                            }, 100);
                                console.log("city existe"+localStorage.getItem('filter_city'));
                            break;                            
                                
                        case 'ahorro':
                            setTimeout(function() {
                            // $('.filter_ahorro').val(filterValue);
                                $('#ahorro_' + filterValue).prop('checked', true);
                            }, 100);
                                console.log("ahorro existe"+localStorage.getItem('filter_ahorro'));
                            break;


                            
                        case 'superficie':
                            $('.filter_m2').val(filterValue);
                            $('.m2-value').text(filterValue);

                            break;
                        case 'superficieMIN':
                            $('.filter_m2MIN').val(filterValue);
                            $('.m2MIN-value').text(filterValue);
        
                                break;

                         case 'pricemin':
                                $('.filter_pricemin').val(filterValue);
                                $('.pricemin-value').text(filterValue);
        
                                break;
                        case 'pricemax':
                            $('.filter_pricemax').val(filterValue);
                            $('.pricemax-value').text(filterValue);                
                            break;

                        case 'order':
                            setTimeout(function() {
                                $('.orderby').val(filterValue);
                            }, 100);
                                console.log("order existe   "+localStorage.getItem('order'));

                            break;

                        

                        default:
                            break;

                        }
                    });
             }

            if (filtrosearch !== undefined &&filtrosearch!==null && filtrosearch.length > 0) {

                localStorage.removeItem('order');

                 var  filtroshop =[];
                    filtrosearch.forEach(function(filter) {
                        var filterType = filter[0];
                        var filterValue = filter[1];
                       
                        // for (var filterType in filter) {
                           
                        //     var filterValues = filter[filterType];
                
                            
                        //     console.log(" search Tipo de filtro:", filterType);
                        //     console.log(" search Valores de filtro:", filterValue);
                 
                       switch (filterType) {
                      
                        case 'tipo':
                            console.log("entre a tipo ");
                            setTimeout(function() {
                                var filter = [];
                                $('.filter_type').val(filterValue);
                                localStorage.setItem('filter_type', filterValue);
                                filtroshop.push(['tipo', localStorage.getItem('filter_type')])
                                localStorage.setItem('filtrosshop', JSON.stringify(filtroshop));
                            }, 100);

                            console.log("filter_type existe  search  "+localStorage.getItem('filter_type'));

    
                            
                            break;

                        case 'city':
                                setTimeout(function() {
                                    var filter = [];
                                    $('.filter_city').val(filterValue);
                                    localStorage.setItem('filter_city', filterValue);
                                    filtroshop.push(['city', localStorage.getItem('filter_city')])
                                    localStorage.setItem('filtrosshop', JSON.stringify(filtroshop));
                                }, 100);
                                   
                            break;    

                        case 'ahorro':
                            setTimeout(function() {
                                var filter = [];
                            // $('.filter_ahorro').val(filterValue);
                                $('#ahorro_' + filterValue).prop('checked', true);
                                localStorage.setItem('filter_ahorro', filterValue);
                                filter.push(['ahorro', localStorage.getItem('filter_ahorro')])      
                                  localStorage.setItem('filtrosshop', JSON.stringify(filter));
                                }, 100);
                                  
                                break;
                        default:

                            break;
                        }
            
                       // localStorage.setItem('filtrosshop', JSON.stringify(filter));
                    });
                
            

                    
                    
                localStorage.removeItem('search');
             }
            



            if (filtroshome !== undefined &&filtroshome!==null && filtroshome.length > 0) {
                localStorage.removeItem('order');
                    filtroshome.forEach(function(filter) {
                        
                        // for (var filterType in filter) {
                        //     var filterValues = filter[filterType];
                
                            
                        //     console.log("Tipo de filtro: home", filterType);
                        //     console.log("Valores de filtro: home", filterValues);


                        var filterType = filter[0];
                        var filterValues = filter[1];
                
                switch (filterType) {
                    
                    case 'tipo':
                        setTimeout(function() {
                            var filter = [];
                            $('.filter_type').val(filterValues);
                            localStorage.setItem('filter_type', filterValues);
                            filter.push(['tipo', localStorage.getItem('filter_type')])
                            localStorage.setItem('filtrosshop', JSON.stringify(filter));
                        }, 100);

                        
                        break;
                        
                    case 'categoria':
                        setTimeout(function() {
                            var filter = [];
                            $('.filter_category').val(filterValues);
                            localStorage.setItem('filter_category', filterValues);
                            filter.push(['categoria', localStorage.getItem('filter_category')])
                            localStorage.setItem('filtrosshop', JSON.stringify(filter));
                        }, 100);
                       
                        break;

                    case 'operation':
                        setTimeout(function() {
                            var filter = [];
                            $('.filter_operation').val(filterValues);
                            localStorage.setItem('filter_operation', filterValues);
                            filter.push(['operation', localStorage.getItem('filter_operation')])
                            localStorage.setItem('filtrosshop', JSON.stringify(filter));
                        }, 100);
                          
                        break;

                    case 'city':
                        setTimeout(function() {
                            var filter = [];
                            $('.filter_city').val(filterValues);
                            localStorage.setItem('filter_city', filterValues);
                            filter.push(['city', localStorage.getItem('filter_city')])
                            localStorage.setItem('filtrosshop', JSON.stringify(filter));
                        }, 100);
                           
                        break;                            
                            
                    case 'ahorro':
                        setTimeout(function() {
                            var filter = [];
                        // $('.filter_ahorro').val(filterValue);
                            $('#ahorro_' + filterValues).prop('checked', true);
                            localStorage.setItem('filter_ahorro', filterValues);
                            filter.push(['ahorro', localStorage.getItem('filter_ahorro')])
                            localStorage.setItem('filtrosshop', JSON.stringify(filter));
                        }, 100);
                          
                        break;


                        
                    case 'superficie':
                        $('.filter_m2').val(filterValue);
                        $('.m2-value').text(filterValue);

                        break;
                    case 'superficieMIN':
                        $('.filter_m2MIN').val(filterValue);
                        $('.m2MIN-value').text(filterValue);

                        break;

                    
                    case 'pricemin':
                        $('.filter_pricemin').val(filterValue);
                        $('.pricemin-value').text(filterValue);
        
                        break;
                    case 'pricemax':
                        $('.filter_pricemax').val(filterValue);
                        $('.pricemax-value').text(filterValue);
                
                       break;
                    case 'visitas':
                        console.log("esto aqui");
                        setTimeout(function() {
                            loadDetails(filterValues);
                        }, 100);

                    break;

                    

                    default:
                        break;

                    }

                



                }
                
                
            );
            localStorage.removeItem('filtershome');
        }
    }


    function mapBox_all(data) {
        


       
        // TO MAKE THE MAP APPEAR YOU MUST
        // ADD YOUR ACCESS TOKEN FROM
        // https://account.mapbox.com
        mapboxgl.accessToken = 'pk.eyJ1IjoiMjBqdWFuMTUiLCJhIjoiY2t6eWhubW90MDBnYTNlbzdhdTRtb3BkbyJ9.uR4BNyaxVosPVFt8ePxW1g';
    
        const map = new mapboxgl.Map({
            container: 'map', // container ID
            style: 'mapbox://styles/mapbox/streets-v12', // style URL
           // center:  [-0.577111, 38.870000 ], // starting position [lng, lat]
            center:  [-0.457111, 38.800000 ],
           
            zoom: 10, // starting zoom
        });
      
        for (row in data) {
          
             var ImageUrls = data[row].imgimages.split(':');

            const marker = new mapboxgl.Marker()
            const minPopup = new mapboxgl.Popup()
            minPopup.setHTML('<h3 style="text-align:center;">' + data[row].nameviv + '</h3><p style="text-align:center;">tipo: <b>' + data[row].nametipo+ '</b></p>' +
                '<p style="text-align:center;">Precio: <b>' + data[row].price + '€</b></p>' +
                '<img src=" ' + ImageUrls[0] + '"/>' +
                '<a class="button button-primary-outline button-ujarak button-size-1 wow fadeInLeftSmall link golist"  data-wow-delay=".4s" id="' + data[row].idvivienda + '">Read More</a>')
            marker.setPopup(minPopup)
                .setLngLat([data[row].longi, data[row].lat])
                .addTo(map);
        }
    }

    function mapBox(id) {
        mapboxgl.accessToken = 'pk.eyJ1IjoiMjBqdWFuMTUiLCJhIjoiY2t6eWhubW90MDBnYTNlbzdhdTRtb3BkbyJ9.uR4BNyaxVosPVFt8ePxW1g';
        console.log("entre en mapbox id")
        const map = new mapboxgl.Map({
            container: 'mapd',
            style: 'mapbox://styles/mapbox/streets-v12',
            center: [id.longi, id.lat], // starting position [lng, lat]
            zoom: 10 // starting zoom
        });
        var ImageUrls = id.imgimages.split(':');
        const markerOntinyent = new mapboxgl.Marker()
        const minPopup = new mapboxgl.Popup()
        minPopup.setHTML('<h3 style="text-align:center;">' + id.nameviv + '</h3><p style="text-align:center;">tipo: <b>' + id.nametipo+ '</b></p>' +
        '<p style="text-align:center;">Precio: <b>' + id.price + '€</b></p>' +
        '<img src=" ' + ImageUrls[0] + '"/>' )
        markerOntinyent.setPopup(minPopup)
            .setLngLat([id.longi, id.lat])
            .addTo(map);
    }

    function setupMapScrolling() {
   
        var containerShop = document.querySelector('.container_shop');
        var mapContainer = document.getElementById('map-container');

        if (containerShop === null || mapContainer === null) {
            console.log("hola patata");
            return; // Exit early if either containerShop or mapContainer is null
        }
                
                 window.addEventListener('scroll', function() {
             
              //  var containerShop = document.querySelector('.container_shop');
                var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                var containerShopTop = containerShop.getBoundingClientRect().top + scrollTop;
                var containerShopBottom = containerShopTop + containerShop.offsetHeight;
                var mapTop = 210; // Adjust this value to start scrolling a bit sooner
                var minDistanceFromBottom = 65;

                if (scrollTop >= containerShopTop && scrollTop <= containerShopBottom - window.innerHeight - minDistanceFromBottom) {
                    mapContainer.style.top = scrollTop - containerShopTop + mapTop + 'px';
                } else if (scrollTop > containerShopBottom - window.innerHeight - minDistanceFromBottom) {
                    mapContainer.style.top = containerShop.offsetHeight - window.innerHeight + mapTop - minDistanceFromBottom + 'px';
                } else {
                    mapContainer.style.top = mapTop + 'px';
                }
            });
        
    
    }

    function pagination(filter) {
        console.log("paginationfilter", filter);

        var filter = filter;

        if (filter) {
            var url = "?module=shop&op=count_shop";
        } else {
        // var url = "module/shop/ctrl/ctrl_shop.php?op=count";
            var url ="?module=shop&op=count";
        }
        console.log(url);

        ajaxPromise(friendlyURL(url), 'POST', 'JSON', { 'filtrosshop': filter })
            .then(function(data) {
                console.log("hei",data);


                console.log("data0",data[0].contador);
                var total_prod = data[0].contador;
                if (total_prod >= 3) {
                    total_pages = Math.ceil(total_prod / 3);
                } else {
                    total_pages = 1;
                }   

                //  $('#pagination-top').empty();
                if(localStorage.getItem('currentPage')===1){
                    $('#pagination-bottom').empty();
                }

                console.log("Número total de páginas:", total_pages);
                var start = (localStorage.getItem('currentPage') - 1) * 3;
                console.log("start",start);
                if (filter !== undefined && filter !== null) {
                    console.log("entrefiltrosshop", filter);
                // ajaxForSearch2('module/shop/ctrl/ctrl_shop.php?op=filtershop', 'POST', filter, start, 3);
                    ajaxForSearch2(friendlyURL("?module=shop&op=filtershop"),'POST',filter,start,3);
                } else {
                    // ajaxForSearch('module/shop/ctrl/ctrl_shop.php?op=all_vivienda', 'POST', start, 3);
                    ajaxForSearch(friendlyURL("?module=shop&op=list"),'POST',start,3);
                }
                    
                var currentPage = localStorage.getItem('currentPage')||1;
                for (var i = 1; i <= total_pages; i++) {
                    var button = $('<button class="pagination-btn">' + i + '</button>');
                //   var currentPage = localStorage.getItem('currentPage');                    
                    if (i === parseInt(currentPage)) {
                        console.log("currentpage",i,currentPage);
                        button.addClass('current-page');
                    }
                    //  $('#pagination-top').append(button.clone());
                    $('#pagination-bottom').append(button.clone());
                }

                    $('.pagination-btn').click(function() {
                        $('.pagination-btn').removeClass('current-page');
                        var page = $(this).text();
                        start = (page - 1) * 3;
                        
                        localStorage.setItem('currentPage', page);
                    $(this).addClass('current-page');
                    
                        
                        if (filter !== undefined && filter !== null) {
                            ajaxForSearch2(friendlyURL("?module=shop&op=filtershop"), 'POST', filter, start, 3);
                        } else {
                            console.log("hola!!!");
                            ajaxForSearch(friendlyURL("?module=shop&op=list"), 'POST',start,3);
                        }

                        $("html, body").animate({ scrollTop: 0 }, "slow");
                    });

                })
                .catch(function(error) {
                    console.error("Error:", error);
                });

            //  highlightFilters();
        }
    function button_cart(){

        $(document).on("click", ".cart_button", function() {
            var idvivienda = $(this).data('idvivienda');
                console.log('ID Vivienda:', idvivienda);
            
                if(localStorage.getItem("accesstoken")){
                    accesstoken =  localStorage.getItem("accesstoken");
                    ajaxPromise(friendlyURL("?module=cart&op=addtocart"),'POST','JSON', { 'idvivienda': idvivienda,'accesstoken':accesstoken })
                    //ajaxPromise('module/shop/ctrl/ctrl_shop.php?op=details_vivienda&id=' + idvivienda, 'GET', 'JSON')
                        .then(function(data) {
                            if(data==="added"){
                                toastr.success("updated");
                            }
                            else if(data==="created"){

                                toastr.success("created");
                            }else if(data==="no stock"){

                                toastr.error("no stock");
                            }

                        })
                        .catch(function(error) {
                            console.error('Error fetching data:', error);
                           
                        });

                        count_cart(accesstoken);
                }else{
                setTimeout(function(){ 
                    window.location.href =friendlyURL("?module=login");
                  }, 1000);
                } 
        });

    }
 

    $(document).ready(function() {
        loadvivienda();
         clicks();   
         print_filters();
         filter_button();
       highlightFilters();
        likebutton();
        button_cart();
       //count_cart();
        setupMapScrolling();

       // pagination();
        
        $('#Remove_filter').on('click', function() {
            remove_filters();
        });
    });



