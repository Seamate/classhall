/******/(()=>{// webpackBootstrap
/******/var e={
/***/1455:
/***/e=>{"use strict";e.exports=window.wp.apiFetch}
/***/,
/***/2192:
/***/(e,t,s)=>{"use strict";
/**
 * @license React
 * react-jsx-runtime.production.min.js
 *
 * Copyright (c) Facebook, Inc. and its affiliates.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */var r=s(51609),n=Symbol.for("react.element"),o=Symbol.for("react.fragment"),i=Object.prototype.hasOwnProperty,l=r.__SECRET_INTERNALS_DO_NOT_USE_OR_YOU_WILL_BE_FIRED.ReactCurrentOwner,a={key:!0,ref:!0,__self:!0,__source:!0};function c(e,t,s){var r,o={},c=null,d=null;for(r in void 0!==s&&(c=""+s),void 0!==t.key&&(c=""+t.key),void 0!==t.ref&&(d=t.ref),t)i.call(t,r)&&!a.hasOwnProperty(r)&&(o[r]=t[r]);if(e&&e.defaultProps)for(r in t=e.defaultProps)void 0===o[r]&&(o[r]=t[r]);return{$$typeof:n,type:e,key:c,ref:d,props:o,_owner:l.current}}t.Fragment=o,t.jsx=c,t.jsxs=c}
/***/,
/***/2976:
/***/(e,t,s)=>{"use strict";s.r(t),
/* harmony export */s.d(t,{
/* harmony export */getLogsBySeverity:()=>/* binding */l
/* harmony export */});
/* harmony import */var r=s(32406),n=s(77505),o=s(97584),i=s(74153);
/* harmony import */
/**
 * Internal dependencies
 */
const l=(0,n/* .composeFetchAction */.z6)(null,(function*(e){if(e)return yield(0,o.fetchFromAPI)({path:(0,i/* .buildJobEndpointUrl */.O)(e,["logs"])})}),r/* .SET_IMPORT_LOG */.Sc,r/* .ERROR_FETCH_IMPORT_LOG */.Nz);
/***/},
/***/4452:
/***/(e,t)=>{var s;
/*!
	Copyright (c) 2018 Jed Watson.
	Licensed under the MIT License (MIT), see
	http://jedwatson.github.io/classnames
*/
/* global define */!function(){"use strict";var r={}.hasOwnProperty;function n(){for(var e="",t=0;t<arguments.length;t++){var s=arguments[t];s&&(e=i(e,o(s)))}return e}function o(e){if("string"==typeof e||"number"==typeof e)return e;if("object"!=typeof e)return"";if(Array.isArray(e))return n.apply(null,e);if(e.toString!==Object.prototype.toString&&!e.toString.toString().includes("[native code]"))return e.toString();var t="";for(var s in e)r.call(e,s)&&e[s]&&(t=i(t,s));return t}function i(e,t){return t?e?e+" "+t:e+t:e}e.exports?(n.default=n,e.exports=n):void 0===(s=function(){return n}.apply(t,[]))||(e.exports=s)}()}
/***/,
/***/5573:
/***/e=>{"use strict";e.exports=window.wp.primitives}
/***/,
/***/8141:
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */A:()=>i
/* harmony export */});
/* harmony import */var r=s(47143),n=s(29491),o=s(12703);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/* harmony default export */const i=(0,n.compose)((0,r.withSelect)((e=>{const t=e("sensei/import");return{jobId:t.getJobId(),state:t.getStepData("upload")}})),(0,r.withDispatch)((e=>{const{deleteLevelFile:t,uploadFileForLevel:s,throwEarlyUploadError:r}=e("sensei/import");return{deleteLevelFile:t,uploadFileForLevel:s,throwEarlyUploadError:r}})))(o/* .UploadLevels */.n);
/***/},
/***/12703:
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */n:()=>/* binding */c
/* harmony export */});
/* harmony import */var r=s(56427),n=s(56009),o=s(27723),i=s(75808),l=s(27371),a=s(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Helper method to upload a file.
 *
 * @param {string}   jobId                 The job identifier.
 * @param {FileList} files                 The files of the input.
 * @param {string}   levelKey              The level key.
 * @param {Function} uploadFileForLevel    Callback for action to upload file.
 * @param {Function} throwEarlyUploadError Callback for throwing an early upload error.
 */
const c=({jobId:e,state:t,uploadFileForLevel:s,throwEarlyUploadError:c,deleteLevelFile:d})=>(0,a.jsx)("ol",{children:l/* .levels */.y.map((l=>{const u=t[l.key],p=(e=>e.hasError?(0/* .Notice */,a.jsx)(i.$,{message:e.errorMsg,isError:!0}):e.isUploaded?(0/* .Notice */,a.jsx)(i.$,{message:e.filename}):void 0)(u);let m;
/* eslint-disable jsx-a11y/label-has-for */
return u.isDeleting?m=(0,a.jsx)("div",{className:"sensei-upload-file-line__delete-button-wrapper",children:(0,a.jsx)(r.Spinner,{})}):u.isUploaded&&(m=(0,a.jsx)("div",{className:"sensei-upload-file-line__delete-button-wrapper",children:(0,a.jsx)(r.Button,{icon:n/* ["default"] */.A,label:(0,o.__)("Delete File","sensei-lms"),onClick:()=>d(e,l.key),disabled:u.isDeleting})})),(0,a.jsxs)("li",{className:"sensei-upload-file-line sensei-data-port-step__line",children:[(0,a.jsx)("label",{className:"sensei-upload-file-line__description",htmlFor:`sensei-upload-file-line-${l.key}`,children:l.description}),(0,a.jsx)(r.FormFileUpload,{isSecondary:!0,id:`sensei-upload-file-line-${l.key}`,accept:[".csv",".txt"],disabled:u.isUploading||u.isDeleting,onChange:t=>((e,t,s,r,n)=>{if(t.length<1)return;const i=t[0];if(!["csv","txt"].includes(i.name.split(".").pop()))return void n(s,(0,o.__)("Only CSV files are supported.","sensei-lms"));const l=new FormData;l.append("file",i),r(e,s,l)})(e,t.target.files,l.key,s,c),children:u.isUploading?(0,o.__)("Uploading…","sensei-lms"):(0,o.__)("Upload","sensei-lms")},u.isUploading),(p||m)&&(0,a.jsxs)("div",{className:"sensei-upload-file-line__info",children:[p,m]})]},l.key);
/* eslint-enable */}))});
/**
 * A component which displays a list of upload levels. Each level has each own description, upload button and a
 * placeholder for messages.
 *
 * @param {Object}   input                       UploadLevels input.
 * @param {number}   input.jobId                 The job id.
 * @param {Object}   input.state                 The import state.
 * @param {Function} input.uploadFileForLevel    Callback for action to upload file.
 * @param {Function} input.throwEarlyUploadError Callback for throwing an early upload error.
 * @param {Function} input.deleteLevelFile       The import state.
 */}
