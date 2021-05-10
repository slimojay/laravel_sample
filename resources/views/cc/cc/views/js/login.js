document.getElementById('fm').addEventListener('submit', function(e){
    e.preventDefault();
    var xhttp = new XMLHttpRequest();
xhttp.open("POST", "../../CMC/model/login.php", true); 
xhttp.setRequestHeader("Content-Type", "application/json");
xhttp.onreadystatechange = function() {
   if (this.readyState == 4 && this.status == 200) {
     // Response
     var response = this.responseText;
   }
};
var name = document.getElementById("name").value;
var pass = document.getElementById("pass").value;
var data = {username:name, password:pass};
xhttp.send(JSON.stringify(data));
});