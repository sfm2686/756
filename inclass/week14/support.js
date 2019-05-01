console.log("Child process: " + process.argv[2] + " executed");

process.on("message", (msg) => {
  console.log("Child process " + process.argv[2] + " received msg: ", msg);

  process.send({message: "hi parent"});
});
