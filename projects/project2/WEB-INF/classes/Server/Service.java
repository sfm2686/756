package Server;

import javax.ws.rs.core.*;
import javax.ws.rs.*;
import companydata.*;
import java.text.SimpleDateFormat;
import org.json.simple.*;
import com.google.gson.*;
import java.util.*;
import java.sql.*;

@Path("CompanyServices")
public class Service {

  private static final String DEFAULT_COMPANY = "sfm2686";

  private DataLayer dl = null;

/****************************** HELPER METHODS ********************************/
  // validate string length to ensure compatbility with the DB
  private boolean validateString(String str, int maxLen, int minLen) {
    if (str.length() <= maxLen && str.length() >= minLen) {
      return true;
    }
    return false;
  }

  // check if passed in date is a weekday or a weekend
  private boolean isWeekend(java.util.Date date) {
    Calendar cal = Calendar.getInstance();
    cal.setTime(date);
    if (cal.get(Calendar.DAY_OF_WEEK) == Calendar.SATURDAY || cal.get(Calendar.DAY_OF_WEEK) == Calendar.SUNDAY) {
      return true;
    }
    return false;
  }

  // check if the passed in time is during defined business hours
  private boolean isBusinessHours(Timestamp time) {
    Calendar cal = Calendar.getInstance();
    cal.setTime(time);
    int hour = cal.get(Calendar.HOUR_OF_DAY);
    int mins = cal.get(Calendar.MINUTE);
    int secs = cal.get(Calendar.SECOND);
    if (hour >= 6 && hour <= 18) {
      if (hour == 18 && (mins > 0 || secs > 0)) {
        return false;
      }
      return true;
    }
    return false;
  }

  // check time range between start date and today's date
  private boolean isTimeRangeValid(Timestamp time) {
    long currMillis = new java.util.Date().getTime();
    long oneWeekMillis = 7 * 24 * 60 * 60 * 1000;
    return time.getTime() >= (currMillis - oneWeekMillis);
  }

  // comparing the new (given) start date of a timecard with all of the
  // start dates of a list of timecards to check if any happen to be on the same
  // date
  private boolean validStartDate(List<Timecard> cards, Timestamp start) {
    Calendar cal = Calendar.getInstance();
    Calendar curr = Calendar.getInstance();
    curr.setTime(start);
    int currYear, currMonth, currDay, oldYear, oldMonth, oldDay;
    currYear = curr.get(Calendar.YEAR);
    currMonth = curr.get(Calendar.MONTH);
    currDay = curr.get(Calendar.DAY_OF_YEAR);
    for(Timecard card : cards) {
      cal.setTime(card.getStartTime());
      oldYear = cal.get(Calendar.YEAR);
      oldMonth = cal.get(Calendar.MONTH);
      oldDay = cal.get(Calendar.DAY_OF_YEAR);
      if (currYear == oldYear && currMonth == oldMonth && currDay == oldDay) {
        return false;
      }
    }
    return true;
  }

/****************************** COMPANY ENDPOINT ******************************/
@Path("company")
@DELETE
@Produces("application/json")
public String deleteCompany(
@DefaultValue(DEFAULT_COMPANY) @QueryParam("company") String company
) {
  JSONObject result = new JSONObject();
  if (!this.validateString(company, 10, 1)) {
    result.put("error", "Invalid company");
    return result.toString();
  }
  try {
    this.dl = new DataLayer("production");
    this.dl.deleteCompany(company);
    result.put("success", company + "\'s information deleted");
    return result.toString();
  } catch (Exception e) {
    result.put("error", "An error has occured deleting company: " + company);
    return result.toString();
  } finally {
    this.dl.close();
  }
}

/**************************** DEPARTMENT ENDPOINTS ****************************/
  @Path("departments")
  @GET
  @Produces("application/json")
  public String getAllDepartments(
  @DefaultValue(DEFAULT_COMPANY) @QueryParam("company") String company
  ) {
    if (!this.validateString(company, 10, 1)) {
      JSONObject err = new JSONObject();
      err.put("error", "Invalid company");
      return err.toString();
    }
    try {
      this.dl = new DataLayer("production");
      Gson gson = new Gson();
      return gson.toJson(dl.getAllDepartment(company));
    } catch (Exception e) {
      JSONObject err = new JSONObject();
      err.put("error", "An error has occured accessing departments");
      return err.toString();
    } finally {
      this.dl.close();
    }
  }

