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

    <style>
        body {
            background-image: url('{{ asset('')}}assets/img/background.jpg');
            background-repeat: no-repeat;
            background-attachment: fixed;  
            background-size: cover;
        }
    </style>

</head>
<body>
    {{-- Navbar --}}
    <nav class="navbar justify-content-between px-3" style="background-color: #ffff; box-shadow: 5px 0px 5px rgba(0, 0, 0, 0.3);">
            {{-- Logo IG --}}
            <a class="navbar-brand" href="#">
                <img src="{{ asset('assets') }}/icons/Logo_IG_Header.png" alt="Logo IGXXX" style="max-height: 40px">
            </a>

            <form class="form-inline">
                {{-- Score Recap --}}
                <a  href="{{ route('score-recap') }}"><button class="btn btn-outline-success my-sm-0" type="button">Score Recap</button></a>
                {{-- Log out --}}
                <button class="btn btn-outline-danger my-sm-0" type="button" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</button>
            </form>
            
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
    </nav>

    <div class="row justify-content-center p-5">
        <div class="col">
            <div class="card bg-dark">
                <div class="card-body">
                    <h2 class="card-title text-center text-white">LEADERBOARD</h2>
                    <h4 class="card-title text-center text-white">LEVEL SIGMA</h4>
                    <ul class="list-group" id="leaderboard">
                        @foreach($leaderboard as $key=>$value)
                            <li class="list-group-item text-center fw-bold"><h4>{{ $key }}</h4></li>
                        @endforeach
                    </ul>   
                </div>
            </div>
        </div>
        <div class="col">
            <div class="row mb-2">
                <div class="col rounded-start bg-dark ms-2"><h1 class="text-center text-white py-2" id="batch">
                    @if($preparation)
                        Cooldown
                    @else
                        BATCH-{{ $batch }}
                    @endif
                    </h1>
                </div>
                <div class="col rounded-end bg-dark me-2"><h1 class="text-center text-white fw-bold py-2" id="timer">00:00</h1></div>
                <input type="hidden" id="time" value="{{ $time }}">
            </div>

            {{-- UMKM & Denda --}}
            <table class="table table-warning table-bordered shadow-sm">
                <thead>
                    <tr class="text-center align-middle">
                        <th><h3 class="fw-bold" >Jenis</h3></th>
                        <th><h3 class="fw-bold">Harga</h3></th>
                    </tr>
                </thead>
                <tbody>
                        <tr class="text-center align-middle">
                            <td class="border-0 text-center align-middle"><h4>UMKM</h4></td>
                            <td class="border-0 text-center align-middle"><h4>{{ $umkm }} TC</h4></td>
                        </tr>
                        <tr class="text-center align-middle">
                            <td class="border-0 text-center align-middle"><h4>Denda</h4></td>
                            <td class="border-0 text-center align-middle"><h4>{{ $denda }} TC</h4></td>
                        </tr>
                </tbody>
            </table>

            <div class="row mb-2">
                <div class="col rounded bg-dark mx-2"><h2 class="text-center text-white py-2">DEMAND</h2></div>
            </div>

            {{-- Demand --}}
            <table class="table table-light table-bordered shadow-sm">
                <thead>
                    <tr class="text-center align-middle">
                        <th><h3 class="fw-bold" >Produk</h3></th>
                        <th><h3 class="fw-bold">Harga</h3></th>
                        <th><h3 class="fw-bold">Sisa Demand</h3></th>
                    </tr>
                </thead>
                <tbody id="tbody-demand">
                    @foreach ($demands as $index=>$demand)
                        <tr class="text-center align-middle">
                            <td class="border-0 text-center align-middle"><h4>{{ $demand->name }}</h4></td>
                            <td class="border-0 text-center align-middle"><h4>{{ $price[$index] }} TC</h4></td>
                            <td class="border-0 text-center align-middle"><h4>{{ $demand->pivot->amount }}</h4></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script src="../js/app.js"></script>
    <script type="text/javascript">
        window.Echo.channel('update-demand').listen('.update', (e) => {
            if(e.preparation){
                $(`#batch`).text("BATCH " + e.batch)
            }else{
                $(`#batch`).text("Cooldown")            
            }

            $(`#time`).val(e.new_timer)

            $(`#tbody-demand`).empty()
            $(`#tbody-price`).empty()
            e.demands.forEach((demand,index) => {
                $(`#tbody-demand`).append(`
                    <tr>
                        <td class="border-0 text-center align-middle"><h4>${ demand.name }</h4></td>
                        <td class="border-0 text-center align-middle"><h4>${ e.price[index] } TC</h4></td>
                        <td class="border-0 text-center align-middle"><h4>${ demand.amount }</h4></td>
                    </tr>
                `)
            })
        })

        //update leaderboard
        window.Echo.channel('update-leaderboard').listen('.update', (e) => {
            $(`#leaderboard`).empty()
            // e.leaderboard.forEach(key =>{
            //     $(`<li class="list-group-item text-center fw-bold"><h4>${key}</h4></li>`).appendTo(leaderboard)
            // })
            $.each( e.leaderboard, function( key, value ){
                $(`<li class="list-group-item text-center fw-bold"><h4>${key}</h4></li>`).appendTo(leaderboard)
            })
        })

        // Update the timer terus menerus
        let x = setInterval(function() {
            // dapetin waktu target
            let time = $(`#time`).val()
            let countDownDate = new Date(time).getTime()
        
            // dapetin waktu sekarang
            let now = new Date().getTime()
            
            // cari jaraknya
            let distance = countDownDate - now;
            
            // ubah ke menit dan detik
            let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60))
            let seconds = Math.floor((distance % (1000 * 60)) / 1000)

            minutes = minutes < 10 ? '0' + minutes : minutes
            seconds = seconds < 10 ? '0' + seconds : seconds
            
            document.getElementById("timer").innerHTML = minutes + ":" + seconds
            
            // kalau waktu habis, ubah timer jadi 00:00
            if (distance < 0) {
                // clearInterval(x)
                document.getElementById("timer").innerHTML = "00:00"
            }
        }, 1000)
    </script>
</body>
</html>