package server;

import useless.*;
import javax.jws.*;

@WebService(serviceName="ServiceName")
public class Area {

	@WebMethod(operationName="classicHello")
	public String helloWorld() {
		return "Hello World";
	}

	@WebMethod(operationName="ETHello")
	public String etHello() {
		Helper h = new Helper();
		return h.etHelloWorld();
	}

	public double calcRectangle(double x, double y) {
		return x * y;
	}

	@WebMethod(exclude=true)
	public double calcCircle(double r) {
		return r * r * Math.PI;
	}
}