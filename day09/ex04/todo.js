$(document).ready(function() {
	$.ajax ({
		url: 'select.php',
		success: function (response) {
			var tab = JSON.parse(response);
    		if (Array.isArray(tab) && tab[0] != null) {
     	   		for (var i = 0; i < tab.length; i++) {
          			if (tab[i] != null) {
          				buf = tab[i].split(';');
            			push_prev(buf[1]);
            		}
            	}
        	}
    	}
	});
})

function push_prev(what_to_do) {
	if (what_to_do != null) {
      var elem = $('#ft_list').prepend($('<div>' + what_to_do + '</div>').click(pop));
  	}
}

function to_do() {
	var what_to_do = prompt("Please enter what TO DO: ");
	if (what_to_do != null) {
		push(what_to_do);
	}
}

function pop() {
	if (confirm("Do you really want to remove this task?")) {
		this.remove();
		pop_data(this.innerHTML);
	}
}

function push(what_to_do) {
	if (what_to_do != null) {
		$('#ft_list').prepend($('<div>' + what_to_do + '</div>').click(pop));
	}
	$.ajax ({
		type: "GET",
		url: "insert.php?" + what_to_do + "=" + what_to_do
	});
}

function pop_data(what_to_do) {
    $.ajax({
        type: "GET",
        url: "delete.php?" + what_to_do + "=" + what_to_do,
        success: function () {}
    });
}