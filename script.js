document.addEventListener('DOMContentLoaded', () => {
    const dateInput = document.getElementById('booking_date');
    const startTime = document.getElementById('start_time');
    const endTime = document.getElementById('end_time');
    const form = document.getElementById('bookingForm');

    // Restrict date selection to today or future dates
    if (dateInput) {
        const today = new Date().toISOString().split('T')[0];
        dateInput.setAttribute('min', today);
    }

    // Time validation before HTTP POST submission
    if (form) {
        form.addEventListener('submit', (e) => {
            if (startTime.value && endTime.value) {
                if (startTime.value >= endTime.value) {
                    alert('End time must be later than start time!');
                    e.preventDefault(); // Stop form submission
                }
            }
        });
    }
});