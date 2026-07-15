/******/(()=>{// webpackBootstrap
/******/"use strict";
/******/var e={
/***/1455:
/***/e=>{e.exports=window.wp.apiFetch;
/***/},
/***/2192:
/***/(e,t,s)=>{var n=s(51609),i=Symbol.for("react.element"),r=Symbol.for("react.fragment"),o=Object.prototype.hasOwnProperty,a=n.__SECRET_INTERNALS_DO_NOT_USE_OR_YOU_WILL_BE_FIRED.ReactCurrentOwner,l={key:!0,ref:!0,__self:!0,__source:!0};
/**
 * @license React
 * react-jsx-runtime.production.min.js
 *
 * Copyright (c) Facebook, Inc. and its affiliates.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */function d(e,t,s){var n,r={},d=null,c=null;for(n in void 0!==s&&(d=""+s),void 0!==t.key&&(d=""+t.key),void 0!==t.ref&&(c=t.ref),t)o.call(t,n)&&!l.hasOwnProperty(n)&&(r[n]=t[n]);if(e&&e.defaultProps)for(n in t=e.defaultProps)void 0===r[n]&&(r[n]=t[n]);return{$$typeof:i,type:e,key:d,ref:c,props:r,_owner:a.current}}t.jsx=d,t.jsxs=d}
/***/,
/***/7894:
/***/(e,t,s)=>{
/* harmony export */s.d(t,{
/* harmony export */O:()=>/* binding */i
/* harmony export */});
/* harmony import */var n=s(27723);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Exit survey reasons
 */
const i=[{id:"no-longer-need",label:(0,n.__)("I no longer need the plugin","sensei-lms")},{id:"not-working",label:(0,n.__)("The plugin isn't working","sensei-lms"),detailsLabel:(0,n.__)("What isn't working properly?","sensei-lms")},{id:"different-functionality",label:(0,n.__)("I'm looking for different functionality","sensei-lms"),detailsLabel:(0,n.__)("What functionality is missing?","sensei-lms")},{id:"found-better-plugin",label:(0,n.__)("I found a better plugin","sensei-lms"),detailsLabel:(0,n.__)("What's the name of the plugin?","sensei-lms")},{id:"temporary",label:(0,n.__)("It's a temporary deactivation","sensei-lms")},{id:"other",label:"Other",detailsLabel:(0,n.__)("Why are you deactivating?","sensei-lms")}];
/***/},
/***/27723:
/***/e=>{e.exports=window.wp.i18n;
/***/},
/***/51609:
/***/e=>{e.exports=window.React;
/***/},
/***/62540:
/***/(e,t,s)=>{e.exports=s(2192)}
/***/,
/***/80757:
/***/(e,t,s)=>{
/* harmony export */s.d(t,{
/* harmony export */Y:()=>/* binding */i
/* harmony export */});
/* harmony import */var n=s(62540);
/**
 * Exit survey reason item with details text field.
 *
 * @param {Object} props
 * @param {string} props.id           Option key.
 * @param {string} props.label        Option text label.
 * @param {string} props.detailsLabel Label for details field.
 */const i=({id:e,label:t,detailsLabel:s})=>{const i=`sensei-exit-reason__${e}`,r=`${i}-details`;
return(0,n.jsxs)("div",{className:"sensei-exit-survey__item",children:[(0,n.jsx)("input",{id:i,type:"radio",name:"reason",value:e,className:"sensei-exit-survey__radio"}),(0,n.jsxs)("label",{htmlFor:i,children:[" ",t]}),s&&(0,n.jsx)("div",{className:"sensei-exit-survey__details",children:(0,n.jsx)("input",{id:r,name:`details-${e}`,defaultValue:"",type:"text",placeholder:s})})]})};
/***/},
/***/86087:
/***/e=>{e.exports=window.wp.element;
/***/},
/***/98769:
/***/(e,t,s)=>{
/* harmony export */s.d(t,{
/* harmony export */V:()=>/* binding */l
/* harmony export */});
/* harmony import */var n=s(86087),i=s(27723),r=s(80757),o=s(7894),a=s(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Exit survey form.
 *
 * @param {Object}   props
 * @param {Function} props.submit Callback to submit feedback.
 * @param {Function} props.skip   Callback to skip feedback.
 */
const l=({submit:e,skip:t})=>{const s=(0,n.useRef)(null),[,l]=(0,n.useState)(null),d=(0,n.useCallback)((t=>{t.preventDefault();const n=new window.FormData(s.current),i=n.get("reason");e({reason:i,details:i&&n.get(`details-${i}`)})}),[e]);let c=!1;if(s.current){const e=new window.FormData(s.current),t=`details-${e.get("reason")}`,n=s.current?.elements[t]||!1;c=!(!e.get("reason")||n&&""===e.get(t).trim())}
return(0,a.jsxs)("form",{onChange:()=>{const e=new window.FormData(s.current);l(e.values())},className:"sensei-modal sensei-exit-survey",ref:s,onSubmit:d,children:[(0,a.jsxs)("div",{className:"sensei-exit-survey__content",children:[(0,a.jsx)("h2",{children:(0,i.__)("Quick Feedback","sensei-lms")}),(0,a.jsx)("p",{children:(0,i.__)("If you have a moment, please let us know why you are deactivating so that we can work to improve our product.","sensei-lms")}),o/* .reasons */.O.map((e=>(0/* .ExitSurveyFormItem */,a.jsx)(r.Y,{...e},e.id)))]}),(0,a.jsxs)("div",{className:"sensei-exit-survey__buttons",children:[(0,a.jsx)("button",{className:"button button-primary",type:"submit",disabled:!c,children:(0,i.__)("Submit Feedback","sensei-lms")}),(0,a.jsx)("button",{className:"button button-secondary",onClick:t,type:"button",children:(0,i.__)("Skip Feedback","sensei-lms")})]})]})};
/***/
/******/}},t={};
/************************************************************************/
/******/ // The module cache
/******/
/******/
/******/ // The require function
/******/function s(n){
/******/ // Check if module is in cache
/******/var i=t[n];
/******/if(void 0!==i)
/******/return i.exports;
/******/
/******/ // Create a new module (and put it into the cache)
/******/var r=t[n]={
/******/ // no module.id needed
/******/ // no module.loaded needed
/******/exports:{}
/******/};
/******/
/******/ // Execute the module function
/******/
/******/
/******/ // Return the exports of the module
/******/return e[n](r,r.exports,s),r.exports;
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
/******/for(var n in t)
/******/s.o(t,n)&&!s.o(e,n)&&
/******/Object.defineProperty(e,n,{enumerable:!0,get:t[n]})
/******/;
/******/},
/******/s.o=(e,t)=>Object.prototype.hasOwnProperty.call(e,t)
/******/;
/* harmony import */var n=s(1455),i=s.n(n),r=s(86087),o=s(98769),a=s(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
!function(){
/**
   * Id of the container the survey is mounted into.
   */
const e="sensei-exit-survey-modal";
/**
   * The single React root for the survey, reused across opens.
   *
   * @type {?Object}
   */let t=null;
/**
   * Add exit survey modal when clicking the Deactivate link for Sensei LMS plugin.
   */
/**
   * Exit survey modal.
   */
class s{href;container;root;
/**
     * Exit survey constructor.
     *
     * @param {string} href Link to deactivate plugin.
     */
constructor({href:e}){this.href=e}
/**
     * Create and open a modal with an exit survey form.
     *
     */open=()=>{let s=document.getElementById(e);s||(s=document.createElement("div"),s.setAttribute("id",e),document.body.appendChild(s)),this.container=s,
// Reuse a single root so repeated opens don't mount twice
// into the same container.
t||(t=(0,r.createRoot)(s)),this.root=t,this.root.render((0/* .ExitSurveyForm */,a.jsx)(o.V,{submit:this.submitExitSurvey,skip:this.closeAndDeactivate}))};
/**
     * Submit exit survey to AJAX endpoint.
     *
     * @param {Object} data
     */
submitExitSurvey=async e=>{const t=new window.FormData;t.append("action","exit_survey"),t.append("_wpnonce",window.sensei_exit_survey?.nonce),t.append("reason",e.reason),t.append("details",e.details);
// Get the name of the active theme.
try{const e=await i()({path:"/wp/v2/themes?status=active"});e.length>0&&t.append("theme",e[0].name?.raw||"")}catch(e){}await window.fetch(window.ajaxurl,{method:"POST",body:t}),this.closeAndDeactivate()};
/**
     * Close survey modal and continue plugin deactivation.
     */
closeAndDeactivate=()=>{this.root?.unmount(),t=null,this.container.remove(),window.location=this.href}}(()=>{const e=e=>document.querySelector(`#the-list [data-slug="${e}"] span.deactivate a`);[e("sensei-lms"),e("sensei-pro-wc-paid-courses"),e("sensei-with-woocommerce-paid-courses"),e("woocommerce-com-woocommerce-paid-courses")].filter((e=>!!e)).forEach((e=>{e.addEventListener("click",(e=>{e.preventDefault(),new s({href:e.target.href}).open()}))}))})()}()})
/******/();