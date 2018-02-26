<?php

namespace App\Jobs;

use App\Models\DataToPdf;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class GenerateFilePdf implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected $plano;
    protected $uasg;
    protected $filename;


    public function __construct($plano, $uasg , $filename){
        $this->uasg = $uasg;
        $this->plano = $plano;
        $this->filename = $filename;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(DataToPdf $pdf){
        try {
            \Log::alert("[Arquivo: .pdf foi exportado com sucesso!]");
            $pdf->gerarPDF($this->plano,$this->uasg,$this->filename);
        }
        catch (Exception $e) {
            \Log::error('Falha ao processar o Job : ' . $e->getMessage() .' na linha :' . $e->getLine());
        }
    }
}
