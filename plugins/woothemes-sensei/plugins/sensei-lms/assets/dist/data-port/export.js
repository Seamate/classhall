/******/(()=>{// webpackBootstrap
/******/var e={
/***/1455:
/***/e=>{"use strict";e.exports=window.wp.apiFetch}
/***/,
/***/2192:
/***/(e,s,t)=>{"use strict";
/**
 * @license React
 * react-jsx-runtime.production.min.js
 *
 * Copyright (c) Facebook, Inc. and its affiliates.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */var n=t(51609),o=Symbol.for("react.element"),r=Symbol.for("react.fragment"),i=Object.prototype.hasOwnProperty,l=n.__SECRET_INTERNALS_DO_NOT_USE_OR_YOU_WILL_BE_FIRED.ReactCurrentOwner,a={key:!0,ref:!0,__self:!0,__source:!0};function c(e,s,t){var n,r={},c=null,d=null;for(n in void 0!==t&&(c=""+t),void 0!==s.key&&(c=""+s.key),void 0!==s.ref&&(d=s.ref),s)i.call(s,n)&&!a.hasOwnProperty(n)&&(r[n]=s[n]);if(e&&e.defaultProps)for(n in s=e.defaultProps)void 0===r[n]&&(r[n]=s[n]);return{$$typeof:o,type:e,key:c,ref:d,props:r,_owner:l.current}}s.Fragment=r,s.jsx=c,s.jsxs=c}
/***/,
/***/4452:
/***/(e,s)=>{var t;
/*!
	Copyright (c) 2018 Jed Watson.
	Licensed under the MIT License (MIT), see
	http://jedwatson.github.io/classnames
*/
/* global define */!function(){"use strict";var n={}.hasOwnProperty;function o(){for(var e="",s=0;s<arguments.length;s++){var t=arguments[s];t&&(e=i(e,r(t)))}return e}function r(e){if("string"==typeof e||"number"==typeof e)return e;if("object"!=typeof e)return"";if(Array.isArray(e))return o.apply(null,e);if(e.toString!==Object.prototype.toString&&!e.toString.toString().includes("[native code]"))return e.toString();var s="";for(var t in e)n.call(e,t)&&e[t]&&(s=i(s,t));return s}function i(e,s){return s?e?e+" "+s:e+s:e}e.exports?(o.default=o,e.exports=o):void 0===(t=function(){return o}.apply(s,[]))||(e.exports=t)}()}
/***/,
/***/6934:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */B:()=>/* binding */p
/* harmony export */});
/* harmony import */var n=t(86087),o=t(56427),r=t(1455),i=t.n(r),l=t(27723),a=t(64978),c=t(78432),d=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Build the text shown for one row in the summary list.
 *
 * @param {Object}  args
 * @param {Object}  args.row      Row config (label + i18n helpers).
 * @param {boolean} args.included
 * @param {number}  args.count    Number of items selected for this type.
 * @param {?number} args.total    Total available for this type, or null if unknown.
 *
 * @return {string} Sentence describing what will be exported for this type.
 */
const u=({row:e,included:s,count:t,total:n})=>{const o=e.i18n;return s?
// No filter applied: describe the full set. `total === null` means the
// count fetch failed or hasn't returned yet — fall back to the bare label.
0===t?null===n?o.unknownTotal:0===n?o.none:1===n?o.one:o.all(n):null===n?o.count(t):o.countOf(t,n):o.skipped},p=({job:e,onSubmit:s})=>{const[t,r]=(0,n.useState)({course:!0,lesson:!0,question:!0}),[p,_]=(0,n.useState)({course:[],lesson:[],question:[]}),[m,f]=(0,n.useState)({course:null,lesson:null,question:null}),[y,h]=(0,n.useState)({course:new Map,lesson:new Map,question:new Map}),x=(0,n.useCallback)(((e,s)=>{h((t=>{const n=new Map(t[e]);return s.forEach((e=>n.set(e.id,e))),{...t,[e]:n}}))}),[]);
// Fetch the total count for each content type so the summary can show
// "All N courses" instead of just "All courses". `parse: false` gives us
// access to the raw response so we can read the X-WP-Total header.
// Fetch the total count for each content type so the summary can show
// "All N courses" instead of just "All courses". `parse: false` gives us
// access to the raw response so we can read the X-WP-Total header.
(0,n.useEffect)((()=>{let e=!1;return c/* .ROWS */.I.forEach((({type:s,restBase:t})=>{i()({path:`/wp/v2/${t}?per_page=1&status=any&_fields=id&context=edit`,parse:!1}).then((t=>{
// Guard against setting state after unmount.
if(e)return;const n=parseInt(t.headers.get("X-WP-Total")||"0",10);f((e=>({...e,[s]:n})))})).catch((e=>{
// Totals are cosmetic — the summary falls back to the
// bare type label — but log the underlying reason so a
// real REST regression doesn't go unnoticed indefinitely.
window.console?.warn(`[sensei export] failed to fetch ${s} total`,e)}))})),()=>{e=!0}}),[]);const w=e&&"creating"===e.status,j=c/* .ROWS */.I.filter((({type:e})=>t[e])).map((({type:e})=>e)),b=j.length>0&&!w;
// Preserve ROWS order so the wire payload (and analytics) is deterministic
// regardless of the order the user toggled checkboxes.
return(0,d.jsxs)("div",{className:"sensei-data-port-step__body",children:[(0,d.jsx)("p",{className:"sensei-export__select-content__label",children:(0,l.__)("Choose what to export.","sensei-lms")}),c/* .ROWS */.I.map((({type:e,label:s,placeholder:n,filterAriaLabel:i})=>(0,d.jsxs)("div",{className:"sensei-export__select-content__row",children:[(0,d.jsx)(o.CheckboxControl,{__nextHasNoMarginBottom:!0,label:s,checked:t[e],onChange:s=>r((t=>({...t,[e]:s})))}),t[e]&&(0/* .PostTokenField */,d.jsx)(a.W,{type:e,ariaLabel:i,placeholder:n,selectedIds:p[e],onChange:s=>_((t=>({...t,[e]:s}))),cachedItems:y[e],onItemsFetched:s=>x(e,s)})]},e))),b&&(0,d.jsxs)("div",{className:"sensei-export__summary","aria-live":"polite",children:[(0,d.jsx)("p",{className:"sensei-export__summary__heading",children:(0,l.__)("Your export will include:","sensei-lms")}),(0,d.jsx)("ul",{className:"sensei-export__summary__list",children:c/* .ROWS */.I.map((e=>(0,d.jsx)("li",{className:"sensei-export__summary__item "+(t[e.type]?"is-included":"is-skipped"),children:u({row:e,included:t[e.type],count:p[e.type].length,total:m[e.type]})},e.type)))})]}),(0,d.jsx)("div",{className:"sensei-data-port-step__footer",children:(0,d.jsx)(o.Button,{isPrimary:!0,onClick:()=>s(j.reduce(((e,s)=>({...e,[s]:p[s]})),{})),disabled:!b,isBusy:w,children:(0,l.__)("Start Export","sensei-lms")})})]})};
/**
 * The setup screen for the exporter. Each row toggles whether a CSV
 * is produced for that content type, and lets the user limit it to
 * specific items via a filter field. Empty filter on an enabled row
 * exports every item of that type.
 *
 * @param {Object}   props
 * @param {Object}   props.job      Current job state (from the export store).
 * @param {Function} props.onSubmit Called with the per-type selections object.
 */}
