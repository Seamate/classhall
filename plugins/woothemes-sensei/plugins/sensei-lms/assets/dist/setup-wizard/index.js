/******/(()=>{// webpackBootstrap
/******/var e={
/***/1455:
/***/e=>{"use strict";e.exports=window.wp.apiFetch}
/***/,
/***/2192:
/***/(e,s,t)=>{"use strict";
/**
 * @license React
 * react-jsx-runtime.production.min.js
 *
 * Copyright (c) Facebook, Inc. and its affiliates.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */var i=t(51609),n=Symbol.for("react.element"),r=Symbol.for("react.fragment"),a=Object.prototype.hasOwnProperty,o=i.__SECRET_INTERNALS_DO_NOT_USE_OR_YOU_WILL_BE_FIRED.ReactCurrentOwner,l={key:!0,ref:!0,__self:!0,__source:!0};function c(e,s,t){var i,r={},c=null,d=null;for(i in void 0!==t&&(c=""+t),void 0!==s.key&&(c=""+s.key),void 0!==s.ref&&(d=s.ref),s)a.call(s,i)&&!l.hasOwnProperty(i)&&(r[i]=s[i]);if(e&&e.defaultProps)for(i in s=e.defaultProps)void 0===r[i]&&(r[i]=s[i]);return{$$typeof:n,type:e,key:c,ref:d,props:r,_owner:o.current}}s.Fragment=r,s.jsx=c,s.jsxs=c}
/***/,
/***/3582:
/***/e=>{"use strict";e.exports=window.wp.coreData}
/***/,
/***/3735:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */DN:()=>/* binding */i
/* harmony export */,FY:()=>/* binding */o
/* harmony export */,M9:()=>/* binding */d
/* harmony export */,P:()=>/* binding */a
/* harmony export */,_0:()=>/* binding */l
/* harmony export */,jI:()=>/* binding */c
/* harmony export */,oE:()=>/* binding */r
/* harmony export */,pI:()=>/* binding */n
/* harmony export */});
/**
 * Setup wizard constants.
 */
const i="/sensei-internal/v1/setup-wizard/",n="START_FETCH_SETUP_WIZARD_DATA",r="SUCCESS_FETCH_SETUP_WIZARD_DATA",a="ERROR_FETCH_SETUP_WIZARD_DATA",o="START_SUBMIT_SETUP_WIZARD_DATA",l="SUCCESS_SUBMIT_SETUP_WIZARD_DATA",c="ERROR_SUBMIT_SETUP_WIZARD_DATA",d="SET_DATA";
/**
 * Fetch action type constants.
 */}
/***/,
/***/4452:
/***/(e,s)=>{var t;
/*!
	Copyright (c) 2018 Jed Watson.
	Licensed under the MIT License (MIT), see
	http://jedwatson.github.io/classnames
*/
/* global define */!function(){"use strict";var i={}.hasOwnProperty;function n(){for(var e="",s=0;s<arguments.length;s++){var t=arguments[s];t&&(e=a(e,r(t)))}return e}function r(e){if("string"==typeof e||"number"==typeof e)return e;if("object"!=typeof e)return"";if(Array.isArray(e))return n.apply(null,e);if(e.toString!==Object.prototype.toString&&!e.toString.toString().includes("[native code]"))return e.toString();var s="";for(var t in e)i.call(e,t)&&e[t]&&(s=a(s,t));return s}function a(e,s){return s?e?e+" "+s:e+s:e}e.exports?(n.default=n,e.exports=n):void 0===(t=function(){return n}.apply(s,[]))||(e.exports=t)}()}
/***/,
/***/5731:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>r
/* harmony export */});
/* harmony import */var i=t(86087);
/* harmony import */
/**
 * WordPress dependencies
 */
const n=(e,s)=>{e?document.body.classList.add(...s):document.body.classList.remove(...s),document.documentElement.classList.toggle("wp-toolbar",!e)},r=(e=[])=>{(0,i.useLayoutEffect)((()=>{const s=[...e,"sensei-wp-admin-fullscreen"];return n(!0,s),()=>{n(!1,s)}}),[e])};
/**
 * Apply fullscreen view by hiding wp-admin elements via CSS.
 *
 * Allows setting additional classes on the body element.
 * Fullscreen and classes are added when the component is mounted, and removed when unmounted.
 *
 * @param {string[]} bodyClasses Additional classes to be set.
 */}
/***/,
/***/7619:
/***/e=>{"use strict";e.exports="assets/dist/images/onboarding-theme-mobile-2-c03ce47e5669f2251f8a.webp"}
/***/,
/***/8397:
/***/e=>{"use strict";e.exports="assets/dist/images/onboarding-theme-small-mobile-2-c03ce47e5669f2251f8a.webp"}
/***/,
/***/9816:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */Ay:()=>c
/* harmony export */,Yr:()=>/* binding */d
/* harmony export */,qh:()=>/* reexport safe */o.A
/* harmony export */});
/* harmony import */var i=t(86087),n=t(44196),r=t(31173),a=t(62540),o=t(45817);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Query string router context.
 */
const l=(0,i.createContext)(),c=({paramName:e,routes:s,defaultRoute:t,children:o})=>{
// Current route.
const[c,d]=(0,i.useState)((0,r/* .getParam */.s)(e)),u=(0,i.useMemo)((()=>{
/**
     * Function that send the user to another route.
     * It changes the URL and update the state of the current route.
     *
     * @param {string}  newRoute New route to send the user.
     * @param {boolean} replace  Flag to mark if should replace or push state.
     */
const i=(s,t=!1)=>{(0,r/* .updateQueryString */.Z)(e,s,t),d(s)};
/**
     * Function that send the user to the next route, in a linear navigation.
     * It changes the URL and update the state of the current route.
     */return c||i(t,!0),{currentRoute:c,goNext:()=>{const e=s.findIndex((e=>e===c)),t=s[e+1];t&&i(t)},goTo:i}}),[c,e,s,t]);
// Provider value.
// Handle history changes through popstate.
// Handle history changes through popstate.
return(0,n/* .useEventListener */.ML)("popstate",(()=>{d((0,r/* .getParam */.s)(e))}),[e]),(0,a.jsx)(l.Provider,{value:u,children:o})},d=()=>(0,i.useContext)(l)
/***/;
/**
 * Query string router component.
 * It creates a provider with the following values in the context:
 * - `currentRoute`: The string of the current route.
 * - `goNext`: Function that send the user to the next route.
 * - `goTo`: Function that send the user to another route.
 *
 * @param {Object}   props
 * @param {string}   props.paramName    Param used as reference in the query string.
 * @param {string[]} props.routes       Routes of the navigation.
 * @param {string}   props.defaultRoute Default route to open if there is nothing in the URL.
 * @param {Object}   props.children     Render this children if it matches the route.
 */},
/***/12031:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>p
/* harmony export */});
/* harmony import */var i=t(4452),n=t.n(i),r=t(27723),a=t(86087),o=t(72316),l=t(9816),c=t(38407),d=t(69178),u=t(42401),m=t(62540);
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
 * Theme step for Setup Wizard.
 */
