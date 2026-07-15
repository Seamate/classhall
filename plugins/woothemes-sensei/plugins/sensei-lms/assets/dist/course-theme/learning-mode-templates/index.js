/******/(()=>{// webpackBootstrap
/******/var e={
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
 */var r=s(51609),n=Symbol.for("react.element"),i=Symbol.for("react.fragment"),l=Object.prototype.hasOwnProperty,o=r.__SECRET_INTERNALS_DO_NOT_USE_OR_YOU_WILL_BE_FIRED.ReactCurrentOwner,a={key:!0,ref:!0,__self:!0,__source:!0};function c(e,t,s){var r,i={},c=null,u=null;for(r in void 0!==s&&(c=""+s),void 0!==t.key&&(c=""+t.key),void 0!==t.ref&&(u=t.ref),t)l.call(t,r)&&!a.hasOwnProperty(r)&&(i[r]=t[r]);if(e&&e.defaultProps)for(r in t=e.defaultProps)void 0===i[r]&&(i[r]=t[r]);return{$$typeof:n,type:e,key:c,ref:u,props:i,_owner:o.current}}t.Fragment=i,t.jsx=c,t.jsxs=c}
/***/,
/***/4452:
/***/(e,t)=>{var s;
/*!
	Copyright (c) 2018 Jed Watson.
	Licensed under the MIT License (MIT), see
	http://jedwatson.github.io/classnames
*/
/* global define */!function(){"use strict";var r={}.hasOwnProperty;function n(){for(var e="",t=0;t<arguments.length;t++){var s=arguments[t];s&&(e=l(e,i(s)))}return e}function i(e){if("string"==typeof e||"number"==typeof e)return e;if("object"!=typeof e)return"";if(Array.isArray(e))return n.apply(null,e);if(e.toString!==Object.prototype.toString&&!e.toString.toString().includes("[native code]"))return e.toString();var t="";for(var s in e)r.call(e,s)&&e[s]&&(t=l(t,s));return t}function l(e,t){return t?e?e+" "+t:e+t:e}e.exports?(n.default=n,e.exports=n):void 0===(s=function(){return n}.apply(t,[]))||(e.exports=s)}()}
/***/,
/***/24206:
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */HJ:()=>/* binding */c
/* harmony export */,Us:()=>/* binding */n
/* harmony export */,du:()=>/* binding */o
/* harmony export */,eV:()=>/* binding */a
/* harmony export */,kT:()=>/* binding */l
/* harmony export */,yu:()=>/* binding */i
/* harmony export */});const r=window.sensei?.learningModeTemplateSetting||{},n=r.value,i=r.name,l=r.options,o=r.customizeUrl,a=r.formId,c=r.section}
/***/,
/***/27723:
/***/e=>{"use strict";e.exports=window.wp.i18n}
/***/,
/***/48583:
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */H:()=>/* binding */c
/* harmony export */});
/* harmony import */var r=s(4452),n=s.n(r),i=s(27723),l=s(70728),o=s(64778),a=s(62540);
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
 * Renders the Learning Mode template option's footer.
 *
 * @param {Object} props
 * @param {string} props.name       The name of the template.
 * @param {string} props.title      The title of the template.
 * @param {string} props.isActive   Tells if the current template is activated.
 * @param {Object} props.upsell     The upsell data.
 * @param {string} props.upsell.tag The upsell tag.
 */
