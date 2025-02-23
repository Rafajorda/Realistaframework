function show_invoices() {
    var accesstoken = localStorage.getItem('accesstoken');
    ajaxPromise(friendlyURL("?module=profile&op=listinvoices"), 'POST', 'JSON', { 'accesstoken': accesstoken })
        .then(function(data) {
            // Clear previous items
            $('.profile-items').empty();

            // Create a table element
            var tableHTML = "<table class='bills-table'><thead><tr><th>invoice</th><th>Quantity</th><th>Price</th><th>Actions</th></tr></thead><tbody>";
            // Iterate through each item in the data
            data.forEach(function(item) {
                
                    // Calculate total price for the item (price * quantity)
                   

                    // Append a row for each item
                    tableHTML += "<tr data-id='" + item.ID + "'>" +
                                    "<td>" + item.ID + "</td>" +
                                    "<td>" +                              
                                        "<span class='quantity'>" + item.items + "</span> " +
                                    "</td>" +
                                    "<td>" + item.price + "</td>" + 
                                    "<td><button class='print-invoice' data-id='" + item.ID + "'>Print</button></td>" +
                                "</tr>";
                
            });

            
            tableHTML += "</tbody></table>";
           


            $('.profile-items').append(tableHTML);

            $('.print-invoice').on('click', function() {
                var invoiceID = $(this).data('id');
                
                generatePDF(invoiceID);
            });

           
        })
        .catch(function(error) {
            console.error('Error fetching data:', error);
        });
}

function generatePDF(invoiceID){
console.log("invoice",invoiceID);
    ajaxPromise(friendlyURL("?module=profile&op=generatepdf"), 'POST', 'JSON', { 'invoiceID': invoiceID })
    .then(function(data) {
            console.log("hola");
    })
    .catch(function(error) {
        console.error('Error fetching data:', error);
    });

}


function show_likes() {
    var accesstoken = localStorage.getItem('accesstoken');
    ajaxPromise(friendlyURL("?module=profile&op=listlikes"), 'POST', 'JSON', { 'accesstoken': accesstoken })
        .then(function(data) {
            // Clear previous items
            $('.profile-likes').empty();

            // Create a table element
            var tableHTML = "<table class='likes-table'><thead><tr><th>Image</th><th>Name</th><th>Energy Saving</th><th>Type</th><th>Price</th><th>Superficie</th><th>City</th><th>Actions</th></tr></thead><tbody>";
            
            // Iterate through each item in the data
            data.forEach(function(item) {
                // Extract the first image URL
                var firstImageURL = item.Vivienda_Images.split(':')[0];
                
                // Append a row for each item
                tableHTML += "<tr data-id='" + item.idvivienda + "'>" +
                                "<td><img src='" + firstImageURL + "' alt='" + item.nameviv + "' style='max-width: 100px; max-height: 100px;'></td>" +
                                "<td>" + item.Vivienda_Name + "</td>" +
                                "<td>" + item.Ahorro_Name + "</td>" +
                                "<td>" + item.Tipo_Name + "</td>" +
                                "<td>" + item.Vivienda_Price + "</td>" + 
                                "<td>" + item.Vivienda_Superficie + "</td>" +
                                "<td>" + item.City_Name + "</td>" +
                                "<td><button class='go'>go</button></td>" +
                             "</tr>";
            });

            tableHTML += "</tbody></table>";

            $('.profile-likes').append(tableHTML);
        })
        .catch(function(error) {
            console.error('Error fetching data:', error);
        });
}

function validateChangeUsername() {
    var username_exp = /^(?=.{5,}$)(?=.*[a-zA-Z0-9]).*$/;
    var error = false;

    var newUsername = document.getElementById('newUsername').value;
    
    if (newUsername.length === 0) {
        document.getElementById('error_newUsername').innerHTML = "Tienes que escribir el nuevo nombre de usuario";
        error = true;
    } else {
        if (newUsername.length < 5) {
            document.getElementById('error_newUsername').innerHTML = "El nombre de usuario tiene que tener 5 caracteres como mínimo";
            error = true;
        } else {
            if (!username_exp.test(newUsername)) {
                document.getElementById('error_newUsername').innerHTML = "No se pueden poner caracteres especiales";
                error = true;
            } else {
                document.getElementById('error_newUsername').innerHTML = "";
            }
        }
    }

    return !error;
}

