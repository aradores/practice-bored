<?php

namespace App\Admin\Components\ManageFees;

use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Repay\Fee\Services\FeeTablePaginator;

class ChangeHistory extends Component
{
    use WithPagination;

    public $start_date;

    public $end_date;

    public $date_from;

    public $date_to;

    public $merchant;

    public $perPage = 10;

    public $selectedFeeId;

    public $showEditModal = true;

    protected $listeners = ['refresh-table' => '$refresh'];

    public function mount($merchant = null)
    {
        $this->merchant = $merchant;
    }

    #[On('date-range-picker-fee-management')]
    public function changeDateRange($from = null, $to = null)
    {
        $this->date_from = $from;
        $this->date_to = $to;
    }

    public function editModal($selectedFeeId)
    {
        $this->selectedFeeId = $selectedFeeId;
        $this->showEditModal = true;
        $this->dispatch('openEditModal', selectedFeeId: $this->selectedFeeId);
    }

    public function getFilters()
    {
        $filters = [
            'date_from' => $this->date_from,
            'date_to' => $this->date_to,
            'merchant_id' => $this->merchant?->id ?? null,
            'is_upcoming' => false,
            'latest_only' => false,
        ];

        return $filters;
    }

    public function getChangeHistoryRecords()
    {
        /* $feeTablePaginator = app(FeeTablePaginator::class); */
        /* $filters = $this->getFilters(); */
        /* $filters['is_upcoming'] = false; */
        /* $changeHistoryRecords = $feeTablePaginator->paginateForTable($filters, $this->perPage, dto_type: 'fee-history'); */
        /* return $changeHistoryRecords; */
    }

    public function getUpcomingRateChanges()
    {
        /* $feeTablePaginator = app(FeeTablePaginator::class); */
        /* $filters = $this->getFilters(); */
        /* $filters['is_upcoming'] = true; */
        /* $filters['latest_only'] = true; */
        /* $upcomingRateChanges = $feeTablePaginator->paginateForTable($filters, $this->perPage, dto_type: 'fee-history'); */
        return [];
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        /* $upcomingRateChanges = $this->getUpcomingRateChanges(); */
        /* $changeHistoryRecords = $this->getChangeHistoryRecords(); */
        /* $elements = $this->buildPaginationElements($changeHistoryRecords['pagination']['current_page'], $changeHistoryRecords['pagination']['last_page']); */

        return view('admin.components.manage-fees.change-history',
            [
                'upcoming_rate_changes' => [
                    'data' => [


                    ]
                ],
                'change_history_records' => [
                    'data' => [

                    ],
                    'pagination' => [
                        'current_page' => 1,
                        'last_page' => 2

                    ]
                ],
                'elements' => [],
            ]);
    }
}
