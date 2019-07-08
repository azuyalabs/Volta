webpackJsonp([16],{

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}],\"@babel/plugin-syntax-dynamic-import\"]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/assets/js/components/CollectionTableMachines.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__ = __webpack_require__("./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_runtime_regenerator__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_axios__ = __webpack_require__("./node_modules/axios/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_axios___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_axios__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__svg_icons_compiled_square_down_js__ = __webpack_require__("./resources/svg-icons/compiled/square_down.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__svg_icons_compiled_square_down_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2__svg_icons_compiled_square_down_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__svg_icons_compiled_plus_js__ = __webpack_require__("./resources/svg-icons/compiled/plus.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__svg_icons_compiled_plus_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_3__svg_icons_compiled_plus_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__svg_icons_compiled_details_js__ = __webpack_require__("./resources/svg-icons/compiled/details.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__svg_icons_compiled_details_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_4__svg_icons_compiled_details_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__svg_icons_compiled_delete_js__ = __webpack_require__("./resources/svg-icons/compiled/delete.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__svg_icons_compiled_delete_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_5__svg_icons_compiled_delete_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__svg_icons_compiled_edit_js__ = __webpack_require__("./resources/svg-icons/compiled/edit.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__svg_icons_compiled_edit_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_6__svg_icons_compiled_edit_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7__svg_icons_compiled_actions_js__ = __webpack_require__("./resources/svg-icons/compiled/actions.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7__svg_icons_compiled_actions_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_7__svg_icons_compiled_actions_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_8__helpers__ = __webpack_require__("./resources/assets/js/helpers.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_9_vue_status_indicator__ = __webpack_require__("./node_modules/vue-status-indicator/dist/vue-status-indicator.esm.js");


function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  components: {
    StatusIndicator: __WEBPACK_IMPORTED_MODULE_9_vue_status_indicator__["a" /* StatusIndicator */]
  },
  props: {},
  data: function data() {
    return {
      sortBy: 'name',
      sortDesc: false,
      fields: [{
        key: 'details',
        label: ''
      }, {
        key: 'name',
        label: 'Name',
        sortable: true
      }, {
        key: 'model',
        sortable: true
      }, {
        key: 'hourlyRate',
        label: 'Cost per hour',
        sortable: false
      }, {
        key: 'actions',
        label: ''
      }, {
        key: 'extra',
        label: ''
      }, {
        key: 'status',
        label: 'Status',
        "class": 'text-center'
      }],
      filter: null,
      totalRows: 0,
      currentPage: 1,
      perPage: 5,
      collection: []
    };
  },
  mounted: function mounted() {
    this.getCollection();
    setInterval(this.getCollection, 20 * 1000);
  },
  methods: {
    isActive: function isActive(machine) {
      return !!(machine.reference_id && ['cancelling', 'operational', 'finishing'].includes(machine.status));
    },
    isRunning: function isRunning(machine) {
      return !!(machine.reference_id && ['printing', 'resuming'].includes(machine.status));
    },
    isPaused: function isPaused(machine) {
      return !!(machine.reference_id && ['paused', 'pausing'].includes(machine.status));
    },
    isOffline: function isOffline(machine) {
      return !!(machine.reference_id && machine.status === 'offline');
    },
    isUnknown: function isUnknown(machine) {
      return !!(machine.reference_id && !machine.status);
    },
    onFiltered: function onFiltered(filteredItems) {
      // Trigger pagination to update the number of buttons/pages due to filtering
      this.totalRows = filteredItems.length;
      this.currentPage = 1;
    },
    deleteInstance: function deleteInstance(id) {
      var _this = this;

      var conf = confirm('Do you really want to delete this machine?');
      var index = this.collection.findIndex(function (x) {
        return x.id === id;
      });

      if (conf === true) {
        __WEBPACK_IMPORTED_MODULE_1_axios___default.a["delete"]('/api/machines/' + id).then(function (response) {
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
                return __WEBPACK_IMPORTED_MODULE_1_axios___default.a.get('/api/machines');

              case 3:
                response = _context.sent;
                // Remap JSON:API data to simple array with objects as its elements
                collectionData = response.data.data;
                this.collection = [];

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

                _context.next = 13;
                break;

              case 9:
                _context.prev = 9;
                _context.t0 = _context["catch"](0);
                console.log(_context.t0);
                return _context.abrupt("return", []);

              case 13:
              case "end":
                return _context.stop();
            }
          }
        }, _callee, this, [[0, 9]]);
      }));

      function getCollection() {
        return _getCollection.apply(this, arguments);
      }

      return getCollection;
    }(),
    moneyFormat: __WEBPACK_IMPORTED_MODULE_8__helpers__["b" /* moneyFormat */]
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-2e81f5d6\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/assets/js/components/CollectionTableMachines.vue":
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
                attrs: { href: "/machines/create", title: "Add a new Machine" }
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
          { staticClass: "ml-auto p-2" },
          [
            _c(
              "b-form-group",
              { attrs: { horizontal: "" } },
              [
                _c(
                  "b-input-group",
                  [
                    _c("b-form-input", {
                      attrs: { placeholder: "Search..." },
                      model: {
                        value: _vm.filter,
                        callback: function($$v) {
                          _vm.filter = $$v
                        },
                        expression: "filter"
                      }
                    }),
                    _vm._v(" "),
                    _c(
                      "b-input-group-append",
                      [
                        _c(
                          "b-btn",
                          {
                            attrs: { disabled: !_vm.filter },
                            on: {
                              click: function($event) {
                                _vm.filter = ""
                              }
                            }
                          },
                          [_vm._v("Clear")]
                        )
                      ],
                      1
                    )
                  ],
                  1
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
                  "b-link",
                  {
                    on: {
                      click: function($event) {
                        $event.stopPropagation()
                        return row.toggleDetails($event)
                      }
                    }
                  },
                  [_vm._v(_vm._s(row.value))]
                )
              ]
            }
          },
          {
            key: "hourlyRate",
            fn: function(row) {
              return [_vm._v(_vm._s(_vm.moneyFormat(row.value)) + "\n        ")]
            }
          },
          {
            key: "details",
            fn: function(row) {
              return [
                _c(
                  "b-link",
                  {
                    attrs: { title: "View more details" },
                    on: {
                      click: function($event) {
                        $event.stopPropagation()
                        return row.toggleDetails($event)
                      }
                    }
                  },
                  [
                    _c("svgicon", {
                      staticClass: "action-icon-sm",
                      class: { "svg-right": row.detailsShowing },
                      attrs: { icon: "details" }
                    })
                  ],
                  1
                )
              ]
            }
          },
          {
            key: "actions",
            fn: function(row) {
              return [
                _c(
                  "b-dropdown",
                  { attrs: { variant: "link", size: "sm", "no-caret": "" } },
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
                          href: "/machines/" + row.item.id + "/edit",
                          title: "Edit machine `" + row.item.name + "`"
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
                          title: "Delete machine `" + row.item.name + "`"
                        },
                        on: {
                          click: function($event) {
                            $event.stopPropagation()
                            return _vm.deleteInstance(row.item.id)
                          }
                        }
                      },
                      [_vm._v("Delete\n                ")]
                    )
                  ],
                  2
                )
              ]
            }
          },
          {
            key: "extra",
            fn: function(row) {
              return [
                row.item.reference_id
                  ? _c(
                      "b-badge",
                      {
                        directives: [
                          {
                            name: "b-tooltip",
                            rawName: "v-b-tooltip.hover",
                            modifiers: { hover: true }
                          }
                        ],
                        attrs: {
                          pill: "",
                          variant: "success",
                          title: "Paired with OctoPrint"
                        }
                      },
                      [_vm._v("OctoPrint\n            ")]
                    )
                  : _vm._e()
              ]
            }
          },
          {
            key: "status",
            fn: function(row) {
              return [
                _vm.isActive(row.item)
                  ? _c("status-indicator", {
                      directives: [
                        {
                          name: "b-tooltip",
                          rawName: "v-b-tooltip.hover",
                          modifiers: { hover: true }
                        }
                      ],
                      attrs: { active: "", title: "Ready" }
                    })
                  : _vm._e(),
                _vm._v(" "),
                _vm.isRunning(row.item)
                  ? _c("status-indicator", {
                      directives: [
                        {
                          name: "b-tooltip",
                          rawName: "v-b-tooltip.hover",
                          modifiers: { hover: true }
                        }
                      ],
                      attrs: {
                        positive: "",
                        pulse: "",
                        title: "Printing in progress..."
                      }
                    })
                  : _vm._e(),
                _vm._v(" "),
                _vm.isPaused(row.item)
                  ? _c("status-indicator", {
                      directives: [
                        {
                          name: "b-tooltip",
                          rawName: "v-b-tooltip.hover",
                          modifiers: { hover: true }
                        }
                      ],
                      attrs: { intermediary: "", title: "Paused" }
                    })
                  : _vm._e(),
                _vm._v(" "),
                _vm.isOffline(row.item)
                  ? _c("status-indicator", {
                      directives: [
                        {
                          name: "b-tooltip",
                          rawName: "v-b-tooltip.hover",
                          modifiers: { hover: true }
                        }
                      ],
                      attrs: { negative: "", title: "Offline / Disconnected" }
                    })
                  : _vm._e(),
                _vm._v(" "),
                _vm.isUnknown(row.item)
                  ? _c("status-indicator", {
                      directives: [
                        {
                          name: "b-tooltip",
                          rawName: "v-b-tooltip.hover",
                          modifiers: { hover: true }
                        }
                      ],
                      attrs: { title: "Unknown" }
                    })
                  : _vm._e()
              ]
            }
          },
          {
            key: "row-details",
            fn: function(row) {
              return [
                _c("b-card", { staticClass: "collection-row-detail" }, [
                  _c("div", { staticClass: "d-flex justify-content-start" }, [
                    _c("div", { staticClass: "p-2" }, [
                      _c("table", { staticClass: "table detail-table" }, [
                        _c("tbody", [
                          _c("tr", [
                            _c("th", { attrs: { scope: "row" } }, [
                              _vm._v("Lifespan")
                            ]),
                            _vm._v(" "),
                            _c("td", [
                              _vm._v(_vm._s(row.item.lifespan) + " years")
                            ])
                          ]),
                          _vm._v(" "),
                          _c("tr", [
                            _c("th", { attrs: { scope: "row" } }, [
                              _vm._v("Operating Hours")
                            ]),
                            _vm._v(" "),
                            _c("td", [_vm._v(_vm._s(row.item.operating_hours))])
                          ]),
                          _vm._v(" "),
                          _c("tr", [
                            _c("th", { attrs: { scope: "row" } }, [
                              _vm._v("Energy Consumption")
                            ]),
                            _vm._v(" "),
                            _c("td", [
                              _vm._v(_vm._s(row.item.energy_consumption) + " W")
                            ])
                          ])
                        ])
                      ])
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "p-2 pl-4" }, [
                      _c("table", { staticClass: "table detail-table" }, [
                        _c("tr", { staticClass: "money" }, [
                          _c("th", [_vm._v("Acquisition Cost")]),
                          _vm._v(" "),
                          _c("td", [
                            _vm._v(
                              _vm._s(_vm.moneyFormat(row.item.acquisition_cost))
                            )
                          ])
                        ]),
                        _vm._v(" "),
                        _c("tr", { staticClass: "money" }, [
                          _c("th", { attrs: { scope: "row" } }, [
                            _vm._v("Residual Value")
                          ]),
                          _vm._v(" "),
                          _c("td", [
                            _vm._v(
                              _vm._s(_vm.moneyFormat(row.item.residual_value))
                            )
                          ])
                        ]),
                        _vm._v(" "),
                        _c("tr", { staticClass: "money" }, [
                          _c("th", { attrs: { scope: "row" } }, [
                            _vm._v("Maintenance Cost")
                          ]),
                          _vm._v(" "),
                          _c("td", [
                            _vm._v(
                              _vm._s(_vm.moneyFormat(row.item.maintenance_cost))
                            )
                          ])
                        ]),
                        _vm._v(" "),
                        _c("tr", { staticClass: "money" }, [
                          _c("th", { attrs: { scope: "row" } }, [
                            _vm._v("Total Lifetime Cost")
                          ]),
                          _vm._v(" "),
                          _c("th", { staticClass: "footer" }, [
                            _vm._v(
                              "\n                                    " +
                                _vm._s(
                                  _vm.moneyFormat(row.item.lifetime_cost)
                                ) +
                                "\n                                "
                            )
                          ])
                        ])
                      ])
                    ])
                  ])
                ])
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
    require("vue-hot-reload-api")      .rerender("data-v-2e81f5d6", module.exports)
  }
}

/***/ }),