  @Path("department")
  @GET
  @Produces("application/json")
  public String getDepartment(
  @DefaultValue(DEFAULT_COMPANY) @QueryParam("company") String company,
  @QueryParam("dept_id") int id
  ) {
    try {
      this.dl = new DataLayer("production");
      if (!this.validateString(company, 10, 1)) {
        JSONObject result = new JSONObject();
        result.put("error", "Invalid company");
        return result.toString();
      }
      Department dept = null;
      dept = dl.getDepartment(company, id);
      if (dept != null) {
        Gson gson = new Gson();
        return gson.toJson(dept).toString();
      }
      return "{}";
    } catch (Exception e) {
      JSONObject result = new JSONObject();
      result.put("error", "An error has occured accessing the department");
      return result.toString();
    } finally {
      this.dl.close();
    }
  }

  @Path("department")
  @DELETE
  @Produces("application/json")
  public String deleteDepartment(
  @DefaultValue(DEFAULT_COMPANY) @QueryParam("company") String company,
  @QueryParam("dept_id") int id
  ) {
    JSONObject result = new JSONObject();
    try {
      this.dl = new DataLayer("production");
      Department dept = null;
      dept = dl.getDepartment(company, id);
      if (dept != null) {
        dl.deleteDepartment(company, id);
        result.put("success", "Department " + id + " from " + company + " deleted");
      } else {
        result.put("error", "Could not find a department with the given ID/company combination");
      }
    } catch (Exception e) {
      result.put("error", "An error has occured accessing departments");
    } finally {
      this.dl.close();
    }
    return result.toString();
  }

  @Path("department")
  @POST
  @Produces("application/json")
  @Consumes("application/json")
  public String insertDepartment(JSONObject deptInfo) {
    String company, name, number, location;
    JSONObject err = new JSONObject();
    // input validation
    try {
      company = deptInfo.get("company").toString();
      if (!this.validateString(company, 10, 1)) {
        err.put("error", "Invalid company");
        return err.toString();
      }
      name = deptInfo.get("dept_name").toString();
      if (!this.validateString(name, 255, 1)) {
        err.put("error", "Invalid name");
        return err.toString();
      }
      number = deptInfo.get("dept_no").toString();
      if (!this.validateString(number, 20, 1)) {
        err.put("error", "Invalid number");
        return err.toString();
      }
      location = deptInfo.get("location").toString();
      if (!this.validateString(location, 255, 1)) {
        err.put("error", "Invalid location");
        return err.toString();
      }
    } catch (Exception e) {
      err.put("error", "Missing one or more input field/s");
      return err.toString();
    }
    try {
      dl = new DataLayer("production");
      Department inserted = dl.insertDepartment(new Department(company, name, number, location));
      Gson gson = new Gson();
      String result = "{\"success\": " + gson.toJson(inserted) + " }";
      return result;
    } catch (Exception e) {
      err.put("error", "Department number must be unique");
      return err.toString();
    } finally {
      dl.close();
    }
  }

