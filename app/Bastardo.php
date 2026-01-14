<?php
namespace App;

use App\Admin\Components\Forms\BaseForm;
use App\Models\User;
use App\Models\YourModel;
use Illuminate\Support\Facades\DB;

class Bastardo extends BaseForm
{
    // Define your form properties
    public string $name = '';
    public string $email = '';
    public string $description = '';
    public ?int $modelId = null; // If editing existing record
    public bool $showResetFormButton = true; // If editing existing record
    /**
     * Initialize the form
     */
    protected function initialize(): void
    {
        // Set default values or load existing data
        if ($this->modelId) {
            $model = User::findOrFail($this->modelId);
            $this->name = $model->name;
            $this->email = $model->email;
            $this->description = $model->description ?? '';
        }

        // You can also set custom confirmation messages here
        $this->confirmationTitle = 'Confirm Submission';
        $this->confirmationMessage = 'Are you sure you want to submit this form?';
    }

    /**
     * Validation rules
     */
    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'description' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Process the form submission
     */
    protected function processForm(array $validatedData): mixed
    {
        return DB::transaction(function () use ($validatedData) {
            if ($this->modelId) {
                // Update existing record
                $model = User::findOrFail($this->modelId);
                $model->update($validatedData);
            } else {
                // Create new record
                $model = User::create($validatedData);
            }

            return $model;
        });
    }

    /**
     * Get form data for change tracking
     */
    protected function getFormData(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'description' => $this->description,
        ];
    }

    /**
     * Custom success message
     */
    protected function getSuccessMessage(mixed $result = null): string
    {
        return $this->modelId
            ? 'Record updated successfully!'
            : 'Record created successfully!';
    }

    /**
     * Optional: Custom confirmation preparation
     */
    protected function prepareConfirmation(): void
    {
        // You can dynamically set confirmation messages based on form state
        if ($this->modelId) {
            $this->confirmationMessage = 'Are you sure you want to update this record?';
        } else {
            $this->confirmationMessage = 'Are you sure you want to create a new record?';
        }
    }

    /**
     * Optional: Success callback
     */
    protected function onSuccess(mixed $result = null): void
    {
        // Redirect or dispatch additional events
        // $this->redirect(route('admin.bastardo.index'));
    }

    /**
     * Optional: Error callback
     */
    protected function onError(\Throwable $exception): void
    {
        // Additional error handling
        // Log::error('Bastardo form error', ['exception' => $exception]);
    }

    public function render()
    {
        return view('bastardo');
    }
}

