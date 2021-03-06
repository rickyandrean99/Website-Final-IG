<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('') }}assets/icons/logo.png">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('') }}assets/icons/logo.png">
    <title>Rekap Penilaian Industrial Games 30</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body style="background-color: #FAF0DC;">
    <div class="row align-items-center" style="background-color: #EA435E;">
        <div class="col-md-4 offset-md-4">
            <h3 class="text-center text-white fw-bolder m-2">REKAP PENILAIAN</h3>
        </div>
        <div class="col-md-1 offset-md-3">
            <button type="button" class=" btn btn-block btn-danger shadow-sm m-2" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-danger">Logout</button>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
        </div>
    </div>
    @for ($i = 1; $i <= 5; $i++)
        <div class="row justify-content-center">
            <h2 class="text-center"><span class="badge bg-dark rounded mt-3"> BATCH {{$i}} </span></h2>
            <table class="table table-striped table-warning table-bordered mt-2 shadow-sm" style="width: 85%">
                <thead>
                    <tr class="text-center align-middle">
                        <th scope="col">Nama Tim</th>
                        <th scope="col">Six Sigma</th>
                        <th scope="col">Profit</th>
                        <th scope="col">Pangsa</th>
                        <th scope="col">TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($teams as $team)
                    <tr class="text-center align-middle">
                        <td style="width: 40%;">Perusahaan {{ $team -> id }}</td>
                        <td> {{$team
                            ->rounds()
                            ->where("batch", "$i")
                            -> }} </td>
                        <td> </td>
                        <td> </td>
                        <td>0</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endfor
       
</body>
</html>