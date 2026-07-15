/******/(()=>{// webpackBootstrap
/******/"use strict";
/******/var e={
/***/2192:
/***/(e,n,r)=>{
/**
 * @license React
 * react-jsx-runtime.production.min.js
 *
 * Copyright (c) Facebook, Inc. and its affiliates.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */
var t=r(51609),o=Symbol.for("react.element"),s=Symbol.for("react.fragment"),i=Object.prototype.hasOwnProperty,a=t.__SECRET_INTERNALS_DO_NOT_USE_OR_YOU_WILL_BE_FIRED.ReactCurrentOwner,l={key:!0,ref:!0,__self:!0,__source:!0};function c(e,n,r){var t,s={},c=null,p=null;for(t in void 0!==r&&(c=""+r),void 0!==n.key&&(c=""+n.key),void 0!==n.ref&&(p=n.ref),n)i.call(n,t)&&!l.hasOwnProperty(t)&&(s[t]=n[t]);if(e&&e.defaultProps)for(t in n=e.defaultProps)void 0===s[t]&&(s[t]=n[t]);return{$$typeof:o,type:e,key:c,ref:p,props:s,_owner:a.current}}n.Fragment=s,n.jsx=c,n.jsxs=c}
/***/,
/***/12417:
/***/(e,n,r)=>{
/* harmony export */r.d(n,{
/* harmony export */A:()=>o
/* harmony export */});
/* harmony import */var t=r(86087);
/* harmony import */
/* harmony default export */const o=(0,t.forwardRef)((
/**
 * WordPress dependencies
 */
/** @typedef {{icon: JSX.Element, size?: number} & import('@wordpress/primitives').SVGProps} IconProps */
/**
 * Return an SVG icon.
 *
 * @param {IconProps}                                 props icon is the SVG component to render
 *                                                          size is a number specifying the icon size in pixels
 *                                                          Other props will be passed to wrapped SVG component
 * @param {import('react').ForwardedRef<HTMLElement>} ref   The forwarded ref to the SVG element.
 *
 * @return {JSX.Element}  Icon component
 */
function({icon:e,size:n=24,...r},o){return(0,t.cloneElement)(e,{width:n,height:n,...r,ref:o})}));
//# sourceMappingURL=index.js.map
/***/},
/***/27723:
/***/e=>{e.exports=window.wp.i18n;
/***/},
/***/29491:
/***/e=>{e.exports=window.wp.compose;
/***/},
/***/51609:
/***/e=>{e.exports=window.React;
/***/},
/***/52619:
/***/e=>{e.exports=window.wp.hooks;
/***/},
/***/56427:
/***/e=>{e.exports=window.wp.components;
/***/},
/***/62540:
/***/(e,n,r)=>{e.exports=r(2192)}
/***/,
/***/65419:
/***/(e,n,r)=>{
/* harmony export */r.d(n,{
/* harmony export */A:()=>i
/* harmony export */});
/* harmony import */var t,o=r(51609);
/* harmony import */function s(){return s=Object.assign?Object.assign.bind():function(e){for(var n=1;n<arguments.length;n++){var r=arguments[n];for(var t in r)({}).hasOwnProperty.call(r,t)&&(e[t]=r[t])}return e},s.apply(null,arguments)}
/* harmony default export */const i=function(e){
return o.createElement("svg",s({width:24,height:24,fill:"none",xmlns:"http://www.w3.org/2000/svg"},e),t||(t=o.createElement("path",{fillRule:"evenodd",clipRule:"evenodd",d:"M16.5 9.25a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0ZM10 13.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm4.75 3a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z",fill:"#00594F"})))};
/***/},
/***/86087:
/***/e=>{e.exports=window.wp.element;
/***/},
/***/96516:
/***/(e,n,r)=>{
/* harmony export */r.d(n,{
/* harmony export */h:()=>/* binding */t
/* harmony export */});
/* unused harmony export getSenseiProCheckoutUrl */
/**
 * Get the Sensei Pro upgrade URL.
 *
 * @param {string} campaign The campaign name.
 *
 * @return {string} The upgrade URL.
 */
const t=(e="")=>{const{upsellUrl:n}=window.sensei_admin;return`${n}?${new URLSearchParams({utm_source:"plugin_sensei",utm_medium:"upsell",utm_campaign:e}).toString()}`};
/**
 * Get the Sensei Pro checkout URL.
 *
 * @param {string} campaign The campaign name.
 *
 * @return {string} The checkout URL.
 */}
/***/
/******/},n={};
/************************************************************************/
/******/ // The module cache
/******/
/******/
/******/ // The require function
/******/function r(t){
/******/ // Check if module is in cache
/******/var o=n[t];
/******/if(void 0!==o)
/******/return o.exports;
/******/
/******/ // Create a new module (and put it into the cache)
/******/var s=n[t]={
/******/ // no module.id needed
/******/ // no module.loaded needed
/******/exports:{}
/******/};
/******/
/******/ // Execute the module function
/******/
/******/
/******/ // Return the exports of the module
/******/return e[t](s,s.exports,r),s.exports;
/******/}
/******/
/************************************************************************/
/******/ /* webpack/runtime/compat get default export */
/******/
/******/ // getDefaultExport function for compatibility with non-harmony modules
/******/r.n=e=>{
/******/var n=e&&e.__esModule?
/******/()=>e.default
/******/:()=>e
/******/;
/******/return r.d(n,{a:n}),n;
/******/},
/******/ // define getter functions for harmony exports
/******/r.d=(e,n)=>{
/******/for(var t in n)
/******/r.o(n,t)&&!r.o(e,t)&&
/******/Object.defineProperty(e,t,{enumerable:!0,get:n[t]})
/******/;
/******/},
/******/r.o=(e,n)=>Object.prototype.hasOwnProperty.call(e,n)
/******/;
/* unused harmony export addQuestionGeneratorUpsellButtonToQuizBlock */
/* harmony import */var t=r(56427),o=r(27723),s=r(52619),i=r(29491),a=r(12417),l=r(65419),c=r(96516),p=r(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
const u=e=>n=>(0,p.jsxs)(p.Fragment,{children:[(0,p.jsx)(t.Fill,{name:"SenseiQuizHeader",children:(0,p.jsxs)(t.Button,{variant:"secondary",className:"sensei-pro-ai-generate-questions-button upsell",onClick:()=>{window.open((0,c/* .getSenseiProUpsellUrl */.h)("question-ai"),"_blank")},children:[(0,p.jsxs)("div",{className:"button-text-content",children:[(0/* ["default"] */,p.jsx)(a.A,{icon:(0/* ["default"] */,p.jsx)(l.A,{})}),(0,o.__)("Generate quiz questions with AI","sensei-pro")]}),(0,p.jsx)("span",{className:"awaiting-mod sensei-upsell-pro-badge",children:(0,o.__)("Pro","sensei-lms")})]})}),(0,p.jsx)(e,{...n})]});(0,s.addFilter)("blocks.registerBlockType","sensei-lms/with-chat-gpt-question-generator",(e=>"sensei-lms/quiz"!==e.name?e:{...e,edit:(0,i.compose)(u)(e.edit)}))})
/******/();