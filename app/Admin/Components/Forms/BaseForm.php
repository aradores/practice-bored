<?php

namespace App\Admin\Components\Forms;

use Illuminate\Support\Facades\Log;
use Livewire\Component;

abstract class BaseForm extends Component
{
    public bool $showConfirmation = false;

    public bool $isSubmitting = false;

    public string $confirmationTitle = 'Confirm Action';

    public string $confirmationMessage = 'Are you sure you want to proceed?';

    public bool $showResetFormButton = false;

    public bool $requireConfirmation = true;

    // Success/Error messages
    public ?string $successMessage = null;

    public ?string $errorMessage = null;

    // Form state
    public array $originalData = [];

    public bool $hasChanges = false;

    public bool $autoResetFormOnSuccess = true;

    /**
     * Initialize the form (set default values, load data, etc.)
     */
    abstract protected function initialize(): void;

    /**
     * Validation rules for the form
     */
    abstract protected function rules(): array;

    /**
     * Process form submission (business logic)
     */
    abstract protected function processForm(array $validatedData): mixed;

    /**
     * Get list of form field properties to reset
     * Override this to specify which properties should be reset
     */
    protected function getFormFields(): array
    {
        // By default, get all public properties except these system ones
        $excludedProperties = [
            'showConfirmation',
            'isSubmitting',
            'confirmationTitle',
            'confirmationMessage',
            'successMessage',
            'errorMessage',
            'originalData',
            'hasChanges',
            'showResetFormButton',
            'requireConfirmation',
        ];

        $reflection = new \ReflectionClass($this);
        $properties = $reflection->getProperties(\ReflectionProperty::IS_PUBLIC);

        $formFields = [];
        foreach ($properties as $property) {
            if ($property->isStatic()) {
                continue;
            }

            $propertyName = $property->getName();
            if (! in_array($propertyName, $excludedProperties)) {
                $formFields[] = $propertyName;
            }
        }

        return $formFields;
    }

    /**
     * Success callback after form submission
     */
    protected function onSuccess(mixed $result = null): void
    {
        $this->resetForm();
        // Can be overridden by child components
    }

    /**
     * Error callback if form submission fails
     */
    protected function onError(\Throwable $exception): void
    {
        // Can be overridden by child components
    }

    /**
     * Prepare confirmation dialog (optional)
     */
    protected function prepareConfirmation(): void
    {
        // Can be overridden to set custom confirmation messages
    }

    public function mount(): void
    {
        $this->initialize();
        $this->originalData = $this->getFormData();
    }

    public function updated($property): void
    {
        if (! str_starts_with($property, 'showConfirmation') &&
            ! str_starts_with($property, 'isSubmitting')) {
            $this->hasChanges = true;
        }
    }

    protected function shouldAutoResetForm(): bool
    {
        return true;
    }

    /**
     * Open confirmation dialog or submit directly
     */
    public function confirm(): void
    {
        // Clear previous messages
        $this->successMessage = null;
        $this->errorMessage = null;

        try {
            $this->prepareConfirmation();
            $this->validate();

            // If confirmation is not required, submit directly
            if (! $this->requireConfirmation) {
                $this->submit();
            } else {
                $this->showConfirmation = true;
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Validation failed, don't show modal
            // Livewire will automatically display the validation errors
            $this->showConfirmation = false;
            throw $e;
        }
    }

    /**
     * Submit form after confirmation
     */
    public function submit(): void
    {
        $this->isSubmitting = true;

        try {
            $validatedData = $this->validate();
            $result = $this->processForm($validatedData);

            $this->successMessage = $this->getSuccessMessage($result);
            $this->showConfirmation = false;
            $this->resetFormState();
            $this->onSuccess($result);

            $this->dispatch('form-submitted',
                form: static::class,
                data: $validatedData,
                result: $result
            );

            if ($this->autoResetFormOnSuccess) {
                $this->resetFields();
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Validation error - close modal and show errors
            $this->showConfirmation = false;
            $this->errorMessage = 'Please correct the validation errors below.';
            throw $e;
        } catch (\Throwable $exception) {
            // Other errors - close modal and show error message
            $this->showConfirmation = false;
            $this->errorMessage = $this->getErrorMessage($exception);
            $this->onError($exception);

            Log::error('Form submission failed', [
                'form' => static::class,
                'error' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
            ]);
        } finally {
            $this->isSubmitting = false;
        }
    }

    /**
     * Cancel confirmation
     */
    public function cancel(): void
    {
        $this->showConfirmation = false;
        $this->resetErrorBag();
    }

    /**
     * Reset form to original state
     */
    public function resetForm(): void
    {
        $this->resetFields();

        // Reset validation errors and messages
        $this->resetErrorBag();
        $this->successMessage = null;
        $this->errorMessage = null;
        $this->hasChanges = false;

        // Re-initialize to set default values
        $this->initialize();
        $this->originalData = $this->getFormData();
    }

    public function resetFields()
    {
        $formFields = $this->getFormFields();
        $this->reset($formFields);
    }

    /**
     * Get form data for comparison
     */
    protected function getFormData(): array
    {
        // Child components should implement this
        return [];
    }

    /**
     * Generate success message
     */
    protected function getSuccessMessage(mixed $result = null): string
    {
        return 'Action completed successfully!';
    }

    /**
     * Generate error message
     */
    protected function getErrorMessage(\Throwable $exception): string
    {
        return $exception->getMessage() ?: 'Something went wrong. Please try again.';
    }

    /**
     * Reset form state after successful submission
     */
    protected function resetFormState(): void
    {
        $this->hasChanges = false;
        $this->errorMessage = null;
        $this->originalData = $this->getFormData();
    }

    public function render()
    {
        return view('admin.components.forms.base-form');
    }
}
