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


$(document).ready(function() {
    show_invoices();
      show_likes();
 });