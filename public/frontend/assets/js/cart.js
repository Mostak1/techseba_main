// Add To WishList Cart
function addToWishlist(productId, element) {
    $.ajax({
        url: element.dataset.url, // Get URL from data attribute
        type: "POST",
        data: {
            product_id: productId,
            _token: document.querySelector('meta[name="csrf-token"]').content
        },
        success: function (response) {
            $(element).toggleClass('active');
            toastr.success(response.message);
            
            // Remove the product card from wishlist view
            $("#wishlist-item-" + productId).fadeOut(300, function() {
                $(this).remove();
                // Check if wishlist is empty after removal
                if ($("#wishlist-container").children().length === 0) {
                    location.reload(); // Reload to show the "not found" message
                }
            });
        },
        error: function (xhr) {
            toastr.error(xhr.responseJSON.message);
        }
    });
}