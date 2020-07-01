$(document).ready(function(){
	displayRate();
	$('#selectrate').change(function(){
		displayRate();
	});
});
function displayRate(){
	var rate=$("#selectrate option:selected");
	var rateText=rate.data('rate-cnt')+' '+rate.data('full-name')+' = '+rate.data('rate')+' руб.';
	$('#currentrate').text(rateText);
}
