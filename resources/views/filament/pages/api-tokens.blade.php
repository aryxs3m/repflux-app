<x-filament-panels::page>
    {{ $this->table }}

    <x-filament::section>
        <x-slot name="heading">
            {{ __('pages.api_tokens.new_token') }}
        </x-slot>

        @livewire(\App\Livewire\CreateApiTokenForm::class)
    </x-filament::section>
</x-filament-panels::page>
