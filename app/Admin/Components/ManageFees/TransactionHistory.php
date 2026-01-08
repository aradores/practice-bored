<?php

namespace App\Admin\Components\ManageFees;

use App\Models\Merchant;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Repay\Fee\Services\FeeTransactionPaginator;

class TransactionHistory extends Component
{
    use WithPagination;

    public $date_from;

    public $date_to;

    public $perPage = 15;

    #[Url]
    public $search;

    public $merchant;

    public $header_columns = [];

    #[On('date-range-picker-transaction-history')]
    public function changeDateRange($from = null, $to = null)
    {
        $this->date_from = $from;
        $this->date_to = $to;
    }

    public function mount($merchant = null)
    {
        $this->merchant = $merchant;
        $this->date_from = null;
        $this->date_to = null;

        $this->assignHeaderColumns();
    }

    public function assignHeaderColumns()
    {
        $this->header_columns = [
            [
                'key' => 'date_time',
                'label' => 'Date & Time',
                'width' => 'w-32',
                'show' => true,
            ],
            [
                'key' => 'merchant_name',
                'label' => 'Merchant',
                'width' => 'w-32',
                'show' => true ? (! isset($this->merchant) || $this->merchant == null) : false,
            ],
            [
                'key' => 'reference_number',
                'label' => 'Reference Number',
                'width' => 'w-40',
                'show' => true,
            ],
            [
                'key' => 'transaction_number',
                'label' => 'Transaction Number',
                'width' => 'w-40',
                'show' => true,
            ],
            [
                'key' => 'fee_type',
                'label' => 'Fee Type',
                'width' => 'w-32',
                'show' => true,
            ],
            [
                'key' => 'transaction_amount',
                'label' => 'Transaction Amount',
                'width' => 'w-32',
                'show' => true,
            ],
            [
                'key' => 'fee',
                'label' => 'Fee',
                'width' => 'w-10',
                'show' => true,
            ],
        ];
    }

    public function getTransactionFee()
    {
        /* $transactionFee = app(FeeTransactionPaginator::class); */
        /**/
        /* $filters = [ */
        /*     'merchant_id' => $this->merchant->id ?? null, */
        /*     'search' => $this->search ?? null, */
        /*     'date_from' => $this->date_from ?? null, */
        /*     'date_to'=> $this->date_to ?? null */
        /* ]; */
        /* $perPage = $this->perPage; */
        /* $transactionFees = $transactionFee->paginateForTable($filters, $perPage); */
        /* return $transactionFees; */
    }

    public function render()
    {
        /* $transactionFees = $this->getTransactionFee(); */
        /* $header_columns = $this->header_columns; */
        /* $elements = $this->buildPaginationElements($transactionFees['pagination']['current_page'], $transactionFees['pagination']['last_page']); */

        return view('admin.components.manage-fees.transaction-history',
            ['transactionFeexs' =>
                [], 'elements' => [],
                'header_columns' => [],

                            'transactionFees' => [
                    'data' => [

                    ],
                    'pagination' => [
                        'current_page' => 1,
                        'last_page' => 2

                    ]
                ],
            ]);
    }
}