function validateChangePassword() {
    var pssswd_exp = /^(?=.{8,}$)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$/;
    var error = false;

    var oldPassword = document.getElementById('oldPassword').value;
    var newPassword = document.getElementById('newPassword').value;
    var confirmNewPassword = document.getElementById('confirmNewPassword').value;

    if (oldPassword.length === 0) {
        document.getElementById('error_oldPassword').innerHTML = "Tienes que escribir la contraseña actual";
        error = true;
    } else {
        document.getElementById('error_oldPassword').innerHTML = "";
    }

    if (newPassword.length === 0) {
        document.getElementById('error_newPassword').innerHTML = "Tienes que escribir la nueva contraseña";
        error = true;
    } else {
        if (newPassword.length < 8) {
            document.getElementById('error_newPassword').innerHTML = "La contraseña tiene que tener 8 caracteres como mínimo";
            error = true;
        } else {
            if (!pssswd_exp.test(newPassword)) {
                document.getElementById('error_newPassword').innerHTML = "Debe de contener mínimo 8 caracteres, mayúsculas, minúsculas y símbolos especiales";
                error = true;
            } else {
                document.getElementById('error_newPassword').innerHTML = "";
            }
        }
    }

    if (confirmNewPassword.length === 0) {
        document.getElementById('error_confirmNewPassword').innerHTML = "Tienes que repetir la nueva contraseña";
        error = true;
    } else {
        if (confirmNewPassword !== newPassword) {
            document.getElementById('error_confirmNewPassword').innerHTML = "Las contraseñas no coinciden";
            error = true;
        } else {
            document.getElementById('error_confirmNewPassword').innerHTML = "";
        }
    }

    return !error;
}


    function changeUsername() {
        if (validateChangeUsername() != 0) {
            var newUsername = document.getElementById('newUsername').value;
            var accesstoken = localStorage.getItem('accesstoken');
            ajaxPromise(friendlyURL("?module=profile&op=changeUsername"), 'POST', 'JSON', { 'newUsername': newUsername, 'accesstoken': accesstoken })
                .then(function(result) {
                    if (result === "exists") {
                        document.getElementById('error_newUsername').innerHTML = "El nombre de usuario ya existe, elija otro";
                    } else {
                        localStorage.setItem("accesstoken", result[0]);
                        localStorage.setItem("refreshtoken", result[1]);
                        toastr.success("Nombre de usuario cambiado con éxito");
                        document.getElementById('currentUsername').innerText = newUsername;
                    } 
                })
                .catch(function(textStatus) {
                    if (console && console.log) {
                        console.log("La solicitud ha fallado: " + textStatus);
                    }
                });
        }
    }

// function validateChangeUsername() {
//     var username_exp = /^(?=.{5,}$)(?=.*[a-zA-Z0-9]).*$/;
//     var error = false;

//     var newUsername = document.getElementById('newUsername').value;
    
//     if (newUsername.length === 0) {
//         document.getElementById('error_newUsername').innerHTML = "Tienes que escribir el nuevo nombre de usuario";
//         error = true;
//     } else {
//         if (newUsername.length < 5) {
//             document.getElementById('error_newUsername').innerHTML = "El nombre de usuario tiene que tener 5 caracteres como mínimo";
//             error = true;
//         } else {
//             if (!username_exp.test(newUsername)) {
//                 document.getElementById('error_newUsername').innerHTML = "No se pueden poner caracteres especiales";
//                 error = true;
//             } else {
//                 document.getElementById('error_newUsername').innerHTML = "";
//             }
//         }
//     }

//     return !error;
// }
function button_changeusername(){
    
    if (!document.getElementById('changeUsernameForm').onsubmit) {
        document.getElementById('changeUsernameForm').onsubmit = function(event) {
            event.preventDefault(); // Prevent the default form submission
            changeUsername();
        };
    }
}


