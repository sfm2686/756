// exports is the object that gets exposed from each module
// anything that is not exported is (private??)

// exporting world function to be public from outside of this module
exports.world = function() {
  console.log("Hello world");
}

// this is same as
/*
function world() {
  console.log("Hello world");
}
exports.world = world;
*/
