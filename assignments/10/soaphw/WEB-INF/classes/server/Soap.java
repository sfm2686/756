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

	@WebService(operationName="getPrice")
	public Double getPrice(String product) {
		return this.soaps.get(product);
	}

	@WebService(operationName="getProducts")
	public String[] getProducts() {
		;
	}

	@WebService(operationName="getCheapest")
	public String getCheapest() {
			;
	}

	@WebService(operationName="getCostliest")
	public String getCostliest() {
		;
	}

	@WebMethod(operationName="getMethods")
	public String[] getMethods() {
		;
	}
}
