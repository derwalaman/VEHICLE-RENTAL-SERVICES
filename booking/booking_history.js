document.addEventListener('DOMContentLoaded', () => {
    // Function to fetch and display bookings
    function fetchAndDisplayBookings(userId) {
        // URLs for fetching booking data
        const liveBookingsUrl = `get_live_bookings.php?userId=${userId}`;
        const completedBookingsUrl = `get_completed_bookings.php?userId=${userId}`;

        // Fetch and display live bookings
        fetch(liveBookingsUrl)
            .then(response => response.json())
            .then(data => {
                const liveBookingsBody = document.getElementById('live-bookings-body');
                if (data && Array.isArray(data)) {
                    liveBookingsBody.innerHTML = ''; // Clear existing rows
                    data.forEach(booking => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${booking.name}</td>
                            <td>${booking.price}</td>
                            <td>${booking.rental_date}</td>
                            <td>${booking.return_date}</td>
                            <td>${booking.start_time}</td>
                            <td>${booking.end_time}</td>
                            <td>${booking.status}</td>
                        `;
                        liveBookingsBody.appendChild(row);
                    });
                } else {
                    liveBookingsBody.innerHTML = '<tr><td colspan="6">No live bookings found.</td></tr>';
                }
            })
            .catch(error => console.error('Error fetching live bookings:', error));

        // Fetch and display completed bookings
        fetch(completedBookingsUrl)
            .then(response => response.json())
            .then(data => {
                const completedBookingsBody = document.getElementById('completed-bookings-body');
                if (data && Array.isArray(data)) {
                    completedBookingsBody.innerHTML = ''; // Clear existing rows
                    data.forEach(booking => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${booking.name}</td>
                            <td>${booking.price}</td>
                            <td>${booking.rental_date}</td>
                            <td>${booking.return_date}</td>
                            <td>${booking.start_time}</td>
                            <td>${booking.end_time}</td>
                            <td>${booking.status}</td>
                        `;
                        completedBookingsBody.appendChild(row);
                    });
                } else {
                    completedBookingsBody.innerHTML = '<tr><td colspan="6">No completed bookings found.</td></tr>';
                }
            })
            .catch(error => console.error('Error fetching completed bookings:', error));
    }

    // Fetch user ID and then fetch bookings
    fetch('get_user_id.php')
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error('Error:', data.error);
                return;
            }

            const userId = data.userId;
            if (userId) {
                fetchAndDisplayBookings(userId);
            } else {
                console.error('User ID not found.');
            }
        })
        .catch(error => console.error('Error fetching user ID:', error));
});