/***/,
/***/12742:
/***/e=>{"use strict";function t(e){
// {{/example}}
return e.match(/^\{\{\//)?{type:"componentClose",value:e.replace(/\W/g,"")}:
// {{example /}}
e.match(/\/\}\}$/)?{type:"componentSelfClosing",value:e.replace(/\W/g,"")}:
// {{example}}
e.match(/^\{\{/)?{type:"componentOpen",value:e.replace(/\W/g,"")}:{type:"string",value:e}}e.exports=function(e){// split to components and strings
return e.split(/(\{\{\/?\s*\w+\s*\/?\}\})/g).map(t)}}
//# sourceMappingURL=tokenize.js.map
/***/,
/***/13266:
/***/(e,t,s)=>{"use strict";
/**
 * Copyright (c) 2015-present, Facebook, Inc.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */var r=s(51609),n="function"==typeof Symbol&&Symbol.for&&Symbol.for("react.element")||60103,o=s(98615),i=s(41634),l=s(94942),a="function"==typeof Symbol&&Symbol.iterator;function c(e,t){
// Do some typechecking here since we call this blindly. We want to ensure
// that we don't block potential future ES APIs.
return e&&"object"==typeof e&&null!=e.key?(s=e.key,r={"=":"=0",":":"=2"},"$"+(""+s).replace(/[=:]/g,(function(e){return r[e]}))):t.toString(36);
// Implicit key determined by the index in the set
var s,r}function d(e,t,s,r){var o,l=typeof e;if("undefined"!==l&&"boolean"!==l||(
// All of the above are perceived as null.
e=null),null===e||"string"===l||"number"===l||
// The following is inlined from ReactElement. This means we can optimize
// some checks. React Fiber also inlines this logic for similar purposes.
"object"===l&&e.$$typeof===n)return s(r,e,
// If it's the only child, treat the name as if it was wrapped in an array
// so that it's consistent if the number of children grows.
""===t?"."+c(e,0):t),1;var u=0,p=""===t?".":t+":";// Count of children found in the current subtree.
if(Array.isArray(e))for(var m=0;m<e.length;m++)u+=d(o=e[m],p+c(o,m),s,r);else{var h=// Before Symbol spec.
function(e){var t=e&&(a&&e[a]||e["@@iterator"]);if("function"==typeof t)return t}(e);if(h){0;for(var g,f=h.call(e),y=0;!(g=f.next()).done;)u+=d(o=g.value,p+c(o,y++),s,r)}else if("object"===l){0;var _=""+e;i(!1,"Objects are not valid as a React child (found: %s).%s","[object Object]"===_?"object with keys {"+Object.keys(e).join(", ")+"}":_,"")}}return u}var u=/\/+/g;function p(e){return(""+e).replace(u,"$&/")}var m,h,g=f,f=function(e){var t=this;if(t.instancePool.length){var s=t.instancePool.pop();return t.call(s,e),s}return new t(e)},y=function(e){var t=this;i(e instanceof t,"Trying to release an instance into a pool of a different type."),e.destructor(),t.instancePool.length<t.poolSize&&t.instancePool.push(e)};function _(e,t,s,r){this.result=e,this.keyPrefix=t,this.func=s,this.context=r,this.count=0}function v(e,t,s){var n,i,l=e.result,a=e.keyPrefix,c=e.func,d=e.context,u=c.call(d,t,e.count++);Array.isArray(u)?x(u,l,s,o.thatReturnsArgument):null!=u&&(r.isValidElement(u)&&(n=u,i=
// Keep both the (mapped) and old keys if they differ, just as
// traverseAllChildren used to do for objects as children
a+(!u.key||t&&t.key===u.key?"":p(u.key)+"/")+s,u=r.cloneElement(n,{key:i},void 0!==n.props?n.props.children:void 0)),l.push(u))}function x(e,t,s,r,n){var o="";null!=s&&(o=p(s)+"/");var i=_.getPooled(t,o,r,n);!function(e,t,s){null==e||d(e,"",t,s)}(e,v,i),_.release(i)}_.prototype.destructor=function(){this.result=null,this.keyPrefix=null,this.func=null,this.context=null,this.count=0},m=function(e,t,s,r){var n=this;if(n.instancePool.length){var o=n.instancePool.pop();return n.call(o,e,t,s,r),o}return new n(e,t,s,r)},(h=_).instancePool=[],h.getPooled=m||g,h.poolSize||(h.poolSize=10),h.release=y;e.exports=function(e){if("object"!=typeof e||!e||Array.isArray(e))return l(!1,"React.addons.createFragment only accepts a single object. Got: %s",e),e;if(r.isValidElement(e))return l(!1,"React.addons.createFragment does not accept a ReactElement without a wrapper object."),e;i(1!==e.nodeType,"React.addons.createFragment(...): Encountered an invalid child; DOM elements are not valid children of React components.");var t=[];for(var s in e)x(e[s],t,s,o.thatReturnsArgument);return t}}
/***/,
/***/14995:
/***/(e,t,s)=>{"use strict";var r="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},n=l(s(51609)),o=l(s(13266)),i=l(s(12742));
/**
                                                                                                                                                                                                                                                                               * External Dependencies
                                                                                                                                                                                                                                                                               */
/**
 * Internal Dependencies
 */function l(e){return e&&e.__esModule?e:{default:e}}var a=void 0;function c(e,t){var s,i,l,d,u,p,m,h,g=[],f={};for(p=0;p<e.length;p++)if("string"!==(u=e[p]).type){
// component node should at least be set
if(!t.hasOwnProperty(u.value)||void 0===t[u.value])throw new Error("Invalid interpolation, missing component node: `"+u.value+"`");
// should be either ReactElement or null (both type "object"), all other types deprecated
if("object"!==r(t[u.value]))throw new Error("Invalid interpolation, component node must be a ReactElement or null: `"+u.value+"`","\n> "+a);
// we should never see a componentClose token in this loop
if("componentClose"===u.type)throw new Error("Missing opening component token: `"+u.value+"`");if("componentOpen"===u.type){s=t[u.value],l=p;break}
// componentSelfClosing token
g.push(t[u.value])}else g.push(u.value);return s&&(d=function(e,t){var s,r,n=t[e],o=0;for(r=e+1;r<t.length;r++)if((s=t[r]).value===n.value){if("componentOpen"===s.type){o++;continue}if("componentClose"===s.type){if(0===o)return r;o--}}
// if we get this far, there was no matching close token
throw new Error("Missing closing component token `"+n.value+"`")}(l,e),m=c(e.slice(l+1,d),t),i=n.default.cloneElement(s,{},m),g.push(i),d<e.length-1&&(h=c(e.slice(d+1),t),g=g.concat(h))),1===g.length?g[0]:(g.forEach((function(e,t){e&&(f["interpolation-child-"+t]=e)})),(0,o.default)(f))}t.A=function(e){var t=e.mixedString,s=e.components,n=e.throwErrors;if(a=t,!s)return t;if("object"!==(void 0===s?"undefined":r(s))){if(n)throw new Error("Interpolation Error: unable to process `"+t+"` because components is not an object");return t}var o=(0,i.default)(t);try{return c(o,s)}catch(e){if(n)throw new Error("Interpolation Error: unable to process `"+t+"` because of error `"+e.message+"`");return t}}}
//# sourceMappingURL=index.js.map
/***/,
/***/20575:
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */A:()=>o
/* harmony export */});
/* harmony import */var r=s(86087),n=s(47143);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Progress polling hook.
 */
const o=()=>{const{pollJobProgress:e}=(0,n.useDispatch)("sensei/import"),t=(0,n.useSelect)((e=>e("sensei/import").getJobId()));(0,r.useEffect)((()=>{e(t)}),[e,t])};
/* harmony default export */}
/***/,
/***/27371:
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */y:()=>/* binding */n
/* harmony export */});
/* harmony import */var r=s(27723);
/* harmony import */
/**
 * WordPress dependencies
 */
const n=[{key:"courses",description:(0,r.__)("Courses CSV File","sensei-lms")},{key:"lessons",description:(0,r.__)("Lessons CSV File","sensei-lms")},{key:"questions",description:(0,r.__)("Questions CSV File","sensei-lms")}];
/***/},
/***/27723:
/***/e=>{"use strict";e.exports=window.wp.i18n}
/***/,
/***/28305:
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */y:()=>/* binding */l
/* harmony export */});
/* harmony import */var r=s(66087),n=s(27723),o=s(72266),i=s(62540);
/* harmony import */
/**
 * External dependencies
 */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Create title with link.
 *
 * @param {string} title    Post title.
 * @param {string} editLink Post edit link.
 */
