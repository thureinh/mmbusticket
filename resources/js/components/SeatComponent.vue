<template>
	<div class="row my-5">
		<div class="col-12 col-md-7 col-lg-7">
			<h3 class="text-center" style="color: #808b96;">Please Select Seats</h3>
			<div class="row p-2 pl-5">
				<template v-for="seat in seats">
					<div v-if="seat.status === 'unavailable'" :key="seat.id" class="col-md-3 col-lg-3 my-2 w-25 h-25" >
						<input type="button" name="seat" :value="seat.seat_number" :id="seat.seat_number" class="btn btn-danger w-50 h-25 shadow text-center" disabled="disabled">
					</div>

					<div v-if="seat.status === 'available'" :key="seat.id" class="col-md-3 col-lg-3 my-2 w-25 h-25" >
						<input type="button" name="seat" @click="operateSelection(seat.seat_number)" :value="seat.seat_number" :id="seat.seat_number" class="btn w-50 h-25 seat shadow text-center" style="border: solid 1px black;">
					</div>
				</template>
			</div>
			<div class="container my-5">
				<table class="table">
				<tr>
					<td><button class="btn btn-danger text-danger w-50 h-50  my-1" disabled="">&nbsp;</button></td>
					<td class="pt-4"><span class=" mr-3">-</span>Unavailable Seats</td>
				</tr>
				<tr>
					<td><button class="btn w-50 h-50  choose my-1" style="color: #2E86C1">&nbsp;</button></td>
					<td class="pt-4"><span class=" mr-3">-</span>Your Selected Seats</td>
				</tr>
				<tr>
					<td><button class="btn w-50 h-50  my-1" disabled="" style="border: solid 1px black; color: white;">&nbsp;</button></td>
					<td class="pt-4"><span class=" mr-3">-</span>Available Seats</td>
				</tr>
			</table>
			</div>
		</div>
		<customer-info :seats='selected_seats' :itinerary='itinerary' :locations='locations' :company='company'></customer-info>
	</div>
</template>
<script>
	import CustomerInfo from './subcomponents/CustomerInfo.vue'
	export default{
		components: {
			'customer-info': CustomerInfo
		},
		props: {
			seats: Array,
			itinerary: Object,
			company: Object,
			locations: Array
		},
		data(){
			return {
				selected_seats: []
			}
		},
		methods: {
			operateSelection(seatnum)
			{
				if(this.selected_seats.indexOf(seatnum) !== -1)
					this.selected_seats.splice(this.selected_seats.indexOf(seatnum), 1)
				else
					this.selected_seats.push(seatnum)
			}
		}
	}
</script>