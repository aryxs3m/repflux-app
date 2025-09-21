@php use App\Services\Settings\Tenant; @endphp
<x-filament-panels::page>
    <div id='calendar'></div>
</x-filament-panels::page>

@push('scripts')
    <script>
        initCalendar({{ Tenant::getTenant()->id }}, '{{ \App::getLocale() }}');
    </script>
@endpush
