$(document).ready(function() {
    var tab = document.cookie.split(';');
    if (Array.isArray(tab) && tab[0] != null) {
        for (var i = 0; i < tab.length; i++) {
            buf = tab[i].split('=');
            push(buf[1]);
        }
    }
})

function to_do() {
	var what_to_do = prompt("Please enter what TO DO: ");
	if (what_to_do !== null) {
		push(what_to_do);
	}
}

function pop() {
	if (confirm("Do you really want to remove this task?")) {
		this.remove();
		remove_cookie(this.innerHTML);
	}
}

function remove_cookie(list) {
	document.cookie = list + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}

function push(what_to_do) {
	if (what_to_do != null) {
		$('#ft_list').prepend($('<div>' + what_to_do + '</div>').click(pop));
		document.cookie = what_to_do + "=" + what_to_do + ";";
	}
}