/***/,
/***/14659:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */l:()=>/* binding */c
/* harmony export */});
/* harmony import */var n=t(56427),o=t(86087),r=t(27723),i=t(20408),l=t(75808),a=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * @typedef Job
 * @property {string}       status     Export status.
 * @property {number}       percentage Export progress percentage.
 * @property {ExportFile[]} files      Exported files.
 * @property {string}       error      Error message.
 */
/**
 * @typedef ExportFile
 * @property {string} url  File URL.
 * @property {string} name File name.
 */
/**
 * Exporter progress and result.
 *
 * @param {Object}   props
 * @param {Job}      props.job    Export job state.
 * @param {Function} props.reset  Function to return to initial export screen.
 * @param {Function} props.cancel Function to request job cancellation.
 */
const c=({job:e,reset:s,cancel:t})=>{const{status:c,percentage:d,files:u,error:p}=e||{},_="completed"!==c;return(0,o.useEffect)((()=>{!_&&u&&u.forEach(i/* .downloadFile */.P)}),[u,_]),(0,a.jsx)("section",{className:"sensei-data-port-step__body",children:_?(0,a.jsxs)(a.Fragment,{children:[(0,a.jsx)("p",{children:(0,a.jsx)("progress",{className:"sensei-data-port__progressbar",max:"100",value:d||0})}),(0,a.jsx)("div",{className:"sensei-data-port-step__footer",children:(0,a.jsx)(n.Button,{isPrimary:!0,onClick:()=>t(),children:(0,r.__)("Cancel","sensei-lms")})})]}):(0,a.jsxs)(a.Fragment,{children:[(0,a.jsxs)("div",{className:"sensei-export__output-result",children:[u&&(0,a.jsxs)(a.Fragment,{children:[(0,a.jsx)("p",{children:(0,r._n)("The following file was exported:","The following files were exported:",u.length,"sensei-lms")}),(0,a.jsx)("ul",{className:"sensei-export__output-files",children:u.map((({name:e,url:s})=>(0,a.jsx)("li",{className:"sensei-export__output-file sensei-data-port-step__line",children:(0,a.jsx)("a",{href:s,download:e,children:e})},e)))})]}),p&&(0,a.jsx)("div",{className:"sensei-data-port-step__line",children:(0/* .Notice */,a.jsx)(l.$,{isError:!0,message:p})})]}),(0,a.jsx)("div",{className:"sensei-data-port-step__footer",children:(0,a.jsx)(n.Button,{isPrimary:!0,onClick:()=>s(),children:(0,r.__)("Export More Content","sensei-lms")})})]})})};
/***/},
/***/18537:
/***/e=>{"use strict";e.exports=window.wp.htmlEntities}
/***/,
/***/20408:
/***/(e,s,t)=>{"use strict";
/* harmony export */
/**
 * Prompt opening a file from the given url.
 *
 * @param {Object} options
 * @param {string} options.url    The file URL.
 * @param {string} [options.name] Filename for the downloaded file.
 */
function n({url:e,name:s}){const t=document.createElement("a");t.href=e,t.download=s||!0,document.body.appendChild(t),t.click(),document.body.removeChild(t)}
/***/t.d(s,{
/* harmony export */P:()=>/* binding */n
/* harmony export */})},
/***/27723:
/***/e=>{"use strict";e.exports=window.wp.i18n}
/***/,
/***/29491:
/***/e=>{"use strict";e.exports=window.wp.compose}
/***/,
/***/32404:
/***/(e,s,t)=>{"use strict";t.r(s),
/* harmony export */t.d(s,{
/* harmony export */cancel:()=>/* binding */m
/* harmony export */,checkForActiveJob:()=>/* binding */h
/* harmony export */,reset:()=>/* binding */_
/* harmony export */,start:()=>/* binding */p
/* harmony export */,update:()=>/* binding */f
/* harmony export */});
/* harmony import */var n=t(66161),o=t(87671),r=t(54106);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
const i="/sensei-internal/v1/export",l=e=>({type:"SET_JOB",job:e}),a=e=>({type:"UPDATE_JOB",job:e}),c=()=>(0/* .EXPORT_STORE */,n.select)(o.zz,"getJobId"),d=e=>({type:"SET_ERROR",error:e})
/**
 * Clear job state.
 */,u=function*(e){e&&!e.error&&"pending"===e.status.status&&(yield(0,r/* .timeout */.wR)(f,1e3))},p=function*(e){yield l({status:"creating"}),yield j();if(!(yield c()))return;const s=yield b(e);yield u(s)},_=function*(){yield(0,r/* .cancelTimeout */.yV)(),yield{type:"CLEAR_JOB"}},m=function*(e){yield(0,r/* .cancelTimeout */.yV)(),e||(e=yield c()),yield{type:"CLEAR_JOB"},yield x({method:"DELETE",jobId:e})},f=function*(){let e=yield c();if(!e)return;const s=yield x({endpoint:"process",method:"POST",jobId:e});e=yield c(),e&&(yield a(s),yield u(s),yield y(s))},y=function*(e){if("completed"===e.status.status){const e=yield x({endpoint:"logs",skipJobCheck:!0});e.items.length>0&&(yield d(e.items.map((e=>e.message)).join(" ")))}},h=function*(){const e=yield x({jobId:"active"});e&&e.id&&("setup"===e.status.status?yield m(e.id):(yield l(e),yield u(e)))},x=function*(e={}){let{jobId:s,...t}=e;if(s||(s=yield c(),s))return yield*w({jobId:s,...t});yield d("No job ID")},w=function*(e={}){const{skipJobCheck:s,endpoint:t,jobId:o,...r}=e,l=[i,o,t].filter((e=>!!e)).join("/");try{const e=yield(0,n.apiFetch)({path:l,...r});if(s||!e||!o||o===e.id||"active"===o)return e}catch(e){if("active"===o&&"sensei_data_port_job_not_found"===e.code)return yield{type:"CLEAR_JOB"};yield d(e.message)}},j=function*(){const e=yield w({method:"POST"});if(e)return void(yield l(e));
// sendRequest swallowed the throw and called setError. Clear the
// 'creating' synthetic job so the setup screen exits its loading state,
// then re-apply the error since clearJob wipes the whole store.
const s=yield(0/* .EXPORT_STORE */,n.select)(o.zz,"getError");yield{type:"CLEAR_JOB"},s&&(yield d(s))},b=function*(e){const s=yield x({endpoint:"start",method:"POST",data:{selections:e}}),t=Object.keys(e).map((e=>e+"s")).sort().join(",");
// Log when users start an export.
return window.sensei_log_event("export_continue_click",{type:t}),yield a(s),s};
/**
 * @typedef LogItem
 *
 * @property {string} message Log message.
 */
/**
 * @typedef LogsResponse
 *
 * @property {LogItem[]} items Log items.
 */
/**
 * @typedef JobResponse
 *
 * @property {Object}   status            Job status.
 * @property {string}   status.status     Job status name.
 * @property {number}   status.percentage Job progress percentage.
 * @property {string}   id                Job ID.
 * @property {boolean}  deleted           Was the job deleted.
 * @property {Object}   result            Job result.
 * @property {Object[]} files             Job files.
 * @property {Object}   error             Error message.
 */
/**
 * Set job state. Clears request error.
 *
 * @param {JobResponse} job Job state.
 */}
