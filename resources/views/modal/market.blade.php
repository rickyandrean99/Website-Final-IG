<div class="modal fade" id="modalMarketMenu" aria-hidden="true" aria-labelledby="modalMarketMenu" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h5 class="modal-title w-100" id="marketPlaceLabel">MARKET</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row px-4">
                    <!-- <button class="btn btn-primary" data-bs-target="#modalBahanBaku" data-bs-toggle="modal">Bahan
                        Baku</button> -->
                    <button class="col-12 btn btn-outline-primary my-2" data-bs-target="#modalMachine"
                        data-bs-toggle="modal">
												<i class="bi-tools fw-bold"></i>
												Machine</button>
                    <button class="col-12 btn btn-outline-primary my-2" data-bs-target="#modalMarketTransport"
                        data-bs-toggle="modal">
												<i class="bi-truck fw-bold"></i>
												Transport</button>
                    <button type="button" class="col-12 btn btn-outline-info my-2" onclick="buyFridge({{ $team->id }})">
                        <i class="bi-snow fw-bold"></i>
                        &nbsp; Beli Kulkas</button>      
                </div>
            </div>
            <div class="modal-footer">
                <div class="col text-end">
										<button class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>