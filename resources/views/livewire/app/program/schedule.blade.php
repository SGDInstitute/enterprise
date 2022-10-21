<div class="space-y-8">
    <div class="prose dark:prose-light">
        <h1>Schedule</h1>
    </div>

    <div id="calendar-container" wire:ignore>
        <div id="calendar"></div>
    </div>

</div>

@push('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.3.1/main.min.js'></script>
<script src="https://unpkg.com/moment"></script>
<script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            timeZone: '{{ $this->event->timezone }}',
            initialView: 'timeGridDay',
            initialDate: '{{ $this->event->start->format("Y-m-d") }}',
            editable: false,
            nowIndicator: true,
            contentHeight: window.innerHeight - 100,
            headerToolbar: {
                left: 'prev,next',
                center: 'title',
                right: 'timeGridDay,listWeek'
            },
            views: {
                timeGridDay: {
                    slotMinTime: '7:00',
                },
                listWeek: {
                    type: 'listDay',
                    duration: { days: 3 }
                }
            },
            eventClick(info) {
                @this.redirectTo(info.event.id);
            }
        });

        calendar.addEventSource( {
            url: '/api/events/{{ $event->id }}/schedule'
        });

        calendar.render();

        @this.on(`refreshCalendar`, () => {
            calendar.refetchEvents()
        });
    });
</script>
@endpush

@push('styles')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.3.1/main.min.css' rel='stylesheet' />
@endpush
