<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bahan Baku Import</title>
    <link rel="stylesheet" href="{{ asset('sandbox/css/plugins.css') }}">
    <link rel="stylesheet" href="{{ asset('sandbox/css/style.css') }}">
    <link rel="preload" href="./assets/css/fonts/urbanist.css" as="style" onload="this.rel='stylesheet'">
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
                                    <th class="border-0 text-center" style='width:30%'>Jumlah</th>
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
                                    <td class="text-center" style='width:35%'>{{ $i->name }}</td>
                                    <td class="text-center" style='width:30%'>
                                        <input type="number" style="margin: auto"
                                            class="form-control ingredient-amount w-50 text-center"
                                            id="ingredient-amount-{{ $i->id }}" value="0" min="0"
                                            onchange="updateIngredientPriceAndLimit()">
                                    </td>
                                    <td class="text-center" style='width:25%'>{{ $i->price }} TC</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-5 px-5 pt-5">
                    <label for="pilih-tim">Tim Peserta</label>
                    <select class="form-select w-100 m-0" id="pilih-tim" style="cursor: pointer">
                        <option value="0" selected disabled>-- Pilih Tim --</option>
                        @foreach($teams as $team)
                            <option value="{{ $team->id }}">{{ $team->name }}</option>
                        @endforeach
                    </select>

                    <div class="row mt-4 row-cols-2">
                        <div class="col mb-4">
                            <div class="card shadow-none bg-orange">
                                <div class="card-body p-3 text-center">
                                    <div class="fw-bold">Limit</div>
                                    <span id="package-limit">-</span>
                                    <input type="hidden" id="package-limit-hidden" value="0">
                                </div>
                            </div>
                        </div>

                        <div class="col mb-4">
                            <div class="card shadow-none bg-pink">
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

                        <div class="col-12">
                            <button class="btn btn-success fw-bold p-3 text-white w-100" style="font-size: 20px; font-weight: bold" onclick="buyIngredients()">Buy Ingredient</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="{{ asset('sandbox/js/plugins.js') }}"></script>
    <script src="{{ asset('sandbox/js/theme.js') }}"></script>
    <script type="text/javascript">
        // Update total bahan baku dan limit
        const updateIngredientPriceAndLimit = () => {
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
    </script>
</body>

</html>