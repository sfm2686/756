// some ES6 syntax are used in this script

const express = require("express"),
      app = express(),
      // requiring this to parse POSTed data (in the body of the request)
      bodyParser = require("body-parser"),
      // when extended is false, created objects are array or object ally
      urlEncodedParser = bodyParser.urlencoded({extended: false}),
      jsonParser = bodyParser.json(),
      // port, callback function for listening (arrow replaces the word function in ES6)
      server = app.listen(1234, () => {
        const host = server.address().address,
              port = server.address().port;
              console.log("App listening at http://%s:%s: ", host, port);
      });

// app.get => GET request, app.post => POST ..etc
app.get("/", (req, res) => {
  console.log("GET request for homepage");
  res.send("Hello world");
});

app.post("/", (req, res) => {
  console.log("POST request for homepage");
  // status & other header specific stuff have to be BEFORE the send
  res.status(201).send("Hello POST");
});

app.get("/employee", (req, res) => {
  console.log("GET request for employee");
  // first can be found in the query labled as (first_name)
  const response = {
    first: req.query.first_name,
    last: req.query.last_name
  };
  res.type("json").send(JSON.stringify(response));
});

app.post("/employee", urlEncodedParser, (req, res) => {
  console.log("POST request for employee");
  response = {
    first: req.body.first_name,
    last: req.body.last_name
  };
  res.status(201).
      type("json").
      send(JSON.stringify(response));
});

app.post("/dept", jsonParser, (req, res) => {
  console.log("POST request for employee");
  response = {
    dept_name: req.body.name,
    dept_num: req.body.num
  };
  res.status(201).
      type("json").
      send(JSON.stringify(response));
});