const l=({items:e,type:t})=>(0,i.jsx)("div",{className:"sensei-import-done__log-data",children:(0,i.jsxs)("table",{className:"sensei-data-table",children:[(0,i.jsx)("thead",{children:(0,i.jsxs)("tr",{children:["error"===t&&(0,i.jsx)("th",{children:(0,n.__)("File","sensei-lms")}),(0,i.jsx)("th",{children:(0,n.__)("Title","sensei-lms")}),(0,i.jsx)("th",{children:(0,n.__)("Line #","sensei-lms")}),(0,i.jsx)("th",{children:o/* .logTypeLabels */.K[t]})]})}),(0,i.jsx)("tbody",{children:e.map((e=>{return(0,i.jsxs)("tr",{children:["error"===t&&(0,i.jsx)("td",{children:e.filename}),(0,i.jsx)("td",{children:(s=e.post.title,n=e.post.edit_link,n?(0,i.jsx)("a",{href:n,target:"_blank",rel:"noreferrer",children:s}):s)}),(0,i.jsx)("td",{children:e.line}),(0,i.jsx)("td",{children:e.message})]},(0,r.kebabCase)(Object.entries(e).join("")));var s,n}))})]})})
/***/;
/**
 * ImportLog component.
 *
 * @param {Object} input       ImportLog input.
 * @param {Array}  input.items An array of log items.
 * @param {string} input.type  Log type.
 */},
/***/29491:
/***/e=>{"use strict";e.exports=window.wp.compose}
/***/,
/***/32406:
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */$K:()=>/* binding */v
/* harmony export */,C_:()=>/* binding */i
/* harmony export */,DN:()=>/* binding */r
/* harmony export */,DZ:()=>/* binding */f
/* harmony export */,Gu:()=>/* binding */g
/* harmony export */,HZ:()=>/* binding */y
/* harmony export */,Ig:()=>/* binding */_
/* harmony export */,Lh:()=>/* binding */a
/* harmony export */,Nz:()=>/* binding */j
/* harmony export */,RI:()=>/* binding */d
/* harmony export */,Sc:()=>/* binding */x
/* harmony export */,U2:()=>/* binding */m
/* harmony export */,Vl:()=>/* binding */h
/* harmony export */,do:()=>/* binding */u
/* harmony export */,eH:()=>/* binding */S
/* harmony export */,ge:()=>/* binding */c
/* harmony export */,kD:()=>/* binding */l
/* harmony export */,k_:()=>/* binding */n
/* harmony export */,l1:()=>/* binding */o
/* harmony export */,nR:()=>/* binding */p
/* harmony export */});
/**
 * Data import constants.
 */
const r="/sensei-internal/v1/import/",n="active",o="FETCH_FROM_API",i="WAIT",l="START_LOAD_CURRENT_JOB_STATE",a="SUCCESS_LOAD_CURRENT_JOB_STATE",c="ERROR_LOAD_CURRENT_JOB_STATE",d="SET_JOB_STATE",u="START_IMPORT",p="SUCCESS_START_IMPORT",m="ERROR_START_IMPORT",h="START_UPLOAD_IMPORT_DATA_FILE",g="SUCCESS_UPLOAD_IMPORT_DATA_FILE",f="ERROR_UPLOAD_IMPORT_DATA_FILE",y="START_DELETE_IMPORT_DATA_FILE",_="SUCCESS_DELETE_IMPORT_DATA_FILE",v="ERROR_DELETE_IMPORT_DATA_FILE",x="SET_IMPORT_LOG",j="ERROR_FETCH_IMPORT_LOG",S="RESET_STATE"}
/***/,
/***/38407:
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */H:()=>/* binding */i
/* harmony export */,w:()=>/* binding */l
/* harmony export */});
/* harmony import */var r=s(86087),n=s(62540);
/* harmony import */
/**
 * Section and Header helper component from `@woocommerce/components`.
 */
/**
 * WordPress dependencies
 */
/**
 * Context container for heading level. We start at 2 because the `h1` assumed to be the page header.
 */
const o=(0,r.createContext)(2);
/**
 * These components are used to frame out the page content for accessible heading hierarchy. Instead of defining fixed heading levels
 * (`h2`, `h3`, …) you can use `<H />` to create "section headings", which look to the parent `<Section />`s for the appropriate
 * heading level.
 *
 * @param {Object} props -
 * @return {Object} -
 */function i(e){
return(0,n.jsx)(o.Consumer,{children:t=>{const s="h"+Math.min(t,6);
return(0,n.jsx)(s,{...e})}})}
/**
 * The section wrapper, used to indicate a sub-section (and change the header level context).
 *
 * @param {Object} props
 * @param {string} props.component
 * @param {Node}   props.children
 * @return {Object} -
 */function l({component:e,children:t,...s}){const r=e||"div";
return(0,n.jsx)(o.Consumer,{children:i=>(0,n.jsx)(o.Provider,{value:i+1,children:!1===e?t:(0,n.jsx)(r,{...s,children:t})})})}
/***/},
/***/38630:
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */J:()=>/* binding */i
/* harmony export */});
/* unused harmony export formattingComponents */
/* harmony import */var r=s(14995),n=s(62540);
/* harmony import */
/**
 * External dependencies
 */
const o={em:(0,n.jsx)("em",{}),strong:(0,n.jsx)("strong",{}),code:(0,n.jsx)("code",{}),small:(0,n.jsx)("small",{}),sub:(0,n.jsx)("sub",{}),sup:(0,n.jsx)("sup",{}),br:(0,n.jsx)("br",{}),p:(0,n.jsx)("p",{}),del:(0,n.jsx)("del",{})},i=(e,t={})=>(0,r/* ["default"] */.A)({mixedString:e,components:{...o,...t}})
/***/;
/**
 * Interpolate components and create a node from the given template string.
 *
 * @example formatString(' Welcome to {{strong}}Sensei{{/strong}}!')
 *
 * @param {string} mixedString Template string.
 * @param {Object} components  Replacements.
 */},
/***/41634:
/***/e=>{"use strict";
/**
 * Copyright (c) 2013-present, Facebook, Inc.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 *
 */
/**
 * Use invariant() to assert state which your program assumes to be true.
 *
 * Provide sprintf-style format (only %s is supported) and arguments
 * to provide information about what broke and what you were
 * expecting.
 *
 * The invariant message will be stripped in production, but the invariant
 * will remain to ensure logic does not differ in production.
 */e.exports=function(e,t,s,r,n,o,i,l){if(!e){var a;if(void 0===t)a=new Error("Minified exception occurred; use the non-minified dev environment for the full error message and additional helpful warnings.");else{var c=[s,r,n,o,i,l],d=0;(a=new Error(t.replace(/%s/g,(function(){return c[d++]})))).name="Invariant Violation"}// we don't care about invariant's own frame
throw a.framesToPop=1,a}}}
/***/,
/***/46979:
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */x:()=>/* binding */n
/* harmony export */});
/* harmony import */var r=s(86087);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Use Sensei color theme.
 *
 * Requires enqueueing the sensei-wp-components stylesheet.
 */
