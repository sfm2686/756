// package server;

// import javax.jws.*;
import java.util.*;

// @WebService(serviceName="SoapsSoapService")
public class Soap {

	private Map<String, Double> soaps = new HashMap<String, Double>();

	public Soap() {
		this.soaps.put("dove", 6.49);
		this.soaps.put("irish spring", 4.39);
		this.soaps.put("dial", 2.97);
		this.soaps.put("lever", 6.19);
		this.soaps.put("zest", 3.00);
	}

	// @WebMethod(operationName="getPrice")
	public Double getPrice(String product) {
		return this.soaps.get(product.toLowerCase());
	}

	// @WebMethod(operationName="getProducts")
	public String[] getProducts() {
		return this.soaps.keySet().toArray(new String[0]);
	}

	// @WebMethod(operationName="getCheapest")
	public String getCheapest() {
		Double lowest = Double.MAX_VALUE;
		String lowestKey = "";
		for (String key : this.soaps.keySet()) {
			if (this.soaps.get(key) < lowest) {
				lowest = this.soaps.get(key);
				lowestKey = key;
			}
		}
		return lowestKey;
	}

	// @WebMethod(operationName="getCostliest")
	public String getCostliest() {
		Double highest = 0.0; // no negative prices
		String highestKey = "";
		for (String key : this.soaps.keySet()) {
			if (this.soaps.get(key) > highest) {
				highest = this.soaps.get(key);
				highestKey = key;
			}
		}
		return highestKey;
	}

	// @WebMethod(operationName="getMethods")
	public String[] getMethods() {
		return new String[] {"getPrice(String product)", "getProducts()", "getCheapest()",
						"getCostliest()"};
	}

	// DEBUGGING
	public static void main(String[] args) {
		// Soap s = new Soap();
		// System.out.println(s.getPrice("dove"));
		// System.out.println(s.getPrice("irish spring"));
		// String[] results = s.getProducts();
		// for(int i = 0; i < results.length; i ++) {
		// 	System.out.println(results[i] + "\n");
		// }
		// System.out.println(s.getCheapest());
		// System.out.println(s.getCostliest());
		// String[] methods = s.getMethods();
		// for (String str : methods) {
		// 	System.out.println(str);
		// }
	} // MAIN

} // SOAP
