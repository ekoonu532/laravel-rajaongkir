<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ongkos Kirim</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Cek Ongkos Kirim</h1>
        <div class="card">

            <div class="card-body">
                <form id="shippingForm">
                    @csrf
                    <div class="form-group">
                        <label for="destination">Kota Tujuan:</label>
                        <select name="destination" id="destination" class="form-control">
                            @foreach($cities['rajaongkir']['results'] as $city)
                                <option value="{{ $city['city_id'] }}">{{ $city['city_name'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="weight">Berat (gram):</label>
                        <input type="number" name="weight" id="weight" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="courier">Ekspedisi:</label>
                        <select name="courier" id="courier" class="form-control">
                            <option value="jne">JNE</option>
                            <option value="pos">POS</option>
                            <option value="tiki">TIKI</option>

                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Cek Ongkos Kirim</button>
                </form>
            </div>
        </div>


        <div id="result" class="mt-4"></div>
    </div>

    <script>
        $(document).ready(function() {
            $('#shippingForm').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: "{{ route('shipping.calculate-ajax') }}",
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        var resultHtml = '<div class="text-center mb-4"><h2>Hasil Ongkos Kirim</h2></div>';
                        response.rajaongkir.results[0].costs.forEach(function(cost) {
                            var formattedCost = cost.cost[0].value.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' });
                            resultHtml += '<div class="card mb-3">';
                            resultHtml += '<div class="card-body">';
                            resultHtml += '<h5 class="card-title">Layanan: ' + cost.service + '</h5>';
                            resultHtml += '<p class="card-text">Deskripsi: ' + cost.description + '</p>';
                            resultHtml += '<p class="card-text">Biaya: ' + formattedCost + '</p>';
                            resultHtml += '<p class="card-text">Estimasi Pengiriman: ' + cost.cost[0].etd + ' hari</p>';
                            resultHtml += '</div></div>';
                        });
                        $('#result').html(resultHtml);
                    }
                });
            });
        });
    </script>
</body>
</html>
