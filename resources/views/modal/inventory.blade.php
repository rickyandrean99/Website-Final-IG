<div class="modal fade p-3" id="modalInventory" aria-hidden="true" aria-labelledby="modalInventoryLabel" tabindex="-1">
    <div class="modal-dialog modal-fullscreen w-100">
        <div class="modal-content rounded">
            <div class="modal-header text-center">
                <h5 class="modal-title w-100" id="exampleModalToggleLabel2">INVENTORY</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    {{-- BAHAN BAKU --}}
                    <div class="col-4">
                        <div class="bg-info rounded">
                            <h3 class="text-center text-gray-100">BAHAN BAKU</h3>
                            <div class="d-flex justify-content-center text-gray-100">
                                <h5 id="used-capacity-ingredient">{{ $team->ingredients->sum('pivot.amount') }}</h5>
                                <h5>/</h5>
                                <h5>{{ $team->ingredient_inventory }}</h5>
                            </div>
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col" class="border-0 text-center">No.</th>
                                    <th scope="col" class="border-0 text-center">Nama Bahan</th>
                                    <th scope="col" class="border-0 text-center">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-ingredient">
                                @php
                                $i = 1
                                @endphp
                                @foreach ($team->ingredients as $ingre)
                                <tr>
                                    <td class="border-0 text-center align-middle">{{ $i++ }}</td>
                                    <td class="border-0 text-center align-middle">
                                        {{ $ingre->name }}</td>
                                    <td class="border-0 text-center align-middle">
                                        {{ $ingre->pivot->amount}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- MESIN --}}
                    <div class="col-4">
                        <div class="bg-info rounded">
                            <h3 class="text-center text-gray-100">MESIN</h3>
                            <div class="d-flex justify-content-center text-gray-100">
                                <h5>-------</h5>
                            </div>

                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col" class="border-0 text-center">No.</th>
                                    <th scope="col" class="border-0 text-center">Nama Mesin</th>
                                    <th scope="col" class="border-0 text-center">Level</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-machine">
                                @php
                                $i = 1
                                @endphp
                                @foreach ($team->machineTypes as $machine)
                                @if($machine->pivot->exist)
                                <tr>
                                    <td class="border-0 text-center align-middle">{{ $i++ }}</td>
                                    <td class="border-0 text-center align-middle">
                                        {{ $machine->name_type }} {{$machine->pivot->id}}</td>
                                    <td class="border-0 text-center align-middle">
                                        {{ $machine->pivot->level}}</td>
                                    <td class="border-0 text-center align-middle">
                                        <button type="button" class="btn btn-danger" data-bs-target="#modalJualMesin"
                                            data-bs-toggle="modal"
                                            onclick="showMachineSell({{ $machine->pivot->id }}, {{ $machine->pivot->machine_types_id }})">Jual</button>
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- PRODUK --}}
                    <div class="col-4">
                        <div class="bg-info rounded">
                            <h3 class="text-center text-gray-100">PRODUK</h3>
                            <div class="d-flex justify-content-center text-gray-100">
                                <h5 id="used-capacity-product">{{ $team->products->sum('pivot.amount') }}</h5>
                                <h5>/</h5>
                                <h5>{{ $team->product_inventory }}</h5>
                            </div>
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col" class="border-0 text-center">No.</th>
                                    <th scope="col" class="border-0 text-center">Nama Produk</th>
                                    <th scope="col" class="border-0 text-center">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $i = 1
                                @endphp
                                @foreach ($team->products as $product)
                                <tr>
                                    <td class="border-0 text-center align-middle">{{ $i++ }}</td>
                                    <td class="border-0 text-center align-middle">
                                        {{$product->name}} {{$product->pivot->id}}</td>
                                    <td class="border-0 text-center align-middle">
                                        {{ $product->pivot->amount}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalUpgradeInventoryIngredient">+ Kapasitas Bahan Baku</button>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalUpgradeInventoryProduct">+ Kapasitas Produk</button>
            </div>
        </div>
    </div>
</div>