<div class="modal fade p-5" id="modalTransport" aria-hidden="true" aria-labelledby="modalTransportLabel" tabindex="-1">
    <div class="modal-dialog modal-fullscreen w-100">
        <div class="modal-content rounded">
            <div class="modal-header text-center">
                <h5 class="modal-title w-100">TRANSPORTATION</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="border-0 text-center">No</th>
                            <th class="border-0 text-center">Jenis</th>
                            <th class="border-0 text-center">Kapasitas</th>
                            <th class="border-0 text-center">Durasi</th>
                            <th class="border-0 text-center">Masa Pakai</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-transportation">
                        @php
                        $i = 1
                        @endphp
                        @foreach ($team->transportations as $transportation)
                        @if($transportation->pivot->exist)
                        <tr>
                            <td class="border-0 text-center align-middle">{{ $i++ }}</td>
                            <td class="border-0 text-center align-middle">{{ $transportation->name }}
                            </td>
                            <td class="border-0 text-center align-middle">
                                {{ $transportation->capacity }}</td>
                            <td class="border-0 text-center align-middle">
                                {{ $transportation->duration }}</td>
                            <td class="border-0 text-center align-middle">
                                {{ $batch -$transportation->pivot->batch  +1}}</td>

                            <td class="border-0 text-center align-middle">
                                <button type="button" class="btn btn-danger" data-bs-target="#modalJualTransport"
                                    data-bs-toggle="modal"
                                    onclick="showTransportSell({{ $transportation->pivot->id }})">Jual</button>
                            </td>
                        </tr>
                        @endif
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