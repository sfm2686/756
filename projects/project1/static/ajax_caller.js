function validate(url, element, feedback_div) {
  xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        if (this.responseText == 'true') {
          // document.getElementById(fb.id).innerHTML = "<p class='bg-success'>Valid</p>";
          feedback_div.innerHTML = "<p class='bg-success'>Valid</p>";

        } else {
          // document.getElementById(fb.id).innerHTML = "<p class='bg-danger'>Invalid</p>";
          feedback_div.innerHTML = "<p class='bg-danger'>Invalid</p>";
        }
      }
  };
  args = '?' + element.name + '=' + element.value;
  xmlhttp.open("GET",  url + args , true);
  data = JSON.stringify(element.name + '=' + element.value);
  xmlhttp.send(data);
}
