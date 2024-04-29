function load_ahorro() {
    ajaxPromise('module/search/ctrl/ctrl_search.php?op=ahorro_vivienda', 'POST', 'JSON')
        .then(function(data) {
            $('#ahorro_vivienda').append('<option value = "0">ahorro_vivienda</option>');
            for (row in data) {
                $('#ahorro_vivienda').append('<option value = "' + data[row].idahorro + '">' + data[row].nameahorro + '</option>');
            }
        }).catch(function() {
            console.log("Fail load ahorro_vivienda");
        });
}

// function load_type(data) {
//     if (data == undefined) {
//         ajaxPromise('module/search/ctrl/ctrl_search.php?op=type_vivienda', 'POST', 'JSON')
//             .then(function(data) {
//                 $('#type_vivienda').empty();
//                 $('#type_vivienda').append('<option value = "0">types</option>');
//                 for (row in data) {
//                     $('#type_vivienda').append('<option value = "' + data[row].nametipo + '"</option>');
//                 }
//             }).catch(function(data) {
//                 console.log('Fail load type');
//             });
//     } else {
//         ajaxPromise('module/search/ctrl/ctrl_search.php?op=type_category', 'POST', 'JSON', data)
//             .then(function(data) {
//                 $('#type_vivienda').empty();
//                 $('#type_vivienda').append('<option value = "0">types</option>');
//                 for (row in data) {
//                     $('#type_vivienda').append('<option value = "' + data[row].name_type + '">' + data[row].name_type + '</option>');
//                 }
//             }).catch(function(data) {
//                 console.log('Fail load type');
//             });
//     }
// }
//__________________________________________________________________________________
function load_ahorro_type(data) {
    console.log(data);
    if (data == undefined || (data && data.ahorro === "0") ) {
        ajaxPromise('module/search/ctrl/ctrl_search.php?op=type_ahorro_vivienda', 'POST', 'JSON',data)
            .then(function(data) {
                $('#type_vivienda').empty();
                $('#type_vivienda').append('<option value = "0">tipo</option>');
                for (row in data) {
                    $('#type_vivienda').append('<option value = "' + data[row].idtipo + '">' + data[row].nametipo + '</option>');
                }
            }).catch(function(data) {
                console.log('Fail load pepito');
            });
    } else {
        ajaxPromise('module/search/ctrl/ctrl_search.php?op=type_ahorro_vivienda', 'POST', 'JSON', data)
            .then(function(data) {
                $('#type_vivienda').empty();
                $('#type_vivienda').append('<option value = "0">types</option>');
                for (row in data) {
                    $('#type_vivienda').append('<option value = "' + data[row].idtipo + '">' + data[row].nametipo + '</option>');
                }
            }).catch(function(data) {
                console.log('Fail load type');
            });
    }
}
function launch_search() {
   
    load_ahorro();
    load_ahorro_type();
    $('#ahorro_vivienda').on('change', function() {
        let ahorro = $(this).val();
        console.log(ahorro);
        if (ahorro === 0) {
            load_ahorro_type(ahorro);
        } else {
            load_ahorro_type({ahorro});
        }
    });
}

// function autocomplete() {
//     $("#autocom").on("keyup focus input", function() {
//         let sdata = { complete: $(this).val() };

//         if (($('#ahorro_vivienda').val() != 0)) {
//             sdata.ahorro = $('#ahorro_vivienda').val();
//             if (($('#ahorro_vivienda').val() != 0) && ($('#type_vivienda').val() != 0)) {
//                 sdata.type = $('#type_vivienda').val();
//             }
//         }
//         if (($('#ahorro_vivienda').val() == 0) && ($('#type_vivienda').val() != 0)) {
//             sdata.type = $('#type_vivienda').val();
//             console.log(sdata.type);
//         }
//         ajaxPromise('module/search/ctrl/ctrl_search.php?op=autocomplete', 'POST', 'JSON', sdata)
//             .then(function(data) {
//                 $('#search_vivienda').empty();
//                 $('#search_vivienda').fadeIn(10000000);
                
