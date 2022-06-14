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
    <div class="d-flex justify-content-center p-5">
        <div class="card " style="width: 20rem;">
        <img src="https://c.tenor.com/MgVKRHA7lUcAAAAd/tentara-itu-harus-hitam-meme-tentara.gif" class="card-img-top" alt="updet">
            <div class="card-body shadow">
                <h5 class="card-title text-center">UPDATE BATCH</h5>
                <p class="card-text text-center">Tombol dibawah kalo dipencet nanti bakal ganti batch oke, cek dulu kesesuaian batchnya sebelum tekan tombol ! >:D</p>
                <div class="d-flex justify-content-center">
                    <button type="button" class="btn btn-block btn-outline-success m-2">Update</button>
                    <button type="button" class="btn btn-block btn-outline-warning m-2">Preperation</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>
</html>