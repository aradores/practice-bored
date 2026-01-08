<?php 

namespace App\Admin\FeeManagement;

use Livewire\Attributes\Layout;
use Livewire\Component;

class ManageFees extends Component
{

    #[Layout('layouts.admin')]
    public function render(){
        return view("admin.fee-management.manage-fees");
    }
}
