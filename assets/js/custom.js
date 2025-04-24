// Auto refresh notifikasi setiap 30 detik
$(document).ready(function() {
    // Fungsi untuk memperbarui notifikasi
    function refreshNotifications() {
        $.ajax({
            url: BASE_URL + 'api/get_notifications',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Update badge counter
                    if (response.count > 0) {
                        $('#notificationDropdown').html('<i class="fa fa-bell fa-lg"></i><span class="badge badge-danger badge-counter position-absolute">' + response.count + '</span>');
                    } else {
                        $('#notificationDropdown').html('<i class="fa fa-bell fa-lg"></i>');
                    }
                    
                    // Update dropdown content
                    $('.notification-dropdown-menu').html(response.html);
                }
            }
        });
    }
    
    // Refresh setiap 30 detik
    setInterval(refreshNotifications, 30000);
});