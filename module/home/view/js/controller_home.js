
//____________________________________________________________________________________________________________________

function carrusel() {
    ajaxPromise(friendlyURL("?module=home"), 'POST', 'JSON',{ 'op': 'carrusel'})
        .then(function (data) {
           // console.log(data);
            var carouselList = $('.carousel__list');
            for (var row in data) {
                var itemContainer = $('<div class="carousel__element"></div>');
                var image = $("<img class='carousel__img' id='" + data[row].nameahorro + "' src='" + data[row].imgahorro + "' alt=''>");
                var button = $("<button class='btn div_ahorro' id = '" + data[row].idahorro + "'  data-idtipo='" + data[row].idahorro + "' >"+ data[row].nameahorro +"</button>");

                itemContainer.append(image).append(button);
                carouselList.append(itemContainer);
            }

           // Initialize Glider
var glider = new Glider(carouselList.get(0), {
    slidesToShow: 3,
    slidesToScroll: 1,
    draggable: true,
    dots: '.dots',
    scrollLock: false,
    arrows: {
        prev: '.glider-prev',
        next: '.glider-next'
    },
    scrollPropagate: true, // Allow scroll events to propagate
    onEndAnimated: function () {
        // Check if it's the last slide, and if so, manually scroll back to the first one
        if (glider.getCurrentSlide() === glider.slides.length - 3) {
            setTimeout(function () {
                glider.scrollTo(0);
            },100);
        }
    }
});

            // Set an interval for auto-scrolling (e.g., every 3 seconds)
            var autoScrollInterval = setInterval(function () {
                glider.scrollItem(glider.getCurrentSlide() + 1);
            }, 3000);

            // Stop auto-scrolling when the user interacts with Glider
            glider.event(glider.ele, 'add', {
                'glider-scroll': function () {
                    // Clear the auto-scrolling interval
                    clearInterval(autoScrollInterval);
                },
            });
        })
        .catch(function (error) {
            console.log('exceptionajaxC', error);
        });
}


function Category() {
   // console.log('loadcategories');
    ajaxPromise(friendlyURL("?module=home"), 'POST', 'JSON',{ 'op': 'category'})
   
    .then(function(data) {
       
        for (row in data) {
         
            var newCategory = $('<div></div>').addClass('col-md-3 col-sm-6 div_cat')
            .attr('data-idcat', data[row].idcat)
            .attr('id', data[row].idcat)
        .append(
            "<li class='portfolio-item'>" + 
            "<div class='item-main'>" +
            "<div class='portfolio-image'>" +
            "<img src='" + data[row].imgcat + "' alt='foto' />" +
            "<div class='overlay'>"+
            " <a class='preview btn btn-primary'  title="+data[row].namecat+">VIEW</a>"+
         "</div>"+
            "</div>" +
            "<h5>" + data[row].namecat + "</h5>" +
            "</div>" +
            "</li>"
        );

    $('#containerCategories').append(newCategory);

        }
    
    }).catch(function(error) {
       
       //window.location.href = "index.php?module=ctrl_exceptions&op=503&type=503&lugar=Type_Categories HOME";
       console.log('loadcategories catch', error);
       console.log('Response data:', error.responseText);
    });
}
function loadCities() {
    // console.log('loadcategories');
     ajaxPromise(friendlyURL("?module=home"), 'POST', 'JSON',{ 'op': 'city'}) 
     .then(function(data) {
        
         for (row in data) {
          
             var newCity = $('<div></div>').addClass('col-md-3 col-sm-6 div_city')
             .attr('data-idcity', data[row].idcity)
             .attr('id', data[row].idcity)
         .append(
             "<li class='portfolio-item'>" + 
             "<div class='item-main'>" +
             "<div class='portfolio-image'>" +
             "<img src='" + data[row].imgcity + "' alt='foto' />" +
             "<div class='overlay'>"+
             " <a class='preview btn btn-primary' title="+data[row].namecity+" >VIEW</a>"+
          "</div>"+
             "</div>" +
             "<h5>" + data[row].namecity + "</h5>" +
             "</div>" +
             "</li>"
         );
 
     $('#containerCity').append(newCity);
 
         }
     
     }).catch(function(error) {
        
         
        console.log('loadcategories catch', error);
        console.log('Response data:', error.responseText);
     });
 }


 function loadvisitas() {
     ajaxPromise(friendlyURL("?module=home"), 'POST', 'JSON',{ 'op': 'visits'})
    
     .then(function(data) {
        
         for (row in data) {
            var firstImageUrl = data[row].imgimages.split(':')[0];
             var newvisitas = $('<div></div>').addClass('col-md-3 col-sm-6 div_visitas')
             .attr('data-idvivienda', data[row].idvivienda)
             .attr('id', data[row].idvivienda)
         .append(
             "<li class='portfolio-item'>" + 
             "<div class='item-main'>" +
             "<div class='portfolio-image'>" +
             "<img src='" + firstImageUrl+ "' alt='foto' />" +
             "<div class='overlay'>"+
             " <a class='preview btn btn-primary'  title="+data[row].nameviv+">VIEW</a>"+
          "</div>"+
             "</div>" +
             "<h5>" + data[row].nameviv + "</h5>" +
             "</div>" +
             "</li>"
         );
 
     $('#containervisitas').append(newvisitas);
 
         }
     
     }).catch(function(error) {
        
         // window.location.href = "index.php?module=ctrl_exceptions&op=503&type=503&lugar=Type_Categories HOME";
        console.log('loadvisitas', error);
        console.log('Response data:', error.responseText);
     });
 }

 