const p=()=>{const{goNext:e}=(0,l/* .useQueryStringRouter */.Yr)(),[s,t]=(0,a.useState)(!1),[i,p]=(0,a.useState)(!1),_=(0,a.useRef)(),{submitStep:h,isSubmitting:w,errorNotice:g}=(0,o/* .useSetupWizardStep */.m)("theme");(0,a.useLayoutEffect)((()=>{const e=_.current?.ownerDocument.defaultView,s=()=>{t(window.innerWidth>=600)},i=()=>{p(_.current.getBoundingClientRect().y<=80)};
// Check if it's a big screen.
// Checks on load.
return s(),i(),e.addEventListener("resize",s),e.addEventListener("scroll",i),()=>{e.removeEventListener("resize",s),e.removeEventListener("scroll",i)}}),[]);const x=s=>()=>{h({theme:{install_sensei_theme:s}},{onSuccess:e})};
return(0,m.jsxs)(m.Fragment,{children:[s&&i&&(0,m.jsxs)("div",{className:"sensei-setup-wizard-theme-top-actions sensei-setup-wizard-theme-top-actions--enter-animation",children:[(0,m.jsx)("button",{disabled:w,className:"sensei-setup-wizard__button sensei-setup-wizard__button--link",onClick:x(!1),children:(0,r.__)("Skip","sensei-lms")}),(0,m.jsx)("button",{disabled:w,className:"sensei-setup-wizard__button sensei-setup-wizard__button--primary",onClick:x(!0),children:(0,r.__)("Get the Course theme","sensei-lms")})]}),(0,m.jsxs)("div",{className:n()("sensei-setup-wizard__content sensei-setup-wizard__content--large",{"sensei-setup-wizard__content--hidden":s&&i}),children:[(0,m.jsxs)("div",{className:"sensei-setup-wizard__title",children:[(0,m.jsx)(c.H,{className:"sensei-setup-wizard__step-title",children:(0,r.__)("Use our default theme","sensei-lms")}),(0,m.jsx)("p",{children:(0,r.__)("'Course' is a free WordPress theme built to work perfectly with Sensei and courses. You can use any WordPress theme with Sensei, or activate 'Course'.","sensei-lms")})]}),(0,m.jsxs)("div",{className:"sensei-setup-wizard__actions sensei-setup-wizard__actions--full-width",children:[g,(0,m.jsxs)("div",{className:"sensei-setup-wizard__theme-actions",children:[(0,m.jsx)("button",{disabled:w,className:"sensei-setup-wizard__button sensei-setup-wizard__button--primary",onClick:x(!0),children:(0,r.__)("Get the Course theme","sensei-lms")}),(0,m.jsx)("button",{className:"sensei-setup-wizard__button sensei-setup-wizard__button--secondary sensei-setup-wizard__button--only-medium",onClick:()=>{const e=_.current?.ownerDocument.defaultView;e.scroll({top:_.current.getBoundingClientRect().y-70,behavior:"smooth"})},children:(0,r.__)("Explore the theme","sensei-lms")})]}),(0,m.jsx)("div",{className:"sensei-setup-wizard__action-skip",children:(0,m.jsx)("button",{disabled:w,className:"sensei-setup-wizard__button sensei-setup-wizard__button--link",onClick:x(!1),children:(0,r.__)("Keep my current theme","sensei-lms")})})]})]}),(0,m.jsx)("div",{ref:_,children:s?(0/* ["default"] */,m.jsx)(d.A,{}):(0/* ["default"] */,m.jsx)(u.A,{})})]})};
/* harmony default export */}
/***/,
/***/14558:
/***/e=>{"use strict";e.exports="assets/dist/images/onboarding-theme-mobile-5-46ff4513001bbd87aeff.webp"}
/***/,
/***/17516:
/***/(e,s,t)=>{"use strict";t.r(s),
/* harmony export */t.d(s,{
/* harmony export */getFetchError:()=>/* binding */n
/* harmony export */,getStepData:()=>/* binding */o
/* harmony export */,getSubmitError:()=>/* binding */a
/* harmony export */,isFetching:()=>/* binding */i
/* harmony export */,isSubmitting:()=>/* binding */r
/* harmony export */});
/**
 * Is fetching setup wizard data selector.
 *
 * @param {Object} state Current state.
 *
 * @return {boolean} Is fetching.
 */
const i=e=>e.isFetching
/**
 * Fetch setup wizard error selector.
 *
 * @param {Object} state Current state.
 *
 * @return {Object|boolean} Error object or false.
 */,n=e=>e.fetchError
/**
 * Is submitting setup wizard data selector.
 *
 * @param {Object} state Current state.
 *
 * @return {boolean} Is submitting.
 */,r=e=>e.isSubmitting
/**
 * Submit error selector.
 *
 * @param {Object} state Current state.
 *
 * @return {Object|boolean} Error object or false.
 */,a=e=>e.submitError
/**
 * Step state selector.
 *
 * @param {Object} state Current state.
 * @param {string} step  Step name.
 *
 * @return {Object} Step data.
 */,o=(e,s)=>e.data[s]
/***/},
/***/21627:
/***/e=>{"use strict";e.exports="assets/dist/images/onboarding-theme-main-41fd4fea2f81a3427114.webp"}
/***/,
/***/22502:
/***/e=>{"use strict";e.exports="assets/dist/images/onboarding-theme-quote-author-aef7d6749e2a016e0df5.webp"}
/***/,
/***/22821:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>n
/* harmony export */});
/* unused harmony export useDragging */
/* harmony import */var i=t(86087);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * A dragging hook.
 *
 * @param {Object}   options             Hook options.
 * @param {Function} options.onDrag      Drag callback.
 * @param {Function} options.onDragStart Drag start callback.
 * @param {Function} options.onDragEnd   Drag end callback.
 *
 * @return {Object} Object containing draggable props, and isDragging.
 */
const n=({onDrag:e=()=>{},onDragStart:s=()=>{},onDragEnd:t=()=>{}})=>{const[n,r]=(0,i.useState)(!1),[a,o]=(0,i.useState)({}),l=e=>e.touches?.[0]||e.changedTouches?.[0]||e
/**
   * Get the enhanced event, including the diff from initial position.
   *
   * @return {Object} Original event and dragged diff.
   */,c=(0,i.useCallback)((e=>{const s=l(e);return{event:e,diff:{x:s.clientX-a.x,y:s.clientY-a.y}}}),[a]),d=(0,i.useCallback)((e=>{const t=l(e);s(),r(!0),o({x:t.clientX,y:t.clientY})}),[s]),u=(0,i.useCallback)((e=>{const s=l(e);n&&(e.preventDefault(),r(!1),t(c(s)))}),[n,t,c]),m=(0,i.useCallback)((s=>{if(n){const t=l(s);e(c(t))}}),[n,e,c]);return(0,i.useEffect)((()=>(document.addEventListener("mouseup",u),document.addEventListener("touchend",u),document.addEventListener("mousemove",m),document.addEventListener("touchmove",m),()=>{document.removeEventListener("mouseup",u),document.removeEventListener("touchend",u),document.removeEventListener("mousemove",m),document.removeEventListener("touchmove",m)})
/* eslint-enable */),[u,m]),{draggableProps:{onMouseDown:d,onTouchStart:d},isDragging:n}};
/* harmony default export */}
/***/,
/***/24576:
/***/e=>{"use strict";e.exports="assets/dist/images/onboarding-theme-mobile-3-8ae32618f58aba019865.webp"}
/***/,
/***/25593:
/***/e=>{"use strict";e.exports="assets/dist/images/onboarding-theme-mobile-4-816aa9725b9c97345238.webp"}
/***/,
/***/26172:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>a
/* harmony export */,W:()=>/* binding */r
/* harmony export */});
/* harmony import */var i=t(86087),n=t(27723);
/* harmony import */
/**
 * WordPress dependencies
 */
// Minimum timer for the actions, to make sure the user will have time to read the texts.
const r=1500,a=e=>{const[s,t]=(0,i.useState)(),[a,o]=(0,i.useState)(!1),l=e[s]?.action,c=(0,i.useCallback)((()=>{s+1<e.length&&t((e=>e+1))}),[s,e.length]),d=(0,i.useCallback)((()=>{o(!1);const e=l?.();return Promise.all([new Promise((e=>{setTimeout((()=>{e()}),r)})),e]).then((()=>{c()})).catch((e=>{o(e)})),e?.clearAction}),[l,c]);
// Navigate through the actions.
// Navigate through the actions.
(0,i.useEffect)((()=>{
// This is to make sure that the bar will run the CSS transition for the first step.
if(void 0===s)return void setTimeout((()=>{t(0)}));const e=d();return()=>{e?.()}}),[s,d]);const u=a&&[{variant:"primary",label:(0,n.__)("Retry","sensei-lms"),onClick:d},{label:(0,n.__)("Skip","sensei-lms"),onClick:c}];return{percentage:(s+(a?0:1))/e.length*100||0,label:e[s]?.label,error:a,errorActions:u}};
/**
 * Function that simulates an action, returning a promise with the minimum time.
 *
 * @return {Promise} Promise that resolves after a minimum timer.
 */}
/***/,
/***/27723:
/***/e=>{"use strict";e.exports=window.wp.i18n}
/***/,
/***/29656:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>o
/* harmony export */});
/* harmony import */var i=t(4452),n=t.n(i),r=t(56427),a=t(62540);
/* harmony import */
/**
 * External dependencies
 */
/**
 * WordPress dependencies
 */
/**
 * Purpose Item component.
 *
 * @param {Object}   props          Component props.
 * @param {string}   props.label    Item label.
 * @param {boolean}  props.checked  Whether it's checked.
 * @param {Function} props.onToggle Toggle callback.
 * @param {Object}   props.children Component children, which is displayed when it's checked.
 */
const o=({label:e,checked:s,onToggle:t,children:i})=>(0,a.jsxs)("li",{className:n()("sensei-setup-wizard__purpose-item",{"sensei-setup-wizard__purpose-item--checked":s}),children:[(0,a.jsx)(r.CheckboxControl,{className:"sensei-setup-wizard__checkbox",label:e,checked:s,onChange:t}),s&&i&&(0,a.jsx)("small",{className:"sensei-setup-wizard__purpose-children",children:i})]})
/* harmony default export */}
/***/,
/***/31173:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */Z:()=>/* binding */n
/* harmony export */,s:()=>/* binding */i
/* harmony export */});
/**
 * Get parameter from URL.
 *
 * @param {string} name Name of the param to get.
 *
 * @return {string|null} The value in the param. If it's empty, return null.
 */
const i=e=>new URLSearchParams(window.location.search).get(e)||null
/**
 * Update query string.
 *
 * @param {string}  paramName  Param name to be added to the URL.
 * @param {string}  paramValue Param value to be added to the URL.
 * @param {boolean} replace    Flag if it should replace the state. Otherwise it'll push a new.
 */,n=(e,s,t=!1)=>{const{search:i}=window.location,n=t?"replaceState":"pushState",r=new URLSearchParams(i);null===s?r.delete(e):r.set(e,s),window.history[n]({},"",`?${r.toString()}`)}}
/***/,
/***/34198:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */$:()=>/* binding */i
/* harmony export */,P:()=>/* binding */n
/* harmony export */});
/**
 * Send log event.
 *
 * @param {string} eventName  Event name.
 * @param {Array}  properties Event properties.
 */
const i=(e,s)=>{window.sensei_log_event(e,s)};
/**
 * Enable or disable event logging.
 *
 * @param {boolean} enabled Enabled state.
 */i.enable=e=>{window.sensei_event_logging.enabled=e};
