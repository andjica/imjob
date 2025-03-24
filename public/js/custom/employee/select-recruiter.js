$(document).ready(function() {
    function formatRecruiter(recruiter) {
        if (!recruiter.id) {
            return recruiter.text;
        }
        
        var image = $(recruiter.element).data('img') || "{{ asset('/images/user-profile.png') }}";
        var country = $(recruiter.element).data('country') || "Unknown Country";
        var city = $(recruiter.element).data('city') || "Unknown City";

        var template = $(
            `<div style="display: flex; align-items: center;">
                <img src="${image}" class="rounded-circle" style="width:30px; height:30px; margin-right:10px;"/>
                <div>
                    <strong>${recruiter.text}</strong><br>
                    <small><i>${country}, ${city}</i></small>
                </div>
            </div>`
        );
        return template;
    }

    $('#recruiter_id').select2({
        templateResult: formatRecruiter,
        templateSelection: formatRecruiter,
        escapeMarkup: function(m) { return m; } // Render HTML properly
    });
});