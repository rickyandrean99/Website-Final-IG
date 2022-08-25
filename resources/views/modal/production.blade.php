<div class="modal fade p-5" id="modalProduksi" tabindex="-1" role="dialog" aria-labelledby="modal-default"
    aria-hidden="true">
    <div class="modal-dialog modal-fullscreen w-100" role="document">
        <div class="modal-content rounded">
            <div class="modal-header text-center">
                <h5 class="modal-title w-100" id="modalProduksiLabel">PRODUKSI</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modal-body-production">
                
            </div>

            <div class="modal-footer">
                <div class="row w-100">
                    <div class="col">
                        <button class='btn btn-secondary' id='btnAdd' onclick="addProduction()">+ Tambah
                            Produksi</button>
                    </div>
                    <div class="col text-end">
                        <button class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
                        <button class='btn btn-success' data-bs-toggle="modal" id='btnProduksi' onclick="startProduction()">Mulai
                            Produksi</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>