/***/ "./node_modules/vue-status-indicator/dist/vue-status-indicator.esm.js":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* WEBPACK VAR INJECTION */(function(global) {/* unused harmony export install */
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return StatusIndicator; });
function __vue_normalize__(e,t,_,n,i,a,r,s){var u=_||{};return u.__file="/Users/coderdiaz/github.com/coderdiaz/vue-status-indicator/src/components/StatusIndicator.vue",u.render||(u.render=e.render,u.staticRenderFns=e.staticRenderFns,u._compiled=!0,i&&(u.functional=!0)),u._scopeId=n,u}function __vue_create_injector__(){var e=document.head||document.getElementsByTagName("head")[0],t={},_="undefined"!=typeof navigator&&/msie [6-9]\\b/.test(navigator.userAgent.toLowerCase());return function(n,i){if(!document.querySelector('style[data-vue-ssr-id~="'+n+'"]')){var a=_?i.media||"default":n,r=t[a]||(t[a]={ids:[],parts:[],element:void 0});if(!r.ids.includes(n)){var s=i.source,u=r.ids.length;if(r.ids.push(n),_&&(r.element=r.element||document.querySelector("style[data-group="+a+"]")),!r.element){var d=r.element=document.createElement("style");d.type="text/css",i.media&&d.setAttribute("media",i.media),_&&(d.setAttribute("data-group",a),d.setAttribute("data-next-index","0")),e.appendChild(d)}if(_&&(u=parseInt(r.element.getAttribute("data-next-index")),r.element.setAttribute("data-next-index",u+1)),r.element.styleSheet)r.parts.push(s),r.element.styleSheet.cssText=r.parts.filter(Boolean).join("\n");else{var l=document.createTextNode(s),o=r.element.childNodes;o[u]&&r.element.removeChild(o[u]),o.length?r.element.insertBefore(l,o[u]):r.element.appendChild(l)}}}}}function install(e){install.installed||(install.installed=!0,e.component("StatusIndicator",StatusIndicator))}var script={name:"StatusIndicator"},__vue_script__=script,__vue_render__=function(){var e=this,t=e.$createElement;return(e._self._c||t)("span",{staticClass:"status-indicator"})},__vue_staticRenderFns__=[];__vue_render__._withStripped=!0;var __vue_template__=void 0!==__vue_render__?{render:__vue_render__,staticRenderFns:__vue_staticRenderFns__}:{},__vue_inject_styles__=void 0,__vue_scope_id__=void 0,__vue_module_identifier__=void 0,__vue_is_functional_template__=!1,StatusIndicator=__vue_normalize__(__vue_template__,__vue_inject_styles__,void 0===__vue_script__?{}:__vue_script__,__vue_scope_id__,__vue_is_functional_template__,__vue_module_identifier__,void 0!==__vue_create_injector__?__vue_create_injector__:function(){},"undefined"!=typeof __vue_create_injector_ssr__?__vue_create_injector_ssr__:function(){}),plugin={install:install},GlobalVue=null;"undefined"!=typeof window?GlobalVue=window.Vue:"undefined"!=typeof global&&(GlobalVue=global.Vue),GlobalVue&&GlobalVue.use(plugin);/* unused harmony default export */ var _unused_webpack_default_export = (plugin);

/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__("./node_modules/webpack/buildin/global.js")))

/***/ }),

/***/ "./resources/assets/js/components/CollectionTableMachines.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"@babel/preset-env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"]},\"forceAllTransforms\":true}]],\"plugins\":[\"@babel/plugin-proposal-object-rest-spread\",[\"@babel/plugin-transform-runtime\",{\"helpers\":false}],\"@babel/plugin-syntax-dynamic-import\"]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/assets/js/components/CollectionTableMachines.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-2e81f5d6\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/assets/js/components/CollectionTableMachines.vue")
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
Component.options.__file = "resources/assets/js/components/CollectionTableMachines.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-2e81f5d6", Component.options)
  } else {
    hotAPI.reload("data-v-2e81f5d6", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ })

});