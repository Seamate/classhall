/******/(()=>{// webpackBootstrap
/******/var e={
/***/24945:
/***/(e,t,s)=>{"use strict";
/* harmony import */var o=s(98490);
/* harmony import */
/**
 * Update video height when its width changes to keep original aspect ratio.
 *
 * @param {HTMLElement} block Container to track. Must have an <iframe> width and height attributes.
 */
function n(e){const t=()=>e.querySelector("iframe");let s=t();const o=s&&
/**
 * Get aspect ratio from element width and height attribute.
 *
 * @param {HTMLElement} element
 * @param {string}      element.width
 * @param {string}      element.height
 * @return {null|number} Width / Height aspect ratio.
 */
function({width:e,height:t}){return t&&e?+e/+t:null}(s);function n(){if(s=t(),!s)return;const{offsetHeight:e,offsetWidth:n}=s,r=n/o;r&&r!==e&&s.style.setProperty("height",`${r}px`)}o&&(new window.ResizeObserver(n).observe(e),n())}s.n(o)()((
/**
 * WordPress dependencies
 */
function(){document.querySelectorAll(".sensei-course-theme-lesson-video").forEach(n)}))}
/***/,
/***/32334:
/***/()=>{let e=0;const t="scroll",s=e=>{const[s,o]=e<0?["up","down"]:["down","up"];document.body.classList.remove(`${t}-${o}`),document.body.classList.add(`${t}-${s}`)};
/**
 * Detect if a scroll movement is upward or downward.
 */window.addEventListener("scroll",(()=>{const{scrollTop:o,scrollHeight:n,clientHeight:r}=document.documentElement,c=o-e;e=Math.max(0,o),s(c);const i=n-o-r<100;document.body.classList.toggle(`${t}-bottom`,i)}),{capture:!1,passive:!0})}
/***/,
/***/52208:
/***/(e,t,s)=>{"use strict";
/* harmony import */var o=s(66087);
/* harmony import */window.addEventListener("DOMContentLoaded",(()=>{const e=document.querySelector("#wpadminbar");function t(){if(!e)return;const{top:t,height:s}=e.getBoundingClientRect(),o=Math.max(0,s+t);document.documentElement.style.setProperty("--sensei-wpadminbar-offset",o+"px")}e&&(t(),window.addEventListener("scroll",t,{capture:!1,passive:!0}),
/**
   * The debounce has 2 reasons here:
   * 1. Reduce the number of times we call the function in a resize.
   * 2. The admin bar contains an animated transition, so this transition
   *    needs to be completed in order to make the correct calc.
   */
window.addEventListener("resize",(0,o.debounce)(t,500)))}))}
/***/,
/***/52229:
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */W:()=>/* binding */c
/* harmony export */});
/**
 * Focus mode class name and session storage key.
 *
 * @type {string}
 */
const o="sensei-course-theme--focus-mode",n="sensei-course-theme__sidebar--hidden",r=()=>{const e=window.sessionStorage.getItem(o);if(e)try{const t=JSON.parse(e);"boolean"==typeof t&&c(t,!0)}catch(e){}},c=(e,t)=>{const{classList:s}=document.body,r=document.querySelector(".sensei-course-theme__sidebar"),c=s.contains(o),i=void 0===e?!c:e;i?t&&r?.classList.add(n):r?.classList.remove(n),s.toggle(o,i),window.sessionStorage.setItem(o,JSON.stringify(i))};window.addEventListener("DOMContentLoaded",(()=>{r(),setTimeout((()=>{document.body.classList.add(`${o}--animated`)}),500),document.querySelector(".sensei-course-theme__sidebar")?.addEventListener("transitionend",(e=>{"left"===e.propertyName&&document.body.classList.contains(o)&&document.querySelector(".sensei-course-theme__sidebar")?.classList.add(n)}))}))}
/***/,
/***/61764:
/***/(e,t,s)=>{"use strict";
/* harmony export */
/**
 * @module ContactTeacher
 * @description Responsible for making a seamless ajax post of the
 * contact teacher form, without refreshing the whole page.
 */
/**
 * Handles the contact teacher submit event.
 *
 * @param {Object} ev The contact teacher form submit event.
 */
function o(e){
// If the fetch api is not available then bail.
if(!window.fetch)return;const t=document.querySelector('link[rel="https://api.w.org/"]')?.href;
// If the rest api is not available then bail.
if(!t)return;
// Prevent browser from refreshing.
e.preventDefault();const s=e.target,o=s.querySelector("button.sensei-contact-teacher-form__submit"),n=s.parentElement.querySelector(".sensei-contact-teacher-close");o.classList.add("sensei-course-theme__button","is-busy"),o.disabled=!0;const r=["sensei_message_teacher_nonce","_wpnonce","post_id","contact_message"].reduce(((e,t)=>({...e,[t]:s.elements[t].value})),{});window.fetch(`${t}sensei-internal/v1/messages?_locale=user`,{method:"POST",body:JSON.stringify(r),headers:{"Content-Type":"application/json","X-WP-Nonce":r._wpnonce}}).then((()=>{s.classList.add("is-success"),n.focus()})).catch((()=>{}))}
/***/s.d(t,{
/* harmony export */H:()=>/* binding */o
/* harmony export */})},
/***/66087:
/***/e=>{"use strict";e.exports=window.lodash}
/***/,
/***/77594:
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */N:()=>/* binding */r
/* harmony export */});
/* harmony import */var o=s(98490),n=s.n(o);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Initializes complete lesson transition.
 */
