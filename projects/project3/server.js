const express = require("express");
const app = express();

var bl = require('./businessLayer');

// // requiring this to parse POSTed data
// const bodyParser = require("body-parser");
// // when extended is false, created objects are array or object ally
// const urlEncodedParser = bodyParser.urlencoded({extended: false});
// const sjsonParser = bodyParser.json();
app.use(express.urlencoded({extended:false}))
app.use(express.json())

      // port, callback function for listening (arrow replaces the word function in ES6)
      // TODO change port to 8080*********************************
const server = app.listen(8080, () => {
        const host = server.address().address,
              port = server.address().port;
              console.log("App listening at http://%s:%s: ", host, port);
        });

/************************** DEPARTMENT ENDPOINTS ******************************/
app.get(/CompanyServices\/department$/, (req, res) => {
  resp = bl.getDept(req.query.company, req.query.dept_id);
  res.type("json").send(JSON.stringify(resp));
});

app.get(/CompanyServices\/departments$/, (req, res) => {
  resp = bl.getAllDepts(req.query.company);
  res.type("json").send(JSON.stringify(resp));
});

app.post(/CompanyServices\/department$/, (req, res) => {
  res.type("json").send(JSON.stringify(bl.insertDept(req.body.company, req.body.dept_name,
  req.body.dept_no, req.body.location)));
});

app.delete(/CompanyServices\/department$/, (req, res) => {
  resp = bl.deleteDept(req.query.company, req.query.dept_id);
  res.type("json").send(JSON.stringify(resp));
});

app.put(/CompanyServices\/department$/, (req, res) => {
  res.type("json").send(JSON.stringify(bl.updateDept(req.body.company, req.body.dept_name,
  req.body.dept_no, req.body.location, req.body.dept_id)));
});
