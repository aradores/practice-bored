<?php

namespace App\Admin\Components\ManageFees;

use App\Models\Merchant;
use Livewire\Attributes\Locked;
use Livewire\Component;

// use App\Services\Transaction\FeeService;

/* use Repay\Fee\Contracts\FeeRepositoryInterface as FeeRepository; */

// use Repay\Fee\Actions\ProcessMerchantSpecificFee;

class FeeForm extends Component
{
    public $formModal = false;

    public $confirmModal = false;

    public $merchant = null;

    public $fee_id;

    public ?bool $isApproval;   // is used to verify form if its from merchant approval dispatch. also a fix for accidentally double triggering save - see the save function for additional details

    public $use_default;

    /**/
    #[Locked]
    public $allowed_fee_type = ['MARKUP', 'INVOICE'];

    public $allowed_invoice_type = ['COMMISSION_FEE', 'CONVENIENCE_FEE'];

    public $allowed_rate_type = ['FLAT', 'PERCENTAGE'];

    public $curren_rate_value;

    public $default_rate_value;

    /**/
    /**/
    public $type;           // MARKUP or INVOICE

    public $invoiceType;    // COMMISSION or CONVENIENCE

    public $rateType;       // PERCENTAGE or FLAT

    public $amount;

    public $reason;

    public $effective_date;

    public $apply_to_existing;

    /**/
    public $current_fees = [
        'MARKUP' => ['value' => 0, 'is_custom' => false],
        'INVOICE' => ['value' => 0, 'is_custom' => false],
    ];
    /**/

    public function render()
    {
        /* $this->getCurrentFees(); */
        return view('admin.components.manage-fees.fee-form');
    }
}
