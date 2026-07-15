/******/(()=>{// webpackBootstrap
/******/"use strict";
/******/var t={
/***/52619:
/***/t=>{t.exports=window.wp.hooks;
/***/},
/***/66087:
/***/t=>{t.exports=window.lodash;
/***/
/******/}},o={};
/************************************************************************/
/******/ // The module cache
/******/
/******/
/******/ // The require function
/******/function r(e){
/******/ // Check if module is in cache
/******/var a=o[e];
/******/if(void 0!==a)
/******/return a.exports;
/******/
/******/ // Create a new module (and put it into the cache)
/******/var s=o[e]={
/******/ // no module.id needed
/******/ // no module.loaded needed
/******/exports:{}
/******/};
/******/
/******/ // Execute the module function
/******/
/******/
/******/ // Return the exports of the module
/******/return t[e](s,s.exports,r),s.exports;
/******/}
/******/
/************************************************************************/
/******/ /* webpack/runtime/compat get default export */
/******/
/******/ // getDefaultExport function for compatibility with non-harmony modules
/******/r.n=t=>{
/******/var o=t&&t.__esModule?
/******/()=>t.default
/******/:()=>t
/******/;
/******/return r.d(o,{a:o}),o;
/******/},
/******/ // define getter functions for harmony exports
/******/r.d=(t,o)=>{
/******/for(var e in o)
/******/r.o(o,e)&&!r.o(t,e)&&
/******/Object.defineProperty(t,e,{enumerable:!0,get:o[e]})
/******/;
/******/},
/******/r.o=(t,o)=>Object.prototype.hasOwnProperty.call(t,o)
/******/;
/* unused harmony export default */
/* harmony import */var e=r(52619),a=r(66087);
/* harmony import */(0,e.addFilter)("blocks.registerBlockType","sensei-lms/email-blocks",(
/**
   * Update the blocks to remove extra settings when used in email editor.
   *
   * @param {Object} settings Block settings.
   * @param {string} name     Block name.
   */
function(t,o){const r={...t.supports?t.supports:{}};
// Remove font family setting.
return((0,a.has)(t,"supports.typography.fontFamily")||(0,a.has)(t,"supports.typography.__experimentalFontFamily"))&&(r.typography={...r.typography,__experimentalFontFamily:!1,fontFamily:!1}),
// Remove alignWide setting.
(0,a.has)(t,"supports.alignWide")&&(r.alignWide=!1),
// Remove wide from align options.
(0,a.has)(t,"supports.align.length")&&(r.align=r.align.filter((t=>"wide"!==t))),
// Alignment is not supported for buttons block in emails.
"core/buttons"===o&&(0,a.has)(r,"layout")&&(r.layout=!1),
// Alingment is not supported for image block in emails.
"core/image"===o&&(0,a.has)(r,"align")&&(r.align=!1),{...t,supports:r}}),10)})
/******/();