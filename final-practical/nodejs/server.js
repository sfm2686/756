var Products = require("upcbiz").Products;
var Product = require("upcbiz").Product;
var express = require('express');
var app = express();

var server = app.listen(8282, function () {
})

app.get('/CountProducts', function (req, res) {
  var prods = new Products();
  res.send({Products: prods.getCount()});
});

app.get('/Product/:upc', function (req, res) {
  var upc = req.params.upc;
  var product = null;
  try {
    product = new Product(upc);
    res.send({[upc]: product.getDescription()});
  } catch (err) {
    res.send({Error: "invalid upc"});
  }
});

app.get('/Product', function (req, res) {
  var desc = req.query.descrip;
  var prods = new Products().getUpcs(desc);
  var results = [];
  var tempProd;
  prods.forEach(function(prodUpc) {
    tempProd = new Product(prodUpc);
    results.push({[tempProd.getUpc()]: tempProd.getDescription()});
  });
  res.send(results);
});