/**
 * Send log event when link is opened.
 *
 * @param {string} eventName  Event name.
 * @param {Array}  properties Event properties.
 * @return {Object} Element attributes.
 */
const n=(e,s)=>({onClick:()=>i(e,s),onAuxClick:t=>(e=>1===e.button)(t)&&i(e,s)});
/***/},
/***/34808:
/***/e=>{"use strict";e.exports="assets/dist/images/onboarding-theme-learning-mode-3-7d05ee19edda724c37e7.webp"}
/***/,
/***/36165:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>p
/* harmony export */});
/* harmony import */var i=t(86087),n=t(56427),r=t(27723),a=t(1455),o=t.n(a),l=t(72316),c=t(26172),d=t(39424),u=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
const m={woocommerce:(0,r.__)("Installing WooCommerce","sensei-lms"),"sensei-certificates":(0,r.__)("Installing Certificates","sensei-lms")},p=()=>{const{stepData:e,submitStep:s,error:t}=(0,l/* .useSetupWizardStep */.m)("features"),{stepData:a}=(0,l/* .useSetupWizardStep */.m)("theme"),{install_sensei_theme:p}=a,_=(0,i.useMemo)((()=>{const s=(({selected:e,options:s})=>e.filter((e=>s.some((s=>s.product_slug===e&&!s.is_activated)))).map((e=>({label:m[e],action:()=>o()({path:"/sensei-internal/v1/sensei-extensions/install",method:"POST",data:{plugin:e}})}))))(e);return p&&!window.sensei.isCourseThemeInstalled&&s.push({label:(0,r.__)("Installing the Course theme","sensei-lms"),action:()=>o()({path:"/sensei-internal/v1/themes/install",method:"POST",data:{theme:"course"}})}),s}),[e,p]),h=(0,i.useMemo)((()=>[{label:(0,r.__)("Applying your choices","sensei-lms")},..._,{label:(0,r.__)("Setting up your new Sensei Home","sensei-lms"),action:()=>{let e;const t=new Promise((t=>{e=setTimeout((()=>{s({},{onSuccess:()=>{window.location.href=d/* .HOME_PATH */.g,t()}})}),c/* .actionMinimumTimer */.W)}));return t.clearAction=()=>clearTimeout(e),t}}]),[_,s]),{percentage:w,label:g,error:x,errorActions:b}=(0,c/* ["default"] */.A)(h),f=x||t;
return(0,u.jsx)("div",{className:"sensei-setup-wizard__full-centered-step",children:(0,u.jsxs)("div",{className:"sensei-setup-wizard__full-centered-content",children:[(0,u.jsx)("div",{className:"sensei-setup-wizard__features-status",role:"status","aria-live":"polite",children:(0,u.jsx)("div",{className:"sensei-setup-wizard__fade-in",children:g},g)}),f&&(0,u.jsx)(n.Notice,{status:"error",className:"sensei-setup-wizard__error-notice",isDismissible:!1,actions:b||[{label:(0,r.__)("Go to Sensei Home","sensei-lms"),url:d/* .HOME_PATH */.g}],children:f.message}),(0,u.jsx)("div",{className:"sensei-setup-wizard__features-progress-bar",children:(0,u.jsx)("div",{role:"progressbar","aria-label":(0,r.__)("Sensei Onboarding Progress","sensei-lms"),"aria-valuenow":w,className:"sensei-setup-wizard__features-progress-bar-filled",style:{width:`${w}%`}})})]})})};
/**
 * Get actions for the features to be installed.
 *
 * @param {Object}   featuresData          The features step data.
 * @param {string[]} featuresData.selected Selected features to be installed.
 * @param {Object[]} featuresData.options  Features available to install.
 *
 * @return {Array} Actions to install the selected features.
 */}
/***/,
/***/37382:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>c
/* harmony export */,M:()=>/* binding */l
/* harmony export */});
/* harmony import */var i=t(47143),n=t(66161),r=t(65498),a=t(89125),o=t(17516);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
const l=(0,i.createReduxStore)("sensei/setup-wizard",{reducer:r/* ["default"] */.A,actions:a,selectors:o,controls:n.controls}),c=()=>{(0,i.register)(l)}}
/***/,
/***/38407:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */H:()=>/* binding */a
/* harmony export */,w:()=>/* binding */o
/* harmony export */});
/* harmony import */var i=t(86087),n=t(62540);
/* harmony import */
/**
 * Section and Header helper component from `@woocommerce/components`.
 */
/**
 * WordPress dependencies
 */
/**
 * Context container for heading level. We start at 2 because the `h1` assumed to be the page header.
 */
const r=(0,i.createContext)(2);
/**
 * These components are used to frame out the page content for accessible heading hierarchy. Instead of defining fixed heading levels
 * (`h2`, `h3`, …) you can use `<H />` to create "section headings", which look to the parent `<Section />`s for the appropriate
 * heading level.
 *
 * @param {Object} props -
 * @return {Object} -
 */function a(e){
return(0,n.jsx)(r.Consumer,{children:s=>{const t="h"+Math.min(s,6);
return(0,n.jsx)(t,{...e})}})}
/**
 * The section wrapper, used to indicate a sub-section (and change the header level context).
 *
 * @param {Object} props
 * @param {string} props.component
 * @param {Node}   props.children
 * @return {Object} -
 */function o({component:e,children:s,...t}){const i=e||"div";
return(0,n.jsx)(r.Consumer,{children:a=>(0,n.jsx)(r.Provider,{value:a+1,children:!1===e?s:(0,n.jsx)(i,{...t,children:s})})})}
/***/},
/***/39424:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */g:()=>/* binding */i
/* harmony export */});const i="admin.php?page=sensei";
/***/},
/***/40249:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>c
/* harmony export */});
/* harmony import */var i=t(27723),n=t(9816),r=t(72316),a=t(38407),o=t(34198),l=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Usage Tracking step for Setup Wizard.
 */
const c=()=>{const{goNext:e}=(0,n/* .useQueryStringRouter */.Yr)(),{submitStep:s,isSubmitting:t,errorNotice:c}=(0,r/* .useSetupWizardStep */.m)("tracking"),d=s=>()=>{o/* .logEvent */.$.enable(s),e()},u=e=>()=>{s({tracking:{usage_tracking:e}},{onSuccess:d(e)})};
return(0,l.jsxs)(l.Fragment,{children:[(0,l.jsxs)("div",{className:"sensei-setup-wizard__content",children:[(0,l.jsx)(a.H,{className:"sensei-setup-wizard__step-title",children:(0,i.__)("Help us improve your Sensei experience","sensei-lms")}),(0,l.jsx)("p",{children:(0,i.__)("Help us build a better Sensei by sharing anonymous and non-sensitive data with our team. No personal data will be tracked or stored.","sensei-lms")}),(0,l.jsxs)("div",{className:"sensei-setup-wizard__actions sensei-setup-wizard__actions--full-width",children:[c,(0,l.jsx)("button",{disabled:t,className:"sensei-setup-wizard__button sensei-setup-wizard__button--primary",onClick:u(!0),children:(0,i.__)("Exciting, count me in!","sensei-lms")}),(0,l.jsx)("div",{className:"sensei-setup-wizard__action-skip",children:(0,l.jsx)("button",{disabled:t,className:"sensei-setup-wizard__button sensei-setup-wizard__button--link",onClick:u(!1),children:(0,i.__)("No thanks","sensei-lms")})})]})]}),(0,l.jsx)("div",{className:"sensei-setup-wizard__illustration sensei-setup-wizard__illustration--tracking","aria-hidden":"true"})]})};
/* harmony default export */}
/***/,
/***/40427:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>a
/* harmony export */});
/* harmony import */var i,n=t(51609);
/* harmony import */function r(){return r=Object.assign?Object.assign.bind():function(e){for(var s=1;s<arguments.length;s++){var t=arguments[s];for(var i in t)({}).hasOwnProperty.call(t,i)&&(e[i]=t[i])}return e},r.apply(null,arguments)}
/* harmony default export */const a=function(e){
return n.createElement("svg",r({viewBox:"0 0 24 24",fill:"none",xmlns:"http://www.w3.org/2000/svg"},e),i||(i=n.createElement("path",{d:"m10 7 5 5.5-5 5.5",stroke:"currentColor",strokeWidth:1.5})))};
/***/},
/***/42401:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>c
/* harmony export */});
/* harmony import */var i=t(27723),n=t(90473),r=t(65312),a=t(8397),o=t(61730),l=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Theme step content for small screens.
 */
