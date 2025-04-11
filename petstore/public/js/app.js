// Simple script to toggle the display of a specific element
function toggleVisibility(id) {
    var element = document.getElementById(id);
    if (element.style.display === "none") {
        element.style.display = "block";
    } else {
        element.style.display = "none";
    }
}

// Example: Handle form submission alert
// document.addEventListener('DOMContentLoaded', function () {
//     const form = document.querySelector('form');
//     if (form) {
//         form.addEventListener('submit', function (e) {
//             e.preventDefault();  // Prevent the form from submitting
//             alert('Form submitted!');
//             // You can add AJAX call here if needed to submit form data without page reload
//         });
//     }
// });
document.addEventListener('DOMContentLoaded', function () {
    // addToCartForm 
    const addToCartForm = document.getElementById('addToCartForm');
    if (addToCartForm) {
        addToCartForm.addEventListener('submit', function (e) {
            e.preventDefault();
            alert('Form submitted!');

            const formData = new FormData(addToCartForm);
            fetch(addToCartForm.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Item added to cart!');
                } else {
                    alert('Error adding item to cart: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while adding the item to the cart.');
            });
        });
    }

    
});


// Example: Confirmation prompt for deleting an item (for product deletion etc.)
function confirmDelete(itemName) {
    return confirm(`Are you sure you want to delete ${itemName}?`);
}
