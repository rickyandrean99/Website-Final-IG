<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('') }}assets/icons/logo.png">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('') }}assets/icons/logo.png">
    <title>Market Industrial Games 30</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body style="background-color: #FAF0DC">

    <div style="background-color: #EA435E;">
        <h3 class="text-center text-white fw-bolder">PASAR</h3>
    </div>

    <div class="d-flex justify-content-between align-center">
            
            <!-- SELECT BATCH -->
            <select name="selectBatch" id="selectBatch" class="form-select fw-bold w-75" style="color: #EA435E;">
                @for ($i = 1; $i < 7; $i++)
                    <option value="batch-{{$i}}">Batch {{$i}}</option>
                @endfor
            </select>

            <!-- BUTTON SELL -->
            <button type="button" class="btn btn-danger w-25 fw-semibold" data-bs-toggle="modal"
            data-bs-target="#modalSell">JUAL</button>

            <!-- MODAL SELL -->
           <!-- Modal Content -->
           <div class="modal fade" id="modalSell" aria-hidden="true" aria-labelledby="modalSellLabel"
                    tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header text-center">
                                <h5 class="modal-title w-100"">Jual Produk</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="selectTim" class="col-form-label fw-bold">Nama Tim</label>
                                    <select name="selectTim" id="selectTim" class="form-select w-50 mb-3" onchange="updateMarket()">
                                        @for ($i = 1; $i < 11; $i++)
                                            <option value="{{$i}}">Perusahaan {{$i}}</option>
                                        @endfor
                                    </select>
                                    <table class="table table-hover bg-white rounded">
                                        <thead>
                                            <tr>
                                                <th class="border-0 text-center align-middle" scope="col" class="w-50">Nama Produk</th>
                                                <th class="border-0 text-center align-middle" scope="col" class="w-50">Jumlah</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($products as $product)
                                                <tr>
                                                    <td class="border-0 text-center align-middle">
                                                        {{ $product->name }}
                                                        <input type="hidden" class="product-id"
                                                                value="{{ $product->id }}">
                                                    </td>
                                                    <td class="border-0 text-center align-middle">
                                                        <input type="number" style="margin: auto" class="form-control product-amount w-50 text-center" id="numUpDownProduct{{$i}}" placeholder=0 min=0>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    <div class="d-flex justify-content-center mt-2">    
                                        <button type="button" class="btn btn-danger w-25"
                                            id="btnTambahTC" onclick = "sellProducts()">Jual</button>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
    </div>

    <!-- TABLE -->
    <table class="table table-hover bg-white rounded my-1">
        <thead>
            <tr class = "text-center align-middle">
                <th scope="col">Nama Tim</th>
                <th scope="col">Keripik Apel</th>
                <th scope="col">Dodol Apel</th>
                <th scope="col">Sari Buah Apel</th>
                <th scope="col">Selai Kulit Apel</th>
                <th scope="col">Cuka Apel</th>
                <th scope="col">Total</th>
                <th scope="col">Hasil Penjualan</th>
            </tr>
        </thead>
        <tbody>
            @for ($i = 0; $i < 10; $i++)
                <tr class = "text-center align-middle">
                    <td>Perusahaan {{ $i + 1 }}</td>
                    <td>
                        <p>0</p>
                    </td>
                    <td>
                        <p>0</p>
                    </td>
                    <td>
                        <p>0</p>
                    </td>
                    <td>
                        <p>0</p>
                    </td>
                    <td>
                        <p>0</p>
                    </td>
                    <td>
                        <p>0</p>
                    </td>
                    <td>
                        <p>0</p>
                    </td>
                </tr>
            @endfor
        </tbody>
    </table>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>

    <script type="text/javascript">
        //jual produk

        const sellProducts = () => {
            if (!confirm("Are you sure?")) return

            let productId = $(`.product-id`).map(function() {
                return $(this).val()
            }).get()

            let productAmount = $(`.product-amount`).map(function() {
                return $(this).val()
            }).get()

            let id = $(`#selectTim`).val();

            $.ajax({
                type: 'POST',
                url: '{{ route("product.sell") }}',
                data: {
                    '_token': '<?php echo csrf_token() ?>',
                    'id': id,
                    'product_id': productId,
                    'product_amount': productAmount
                },
                success: function(data) {
                    alert(data.message)
                },
                error: function(error) {
                    console.log(error)
                }
            })
        }

        const updateMarket = () =>{

        }
    </script>
</body>
</html>