<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <title>Volt - Free Bootstrap 5 Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="title" content="Volt - Free Bootstrap 5 Dashboard">
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

    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('') }}assets/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('') }}assets/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('') }}assets/img/favicon/favicon-16x16.png">
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
                <div class="d-flex justify-content-between w-100" id="navbarSupportedContent">
                    {{-- SALDO --}}
                    <div class="bg-white rounded shadow p-3 d-flex align-items-center">
                        <img src="{{ asset('') }}assets/icon/coin.png" height="20" alt="Coin">
                        <div>{{ $team->balance }} TC</div>
                    </div>
                    {{-- NAMA PERUSAHAAN --}}
                    <div class="bg-white rounded shadow p-3 align-items-center">
                        <div> {{ $team->name }}</div>
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

        <div class="row mt-4">
            <!-- PROFIT -->
            <div class="col-12 col-sm-3 col-xl-3  mb-4 ">
                <div class="card border-0 shadow ">
                    <div class="card-body ">
                        <div class="row d-block d-xl-flex align-items-center">
                            <div class="col-12 col-xl-7">
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
            <div class="col-12 col-sm-3 col-xl-4 mb-4">
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <div class="row d-block d-xl-flex align-items-center">
                            <div class="col-12 col-xl-7">
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
            <div class="col-12 col-sm-3 col-xl-3  mb-4">
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

        <div class="row d-flex justify-content-center">
            {{-- <div class="col-12 col-md-4 col-xl-6 mb-4 mb-md-0">
            <p class="mb-0 text-center text-lg-start">© 2019-<span class="current-year"></span> <a class="text-primary fw-normal" href="https://themesberg.com" target="_blank">Themesberg</a></p>
        </div>
        
        <div class="col-12 col-md-8 col-xl-6 text-center text-lg-start">
            <!-- List -->
            <ul class="list-inline list-group-flush list-group-borderless text-md-end mb-0">
                <li class="list-inline-item px-0 px-sm-2">
                    <a href="https://themesberg.com/about">About</a>
                </li>
                <li class="list-inline-item px-0 px-sm-2">
                    <a href="https://themesberg.com/themes">Themes</a>
                </li>
                <li class="list-inline-item px-0 px-sm-2">
                    <a href="https://themesberg.com/blog">Blog</a>
                </li>
                <li class="list-inline-item px-0 px-sm-2">
                    <a href="https://themesberg.com/contact">Contact</a>
                </li>
            </ul>
        </div> --}}

            <!-- PRODUKSI -->
            <div class="col-lg-1 align-items-center">
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


            <div class="col-lg-1 align-items-center">
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
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End of Modal Content -->
            </div>

            <!-- MARKET -->
            <div class="col-lg-1 align-items-center">
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
                                    <button class="btn btn-primary" data-bs-target="#modalTransport"
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
                                            <table class="table table-centered table-wrap">
                                                <thead>
                                                    <tr>
                                                        <th class="border-0 rouded-start text-center">No</th>
                                                        <th class="border-0 text-center">Bahan Baku</th>
                                                        <th class="border-0 rounded-end text-center">Jumlah</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($ingredient as $i)
                                                    <tr>
                                                        <td class="border-0 text-center">
                                                            {{ $i->id }}
                                                            <input type="hidden" class="ingredient-id" value="{{ $i->id }}">
                                                        </td>
                                                        <td class="border-0 text-center">{{ $i->name }}</td>
                                                        <td class="border-0 text-center text-danger">
                                                            <input type="number" style="margin: auto"
                                                                class="form-control ingredient-amount w-50 text-center"
                                                                id="ingredient-amount-{{ $i->id }}" value="0" min="0" onchange="updateIngredientPriceAndLimit()">
                                                        </td>
                                                        <td>
                                                            <input type="hidden" class="ingredient-price" id="ingredient-price-{{ $i->id }}" value="{{ $i->price }}">
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-5 px-5 py-4">
                                        <!-- Package Limit -->
                                        <div class="row w-100">
                                            <div class="col-7 p-3 bg-primary rounded-start text-white text-center fw-bold">
                                                Limit
                                            </div>
                                            <div class="col-5 p-3 bg-info rounded-end text-white text-center fw-bold">
                                                <span id="package-limit">50</span>
                                                <input type="hidden" id="package-limit-hidden" value="50">
                                            </div>
                                        </div>

                                        <!-- Total Pengeluaran -->
                                        <div class="row w-100 mt-4">
                                            <div class="col-7 p-3 bg-primary rounded-start text-white text-center fw-bold">
                                                Pengeluaran
                                            </div>
                                            <div class="col-5 p-3 bg-info rounded-end text-white text-center fw-bold" id="pengeluaran-ingredient">
                                                0
                                            </div>
                                        </div>

                                        <!-- Buy Button -->
                                        <div class="row w-100 mt-5 pt-2">
                                            <buton class="btn btn-success fw-bold p-3 text-white" onclick="buyIngredients()" style="font-size: 20px; font-weight: bold">Buy</button>
                                        </div>
                                    </div>
                                </div>
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
                                                        <th class="border-0 rouded-start text-center">No</th>
                                                        <th class="border-0 text-center">Mesin</th>
                                                        <th class="border-0 rounded-end text-center">Jumlah</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($machines as $machine)
                                                    <tr>
                                                        <td class="border-0 text-center">{{ $machine->id }}</td>
                                                        <td class="border-0 text-center">{{ $machine->name_type }}</td>
                                                        <td class="border-0 text-center text-danger">
                                                            <input type="number" style="margin: auto"
                                                                class="form-control machine-amount w-60 text-center"
                                                                id="machine-amount-{{ $machine->id }}" value="0" min="0" onchange="updateMachinePrice()">
                                                        </td>
                                                        <td></td>
                                                            <input type="hidden"  class="machine-price" id="machine-price-{{ $machine->id }}" value="{{ $machine->price }}">
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-4 px-4 py-4">
                                        <!-- Total Pengeluaran -->
                                        <div class="row position-fixed"></div>
                                            <div class="col-12 bg-primary rounded-top text-white text-center fw-bold ">
                                                Pengeluaran
                                            </div>
                                            <div class="col-12 bg-info rounded-bottom text-white text-center fw-bold ", id="pengeluaran-machine">
                                                0
                                            </div>
                                        </div>

                                        <!-- Buy Button -->
                                        <div class="row mt-5 pt-2 position-fixed" style="width:160px;">
                                            <buton class="col-12 btn btn-success fw-bold p-3 text-white" style="font-size: 20px; font-weight: bold">Buy</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>

                {{-- MODAL MARKET TRANSPORT --}}
                <div class="modal fade p-5" id="modalTransport" aria-hidden="true" aria-labelledby="modalTransportLabel"
                    tabindex="-1">
                    <div class="modal-dialog modal-fullscreen w-100">
                        <div class="modal-content rounded">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalToggleLabel2">Transport</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Jenis</th>
                                            <th scope="col">Kapaistas</th>
                                            <th scope="col">Durasi</th>
                                            <th scope="col">Masa Pakai</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($team->transportations as $transportation)
                                        <tr>
                                            <td></td>
                                            <td>{{ $transportation->name }}</td>
                                            <td>{{ $transportation->capacity }}</td>
                                            <td>{{ $transportation->duration }}</td>
                                            <td>{{ $batch -$transportation->pivot->batch  +1}}</td>
                                        </tr>
                                        @endforeach
                                </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary" data-bs-target="#modalMarketMenu"
                                    data-bs-toggle="modal">Kembali</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End of Modal Content -->
            </div>

            {{-- MODAL  INPUT TC --}}
            <div class="col-lg-1  align-items-right">
                <!-- Button Modal -->
                <button type="button" class="btn btn-block btn-warning m-2" data-bs-toggle="modal"
                    data-bs-target="#modalTambahTC">Tambah TC</button>
                <!-- Modal Content -->
                <div class="modal fade" id="modalTambahTC" aria-hidden="true"
                    aria-labelledby="modalTambahTCLabel" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalToggleLabel2">Tambah Tiggie Coin</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="number" id="inputTC">
                                <button type="button" id="btnTambahTC">Tambah</button>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End of Modal Content -->
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
    <script src="{{ asset('') }}assets/js/volt.js"></script>

    <script type="text/javascript">
        // Update total ingredient dan limit
        const updateIngredientPriceAndLimit = () => {
            let ingredientsAmount = $(`.ingredient-amount`).map(function(){return $(this).val()}).get()
            let ingredientsPrice = $(`.ingredient-price`).map(function(){return $(this).val()}).get()
            
            // Update total price
            let totalPrice = 0
            for(let i = 0; i < ingredientsAmount.length; i++) {
                totalPrice += (ingredientsAmount[i] * ingredientsPrice[i])
            }
            $(`#pengeluaran-ingredient`).text(totalPrice)

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

        const buyIngredients = () => {
            let ingredientId = $(`.ingredient-id`).map(function(){return $(this).val()}).get()
            let ingredientAmount = $(`.ingredient-amount`).map(function(){return $(this).val()}).get()

            $.ajax({
                type: 'POST',
                url: '{{ route("buy-ingredient") }}',
                data: {
                    '_token':'<?php echo csrf_token() ?>',
                    'ingredient_id': ingredientId,
                    'ingredient_amount': ingredientAmount
                },
                success: function(data) {
                    alert(data.status)
                }
            })
        }

        // Update total machine price
        const updateMachinePrice = () => {
            let machinesAmount = $('.machine-amount').map(function(){return $(this).val()}).get()
            let machinesPrice = $('.machine-price').map(function(){return $(this).val()}).get()

            let totalPrice = 0
            for (let i = 0; i < machinesAmount.length; i++){
                totalPrice += (machinesAmount[i] * machinesPrice[i])
            }

            $('#pengeluaran-machine').text(totalPrice)
        }
    </script>
</body>

</html>