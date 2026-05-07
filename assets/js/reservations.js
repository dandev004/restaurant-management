
function openEditModal(reservation) {
    document.getElementById('edit_reservation_id').value = reservation.id;
    document.getElementById('edit_client_name').value = reservation.client_name;
    document.getElementById('edit_client_phone').value = reservation.client_phone || '';
    document.getElementById('edit_number_people').value = reservation.number_people;
    document.getElementById('edit_table_number').value = reservation.table_number;
    document.getElementById('edit_reservation_date').value = reservation.reservation_date;
    document.getElementById('edit_start_time').value = reservation.start_time;
    document.getElementById('edit_end_time').value = reservation.end_time;
    document.getElementById('edit_status').value = reservation.status;
    
    document.getElementById('editModal').classList.remove('hidden');
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
}

function openDeleteModal(reservationId, clientName) {
    document.getElementById('delete_reservation_id').value = reservationId;
    document.getElementById('delete_client_name').textContent = clientName;
    
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