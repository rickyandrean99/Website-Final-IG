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
    <button type="button" class="btn btn-block btn-outline-danger m-2" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-danger">Logout</button>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
    
    <div style="background-color: #EA435E;">
        <h3 class="text-center text-white fw-bolder">PASAR</h3>
    </div>

    <div class="d-flex justify-content-between align-center">
        <!-- SELECT BATCH -->
        <select name="selectBatch" id="selectBatch" onchange="updateMarket('yes')" class="form-select fw-bold w-75" style="color: #EA435E;">
            <option value="0" disabled selected>Pilih Batch</option>    
            @for ($i = 1; $i < 7; $i++)
                <option value="{{$i}}">Batch {{$i}}</option>
            @endfor
        </select>

        <!-- BUTTON SELL -->
        <button type="button" class="btn btn-danger w-25 fw-semibold" data-bs-toggle="modal"
        data-bs-target="#modalSell">JUAL</button>

        <!-- MODAL SELL -->
        <div class="modal fade" id="modalSell" aria-hidden="true" aria-labelledby="modalSellLabel" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <h5 class="modal-title w-100"">Jual Produk</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="selectTim" class="col-form-label fw-bold">Nama Tim</label>
                            <select name="selectTim" id="selectTim" class="form-select w-50 mb-3">
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
                                                <input type="hidden" class="product-id" value="{{ $product->id }}">
                                            </td>
                                            <td class="border-0 text-center align-middle">
                                                <input type="number" style="margin: auto" class="form-control product-amount w-50 text-center" id="numUpDownProduct{{$i}}" placeholder=0 min=0>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="divider py-1 bg-warning"></div>
                            {{-- Metode Pengiriman --}}
                            <label for="metode" class="col-form-label mx-2 my-3 fw-bold">Metode Pengiriman: </label>
                            <div class="form-check-inline">
                                <label class="form-check-label" for="metode1">
                                <input class="form-check-input" type="radio" name="metode" id="metode1" value="1" checked>
                                  Antar Sendiri
                                </label>
                              </div>
                              <div class="form-check-inline">
                                <label class="form-check-label" for="metode2">
                                <input class="form-check-input" type="radio" name="metode" id="metode2" value="2">
                                  Delivery
                                </label>
                            </div>

                            <div class="divider py-1 bg-warning"></div>
                            {{-- Transportation --}}
                            <div class="row">
                                <div class="col-8 ps-4">
                                    <div class="table-responsive">
                                        <table class="table table-centered table-wrap">
                                            <thead>
                                                <tr>
                                                    <th class="border-0 text-center">Kendaraan</th>
                                                    <th class="border-0 rounded-end text-center">Jumlah</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($transportations as $transportation)
                                                <tr>
                                                    <td class="border-0 text-center">{{ $transportation->name }}
                                                        <input type="hidden" class="transportation-id"
                                                                value="{{ $transportation->id }}">
                                                    </td>
                                                    <td class="border-0 text-center text-danger">
                                                        <input type="number" style="margin: auto"
                                                            class="form-control transportation-amount w-50 text-center"
                                                            id="transportation-amount-{{ $transportation->id }}"
                                                            value="0" min="0"
                                                            onchange="updateCapacity()">
                                                    </td>
                                                    <input type="hidden" class="transportation-capacity"
                                                            id="transportation-capacity-{{ $transportation->id }}"
                                                            value="{{ $transportation->capacity }}">
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-4 px-1 py-5">
                                    <!-- Kapasitas -->
                                    <div class="row" style="width:150px;">
                                        <div class="col-10 bg-dark rounded-top text-white text-center fw-bold ">
                                            Kapasitas Maksimal
                                        </div>
                                        <div class="col-10 bg-danger rounded-bottom text-white text-center fw-bold "
                                            id="kapasitas-transportation">
                                            0
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-danger w-20" id="btnTambahTC" onclick = "sellProducts()">Jual</button>
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
            @for ($i = 1; $i <= 10; $i++)
                <tr class = "text-center align-middle">
                    <td>Perusahaan {{ $i }}</td>
                    <td>
                        <span id="keripik-{{ $i }}">0</span>
                    </td>
                    <td>
                        <span id="dodol-{{ $i }}">0</span>
                    </td>
                    <td>
                        <span id="sari-{{ $i }}">0</span>
                    </td>
                    <td>
                        <span id="selai-{{ $i }}">0</span>
                    </td>
                    <td>
                        <span id="cuka-{{ $i }}">0</span>
                    </td>
                    <td>
                        <span id="jumlah-{{ $i }}">0</span>
                    </td>
                    <td>
                        <span id="subtotal-{{ $i }}">0</span>
                    </td>
                </tr>
            @endfor
            <tr class = "text-center align-middle">
                <td>Total</td>
                <td id = "keripiks">0</td>
                <td id = "dodols">0</td>
                <td id = "saris">0</td>
                <td id = "selais">0</td>
                <td id = "cukas">0</td>
                <td id = "jumlahs">0</td>
                <td id = "subtotals">0</td>
            </tr>
        </tbody>
    </table>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script type="text/javascript">
        //jual produk
        const sellProducts = () => {
            if (!confirm("Are you sure?")) return

            //metode
            let metode = $('input[name="metode"]:checked').val()

            //produk
            let productId = $(`.product-id`).map(function() {
                return $(this).val()
            }).get()

            let productAmount = $(`.product-amount`).map(function() {
                return $(this).val()
            }).get()

            let id = $(`#selectTim`).val()

            //transportasi

            let capacity = $('#kapasitas-transportation').text()

            let transportationId = $(`.transportation-id`).map(function() {
                return $(this).val()
            }).get()

            let transportationAmount = $(`.transportation-amount`).map(function() {
                return $(this).val()
            }).get()


            $.ajax({
                type: 'POST',
                url: '{{ route("product.sell") }}',
                data: {
                    '_token': '<?php echo csrf_token() ?>',
                    'id': id,
                    'product_id': productId,
                    'product_amount': productAmount,
                    'capacity': capacity,
                    'metode': metode,
                    'transportation_id': transportationId,
                    'transportation_amount': transportationAmount

                },
                success: function(data) {
                    alert(data.message)
                    updateMarket('no')
                    $(`.product-amount`).val(0)
                    $(`.transportation-amount`).val(0)
                    $('#kapasitas-transportation').text(0)
                    $('input[name="metode"][value="1"]').prop('checked', true);
                    $(`#modalSell`).modal('hide')
                },
                error: function(error) {
                    showError(error)
                }
            })
        }

        const updateMarket = (info) =>{
            let batch = $(`#selectBatch`).val();
            let keripiks = 0;
            let dodols = 0;
            let saris = 0;
            let jumlahs = 0;
            let subtotals = 0;
            let is_info = info;

            $.ajax({
                type: 'POST',
                url: '{{ route("update-market") }}',
                data: {
                    '_token': '<?php echo csrf_token() ?>',
                    'batch' : batch
                },
                success: function(data) {
                    if(is_info == 'yes'){
                        alert("Berhasil update product batch")
                    }

                    data.keripik.forEach((value, index)=>{
                        $(`#keripik-${index+1}`).text(value)
                        keripiks += value
                    })
                    data.dodol.forEach((value, index)=>{
                        $(`#dodol-${index+1}`).text(value)
                        dodols += value
                    })
                    data.sari.forEach((value, index)=>{
                        $(`#sari-${index+1}`).text(value)
                        saris += value
                    })
                    data.selai.forEach((value, index)=>{
                        $(`#selai-${index+1}`).text(value)
                    })
                    data.cuka.forEach((value, index)=>{
                        $(`#cuka-${index+1}`).text(value)
                    })
                    data.jumlah.forEach((value, index)=>{
                        $(`#jumlah-${index+1}`).text(value)
                        jumlahs += value
                    })
                    data.subtotal.forEach((value, index)=>{
                        $(`#subtotal-${index+1}`).text(value)
                        subtotals += value
                    })

                    $(`#keripiks`).text(keripiks)
                    $(`#dodols`).text(dodols)
                    $(`#saris`).text(saris)
                    $(`#selais`).text("-")
                    $(`#cukas`).text("-")
                    $(`#jumlahs`).text(jumlahs)
                    $(`#subtotals`).text(subtotals)
                },
                error: function(error) {
                    alert("Gagal update product batch")
                }
            })
        }

        //update kapasitas transportasi
        const updateCapacity = () => {
            let transportationsAmount = $('.transportation-amount').map(function() {
                return $(this).val()
            }).get()
            let transportationsCapacity = $('.transportation-capacity').map(function() {
                return $(this).val()
            }).get()

            let totalCapacity = 0
            for (let i = 0; i < transportationsAmount.length; i++) {
                totalCapacity += (transportationsAmount[i] * transportationsCapacity[i])
            }

            $('#kapasitas-transportation').text(totalCapacity)
        }

        const showError = (error) => {
            let errorMessage = JSON.parse(error.responseText).message
            alert(`Error: ${errorMessage}`)
            console.log(`Error: ${errorMessage}`)
        }
    </script>
</body>
</html>