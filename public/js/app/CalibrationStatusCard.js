webpackJsonp([20],{

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}],\"@babel/plugin-syntax-dynamic-import\"]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/assets/js/components/CalibrationStatusCard.vue":
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
//
/* harmony default export */ __webpack_exports__["default"] = ({
  components: {},
  data: function data() {
    return {
      input1: '',
      input1state: null,
      input2: '',
      input2state: null,
      options: [{
        text: '- Choose 1 -',
        value: ''
      }, 'Red', 'Green', 'Blue'],
      input1Return: '',
      input2Return: '',
      popoverShow: false
    };
  },
  watch: {
    input1: function input1(val) {
      if (val) {
        this.input1state = true;
      }
    },
    input2: function input2(val) {
      if (val) {
        this.input2state = true;
      }
    }
  },
  methods: {
    onClose: function onClose() {
      this.popoverShow = false;
    },
    onOk: function onOk() {
      if (!this.input1) {
        this.input1state = false;
      }

      if (!this.input2) {
        this.input2state = false;
      }

      if (this.input1 && this.input2) {
        this.onClose();
        /* "Return" our popover "form" results */

        this.input1Return = this.input1;
        this.input2Return = this.input2;
      }
    },
    onShow: function onShow() {
      /* This is called just before the popover is shown */

      /* Reset our popover "form" variables */
      this.input1 = '';
      this.input2 = '';
      this.input1state = null;
      this.input2state = null;
      this.input1Return = '';
      this.input2Return = '';
    },
    onShown: function onShown() {
      /* Called just after the popover has been shown */

      /* Transfer focus to the first input */
      this.focusRef(this.$refs.input1);
    },
    onHidden: function onHidden() {
      /* Called just after the popover has finished hiding */

      /* Bring focus back to the button */
      this.focusRef(this.$refs.button);
    },
    focusRef: function focusRef(ref) {
      var _this = this;

      /* Some references may be a component, functional component, or plain element */

      /* This handles that check before focusing, assuming a focus() method exists */

      /* We do this in a double nextTick to ensure components have updated & popover positioned first */
      this.$nextTick(function () {
        _this.$nextTick(function () {
          (ref.$el || ref).focus();
        });
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-64954005\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/assets/js/components/CalibrationStatusCard.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { staticClass: "card-volta card" },
    [
      _c(
        "b-popover",
        {
          ref: "popover",
          attrs: {
            target: "exPopoverReactive1",
            triggers: "click",
            show: _vm.popoverShow,
            placement: "auto",
            container: "myContainer"
          },
          on: {
            "update:show": function($event) {
              _vm.popoverShow = $event
            },
            show: _vm.onShow,
            shown: _vm.onShown,
            hidden: _vm.onHidden
          }
        },
        [
          _c(
            "template",
            { slot: "title" },
            [
              _c(
                "b-btn",
                {
                  staticClass: "close",
                  attrs: { "aria-label": "Close" },
                  on: { click: _vm.onClose }
                },
                [
                  _c(
                    "span",
                    {
                      staticClass: "d-inline-block",
                      attrs: { "aria-hidden": "true" }
                    },
                    [_vm._v("×")]
                  )
                ]
              ),
              _vm._v("\n            Interactive Content\n        ")
            ],
            1
          ),
          _vm._v(" "),
          _c(
            "div",
            [
              _c(
                "b-form-group",
                {
                  staticClass: "mb-1",
                  attrs: {
                    label: "Name",
                    "label-for": "pop1",
                    state: _vm.input1state,
                    horizontal: "",
                    description: "Enter your name",
                    "invalid-feedback": "This field is required"
                  }
                },
                [
                  _c("b-form-input", {
                    ref: "input1",
                    attrs: { id: "pop1", state: _vm.input1state, size: "sm" },
                    model: {
                      value: _vm.input1,
                      callback: function($$v) {
                        _vm.input1 = $$v
                      },
                      expression: "input1"
                    }
                  })
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "b-form-group",
                {
                  staticClass: "mb-1",
                  attrs: {
                    label: "Color",
                    "label-for": "pop2",
                    state: _vm.input2state,
                    horizontal: "",
                    description: "Pick a color",
                    "invalid-feedback": "This field is required"
                  }
                },
                [
                  _c("b-form-select", {
                    attrs: {
                      size: "sm",
                      id: "pop2",
                      state: _vm.input2state,
                      options: _vm.options
                    },
                    model: {
                      value: _vm.input2,
                      callback: function($$v) {
                        _vm.input2 = $$v
                      },
                      expression: "input2"
                    }
                  })
                ],
                1
              ),
              _vm._v(" "),
              _c("b-alert", { staticClass: "small", attrs: { show: "" } }, [
                _c("strong", [_vm._v("Current Values:")]),
                _c("br"),
                _vm._v("\n                Name: "),
                _c("strong", [_vm._v(_vm._s(_vm.input1))]),
                _c("br"),
                _vm._v("\n                Color: "),
                _c("strong", [_vm._v(_vm._s(_vm.input2))])
              ]),
              _vm._v(" "),
              _c(
                "b-btn",
                {
                  attrs: { size: "sm", variant: "danger" },
                  on: { click: _vm.onClose }
                },
                [_vm._v("Cancel")]
              ),
              _vm._v(" "),
              _c(
                "b-btn",
                {
                  attrs: { size: "sm", variant: "primary" },
                  on: { click: _vm.onOk }
                },
                [_vm._v("Ok")]
              )
            ],
            1
          )
        ],
        2
      ),
      _vm._v(" "),
      _c("div", { staticClass: "card-header" }, [_vm._v("Calibrations")]),
      _vm._v(" "),
      _c("div", { staticClass: "card-body" }, [
        _c("div", { staticClass: "table-responsive" }, [
          _c("table", { staticClass: "table" }, [
            _c("tbody", [
              _c("tr", [
                _vm._m(0),
                _vm._v(" "),
                _c(
                  "td",
                  { staticStyle: { "text-align": "right" } },
                  [
                    _vm._v(
                      "\n                            40\n                            "
                    ),
                    _c("b-link", {
                      attrs: {
                        id: "exPopoverReactive1",
                        disabled: _vm.popoverShow
                      }
                    })
                  ],
                  1
                )
              ]),
              _vm._v(" "),
              _vm._m(1),
              _vm._v(" "),
              _vm._m(2)
            ])
          ])
        ])
      ])
    ],
    1
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("th", [
      _c("div", { staticClass: "icon-inline" }, [_vm._v("@svg('image')")]),
      _vm._v(
        "\n                            Linear Advance\n                        "
      )
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("tr", [
      _c("th", [
        _c("div", { staticClass: "icon-inline" }, [_vm._v("@svg('resize_6')")]),
        _vm._v(
          "\n                            Diameter\n                        "
        )
      ]),
      _vm._v(" "),
      _c("td", { staticStyle: { "text-align": "right" } }, [
        _c("abbr", { attrs: { title: "This filament has a variance of" } }, [
          _vm._v("1.76 mm")
        ])
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("tr", [
      _c("th", [
        _c("div", { staticClass: "icon-inline" }, [
          _vm._v("@svg('square_down')")
        ]),
        _vm._v(
          "\n                            Extrusion\n                        "
        )
      ]),
      _vm._v(" "),
      _c("td", { staticStyle: { "text-align": "right" } }, [
        _c("abbr", { attrs: { title: "Your filament " } }, [_vm._v("0.49 mm")])
      ])
    ])
  }
]
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-64954005", module.exports)
  }
}

/***/ }),

/***/ "./resources/assets/js/components/CalibrationStatusCard.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}],\"@babel/plugin-syntax-dynamic-import\"]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/assets/js/components/CalibrationStatusCard.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-64954005\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/assets/js/components/CalibrationStatusCard.vue")
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
Component.options.__file = "resources/assets/js/components/CalibrationStatusCard.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-64954005", Component.options)
  } else {
    hotAPI.reload("data-v-64954005", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ })

});