<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bahan Baku Import</title>
    <link rel="stylesheet" href="{{ asset('sandbox/css/plugins.css') }}">
    <link rel="stylesheet" href="{{ asset('sandbox/css/style.css') }}">
    <link rel="preload" href="./assets/css/fonts/thicccboi.css" as="style" onload="this.rel='stylesheet'">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
        main, table {
            color: white !important;
        }
    </style>
</head>

<body style="background: url('{{ asset('assets/img/bgpos.jpg') }}')">
    <!-- Navigation Section -->
    <nav class="navbar navbar-expand-lg fancy navbar-light navbar-bg-light" style="z-index: 100">
        <div class="container w-100">
            <div
                class="navbar-collapse-wrapper bg-white d-flex flex-row flex-nowrap w-100 justify-content-between align-items-center">
                <div class="navbar-brand w-100">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="Logo IG Ubaya" style="width: 100px" />
                </div>
                <div class="navbar-collapse offcanvas offcanvas-nav offcanvas-start">
                    <div class="offcanvas-header d-lg-none">
                        <img src="{{ asset('assets/img/logo.png') }}" alt="Logo IG Ubaya" style="width: 100px" />
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body ms-lg-auto d-flex flex-column h-100">
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle fw-bolder" href="#" data-bs-toggle="dropdown">Hi, Penpos Bahan Baku Import!</a>
                                <ul class="dropdown-menu">
                                    <li class="nav-item">
                                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-white">Keluar</a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Responsive Navbar -->
                <div class="navbar-other ms-lg-4">
                    <ul class="navbar-nav flex-row align-items-center ms-auto">
                        <li class="nav-item d-lg-none">
                            <button class="hamburger offcanvas-nav-btn"><span></span></button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    
    <!-- Main Section -->
    <main>
        <div class="container w-100 px-3 py-6">
            <div class="row">
                <div class="col-7">
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap" style="width: 100%">
                            <thead class="thead-dark"
                                style="table-layout: fixed; width: calc( 100% - 1em ); display: table;">
                                <tr>
                                    <th class="border-0 rounded-start text-center" style='width:10%'>No</th>
                                    <th class="border-0 text-center" style='width:35%'>Bahan Baku</th>
                                    <th class="border-0 text-center" style='width:30%'>Jumlah (paket)</th>
                                    <th class="border-0 rounded-end text-center" style='width:25%'>Harga /paket</th>
                                </tr>
                            </thead>
                            <tbody style="display: block; overflow-y: auto; height: 70vh;">
                                @php $index = 1 @endphp
                                @foreach($ingredients as $i)
                                <tr style='display: table; table-layout: fixed; width: 100%'>
                                    <input type="hidden" class="ingredient-id" value="{{ $i->id }}">
                                    <input type="hidden" class="import-price" id="import-price-{{ $i->id }}"
                                        value="{{ $i->import_price }}">

                                    <td class="text-center" style='width:10%'>{{ $index++ }}</td>
                                    <td class="text-center" style='width:35%' id="ingredient-name-{{ $i->id }}">{{ $i->name }}</td>
                                    <td class="text-center" style='width:30%'>
                                        <input type="number" style="margin: auto"
                                            class="form-control ingredient-amount w-50 text-center"
                                            id="ingredient-amount-{{ $i->id }}" value="0" min="0"
                                            onchange="updateIngredientPriceAndLimit()">
                                    </td>
                                    <td class="text-center" style='width:25%'>{{ $i->import_price }} TC</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-5 px-5 pt-5">
                    <label for="pilih-tim">Tim Peserta</label>
                    <select class="form-select w-100 m-0" id="pilih-tim" style="cursor: pointer" onchange="changeTeam()">
                        <option value="0" selected disabled>-- Pilih Tim --</option>
                        @foreach($teams as $team)
                            <option value="{{ $team->id }}">{{ $team->name }}</option>
                        @endforeach
                    </select>

                    <div class="row mt-4 row-cols-2">
                        <div class="col mb-4">
                            <div class="card shadow-none bg-sky">
                                <div class="card-body p-3 text-center">
                                    <div class="fw-bold">Limit</div>
                                    <span id="package-limit">-</span>
                                    <input type="hidden" id="package-limit-hidden" value="0">
                                </div>
                            </div>
                        </div>

                        <div class="col mb-4">
                            <div class="card shadow-none bg-ash">
                                <div class="card-body p-3 text-center">
                                    <div class="fw-bold">Total</div>
                                    <div id="total-ingredient">-</div>
                                </div>
                            </div>
                        </div>

                        <div class="col mb-4">
                            <div class="card shadow-none bg-blue">
                                <div class="card-body p-3 text-center">
                                    <div class="fw-bold">Ongkir</div>
                                    <div id="ongkir-ingredient">-</div>
                                    <input type="hidden" id="package-ongkir" value="{{ $ongkir }}">
                                </div>
                            </div>
                        </div>

                        <div class="col mb-4">
                            <div class="card shadow-none bg-navy">
                                <div class="card-body p-3 text-center">
                                    <div class="fw-bold">Subtotal</div>
                                    <div id="subtotal-ingredient">-</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mt-9">
                            <button class="btn btn-success fw-bold p-3 text-white w-100" style="font-size: 20px; font-weight: bold" onclick="buyIngredients()">Buy Ingredient</button>
                            <button class="btn btn-danger fw-bold p-3 text-white w-100 mt-4" style="font-size: 20px; font-weight: bold" onclick="clearMarket(true)">Clear Market</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="{{ asset('sandbox/js/plugins.js') }}"></script>
    <script src="{{ asset('sandbox/js/theme.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        // Update total bahan baku dan limit
        const updateIngredientPriceAndLimit = () => {
            if ($(`#pilih-tim`).val() == null) {
                Swal.fire({
                    icon: 'error',
                    text: 'Pilih tim dulu ya!',
                })
                $(`.ingredient-amount`).val(0)
                return
            }

            let ingredientId = $(`.ingredient-id`).map(function() { return $(this).val() }).get()
            let ingredientsAmount = $(`.ingredient-amount`).map(function() { return $(this).val() }).get()
            let ingredientsImportPrice = $(`.import-price`).map(function() { return $(this).val() }).get()

            // Update Total
            let totalPrice = 0
            for (let i = 0; i < ingredientsAmount.length; i++) {
                totalPrice += (ingredientsAmount[i] * ingredientsImportPrice[i])
            }

            // Get limit dan Ongkir
            let limit = parseInt($(`#package-limit-hidden`).val())
            let ongkir = parseInt($(`#package-ongkir`).val())
            
            // Get Amount Quantity
            let quantity = 0
            ingredientsAmount.forEach(amount => {
                quantity += parseInt(amount)
            })

            // Get Ongkir Additional
            let remaining = limit - quantity
            if (remaining < 0) { 
                remaining = 0
                ongkir += ((quantity-limit)*3)
            }
            if (quantity == 0) ongkir = 0

            $(`#total-ingredient`).text(`${totalPrice} TC`)
            $(`#package-limit`).text(remaining)
            $(`#ongkir-ingredient`).text(`${ongkir} TC`)
            $(`#subtotal-ingredient`).text(`${totalPrice+ongkir} TC`)
        }

        // Change Team
        const changeTeam = _ => {
            let teamId = $(`#pilih-tim`).val()

            $.ajax({
                type: 'POST',
                url: '{{ route("change-team") }}',
                data: {
                    '_token': '<?php echo csrf_token() ?>',
                    'teamId': teamId,
                },
                success: function(data) {
                    if (data.status == "success") {
                        $(`#package-limit-hidden`).val(data.limit)
                        $(`#package-limit`).text(data.limit)

                        Swal.fire({
                            icon: 'success',
                            text: data.message,
                        })

                        updateIngredientPriceAndLimit()
                    }
                },
                error: function(error) {
                    showError(error)
                }
            })
        }

        // Beli bahan baku
        const buyIngredients = () => {
            // Get value
            let ingredientId = $(`.ingredient-id`).map(function() { return $(this).val() }).get()
            let ingredientAmount = $(`.ingredient-amount`).map(function() { return $(this).val() }).get()
            let ingredientType = ingredientId.map(id => { return "import" })
            let teamId = $(`#pilih-tim`).val()

            // Pengecekan tim
            if (teamId == null) {
                Swal.fire({
                    icon: 'error',
                    text: 'Pilih tim dulu ya!',
                })
                return
            }

            // Pengecekan apakah ada yang dibeli
            if (ingredientAmount.reduce((acc, amount) => acc + amount, 0) == 0) {
                Swal.fire({
                    icon: 'error',
                    text: 'Tidak ada bahan baku yang dibeli',
                })
                return
            }
            
            // Generate pesan konfirmasi
            let pesanKonfirmasi = "Yakin membeli"
            ingredientId.forEach(id => {
                const amount = parseInt($(`#ingredient-amount-${id}`).val())
                const name = $(`#ingredient-name-${id}`).text()
                if (amount > 0) {
                    pesanKonfirmasi += ` ${amount} ${name},`
                }
            })

            Swal.fire({
                title: 'Konfirmasi pembelian',
                text: `${pesanKonfirmasi.slice(0, -1)}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Beli'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route("buy-ingredient") }}',
                        data: {
                            '_token': '<?php echo csrf_token() ?>',
                            'ingredient_id': ingredientId,
                            'ingredient_amount': ingredientAmount,
                            'ingredient_type': ingredientType,
                            'team_id': teamId
                        },
                        success: function(data) {
                            let icon = 'error'
                            if (data.status == "success") {
                                icon = 'success'
                                clearMarket(false)
                            }

                            Swal.fire({
                                icon: icon,
                                text: data.message,
                            })
                        },
                        error: function(error) {
                            showError(error)
                        }
                    })
                }
            })
        }

        // Clear Ingredient Market
        const clearMarket = status => {
            $(`.ingredient-amount`).val(0)
            $(`#total-ingredient`).text("-")
            $(`#ongkir-ingredient`).text("-")
            $(`#subtotal-ingredient`).text("-")
            $(`#package-limit-hidden`).val(0)
            $(`#package-limit`).text("-")
            $('#pilih-tim').prop('selectedIndex', 0);

            if (status) {
                Swal.fire({
                    icon: 'success',
                    text: 'Berhasil Clear Market!',
                })
            }
        }

        // Error message
        const showError = (error) => {
            let errorMessage = JSON.parse(error.responseText).message
            console.log(`Error: ${errorMessage}`)

            Swal.fire({
                icon: 'error',
                text: errorMessage,
            })
        }
    </script>
</body>

</html>