<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('') }}assets/icons/logo.png">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('') }}assets/icons/logo.png">
    <title>Market Industrial Games 30</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
</head>
<body style="background-color: #FAF0DC">

    <div style="background-color: #EA435E;">
        <h3 class="text-center text-white fw-bolder">PASAR</h3>
    </div>

    <div class="align-center">
        <select name="selectBatch" id="selectBatch" class="form-select fw-bold" style="color: #EA435E;">
            @for ($i = 1; $i < 7; $i++)
                <option value="batch{{$i}}">Batch {{$i}}</option>
            @endfor
        </select>

        <table class="table table-hover bg-white rounded my-1">
            <thead>
                <tr class = "text-center align-middle">
                    <th scope="col">Nama Tim</th>
                    <th scope="col">Keripik Apel</th>
                    <th scope="col">Dodol Apel</th>
                    <th scope="col">Sari Buah Apel</th>
                    <th scope="col">Total</th>
                    <th scope="col">Hasil Penjualan</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < 10; $i++)
                    <tr class = "text-center align-middle">
                        <td>Perusahaan {{ $i + 1 }}</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>
</html>