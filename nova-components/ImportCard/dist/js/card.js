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

Nova.booting(function (Vue, router, store) {
  Vue.component('import-card', __webpack_require__(2));
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
Component.options.__file = "resources/js/components/Card.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-b9bc2c0a", Component.options)
  } else {
    hotAPI.reload("data-v-b9bc2c0a", Component.options)
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
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
  props: ["card"],

  data: function data() {
    return {
      fileName: "",
      file: null,
      label: this.__("no file selected"),
      working: false,
      errors: null
    };
  },
  mounted: function mounted() {
    console.log(this.card.sample);
  },


  methods: {
    fileChange: function fileChange(event) {
      var path = event.target.value;
      var fileName = path.match(/[^\\/]*$/)[0];
      this.fileName = fileName;
      this.file = this.$refs.fileField.files[0];
    },
    processImport: function processImport() {
      var _this = this;

      if (!this.file) {
        return;
      }
      this.working = true;
      var formData = new FormData();
      formData.append("file", this.file);
      Nova.request().post("/nova-vendor/import-card/import/" + this.card.resource, formData).then(function (_ref) {
        var data = _ref.data;

        _this.$toasted.success(data.message);
        _this.$parent.$parent.$parent.$parent.getResources();
        _this.errors = null;
      }).catch(function (_ref2) {
        var response = _ref2.response;

        if (response.data.danger) {
          _this.$toasted.error(response.data.danger);
          _this.errors = null;
        } else {
          _this.errors = response.data.errors;
        }
      }).finally(function () {
        _this.working = false;
        _this.file = null;
        _this.fileName = "";
        _this.$refs.form.reset();
      });
    }
  },
  computed: {
    currentLabel: function currentLabel() {
      return this.fileName || this.label;
    },
    firstError: function firstError() {
      return this.errors ? this.errors[Object.keys(this.errors)[0]][0] : null;
    },
    inputName: function inputName() {
      return "file-import-input-" + this.card.resource;
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
  return _c("card", { staticClass: "flex flex-col h-auto" }, [
    _c("div", { staticClass: "px-3 py-3" }, [
      _c("div", { staticClass: "mb-4 border-b border-50 pb-2" }, [
        _c(
          "h1",
          {
            staticClass:
              "text-center mb-2 text-sm font-semibold uppercase tracking-wide"
          },
          [
            _vm._v(
              _vm._s(_vm.__("Import")) + " " + _vm._s(_vm.card.resourceLabel)
            )
          ]
        ),
        _vm._v(" "),
        _vm.card.sample
          ? _c("p", { staticClass: "leading-normal text-center" }, [
              _c(
                "a",
                {
                  staticClass:
                    "text-primary no-underline hover:bg-40 py-1 px-2 rounded",
                  attrs: { target: "_blank", href: _vm.card.sample }
                },
                [_vm._v("Download Sample File")]
              )
            ])
          : _vm._e()
      ]),
      _vm._v(" "),
      _c(
        "form",
        {
          ref: "form",
          on: {
            submit: function($event) {
              $event.preventDefault()
              return _vm.processImport($event)
            }
          }
        },
        [
          _c("div", { staticClass: "py-4" }, [
            _c("span", { staticClass: "form-file mr-4" }, [
              _c("input", {
                ref: "fileField",
                staticClass: "form-file-input",
                attrs: { type: "file", id: _vm.inputName, name: _vm.inputName },
                on: { change: _vm.fileChange }
              }),
              _vm._v(" "),
              _c(
                "label",
                {
                  staticClass: "form-file-btn btn btn-default btn-primary",
                  attrs: { for: _vm.inputName }
                },
                [_vm._v(_vm._s(_vm.__("Choose File")))]
              )
            ]),
            _vm._v(" "),
            _c("span", { staticClass: "text-gray-50" }, [
              _vm._v(_vm._s(_vm.currentLabel))
            ])
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "flex" }, [
            _vm.errors
              ? _c(
                  "div",
                  _vm._l(_vm.errors, function(error, index) {
                    return _c(
                      "p",
                      { key: index, staticClass: "text-danger mb-1" },
                      [_vm._v(_vm._s(error[0]))]
                    )
                  }),
                  0
                )
              : _vm._e(),
            _vm._v(" "),
            _c(
              "button",
              {
                staticClass: "btn btn-default btn-primary ml-auto mt-auto",
                attrs: { disabled: _vm.working, type: "submit" }
              },
              [
                _vm.working
                  ? _c("loader", { attrs: { width: "30" } })
                  : _c("span", [_vm._v(_vm._s(_vm.__("Import")))])
              ],
              1
            )
          ])
        ]
      )
    ])
  ])
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-b9bc2c0a", module.exports)
  }
}

/***/ }),
/* 6 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ })
/******/ ]);