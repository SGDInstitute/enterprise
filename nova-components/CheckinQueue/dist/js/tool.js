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
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
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
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(1);
module.exports = __webpack_require__(6);


/***/ }),
/* 1 */
/***/ (function(module, exports, __webpack_require__) {

Nova.booting(function (Vue, router) {
    router.addRoutes([{
        name: 'checkin-queue',
        path: '/checkin-queue',
        component: __webpack_require__(2)
    }]);
});

/***/ }),
/* 2 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(3)
/* script */
var __vue_script__ = __webpack_require__(4)
/* template */
var __vue_template__ = __webpack_require__(5)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/js/components/Tool.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-68ff5483", Component.options)
  } else {
    hotAPI.reload("data-v-68ff5483", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 3 */
/***/ (function(module, exports) {

/* globals __VUE_SSR_CONTEXT__ */

// IMPORTANT: Do NOT use ES2015 features in this file.
// This module is a runtime utility for cleaner component module output and will
// be included in the final webpack user bundle.

module.exports = function normalizeComponent (
  rawScriptExports,
  compiledTemplate,
  functionalTemplate,
  injectStyles,
  scopeId,
  moduleIdentifier /* server only */
) {
  var esModule
  var scriptExports = rawScriptExports = rawScriptExports || {}

  // ES6 modules interop
  var type = typeof rawScriptExports.default
  if (type === 'object' || type === 'function') {
    esModule = rawScriptExports
    scriptExports = rawScriptExports.default
  }

  // Vue.extend constructor export interop
  var options = typeof scriptExports === 'function'
    ? scriptExports.options
    : scriptExports

  // render functions
  if (compiledTemplate) {
    options.render = compiledTemplate.render
    options.staticRenderFns = compiledTemplate.staticRenderFns
    options._compiled = true
  }

  // functional template
  if (functionalTemplate) {
    options.functional = true
  }

  // scopedId
  if (scopeId) {
    options._scopeId = scopeId
  }

  var hook
  if (moduleIdentifier) { // server build
    hook = function (context) {
      // 2.3 injection
      context =
        context || // cached call
        (this.$vnode && this.$vnode.ssrContext) || // stateful
        (this.parent && this.parent.$vnode && this.parent.$vnode.ssrContext) // functional
      // 2.2 with runInNewContext: true
      if (!context && typeof __VUE_SSR_CONTEXT__ !== 'undefined') {
        context = __VUE_SSR_CONTEXT__
      }
      // inject component styles
      if (injectStyles) {
        injectStyles.call(this, context)
      }
      // register component module identifier for async chunk inferrence
      if (context && context._registeredComponents) {
        context._registeredComponents.add(moduleIdentifier)
      }
    }
    // used by ssr in case component is cached and beforeCreate
    // never gets called
    options._ssrRegister = hook
  } else if (injectStyles) {
    hook = injectStyles
  }

  if (hook) {
    var functional = options.functional
    var existing = functional
      ? options.render
      : options.beforeCreate

    if (!functional) {
      // inject component registration as beforeCreate hook
      options.beforeCreate = existing
        ? [].concat(existing, hook)
        : [hook]
    } else {
      // for template-only hot-reload because in that case the render fn doesn't
      // go through the normalizer
      options._injectStyles = hook
      // register for functioal component in vue file
      options.render = function renderWithStyleInjection (h, context) {
        hook.call(context)
        return existing(h, context)
      }
    }
  }

  return {
    esModule: esModule,
    exports: scriptExports,
    options: options
  }
}


/***/ }),
/* 4 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
    data: function data() {
        return {
            tickets: [],
            picked: []
        };
    },
    mounted: function mounted() {
        this.fetchQueue();
    },

    methods: {
        fetchQueue: function fetchQueue() {
            var _this = this;

            axios.get('/api/queue').then(function (response) {
                _this.tickets = response.data;
            });
        },
        toggleTicket: function toggleTicket(id) {
            if (_.includes(this.picked, id)) {
                this.picked.splice(_.indexOf(this.picked, id), 1);
            } else {
                this.picked.push(id);
            }
        }
    },
    computed: {
        selected: function selected() {
            return this.picked.join(',');
        }
    }
});

/***/ }),
/* 5 */
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    [
      _c("heading", { staticClass: "mb-6" }, [_vm._v("Checkin Queue")]),
      _vm._v(" "),
      _c(
        "card",
        { staticClass: "bg-10 p-4", staticStyle: { "min-height": "300px" } },
        [
          _c("div", { staticClass: "mb-4" }, [
            _c("button", { staticClass: "btn btn-default btn-primary" }, [
              _vm._v("Select 10")
            ]),
            _vm._v(" "),
            _c(
              "a",
              {
                staticClass: "btn btn-default btn-primary",
                attrs: { href: "/print/" + _vm.selected, target: "_blank" }
              },
              [_vm._v("Print Selected")]
            )
          ]),
          _vm._v(" "),
          _c("table", { staticClass: "table w-full" }, [
            _c("thead", [
              _c("tr", [
                _c("th"),
                _vm._v(" "),
                _c("th", [_vm._v("Batch")]),
                _vm._v(" "),
                _c("th", [_vm._v("Name")]),
                _vm._v(" "),
                _c("th", [_vm._v("Pronouns")]),
                _vm._v(" "),
                _c("th", [_vm._v("College")]),
                _vm._v(" "),
                _c("th", [_vm._v("Tshirt")]),
                _vm._v(" "),
                _c("th", [_vm._v("Early")]),
                _vm._v(" "),
                _c("th")
              ])
            ]),
            _vm._v(" "),
            _c(
              "tbody",
              [
                _vm.tickets.length === 0
                  ? _c("tr", [
                      _c("td", { attrs: { colspan: "7" } }, [
                        _vm._v("No tickets in queue")
                      ])
                    ])
                  : _vm._l(_vm.tickets, function(ticket) {
                      return _c(
                        "tr",
                        {
                          key: ticket.id,
                          on: {
                            click: function($event) {
                              return _vm.toggleTicket(ticket.id)
                            }
                          }
                        },
                        [
                          _c("td", [
                            _c("input", {
                              directives: [
                                {
                                  name: "model",
                                  rawName: "v-model",
                                  value: _vm.picked,
                                  expression: "picked"
                                }
                              ],
                              staticClass: "checkbox",
                              attrs: { type: "checkbox" },
                              domProps: {
                                value: ticket.id,
                                checked: Array.isArray(_vm.picked)
                                  ? _vm._i(_vm.picked, ticket.id) > -1
                                  : _vm.picked
                              },
                              on: {
                                change: function($event) {
                                  var $$a = _vm.picked,
                                    $$el = $event.target,
                                    $$c = $$el.checked ? true : false
                                  if (Array.isArray($$a)) {
                                    var $$v = ticket.id,
                                      $$i = _vm._i($$a, $$v)
                                    if ($$el.checked) {
                                      $$i < 0 &&
                                        (_vm.picked = $$a.concat([$$v]))
                                    } else {
                                      $$i > -1 &&
                                        (_vm.picked = $$a
                                          .slice(0, $$i)
                                          .concat($$a.slice($$i + 1)))
                                    }
                                  } else {
                                    _vm.picked = $$c
                                  }
                                }
                              }
                            })
                          ]),
                          _vm._v(" "),
                          _c("td", [_vm._v(_vm._s(ticket.batch))]),
                          _vm._v(" "),
                          _c("td", [_vm._v(_vm._s(ticket.name))]),
                          _vm._v(" "),
                          _c("td", [_vm._v(_vm._s(ticket.pronouns || "n/a"))]),
                          _vm._v(" "),
                          _c("td", [_vm._v(_vm._s(ticket.college || "n/a"))]),
                          _vm._v(" "),
                          _c("td", [_vm._v(_vm._s(ticket.tshirt || "n/a"))]),
                          _vm._v(" "),
                          _c("td", [_vm._v(_vm._s(ticket.order_created))]),
                          _vm._v(" "),
                          _c("td", [
                            _c(
                              "a",
                              {
                                staticClass: "btn btn-default btn-primary",
                                attrs: {
                                  href: "/print/" + ticket.id,
                                  target: "_blank"
                                }
                              },
                              [_vm._v("Print")]
                            ),
                            _vm._v(" "),
                            _c(
                              "button",
                              { staticClass: "btn btn-default btn-secondary" },
                              [_vm._v("Completed")]
                            )
                          ])
                        ]
                      )
                    })
              ],
              2
            )
          ])
        ]
      )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-68ff5483", module.exports)
  }
}

/***/ }),
/* 6 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ })
/******/ ]);