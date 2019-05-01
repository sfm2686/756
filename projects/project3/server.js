const express = require("express");
const app = express();
      // requiring this to parse POSTed data (in the body of the request)
const bodyParser = require("body-parser");
      // when extended is false, created objects are array or object ally
const urlEncodedParser = bodyParser.urlencoded({extended: false});
const sjsonParser = bodyParser.json();

      // port, callback function for listening (arrow replaces the word function in ES6)
const server = app.listen(1234, () => {
        const host = server.address().address,
              port = server.address().port;
              console.log("App listening at http://%s:%s: ", host, port);
      });
