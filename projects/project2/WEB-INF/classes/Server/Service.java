package Server;

import javax.ws.rs.core.*;
import javax.ws.rs.*;
import companydata.*;
// import org.json.simple.JSONObject;
import org.json.simple.*;
import com.google.gson.*;
import java.util.*;

@Path("CompanyServices")
public class Service {

  private static final String DEFAULT_COMPANY = "sfm2686";

  private DataLayer dl = null;

  private boolean validateString(String str, int maxLen, int minLen) {
    if (str.length() <= maxLen && str.length() >= minLen) {
      return true;
    }
    return false;
  }

/**************************** DEPARTMENT ENDPOINTS ****************************/
  @Path("departments")
  @GET
  @Produces("application/json")
  public String getAllDepartments(
  @DefaultValue(DEFAULT_COMPANY) @QueryParam("company") String company
  ) {
    try {
      this.dl = new DataLayer("production");
      JSONArray jsonArr = new JSONArray();
      Gson gson = new Gson();
      if (!this.validateString(company, 10, 1)) {
        JSONObject err = new JSONObject();
        err.put("error", "Invalid company");
        return err.toString();
      }
      for (Department d : dl.getAllDepartment(company)) {
        jsonArr.add(gson.toJson(d));
      }
      return jsonArr.toString();
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
      return gson.toJson(inserted).toString();
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

  /**************************** TIMECARD ENDPOINTS ****************************/
}
