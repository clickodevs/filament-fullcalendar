@php
    $plugin = \Saade\FilamentFullCalendar\FilamentFullCalendarPlugin::get();
    $jobs = $this->getUnassignedJobs();
    if (count($jobs) == 0) {
        $this->hideJobs = true;
        $this->noUnassignedJobs = true;
    }
@endphp

<x-filament-widgets::widget>
    <div class="flex gap-4">

        <div class="flex flex-col min-w-64 w-64 rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 p-4"
            id="unassigned-jobs"@if ($this->hideJobs) style="display: none;" @endif>
            <h3 class="text-center font-bold">Unassigned Jobs</h3>

            <div class="flex flex-col gap-2 overflow-y-auto mt-4" style="max-height: 990px;">
                @foreach ($this->getUnassignedJobs() as $job)
                    <div class="flex flex-col border rounded px-3 py-2 job-item"
                        data-event="{{ json_encode($job['event']) }}">
                        <div class="flex gap-4 justify-between">
                            <a href="#" class="underline text-xs">
                                {{ $job['name'] }}
                            </a>
                            @if (isset($job['shelf']))
                                <p class="fi-badge flex items-center justify-center gap-x-1 rounded-md text-xs font-medium ring-1 ring-inset px-2 min-w-[theme(spacing.6)] py-1 fi-color-custom bg-custom-50 text-custom-600 ring-custom-600/10 dark:bg-custom-400/10 dark:text-custom-400 dark:ring-custom-400/30 fi-color-success"
                                    style="--c-50:var(--success-50);--c-400:var(--success-400);--c-600:var(--success-600);">
                                    {{ $job['shelf'] }}
                                </p>
                            @endif
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            {{ $job['time'] }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>


        <x-filament::section class="flex-1">
            <div class="flex justify-between items-center mb-4 w-full">
                <div class="flex gap-2">
                    <x-filament-actions::actions :actions="array_slice($this->getCachedHeaderActions(), 0, 2)" class="shrink-0" />
                </div>

                <div class="flex gap-2">
                    <x-filament-actions::actions :actions="array_slice($this->getCachedHeaderActions(), 2)" class="shrink-0" />
                </div>
            </div>

            <div class="filament-fullcalendar" wire:ignore x-load
                x-load-src="{{ \Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('filament-fullcalendar-alpine', 'saade/filament-fullcalendar') }}"
                ax-load-css="{{ \Filament\Support\Facades\FilamentAsset::getStyleHref('filament-fullcalendar-styles', 'saade/filament-fullcalendar') }}"
                x-ignore x-data="fullcalendar({
                    locale: @js($plugin->getLocale()),
                    plugins: @js($plugin->getPlugins()),
                    schedulerLicenseKey: @js($plugin->getSchedulerLicenseKey()),
                    timeZone: @js($plugin->getTimezone()),
                    config: @js($this->getConfig()),
                    editable: @json($plugin->isEditable()),
                    selectable: @json($plugin->isSelectable()),
                    eventClassNames: {!! htmlspecialchars($this->eventClassNames(), ENT_COMPAT) !!},
                    eventContent: {!! htmlspecialchars($this->eventContent(), ENT_COMPAT) !!},
                    eventDidMount: {!! htmlspecialchars($this->eventDidMount(), ENT_COMPAT) !!},
                    eventWillUnmount: {!! htmlspecialchars($this->eventWillUnmount(), ENT_COMPAT) !!},
                })">
            </div>
        </x-filament::section>
    </div>
    <x-filament-actions::modals />
</x-filament-widgets::widget>
