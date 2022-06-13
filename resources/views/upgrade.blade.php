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
    <div style="background-color: #EA435E;">
        <h3 class="text-center text-white fw-bolder">UPGRADE</h3>
    </div>
    <table class="table table-hover bg-white rounded my-1">
        <thead>
            <tr class = "text-center align-middle">
                <th scope="col">Nama Tim</th>
                <th scope="col">Nama Mesin</th>
                <th scope="col">Level</th>
                <th scope="col"><i class="bi-arrow-up-right-square-fill text-success fw-bold"></th>
                <th scope="col"><i class="bi-snow text-primary fw-bold"></i></th>
            </tr>
        </thead>
        <tbody>
            @for ($i = 1; $i <= 10; $i++)
                <tr class = "text-center align-middle">
                    <td class="w-25">Perusahaan {{ $i }}
                        <input type="hidden" class="team-id" value="{{ $i }}">
                    </td>
                    <td class="w-25">
                        <select name="selectMachine" id="selectMachine" class="form-select fw-bold">
                            @for ($j = 0; $j < 7; $j++)
                                <option value="test">test</option>
                            @endfor
                        </select>
                    </td>
                    <td class="w-25">
                        <p> 1 <p> 
                    </td>
                    <td>
                        <button type="button" class="btn btn-block btn-success m-2">Upgrade</button>
                    </td>
                    <td>
                        <button type="button" class="btn btn-block btn-primary m-2" onclick="buyFridge()">Buy Fridge</button>
                    </td>
                </tr>
            @endfor
        </tbody>
    </table>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>

    <script type="text/javascript">
        //beli kulkas
        const buyFridge = () => {
            id = $('#team-id').val()
            alert(id)

            // if (!confirm("Are you sure?")) return

            // let machineId = $(`.machine-id`).map(function() {
            //     return $(this).val()
            // }).get()
            // let machineAmount = $(`.machine-amount`).map(function() {
            //     return $(this).val()
            // }).get()

            // $.ajax({
            //     type: 'POST',
            //     url: '{{ route("buy-machine") }}',
            //     data: {
            //         '_token': '<?php echo csrf_token() ?>',
            //         'machine_id': machineId,
            //         'machine_amount': machineAmount
            //     },
            //     success: function(data) {
            //         if (data.status == "success") {
            //             $(`.machine-amount`).val(0)
            //             $(`#pengeluaran-machine`).text("0 TC")
            //         }
            //         alert(data.message)
            //     }
            // })
        }
    </script>
</body>
</html>