<?php

namespace App\Admin\Components\ManageFees;

use Livewire\Component;
use App\Models\Merchant;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;
use Repay\Fee\Models\FeeTransaction;
use App\Traits\WithCustomPaginationLinks;
use Repay\Fee\Enums\FeeTransactionStatus;
use App\Services\UnsettledFeesTablePaginator;

class MerchantUnsettledFees extends Component{
    use WithPagination, WithCustomPaginationLinks;
    
    public Merchant $merchant;

    public $filters = null;
    #[Url]
    public $search;
    public $date_to, $date_from;

    public $perPage = 15;

    public function mount(Merchant $merchant){
        $this->merchant = $merchant;
    }

    #[Computed]
    public function latest_balance()
    {
        return $this->merchant->latest_balance()->first()->amount ?? 0;
    }
    
    #[Computed]
    public function total_unsettled_fees(){
        dd('yo');
    }

    #[On('date-range-picker-admin-merchant-unsettled-fees')]
    public function changeDateRange($from =null , $to = null)
    {
        $this->date_from = $from;
        $this->date_to = $to;
    }

    public function getFilters(){
        $filters = [
            'search' => $this->search,
            'merchant_id' => $this->merchant->id,
            'ref_no' => $this->search,
            'date_to' => $this->date_to,
            'date_from' => $this->date_from,
        ];
        return $filters;
    }

    public function getUnsettledFees(){
        $unsettledFeesPaginator = app(UnsettledFeesTablePaginator::class);
        $filters = $this->getFilters();
        $unsettledFees = $unsettledFeesPaginator->paginateForTable($filters, $this->perPage);
        return $unsettledFees;
    }

    public function render(){
        
        $query = FeeTransaction::query()
            ->with(['transaction', 'fee_bearer', 'fee_bearer.profile'])
            ->where('status', FeeTransactionStatus::UNSETTLED);
            // dd($query->get());
        
        $unsettledFees = $this->getUnsettledFees();
        // dd($unsettledFees);
        $elements = $this->buildPaginationElements($unsettledFees['pagination']['current_page'], $unsettledFees['pagination']['last_page']);
        return view('admin.components.manage-fees.merchant-unsettled-fees', [
            'unsettledFees' => $unsettledFees,
            'elements' => $elements
        ]);
    }
}