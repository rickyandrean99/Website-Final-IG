<div class="modal fade p-5" id="modalProduksi" tabindex="-1" role="dialog" aria-labelledby="modal-default"
    aria-hidden="true">
    <div class="modal-dialog modal-fullscreen w-100" role="document">
        <div class="modal-content rounded">
            <div class="modal-header text-center">
                <h5 class="modal-title w-100" id="modalProduksiLabel">PRODUKSI</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-centered table-nowrap" style="vertical-align:middle">
                    <thead class="thead-dark">
                        <tr>
                            <th class="border-0 rounded-start text-center">No</th>
                            <th class="border-0 text-center">Produk</th>
                            <th class="border-0 text-center">Bahan</th>
                            <th class="border-0 text-center">Mesin</th>
                            <th class="border-0 rounded-end text-center">Jumlah Produksi</th>
                        </tr>
                    </thead>
                    <input type="hidden" value="0" id="production-amount" />
                    <tbody class="border-0" id="tbody-produksi">

                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                <div class="row w-100">
                    <div class="col">
                        <button class='btn btn-secondary' id='btnAdd' onclick="addProduction()">+ Tambah
                            Produksi</button>
                    </div>
                    <div class="col text-end">
                        <button class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
                        <button class='btn btn-success' id='btnProduksi' onclick="startProduction()">Mulai
                            Produksi</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>