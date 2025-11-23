<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <div class="justify-center w-full flex flex-col items-center gap-2">
    <div class="border-4 border-white/40 rounded-full w-80 h-80 flex justify-center text-4xl">
        <input type="time" class="font-mono text-2xl" step="0.001" wire:model="{{ $getStatePath() }}" />
    </div>

    <x-filament::button x-data x-show="$store.stopwatchInterval == null" @click="toggleStopwatch">
        Start
    </x-filament::button>
    <x-filament::button x-data outlined x-show="$store.stopwatchInterval != null" @click="toggleStopwatch">
        Stop
    </x-filament::button>
    </div>
</x-dynamic-component>

@script

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('stopwatchInterval', null)
    })

    window.toggleStopwatch = function (e) {
        const btn = e.target;

        if ($store.stopwatchInterval) {
            clearInterval($store.stopwatchInterval);
            $store.stopwatchInterval = null;

            // ensure final value is synced to Livewire
            const time = btn.parentElement.querySelector('input[type="time"]');
            time.dispatchEvent(new Event('input', { bubbles: true }));
            time.dispatchEvent(new Event('change', { bubbles: true }));
        } else {
            $store.stopwatchInterval = window.startStopwatch(e);
        }
    }

    window.startStopwatch = function (e) {
        const btn = e.target;
        const time = btn.parentElement.querySelector('input[type="time"]');

        const start = new Date();
        return setInterval(function() {
            let now = new Date();
            let diff = now - start;
            time.value = new Date(diff).toISOString().slice(11, 23);
        }, 50);
    }
</script>
@endscript
