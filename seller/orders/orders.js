function changeStatus(bookingId, status) {
    fetch('change_booking_status.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `id=${bookingId}&status=${status}`
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Booking status updated successfully.');
                // Refresh the page after the alert
                window.location.reload();
            } else {
                alert('Failed to update booking status.');
            }
        })
        .catch(error => console.error('Error updating booking status:', error));
}


document.addEventListener('DOMContentLoaded', () => {
    function fetchAndDisplayBookings(userId) {
        const liveBookingsUrl = `get_live_bookings.php?userId=${userId}`;
        const completedBookingsUrl = `get_completed_bookings.php?userId=${userId}`;

        fetch(liveBookingsUrl)
            .then(response => response.json())
            .then(data => {
                const liveBookingsBody = document.getElementById('live-bookings-body');
                if (data && Array.isArray(data)) {
                    liveBookingsBody.innerHTML = '';
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
                            <td>
                                <div class="action-buttons">
                                    <button class="accept-btn" onclick="changeStatus(${booking.id}, 'live')">Accept</button>
                                    <button class="accept-btn" onclick="changeStatus(${booking.id}, 'completed')">Complete</button>
                                    <button class="reject-btn" onclick="changeStatus(${booking.id}, 'rejected')">Reject</button>
                                </div>
                            </td>
                        `;
                        liveBookingsBody.appendChild(row);
                    });
                } else {
                    liveBookingsBody.innerHTML = '<tr><td colspan="8">No live bookings found.</td></tr>';
                }
            })
            .catch(error => console.error('Error fetching live bookings:', error));

        fetch(completedBookingsUrl)
            .then(response => response.json())
            .then(data => {
                const completedBookingsBody = document.getElementById('completed-bookings-body');
                if (data && Array.isArray(data)) {
                    completedBookingsBody.innerHTML = '';
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
                    completedBookingsBody.innerHTML = '<tr><td colspan="7">No completed bookings found.</td></tr>';
                }
            })
            .catch(error => console.error('Error fetching completed bookings:', error));
    }

    fetch('get_seller_id.php')
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
