var datalayer = require("companydata");
var Department = require("companydata").Department;
var Employee = require("companydata").Employee;
var Timecard = require("companydata").Timecard;
var date_fns = require('date-fns');

var DEFAULT_COMPANY = "sfm2686";

/**************************** DEPARTMENT LOGIC ********************************/
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

/***************************** EMPLOYEE LOGIC *********************************/
exports.insertEmployee = function(name, no, hireDate, job, sal, dept_id, mng_id) {
  var mng = datalayer.getEmployee(mng_id);
  if (mng == null && mng_id != 0) {
    return {Error: "mng_id must reference an existing employee"};
  }
  hire_date = new Date(hireDate);
  if (!date_fns.isPast(hire_date)) {
    return {Error: "hire_date must be in the past"};
  }
  if (date_fns.isWeekend(hire_date)) {
    return {Error: "hire_date cannot be a weekend"};
  }
  var dept = datalayer.getDepartment(DEFAULT_COMPANY, dept_id);
  if (dept == null) {
    return {Error: "dept_id must reference an existing department"};
  }
  var emp = datalayer.insertEmployee(new Employee(name, no, hireDate, job, sal, dept_id, mng_id));
  if (emp == null) {
    return {Error: "emp_no must be unique"};
  }
  return emp;
}

exports.getAllEmployees = function(company) {
  console.log(company);
  return datalayer.getAllEmployee(company);
}

exports.getEmployee = function(id) {
  var emp = datalayer.getEmployee(id);
  if (emp == null) {
    return {Error: "no employee found with id: " + id};
  }
  return emp;
}

exports.deleteEmployee = function(id) {
  var emp = datalayer.getEmployee(id);
  if (emp == null) {
    return {Error: "no employee found with id: " + id};
  }
  datalayer.deleteEmployee(id);
  return {Success: "Employee " + id + " has been deleted"};
}

exports.updateEmployee = function(id, name, no, hireDate, job, sal, dept_id, mng_id) {
  var emp = datalayer.getEmployee(id);
  if (emp == null) {
    return {Error: "no employee found with id: " + id};
  }
  var mng = datalayer.getEmployee(mng_id);
  if (mng == null && mng_id != 0) {
    return {Error: "mng_id must reference an existing employee"};
  }
  hire_date = new Date(hireDate);
  if (!date_fns.isPast(hire_date)) {
    return {Error: "hire_date must be in the past"};
  }
  if (date_fns.isWeekend(hire_date)) {
    return {Error: "hire_date cannot be a weekend"};
  }
  var dept = datalayer.getDepartment(DEFAULT_COMPANY, dept_id);
  if (dept == null) {
    return {Error: "dept_id must reference an existing department"};
  }
  emp.setJob(job);
  emp.setEmpName(name);
  emp.setEmpNo(no);
  emp.setSalary(sal);
  emp.setDeptId(dept_id);
  emp.setHireDate(hireDate);
  emp.setMngId(mng_id);
  var updated = datalayer.updateEmployee(emp);
  if (updated == null) {
    updated = {Error: "emp_no must be unique"};
  }
  return updated;
}
