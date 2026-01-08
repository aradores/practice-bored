<?php 

namespace App\Admin\Components\ManageFees;

use Livewire\Component;
use Livewire\Attributes\On;

class KpiChartCard extends Component{
    public $class;
    public $title;
    public $tooltip;
    public $chartId;
    public $total;
    public $previous;
    public $percentageDifferential;
    public array $labels;
    public array $chartData = [];



    public function render(){
        return view("admin.components.manage-fees.kpi-chart-card");
    }
}
