<script>
import '@fullcalendar/core/vdom' // solves problem with Vite
import FullCalendar from '@fullcalendar/vue'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'

export default {
    components: {
        FullCalendar // make the <FullCalendar> tag available
    },
    data: function() {
        return {
            calendarOptions: {
                plugins: [
                    dayGridPlugin,
                    interactionPlugin // needed for dateClick
                ],
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                initialView: 'dayGridMonth',
                editable: true,
                selectable: true,
                selectMirror: true,
                dayMaxEvents: true,
                weekends: true,
                select: this.handleDateSelect,
                eventClick: this.handleEventClick,
                eventsSet: this.handleEvents,
                dateClick: this.clickDate
                /* you can update a remote database when these fire:
                eventAdd:
                eventChange:
                eventRemove:
                */
            },
            currentEvents: []
        }
    },
    methods: {
        handleWeekendsToggle() {

        },
        handleDateSelect(selectInfo) {
            alert('hello sdfsdf')
        },
        handleEventClick(clickInfo) {

        },
        handleEvents(events) {

        },
        clickDate(events) {
            alert('date cledsfsdfsdfck')
        }

    }
}
</script>
<template>
    <FullCalendar :options="calendarOptions" />
</template>
