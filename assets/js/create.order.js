const openModal = document.getElementById('openModal');
const closeModal = document.getElementById('closeModal');
const modal = document.getElementById('orderModal');

openModal.addEventListener('click', () => {
    modal.classList.remove('hidden');
});

closeModal.addEventListener('click', () => {
    modal.classList.add('hidden');
});

modal.addEventListener('click', (e) => {
    if (e.target === modal) {
        modal.classList.add('hidden');
    }
});


const openModalCategory = document.getElementById('openModalCategory');
const modalCategory = document.getElementById('modalCategory');
const modalProduct = document.getElementById('modalProduct');
const selectCategory = document.getElementById('select_category');
const selectProduct = document.getElementById('select_Product');
const productsList = document.getElementById('productsList');
const totalAmountDisplay = document.getElementById('totalAmount');
const totalAmountInput = document.getElementById('total_amount_input');
const productsInput = document.getElementById('products_input');

let selectedProducts = [];
let totalAmount = 0;

openModalCategory.addEventListener('click', () => {
    modalCategory.classList.remove('hidden');

    selectCategory.value = '';
    modalProduct.classList.add('hidden');
    selectProduct.innerHTML = '<option value="">Choose product</option>';
});

selectCategory.addEventListener('change', async () => {
    const category = selectCategory.value;

    if (!category) {
        modalProduct.classList.add('hidden');
        return;
    }

    try {
        const response = await fetch(`?category=${encodeURIComponent(category)}`);
        const products = await response.json();

        selectProduct.innerHTML = '<option value="">Choose product</option>';

        products.forEach(product => {
            const option = document.createElement('option');
            option.value = product.id;
            option.dataset.name = product.name;
            option.dataset.price = product.price;
            option.textContent = `${product.name} - ${product.price} EUR`;
            selectProduct.appendChild(option);
        });

        modalProduct.classList.remove('hidden');

    } catch (error) {
        console.error('Error loading products:', error);
        alert('Error loading products');
    }
});

selectProduct.addEventListener('change', () => {
    const selectedOption = selectProduct.options[selectProduct.selectedIndex];

    if (!selectedOption.value) return;

    const product = {
        id: selectedOption.value,
        name: selectedOption.dataset.name,
        price: parseFloat(selectedOption.dataset.price),
        quantity: 1
    };

    const existingProductIndex = selectedProducts.findIndex(p => p.id === product.id);

    if (existingProductIndex !== -1) {
        selectedProducts[existingProductIndex].quantity++;
    } else {
        selectedProducts.push(product);
    }
    updateProductsList();
    updateTotal();

    modalCategory.classList.add('hidden');
    modalProduct.classList.add('hidden');
    selectCategory.value = '';
    selectProduct.innerHTML = '<option value="">Choose product</option>';
});

function updateProductsList() {
    productsList.innerHTML = '';

    selectedProducts.forEach((product, index) => {
        const productDiv = document.createElement('div');
        productDiv.className = 'flex justify-between items-center border p-2 rounded';
        productDiv.innerHTML = `
            <div class="flex-1">
                <p class="font-medium">${product.name}</p>
                <p class="text-sm text-gray-600">${product.price} EUR × ${product.quantity}</p>
            </div>
            <div class="flex items-center gap-2">
                <button type="button" onclick="decreaseQuantity(${index})" class="px-2 py-1 bg-gray-200 rounded">-</button>
                <span>${product.quantity}</span>
                <button type="button" onclick="increaseQuantity(${index})" class="px-2 py-1 bg-gray-200 rounded">+</button>
                <button type="button" onclick="removeProduct(${index})" class="px-2 py-1 bg-red-500 text-white rounded ml-2">×</button>
            </div>
        `;
        productsList.appendChild(productDiv);
    });

    productsInput.value = JSON.stringify(selectedProducts);
}

function updateTotal() {
    totalAmount = selectedProducts.reduce((sum, product) => {
        return sum + (product.price * product.quantity);
    }, 0);

    totalAmountDisplay.textContent = totalAmount.toFixed(2) + ' EUR';
    totalAmountInput.value = totalAmount.toFixed(2);
}

function increaseQuantity(index) {
    selectedProducts[index].quantity++;
    updateProductsList();
    updateTotal();
}

function decreaseQuantity(index) {
    if (selectedProducts[index].quantity > 1) {
        selectedProducts[index].quantity--;
        updateProductsList();
        updateTotal();
    }
}

function removeProduct(index) {
    selectedProducts.splice(index, 1);
    updateProductsList();
    updateTotal();
}
