<?php

namespace App\Admin\Cashoutflow;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Url;
use Livewire\Component;

class Manage extends Component
{
    #[Layout('layouts.admin')]

    #[Locked]
    public $allowedTabs = ['manage-fees', 'audit-trail', 'KPIs'];

    #[Url]
    public $selectedTab;

    public function render()
    {
        return view('admin.cashout-flow.manage');
    }
}
