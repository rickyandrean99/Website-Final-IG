<div class="modal fade" id="modalTambahTC" aria-hidden="true" aria-labelledby="modalTambahTCLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h5 class="modal-title w-100">TAMBAH TIGGIE COIN</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{-- Metode Pengiriman --}}
                <label for="metode" class="col-form-label mx-2 my-3 fw-bold">Jenis Input TC: </label>
                <div class="form-check-inline">
                    <label class="form-check-label" for="metode1">
                        <input class="form-check-input" type="radio" name="metode" id="metode1" value="1" checked>
                        Non Hutang
                    </label>
                </div>
                <div class="form-check-inline">
                    <label class="form-check-label" for="metode2">
                        <input class="form-check-input" type="radio" name="metode" id="metode2" value="2">
                        Hutang
                    </label>
                </div>
                <div class="mb-3">
                    <label for="jumlah-tc" class="col-form-label">Jumlah TC</label>
                    <div class="d-flex flex-row">
                        <input type="number" class="form-control w-50" id="jumlah-tc">
                        <button type="button" class="btn btn-success w-25 ms-2" id="btnTambahTC"
                        data-bs-toggle="modal" onclick="addCoin()">Tambah</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>