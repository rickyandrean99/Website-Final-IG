<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('') }}assets/icons/logo.png">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('') }}assets/icons/logo.png">
    <title>Upgrade Industrial Games 30</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
    <div class="row align-items-center">
        <div class="col-md-4 offset-md-4">
            <h3 class="text-center fw-bolder m-2" style="color: #EA435E;">REKAP PENILAIAN</h3>
        </div>
        <div class="col-md-1 offset-md-3">
            <button type="button" class=" btn btn-block btn-outline-danger m-2" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-danger">Logout</button>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
        </div>
    </div>
    
    <table class="table table-hover bg-white rounded my-1">
        <thead>
            <tr class="text-center align-middle">
                <th scope="col">Nama Tim</th>
                <th scope="col">Score</th>
            </tr>
        </thead>
        <tbody>
            @for ($i = 1; $i < 10; $i++)
            <tr class="text-center align-middle">
                <td class="w-25">Perusahaan {{$i}}</td>
                <td class="w-25">0</td>
            </tr>
            @endfor
        </tbody>
    </table>
</body>
</html>