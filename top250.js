$(document).ready(function() {
	$("button").click(function() {
		var id = $(this).attr("id");
		var mvname = $(this).attr("name");
		var api = 'http://top250.ml/top250api.php?id=' + id;
		$.getJSON(api)
			.done(function (json) {
				$("#myModalLabel").text(mvname);
				$("#downlist").empty();
				$.each(json, function(index, val) {
					$("<a>").text(val.name).attr('uhash', val.uhash).attr('btid', val.btid).attr('type', 'button').attr('class', 'btn btn-link').appendTo('#downlist');
				});
			});
	});

	$('#myModal').on('shown.bs.modal', function(e) {
		$("a").click(function() {
			var uhash = $(this).attr("uhash");
			var btid = $(this).attr("btid");
			$("#formid").attr('value', btid);
			$("#formuhash").attr('value', uhash);
			$("#formdown").click();
			$('#myModal').modal('hide');
		});
	});
});
