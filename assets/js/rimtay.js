function contactSend() {
	var message = encodeURIComponent(document.getElementById("message").value);
	var phone = encodeURIComponent(document.getElementById("phone").value);
	var name = encodeURIComponent(document.getElementById("name").value);
	var email = encodeURIComponent(document.getElementById("email").value);
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function () {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById('success').innerHTML = '<font color="#2ecc71">Mesajınız başarıyla gönderildi</font>';
		} else if (this.readyState == 4 && this.status == 400) {
			var error = JSON.parse(this.responseText);
			document.getElementById('success').innerHTML = '<font color="#c0392b">Bir Hata Oluştu: ' + error["text"] + '</font>';
		} else if (this.readyState == 4 && this.status == 500) {
			var error = JSON.parse(this.responseText);
			document.getElementById('success').innerHTML = '<font color="#c0392b">Bir Hata Oluştu: ' + error["text"] + '</font>';
		}
	};
	xhttp.open("POST", "{{@REALM}}yollagelsin", true);
	xhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("name=" + name + "&phone=" + phone + "&email=" + email + "&message=" + message);
	return true;
}