function change_password() {
    if (validateChangePassword() != 0) {
        var oldPassword = document.getElementById('oldPassword').value;
        var newPassword = document.getElementById('newPassword').value;
        var accesstoken = localStorage.getItem('accesstoken');
        
        ajaxPromise(friendlyURL("?module=profile&op=changePassword"), 'POST', 'JSON', { 'oldPassword': oldPassword, 'newPassword': newPassword, 'accesstoken': accesstoken })
        .then(function(result) {
            if (result === 'password_success') {
                console.log("Password changed successfully:", result);
                // Show a success message to the user
                document.getElementById('error_oldPassword').innerText = "Password changed successfully.";
            } else if (result === 'incorrect_old_password') {
                console.log("Incorrect old password:", result);
                // Show an error message to the user
                document.getElementById('error_oldPassword').innerText = "The old password is incorrect.";
            } else if (result === 'user_not_found') {
                console.log("User not found:", result);
                // Show an error message to the user
                document.getElementById('error_oldPassword').innerText = "User not found.";
            } else {
                console.log("Unexpected error:", result);
                // Show a generic error message to the user
                document.getElementById('error_oldPassword').innerText = "An unexpected error occurred.";
            }
        })
        .catch(function(textStatus) {
            if (console && console.log) {
                console.log("La solicitud ha fallado: " + textStatus);
                // Show a generic error message to the user
                document.getElementById('error_oldPassword').innerText = "An unexpected error occurred.";
            }
        });
    }
}
function button_changePassword() {
    if (!document.getElementById('changePasswordForm').onsubmit) {
        document.getElementById('changePasswordForm').onsubmit = function(event) {
            event.preventDefault(); // Prevent the default form submission
            change_password();
        };
    }
}
// function change_avatar(){
//     var avatarFile = document.getElementById('avatarFile').files[0];
//     var accesstoken = localStorage.getItem('accesstoken');
//     ajaxPromise(friendlyURL("?module=profile&op=changeAvatar"), 'POST', 'JSON', { 'newAvatar': avatarFile,'accesstoken': accesstoken })
//         .then(function(result) {


//         })
//             .catch(function(textStatus) {
//                 if (console && console.log) {
//                     console.log("La solicitud ha fallado: " + textStatus);
//                     // Show a generic error message to the user
                    
//                 }
//             });
        

// }
function change_avatar() {
    var avatarFile = document.getElementById('avatarFile').files[0];
    var accesstoken = localStorage.getItem('accesstoken');
    var formData = new FormData();
    formData.append('newAvatar', avatarFile);
    formData.append('accesstoken', accesstoken);
    var validImageTypes = ['image/jpeg', 'image/png', 'image/gif'];
    var maxSizeInBytes = 5 * 1024 * 1024; // 5MB

    
    if (!avatarFile) {
        toastr.error('Please select a file.');
        return;
    }
     if (!validImageTypes.includes(avatarFile.type)) {
        toastr.error('Invalid file type. Please select an image file (jpeg, png, gif).');
        return;
    }
     if (avatarFile.size > maxSizeInBytes) {
        toastr.error('File size exceeds 5MB.');
        return;
     }
    
        fetch(friendlyURL("?module=profile&op=changeAvatar"), {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(result => {
            if (result === 'done') {
                
                toastr.success('Avatar changed successfully.');
            
                window.location.reload();
            } else {
                
                toastr.error('An error occurred while changing the avatar.');
            }
        })
        .catch(error => {
            toastr.error('An error occurred while changing the avatar.');
        });
    
}


function button_changeAvatar() {
    if (!document.getElementById('uploadAvatarForm').onsubmit) {
        document.getElementById('uploadAvatarForm').onsubmit = function(event) {
            event.preventDefault(); // Prevent the default form submission
            change_avatar();
        };
    }
}
function checkUserType() {
    var userType = localStorage.getItem('userType');
    var accesstoken = localStorage.getItem('accesstoken');
    if (userType === null) {
        ajaxPromise(friendlyURL("?module=profile&op=getUserType"), 'POST', 'JSON', { 'accesstoken': accesstoken })
            .then(function(result) {
                localStorage.setItem('userType', result);
                if (result === "google") {
                   
                    // document.getElementById('changeUsernameForm').style.display = 'none';
                    // document.getElementById('changePasswordForm').style.display = 'none';
                    // document.getElementById('uploadAvatarForm').style.display = 'none';
                    document.querySelector('.profile-html').style.display = 'none';
                }
            })
            .catch(function(error) {
                console.error('Error:', error);
            });
    } else {
        if (userType === "google") {
            
            // document.getElementById('changeUsernameForm').style.display = 'none';
            // document.getElementById('changePasswordForm').style.display = 'none';
            // document.getElementById('uploadAvatarForm').style.display = 'none';
            document.querySelector('.profile-html').style.display = 'none';
        }
    }
}
function updateusernamescreen(){

    var accessToken = localStorage.getItem('accessToken');

    if (username) {
       console.log(username,"username");
        document.getElementById('currentUsername').textContent = username;
    } else {
        
        document.getElementById('currentUsername').textContent = 'Default Username';
    }

}

$(document).ready(function() {
    show_invoices();
      show_likes();
      button_changeusername();
      checkUserType();
      button_changePassword();
      button_changeAvatar();
      updateusernamescreen();
 });