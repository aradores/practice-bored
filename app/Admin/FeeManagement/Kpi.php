<?php

namespace App\Admin\FeeManagement;

use Repay\Fee\Enums\FeeKPIChartType;
use Repay\Fee\Services\FeeKPIService;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Attributes\On;
class Kpi extends Component
{

    public $date_from, $date_to;

    #[On('date-range-picker-fee-management')]
    public function changeDateRange($from =null , $to = null)
    {
        $this->date_from = $from;
        $this->date_to = $to;
    }

    public function getFilters(){
        $filters = [
            'date_from' => $this->date_from,
            'date_to' => $this->date_to
        ];
        return $filters;
    }

    public function getKpiData(){
        /* $kpi = app(FeeKPIService::class); */
        /* $filters = $this->getFilters();  */
        /* $data[] = $kpi->generate(FeeKPIChartType::MARKUP_REVENUE, $filters); */
        /* $data[] = $kpi->generate(FeeKPIChartType::CONVENIENCE_REVENUE, $filters); */
        /* $data[] = $kpi->generate(FeeKPIChartType::COMMISSION_REVENUE, $filters); */
        /* $data[] = $kpi->generate(FeeKPIChartType::AVG_MARKUP_REVENUE_PER_MERCHANT, $filters); */
        /* $data[] = $kpi->generate(FeeKPIChartType::AVG_CONVENIENCE_REVENUE_PER_MERCHANT, $filters); */
        /* $data[] = $kpi->generate(FeeKPIChartType::AVG_COMMISSION_REVENUE_PER_MERCHANT, $filters); */


        // dd($data);
        return [

        ];
    }

    #[Layout('layouts.admin')]
    public function render(){
        $data = $this->getKpiData();
        return view("admin.fee-management.kpi", ['data'=>$data]);
    }
}