function loadoperations() {
    // console.log('loadcategories');
     ajaxPromise(friendlyURL("?module=home"), 'POST', 'JSON',{ 'op': 'operation'})
    
     .then(function(data) {
        
         for (row in data) {
          
             var newoperation = $('<div></div>').addClass('col-md-2 col-sm-4 div_op')
             .attr('data-idop', data[row].idop)
             .attr('id', data[row].idop)
         .append(
             "<li class='portfolio-item'>" + 
             "<div class='item-main'>" +
             "<div class='portfolio-image'>" +
             "<img src='" + data[row].imgop + "' alt='foto' />" +
             "<div class='overlay'>"+
             " <a class='preview btn btn-primary' title="+data[row].nameop+" >VIEW</a>"+
          "</div>"+
             "</div>" +
             "<h5>" + data[row].nameop + "</h5>" +
             "</div>" +
             "</li>"
         );
 
     $('#containeroperation').append(newoperation);
 
         }
     
     }).catch(function(error) {
        
       //  window.location.href = "index.php?module=ctrl_exceptions&op=503&type=503&lugar=Type_Categories HOME";
        console.log('loadcategories catch', error);
        console.log('Response data:', error.responseText);
     });
 }
 function loadrecommend() {
    // console.log('loadcategories');
     ajaxPromise(friendlyURL("?module=home"), 'POST', 'JSON',{ 'op': 'recommend'})
    
     .then(function(data) {
        console.log(data);
         for (row in data) {
          
             var newrecommend = $('<div></div>').addClass('col-md-3 col-sm-6 div_rec div_rec')
             .attr('idtab', data[row].tabla)
             .attr('id', data[row].id)
         .append(
             "<li class='portfolio-item'>" + 
             "<div class='item-main'>" +
             "<div class='portfolio-image'>" +
             "<img src='" + data[row].img + "' alt='foto' />" +
             "<div class='overlay'>"+
             " <a class='preview btn btn-primary' title="+data[row].name+">VIEW</a>"+
          "</div>"+
             "</div>" +
             "<h5>" + data[row].name + "</h5>" +
             "</div>" +
             "</li>"
         );
 
     $('#containerrecommend').append(newrecommend);
 
         }
     
     }).catch(function(error) {
        
       //  window.location.href = "index.php?module=ctrl_exceptions&op=503&type=503&lugar=Type_Categories HOME";
        console.log('loadcategories catch', error);
        console.log('Response data:', error.responseText);
     });
 }

//  function loadultimabusqueda() {
//     // console.log('loadcategories');
//     let busqueda = JSON.parse(localStorage.getItem('busqueda'))||undefined;
//     if(busqueda!=undefined){
//      ajaxPromise('module/Home/controller/controller_vivienda.php?op=homePagebusqueda','POST', 'JSON',{ 'busqueda': busqueda })
    
//      .then(function(data) {
//         console.log(data);
//          for (row in data) {
          
