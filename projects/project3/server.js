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

/*************************** EMPLOYEE ENDPOINTS *******************************/
app.post(/CompanyServices\/employee$/, (req, res) => {
  res.type("json").send(JSON.stringify(bl.insertEmployee(
    req.body.emp_name, req.body.emp_no,
    req.body.hire_date, req.body.job,
    req.body.salary, req.body.dept_id,
    req.body.mng_id
    )));
});

app.get(/CompanyServices\/employees$/, (req, res) => {
  res.type("json").send(JSON.stringify(bl.getAllEmployees(req.query.company)));
});

app.get(/CompanyServices\/employee$/, (req, res) => {
  res.type("json").send(JSON.stringify(bl.getEmployee(req.query.emp_id)));
});

app.delete(/CompanyServices\/employee$/, (req, res) => {
  res.type("json").send(JSON.stringify(bl.deleteEmployee(req.query.emp_id)));
});

app.put(/CompanyServices\/employee$/, (req, res) => {
  res.type("json").send(JSON.stringify(bl.updateEmployee(
    req.body.emp_id, req.body.emp_name,
    req.body.emp_no, req.body.hire_date,
    req.body.job, req.body.salary,
    req.body.dept_id, req.body.mng_id
    )));
});

/*************************** TIMECARD ENDPOINTS *******************************/
app.post(/CompanyServices\/timecard$/, (req, res) => {
  res.type("json").send(JSON.stringify(bl.insertTimecard(
    req.body.emp_id, req.body.start_time,
    req.body.end_time)));
});

app.get(/CompanyServices\/timecards$/, (req, res) => {
  res.type("json").send(JSON.stringify(bl.getAllTimecards(
    req.query.emp_id)));
});

app.get(/CompanyServices\/timecard$/, (req, res) => {
  res.type("json").send(JSON.stringify(bl.getTimecard(
    req.query.timecard_id)));
});

app.delete(/CompanyServices\/timecard$/, (req, res) => {
  res.type("json").send(JSON.stringify(bl.deleteTimecard(
    req.query.timecard_id)));
});

app.put(/CompanyServices\/timecard$/, (req, res) => {
  res.type("json").send(JSON.stringify(bl.updateTimecard(
    req.body.timecard_id, req.body.emp_id,
    req.body.start_time, req.body.end_time
    )));
});

/**************************** COMPANY ENDPOINT ********************************/
app.delete(/CompanyServices\/company$/, (req, res) => {
  res.type("json").send(JSON.stringify(bl.deleteCompany(
    req.query.company)));
});