const c=()=>(0,l.jsx)("div",{className:"sensei-setup-wizard-theme",children:(0,l.jsx)("div",{className:"sensei-setup-wizard-theme__learning-mode-carousel",children:(0/* ["default"] */,l.jsxs)(n.A,{children:[(0/* ["default"] */,l.jsx)(n.A.Item,{children:(0,l.jsx)("div",{className:"sensei-setup-wizard-theme__image-wrapper",children:(0,l.jsx)("img",{src:window.sensei.pluginUrl+r,alt:(0,i.__)("Sensei theme illustration","sensei-lms"),className:"sensei-setup-wizard-theme__image"})})}),(0/* ["default"] */,l.jsx)(n.A.Item,{children:(0,l.jsx)("div",{className:"sensei-setup-wizard-theme__image-wrapper",children:(0,l.jsx)("img",{src:window.sensei.pluginUrl+a,alt:(0,i.__)("Sensei theme illustration","sensei-lms"),className:"sensei-setup-wizard-theme__image"})})}),(0/* ["default"] */,l.jsx)(n.A.Item,{children:(0,l.jsx)("div",{className:"sensei-setup-wizard-theme__image-wrapper",children:(0,l.jsx)("img",{src:window.sensei.pluginUrl+o,alt:(0,i.__)("Sensei theme illustration","sensei-lms"),className:"sensei-setup-wizard-theme__image"})})})]})})})
/* harmony default export */}
/***/,
/***/42722:
/***/e=>{"use strict";e.exports="assets/dist/images/onboarding-theme-mobile-1-a7ae6d9f83074abdba06.webp"}
/***/,
/***/43066:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>d
/* harmony export */});
/* harmony import */var i=t(52619),n=t(27723),r=t(9816),a=t(72316),o=t(38407),l=t(39424),c=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Welcome step for Setup Wizard.
 */
const d=()=>{const{goNext:e}=(0,r/* .useQueryStringRouter */.Yr)(),{submitStep:s,isSubmitting:t,errorNotice:d}=(0,a/* .useSetupWizardStep */.m)("welcome"),u=(0,i.applyFilters)("sensei.setupWizard.welcomeTitle",(0,n.__)("Welcome to Sensei LMS","sensei-lms")),m=(0,i.applyFilters)("sensei.setupWizard.welcomeParagraph",(0,n.__)("Let’s set up your site to launch your first course.","sensei-lms"));
return(0,c.jsx)("div",{className:"sensei-setup-wizard__full-centered-step",children:(0,c.jsxs)("div",{className:"sensei-setup-wizard__full-centered-content",children:[(0,c.jsx)(o.H,{className:"sensei-setup-wizard__step-title",children:u}),(0,c.jsx)("p",{children:m}),(0,c.jsxs)("div",{className:"sensei-setup-wizard__actions",children:[d,(0,c.jsx)("button",{disabled:t,className:"sensei-setup-wizard__button sensei-setup-wizard__button--primary",onClick:()=>{s({},{onSuccess:e})},children:(0,n.__)("Get started","sensei-lms")}),(0,c.jsx)("div",{className:"sensei-setup-wizard__action-skip",children:(0,c.jsx)("a",{href:l/* .HOME_PATH */.g,children:(0,n.__)("Skip onboarding","sensei-lms")})})]})]})})};
/* harmony default export */}
/***/,
/***/44196:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */ML:()=>/* reexport safe */n.A
/* harmony export */,ZN:()=>/* reexport safe */r.A
/* harmony export */,tQ:()=>/* reexport safe */i.A
/* harmony export */});
/* harmony import */t(77549),t(65471)
/* harmony import */;var i=t(22821),n=t(81655),r=(t(84299),t(93301),t(46979),t(5731))}
/***/,
/***/45380:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>a
/* harmony export */});
/* harmony import */var i,n=t(51609);
/* harmony import */function r(){return r=Object.assign?Object.assign.bind():function(e){for(var s=1;s<arguments.length;s++){var t=arguments[s];for(var i in t)({}).hasOwnProperty.call(t,i)&&(e[i]=t[i])}return e},r.apply(null,arguments)}
/* harmony default export */const a=function(e){
return n.createElement("svg",r({viewBox:"0 0 24 24",fill:"none",xmlns:"http://www.w3.org/2000/svg"},e),i||(i=n.createElement("path",{d:"m14 7-5 5.5 5 5.5",stroke:"currentColor",strokeWidth:1.5})))};
/***/},
/***/45817:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>n
/* harmony export */});
/* harmony import */var i=t(9816);
/**
 * Internal dependencies
 */
/**
 * Route component. It works inner the `QueryStringRouter context.
 *
 * @param {Object} props
 * @param {string} props.route    Route name.
 * @param {Object} props.children Render this children if it matches the route.
 *
 * @return {Object|null} Return the children if the routes match. Otherwise return null.
 */const n=({route:e,children:s})=>{const{currentRoute:t}=(0,i/* .useQueryStringRouter */.Yr)();return t===e?s:null};
