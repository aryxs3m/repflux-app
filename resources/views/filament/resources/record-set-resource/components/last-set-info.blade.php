@php use App\Models\Record; @endphp

<div>
    @if($getState() === null || is_array($getState()))
        <div class="text-center text-gray-500">No records yet, make your first!</div>
    @else
        <div class="flex justify-center md:justify-between justify-content-center items-center gap-2 flex-wrap md:flex-nowrap">
            @php /** @var Record $record */ @endphp
            @foreach($getState()->records as $record)
                <div class="text-center content-center border-1 border-gray-700 rounded-xl p-2 md:p-4 min-w-[10rem] md:min-w-auto">
                    <span class="text-gray-500 md:block md:mb-2">{{ $record->repeat_index }}.</span> {{ $record->repeat_count }} x {{ $record->weight_with_base }} kg
                </div>

                @if(!$loop->last)
                    <x-heroicon-c-chevron-right class="text-gray-500 h-5 hidden md:block"></x-heroicon-c-chevron-right>
                @endif
            @endforeach
        </div>
    @endif
</div>
