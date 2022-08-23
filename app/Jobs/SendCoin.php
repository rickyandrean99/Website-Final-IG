<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Team;
use App\Batch;
use App\Transaction;
use App\Events\SendTransactionCoin;
use DB;

class SendCoin implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $team_id;
    public $transaction_id;
    public $coin;

    public function __construct($team_id, $transaction_id, $coin)
    {
        $this->team_id = $team_id;
        $this->transaction_id = $transaction_id;
        $this->coin = $coin;
    }

    public function handle()
    {
        // Update balance team
        $team = Team::find($this->team_id);
        $team->increment('balance', $this->coin);

        // Ubah status transaksi menjadi sukses
        $transaction = Transaction::find($this->transaction_id);
        $transaction->received = true;
        $transaction->save();

        // Menambahkan Histori
        DB::table('histories')->insert([
            "teams_id" => $this->team_id,
            "kategori" => "PENJUALAN",
            "batch" => Batch::find(1)->batch,
            "type" => "IN",
            "amount" => $this->coin,
            "keterangan" => "Berhasil mendapatkan coin sejumlah ".$this->coin." TC dari hasil penjualan"
        ]);

        // Push balance terbaru ke dashboard TO
        event(new SendTransactionCoin($this->team_id, $team->balance, $this->coin));
    }
}