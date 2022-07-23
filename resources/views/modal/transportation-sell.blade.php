<div class="modal fade" id="modalJualTransport" aria-hidden="true" aria-labelledby="modalJualTransportLabel"
    tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalToggleLabel2">Jual</h5>
                <button type="button" class="btn-close" data-bs-toggle="modal"
                    data-bs-target="#modalTransport"></button>
            </div>

            <div class="modal-body">
                <p><input type="hidden" id="sell-transport-id" value=""></p>
                <p>Nama Transportasi : <span id="sell-transport-name"></span></p>
                <p>Masa Pakai : <span id="sell-transport-lifetime"></span></p>
                <p>Harga Jual : <span id="sell-transport-price"></span></p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalTransport"
                    onclick="sellTransportations({{ $batch }})">Jual
                    Transoprtasi</button>
            </div>
        </div>
    </div>
</div>