function n(){(0,r.useLayoutEffect)((()=>(document.body.classList.add("sensei-color"),()=>document.body.classList.remove("sensei-color"))))}
/***/},
/***/47143:
/***/e=>{"use strict";e.exports=window.wp.data}
/***/,
/***/49395:
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */A:()=>c
/* harmony export */});
/* harmony import */var r=s(47143),n=s(57571),o=s(97584),i=s(64021),l=s(71469),a=s(2976);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
const c=()=>{(0,r.registerStore)("sensei/import",{reducer:n/* ["default"] */.A,actions:o,selectors:i,controls:l/* ["default"] */.A,resolvers:a})};
/* harmony default export */}
/***/,
/***/51609:
/***/e=>{"use strict";e.exports=window.React}
/***/,
/***/51865:
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */c:()=>/* binding */l
/* harmony export */});
/* harmony import */var r=s(27723),n=s(20575),o=s(38407),i=s(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * This component displays the import progress page of the importer.
 *
 * @param {Object} input       ImportProgressPage input.
 * @param {Object} input.state The import state.
 */
const l=({state:e})=>{const{percentage:t}=e;return(0,n/* ["default"] */.A)(),(0,i.jsxs)("section",{className:"sensei-data-port-step sensei-import-progress-page",children:[(0,i.jsxs)("header",{className:"sensei-data-port-step__header",children:[(0,i.jsx)(o.H,{children:(0,r.__)("Importing","sensei-lms")}),(0,i.jsx)("p",{children:(0,r.__)("Your content is now being imported…","sensei-lms")})]}),(0/* .Section */,i.jsx)(o.w,{className:"sensei-data-port-step__body",component:"section",children:(0,i.jsx)("p",{children:(0,i.jsx)("progress",{className:"sensei-data-port__progressbar sensei-import-progress-page__progress",max:"100",value:t})})})]})};
/***/},
/***/56009:
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */A:()=>o
/* harmony export */});
/* harmony import */var r=s(5573),n=s(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
const o=(0,n.jsx)(r.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24",children:(0,n.jsx)(r.Path,{d:"M12 13.06l3.712 3.713 1.061-1.06L13.061 12l3.712-3.712-1.06-1.06L12 10.938 8.288 7.227l-1.061 1.06L10.939 12l-3.712 3.712 1.06 1.061L12 13.061z"})});
/* harmony default export */}
//# sourceMappingURL=close-small.js.map
/***/,
/***/56427:
/***/e=>{"use strict";e.exports=window.wp.components}
/***/,
/***/57571:
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */A:()=>l
/* harmony export */});
/* harmony import */var r=s(66087),n=s(32406);
/* harmony import */
/**
 * External dependencies
 */
/**
 * Internal dependencies
 */
const o={jobId:null,isFetching:!0,fetchError:!1,completedSteps:[],upload:{isSubmitting:!1,errorMsg:null,courses:{isUploaded:!1,isUploading:!1,isDeleting:!1,hasError:!1,errorMsg:null,filename:null},lessons:{isUploaded:!1,isUploading:!1,isDeleting:!1,hasError:!1,errorMsg:null,filename:null},questions:{isUploaded:!1,isUploading:!1,isDeleting:!1,hasError:!1,errorMsg:null,filename:null}},progress:{status:"",percentage:0},done:{results:null,logs:null}},i=(e,t,s)=>({...e,upload:{...e.upload,[t]:s}})
/**
 * Data importer reducer.
 *
 * @param {Object}         state  Current state.
 * @param {{type: string}} action Action to update the state.
 *
 * @return {Object} State updated.
 */
/* harmony default export */,l=(e=o,t)=>{switch(t.type){case n/* .START_LOAD_CURRENT_JOB_STATE */.kD:return{...e,isFetching:!0,fetchError:!1};case n/* .SUCCESS_LOAD_CURRENT_JOB_STATE */.Lh:return{...(0,r.merge)({},e,t.data),isFetching:!1};case n/* .SET_JOB_STATE */.RI:return{...(0,r.merge)({},e,t.data)};case n/* .ERROR_LOAD_CURRENT_JOB_STATE */.ge:return{...e,isFetching:!1,fetchError:t.error};case n/* .START_IMPORT */.do:return{...e,upload:{...e.upload,errorMsg:null,isSubmitting:!0}};case n/* .ERROR_START_IMPORT */.U2:return{...e,upload:{...e.upload,errorMsg:t.error.message,isSubmitting:!1}};case n/* .SUCCESS_START_IMPORT */.nR:return{...e,completedSteps:t.data.completedSteps,upload:{...e.upload,isSubmitting:!1},progress:{...e.progress,...t.data.progress}};case n/* .START_UPLOAD_IMPORT_DATA_FILE */.Vl:return i(e,t.level,{...e.upload[t.level],isUploaded:!1,isUploading:!0,isDeleting:!1,hasError:!1,errorMsg:null,filename:null});case n/* .SUCCESS_UPLOAD_IMPORT_DATA_FILE */.Gu:return i({...e,jobId:t.data.jobId},t.level,{...e.upload[t.level],...t.data.upload[t.level],isUploading:!1,isDeleting:!1,hasError:!1,errorMsg:null});case n/* .ERROR_UPLOAD_IMPORT_DATA_FILE */.DZ:return i(e,t.level,{...e.upload[t.level],isUploaded:!1,isUploading:!1,isDeleting:!1,hasError:!0,errorMsg:t.error.message,filename:null});case n/* .START_DELETE_IMPORT_DATA_FILE */.HZ:return i(e,t.level,{...e.upload[t.level],isDeleting:!0});case n/* .SUCCESS_DELETE_IMPORT_DATA_FILE */.Ig:return i(e,t.level,{...t.data.upload[t.level],isUploaded:!1,isDeleting:!1,hasError:!1,errorMsg:null,filename:null});case n/* .ERROR_DELETE_IMPORT_DATA_FILE */.$K:return i(e,t.level,{...e.upload[t.level],isUploaded:!1,isDeleting:!1,hasError:!0,errorMsg:t.error.message});case n/* .SET_IMPORT_LOG */.Sc:return{...e,done:{...e.done,logs:t.data}};case n/* .ERROR_FETCH_IMPORT_LOG */.Nz:return{...e,done:{...e.done,logs:{fetchError:t.error}}};case n/* .RESET_STATE */.eH:return{...o};default:return e}};
/**
 *
 * @param {Object}         state      Current state.
 * @param {{type: string}} levelKey   Level to update.
 * @param {Object}         attributes Attributes to set.
 * @return {Object} State updated.
 */}
/***/,
/***/58694:
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */A:()=>i
/* harmony export */});
/* harmony import */var r=s(47143),n=s(29491),o=s(67513);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/* harmony default export */const i=(0,n.compose)((0,r.withSelect)((e=>{const t=e("sensei/import");return{state:t.getStepData("upload"),isReady:t.isReadyToStart()}})),(0,r.withDispatch)(((e,t,{select:s})=>{const{submitStartImport:r}=e("sensei/import");return{submitStartImport:()=>{r(s("sensei/import").getJobId());
// Log continue to import from uploaded files.
const e=s("sensei/import").getUploadedLevelKeys().join(",");window.sensei_log_event("import_continue_click",{type:e})}}})))(o/* .UploadPage */.j);
/***/},
/***/59368:
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */xk:()=>/* binding */o
/* harmony export */});
/* unused harmony exports normalizeUploadsState, parseCompletedSteps */
/**
 * Normalize uploads state.
 *
 * @param {Object} files Files raw data.
 *
 * @return {Object} Normalized levels data.
 */
const r=e=>{const t={};return Object.entries(e).forEach((([e,s])=>{s.name&&(t[e]={filename:s.name,isUploaded:!0})})),t},n=e=>"pending"===e.status?["upload"]:"completed"===e.status?["upload","progress"]:[],o=({id:e,files:t,status:s,results:o,...i})=>({...i,jobId:e,progress:s,upload:r(t||[]),completedSteps:n(s||{}),done:{results:o}})
/***/;
/**
 * Parses completed steps data.
 *
 * @param {Object} data Status data.
 *
 * @return {Array} Parsed completed steps data.
 */},
