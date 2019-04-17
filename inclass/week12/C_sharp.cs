// make a new project in visual studio
// choose ASP .NET Web Application (C#)
// product service: MCV

// classes in here are NOT in the same file

// in the App_start open RouteConfig.cs and delete routes.MapRoute(....etc)

// make a new class (model) in the models directory

// in Controllers, delete HomeController.cs
// add a Controller (Web API 2 Controller - Empty) to Controllers
public class ProductController : ApiController {
  private List<Models.Product> products = new List<Models.Product>();

  private void CreateProducts() {
    for (int i = 1; i <= 5; i ++) {
      products.Add(new Models.Product() {Name = "Product" + i, Id = i}); // synatx for object initilizr (specific to C#), similar to passing
      // stuff to the constrcutor but instead invoking the getters and setters in the Product class
    }
  }

  // endpoints

  // the following 2 methods know that those are GET methods because the method names are GET
  // GET METHODS

  // GET api/products
  // return the whole collection
  [Route("api/products")]
  public IEnumerable<Models.Product> Get() {
    CreateProducts();
    return this.products;
  }

  // GET api/product/{id}
  // return one product
  [Route("api/product/{id}", Name="Product")]
  public Models.Product Get(int id) {
    CreateProducts();
    // mapping x to each element of the collection and return where the condition is true
    Models.Product product = this.products.Find(x => x.Id == id);

    if (product == null) {
      throw new HttPResponseException(
        Request.CreateResponse(HttpStatusCode.NotFound));
    }
    return product;
  }

  // POST METHODS
  [Route("api/product")]
  public HttpResponseMessage Post([FromBody]Models.Product product) { // [FromBody]... is just telling it what the source of the param is, converts it the class Product
    if (ModelState.IsValid) { // making sure we got a good object??
      // returning a new link that goes to the new created product (in the location header)
      // although normally we would add this to a data store so the link we are returning here should not work
      this.products.Add(product);
      var response = Request.CreateResponse(HttpStatusCode.Created, product);
      string uri = Url.Link("Product", new {id = product.id});
      response.Headers.Location = new Uri(uri);
      return response;
    }
    return Request.CreateResponse(HttpStatusCode.BadRequest);
  }

  // PUT METHODS
  // update a product
  [Route("api/product/{id}")]
  public HttpResponseMessage Put(int id, [FromBody]Models.Product product) {
    CreateProducts();
    if (ModelState.IsValid && id == product.Id) {
      if (!products.Exists(x => x.Id == id)) { // if the product to be updated doesnt exist
        return Request.CreateResponse(HttpStatusCode.NotFound);
      }
      // all good, update the data store
      return Request.CreateResponse(HttpStatusCode.Ok);
    }
    // product is not valid
    return Request.CreateResponse(HttpStatusCode.BadRequest);
  }


} // end of controller class


public class Product {

  public int Id {get; set;} // getters and setters
  public string Name {get; set;}

  public override string ToString() {
    return "ID: " + Id + " Name: " + Name;
  }
}


// in Global.asax.cs
// add the following namespaces (like packages in java)
using System.Web.Routing; //?? (if not already there)
using System.Web.Http;

// delete everything in Application_Start() and add:
GlobalConfiguration.Configure(WebApiConfig.Register);

// in App_Start, open WebApiConfig and remove the edefault routing -> config.Routes.MapHttpRoute...etc

// when you hit run, a browser should open with a 5 digit port on localhost with 403 (since there is no route to the root path)
