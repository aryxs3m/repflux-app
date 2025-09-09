@php use App\Services\Settings\TenantSettings; @endphp
<x-filament-panels::page>
    <div id='calendar'></div>
</x-filament-panels::page>

@push('scripts')
    <script>
        initCalendar({{ TenantSettings::getTenant()->id }}, '{{ \App::getLocale() }}');
    </script>
@endpush
