/******/(()=>{// webpackBootstrap
/******/"use strict";
/******/var e={
/***/2192:
/***/(e,r,o)=>{var s=o(51609),n=Symbol.for("react.element"),t=Symbol.for("react.fragment"),i=Object.prototype.hasOwnProperty,l=s.__SECRET_INTERNALS_DO_NOT_USE_OR_YOU_WILL_BE_FIRED.ReactCurrentOwner,_={key:!0,ref:!0,__self:!0,__source:!0};
/**
 * @license React
 * react-jsx-runtime.production.min.js
 *
 * Copyright (c) Facebook, Inc. and its affiliates.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */function d(e,r,o){var s,t={},d=null,p=null;for(s in void 0!==o&&(d=""+o),void 0!==r.key&&(d=""+r.key),void 0!==r.ref&&(p=r.ref),r)i.call(r,s)&&!_.hasOwnProperty(s)&&(t[s]=r[s]);if(e&&e.defaultProps)for(s in r=e.defaultProps)void 0===t[s]&&(t[s]=r[s]);return{$$typeof:n,type:e,key:d,ref:p,props:t,_owner:l.current}}r.jsx=d,r.jsxs=d}
/***/,
/***/27723:
/***/e=>{e.exports=window.wp.i18n;
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
/***/(e,r,o)=>{e.exports=o(2192)}
/***/,
/***/96516:
/***/(e,r,o)=>{
/* harmony export */o.d(r,{
/* harmony export */h:()=>/* binding */s
/* harmony export */});
/* unused harmony export getSenseiProCheckoutUrl */
/**
 * Get the Sensei Pro upgrade URL.
 *
 * @param {string} campaign The campaign name.
 *
 * @return {string} The upgrade URL.
 */
const s=(e="")=>{const{upsellUrl:r}=window.sensei_admin;return`${r}?${new URLSearchParams({utm_source:"plugin_sensei",utm_medium:"upsell",utm_campaign:e}).toString()}`};
/**
 * Get the Sensei Pro checkout URL.
 *
 * @param {string} campaign The campaign name.
 *
 * @return {string} The checkout URL.
 */}
/***/
/******/},r={};
/************************************************************************/
/******/ // The module cache
/******/
/******/
/******/ // The require function
/******/function o(s){
/******/ // Check if module is in cache
/******/var n=r[s];
/******/if(void 0!==n)
/******/return n.exports;
/******/
/******/ // Create a new module (and put it into the cache)
/******/var t=r[s]={
/******/ // no module.id needed
/******/ // no module.loaded needed
/******/exports:{}
/******/};
/******/
/******/ // Execute the module function
/******/
/******/
/******/ // Return the exports of the module
/******/return e[s](t,t.exports,o),t.exports;
/******/}
/******/
/************************************************************************/
/******/ /* webpack/runtime/compat get default export */
/******/
/******/ // getDefaultExport function for compatibility with non-harmony modules
/******/o.n=e=>{
/******/var r=e&&e.__esModule?
/******/()=>e.default
/******/:()=>e
/******/;
/******/return o.d(r,{a:r}),r;
/******/},
/******/ // define getter functions for harmony exports
/******/o.d=(e,r)=>{
/******/for(var s in r)
/******/o.o(r,s)&&!o.o(e,s)&&
/******/Object.defineProperty(e,s,{enumerable:!0,get:r[s]})
/******/;
/******/},
/******/o.o=(e,r)=>Object.prototype.hasOwnProperty.call(e,r)
/******/;
/* harmony import */var s=o(27723),n=o(52619),t=o(56427),i=o(96516),l=o(62540);
/* harmony import */(0,n.addFilter)("senseiQuestionTypeToolbarOptions","sensei-lms/ordering-promo",(
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
function(e){return e.push({title:(0,s.__)("Ordering","sensei-lms"),description:(0,s.__)("Place the answers in the correct order.","sensei-lms"),label:(0,s.__)("Ordering","sensei-lms"),value:"ordering",disabled:!0}),e})),(0,n.addFilter)("senseiQuestionTypeToolbarOptionChildren","sensei-lms/ordering-promo",(function(e,r){return"ordering"!==r.value?e:(0,l.jsxs)("div",{className:"sensei-lms-question-block__type-selector__option__container--disabled",children:[(0,l.jsxs)("strong",{children:[" ",r.title]}),(0,l.jsx)("div",{className:"sensei-lms-question-block__type-selector__option__description sensei-lms-question-block__type-selector__option__description--disabled",children:r.description}),(0,l.jsx)(t.ExternalLink,{href:(0,i/* .getSenseiProUpsellUrl */.h)("quiz_ordering_question_type"),children:(0,s.__)("Upgrade to Sensei Pro","sensei-lms")})]})}))})
/******/();