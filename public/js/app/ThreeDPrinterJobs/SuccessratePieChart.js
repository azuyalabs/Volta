webpackJsonp([10],{"3Dan":function(t,e,i){var n=i("VU/8")(i("W75R"),i("fGyN"),!1,null,null,null);t.exports=n.exports},"5RBq":function(t,e,i){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),i.d(e,"messages",function(){return n});var n={"en-US":{main_title:"Success Rate",refresh:"Refresh",footer_text:"Based on print jobs made in the last year.",labels:{success:"Success",failed:"Failed"}}}},FUjU:function(t,e,i){i("QEfS").register({mini_refresh_circle:{width:24,height:24,viewBox:"0 0 24 24",data:'<circle pid="0" cx="12" cy="12" r="10"/>'}})},SYh3:function(t,e,i){var n=i("Y8dB");"string"==typeof n&&(n=[[t.i,n,""]]);var a={transform:void 0};i("MTIv")(n,a);n.locals&&(t.exports=n.locals)},W75R:function(t,e,i){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var n=i("En79"),a=i.n(n),r=i("mtWM"),s=i.n(r),o=i("pyJd"),l=i("ZZvs"),c=i.n(l),u=i("SYh3"),d=(i.n(u),i("FUjU"));i.n(d);function f(t,e,i,n,a,r,s){try{var o=t[r](s),l=o.value}catch(t){return void i(t)}o.done?e(l):Promise.resolve(l).then(n,a)}e.default={i18n:i("5RBq"),components:{HalfCircleSpinner:o.HalfCircleSpinner,Loading:c.a},data:function(){return{isLoading:!1,fullPage:!1,totalJobs:1,sections:[]}},mounted:function(){this.getData()},computed:{ratio:function(){for(var t=0,e=0;e<this.sections.length;e++)this.sections[e]&&"Success"===this.sections[e].label&&(t=this.sections[e].value);return Math.round(t/this.totalJobs*100)}},methods:{getData:function(){var t,e=(t=a.a.mark(function t(){var e,i,n;return a.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return this.isLoading=!0,t.prev=1,t.next=4,s.a.get("/api/threedprinterjobs/success_rate");case 4:if(e=t.sent,this.totalJobs=0,this.sections=[],e.data.length>0)for(i=0;i<e.data.length;i++)this.totalJobs+=parseInt(e.data[i].value),(n={value:parseInt(e.data[i].value)}).color="success"===e.data[i].status?"#4bd28f":"#ff4d4d",n.label="success"===e.data[i].status?this.$t("labels.success"):this.$t("labels.failed"),this.sections.push(n);else this.totalJobs=1;this.isLoading=!1,t.next=15;break;case 11:return t.prev=11,t.t0=t.catch(1),console.log(t.t0),t.abrupt("return",[]);case 15:case"end":return t.stop()}},t,this,[[1,11]])}),function(){var e=this,i=arguments;return new Promise(function(n,a){var r=t.apply(e,i);function s(t){f(r,n,a,s,o,"next",t)}function o(t){f(r,n,a,s,o,"throw",t)}s(void 0)})});return function(){return e.apply(this,arguments)}}()}}},Y8dB:function(t,e,i){(t.exports=i("FZ+f")(!1)).push([t.i,".vld-overlay{bottom:0;left:0;position:absolute;right:0;top:0;align-items:center;display:none;justify-content:center;overflow:hidden;z-index:1}.vld-overlay.is-active{display:flex}.vld-overlay.is-full-page{z-index:999;position:fixed}.vld-overlay .vld-background{bottom:0;left:0;position:absolute;right:0;top:0;background:#fff;opacity:.5}.vld-overlay .vld-icon,.vld-parent{position:relative}",""])},ZZvs:function(t,e,i){var n;"undefined"!=typeof self&&self,n=function(){return function(t){var e={};function i(n){if(e[n])return e[n].exports;var a=e[n]={i:n,l:!1,exports:{}};return t[n].call(a.exports,a,a.exports,i),a.l=!0,a.exports}return i.m=t,i.c=e,i.d=function(t,e,n){i.o(t,e)||Object.defineProperty(t,e,{enumerable:!0,get:n})},i.r=function(t){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},i.t=function(t,e){if(1&e&&(t=i(t)),8&e)return t;if(4&e&&"object"==typeof t&&t&&t.__esModule)return t;var n=Object.create(null);if(i.r(n),Object.defineProperty(n,"default",{enumerable:!0,value:t}),2&e&&"string"!=typeof t)for(var a in t)i.d(n,a,function(e){return t[e]}.bind(null,a));return n},i.n=function(t){var e=t&&t.__esModule?function(){return t.default}:function(){return t};return i.d(e,"a",e),e},i.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},i.p="",i(i.s=1)}([function(t,e,i){},function(t,e,i){"use strict";i.r(e);var n="undefined"!=typeof window?window.HTMLElement:Object,a={mounted:function(){document.addEventListener("focusin",this.focusIn)},methods:{focusIn:function(t){if(this.isActive&&t.target!==this.$el&&!this.$el.contains(t.target)){var e=this.container?this.container:this.isFullPage?null:this.$el.parentElement;(this.isFullPage||e&&e.contains(t.target))&&(t.preventDefault(),this.$el.focus())}}},beforeDestroy:function(){document.removeEventListener("focusin",this.focusIn)}};function r(t,e,i,n,a,r,s,o){var l,c="function"==typeof t?t.options:t;if(e&&(c.render=e,c.staticRenderFns=i,c._compiled=!0),n&&(c.functional=!0),r&&(c._scopeId="data-v-"+r),s?(l=function(t){(t=t||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(t=__VUE_SSR_CONTEXT__),a&&a.call(this,t),t&&t._registeredComponents&&t._registeredComponents.add(s)},c._ssrRegister=l):a&&(l=o?function(){a.call(this,this.$root.$options.shadowRoot)}:a),l)if(c.functional){c._injectStyles=l;var u=c.render;c.render=function(t,e){return l.call(e),u(t,e)}}else{var d=c.beforeCreate;c.beforeCreate=d?[].concat(d,l):[l]}return{exports:t,options:c}}var s=r({name:"spinner",props:{color:{type:String,default:"#000"},height:{type:Number,default:64},width:{type:Number,default:64}}},function(){var t=this.$createElement,e=this._self._c||t;return e("svg",{attrs:{viewBox:"0 0 38 38",xmlns:"http://www.w3.org/2000/svg",width:this.width,height:this.height,stroke:this.color}},[e("g",{attrs:{fill:"none","fill-rule":"evenodd"}},[e("g",{attrs:{transform:"translate(1 1)","stroke-width":"2"}},[e("circle",{attrs:{"stroke-opacity":".25",cx:"18",cy:"18",r:"18"}}),e("path",{attrs:{d:"M36 18c0-9.94-8.06-18-18-18"}},[e("animateTransform",{attrs:{attributeName:"transform",type:"rotate",from:"0 18 18",to:"360 18 18",dur:"0.8s",repeatCount:"indefinite"}})],1)])])])},[],!1,null,null,null).exports,o=r({name:"dots",props:{color:{type:String,default:"#000"},height:{type:Number,default:240},width:{type:Number,default:60}}},function(){var t=this.$createElement,e=this._self._c||t;return e("svg",{attrs:{viewBox:"0 0 120 30",xmlns:"http://www.w3.org/2000/svg",fill:this.color,width:this.width,height:this.height}},[e("circle",{attrs:{cx:"15",cy:"15",r:"15"}},[e("animate",{attrs:{attributeName:"r",from:"15",to:"15",begin:"0s",dur:"0.8s",values:"15;9;15",calcMode:"linear",repeatCount:"indefinite"}}),e("animate",{attrs:{attributeName:"fill-opacity",from:"1",to:"1",begin:"0s",dur:"0.8s",values:"1;.5;1",calcMode:"linear",repeatCount:"indefinite"}})]),e("circle",{attrs:{cx:"60",cy:"15",r:"9","fill-opacity":"0.3"}},[e("animate",{attrs:{attributeName:"r",from:"9",to:"9",begin:"0s",dur:"0.8s",values:"9;15;9",calcMode:"linear",repeatCount:"indefinite"}}),e("animate",{attrs:{attributeName:"fill-opacity",from:"0.5",to:"0.5",begin:"0s",dur:"0.8s",values:".5;1;.5",calcMode:"linear",repeatCount:"indefinite"}})]),e("circle",{attrs:{cx:"105",cy:"15",r:"15"}},[e("animate",{attrs:{attributeName:"r",from:"15",to:"15",begin:"0s",dur:"0.8s",values:"15;9;15",calcMode:"linear",repeatCount:"indefinite"}}),e("animate",{attrs:{attributeName:"fill-opacity",from:"1",to:"1",begin:"0s",dur:"0.8s",values:"1;.5;1",calcMode:"linear",repeatCount:"indefinite"}})])])},[],!1,null,null,null).exports,l=r({name:"bars",props:{color:{type:String,default:"#000"},height:{type:Number,default:40},width:{type:Number,default:40}}},function(){var t=this.$createElement,e=this._self._c||t;return e("svg",{attrs:{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 30 30",height:this.height,width:this.width,fill:this.color}},[e("rect",{attrs:{x:"0",y:"13",width:"4",height:"5"}},[e("animate",{attrs:{attributeName:"height",attributeType:"XML",values:"5;21;5",begin:"0s",dur:"0.6s",repeatCount:"indefinite"}}),e("animate",{attrs:{attributeName:"y",attributeType:"XML",values:"13; 5; 13",begin:"0s",dur:"0.6s",repeatCount:"indefinite"}})]),e("rect",{attrs:{x:"10",y:"13",width:"4",height:"5"}},[e("animate",{attrs:{attributeName:"height",attributeType:"XML",values:"5;21;5",begin:"0.15s",dur:"0.6s",repeatCount:"indefinite"}}),e("animate",{attrs:{attributeName:"y",attributeType:"XML",values:"13; 5; 13",begin:"0.15s",dur:"0.6s",repeatCount:"indefinite"}})]),e("rect",{attrs:{x:"20",y:"13",width:"4",height:"5"}},[e("animate",{attrs:{attributeName:"height",attributeType:"XML",values:"5;21;5",begin:"0.3s",dur:"0.6s",repeatCount:"indefinite"}}),e("animate",{attrs:{attributeName:"y",attributeType:"XML",values:"13; 5; 13",begin:"0.3s",dur:"0.6s",repeatCount:"indefinite"}})])])},[],!1,null,null,null).exports,c=r({name:"vue-loading",mixins:[a],props:{active:Boolean,programmatic:Boolean,container:[Object,Function,n],isFullPage:{type:Boolean,default:!0},transition:{type:String,default:"fade"},canCancel:Boolean,onCancel:{type:Function,default:function(){}},color:String,backgroundColor:String,opacity:Number,width:Number,height:Number,zIndex:Number,loader:{type:String,default:"spinner"}},data:function(){return{isActive:this.active}},components:{Spinner:s,Dots:o,Bars:l},beforeMount:function(){this.programmatic&&(this.container?(this.isFullPage=!1,this.container.appendChild(this.$el)):document.body.appendChild(this.$el))},mounted:function(){this.programmatic&&(this.isActive=!0),document.addEventListener("keyup",this.keyPress)},methods:{cancel:function(){this.canCancel&&this.isActive&&(this.hide(),this.onCancel.apply(null,arguments))},hide:function(){var t=this;this.$emit("hide"),this.$emit("update:active",!1),this.programmatic&&(this.isActive=!1,setTimeout(function(){var e;t.$destroy(),void 0!==(e=t.$el).remove?e.remove():e.parentNode.removeChild(e)},150))},keyPress:function(t){27===t.keyCode&&this.cancel()}},watch:{active:function(t){this.isActive=t}},beforeDestroy:function(){document.removeEventListener("keyup",this.keyPress)}},function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("transition",{attrs:{name:t.transition}},[i("div",{directives:[{name:"show",rawName:"v-show",value:t.isActive,expression:"isActive"}],staticClass:"vld-overlay is-active",class:{"is-full-page":t.isFullPage},style:{zIndex:this.zIndex},attrs:{tabindex:"0","aria-busy":t.isActive,"aria-label":"Loading"}},[i("div",{staticClass:"vld-background",style:{background:this.backgroundColor,opacity:this.opacity},on:{click:function(e){return e.preventDefault(),t.cancel(e)}}}),i("div",{staticClass:"vld-icon"},[t._t("before"),t._t("default",[i(t.loader,{tag:"component",attrs:{color:t.color,width:t.width,height:t.height}})]),t._t("after")],2)])])},[],!1,null,null,null).exports;i(0),c.install=function(t){var e=function(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{},i=arguments.length>2&&void 0!==arguments[2]?arguments[2]:{};return{show:function(){var n=arguments.length>0&&void 0!==arguments[0]?arguments[0]:e,a=arguments.length>1&&void 0!==arguments[1]?arguments[1]:i,r=Object.assign({},e,n,{programmatic:!0}),s=new(t.extend(c))({el:document.createElement("div"),propsData:r}),o=Object.assign({},i,a);return Object.keys(o).map(function(t){s.$slots[t]=o[t]}),s}}}(t,arguments.length>1&&void 0!==arguments[1]?arguments[1]:{},arguments.length>2&&void 0!==arguments[2]?arguments[2]:{});t.$loading=e,t.prototype.$loading=e},e.default=c}]).default},t.exports=n()},fGyN:function(t,e){t.exports={render:function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("div",{staticClass:"card card-metric"},[i("loading",{attrs:{active:t.isLoading,"can-cancel":!1,"is-full-page":t.fullPage,opacity:.9},on:{"update:active":function(e){t.isLoading=e}}},[i("half-circle-spinner",{attrs:{"animation-duration":1e3,size:30,color:"#f5b180"}})],1),t._v(" "),i("div",{staticClass:"container-fluid row pr-0"},[i("div",{staticClass:"card-title pl-2"},[t._v(t._s(t.$t("main_title")))]),t._v(" "),i("div",{staticClass:"ml-auto"},[i("b-link",{attrs:{href:"#",title:t.$t("refresh")},on:{click:function(e){return e.preventDefault(),t.getData(e)}}},[i("svgicon",{staticClass:"mini_refresh_data",attrs:{icon:"mini_refresh_circle",title:t.$t("refresh")}})],1)],1)]),t._v(" "),i("div",{staticClass:"card-body pt-0"},[i("vc-donut",{attrs:{sections:t.sections,size:32,unit:"%",thickness:20,total:parseInt(t.totalJobs),hasLegend:"",legendPlacement:"right"}},[i("span",{staticClass:"chart-donut-center-text"},[t._v(t._s(t.ratio)+"%")])])],1),t._v(" "),i("div",{staticClass:"footer-text"},[t._v("\n        "+t._s(t.$t("footer_text"))+"\n    ")])],1)},staticRenderFns:[]}}});