const r=()=>{n()((()=>{const e=document.querySelectorAll('[data-id="complete-lesson-form"]'),t=document.querySelectorAll('[data-id="complete-lesson-button"]'),s=document.querySelectorAll(".sensei-course-theme-course-progress-bar-inner"),o=(e,s)=>{e.preventDefault(),t.forEach((e=>{e.setAttribute("disabled","disabled"),e.classList.add("is-busy")})),setTimeout((()=>{s.submit()}),1e3)},n=e=>{const t=e.target;o(e,t),s.forEach((e=>{const{completed:t,count:s}=e.dataset,o=(+t+1)/+s*100;
// Percentage with one more completed.
e.style.width=`${o}%`}))};e.forEach((e=>{e.addEventListener("submit",n)}))}))};
/***/},
/***/98490:
/***/e=>{"use strict";e.exports=window.wp.domReady}
/***/
/******/},t={};
/************************************************************************/
/******/ // The module cache
/******/
/******/
/******/ // The require function
/******/function s(o){
/******/ // Check if module is in cache
/******/var n=t[o];
/******/if(void 0!==n)
/******/return n.exports;
/******/
/******/ // Create a new module (and put it into the cache)
/******/var r=t[o]={
/******/ // no module.id needed
/******/ // no module.loaded needed
/******/exports:{}
/******/};
/******/
/******/ // Execute the module function
/******/
/******/
/******/ // Return the exports of the module
/******/return e[o](r,r.exports,s),r.exports;
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
/******/for(var o in t)
/******/s.o(t,o)&&!s.o(e,o)&&
/******/Object.defineProperty(e,o,{enumerable:!0,get:t[o]})
/******/;
/******/},
/******/s.o=(e,t)=>Object.prototype.hasOwnProperty.call(e,t)
/******/,
// This entry needs to be wrapped in an IIFE because it needs to be in strict mode.
(()=>{"use strict";
/* harmony import */s(52208),s(24945),s(32334)
/* harmony import */;var e=s(77594),t=s(61764),o=s(52229);
/**
 * Internal dependencies
 */
window.sensei||(window.sensei={})
/**
 * Show or hide the sidebar in mobile mode.
 */;window.sensei.courseTheme={toggleFocusMode:o/* .toggleFocusMode */.W,toggleSidebar:()=>{document.body.classList.toggle("sensei-course-theme--sidebar-open")}},window.sensei.submitContactTeacher=t/* .submitContactTeacher */.H,(0,e/* .initCompleteLessonTransition */.N)()})()})
/******/();