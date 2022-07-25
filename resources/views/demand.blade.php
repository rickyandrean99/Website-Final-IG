<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('') }}assets/icons/logo.png">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('') }}assets/icons/logo.png">
    <title>Demand Industrial Games 30</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body style="background-color: #FAF0DC;">
    <div class="row align-items-center bg-warning" style="box-shadow: 5px 2px 5px rgba(0, 0, 0, 0.5)">
        <div class="col-md-1">
            <button type="button" class=" btn btn-block btn-danger m-2" style="box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3)" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</button>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
        </div>
        <div class="col-md-4 offset-md-3">
            <h3 class="text-center fw-bolder m-2">DEMAND</h3>
        </div>
        <div class="col-md-1 offset-md-3">
            <button type="button" class=" btn btn-block btn-success m-2" style="box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3)" href="" onclick="">Recap</button>
            <form id="demand-form" action="" method="POST" class="d-none">@csrf</form>
        </div>
    </div>
    <div class="row justify-content-center">
        <h2 class="text-center"><span class="badge bg-dark rounded mt-3">BATCH 1</span></h2>
        <table class="table table-warning table-bordered shadow-sm" style="width: 70%">
            <thead>
                <tr class="text-center align-middle">
                    <th style="width : 50%;">Produk</th>
                    <th>Demand</th>
                </tr>
            </thead>
            <tbody>
                <tr class="text-center align-middle">
                    <td>Keripik Apel</td>
                    <td>500</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>