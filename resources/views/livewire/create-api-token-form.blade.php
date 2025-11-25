<div>
    @if($this->plainToken)
        <p class="mb-5">{{ __('pages.api_tokens.notification.created_text') }}</p>

        <x-filament::input.wrapper disabled="disabled">
            <x-filament::input
                type="text"
                wire:model="plainToken"
                disabled="disabled"
            />
        </x-filament::input.wrapper>
    @else
        <form wire:submit="submit">
            {{ $this->form }}

            <x-filament::button type="submit" class="mt-5">
                {{ __('pages.api_tokens.new_token') }}
            </x-filament::button>
        </form>
    @endif

    <x-filament-actions::modals />
</div>
