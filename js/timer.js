var startTime, countAmt, interval;

function now() {
	return ((new Date()).getTime());
}

function tick() {
	var elapsed = now() - startTime;
	var cnt = countAmt - elapsed;
		
	if(cnt < 0) {
	clearInterval(interval);
	startTimer(180);
	}
}

function startTimer(secs) {
	clearInterval(interval);
	countAmt = secs * 1000;
	startTime = now();
  
	$.post("infoload_demand.php")
		.done(function(data){
			$("#demand_qty").html(data);
		})
		.fail(function(){
			console.log('error load');
		});

	$.post("infoload_QA.php")
		.done(function(data){
			$("#qa_qty").html(data);
		})
		.fail(function(){
			console.log('error load');
		});		
		
	$.post("infoload_receive.php")
		.done(function(data){
			$("#receive_qty").html(data);
		})
		.fail(function(){
			console.log('error load');
		});

	$.post("infoload_notreceive.php")
		.done(function(data){
			$("#not_receive_qty").html(data);
		})
		.fail(function(){
			console.log('error load');
		});

	interval = setInterval(tick, 1000);  
}

startTimer(180);