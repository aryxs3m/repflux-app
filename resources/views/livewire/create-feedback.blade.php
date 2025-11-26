<div>
    @if(!$this->sent)
    <form wire:submit="create">
        {{ $this->form }}

        <x-filament::button class="mt-5" type="submit" color="gray" icon="heroicon-m-sparkles">
            Submit Feedback
        </x-filament::button>
    </form>
    @else
        <div>
            Thank you for your feedback!
        </div>
    @endif

    <x-filament-actions::modals />
</div>