//              var newrecommend = $('<div></div>').addClass('col-md-3 col-sm-6 div_rec div_rec')
//              .attr('idtab', data[row].tabla)
//              .attr('id', data[row].id)
//          .append(
//              "<li class='portfolio-item'>" + 
//              "<div class='item-main'>" +
//              "<div class='portfolio-image'>" +
//              "<img src='" + data[row].img + "' alt='foto' />" +
//              "<div class='overlay'>"+
//              " <a class='preview btn btn-primary' title="+data[row].name+">VIEW</a>"+
//           "</div>"+
//              "</div>" +
//              "<h5>" + data[row].name + "</h5>" +
//              "</div>" +
//              "</li>"
//          );
 
//      $('#containerbusqueda').append(newrecommend);
 
//          }
//         }
//      ).catch(function(error) {
        
//          window.location.href = "index.php?module=ctrl_exceptions&op=503&type=503&lugar=Type_Categories HOME";
//         console.log('loadcategories catch', error);
//         console.log('Response data:', error.responseText);
//      });
//     }
//     localStorage.removeItem('busqueda');
//  }


// function loadCatTypes() {
//     ajaxPromise('module/Home/controller/controller_vivienda.php?op=homePageType','GET', 'JSON')
//     .then(function(data) {
//         for (row in data) {
//             var newtype = $('<div></div>').addClass('col-md-3 col-sm-6 div_type')
//             .append(
//                 "<li class='portfolio-item'>" +
//                 "<div class='item-main'>" +
//                 "<div class='portfolio-image'>" +
//                 "<img src='" + data[row].imgtipo + "' alt='foto' />" +
//                 "<div class='overlay'>"+
//                " <a class='preview btn btn-primary' title='Image Title Here''>VIEW</a>"+
//             "</div>"+
//                 "</div>" +
//                 "<h5>" + data[row].nametipo + "</h5>" +
//                 "</div>" +
//                 "</li>"
//             );
    
//         $('#containertypes').append(newtype);
    

//         }
//     }).catch(function() {
//         window.location.href = "index.php?module=ctrl_exceptions&op=503&type=503&lugar=Types_car HOME";
//     });
// }

