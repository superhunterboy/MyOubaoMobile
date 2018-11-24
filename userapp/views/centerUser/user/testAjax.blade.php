<html>
<head>
	{{ script('jquery-1.9.1') }}
</head>
<body>
	test ajax:
	<button id="testAjax">testAjax</button>
	<div id="getLoginUserMonetaryInfo"></div>
</body>
<script>
$('#testAjax').click(function(event) {
	$.ajax({
		url: "{{ route('users.user-monetary-info') }}",
		type: 'GET',
		dataType: 'json',
		data: {},
	})
	.done(function(data) {
		$('#getLoginUserMonetaryInfo').html(data['data']['available']);
		console.log("success");
	})
	.fail(function(data) {
		console.log("error");
	})
	.always(function(data) {
		console.log("complete");
	});
});



</script>
</html>