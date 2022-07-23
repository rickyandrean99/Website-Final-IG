<div class="modal fade p-5" id="modalBahanBaku" tabindex="-1">
    <div class="modal-dialog modal-fullscreen w-100">
        <div class="modal-content rounded">
            <div class="modal-header d-flex align-items-center justify-content-center position-relative">
                <h5 class="modal-title text-center fw-bolder">BAHAN BAKU</h5>
                <button type="button" class="btn-close position-absolute" data-bs-dismiss="modal" style="right: 20px"></button>
            </div>
            <div class="modal-body px-5 py-4">
                <div class="row">
                    <div class="col-7">
                        <div class="table-responsive">
                            <table class="table table-centered table-nowrap" style="width: 100%">
                                <thead class="thead-dark" style="table-layout: fixed; width: calc( 100% - 1em ); display: table;">
                                    <tr>
                                        <th class="border-0 rounded-start text-center" style='width:10%'>No</th>
                                        <th class="border-0 text-center" style='width:40%'>Bahan Baku</th>
                                        <th class="border-0 rounded-end text-center" style='width:50%'>Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody class="border-0" style="display: block; overflow-y: auto; height: 70vh;">
                                    @foreach($ingredient as $i)
                                    <tr style='display: table; table-layout: fixed; width: 100%'>
                                        <input type="hidden" class="ingredient-id" value="{{ $i->id }}">
                                        <input type="hidden" class="ingredient-price" id="ingredient-price-{{ $i->id }}" value="{{ $i->price }}">
                                        <td class="border-0 text-center" style='width:10%'>{{ $i->id }}</td>
                                        <td class="border-0 text-center" style='width:40%'>{{ $i->name }}</td>
                                        <td class="border-0 text-center text-danger" style='width:50%'>
                                            <input type="number" style="margin: auto" class="form-control ingredient-amount w-50 text-center" id="ingredient-amount-{{ $i->id }}" value="0" min="0" onchange="updateIngredientPriceAndLimit()">
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-5 px-5">
                        <div class="row mt-3">
                            <div class="col-6 bg-info text-white text-center fw-bold p-3 rounded-start">Limit</div>
                            <div class="col-6 bg-primary text-white text-center fw-bold p-3 rounded-end">
                                <span id="package-limit">{{ $limit }}</span>
                                <input type="hidden" id="package-limit-hidden" value="{{ $limit }}">
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-6 bg-info text-white text-center fw-bold p-3 rounded-start">Pengeluaran</div>
                            <div class="col-6 bg-primary text-white text-center fw-bold p-3 rounded-end"id="pengeluaran-ingredient">0 TC</div>
                        </div>

                        <div class="row mt-4">
                            <button class="btn btn-success fw-bold p-3 text-white"style="font-size: 20px; font-weight: bold" onclick="buyIngredients()">Buy</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>