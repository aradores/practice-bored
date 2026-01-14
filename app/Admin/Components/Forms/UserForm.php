<?php

namespace App\Livewire\Forms;

use App\Admin\Components\Forms\BaseForm;
use App\Models\User;
use Illuminate\Validation\Rule;

class UserForm extends BaseForm
{
    public ?int $userId = null;
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $role = 'user';

    protected function initialize(): void
    {
        if ($this->userId) {
            $user = User::findOrFail($this->userId);
            $this->name = $user->name;
            $this->email = $user->email;
            $this->role = $user->role;
        }
    }

    protected function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($this->userId),
            ],
            'role' => ['required', 'in:user,admin,editor'],
        ];

        if (!$this->userId || $this->password) {
            $rules['password'] = ['required', 'min:8', 'confirmed'];
            $rules['password_confirmation'] = ['required'];
        }

        return $rules;
    }

    protected function processForm(array $validatedData): mixed
    {
        $userData = [
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'role' => $validatedData['role'],
        ];

        if (isset($validatedData['password'])) {
            $userData['password'] = bcrypt($validatedData['password']);
        }

        return $this->userId
            ? User::findOrFail($this->userId)->update($userData)
            : User::create($userData);
    }

    protected function getFormData(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
        ];
    }

    protected function prepareConfirmation(): void
    {
        $this->confirmationTitle = $this->userId
            ? 'Update User'
            : 'Create User';

        $this->confirmationMessage = $this->userId
            ? 'Are you sure you want to update this user?'
            : 'Are you sure you want to create a new user?';
    }


    protected function getSuccessMessage(mixed $user = null): string
    {
        return $this->userId
            ? 'User updated successfully!'
            : 'User created successfully!';
    }

    protected function onSuccess(mixed $result = null): void
    {
        if (!$this->userId) {
            $this->reset(['name', 'email', 'password', 'password_confirmation', 'role']);
        }
    }

}