const c=e=>{const{title:t,isActive:s,upsell:r}=e;
return(0,a.jsxs)("div",{className:n()({"sensei-lm-template-option__footer":!0,"sensei-lm-template-option__footer--active":s}),children:[(0/* .TemplateOptionTitle */,a.jsx)(l._,{isActive:s,tag:s?t:r?.tag,children:s?(0,i.__)("Active","sensei-lms"):t}),(0,a.jsx)("div",{className:"sensei-lm-template-option__actions",children:(0/* .TemplateActions */,a.jsx)(o.u,{...e})})]})};
/***/},
/***/51609:
/***/e=>{"use strict";e.exports=window.React}
/***/,
/***/55284:
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */U:()=>/* binding */c
/* harmony export */});
/* harmony import */var r=s(86087),n=s(24206),i=s(90907),l=s(58009),o=s(51609),a=s(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
const c=()=>{const[e,t]=(0,r.useState)(null),s=n/* .templates */.kT[e]||{},c=(0,r.useCallback)((e=>t(e)),[]),u=(0,r.useCallback)((()=>t(null)),[]);
return(0,a.jsxs)(a.Fragment,{children:[Object.keys(n/* .templates */.kT).map((e=>{const t=n/* .templates */.kT[e];
return(0/* .TemplateOption */,o.createElement)(i.Y,{...t,key:t.name,isActive:n/* .activeTemplateName */.Us===t.name,onPreview:c})})),e&&(0/* .TemplatePreview */,a.jsx)(l.p,{...s,onClose:u,isActive:n/* .activeTemplateName */.Us===s.name})]})};
/***/},
/***/56427:
/***/e=>{"use strict";e.exports=window.wp.components}
/***/,
/***/58009:
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */p:()=>/* binding */o
/* harmony export */});
/* harmony import */var r=s(56427),n=s(27723),i=s(64778),l=s(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Renders the template preview.
 *
 * @param {Object}   props
 * @param {Function} props.onClose          Handles the modal closing.
 * @param {string}   props.title            The title of the template.
 * @param {Object}   props.screenshots      The url of the screenshots.
 * @param {string}   props.screenshots.full The url of the full size screenshot.
 */
const o=e=>{const{onClose:t,title:s,screenshots:o}=e;
return(0,l.jsx)(r.Modal,{onRequestClose:t,title:(0,n.sprintf)((0,n.__)("Preview %1$s","sensei-lms"),s),className:"sensei-lm-template-preview__modal",children:(0,l.jsxs)("div",{className:"sensei-lm-template-preview__container",children:[(0,l.jsx)("div",{className:"sensei-lm-template-preview__img",children:(0,l.jsx)("img",{alt:s,src:o.full})}),(0,l.jsxs)("div",{className:"sensei-lm-template-preview__footer",children:[(0,l.jsx)(r.Button,{className:"sensei-lm-template-preview__cancel-btn",onClick:t,variant:"tertiary",children:(0,n.__)("Cancel","sensei-lms")}),(0/* .TemplateActions */,l.jsx)(i.u,{...e})]})]})})};
/***/},
/***/62540:
/***/(e,t,s)=>{"use strict";e.exports=s(2192)}
/***/,
/***/64778:
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */u:()=>/* binding */a
/* harmony export */});
/* harmony import */var r=s(86087),n=s(27723),i=s(56427),l=s(24206),o=s(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Renders the template action buttons.
 *
 * @param {Object}  props
 * @param {string}  props.name         The name of the template.
 * @param {Object}  props.upsell       The template upsell data.
 * @param {string}  props.upsell.title The upsell cta title.
 * @param {string}  props.upsell.url   The upsell url.
 * @param {boolean} props.isActive     Tells if this template is activated.
 */
const a=e=>{const{upsell:t,name:s,isActive:a}=e,c=(0,r.useCallback)((()=>{const e=document.querySelector(`#${l/* .formId */.eV} input[name="_wp_http_referer"]`),t=e.getAttribute("value");e.setAttribute("value",`${t}#${l/* .tabId */.HJ}`)}),[]);
// Update the _wp_http_referer so it opens the current settings
// tab after page refresh.
return(0,o.jsxs)(o.Fragment,{children:[t&&(0,o.jsx)(i.Button,{isPrimary:!0,href:t.url,target:"_blank",children:t.title}),!a&&!t&&(0,o.jsx)(i.Button,{isPrimary:!0,type:"submit",value:s,name:l/* .inputName */.yu,form:l/* .formId */.eV,onClick:c,children:(0,n.__)("Activate","sensei-lms")}),a&&(0,o.jsx)(i.Button,{isPrimary:!0,href:l/* .customizeUrl */.du,children:(0,n.__)("Customize","sensei-lms")})]})};
/***/},
/***/70728:
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */_:()=>/* binding */l
/* harmony export */});
/* harmony import */var r=s(4452),n=s.n(r),i=s(62540);
/* harmony import */
/**
 * External dependencies
 */
