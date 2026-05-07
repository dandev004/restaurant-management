
function openEditModal(product) {
    document.getElementById('edit_product_id').value = product.id;
    document.getElementById('edit_name').value = product.name;
    document.getElementById('edit_category').value = product.category;
    document.getElementById('edit_price').value = product.price;
    document.getElementById('edit_current_image').src = '../uploads/menu/' + product.image;
    document.getElementById('edit_current_image_name').value = product.image;
    
    document.getElementById('editModal').classList.remove('hidden');
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
}

function openDeleteModal(productId, productName) {
    document.getElementById('delete_product_id').value = productId;
    document.getElementById('delete_product_name').textContent = productName;
    
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}


document.getElementById('editModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeEditModal();
    }
});

document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});