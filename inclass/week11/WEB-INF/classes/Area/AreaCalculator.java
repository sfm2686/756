package Area;

// JAX-RS: Java API for REST Services
import javax.ws.rs.core.*;
import javax.ws.rs.*;

@Path("AreaCalculator")
public class AreaCalculator {

  @Path("Hello")
  @GET
  @Produces("application/xml")
  @Consumes("text/plain")
  public String helloWorld() {
    return "<result>Hello World</result>";
  }

  @Path("Hello/{name}")
  @GET
  @Produces("application/xml")
  @Consumes("text/plain")
  public String helloName(@PathParam("name") String name) {
    return "<result>Hello " + name + "</result>";
  }

  @Path("Rectangle")
  @GET
  @Produces("application/xml")
  @Consumes("text/plain")
  public String calcRectangleXML(
    @DefaultValue("1") @QueryParam("width") double width,
    @DefaultValue("1") @QueryParam("length") double length
  ) {
    return "<result>" + width * length + "</result>";
  }

  @Path("Rectangle")
  @GET
  @Produces("application/json")
  @Consumes("text/plain")
  public String calcRectangleJSON(
    @DefaultValue("1") @QueryParam("width") double width,
    @DefaultValue("1") @QueryParam("length") double length
  ) {
    return "{\"Area\":\"" + width * length + "\"}";
  }

  @Path("Circle")
  @GET
  @Produces("text/plain")
  @Consumes("text/plain")
  public String calcCircle(
    @DefaultValue("1") @QueryParam("radius") double radius
  ) {
    return "" + Math.PI * radius * radius;
  }
}
