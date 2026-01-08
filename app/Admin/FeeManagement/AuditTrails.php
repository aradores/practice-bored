<?php 

namespace App\Admin\FeeManagement;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Attributes\Url;
class AuditTrails extends Component
{
    #[Layout('layouts.admin')]
    public function render(){
        return view("admin.fee-management.audit-trails");
    }
}
