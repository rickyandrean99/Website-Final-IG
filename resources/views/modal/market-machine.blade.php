<div class="modal fade p-5" id="modalMachine" aria-hidden="true" aria-labelledby="modalMachineLabel" tabindex="-1">
    <div class="modal-dialog modal-fullscreen" style="margin: auto; width: 60%">
        <div class="modal-content rounded">
            <div class="modal-header d-flex align-items-center justify-content-center position-relative">
                <div>
                    <h5 class="modal-title text-center fw-bolder">Mesin</h5>
                </div>

                <button type="button" class="btn-close position-absolute" data-bs-dismiss="modal" aria-label="Close"
                    style="right: 20px"></button>
            </div>
            <div class="modal-body px-5 py-4">
                <div class="row">
                    <div class="col-9">
                        <div class="table-responsive">
                            <table class="table table-centered table-wrap">
                                <thead>
                                    <tr>
                                        <th class="border-0 text-center">No</th>
                                        <th class="border-0 text-center">Mesin</th>
                                        <th class="border-0 text-center">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $index = 1 @endphp
                                    @foreach($machines as $machine)
                                    <tr>
                                        <td class="border-0 text-center align-middle">{{ $index++ }}
                                            <input type="hidden" class="machine-id" value="{{ $machine->id }}">
                                        </td>
                                        <td class="border-0 text-center align-middle">
                                            {{ $machine->name_type }}</td>
                                        <td class="border-0 text-center align-middle">
                                            <input type="number" style="margin: auto"
                                                class="form-control machine-amount w-50 text-center"
                                                id="machine-amount-{{ $machine->id }}" value="0" min="0"
                                                onchange="updateMachinePrice()">
                                        </td>
                                        <input type="hidden" class="machine-price" id="machine-price-{{ $machine->id }}"
                                            value="{{ $machine->price }}">
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-3 px-4 py-4">
                        <!-- Total Pengeluaran -->
                        <div class="row position-fixed" style="width:160px;">
                            <div class="col-12 bg-info rounded-top text-white text-center fw-bold ">
                                Pengeluaran
                            </div>
                            <div class="col-12 bg-primary rounded-bottom text-white text-center"
                                id="pengeluaran-machine">
                                0 TC
                            </div>
                        </div>

                        <!-- Buy Button -->
                        <div class="row mt-5 pt-3 position-fixed" style="width:160px;">
                            <button class="btn btn-success fw-bold p-3 text-white"
                                style="font-size: 20px; font-weight: bold"
                                onclick="buyMachine({{ $batch }})">Buy</button>
                            <!-- <button class="col-12 btn btn-success fw-bold p-3 text-white" data-bs-toggle="modal"
                                                data-bs-target="#modalBeliMachine" style="font-size: 20px; font-weight: bold">Buy</button> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>