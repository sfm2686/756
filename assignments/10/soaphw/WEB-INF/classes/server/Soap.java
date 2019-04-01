package server;

import javax.jws.*;
import java.util.*;

@WebService(serviceName="SoapsSoapService")
public class Soap {

	private Map<String, Double> soaps = new HashMap<String, Double>();

	public Soap() {
		this.soaps.put("Dove", 6.49);
		this.soaps.put("Irish Spring", 4.39);
	}

	@WebMethod(operationName="getPrice")
	public Double getPrice(String product) {
		return this.soaps.get(product);
	}

	@WebMethod(operationName="getProducts")
	public String[] getProducts() {
		;
	}

	@WebMethod(operationName="getCheapest")
	public String getCheapest() {
			;
	}

	@WebMethod(operationName="getCostliest")
	public String getCostliest() {
		;
	}

	@WebMethod(operationName="getMethods")
	public String[] getMethods() {
		;
	}
}