  @Path("department")
  @PUT
  @Produces("application/json")
  public String updateDepartment(
    @FormParam("dept_id") int id,
    @FormParam("company") String company,
    @FormParam("dept_name") String name,
    @FormParam("dept_no") String number,
    @FormParam("location") String location
  ) {
    JSONObject err = new JSONObject();
    if (!this.validateString(company, 10, 1)) {
      err.put("error", "Invalid company");
      return err.toString();
    }
    if (!this.validateString(name, 255, 1)) {
      err.put("error", "Invalid name");
      return err.toString();
    }
    if (!this.validateString(number, 20, 1)) {
      err.put("error", "Invalid number");
      return err.toString();
    }
    if (!this.validateString(location, 255, 1)) {
      err.put("error", "Invalid location");
      return err.toString();
    }
    try {
      dl = new DataLayer("production");
      Department dept = null;
      dept = dl.getDepartment(company, id);
      if (dept != null) {
        dept.setDeptName(name);
        dept.setDeptNo(number);
        dept.setLocation(location);
        dept = dl.updateDepartment(dept);
        Gson gson = new Gson();
        return gson.toJson(dept).toString();
      }
      err.put("error", "Could not find a department with the given ID/company combination");
      return err.toString();
    } catch (Exception e) {
      err.put("error", "An error has occured updating the department");
      return err.toString();
    } finally {
      dl.close();
    }
  }

  /**************************** EMPLOYEE ENDPOINTS ****************************/
  @Path("employee")
  @POST
  @Produces("application/json")
  @Consumes("application/json")
  public String insertEmployee(JSONObject empInfo) {
    String name, number, job;
    Double salary;
    int dept_id, mng_id;
    java.util.Date hire_date;
    JSONObject err = new JSONObject();
    // input validation
    try {
      name = empInfo.get("emp_name").toString();
      if (!this.validateString(name, 50, 1)) {
        err.put("error", "Invalid employee name");
        return err.toString();
      }
      number = empInfo.get("emp_no").toString();
      if (!this.validateString(number, 20, 1)) {
        err.put("error", "Invalid employee number");
        return err.toString();
      }
      hire_date = new SimpleDateFormat("yyyy-MM-dd").parse(empInfo.get("hire_date").toString());
      if (!hire_date.before(new java.util.Date()) && !hire_date.equals(new java.util.Date())) {
        err.put("error", "Invalid date input, hire date must be either today or in the past");
        return err.toString();
      }
      if (this.isWeekend(hire_date)) {
        err.put("error", "Invalid date input, hire date cannot be Saturday or Sunday");
        return err.toString();
      }
      job = empInfo.get("job").toString();
      if (!this.validateString(job, 30, 1)) {
        err.put("error", "Invalid employee job");
        return err.toString();
      }
      salary = Double.parseDouble(empInfo.get("salary").toString());
      dept_id = Integer.parseInt(empInfo.get("dept_id").toString());
      mng_id = Integer.parseInt(empInfo.get("mng_id").toString());
    } catch (Exception e) {
      err.put("error", "Missing one or more input field/s");
      return err.toString();
    }
    try {
      dl = new DataLayer("production");
      Employee manager = null;
      manager = dl.getEmployee(mng_id);
      if (manager == null) {
        err.put("error", "Invalid manager ID, manager must be an employee in company:" + DEFAULT_COMPANY);
        return err.toString();
      }
      Department dept = null;
      dept = dl.getDepartment(DEFAULT_COMPANY, dept_id);
      if (dept == null) {
        err.put("error", "Department ID must correspond with a department in company: " + DEFAULT_COMPANY);
        return err.toString();
      }
      java.sql.Date sql_hire_date = new java.sql.Date(hire_date.getTime());
      Employee new_emp = new Employee(name, number, sql_hire_date, job, salary, dept_id, mng_id);
      new_emp = dl.insertEmployee(new_emp);
      Gson gson = new Gson();
      String result = "{\"success\": " + gson.toJson(new_emp) + " }";
      return result;
    } catch (Exception e) {
      err.put("error", "Employee number must be unique");
      return err.toString();
    } finally {
      dl.close();
    }
  }

