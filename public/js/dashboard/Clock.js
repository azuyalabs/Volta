webpackJsonp([14],{"4awg":function(t,e,r){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var i=r("wFCU");e.default={props:["position","modifiers"],computed:{tilePosition:function(){return"grid-area: ".concat(Object(i.h)(this.position))},tileLook:function(){return Object(i.a)("tile",this.modifiers)}}}},JfQd:function(t,e){t.exports={render:function(){var t=this.$createElement;return(this._self._c||t)("div",{class:this.tileLook,style:this.tilePosition},[this._t("default")],2)},staticRenderFns:[]}},kmrF:function(t,e,r){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var i=r("nho+"),o=r.n(i),n=r("xNPZ"),a=r.n(n);e.default={i18n:{messages:{"ja-JP":{message:{"Asia/Tokyo":"東京","Europe/Amsterdam":"ヨーロッパ/アムステルダム","Europe/Rome":"ヨーロッパ/ローマ","America/New_York":"アメリカ/ニューヨーク","America/Chicago":"アメリカ/シカゴ"}},"en-US":{message:{"Asia/Tokyo":"Asia/Tokyo","Europe/Amsterdam":"Europe/Amsterdam","Europe/Rome":"Europe/Rome","America/New_York":"America/New York","America/Chicago":"America/Chicago"}}}},components:{Tile:o.a},props:{position:{type:String},dateFormat:{type:String,required:!1,default:"LL"}},data:function(){return{time:"",diameter:150,type:"analog"}},computed:{radius:function(){return this.diameter/2},hour:function(){return 30*(this.time.hours()%12+this.time.minutes()/60)},minute:function(){return 6*this.time.minutes()},seconds:function(){return 6*this.time.seconds()}},created:function(){this.type=window.Volta.preferences.dashboard.clock.type,this.timeZone=Intl.DateTimeFormat().resolvedOptions().timeZone,this.refreshTime(),setInterval(this.refreshTime,1e3)},methods:{refreshTime:function(){this.time=a.a.tz(this.timeZone).locale(window.Volta.locale)},hourTick:function(t){return"rotate("+30*t+","+this.radius+","+this.radius+")"}}}},"nho+":function(t,e,r){var i=r("VU/8")(r("4awg"),r("JfQd"),!1,null,null,null);t.exports=i.exports},qDe2:function(t,e){t.exports={render:function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("tile",{attrs:{position:t.position,modifiers:"clock"}},[r("section",{staticClass:"clock-main"},[r("div",{staticClass:"clock-main__timezone"},[t._v(t._s(t.$t("message."+this.timeZone)))]),t._v(" "),"analog"===t.type?r("div",{staticClass:"clock-main__clock"},[r("svg",{attrs:{height:t.diameter,viewBox:"0 0 150 150",version:"1.2",xmlns:"http://www.w3.org/2000/svg"}},[r("circle",{staticClass:"clock__face",attrs:{r:"55",cx:t.radius,cy:t.radius}}),t._v(" "),r("line",{staticClass:"clock__hand-hour",attrs:{x1:t.radius,y1:t.radius+8,x2:t.radius,y2:t.radius-18,transform:"rotate("+t.hour+","+t.radius+","+t.radius+")"}}),t._v(" "),r("line",{staticClass:"clock__hand-minute",attrs:{x1:t.radius,y1:t.radius+8,x2:t.radius,y2:t.radius-30,transform:"rotate("+t.minute+","+t.radius+","+t.radius+")"}}),t._v(" "),r("line",{staticClass:"clock__hand-second",attrs:{x1:t.radius,y1:t.radius+12,x2:t.radius,y2:t.radius-35,transform:"rotate("+t.seconds+","+t.radius+","+t.radius+")"}}),t._v(" "),r("circle",{staticClass:"clock__hand-second-center",attrs:{r:"5",cx:t.radius,cy:t.radius}}),t._v(" "),r("g",{staticClass:"clock__face-ticks",attrs:{id:"hour_ticks"}},[t._l(12,function(e){return[r("line",{attrs:{x1:75,y1:t.radius-46,x2:t.radius,y2:t.radius-42,transform:"rotate("+30*e+","+t.radius+","+t.radius+")"}})]})],2)])]):t._e(),t._v(" "),"digital"===t.type?r("div",{staticClass:"clock-main__clock clock-main__clock--digital"},[t._v("\n            "+t._s(t.time.format("LT"))+"\n        ")]):t._e()]),t._v(" "),r("section",{staticClass:"clock-date",domProps:{textContent:t._s(t.time.format(t.dateFormat))}})])},staticRenderFns:[]}},wFCU:function(t,e,r){"use strict";e.f=function(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:7,r=o()(t).tz(Intl.DateTimeFormat().resolvedOptions().timeZone).locale(window.Volta.locale);return o()().subtract(e,"days").isSameOrBefore(r)},e.e=function(t){return a()(o.a),o.a.duration(t,"seconds").locale(window.Volta.locale).format("dd:hh:mm:ss",{trim:!1})},e.d=function(t){var e=o()().add(t,"s");return e.locale(window.Volta.locale),e.format("LTS")},e.g=function(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:2;return new Intl.NumberFormat(window.Volta.locale,{maximumFractionDigits:e}).format(t)},e.b=function(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"D-M-Y";return o.a.tz(t,"UTC").tz(Intl.DateTimeFormat().resolvedOptions().timeZone).locale(window.Volta.locale).format(e)},e.c=function(t){var e=o()(t).tz(Intl.DateTimeFormat().resolvedOptions().timeZone).locale(window.Volta.locale);if(o()().isSame(e,"d"))return"Today";if(o()().isAfter(e))return e.fromNow(!1);return"in "+e.toNow(!0)},e.a=function(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:[];Array.isArray(e)||(e=e.split(" "));return e=e.map(function(e){return"".concat(t,"--").concat(e)}),[t].concat((r=e,function(t){if(Array.isArray(t)){for(var e=0,r=new Array(t.length);e<t.length;e++)r[e]=t[e];return r}}(r)||function(t){if(Symbol.iterator in Object(t)||"[object Arguments]"===Object.prototype.toString.call(t))return Array.from(t)}(r)||function(){throw new TypeError("Invalid attempt to spread non-iterable instance")}()));var r},e.h=function(t){var e=(n=t.toLowerCase().split(":"),a=2,function(t){if(Array.isArray(t))return t}(n)||function(t,e){var r=[],i=!0,o=!1,n=void 0;try{for(var a,s=t[Symbol.iterator]();!(i=(a=s.next()).done)&&(r.push(a.value),!e||r.length!==e);i=!0);}catch(t){o=!0,n=t}finally{try{i||null==s.return||s.return()}finally{if(o)throw n}}return r}(n,a)||function(){throw new TypeError("Invalid attempt to destructure non-iterable instance")}()),r=e[0],i=e[1],o=void 0===i?null:i;var n,a;if(2!==r.length||o&&2!==o.length)return;var c="".concat(r[1]," / ").concat(s(r[0]));return o?"".concat(c," / ").concat(Number(o[1])+1," / ").concat(s(o[0])+1):c};var i=r("xNPZ"),o=r.n(i),n=r("SdwT"),a=r.n(n);function s(t){var e=t.toLowerCase().charCodeAt(0)-96;return e<1?1:e}},zrwA:function(t,e,r){var i=r("VU/8")(r("kmrF"),r("qDe2"),!1,null,null,null);t.exports=i.exports}});