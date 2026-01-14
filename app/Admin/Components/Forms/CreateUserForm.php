<?php

namespace App\Admin\Components\Forms;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Validate;

class CreateUserForm extends BaseForm
{
    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('required|email|unique:users,email')]
    public string $email = '';

    #[Validate('required|string|min:8')]
    public string $password = '';

    #[Validate('required|same:password')]
    public string $password_confirmation = '';

    #[Validate('required|array')]
    public array $roles = [];

    protected function initialize(): void
    {
        // Load default values if needed
        $this->roles = ['user'];
    }

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'password_confirmation' => 'required|same:password',
            'roles' => 'required|array',
        ];
    }

    protected function prepareConfirmation(): void
    {
        dd('ad');
        $this->confirmationTitle = 'Create User Account';
        $this->confirmationMessage = "Are you sure you want to create a new user account for {$this->name}?";
    }

    protected function processForm(array $validatedData): User
    {
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        $user->roles()->sync($validatedData['roles']);

        return $user;
    }

    protected function getSuccessMessage(mixed $result = null): string
    {
        return "User {$result->name} has been created successfully!";
        /* return parent::getSuccessMessage($result); */
    }

    /* protected function getSuccessMessage(?mixed $user): string */
    /* { */
    /*     return "User {$user->name} has been created successfully!"; */
    /* } */

    protected function onSuccess(mixed $result = null): void
    {
        $this->reset('name', 'email', 'password', 'password_confirmation', 'roles');
        $this->roles = ['user'];

        // Dispatch event to parent component
        $this->dispatch('user-created', user: $result);

        parent::onSuccess($result);
    }

    /* protected function onSu */

    /* protected function onSuccess(?mixed $result): void */
    /* { */
    /*     // Clear form fields */

    /* } */

    protected function getFormData(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'password_confirmation' => $this->password_confirmation,
            'roles' => $this->roles,
        ];
    }

    public function render()
    {
        return view('admin.components.forms.create-user-form', [
            'availableRoles' => collect([

                (object) [
                    'id' => 1,
                    'name' => 'adi'
                ]
            ]),
        ]);
    }
}
