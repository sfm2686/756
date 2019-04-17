package Server;

import javax.ws.rs.core.Application;
import java.util.Set;

@javax.ws.rs.ApplicationPath("resources")
public class ApplicationConfig extends Application{

  @Override
  public Set<Class<?>> getClasses() {
    return getRestResourceClasses();
  }

  private Set<Class<?>> getRestResourceClasses() {
    Set<Class<?>> resources =
       new java.util.HashSet<Class<?>>();

    // resources.add(Server.AreaCalculator.class);
    resources.add(Server.Service.class);
    return resources;
  }
}
