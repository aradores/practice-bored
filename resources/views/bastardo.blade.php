{{-- resources/views/admin/components/forms/bastardo.blade.php --}}
<div>

    <input type="text" placeholder="Search users..."
       oninput="updateUsersTableFilters({ search: this.value })">

<select onchange="updateUsersTableFilters({ status: this.value })">
    <option value="">All Status</option>
    <option value="active">Active</option>
    <option value="suspended">Suspended</option>
</select>

<input type="date" onchange="updateUsersTableFilters({ dateFrom: this.value })">
<input type="date" onchange="updateUsersTableFilters({ dateTo: this.value })">

    <br><br>


    <div id="usersTableWrapper">
    @livewire(App\Livewire\UsersTable::class)
</div>


    <br><br><br><br>

    @include('admin.components.forms.base-form')

</div>


<script>
window.updateUsersTableFilters = function(filters) {
    // Find the first Livewire component inside wrapper
    const wrapper = document.getElementById('usersTableWrapper');
    const livewireEl = wrapper.querySelector('[wire\\:id]');

    if (!livewireEl) return;

    // Get the Livewire component ID
    const componentId = livewireEl.getAttribute('wire:id');
    if (!componentId) return;

    // Call handleFilters using Livewire 3 API
    Livewire.find(componentId).call('handleFilters', filters);
};
</script>