  @Path("employees")
  @GET
  @Produces("application/json")
  public String getAllEmployees(
  @DefaultValue(DEFAULT_COMPANY) @QueryParam("company") String company
  ) {
    if (!this.validateString(company, 10, 1)) {
      JSONObject err = new JSONObject();
      err.put("error", "Invalid company");
      return err.toString();
    }
    try {
      this.dl = new DataLayer("production");
      Gson gson = new Gson();
      return gson.toJson(dl.getAllEmployee(company));
    } catch (Exception e) {
      JSONObject err = new JSONObject();
      err.put("error", "An error has occured accessing employees");
      return err.toString();
    } finally {
      this.dl.close();
    }
  }

  @Path("employee")
  @GET
  @Produces("application/json")
  public String getEmployee(
  @QueryParam("emp_id") int id
  ) {
    try {
      this.dl = new DataLayer("production");
      Employee emp = null;
      emp = dl.getEmployee(id);
      if (emp != null) {
        Gson gson = new Gson();
        return gson.toJson(emp).toString();
      }
      return "{}";
    } catch (Exception e) {
      JSONObject result = new JSONObject();
      result.put("error", "An error has occured accessing the employee, please make sure you have the correct ID");
      return result.toString();
    } finally {
      this.dl.close();
    }
  }

  @Path("employee")
  @PUT
  @Produces("application/json")
  public String updateEmployee(
    @FormParam("emp_id") int id,
    @FormParam("emp_name") String emp_name,
    @FormParam("emp_no") String emp_no,
    @FormParam("hire_date") String hire_date_str,
    @FormParam("job") String job,
    @FormParam("salary") double salary,
    @FormParam("dept_id") int dept_id,
    @FormParam("mng_id") int mng_id
  ) {
    JSONObject err = new JSONObject();
    // input validation
    if (!this.validateString(emp_name, 50, 1)) {
      err.put("error", "Invalid employee name");
      return err.toString();
    }
    if (!this.validateString(emp_no, 20, 1)) {
      err.put("error", "Invalid employee number");
      return err.toString();
    }
    java.util.Date hire_date = null;
    try {
      hire_date = new SimpleDateFormat("yyyy-MM-dd").parse(hire_date_str);
      if (!hire_date.before(new java.util.Date()) && !hire_date.equals(new java.util.Date())) {
        err.put("error", "Invalid date input, hire date must be either today or in the past");
        return err.toString();
      }
      if (this.isWeekend(hire_date)) {
        err.put("error", "Invalid date input, hire date cannot be Saturday or Sunday");
        return err.toString();
      }
    } catch (Exception e) {
      err.put("error", "Invalid date, please make sure your date is in the format yyyy-MM-dd");
    }
    if (!this.validateString(job, 30, 1)) {
      err.put("error", "Invalid employee job");
      return err.toString();
    }
    try {
      dl = new DataLayer("production");
      Employee emp = null;
      emp = dl.getEmployee(id);
      if (emp != null) {
        emp.setEmpName(emp_name);
        java.sql.Date sql_hire_date = new java.sql.Date(hire_date.getTime());
        emp.setHireDate(sql_hire_date);
        emp.setMngId(mng_id);
        emp.setSalary(salary);
        emp.setJob(job);
        emp.setEmpNo(emp_no);
        emp.setDeptId(dept_id);
        emp = dl.updateEmployee(emp);
        Gson gson = new Gson();
        return "{\"success\": " + gson.toJson(emp) + " }";
      }
      err.put("error", "Could not find an employee with the given ID");
      return err.toString();
    } catch (Exception e) {
      err.put("error", "An error has occured updating the employee." +
      "Please make sure the department ID is already registered in the database" +
      "and the employee number is unique");
      return err.toString();
    } finally {
      dl.close();
    }
  }

  @Path("employee")
  @DELETE
  @Produces("application/json")
  public String deleteEmployee(
  @QueryParam("emp_id") int id
  ) {
    JSONObject result = new JSONObject();
    try {
      this.dl = new DataLayer("production");
      Employee emp = null;
      emp = dl.getEmployee(id);
      if (emp != null) {
        dl.deleteEmployee(id);
        result.put("success", "Employee " + id + " deleted");
      } else {
        result.put("error", "Could not find an employee with the given ID");
      }
    } catch (Exception e) {
      result.put("error", "An error has occured accessing the employee, " +
      "please make sure you are using the correct ID");
    } finally {
      this.dl.close();
    }
    return result.toString();
  }

