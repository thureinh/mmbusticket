<template>
<div class="row">
	<div class="col-lg-5">
		<div class="card">
			<div class="card-header d-flex align-items-center">
			  <h3 class="h4">Main Form</h3>
			</div>
			<div class="card-body">
			  <form :action="url" method="POST">
			  	<input type="hidden" name="_token" :value="csrf"/>
			  	<input type="hidden" name="itineraries" :value="itineraries">
			  	<input type="hidden" name="duration" :value="duration">
			    <div class="form-group">
			      <label class="form-control-label">Departure</label>
			      <input type="datetime-local" name="departure" v-model="departure" placeholder="Departure Date & Time" class="form-control" :class="error_bag.departure ? 'is-invalid' : ''">
                    <div v-if="error_bag.departure !== undefined" class="invalid-feedback"><strong>{{ error_bag.departure[0] }}</strong></div>
			    </div>
			    <div class="form-group">
			      <label class="form-control-label">Duration</label>
			      <time-picker @update-time="updateTime" v-once></time-picker> 
			      <div v-if="error_bag.duration !== undefined" class="alert alert-danger mt-0" role="alert"><strong>{{ error_bag.duration[0] }}</strong></div>                   
			    </div>
			    <div class="form-group">
			      <label class="form-control-label">Arrival</label>
			      <input type="text" v-model="arrival" placeholder="Arrival Date & Time" class="form-control" disabled>
			    </div>
				<div class="form-group">
			      	<label class="form-control-label">Select Bus</label>
			        <select name="license" model="bus" class="form-control mb-3" :class="error_bag.license ? 'is-invalid' : ''">
			          <option value="0">Choose By License Number</option>
			          <option v-for="(bus, index) in buses" :key="index" :value="bus.id">{{ bus.license }}</option>
			        </select>
			        <div v-if="error_bag.license !== undefined" class="invalid-feedback"><strong>{{ error_bag.license[0] }}</strong></div>
			    </div>
				<div class="form-group">
			      	<label class="form-control-label">Foreigner Allowrance</label>
			      	<div>
			          	<input id="optionsRadios1" type="radio" checked value="true" name="f_allowrance">
			          	<label for="optionsRadios1">Allow Foreigners</label>
			        </div>
		            <div>
		                <input id="optionsRadios2" type="radio" value="false" name="f_allowrance">
		                <label for="optionsRadios2">Disallow Foreigners</label>
		            </div>
			    </div>
			    <div class="form-group">
			    	<label class="form-control-label">Price</label>
		            <div class="input-group">
		                <div class="input-group-prepend"><span class="input-group-text">MMK</span></div>
			                <input type="number" name="price" class="form-control" :class="error_bag.price ? 'is-invalid' : ''" min="0">
			            <div class="input-group-append"><span class="input-group-text">.00</span></div>
			            <div v-if="error_bag.price !== undefined" class="invalid-feedback"><strong>{{ error_bag.price[0] }}</strong></div>
		            </div>
		        </div>
			    <div class="form-group">       
			      <input type="submit" value="Create Itinerary" class="btn btn-primary">
			      <a :href="back_url" class="btn btn-secondary">Back</a>
			    </div>
			  </form>
			</div>
		</div>
	</div>
	<div class="col-lg-7">
		<form>
			<div class="card">
	            <div class="card-header d-flex align-items-center">
	              <h3 class="h4">Location Form</h3>
	            </div>
	            <div class="card-body">
	              	<form>
		                <div class="form-group">
	                		<select-box2 :data="location_data" :errors="error_bag" @sendSelectedValue="getSelectedValue"></select-box2>
	                		<div v-if="error_bag.itineraries !== undefined" class="invalid-feedback"><strong>{{ error_bag.itineraries[0] }}</strong></div>
							<div class="d-flex justify-content-end">
								<button type="button" @click="addTable" class="btn btn-sm btn-primary ml-aut">Add Location</button>
							</div>
						</div>
	              	</form>
	              	<div class="table-responsive">                       
                        <div class="table-responsive">                       
	                        <table class="table table-bordered table-hover">
	                          <thead>
	                            <tr>
	                              <th class="text-center">#</th>
	                              <th class="text-center">Image</th>
	                              <th class="text-center">Location</th>
	                              <th class="text-center">Move</th>
	                              <th class="text-center">Extra</th>
	                              <th class="text-center">Delete</th>
	                            </tr>
	                          </thead>
	                          <tbody>
	                          	<template v-for="(selected, index) in selected_locations">
	                          		<tr :key="index">
		                              <th scope="row">{{index + 1}}</th>
		                              <td>
		                              	<div class="d-flex justify-content-center">
		                              		<img :src="selected.image" width="50" height="50" alt="" class="img-thumbnail">
		                              	</div>
		                              </td>
		                              <td class="text-center">{{selected.english}} ( {{selected.myanmar}} )</td>
		                              <td>
		                              	<div class="row">
		                              		<div class="col-6 d-flex justify-content-center">
		                              			<button type="button" @click="moveup(index)" class="btn btn-sm btn-info">
		                              				<i class="fas fa-arrow-up"></i>
		                              			</button>
		                              		</div>
		                              		<div class="col-6 d-flex justify-content-center">
		                              			<button type="button" @click="movedown(index)" class="btn btn-sm btn-info">
		                              				<i class="fas fa-arrow-down"></i>
		                              			</button>
		                              		</div>
		                              	</div>
		                              </td>
		                              <td>	
		                              	<div class="d-flex justify-content-center">
		                              		<button type="button" @click="getFocusId(index)" class="btn btn-sm btn-success" data-toggle="modal" data-target="#exampleModalCenter"><i class="fas fa-plus-square"></i></button>
		                              		<!-- Modal -->
											<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
											  <div class="modal-dialog modal-dialog-centered" role="document">
											    <div class="modal-content">
											      <div class="modal-header">
											        <h5 class="modal-title" id="exampleModalLongTitle">Write Extra Info Here</h5>
											        <button type="button" class="close" data-dismiss="modal" aria-label="OK">
											          <span aria-hidden="true">&times;</span>
											        </button>
											      </div>
											      <div class="modal-body">
											        <form>
											        	<textarea v-model="extra_info" class="form-control" rows="3"></textarea>
											        </form>
											      </div>
											      <div class="modal-footer">
											        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
											        <button type="button" @click="insertExtra" class="btn btn-primary" data-dismiss="modal">Save changes</button>
											      </div>
											    </div>
											  </div>
											</div>
											<!-- Modal -->
		                              	</div>
		                              </td>
		                              <td>	
		                              	<div class="d-flex justify-content-center">
		                              		<button type="button" @click="deleteLocation(index)" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
		                              	</div>
		                              </td>
		                            </tr>
	                          	</template>	                      
	                          </tbody>
	                        </table>
                      	</div>
                    </div>
	            </div>
	        </div>
		</form>
	</div>
