<template>
<div class="offset-md-1 col-12 col-md-4 col-lg-4">
	<h3 class="text-center" style="color: #808b96;">Trip Information</h3>
	<div class="row">
			<img :src="'http://localhost:8000/storage/' + company.logo" width="200" height="100" class="rounded mx-auto d-block" alt="...">
	</div>
	<div class="row my-4">
		<table class="table">
			<tr>
				<td>Operator:</td>
				<td>{{company.name}}</td>
			</tr>
			<tr>
				<td>Route:</td>
				<td>
					<template v-for="(location, index) in locations">
						{{location.location_name}}&nbsp;<template v-if="index !== locations.length - 1">-</template> 
					</template>
				</td>
			</tr>
			<tr>
				<td>Departure:</td>
				<td>{{departure}}</td>
			</tr>
			<tr>
				<td>Arrival ≈</td>
				<td>{{arrival}}</td>
			</tr>
			<tr>
				<td>Total:</td>
				<td>{{totalprice}}&nbsp;MMK</td>
			</tr>
			<tr>
				<td>Seat No:</td>
				<td>									
					<input type="text" :value="seats" class="form-control" readonly>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<form>
						<input type="hidden" name="taken_seats" :value="seatsJson">
						<a v-if="showBtn" href="/customerform" value="Continue to Booking" class="form-control btn btn-info">Continue to Booking</a>
					</form>
				</td>
			</tr>		
		</table>
	</div>
</div>
</template>
<script>
	export default{
		props: {
			itinerary: Object,
			company: Object,
			locations: Array,
			seats: Array,
			showBtn: {
				type: Boolean,
				default: true
			}
		},
		computed: {
			totalprice(){
				return this.seats.length * this.itinerary.price
			},
			departure(){
				return moment(this.itinerary.departure).format("dddd, MMMM Do YYYY, h:mm A")
			},
			arrival(){
				let duration_time = this.itinerary.duration.split(':')
				let hours = duration_time[0]
				let minutes = duration_time[1]
				return moment(this.itinerary.departure).add({hours, minutes}).format("dddd, MMMM Do YYYY, h:mm A")
			},
			seatsJson()
			{
				localStorage.setItem("cart", JSON.stringify({
					itinerary_id: this.itinerary.id,
					seats: this.seats
				}))
				return localStorage.getItem("cart")
			}
		}
	}
</script>