  /**************************** TIMECARD ENDPOINTS ****************************/
  @Path("timecard")
  @POST
  @Produces("application/json")
  @Consumes("application/json")
  public String insertTimecard(JSONObject timecardInfo) {
    int emp_id;
    Timestamp start, end;
    String timeStr;
    JSONObject err = new JSONObject();
    // input validation
    try {
      emp_id = Integer.parseInt(timecardInfo.get("emp_id").toString());
      timeStr = timecardInfo.get("start_time").toString();
      start = new Timestamp(new SimpleDateFormat("yyyy-MM-dd HH:mm:ss").parse(timeStr).getTime());
      timeStr = timecardInfo.get("end_time").toString();
      end = new Timestamp(new SimpleDateFormat("yyyy-MM-dd HH:mm:ss").parse(timeStr).getTime());
      if (this.isWeekend(start)) {
        err.put("error", "Invalid date input, start date cannot be Saturday or Sunday");
        return err.toString();
      }
      if (this.isWeekend(end)) {
        err.put("error", "Invalid date input, end date cannot be Saturday or Sunday");
        return err.toString();
      }
      if (!this.isBusinessHours(start)) {
        err.put("error", "Invalid start time input, the time must be between" +
                " 06:00:00 and 18:00:00");
        return err.toString();
      }
      if (!this.isBusinessHours(end)) {
        err.put("error", "Invalid end time input, the time must be between" +
                " 06:00:00 and 18:00:00");
        return err.toString();
      }
      if (!this.isTimeRangeValid(start)) {
        err.put("error", "Invalid start time input, the start time cannot be " +
                "older than one week from today");
        return err.toString();
      }
      long anHourMillis = 60 * 60 * 1000;

      if ((end.getTime() - start.getTime()) < anHourMillis) {
        err.put("error", "Invalid start and end times, end time must be at least " +
                "1 hour greater than start time");
        return err.toString();
      }
    } catch (Exception e) {
      err.put("error", "Missing or invalid one or more input field/s");
      return err.toString();
    }
    try {
      dl = new DataLayer("production");
      Employee emp = null;
      emp = dl.getEmployee(emp_id);
      if (emp == null) {
        err.put("error", "Invalid employee id, no employee found with given ID in company:" + DEFAULT_COMPANY);
        return err.toString();
      }
      List<Timecard> empsCards = dl.getAllTimecard(emp_id);
      if (!validStartDate(empsCards, start)) {
        err.put("error", "Invalid start date, employee with the id " + emp_id +
                " already has an entry for that day");
        return err.toString();
      }
      Timecard result = dl.insertTimecard(new Timecard(start, end, emp_id));
      Gson gson = new Gson();
      return "{\"success\": " + gson.toJson(result) + " }";
    } catch (Exception e) {
      err.put("error", "An error occured inserting the timecard");
      return err.toString();
    } finally {
      dl.close();
    }
  }

  @Path("timecards")
  @GET
  @Produces("application/json")
  public String getAllTimecards(
  @QueryParam("emp_id") int emp_id
  ) {
    try {
      this.dl = new DataLayer("production");
      Gson gson = new Gson();
      return gson.toJson(dl.getAllTimecard(emp_id));
    } catch (Exception e) {
      JSONObject err = new JSONObject();
      err.put("error", "An error has occured accessing timecards");
      return err.toString();
    } finally {
      this.dl.close();
    }
  }

