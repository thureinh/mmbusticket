<template>
<div class="row my-5">
	<div class="col-12 col-md-7 col-lg-7">
		<h3 class="text-center" style="color: #808b96;">Customer Information</h3>
		<div class="container">
			<form action="/book" method="POST">
				<input type="hidden" name="_token" :value="csrf"/>
				<input type="hidden" name="cart" :value="cart">
				<div class="form-group">
					<label>Name:</label>
					<input type="text" name="name" class="form-control" :class="error_bag.name ? 'is-invalid' : ''">
					<div v-if="error_bag.name !== undefined" class="invalid-feedback"><strong>{{ error_bag.name[0] }}</strong></div>
				</div>
				<div class="form-group">
					<label>Email:</label>
					<input type="text" name="email" class="form-control" :class="error_bag.email ? 'is-invalid' : ''">
					<div v-if="error_bag.email !== undefined" class="invalid-feedback"><strong>{{ error_bag.email[0] }}</strong></div>
				</div>
				<div class="form-group">
					<label>Phone:</label>
					<input type="text" name="phone" class="form-control" :class="error_bag.phone ? 'is-invalid' : ''">
					<div v-if="error_bag.phone !== undefined" class="invalid-feedback"><strong>{{ error_bag.phone[0] }}</strong></div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col">
							<label>Gender:</label>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<select class="form-control" name="gender">
								<option value="Male">Male</option>
								<option value="Female">Female</option>
								<option value="Gay">Gay</option>
							</select>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col">
							<label>Nationality:</label>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<select class="form-control" :class="error_bag.nationality ? 'is-invalid' : ''" name="nationality">
								<option value selected>Choose</option>
								<option>Myanmar</option>
								<option>Foreigner</option>
							</select>
							<div v-if="error_bag.nationality !== undefined" class="invalid-feedback"><strong>{{ error_bag.nationality[0] }}</strong></div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label>Note:</label>
					<input type="text" name="note" class="form-control">
				</div>
				<input type="submit" name="" class="btn btn-info form-control" value="Continue to Booking">
			</form>
		</div>
	</div>
	<customer-info 
	v-if="!retrieving"
	:company="informations.company" 
	:itinerary="informations.itinerary"
	:locations="informations.locations"
	:seats="seats"
	:showBtn="false"
	></customer-info>
</div>
</template>
<script>
	import CustomerInfo from './subcomponents/CustomerInfo.vue'
	export default{
		components: {
			'customer-info': CustomerInfo
		},
		props:{
			errors: Array,
			csrf: String
		},
		data(){
			return {
				retrieving: true,
				informations: {},
			}
		},
		computed:{
			seats(){
				return JSON.parse(localStorage.getItem('cart')).seats
			},
			error_bag(){
				if(this.errors[0])
					return JSON.parse(this.errors[0])
				return {}
			},
			cart(){
				return localStorage.getItem('cart')
			}
		},
		mounted(){
			let cart = JSON.parse(localStorage.getItem('cart'))
			axios.get(`/itinerary/${cart.itinerary_id}?api=true`)
			.then(resp => {
				this.informations = resp.data
				this.retrieving = false
				console.log('retrieving')
			})
		}
	}
</script>