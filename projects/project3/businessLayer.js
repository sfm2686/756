var datalayer = require("companydata");
var Department = require("companydata").Department;
var Employee = require("companydata").Employee;
var Timecard = require("companydata").Timecard;

exports.getAllDepts = function (company) {
  return datalayer.getAllDepartment(company);
}

exports.getDept = function (company, id) {
  var resp = datalayer.getDepartment(company, id);
  if (resp == null) {
    resp = {Error: "No department found with dept_id: " + id};
  }
  return resp;
}

exports.insertDept = function(company, name, no, loc) {
  var inserted = datalayer.insertDepartment(new Department(company, name, no, loc));
  if (inserted == null) {
    inserted = {Error: "dept_no must be unique"};
  }
  return inserted;
}

exports.deleteDept = function(company, id) {
  var resp = datalayer.getDepartment(company, id);
  if (resp == null) {
    return {Error: "No department found with dept_id: " + id};
  }
  datalayer.deleteDepartment(company, id);
  return {Success: "Department " + id + " has been deleted"};
}

exports.updateDept = function(company, name, no, loc, id) {
  var result = datalayer.getDepartment(company, id);
  if (result == null) {
    return {Error: "No department found with dept_id: " + id};
  }
  result.setDeptName(name);
  result.setLocation(loc);
  result.setDeptNo(no);
  var updated = datalayer.updateDepartment(result);
  if (updated == null) {
    updated = {Error: "dept_no must be unique"};
  }
  return updated;
}
