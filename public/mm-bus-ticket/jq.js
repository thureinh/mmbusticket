$('document').ready(function () {
	var seat = $('#countno').val();
	//alert(seat);
	var countno=0;
	var arr=new Array();
	$('.seat').click(function(){
		var seatno = $(this).val();
		var index = arr.indexOf(seatno);
		//alert(index);
		if(index >= 0){
			arr.splice(index,1);
			countno -= 1;
		}else{
			arr.push(seatno);
			countno += 1;
		}
		if(countno>=seat){
			$('.seat').attr('disabled','disabled');
			for(var i=0;i<arr.length;i++){
				var no_disabled = arr[i];
				$('#'+no_disabled).removeAttr('disabled');
			}
		}else{
			$('.seat').removeAttr('disabled');
		}
		$('.seatno').val(arr);
		$(this).toggleClass('choose');
		//alert(countno);
	})
	let booking;
/*	$('#depaturedate').datepicker({
		format: 'dd-mm-yy',
		autoclose: true,
		todayHightlight: true,
		showOtherMonths: true,
		selectOtherMonths: true,
		changeMonth: true,
		changeYear:true,
		minDate: new Date()
	}); */
	$('#depaturedate').datepicker({ 
		dateFormat: 'dd-mm-yy',
		autoclose: true,
		todayHightlight: true,
		showOtherMonths: true,
		selectOtherMonths: true,
		changeMonth: true,
		changeYear:true,
		minDate: new Date() 
	}).val();


	$('#submit').click(function() {
		let	leavingfrom = $('#leavingfrom').val();
		let goingto     = $('#goingto').val();
		let depaturedate = $('#departuredate').val();
		let noseats = $('#noseats').val();
		let national =$('#nationality').val();
		//alert(leavingfrom+","+goingto+","+depaturedate+","+noseats+","+national);
		//$('#leavingfrom1').val("leavingfrom");
		booking = {
			leavingfrom: leavingfrom,
			goingto:goingto,
			depaturedate:depaturedate,
			noseats:noseats,
			national:national
		}
		//console.log(booking);
		let bookStr = localStorage.getItem('bookings');
		let bookArr;
		if (bookStr==null) {
            bookArr = Array();
          }
         bookArr = JSON.parse(bookStr);
         bookArr.push(booking);
         //console.log(bookArr);
         localStorage.setItem('bookings',JSON.stringify(bookArr));
	})
	$('#submit1').click(function() {
		let	leavingfrom = $('#leavingfrom1').val();
		let goingto     = $('#goingto1').val();
		let depaturedate = $('#departuredate1').val();
		let noseats = $('#noseats1').val();
		let national =$('#nationality1').val();
		//alert(leavingfrom+","+goingto+","+depaturedate+","+noseats+","+national);
		//$('#leavingfrom1').val("leavingfrom");
		booking = {
			leavingfrom: leavingfrom,
			goingto:goingto,
			depaturedate:depaturedate,
			noseats:noseats,
			national:national
		}
		//console.log(booking);
		let bookStr = localStorage.getItem('bookings');
		let bookArr;
		if (bookStr==null) {
            bookArr = Array();
          }else{
          	  localStorage.clear();
          	  bookArr = JSON.parse(bookStr);
         	  bookArr.push(booking);
          }
                //console.log(bookArr);
         localStorage.setItem('bookings',JSON.stringify(bookArr));
	})
  
});