/* harmony default export */}
/***/,
/***/46979:
/***/(e,s,t)=>{"use strict";
/* unused harmony export useSenseiColorTheme */
/* harmony import */t(86087);
/* harmony import */}
/***/,
/***/47143:
/***/e=>{"use strict";e.exports=window.wp.data}
/***/,
/***/48597:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>o
/* harmony export */});
/* harmony import */var i,n,r=t(51609);
/* harmony import */function a(){return a=Object.assign?Object.assign.bind():function(e){for(var s=1;s<arguments.length;s++){var t=arguments[s];for(var i in t)({}).hasOwnProperty.call(t,i)&&(e[i]=t[i])}return e},a.apply(null,arguments)}
/* harmony default export */const o=function(e){
return r.createElement("svg",a({viewBox:"0 0 24 24",fill:"none",xmlns:"http://www.w3.org/2000/svg"},e),i||(i=r.createElement("circle",{cx:12,cy:12,r:12,fill:"#43AF99"})),n||(n=r.createElement("path",{fillRule:"evenodd",clipRule:"evenodd",d:"M9.835 15.38c.3-.23.179-.474.6-.563-.02.194.146.391.251.563-.109-.367-.002-.536.08-.72.347-.785-.662-1.293-1.35-1.418.235-.164.399-.327.694-.355a2.377 2.377 0 0 0-1.058.23c-1.112.531-1.993-.523-1.41-1.48.31-.51.664-.519.982-.865.077.178.103.372.075.564a.919.919 0 0 0 .049-.664c-.104-.336-.4-.338-.456-.821-.012-.101-.105.056-.263-.077-.038-.032-.113-.09-.163-.064-.085.044-.18.008-.232.034-.083.041-.109-.045-.2.016-.16.107-.178-.013-.332.005-.193.023-.32.261-.43.144-.102-.108-.206.075-.28.075-.05 0-.311.317-.426.028-.086-.216-.28.206-.382.063-.033-.046-.123.108-.18-.044-.014-.035 0-.078-.108-.027-.215.099-.138-.06-.207-.144-.083-.103-.113-.103-.068-.27.036-.133-.019-.33.2-.364.055-.008.107-.005.184-.148.096-.18.231-.093.207-.175-.036-.119.143-.28.226-.355.11-.103.254-.252.306-.396a.63.63 0 0 1 .102-.141c.081-.084.105-.003.227-.045.088-.03.02.053.106-.07.028-.038.105-.001.19-.039.259-.112.283-.11.347-.371.012-.05.025-.088.08-.083.109.01.134-.052.2-.05.061.001.083-.03.115-.068.18-.216.277-.055.357-.072.06-.012.022-.142.184-.102.23.057.155-.05.303-.015.174.041.186.19.306.225.143.042.211.198.307.196.337-.005.235.23.448.323-.16-.161.012-.421-.352-.455-.08-.007-.11-.127-.23-.183-.146-.067-.13-.21-.394-.27.068-.04.089.005.13-.073.058-.11.09-.046.113-.113.02-.063.006-.099.165-.155.165-.06.325-.195.472-.188.13.006.185-.08.177-.19-.008-.112-.033-.267.222-.22.153.029.15.003.15-.1-.002-.102.04-.165.174-.16.098.002.194-.003.231-.117.03-.091.207-.114.302-.148.317-.114.361.05.447-.095.07-.117.196-.317.337-.175.028.029.054.05.15-.056.08-.088.27-.2.337-.048.027.06.086.121.138.044a.08.08 0 0 1 .053-.039c.05-.01.079-.024.104-.036.218-.101.314-.095.213.125-.142.316.792-.192.532.151-.095.126.538.197.63.254.05.032.048.059.144.077.271.05.267.026.284.243.007.098.107.043.107.168 0 .535.472.266.549.399.012.022.032.042.079.042.149 0 .157-.03.224.089.027.047.05.072.127.096.12.037.112.05.068.138-.054.104.03.102.138.112.1.01.148.062.216.138.11.122.284.156.43.227.084.04.002.14.143.243.104.077.156.066.016.165-.59.418.22.305.446.694.051.087.118.195.216.295.225.23.1.293.221.437.07.083.015.063.13.137.272.175-.105.292-.319.212-.097-.035-.166-.085-.147-.025.016.049-.01.083-.052.12-.125.112.123.068.181.06.181-.025.664-.076.66.093-.005.22.136.27.25.284.185.024.238.057.34.226.092.152.145.07.288.205.097.093.217.258.02.282-.047.005-.099 0-.12.017a.411.411 0 0 1-.14.066c-.295.09.14.136.246.113.093-.02.209-.05.3-.027.057.015.062.08.244.107.06.01.036.099.006.16-.104.214.191.1.16.263-.017.093.11.245-.067.248-.057.001-.117-.015-.115.034.004.105-.165-.03-.317.115-.056.054-.19.092-.272-.009-.032-.038-.07-.069-.218-.023-.144.046-.242.204-.306-.04-.017-.064-.05-.065-.142-.097-.125-.043-.114-.258-.297-.12a.24.24 0 0 1-.214.039c-.144-.037-.303.012-.317-.096-.021-.179-.191-.305-.377-.296-.147.008-.278.034-.355-.137.057.195.207.208.382.208.144 0 .23.075.255.225.045.265.204.099.406.223.1.06.17.159.21.273.042.118.37-.024.282.258-.037.122-.107.168-.242.266-.4.294-.5.004-.618.239-.062.121-.063.031-.196.09-.22.098-.36-.128-.522-.045-.182.094-.168-.08-.352.037-.152.097-.308-.074-.38.192-.063.227-.322.232-.44.11-.189-.194-.132.229-.362.054-.123-.091-.213.043-.392.045-.33.005-.489-.282-.65-.107-.192.206-.331-.032-.334-.242-.003-.216-.777-.144-1.185-.256-.225-.062-.932.013-.702-.35-.372.39.456.366.682.455.136.053.245.095.377.114.13.296.214.617.227 1.007.043-.214.053-.433.028-.649-.043-.383.242.19.276.272.184.45-.022 1.278-.488 1.526a2.957 2.957 0 0 0-.562-.99c.256.392.616 1.192.327 1.65a1.023 1.023 0 0 1-.55-.483c.077.333.413.702.818.58.707-.213.704.233 1.641.307.682.111 1.654 0 2.118.037.254.02 1.32.197 1.315.465-.02 1.105-.438 1.164-1.539 1.268-.64.06-1.134.085-1.823.11-1.54.058-3.391.06-4.868 0-.724-.03-1.072-.036-1.841-.137-.769-.1-1.19-.363-1.178-1.187.005-.304.905-.594 1.2-.628.347-.039.901.005 1.405-.116.527-.127.747-.21 1.135-.508Zm5.347-6.052c-.167-.042-.051-.138-.339-.014-.17.073-.194-.13-.365-.094-.172.036-.242-.125-.499-.166-.318-.05-.088-.133-.592-.032-.097.02-.179-.09-.481-.052-.355.046-.23.084-.445-.115-.272-.251-.488-.082-.767-.184.216.166.368.019.622.221-.242.138-.523.802-.962.844.478.107.709.354 1.148.413.504.068.882.118 1.151.531.301.463.44.196.874.168.275-.017.282-.185.328-.362.063-.245.126-.256.31-.289.213-.037.163-.092.107-.156-.15-.172.019-.207.146-.244.222-.064.042-.075.042-.166-.278-.09-.063-.217.092-.273.169.105.242.087.317.073.109-.021.181.03.273-.028-.135.014-.163-.037-.278-.02-.051.007-.112.01-.219-.054-.18-.107-.27.048-.463 0Zm-2.28 1.64-1.09-.545c-1.316-.657-1.915.313-2.337 1.376l-.766.73c.549-.338.996-.714 1.574-.71.092 0 1.516.484 1.286-.092-.04-.104.09-.052.125-.201.04-.17.055-.141.195-.033.089.069.211.113.174-.048-.017-.072-.04-.137.28-.004.15.062.095-.064.303-.09.29-.034.228-.31.364-.349.076-.022.152.058.295-.077.05-.046.11-.089.232-.057-.143-.073-.22-.014-.292.03-.146.089-.204-.037-.343.07Zm-2.23-1.923c.16-.02.32-.036.482-.046a.13.13 0 0 0 .074-.06.111.111 0 0 0 .007-.09.268.268 0 0 1 .147-.206l-.002-.003c-.258.001-.466.1-.73.211-.052.022-.024.111-.118.213a.26.26 0 0 1-.201.235.136.136 0 0 0-.09.046.113.113 0 0 0-.026.092.252.252 0 0 1-.277.061c-.2-.077-.35-.065-.448.036a.39.39 0 0 1 .398.014c.134.066.3.031.39-.082a.132.132 0 0 1 .126-.098.421.421 0 0 0 .268-.323Z",fill:"#fff"})))};
/***/},
/***/51609:
/***/e=>{"use strict";e.exports=window.React}
/***/,
/***/52619:
/***/e=>{"use strict";e.exports=window.wp.hooks}
/***/,
/***/56427:
/***/e=>{"use strict";e.exports=window.wp.components}
/***/,
/***/61730:
/***/e=>{"use strict";e.exports="assets/dist/images/onboarding-theme-small-mobile-3-8ae32618f58aba019865.webp"}
/***/,
/***/61912:
/***/(e,s,t)=>{"use strict";
/* unused harmony export preloadedDataUsedOnceMiddleware */
/* harmony import */var i=t(93832),n=t(1455);
/* harmony import */t.n(n)().use(
/**
 * WordPress dependencies
 */
/**
 * Use data preloaded with createPreloadingMiddleware only once.
 */
function(){const e={};return(s,t)=>("string"!=typeof s.path||"GET"!==s.method&&s.method||(e[s.path]?s.path=(0,i.addQueryArgs)(s.path,{__skip_preload:1}):e[s.path]=!0),t(s))}())}
/***/,
/***/62416:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>u
/* harmony export */});
/* harmony import */var i=t(86087),n=t(56427),r=t(93832),a=t(27723),o=t(34198),l=t(72316),c=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
const d="senseiSignupCallback",u=({onSubmit:e})=>{const{stepData:s}=(0,l/* .useSetupWizardStep */.m)("newsletter"),[t,u]=(0,i.useState)(s.admin_email),[m,p]=(0,i.useState)(!1),[_,h]=(0,i.useState)(!1);
return(0,c.jsxs)(c.Fragment,{children:[_&&(0,c.jsx)(n.Notice,{status:"error",className:"sensei-setup-wizard__error-notice",isDismissible:!1,children:_}),(0,c.jsxs)("form",{action:s.mc_url,method:"GET",className:"sensei-signup-form",onSubmit:s=>{s.preventDefault();const t=new window.FormData(s.target),i=(0,r.addQueryArgs)(s.target.action,Object.fromEntries(t));
// JSONP callback.
window[d]=s=>{p(!1),"error"===s.result?h(s.msg):e()};
// Create and append JSONP script.
const n=document.createElement("script");n.src=`${i}&c=${d}`,n.onerror=()=>{p(!1),h((0,a.__)("Failed to connect to the server. Please try again later.","sensei-lms"))},p(!0),h(!1),document.body.append(n)},children:[(0,c.jsx)("input",{type:"hidden",name:`gdpr[${s.gdpr_field}]`,value:"Y"}),(0,c.jsx)(n.TextControl,{className:"sensei-setup-wizard__text-control sensei-signup-form__text-control",placeholder:(0,a.__)("Your email address","sensei-lms"),type:"email",name:"EMAIL",value:t,onChange:u}),(0,c.jsx)("button",{disabled:m,className:"sensei-setup-wizard__button sensei-setup-wizard__button--primary sensei-signup-form__button",type:"submit",...(0,o/* .logLink */.P)("setup_wizard_newsletter_signup"),children:(0,a.__)("Nice! Sign me up","sensei-lms")})]})]})};
/**
 * Sign up to Sensei Mailing list.
 *
 * Submits form to mailing list provider signup page in new tab.
 * Fills in site administrator e-mail address.
 *
 * @param {Object}   props          Component props.
 * @param {Function} props.onSubmit Submit callback.
 */}
/***/,
/***/62540:
/***/(e,s,t)=>{"use strict";e.exports=t(2192)}
/***/,
/***/65312:
/***/e=>{"use strict";e.exports="assets/dist/images/onboarding-theme-small-mobile-1-a7ae6d9f83074abdba06.webp"}
/***/,
/***/65471:
/***/(e,s,t)=>{"use strict";
/* harmony import */t(3582);
/* harmony import */}
/***/,
/***/65498:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>a
/* harmony export */});
/* harmony import */var i=t(66087),n=t(3735);
/* harmony import */
/**
 * External dependencies
 */
/**
 * Internal dependencies
 */
const r={isFetching:!0,fetchError:!1,isSubmitting:!1,submitError:!1,data:{purpose:{selected:[],other:""},theme:{install_sensei_theme:!1},tracking:{usage_tracking:!1},features:{selected:[],options:[]}}},a=(e=r,s)=>{switch(s.type){case n/* .START_FETCH_SETUP_WIZARD_DATA */.pI:return{...e,isFetching:!0,fetchError:!1};case n/* .SUCCESS_FETCH_SETUP_WIZARD_DATA */.oE:return{...e,isFetching:!1,data:{...e.data,...s.data}};case n/* .ERROR_FETCH_SETUP_WIZARD_DATA */.P:return{...e,isFetching:!1,fetchError:s.error};case n/* .START_SUBMIT_SETUP_WIZARD_DATA */.FY:return{...e,isSubmitting:!0,submitError:!1};case n/* .SUCCESS_SUBMIT_SETUP_WIZARD_DATA */._0:return{...e,isSubmitting:!1};case n/* .ERROR_SUBMIT_SETUP_WIZARD_DATA */.jI:return{...e,isSubmitting:!1,submitError:s.error};case n/* .SET_DATA */.M9:
// It avoids merging arrays, so it works properly when removing item from arrays.
const t=(e,s)=>{if(Array.isArray(s))return s};return{...e,data:(0,i.mergeWith)(e.data,s.data,t)};default:return e}};
/**
 * Setup wizard reducer.
 *
 * @param {Object}         state  Current state.
 * @param {{type: string}} action Action to update the state.
 *
 * @return {Object} State updated.
 */
