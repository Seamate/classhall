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
/******/function t(n){
/******/ // Check if module is in cache
/******/var o=r[n];
/******/if(void 0!==o)
/******/return o.exports;
/******/
/******/ // Create a new module (and put it into the cache)
/******/var a=r[n]={
/******/ // no module.id needed
/******/ // no module.loaded needed
/******/exports:{}
/******/};
/******/
/******/ // Execute the module function
/******/
/******/
/******/ // Return the exports of the module
/******/return e[n](a,a.exports,t),a.exports;
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
/******/for(var n in r)
/******/t.o(r,n)&&!t.o(e,n)&&
/******/Object.defineProperty(e,n,{enumerable:!0,get:r[n]})
/******/;
/******/},
/******/t.o=(e,r)=>Object.prototype.hasOwnProperty.call(e,r)
/******/;
/******/
/************************************************************************/
/* harmony import */var n=t(98490);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Handles uploading a file for a file upload question.
 *
 */
t.n(n)()((()=>{document.querySelectorAll(".sensei-lms-question-block__file-input").forEach((e=>{e.addEventListener("change",(e=>{const r=e.target,t=r.files?.[0],n=r.parentElement.parentElement.querySelector(".sensei-lms-question-block__file-upload-name");n&&(n.innerText=t&&t.name)}))}))}))})
/******/();