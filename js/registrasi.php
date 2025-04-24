<script>
let currentSlide = 1;

function nextSlide(slideNumber) {
    if (validateForm(slideNumber)) {
        document.getElementById('slide' + slideNumber).style.display = 'none';
        currentSlide++;
        document.getElementById('slide' + currentSlide).style.display = 'block';
    }
}

function validateForm(slideNumber) {
    let valid = true;
    let inputs = document.querySelectorAll('#slide' + slideNumber + ' input[required], #slide' + slideNumber + ' select[required]');
    inputs.forEach(input => {
        if (input.value === '') {
            valid = false;
            alert(input.name + ' harus diisi!');
        }
    });
    return valid;
}

$('#provinsi').change(function () {
            var provinsi_id = $(this).val();
            if (provinsi_id) {
                $.ajax({
                    url: 'https://strayneko.fly.dev/api/kabupaten/' + provinsi_id,
                    type: 'GET',
                    success: function (response) {
                        var kabupatenSelect = $('#kabupatenKota');
                        kabupatenSelect.empty();
                        kabupatenSelect.append('<option value="">Pilih Kabupaten/Kota</option>');
                        if (response.data && response.data.list) {
                            response.data.list.forEach(function (kabupaten) {
                                kabupatenSelect.append('<option value="' + kabupaten.id + '">' + kabupaten.nama + '</option>');
                            });
                        }
                    },
                    error: function () {
                        alert('Gagal mendapatkan data kabupaten.');
                    },
                });
            }
        });

        $('#kabupatenKota').change(function () {
            var kabupaten_id = $(this).val();
            if (kabupaten_id) {
                $.ajax({
                    url: 'https://strayneko.fly.dev/api/kecamatan/' + kabupaten_id,
                    type: 'GET',
                    success: function (response) {
                        var kecamatanSelect = $('#kecamatan');
                        kecamatanSelect.empty();
                        kecamatanSelect.append('<option value="">Pilih Kecamatan</option>');
                        if (response.data && response.data.list) {
                            response.data.list.forEach(function (kecamatan) {
                                kecamatanSelect.append('<option value="' + kecamatan.id + '">' + kecamatan.nama + '</option>');
                            });
                        }
                    },
                    error: function () {
                        alert('Gagal mendapatkan data kecamatan.');
                    },
                });
            }
        });

        
        $('#kecamatan').change(function () {
            var kecamatan_id = $(this).val();
            if (kecamatan_id) {
                $.ajax({
                    url: 'https://strayneko.fly.dev/api/kelurahan/' + kecamatan_id,
                    type: 'GET',
                    success: function (response) {
                        var kelurahanSelect = $('#kelurahanDesa');
                        kelurahanSelect.empty();
                        kelurahanSelect.append('<option value="">Pilih Kelurahan/Desa</option>');
                        if (response.data && response.data.list) {
                            response.data.list.forEach(function (kelurahan) {
                                 kelurahanSelect.append('<option value="' + kelurahan.id + '">' + kelurahan.nama + '</option>');
                            });
                        }
                    },
                    error: function () {
                        alert('Gagal mendapatkan data kelurahan/desa.');
                    },
                });
            }
        });
        </script>