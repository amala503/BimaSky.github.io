<script>
    $(document).ready(function() {
        $('.konfirmasi-pesanan-form').on('submit', function(e) {
            if (!confirm('Apakah Anda yakin ingin mengkonfirmasi penerimaan pesanan ini?')) {
                e.preventDefault();
            }
        });
    });
</script>