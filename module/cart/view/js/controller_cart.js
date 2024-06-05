
// function show_products() {
//     var accesstoken = localStorage.getItem('accesstoken');
//     ajaxPromise(friendlyURL("?module=cart&op=list"), 'POST', 'JSON', { 'accesstoken': accesstoken })
//         .then(function(data) {
//             // Clear previous items
//             $('.cart-items').empty();

//             // Create a table element
//             var tableHTML = "<table class='cart-table'><thead><tr><th>Item Name</th><th>Quantity</th><th>Price</th><th>Total Price</th><th>Actions</th></tr></thead><tbody>";
//             var totalItems = 0;
//             var totalPrice = 0;

//             // Iterate through each item in the data
//             data.forEach(function(item) {
//                 // Calculate total price for the item (price * quantity)
//                 var totalPriceItem = parseFloat(item.price) * parseInt(item.quantity);
//                 totalItems += parseInt(item.quantity);
//                 totalPrice += totalPriceItem;

//                 // Append a row for each item
//                 tableHTML += "<tr>" +
//                                 "<td>" + item.nameviv + "</td>" +
//                                 "<td>" +
//                                     "<button class='decrease-quantity' data-id='" + item.id_vivienda + "' data-stock='" + item.stock + "'>-</button> " +
//                                     "<span class='quantity'>" + item.quantity + "</span> " +
//                                     "<button class='increase-quantity' data-id='" + item.id_vivienda + "' data-stock='" + item.stock + "'>+</button>" +
//                                 "</td>" +
//                                 "<td>" + item.price + "</td>" +
//                                 "<td>" + totalPriceItem.toFixed(2) + "</td>" +
//                                 "<td><button class='delete-item' data-id='" + item.id_vivienda + "'>Delete</button></td>" +
//                              "</tr>";
//             });

//             // Close the table body and table
//             tableHTML += "</tbody></table>";
//             $('#total-items').text(totalItems);
//             $('#total-price').text(totalPrice.toFixed(2));

//             // Append the table HTML to the .cart-items div
//             $('.cart-items').append(tableHTML);

//             // Event listeners for the buttons
//             $('.decrease-quantity').on('click', function() {
//                 var id = $(this).data('id');
//                 var stock = $(this).data('stock');
//                 var $quantityCell = $(this).siblings('.quantity');
//                 var currentQuantity = parseInt($quantityCell.text().trim());

//                 if (currentQuantity > 0) {
//                     var newQuantity = currentQuantity - 1;
//                     $quantityCell.text(newQuantity);

//                     // Implement your logic to update the quantity on the server
//                     console.log('Decrease quantity for item:', id);
//                 }
//             });

//             $('.increase-quantity').on('click', function() {
//                 var id = $(this).data('id');
//                 var stock = $(this).data('stock');
//                 var $quantityCell = $(this).siblings('.quantity');
//                 var currentQuantity = parseInt($quantityCell.text().trim());

//                 if (currentQuantity < stock) {
//                     var newQuantity = currentQuantity + 1;
//                     $quantityCell.text(newQuantity);

//                     // Implement your logic to update the quantity on the server
//                     console.log('Increase quantity for item:', id);
//                 }
//             });

//             $('.delete-item').on('click', function() {
//                 var id = $(this).data('id');
//                 $(this).closest('tr').remove();

//                 // Implement your logic to delete the item from the server
//                 console.log('Delete item:', id);
//             });
//         })
//         .catch(function(error) {
//             console.error('Error fetching data:', error);
//         });
// }

function show_products() {
    var accesstoken = localStorage.getItem('accesstoken');
    ajaxPromise(friendlyURL("?module=cart&op=list"), 'POST', 'JSON', { 'accesstoken': accesstoken })
        .then(function(data) {
            // Clear previous items
            $('.cart-items').empty();

            // Create a table element
            var tableHTML = "<table class='cart-table'><thead><tr><th>Item Name</th><th>Quantity</th><th>Price</th><th>Total Price</th><th>Actions</th></tr></thead><tbody>";
            var totalItems = 0;
            var totalPrice = 0;

            // Iterate through each item in the data
            data.forEach(function(item) {
                if (parseInt(item.isactive) === 1){
                    // Calculate total price for the item (price * quantity)
                    var totalPriceItem = parseFloat(item.price) * parseInt(item.quantity);
                    totalItems += parseInt(item.quantity);
                    totalPrice += totalPriceItem;

                    // Append a row for each item
                    tableHTML += "<tr data-id='" + item.id_vivienda + "' data-stock='" + item.stock + "'>" +
                                    "<td>" + item.nameviv + "</td>" +
                                    "<td>" +
                                        "<button class='decrease-quantity'>-</button> " +
                                        "<span class='quantity'>" + item.quantity + "</span> " +
                                        "<button class='increase-quantity'>+</button>" +
                                    "</td>" +
                                    "<td>" + item.price + "</td>" +
                                    "<td class='total-price-item'>" + totalPriceItem.toFixed(2) + "</td>" + 
                                    "<td><button class='delete-item'>Delete</button></td>" +
                                "</tr>";
                }
            });

            // Close the table body and table
            tableHTML += "</tbody></table>";
            $('#total-items').text(totalItems);
            $('#total-price').text(totalPrice.toFixed(2));

            // Append the table HTML to the .cart-items div
            $('.cart-items').append(tableHTML);

            // Attach event listeners
            attachEventListeners();
        })
        .catch(function(error) {
            console.error('Error fetching data:', error);
        });
}

