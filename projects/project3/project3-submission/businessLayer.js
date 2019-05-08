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
    return {Error: "No department found with dept_id: " + id};
  }
  return {Success: resp};
}

exports.insertDept = function(company, name, no, loc) {
  var inserted = datalayer.insertDepartment(new Department(company, name, no, loc));
  if (inserted == null) {
    return {Error: "dept_no must be unique"};
  }
  return {Success: inserted};
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
    return {Error: "dept_no must be unique"};
  }
  return {Success: updated};
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
  return {Success: emp};
}

exports.getAllEmployees = function(company) {
  console.log(company);
  return datalayer.getAllEmployee(company);
}

exports.getEmployee = function(id) {
  var emp = datalayer.getEmployee(id);
  if (emp == null) {
    return {Error: "No employee found with id: " + id};
  }
  return {Success: emp};
}

exports.deleteEmployee = function(id) {
  var emp = datalayer.getEmployee(id);
  if (emp == null) {
    return {Error: "No employee found with id: " + id};
  }
  datalayer.deleteEmployee(id);
  return {Success: "Employee " + id + " has been deleted"};
}

exports.updateEmployee = function(id, name, no, hireDate, job, sal, dept_id, mng_id) {
  var emp = datalayer.getEmployee(id);
  if (emp == null) {
    return {Error: "No employee found with id: " + id};
  }
  var mng = datalayer.getEmployee(mng_id);
  if (mng == null && mng_id != 0) {
    return {Error: "mng_id must reference an existing employee"};
  }
  var hire_date = new Date(hireDate);
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
    return {Error: "emp_no must be unique"};
  }
  return {Success: updated};
}

/***************************** TIMECARD LOGIC *********************************/
exports.insertTimecard = function(emp_id, start_d, end_d) {
  var emp = datalayer.getEmployee(emp_id);
  if (emp == null) {
    return {Error: "No employee found with id: " + emp_id};
  }
  var start = new Date(start_d);
  var end = new Date(end_d);
  // checking start_time is current date or at least within 1 week ago
  if (date_fns.differenceInDays(start, new Date()) < -7 || !date_fns.isPast(start)) {
    return {Error: "start_time must be between current date and 1 week ago"};
  }
  if (date_fns.isWeekend(start)) {
    return {Error: "start_time cannot be a weekend"};
  }
  if (date_fns.getHours(start) < 6 || date_fns.getHours(start) > 18) {
    return {Error: "start_time must be between the hours of 6 and 18 (24h format)"};
  }
  if (date_fns.isWeekend(end)) {
    return {Error: "end_time cannot be a weekend"};
  }
  if (date_fns.getHours(end) < 6 || date_fns.getHours(end) > 18) {
    return {Error: "end_time must be between the hours of 6 and 18 (24h format)"};
  }
  if (date_fns.differenceInHours(end, start) < 1) {
    return {Error: "end_time must be at least 1 hour greater than start_time"};
  }
  // validate start date not the same as any other start date
  var tcs = datalayer.getAllTimecard(emp_id);
  for (var i = 0; i < tcs.length; i ++) {
    if (date_fns.differenceInDays(new Date(tcs[i].getStartTime()), start) == 0) {
      return {Error: "There is already an inserted timecard with the same start day for employee: " + emp_id};
    }
  }
  var inserted = datalayer.insertTimecard(new Timecard(start_d, end_d, emp_id));
  return {Success: inserted};
}

exports.getAllTimecards = function(emp_id) {
  return datalayer.getAllTimecard(emp_id);
}

exports.deleteTimecard = function(tc_id) {
  var tc = datalayer.getTimecard(tc_id);
  if (tc == null) {
    return {Error: "No timecard found with id: " + tc_id};
  }
  datalayer.deleteTimecard(tc_id);
  return {Success: "Timecard " + tc_id + " has been deleted"};
}

exports.getTimecard = function(tc_id) {
  var tc = datalayer.getTimecard(tc_id);
  if (tc == null) {
    return {Error: "No timecard found with id: " + tc_id};
  }
  return {Success: tc};
}

exports.updateTimecard = function(tc_id, emp_id, start_d, end_d) {
  var emp = datalayer.getEmployee(emp_id);
  if (emp == null) {
    return {Error: "No employee found with id: " + emp_id};
  }
  var start = new Date(start_d);
  var end = new Date(end_d);
  // checking start_time is current date or at least within 1 week ago
  if (date_fns.differenceInDays(start, new Date()) < -7 || !date_fns.isPast(start)) {
    return {Error: "start_time must be between current date and 1 week ago"};
  }
  if (date_fns.isWeekend(start)) {
    return {Error: "start_time cannot be a weekend"};
  }
  if (date_fns.getHours(start) < 6 || date_fns.getHours(start) > 18) {
    return {Error: "start_time must be between the hours of 6 and 18 (24h format)"};
  }
  if (date_fns.isWeekend(end)) {
    return {Error: "end_time cannot be a weekend"};
  }
  if (date_fns.getHours(end) < 6 || date_fns.getHours(end) > 18) {
    return {Error: "end_time must be between the hours of 6 and 18 (24h format)"};
  }
  if (date_fns.differenceInHours(end, start) < 1) {
    return {Error: "end_time must be at least 1 hour greater than start_time"};
  }
  // validate start date not the same as any other start date
  var tcs = datalayer.getAllTimecard(emp_id);
  for (var i = 0; i < tcs.length; i ++) {
    if (date_fns.differenceInDays(new Date(tcs[i].getStartTime()), start) == 0) {
      return {Error: "There is already an inserted timecard with the same start day for employee: " + emp_id};
    }
  }
  var updated = datalayer.getTimecard(tc_id);
  updated.setStartTime(start_d);
  updated.setEndTime(end_d);
  updated.setEmpId(emp_id);
  updated = datalayer.updateTimecard(updated);
  return {Success: updated};
}

/****************************** COMPANY LOGIC *********************************/
exports.deleteCompany = function(company) {
  var deleted = datalayer.deleteCompany(company);
  if (deleted == 0) {
    return {Error: "Company could not be deleted, please make sure you have the right company"};
  }
  return {Success: company + "\'s information deleted"};
}
