<div class="modal fade" id="modalMarketMenu" aria-hidden="true" aria-labelledby="modalMarketMenu" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h5 class="modal-title w-100" id="marketPlaceLabel">MARKET</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <!-- <button class="btn btn-primary" data-bs-target="#modalBahanBaku" data-bs-toggle="modal">Bahan
                        Baku</button> -->
                    <button class="btn btn-primary" data-bs-target="#modalMachine"
                        data-bs-toggle="modal">Machine</button>
                    <button class="btn btn-primary" data-bs-target="#modalMarketTransport"
                        data-bs-toggle="modal">Transport</button>
                    <button type="button" class="btn btn-info" onclick="buyFridge({{ $team->id }})">
                        <i class="bi-snow text-white fw-bold"></i>
                        &nbsp; Beli Kulkas</button>      
                </div>
            </div>
        </div>
    </div>
</div>