/***/,
/***/37283:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */W:()=>/* binding */c
/* harmony export */});
/* harmony import */var n=t(27723),o=t(46979),r=t(56427),i=t(14659),l=t(6934),a=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Export page.
 *
 * @param {Object}   props
 * @param {Object}   props.job
 * @param {Object}   props.error
 * @param {Function} props.start
 * @param {Function} props.reset
 * @param {Function} props.cancel
 */
const c=({job:e,error:s,start:t,reset:c,cancel:d})=>((0,o/* .useSenseiColorTheme */.x)(),(0,a.jsx)("div",{className:"sensei-page-export",children:(0,a.jsxs)("section",{className:"sensei-data-port-step",children:[(0,a.jsxs)("header",{className:"sensei-data-port-step__header",children:[(0,a.jsx)("h2",{children:(0,n.__)("Export content to a CSV file","sensei-lms")}),(0,a.jsx)("p",{children:(0,n.__)("This tool enables you to export courses, lessons, and questions to CSV files. These files are bundled together and downloaded to your computer in .zip format.","sensei-lms")})]}),s&&(0,a.jsx)(r.Notice,{status:"error",isDismissible:!1,children:s}),e&&"creating"!==e.status?(0/* .ExportProgressPage */,a.jsx)(i.l,{job:e,reset:c,cancel:d}):(0/* .ExportSelectContentPage */,a.jsx)(l.B,{onSubmit:e=>t(e),job:e})]})}));
/***/},
/***/46979:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */x:()=>/* binding */o
/* harmony export */});
/* harmony import */var n=t(86087);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Use Sensei color theme.
 *
 * Requires enqueueing the sensei-wp-components stylesheet.
 */
