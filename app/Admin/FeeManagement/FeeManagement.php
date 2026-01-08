<?php

namespace App\Admin\FeeManagement;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Url;
use Livewire\Component;

class FeeManagement extends Component
{
    #[Layout('layouts.admin')]

    #[Locked]
    public $allowedTabs = ['manage-fees', 'audit-trail', 'KPIs'];

    #[Url]
    public $selectedTab;

    public function mount()
    {
        if (in_array($this->selectedTab, $this->allowedTabs)) {
            $this->selectedTab = $this->selectedTab ?? 'manage-fees';
        } else {
            $this->selectedTab = $this->allowedTabs[0];
        }
    }

    public function render()
    {
        return view('admin.fee-management.fee-management');
    }
}