  @Path("timecard")
  @GET
  @Produces("application/json")
  public String getTimecard(
  @QueryParam("timecard_id") int id
  ) {
    try {
      this.dl = new DataLayer("production");
      Timecard card = null;
      card = dl.getTimecard(id);
      if (card != null) {
        Gson gson = new Gson();
        return gson.toJson(card).toString();
      }
      return "{}";
    } catch (Exception e) {
      JSONObject result = new JSONObject();
      result.put("error", "An error has occured accessing the timecard, please make sure you have the correct ID");
      return result.toString();
    } finally {
      this.dl.close();
    }
  }

  @Path("timecard")
  @PUT
  @Produces("application/json")
  public String updateTimecard(
    @FormParam("timecard_id") int timecard_id,
    @FormParam("emp_id") int emp_id,
    @FormParam("start_time") String startStr,
    @FormParam("end_time") String endStr
  ) {
    JSONObject err = new JSONObject();
    // input validation
    Timestamp start, end;
    try {
      start = new Timestamp(new SimpleDateFormat("yyyy-MM-dd HH:mm:ss").parse(startStr).getTime());
      end = new Timestamp(new SimpleDateFormat("yyyy-MM-dd HH:mm:ss").parse(endStr).getTime());
      if (this.isWeekend(start)) {
        err.put("error", "Invalid date input, start date cannot be Saturday or Sunday");
        return err.toString();
      }
      if (this.isWeekend(end)) {
        err.put("error", "Invalid date input, end date cannot be Saturday or Sunday");
        return err.toString();
      }
      if (!this.isBusinessHours(start)) {
        err.put("error", "Invalid start time input, the time must be between" +
                " 06:00:00 and 18:00:00");
        return err.toString();
      }
      if (!this.isBusinessHours(end)) {
        err.put("error", "Invalid end time input, the time must be between" +
                " 06:00:00 and 18:00:00");
        return err.toString();
      }
      if (!this.isTimeRangeValid(start)) {
        err.put("error", "Invalid start time input, the start time cannot be " +
                "older than one week from today");
        return err.toString();
      }
      long anHourMillis = 60 * 60 * 1000;

      if ((end.getTime() - start.getTime()) < anHourMillis) {
        err.put("error", "Invalid start and end times, end time must be at least " +
                "1 hour greater than start time");
        return err.toString();
      }
    } catch (Exception e) {
      err.put("error", "Missing or invalid one or more input field/s");
      return err.toString();
    }
    try {
      dl = new DataLayer("production");
      Employee emp = null;
      emp = dl.getEmployee(emp_id);
      if (emp == null) {
        err.put("error", "Invalid employee id, no employee found with given ID in company:" + DEFAULT_COMPANY);
        return err.toString();
      }
      List<Timecard> empsCards = dl.getAllTimecard(emp_id);
      if (!validStartDate(empsCards, start)) {
        err.put("error", "Invalid start date, employee with the id " + emp_id +
                " already has an entry for that day");
        return err.toString();
      }
      Timecard result = null;
      result = dl.getTimecard(timecard_id);
      if (result == null) {
        err.put("error", "Invalid timecard_id, could not find a timecard with the given ID");
        return err.toString();
      }
      result.setStartTime(start);
      result.setEndTime(end);
      result.setEmpId(emp_id);
      Gson gson = new Gson();
      return "{\"success\": " + gson.toJson(dl.updateTimecard(result)) + " }";
    } catch (Exception e) {
      err.put("error", "An error occured updating the timecard");
      return err.toString();
    } finally {
      dl.close();
    }
  }

  @Path("timecard")
  @DELETE
  @Produces("application/json")
  public String deleteDepartment(
  @QueryParam("timecard_id") int id
  ) {
    JSONObject result = new JSONObject();
    try {
      this.dl = new DataLayer("production");
      Timecard card = null;
      card = dl.getTimecard(id);
      if (card != null) {
        dl.deleteTimecard(id);
        result.put("success", "Timecard " + id + " deleted");
      } else {
        result.put("error", "Could not find a timecard with the given ID");
      }
    } catch (Exception e) {
      result.put("error", "An error has occured accessing timecards");
    } finally {
      this.dl.close();
    }
    return result.toString();
  }
}
