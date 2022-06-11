<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <title>Industrial Games 30</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="title" content="Industrial Games 30">
    <meta name="author" content="Themesberg">
    <meta name="description"
        content="Volt Pro is a Premium Bootstrap 5 Admin Dashboard featuring over 800 components, 10+ plugins and 20 example pages using Vanilla JS.">
    <meta name="keywords"
        content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, themesberg, themesberg dashboard, themesberg admin dashboard" />
    <link rel="canonical" href="https://themesberg.com/product/admin-dashboard/volt-premium-bootstrap-5-dashboard">

    <meta property="og:type" content="website">
    <meta property="og:url" content="https://demo.themesberg.com/volt-pro">
    <meta property="og:title" content="Volt - Free Bootstrap 5 Dashboard">
    <meta property="og:description"
        content="Volt Pro is a Premium Bootstrap 5 Admin Dashboard featuring over 800 components, 10+ plugins and 20 example pages using Vanilla JS.">
    <meta property="og:image"
        content="https://themesberg.s3.us-east-2.amazonaws.com/public/products/volt-pro-bootstrap-5-dashboard/volt-pro-preview.jpg">

    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://demo.themesberg.com/volt-pro">
    <meta property="twitter:title" content="Volt - Free Bootstrap 5 Dashboard">
    <meta property="twitter:description"
        content="Volt Pro is a Premium Bootstrap 5 Admin Dashboard featuring over 800 components, 10+ plugins and 20 example pages using Vanilla JS.">
    <meta property="twitter:image"
        content="https://themesberg.s3.us-east-2.amazonaws.com/public/products/volt-pro-bootstrap-5-dashboard/volt-pro-preview.jpg">

    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('') }}assets/icons/logo.png">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('') }}assets/icons/logo.png">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('') }}assets/icons/logo.png">
    <link rel="manifest" href="{{ asset('') }}assets/img/favicon/site.webmanifest">
    <link rel="mask-icon" href="{{ asset('') }}assets/img/favicon/safari-pinned-tab.svg" color="#ffffff">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">

    <link type="text/css" href="{{ asset('') }}vendor/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">
    <link type="text/css" href="{{ asset('') }}vendor/notyf/notyf.min.css" rel="stylesheet">
    <link type="text/css" href="{{ asset('') }}css/volt.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
    <main class="content contentBaru">
        <nav class="navbar navbar-top navbar-expand navbar-dashboard navbar-dark ps-0 pe-2 pb-0">
            <div class="container-fluid px-0">
                <div class="d-flex flex-row justify-content-between w-100" id="navbarSupportedContent">
                    {{-- SALDO --}}
                    <div class="navbar-nav align-items-center">
                        <div class="bg-white rounded shadow p-3 d-flex flex-row align-items-center">
                            <img src="{{ asset('') }}assets/icons/coin.png" height="20" alt="Coin">
                            <div class="ms-2">{{ $team->balance }} TC</div>
                        </div>
                    </div>

                    {{-- NAMA PERUSAHAAN --}}
                    <div class="bg-white rounded shadow p-3 ms-5 align-items-center">
                        <div class="fs-2 fw-bolder"> {{ $team->name }}</div>
                    </div>
                    <!-- Navbar links -->
                    <ul class="navbar-nav align-items-center">
                        <!-- BATCH  -->
                        <div class="bg-white rounded shadow p-3">
                            BATCH-{{ $batch }}
                        </div>

                        <!-- LOGOUT -->
                        <div class="bg-white rounded shadow p-3 ms-4">
                            <span class="h5 text-capitalize fw-bold" style="border-radius: 20px"><a
                                    href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                    class="text-light"> {{ __('Logout') }}</a></span>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf
                            </form>
                        </div>
                    </ul>

                </div>
            </div>
        </nav>

        <div class="d-flex flex-row justify-content-center">
            <!-- PROFIT -->
            <div class="p-5 w-25">
                <div class="card border-0 shadow ">
                    <div class="card-body ">
                        <div class="row d-block d-xl-flex align-items-center">
                            <div class="col-12">
                                <div class="d-flex d-sm-block">
                                    <h2 class="mb-0">Profit</h2>
                                    <h4 class="fw-extrabold text-success mb-2">+3,450 TC</h4>
                                </div>
                                <div class="d-flex mt-1">
                                    <div>Persentase <svg class="icon icon-xs text-success" fill="currentColor"
                                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"
                                                clip-rule="evenodd"></path>
                                        </svg><span class="text-success fw-bolder">22%</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PANGSA -->
            <div class="p-5" style="width: 30%">
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <div class="row d-block d-xl-flex align-items-center">
                            <div class="col-12 ">
                                <div class="d-flex d-sm-block">
                                    <h2 class="mb-0">Pangsa Pasar</h2>
                                    <h1 class="fw-extrabold text-success mb-2">+38%</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SIGMA -->
            <div class="p-5 w-25">
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <div class="row d-block d-xl-flex align-items-center">
                            <div class="col-12 col-xl-7">
                                <div class="d-flex d-sm-block">
                                    <h2 class="mb-0">Sigma</h2>
                                    <div class="d-flex">
                                        <h1 class="fw-extrabold fs-1 mb-2">Σ</h1>
                                        <h3 class="fs-1 mb-2">4.34</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex flex-row justify-content-center">
            <!-- PRODUKSI -->
            <div class="p-1 align-items-center">
                <!-- Button Modal Produksi -->
                <button type="button" class="btn btn-block btn-gray-800 m-2" data-bs-toggle="modal"
                    data-bs-target="#modalProduksi">Produksi</button>
                <!-- Modal Content Produksi -->
                <div class="modal fade p-5" id="modalProduksi" tabindex="-1" role="dialog"
                    aria-labelledby="modal-default" aria-hidden="true">
                    <div class="modal-dialog modal-fullscreen w-100" role="document">
                        <div class="modal-content rounded">
                            <div class="modal-header text-center">
                                <h5 class="modal-title w-100" id="modalProduksiLabel">PRODUKSI</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">No.</th>
                                            <th scope="col">Produk</th>
                                            <th scope="col">Bahan</th>
                                            <th scope="col">Mesin</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope='row'>1</th>
                                            <th>
                                                <select name='produk' id='produk'>
                                                    <option value='Keripik Apel'>Keripik Apel</option>
                                                    <option value='Dodol'>Dodol</option>
                                                    <option value='Sari Buah Apel'>Sari Buah Apel </option>
                                                </select>
                                            </th>
                                            <th>- 2 unit buah apel <br>
                                                - 2 unit air <br>
                                                - 1 unit minyak nabati
                                            </th>
                                            <th>
                                                <select name='fruitWasher' id='fruitWasher'>
                                                    <option value='' disabled selected hidden> --Pilih Fruit Washer--
                                                    </option>
                                                    <option value='Fruit Washer X'>Fruit Washer & Seed Remover X
                                                    </option>
                                                    <option value='Fruit Washer Y'>Fruit Washer & Seed Remover Y
                                                    </option>
                                                    <option value='Fruit Washer Z'>Fruit Washer & Seed Remover Z
                                                    </option>
                                                </select> <br>
                                                <select name='pealer' id='pealer'>
                                                    <option value='' disabled selected hidden> --Pilih Pealer--
                                                    </option>
                                                    <option value='Pealer X'>Pealer X</option>
                                                    <option value='Pealer Y'>Pealer Y</option>
                                                    <option value='Pealer Z'>Pealer Z</option>
                                                </select> <br>
                                                <select name='cuttingMachine' id='cuttingMachine'>
                                                    <option value='' disabled selected hidden> --Pilih Cutting Machine--
                                                    </option>
                                                    <option value='Cutting Machine X'>Cutting Machine X</option>
                                                    <option value='Cutting Machine Y'>Cutting Machine Y</option>
                                                    <option value='Cutting Machine Z'>Cutting Machine Z</option>
                                                </select> <br>
                                                <select name='deepFryer' id='deepFryer'>
                                                    <option value='' disabled selected hidden> --Pilih Deep Fryer--
                                                    </option>
                                                    <option value='Deep Fryer X'>Deep Fryer X</option>
                                                    <option value='Deep Fryer Y'>Deep Fryer Y</option>
                                                    <option value='Deep Fryer Z'>Deep Fryer Z</option>
                                                </select> <br>
                                                <select name='sealer' id='sealer'>
                                                    <option value='' disabled selected hidden> --Pilih Sealer--
                                                    </option>
                                                    <option value='Sealer X'>Sealer X</option>
                                                    <option value='Sealer Y'>Sealer Y</option>
                                                    <option value='Sealer Z'>Sealer Z</option>
                                                </select> <br>
                                            </th>
                                        </tr>
                                    </tbody>
                                </table>
                                <button id='btnAdd' class='btn btn-primary' style="float: left;">Tambah Produk</button>
                                <button id='btnProduksi' class='btn btn-success' style="float: right;">Mulai
                                    Produksi</button>

                                <!-- <script>
                                            $("#btnAdd").click(function(){
                                                $("tbody").append();
                                            });
                                    </script> -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End of Modal Content -->
            </div>

            <!-- INVENTORY -->
            <div class="p-1 align-items-center">
                <!-- Button Modal -->
                <button type="button" class="btn btn-block btn-gray-800 m-2" data-bs-toggle="modal"
                    data-bs-target="#modalInventory">Inventory</button>
                <!-- Modal Content -->

                {{-- MODAL INVENTORY --}}
                <div class="modal fade p-5" id="modalInventory" aria-hidden="true" aria-labelledby="modalInventoryLabel"
                    tabindex="-1">
                    <div class="modal-dialog modal-fullscreen w-100">
                        <div class="modal-content rounded">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalToggleLabel2">Inventory</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    {{-- BAHAN BAKU --}}
                                    <div class="col-4">
                                        <div class="bg-info rounded">
                                            <h3 class="text-center text-gray-100">BAHAN BAKU</h3>
                                        </div>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="border-0 text-center">No.</th>
                                                    <th scope="col" class="border-0 text-center">Nama Bahan</th>
                                                    <th scope="col" class="border-0 text-center">Jumlah</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $i = 1
                                                @endphp
                                                @foreach ($team->ingredients as $ingre)
                                                <tr>
                                                    <td class="border-0 text-center align-middle">{{ $i++ }}</td>
                                                    <td class="border-0 text-center align-middle">{{ $ingre->name }}
                                                    </td>
                                                    <td class="border-0 text-center align-middle">
                                                        {{ $ingre->pivot->amount}}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    {{-- MESIN --}}
                                    <div class="col-4">
                                        <div class="bg-info rounded">
                                            <h3 class="text-center text-gray-100">MESIN</h3>
                                        </div>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="border-0 text-center">No.</th>
                                                    <th scope="col" class="border-0 text-center">Nama Mesin</th>
                                                    <th scope="col" class="border-0 text-center">Defect</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    @php
                                                    $i = 1
                                                    @endphp
                                                    @foreach ($team->machineTypes as $machine)
                                                <tr>
                                                    <td class="border-0 text-center align-middle">{{ $i++ }}</td>
                                                    <td class="border-0 text-center align-middle">
                                                        {{ $machine->name_type }}</td>
                                                    <td class="border-0 text-center align-middle">
                                                        {{ $machine->pivot->defact*100}}%</td>
                                                    <td class="border-0 text-center align-middle">
                                                        <button type="button" class="btn btn-danger"
                                                            data-bs-target="#modalJualMesin" data-bs-toggle="modal"
                                                            )>Jual</button>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    {{-- PRODUK --}}
                                    <div class="col-4">
                                        <div class="bg-info rounded">
                                            <h3 class="text-center text-gray-100">PRODUK</h3>
                                        </div>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="border-0 text-center">No.</th>
                                                    <th scope="col" class="border-0 text-center">Nama Produk</th>
                                                    <th scope="col" class="border-0 text-center">Jumlah</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $i = 1
                                                @endphp
                                                @foreach ($team->products as $product)
                                                <tr>
                                                    <td class="border-0 text-center align-middle">{{ $i++ }}</td>
                                                    <td class="border-0 text-center align-middle">{{ $product->name }}
                                                    </td>
                                                    <td class="border-0 text-center align-middle">
                                                        {{ $product->pivot->amount}}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- JUAL MESIN --}}
                <div class="modal fade" id="modalJualMesin" aria-hidden="true" aria-labelledby="modalJualMesinLabel"
                    tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalJualMesinToggleLabel2">Jual</h5>
                                <button type="button" class="btn-close" data-bs-toggle="modal"
                                    data-bs-target="#modalInventory" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Nama Mesin : <span id="">Pickup<span></p>
                                <p>Harga Jual : 2.500 TC</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#modalInventory">Jual Mesin</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End of Modal Content -->
            </div>

            <!-- MARKET -->
            <div class="p-1 align-items-center">
                <!-- Button Modal -->
                <button type="button" class="btn btn-block btn-gray-800 m-2" data-bs-toggle="modal"
                    data-bs-target="#modalMarketMenu">Market</button>
                <!-- Modal Content -->

                {{-- MODAL MARKET --}}
                <div class="modal fade" id="modalMarketMenu" aria-hidden="true" aria-labelledby="modalMarketMenu"
                    tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header text-center">
                                <h5 class="modal-title w-100" id="marketPlaceLabel">Market</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="text-center">
                                    <button class="btn btn-primary" data-bs-target="#modalBahanBaku"
                                        data-bs-toggle="modal">Bahan Baku</button>
                                    <button class="btn btn-primary" data-bs-target="#modalMachine"
                                        data-bs-toggle="modal">Machine</button>
                                    <button class="btn btn-primary" data-bs-target="#modalMarketTransport"
                                        data-bs-toggle="modal">Transport</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- MODAL MARKET BAHAN BAKU --}}
                <div class="modal fade p-5" id="modalBahanBaku" aria-hidden="true" aria-labelledby="modalBahanBaku"
                    tabindex="-1">
                    <div class="modal-dialog modal-fullscreen" style="margin: auto; width: 60%">
                        <div class="modal-content rounded">
                            <div
                                class="modal-header d-flex align-items-center justify-content-center position-relative">
                                <div>
                                    <h5 class="modal-title text-center fw-bolder">Bahan Baku</h5>
                                </div>

                                <button type="button" class="btn-close position-absolute" data-bs-dismiss="modal"
                                    aria-label="Close" style="right: 20px"></button>
                            </div>
                            <div class="modal-body px-5 py-4">
                                <div class="row">
                                    <div class="col-7">
                                        <div class="table-responsive">
                                            <table class="table table-centered table-nowrap" style="width: 100%">
                                                <thead class="thead-dark"
                                                    style="table-layout: fixed; width: calc( 100% - 1em ); display: table;">
                                                    <tr>
                                                        <th class="border-0 rounded-start text-center"
                                                            style='width:10%'>No</th>
                                                        <th class="border-0 text-center" style='width:40%'>Bahan Baku
                                                        </th>
                                                        <th class="border-0 rounded-end text-center" style='width:50%'>
                                                            Jumlah</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="border-0"
                                                    style="display: block; overflow-y: auto; height: 70vh;">
                                                    @foreach($ingredient as $i)
                                                    <tr style='display: table; table-layout: fixed; width: 100%'>
                                                        <td class="border-0 text-center" style='width:10%'>
                                                            {{ $i->id }}
                                                            <input type="hidden" class="ingredient-id"
                                                                value="{{ $i->id }}">
                                                        </td>
                                                        <td class="border-0 text-center" style='width:40%'>
                                                            {{ $i->name }}</td>
                                                        <td class="border-0 text-center text-danger" style='width:50%'>
                                                            <input type="number" style="margin: auto"
                                                                class="form-control ingredient-amount w-50 text-center"
                                                                id="ingredient-amount-{{ $i->id }}" value="0" min="0"
                                                                onchange="updateIngredientPriceAndLimit()">
                                                        </td>
                                                        <input type="hidden" class="ingredient-price"
                                                            id="ingredient-price-{{ $i->id }}" value="{{ $i->price }}">
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-5 px-5">
                                        <!-- Package Limit -->
                                        <div class="row mt-3">
                                            <div class="col-6 bg-info text-white text-center fw-bold p-3 rounded-start">
                                                Limit
                                            </div>
                                            <div class="col-6 bg-primary text-white text-center fw-bold p-3 rounded-end">
                                                <span id="package-limit">{{ $limit }}</span>
                                                <input type="hidden" id="package-limit-hidden" value="{{ $limit }}">
                                            </div>
                                        </div>

                                        <!-- Total Pengeluaran -->
                                        <div class="row mt-3">
                                            <div class="col-6 bg-info text-white text-center fw-bold p-3 rounded-start">
                                                Pengeluaran
                                            </div>
                                            <div class="col-6 bg-primary text-white text-center fw-bold p-3 rounded-end"
                                                id="pengeluaran-ingredient">
                                                0 TC
                                            </div>
                                        </div>

                                        <!-- Buy Button -->
                                        <div class="row mt-4">
                                            <button class="btn btn-success fw-bold p-3 text-white"
                                                style="font-size: 20px; font-weight: bold"
                                                onclick="buyIngredients()">Buy</button>
                                            <!-- <button class="btn btn-success fw-bold p-3 text-white" data-bs-toggle="modal"
                                                data-bs-target="#modalBeliBahanBaku" style="font-size: 20px; font-weight: bold">Buy</button> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- MODAL BUY CONFIRMATION BAHAN BAKU --}}
                <div class="modal fade" id="modalBeliBahanBaku" aria-hidden="true" aria-labelledby="modalBeliBahanBaku"
                    tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalToggleLabel2">Apakah yakin ingin membeli ?</h5>
                                <button type="button" class="btn-close" data-bs-toggle="modal"
                                    data-bs-target="#modalMarketTransport"></button>
                            </div>

                            <div class="modal-body">
                                <p>Harga Total : <span id="buy-transport-price">2500 TC</span></p>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" onclick="buyIngredients()"
                                    data-bs-toggle="modal" data-bs-target="#modalMarketMenu">Beli</button>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#modalBahanBaku">Batal</button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- MODAL MARKET MACHINE --}}
                <div class="modal fade p-5" id="modalMachine" aria-hidden="true" aria-labelledby="modalMachineLabel"
                    tabindex="-1">
                    <div class="modal-dialog modal-fullscreen" style="margin: auto; width: 60%">
                        <div class="modal-content rounded">
                            <div
                                class="modal-header d-flex align-items-center justify-content-center position-relative">
                                <div>
                                    <h5 class="modal-title text-center fw-bolder">Mesin</h5>
                                </div>

                                <button type="button" class="btn-close position-absolute" data-bs-dismiss="modal"
                                    aria-label="Close" style="right: 20px"></button>
                            </div>
                            <div class="modal-body px-5 py-4">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="table-responsive">
                                            <table class="table table-centered table-wrap">
                                                <thead>
                                                    <tr>
                                                        <th class="border-0 text-center">No</th>
                                                        <th class="border-0 text-center">Mesin</th>
                                                        <th class="border-0 text-center">Jumlah</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($machines as $machine)
                                                    <tr>
                                                        <td class="border-0 text-center align-middle">{{ $machine->id }}
                                                        </td>
                                                        <td class="border-0 text-center align-middle">
                                                            {{ $machine->name_type }}</td>
                                                        <td class="border-0 text-center align-middle">
                                                            <input type="number" style="margin: auto"
                                                                class="form-control machine-amount w-50 text-center"
                                                                id="machine-amount-{{ $machine->id }}" value="0" min="0"
                                                                onchange="updateMachinePrice()">
                                                        </td>
                                                        <input type="hidden" class="machine-price"
                                                            id="machine-price-{{ $machine->id }}"
                                                            value="{{ $machine->price }}">
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-4 px-4 py-4">
                                        <!-- Total Pengeluaran -->
                                        <div class="row position-fixed" style="width:160px;">
                                            <div class="col-12 bg-info rounded-top text-white text-center fw-bold ">
                                                Pengeluaran
                                            </div>
                                            <div class="col-12 bg-primary rounded-bottom text-white text-center"
                                                id="pengeluaran-machine">
                                                0 TC
                                            </div>
                                        </div>

                                        <!-- Buy Button -->
                                        <div class="row mt-5 pt-3 position-fixed" style="width:160px;">
                                            <button class="btn btn-success fw-bold p-3 text-white"
                                                style="font-size: 20px; font-weight: bold"
                                                onclick="buyMachines()">Buy</button>
                                            <!-- <button class="col-12 btn btn-success fw-bold p-3 text-white" data-bs-toggle="modal"
                                                data-bs-target="#modalBeliMachine" style="font-size: 20px; font-weight: bold">Buy</button> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- MODAL BUY CONFIRMATION MACHINE --}}
                <div class="modal fade" id="modalBeliMachine" aria-hidden="true" aria-labelledby="modalBeliMachine"
                    tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalToggleLabel2">Apakah yakin ingin membeli ?</h5>
                                <button type="button" class="btn-close" data-bs-toggle="modal"
                                    data-bs-target="#modalMachine"></button>
                            </div>

                            <div class="modal-body">
                                <p>Harga Total : <span id="buy-machine-price">2500 TC</span></p>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                    data-bs-target="#modalMarketMenu" onclick="buyMachines()">Beli</button>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#modalMachine">Batal</button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- MODAL MARKET TRANSPORTATION --}}
                <div class="modal fade p-5" id="modalMarketTransport" aria-hidden="true"
                    aria-labelledby="modalMarketTransportLabel" tabindex="-1">
                    <div class="modal-dialog modal-fullscreen" style="margin: auto; width: 60%">
                        <div class="modal-content rounded">
                            <div
                                class="modal-header d-flex align-items-center justify-content-center position-relative">
                                <div>
                                    <h5 class="modal-title text-center fw-bolder">Transportation</h5>
                                </div>

                                <button type="button" class="btn-close position-absolute" data-bs-dismiss="modal"
                                    aria-label="Close" style="right: 20px"></button>
                            </div>
                            <div class="modal-body px-5 py-4">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="table-responsive">
                                            <table class="table table-centered table-wrap">
                                                <thead>
                                                    <tr>
                                                        <th class="border-0 rounded-start text-center">No</th>
                                                        <th class="border-0 text-center">Kendaraan</th>
                                                        <th class="border-0 rounded-end text-center">Jumlah</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($transportations as $transportation)
                                                    <tr>
                                                        <td class="border-0 text-center">{{ $transportation->id }}</td>
                                                        <td class="border-0 text-center">{{ $transportation->name }}
                                                        </td>
                                                        <td class="border-0 text-center text-danger">
                                                            <input type="number" style="margin: auto"
                                                                class="form-control transportation-amount w-50 text-center"
                                                                id="transportation-amount-{{ $transportation->id }}"
                                                                value="0" min="0"
                                                                onchange="updateTransportationPrice()">
                                                        </td>
                                                        <input type="hidden" class="transportation-price"
                                                            id="transportation-price-{{ $transportation->id }}"
                                                            value="{{ $transportation->price }}">

                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-4 px-4 py-4">
                                        <!-- Total Pengeluaran -->
                                        <div class="row position-fixed" style="width:160px;">
                                            <div class="col-12 bg-primary rounded-top text-white text-center fw-bold ">
                                                Pengeluaran
                                            </div>
                                            <div class="col-12 bg-info rounded-bottom text-white text-center fw-bold " ,
                                                id="pengeluaran-transportation">
                                                0 TC
                                            </div>
                                        </div>

                                        <!-- Buy Button -->
                                        <div class="row mt-5 pt-2 position-fixed" style="width:160px;">
                                            <button class="btn btn-success fw-bold p-3 text-white"
                                                style="font-size: 20px; font-weight: bold"
                                                onclick="buyTransportations()">Buy</button>
                                            <!-- <button class="col-12 btn btn-success fw-bold p-3 text-white" data-bs-toggle="modal"
                                                data-bs-target="#modalBeliTransport"style="font-size: 20px; font-weight: bold">Buy</button> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- MODAL BUY CONFIRMATION TRANSPORTATION --}}
                <div class="modal fade" id="modalBeliTransport" aria-hidden="true" aria-labelledby="modalBeliTransport"
                    tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalToggleLabel2">Apakah yakin ingin membeli ?</h5>
                                <button type="button" class="btn-close" data-bs-toggle="modal"
                                    data-bs-target="#modalMarketTransport"></button>
                            </div>

                            <div class="modal-body">
                                <p>Harga Total : <span id="buy-transport-price">2500 TC</span></p>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                    data-bs-target="#modalMarketMenu" onclick="buyTransportations()">Beli</button>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#modalMarketTransport">Batal</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TRANSPORTATION -->
            <div class="p-1 align-items-center">
                <!-- Button Modal -->
                <button type="button" class="btn btn-block btn-primary m-2" data-bs-toggle="modal"
                    data-bs-target="#modalTransport">Transportation</button>
                <!-- Modal Content -->

                <!-- MODAL TRANSPORTATION -->
                <div class="modal fade p-5" id="modalTransport" aria-hidden="true" aria-labelledby="modalTransportLabel"
                    tabindex="-1">
                    <div class="modal-dialog modal-fullscreen w-100">
                        <div class="modal-content rounded">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalToggleLabel2">Transportation</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="border-0 text-center">No</th>
                                            <th class="border-0 text-center">Jenis</th>
                                            <th class="border-0 text-center">Kapasitas</th>
                                            <th class="border-0 text-center">Durasi</th>
                                            <th class="border-0 text-center">Masa Pakai</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $i = 1
                                        @endphp
                                        @foreach ($team->transportations as $transportation)
                                        @if($transportation->pivot->exist)
                                        <tr>
                                            <td class="border-0 text-center align-middle">{{ $i++ }}</td>
                                            <td class="border-0 text-center align-middle">{{ $transportation->name }}
                                            </td>
                                            <td class="border-0 text-center align-middle">
                                                {{ $transportation->capacity }}</td>
                                            <td class="border-0 text-center align-middle">
                                                {{ $transportation->duration }}</td>
                                            <td class="border-0 text-center align-middle">
                                                {{ $batch -$transportation->pivot->batch  +1}}</td>

                                            <td class="border-0 text-center align-middle">
                                                <button type="button" class="btn btn-danger"
                                                    data-bs-target="#modalJualTransport" data-bs-toggle="modal"
                                                    onclick="showTransportSell({{ $transportation->pivot->id }})">Jual</button>
                                            </td>
                                        </tr>
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- MODAL JUAL TRANSPORTATION -->
                <div class="modal fade" id="modalJualTransport" aria-hidden="true"
                    aria-labelledby="modalJualTransportLabel" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalToggleLabel2">Jual</h5>
                                <button type="button" class="btn-close" data-bs-toggle="modal"
                                    data-bs-target="#modalTransport"></button>
                            </div>

                            <div class="modal-body">
                                <p><input type="hidden" id="sell-transport-id" value=""></p>
                                <p>Nama Transportasi : <span id="sell-transport-name"></span></p>
                                <p>Masa Pakai : <span id="sell-transport-lifetime"></span></p>
                                <p>Harga Jual : <span id="sell-transport-price"></span></p>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#modalTransport" onclick="sellTransportations()">Jual
                                    Transoprtasi</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- INPUT TC -->
            <div class="p-1  align-items-center">
                <!-- Button Modal -->
                <button type="button" class="btn btn-block btn-primary m-2" data-bs-toggle="modal"
                    data-bs-target="#modalTambahTC">Tambah TC</button>
                <!-- Modal Content -->
                <div class="modal fade" id="modalTambahTC" aria-hidden="true" aria-labelledby="modalTambahTCLabel"
                    tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalToggleLabel2">Tambah Tiggie Coin</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="batch" class="col-form-label">Batch</label>
                                    <input type="number" class="form-control w-25 mb-2" id="batch">

                                    <label for="jumlah-tc" class="col-form-label">Jumlah TC</label>
                                    <div class="d-flex flex-row">
                                        <input type="number" class="form-control w-50" id="jumlah-tc">
                                        <button type="button" class="btn btn-success w-25 ms-2"
                                            id="btnTambahTC">Tambah</button>
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
        </div>
    </main>

    <script src="{{ asset('') }}vendor/@popperjs/core/dist/umd/popper.min.js"></script>
    <script src="{{ asset('') }}vendor/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="{{ asset('') }}vendor/onscreen/dist/on-screen.umd.min.js"></script>
    <script src="{{ asset('') }}vendor/nouislider/distribute/nouislider.min.js"></script>
    <script src="{{ asset('') }}vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js"></script>
    <script src="{{ asset('') }}vendor/chartist/dist/chartist.min.js"></script>
    <script src="{{ asset('') }}vendor/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>
    <script src="{{ asset('') }}vendor/vanillajs-datepicker/dist/js/datepicker.min.js"></script>
    <script src="{{ asset('') }}vendor/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"></script>
    <script src="{{ asset('') }}vendor/vanillajs-datepicker/dist/js/datepicker.min.js"></script>
    <script src="{{ asset('') }}vendor/notyf/notyf.min.js"></script>
    <script src="{{ asset('') }}vendor/simplebar/dist/simplebar.min.js"></script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script src="{{ asset('assets/js/update') }}assets/js/volt.js"></script>

    <script type="text/javascript">
    // Update total bahan baku dan limit
    const updateIngredientPriceAndLimit = () => {
        let ingredientsAmount = $(`.ingredient-amount`).map(function() {
            return $(this).val()
        }).get()
        let ingredientsPrice = $(`.ingredient-price`).map(function() {
            return $(this).val()
        }).get()

        // Update total price
        let totalPrice = 0
        for (let i = 0; i < ingredientsAmount.length; i++) {
            totalPrice += (ingredientsAmount[i] * ingredientsPrice[i])
        }
        $(`#pengeluaran-ingredient`).text(`${totalPrice} TC`)

        // Update limit
        let limit = $(`#package-limit-hidden`).val()
        let quantity = 0
        ingredientsAmount.forEach(amount => {
            quantity += parseInt(amount)
        })
        let remaining = limit - quantity
        if (remaining < 0) remaining = 0

        $(`#package-limit`).text(remaining)
    }

    // Beli bahan baku
    const buyIngredients = () => {
        if (!confirm("Are you sure?")) return

        let ingredientId = $(`.ingredient-id`).map(function() {
            return $(this).val()
        }).get()
        let ingredientAmount = $(`.ingredient-amount`).map(function() {
            return $(this).val()
        }).get()

        $.ajax({
            type: 'POST',
            url: '{{ route("buy-ingredient") }}',
            data: {
                '_token': '<?php echo csrf_token() ?>',
                'ingredient_id': ingredientId,
                'ingredient_amount': ingredientAmount
            },
            success: function(data) {
                if (data.status == "success") {
                    $(`.ingredient-amount`).val(0)
                    $(`#pengeluaran-ingredient`).text("0 TC")
                    $(`#package-limit-hidden`).val(data.limit)
                    $(`#package-limit`).text(data.limit)
                }

                alert(data.message)
            }
        })
    }

    // Update total machine price
    const updateMachinePrice = () => {
        let machinesAmount = $('.machine-amount').map(function() {
            return $(this).val()
        }).get()
        let machinesPrice = $('.machine-price').map(function() {
            return $(this).val()
        }).get()

        let totalPrice = 0
        for (let i = 0; i < machinesAmount.length; i++) {
            totalPrice += (machinesAmount[i] * machinesPrice[i])
        }

        $('#pengeluaran-machine').text(totalPrice + " TC")
    }

    // Method buy machine
    const buyMachines = () => {
        let machineId = $(`.machine-id`).map(function() {
            return $(this).val()
        }).get()

        $.ajax({
            type: 'POST',
            url: '{{ route("buy-machine") }}',
            data: {
                '_token': '<?php echo csrf_token() ?>',
                'machine_id': machineId,
                'machine_amount': machineAmount
            },
            success: function(data) {
                alert(data.message)
            }
        })
    }

    // Update total transportation price
    const updateTransportationPrice = () => {
        let transportationsAmount = $('.transportation-amount').map(function() {
            return $(this).val()
        }).get()
        let transportationsPrice = $('.transportation-price').map(function() {
            return $(this).val()
        }).get()

        let totalPrice = 0
        for (let i = 0; i < transportationsAmount.length; i++) {
            totalPrice += (transportationsAmount[i] * transportationsPrice[i])
        }

        $('#pengeluaran-transportation').text(totalPrice + " TC")
    }

    // Method buy transportation
    const buyTransportations = () => {
        if (!confirm("Are you sure?")) return

        let transportationId = $(`.transportation-id`).map(function() {
            return $(this).val()
        }).get()

        $.ajax({
            type: 'POST',
            url: '{{ route("buy-transportation") }}',
            data: {
                '_token': '<?php echo csrf_token() ?>',
                'transportation_id': transportationId,
                'transportation_amount': transportationAmount
            },
            success: function(data) {
                alert(data.message)
            }
        })
    }

    // showTransportSell
    const showTransportSell = (id) => {

        $.ajax({
            type: 'POST',
            url: '{{ route("transportation.getbyid") }}',
            data: {
                '_token': '<?php echo csrf_token() ?>',
                'id': id
            },
            success: function(data) {
                $(`#sell-transport-name`).text(data.nama)
                $(`#sell-transport-lifetime`).text(data.lifetime + " Batch")
                $(`#sell-transport-price`).text(data.price + " TC")
                $(`#sell-transport-id`).val(data.id)
            },
            error: function(error) {
                console.log(error)
            }
        })
    }

    const sellTransportations = () => {
        let id = $(`#sell-transport-id`).val()

        $.ajax({
            type: 'POST',
            url: '{{ route("transportation.sell") }}',
            data: {
                '_token': '<?php echo csrf_token() ?>',
                'id': id
            },
            success: function(data) {
                alert(data.message)
            },
            error: function(error) {
                console.log(error)
            }
        })
    }
    </script>
</body>

</html>