/***/60902:
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */A:()=>i
/* harmony export */});
/* harmony import */var r=s(47143),n=s(29491),o=s(51865);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/* harmony default export */const i=(0,n.compose)((0,r.withSelect)((e=>({state:e("sensei/import").getStepData("progress")}))))(o/* .ImportProgressPage */.c);
/***/},
/***/61912:
/***/(e,t,s)=>{"use strict";
/* unused harmony export preloadedDataUsedOnceMiddleware */
/* harmony import */var r=s(93832),n=s(1455);
/* harmony import */s.n(n)().use(
/**
 * WordPress dependencies
 */
/**
 * Use data preloaded with createPreloadingMiddleware only once.
 */
function(){const e={};return(t,s)=>("string"!=typeof t.path||"GET"!==t.method&&t.method||(e[t.path]?t.path=(0,r.addQueryArgs)(t.path,{__skip_preload:1}):e[t.path]=!0),s(t))}())}
/***/,
/***/62540:
/***/(e,t,s)=>{"use strict";e.exports=s(2192)}
/***/,
/***/64021:
/***/(e,t,s)=>{"use strict";s.r(t),
/* harmony export */s.d(t,{
/* harmony export */getFetchError:()=>/* binding */c
/* harmony export */,getJobId:()=>/* binding */a
/* harmony export */,getLogsBySeverity:()=>/* binding */f
/* harmony export */,getLogsFetchError:()=>/* binding */y
/* harmony export */,getNavigationSteps:()=>/* binding */u
/* harmony export */,getStepData:()=>/* binding */d
/* harmony export */,getSuccessResults:()=>/* binding */g
/* harmony export */,getUploadedLevelKeys:()=>/* binding */h
/* harmony export */,isCompleteStep:()=>/* binding */p
/* harmony export */,isFetching:()=>/* binding */l
/* harmony export */,isReadyToStart:()=>/* binding */m
/* harmony export */});
/* harmony import */var r=s(66087),n=s(97565),o=s(27371);
/* harmony import */
/**
 * External dependencies
 */
/**
 * Internal dependencies
 */
const i=["course","lesson","question"],l=e=>e.isFetching
/**
 * Get the import job ID.
 *
 * @param {Object} state Current state.
 *
 * @return {string} Job ID.
 */,a=e=>e.jobId
/**
 * Fetch importer error selector.
 *
 * @param {Object} state Current state.
 *
 * @return {Object|boolean} Error object or false.
 */,c=e=>e.fetchError
/**
 * Step state selector.
 *
 * @param {Object} state Current state.
 * @param {string} step  Step name.
 *
 * @return {Object} Step data.
 */,d=(e,t)=>e[t]
/**
 * Get navigation steps with their state.
 *
 * @param {Object} state                Current state.
 * @param {Array}  state.completedSteps An array of the completed steps.
 *
 * @return {Array} Navigation steps.
 */,u=({completedSteps:e})=>{const t=n/* .steps */.C.map((t=>({...t,isComplete:e.includes(t.key),isNext:!1})));return(t.find((e=>!e.isComplete))||t[0]).isNext=!0,t},p=({completedSteps:e},t)=>e.includes(t)
/**
 * Get whether the importer is ready to start.
 *
 * @param {Object} state Current state.
 *
 * @return {boolean} If the importer is ready.
 */,m=e=>{const t=o/* .levels */.y.map((({key:t})=>e.upload[t])),s=t.some((e=>e.isUploaded)),r=t.some((e=>e.isUploading||e.isDeleting));return s&&!r},h=({upload:e})=>o/* .levels */.y.filter((({key:t})=>e[t].isUploaded)).map((({key:e})=>e))
/**
 * Get success results.
 *
 * @param {Object} state      Current state.
 * @param {Object} state.done The object which contains the results of the job.
 *
 * @return {Array} Success results.
 */,g=({done:e})=>i.map((t=>({key:t,count:(0,r.get)(e,["results",t,"success"],0)+(0,r.get)(e,["results",t,"warning"],0)}))).filter((({count:e})=>e>0))
/**
 * Get logs by severity.
 *
 * @param {Object} state        Current state.
 * @param {Object} state.done   The object which contains the logs of the job.
 * @param {Object} state.upload The object which contains the uploads.
 *
 * @return {Object} Object with the logs by severity.
 */,f=({done:e,upload:t})=>{const s=(0,r.get)(e,"logs.items",[]).map((e=>({...e,filename:(0,r.get)(t,e.type+"s.filename","")})));return(0,r.groupBy)(s,"severity")},y=({done:e})=>(0,r.get)(e,"logs.fetchError",!1)
/***/;
/**
 * Is fetching importer data selector.
 *
 * @param {Object} state Current state.
 *
 * @return {boolean} Is fetching.
 */},
/***/66087:
/***/e=>{"use strict";e.exports=window.lodash}
/***/,
/***/67513:
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */j:()=>/* binding */d
/* harmony export */});
/* harmony import */var r=s(27723),n=s(56427),o=s(8141),i=s(75808),l=s(38630),a=s(38407),c=s(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * This component displays the upload page of the importer.
 *
 * @param {Object}   input                   UploadPage input.
 * @param {Object}   input.state             The import state.
 * @param {boolean}  input.isReady           Whether the upload is finished.
 * @param {Function} input.submitStartImport Callback which is called when start button is clicked.
 */
const d=({state:e,isReady:t,submitStartImport:s})=>{const{isSubmitting:d,errorMsg:u}=e;
return(0,c.jsxs)("section",{className:"sensei-data-port-step sensei-upload-page",children:[(0,c.jsxs)("header",{className:"sensei-data-port-step__header",children:[(0,c.jsx)(a.H,{children:(0,r.__)("Import content from a CSV file","sensei-lms")}),(0,c.jsx)("p",{children:(0,l/* .formatString */.J)((0,r.__)("This tool enables you to import courses, lessons, and questions from a CSV file. Please review the {{link}}documentation{{/link}} to learn more about the expected file structure.","sensei-lms"),{link:

// eslint-disable-next-line jsx-a11y/anchor-has-content

// eslint-disable-next-line jsx-a11y/anchor-has-content
(0,c.jsx)("a",{className:"link__color-secondary",href:"https://senseilms.com/documentation/import/",target:"_blank",type:"external",rel:"noopener noreferrer"})})})]}),(0/* .Section */,c.jsxs)(a.w,{className:"sensei-data-port-step__body",component:"section",children:[(0,c.jsx)("p",{children:(0,r.__)("Choose one or more CSV files to upload from your computer.","sensei-lms")}),(0/* ["default"] */,c.jsx)(o.A,{}),(0,c.jsxs)("div",{className:"sensei-data-port-step__footer",children:[null!==u&&(0/* .Notice */,c.jsx)(i.$,{message:u,isError:!0}),(0,c.jsx)(n.Button,{isPrimary:!0,className:"continue-button",disabled:!t||d,onClick:s,children:(0,r.__)("Continue","sensei-lms")})]})]})]})};
/***/},
/***/71469:
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */A:()=>i
/* harmony export */});
/* harmony import */var r=s(1455),n=s.n(r),o=s(32406);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/* harmony default export */const i={
/**
   * Fetch control.
   *
   * @param {{request: Object}} action Action with the request object that is used to fetch.
   *
   * @return {Promise} API fetch promise.
   */
[o/* .FETCH_FROM_API */.l1]:({request:e})=>n()(e),[o/* .WAIT */.C_]:({timeout:e})=>new Promise((t=>setTimeout(t,e)))};
/***/},
/***/72266:
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */K:()=>/* binding */n
/* harmony export */});
/* unused harmony export postTypeLabels */
/* harmony import */var r=s(27723);
/* harmony import */
/**
 * WordPress dependencies
 */
(0,r.__)("Courses","sensei-lms"),(0,r.__)("Lessons","sensei-lms"),(0,r.__)("Questions","sensei-lms");const n={error:(0,r.__)("Error","sensei-lms"),warning:(0,r.__)("Warning","sensei-lms")}}
/***/,
/***/74153:
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */O:()=>/* binding */n
/* harmony export */});
/* harmony import */var r=s(32406);
/**
 * Internal dependencies
 */
/**
 * Build a URL for a job specific route.
 *
 * @param {string?} jobId Job identifier.
 * @param {Array?}  parts Parts of the URL.
 * @return {string} Combined URL.
 */const n=(e,t=null)=>{const s=[...e?[e]:[],...t||[]].join("/");return r/* .API_BASE_PATH */.DN+s};
