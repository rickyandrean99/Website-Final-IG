<div class="modal fade p-5" id="modalMarketTransport" aria-hidden="true" aria-labelledby="modalMarketTransportLabel"
    tabindex="-1">
    <div class="modal-dialog modal-fullscreen" style="margin: auto; width: 60%">
        <div class="modal-content rounded">
            <div class="modal-header d-flex align-items-center justify-content-center position-relative">
                <div>
                    <h5 class="modal-title text-center fw-bolder">Transportation</h5>
                </div>

                <button type="button" class="btn-close position-absolute" data-bs-dismiss="modal" aria-label="Close"
                    style="right: 20px"></button>
            </div>
            <div class="modal-body px-5 py-4">
                <div class="row">
                    <div class="col-8">
                        <div class="table-responsive">
                            <table class="table table-centered table-wrap">
                                <thead>
                                    <tr>
                                        <th class="border-0 rounded-start text-center">No</th>
                                        <th class="border-0 text-center">Kendaraan</th>
                                        <th class="border-0 rounded-end text-center">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transportations as $transportation)
                                    <tr>
                                        <td class="border-0 text-center">{{ $transportation->id }}
                                            <input type="hidden" class="transportation-id"
                                                value="{{ $transportation->id }}">
                                        </td>
                                        <td class="border-0 text-center">{{ $transportation->name }}
                                        </td>
                                        <td class="border-0 text-center text-danger">
                                            <input type="number" style="margin: auto"
                                                class="form-control transportation-amount w-50 text-center"
                                                id="transportation-amount-{{ $transportation->id }}" value="0" min="0"
                                                onchange="updateTransportationPrice()">
                                        </td>
                                        <input type="hidden" class="transportation-price"
                                            id="transportation-price-{{ $transportation->id }}"
                                            value="{{ $transportation->price }}">

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-4 px-4 py-4">
                        <!-- Total Pengeluaran -->
                        <div class="row position-fixed" style="width:160px;">
                            <div class="col-12 bg-primary rounded-top text-white text-center fw-bold ">
                                Pengeluaran
                            </div>
                            <div class="col-12 bg-info rounded-bottom text-white text-center fw-bold " ,
                                id="pengeluaran-transportation">
                                0 TC
                            </div>
                        </div>

                        <!-- Buy Button -->
                        <div class="row mt-5 pt-2 position-fixed" style="width:160px;">
                            <button class="btn btn-success fw-bold p-3 text-white"
                                style="font-size: 20px; font-weight: bold"
                                onclick="buyTransportations({{ $batch }})">Buy</button>
                            <!-- <button class="col-12 btn btn-success fw-bold p-3 text-white" data-bs-toggle="modal"
                                                data-bs-target="#modalBeliTransport"style="font-size: 20px; font-weight: bold">Buy</button> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="col text-end">
                    <button class="btn btn-primary" data-bs-target="#modalMarketMenu"
																				data-bs-toggle="modal">Kembali</button>
                </div>
            </div>
        </div>
    </div>
</div>