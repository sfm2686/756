package Server;
import javax.ws.rs.*;
import UpcBiz.*;

@Path("/upc")
public class Upc {

  @Path("/CountProducts")
  @GET
  @Produces("text/json")
  public static String getUpcCount() {
    try {
      Products prods = new Products();
      return "{\"Products\":\"" + prods.getCount() + "\"}";
    } catch(Exception e) {
      return e.getMessage();
      // return "{\"Error\":\"an error occured retreiving UPC count\"}";
    }
  }

  @Path("/Product/{upc}")
  @GET
  @Produces("text/json")
  public static String product(@PathParam("upc") String upc) {
    Product prod = null;
    try {
      prod = new Product(upc);
      return "{\"" + upc + "\":\"" + prod.getDescription() + "\"}";
    } catch (Exception e) {
      return e.getMessage();
      // return "{\"Error\": \"Invalid UPC\"}";
    }
  }

  @Path("/Product")
  @GET
  @Produces("text/json")
  public static String products(@QueryParam("descrip") String descrip) {
    try {
      String[] prods = new Products().getUpcs(descrip);
      String results = "[";
      Product tempProd;
      for(String prodUpc : prods) {
        tempProd = new Product(prodUpc);
        results += "{\"" + prodUpc + "\":\"" +  tempProd.getDescription() + "\"},";
      }
      results += "]";
      return results;
    } catch (Exception e) {
      return e.getMessage();
      // return "{\"Error\": \"An error has occured\"}";
    }
  }

  public static void main(String[] args) {
    System.out.println(getUpcCount());
    System.out.println(product("0071860432157"));
    System.out.println(products("cat collar"));
  }
}