/***/},
/***/75808:
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */$:()=>/* binding */l
/* harmony export */});
/* harmony import */var r=s(4452),n=s.n(r),o=s(56427),i=s(62540);
/* harmony import */
/**
 * External dependencies
 */
/**
 * WordPress dependencies
 */
/**
 * Sensei data port error notice.
 *
 * @param {Object}  input         Notice input.
 * @param {string}  input.message The message to be displayed.
 * @param {boolean} input.isError Whether the message is an error.
 */
const l=({message:e,isError:t})=>{const s=n()({"sensei-data-port-notice__message":!0,error:t});
return(0,i.jsxs)("div",{className:"sensei-data-port-notice",children:[t&&(0,i.jsx)(o.Dashicon,{className:"sensei-data-port-notice__icon error",icon:"warning"}),(0,i.jsx)("span",{className:s,children:e})]})};
/***/},
/***/77505:
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */z6:()=>/* binding */n
/* harmony export */});
/* unused harmony exports createReducerFromActionMap, createStore */
/* harmony import */s(47143);
/* harmony import */
/**
 * WordPress dependencies
 */
// We register the store in the global scope to avoid registering it multiple times.
// The reason to be in the global scope is that some times we have different built files using the same source.
window.senseiStores=window.senseiStores||[];const{senseiStores:r}=window,n=(e,t,s,r)=>function*(...n){e&&(yield{type:e});try{const e=yield*t(...n);yield{type:s,data:e}}catch(e){yield{type:r,error:e}}}
/**
 * Create reducer from a map of action type keys and reducer function.
 *
 * @example
 *  createSimpleReducer({ SAMPLE_ACTION: ( { actionProperty }, state ) => ({ ...state, actionProperty }) )
 *
 * @param {Object} reducers     Map of action type - reducer functions.
 * @param {Object} defaultState Default state.
 *
 * @return {Function} Store reducer.
 */;
/**
 * Compose an action creator with the given start, success and error actions.
 *
 * @param {string}   startAction   Start action type.
 * @param {Function} fetchFn       The action creator to be wrapped. Should return the resolved data.
 * @param {string}   successAction Success action type.
 * @param {string}   errorAction   Error action type.
 * @return {Function} The wrapped action creator.
 */}
/***/,
/***/82255:
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */U:()=>/* binding */c
/* harmony export */});
/* harmony import */var r=s(27723),n=s(56427),o=s(28305),i=s(88123),l=s(38407),a=s(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Done page of the importer.
 *
 * @param {Object}   input                 DonePage input.
 * @param {Function} input.restartImporter A callback to be called when the importer gets restarted.
 * @param {Array}    input.successResults  The results of the job.
 * @param {Object}   input.logs            The logs of the job.
 * @param {boolean}  input.isFetching      Whether the logs of the job are currently fetching.
 * @param {boolean}  input.fetchError      Whether there was an error during fetching.
 * @param {Function} input.retry           Callback to be called when fetching is retried.
 */
const c=({restartImporter:e,successResults:t=[],logs:s={},isFetching:c=!1,fetchError:d=!1,retry:u})=>{let p=(0,a.jsxs)(a.Fragment,{children:[s.error&&s.error.length>0&&(0,a.jsx)("section",{className:"sensei-data-port-step",children:(0/* .Section */,a.jsxs)(l.w,{className:"sensei-data-port-step__body",children:[(0,a.jsx)("h2",{children:(0,r.__)("Failed","sensei-lms")}),(0,a.jsx)("p",{className:"sensei-import-done__section-description",children:(0,r.__)("The following content was not imported. Please make the necessary corrections to the import file and try again.","sensei-lms")}),(0/* .ImportLog */,a.jsx)(o.y,{items:s.error,type:"error"})]})}),s.notice&&s.notice.length>0&&(0,a.jsx)("section",{className:"sensei-data-port-step",children:(0/* .Section */,a.jsxs)(l.w,{className:"sensei-data-port-step__body",children:[(0,a.jsx)("h2",{children:(0,r.__)("Partial","sensei-lms")}),(0,a.jsx)("p",{className:"sensei-import-done__section-description",children:(0,r.__)("The following content was partially imported. The import process encountered some issues that you can resolve manually by clicking the link and making the necessary adjustments.","sensei-lms")}),(0/* .ImportLog */,a.jsx)(o.y,{items:s.notice,type:"warning"})]})})]});return c?p=(0,a.jsxs)("div",{className:"sensei-import-done__log-fetching",children:[(0,a.jsx)(n.Spinner,{})," ",(0,r.__)("Fetching log details…","sensei-lms")]}):d&&(p=(0,a.jsxs)(n.Notice,{status:"error",isDismissible:!1,children:[(0,r.__)("Failed to load import log.","sensei-lms")," ",d.message,(0,a.jsx)(n.Button,{onClick:u,isLink:!0,isSmall:!0,children:(0,r.__)("Retry","sensei-lms")})]})),(0,a.jsxs)(a.Fragment,{children:[(0,a.jsx)("section",{className:"sensei-data-port-step",children:(0/* .Section */,a.jsxs)(l.w,{className:"sensei-data-port-step__body",children:[(0,a.jsx)("h2",{children:(0,r.__)("Completed","sensei-lms")}),t.length>0?(0,a.jsxs)(a.Fragment,{children:[(0,a.jsx)("p",{className:"sensei-import-done__section-description",children:(0,r.__)("The following content was imported:","sensei-lms")}),(0/* ["default"] */,a.jsx)(i.A,{successResults:t})]}):(0,a.jsx)("p",{className:"sensei-import-done__section-description",children:(0,r.__)("No content was imported.","sensei-lms")}),(0,a.jsx)("div",{className:"sensei-data-port-step__footer",children:(0,a.jsx)(n.Button,{isPrimary:!0,onClick:e,children:(0,r.__)("Import More Content","sensei-lms")})})]})}),p]})};
/***/},
/***/86087:
/***/e=>{"use strict";e.exports=window.wp.element}
/***/,
/***/88123:
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */A:()=>i
/* harmony export */});
/* harmony import */var r=s(27723),n=s(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Get post type label.
 *
 * @param {{key: string, count: number}} typeData Type data.
 *
 * @return {string} Translated label.
 */
const o=({key:e,count:t})=>({course:(0,r._n)("course","courses",t,"sensei-lms"),lesson:(0,r._n)("lesson","lessons",t,"sensei-lms"),question:(0,r._n)("question","questions",t,"sensei-lms")}[e]),i=({successResults:e})=>(0,n.jsx)("ul",{className:"sensei-import-bullet-list",children:e.map((({key:e,count:t})=>(0,n.jsxs)("li",{children:[t," ",o({key:e,count:t})]},e)))})
/* harmony default export */;
/**
 * ImportSuccessResults component.
 *
 * @param {Object} input                ImportSuccessResults input.
 * @param {Array}  input.successResults An array of counts of successfully imported items.
 */}
/***/,
/***/89439:
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */A:()=>i
/* harmony export */});
/* harmony import */var r=s(47143),n=s(29491),o=s(82255);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/* harmony default export */const i=(0,n.compose)((0,r.withSelect)((e=>{const t=e("sensei/import"),s=t.getJobId();return{successResults:t.getSuccessResults(),logs:t.getLogsBySeverity(s),isFetching:t.isResolving("getLogsBySeverity",[s]),fetchError:t.getLogsFetchError()}})),(0,r.withDispatch)((e=>{const{restartImporter:t,invalidateResolutionForStoreSelector:s}=e("sensei/import");return{restartImporter:t,retry:()=>s("getLogsBySeverity")}})))(o/* .DonePage */.U);
/***/},
/***/93544:
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */B:()=>/* binding */i
/* harmony export */});
/* harmony import */var r=s(4452),n=s.n(r),o=s(62540);
/* harmony import */
/**
 * External dependencies
 */
