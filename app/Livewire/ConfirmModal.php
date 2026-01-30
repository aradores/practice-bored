<?php

namespace App\Livewire;

use Livewire\Component;

class ConfirmModal extends Component
{
    public $show = false;

    public $title = '';

    public $message = '';

    public $event = '';

    public $params = [];

    public $confirmText = 'Confirm';

    public $cancelText = 'Cancel';

    public $confirmClass = 'bg-blue-600 hover:bg-blue-700';

    public $icon = 'info';

    protected $listeners = ['showConfirm' => 'open'];

    public function open(
        $title = 'Confirm Action',
        $message = 'Are you sure you want to perform this action?',
        $event = '',
        $params = [],
        $confirmText = 'Confirm',
        $cancelText = 'Cancel',
        $confirmClass = 'bg-blue-600 hover:bg-blue-700',
        $icon = 'info'
    ) {
        $this->title = $title;
        $this->message = $message;
        $this->event = $event;
        $this->params = $params;
        $this->confirmText = $confirmText;
        $this->cancelText = $cancelText;
        $this->confirmClass = $confirmClass;
        $this->icon = $icon;
        $this->show = true;
    }

    public function confirm()
    {
        if ($this->event) {
            $this->dispatch($this->event, ...$this->params);
        }

        $this->show = false;
        $this->resetExcept('show');
    }

    public function cancel()
    {
        $this->show = false;
        $this->resetExcept('show');
    }

    public function render()
    {
        return view('livewire.confirm-modal');
    }
}
