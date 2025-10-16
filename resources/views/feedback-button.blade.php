@can('create-feedback')
<x-filament::modal>
    <x-slot name="trigger">
        <x-filament::button color="gray" icon="heroicon-m-chat-bubble-left-ellipsis">
            Feedback
        </x-filament::button>
    </x-slot>

    <x-slot name="heading">
        Feedback
    </x-slot>

    <x-slot name="description">
        Found a bug? Have a suggestion? Let us know!
    </x-slot>

    @livewire('create-feedback')
</x-filament::modal>
@endcan
