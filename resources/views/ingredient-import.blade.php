<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pos Bahan Baku Lokal</title>
    <link type="text/css" href="{{ asset('') }}vendor/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">
    <link type="text/css" href="{{ asset('') }}vendor/notyf/notyf.min.css" rel="stylesheet">
    <link type="text/css" href="{{ asset('') }}css/volt.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
</head>

<body>
    Pos Ingredient Import
    <!-- <div class="bg-danger rounded shadow p-3 ms-4">
        <span class="h5 text-capitalize fw-bold"><a href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-white">
                {{ __('Logout') }}</a></span>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
    </div> -->

    <main>
        <div class="row">
            <div class="col-7">
                <div class="table-responsive">
                    <table class="table table-centered table-nowrap" style="width: 100%">
                        <thead class="thead-dark"
                            style="table-layout: fixed; width: calc( 100% - 1em ); display: table;">
                            <tr>
                                <th class="border-0 rounded-start text-center" style='width:10%'>No</th>
                                <th class="border-0 text-center" style='width:30%'>Bahan Baku</th>
                                <th class="border-0 text-center" style='width:25%'>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody style="display: block; overflow-y: auto; height: 70vh; border-top: 0">
                            @php $index = 1 @endphp
                            @foreach($ingredient as $i)
                            <tr style='display: table; table-layout: fixed; width: 100%'>
                                <input type="hidden" class="ingredient-id" value="{{ $i->id }}">
                                <input type="hidden" class="ingredient-price" id="ingredient-price-{{ $i->id }}"
                                    value="{{ $i->price }}">
                                <input type="hidden" class="import-price" id="import-price-{{ $i->id }}"
                                    value="{{ $i->import_price }}">

                                <td class="text-center" style='width:10%'>{{ $index++ }}</td>
                                <td class="text-center" style='width:30%'>{{ $i->name }}</td>
                                <td class="text-center" style='width:25%'>
                                    <input type="number" style="margin: auto"
                                        class="form-control ingredient-amount w-50 text-center"
                                        id="ingredient-amount-{{ $i->id }}" value="0" min="0"
                                        onchange="updateIngredientPriceAndLimit()">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-5 px-5">
                <div class="row mt-3">
                    <div class="col-6 bg-info text-white text-center fw-bold p-3 rounded-start">Limit
                    </div>
                    <div class="col-6 bg-primary text-white text-center fw-bold p-3 rounded-end">
                        <span id="package-limit">{{ $limit }}</span>
                        <input type="hidden" id="package-limit-hidden" value="{{ $limit }}">
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-6 bg-info text-white text-center fw-bold p-3 rounded-start">Total
                    </div>
                    <div class="col-6 bg-primary text-white text-center fw-bold p-3 rounded-end" id="total-ingredient">0
                        TC</div>
                </div>

                <div class="row mt-3">
                    <div class="col-6 bg-info text-white text-center fw-bold p-3 rounded-start">Ongkir
                    </div>
                    <div class="col-6 bg-primary text-white text-center fw-bold p-3 rounded-end" id="ongkir-ingredient">
                        0 TC</div>
                    <input type="hidden" id="package-ongkir" value="{{ $ongkir }}">
                </div>

                <div class="row mt-3">
                    <div class="col-6 bg-info text-white text-center fw-bold p-3 rounded-start">Subtotal
                    </div>
                    <div class="col-6 bg-primary text-white text-center fw-bold p-3 rounded-end"
                        id="subtotal-ingredient">0 TC</div>
                </div>

                <div class="row mt-4">
                    <button class="btn btn-success fw-bold p-3 text-white" style="font-size: 20px; font-weight: bold"
                        onclick="buyIngredients()">Buy</button>
                </div>
            </div>
        </div>
    </main>

    <script src="{{ asset('vendor/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript">

    </script>
</body>

</html>