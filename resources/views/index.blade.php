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

                <div class="text-white rounded shadow p-3 border border-white">BATCH-{{ $batch }}</div>

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
                            <h2 id="profit" class="mb-2 mt-1 fw-bold">{{$team->rounds()->where('batch',$batch)->sum("profit")}} TC</h2>
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
                            <h1 class="fw-extrabold text-success mb-2"> {{round($team->rounds()->where('batch',$batch)->sum("market_share")*100,2)}}%</h1>
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
                                <h3 class="fs-1 mb-2">4.34</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="footer mt-auto text-inverse shadow" style="background: black">
        <div class="d-flex flex-row justify-content-center position-fixed w-100" style="bottom: 5%">
            <button type="button" class="btn btn-block btn-outline-primary shadow m-2" data-bs-toggle="modal" data-bs-target="#modalProduksi"><i class="bi-gear"></i> Produksi</button>
            <button type="button" class="btn btn-block btn-outline-primary shadow m-2" data-bs-toggle="modal" data-bs-target="#modalInventory"><i class="bi-bag"></i> Inventory</button>
            <button type="button" class="btn btn-block btn-outline-primary shadow m-2" data-bs-toggle="modal" data-bs-target="#modalMarketMenu"><i class="bi-shop"></i> Market</button>
            <button type="button" class="btn btn-block btn-outline-primary shadow  m-2" data-bs-toggle="modal" data-bs-target="#modalTransport"><i class="bi-truck"></i> Transportation</button>
            <button type="button" class="btn btn-block btn-outline-primary shadow m-2" data-bs-toggle="modal" data-bs-target="#modalTambahTC"><i class="bi-coin"></i> Tambah TC</button>
            <button type="button" class="btn btn-block btn-outline-primary shadow m-2" data-bs-toggle="modal" data-bs-target="#modalInfoHutang" onclick="infoHutang()"><i class="bi-cash-coin"></i> Info Hutang</button>
            <button type="button" class="btn btn-block btn-outline-primary shadow m-2" data-bs-toggle="modal" data-bs-target="#modalHistory"><i class="bi-list-task"></i> Histori Transaksi</button>
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
                        $(`.ingredient-amount`).val(null)
                        $(`#subtotal-ingredient`).text("0 TC")
                        $(`#package-limit-hidden`).val(data.limit)
                        $(`#package-limit`).text(data.limit)
                        $(`#balance`).text(data.balance + " TC")
                        
                        //perbarui inventory
                        let table = document.getElementById("tbody-ingredient");
	                    table.innerHTML = "";
                        let counter = 1

                        // data.ingredients.forEach(ingredient => {
                        //     $(`#tbody-ingredient`).append(`
                        //         <tr>
                        //             <td class="border-0 text-center align-middle">${counter}</td>
                        //             <td class="border-0 text-center align-middle">${ingredient.name}</td>
                        //             <td class="border-0 text-center align-middle">${ingredient.pivot.amount}</td>
                        //         </tr>
                        //     `)
                        //     counter++
                        // })

                        // $(`#used-capacity-ingredient`).text(data.used)
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
                        $(`.machine-amount`).val(null)
                        $(`#pengeluaran-machine`).text("0 TC")
                        $(`#balance`).text(data.balance + " TC")

                        //perbarui inventory machine
                        let table = document.getElementById("tbody-machine");
	                    table.innerHTML = "";
                        let counter = 1

                        data.machines.forEach(machine => {
                            let lifetime = batch - machine.pivot.batch  + 1
                            if(machine.pivot.exist){
                                $(`#tbody-machine`).append(`
                                    <tr>
                                        <td class="border-0 text-center align-middle">${counter}</td>
                                        <td class="border-0 text-center align-middle">${machine.name_type} ${machine.pivot.id}</td>
                                        <td class="border-0 text-center align-middle">${machine.pivot.level}</td>
                                        <td class="border-0 text-center align-middle">
                                            <button type="button" class="btn btn-danger"
                                                data-bs-target="#modalJualMesin" data-bs-toggle="modal"
                                                onclick="showMachineSell(${ machine.pivot.id }, ${ machine.pivot.machine_types_id })">Jual</button>
                                        </td>
                                    </tr>
                                `)
                                counter++
                            }
                        })
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
                    if (data.status == "success") {
                        $(`.transportation-amount`).val(null)
                        $(`#pengeluaran-transportation`).text("0 TC")
                        $(`#balance`).text(data.balance + " TC")

                        //perbarui inventory
                        let table = document.getElementById("tbody-transportation");
	                    table.innerHTML = "";
                        let counter = 1

                        data.transportations.forEach(transport => {
                            let lifetime = batch - transport.pivot.batch  + 1
                            if(transport.pivot.exist){
                                $(`#tbody-transportation`).append(`
                                    <tr>
                                        <td class="border-0 text-center align-middle">${counter}</td>
                                        <td class="border-0 text-center align-middle">${transport.name}</td>
                                        <td class="border-0 text-center align-middle">${transport.capacity}</td>
                                        <td class="border-0 text-center align-middle">${transport.duration}</td>
                                        <td class="border-0 text-center align-middle">${lifetime}</td>
                                        <td class="border-0 text-center align-middle">
                                            <button type="button" class="btn btn-danger"
                                                data-bs-target="#modalJualTransport" data-bs-toggle="modal"
                                                onclick="showTransportSell(${ transport.pivot.id })">Jual
                                            </button>
                                        </td>
                                    </tr>
                                `)
                                counter++
                            }
                        })
                    }
                    alert(data.message) 
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
                    if (data.status == "success"){
                        $(`#balance`).text(data.balance + " TC")

                        //perbarui inventory
                        let table = document.getElementById("tbody-transportation");
	                    table.innerHTML = "";
                        let counter = 1

                        data.transportations.forEach(transport => {
                            let lifetime = batch - transport.pivot.batch  + 1
                            if(transport.pivot.exist){
                                $(`#tbody-transportation`).append(`
                                    <tr>
                                        <td class="border-0 text-center align-middle">${counter}</td>
                                        <td class="border-0 text-center align-middle">${transport.name}</td>
                                        <td class="border-0 text-center align-middle">${transport.capacity}</td>
                                        <td class="border-0 text-center align-middle">${transport.duration}</td>
                                        <td class="border-0 text-center align-middle">${lifetime}</td>
                                        <td class="border-0 text-center align-middle">
                                            <button type="button" class="btn btn-danger"
                                                data-bs-target="#modalJualTransport" data-bs-toggle="modal"
                                                onclick="showTransportSell(${ transport.pivot.id })">Jual
                                            </button>
                                        </td>
                                    </tr>
                                `)
                                counter++
                            }
                        })
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
                    if (data.status == "success") {
                        $(`#balance`).text(data.balance + " TC")

                        //perbarui inventory machine
                        let table = document.getElementById("tbody-machine");
	                    table.innerHTML = "";
                        let counter = 1

                        data.machines.forEach(machine => {
                            let lifetime = batch - machine.pivot.batch  + 1
                            if(machine.pivot.exist){
                                $(`#tbody-machine`).append(`
                                    <tr>
                                        <td class="border-0 text-center align-middle">${counter}</td>
                                        <td class="border-0 text-center align-middle">${machine.name_type} ${machine.pivot.id}</td>
                                        <td class="border-0 text-center align-middle">${machine.pivot.level}</td>
                                        <td class="border-0 text-center align-middle">
                                            <button type="button" class="btn btn-danger"
                                                data-bs-target="#modalJualMesin" data-bs-toggle="modal"
                                                onclick="showMachineSell(${ machine.pivot.id }, ${ machine.pivot.machine_types_id })">Jual</button>
                                        </td>
                                    </tr>
                                `)
                                counter++
                            }
                        })
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
                    if (data.status == "success"){
                        $(`#balance`).text(data.balance + " TC")
                    }
                    $(`#jumlahHutang`).text(data.info)
                    $(`#jumlah-bayar`).val(null)
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
    </script>
</body>

</html>