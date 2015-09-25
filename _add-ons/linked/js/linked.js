$( "select[data-linked-linkto]" ).change(function() {
	var selection = $(this).val();
	var linked_field = $(this).attr("data-linked-linkto");
	
	// have to do the `$=` selector because in a grid the field is `page][0][foo` so
	// just look for it at the end.
	var lookup = $('select[data-linked-field$="' + linked_field + '"]').attr("data-linked-key");
	
	// get the related values
    $.ajax({
        url: "/TRIGGER/linked/get_values",
        dataType: "json",
        async: false,
 		data: {
 			'file': selection,
 			'lookup': lookup
 		},
 		success: function(data, textStatus, jqXHR) {
			var selectize = $('select[data-linked-field$="' + linked_field + '"]')[0].selectize;

			selectize.clearOptions(); // remove old options
			selectize.addOption(data); // add new ones
 		}
    });
});