/* harmony default export */}
/***/,
/***/66087:
/***/e=>{"use strict";e.exports=window.lodash}
/***/,
/***/66161:
/***/e=>{"use strict";e.exports=window.wp.dataControls}
/***/,
/***/66770:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>d
/* harmony export */});
/* harmony import */var i=t(43066),n=t(90448),r=t(12031),a=t(40249),o=t(80605),l=t(36165),c=t(62540);
/* harmony import */
/**
 * Internal dependencies
 */
const d=[{key:"welcome",container:(0/* ["default"] */,c.jsx)(i.A,{})},{key:"purpose",container:(0/* ["default"] */,c.jsx)(n.A,{})},{key:"theme",container:(0/* ["default"] */,c.jsx)(r.A,{})},{key:"tracking",container:(0/* ["default"] */,c.jsx)(a.A,{})},{key:"newsletter",container:(0/* ["default"] */,c.jsx)(o.A,{})},{key:"features",container:(0/* ["default"] */,c.jsx)(l.A,{})}].filter((
// Remove theme step if it's already installed.
e=>!("theme"===e.key&&window.sensei.isCourseThemeInstalled)));
/* harmony default export */}
/***/,
/***/69178:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>g
/* harmony export */});
/* harmony import */var i=t(27723),n=t(38407),r=t(21627),a=t(42722),o=t(7619),l=t(24576),c=t(25593),d=t(14558),u=t(22502),m=t(98106),p=t(77627),_=t(34808),h=t(90473),w=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Theme step content for big screens.
 */
const g=()=>(0,w.jsxs)("div",{className:"sensei-setup-wizard-theme",children:[(0,w.jsx)("div",{className:"sensei-setup-wizard-theme__main-image",children:(0,w.jsx)("div",{className:"sensei-setup-wizard-theme__image-wrapper",children:(0,w.jsx)("img",{src:window.sensei.pluginUrl+r,alt:(0,i.__)("Sensei theme illustration","sensei-lms"),className:"sensei-setup-wizard-theme__image"})})}),(0/* .Section */,w.jsxs)(n.w,{className:"sensei-setup-wizard-theme__section",children:[(0,w.jsx)(n.H,{className:"sensei-setup-wizard__subsection-title",children:(0,i.__)("Mobile optimized so it looks great on any screen size","sensei-lms")}),(0,w.jsxs)("ul",{className:"sensei-setup-wizard-theme__mobile-images",children:[(0,w.jsx)("li",{children:(0,w.jsx)("div",{className:"sensei-setup-wizard-theme__image-wrapper",children:(0,w.jsx)("img",{src:window.sensei.pluginUrl+a,alt:(0,i.__)("Sensei theme illustration","sensei-lms"),className:"sensei-setup-wizard-theme__image"})})}),(0,w.jsx)("li",{children:(0,w.jsx)("div",{className:"sensei-setup-wizard-theme__image-wrapper",children:(0,w.jsx)("img",{src:window.sensei.pluginUrl+o,alt:(0,i.__)("Sensei theme illustration","sensei-lms"),className:"sensei-setup-wizard-theme__image"})})}),(0,w.jsx)("li",{children:(0,w.jsx)("div",{className:"sensei-setup-wizard-theme__image-wrapper",children:(0,w.jsx)("img",{src:window.sensei.pluginUrl+l,alt:(0,i.__)("Sensei theme illustration","sensei-lms"),className:"sensei-setup-wizard-theme__image"})})}),(0,w.jsx)("li",{children:(0,w.jsx)("div",{className:"sensei-setup-wizard-theme__image-wrapper",children:(0,w.jsx)("img",{src:window.sensei.pluginUrl+c,alt:(0,i.__)("Sensei theme illustration","sensei-lms"),className:"sensei-setup-wizard-theme__image"})})}),(0,w.jsx)("li",{children:(0,w.jsx)("div",{className:"sensei-setup-wizard-theme__image-wrapper",children:(0,w.jsx)("img",{src:window.sensei.pluginUrl+d,alt:(0,i.__)("Sensei theme illustration","sensei-lms"),className:"sensei-setup-wizard-theme__image"})})})]})]}),(0/* .Section */,w.jsx)(n.w,{className:"sensei-setup-wizard-theme__section",children:(0,w.jsxs)("figure",{className:"sensei-setup-wizard-theme-testimonial",children:[(0,w.jsx)("img",{src:window.sensei.pluginUrl+u,alt:(0,i.__)("Sensei theme illustration","sensei-lms"),className:"sensei-setup-wizard-theme-testimonial__image"}),(0,w.jsxs)("div",{className:"sensei-setup-wizard-theme-testimonial__content",children:[(0,w.jsx)("blockquote",{className:"sensei-setup-wizard-theme-testimonial__quote",children:(0,w.jsx)("p",{children:(0,i.__)("I always wanted to write, and thanks to Course, I got it right. My writing is clearer, and I can finally get my message across.","sensei-lms")})}),(0,w.jsxs)("figcaption",{children:[(0,w.jsx)("strong",{className:"sensei-setup-wizard-theme-testimonial__author",children:"Cristopher Brown"}),(0,i.__)("Founder at BeautifulWriting.com","sensei-lms")]})]})]})}),(0/* .Section */,w.jsxs)(n.w,{className:"sensei-setup-wizard-theme__section",children:[(0,w.jsx)(n.H,{className:"sensei-setup-wizard__subsection-title",children:(0,i.__)("All new and improved Learning Mode to help keep your students focused","sensei-lms")}),(0,w.jsx)("div",{className:"sensei-setup-wizard-theme__learning-mode-carousel",children:(0/* ["default"] */,w.jsxs)(h.A,{children:[(0/* ["default"] */,w.jsx)(h.A.Item,{children:(0,w.jsx)("div",{className:"sensei-setup-wizard-theme__image-wrapper",children:(0,w.jsx)("img",{src:window.sensei.pluginUrl+m,alt:(0,i.__)("Sensei theme illustration","sensei-lms"),className:"sensei-setup-wizard-theme__image"})})}),(0/* ["default"] */,w.jsx)(h.A.Item,{children:(0,w.jsx)("div",{className:"sensei-setup-wizard-theme__image-wrapper",children:(0,w.jsx)("img",{src:window.sensei.pluginUrl+p,alt:(0,i.__)("Sensei theme illustration","sensei-lms"),className:"sensei-setup-wizard-theme__image"})})}),(0/* ["default"] */,w.jsx)(h.A.Item,{children:(0,w.jsx)("div",{className:"sensei-setup-wizard-theme__image-wrapper",children:(0,w.jsx)("img",{src:window.sensei.pluginUrl+_,alt:(0,i.__)("Sensei theme illustration","sensei-lms"),className:"sensei-setup-wizard-theme__image"})})})]})})]})]})
/* harmony default export */}
/***/,
/***/72316:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */m:()=>/* binding */l
/* harmony export */});
/* harmony import */var i=t(86087),n=t(47143),r=t(56427),a=t(37382),o=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * @typedef {Object} StepStoreHookHandle
 *
 * @property {Object}   stepData     Data for the step.
 * @property {Function} submitStep   Method to POST to endpoint.
 * @property {boolean}  isSubmitting Submitting state.
 * @property {Object}   error        Submit error.
 * @property {Element}  errorNotice  Error notice element.
 */
/**
 * Use Setup Wizard State store and REST API for the given step.
 *
 * Gets step-specific data, and provides a submit function that sends step form data to the step endpoint
 * via POST request.
 *
 * @param {string} step Setup Wizard step endpoint name.
 * @return {StepStoreHookHandle} handle
 */
const l=e=>{const{stepData:s,isSubmitting:t,error:l}=(0,n.useSelect)((s=>{const t=s(a/* .store */.M);return{stepData:t.getStepData(e),isSubmitting:t.isSubmitting(),error:t.getSubmitError()}}),[]),{submitStep:c}=(0/* .store */,n.useDispatch)(a.M),d=l?(0,o.jsx)(r.Notice,{status:"error",className:"sensei-setup-wizard__error-notice",isDismissible:!1,children:l.message}):null;return{stepData:s,submitStep:(0,i.useCallback)(((s,t)=>c(e,s,t)),[e,c]),isSubmitting:t,error:l,errorNotice:d}};
/***/},
/***/77549:
/***/(e,s,t)=>{"use strict";
/* unused harmony exports useColorsByProbe, getProbeStyles */
/* harmony import */var i=t(66087);
/* harmony import */t(86087),t(47143);
/**
 * External dependencies
 */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
const{getComputedStyle:n}=window;
/**
 * Get color object by probe.
 *
 * @return {Object} Object containing the color objects, where the key is the probe key.
 */(0,i.memoize)((()=>{
// Create temporary probe elements.
const e=document.createElement("div");e.className="editor-styles-wrapper sensei-probe-element";const s=document.createElement("div");s.className="wp-block-button";const t=document.createElement("div");t.className="wp-block-button__link",t.textContent="Probe",
// Set probe position outside the screen to be hidden.
e.style.position="fixed",e.style.top="-100vh",
// Add probe to the screen.
s.appendChild(t),e.appendChild(s),document.body.appendChild(e);
// Save styles.
const i={primaryColor:n(t).backgroundColor,primaryContrastColor:n(t).color};
// Remove probe.
return document.body.removeChild(e),i}))}
/***/,
/***/77627:
/***/e=>{"use strict";e.exports="assets/dist/images/onboarding-theme-learning-mode-2-a9e44911c7fa0d006155.webp"}
/***/,
/***/80605:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>l
/* harmony export */});
/* harmony import */var i=t(27723),n=t(62416),r=t(9816),a=t(38407),o=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Newsletter step for Setup Wizard.
 */
