<script>
import FullCalendar from '@fullcalendar/vue'
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid'
import interactionPlugin from '@fullcalendar/interaction'
export default {
  components: {
    FullCalendar // make the <FullCalendar> tag available
  },
  props: {
  	itineraries: Array
  },
  beforeMount(){
  	this.calendarOptions.initialEvents = this.itineraries.map(function(itinerary, index){
  		let duration_time = itinerary.duration.split(':')
		let hours = duration_time[0]
		let minutes = duration_time[1]
		itinerary.locations.sort(function(a, b){
			return a.sequence_number - b.sequence_number
		})
  		return {
		  	  	id : index,
		      	title  : itinerary.bus_license,
		      	start  : moment(itinerary.departure).toDate(),
		      	classNames : [
		      		'bg-dark',
		      		'text-white',
		      	],
		      	extendedProps: {
		        	departure: moment(itinerary.departure).format("dddd, MMMM Do YYYY, h:mm a"),
		        	arrival: moment(itinerary.departure).add({hours, minutes}).format("dddd, MMMM Do YYYY, h:mm a"),
		        	bus_image: itinerary.bus_image,	
		        	locations: itinerary.locations, 
		        	departure_time: moment(itinerary.departure).format("ddd, hh:mma"),
		        	arrival_time: moment(itinerary.departure).add({hours, minutes}).format("ddd, hh:mma"),    	
		    },
		}
  	})
  },
  data: function() {
    return {
      todayStr : new Date().toISOString().replace(/T.*$/, ''),
      eventGuid : 5,
      calendarOptions: {
        plugins: [
          dayGridPlugin,
          timeGridPlugin,
          interactionPlugin // needed for dateClick
        ],
        headerToolbar: {
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        initialView: 'dayGridMonth',
        initialEvents: [],
        editable: false,
        selectable: false,
        selectMirror: true,
        dayMaxEvents: true,
        weekends: true,
        displayEventTime: true,
        select: this.handleDateSelect,
        // eventClick: this.handleEventClick,
        // eventsSet: this.handleEvents,
        eventMouseEnter: this.showPopover,
        eventMouseLeave: this.hidePopover
        /* you can update a remote database when these fire:
        eventAdd:
        eventChange:
        eventRemove:
        */
      },
      currentEvents: []
    }
  },
  computed: {
  	createEventId() {
	  	let return_val = this.eventGuid++
	  	return return_val
	}
  },
  methods: {
  	showPopover(info){
  		let extraProps = info.event.extendedProps;
  		let locations = ""
  		extraProps.locations.forEach(function(el){
  			locations += `<li>${el.english} ( ${el.myanmar} ) <br/> [ ${el.extra_info ? el.extra_info : 'None'} ]</li>`
  		})
  		$(info.el).popover({
  			title: "License Number: " + info.event.title,
  			html: true,
  			content: locations,
  			template: `<div class="card border popover" role="tooltip" style="width: 18rem;">
  							<div class="arrow"></div>
  							<h5 class="popover-header"></h5>
					  		<img class="card-img-top p-2" src="${extraProps.bus_image}" alt="Card image cap">
					  		<div class="card-body">
					    		<strong>${extraProps.departure_time} ~ ${extraProps.arrival_time}</strong>
					    		<div class="card-text">
					    			<ol class="popover-body">
					    			</ol>
					    		</div>
					  		</div>
						</div>`,
  		}).popover('show')
  	},
  	hidePopover(info){
  		$(info.el).popover('hide')
  	},
    handleWeekendsToggle() {
      this.calendarOptions.weekends = !this.calendarOptions.weekends // update a property
    },
    handleDateSelect(selectInfo) {
      let title = prompt('Please enter a new title for your event')
      let calendarApi = selectInfo.view.calendar
      calendarApi.unselect() // clear date selection
      if (title) {
        calendarApi.addEvent({
          id: this.createEventId,
          title,
          start: selectInfo.startStr,
          end: selectInfo.endStr,
          allDay: selectInfo.allDay
        })
      }
    },
    handleEventClick(clickInfo) {
      if (confirm(`Are you sure you want to delete the event '${clickInfo.event.title}'`)) {
        clickInfo.event.remove()
      }
    },
    handleEvents(events) {
      this.currentEvents = events
    },
  }
}
</script>

<template>
  <div class='demo-app'>
    <div class='demo-app-sidebar'>
      <div class='demo-app-sidebar-section'>
        <h2>All Itineraries ({{ calendarOptions.initialEvents.length }})</h2>
        <ul>
          <li v-for='event in calendarOptions.initialEvents' :key='event.id'>
            <h5 class="d-block">Bus License: {{ event.title }}</h5>
            <p class="d-block"><b>Departure:</b> {{ event.extendedProps.departure }}</p>
            <p class="d-block"><b>Arrival:</b> {{ event.extendedProps.arrival }}</p>
          </li>
        </ul>
      </div>
    </div>
    <div class='demo-app-main'>
      <FullCalendar
        class='demo-app-calendar'
        :options='calendarOptions'
      >
        <template v-slot:eventContent='arg'>
          <b>{{ arg.timeText }}</b>
          <i>{{ arg.event.title }}</i>
        </template>
      </FullCalendar>
    </div>
  </div>
</template>

<style scoped lang='css'>
h2 {
  margin: 0;
  font-size: 16px;
}
ul {
  margin: 0;
  padding: 0 0 0 1.5em;
}
li {
  margin: 1.5em 0;
  padding: 0;
}
b { /* used for event dates/times */
  margin-right: 3px;
}
.demo-app {
  display: flex;
  min-height: 100%;
  font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
  font-size: 14px;
}
.demo-app-sidebar {
  width: 300px;
  line-height: 1.5;
  background: #eaf9ff;
  border-right: 1px solid #d3e2e8;
}
.demo-app-sidebar-section {
  padding: 2em;
}
.demo-app-main {
  flex-grow: 1;
  padding: 3em;
}
.fc { /* the calendar root */
  max-width: 1100px;
  margin: 0 auto;
}
</style>