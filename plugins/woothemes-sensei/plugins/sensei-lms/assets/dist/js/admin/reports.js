/******/(()=>{// webpackBootstrap
/******/"use strict";
/******/var e={
/***/98490:
/***/e=>{e.exports=window.wp.domReady;
/***/
/******/}},r={};
/************************************************************************/
/******/ // The module cache
/******/
/******/
/******/ // The require function
/******/function t(o){
/******/ // Check if module is in cache
/******/var a=r[o];
/******/if(void 0!==a)
/******/return a.exports;
/******/
/******/ // Create a new module (and put it into the cache)
/******/var n=r[o]={
/******/ // no module.id needed
/******/ // no module.loaded needed
/******/exports:{}
/******/};
/******/
/******/ // Execute the module function
/******/
/******/
/******/ // Return the exports of the module
/******/return e[o](n,n.exports,t),n.exports;
/******/}
/******/
/************************************************************************/
/******/ /* webpack/runtime/compat get default export */
/******/
/******/ // getDefaultExport function for compatibility with non-harmony modules
/******/t.n=e=>{
/******/var r=e&&e.__esModule?
/******/()=>e.default
/******/:()=>e
/******/;
/******/return t.d(r,{a:r}),r;
/******/},
/******/ // define getter functions for harmony exports
/******/t.d=(e,r)=>{
/******/for(var o in r)
/******/t.o(r,o)&&!t.o(e,o)&&
/******/Object.defineProperty(e,o,{enumerable:!0,get:r[o]})
/******/;
/******/},
/******/t.o=(e,r)=>Object.prototype.hasOwnProperty.call(e,r)
/******/;
/******/
/************************************************************************/
/* harmony import */var o=t(98490);
/* harmony import */
/**
 * WordPress dependencies
 */
t.n(o)()((()=>{jQuery(".sensei-date-picker").datepicker({dateFormat:"yy-mm-dd"});const e=Intl?.DateTimeFormat()?.resolvedOptions()?.timeZone;e&&jQuery('.sensei-analysis__top-filters input[name="timezone"]').val(e)}))})
/******/();