const l=()=>{const{goNext:e}=(0,r/* .useQueryStringRouter */.Yr)();
return(0,o.jsxs)(o.Fragment,{children:[(0,o.jsxs)("div",{className:"sensei-setup-wizard__content",children:[(0,o.jsx)(a.H,{className:"sensei-setup-wizard__step-title",children:(0,i.__)("Be the first to know about new features","sensei-lms")}),(0,o.jsx)("p",{children:(0,i.__)("Sensei is growing fast and we’re constantly releasing new features. Join on our mailing list to know first.","sensei-lms")}),(0,o.jsxs)("div",{className:"sensei-setup-wizard__actions sensei-setup-wizard__actions--full-width",children:[(0/* ["default"] */,o.jsx)(n.A,{onSubmit:e}),(0,o.jsx)("div",{className:"sensei-setup-wizard__action-skip",children:(0,o.jsx)("button",{className:"sensei-setup-wizard__button sensei-setup-wizard__button--link",onClick:e,children:(0,i.__)("Skip newsletter signup","sensei-lms")})})]})]}),(0,o.jsx)("div",{className:"sensei-setup-wizard__illustration sensei-setup-wizard__illustration--newsletter","aria-hidden":"true"})]})};
/* harmony default export */}
/***/,
/***/81655:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>n
/* harmony export */});
/* harmony import */var i=t(86087);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Hook for event listeners.
 *
 * @param {string}   eventName Event name to be attached.
 * @param {Function} handler   Handler function to the event.
 * @param {Array}    deps      Dependencies of the handler function.
 * @param {Object}   element   Element to attach the event. Default is `window`.
 */
const n=(e,s,t,n=window)=>{
// eslint-disable-next-line react-hooks/exhaustive-deps
const r=(0,i.useCallback)(s,t);(0,i.useEffect)((()=>{const s=[e,r,!1];return n.addEventListener(...s),()=>{n.removeEventListener(...s)}}),[e,r,n])};
/* harmony default export */}
/***/,
/***/84299:
/***/(e,s,t)=>{"use strict";
/* unused harmony export useMergeReducer */
/* harmony import */t(86087);
/* harmony import */}
/***/,
/***/86087:
/***/e=>{"use strict";e.exports=window.wp.element}
/***/,
/***/89125:
/***/(e,s,t)=>{"use strict";t.r(s),
/* harmony export */t.d(s,{
/* harmony export */errorFetch:()=>/* binding */o
/* harmony export */,errorSubmit:()=>/* binding */u
/* harmony export */,fetchSetupWizardData:()=>/* binding */r
/* harmony export */,setData:()=>/* binding */p
/* harmony export */,startFetch:()=>/* binding */l
/* harmony export */,startSubmit:()=>/* binding */c
/* harmony export */,submitStep:()=>/* binding */m
/* harmony export */,successFetch:()=>/* binding */a
/* harmony export */,successSubmit:()=>/* binding */d
/* harmony export */});
/* harmony import */var i=t(66161),n=t(3735);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Fetch setup wizard data action creator.
 */
function*r(){yield l();try{const e=yield(0,i.apiFetch)({path:n/* .API_BASE_PATH */.DN.replace(/\/$/,"")});yield a(e)}catch(e){yield o(e)}}
/**
 * @typedef  {Object} SuccessSetupWizardDataAction
 * @property {string} type Action type.
 * @property {Object} data Setup wizard data.
 */
/**
 * Success fetch action creator.
 *
 * @param {Object} data Setup wizard data.
 *
 * @return {SuccessSetupWizardDataAction} Success fetch action.
 */const a=e=>({type:n/* .SUCCESS_FETCH_SETUP_WIZARD_DATA */.oE,data:e})
/**
 * @typedef  {Object}         ErrorFetchAction
 * @property {string}         type  Action type.
 * @property {Object|boolean} error Error object or false.
 */
/**
 * Error fetch action creator.
 *
 * @param {Object|boolean} error Error object or false.
 *
 * @return {ErrorFetchAction} Error action.
 */,o=e=>({type:n/* .ERROR_FETCH_SETUP_WIZARD_DATA */.P,error:e})
/**
 * Start fetch setup wizard data action creator.
 *
 * @return {{type: string}} Start fetch action.
 */,l=()=>({type:n/* .START_FETCH_SETUP_WIZARD_DATA */.pI})
/**
 * Start submit action creator.
 *
 * @return {{type: string}} Start submit action.
 */,c=()=>({type:n/* .START_SUBMIT_SETUP_WIZARD_DATA */.FY})
/**
 * Success submit action creator.
 *
 * @return {{type: string}} Success submit action.
 */,d=()=>({type:n/* .SUCCESS_SUBMIT_SETUP_WIZARD_DATA */._0})
/**
 * @typedef  {Object}         ErrorSubmitAction
 * @property {string}         type  Action type.
 * @property {Object|boolean} error Error object or false.
 */
/**
 * Error submit action creator.
 *
 * @param {Object|boolean} error Error object or false.
 *
 * @return {ErrorSubmitAction} Error action.
 */,u=e=>({type:n/* .ERROR_SUBMIT_SETUP_WIZARD_DATA */.jI,error:e})
/**
 * Submit step action creator.
 *
 * @param {string}   step                Step name.
 * @param {Object}   data                Data to submit.
 * @param {Object}   [options]
 * @param {Function} [options.onSuccess] Step name.
 * @param {Function} [options.onError]   Data to submit.
 */;function*m(e,s,{onSuccess:t,onError:r}={}){yield c();try{yield(0,i.apiFetch)({path:n/* .API_BASE_PATH */.DN+e,method:"POST",data:s}),yield d(),yield p(s),t&&t()}catch(e){yield u(e),r&&r(e)}}
/**
 * @typedef  {Object} SetDataAction
 * @property {string} type Action type.
 * @property {Object} data Data object.
 */
/**
 * Set data action creator.
 *
 * @param {Object} data Data object.
 *
 * @return {SetDataAction} Set data action.
 */const p=e=>({type:n/* .SET_DATA */.M9,data:e})
/***/},
/***/90448:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>p
/* harmony export */});
/* harmony import */var i=t(27723),n=t(56427),r=t(86087),a=t(9816),o=t(72316),l=t(38407),c=t(29656),d=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
const u=[{id:"sell_courses",label:(0,i.__)("Sell courses and generate income","sensei-lms"),feature:"woocommerce"},{id:"provide_certification",label:(0,i.__)("Provide certification","sensei-lms"),feature:"sensei-certificates"},{id:"educate_students",label:(0,i.__)("Educate students","sensei-lms")},{id:"train_employees",label:(0,i.__)("Train employees","sensei-lms")}],m=(e,s)=>{const t=s.find((s=>s.product_slug===e));if(t&&!t.is_activated){const e=t.is_installed?(0,i.__)("activated","sensei-lms"):(0,i.__)("installed for free","sensei-lms");return(0,i.sprintf)(
// translators: %1$s Plugin name, %2$s Action that will be done.
// translators: %1$s Plugin name, %2$s Action that will be done.
(0,i.__)("%1$s will be %2$s.","sensei-lms"),t.title,e)}return null},p=()=>{const{goNext:e}=(0,a/* .useQueryStringRouter */.Yr)(),{stepData:s,submitStep:t,isSubmitting:p,errorNotice:_}=(0,o/* .useSetupWizardStep */.m)("purpose"),{stepData:h}=(0,o/* .useSetupWizardStep */.m)("features"),[{selected:w,other:g},x]=(0,r.useState)({selected:[],other:""});(0,r.useEffect)((()=>x(s)),[s]);const b=!w.length,f=e=>{x((s=>({...s,selected:w.includes(e)?w.filter((s=>s!==e)):[e,...w]})))};
return(0,d.jsxs)("div",{className:"sensei-setup-wizard__content",children:[(0,d.jsxs)("div",{className:"sensei-setup-wizard__title",children:[(0,d.jsx)(l.H,{className:"sensei-setup-wizard__step-title",children:(0,i.__)("Choose the purpose of your site","sensei-lms")}),(0,d.jsx)("p",{children:(0,i.__)("Select your goals for offering courses, and we will help you set everything up.","sensei-lms")})]}),(0,d.jsxs)("ul",{className:"sensei-setup-wizard__purpose-list",children:[u.map((({id:e,label:s,feature:t})=>(0/* ["default"] */,d.jsx)(c.A,{label:s,checked:w.includes(e),onToggle:()=>f(e),children:t&&m(t,h.options)},e))),(0/* ["default"] */,d.jsx)(c.A,{label:(0,i.__)("Other","sensei-lms"),checked:w.includes("other"),onToggle:()=>f("other"),children:(0,d.jsx)(n.TextControl,{className:"sensei-setup-wizard__text-control",value:g,placeholder:(0,i.__)("Description","sensei-lms"),onChange:e=>x((s=>({...s,other:e})))})})]}),(0,d.jsxs)("div",{className:"sensei-setup-wizard__actions sensei-setup-wizard__actions--full-width",children:[
// It should contain WooCommerce + other Sensei extensions.
h.options.length<=1&&(0,d.jsx)(n.Notice,{status:"error",className:"sensei-setup-wizard__error-notice",isDismissible:!1,actions:[{label:(0,i.__)("Refresh the page","sensei-lms"),url:window.location.href}],children:(0,i.__)("An error happened while loading the Sensei extensions.","sensei-lms")}),_,(0,d.jsx)("button",{disabled:p||b,className:"sensei-setup-wizard__button sensei-setup-wizard__button--primary",onClick:()=>{const s=u.filter((e=>e.feature&&w.includes(e.id))).map((e=>e.feature));t({purpose:{selected:w,other:g},features:{selected:s}},{onSuccess:e})},children:(0,i.__)("Continue","sensei-lms")}),(0,d.jsx)("div",{className:"sensei-setup-wizard__action-skip",children:(0,d.jsx)("button",{disabled:p,className:"sensei-setup-wizard__button sensei-setup-wizard__button--link",onClick:e,children:(0,i.__)("Skip customization","sensei-lms")})})]})]})};
/**
 * Get a description of a feature that will be installed or activated.
 *
 * @param {string} slug     Slug of the feature to check.
 * @param {Array}  features Features list.
 *
 * @return {string|null} Install description or `null` if it won't install anything.
 */}