/**
 * Renders a template option title.
 *
 * @param {Object}  props
 * @param {string}  props.children The title.
 * @param {string}  props.tag      A tag for template to indicate it belongs to some group of templates. E.g.: "PREMIUM"
 * @param {boolean} props.isActive If the template is activated.
 */
const l=({children:e,isActive:t,tag:s=""})=>(0,i.jsxs)("h4",{className:n()({"sensei-lm-template-option__title":!0,"sensei-lm-template-option__title--active":t}),children:[e,s&&(0,i.jsxs)(i.Fragment,{children:[": ",(0,i.jsx)("span",{className:"sensei-lm-template-option__title-tag",children:s})]})]});
/***/},
/***/79738:
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */u:()=>/* binding */i
/* harmony export */});
/* harmony import */var r=s(27723),n=s(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Renders the Learning Mode template thumbnail.
 *
 * @param {Object}   props
 * @param {string}   props.title     The title of the template.
 * @param {string}   props.url       The url of the image.
 * @param {Function} props.onPreview The callback to show preview.
 */
const i=({title:e,url:t,onPreview:s})=>(0,n.jsxs)("div",{className:"sensei-lm-template-option__thumbnail",onKeyPress:s,onClick:s,tabIndex:"0",role:"option",title:e,children:[(0,n.jsx)("img",{alt:e,src:t}),(0,n.jsx)("div",{className:"sensei-lm-template-option__preview",children:(0,n.jsx)("h4",{className:"sensei-lm-template-option__preview-title",children:(0,r.__)("Preview","sensei-lms")})})]});
/***/},
/***/86087:
/***/e=>{"use strict";e.exports=window.wp.element}
/***/,
/***/90907:
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */Y:()=>/* binding */o
/* harmony export */});
/* harmony import */var r=s(86087),n=s(48583),i=s(79738),l=s(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Renders the individual template.
 *
 * @param {Object}   props
 * @param {string}   props.name                  The name of the template.
 * @param {string}   props.title                 The title of the template.
 * @param {Object}   props.screenshots           The urls to screenshot images of the template.
 * @param {string}   props.screenshots.thumbnail The url to the thumbnail screenshot of the template.
 * @param {Function} props.onPreview             The callback that handles the preview.
 */
const o=e=>{const{name:t,title:s,screenshots:o,onPreview:a}=e,c=(0,r.useCallback)((()=>a(t)),[a,t]);
return(0,l.jsxs)("li",{className:"sensei-lm-template-option__container",children:[(0/* .TemplateOptionThumbnail */,l.jsx)(i.u,{title:s,url:o.thumbnail,onPreview:c}),(0/* .TemplateOptionFooter */,l.jsx)(n.H,{...e})]})};
/***/
/******/}},t={};
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
/******/var i=t[r]={
/******/ // no module.id needed
/******/ // no module.loaded needed
/******/exports:{}
/******/};
/******/
/******/ // Execute the module function
/******/
/******/
/******/ // Return the exports of the module
/******/return e[r](i,i.exports,s),i.exports;
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
// This entry needs to be wrapped in an IIFE because it needs to be in strict mode.
(()=>{"use strict";
/* harmony import */var e=s(86087),t=s(55284),r=s(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
const n=document.getElementById("sensei-lm-block-template__options");n&&(0,e.createRoot)(n).render((0/* .TemplateSelector */,r.jsx)(t.U,{}))})()})
/******/();