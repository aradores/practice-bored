<div 
    x-data="{ visible: false }" 
    {{-- @keyup.escape.window="visible=false"  --}}
    x-init="() => { 
        Livewire.on('closeModal', () => {
            visible = false;
        });
    }"  
    x-cloak 
    x-show="visible" 
    x-modelable="visible"
    x-transition.duration.500ms x-transition.opacity 
    {{ $attributes->merge(['class' => "fixed h-screen inset-0 grid place-items-end backdrop-blur-sm bg-black/50 z-50"]) }}>
    {{ $slot }}
</div>