/**
 * @typedef  {Object}   Step
 * @property {string}  key         Unique key for the step.
 * @property {string}  description A description of the step that is going to be displayed.
 * @property {boolean} isActive    True if the step is the currently active one.
 * @property {boolean} isComplete  True if the step is completed.
 */
/**
 * A simple component to display a stepper on data port pages.
 *
 * @param {Step[]} steps The array of the steps.
 */
const i=({steps:e})=>(0,o.jsx)("ol",{className:"sensei-data-port-steps",children:e.map((e=>{const t=n()({active:e.isNext,done:e.isComplete});
return(0,o.jsx)("li",{className:t,children:e.label},e.key)}))})
/***/},
/***/93832:
/***/e=>{"use strict";e.exports=window.wp.url}
/***/,
/***/94942:
/***/(e,t,s)=>{"use strict";
/**
 * Copyright (c) 2014-present, Facebook, Inc.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 *
 */var r=s(98615);
/**
 * Similar to invariant but only logs a warning if the condition is not met.
 * This can be used to log issues in development environments in critical
 * paths. Removing the logging code for production environments will keep the
 * same logic and follow the same code paths.
 */e.exports=r}
/***/,
/***/97565:
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */C:()=>/* binding */a
/* harmony export */});
/* harmony import */var r=s(27723),n=s(58694),o=s(60902),i=s(89439),l=s(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
const a=[{key:"upload",container:(0/* ["default"] */,l.jsx)(n.A,{}),label:(0,r.__)("Upload CSV Files","sensei-lms")},{key:"progress",container:(0/* ["default"] */,l.jsx)(o.A,{}),label:(0,r.__)("Import","sensei-lms")},{key:"complete",container:(0/* ["default"] */,l.jsx)(i.A,{}),label:(0,r.__)("Done","sensei-lms")}];
/***/},
/***/97584:
/***/(e,t,s)=>{"use strict";s.r(t),
/* harmony export */s.d(t,{
/* harmony export */deleteLevelFile:()=>/* binding */S
/* harmony export */,errorDeleteLevelFileAction:()=>/* binding */E
/* harmony export */,errorFileUpload:()=>/* binding */j
/* harmony export */,errorStartImport:()=>/* binding */f
/* harmony export */,fetchFromAPI:()=>/* binding */l
/* harmony export */,loadCurrentJobState:()=>/* binding */c
/* harmony export */,pollJobProgress:()=>/* binding */u
/* harmony export */,resetState:()=>/* binding */R
/* harmony export */,restartImporter:()=>/* binding */T
/* harmony export */,setJobState:()=>/* binding */p
/* harmony export */,startDeleteLevelFileAction:()=>/* binding */b
/* harmony export */,startFileUploadAction:()=>/* binding */v
/* harmony export */,startImport:()=>/* binding */h
/* harmony export */,submitStartImport:()=>/* binding */m
/* harmony export */,successDeleteLevelFileAction:()=>/* binding */w
/* harmony export */,successFileUpload:()=>/* binding */x
/* harmony export */,successStartImport:()=>/* binding */g
/* harmony export */,throwEarlyUploadError:()=>/* binding */_
/* harmony export */,updateJobState:()=>/* binding */d
/* harmony export */,uploadFileForLevel:()=>/* binding */y
/* harmony export */,wait:()=>/* binding */a
/* harmony export */});
/* harmony import */var r=s(32406),n=s(77505),o=s(59368),i=s(74153);
/* harmony import */
/**
 * Internal dependencies
 */
/**
 * @typedef  {Object} FetchFromAPIAction
 * @property {string} type    Action type.
 * @property {Object} request Object that is used to fetch.
 */
/**
 * Fetch action creator.
 *
 * @param {Object} request Object that is used to fetch.
 *
 * @return {FetchFromAPIAction} Fetch action.
 */
const l=e=>({type:r/* .FETCH_FROM_API */.l1,request:e}),a=e=>({type:r/* .WAIT */.C_,timeout:e})
/**
 * Fetch importer data for current job.
 */,c=(0/* .START_LOAD_CURRENT_JOB_STATE */,n/* .composeFetchAction */.z6)(r.kD,(function*(){const e=yield l({path:(0/* .API_SPECIAL_ACTIVE_JOB_ID */,i/* .buildJobEndpointUrl */.O)(r.k_)});return(0,o/* .normalizeImportData */.xk)(e)}),r/* .SUCCESS_LOAD_CURRENT_JOB_STATE */.Lh,r/* .ERROR_LOAD_CURRENT_JOB_STATE */.ge);
/**
 * Update job state in the background.
 *
 * @param {string} jobId The job ID.
 */
function*d(e){try{const t=yield l({path:(0,i/* .buildJobEndpointUrl */.O)(e)});yield p((0,o/* .normalizeImportData */.xk)(t))}catch(e){
// Silent.
}}
/**
 * Run job batches and query progress until it is completed.
 *
 * @param {string} jobId Job ID.
 */const u=function*(e){try{const t=yield l({path:(0,i/* .buildJobEndpointUrl */.O)(e,["process"]),method:"POST"});yield p((0,o/* .normalizeImportData */.xk)(t));const{status:s}=t.status;"completed"!==s&&(yield*u(e))}catch(t){yield a(2e3),yield*u(e)}},p=e=>({type:r/* .SET_JOB_STATE */.RI,data:e})
/**
 * Start import.
 *
 * @param {string}   jobId               The job identifier.
 * @param {Object}   [options]
 * @param {Function} [options.onSuccess] On Success handler.
 * @param {Function} [options.onError]   On Error handler.
 */;
/**
 * @typedef  {Object} SetJobStateAction
 * @property {string} type Action type.
 * @property {Object} data Job state.
 */
/**
 * Set job state action creator.
 *
 * @param {Object} data Job state.
 * @return {SetJobStateAction} Set job state action.
 */function*m(e,{onSuccess:t,onError:s}={}){yield h();try{if(!e)return void(yield f({message:null}));const s=yield l({path:(0,i/* .buildJobEndpointUrl */.O)(e,["start"]),method:"POST"});yield g((0,o/* .normalizeImportData */.xk)(s)),t&&t()}catch(e){yield f(e),s&&s(e)}}
/**
 * @typedef  {Object} StartImportAction
 * @property {string} type Action type.
 */
/**
 * Start action to start import.
 *
 * @return {StartImportAction} Start import action.
 */const h=()=>({type:r/* .START_IMPORT */.do})
/**
 * @typedef  {Object} SuccessStartImportAction
 * @property {string} type Action type.
 * @property {Object} data Data object.
 */
/**
 * Success submit action creator.
 *
 * @param {Object} data Importer data.
 * @return {SuccessStartImportAction} Success submit action.
 */,g=e=>({type:r/* .SUCCESS_START_IMPORT */.nR,data:e})
/**
 * @typedef  {Object}         ErrorStartImportAction
 * @property {string}         type  Action type.
 * @property {Object|boolean} error Error object or false.
 */
/**
 * Error start import job creator.
 *
 * @param {Object} error Error object or false.
 *
 * @return {ErrorStartImportAction} Error action.
 */,f=e=>({type:r/* .ERROR_START_IMPORT */.U2,error:e})
/**
 * Upload a file for a level.
 *
 * @param {string}   jobId               The job identifier.
 * @param {string}   level               Level identifier.
 * @param {Object}   uploadData          Data to submit.
 * @param {Object}   [options]
 * @param {Function} [options.onSuccess] Callback on success.
 * @param {Function} [options.onError]   Callback on error.
 */;function*y(e,t,s,{onSuccess:n,onError:a}={}){yield v(t,s);try{e||(e=r/* .API_SPECIAL_ACTIVE_JOB_ID */.k_);const a=yield l({path:(0,i/* .buildJobEndpointUrl */.O)(e,["file",t]),method:"POST",body:s});yield x(t,(0,o/* .normalizeImportData */.xk)(a)),n&&n()}catch(e){yield j(t,e),a&&a(e)}}
/**
 * Throw an early upload error.
 *
 * @param {string} level    Level identifier.
 * @param {string} errorMsg Error object or false.
 */const _=(e,t)=>j(e,{code:"",message:t})
/**
 * @typedef  {Object} StartFileUploadAction
 * @property {string} type       Action type.
 * @property {string} level      Level identifier.
 * @property {Object} uploadData Error object or false.
 */
/**
 * Start file upload action creator.
 *
 * @param {string} level      Level identifier.
 * @param {Object} uploadData Data to submit.
 *
 * @return {StartFileUploadAction} Start file upload action.
 */,v=(e,t)=>({type:r/* .START_UPLOAD_IMPORT_DATA_FILE */.Vl,level:e,uploadData:t})
/**
 * @typedef  {Object} SuccessFileUploadAction
 * @property {string} type  Action type.
 * @property {string} level Level identifier.
 * @property {Object} data  Data object.
 */
/**
 * Success upload file action.
 *
 * @param {string} level Level identifier.
 * @param {Object} data  Importer data.
 * @return {SuccessFileUploadAction} Success file upload action.
 */,x=(e,t)=>({type:r/* .SUCCESS_UPLOAD_IMPORT_DATA_FILE */.Gu,level:e,data:t})
/**
 * @typedef  {Object}         ErrorFileUploadAction
 * @property {string}         type  Action type.
 * @property {string}         level Level identifier.
 * @property {Object|boolean} error Error object or false.
 */
/**
 * Error submit action creator.
 *
 * @param {string}         level Level identifier.
 * @param {Object|boolean} error Error object or false.
 *
 * @return {ErrorFileUploadAction} Error action.
 */,j=(e,t)=>({type:r/* .ERROR_UPLOAD_IMPORT_DATA_FILE */.DZ,level:e,error:t})
/**
 * Delete a level file.
 *
 * @param {string} jobId The job identifier.
 * @param {string} level Level identifier.
 */;function*S(e,t){yield b(t);try{if(!e)return void(yield E({message:null}));const s=yield l({path:(0,i/* .buildJobEndpointUrl */.O)(e,["file",t]),method:"DELETE"});yield w(t,(0,o/* .normalizeImportData */.xk)(s))}catch(e){yield E(t,e)}}
/**
 * @typedef  {Object} StartDeleteLevelFileAction
 * @property {string} type  Action type.
 * @property {string} level Level identifier.
 */
/**
 * Start file upload action creator.
 *
 * @param {string} level Level identifier.
 *
 * @return {StartDeleteLevelFileAction} Start delete file action.
 */const b=e=>({type:r/* .START_DELETE_IMPORT_DATA_FILE */.HZ,level:e})
/**
 * @typedef  {Object} SuccessDeleteLevelFileAction
 * @property {string} type  Action type.
 * @property {string} level Level identifier.
 * @property {Object} data  Data object.
 */
/**
 * Success delete level file action.
 *
 * @param {string} level Level identifier.
 * @param {Object} data  Importer data.
 * @return {SuccessDeleteLevelFileAction} Success delete level file action.
 */,w=(e,t)=>({type:r/* .SUCCESS_DELETE_IMPORT_DATA_FILE */.Ig,level:e,data:t})
/**
 * @typedef  {Object}  ErrorSuccessDeleteLevelFileAction
 * @property {string} type  Action type.
 * @property {string} level Level identifier.
 * @property {Object} error Error object or false.
 */
/**
 * Error delete level file action creator.
 *
 * @param {string} level Level identifier.
 * @param {Object} error Error object or false.
 *
 * @return {ErrorSuccessDeleteLevelFileAction} Error delete level file action.
 */,E=(e,t)=>({type:r/* .ERROR_DELETE_IMPORT_DATA_FILE */.$K,level:e,error:t})
/**
 * Reset importer state.
 */,R=()=>({type:r/* .RESET_STATE */.eH})
/**
 * Restart importer.
 */;function*T(){yield R(),yield c()}
/***/},
/***/98615:
/***/e=>{"use strict";
/**
 * Copyright (c) 2013-present, Facebook, Inc.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 *
 * 
 */function t(e){return function(){return e}}
/**
 * This function accepts and discards inputs; it has no side effects. This is
 * primarily useful idiomatically for overridable function endpoints which
 * always need to be callable, since JS lacks a null-call idiom ala Cocoa.
 */var s=function(){};s.thatReturns=t,s.thatReturnsFalse=t(!1),s.thatReturnsTrue=t(!0),s.thatReturnsNull=t(null),s.thatReturnsThis=function(){return this},s.thatReturnsArgument=function(e){return e},e.exports=s}
