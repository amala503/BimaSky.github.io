$(document).ready(function() {
    // Handle status change clicks
    $(document).on('click', '.status-change', function(e) {
        e.preventDefault();
        
        var $this = $(this);
        var orderId = $this.data('id');
        var newStatus = $this.data('status');
        var url = $this.data('url');
        
        // Show SweetAlert2 confirmation dialog
        Swal.fire({
            title: 'Konfirmasi Perubahan Status',
            html: `Apakah Anda yakin ingin mengubah status pesanan menjadi <strong>${newStatus}</strong>?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Ubah Status',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading state
                Swal.fire({
                    title: 'Memproses...',
                    text: 'Sedang mengubah status pesanan',
                    icon: 'info',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    showConfirmButton: false
                });
                
                // Send AJAX request to update status
                $.ajax({
                    url: url + "/" + orderId,
                    type: 'POST',
                    data: {
                        'status': newStatus,
                        'csrf_token': csrfToken
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            // Update the button text and class
                            var $button = $('#statusDropdown' + orderId);
                            $button.text(newStatus);
                            
                            // Update button class based on new status
                            $button.removeClass('btn-info btn-primary btn-success btn-secondary btn-warning btn-danger');
                            switch(newStatus) {
                                case 'Menunggu':
                                    $button.addClass('btn-secondary');
                                    break;
                                case 'Diproses':
                                    $button.addClass('btn-info');
                                    break;
                                case 'Dikirim':
                                    $button.addClass('btn-primary');
                                    break;
                                case 'Selesai':
                                    $button.addClass('btn-success');
                                    break;
                                case 'Dibatalkan':
                                    $button.addClass('btn-danger');
                                    break;
                                // Also handle English status names for direct API calls
                                case 'pending':
                                    $button.addClass('btn-secondary');
                                    break;
                                case 'processing':
                                    $button.addClass('btn-info');
                                    break;
                                case 'shipped':
                                    $button.addClass('btn-primary');
                                    break;
                                case 'completed':
                                    $button.addClass('btn-success');
                                    break;
                                case 'cancelled':
                                    $button.addClass('btn-danger');
                                    break;
                                default:
                                    $button.addClass('btn-secondary');
                            }
                            
                            // Show success message
                            Swal.fire({
                                title: 'Berhasil!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'OK'
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: response.message || 'Terjadi kesalahan saat mengubah status pesanan',
                                icon: 'error',
                                confirmButtonColor: '#d33',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', {
                            xhr: xhr,
                            status: status,
                            error: error
                        });
                        
                        let errorMessage = 'Terjadi kesalahan saat menghubungi server';
                        
                        // Try to get more specific error message
                        try {
                            const response = JSON.parse(xhr.responseText);
                            if (response && response.message) {
                                errorMessage = response.message;
                            }
                        } catch (e) {
                            console.error('Error parsing response:', e);
                            // If we can't parse the response, use the error message
                            errorMessage = error || errorMessage;
                        }
                        
                        Swal.fire({
                            title: 'Error!',
                            text: errorMessage,
                            icon: 'error',
                            confirmButtonColor: '#d33',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            }
        });
    });
});