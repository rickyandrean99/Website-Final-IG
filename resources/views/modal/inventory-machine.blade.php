<div class="modal fade" id="modalJualMesin" aria-hidden="true" aria-labelledby="modalJualMesinLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalJualMesinToggleLabel2">Jual</h5>
                <button type="button" class="btn-close" data-bs-toggle="modal" data-bs-target="#modalInventory"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><input type="hidden" id="sell-machine-id" value=""></p>
                <p><input type="hidden" id="sell-machine-type-id" value=""></p>
                <p>Nama Mesin : <span id="sell-machine-name"></span></p>
                <p>Masa Pakai : <span id="sell-machine-lifetime"></span></p>
                <p>Harga Jual : <span id="sell-machine-price"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalInventory"
                    onclick="sellMachine({{ $batch }})">Jual Mesin</button>
            </div>
        </div>
    </div>
</div>