/***/
/******/},t={};
/************************************************************************/
/******/ // The module cache
/******/
/******/
/******/ // The require function
/******/function s(r){
/******/ // Check if module is in cache
/******/var n=t[r];
/******/if(void 0!==n)
/******/return n.exports;
/******/
/******/ // Create a new module (and put it into the cache)
/******/var o=t[r]={
/******/ // no module.id needed
/******/ // no module.loaded needed
/******/exports:{}
/******/};
/******/
/******/ // Execute the module function
/******/
/******/
/******/ // Return the exports of the module
/******/return e[r](o,o.exports,s),o.exports;
/******/}
/******/
/************************************************************************/
/******/ /* webpack/runtime/compat get default export */
/******/
/******/ // getDefaultExport function for compatibility with non-harmony modules
/******/s.n=e=>{
/******/var t=e&&e.__esModule?
/******/()=>e.default
/******/:()=>e
/******/;
/******/return s.d(t,{a:t}),t;
/******/},
/******/ // define getter functions for harmony exports
/******/s.d=(e,t)=>{
/******/for(var r in t)
/******/s.o(t,r)&&!s.o(e,r)&&
/******/Object.defineProperty(e,r,{enumerable:!0,get:t[r]})
/******/;
/******/},
/******/s.o=(e,t)=>Object.prototype.hasOwnProperty.call(e,t)
/******/,
/******/ // define __esModule on exports
/******/s.r=e=>{
/******/"undefined"!=typeof Symbol&&Symbol.toStringTag&&
/******/Object.defineProperty(e,Symbol.toStringTag,{value:"Module"})
/******/,Object.defineProperty(e,"__esModule",{value:!0})}
/******/,
// This entry needs to be wrapped in an IIFE because it needs to be in strict mode.
(()=>{"use strict";
/* harmony import */var e=s(27723),t=s(47143),r=s(86087),n=s(46979),o=s(93544),i=s(49395),l=s(56427),a=(s(61912),s(62540));
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
(0,i/* ["default"] */.A)();
/**
 * Sensei import page.
 */
const c=()=>{const{error:s,navigationSteps:i}=(0,t.useSelect)((e=>{const t=e("sensei/import");return{error:t.getFetchError(),navigationSteps:t.getNavigationSteps()}}),[]),{loadCurrentJobState:c}=(0,t.useDispatch)("sensei/import");if((0,r.useLayoutEffect)((()=>{c()}),[c]),(0,n/* .useSenseiColorTheme */.x)(),s)
return(0,a.jsxs)(l.Notice,{status:"error",isDismissible:!1,children:[(0,e.__)("An error has occurred while fetching the data. Please try again later!","sensei-lms"),(0,a.jsx)("br",{}),(0,e.__)("Error details:","sensei-lms")," ",s.message]});const d=i.find((e=>e.isNext));
return(0,a.jsxs)("div",{className:"sensei-page-import",children:[(0/* .DataPortStepper */,a.jsx)(o.B,{steps:i}),d.container]})};(0,r.createRoot)(document.getElementById("sensei-import-page")).render((0,a.jsx)(c,{}))})()})
/******/();