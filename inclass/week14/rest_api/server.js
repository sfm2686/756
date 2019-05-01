// some ES6 syntax are used in this script

const express = require("express"),
      app = express(),
      // requiring this to parse POSTed data (in the body of the request)
      bodyParser = require("body-parser"),
      // when extended is false, created objects are array or object ally
      urlEncodedParser = bodyParser.urlencoded({extended: false}),
      jsonParser = bodyParser.json(),

      fs = require("fs"), // import file system
      multer = require("multer"), // to deal with multipart form data
      upload = multer({dest: "./tmp/"}) //  where we want the files to be uploaded too temporarily
                                        // make sure you also create the tmp dir in the project root

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

app.delete("/employee", (req, res) => {
  console.log("DELETE request for employee");
  res.send("HELLO DELETE");
});

app.get("/ab*cd", (req, res) => { // path: ab(wilcdard: any path..)cd so /abSOMETHINGcd leads here
  console.log("GET request for /ab*cd");
  res.send("Hello pattern match");
});

// to serve static files (images, js files, css...etc)
// path: localhost:1234/{PATH STARTING FROM PUBLIC DIR TO THE RESOURCE}
// in this project: localhost1234/images/image1.png
// this logic should be done before routing logic
app.use(express.static("public"));

// for static pages (like index.html in this project)
app.get("/index.html", (req, res) => {
  res.sendFile(__dirname + "/index.html"); // sendFile needs an absolute path
});

// handling file upload
// path in the form + name of upload input HTML element
app.post("/file_upload", upload.single("file"), (req, res) => {
  console.log(req.file);
  const file = __dirname + "/uploads/" + req.file.originalname;

  // read from the temp location /tmp/ where mutler put the file
  fs.readFile(req.file.path, (err, data) => {
    // write out to the upload dir, with original f ile name
    fs.writeFile(file, data, (err) => {
      if (err) {
        console.log(err);
      } else {
        response = {
          message: "File uploaded successfully",
          filename: req.file.originalname
        };
        console.log(response);
        res.type("json").send(JSON.stringify(response));
      }
    });
  });
});
