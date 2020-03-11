/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./node_modules/@babel/runtime/regenerator/index.js":
/*!**********************************************************!*\
  !*** ./node_modules/@babel/runtime/regenerator/index.js ***!
  \**********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! regenerator-runtime */ "./node_modules/regenerator-runtime/runtime.js");


/***/ }),

/***/ "./node_modules/regenerator-runtime/runtime.js":
/*!*****************************************************!*\
  !*** ./node_modules/regenerator-runtime/runtime.js ***!
  \*****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

/**
 * Copyright (c) 2014-present, Facebook, Inc.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

var runtime = (function (exports) {
  "use strict";

  var Op = Object.prototype;
  var hasOwn = Op.hasOwnProperty;
  var undefined; // More compressible than void 0.
  var $Symbol = typeof Symbol === "function" ? Symbol : {};
  var iteratorSymbol = $Symbol.iterator || "@@iterator";
  var asyncIteratorSymbol = $Symbol.asyncIterator || "@@asyncIterator";
  var toStringTagSymbol = $Symbol.toStringTag || "@@toStringTag";

  function wrap(innerFn, outerFn, self, tryLocsList) {
    // If outerFn provided and outerFn.prototype is a Generator, then outerFn.prototype instanceof Generator.
    var protoGenerator = outerFn && outerFn.prototype instanceof Generator ? outerFn : Generator;
    var generator = Object.create(protoGenerator.prototype);
    var context = new Context(tryLocsList || []);

    // The ._invoke method unifies the implementations of the .next,
    // .throw, and .return methods.
    generator._invoke = makeInvokeMethod(innerFn, self, context);

    return generator;
  }
  exports.wrap = wrap;

  // Try/catch helper to minimize deoptimizations. Returns a completion
  // record like context.tryEntries[i].completion. This interface could
  // have been (and was previously) designed to take a closure to be
  // invoked without arguments, but in all the cases we care about we
  // already have an existing method we want to call, so there's no need
  // to create a new function object. We can even get away with assuming
  // the method takes exactly one argument, since that happens to be true
  // in every case, so we don't have to touch the arguments object. The
  // only additional allocation required is the completion record, which
  // has a stable shape and so hopefully should be cheap to allocate.
  function tryCatch(fn, obj, arg) {
    try {
      return { type: "normal", arg: fn.call(obj, arg) };
    } catch (err) {
      return { type: "throw", arg: err };
    }
  }

  var GenStateSuspendedStart = "suspendedStart";
  var GenStateSuspendedYield = "suspendedYield";
  var GenStateExecuting = "executing";
  var GenStateCompleted = "completed";

  // Returning this object from the innerFn has the same effect as
  // breaking out of the dispatch switch statement.
  var ContinueSentinel = {};

  // Dummy constructor functions that we use as the .constructor and
  // .constructor.prototype properties for functions that return Generator
  // objects. For full spec compliance, you may wish to configure your
  // minifier not to mangle the names of these two functions.
  function Generator() {}
  function GeneratorFunction() {}
  function GeneratorFunctionPrototype() {}

  // This is a polyfill for %IteratorPrototype% for environments that
  // don't natively support it.
  var IteratorPrototype = {};
  IteratorPrototype[iteratorSymbol] = function () {
    return this;
  };

  var getProto = Object.getPrototypeOf;
  var NativeIteratorPrototype = getProto && getProto(getProto(values([])));
  if (NativeIteratorPrototype &&
      NativeIteratorPrototype !== Op &&
      hasOwn.call(NativeIteratorPrototype, iteratorSymbol)) {
    // This environment has a native %IteratorPrototype%; use it instead
    // of the polyfill.
    IteratorPrototype = NativeIteratorPrototype;
  }

  var Gp = GeneratorFunctionPrototype.prototype =
    Generator.prototype = Object.create(IteratorPrototype);
  GeneratorFunction.prototype = Gp.constructor = GeneratorFunctionPrototype;
  GeneratorFunctionPrototype.constructor = GeneratorFunction;
  GeneratorFunctionPrototype[toStringTagSymbol] =
    GeneratorFunction.displayName = "GeneratorFunction";

  // Helper for defining the .next, .throw, and .return methods of the
  // Iterator interface in terms of a single ._invoke method.
  function defineIteratorMethods(prototype) {
    ["next", "throw", "return"].forEach(function(method) {
      prototype[method] = function(arg) {
        return this._invoke(method, arg);
      };
    });
  }

  exports.isGeneratorFunction = function(genFun) {
    var ctor = typeof genFun === "function" && genFun.constructor;
    return ctor
      ? ctor === GeneratorFunction ||
        // For the native GeneratorFunction constructor, the best we can
        // do is to check its .name property.
        (ctor.displayName || ctor.name) === "GeneratorFunction"
      : false;
  };

  exports.mark = function(genFun) {
    if (Object.setPrototypeOf) {
      Object.setPrototypeOf(genFun, GeneratorFunctionPrototype);
    } else {
      genFun.__proto__ = GeneratorFunctionPrototype;
      if (!(toStringTagSymbol in genFun)) {
        genFun[toStringTagSymbol] = "GeneratorFunction";
      }
    }
    genFun.prototype = Object.create(Gp);
    return genFun;
  };

  // Within the body of any async function, `await x` is transformed to
  // `yield regeneratorRuntime.awrap(x)`, so that the runtime can test
  // `hasOwn.call(value, "__await")` to determine if the yielded value is
  // meant to be awaited.
  exports.awrap = function(arg) {
    return { __await: arg };
  };

  function AsyncIterator(generator) {
    function invoke(method, arg, resolve, reject) {
      var record = tryCatch(generator[method], generator, arg);
      if (record.type === "throw") {
        reject(record.arg);
      } else {
        var result = record.arg;
        var value = result.value;
        if (value &&
            typeof value === "object" &&
            hasOwn.call(value, "__await")) {
          return Promise.resolve(value.__await).then(function(value) {
            invoke("next", value, resolve, reject);
          }, function(err) {
            invoke("throw", err, resolve, reject);
          });
        }

        return Promise.resolve(value).then(function(unwrapped) {
          // When a yielded Promise is resolved, its final value becomes
          // the .value of the Promise<{value,done}> result for the
          // current iteration.
          result.value = unwrapped;
          resolve(result);
        }, function(error) {
          // If a rejected Promise was yielded, throw the rejection back
          // into the async generator function so it can be handled there.
          return invoke("throw", error, resolve, reject);
        });
      }
    }

    var previousPromise;

    function enqueue(method, arg) {
      function callInvokeWithMethodAndArg() {
        return new Promise(function(resolve, reject) {
          invoke(method, arg, resolve, reject);
        });
      }

      return previousPromise =
        // If enqueue has been called before, then we want to wait until
        // all previous Promises have been resolved before calling invoke,
        // so that results are always delivered in the correct order. If
        // enqueue has not been called before, then it is important to
        // call invoke immediately, without waiting on a callback to fire,
        // so that the async generator function has the opportunity to do
        // any necessary setup in a predictable way. This predictability
        // is why the Promise constructor synchronously invokes its
        // executor callback, and why async functions synchronously
        // execute code before the first await. Since we implement simple
        // async functions in terms of async generators, it is especially
        // important to get this right, even though it requires care.
        previousPromise ? previousPromise.then(
          callInvokeWithMethodAndArg,
          // Avoid propagating failures to Promises returned by later
          // invocations of the iterator.
          callInvokeWithMethodAndArg
        ) : callInvokeWithMethodAndArg();
    }

    // Define the unified helper method that is used to implement .next,
    // .throw, and .return (see defineIteratorMethods).
    this._invoke = enqueue;
  }

  defineIteratorMethods(AsyncIterator.prototype);
  AsyncIterator.prototype[asyncIteratorSymbol] = function () {
    return this;
  };
  exports.AsyncIterator = AsyncIterator;

  // Note that simple async functions are implemented on top of
  // AsyncIterator objects; they just return a Promise for the value of
  // the final result produced by the iterator.
  exports.async = function(innerFn, outerFn, self, tryLocsList) {
    var iter = new AsyncIterator(
      wrap(innerFn, outerFn, self, tryLocsList)
    );

    return exports.isGeneratorFunction(outerFn)
      ? iter // If outerFn is a generator, return the full iterator.
      : iter.next().then(function(result) {
          return result.done ? result.value : iter.next();
        });
  };

  function makeInvokeMethod(innerFn, self, context) {
    var state = GenStateSuspendedStart;

    return function invoke(method, arg) {
      if (state === GenStateExecuting) {
        throw new Error("Generator is already running");
      }

      if (state === GenStateCompleted) {
        if (method === "throw") {
          throw arg;
        }

        // Be forgiving, per 25.3.3.3.3 of the spec:
        // https://people.mozilla.org/~jorendorff/es6-draft.html#sec-generatorresume
        return doneResult();
      }

      context.method = method;
      context.arg = arg;

      while (true) {
        var delegate = context.delegate;
        if (delegate) {
          var delegateResult = maybeInvokeDelegate(delegate, context);
          if (delegateResult) {
            if (delegateResult === ContinueSentinel) continue;
            return delegateResult;
          }
        }

        if (context.method === "next") {
          // Setting context._sent for legacy support of Babel's
          // function.sent implementation.
          context.sent = context._sent = context.arg;

        } else if (context.method === "throw") {
          if (state === GenStateSuspendedStart) {
            state = GenStateCompleted;
            throw context.arg;
          }

          context.dispatchException(context.arg);

        } else if (context.method === "return") {
          context.abrupt("return", context.arg);
        }

        state = GenStateExecuting;

        var record = tryCatch(innerFn, self, context);
        if (record.type === "normal") {
          // If an exception is thrown from innerFn, we leave state ===
          // GenStateExecuting and loop back for another invocation.
          state = context.done
            ? GenStateCompleted
            : GenStateSuspendedYield;

          if (record.arg === ContinueSentinel) {
            continue;
          }

          return {
            value: record.arg,
            done: context.done
          };

        } else if (record.type === "throw") {
          state = GenStateCompleted;
          // Dispatch the exception by looping back around to the
          // context.dispatchException(context.arg) call above.
          context.method = "throw";
          context.arg = record.arg;
        }
      }
    };
  }

  // Call delegate.iterator[context.method](context.arg) and handle the
  // result, either by returning a { value, done } result from the
  // delegate iterator, or by modifying context.method and context.arg,
  // setting context.delegate to null, and returning the ContinueSentinel.
  function maybeInvokeDelegate(delegate, context) {
    var method = delegate.iterator[context.method];
    if (method === undefined) {
      // A .throw or .return when the delegate iterator has no .throw
      // method always terminates the yield* loop.
      context.delegate = null;

      if (context.method === "throw") {
        // Note: ["return"] must be used for ES3 parsing compatibility.
        if (delegate.iterator["return"]) {
          // If the delegate iterator has a return method, give it a
          // chance to clean up.
          context.method = "return";
          context.arg = undefined;
          maybeInvokeDelegate(delegate, context);

          if (context.method === "throw") {
            // If maybeInvokeDelegate(context) changed context.method from
            // "return" to "throw", let that override the TypeError below.
            return ContinueSentinel;
          }
        }

        context.method = "throw";
        context.arg = new TypeError(
          "The iterator does not provide a 'throw' method");
      }

      return ContinueSentinel;
    }

    var record = tryCatch(method, delegate.iterator, context.arg);

    if (record.type === "throw") {
      context.method = "throw";
      context.arg = record.arg;
      context.delegate = null;
      return ContinueSentinel;
    }

    var info = record.arg;

    if (! info) {
      context.method = "throw";
      context.arg = new TypeError("iterator result is not an object");
      context.delegate = null;
      return ContinueSentinel;
    }

    if (info.done) {
      // Assign the result of the finished delegate to the temporary
      // variable specified by delegate.resultName (see delegateYield).
      context[delegate.resultName] = info.value;

      // Resume execution at the desired location (see delegateYield).
      context.next = delegate.nextLoc;

      // If context.method was "throw" but the delegate handled the
      // exception, let the outer generator proceed normally. If
      // context.method was "next", forget context.arg since it has been
      // "consumed" by the delegate iterator. If context.method was
      // "return", allow the original .return call to continue in the
      // outer generator.
      if (context.method !== "return") {
        context.method = "next";
        context.arg = undefined;
      }

    } else {
      // Re-yield the result returned by the delegate method.
      return info;
    }

    // The delegate iterator is finished, so forget it and continue with
    // the outer generator.
    context.delegate = null;
    return ContinueSentinel;
  }

  // Define Generator.prototype.{next,throw,return} in terms of the
  // unified ._invoke helper method.
  defineIteratorMethods(Gp);

  Gp[toStringTagSymbol] = "Generator";

  // A Generator should always return itself as the iterator object when the
  // @@iterator function is called on it. Some browsers' implementations of the
  // iterator prototype chain incorrectly implement this, causing the Generator
  // object to not be returned from this call. This ensures that doesn't happen.
  // See https://github.com/facebook/regenerator/issues/274 for more details.
  Gp[iteratorSymbol] = function() {
    return this;
  };

  Gp.toString = function() {
    return "[object Generator]";
  };

  function pushTryEntry(locs) {
    var entry = { tryLoc: locs[0] };

    if (1 in locs) {
      entry.catchLoc = locs[1];
    }

    if (2 in locs) {
      entry.finallyLoc = locs[2];
      entry.afterLoc = locs[3];
    }

    this.tryEntries.push(entry);
  }

  function resetTryEntry(entry) {
    var record = entry.completion || {};
    record.type = "normal";
    delete record.arg;
    entry.completion = record;
  }

  function Context(tryLocsList) {
    // The root entry object (effectively a try statement without a catch
    // or a finally block) gives us a place to store values thrown from
    // locations where there is no enclosing try statement.
    this.tryEntries = [{ tryLoc: "root" }];
    tryLocsList.forEach(pushTryEntry, this);
    this.reset(true);
  }

  exports.keys = function(object) {
    var keys = [];
    for (var key in object) {
      keys.push(key);
    }
    keys.reverse();

    // Rather than returning an object with a next method, we keep
    // things simple and return the next function itself.
    return function next() {
      while (keys.length) {
        var key = keys.pop();
        if (key in object) {
          next.value = key;
          next.done = false;
          return next;
        }
      }

      // To avoid creating an additional object, we just hang the .value
      // and .done properties off the next function object itself. This
      // also ensures that the minifier will not anonymize the function.
      next.done = true;
      return next;
    };
  };

  function values(iterable) {
    if (iterable) {
      var iteratorMethod = iterable[iteratorSymbol];
      if (iteratorMethod) {
        return iteratorMethod.call(iterable);
      }

      if (typeof iterable.next === "function") {
        return iterable;
      }

      if (!isNaN(iterable.length)) {
        var i = -1, next = function next() {
          while (++i < iterable.length) {
            if (hasOwn.call(iterable, i)) {
              next.value = iterable[i];
              next.done = false;
              return next;
            }
          }

          next.value = undefined;
          next.done = true;

          return next;
        };

        return next.next = next;
      }
    }

    // Return an iterator with no values.
    return { next: doneResult };
  }
  exports.values = values;

  function doneResult() {
    return { value: undefined, done: true };
  }

  Context.prototype = {
    constructor: Context,

    reset: function(skipTempReset) {
      this.prev = 0;
      this.next = 0;
      // Resetting context._sent for legacy support of Babel's
      // function.sent implementation.
      this.sent = this._sent = undefined;
      this.done = false;
      this.delegate = null;

      this.method = "next";
      this.arg = undefined;

      this.tryEntries.forEach(resetTryEntry);

      if (!skipTempReset) {
        for (var name in this) {
          // Not sure about the optimal order of these conditions:
          if (name.charAt(0) === "t" &&
              hasOwn.call(this, name) &&
              !isNaN(+name.slice(1))) {
            this[name] = undefined;
          }
        }
      }
    },

    stop: function() {
      this.done = true;

      var rootEntry = this.tryEntries[0];
      var rootRecord = rootEntry.completion;
      if (rootRecord.type === "throw") {
        throw rootRecord.arg;
      }

      return this.rval;
    },

    dispatchException: function(exception) {
      if (this.done) {
        throw exception;
      }

      var context = this;
      function handle(loc, caught) {
        record.type = "throw";
        record.arg = exception;
        context.next = loc;

        if (caught) {
          // If the dispatched exception was caught by a catch block,
          // then let that catch block handle the exception normally.
          context.method = "next";
          context.arg = undefined;
        }

        return !! caught;
      }

      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i];
        var record = entry.completion;

        if (entry.tryLoc === "root") {
          // Exception thrown outside of any try block that could handle
          // it, so set the completion value of the entire function to
          // throw the exception.
          return handle("end");
        }

        if (entry.tryLoc <= this.prev) {
          var hasCatch = hasOwn.call(entry, "catchLoc");
          var hasFinally = hasOwn.call(entry, "finallyLoc");

          if (hasCatch && hasFinally) {
            if (this.prev < entry.catchLoc) {
              return handle(entry.catchLoc, true);
            } else if (this.prev < entry.finallyLoc) {
              return handle(entry.finallyLoc);
            }

          } else if (hasCatch) {
            if (this.prev < entry.catchLoc) {
              return handle(entry.catchLoc, true);
            }

          } else if (hasFinally) {
            if (this.prev < entry.finallyLoc) {
              return handle(entry.finallyLoc);
            }

          } else {
            throw new Error("try statement without catch or finally");
          }
        }
      }
    },

    abrupt: function(type, arg) {
      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i];
        if (entry.tryLoc <= this.prev &&
            hasOwn.call(entry, "finallyLoc") &&
            this.prev < entry.finallyLoc) {
          var finallyEntry = entry;
          break;
        }
      }

      if (finallyEntry &&
          (type === "break" ||
           type === "continue") &&
          finallyEntry.tryLoc <= arg &&
          arg <= finallyEntry.finallyLoc) {
        // Ignore the finally entry if control is not jumping to a
        // location outside the try/catch block.
        finallyEntry = null;
      }

      var record = finallyEntry ? finallyEntry.completion : {};
      record.type = type;
      record.arg = arg;

      if (finallyEntry) {
        this.method = "next";
        this.next = finallyEntry.finallyLoc;
        return ContinueSentinel;
      }

      return this.complete(record);
    },

    complete: function(record, afterLoc) {
      if (record.type === "throw") {
        throw record.arg;
      }

      if (record.type === "break" ||
          record.type === "continue") {
        this.next = record.arg;
      } else if (record.type === "return") {
        this.rval = this.arg = record.arg;
        this.method = "return";
        this.next = "end";
      } else if (record.type === "normal" && afterLoc) {
        this.next = afterLoc;
      }

      return ContinueSentinel;
    },

    finish: function(finallyLoc) {
      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i];
        if (entry.finallyLoc === finallyLoc) {
          this.complete(entry.completion, entry.afterLoc);
          resetTryEntry(entry);
          return ContinueSentinel;
        }
      }
    },

    "catch": function(tryLoc) {
      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i];
        if (entry.tryLoc === tryLoc) {
          var record = entry.completion;
          if (record.type === "throw") {
            var thrown = record.arg;
            resetTryEntry(entry);
          }
          return thrown;
        }
      }

      // The context.catch method must only be called with a location
      // argument that corresponds to a known catch block.
      throw new Error("illegal catch attempt");
    },

    delegateYield: function(iterable, resultName, nextLoc) {
      this.delegate = {
        iterator: values(iterable),
        resultName: resultName,
        nextLoc: nextLoc
      };

      if (this.method === "next") {
        // Deliberately forget the last sent value so that we don't
        // accidentally pass it on to the delegate.
        this.arg = undefined;
      }

      return ContinueSentinel;
    }
  };

  // Regardless of whether this script is executing as a CommonJS module
  // or not, return the runtime object so that we can declare the variable
  // regeneratorRuntime in the outer scope, which allows this module to be
  // injected easily by `bin/regenerator --include-runtime script.js`.
  return exports;

}(
  // If this script is executing as a CommonJS module, use module.exports
  // as the regeneratorRuntime namespace. Otherwise create a new empty
  // object. Either way, the resulting object will be used to initialize
  // the regeneratorRuntime variable at the top of this file.
   true ? module.exports : undefined
));

try {
  regeneratorRuntime = runtime;
} catch (accidentalStrictMode) {
  // This module should not be running in strict mode, so the above
  // assignment should always work unless something is misconfigured. Just
  // in case runtime.js accidentally runs in strict mode, we can escape
  // strict mode using a global Function call. This could conceivably fail
  // if a Content Security Policy forbids using Function, but in that case
  // the proper solution is to fix the accidental strict mode problem. If
  // you've misconfigured your bundler to force strict mode and applied a
  // CSP to forbid Function, and you're not willing to fix either of those
  // problems, please detail your unique predicament in a GitHub issue.
  Function("r", "regeneratorRuntime = r")(runtime);
}


/***/ }),

