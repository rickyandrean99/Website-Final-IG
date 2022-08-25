<div class="modal fade" id="modalInfoHutang" aria-hidden="true" aria-labelledby="modalInfoHutangLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h5 class="modal-title w-100">INFO HUTANG</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <h2 id="jumlahHutang"></h2>

                    <div class="mb-3">
                        <label for="jumlah-bayar" class="col-form-label">Bayar Hutang</label>
                        <div class="d-flex flex-row">
                            <input type="number" class="form-control w-50" id="jumlah-bayar">
                            <button type="button" class="btn btn-success w-25 ms-2" id="btnBayarHutang"
                            data-bs-toggle="modal" onclick="bayarHutang()">Bayar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>