//            let uniqueCities = new Set();
     
//             data.forEach(function(row) {
//                 uniqueCities.add({ name: row.namecity, id: row.idcity });
//             });

//             uniqueCities.forEach(function(city) {
//                 $('<div></div>').appendTo('#search_vivienda')
//                     .html(city.name) 
//                     .attr({ 'class': 'searchElement', 'id': city.id }); 
//                 });
                 
//                 $(document).on('click', '.searchElement', function() {
//                     let cityName = $(this).html(); 
//                     let cityId = $(this).attr('id');
//                     $('#autocom').val(cityName); 
//                     $('#autocom').data('cityid', cityId); 
//                     $('#search_vivienda').fadeOut(900);
//                 });

//                 $(document).on('click scroll', function(event) {
//                     if (event.target.id !== 'autocom') {
//                         $('#search_vivienda').fadeOut(1000);
//                     }
//                 });
//             }).catch(function() {
//                 $('#search_vivienda').fadeOut(500);
//             });
//     });
// }

function autocomplete() {
    let timer;

    $("#autocom").on(" keyup focus input", function() {
        clearTimeout(timer);
        let sdata = { complete: $(this).val() };

        if ($('#ahorro_vivienda').val() != "0") {
            sdata.ahorro = $('#ahorro_vivienda').val();
            if ($('#type_vivienda').val() != "0") {
                sdata.type = $('#type_vivienda').val();
            }
        } else if ($('#type_vivienda').val() != "0") {
            sdata.type = $('#type_vivienda').val();
        }

        timer = setTimeout(function() {
            ajaxPromise('module/search/ctrl/ctrl_search.php?op=autocomplete', 'POST', 'JSON', sdata)
                .then(function(data) {
                    $('#search_vivienda').empty();
                    if (data.length > 0) {
                        let uniqueCities = new Set();
                        data.forEach(function(row) {
                            uniqueCities.add({ name: row.namecity, id: row.idcity });
                        });
                        uniqueCities.forEach(function(city) {
                            $('<div></div>').appendTo('#search_vivienda')
                                .html(city.name)
                                .attr({ 'class': 'searchElement', 'id': city.id })
                                .on('click', function() {
                                    $('#autocom').val(city.name);
                                    $('#autocom').data('cityid', city.id);
                                    $('#search_vivienda').fadeOut(900);
                                });
                        });
                        $('#search_vivienda').fadeIn(100);
                    } else {
                        $('#search_vivienda').fadeOut(1000);
                    }
                })
                .catch(function() {
                    $('#search_vivienda').fadeOut(500);
                });
        }, 500);
    });

    $(document).on('click scroll', function(event) {
        if (!$(event.target).closest('#search_vivienda').length) {
            $('#search_vivienda').fadeOut(1000);
        }
    });
}



function btn_search() {
    $('#search-btn').on('click', function() {
        var search = [];

        if ($('#autocom').val() == "") {
          //  search.push({ "city": '0' });
         
          if($('#ahorro_vivienda').val()!=0){
            search.push([ "ahorro", $('#ahorro_vivienda').val() ]);
          } 
          if($('#type_vivienda').val()!=0){
            search.push([ "tipo", $('#type_vivienda').val() ]);
          }
        } else {
            search.push([ "city", $('#autocom').data('cityid') ]);
            if($('#ahorro_vivienda').val()!=0){
            search.push([ "ahorro", $('#ahorro_vivienda').val() ]);
            }
            if($('#type_vivienda').val()!=0){
            search.push(["tipo", $('#type_vivienda').val() ]);
            }
        }

        localStorage.removeItem('filters');
        localStorage.removeItem('type_filter');
        localStorage.removeItem('category_filter');
        localStorage.removeItem('order');
        

        localStorage.setItem('search', JSON.stringify(search));

        window.location.href = 'index.php?page=shop';
    });
}

$(document).ready(function() {
    launch_search();
    autocomplete();
    btn_search();
});