<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('') }}assets/icons/logo.png">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('') }}assets/icons/logo.png">
    <title>Update Batch</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <style>
        body{
            background-image: url('{{ asset('')}}assets/img/background.jpg');
            background-repeat: no-repeat;
            background-attachment: fixed;  
            background-size: cover;
        }
    </style>
</head>
<body>
    <div class="w-100 h-100 position-fixed align-items-center justify-content-center" id="loading-animation" style="background: rgba(0,0,0,0.5); z-index: 999; display:none; flex-direction: column">
        <h3 class="fw-bolder text-white">Loading</h3><br>
        <div class="spinner-border text-white" role="status">
            <span class="visually-hidden"></span>
        </div>
    </div>

    <div class="d-flex justify-content-center p-3">
        <div class="card " style="width: 400px;">
            <img src="https://c.tenor.com/MgVKRHA7lUcAAAAd/tentara-itu-harus-hitam-meme-tentara.gif" class="card-img-top" alt="updet">
            <div class="card-body">
                <h5 class="card-title text-center">UPDATE BATCH</h5>
                <p class="card-text text-center">Tombol dibawah untuk ganti-ganti batch</p>
                <div class="d-flex justify-content-center">
                    <button type="button" class="btn btn-block btn-outline-success m-2" onclick="updateBatch()">Update</button>
                    <button type="button" class="btn btn-block btn-outline-warning m-2" onclick="updatePreperation()">Cooldown</button>
                    <button type="button" class="btn btn-block btn-outline-danger m-2" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-danger">Logout</button>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                </div>
            </div>
            <div class="row g-2 ps-3 py-3">
                <div class="col-6">
                    <select name="selectProduct" id="selectProduct" class="form-select w-45 mb-3">
                        <option value="1">Keripik Apel</option>
                        <option value="2">Dodol Apel</option>
                        <option value="3">Sari Buah Apel</option>
                        <option value="4">Selai Kulit Apel</option>
                        <option value="5">Cuka Apel</option>
                    </select>
                </div>
                <div class="col-3">
                    <input type="number" class="form-control product-amount w-70" id="demand" placeholder=0 min=0>
                </div>
                <div class="col-2">
                    <button type="submit" class="btn btn-block btn-outline-primary mb-3" onclick="updateDemand()">Update</button>
                </div>
            </div>
            <div class="row ps-3">
                <div class="col-8">    
                    <select name="selectID" id="selectID" class="form-select w-90">
                        <option value="0" disabled selected>Pilih Transaksi</option>    
                        @foreach ($transaction as $t)
                        @php
                            $time = date('H:i:s', strtotime($t->delivered_time))
                        @endphp
                        <option value="{{$t->id}}">Tim {{ $t->teams_id }} -> {{ $time }} = {{ $t->total }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-4">
                    <button type="submit" class="btn btn-block btn-outline-primary mb-3" onclick="sendTC()">Send TC</button>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script type="text/javascript">
        const enableLoading = _ => {
            $(`#loading-animation`).css(`display`, `flex`)
        }

        const disableLoading = _ => {
            $(`#loading-animation`).css(`display`, `none`)
        }
        
        //update preperation
        const updatePreperation = () => {
            if (!confirm("Are you sure?")) return

            enableLoading()
            $.ajax({
                type: 'POST',
                url: '{{ route("update-preparation") }}',
                data: {
                    '_token': '<?php echo csrf_token() ?>',
                },
                success: function(data) {
                    disableLoading()
                    alert(data.message)
                },
                error: function(error){
                    showError(error)
                }
            })
        }

        const updateBatch = () => {
            if (!confirm("Are you sure?")) return

            enableLoading()
            $.ajax({
                type: 'POST',
                url: '{{ route("update-batch") }}',
                data: {
                    '_token': '<?php echo csrf_token() ?>',
                },
                success: function(data) {
                    disableLoading()
                    alert(data.message)
                },
                error: function(error){
                    showError(error)
                }
            })
        }

        const updateDemand = () => {
            if (!confirm("Are you sure?")) return
            let id = $(`#selectProduct`).val()
            let demand = $(`#demand`).val()

            enableLoading()
            $.ajax({
                type: 'POST',
                url: '{{ route("update-demand") }}',
                data: {
                    '_token': '<?php echo csrf_token() ?>',
                    'id': id,
                    'demand': demand
                },
                success: function(data) {
                    disableLoading()
                    alert(data.message)
                    $(`#demand`).val(0)
                },
                error: function(error){
                    showError(error)
                }
            })
        }

        const sendTC = () => {
            if (!confirm("Are you sure?")) return
            let trans_id = $(`#selectID`).val()

            enableLoading()
            $.ajax({
                type: 'POST',
                url: '{{ route("send-tc") }}',
                data: {
                    '_token': '<?php echo csrf_token() ?>',
                    'trans_id': trans_id,
                },
                success: function(data) {
                    disableLoading()
                    alert(data.message)
                },
                error: function(error){
                    showError(error)
                }
            })
        }

        const showError = (error) => {
            disableLoading()
            
            let errorMessage = JSON.parse(error.responseText).message
            alert(`Error: ${errorMessage}`)
            console.log(`Error: ${errorMessage}`)
        }
    </script>
</body>
</html>