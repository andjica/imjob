document.addEventListener('DOMContentLoaded', function () {
    // Initialize Flatpickr for date and time picker
    flatpickr("#meetingDate", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        minDate: "today"
    });

    // Initialize Select2 for Contributors Multi-Select
    $('#meetingContributors').select2({
        placeholder: "Select contributors",
        allowClear: true,
        width: '100%'
    });

    // Handle chat form submission
    const chatForm = document.getElementById('chatForm');
    const chatBox = document.getElementById('chatBox');
    chatForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const message = document.getElementById('chatInput').value.trim();
        if (message) {
            appendChatMessage('sent', message);
            // TODO: Send the message to the server via AJAX or WebSockets
            document.getElementById('chatInput').value = '';
        }
    });

    // Handle schedule meeting form submission
    const scheduleMeetingForm = document.getElementById('scheduleMeetingForm');
    scheduleMeetingForm.addEventListener('submit', function (e) {
        // e.preventDefault();
        const title = document.getElementById('meetingTitle').value.trim();
        const date = document.getElementById('meetingDate').value.trim();
        const description = document.getElementById('meetingDescription').value.trim();
        const contributors = $('#meetingContributors').val(); // Get selected contributors

        if (title && date && description && contributors.length > 0) {
            // Parse date and time
            const startDate = new Date(date);
            const endDate = new Date(startDate.getTime() + 60 * 60 * 1000); // Assuming 1-hour meeting

            // Add event to FullCalendar
            calendar.addEvent({
                title: title,
                start: startDate,
                end: endDate,
                description: description
            });

            // Show success pop-up
            Swal.fire({
                icon: 'success',
                title: 'Meeting Scheduled',
                html: `
                    <strong>Title:</strong> ${escapeHtml(title)}<br>
                    <strong>Date & Time:</strong> ${escapeHtml(startDate.toLocaleString())}<br>
                    <strong>Description:</strong> ${escapeHtml(description)}<br>
                    <strong>Contributors:</strong> ${escapeHtml(getContributorsText(contributors))}
                `,
                confirmButtonText: 'OK'
            });

            // Close the modal
            var scheduleMeetingModal = bootstrap.Modal.getInstance(document.getElementById('scheduleMeetingModal'));
            scheduleMeetingModal.hide();
            // Reset the form
            scheduleMeetingForm.reset();
            $('#meetingContributors').val(null).trigger('change');
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Missing Information',
                text: 'Please fill in all fields and select at least one contributor.',
                confirmButtonText: 'OK'
            });
        }
    });

    // Function to append chat messages
    function appendChatMessage(type, message) {
        const messageElement = document.createElement('div');
        messageElement.classList.add('chat-message', type);
        messageElement.innerHTML = `
            <strong>${type === 'sent' ? 'You' : 'Candidate'}:</strong>
            <p>${escapeHtml(message)}</p>
            <small class="text-muted">${formatTime(new Date())}</small>
        `;
        chatBox.appendChild(messageElement);
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    // Initialize FullCalendar
    var calendarEl = document.getElementById('meetingCalendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: [
            // Example event
            {
                title: 'Initial Interview with Andjela',
                start: '2025-01-20T10:00:00',
                end: '2025-01-20T11:00:00',
                description: 'Discuss initial qualifications and experience.'
            }
            // Additional events can be dynamically added here
        ],
        eventClick: function(info) {
            // Display event details in a popup
            Swal.fire({
                title: info.event.title,
                html: `
                    <strong>Date & Time:</strong> ${info.event.start.toLocaleString()}<br>
                    <strong>Description:</strong> ${info.event.extendedProps.description || 'N/A'}
                `,
                icon: 'info',
                confirmButtonText: 'Close'
            });
        }
    });
    calendar.render();

    // Function to append meetings to the meeting list (if you still need it)
    /*
    function appendMeeting(meeting) {
        const meetingList = document.getElementById('meetingList');
        // Clear "No meetings scheduled yet." message if present
        if (meetingList.querySelector('p')) {
            meetingList.innerHTML = '';
        }
        const meetingCard = document.createElement('div');
        meetingCard.classList.add('mb-3', 'p-3', 'border', 'rounded', 'shadow-sm');
        meetingCard.innerHTML = `
            <h5>${escapeHtml(meeting.title)}</h5>
            <p><strong>Date & Time:</strong> ${escapeHtml(meeting.date)}</p>
            <p><strong>Description:</strong> ${escapeHtml(meeting.description)}</p>
            <p><strong>Contributors:</strong> ${escapeHtml(meeting.contributors)}</p>
        `;
        meetingList.appendChild(meetingCard);
    }
    */

    // Utility function to format time
    function formatTime(date) {
        return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    }

    // Utility function to escape HTML to prevent XSS
    function escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.replace(/[&<>"']/g, function(m) { return map[m]; });
    }

    // Function to get contributors' names from their IDs
    function getContributorsText(contributorIds) {
        const contributorsMap = {
            '1': 'John Doe',
            '2': 'Jane Smith',
            '3': 'Mike Johnson'
            // Add more mappings as per your database
        };
        return contributorIds.map(id => contributorsMap[id] || 'Unknown').join(', ');
    }
});
