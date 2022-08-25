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
    <button type="button" class="btn btn-block btn-outline-danger m-2" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-danger">Logout</button>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
    
    <div style="background-color: #EA435E;">
        <h3 class="text-center text-white fw-bolder">UPGRADE</h3>
    </div>
    
    <table class="table table-hover bg-white rounded my-1">
        <thead>
            <tr class="text-center align-middle">
                <th scope="col">Nama Tim</th>
                <th scope="col">Nama Mesin</th>
                <th scope="col">Level</th>
                <th scope="col">Defect</th>
                <th scope="col">Limit</th>
                <th scope="col"><i class="bi-arrow-up-right-square-fill text-success fw-bold"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($teams as $team)
                <tr class="text-center align-middle">
                    <td class="w-25">{{ $team->name }}</td>
                    <td class="w-25">
                        <select name="selectMachine" id="select-machine-{{$team->id}}" class="form-select fw-bold" onchange="updateLevel({{ $team->id }})">
                            <option value="" disabled selected>Pilih Mesin</option>
                            @foreach($team->machineTypes as $machine)
                                @if($machine->pivot->exist) 
                                    <option value="{{ $machine->pivot->id }}" machinetypeid="{{ $machine->id }}">{{ $machine->name_type }} {{ $machine->pivot->id}}</option>
                                @endif
                            @endforeach
                        </select>
                    </td>
                    <td class="w-20">
                        <div><span id="level-mesin-{{$team->id}}">0</span></div>
                    </td>
                    <td class="w-20">
                        <div><span id="defect-mesin-{{$team->id}}">0</span></div>
                    </td>
                    <td class="w-20" id="limit-{{$team->id}}">{{ $team->upgrade_machine_limit }}</td>
                    <td>
                        <button type="button" class="btn btn-block btn-success m-2" 
                        data-bs-target="#modalJualMachine" data-bs-toggle="modal"
                        onclick="showMachineUpgrade({{ $team->id }})">Upgrade</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- MODAL KONFIRMASI UPGRADE -->
    <div class="modal fade" id="modalJualMachine" aria-hidden="true"
    aria-labelledby="modalJualTransportLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalToggleLabel2">Upgrade Mesin</h5>
                    <button type="button" class="btn-close" data-bs-toggle="modal"
                        data-bs-target="#modalTransport"></button>
                </div>

                <div class="modal-body">
                    <p><input type="hidden" id="sell-machine-team" value=""></p>
                    <p><input type="hidden" id="sell-machine-id" value=""></p>
                    <p><input type="hidden" id="sell-machine-type" value=""></p>

                    <p>Nama Tim : <span id="sell-machine-tim"></span></p>
                    <p>Nama Mesin : <span id="sell-machine-name"></span></p>
                    <p>Level : <span id="sell-machine-level"></span></p>
                    <p>Biaya Upgrade : <span id="sell-machine-price"></span></p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-toggle="modal"
                    onclick="upgradeMachine()">Upgrade Mesin</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script type="text/javascript">

        // update level
        const updateLevel = (id) => {
            let machine_id = $(`#select-machine-${id}`).val()
            let machine_types_id = $(`#select-machine-${id}`).find(":selected").attr("machinetypeid")

            $.ajax({
                type: 'POST',
                url: '{{ route("update-level") }}',
                data: {
                    '_token': '<?php echo csrf_token() ?>',
                    'machine_id': machine_id,
                    'machine_types_id': machine_types_id,
                    'id': id
                },
                success: function(data) {
                    $(`#level-mesin-${id}`).text(data.level)
                    $(`#defect-mesin-${id}`).text(data.defect)
                },
                error: function(error) {
                    showError(error)
                }
            })
        }

        //show machine upgrade
        const showMachineUpgrade = (id) =>{
            let machine_id = $(`#select-machine-${id}`).val()
            let machine_types_id = $(`#select-machine-${id}`).find(":selected").attr("machinetypeid")

            if (machine_id == null) {
                alert("Pilih mesin terlebih dahulu!")
                return
            }

            $.ajax({
                type: 'POST',
                url: '{{ route("machine.getbyid2") }}',
                data: {
                    '_token': '<?php echo csrf_token() ?>',
                    'machine_id': machine_id,
                    'machine_types_id': machine_types_id,
                    'id': id
                },
                success: function(data) {
                    $(`#sell-machine-team`).val(id)
                    $(`#sell-machine-id`).val(machine_id)
                    $(`#sell-machine-type`).val(machine_types_id)
                    $(`#sell-machine-tim`).text("Perusahaan " + id)
                    $(`#sell-machine-name`).text(data.name +" " + machine_id)
                    $(`#sell-machine-level`).text(data.level)
                    $(`#sell-machine-price`).text(data.price)
                },
                error: function(error) {
                    showError(error)
                }
            })
        }

        // upgrade machine
        const upgradeMachine = () =>{
            let id = $(`#sell-machine-team`).val()
            let machine_id = $(`#sell-machine-id`).val()
            let machine_types_id = $(`#sell-machine-type`).val()

            if (machine_id == null) {
                alert("Pilih mesin terlebih dahulu!")
                return
            }

            $.ajax({
                type: 'POST',
                url: '{{ route("upgrade-machine") }}',
                data: {
                    '_token': '<?php echo csrf_token() ?>',
                    'machine_id': machine_id,
                    'machine_types_id': machine_types_id,
                    'id': id
                },
                success: function(data) {
                    alert(data.message)
                    if (data.status == "success") {
                        $(`#level-mesin-${id}`).text(data.level)
                        $(`#defect-mesin-${id}`).text(data.defect)
                        $(`#limit-${id}`).text(data.limit)
                    }
                },
                error: function(error) {
                    showError(error)
                }
            })
        }

        const showError = (error) => {
            let errorMessage = JSON.parse(error.responseText).message
            alert(`Error: ${errorMessage}`)
            console.log(`Error: ${errorMessage}`)
        }
    </script>
</body>
</html>