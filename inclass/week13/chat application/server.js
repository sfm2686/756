// only using HTTP server to connect the  websocket
var http = require("http"),
  server = http.createServer(function(request, response) {

  });

server.listen(1234, function() {
  console.log(new Date() + " server is listening on port 1234");
});

// attach websocket server to the http server connection its riding on
var webSocketServer = require("websocket").server,
  wsServer = new webSocketServer({
    httpServer: server
  });
var count = 0; // # of connections to the server
var clients = {}; // all clients that are connected to the server

wsServer.on("request", function(request){ // on this event, run this function
  // params: sub-protocol, request domain
  var connection = request.accept(null, request.origin);
  var id = count++; // unique ID for each connection

  clients[id] = connection;
  console.log(new Date() + " connection accepted [" + id + "]");

  // event listner on WS connection
  connection.on("message", function(msg) {
    // console.log(msg);
    var msgString = msg.utf8Data;
    console.log("Message received from [" + id + "]: " + msgString);
    // go over all the clients and push the new message to them
    for (var i in clients) {
      clients[i].sendUTF(msgString);
    }
  });

  // on connection close, delete client from clients array and log it to console
  // (terminal since we're doing server side dev)
  connection.on("close", function(reasonCode, description) {
    delete clients[id];
    console.log(new Date() + " User " + connection.remoteAddress + " disconnected");
  });

});
