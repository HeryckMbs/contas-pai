<?php
namespace App\Jobs;

use App\Exports\UsersExport;
use App\Http\Service\ReportService;
use App\Models\Report;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class GenerateReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Report $report;

    public function __construct(Report $report)
    {
        $this->report = $report;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        

        try{
            $this->report->update(['status' => 'executando']);
            
           

            $nameFile = "Report_{$this->report->type}_{$this->report->id}";

            if($this->report->type == 'credit_card'){
                $this->creditCard($nameFile);
            }else{
                $this->bills($nameFile);
            }

            

            $this->report->update([
                'status' => 'sucesso',
                'url_report' => asset("reports/{$nameFile}.pdf"),
                'url_report_excel' => '',
            ]);

        }catch(Exception $e){
            info($e);
            $this->report->update(['status' => 'erro']);
        }
    }

    public function creditCard($nameFile){
        $data = ReportService::getMonthlyPurchasesByCard($this->report->ano,$this->report->mes);

 
        $pdf = Pdf::loadView('pdf.invoice', [
            'foo'=> $data,
            'report' => $this->report
        ]);
        
        Storage::disk('reports')->put($nameFile.".pdf", $pdf->stream());

    }
    public function bills($nameFile){
        $data = ReportService::generateBillReport($this->report->ano,$this->report->mes);

 
        $pdf = Pdf::loadView('pdf.extrato', [
            'foo'=> $data,
            'report' => $this->report
        ]);
        
        Storage::disk('reports')->put($nameFile.".pdf", $pdf->stream());

    }
}
