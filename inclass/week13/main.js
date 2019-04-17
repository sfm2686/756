var hello = require("./hello"); // no need for the .js (it would work tho)
// everything that was exposed in the hello module (exported) is now
// available in the hello var
hello.world(); // invoke the module

var greetings = require("./greetings.js"); // just to show it works with .js :D
console.log(greetings.sayHelloInEnglish());
console.log(greetings.sayHelloInSpanish());

// include the http module that ships with node
var http = require("http");
http.createServer(function(request, response){
  // handle request
  console.log(request);
  response.writeHead(200, {"Content-type": "text/plain"});
  response.write("Hello world (again)");
  response.end();
}).listen(8888); // port