function loadTipo() {
    ajaxPromise(friendlyURL("?module=home"), 'POST', 'JSON',{ 'op': 'type'})
    .then(function(data) {
        for (row in data) {
            var newtipo = $('<div></div>').addClass('col-md-3 col-sm-6 div_type')
            .attr('data-idtipo', data[row].idtipo)
            .attr('id', data[row].idtipo)
            .append(
                "<li class='portfolio-item'>" +
                "<div class='item-main'>" +
                "<div class='portfolio-image'>" +
                "<img src='" + data[row].imgtipo + "' alt='foto' />" +
                "<div class='overlay'>"+
               " <a class='preview btn btn-primary' title="+data[row].nametipo+">VIEW</a>"+
            "</div>"+
                "</div>" +
                "<h5>" + data[row].nametipo + "</h5>" +
                "</div>" +
                "</li>"
            );
    
        $('#containertipo').append(newtipo);
    

        }
    }).catch(function() {
       // window.location.href = "index.php?module=ctrl_exceptions&op=503&type=503&lugar=Types_car HOME";
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
    }


function clicks() {
    // $(document).on("click", '.div_cat', function() {
    //     console.log('clickity click cat');
    //   var filtershome = [];
    //  filtershome.push({"categoria":[this.getAttribute('id')]});
    //    localStorage.removeItem('filtershome')
    //   localStorage.setItem('filtershome', JSON.stringify(filtershome)); 
    //   setTimeout(function(){ 
    //       window.location.href = 'index.php?page=shop';
    //     }, 1000);   
    // });
    $(document).on("click", '.div_cat', function() {
        console.log('clickity click cat');
        remove_filters();
       
        var filtershome = [];
       
        // Push the filter name "categoria" and its value obtained from this.getAttribute('id')
        filtershome.push(["categoria", this.getAttribute('id')]);
        localStorage.removeItem('filtershome');
        localStorage.setItem('filtershome', JSON.stringify(filtershome)); 
        setTimeout(function() { 
            window.location.href = 'shop';
        }, 1000);   
    });


    
    $(document).on("click", '.div_city', function() {  
        console.log('clickity click city');
        remove_filters();
        var filtershome = [];
       filtershome.push(["city",this.getAttribute('id')]);
        localStorage.removeItem('filtershome')
        localStorage.setItem('filtershome', JSON.stringify(filtershome)); 
        setTimeout(function(){ 
            window.location.href = 'shop';
          }, 1000);   
       
    });
    $(document).on("click", '.div_op', function() {
        console.log('clickity click operation');
        remove_filters();
        var filtershome = [];
       filtershome.push(["operation",this.getAttribute('id')]);
        localStorage.removeItem('filtershome')
        localStorage.setItem('filtershome', JSON.stringify(filtershome)); 
        setTimeout(function(){ 
            window.location.href = 'shop';
          }, 1000);   
       
    });
    $(document).on("click", '.div_type', function() {
        console.log('clickity click tipo');
        remove_filters();
        var filtershome = [];
       filtershome.push(["tipo",this.getAttribute('id')]);
         localStorage.removeItem('filtershome')
        localStorage.setItem('filtershome', JSON.stringify(filtershome)); 
        setTimeout(function(){ 
            window.location.href = 'shop';
          }, 1000);   
       
    });
    $(document).on("click", '.div_rec', function() {
        console.log('clickity click rec');
        remove_filters();
        var filtershome = [];
       filtershome.push([this.getAttribute('idtab'),this.getAttribute('id')]);
         localStorage.removeItem('filtershome')
        localStorage.setItem('filtershome', JSON.stringify(filtershome)); 
        setTimeout(function(){ 
            window.location.href = 'shop';
          }, 1000);   
       
    });

    $(document).on("click", '.div_ahorro', function() {
        console.log('clickity click ahorro');
        remove_filters();
        var filtershome = [];
        filtershome.push(["ahorro",this.getAttribute('id')]);
         localStorage.removeItem('filtershome')
        localStorage.setItem('filtershome', JSON.stringify(filtershome)); 
        setTimeout(function(){ 
            window.location.href = 'shop';
          }, 1000);   
       
    });


    $(document).on("click", '.div_visitas', function() {
    //     console.log('clickity click visitas');
    //     var filtershome = [];
    //     filtershome.push(["visitas",this.getAttribute('id')]);
    //    //  localStorage.removeItem('filtershome')
    //     localStorage.setItem('filtershome', JSON.stringify(filtershome)); 
    //     setTimeout(function(){ 
    //         window.location.href = 'index.php?page=shop';
    //       }, 1000);   

    var viviendaID =  $(this).data('idvivienda'); // Get the ID of the clicked vivienda
    window.location.href = 'index.php?page=shop&viviendaID=' + viviendaID;
    // var filtershome = [viviendaID]; // Construct filters based on the clicked vivienda
    // localStorage.setItem('viviendavisitas', JSON.stringify(filtershome)); // Store the filters
    // window.location.href = 'index.php?page=shop'; // Redirect to the shop page
       
    });

    // $(document).on("click", '.div_motor', function() {
    //     var type_motor_filter = [];
    //     type_motor_filter.push({ "name_tmotor": [this.getAttribute('id')] });
    //     localStorage.removeItem('filters');
    //     localStorage.removeItem('brand_filter');
    //     localStorage.removeItem('category_filter');
    //     localStorage.setItem('type_motor_filter', JSON.stringify(type_motor_filter));

    //     setTimeout(function() {
    //         window.location.href = ' index.php?module=ctrl_shop&op=list ';
    //     }, 300);
    // });
}








$(document).ready(function() {
    //carousel_tipos();
    carrusel();
    Category();
    loadTipo();
    loadoperations();
    loadCities();
    loadrecommend();
    loadvisitas();
    // loadAhorro();
     clicks();
    //  loadultimabusqueda()
});

// Glider configuration
// new Glider(document.getElementById("slider"), {
//     // Optional parameters
//     slidesToShow: 1,
//     slidesToScroll: 1,
//     draggable: true,
//     rewind: true,
//     duration: 0.5,
//     dots: ".pagination",
//     arrows: {
//       prev: ".slider-prev",
//       next: ".slider-next"
//     },
  
//     // Responsive breakpoints
//     responsive: [
//       {
//         breakpoint: 768,
//         settings: {
//           slidesToShow: 1.5,
//           scrollLock: false,
//           rewind: true
//         }
//       }
//     ]
//   });
  
