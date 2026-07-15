/******/(()=>{// webpackBootstrap
/******/"use strict";
/******/var e={
/***/27723:
/***/e=>{e.exports=window.wp.i18n;
/***/
/******/}},r={};
/************************************************************************/
/******/ // The module cache
/******/
/******/
/******/ // The require function
/******/function o(n){
/******/ // Check if module is in cache
/******/var t=r[n];
/******/if(void 0!==t)
/******/return t.exports;
/******/
/******/ // Create a new module (and put it into the cache)
/******/var i=r[n]={
/******/ // no module.id needed
/******/ // no module.loaded needed
/******/exports:{}
/******/};
/******/
/******/ // Execute the module function
/******/
/******/
/******/ // Return the exports of the module
/******/return e[n](i,i.exports,o),i.exports;
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
/******/for(var n in r)
/******/o.o(r,n)&&!o.o(e,n)&&
/******/Object.defineProperty(e,n,{enumerable:!0,get:r[n]})
/******/;
/******/},
/******/o.o=(e,r)=>Object.prototype.hasOwnProperty.call(e,r)
/******/;
/******/
/************************************************************************/
/* harmony import */var n=o(27723);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Add placeholder to tinymce editor
 *
 * @param editor tinymce editor.
 */
window.addPlaceholderInTinymceEditor=e=>{
// Remove placeholder on submit.
jQuery("#sensei-quiz-form").submit((function(){return e.dom.remove("multi-line-placeholder"),!0})),
// Add placeholder on init and blur.
e.on("blur init",(function(){""==e.getContent()&&e.setContent("<p id='multi-line-placeholder'>"+(0,n.__)("Your answer","sensei-lms")+"</p>")})),
// Remove placeholder on focus.
e.on("focus",(function(){e.dom.remove("multi-line-placeholder")}))}})
/******/();