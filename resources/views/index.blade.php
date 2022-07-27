<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Final Industrial Games 30</title>
    <link type="text/css" href="{{ asset('') }}vendor/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">
    <link type="text/css" href="{{ asset('') }}vendor/notyf/notyf.min.css" rel="stylesheet">
    <link type="text/css" href="{{ asset('') }}css/volt.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">

    <style>
        body {
            background-image: url('{{ asset('')}}assets/img/background.jpg');
            background-repeat: no-repeat;
            background-attachment: fixed;  
            background-size: cover;
        }
    </style>
</head>

<body class="d-flex flex-column h-100">
    <nav class="navbar navbar-top navbar-expand navbar-dashboard navbar-dark ps-0 pe-2 pb-0">
        <div class="container-fluid px-0">
            <div class="d-flex flex-row justify-content-between w-100" id="navbarSupportedContent">
                <div class="bg-white rounded shadow p-3 ms-2 d-flex flex-row align-items-center">
                    <img src="{{ asset('') }}assets/icons/coin.png" height="20" alt="Coin">
                    <div id="balance" class="ms-2">{{ $team->balance }} TC</div>
                </div>

                <div class="text-white rounded shadow p-3 border border-white" id="batch">
                    @if($preparation)
                        Preparation
                    @else
                        BATCH-{{ $batch }}
                    @endif
                </div>

                <div class="bg-danger rounded shadow p-3 ms-4">
                    <span class="h5 text-capitalize fw-bold"><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-white"> {{ __('Logout') }}</a></span>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                </div>
            </div>
        </div>
    </nav>

    <main>
        <div class="d-flex justify-content-center py-5">
            <div class="rounded-pill p-2 w-50 shadow align-items-center" style="background-color:rgb(234,67,94,0.6);">
                <div class=" fw-bolder fs-1 text-center text-white">{{ $team->name }}</div>
            </div>
        </div>
                
        <div class="d-flex justify-content-around  p-3">
            <!-- PROFIT -->
            <div class="card shadow mb-3" style="max-width: 18rem;">
                <img src="{{ asset('')}}assets/img/profit.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <div class="col-12">
                        <div class="d-flex d-sm-block">
                            <h2 class="mb-0">Profit</h2>
                            <h2 id="profit" class="mb-2 mt-1 fw-bold" id="profit">{{$team->rounds()->where('rounds_id',$batch)->sum("profit")}} TC</h2>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PANGSA -->
            <div class="card shadow mb-3" style="max-width: 18rem;">
                <img src="{{ asset('')}}assets/img/pangsa.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <div class="col-12 ">
                        <div class="d-flex d-sm-block">
                            <h2 class="mb-0">Pangsa Pasar</h2>
                            <h1 class="fw-extrabold text-success mb-2" id="market-share"> {{round($team->rounds()->where('rounds_id',$batch)->sum("market_share")*100,2)}}%</h1>
                        </div>
                    </div>
                </div>
            </div>
           
            <!-- SIX-SIGMA -->
            <div class="card shadow mb-3" style="max-width: 18rem;">
                <img src="{{ asset('')}}assets/img/sigma.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <div class="col-12">
                        <div class="d-flex d-sm-block">
                            <h2 class="mb-0">Sigma</h2>
                            <div class="d-flex">
                                <h1 class="fw-extrabold fs-1 mb-2">Σ</h1>
                                <h3 class="fs-1 mb-2" id="sigma-level">{{round($team->rounds()->where('rounds_id', $batch)->sum("six_sigma"),2)}}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="footer mt-auto text-inverse shadow" style="background: black">
        <div class="d-flex flex-row justify-content-center position-fixed w-100" style="bottom: 5%">
            <button type="button" class="btn btn-block btn-outline-primary shadow m-2" onclick="loadProduction()"><i class="bi-gear"></i> Produksi</button>
            <button type="button" class="btn btn-block btn-outline-primary shadow m-2" onclick="loadInventory()"><i class="bi-bag"></i> Inventory</button>
            <button type="button" class="btn btn-block btn-outline-primary shadow m-2" data-bs-toggle="modal" data-bs-target="#modalMarketMenu"><i class="bi-shop"></i> Market</button>
            <button type="button" class="btn btn-block btn-outline-primary shadow m-2" onclick="loadTransportation()"><i class="bi-truck"></i> Transportation</button>
            <button type="button" class="btn btn-block btn-outline-primary shadow m-2" data-bs-toggle="modal" data-bs-target="#modalTambahTC"><i class="bi-coin"></i> Tambah TC</button>
            <button type="button" class="btn btn-block btn-outline-primary shadow m-2" data-bs-toggle="modal" data-bs-target="#modalInfoHutang" onclick="infoHutang()"><i class="bi-cash-coin"></i> Info Hutang</button>
            <button type="button" class="btn btn-block btn-outline-primary shadow m-2" onclick="loadHistory()"><i class="bi-list-task"></i> Histori Transaksi</button>
        </div>
    </footer>

    @include("modal.debt")
    @include("modal.input-tc")
    @include("modal.inventory-ingredient")
    @include("modal.inventory-machine")
    @include("modal.inventory-product")
    @include("modal.inventory")
    @include("modal.market-ingredient-confirm")
    @include("modal.market-ingredient")
    @include("modal.market-machine-confirm")
    @include("modal.market-machine")
    @include("modal.market-transportation-confirm")
    @include("modal.market-transportation")
    @include("modal.market")
    @include("modal.production")
    @include("modal.transportation-sell")
    @include("modal.transportation")
    @include("modal.history")

    <script src="{{ asset('vendor/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="../js/app.js"></script>
    <script type="text/javascript">
        $("#profit").ready(function(){
            var str = $("#profit").html();
            if(str.indexOf("-") >= 0){
                $("#profit").addClass("text-danger");
                $("#profit").removeClass("text-success");
            }else{
                $("#profit").addClass("text-success");
                $("#profit").removeClass("text-danger");
                $("#profit").prepend("+");             
            }   
        })
        
        const addProduction = () => {
            $.ajax({
                type: 'POST',
                url: '{{ route("add-production") }}',
                data: {
                    '_token': '<?php echo csrf_token() ?>'
                },
                success: function(data) {
                    let counter = parseInt($(`#production-amount`).val())
                    let products = ""
                    let ingredients = ""
                    let machines = ""

                    data.products.forEach(product => {
                        products += `<option value='${product.id}'>${product.name}</option>`
                    })
                    
                    data.ingredients.forEach(ingredient => {
                        ingredients += `<div class="text-center my-3">${ingredient.pivot.amount} ${ingredient.unit} ${ingredient.name}</div>`
                    })

                    data.machines.forEach((machine, index) => {
                        machines += `<select style="margin: auto" class="w-75 form-select my-3 produksi-${counter+1}-select-machine" id="produksi-${counter+1}-select-machine-${index+1}">`
                        machines += `<option value="0" selected>-- Pilih ${machine.name} --</option>`
                        
                        data.team_machine.forEach(tm => {
                            if (machine.id == tm.machines_id) {
                                machines += `<option value="${tm.id}" teammachineid="${tm.pivot.id}">${tm.name_type} ${tm.pivot.id} (Level ${tm.pivot.level})</option>`
                            }
                        })

                        machines += `</select>`
                    })

                    $(`#tbody-produksi`).append(`
                        <tr>
                            <td class="produksi-number text-center p-0">${counter+1}</td>
                            <td><select style="margin: auto" class="w-75 form-select produksi-select-produk" id="produksi-${counter+1}-select-produk" row="${counter+1}">${products}</select></td>
                            <td id="td-produksi-${counter+1}-ingredient">${ingredients}</td>
                            <td id="td-produksi-${counter+1}-machine">${machines}</td>
                            <td><input type="number" style="margin: auto" class="form-control w-50 produksi-input-jumlah" id="produksi-${counter+1}-input-jumlah" min="1" value="1"/></td>
                        </tr>
                    `)
                    
                    $(`#production-amount`).val(counter+1)
                },
                error: function(error) {
                    showError(error)
                }
            })
        }

        // Mengubah produksi
        $(document).on('change', '.produksi-select-produk', function(){
            const row = $(this).attr('row')

            $.ajax({
                type: 'POST',
                url: '{{ route("change-production") }}',
                data: {
                    '_token': '<?php echo csrf_token() ?>',
                    'id': $(this).val()
                },
                success: function(data) {
                    let ingredients = ""
                    let machines = ""

                    data.ingredients.forEach(ingredient => {
                        ingredients += `<div class="text-center my-3">${ingredient.pivot.amount} ${ingredient.unit} ${ingredient.name}</div>`
                    })

                    data.machines.forEach((machine, index) => {
                        machines += `<select style="margin: auto" class="w-75 form-select my-3 produksi-${row}-select-machine" id="produksi-${row}-select-machine-${index+1}">`
                        machines += `<option value="0" selected>-- Pilih ${machine.name} --</option>`
                        
                        data.team_machine.forEach(tm => {
                            if (machine.id == tm.machines_id) {
                                machines += `<option value="${tm.id}" teammachineid="${tm.pivot.id}">${tm.name_type} ${tm.pivot.id} (Level ${tm.pivot.level})</option>`
                            }
                        })

                        machines += `</select>`
                    })

                    $(`#td-produksi-${row}-ingredient`).html(ingredients)
                    $(`#td-produksi-${row}-machine`).html(machines)
                    $(`#produksi-${row}-input-jumlah`).val(1)
                },
                error: function(error) {
                    showError(error)
                }
            })
        })

        // Memulai produksi
        const startProduction = () => {
            if (!confirm("Are you sure?")) return
            
            let productionsId = $(`.produksi-select-produk`).map(function() { return $(this).val() }).get()
            let productionsAmount = $(`.produksi-input-jumlah`).map(function() { return $(this).val() }).get()
            let productionsMachines = []
            let productionsTeamMachines = []
            let machineUnique = true
            let productUnique = true
            
            // Check tidak boleh memproduksi produk yang sama bersamaan dalam satu produksi
            productionsId.forEach((id1, index1) => {
                productionsId.forEach((id2, index2) => {
                    if (index1 != index2) {
                        if (id1 == id2) productUnique = false
                    }
                })
            })

            if (productUnique) {
                // Mendapatkan Id MachineType dan juga id pivot dari team_machine
                productionsId.forEach((product, index) => {
                    let machines = $(`.produksi-${index+1}-select-machine`).map(function() { return $(this).val() }).get()
                    let teamMachines = $(`.produksi-${index+1}-select-machine`).map(function() { return $(this).find(":selected").attr("teammachineid") }).get()
                    productionsMachines.push(machines)
                    productionsTeamMachines.push(teamMachines)
                })

                // Check apakah machine sudah terpilih, jika machineStatus true maka ada yang belum terpilih
                let machineStatus = productionsMachines.some(machines => {
                    return machines.some(machine => machine == 0)
                })
                
                if (!machineStatus) {
                    // kalau ada yang kedouble dipilih machineType dengan idPivotnya, gagalkan produksi
                    let machineList = []
                    let teamMachineList = []
                    productionsMachines.forEach(machines => machines.forEach(machine => machineList.push(machine)))
                    productionsTeamMachines.forEach(machines => machines.forEach(machine => teamMachineList.push(machine)))

                    machineList.forEach((machine1, index1) => {
                        machineList.forEach((machine2, index2) => {
                            if (index1 != index2) {
                                if (machine1 == machine2 && teamMachineList[index1] == teamMachineList[index2]) {
                                    machineUnique = false
                                }
                            }
                        })
                    })

                    if (machineUnique) {
                        $.ajax({
                            type: 'POST',
                            url: '{{ route("start-production") }}',
                            data: {
                                '_token': '<?php echo csrf_token() ?>',
                                'production_id': productionsId,
                                'production_amount': productionsAmount,
                                'production_machine': productionsMachines,
                                'production_team_machine': productionsTeamMachines 
                            },
                            success: function(data) {
                                alert(data.message)
                                if (data.status == "success") {
                                    $(`#balance`).text(`${data.balance}` + " TC")
                                }
                            },
                            error: function(error) {
                                showError(error)
                            }
                        })
                    } else {
                        alert("Tidak boleh menggunakan mesin yang sama di lini produksi yang berbeda!")
                    }
                } else {
                    alert("Harap pilih mesin terlebih dahulu!")
                }
            } else {
                alert("Tidak boleh memproduksi produk yang sama dalam sekali proses produksi!")
            }
        }

        // Update total bahan baku dan limit
        const updateIngredientPriceAndLimit = () => {
            let ingredientId = $(`.ingredient-id`).map(function() { return $(this).val() }).get()
            let ingredientType = ingredientId.map(id => { return $(`#ingredient-type-${id}`).is(':checked') })
            let ingredientsAmount = $(`.ingredient-amount`).map(function() { return $(this).val() }).get()
            let ingredientsPrice = $(`.ingredient-price`).map(function() { return $(this).val() }).get()
            let ingredientsImportPrice = $(`.import-price`).map(function() { return $(this).val() }).get()

            // Update Total
            let totalPrice = 0
            for (let i = 0; i < ingredientsAmount.length; i++) {
                if (ingredientType[i]) {
                    totalPrice += (ingredientsAmount[i] * ingredientsImportPrice[i])
                } else {
                    totalPrice += (ingredientsAmount[i] * ingredientsPrice[i])
                }
            }

            // Update limit dan Ongkir
            let limit = parseInt($(`#package-limit-hidden`).val())
            let quantity = 0
            let ongkir = 0
            ingredientsAmount.forEach(amount => {
                quantity += parseInt(amount)
            })
            let remaining = limit - quantity
            if (remaining < 0) { 
                remaining = 0
                ongkir = limit + ((quantity-limit)*3)
            } else {
                ongkir = quantity
            }

            $(`#total-ingredient`).text(`${totalPrice} TC`)
            $(`#package-limit`).text(remaining)
            $(`#ongkir-ingredient`).text(`${ongkir} TC`)
            $(`#subtotal-ingredient`).text(`${totalPrice+ongkir} TC`)
        }

        // Beli bahan baku
        const buyIngredients = () => {
            if (!confirm("Are you sure?")) return

            let ingredientId = $(`.ingredient-id`).map(function() { return $(this).val() }).get()
            let ingredientAmount = $(`.ingredient-amount`).map(function() { return $(this).val() }).get()
            let ingredientType = ingredientId.map(id => { return $(`#ingredient-type-${id}`).is(':checked') })

            $.ajax({
                type: 'POST',
                url: '{{ route("buy-ingredient") }}',
                data: {
                    '_token': '<?php echo csrf_token() ?>',
                    'ingredient_id': ingredientId,
                    'ingredient_amount': ingredientAmount,
                    'ingredient_type': ingredientType
                },
                success: function(data) {
                    if (data.status == "success") {
                        $(`.ingredient-amount`).val(0)
                        $('.ingredient-type').prop('checked', false);
                        $(`#total-ingredient`).text("0 TC")
                        $(`#ongkir-ingredient`).text("0 TC")
                        $(`#subtotal-ingredient`).text("0 TC")
                        $(`#package-limit-hidden`).val(data.limit)
                        $(`#package-limit`).text(data.limit)
                        $(`#balance`).text(data.balance + " TC")
                    }
                    alert(data.message)
                },
                error: function(error) {
                    showError(error)
                }
            })
        }

        // Beli mesin
        const buyMachine = (batch) => {
            if (!confirm("Are you sure?")) return

            let machineId = $(`.machine-id`).map(function() {
                return $(this).val()
            }).get()
            let machineAmount = $(`.machine-amount`).map(function() {
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
                    if (data.status == "success") {
                        $(`.machine-amount`).val(0)
                        $(`#pengeluaran-machine`).text("0 TC")
                        $(`#balance`).text(data.balance + " TC")
                    }
                    alert(data.message)
                },
                error: function(error) {
                    showError(error)
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
        const buyTransportations = (batch) => {
            if (!confirm("Are you sure?")) return

            let transportationId = $(`.transportation-id`).map(function() {
                return $(this).val()
            }).get()

            let transportationAmount = $(`.transportation-amount`).map(function() {
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
                    if (data.status == "success") {
                        $(`.transportation-amount`).val(0)
                        $(`#pengeluaran-transportation`).text("0 TC")
                        $(`#balance`).text(data.balance + " TC")
                    }
                },
                error: function(error) {
                    showError(error)
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
                    showError(error)
                }
            })
        }

        const sellTransportations = (batch) => {
            let id = $(`#sell-transport-id`).val()

            $.ajax({
                type: 'POST',
                url: '{{ route("transportation.sell") }}',
                data: {
                    '_token': '<?php echo csrf_token() ?>',
                    'id': id
                },
                success: function(data) {
                    $(`#transport-${data.id}`).remove()
                    if (data.status == "success"){
                        $(`#balance`).text(data.balance + " TC")
                    }
                    alert(data.message)
                },
                error: function(error) {
                    showError(error)
                }
            })
        }
        
        // show machine sell
        const showMachineSell = (id, type_id) => {
            $.ajax({
                type: 'POST',
                url: '{{ route("machine.getbyid") }}',
                data: {
                    '_token': '<?php echo csrf_token() ?>',
                    'id': id,
                    'type_id': type_id
                },
                success: function(data) {
                    $(`#sell-machine-name`).text(data.nama)
                    $(`#sell-machine-lifetime`).text(data.lifetime + " Batch")
                    $(`#sell-machine-price`).text(data.price + " TC")
                    $(`#sell-machine-id`).val(data.id)
                    $(`#sell-machine-type-id`).val(type_id)
                },
                error: function(error) {
                    showError(error)
                }
            })
        }

        const sellMachine = (batch) => {
            let id = $(`#sell-machine-id`).val()
            let type_id = $(`#sell-machine-type-id`).val()

            $.ajax({
                type: 'POST',
                url: '{{ route("machine.sell") }}',
                data: {
                    '_token': '<?php echo csrf_token() ?>',
                    'id': id,
                    'type_id': type_id
                },
                success: function(data) {
                    $(`#machine-${data.type}-${data.id}`).remove()
                    if (data.status == "success") {
                        $(`#balance`).text(data.balance + " TC")

                    }
                    alert(data.message)
                },
                error: function(error) {
                    showError(error)
                }
            })
        }

        const addCoin = () =>{
            if (!confirm("Are you sure?")) return

            let coin = $('#jumlah-tc').val()
            let metode = $('input[name="metode"]:checked').val()
           
            $.ajax({
                type: 'POST',
                url: '{{ route("add-coin") }}',
                data: {
                    '_token': '<?php echo csrf_token() ?>',
                    'coin': coin,
                    'metode': metode,
                },
                success: function(data) {
                    $('#modalTambahTC').modal('hide')
                    alert(data.message)
                    if (data.status == "success"){
                        $(`#balance`).text(data.balance + " TC")
                    }
                    $(`#jumlah-tc`).val(null)
                },
                error: function(error) {
                    showError(error)
                }
            })
        }

        const infoHutang = () =>{
            $.ajax({
                type: 'POST',
                url: '{{ route("info-hutang") }}',
                data: {
                    '_token': '<?php echo csrf_token() ?>',
                },
                success: function(data) {
                    $(`#jumlahHutang`).text(data.info)
                },
                error: function(error) {
                    showError(error)
                }
            })
        }

        const bayarHutang = () =>{
            if (!confirm("Are you sure?")) return
            let bayar = $('#jumlah-bayar').val()
            
            $.ajax({
                type: 'POST',
                url: '{{ route("bayar-hutang") }}',
                data: {
                    '_token': '<?php echo csrf_token() ?>',
                    'bayar' : bayar
                },
                success: function(data) {
                    alert(data.message)
                    $('#modalInfoHutang').modal('hide')
                    if (data.status == "success"){
                        $(`#balance`).text(data.balance + " TC")
                    }
                    $(`#jumlahHutang`).text(data.info)
                    $(`#jumlah-bayar`).val(0)
                },
                error: function(error) {
                    showError(error)
                }
            })
        }

        const upgradeInventory = (id, up_id) =>{
            if (!confirm("Are you sure?")) return

            $.ajax({
                type: 'POST',
                url: '{{ route("upgrade-inventory") }}',
                data: {
                    '_token': '<?php echo csrf_token() ?>',
                    'id': id,
                    'up_id': up_id 
                },
                success: function(data) {
                    alert(data.message)
                    $(`#balance`).text(data.balance + " TC")
                },
                error: function(error) {
                    showError(error)
                }
            })
        }

        const showError = (error) => {
            let errorMessage = JSON.parse(error.responseText).message
            alert(`Error: ${errorMessage}`)
            console.log(`Error: ${errorMessage}`)
        }

        const loadTransportation = _ => {
            $.ajax({
                type: 'POST',
                url: '{{ route("load-transportation") }}',
                data: {
                    '_token': '<?php echo csrf_token() ?>'
                },
                success: function(data) {
                    let transportationText = ""
                    
                    data.transportations.forEach(transportation => {
                        transportationText += `
                            <tr id="transport-${transportation.pivot.id}">
                                <td class="border-0 text-center align-middle">${transportation.name}</td>
                                <td class="border-0 text-center align-middle">${transportation.capacity}</td>
                                <td class="border-0 text-center align-middle">${transportation.self_duration}</td>
                                <td class="border-0 text-center align-middle">${transportation.delivery_duration}</td>
                                <td class="border-0 text-center align-middle">${data.batch - transportation.pivot.batch + 1}</td>

                                <td class="border-0 text-center align-middle">
                                    <button type="button" class="btn btn-danger" data-bs-target="#modalJualTransport" data-bs-toggle="modal" onclick="showTransportSell(${transportation.pivot.id})">Jual</button>
                                </td>
                            </tr>
                        `
                    })
                    
                    $(`#modal-body-transport`).html(`
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="border-0 text-center">Jenis</th>
                                    <th class="border-0 text-center">Kapasitas</th>
                                    <th class="border-0 text-center">Durasi Antar Sendiri</th>
                                    <th class="border-0 text-center">Durasi Delivery</th>
                                    <th class="border-0 text-center">Masa Pakai</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-transportation">${transportationText}</tbody>
                        </table>
                    `)

                    $('#modalTransport').modal('show');
                },
                error: function(error) {
                    showError(error)
                }
            })
        }

        const loadInventory = _ => {
            $.ajax({
                type: 'POST',
                url: '{{ route("load-inventory") }}',
                data: {
                    '_token': '<?php echo csrf_token() ?>'
                },
                success: function(data) {
                    let counter1 = 1
                    let counter2 = 1
                    let ingredientText = ""
                    let machineText = ""
                    let productText = ""
                    let fridge = ""

                    data.ingredients.forEach(ingredient => {
                        ingredientText += `
                            <tr>
                                <td class="border-0 text-center align-middle">${ counter1++ }</td>
                                <td class="border-0 text-center align-middle">${ ingredient.name }</td>
                                <td class="border-0 text-center align-middle">${ ingredient.pivot.amount}</td>
                            </tr>
                        `
                    })

                    data.machines.forEach(machine => {
                        machineText += `
                            <tr id="machine-${machine.pivot.machine_types_id}-${machine.pivot.id}">
                                <td class="border-0 text-center align-middle">${ machine.name_type } ${machine.pivot.id}</td>
                                <td class="border-0 text-center align-middle">${ machine.pivot.level}</td>
                                <td class="border-0 text-center align-middle">
                                    <button type="button" class="btn btn-danger" data-bs-target="#modalJualMesin"
                                        data-bs-toggle="modal"
                                        onclick="showMachineSell(${ machine.pivot.id }, ${ machine.pivot.machine_types_id })">Jual</button>
                                </td>
                            </tr>
                        `
                    })

                    data.products.forEach(product => {
                        productText += `
                            <tr>
                                <td class="border-0 text-center align-middle">${ counter2++ }</td>
                                <td class="border-0 text-center align-middle">${ product.name } ${product.pivot.id}</td>
                                <td class="border-0 text-center align-middle">${ product.pivot.amount}</td>
                            </tr>
                        `
                    })
                    
                    if (data.fridge) {
                        fridge = "Ada kulkas"
                    } else {
                        fridge = "Tidak ada kulkas"
                    }

                    $(`#modal-body-inventory`).html(`
                        <div class="row">
                            <div class="col-4">
                                <div class="bg-info rounded">
                                    <h3 class="text-center text-gray-100">BAHAN BAKU</h3>
                                    <div class="d-flex justify-content-center text-gray-100">
                                        <h5 id="used-capacity-ingredient">${ data.team_ingre }</h5>
                                        <h5>/</h5>
                                        <h5>${ data.inventory_ingre }</h5>
                                    </div>
                                </div>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="border-0 text-center">No.</th>
                                            <th scope="col" class="border-0 text-center">Nama Bahan</th>
                                            <th scope="col" class="border-0 text-center">Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody-ingredient">${ingredientText}</tbody>
                                </table>
                            </div>

                            <div class="col-4">
                                <div class="bg-info rounded">
                                    <h3 class="text-center text-gray-100">MESIN</h3>
                                    <div class="d-flex justify-content-center text-gray-100">
                                        <h5>${fridge}</h5>
                                    </div>

                                </div>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="border-0 text-center">Nama Mesin</th>
                                            <th scope="col" class="border-0 text-center">Level</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody-machine">${machineText}</tbody>
                                </table>
                            </div>

                            <div class="col-4">
                                <div class="bg-info rounded">
                                    <h3 class="text-center text-gray-100">PRODUK</h3>
                                    <div class="d-flex justify-content-center text-gray-100">
                                        <h5 id="used-capacity-product">${ data.team_prod }</h5>
                                        <h5>/</h5>
                                        <h5>${ data.inventory_prod }</h5>
                                    </div>
                                </div>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="border-0 text-center">No.</th>
                                            <th scope="col" class="border-0 text-center">Nama Produk</th>
                                            <th scope="col" class="border-0 text-center">Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody>${productText}</tbody>
                                </table>
                            </div>
                        </div>
                    `)

                    $('#modalInventory').modal('show');
                },
                error: function(error) {
                    showError(error)
                }
            })
        }

        const loadHistory = _ => {
            $.ajax({
                type: 'POST',
                url: '{{ route("load-history") }}',
                data: {
                    '_token': '<?php echo csrf_token() ?>'
                },
                success: function(data) {
                    let historyText = ""
                    
                    data.histories.forEach(history => {
                        historyText += `
                            <tr>
                                <td class="border-0 text-center align-middle" style="min-width: 10%; max-width: 10%">${history.batch}</td>
                                <td class="border-0 text-center align-middle" style="word-wrap: break-word; min-width: 90%; max-width: 90%">${history.keterangan}</td>
                            </tr>
                        `
                    })
                    
                    $(`#modal-body-history`).html(`
                        <table class="table table-bordered table-secondary shadow w-100">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center" style="min-width: 10%; max-width: 10%">Batch</th>
                                    <th scope="col" class="text-center" style="min-width: 90%; max-width: 90%">Keterangan Transaksi</th>
                                </tr>
                            </thead>
                            <tbody>${historyText}</tbody>
                        </table>
                    `)

                    $('#modalHistory').modal('show');
                },
                error: function(error) {
                    showError(error)
                }
            })
        }

        const loadProduction = _ => {
            $(`#modal-body-production`).html(`
                <table class="table table-centered table-nowrap" style="vertical-align:middle">
                    <thead class="thead-dark">
                        <tr>
                            <th class="border-0 rounded-start text-center">No</th>
                            <th class="border-0 text-center">Produk</th>
                            <th class="border-0 text-center">Bahan</th>
                            <th class="border-0 text-center">Mesin</th>
                            <th class="border-0 rounded-end text-center">Jumlah Produksi</th>
                        </tr>
                    </thead>
                    <input type="hidden" value="0" id="production-amount" />
                    <tbody class="border-0" id="tbody-produksi">

                    </tbody>
                </table>
            `)

            $('#modalProduksi').modal('show');
        }

        window.Echo.channel('update-batch' + {{ Auth::user()->team }}).listen('.update', (e) => {
            alert(`Berhasil update ke batch ${e.batch}`)
            $(`#balance`).text(`${e.balance}` + " TC")
            $(`#batch`).text("BATCH-" +`${e.batch}`)
            $(`#profit`).text("+0 TC") 
            $(`#market-share`).text("0%")
            $(`#sigma-level`).text("0")
            $("#profit").addClass("text-success")
            $("#profit").removeClass("text-danger")
        })

        window.Echo.channel('update-preparation.' + {{ Auth::user()->team }}).listen('.preparation', (e) => {
            alert(`Masuk ke sesi preparation`)
            $(`#batch`).text("Preparation")
            
            $(`#profit`).text(`${e.profit}` + " TC")
            if(`${e.profit}` < 0){
                $("#profit").addClass("text-danger")
                $("#profit").removeClass("text-success")
            }else{
                $("#profit").addClass("text-success")
                $("#profit").removeClass("text-danger")
                $("#profit").prepend("+")            
            }

            let market_share = (`${e.market_share}` * 100).toFixed(2)
            $(`#market-share`).text(market_share + "%")
        })

        window.Echo.channel('update-market.' + {{ Auth::user()->team }}).listen('.market', (e) => {
            $(`#sigma-level`).text(`${e.sigma_level}`)
        })

        window.Echo.channel('update-balance.' + {{ Auth::user()->team }}).listen('.balance', (e) => {
            $(`#balance`).text(`${e.balance}` + " TC")
        })

        window.Echo.channel('update-import').listen('.import', (e) => {
            e.imports.forEach(ingredient => {
                $(`#ingredient-import-${ingredient.id}`).text(`${ingredient.amount} Paket`)
            })
        })
    </script>
</body>

</html>