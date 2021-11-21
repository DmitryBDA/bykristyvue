<script>
import '@fullcalendar/core/vdom' // solves problem with Vite
import FullCalendar from '@fullcalendar/vue'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'

import ModalAddRecord from "./ModalAddRecord";

export default {
    components: {
        ModalAddRecord,
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
                events:  this.showRecords,
                eventClick: this.handleEventClick,
                eventsSet: this.handleEvents,
                dateClick: this.clickDate
                /* you can update a remote database when these fire:
                eventAdd:
                eventChange:
                eventRemove:
                */
            },
            currentEvents: [],
            dateClick:''
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
        clickDate(event) {
            this.dateClick = event.dateStr
            const elem = this.$refs.open_modal_add_records;
            elem.click();
        },
        showRecords(){
            axios
            .get('/admin/calendar/records').then((response)=>{
                this.calendarOptions.events = response.data
            })
        }

    }
}
</script>
<template>
    <div>
        <FullCalendar :options="calendarOptions" />
        <modal-add-record :dateClick="dateClick"></modal-add-record>
        <button style="display: none" data-toggle="modal" data-target="#modal-add-records" ref="open_modal_add_records"></button>
    </div>
</template>