function o(){(0,n.useLayoutEffect)((()=>(document.body.classList.add("sensei-color"),()=>document.body.classList.remove("sensei-color"))))}
/***/},
/***/47143:
/***/e=>{"use strict";e.exports=window.wp.data}
/***/,
/***/51609:
/***/e=>{"use strict";e.exports=window.React}
/***/,
/***/54106:
/***/(e,s,t)=>{"use strict";
/* harmony export */
/**
 * Schedule to run action creator after the given time.
 *
 * @param {Function} action Action creator to dispatch.
 * @param {number}   wait   Timeout in milliseconds.
 */
function*n(e,s){yield{type:"TIMEOUT",wait:s},yield e()}
/**
 * Clear current timeout.
 */function o(){return{type:"CLEAR_TIMEOUT"}}
/**
 * Manage timeout reference.
 */t.d(s,{
/* harmony export */Ay:()=>i
/* harmony export */,wR:()=>/* binding */n
/* harmony export */,yV:()=>/* binding */o
/* harmony export */});const r={current:null,
/**
   * Create a new timeout promise.
   *
   * @param {number} wait Timeout in ms.
   * @return {Promise} Promise resolved after the timeout.
   */
create:e=>new Promise((s=>{r.clear(),r.current=setTimeout((()=>{s()}),e)})),
/**
   * Clear current scheduled timeout.
   */
clear(){r.current&&(clearTimeout(r.current),r.current=null)}},i={TIMEOUT:({wait:e})=>r.create(e),CLEAR_TIMEOUT:()=>r.clear()};
/* harmony default export */}
/***/,
/***/56427:
/***/e=>{"use strict";e.exports=window.wp.components}
/***/,
/***/62540:
/***/(e,s,t)=>{"use strict";e.exports=t(2192)}
/***/,
/***/64978:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */W:()=>/* binding */_
/* harmony export */});
/* harmony import */var n=t(86087),o=t(56427),r=t(1455),i=t.n(r),l=t(18537),a=t(27723),c=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
const d={course:"courses",lesson:"lessons",question:"questions"},u=e=>(0,l.decodeEntities)(e.title?.rendered||e.title?.raw||"")
/**
 * Build a unique label for a post. When two posts share a title we
 * disambiguate with the post ID so FormTokenField (which works on
 * strings) can map labels back to IDs unambiguously.
 *
 * @param {Object}   item       Post item ({ id, title }).
 * @param {Object[]} knownItems Items in the same context to check for collisions.
 * @return {string} Display label for the token.
 */,p=(e,s)=>{const t=u(e),n=s.some((s=>s.id!==e.id&&u(s)===t)),o=t||(0,a.__)("(no title)","sensei-lms");return n||!t?`${o} (#${e.id})`:o},_=({type:e,ariaLabel:s,placeholder:t,selectedIds:r,onChange:l,cachedItems:a,onItemsFetched:u})=>{const[_,m]=(0,n.useState)(""),[f,y]=(0,n.useState)(""),[h,x]=(0,n.useState)([]);
// Debounce the search input so we don't fire a REST request per keystroke.
// Debounce the search input so we don't fire a REST request per keystroke.
(0,n.useEffect)((()=>{const e=setTimeout((()=>y(_)),300);return()=>clearTimeout(e)}),[_]),
// `cancelled` guards against an older request resolving after a newer one
// and clobbering its result.
// `cancelled` guards against an older request resolving after a newer one
// and clobbering its result.
(0,n.useEffect)((()=>{let s=!1;const t=new URLSearchParams({per_page:String(20),status:"any",_fields:"id,title",context:"edit"});return f&&t.set("search",f),i()({path:`/wp/v2/${d[e]}?${t.toString()}`}).then((e=>{s||(u(e),x(e.map((e=>e.id))))})).catch((t=>{s||(x([]),
// Suggestions failing leaves the dropdown empty, which is
// indistinguishable from "no matches" for the user. Surface
// the underlying reason for the developer console at least.
window.console?.warn(`[sensei export] failed to fetch ${e} suggestions`,t))})),()=>{s=!0};
// `onItemsFetched` is intentionally excluded; including it would re-run
// the effect on every parent render whenever the parent recreates the
// callback inline. The effect only needs to re-fire on type/search.
// eslint-disable-next-line react-hooks/exhaustive-deps
}),[e,f]);const w=Array.from(a.values()),j=r.map((e=>{const s=a.get(e);return s?p(s,w):`#${e}`})),b=h.filter((e=>!r.includes(e))).map((e=>p(a.get(e),w)));
// Fall back to "#<id>" when an id isn't in the cache yet — e.g. the page
// mounted with pre-selected ids we haven't fetched titles for.
return(0,c.jsx)(o.FormTokenField,{label:s,value:j,suggestions:b,onInputChange:m,onChange:e=>{
// Build a label → id index from every cached item, using the same
// `buildLabel` rules so the strings here match what the field renders.
const s=new Map;w.forEach((e=>s.set(p(e,w),e.id)));const t=[],n=new Set;e.forEach((e=>{
// Tokens come in as either a plain string or a `{ value }` object,
// depending on FormTokenField internals — normalize to a string.
const o="string"==typeof e?e:e?.value;
// Skip empties and duplicates (the field allows the same string
// to appear twice; we don't want the same post twice).
if(!o||n.has(o))return;n.add(o);
// If the label doesn't resolve to an id it's free text the user
// typed but didn't pick from suggestions — silently drop it.
const r=s.get(o);r&&t.push(r)})),l(t)},__experimentalExpandOnFocus:!0,__experimentalAutoSelectFirstMatch:!0,__experimentalShowHowTo:!1,__next40pxDefaultSize:!0,placeholder:t})}}
/***/,
/***/66161:
/***/e=>{"use strict";e.exports=window.wp.dataControls}
/***/,
/***/74073:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>l
/* harmony export */});
/* harmony import */var n=t(47143),o=t(29491),r=t(37283),i=t(87671);
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
(0,i/* ["default"] */.Ay)();
/* harmony default export */const l=(0,o.compose)((0,n.withSelect)((e=>({job:e(i/* .EXPORT_STORE */.zz).getJob(),error:e(i/* .EXPORT_STORE */.zz).getError()}))),(0,n.withDispatch)((e=>{const{start:s,cancel:t,reset:n}=e(i/* .EXPORT_STORE */.zz);return{start:s,cancel:t,reset:n}})))(r/* .ExportPage */.W);
/***/},
/***/75808:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */$:()=>/* binding */l
/* harmony export */});
/* harmony import */var n=t(4452),o=t.n(n),r=t(56427),i=t(62540);
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
const l=({message:e,isError:s})=>{const t=o()({"sensei-data-port-notice__message":!0,error:s});
return(0,i.jsxs)("div",{className:"sensei-data-port-notice",children:[s&&(0,i.jsx)(r.Dashicon,{className:"sensei-data-port-notice__icon error",icon:"warning"}),(0,i.jsx)("span",{className:t,children:e})]})};
/***/},
/***/77505:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */$x:()=>/* binding */o
/* harmony export */});
/* unused harmony exports composeFetchAction, createStore */
/* harmony import */t(47143);
/* harmony import */
/**
 * WordPress dependencies
 */
