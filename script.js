let vehicles = [];

function displayProducts(productsToDisplay) {
    const productContainer = document.getElementById('product-container');
    productContainer.innerHTML = '';

    if (productsToDisplay.length === 0) {
        // Show a message if no products are available
        productContainer.innerHTML = '<p>No rental cars available</p>';
    } else {
        productsToDisplay.forEach(product => {
            const productCard = document.createElement('div');
            productCard.classList.add('product-card');
            productCard.innerHTML = `
                <img src="${product.image || 'https://via.placeholder.com/150'}" alt="${product.name}">
                <div class="info">
                    <h3>${product.name}</h3>
                    <p class="price">₹${product.price}</p>
                    <p>Type: ${product.vehicle_type}</p>
                    <p>Fuel: ${product.fuel_type}</p>
                    <p>Delivery: ${product.delivery_types}</p>
                    <p>Distance: ${product.distance.toFixed(2)} km</p>
                </div>
            `;
            productCard.addEventListener('click', () => {
                window.location.href = `products/index.php?id=${product.id}`; // Navigate to product.html with ID as query parameter
            });
            productContainer.appendChild(productCard);
        });
    }
}

function getUserLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, showError, { enableHighAccuracy: true });
    } else {
        alert("Geolocation is not supported by this browser.");
    }
}

function showPosition(position) {
    const lat = position.coords.latitude;
    const lon = position.coords.longitude;
    fetchNearbyVehicles(lat, lon);
}

function showError(error) {
    switch (error.code) {
        case error.PERMISSION_DENIED:
            alert("User denied the request for Geolocation.");
            break;
        case error.POSITION_UNAVAILABLE:
            alert("Location information is unavailable.");
            break;
        case error.TIMEOUT:
            alert("The request to get user location timed out.");
            break;
        case error.UNKNOWN_ERROR:
            alert("An unknown error occurred.");
            break;
    }
}

function fetchNearbyVehicles(lat, lon) {
    fetch(`get_vehicles.php?lat=${lat}&lon=${lon}`)
        .then(response => response.json())
        .then(data => {
            vehicles = data;
            displayProducts(vehicles);
        })
        .catch(error => console.error('Error fetching vehicles:', error));
}

function filterProducts() {
    const priceRange = document.getElementById('price-range').value;
    const vehicleType = document.getElementById('ctype').value;
    const fuelType = document.getElementById('ftype').value;
    const deliveryType = document.getElementById('dtype').value;
    const availability = document.getElementById('availability').value;

    let filteredProducts = vehicles;

    if (priceRange !== 'all') {
        const [min, max] = priceRange.split('-').map(Number);
        filteredProducts = filteredProducts.filter(product => {
            if (max) {
                return product.price >= min && product.price <= max;
            } else {
                return product.price >= min;
            }
        });
    }

    if (vehicleType !== 'all') {
        filteredProducts = filteredProducts.filter(product => product.vehicle_type === vehicleType);
    }

    if (fuelType !== 'all') {
        filteredProducts = filteredProducts.filter(product => product.fuel_type === fuelType);
    }

    if (deliveryType !== 'all') {
        // If deliveryType is 'home', include 'all' delivery types
        filteredProducts = filteredProducts.filter(product => {
            return product.delivery_types === deliveryType || (deliveryType === 'home' && product.delivery_types === 'all');
        });
    }

    if (availability !== 'all') {
        filteredProducts = filteredProducts.filter(product => product.availability === availability);
    }

    displayProducts(filteredProducts);
}

// Call getUserLocation on page load
window.onload = getUserLocation;

// Event listener for the filter button
document.querySelector(".filter").addEventListener('click', () => {
    const filterContainer = document.querySelector(".filter-container");
    filterContainer.style.display = filterContainer.style.display === "none" ? "inline-block" : "none";
});

// Event listener for the filter change
document.querySelectorAll('.foptions select').forEach(select => {
    select.addEventListener('change', filterProducts);
});
