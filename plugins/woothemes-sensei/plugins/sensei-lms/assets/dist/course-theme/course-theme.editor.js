/******/(()=>{// webpackBootstrap
/******/"use strict";
/******/var e={
/***/12418:
/***/(e,t,r)=>{
/* unused harmony export StylesProbe */
/**
 * Probe base colors and update Sensei theme variables when they change.
 */
const o=(()=>{let e,t,r={};return{update:function(){e&&e.isConnected||function(){const r=document.querySelector(".edit-site-visual-editor__editor-canvas")?.contentDocument||document;e=r?.querySelector(".editor-styles-wrapper"),e&&(t=r.createElement("a"),Object.assign(t.attributes,{tabindex:"-1",id:"sensei-theme-style-probe"}),Object.assign(t.style,{position:"fixed",top:"-100vh"}),e.appendChild(t))}(),e&&function(t){for(const[r,o]of Object.entries(t))e.style.setProperty(r,o)}(function(){const{getComputedStyle:o}=window,{color:n,backgroundColor:s}=o(e),{color:c}=o(t),i={"--sensei-primary-color":c,"--sensei-text-color":n,"--sensei-background-color":s,"--sensei-primary-contrast-color":s};for(const e in{...i})r[e]===i[e]&&delete i[e];return r={...r,...i},i}())}}})();setInterval(o.update,1e3)}
/***/,
/***/52619:
/***/e=>{e.exports=window.wp.hooks;
/***/},
/***/78269:
/***/(e,t,r)=>{
/* harmony import */var o=r(52619);
/* harmony import */
/**
 * Turn variable reference to CSS.
 *
 * From @wordpress/edit-site/src/components/global-styles/use-global-styles-output.js
 *
 * @param {string} uncompiledValue
 * @return {string} CSS property value.
 */
function n(e){const t="var:";if(e?.startsWith?.(t)){return`var(--wp--${e.slice(4).split("|").join("--")})`}return e}
/**
 * Turn color name to CSS.
 *
 * @param {string} value A color name.
 * @return {string} CSS property value.
 */(0,o.addFilter)("blocks.registerBlockType","sensei/supports-color/withColorVariableSupport",(
/**
 * WordPress dependencies
 */
/**
 * Add settings to generate CSS variables for colors in the edit and save wrappers.
 *
 * @param {Object} settings Block settings.
 */
function(e){const{getEditWrapperProps:t}=e;return{...e,getEditWrapperProps:e=>{let r={};t&&(r=t(e));const o=
/**
 * Get CSS variables for colors from style and color attributes.
 *
 * @param {Object} attributes Block attributes.
 * @return {Object} CSS variable name-value pairs.
 */
function(e){const{style:t,backgroundColor:r,customBackgroundColor:o}=e,s=t?.elements?.link?.color?.text,c=n(t?.color?.background)||(a=r,a&&`var(--wp--preset--color--${a})`)||o,i={};var a;s&&(i["--sensei-primary-color"]=n(s));c&&(i["--sensei-background-color"]=c,i["--sensei-primary-contrast-color"]=c);return i}(e);return{...r,style:{...r?.style||{},...o||{}}}}}}))}
/***/
/******/},t={};
/************************************************************************/
/******/ // The module cache
/******/
/******/
/******/ // The require function
/******/function r(o){
/******/ // Check if module is in cache
/******/var n=t[o];
/******/if(void 0!==n)
/******/return n.exports;
/******/
/******/ // Create a new module (and put it into the cache)
/******/var s=t[o]={
/******/ // no module.id needed
/******/ // no module.loaded needed
/******/exports:{}
/******/};
/******/
/******/ // Execute the module function
/******/
/******/
/******/ // Return the exports of the module
/******/return e[o](s,s.exports,r),s.exports;
/******/}
/******/
/************************************************************************/
/******/ /* webpack/runtime/compat get default export */
/******/
/******/ // getDefaultExport function for compatibility with non-harmony modules
/******/r.n=e=>{
/******/var t=e&&e.__esModule?
/******/()=>e.default
/******/:()=>e
/******/;
/******/return r.d(t,{a:t}),t;
/******/},
/******/ // define getter functions for harmony exports
/******/r.d=(e,t)=>{
/******/for(var o in t)
/******/r.o(t,o)&&!r.o(e,o)&&
/******/Object.defineProperty(e,o,{enumerable:!0,get:t[o]})
/******/;
/******/},
/******/r.o=(e,t)=>Object.prototype.hasOwnProperty.call(e,t)
/******/;
/* harmony import */r(78269),r(12418)
/* harmony import */})
/**
 * Internal dependencies
 */
/******/();