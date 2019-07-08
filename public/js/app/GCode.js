webpackJsonp([18],{

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}],\"@babel/plugin-syntax-dynamic-import\"]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/assets/js/components/GCode.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__helpers__ = __webpack_require__("./resources/assets/js/helpers.js");
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
  props: ['filename'],
  data: function data() {
    return {
      printJob: {
        name: ''
      },
      filamentDensity: 0,
      filamentDiameter: 0,
      filamentSpool: null,
      machine: {
        hourlyRate: null,
        energy_consumption: null
      },
      filamentSpools: [],
      machines: [],
      filamentDetails: false,
      machineDetails: false,
      electricityDetails: false
    };
  },
  computed: {
    usedFilamentInVolume: function usedFilamentInVolume() {
      return Math.PI * Math.pow(this.filamentDiameter / 2, 2) * this.printJob.filamentInLength / 1000;
    },
    usedFilamentInWeight: function usedFilamentInWeight() {
      return this.usedFilamentInVolume * this.filamentDensity;
    },
    powerConsumption: function powerConsumption() {
      if (typeof this.machine === 'undefined' || !this.machine) {
        return;
      }

      return this.printJob.estimatedPrintingTime / 3600 * this.machine.energy_consumption / 1000;
    },
    estimatedPrintTime: function estimatedPrintTime() {
      return Object(__WEBPACK_IMPORTED_MODULE_0__helpers__["a" /* durationFormat */])(this.printJob.estimatedPrintingTime);
    },
    filamentCost: function filamentCost() {
      return this.usedFilamentInWeight * (this.filamentSpool.purchasePrice / this.filamentSpool.weight);
    },
    machineCost: function machineCost() {
      if (typeof this.machine === 'undefined' || !this.machine) {
        return;
      }

      return this.printJob.estimatedPrintingTime / 3600 * this.machine.hourlyRate;
    },
    electricityCost: function electricityCost() {
      return this.powerConsumption * 27;
    },
    totalCost: function totalCost() {
      return this.filamentCost + this.electricityCost + this.machineCost;
    },
    costPerHour: function costPerHour() {
      return this.totalCost / this.printJob.estimatedPrintingTime * 3600;
    }
  },
  methods: {
    updateFilament: function updateFilament(filamentSpool) {
      this.filamentDensity = filamentSpool.density;
      this.filamentDiameter = filamentSpool.diameter;
    },
    updateMachine: function updateMachine(machine) {},
    numberFormat: __WEBPACK_IMPORTED_MODULE_0__helpers__["c" /* numberFormat */],
    moneyFormat: __WEBPACK_IMPORTED_MODULE_0__helpers__["b" /* moneyFormat */]
  },
  mounted: function mounted() {
    var _this = this;

    // Retrieve the Print Job data
    window.axios.get('/api/printjobs/' + this.filename).then(function (response) {
      if (response.status >= 200 && response.status <= 299) {
        _this.printJob = response.data.attributes;
        _this.filamentDensity = _this.printJob.filamentDensity;
        _this.filamentDiameter = _this.printJob.filamentDiameter;
      }
    }); // Populate the Filament Spools Dropdown

    window.axios.get('/api/filamentspools').then(function (response) {
      if (response.status >= 200 && response.status <= 299) {
        var spools = response.data.data;
        spools.forEach(function (spools) {
          _this.filamentSpools.push({
            value: spool.attributes,
            text: spool.attributes.manufacturer + ' ' + spool.attributes.name
          });
        });
      }
    }); // Populate the Machines Dropdown

    window.axios.get('/api/machines').then(function (response) {
      if (response.status >= 200 && response.status <= 299) {
        var machines = response.data.data;
        machines.forEach(function (machine) {
          _this.machines.push({
            value: machine.attributes,
            text: machine.attributes.name + ' (' + machine.attributes.model + ')'
          });
        });
      }
    });
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-81e8f566\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/assets/js/components/GCode.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("b-container", { staticClass: "container", attrs: { fluid: "" } }, [
    _c("div", { staticClass: "d-flex" }, [
      _c("div", [
        _c("h1", { staticClass: "display-5 text-uppercase" }, [
          _vm._v("Cost Estimator")
        ]),
        _vm._v(" "),
        _c("h3", { staticClass: "display-5 text-capitalize" }, [
          _vm._v("3D Print Job `" + _vm._s(_vm.printJob.name) + "`")
        ])
      ])
    ]),
    _vm._v(" "),
    _c(
      "p",
      {
        staticClass: "text-muted mt-2",
        staticStyle: { "font-size": "medium" }
      },
      [
        _vm._v(
          "\n        Use this Cost Estimator to quickly see how much a 3D Print Job will cost. The estimated\n        cost is based on the consumed material and used machine. Simply select a filament spools\n        and machine for this print job and the cost will be calculated instantly.\n    "
        )
      ]
    ),
    _vm._v(" "),
    _c(
      "div",
      { staticClass: "form-row" },
      [
        _c(
          "b-form-group",
          { attrs: { label: "3D Printer", "label-for": "input_machine" } },
          [
            _c("b-form-select", {
              staticClass: "col-md-12",
              attrs: {
                id: "input_machine",
                plain: false,
                options: _vm.machines
              },
              on: { change: _vm.updateMachine },
              model: {
                value: _vm.machine,
                callback: function($$v) {
                  _vm.machine = $$v
                },
                expression: "machine"
              }
            })
          ],
          1
        ),
        _vm._v(" "),
        _c(
          "b-form-group",
          {
            staticClass: "ml-3",
            attrs: {
              label: "Filament Spool",
              "label-for": "input_filamentspool"
            }
          },
          [
            _c("b-form-select", {
              staticClass: "col-md-12",
              attrs: {
                id: "input_filamentspool",
                plain: false,
                options: _vm.filamentSpools
              },
              on: { change: _vm.updateFilament },
              model: {
                value: _vm.filamentSpool,
                callback: function($$v) {
                  _vm.filamentSpool = $$v
                },
                expression: "filamentSpool"
              }
            })
          ],
          1
        )
      ],
      1
    ),
    _vm._v(" "),
    _c("div", { staticClass: "card-deck mt-3" }, [
      _c("div", { staticClass: "card-volta card" }, [
        _c("div", { staticClass: "card-header" }, [_vm._v("Cost Overview")]),
        _vm._v(" "),
        _vm.filamentSpool
          ? _c(
              "div",
              { staticClass: "card-body" },
              [
                _c(
                  "p",
                  {
                    staticClass: "text-muted",
                    staticStyle: {
                      "font-size": "small",
                      "text-transform": "uppercase"
                    }
                  },
                  [
                    _vm._v(
                      "\n                    Estimated Print Time: " +
                        _vm._s(_vm.estimatedPrintTime) +
                        "\n                "
                    )
                  ]
                ),
                _vm._v(" "),
                _c("div", { staticClass: "row mb-3" }, [
                  _c(
                    "div",
                    { staticClass: "col-sm-1" },
                    [
                      _c(
                        "b-link",
                        {
                          attrs: { title: "View more details" },
                          on: {
                            click: function($event) {
                              $event.stopPropagation()
                              _vm.filamentDetails = !_vm.filamentDetails
                            }
                          }
                        },
                        [
                          _c("svgicon", {
                            staticClass: "action-icon-sm",
                            class: { "svg-right": _vm.filamentDetails },
                            attrs: { icon: "details" }
                          })
                        ],
                        1
                      )
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-sm-7" }, [
                    _c("strong", [_vm._v("Filament")])
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-sm-2 text-right" }, [
                    _vm._v(_vm._s(_vm.moneyFormat(_vm.filamentCost)))
                  ])
                ]),
                _vm._v(" "),
                _c(
                  "div",
                  {
                    directives: [
                      {
                        name: "show",
                        rawName: "v-show",
                        value: _vm.filamentDetails,
                        expression: "filamentDetails"
                      }
                    ],
                    staticClass: "row mb-3 container"
                  },
                  [
                    _c("div", { staticClass: "row ml-3" }, [
                      _c("div", { staticClass: "col text-muted" }, [
                        _vm._v(
                          "\n                            " +
                            _vm._s(
                              _vm.numberFormat(
                                this.printJob.filamentInLength / 1000
                              )
                            ) +
                            " m of\n                            "
                        ),
                        _c("svg", { attrs: { height: "20", width: "20" } }, [
                          _c("circle", {
                            attrs: {
                              cx: "10",
                              cy: "10",
                              r: "10",
                              fill: _vm.filamentSpool.color_value
                            }
                          })
                        ]),
                        _vm._v(" "),
                        _c("span", [
                          _vm._v(
                            _vm._s(_vm.filamentSpool.manufacturer) +
                              " " +
                              _vm._s(_vm.filamentSpool.name) +
                              "\n                                "
                          ),
                          _c(
                            "span",
                            { staticStyle: { "text-transform": "uppercase" } },
                            [_vm._v(_vm._s(_vm.filamentSpool.material))]
                          )
                        ]),
                        _vm._v(
                          "\n                            (at a rate of ~\n                            " +
                            _vm._s(
                              _vm.moneyFormat(
                                _vm.filamentSpool.unitPrice.length
                              )
                            ) +
                            " p/m)\n                        "
                        )
                      ])
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "row ml-3" }, [
                      _c("div", { staticClass: "col text-muted" }, [
                        _vm._v(
                          "\n                            (" +
                            _vm._s(
                              _vm.numberFormat(
                                this.printJob.filamentInLength / 1000
                              )
                            ) +
                            " m =\n                            " +
                            _vm._s(_vm.numberFormat(_vm.usedFilamentInVolume)) +
                            " cm"
                        ),
                        _c("sup", [_vm._v("3")]),
                        _vm._v(
                          " =\n                            " +
                            _vm._s(_vm.numberFormat(_vm.usedFilamentInWeight)) +
                            " g)\n                        "
                        )
                      ])
                    ])
                  ]
                ),
                _vm._v(" "),
                _c("div", { staticClass: "row mb-3" }, [
                  _c(
                    "div",
                    { staticClass: "col-sm-1" },
                    [
                      _c(
                        "b-link",
                        {
                          attrs: { title: "View more details" },
                          on: {
                            click: function($event) {
                              $event.stopPropagation()
                              _vm.electricityDetails = !_vm.electricityDetails
                            }
                          }
                        },
                        [
                          _c("svgicon", {
                            staticClass: "action-icon-sm",
                            class: { "svg-right": _vm.electricityDetails },
                            attrs: { icon: "details" }
                          })
                        ],
                        1
                      )
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-sm-7" }, [
                    _c("strong", [_vm._v("Electricity")])
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-sm-2 text-right" }, [
                    _vm._v(_vm._s(_vm.moneyFormat(_vm.electricityCost)))
                  ])
                ]),
                _vm._v(" "),
                _c(
                  "div",
                  {
                    directives: [
                      {
                        name: "show",
                        rawName: "v-show",
                        value: _vm.electricityDetails,
                        expression: "electricityDetails"
                      }
                    ],
                    staticClass: "row mb-3 container"
                  },
                  [
                    _c("div", { staticClass: "row ml-3" }, [
                      _c("div", { staticClass: "col text-muted" }, [
                        _vm._v(
                          "\n                            " +
                            _vm._s(_vm.numberFormat(_vm.powerConsumption, 4)) +
                            " kWh (at a rate of ~ ¥27\n                            p/kWh)\n                        "
                        )
                      ])
                    ])
                  ]
                ),
                _vm._v(" "),
                _c("div", { staticClass: "row mb-3" }, [
                  _c(
                    "div",
                    { staticClass: "col-sm-1" },
                    [
                      _c(
                        "b-link",
                        {
                          attrs: { title: "View more details" },
                          on: {
                            click: function($event) {
                              $event.stopPropagation()
                              _vm.machineDetails = !_vm.machineDetails
                            }
                          }
                        },
                        [
                          _c("svgicon", {
                            staticClass: "action-icon-sm",
                            class: { "svg-right": _vm.machineDetails },
                            attrs: { icon: "details" }
                          })
                        ],
                        1
                      )
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-sm-7" }, [
                    _c("strong", [_vm._v("Machine")])
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-sm-2 text-right" }, [
                    _vm._v(_vm._s(_vm.moneyFormat(_vm.machineCost)))
                  ])
                ]),
                _vm._v(" "),
                _c(
                  "div",
                  {
                    directives: [
                      {
                        name: "show",
                        rawName: "v-show",
                        value: _vm.machineDetails,
                        expression: "machineDetails"
                      }
                    ],
                    staticClass: "row mb-3 container"
                  },
                  [
                    _c("div", { staticClass: "row ml-3" }, [
                      _c("div", { staticClass: "col text-muted" }, [
                        _vm._v(
                          "\n                            At a rate of ~ " +
                            _vm._s(_vm.moneyFormat(_vm.machine.hourlyRate)) +
                            " p/h\n                        "
                        )
                      ])
                    ])
                  ]
                ),
                _vm._v(" "),
                _c("div", { staticClass: "row" }, [
                  _c("div", { staticClass: "col-sm-1 pt-3" }),
                  _vm._v(" "),
                  _c(
                    "div",
                    {
                      staticClass: "col-sm-7 pt-3",
                      staticStyle: { "border-top": "1px solid #f00" }
                    },
                    [_c("strong", [_vm._v("Total")])]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    {
                      staticClass: "col-sm-2 pt-3 text-right",
                      staticStyle: { "border-top": "1px solid #f00" }
                    },
                    [
                      _vm._v(
                        "\n                        " +
                          _vm._s(_vm.moneyFormat(_vm.totalCost)) +
                          "\n                    "
                      )
                    ]
                  )
                ]),
                _vm._v(" "),
                _c(
                  "b-progress",
                  {
                    staticClass: "mb-3 mt-3",
                    attrs: {
                      "show-value": "",
                      max: _vm.totalCost,
                      height: "2rem"
                    }
                  },
                  [
                    _c("b-progress-bar", {
                      attrs: { variant: "success", value: _vm.filamentCost }
                    }),
                    _vm._v(" "),
                    _c("b-progress-bar", {
                      attrs: { variant: "warning", value: _vm.electricityCost }
                    }),
                    _vm._v(" "),
                    _c("b-progress-bar", {
                      attrs: { variant: "info", value: _vm.machineCost }
                    })
                  ],
                  1
                ),
                _vm._v(" "),
                _c("div", { staticClass: "row mb-3" }, [
                  _c("div", { staticClass: "col-4" }, [
                    _c("svg", { attrs: { height: "20", width: "20" } }, [
                      _c("circle", {
                        attrs: { cx: "10", cy: "10", r: "10", fill: "#28a745" }
                      })
                    ]),
                    _vm._v(" "),
                    _c(
                      "span",
                      {
                        staticClass: "text-muted",
                        staticStyle: {
                          "font-size": "small",
                          "text-transform": "uppercase"
                        }
                      },
                      [_vm._v("Filament")]
                    )
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-4" }, [
                    _c("svg", { attrs: { height: "20", width: "20" } }, [
                      _c("circle", {
                        attrs: { cx: "10", cy: "10", r: "10", fill: "#ffc107" }
                      })
                    ]),
                    _vm._v(" "),
                    _c(
                      "span",
                      {
                        staticClass: "text-muted",
                        staticStyle: {
                          "font-size": "small",
                          "text-transform": "uppercase"
                        }
                      },
                      [_vm._v("Electricity")]
                    )
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-4" }, [
                    _c("svg", { attrs: { height: "20", width: "20" } }, [
                      _c("circle", {
                        attrs: { cx: "10", cy: "10", r: "10", fill: "#17a2b8" }
                      })
                    ]),
                    _vm._v(" "),
                    _c(
                      "span",
                      {
                        staticClass: "text-muted",
                        staticStyle: {
                          "font-size": "small",
                          "text-transform": "uppercase"
                        }
                      },
                      [_vm._v("Machine")]
                    )
                  ])
                ]),
                _vm._v(" "),
                _c(
                  "p",
                  {
                    staticClass: "text-muted",
                    staticStyle: {
                      "font-size": "small",
                      "text-transform": "uppercase"
                    }
                  },
                  [
                    _vm._v(
                      "\n                    The cost per hour for this print job would equate to\n                    "
                    ),
                    _c("strong", [
                      _vm._v(_vm._s(_vm.moneyFormat(_vm.costPerHour)))
                    ]),
                    _vm._v(".\n                ")
                  ]
                )
              ],
              1
            )
          : _vm._e()
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "card-volta card" }, [
        _c("div", { staticClass: "card-header-custom card-header" }, [
          _vm._v("Slicer Configuration")
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "card-body" }, [
          _c("div", { staticClass: "table-responsive" }, [
            _c("table", { staticClass: "table" }, [
              _c("tbody", [
                _c("tr", [
                  _c("th", [_vm._v("Sliced with")]),
                  _vm._v(" "),
                  _c("td", [_vm._v(_vm._s(_vm.printJob.slicer))])
                ]),
                _vm._v(" "),
                _c("tr", [
                  _c("th", [_vm._v("Layer Height")]),
                  _vm._v(" "),
                  _c("td", [
                    _vm._v(
                      _vm._s(_vm.numberFormat(_vm.printJob.layerHeight)) + " mm"
                    )
                  ])
                ]),
                _vm._v(" "),
                _c("tr", [
                  _c("th", [_vm._v("Bed Temperature")]),
                  _vm._v(" "),
                  _c("td", [
                    _vm._v(
                      _vm._s(_vm.numberFormat(_vm.printJob.bedTemperature)) +
                        " °C"
                    )
                  ])
                ]),
                _vm._v(" "),
                _c("tr", [
                  _c("th", [_vm._v("Hot End Temperature")]),
                  _vm._v(" "),
                  _c("td", [
                    _vm._v(
                      _vm._s(_vm.numberFormat(_vm.printJob.hotendTemperature)) +
                        " °C"
                    )
                  ])
                ]),
                _vm._v(" "),
                _c("tr", [
                  _c("th", [_vm._v("Fill Density")]),
                  _vm._v(" "),
                  _c("td", [
                    _vm._v(
                      _vm._s(_vm.numberFormat(_vm.printJob.fillDensity)) + " %"
                    )
                  ])
                ]),
                _vm._v(" "),
                _c("tr", [
                  _c("th", [_vm._v("Perimeter Speed")]),
                  _vm._v(" "),
                  _c("td", [
                    _vm._v(
                      _vm._s(_vm.numberFormat(_vm.printJob.perimeterSpeed)) +
                        " mm/s"
                    )
                  ])
                ])
              ])
            ])
          ])
        ])
      ])
    ])
  ])
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-81e8f566", module.exports)
  }
}

/***/ }),

/***/ "./resources/assets/js/components/GCode.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}],\"@babel/plugin-syntax-dynamic-import\"]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/assets/js/components/GCode.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-81e8f566\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/assets/js/components/GCode.vue")
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
Component.options.__file = "resources/assets/js/components/GCode.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-81e8f566", Component.options)
  } else {
    hotAPI.reload("data-v-81e8f566", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ })

});