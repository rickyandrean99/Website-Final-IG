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
    <div class="row align-items-center bg-success" style="box-shadow: 5px 2px 5px rgba(0, 0, 0, 0.5)">
        <div class="col-md-1">
            <button type="button" class=" btn btn-block btn-danger m-2" style="box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3)" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</button>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
        </div>
        <div class="col-md-4 offset-md-3">
            <h3 class="text-center text-white fw-bolder m-2">REKAP PENILAIAN</h3>
        </div>
        <div class="col-md-1 offset-md-3">
            <a href="{{ route('demand') }}"><button type="button" class=" btn btn-block btn-warning m-2" style="box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3)" href="" onclick="">Demand</button></a>
            <form id="demand-form" action="" method="POST" class="d-none">@csrf</form>
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
                        <th scope="col">Pangsa</th>
                        <th scope="col">Profit</th>
                        <th scope="col">TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($teams as $team)
                    <tr class="text-center align-middle">
                        <td style="width: 40%;">Perusahaan {{ $team -> id }}</td>
                        <td> 
                            {{ 
                                round($team ->rounds()->where('batch',$i)->sum("six_sigma"),2) 
                            }} 
                        </td>
                        <td> 
                            {{ 
                                round($team->rounds()->where('batch',$i)->sum("market_share")*100,2)
                            }} %
                        </td>
                        <td> 
                            {{ 
                                $team->rounds()->where('batch',$i)->sum("profit") 
                            }} 
                        </td>
                        <td>
                            {{ 
                                round($team ->rounds()->where('batch',$i)->sum("six_sigma"),2) +
                                round($team->rounds()->where('batch',$i)->sum("market_share")*0.2*100) +
                                $team->rounds()->where('batch',$i)->sum("profit")*0.2
                            }} 
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endfor

    <div class="row justify-content-center">
            <h2 class="text-center"><span class="badge bg-dark rounded mt-3"> HASIL AKHIR </span></h2>
            <table class="table table-striped table-warning table-bordered mt-2 shadow-sm" style="width: 85%">
                <thead>
                    <tr class="text-center align-middle">
                        <th scope="col">Nama Tim</th>
                        <th scope="col">Balance</th>
                        <th scope="col">TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($teams as $team)
                    <tr class="text-center align-middle">
                        <td style="width: 40%;">Perusahaan {{ $team -> id }}</td>
                        <td>{{ $team -> balance }}</td>
                        <td>
                            {{ 
                                round($team ->rounds()->sum("six_sigma"),2) +
                                round($team->rounds()->sum("market_share")*0.2*100) +
                                $team->rounds()->sum("profit")*0.2
                            }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
       
</body>
</html>