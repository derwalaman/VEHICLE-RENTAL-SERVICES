document.addEventListener('DOMContentLoaded', () => {
    const urlParams = new URLSearchParams(window.location.search);
    const productId = urlParams.get('id');

    if (productId) {
        fetch(`get_product_details.php?id=${productId}`)
            .then(response => response.json())
            .then(data => {
                if (data.error || !data.name) {
                    // If there is an error or no product is found, redirect to home page
                    window.location.href = '../index.php';
                } else {
                    // Handle image source
                    const imageUrl = data.image ? data.image : 'https://via.placeholder.com/150';
                    document.getElementById('product-image').src = imageUrl;

                    // Populate the product details
                    document.getElementById('product-name').innerText = data.name;
                    document.getElementById('product-price').innerText = `₹${data.price}/hour`;
                    document.getElementById('product-vehicle-type').innerText = data.vehicle_type;
                    document.getElementById('product-fuel-type').innerText = data.fuel_type;
                    document.getElementById('product-delivery-types').innerText = data.delivery_types;

                    // Handle distance formatting
                    const distance = parseFloat(data.distance);
                    if (!isNaN(distance)) {
                        document.getElementById('product-distance').innerText = `${distance.toFixed(2)} km`;
                    } else {
                        document.getElementById('product-distance').innerText = 'Distance not available';
                    }

                    // Populate seller information
                    document.getElementById('product-avail').innerText = data.availability;
                    document.getElementById('product-mob').innerText = data.mob;
                    document.getElementById('product-email').innerText = data.email;

                    // Update the map section
                    const mapFrame = document.getElementById('map-frame');
                    if (data.get_map) {
                        // If the get_map column is not empty, use the embedded code directly
                        mapFrame.src = data.get_map;
                    } else {
                        // Otherwise, use Google Maps URL with latitude and longitude
                        const latitude = data.latitude;
                        const longitude = data.longitude;
                        const mapUrl = `https://www.google.com/maps?q=${latitude},${longitude}&hl=en&z=14&output=embed`;
                        mapFrame.src = mapUrl;
                    }

                    // Handle form display based on availability
                    const rental = document.querySelector('.rental-form-container');
                    if (data.availability === 'no') {
                        rental.style.display = 'none';
                    } else {
                        rental.style.display = 'block';
                    }

                    const hourlyRate = data.price;
                    const rentalDateInput = document.getElementById('rental-date');
                    const returnDateInput = document.getElementById('return-date');
                    const startTimeInput = document.getElementById('start-time');
                    const endTimeInput = document.getElementById('end-time');
                    const totalAmountInput = document.getElementById('total-amount');

                    function calculateTotalAmount() {
                        const rentalDate = new Date(rentalDateInput.value);
                        const returnDate = new Date(returnDateInput.value);
                        const startTime = startTimeInput.value;
                        const endTime = endTimeInput.value;

                        if (rentalDate && returnDate && startTime && endTime) {
                            const startDateTime = new Date(`${rentalDate.toISOString().split('T')[0]}T${startTime}`);
                            const endDateTime = new Date(`${returnDate.toISOString().split('T')[0]}T${endTime}`);

                            if (endDateTime > startDateTime) {
                                const durationHours = (endDateTime - startDateTime) / (1000 * 60 * 60);
                                const totalAmount = hourlyRate * durationHours;
                                totalAmountInput.value = `₹${totalAmount.toFixed(2)}`;
                            } else {
                                totalAmountInput.value = '₹0.00';
                            }
                        } else {
                            totalAmountInput.value = '₹0.00';
                        }
                    }

                    rentalDateInput.addEventListener('change', calculateTotalAmount);
                    returnDateInput.addEventListener('change', calculateTotalAmount);
                    startTimeInput.addEventListener('change', calculateTotalAmount);
                    endTimeInput.addEventListener('change', calculateTotalAmount);

                    // Handle form submission
                    const rentalForm = document.getElementById('rental-form');
                    rentalForm.addEventListener('submit', function(event) {
                        // Ensure currency symbol and any commas are removed before parsing
                        const totalAmountValue = parseFloat(totalAmountInput.value.replace('₹', '').replace(',', ''));
                        if (isNaN(totalAmountValue) || totalAmountValue <= 0) {
                            event.preventDefault(); // Prevent form submission
                            alert('Wrong request, please review your request.');
                        }
                    });

                    // Handle delivery options
                    const deliveryOptionsContainer = document.getElementById('delivery-options-container');
                    const deliveryOptionSelect = document.getElementById('delivery-option');

                    if (data.delivery_types === 'all') {
                        // Show delivery options if delivery is 'all'
                        deliveryOptionsContainer.style.display = 'block';
                        deliveryOptionSelect.disabled = false;
                    } else if (data.delivery_types === 'home') {
                        // Fixed delivery option to home delivery
                        deliveryOptionsContainer.style.display = 'block';
                        deliveryOptionSelect.innerHTML = '<option value="home" selected>Home Delivery</option>';
                        deliveryOptionSelect.disabled = true;
                    } else if (data.delivery_types === 'pickup') {
                        // Fixed delivery option to pickup
                        deliveryOptionsContainer.style.display = 'block';
                        deliveryOptionSelect.innerHTML = '<option value="pickup" selected>Pickup</option>';
                        deliveryOptionSelect.disabled = true;
                    } else {
                        // Hide delivery options if delivery type is not supported
                        deliveryOptionsContainer.style.display = 'none';
                    }
                }
            })
            .catch(error => {
                console.error('Error fetching product details:', error);
                // Redirect to home page in case of any error
                window.location.href = '../index.php';
            });
    } else {
        // Redirect to home page if no product ID is provided in the URL
        window.location.href = '../index.php';
    }
});

function toggleNavbar() {
    const navbarCollapse = document.getElementById('navbarSupportedContent');
    navbarCollapse.classList.toggle('show');
}

function toggleNavbar() {
    const navbarMenu = document.getElementById('hamburgerMenu');
    navbarMenu.classList.toggle('active');
}
