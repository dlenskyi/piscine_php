function check_cookies() {
    var tab = document.cookie.split(';');
    if (Array.isArray(tab) && tab[0] != null) {
        for (var i = 0; i < tab.length; i++) {
            buf = tab[i].split('=');
            push(buf[1]);
        }
    }
}

function to_do() {
	var what_to_do = prompt("Please enter what TO DO: ");
	if (what_to_do !== null) {
		push(what_to_do);
	}
}

function pop() {
	if (confirm("Do you really want to remove this task?")) {
		this.parentNode.removeChild(this);
	}
}

function push(what_to_do) {
	if (what_to_do != null) {
		var div = document.createElement('DIV');
		var task = document.createTextNode(what_to_do);
		div.appendChild(task);
		var list = document.getElementById('ft_list');
		div.addEventListener("click", pop);
		div.addEventListener("click", function() {
			document.cookie = what_to_do + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
		});
		list.insertBefore(div, list.childNodes[0]);
		document.cookie = what_to_do + "=" + what_to_do + ";";
	}
}