// We register the store in the global scope to avoid registering it multiple times.
// The reason to be in the global scope is that some times we have different built files using the same source.
window.senseiStores=window.senseiStores||[];const{senseiStores:n}=window,o=(e,s)=>(t=s,n)=>(e[n.type]||e.DEFAULT)(n,t);
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
/***/78432:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */I:()=>/* binding */o
/* harmony export */});
/* harmony import */var n=t(27723);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Per-content-type configuration for the export setup screen.
 *
 * Each row drives one checkbox + filter field on the page and provides the
 * translated strings used in the summary list. The `i18n` shape is consumed
 * by `summaryFor` in `export-select-content-page.js`.
 */
const o=[{type:"course",label:(0,n.__)("Courses","sensei-lms"),restBase:"courses",placeholder:(0,n.__)("Search to limit to specific courses…","sensei-lms"),filterAriaLabel:(0,n.__)("Filter courses to export","sensei-lms"),i18n:{skipped:(0,n.__)("Courses — skipped","sensei-lms"),unknownTotal:(0,n.__)("Courses","sensei-lms"),none:(0,n.__)("No courses","sensei-lms"),one:(0,n.__)("1 course","sensei-lms"),all:e=>(0,n.sprintf)(/* translators: %d is the total number of courses on the site. */ /* translators: %d is the total number of courses on the site. */
(0,n._n)("All %d course","All %d courses",e,"sensei-lms"),e),count:e=>(0,n.sprintf)(/* translators: %d is the number of courses selected. */ /* translators: %d is the number of courses selected. */
(0,n._n)("%d course","%d courses",e,"sensei-lms"),e),countOf:(e,s)=>(0,n.sprintf)(/* translators: 1: number of selected courses, 2: total courses. */ /* translators: 1: number of selected courses, 2: total courses. */
(0,n._n)("%1$d of %2$d course","%1$d of %2$d courses",s,"sensei-lms"),e,s)}},{type:"lesson",label:(0,n.__)("Lessons","sensei-lms"),restBase:"lessons",placeholder:(0,n.__)("Search to limit to specific lessons…","sensei-lms"),filterAriaLabel:(0,n.__)("Filter lessons to export","sensei-lms"),i18n:{skipped:(0,n.__)("Lessons — skipped","sensei-lms"),unknownTotal:(0,n.__)("Lessons","sensei-lms"),none:(0,n.__)("No lessons","sensei-lms"),one:(0,n.__)("1 lesson","sensei-lms"),all:e=>(0,n.sprintf)(/* translators: %d is the total number of lessons on the site. */ /* translators: %d is the total number of lessons on the site. */
(0,n._n)("All %d lesson","All %d lessons",e,"sensei-lms"),e),count:e=>(0,n.sprintf)(/* translators: %d is the number of lessons selected. */ /* translators: %d is the number of lessons selected. */
(0,n._n)("%d lesson","%d lessons",e,"sensei-lms"),e),countOf:(e,s)=>(0,n.sprintf)(/* translators: 1: number of selected lessons, 2: total lessons. */ /* translators: 1: number of selected lessons, 2: total lessons. */
(0,n._n)("%1$d of %2$d lesson","%1$d of %2$d lessons",s,"sensei-lms"),e,s)}},{type:"question",label:(0,n.__)("Questions","sensei-lms"),restBase:"questions",placeholder:(0,n.__)("Search to limit to specific questions…","sensei-lms"),filterAriaLabel:(0,n.__)("Filter questions to export","sensei-lms"),i18n:{skipped:(0,n.__)("Questions — skipped","sensei-lms"),unknownTotal:(0,n.__)("Questions","sensei-lms"),none:(0,n.__)("No questions","sensei-lms"),one:(0,n.__)("1 question","sensei-lms"),all:e=>(0,n.sprintf)(/* translators: %d is the total number of questions on the site. */ /* translators: %d is the total number of questions on the site. */
(0,n._n)("All %d question","All %d questions",e,"sensei-lms"),e),count:e=>(0,n.sprintf)(/* translators: %d is the number of questions selected. */ /* translators: %d is the number of questions selected. */
(0,n._n)("%d question","%d questions",e,"sensei-lms"),e),countOf:(e,s)=>(0,n.sprintf)(/* translators: 1: number of selected questions, 2: total questions. */ /* translators: 1: number of selected questions, 2: total questions. */
(0,n._n)("%1$d of %2$d question","%1$d of %2$d questions",s,"sensei-lms"),e,s)}}];
/***/},
/***/86087:
/***/e=>{"use strict";e.exports=window.wp.element}
/***/,
/***/87671:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */Ay:()=>m
/* harmony export */,zz:()=>/* binding */p
/* harmony export */});
/* unused harmony export EXPORT_STORE_OPTIONS */
/* harmony import */var n=t(47143),o=t(66161),r=t(54106),i=t(77505),l=t(32404);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
const a={},c=e=>e&&!e.deleted?{job:{...e,...e.status,files:e.files&&Object.values(e.files)}}:a,d={UPDATE_JOB:({job:e},s)=>s.job?c(e):s,SET_JOB:({job:e})=>c(e),SET_ERROR:({error:e},s)=>({...s,error:e}),CLEAR_JOB:()=>a,DEFAULT:(e,s)=>s},u={
/**
   * Check for active job on first access.
   */
getJob:()=>l.checkForActiveJob()},p="sensei/export",_={reducer:(0,i/* .createReducerFromActionMap */.$x)(d,a),actions:l,selectors:{getJobId:({job:e})=>e&&e.id||null,getJob:({job:e})=>e,getError:({error:e})=>e},resolvers:u,controls:{...o.controls,...r/* ["default"] */.Ay}},m=()=>(0,n.registerStore)(p,_)
/* harmony default export */}
/***/
/******/},s={};
/************************************************************************/
/******/ // The module cache
/******/
/******/
/******/ // The require function
/******/function t(n){
/******/ // Check if module is in cache
/******/var o=s[n];
/******/if(void 0!==o)
/******/return o.exports;
/******/
/******/ // Create a new module (and put it into the cache)
/******/var r=s[n]={
/******/ // no module.id needed
/******/ // no module.loaded needed
/******/exports:{}
/******/};
/******/
/******/ // Execute the module function
/******/
/******/
/******/ // Return the exports of the module
/******/return e[n](r,r.exports,t),r.exports;
/******/}
/******/
/************************************************************************/
/******/ /* webpack/runtime/compat get default export */
/******/
/******/ // getDefaultExport function for compatibility with non-harmony modules
/******/t.n=e=>{
/******/var s=e&&e.__esModule?
/******/()=>e.default
/******/:()=>e
/******/;
/******/return t.d(s,{a:s}),s;
/******/},
/******/ // define getter functions for harmony exports
/******/t.d=(e,s)=>{
/******/for(var n in s)
/******/t.o(s,n)&&!t.o(e,n)&&
/******/Object.defineProperty(e,n,{enumerable:!0,get:s[n]})
/******/;
/******/},
/******/t.o=(e,s)=>Object.prototype.hasOwnProperty.call(e,s)
/******/,
/******/ // define __esModule on exports
/******/t.r=e=>{
/******/"undefined"!=typeof Symbol&&Symbol.toStringTag&&
/******/Object.defineProperty(e,Symbol.toStringTag,{value:"Module"})
/******/,Object.defineProperty(e,"__esModule",{value:!0})}
/******/,
// This entry needs to be wrapped in an IIFE because it needs to be in strict mode.
(()=>{"use strict";
/* harmony import */var e=t(86087),s=t(74073),n=t(62540);
/* harmony import */(0,e.createRoot)(document.getElementById("sensei-export-page")).render((0/* ["default"] */,n.jsx)(s.A,{}))})()})
/******/();