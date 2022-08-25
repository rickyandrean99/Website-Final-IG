<div class="modal fade" id="modalUpgradeInventoryProduct" aria-hidden="true"
    aria-labelledby="modalUpgradeInventoryProduct" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalToggleLabel2">Upgrade Kapasitas Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-1">
                <table class="table table-hover bg-white rounded my-1 w-75">
                    <thead>
                        <tr class="text-center align-middle">
                            <th scope="col">Kapasitas Upgrade</th>
                            <th scope="col">Harga Upgrade</th>
                            <th scope="col">Biaya Simpan</th>
                            <th scope="col"><i class="bi-cart-check text-success fw-bold fs-2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($inventory2 as $inventory)
                        <tr class="text-center align-middle">
                            <td>{{ $inventory->upgrade_capacity }} </td>
                            <td>{{ $inventory->upgrade_price }}</td>
                            <td>{{ $inventory->rent_price }}</td>
                            <td>
                                <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                    onclick="upgradeInventory(2, {{$inventory->id}})">Beli</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>