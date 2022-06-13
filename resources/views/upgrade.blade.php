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
            @foreach ($teams as $team)
                <tr class = "text-center align-middle">
                    <td class="w-25">Perusahaan {{ $team->id }}
                    </td>
                    <td class="w-25">
                        <select name="selectMachine" id="select-machine-{{$team->id}}" class="form-select fw-bold"
                        onchange="updateLevel({{ $team->id }})">
                            <option value="test">Pilih Mesin</option>
                            @foreach ($team->machineTypes as $machine) 
                                <option value="{{ $machine->pivot->id }}" machinetypeid="{{ $machine->id }}">{{ $machine->name_type }} {{ $machine->pivot->id}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td class="w-25">
                        <div id="level-mesin-{{$team->id}}"> 0 </div>
                    </td>
                    <td>
                        <button type="button" class="btn btn-block btn-success m-2">Upgrade</button>
                    </td>
                    <td>
                        <button type="button" class="btn btn-block btn-primary m-2" onclick="buyFridge({{  $team->id }})">Buy Fridge</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>

    <script type="text/javascript">
        //beli kulkas
        const buyFridge = (id) => {
            if (!confirm("Are you sure?")) return

            $.ajax({
                type: 'POST',
                url: '{{ route("buy-fridge") }}',
                data: {
                    '_token': '<?php echo csrf_token() ?>',
                    'id': id
                },
                success: function(data) {
                    alert(data.message)
                }
            })
        }

        //update level
        const updateLevel = (id) => {
            let machine_id = $(`#select-machine-${id}`).val()
            alert(machine_id)
            alert(id)

            $.ajax({
                type: 'POST',
                url: '{{ route("update-level") }}',
                data: {
                    '_token': '<?php echo csrf_token() ?>',
                    'machine_id': machine_id,
                    'id': id
                },
                success: function(data) {
                    alert(data.message)
                }
            })
        }
    </script>
</body>
</html>