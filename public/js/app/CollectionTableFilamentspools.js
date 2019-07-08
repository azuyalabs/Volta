webpackJsonp([19],{

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}],\"@babel/plugin-syntax-dynamic-import\"]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/assets/js/components/CollectionTableFilamentspools.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__ = __webpack_require__("./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_axios__ = __webpack_require__("./node_modules/axios/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_axios___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_axios__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__svg_icons_compiled_plus_js__ = __webpack_require__("./resources/svg-icons/compiled/plus.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__svg_icons_compiled_plus_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2__svg_icons_compiled_plus_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__svg_icons_compiled_details_js__ = __webpack_require__("./resources/svg-icons/compiled/details.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__svg_icons_compiled_details_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_3__svg_icons_compiled_details_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__svg_icons_compiled_actions_js__ = __webpack_require__("./resources/svg-icons/compiled/actions.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__svg_icons_compiled_actions_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_4__svg_icons_compiled_actions_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__helpers__ = __webpack_require__("./resources/assets/js/helpers.js");


function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance"); }

function _iterableToArray(iter) { if (Symbol.iterator in Object(iter) || Object.prototype.toString.call(iter) === "[object Arguments]") return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = new Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: {},
  data: function data() {
    return {
      sortBy: 'name',
      sortDesc: false,
      fields: [{
        key: 'name',
        label: 'Name',
        sortable: true
      }, {
        key: 'material',
        sortable: true
      }, {
        key: 'price',
        label: 'Price per kg',
        sortable: false
      }, {
        key: 'usage',
        label: 'Usage',
        sortable: false
      }, {
        key: 'actions',
        label: ''
      }],
      totalRows: 0,
      currentPage: 1,
      perPage: 10,
      collection: [],
      filter: {
        material: 'all',
        manufacturer: 'all'
      }
    };
  },
  mounted: function mounted() {
    this.getCollection();
  },
  computed: {
    manufacturerFilterOptions: function manufacturerFilterOptions() {
      return _toConsumableArray(new Set(this.collection.map(function (item) {
        return item.manufacturer;
      }))).sort().map(function (f) {
        return {
          text: f,
          value: f
        };
      });
    },
    materialFilterOptions: function materialFilterOptions() {
      return _toConsumableArray(new Set(this.collection.map(function (item) {
        return item.material;
      }))).sort().map(function (f) {
        return {
          text: f.toUpperCase(),
          value: f
        };
      });
    }
  },
  methods: {
    filterFunction: function filterFunction(record) {
      return (this.filter.material === 'all' || this.filter.material === record.material) && (this.filter.manufacturer === 'all' || record.manufacturer === this.filter.manufacturer);
    },
    spoolUsage: function spoolUsage(spool) {
      return +(spool.length.usage / spool.length.capacity * 100).toFixed(2);
    },
    alertUsage: function alertUsage(spool) {
      return this.spoolUsage(spool) >= 90 && this.spoolUsage(spool) < 100;
    },
    isEmpty: function isEmpty(spool) {
      return this.spoolUsage(spool) === 100;
    },
    onFiltered: function onFiltered(filteredItems) {
      // Trigger pagination to update the number of buttons/pages due to filtering
      this.totalRows = filteredItems.length;
      this.currentPage = 1;
    },
    deleteInstance: function deleteInstance(id) {
      var _this = this;

      var conf = confirm('Do you really want to delete this filament spool?');
      var index = this.collection.findIndex(function (x) {
        return x.id === id;
      });

      if (conf === true) {
        __WEBPACK_IMPORTED_MODULE_1_axios___default.a["delete"]('/api/filamentspools/' + id).then(function (response) {
          _this.collection.splice(index, 1);
        })["catch"](function (error) {
          console.log(error);
        });
      }
    },
    getCollection: function () {
      var _getCollection = _asyncToGenerator(
      /*#__PURE__*/
      __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.mark(function _callee() {
        var response, collectionData, i, o, attr, key;
        return __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _context.prev = 0;
                _context.next = 3;
                return __WEBPACK_IMPORTED_MODULE_1_axios___default.a.get('/api/filamentspools');

              case 3:
                response = _context.sent;
                // Remap JSON:API data to simple array with objects as its elements
                collectionData = response.data.data;

                for (i = 0; i < collectionData.length; i++) {
                  o = {};
                  o.id = collectionData[i].id; // Need to fetch primary key
                  // Fetch all the attributes

                  attr = collectionData[i].attributes;

                  for (key in attr) {
                    if (attr.hasOwnProperty(key)) o[key] = attr[key];
                  }

                  this.collection.push(o);
                }

                _context.next = 12;
                break;

              case 8:
                _context.prev = 8;
                _context.t0 = _context["catch"](0);
                console.log(_context.t0);
                return _context.abrupt("return", []);

              case 12:
              case "end":
                return _context.stop();
            }
          }
        }, _callee, this, [[0, 8]]);
      }));

      function getCollection() {
        return _getCollection.apply(this, arguments);
      }

      return getCollection;
    }(),
    moneyFormat: __WEBPACK_IMPORTED_MODULE_5__helpers__["b" /* moneyFormat */],
    numberFormat: __WEBPACK_IMPORTED_MODULE_5__helpers__["c" /* numberFormat */]
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-4f9b01e3\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/assets/js/components/CollectionTableFilamentspools.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    [
      _c("div", { staticClass: "d-flex" }, [
        _c(
          "div",
          { staticClass: "p-2" },
          [
            _c(
              "b-link",
              {
                staticClass: "btn btn-primary btn-sm text-uppercase",
                attrs: { href: "/spools/create", title: "Add a new Spool" }
              },
              [
                _c("svgicon", {
                  staticClass: "button-icon-sm",
                  attrs: { icon: "plus", color: "#fff" }
                }),
                _vm._v("\n                add\n            ")
              ],
              1
            )
          ],
          1
        ),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "ml-auto p-2 d-inline-flex" },
          [
            _c(
              "b-form-group",
              {
                staticClass: "mr-3",
                attrs: {
                  label: "Material",
                  "label-for": "filter_material",
                  "label-size": "sm"
                }
              },
              [
                _c(
                  "b-form-select",
                  {
                    attrs: {
                      id: "filter_material",
                      options: _vm.materialFilterOptions,
                      size: "sm"
                    },
                    model: {
                      value: _vm.filter.material,
                      callback: function($$v) {
                        _vm.$set(_vm.filter, "material", $$v)
                      },
                      expression: "filter.material"
                    }
                  },
                  [
                    _c(
                      "option",
                      { attrs: { slot: "first", value: "all" }, slot: "first" },
                      [_vm._v("-- All --")]
                    )
                  ]
                )
              ],
              1
            ),
            _vm._v(" "),
            _c(
              "b-form-group",
              {
                attrs: {
                  label: "Manufacturer",
                  "label-for": "filter_manufacturer",
                  "label-size": "sm"
                }
              },
              [
                _c(
                  "b-form-select",
                  {
                    attrs: {
                      id: "filter_manufacturer",
                      options: _vm.manufacturerFilterOptions,
                      size: "sm"
                    },
                    model: {
                      value: _vm.filter.manufacturer,
                      callback: function($$v) {
                        _vm.$set(_vm.filter, "manufacturer", $$v)
                      },
                      expression: "filter.manufacturer"
                    }
                  },
                  [
                    _c(
                      "option",
                      { attrs: { slot: "first", value: "all" }, slot: "first" },
                      [_vm._v("-- All --")]
                    )
                  ]
                )
              ],
              1
            )
          ],
          1
        )
      ]),
      _vm._v(" "),
      _c("b-table", {
        staticClass: "volta",
        attrs: {
          "sort-by": _vm.sortBy,
          "sort-desc": _vm.sortDesc,
          "filter-function": _vm.filterFunction,
          filter: _vm.filter,
          items: _vm.collection,
          fields: _vm.fields,
          "current-page": _vm.currentPage,
          "per-page": _vm.perPage
        },
        on: {
          "update:sortBy": function($event) {
            _vm.sortBy = $event
          },
          "update:sort-by": function($event) {
            _vm.sortBy = $event
          },
          "update:sortDesc": function($event) {
            _vm.sortDesc = $event
          },
          "update:sort-desc": function($event) {
            _vm.sortDesc = $event
          },
          filtered: _vm.onFiltered
        },
        scopedSlots: _vm._u([
          {
            key: "name",
            fn: function(row) {
              return [
                _c(
                  "svg",
                  {
                    directives: [
                      {
                        name: "b-tooltip",
                        rawName: "v-b-tooltip.hover",
                        modifiers: { hover: true }
                      }
                    ],
                    staticClass: "color-swatch",
                    attrs: {
                      xmlns: "http://www.w3.org/2000/svg",
                      width: "32",
                      height: "32",
                      viewBox: "0 0 24 24",
                      fill: row.item.color_value,
                      stroke: "silver",
                      "stroke-width": "1",
                      title: row.item.color
                    }
                  },
                  [_c("circle", { attrs: { cx: "12", cy: "12", r: "10" } })]
                ),
                _vm._v(" "),
                _c("div", { staticClass: "d-inline-block" }, [
                  _c(
                    "div",
                    [
                      _c(
                        "b-link",
                        { attrs: { href: "/spools/" + row.item.id } },
                        [_vm._v(_vm._s(row.value))]
                      )
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c("div", { staticClass: "text-muted small" }, [
                    _vm._v(_vm._s(row.item.manufacturer))
                  ])
                ])
              ]
            }
          },
          {
            key: "material",
            fn: function(row) {
              return [
                _c("div", { staticClass: "d-inline-block" }, [
                  _c("div", { staticClass: "text-uppercase" }, [
                    _vm._v(_vm._s(row.item.material))
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "text-muted small" }, [
                    _vm._v(
                      "\n                    " +
                        _vm._s(row.item.diameter) +
                        " mm / " +
                        _vm._s(row.item.density) +
                        " g/cm"
                    ),
                    _c("sup", [_vm._v("3")])
                  ])
                ])
              ]
            }
          },
          {
            key: "price",
            fn: function(row) {
              return [
                _vm._v(
                  _vm._s(_vm.moneyFormat(row.item.unit_price.kilogram.amount)) +
                    "\n        "
                )
              ]
            }
          },
          {
            key: "usage",
            fn: function(row) {
              return [
                _c(
                  "div",
                  { staticClass: "d-inline-block" },
                  [
                    _c("vm-progress", {
                      directives: [
                        {
                          name: "b-tooltip",
                          rawName: "v-b-tooltip.hover",
                          modifiers: { hover: true }
                        }
                      ],
                      staticClass: "filament_spool",
                      attrs: {
                        percentage: _vm.spoolUsage(row.item),
                        "stroke-width": 10,
                        "show-text": false,
                        title:
                          _vm.numberFormat(
                            row.item.length.capacity - row.item.length.usage
                          ) + " m remaining"
                      }
                    }),
                    _vm._v(" "),
                    _c("div", { staticClass: "text-muted small" }, [
                      _vm._v(
                        "\n                    " +
                          _vm._s(
                            _vm.numberFormat(_vm.spoolUsage(row.item), 1) +
                              "% used"
                          ) +
                          "\n                "
                      )
                    ])
                  ],
                  1
                ),
                _vm._v(" "),
                _vm.alertUsage(row.item)
                  ? _c(
                      "svg",
                      {
                        directives: [
                          {
                            name: "b-tooltip",
                            rawName: "v-b-tooltip.hover",
                            modifiers: { hover: true }
                          }
                        ],
                        staticClass: "usage-alert",
                        attrs: {
                          xmlns: "http://www.w3.org/2000/svg",
                          width: "24",
                          height: "24",
                          viewBox: "0 0 24 24",
                          fill: "none",
                          stroke: "currentColor",
                          "stroke-width": "2",
                          "stroke-linecap": "round",
                          "stroke-linejoin": "round",
                          title:
                            "You are soon running out of " +
                            row.item.manufacturer +
                            " " +
                            row.item.color +
                            "! Please consider getting a new spool."
                        }
                      },
                      [
                        _c("circle", {
                          attrs: { cx: "12", cy: "12", r: "10" }
                        }),
                        _vm._v(" "),
                        _c("line", {
                          attrs: { x1: "12", y1: "8", x2: "12", y2: "12" }
                        }),
                        _vm._v(" "),
                        _c("line", {
                          attrs: { x1: "12", y1: "16", x2: "12", y2: "16" }
                        })
                      ]
                    )
                  : _vm._e()
              ]
            }
          },
          {
            key: "actions",
            fn: function(row) {
              return [
                _c(
                  "b-dropdown",
                  {
                    attrs: {
                      variant: "link",
                      size: "sm",
                      right: "",
                      "no-caret": ""
                    }
                  },
                  [
                    _c(
                      "template",
                      { slot: "button-content" },
                      [
                        _c("svgicon", {
                          directives: [
                            {
                              name: "b-tooltip",
                              rawName: "v-b-tooltip.hover",
                              modifiers: { hover: true }
                            }
                          ],
                          staticClass: "action-icon-md",
                          attrs: { title: "More actions", icon: "actions" }
                        })
                      ],
                      1
                    ),
                    _vm._v(" "),
                    _c(
                      "b-dropdown-item",
                      {
                        attrs: {
                          href: "/spools/" + row.item.id + "/edit",
                          title: "Edit filament spool `" + row.item.name + "`"
                        }
                      },
                      [_vm._v("Edit\n                ")]
                    ),
                    _vm._v(" "),
                    _c(
                      "b-dropdown-item",
                      {
                        attrs: {
                          href: "#",
                          title: "Delete filament spool `" + row.item.name + "`"
                        },
                        on: {
                          click: function($event) {
                            $event.stopPropagation()
                            return _vm.deleteInstance(row.item.id)
                          }
                        }
                      },
                      [_vm._v("Delete\n                ")]
                    ),
                    _vm._v(" "),
                    _c(
                      "b-dropdown-item",
                      {
                        attrs: {
                          href: "/spools/" + row.item.id + "/duplicate",
                          title:
                            "Duplicate filament spool `" + row.item.name + "`"
                        }
                      },
                      [_vm._v("Duplicate\n                ")]
                    ),
                    _vm._v(" "),
                    !_vm.isEmpty(row.item)
                      ? _c(
                          "b-dropdown-item",
                          {
                            attrs: {
                              href: "/spools/" + row.item.id + "/empty",
                              title:
                                "Mark filament spool `" +
                                row.item.name +
                                "` as empty"
                            }
                          },
                          [_vm._v("Mark as Empty\n                ")]
                        )
                      : _vm._e()
                  ],
                  2
                )
              ]
            }
          }
        ])
      }),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "d-flex align-items-center flex-column" },
        [
          _vm.totalRows > _vm.perPage
            ? _c("b-pagination", {
                staticClass: "my-0",
                attrs: { "total-rows": _vm.totalRows, "per-page": _vm.perPage },
                model: {
                  value: _vm.currentPage,
                  callback: function($$v) {
                    _vm.currentPage = $$v
                  },
                  expression: "currentPage"
                }
              })
            : _vm._e()
        ],
        1
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
    require("vue-hot-reload-api")      .rerender("data-v-4f9b01e3", module.exports)
  }
}

/***/ }),

/***/ "./resources/assets/js/components/CollectionTableFilamentspools.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}],\"@babel/plugin-syntax-dynamic-import\"]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/assets/js/components/CollectionTableFilamentspools.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-4f9b01e3\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/assets/js/components/CollectionTableFilamentspools.vue")
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
Component.options.__file = "resources/assets/js/components/CollectionTableFilamentspools.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-4f9b01e3", Component.options)
  } else {
    hotAPI.reload("data-v-4f9b01e3", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ })

});