// function attachEventListeners() {
//     $('.decrease-quantity').on('click', function() {
//         var $row = $(this).closest('tr');
//         var id = $row.data('id');
//         var stock = $row.data('stock');
//         var $quantityCell = $row.find('.quantity');
//         var currentQuantity = parseInt($quantityCell.text().trim());

//         if (currentQuantity > 0) {
//             var newQuantity = currentQuantity - 1;
//             $quantityCell.text(newQuantity);

//             // Call your function to update the quantity on the server
//             update_Quantity(id, newQuantity);
//             console.log('Decrease quantity for item:', id);
//         }
//     });

//     $('.increase-quantity').on('click', function() {
//         var $row = $(this).closest('tr');
//         var id = $row.data('id');
//         var stock = $row.data('stock');
//         var $quantityCell = $row.find('.quantity');
//         var currentQuantity = parseInt($quantityCell.text().trim());

//         if (currentQuantity < stock) {
//             var newQuantity = currentQuantity + 1;
//             $quantityCell.text(newQuantity);

//             // Call your function to update the quantity on the server
//             update_Quantity(id, newQuantity);
//             console.log('Increase quantity for item:', id);
//         }
//     });

//     $('.delete-item').on('click', function() {
//         var $row = $(this).closest('tr');
//         var id = $row.data('id');
//         $row.remove();

//         // Call your function to delete the item from the server
//         delete_Item(id);
//         console.log('Delete item:', id);
//     });
// }
function attachEventListeners() {
    $('.decrease-quantity').on('click', function() {
        var $row = $(this).closest('tr');
        var id = $row.data('id');
        var stock = $row.data('stock');
        var $quantityCell = $row.find('.quantity');
        var currentQuantity = parseInt($quantityCell.text().trim());

        if (currentQuantity > 0) {
            var newQuantity = currentQuantity - 1;
            $quantityCell.text(newQuantity);

            var price = parseFloat($row.find('td').eq(2).text());
            var newTotalPriceItem = price * newQuantity;
            $row.find('.total-price-item').text(newTotalPriceItem.toFixed(2));

            updateTotalItemsAndPrice();

          
            update_Quantity(id, newQuantity);
            console.log('Decrease quantity for item:', id);
        }
    });

    $('.increase-quantity').on('click', function() {
        var $row = $(this).closest('tr');
        var id = $row.data('id');
        var stock = $row.data('stock');
        var $quantityCell = $row.find('.quantity');
        var currentQuantity = parseInt($quantityCell.text().trim());

        if (currentQuantity < stock) {
            var newQuantity = currentQuantity + 1;
            $quantityCell.text(newQuantity);

            // Update total price for the item
            var price = parseFloat($row.find('td').eq(2).text());
            var newTotalPriceItem = price * newQuantity;
            $row.find('.total-price-item').text(newTotalPriceItem.toFixed(2));

            // Update total items and total price
            updateTotalItemsAndPrice();

            // Call your function to update the quantity on the server
            update_Quantity(id, newQuantity);
            console.log('Increase quantity for item:', id);
        }
    });

    $('.delete-item').on('click', function() {
        var $row = $(this).closest('tr');
        var id = $row.data('id');
        $row.remove();

        // Update total items and total price
        updateTotalItemsAndPrice();

        // Call your function to delete the item from the server
        delete_Item(id);
        console.log('Delete item:', id);
    });
}


function update_Quantity(id, quantity) {
    var accesstoken = localStorage.getItem('accesstoken');
    ajaxPromise(friendlyURL("?module=cart&op=update_quantity"), 'POST', 'JSON', { 'accesstoken': accesstoken, 'idvivienda': id, 'quantity': quantity })
        .then(function(response) {
            console.log('Quantity updated successfully:', response);
            count_cart(accesstoken);
        })
        .catch(function(error) {
            console.error('Error updating quantity:', error);
        });
}

function delete_Item(id) {
    var accesstoken = localStorage.getItem('accesstoken');
    ajaxPromise(friendlyURL("?module=cart&op=delete_item"), 'POST', 'JSON', { 'accesstoken': accesstoken, 'idvivienda': id })
        .then(function(response) {
            console.log('Item deleted successfully:', response);
            count_cart(accesstoken);
        })
        .catch(function(error) {
            console.error('Error deleting item:', error);
        });
}

function updateTotalItemsAndPrice() {
    var totalItems = 0;
    var totalPrice = 0;

    $('.cart-table tbody tr').each(function() {
        var quantity = parseInt($(this).find('.quantity').text().trim());
        var totalPriceItem = parseFloat($(this).find('.total-price-item').text().trim());

        totalItems += quantity;
        totalPrice += totalPriceItem;
    });

    $('#total-items').text(totalItems);
    $('#total-price').text(totalPrice.toFixed(2));
}

function checkout(){
    var accesstoken = localStorage.getItem('accesstoken');
    ajaxPromise(friendlyURL("?module=cart&op=checkout"), 'POST', 'JSON', { 'accesstoken': accesstoken})
        .then(function(response) { 
            show_products();
        })
        .catch(function(error) {
            console.error('Error making purchase:', error);
        });
    
}

$(document).ready(function() {
    show_products();
     $('#checkout-button').click(function() {
        checkout();
    }); 
 });