</div>	
</template>
<script>
	const select_box = Vue.component('select-box2', {
		template:   `<select class="form-control" :class="errors.itineraries ? 'is-invalid' : ''">
						<option value="0">Select Location</option>
					  	<option v-for="(location, index) in data" :key="index"  :value="location.id" :data-image="location.image">
					  		{{location.english}} ( {{location.myanmar}} )
					  	</option>
					</select>`,
		props: {
			data: Array,
			errors: Object || Array
		},
		mounted: function(){
			let self = this
			let select_box = $(this.$el).select2({
				theme: 'bootstrap4',
				templateResult: this.formatState
			})
			select_box.on("change", (e) => { 
				let location_id = $(this.$el).find(':selected').val()
				self.$emit('sendSelectedValue', location_id)
			});
			$('span.selection').addClass('w-100')
		},
		methods: {
			formatState (state) {
				if (!$(state.element).data('image')) {
			    	return state.text;
			  	}
				var url = $(state.element).data('image');
			  	var $state = $(
			    	'<span><img src="' + url + '" class="img-thumbnail" width="90" height="90"/>&nbsp;&nbsp;' + state.text + '</span>'
			  	);
			  return $state;
			}
		}
	});
	const date_picker = Vue.component('time-picker', {
	  template: '<input type="text" name="duration" placeholder="Duration" autocomplete="off" class="form-control">',
	  props: [ 'dateFormat' ],
	  mounted: function() {
	  	var self = this;
	    $(this.$el).timepicker({
	        timeFormat: 'HH:mm',
	        interval: 30,
	        minTime: '00:30',
	        maxTime: '23:30',
	        startTime: '00:30',
	        dynamic: false,
	        dropdown: true,
	        scrollbar: true,
	        change: function(time) {
	            // the input field
	            let element = $(this), text;
	            // get access to this Timepicker instance
	            let newTime = element.timepicker().format(time);
	            self.$emit('update-time', newTime)
	        }
	    });
	  },
	});
	export default{
		mounted() {
			this.location_data = this.locations
		},
		components: {
			date_picker,
			select_box
		},
		props: {
			buses: Array,
			locations: Array,
			url: String,
			csrf: String,
			errors: Array,
			back_url: String
		},
		data() {
			return {
				departure: null,
				duration: null,
				bus: '0',
				selected_locations: [],
				location_data: [],
				selected_value: 0,
				extra_info: '',
				modal_focus_id: 0
			}
		},
		computed: {
			error_bag(){
				if(this.errors[0])
					return JSON.parse(this.errors[0])
				return {}
			},
			arrival(){
				if(this.departure && this.duration)
				{
					let duration_time = this.duration.split(':')
					let hours = duration_time[0]
					let minutes = duration_time[1]
					return moment(this.departure).add({hours, minutes}).format("MM/DD/YYYY hh:mm A")
				}
				return null
			},
			itineraries(){
				let return_arr = []
				this.selected_locations.forEach(function(element, index) {
					return_arr.push({index, id: element.id, extra: element.extra})
				})
				return JSON.stringify(return_arr)
			}
		},
		methods: {
			updateTime: function(time){
				this.duration = time
			},
			insertExtra(){
				this.selected_locations = this.selected_locations.map((element, index) => {
					if(this.modal_focus_id === index){
						element['extra'] = this.extra_info
						this.extra_info = ''
					}
					return element
				})
			},
			getFocusId(idx){
				this.modal_focus_id = idx
				const itineraries = JSON.parse(this.itineraries)
				const result = itineraries.filter(function(itinerary){
					return itinerary.index == idx
				})
				this.extra_info = result[0].extra
			},
			addTable: function(){	
				let not_include = true
				let result = this.locations.filter(obj => {
					return obj.id === this.selected_value
				})
				this.selected_locations.forEach(obj => {
					if(obj.id === this.selected_value)
					{
						not_include = false
						return
					}
				})	
				if(not_include && result[0])
					this.selected_locations.push(result[0])
			},
			getSelectedValue: function(selected){
				this.selected_value = Number(selected)
			},
			moveup: function(idx){
				const temp_arr = this.selected_locations
				if(idx === 0) return
				this.selected_locations = this.array_move(temp_arr, idx, idx - 1)				
			},
			movedown: function(idx){
				const temp_arr = this.selected_locations
				if(idx === temp_arr.length - 1) return
				this.selected_locations = this.array_move(temp_arr, idx, idx + 1)	
			},
			deleteLocation: function(idx){
				this.selected_locations.splice(idx, 1);
			},
			array_move(arr, old_index, new_index) {
			    if (new_index >= arr.length) {
			        var k = new_index - arr.length + 1;
			        while (k--) {
			            arr.push(undefined);
			        }
			    }
			    arr.splice(new_index, 0, arr.splice(old_index, 1)[0]);
			    return arr; 
			},
		}
	}
</script>