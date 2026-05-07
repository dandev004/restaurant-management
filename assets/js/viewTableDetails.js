 async function viewTableDetails(tableNumber, date) {
            const modal = document.getElementById('tableDetailsModal');
            const modalTitle = document.getElementById('modalTitle');
            const modalContent = document.getElementById('modalContent');
            
            modalTitle.textContent = `Table ${tableNumber} - ${date}`;
            modalContent.innerHTML = '<p class="text-center">Loading...</p>';
            modal.classList.remove('hidden');
            
            try {
                const response = await fetch(`../components/GetTableDetails.php?table=${tableNumber}&date=${date}`);
                const html = await response.text();
                modalContent.innerHTML = html;
            } catch (error) {
                modalContent.innerHTML = '<p class="text-red-500">Error loading details</p>';
            }
        }
        
        function closeTableDetails() {
            document.getElementById('tableDetailsModal').classList.add('hidden');
        }
        
        document.getElementById('tableDetailsModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeTableDetails();
            }
        });