/***/,
/***/90473:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>m
/* harmony export */});
/* harmony import */var i=t(4452),n=t.n(i),r=t(86087),a=t(27723),o=t(44196),l=t(45380),c=t(40427),d=t(62540);
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
 * Carousel component.
 *
 * @param {Object} props          Component props.
 * @param {Object} props.children Component children.
 */
const u=({children:e})=>{const[s,t]=(0,r.useState)(0),[i,u]=(0,r.useState)(0),m=r.Children.count(e),p=()=>0!==s&&(t(s-1),!0),_=()=>s!==m-1&&(t(s+1),!0),h=e=>100*-e
/**
   * Drag event.
   *
   * @param {Object} arg       Drag argument.
   * @param {Object} arg.event Drag event.
   * @param {Object} arg.diff  Drag diff.
   */,{draggableProps:w,isDragging:g}=(0,o/* .useDragging */.tQ)({onDrag:({event:e,diff:t})=>{const i=e.target.getBoundingClientRect().width;
// Update translate based on the partial drag.
u(h(s)+t.x/i*100)},onDragEnd:({event:e,diff:t})=>{const i=e.target.getBoundingClientRect().width,n=t.x/i*100;Math.abs(n)<=50?
// If didn't drag enough, reset the current index translate.
u(h(s)):n>50?p()||
// If didn't move, reset the current index translate.
u(h(s)):n<-50&&(_()||
// If didn't move, reset the current index translate.
u(h(s)))}});(0,r.useEffect)((()=>{u(h(s))}),[s]);const x={transform:`translateX(${i}%)`};
return(0,d.jsxs)("div",{className:n()("sensei-carousel",{"sensei-carousel--is-dragging":g}),children:[(0,d.jsx)("div",{...w,className:"sensei-carousel__viewport",children:(0,d.jsx)("ul",{className:"sensei-carousel__slider",style:x,children:e})}),(0,d.jsxs)("div",{className:"sensei-carousel__controls",children:[(0,d.jsx)("button",{className:"sensei-carousel__control sensei-carousel__control--prev",onClick:p,title:(0,a.__)("Previous","sensei-lms"),disabled:0===s,children:(0/* ["default"] */,d.jsx)(l.A,{})}),(0,d.jsx)("button",{className:"sensei-carousel__control sensei-carousel__control--next",onClick:_,title:(0,a.__)("Next","sensei-lms"),disabled:s===m-1,children:(0/* ["default"] */,d.jsx)(c.A,{})})]})]})};u.Item=({children:e})=>(0,d.jsx)("li",{children:e})
/* harmony default export */;const m=u;
/***/},
/***/91336:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>a
/* harmony export */});
/* harmony import */var i=t(27723),n=t(9816),r=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Progress Bar component.
 *
 * @param {Object} props       Component props.
 * @param {Array}  props.steps The available steps.
 */
const a=({steps:e})=>{const{currentRoute:s}=(0,n/* .useQueryStringRouter */.Yr)(),t=e.length,a=(e.findIndex((e=>e.key===s))+1)/t*100;
return(0,r.jsx)("div",{className:"sensei-setup-wizard__navigation-bar",children:(0,r.jsx)("div",{role:"progressbar","aria-label":(0,i.__)("Sensei Onboarding Progress","sensei-lms"),"aria-valuenow":a,className:"sensei-setup-wizard__navigation-bar-filled",style:{width:`${a}%`}})})};
/* harmony default export */}
/***/,
/***/93301:
/***/(e,s,t)=>{"use strict";
/* harmony import */t(66087),t(47143),t(86087)
/* harmony import */}
/***/,
/***/93832:
/***/e=>{"use strict";e.exports=window.wp.url}
/***/,
/***/98106:
/***/e=>{"use strict";e.exports="assets/dist/images/onboarding-theme-learning-mode-1-d35a0a65d525e0680834.webp"}
/***/
/******/},s={};
/************************************************************************/
/******/ // The module cache
/******/
/******/
/******/ // The require function
/******/function t(i){
/******/ // Check if module is in cache
/******/var n=s[i];
/******/if(void 0!==n)
/******/return n.exports;
/******/
/******/ // Create a new module (and put it into the cache)
/******/var r=s[i]={
/******/ // no module.id needed
/******/ // no module.loaded needed
/******/exports:{}
/******/};
/******/
/******/ // Execute the module function
/******/
/******/
/******/ // Return the exports of the module
/******/return e[i](r,r.exports,t),r.exports;
/******/}
/******/
/************************************************************************/
/******/ /* webpack/runtime/compat get default export */
/******/
/******/ // getDefaultExport function for compatibility with non-harmony modules
/******/t.n=e=>{
/******/var s=e&&e.__esModule?
/******/()=>e.default
/******/:()=>e
/******/;
/******/return t.d(s,{a:s}),s;
/******/},
/******/ // define getter functions for harmony exports
/******/t.d=(e,s)=>{
/******/for(var i in s)
/******/t.o(s,i)&&!t.o(e,i)&&
/******/Object.defineProperty(e,i,{enumerable:!0,get:s[i]})
/******/;
/******/},
/******/t.o=(e,s)=>Object.prototype.hasOwnProperty.call(e,s)
/******/,
/******/ // define __esModule on exports
/******/t.r=e=>{
/******/"undefined"!=typeof Symbol&&Symbol.toStringTag&&
/******/Object.defineProperty(e,Symbol.toStringTag,{value:"Module"})
/******/,Object.defineProperty(e,"__esModule",{value:!0})}
/******/,
// This entry needs to be wrapped in an IIFE because it needs to be in strict mode.
(()=>{"use strict";
/* harmony import */var e=t(47143),s=t(86087),i=t(56427),n=t(27723),r=(t(61912),t(37382)),a=t(44196),o=t(9816),l=t(91336),c=t(48597),d=t(66770),u=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Register setup wizard store.
 */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Register setup wizard store.
 */
(0,r/* ["default"] */.A)();
/**
 * Param name used to route the setup wizard.
 */
const m=()=>{const{currentRoute:e}=(0,o/* .useQueryStringRouter */.Yr)();return(0,a/* .useWpAdminFullscreen */.ZN)(["sensei-setup-wizard-page",`sensei-setup-wizard-page--${e}`]),null},p=()=>{const{isFetching:t,error:a}=(0,e.useSelect)((e=>{const s=e(r/* .store */.M);return{isFetching:s.isFetching(),error:s.getFetchError()}}),[]),{fetchSetupWizardData:p}=(0/* .store */,e.useDispatch)(r.M);
// We want to show the loading before any content.
// We want to show the loading before any content.
(0,s.useLayoutEffect)((()=>{p()}),[p]);let _=null;return _=t?(0,u.jsx)(i.Spinner,{className:"sensei-setup-wizard__main-loader"}):a?(0,u.jsxs)(i.Notice,{status:"error",isDismissible:!1,children:[(0,n.__)("An error has occurred while fetching the data. Please try again later!","sensei-lms"),(0,u.jsx)("br",{}),(0,n.__)("Error details:","sensei-lms")," ",a.message]}):(0,u.jsx)("div",{className:"sensei-setup-wizard__container",children:d/* ["default"] */.A.map((e=>(0/* .Route */,u.jsx)(o.qh,{route:e.key,children:e.container},e.key)))}),(0/* ["default"] */,u.jsxs)(o.Ay,{paramName:"step",routes:d/* ["default"] */.A.map((e=>e.key)),defaultRoute:d/* ["default"] */.A[0].key,children:[(0,u.jsx)(m,{}),(0,u.jsxs)("header",{className:"sensei-setup-wizard__header",children:[(0/* ["default"] */,u.jsx)(l.A,{steps:d/* ["default"] */.A}),(0,u.jsxs)("h1",{className:"sensei-setup-wizard__sensei-logo",children:[(0/* ["default"] */,u.jsx)(c.A,{})," Sensei"]})]}),_]})};
/**
 * A component to set the full screen and a custom class related to the current route.
 */(0,s.createRoot)(document.getElementById("sensei-setup-wizard-page")).render((0,u.jsx)(p,{}))})()})
/******/();