/***/ "./resources/js/settings.js":
/*!**********************************!*\
  !*** ./resources/js/settings.js ***!
  \**********************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);


function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

$(function () {
  var $loadingWarna = $("#warna_loading");
  var $loadingBahan = $("#bahan_loading");
  var start = 0;
  var start2 = 0;
  var length = 5;
  var length2 = 5;
  var currentCounter = [];
  var currentCounter2 = [];
  var pagination = $('#list_warna').parent().next().find('.pagination');
  var pagination2 = $('#list_bahan').parent().next().find('.pagination');
  loadListWarna();
  loadListBahan();
  pagination.find('li').first().find('a').click(function (e) {
    e.preventDefault();

    if (!$(this).hasClass('disabled') && start > 0) {
      start -= 5;
      $loadingWarna.show();
      axios.get("/api/v1/warna/all/paginate?start=".concat(start, "&length=").concat(length), {
        headers: General.getHeaders()
      }).then(function (res) {
        var tbody = $("#list_warna").find('tbody');
        tbody.html('');

        if (start == 0) {
          pagination.find('li').first().addClass('disabled');
          pagination.find('li').last().removeClass('disabled');
        } else {
          pagination.find('li').last().removeClass('disabled');
        }

        var firstIndex = currentCounter[0] - 5;
        currentCounter = [];
        res.data.data.forEach(function (warna, index) {
          currentCounter.push(firstIndex + index);
          tbody.append($("<tr>\n                                            <td style=\"display:none;\">".concat(warna.id, "</td>\n                                            <td>").concat(currentCounter[index], ".</td>\n                                            <td>").concat(warna.name, "</td>\n                                            <td class=\"text-center\">\n                                                <i style=\"color: ").concat(warna.hex_code, ";\" class=\"fas fa-square\"></i>\n                                            </td>\n                                        </tr>")));
        });
        setTimeout(function () {
          $loadingWarna.hide();
        }, 500);
      })["catch"](function (err) {
        console.log(err);
      });
    }
  });
  pagination.find('li').last().find('a').click(function (e) {
    e.preventDefault();

    if (!$(this).hasClass('disabled')) {
      pagination.find('li').first().removeClass('disabled');
      start += 5;
      $loadingWarna.show();
      axios.get("/api/v1/warna/all/paginate?start=".concat(start, "&length=").concat(length), {
        headers: General.getHeaders()
      }).then(function (res) {
        var tbody = $("#list_warna").find('tbody');
        tbody.html('');
        var next = start + 5;

        if (res.data.data.length <= 5 && next >= res.data.total_records) {
          pagination.find('li').last().addClass('disabled');
        } else {
          pagination.find('li').last().removeClass('disabled');
        }

        var lastCounter = currentCounter[currentCounter.length - 1];
        currentCounter = [];
        res.data.data.forEach(function (warna, index) {
          currentCounter.push(lastCounter + (index + 1));
          tbody.append($("<tr>\n                                            <td style=\"display:none;\">".concat(warna.id, "</td>\n                                            <td>").concat(currentCounter[index], ".</td>\n                                            <td>").concat(warna.name, "</td>\n                                            <td class=\"text-center\">\n                                                <i style=\"color: ").concat(warna.hex_code, ";\" class=\"fas fa-square\"></i>\n                                            </td>\n                                        </tr>")));
        });
        setTimeout(function () {
          $loadingWarna.hide();
        }, 500);
      })["catch"](function (err) {
        console.log(err);
      });
    }
  });
  pagination2.find('li').first().find('a').click(function (e) {
    e.preventDefault();

    if (!$(this).hasClass('disabled') && start2 > 0) {
      start2 -= 5;
      $loadingBahan.show();
      axios.get("/api/v1/bahan/all/paginate?start=".concat(start2, "&length=").concat(length2), {
        headers: General.getHeaders()
      }).then(function (res) {
        var tbody = $("#list_bahan").find('tbody');
        tbody.html('');

        if (start == 0) {
          pagination2.find('li').first().addClass('disabled');
          pagination2.find('li').last().removeClass('disabled');
        } else {
          pagination2.find('li').last().removeClass('disabled');
        }

        var firstIndex = currentCounter2[0] - 5;
        currentCounter2 = [];
        res.data.data.forEach(function (bahan, index) {
          currentCounter2.push(firstIndex + index);
          tbody.append($("<tr>\n                                            <td style=\"display:none;\">".concat(bahan.id, "</td>\n                                            <td>").concat(currentCounter2[index], ".</td>\n                                            <td>").concat(bahan.nama, "</td>\n                                            <td class=\"text-center\">").concat(bahan.deskripsi, "</td>\n                                        </tr>")));
        });
        setTimeout(function () {
          $loadingBahan.hide();
        }, 500);
      })["catch"](function (err) {
        console.log(err);
      });
    }
  });
  pagination2.find('li').last().find('a').click(function (e) {
    e.preventDefault();

    if (!$(this).hasClass('disabled')) {
      pagination2.find('li').first().removeClass('disabled');
      start2 += 5;
      $loadingBahan.show();
      axios.get("/api/v1/bahan/all/paginate?start=".concat(start2, "&length=").concat(length2), {
        headers: General.getHeaders()
      }).then(function (res) {
        var tbody = $("#list_bahan").find('tbody');
        tbody.html('');
        var next = start2 + 5;

        if (res.data.data.length <= 5 && next >= res.data.total_records) {
          pagination2.find('li').last().addClass('disabled');
        } else {
          pagination2.find('li').last().removeClass('disabled');
        }

        var lastCounter = currentCounter2[currentCounter2.length - 1];
        currentCounter2 = [];
        res.data.data.forEach(function (bahan, index) {
          currentCounter2.push(lastCounter + (index + 1));
          tbody.append($("<tr>\n                                            <td style=\"display:none;\">".concat(bahan.id, "</td>\n                                            <td>").concat(currentCounter2[index], ".</td>\n                                            <td>").concat(bahan.nama, "</td>\n                                            <td>").concat(bahan.deskripsi, "</td>\n                                        </tr>")));
        });
        setTimeout(function () {
          $loadingBahan.hide();
        }, 500);
      })["catch"](function (err) {
        console.log(err);
      });
    }
  });
  $("#button_create_warna").click(function (e) {
    $("#modal_create_warna").modal('toggle');
  });
  $("#button_create_bahan").click(function (e) {
    $("#modal_create_bahan").modal('toggle');
  });
  $("#form_create_warna").submit(function (e) {
    e.preventDefault();
    var formData = new FormData();
    formData.append('name', $(this).find('#name').val());
    formData.append('hex_code', $(this).find('#hex_code').val());

    if (formData.get('hex_code') == undefined || formData.get('hex_code') == '') {
      formData["delete"]('hex_code');
    }

    axios.post('/api/v1/warna', formData, {
      headers: General.getHeaders()
    }).then(function (res) {
      General.resetElementsField([{
        selector: '#name',
        type: 'text'
      }, {
        selector: '#hex_code',
        type: 'text'
      }]);
      General.showToast('success', res.data.message);
      $("#modal_create_warna").modal('toggle');
      location.reload();
    })["catch"](function (err) {
      General.showToast('error', err.response.data.errors.name[0]);
    });
  });
  $("#form_create_bahan").submit(function (e) {
    e.preventDefault();
    var formData = new FormData();
    formData.append('nama', $(this).find('#nama_bahan').val());
    formData.append('deskripsi', $(this).find('#deskripsi').val());

    if (formData.get('deskripsi') == undefined || formData.get('deskripsi') == '') {
      formData["delete"]('deskripsi');
    }

    axios.post('/api/v1/bahan', formData, {
      headers: General.getHeaders()
    }).then(function (res) {
      General.resetElementsField([{
        selector: '#nama_bahan',
        type: 'text'
      }, {
        selector: '#deskripsi',
        type: 'textarea'
      }]);
      General.showToast('success', res.data.message);
      $("#modal_create_bahan").modal('toggle');
      location.reload();
    })["catch"](function (err) {
      General.showToast('error', err.response.data.errors.name[0]);
    });
  });
  $("#form_edit_warna").submit(function (e) {
    e.preventDefault();
    var formData = new FormData();
    formData.append('name', $(this).find('#name2').val());
    formData.append('hex_code', $(this).find('#hex_code2').val());

    if (formData.get('hex_code') == undefined || formData.get('hex_code') == '') {
      formData["delete"]('hex_code');
    }

    var id = $("#id_warna_edit").val();
    axios.post("/api/v1/warna/".concat(id, "/edit"), formData, {
      headers: General.getHeaders()
    }).then(function (res) {
      General.showToast('success', res.data.message);
      setTimeout(function () {
        location.reload();
      }, 3000);
    })["catch"](function (err) {
      console.log(err);
    });
  });
  $("#form_edit_bahan").submit(function (e) {
    e.preventDefault();
    var formData = new FormData();
    formData.append('nama', $(this).find('#nama_bahan2').val());
    formData.append('deskripsi', $(this).find('#deskripsi2').val());

    if (formData.get('deskripsi') == undefined || formData.get('deskripsi') == '') {
      formData["delete"]('deskripsi');
    }

    var id = $("#id_bahan_edit").val();
    axios.post("/api/v1/bahan/".concat(id, "/edit"), formData, {
      headers: General.getHeaders()
    }).then(function (res) {
      General.showToast('success', res.data.message);
      setTimeout(function () {
        General.resetElementsField([{
          selector: '#nama_bahan2',
          type: 'text'
        }, {
          selector: '#deskripsi2',
          type: 'textarea'
        }]);
        location.reload();
      }, 3000);
    })["catch"](function (err) {
      console.log(err);
    });
  });
  var timer = 0;
  var delay = 200;
  var prevent = false;
  $("#list_warna tbody").delegate("tr", "click", function () {
    var row = $(this);
    timer = setTimeout(function () {
      if (!prevent) {
        edit(row);
      }

      prevent = false;
    }, delay);
  });
  $("#list_warna tbody").delegate("tr", "dblclick", function () {
    var row = $(this);
    clearTimeout(timer);
    prevent = true;
    remove(row);
  });
  $("#list_bahan tbody").delegate("tr", "click", function () {
    var row = $(this);
    timer = setTimeout(function () {
      if (!prevent) {
        edit2(row);
      }

      prevent = false;
    }, delay);
  });
  $("#list_bahan tbody").delegate("tr", "dblclick", function () {
    var row = $(this);
    clearTimeout(timer);
    prevent = true;
    remove2(row);
  });

  function loadListWarna() {
    return _loadListWarna.apply(this, arguments);
  }

  function _loadListWarna() {
    _loadListWarna = _asyncToGenerator(
    /*#__PURE__*/
    _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee() {
      var url, res, data, tbody, next;
      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee$(_context) {
        while (1) {
          switch (_context.prev = _context.next) {
            case 0:
              $loadingWarna.show();
              _context.prev = 1;
              url = "/api/v1/warna/all/paginate?start=".concat(start, "&length=").concat(length);
              _context.next = 5;
              return axios.get(url, {
                headers: General.getHeaders()
              });

            case 5:
              res = _context.sent;
              data = res.data;
              tbody = $("#list_warna").find('tbody');
              next = start + 5;

              if (res.data.data.length <= 5 && next >= res.data.total_records) {
                pagination.find('li').last().addClass('disabled');
              } else {
                pagination.find('li').last().removeClass('disabled');
              }

              data.data.forEach(function (warna, index) {
                currentCounter.push(index + 1);
                tbody.append($(warnaRow(index, warna, currentCounter)));
              });
              pagination.find('li').first().addClass('disabled');
              setTimeout(function () {
                $loadingWarna.hide();
              }, 500);
              _context.next = 18;
              break;

            case 15:
              _context.prev = 15;
              _context.t0 = _context["catch"](1);
              console.log(_context.t0);

            case 18:
            case "end":
              return _context.stop();
          }
        }
      }, _callee, null, [[1, 15]]);
    }));
    return _loadListWarna.apply(this, arguments);
  }

  function loadListBahan() {
    return _loadListBahan.apply(this, arguments);
  }

  function _loadListBahan() {
    _loadListBahan = _asyncToGenerator(
    /*#__PURE__*/
    _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee2() {
      var url, res, data, tbody, next;
      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee2$(_context2) {
        while (1) {
          switch (_context2.prev = _context2.next) {
            case 0:
              $loadingBahan.show();
              _context2.prev = 1;
              url = "/api/v1/bahan/all/paginate?start=".concat(start2, "&length=").concat(length2);
              _context2.next = 5;
              return axios.get(url, {
                headers: General.getHeaders()
              });

            case 5:
              res = _context2.sent;
              data = res.data;
              tbody = $("#list_bahan").find('tbody');
              next = start2 + 5;

              if (res.data.data.length <= 5 && next >= res.data.total_records) {
                pagination2.find('li').last().addClass('disabled');
              } else {
                pagination2.find('li').last().removeClass('disabled');
              }

              data.data.forEach(function (bahan, index) {
                currentCounter2.push(index + 1);
                tbody.append($(bahanRow(index, bahan, currentCounter2)));
              });
              pagination2.find('li').first().addClass('disabled');
              setTimeout(function () {
                $loadingBahan.hide();
              }, 500);
              _context2.next = 18;
              break;

            case 15:
              _context2.prev = 15;
              _context2.t0 = _context2["catch"](1);
              console.log(_context2.t0);

            case 18:
            case "end":
              return _context2.stop();
          }
        }
      }, _callee2, null, [[1, 15]]);
    }));
    return _loadListBahan.apply(this, arguments);
  }

  function warnaRow(i, wrn, cc) {
    return "<tr>\n                    <td style=\"display:none;\">".concat(wrn.id, "</td>\n                    <td>").concat(cc[i], ".</td>\n                    <td>").concat(wrn.name, "</td>\n                    <td class=\"text-center\">\n                        <i style=\"color: ").concat(wrn.hex_code, ";\" class=\"fas fa-square\"></i>\n                    </td>\n                </tr>");
  }

  function bahanRow(i, bhn, cc) {
    return "<tr>\n                    <td style=\"display:none;\">".concat(bhn.id, "</td>\n                    <td>").concat(cc[i], ".</td>\n                    <td>").concat(bhn.nama, "</td>\n                    <td>").concat(bhn.deskripsi == null ? '' : bhn.deskripsi, "</td>\n                </tr>");
  }

  function edit(row) {
    var id = row.find("td:eq(0)").text().trim();
    axios.get("/api/v1/warna/".concat(id), {
      headers: General.getHeaders()
    }).then(function (res) {
      $("#id_warna_edit").val(res.data.data.id);
      $("#name2").val(res.data.data.name);
      $("#hex_code2").val(res.data.data.hex_code);
      $("#modal_edit_warna").modal('toggle');
    })["catch"](function (err) {
      console.log(err);
    });
  }

  function remove(row) {
    var result = confirm("Anda yakin ingin dihapus?");

    if (result) {
      var id = row.find("td:eq(0)").text().trim();
      axios.post("/api/v1/warna/".concat(id, "/remove"), {}, {
        headers: General.getHeaders()
      }).then(function (res) {
        General.showToast("success", res.data.message);
        location.reload();
      })["catch"](function (err) {
        General.showToast("error", err.response.statusText);
      });
    }
  }

  function edit2(row) {
    var id = row.find("td:eq(0)").text().trim();
    axios.get("/api/v1/bahan/".concat(id), {
      headers: General.getHeaders()
    }).then(function (res) {
      console.log(res);
      $("#id_bahan_edit").val(res.data.data.id);
      $("#nama_bahan2").val(res.data.data.nama);
      $("#deskripsi2").val(res.data.data.deskripsi);
      $("#modal_edit_bahan").modal('toggle');
    })["catch"](function (err) {
      console.log(err);
    });
  }

  function remove2(row) {
    var result = confirm("Anda yakin ingin dihapus?");

    if (result) {
      var id = row.find("td:eq(0)").text().trim();
      axios.post("/api/v1/bahan/".concat(id, "/remove"), {}, {
        headers: General.getHeaders()
      }).then(function (res) {
        General.showToast("success", res.data.message);
        location.reload();
      })["catch"](function (err) {
        General.showToast("error", err.response.statusText);
      });
    }
  }
});

/***/ }),

/***/ 1:
/*!****************************************!*\
  !*** multi ./resources/js/settings.js ***!
  \****************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! D:\my-work\side-work\abcode\MaulaHijabWeb\maulahijab-management\resources\js\settings.js */"./resources/js/settings.js");


/***/ })

/******/ });