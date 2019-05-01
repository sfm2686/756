// this file is going to spawn the child processes

const fs = require("fs");
const child_process = require("child_process"); // core node module

/*
  child_process provides ability to spawn child procsses

  each child process implments EventEmitter API, so the parent
  can register listeners on the child  process
*/

// child_process.spawn()
// spawns child processes asynchronously
console.log("A: child_process.spawn()");
// let and const have block scope, var has function scope
for(let i = 0; i < 3; i++) {
  // you can pass command line comamands as arguments
  // for the child process to run
  // Node takes the first argument in the array to run it
  // so in this example what gets run is: 'ndoe support.js'
  const workerProcess = child_process.spawn("node",
                        ["support.js", i]);
  // if there is an event of type error, the passed in function
  // will run
  workerProcess.on("error", (err) => {
    // single qoutes/ticks: allow string interpelation, and multi-line strings
    // they are called template literals.
    // The error event here will only be raised if the child process
    // could not be spawn or process could not be killed or
    // sending a message to the child process failed
    console.log(`${err.stack}\nError code: ${err.code}\nSignal received: ${err.signal}`);
  });

  workerProcess.stdout.on("data", (data) => {
    console.log(`A: stdout: ${data}`);
  });

  workerProcess.stderr.on("data", (data) => {
    console.log(`A: stderr: ${data}`);
  });

  // track when the child process closes
  workerProcess.on("close", (code) => {
    // should be 0 on success, like any other return code of a process
    console.log(`A: child process exited with exit/return code: ${code}`);
  });
}

// child_process.exec()
// spawns a shell and runs a command in that shell
console.log("B: child_process.exec()");
for(let i = 3; i < 6; i++) {
  const workerProcess = child_process.exec("node support.js " + i,
                        (err, stdout, stderr) => {
                          if (err) {
                            console.log(`${err.stack}\nError code: ${err.code}\nSignal received: ${err.signal}`);
                          }

                          if (stdout) {
                            console.log("B: stdout: " + stdout);
                          }

                          if (stderr) {
                            console.log("B: stderr: " + stderr);
                          }
                        });
    // track when the child process closes
    workerProcess.on("close", (code) => {
      // should be 0 on success, like any other return code of a process
      console.log(`B: child process exited with exit/return code: ${code}`);
    });
}

// child_process.fork()
// spawns a whole new node.js process (with its own V8 instance)
// and invokes a specified module, with a communication channel
// that allows spending messages between parent and child
// V8: open source js engine written by Google

console.log("C: child_process.fork()");
for(let i = 6; i < 9; i++) {
  // third argument is a configuration object
  // if silent is true, then stdin, stdout, and stderr of the child
  // get piped back to the parent, if false (default), they inherit from the parent
  const workerProcess = child_process.fork("support.js", [i], {silent:true});

  workerProcess.stdout.on("data", (data) => {
    console.log(`C: stdout: ${data}`);
  });

  workerProcess.stderr.on("data", (data) => {
    console.log(`C: stderr: ${data}`);
  });

  // track when the child process closes
  workerProcess.on("close", (code) => {
    // should be 0 on success, like any other return code of a process
    console.log(`C: child process exited with exit/return code: ${code}`);
  });

  workerProcess.send({test: "hi world"});

  workerProcess.on("message", (msg) => {
    console.log("C: parent received message: ", msg);
  });

  // killing child process after 4 seconds
  setTimeout( () => {
    console.log(`C: killing ${i}`);
    workerProcess.kill();
  }, 4000);
}
