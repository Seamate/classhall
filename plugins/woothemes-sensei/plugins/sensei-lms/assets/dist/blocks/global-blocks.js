/******/(()=>{// webpackBootstrap
/******/var e={
/***/1027:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>n
/* harmony export */});
/* harmony import */var o=t(5573),r=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
const n=(0,r.jsx)(o.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24",children:(0,r.jsx)(o.Path,{d:"M16.7 7.1l-6.3 8.5-3.3-2.5-.9 1.2 4.5 3.4L17.9 8z"})});
/* harmony default export */}
//# sourceMappingURL=check.js.map
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
 */var o=t(51609),r=Symbol.for("react.element"),n=Symbol.for("react.fragment"),l=Object.prototype.hasOwnProperty,i=o.__SECRET_INTERNALS_DO_NOT_USE_OR_YOU_WILL_BE_FIRED.ReactCurrentOwner,a={key:!0,ref:!0,__self:!0,__source:!0};function c(e,s,t){var o,n={},c=null,u=null;for(o in void 0!==t&&(c=""+t),void 0!==s.key&&(c=""+s.key),void 0!==s.ref&&(u=s.ref),s)l.call(s,o)&&!a.hasOwnProperty(o)&&(n[o]=s[o]);if(e&&e.defaultProps)for(o in s=e.defaultProps)void 0===n[o]&&(n[o]=s[o]);return{$$typeof:r,type:e,key:c,ref:u,props:n,_owner:i.current}}s.Fragment=n,s.jsx=c,s.jsxs=c}
/***/,
/***/2567:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>a
/* harmony export */});
/* harmony import */var o=t(4452),r=t.n(o),n=t(56427),l=t(1027),i=t(62540);
/* harmony import */
/**
 * External dependencies
 */
/**
 * WordPress dependencies
 */
/**
 * @typedef {Object} DropdownOption
 *
 * @property {string} label Option label.
 * @property {string} value Option value.
 */
/**
 * Dropdown for the editor toolbar.
 *
 * @param {Object}           props
 * @param {DropdownOption[]} props.options          Dropdown options.
 * @param {string}           [props.optionsLabel]   Options label.
 * @param {Object}           props.icon             Icon for the toolbar.
 * @param {string}           props.value            Current dropdown value.
 * @param {Function}         props.onChange         Dropdown change callback, which receive the new value as argument.
 * @param {Object}           props.toggleProps      Props passed to the toggle element.
 * @param {Object}           props.popoverProps     Props passed to the popover component.
 * @param {Function}         props.getMenuItemProps Render function for a menu item. Should return a props object.
 */
const a=({options:e,optionsLabel:s,icon:t,value:o,onChange:a,toggleProps:c,getMenuItemProps:u,popoverProps:d,...p})=>{const m=e.find((e=>o===e.value));
return(0,i.jsx)(n.ToolbarDropdownMenu,{className:"sensei-toolbar-dropdown",popoverProps:{variant:"toolbar",position:"bottom right left",focusOnMount:!0,...d,className:r()(d?.className,"sensei-toolbar-dropdown__popover")},label:s,icon:null!=t?t:null,text:c?.children?c.children(m):m?.label,...p,children:({onClose:t})=>(0,i.jsx)(n.MenuGroup,{label:s,children:e.map((e=>{const s=e.value===m?.value,o=u?.(e);
return(0,i.jsx)(n.MenuItem,{role:"menuitemradio",isSelected:s,icon:s?l/* ["default"] */.A:null,className:r()("sensei-toolbar-dropdown__option",{"is-selected":s},o?.className),onClick:()=>{a(e.value),t()},children:e.label,...o},e.value)}))})})};
/* harmony default export */}
/***/,
/***/2883:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */n:()=>/* binding */o
/* harmony export */});
/**
 * An enum of Status constants.
 */
const o={NOT_STARTED:"not-started",IN_PROGRESS:"in-progress",COMPLETED:"completed"};
/***/},
/***/3582:
/***/e=>{"use strict";e.exports=window.wp.coreData}
/***/,
/***/4452:
/***/(e,s)=>{var t;
/*!
	Copyright (c) 2018 Jed Watson.
	Licensed under the MIT License (MIT), see
	http://jedwatson.github.io/classnames
*/
/* global define */!function(){"use strict";var o={}.hasOwnProperty;function r(){for(var e="",s=0;s<arguments.length;s++){var t=arguments[s];t&&(e=l(e,n(t)))}return e}function n(e){if("string"==typeof e||"number"==typeof e)return e;if("object"!=typeof e)return"";if(Array.isArray(e))return r.apply(null,e);if(e.toString!==Object.prototype.toString&&!e.toString.toString().includes("[native code]"))return e.toString();var s="";for(var t in e)o.call(e,t)&&e[t]&&(s=l(s,t));return s}function l(e,s){return s?e?e+" "+s:e+s:e}e.exports?(r.default=r,e.exports=r):void 0===(t=function(){return r}.apply(s,[]))||(e.exports=t)}()}
/***/,
/***/5573:
/***/e=>{"use strict";e.exports=window.wp.primitives}
/***/,
/***/5705:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */l:()=>/* binding */u
/* harmony export */});
/* harmony import */var o=t(47143),r=t(2883),n=t(66161),l=t(77505);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
const i={
/**
   * Sets thecreateReducerFromActionMap status of a lesson.
   *
   * @param {string} lessonId The lesson id.
   * @param {string} status   The lesson status.
   *
   * @return {Object} The setLessonStatus action.
   */
setLessonStatus:(e,s)=>({type:"SET_LESSON_STATUS",lessonId:e,status:s}),
/**
   * Sets the status of a module by updating the status of its lessons.
   *
   * @param {string} moduleId The module block id.
   * @param {string} status   The module status.
   *
   * @return {Object} Yields the lesson update actions.
   */
*setModuleStatus(e,s){const t=yield(0,n.select)(u,"getTrackedLessons"),o=(yield(0,n.select)("core/block-editor","getClientIdsOfDescendants",[e])).filter((e=>t.includes(e)));if(0!==o.length)return r/* .Status */.n.COMPLETED!==s&&r/* .Status */.n.NOT_STARTED!==s?(yield*o.slice(1).map((e=>i.setLessonStatus(e,r/* .Status */.n.NOT_STARTED))),i.setLessonStatus(o[0],r/* .Status */.n.COMPLETED)):void(yield*o.map((e=>i.setLessonStatus(e,s))))},
/**
   * Creates the action to update state after a possible removal of a lesson.
   *
   * @param {string[]} descendantIds The ids of all outline block descendants.
   *
   * @return {Object} The action.
   */
stopTrackingRemovedLessons:e=>({type:"REMOVE_LESSONS",descendantIds:e}),
/**
   * Creates the action which marks a lesson as tracked by the store.
   *
   * @param {string} lessonId The lesson id.
   *
   * @return {Object} The action.
   */
trackLesson:e=>({type:"TRACK_LESSON",lessonId:e}),
/**
   * Creates the action which marks a lesson as not tracked by the store.
   *
   * @param {string} lessonId The lesson id.
   *
   * @return {Object} The action.
   */
ignoreLesson:e=>({type:"IGNORE_LESSON",lessonId:e})},a={
/**
   * Get all the lessons that are tracked by the store.
   *
   * @param {Object} state                The state.
   * @param {Array}  state.trackedLessons The tracked lessons.
   *
   * @return {Object} An object with the total and completed lesson counts.
   */
getTrackedLessons:({trackedLessons:e})=>e
/**
   * Get the lesson counts.
   *
   * @param {Object} state                  The state.
   * @param {Array}  state.trackedLessons   The ids of all the lessons.
   * @param {Array}  state.completedLessons The ids of the completed lessons.
   *
   * @return {Object} An object with the total and completed lesson counts.
   */,getLessonCounts:({trackedLessons:e,completedLessons:s})=>({totalLessonsCount:e.length,completedLessonsCount:s.length})
/**
   * Gets the lesson status.
   *
   * @param {Object} state                  The state.
   * @param {Array}  state.completedLessons The ids of the completed lessons.
   * @param {string} lessonId               The lesson id.
   *
   * @return {string} The lesson status.
   */,getLessonStatus:({completedLessons:e},s)=>e.includes(s)?r/* .Status */.n.COMPLETED:r/* .Status */.n.NOT_STARTED
/**
   * Returns the number of total and completed lessons of a module.
   *
   * @param {Object} state                  The state.
   * @param {Array}  state.completedLessons The ids of the completed lessons.
   * @param {Array}  state.trackedLessons   The ids of  all the lessons.
   * @param {string} moduleId               The module id.
   *
   * @return {Object} The module lesson counts.
   */,getModuleLessonCounts({completedLessons:e,trackedLessons:s},t){const r=(0,o.select)("core/block-editor").getClientIdsOfDescendants([t]).filter((e=>s.includes(e)));return{completedLessonsCount:r.filter((s=>e.includes(s))).length,totalLessonsCount:r.length}}},c={
/**
   * Updates the lesson status.
   *
   * @param {Object} action          The action.
   * @param {string} action.status   The lesson status.
   * @param {string} action.lessonId The lesson id.
   * @param {Object} state           The state.
   *
   * @return {Object} The new state.
   */
SET_LESSON_STATUS:({lessonId:e,status:s},t)=>{let o=[...t.completedLessons];return r/* .Status */.n.COMPLETED===s?o.includes(e)||o.push(e):o=o.filter((s=>s!==e)),{...t,completedLessons:o}},
/**
   * Removes any lessons that don't exist in list of descendantIds.
   *
   * @param {Object} action               The action.
   * @param {Array}  action.descendantIds The ids of all descendants of the outline block.
   * @param {Object} state                The state.
   *
   * @return {Object} The new state.
   */
REMOVE_LESSONS:({descendantIds:e},s)=>{const t=s.completedLessons.filter((s=>e.includes(s))),o=s.trackedLessons.filter((s=>e.includes(s)));
// Do not update the state if no lessons were removed.
return o.length===s.trackedLessons.length&&t.length===s.completedLessons.length?s:{...s,completedLessons:t,trackedLessons:o}},
/**
   * Removes a lesson from the arrays of tracked lessons.
   *
   * @param {Object} action          The action.
   * @param {Array}  action.lessonId The ids of the lesson to ignore.
   * @param {Object} state           The state.
   *
   * @return {Object} The new state.
   */
IGNORE_LESSON:({lessonId:e},s)=>{const t=s.completedLessons.filter((s=>s!==e)),o=s.trackedLessons.filter((s=>s!==e));return{...s,completedLessons:t,trackedLessons:o}},
/**
   * Adds a lesson from the arrays of tracked lessons.
   *
   * @param {Object} action          The action.
   * @param {Array}  action.lessonId The ids of the lesson to track.
   * @param {Object} state           The state.
   *
   * @return {Object} The new state.
   */
TRACK_LESSON:({lessonId:e},s)=>{const t=[...s.trackedLessons];return t.includes(e)?s:(t.push(e),{...s,trackedLessons:t})},DEFAULT:(e,s)=>s},u=(0,l/* .createStore */.y$)("sensei/course-status",{reducer:(0,l/* .createReducerFromActionMap */.$x)(c,{completedLessons:[],trackedLessons:[]}),actions:i,selectors:a,controls:n.controls});
/**
 * Status store actions.
 */}
/***/,
/***/7122:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>b
/* harmony export */});
/* harmony import */var o=t(27723),r=t(94715),n=t(86087),l=t(47143),i=t(74862),a=t(50594),c=t(50131),u=t(60966),d=t(4452),p=t.n(d),m=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * External dependencies
 */
const g=[["sensei-lms/button-take-course",{text:(0,o.__)("Start Course","sensei-lms")}],["sensei-lms/button-continue-course"],["sensei-lms/button-view-results",{className:"is-style-default",text:(0,o.__)("Visit Results","sensei-lms")}]],b=({className:e,context:{postType:s},clientId:t})=>{const[d,b]=(0/* ["default"] */,n.useState)(c.A[0].value),h=(e=>{const s=(0,l.useSelect)((s=>s(r.store).getBlock(e).innerBlocks),[e]),t=(0,l.useDispatch)(r.store).selectBlock;return(0,n.useCallback)((e=>{const o=s.find((s=>s.name===e));o&&t(o.clientId)}),[s,t])})(t),v=(0,n.useCallback)((e=>{b(e);const s=c/* ["default"] */.A.find((s=>s.value===e))?.showBlock;s&&h(s)}),[b,h]),x=(0,n.useMemo)((()=>({courseStatus:d,setCourseStatus:v})),[d,v]);return"course"!==s?(0/* ["default"] */,m.jsx)(i.A,{message:(0,o.__)("The Course Actions block can only be used inside the Course List block.","sensei-lms")}):(0/* ["default"] */,m.jsxs)(u.A.Provider,{value:x,children:[(0,m.jsx)("div",{className:p()(e,`is-status-${d}`),children:(0,m.jsx)(r.InnerBlocks,{allowedBlocks:["sensei-lms/button-take-course","sensei-lms/button-continue-course","sensei-lms/button-view-results"],template:g,templateLock:"all"})}),(0,m.jsx)(r.BlockControls,{children:(0/* ["default"] */,m.jsx)(a.A,{courseStatus:d,setCourseStatus:b})})]})};
/**
 * Hook for selecting a child block.
 *
 * @param {string} clientId Block client ID.
 * @return {Function} Function to select a child block by block name.
 */}
/***/,
/***/7614:
/***/e=>{"use strict";e.exports=JSON.parse('{"apiVersion":2,"name":"sensei-lms/course-progress","title":"Course Progress","description":"Display the user\'s progress in the course. This block is only displayed if the user is enrolled.","category":"sensei-lms","textdomain":"sensei-lms","keywords":["progress","bar","course"],"supports":{"html":false},"attributes":{"textColor":{"type":"string"},"customTextColor":{"type":"string","default":""},"barColor":{"type":"string"},"customBarColor":{"type":"string"},"defaultBarColor":{"type":"string"},"barBackgroundColor":{"type":"string"},"customBarBackgroundColor":{"type":"string"},"height":{"type":"integer"},"borderRadius":{"type":"integer"},"isPreview":{"type":"boolean"}},"usesContext":["postType"],"example":{"attributes":{"customBarBackgroundColor":"#999999","isPreview":true}}}')}
/***/,
/***/8473:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>l
/* harmony export */});
/* harmony import */var o=t(27723),r=t(3582),n=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Featured label wrapper component.
 *
 * @param {Object}  props
 * @param {string}  props.postId          Course id.
 * @param {boolean} props.isFeaturedImage If it is a featured image block (or course categories).
 * @param {Object}  props.children        Child component to be wrapped in Feature Label component.
 */
const l=({postId:e,isFeaturedImage:s,children:t})=>{const[l]=(0,r.useEntityProp)("postType","course","meta",e),[i]=(0,r.useEntityProp)("postType","course","featured_media",e),a=!!l._course_featured,c=i>0,u=s?"sensei-lms-course-list-featured-label__image-wrapper":"sensei-lms-course-list-featured-label__meta-wrapper",d=c&&s||!c&&!s;
return(0,n.jsxs)("div",{className:u,children:[a&&d&&(0,n.jsx)("span",{className:"sensei-lms-course-list-featured-label__text",children:(0,o.__)("Featured","sensei-lms")}),t]})};
/* harmony default export */}
/***/,
/***/16711:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>l
/* harmony export */});
/* harmony import */var o,r=t(51609);
/* harmony import */function n(){return n=Object.assign?Object.assign.bind():function(e){for(var s=1;s<arguments.length;s++){var t=arguments[s];for(var o in t)({}).hasOwnProperty.call(t,o)&&(e[o]=t[o])}return e},n.apply(null,arguments)}
/* harmony default export */const l=function(e){
return r.createElement("svg",n({width:24,height:24,fill:"none",xmlns:"http://www.w3.org/2000/svg"},e),o||(o=r.createElement("path",{fillRule:"evenodd",clipRule:"evenodd",d:"M9 9.5H6a.5.5 0 0 1-.5-.5V6a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-.5.5ZM6 11h3a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2Zm12-1.5h-3a.5.5 0 0 1-.5-.5V6a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-.5.5ZM15 11h3a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-3a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2ZM4 14.5h7V16H4v-1.5Zm16 0h-7V16h7v-1.5Zm-16 4h5V20H4v-1.5Zm14 0h-5V20h5v-1.5Z",fill:"#1E1E1E"})))};
/***/},
/***/19629:
/***/e=>{"use strict";e.exports=JSON.parse('{"$schema":"https://schemas.wp.org/trunk/block.json","apiVersion":2,"name":"sensei-lms/course-categories","title":"Course Categories","description":"Show the course categories","category":"sensei-lms","textdomain":"sensei-lms","keywords":["course","lessons","categories"],"attributes":{"previewCategories":{"type":"array"},"textAlign":{"type":"string"},"options":{"type":"object"}},"usesContext":["postId","postType","queryId"],"supports":{"html":false,"spacing":{"margin":true,"padding":true,"blockGap":true},"align":false,"alignWide":false,"className":true,"typography":{"lineHeight":true,"fontSize":true,"__experimentalFontFamily":true,"__experimentalFontStyle":true,"__experimentalFontWeight":true,"__experimentalLetterSpacing":true,"__experimentalTextTransform":true,"__experimentalDefaultControls":{"fontSize":true}}}}')}
/***/,
/***/19976:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>l
/* harmony export */});
/* harmony import */var o,r=t(51609);
/* harmony import */function n(){return n=Object.assign?Object.assign.bind():function(e){for(var s=1;s<arguments.length;s++){var t=arguments[s];for(var o in t)({}).hasOwnProperty.call(t,o)&&(e[o]=t[o])}return e},n.apply(null,arguments)}
/* harmony default export */const l=function(e){
return r.createElement("svg",n({viewBox:"0 0 24 24",xmlns:"http://www.w3.org/2000/svg"},e),o||(o=r.createElement("path",{d:"M17 3H7c-1.1 0-2 .9-2 2v4c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm.5 6c0 .3-.2.5-.5.5H7c-.3 0-.5-.2-.5-.5V5c0-.3.2-.5.5-.5h10c.3 0 .5.2.5.5v4zm-8-1.2h5V6.2h-5v1.6zM17 13H7c-1.1 0-2 .9-2 2v4c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2v-4c0-1.1-.9-2-2-2zm.5 6c0 .3-.2.5-.5.5H7c-.3 0-.5-.2-.5-.5v-4c0-.3.2-.5.5-.5h10c.3 0 .5.2.5.5v4zm-8-1.2h5v-1.5h-5v1.5z",fill:"currentColor"})))};
/***/},
/***/21130:
/***/e=>{"use strict";e.exports=JSON.parse('{"name":"sensei-lms/course-actions","title":"Course Actions","description":"Enable a student to perform specific actions for a course.","category":"sensei-lms","textdomain":"sensei-lms","keywords":["course","actions","buttons","start course","continue","visit results"],"supports":{"html":false},"usesContext":["postType"]}')}
/***/,
/***/21307:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>c
/* harmony export */});
/* harmony import */var o=t(4452),r=t.n(o),n=t(94715),l=t(74997),i=t(71406),a=t(62540);
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
 * Save function for a Button block.
 *
 * @param {Object} props
 * @param {Object} props.attributes Block attributes.
 * @param {string} props.className  Classname.
 * @param {string} props.tagName    Output HTML tag name.
 * @param {string} props.blockName  Block name.
 */
const c=({attributes:e,className:s,tagName:t,blockName:o})=>{const{text:c,inContainer:u,align:d}=e;let p=t;t||(p=(0,i/* .isLinkStyle */._N)({attributes:e})?"a":"button");const m=(0,a.jsx)("div",{...(0,i/* .getButtonWrapperProps */.KS)({className:s,attributes:e}),children:(0,a.jsx)(n.RichText.Content,{...(0,i/* .getButtonProps */.xh)({attributes:e}),tagName:p,value:c})});return u?(0,a.jsx)("div",{className:r()(s,"sensei-buttons-container__button-block",(0,l.getBlockDefaultClassName)(o)+"__wrapper",{[`sensei-buttons-container__button-align-${d}`]:d}),children:m}):m};
/* harmony default export */}
/***/,
/***/23371:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>a
/* harmony export */});
/* harmony import */var o=t(27723),r=t(94715),n=t(72613),l=t(50594),i=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * View results button block.
 */
/* harmony default export */const a=(0,n/* .createButtonBlockType */.e)({tagName:"a",settings:{name:"sensei-lms/button-view-results",description:(0,o.__)("Enable a student to view their course results.","sensei-lms"),title:(0,o.__)("View Results","sensei-lms"),attributes:{text:{default:(0,o.__)("View Results","sensei-lms")}},styles:[n/* .BlockStyles */.u.Fill,{...n/* .BlockStyles */.u.Outline,isDefault:!0},n/* .BlockStyles */.u.Link]},invalidUsage:{message:(0,o.__)("The View Results block can only be used inside the Course List block.","sensei-lms"),validPostTypes:["course"]},EditWrapper:({children:e})=>(0,i.jsxs)(i.Fragment,{children:[(0,i.jsx)(r.BlockControls,{children:(0/* ["default"] */,i.jsx)(l.A,{useCourseStatusContext:!0})}),e]})});
/***/},
/***/27723:
/***/e=>{"use strict";e.exports=window.wp.i18n}
/***/,
/***/28108:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>/* reexport safe */o.A
/* harmony export */,m:()=>/* reexport safe */r.A
/* harmony export */});
/* harmony import */var o=t(95861),r=t(30983);
/* harmony import */}
/***/,
/***/29281:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */Lt:()=>/* binding */p
/* harmony export */,Sw:()=>/* binding */d
/* harmony export */,rt:()=>/* binding */c
/* harmony export */});
/* unused harmony export ColorSettings */
/* harmony import */var o=t(66087),r=t(86087),n=t(94715),l=t(27723),i=t(77549),a=t(62540);
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
 * Add color customization support and block settings controls for colors.
 *
 * @param {Object} colorSettings
 */
const c=e=>s=>{const t=(0,o.mapValues)(e,(e=>e.style));return(0,n.withColors)(t)((t=>(0,a.jsxs)(a.Fragment,{children:[(0,a.jsx)(s,{...t}),(0,a.jsx)(u,{colorSettings:e,props:t})]})))},u=({colorSettings:e,props:s})=>{const t=Object.keys(e).map((t=>({value:s[t].color,label:e[t].label,onChange:r=>{s[`set${(0,o.upperFirst)(t)}`](r),e[t].onChange&&e[t].onChange({...s,colorValue:r})}}))),r=s.backgroundColor?.color?.includes("var")||s.textColor?.color?.includes("var"),i=s.backgroundColor&&s.textColor&&!r;
return(0,a.jsx)(n.InspectorControls,{children:(0,a.jsx)(n.PanelColorSettings,{title:(0,l.__)("Color settings","sensei-lms"),initialOpen:!1,colorSettings:t,children:i&&(0,a.jsx)(n.ContrastChecker,{textColor:s.textColor.color,backgroundColor:s.backgroundColor.color,isLargeText:!1})})})},d=(e="default")=>s=>t=>{let{className:o}=t;const r={};o&&o.includes("is-style-")||(o=r.className=[o,`is-style-${e}`].join(" "));const n=o.match(/is-style-(\w+)/);return n&&(r.blockStyle=n[1]),(0,a.jsx)(s,{...t,...r})}
/**
 * This HOC sets the default color attribute based in a probe.
 *
 * @example
 * withDefaultColor( {
 *   defaultMainColor: {
 *     style: 'background-color',
 *     probeKey: 'primaryColor',
 *   },
 * } )
 *
 * @param {Object} colorConfigs Colors config object, where the key is the default color attribute name, and the value is an object containing style type and probeKey. The block attributes must register an attribute for every key.
 *
 * @return {Function} Extended component.
 */,p=e=>s=>t=>{const{setAttributes:o,attributes:l}=t,c=(0,i/* .useColorsByProbe */.t)(),[u,d]=(0,r.useState)({}),p=Object.keys(e).map((e=>l[e]));return(0,r.useEffect)((()=>{const s={};Object.entries(e).forEach((([e,{style:t,probeKey:r}])=>{const i=c[r]||{},{slug:a}=i;if(a&&(s[e]={...i,className:(0,n.getColorClassName)(t,a)}),l[e]!==a){const s={};s[e]=a,
// Border color is not compatible with all themes as className, so the color value is needed.
"border-color"===t&&(s[`${e}Value`]=i.color),o(s)}})),d(s)}
// eslint-disable-next-line react-hooks/exhaustive-deps -- The deps are added dynamically because we get it dynamically from the attributes and we don't want add all attributes as dep.
),[c,o,...p]),(0,a.jsx)(s,{...t,...u})}
/***/;
/**
 * Color setting inspector controls.
 *
 * @param {Object} params
 * @param {Object} params.colorSettings Color definitions.
 * @param {Object} params.props         Component props
 * @class
 */},
/***/29491:
/***/e=>{"use strict";e.exports=window.wp.compose}
/***/,
/***/30983:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>i
/* harmony export */});
/* harmony import */var o=t(94715),r=t(56427),n=t(27723),l=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * The course progress settings.
 *
 * @param {Object}   props                 Component properties.
 * @param {number}   props.borderRadius    The value of the bar radius.
 * @param {Function} props.setBorderRadius Callback to set the value of border radius.
 * @param {number}   props.height          The value of the bar height.
 * @param {Function} props.setHeight       Callback to set the value of height.
 */
const i=({borderRadius:e,setBorderRadius:s,height:t,setHeight:i})=>(e=void 0===e?10:e,t=void 0===t?14:t,(0,l.jsx)(o.InspectorControls,{children:(0,l.jsxs)(r.PanelBody,{title:(0,n.__)("Progress bar settings","sensei-lms"),initialOpen:!1,className:"sensei-progress-bar-settings",children:[(0,l.jsx)(r.PanelRow,{children:(0,l.jsx)(r.RangeControl,{label:(0,n.__)("Border radius","sensei-lms"),value:e,onChange:s,min:0,max:15,allowReset:!0,initialPosition:10})}),(0,l.jsx)(r.PanelRow,{children:(0,l.jsx)(r.RangeControl,{label:(0,n.__)("Height","sensei-lms"),value:t,onChange:i,min:1,max:25,allowReset:!0,initialPosition:14})})]})}));
/* harmony default export */}
/***/,
/***/31451:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>n
/* harmony export */});
/* harmony import */var o=t(5573),r=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
const n=(0,r.jsx)(o.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24",children:(0,r.jsx)(o.Path,{d:"M10 17.389H8.444A5.194 5.194 0 1 1 8.444 7H10v1.5H8.444a3.694 3.694 0 0 0 0 7.389H10v1.5ZM14 7h1.556a5.194 5.194 0 0 1 0 10.39H14v-1.5h1.556a3.694 3.694 0 0 0 0-7.39H14V7Zm-4.5 6h5v-1.5h-5V13Z"})});
/* harmony default export */}
//# sourceMappingURL=link.js.map
/***/,
/***/32189:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>l
/* harmony export */});
/* harmony import */var o=t(94715),r=t(38204),n=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
const l=({attributes:e})=>{const s=o.useBlockProps.save((0,r/* .getStyleAndClassesFromAttributes */.O)(e));
return(0,n.jsx)("div",{...s})};
/* harmony default export */}
/***/,
/***/35479:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>n
/* harmony export */});
/* harmony import */var o=t(5573),r=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
const n=(0,r.jsx)(o.SVG,{viewBox:"0 0 24 24",xmlns:"http://www.w3.org/2000/svg",children:(0,r.jsx)(o.Path,{d:"M8 12.5h8V11H8v1.5Z M19 6.5H5a2 2 0 0 0-2 2V15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V8.5a2 2 0 0 0-2-2ZM5 8h14a.5.5 0 0 1 .5.5V15a.5.5 0 0 1-.5.5H5a.5.5 0 0 1-.5-.5V8.5A.5.5 0 0 1 5 8Z"})});
/* harmony default export */}
//# sourceMappingURL=button.js.map
/***/,
/***/38204:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */O:()=>/* binding */i
/* harmony export */});
/* harmony import */var o=t(4452),r=t.n(o),n=t(66087);
/* harmony import */
/**
 * External dependencies
 */
const l="--sensei-lms-course-categories",i=(e={})=>{const{options:s,textAlign:t}=e;return{style:(0,n.omitBy)({[`${l}-background-color`]:s?.backgroundColor,[`${l}-text-color`]:s?.textColor},n.isNil),className:r()({[`has-text-align-${t}`]:!!t})}}}
/***/,
/***/44539:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>a
/* harmony export */});
/* harmony import */var o=t(94715),r=t(56427),n=t(27723),l=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
const i=({borderRadius:e,setAttributes:s})=>(0,l.jsx)(r.PanelBody,{title:(0,n.__)("Border settings","sensei-lms"),initialOpen:!1,children:(0,l.jsx)(r.RangeControl,{label:(0,n.__)("Border radius","sensei-lms"),value:e,min:0,max:50,allowReset:!0,onChange:e=>s({borderRadius:e})})})
/**
 * Settings component for a Button block.
 *
 * @param {Object} props
 */,a=e=>{const{attributes:s,setAttributes:t}=e,{borderRadius:r,align:a}=s;
return(0,l.jsxs)(l.Fragment,{children:[(0,l.jsx)(o.BlockControls,{children:(0,l.jsx)(o.BlockAlignmentToolbar,{label:(0,n.__)("Change button alignment","sensei-lms"),value:a||e.alignmentOptions?.default,onChange:e=>{e&&t({align:e})},...e.alignmentOptions})}),(0,l.jsx)(o.InspectorControls,{children:(0,l.jsx)(i,{borderRadius:r,setAttributes:t})})]})}}
/***/,
/***/44956:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>i
/* harmony export */});
/* harmony import */var o=t(94715),r=t(27723),n=t(74862),l=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Course Overview block edit component.
 *
 * @param {Object} props
 * @param {Object} props.context          Block context.
 * @param {Object} props.context.postType Post type.
 */
const i=({context:{postType:e}})=>{const s=(0,o.useBlockProps)();return["course","lesson"].includes(e)?(0,l.jsx)("div",{...s,children:(0,l.jsx)("a",{href:"#",children:(0,r.__)("Course Overview","sensei-lms")})}):(0/* ["default"] */,l.jsx)(n.A,{message:(0,r.__)("The Course Overview block can only be used inside the Course List block.","sensei-lms")})};
/* harmony default export */}
/***/,
/***/45326:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>l
/* harmony export */});
/* harmony import */var o,r=t(51609);
/* harmony import */function n(){return n=Object.assign?Object.assign.bind():function(e){for(var s=1;s<arguments.length;s++){var t=arguments[s];for(var o in t)({}).hasOwnProperty.call(t,o)&&(e[o]=t[o])}return e},n.apply(null,arguments)}
/* harmony default export */const l=function(e){
return r.createElement("svg",n({width:24,height:24,fill:"none",xmlns:"http://www.w3.org/2000/svg"},e),o||(o=r.createElement("path",{fillRule:"evenodd",clipRule:"evenodd",d:"M15 4h-3v1.5h3V4ZM6 18.5h3a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.5-.5H6a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .5.5ZM9 20H6a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2Zm6-1.5h3a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .5.5Zm3 1.5h-3a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2ZM17 4h3v1.5h-3V4Zm-7 0H4v1.5h6V4Z",fill:"#1E1E1E"})))};
/***/},
/***/47056:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>i
/* harmony export */});
/* harmony import */var o=t(66087),r=t(74997),n=t(48597),l=t(62540);
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
 * Register Sensei blocks.
 *
 * @todo  Refactor how the metadata and settings are passed to `registerBlockType`.
 * @param {Array} blocks Blocks to be registered.
 */
const i=e=>{(0,r.updateCategory)("sensei-lms",{icon:(0/* ["default"] */,l.jsx)(n.A,{width:"20",height:"20"})}),e.forEach((e=>{let{metadata:s,name:t,...n}=e;s&&(
// Remove the overlapping metadata keys from the settings object to make localization work.
// This is needed because only the metadata object is localized, but the overlapping keys will be overwritten by the settings object and the localization is lost.
n=(0,o.omit)(n,Object.keys(s))),
// The metadata object should be used for the `block.json` strings to be localized.
// See https://github.com/Automattic/sensei/pull/5782 for more details.
// The metadata object should be used for the `block.json` strings to be localized.
// See https://github.com/Automattic/sensei/pull/5782 for more details.
(0,r.registerBlockType)(s||t,n)}))};
/* harmony default export */}
/***/,
/***/47143:
/***/e=>{"use strict";e.exports=window.wp.data}
/***/,
/***/48288:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>b
/* harmony export */});
/* unused harmony export CourseCategoryEdit */
/* harmony import */var o=t(66087),r=t(94715),n=t(56427),l=t(29491),i=t(27723),a=t(86087),c=t(63929),u=t(74862),d=t(29281),p=t(47143),m=t(38204),g=t(62540);
/* harmony import */
/* harmony default export */const b=(0,l.compose)((0,d/* .withColorSettings */.rt)({textColor:{style:"color",label:(0,i.__)("Text color","sensei-lms")},backgroundColor:{style:"background-color",label:(0,i.__)("Background color","sensei-lms")}}))((
/**
 * External dependencies
 */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
function(e){const{attributes:s,backgroundColor:t,context:l,textColor:d,setAttributes:b,setBackgroundColor:h,setTextColor:v}=e,{textAlign:x,previewCategories:y,options:_}=s,{postId:C,postType:f}=l,{postTerms:k,isLoading:w}=(0,c/* ["default"] */.A)(C),{__unstableMarkNextChangeAsNotPersistent:A=o.noop}=(0,p.useDispatch)(r.store);(0,a.useEffect)((()=>{_&&(h(_.backgroundColor),v(_.textColor))}),
// eslint-disable-next-line react-hooks/exhaustive-deps
[]),
// We need to store the colors inside the option attribute because
// by default the root backgroundColor and textColor are overwritten by
// Gutenberg withColors HOC.
// We need to store the colors inside the option attribute because
// by default the root backgroundColor and textColor are overwritten by
// Gutenberg withColors HOC.
(0,a.useEffect)((()=>{A(),b({options:{backgroundColor:t?.color,textColor:d?.color}})}),[t,d,b,A]);const j=(0,r.useBlockProps)((0,m/* .getStyleAndClassesFromAttributes */.O)(s)),S=e=>e?.map((e=>(0,g.jsx)("a",{href:e.link,onClick:e=>e.preventDefault(),children:(0,o.unescape)(e.name)},e.id)));return y?(0,g.jsx)("div",{...j,children:S(y)}):"course"!==f?(0/* ["default"] */,g.jsx)(u.A,{message:(0,i.__)("The Course Categories block can only be used inside the Course List block.","sensei-lms")}):(0,g.jsxs)(g.Fragment,{children:[(0,g.jsx)(r.BlockControls,{children:(0,g.jsx)(r.AlignmentToolbar,{value:x,onChange:e=>{b({textAlign:e})}})}),(0,g.jsxs)("div",{...j,children:[w&&(0,g.jsx)(n.Spinner,{}),!w&&S(k)]})]})}));
/***/},
/***/48308:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>l
/* harmony export */});
/* harmony import */var o=t(45326),r=t(89726),n=t(81596);
/* harmony import */
/**
 * Internal dependencies
 */
/* harmony default export */const l={...r,metadata:r,icon:o/* ["default"] */.A,edit:n/* ["default"] */.A};
/***/},
/***/48597:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>i
/* harmony export */});
/* harmony import */var o,r,n=t(51609);
/* harmony import */function l(){return l=Object.assign?Object.assign.bind():function(e){for(var s=1;s<arguments.length;s++){var t=arguments[s];for(var o in t)({}).hasOwnProperty.call(t,o)&&(e[o]=t[o])}return e},l.apply(null,arguments)}
/* harmony default export */const i=function(e){
return n.createElement("svg",l({viewBox:"0 0 24 24",fill:"none",xmlns:"http://www.w3.org/2000/svg"},e),o||(o=n.createElement("circle",{cx:12,cy:12,r:12,fill:"#43AF99"})),r||(r=n.createElement("path",{fillRule:"evenodd",clipRule:"evenodd",d:"M9.835 15.38c.3-.23.179-.474.6-.563-.02.194.146.391.251.563-.109-.367-.002-.536.08-.72.347-.785-.662-1.293-1.35-1.418.235-.164.399-.327.694-.355a2.377 2.377 0 0 0-1.058.23c-1.112.531-1.993-.523-1.41-1.48.31-.51.664-.519.982-.865.077.178.103.372.075.564a.919.919 0 0 0 .049-.664c-.104-.336-.4-.338-.456-.821-.012-.101-.105.056-.263-.077-.038-.032-.113-.09-.163-.064-.085.044-.18.008-.232.034-.083.041-.109-.045-.2.016-.16.107-.178-.013-.332.005-.193.023-.32.261-.43.144-.102-.108-.206.075-.28.075-.05 0-.311.317-.426.028-.086-.216-.28.206-.382.063-.033-.046-.123.108-.18-.044-.014-.035 0-.078-.108-.027-.215.099-.138-.06-.207-.144-.083-.103-.113-.103-.068-.27.036-.133-.019-.33.2-.364.055-.008.107-.005.184-.148.096-.18.231-.093.207-.175-.036-.119.143-.28.226-.355.11-.103.254-.252.306-.396a.63.63 0 0 1 .102-.141c.081-.084.105-.003.227-.045.088-.03.02.053.106-.07.028-.038.105-.001.19-.039.259-.112.283-.11.347-.371.012-.05.025-.088.08-.083.109.01.134-.052.2-.05.061.001.083-.03.115-.068.18-.216.277-.055.357-.072.06-.012.022-.142.184-.102.23.057.155-.05.303-.015.174.041.186.19.306.225.143.042.211.198.307.196.337-.005.235.23.448.323-.16-.161.012-.421-.352-.455-.08-.007-.11-.127-.23-.183-.146-.067-.13-.21-.394-.27.068-.04.089.005.13-.073.058-.11.09-.046.113-.113.02-.063.006-.099.165-.155.165-.06.325-.195.472-.188.13.006.185-.08.177-.19-.008-.112-.033-.267.222-.22.153.029.15.003.15-.1-.002-.102.04-.165.174-.16.098.002.194-.003.231-.117.03-.091.207-.114.302-.148.317-.114.361.05.447-.095.07-.117.196-.317.337-.175.028.029.054.05.15-.056.08-.088.27-.2.337-.048.027.06.086.121.138.044a.08.08 0 0 1 .053-.039c.05-.01.079-.024.104-.036.218-.101.314-.095.213.125-.142.316.792-.192.532.151-.095.126.538.197.63.254.05.032.048.059.144.077.271.05.267.026.284.243.007.098.107.043.107.168 0 .535.472.266.549.399.012.022.032.042.079.042.149 0 .157-.03.224.089.027.047.05.072.127.096.12.037.112.05.068.138-.054.104.03.102.138.112.1.01.148.062.216.138.11.122.284.156.43.227.084.04.002.14.143.243.104.077.156.066.016.165-.59.418.22.305.446.694.051.087.118.195.216.295.225.23.1.293.221.437.07.083.015.063.13.137.272.175-.105.292-.319.212-.097-.035-.166-.085-.147-.025.016.049-.01.083-.052.12-.125.112.123.068.181.06.181-.025.664-.076.66.093-.005.22.136.27.25.284.185.024.238.057.34.226.092.152.145.07.288.205.097.093.217.258.02.282-.047.005-.099 0-.12.017a.411.411 0 0 1-.14.066c-.295.09.14.136.246.113.093-.02.209-.05.3-.027.057.015.062.08.244.107.06.01.036.099.006.16-.104.214.191.1.16.263-.017.093.11.245-.067.248-.057.001-.117-.015-.115.034.004.105-.165-.03-.317.115-.056.054-.19.092-.272-.009-.032-.038-.07-.069-.218-.023-.144.046-.242.204-.306-.04-.017-.064-.05-.065-.142-.097-.125-.043-.114-.258-.297-.12a.24.24 0 0 1-.214.039c-.144-.037-.303.012-.317-.096-.021-.179-.191-.305-.377-.296-.147.008-.278.034-.355-.137.057.195.207.208.382.208.144 0 .23.075.255.225.045.265.204.099.406.223.1.06.17.159.21.273.042.118.37-.024.282.258-.037.122-.107.168-.242.266-.4.294-.5.004-.618.239-.062.121-.063.031-.196.09-.22.098-.36-.128-.522-.045-.182.094-.168-.08-.352.037-.152.097-.308-.074-.38.192-.063.227-.322.232-.44.11-.189-.194-.132.229-.362.054-.123-.091-.213.043-.392.045-.33.005-.489-.282-.65-.107-.192.206-.331-.032-.334-.242-.003-.216-.777-.144-1.185-.256-.225-.062-.932.013-.702-.35-.372.39.456.366.682.455.136.053.245.095.377.114.13.296.214.617.227 1.007.043-.214.053-.433.028-.649-.043-.383.242.19.276.272.184.45-.022 1.278-.488 1.526a2.957 2.957 0 0 0-.562-.99c.256.392.616 1.192.327 1.65a1.023 1.023 0 0 1-.55-.483c.077.333.413.702.818.58.707-.213.704.233 1.641.307.682.111 1.654 0 2.118.037.254.02 1.32.197 1.315.465-.02 1.105-.438 1.164-1.539 1.268-.64.06-1.134.085-1.823.11-1.54.058-3.391.06-4.868 0-.724-.03-1.072-.036-1.841-.137-.769-.1-1.19-.363-1.178-1.187.005-.304.905-.594 1.2-.628.347-.039.901.005 1.405-.116.527-.127.747-.21 1.135-.508Zm5.347-6.052c-.167-.042-.051-.138-.339-.014-.17.073-.194-.13-.365-.094-.172.036-.242-.125-.499-.166-.318-.05-.088-.133-.592-.032-.097.02-.179-.09-.481-.052-.355.046-.23.084-.445-.115-.272-.251-.488-.082-.767-.184.216.166.368.019.622.221-.242.138-.523.802-.962.844.478.107.709.354 1.148.413.504.068.882.118 1.151.531.301.463.44.196.874.168.275-.017.282-.185.328-.362.063-.245.126-.256.31-.289.213-.037.163-.092.107-.156-.15-.172.019-.207.146-.244.222-.064.042-.075.042-.166-.278-.09-.063-.217.092-.273.169.105.242.087.317.073.109-.021.181.03.273-.028-.135.014-.163-.037-.278-.02-.051.007-.112.01-.219-.054-.18-.107-.27.048-.463 0Zm-2.28 1.64-1.09-.545c-1.316-.657-1.915.313-2.337 1.376l-.766.73c.549-.338.996-.714 1.574-.71.092 0 1.516.484 1.286-.092-.04-.104.09-.052.125-.201.04-.17.055-.141.195-.033.089.069.211.113.174-.048-.017-.072-.04-.137.28-.004.15.062.095-.064.303-.09.29-.034.228-.31.364-.349.076-.022.152.058.295-.077.05-.046.11-.089.232-.057-.143-.073-.22-.014-.292.03-.146.089-.204-.037-.343.07Zm-2.23-1.923c.16-.02.32-.036.482-.046a.13.13 0 0 0 .074-.06.111.111 0 0 0 .007-.09.268.268 0 0 1 .147-.206l-.002-.003c-.258.001-.466.1-.73.211-.052.022-.024.111-.118.213a.26.26 0 0 1-.201.235.136.136 0 0 0-.09.046.113.113 0 0 0-.026.092.252.252 0 0 1-.277.061c-.2-.077-.35-.065-.448.036a.39.39 0 0 1 .398.014c.134.066.3.031.39-.082a.132.132 0 0 1 .126-.098.421.421 0 0 0 .268-.323Z",fill:"#fff"})))};
/***/},
/***/50131:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>r
/* harmony export */});
/* harmony import */var o=t(27723);
/* harmony import */
/**
 * WordPress dependencies
 */
const r=[{label:(0,o.__)("Not Started","sensei-lms"),value:"not-started",showBlock:"sensei-lms/button-take-course"},{label:(0,o.__)("In Progress","sensei-lms"),value:"in-progress",showBlock:"sensei-lms/button-continue-course"},{label:(0,o.__)("Completed","sensei-lms"),value:"completed",showBlock:"sensei-lms/button-view-results"}];
/* harmony default export */}
/***/,
/***/50176:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>a
/* harmony export */});
/* harmony import */var o=t(27723),r=t(21130),n=t(7122),l=t(65911),i=t(19976);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/* harmony default export */const a={...r,metadata:r,example:{innerBlocks:[{name:"sensei-lms/button-take-course",attributes:{text:(0,o.__)("Start Course","sensei-lms")}}]},icon:i/* ["default"] */.A,edit:n/* ["default"] */.A,save:l/* ["default"] */.A};
/***/},
/***/50594:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>c
/* harmony export */});
/* harmony import */var o=t(56427),r=t(86087),n=t(50131),l=t(60966),i=t(2567),a=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Toolbar component for the Course State. It can be Enrolled (the default), In
 * Progress, or Completed.
 *
 * @param {Object}   props
 * @param {string}   props.courseStatus           Course status.
 * @param {Function} props.setCourseStatus        Function to set the course status.
 * @param {boolean}  props.useCourseStatusContext Whether to use the course status context instead of callbacks.
 */
const c=({courseStatus:e,setCourseStatus:s,useCourseStatusContext:t=!1})=>{const c=(0/* ["default"] */,r.useContext)(l.A);
// Render nothing if we should use the context but it is not available.
if(t&&!c?.courseStatus)return null;const u=t?c.courseStatus:e,d=t?c.setCourseStatus:s;
return(0,a.jsx)(o.ToolbarGroup,{children:(0/* ["default"] */,a.jsx)(i.A,{options:n/* ["default"] */.A,optionsLabel:"Course Status",value:u,onChange:d})})};
/* harmony default export */}
/***/,
/***/51609:
/***/e=>{"use strict";e.exports=window.React}
/***/,
/***/51764:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>l
/* harmony export */});
/* harmony import */var o=t(31451),r=t(44956),n=t(54350);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/* harmony default export */const l={...n,metadata:n,icon:o/* ["default"] */.A,edit:r/* ["default"] */.A};
/***/},
/***/52619:
/***/e=>{"use strict";e.exports=window.wp.hooks}
/***/,
/***/54350:
/***/e=>{"use strict";e.exports=JSON.parse('{"$schema":"https://schemas.wp.org/trunk/block.json","apiVersion":2,"name":"sensei-lms/course-overview","title":"Course Overview","category":"sensei-lms","description":"Displays a link to the course.","textdomain":"sensei-lms","supports":{"color":{"background":false,"text":true}},"usesContext":["postType"],"example":{}}')}
/***/,
/***/56427:
/***/e=>{"use strict";e.exports=window.wp.components}
/***/,
/***/60966:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>r
/* harmony export */});
/* harmony import */var o=t(86087);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * A React context which contains the course status and a function to set it.
 *
 * It should contain the following properties:
 *
 * - courseStatus: The course status.
 * - setCourseStatus: A function to set the course status.
 */
const r=(0,o.createContext)();
/* harmony default export */}
/***/,
/***/62540:
/***/(e,s,t)=>{"use strict";e.exports=t(2192)}
/***/,
/***/62940:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>m
/* harmony export */});
/* unused harmony export CourseProgressEdit */
/* harmony import */var o=t(4452),r=t.n(o),n=t(29491),l=t(27723),i=t(47143),a=t(29281),c=t(5705),u=t(28108),d=t(74862),p=t(62540);
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
 * Edit course progress bar component.
 *
 * @param {Object}   props                         Component properties.
 * @param {string}   props.className               Custom class name.
 * @param {Object}   props.barColor                Color object for the progress bar.
 * @param {Object}   props.defaultBarColor         Default bar color.
 * @param {Object}   props.barBackgroundColor      Color object for the background of the progress bar.
 * @param {Object}   props.textColor               Color object for the text.
 * @param {Object}   props.attributes              Component attributes.
 * @param {number}   props.attributes.height       The height of the progress bar.
 * @param {number}   props.attributes.borderRadius The border radius of the progress bar.
 * @param {boolean}  props.attributes.isPreview    Whether block is rendered in a preview.
 * @param {Function} props.setAttributes           Callback to set the component attributes.
 */
const m=(0,n.compose)((0,a/* .withColorSettings */.rt)({barColor:{style:"background-color",label:(0,l.__)("Progress bar color","sensei-lms")},barBackgroundColor:{style:"background-color",label:(0,l.__)("Progress bar background color","sensei-lms")},textColor:{style:"color",label:(0,l.__)("Text color","sensei-lms")}}),(0,a/* .withDefaultColor */.Lt)({defaultBarColor:{style:"background-color",probeKey:"primaryColor"}}))((e=>{const{className:s,barColor:t,defaultBarColor:o,barBackgroundColor:n,textColor:a,context:{postType:m},attributes:{height:g,borderRadius:b,isPreview:h},setAttributes:v}=e,{totalLessonsCount:x,completedLessonsCount:y}=(0,i.useSelect)((e=>e(c/* .COURSE_STATUS_STORE */.l).getLessonCounts()),[]),_={className:r()(s,a?.class),style:{color:a?.color}},C={className:t?.class||o?.className,style:{backgroundColor:t?.color||o?.color,borderRadius:b}},f={className:r()("wp-block-sensei-lms-course-progress",n?.class),style:{backgroundColor:n?.color,height:g,borderRadius:b}};return"course"!==m?(0/* ["default"] */,p.jsx)(d.A,{message:(0,l.__)("The Course Progress block can only be used inside the Course List block.","sensei-lms")}):(0,p.jsxs)(p.Fragment,{children:[(0/* ["default"] */,p.jsx)(u.A,{totalCount:h?3:x,completedCount:y,wrapperAttributes:_,barWrapperAttributes:f,barAttributes:C,countersClassName:"wp-block-sensei-lms-progress-heading",label:(0,l.__)("lessons","sensei-lms"),completedCountClassName:"wp-block-sensei-lms-progress-heading__completed"}),(0/* .ProgressBarSettings */,p.jsx)(u.m,{borderRadius:b,setBorderRadius:e=>v({borderRadius:e}),height:g,setHeight:e=>v({height:e})})]})}));
/* harmony default export */}
/***/,
/***/63395:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>n
/* harmony export */});
/* harmony import */var o=t(5573),r=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
const n=(0,r.jsx)(o.SVG,{viewBox:"0 0 24 24",xmlns:"http://www.w3.org/2000/svg",children:(0,r.jsx)(o.Path,{d:"M6 5.5h3a.5.5 0 01.5.5v3a.5.5 0 01-.5.5H6a.5.5 0 01-.5-.5V6a.5.5 0 01.5-.5zM4 6a2 2 0 012-2h3a2 2 0 012 2v3a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm11-.5h3a.5.5 0 01.5.5v3a.5.5 0 01-.5.5h-3a.5.5 0 01-.5-.5V6a.5.5 0 01.5-.5zM13 6a2 2 0 012-2h3a2 2 0 012 2v3a2 2 0 01-2 2h-3a2 2 0 01-2-2V6zm5 8.5h-3a.5.5 0 00-.5.5v3a.5.5 0 00.5.5h3a.5.5 0 00.5-.5v-3a.5.5 0 00-.5-.5zM15 13a2 2 0 00-2 2v3a2 2 0 002 2h3a2 2 0 002-2v-3a2 2 0 00-2-2h-3zm-9 1.5h3a.5.5 0 01.5.5v3a.5.5 0 01-.5.5H6a.5.5 0 01-.5-.5v-3a.5.5 0 01.5-.5zM4 15a2 2 0 012-2h3a2 2 0 012 2v3a2 2 0 01-2 2H6a2 2 0 01-2-2v-3z",fillRule:"evenodd",clipRule:"evenodd"})});
/* harmony default export */}
//# sourceMappingURL=category.js.map
/***/,
/***/63929:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>/* binding */l
/* harmony export */});
/* harmony import */var o=t(3582),r=t(47143);
/* harmony import */
/**
 * WordPress dependencies
 */
// Heavily inspired from here https://github.com/WordPress/gutenberg/blob/trunk/packages/block-library/src/post-terms/use-post-terms.js
const n=({postId:e,postType:s,term:t})=>{const{rest_base:n,slug:l}=t,[i]=(0,o.useEntityProp)("postType",s,n,e);return(0,r.useSelect)((e=>{const r=t?.visibility?.publicly_queryable;if(!r)return{postTerms:[],isLoading:!1,hasPostTerms:!1};if(!i)
// Waiting for post terms to be fetched.
return{isLoading:t?.postTerms?.includes(s)};if(!i.length)return{isLoading:!1};const{getEntityRecords:n,isResolving:a}=e(o.store),c=["taxonomy",l,{include:i,context:"view"}],u=n(...c);return{postTerms:u,isLoading:a("getEntityRecords",c),hasPostTerms:!!u?.length}}),[i,t?.visibility?.publicly_queryable])};function l(e){const s=(0,r.useSelect)((e=>{const{getTaxonomy:s}=e(o.store),t=s("course-category");return t?.visibility?.publicly_queryable?t:{}}));return n({postId:e,postType:"course",term:s})}
/***/},
/***/65911:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>/* binding */n
/* harmony export */});
/* harmony import */var o=t(94715),r=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
function n(){
return(0,r.jsx)(o.InnerBlocks.Content,{})}
/***/},
/***/66087:
/***/e=>{"use strict";e.exports=window.lodash}
/***/,
/***/66161:
/***/e=>{"use strict";e.exports=window.wp.dataControls}
/***/,
/***/67939:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */w6:()=>/* binding */d
/* harmony export */});
/* unused harmony exports DEFAULT_ATTRIBUTES, addWrapperAroundFeaturedImageBlock, addWrapperAroundCourseCategoriesBlock */
/* harmony import */var o=t(27723),r=t(74997),n=t(47143),l=t(52619),i=(t(70371),t(16711)),a=t(8473),c=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
const u={className:"wp-block-sensei-lms-course-list",query:{perPage:3,pages:0,offset:0,postType:"course",order:"desc",orderBy:"date",author:"",search:"",exclude:[],sticky:"",inherit:!1}},d=()=>{(0,r.registerBlockVariation)("core/query",{name:"sensei-lms/course-list",title:(0,o.__)("Course List","sensei-lms"),description:(0,o.__)("Show a list of courses.","sensei-lms"),icon:i/* ["default"] */.A,category:"sensei-lms",keywords:[(0,o.__)("Course","sensei-lms"),(0,o.__)("List","sensei-lms"),(0,o.__)("Courses","sensei-lms")],attributes:{...u},isActive:(e,s)=>e.className?.match(s.className)&&e.query.postType===s.query.postType,scope:["inserter"]})},p=(0,n.subscribe)((()=>{const e=document.querySelector(".interface-interface-skeleton__sidebar");e&&(m(e),p())})),m=e=>{
// pass in the settings panel node, as well as the options.
new MutationObserver((()=>{const e=(0,n.select)("core/block-editor").getSelectedBlock();"core/query"===e?.name&&e?.attributes?.className?.includes("wp-block-sensei-lms-course-list")&&g()})).observe(e,{childList:!0,subtree:!0})},g=()=>{const e=document.querySelectorAll(".components-input-control__label,.components-toggle-control__label");e&&0!==e.length&&Array.from(e).forEach((e=>{[/* eslint-disable-next-line @wordpress/i18n-text-domain */ /* eslint-disable-next-line @wordpress/i18n-text-domain */
(0,o.__)("Post type").toLowerCase(),/* eslint-disable-next-line @wordpress/i18n-text-domain */ /* eslint-disable-next-line @wordpress/i18n-text-domain */
(0,o.__)("Inherit query from template").toLowerCase()].includes(e.textContent.toLowerCase())&&(e.closest(".components-base-control").style.display="none")}))};(0,l.addFilter)("blocks.registerBlockType","sensei-lms/course-list-block",(
/**
 * Add a HOC to a featured image block.
 *
 * @param {Object} settings Block settings.
 * @param {string} name     Block name.
 */
function(e,s){if("core/post-featured-image"!==s)return e;const t=e.edit;return e={...e,edit:e=>"course"===e.context?.postType&&!!e.context?.queryId?(0/* ["default"] */,c.jsx)(a.A,{postId:e.context.postId,isFeaturedImage:!0,children:(0,c.jsx)(t,{...e})}):(0,c.jsx)(t,{...e})}})),(0,l.addFilter)("blocks.registerBlockType","sensei-lms/course-categories",(
/**
 * Add a HOC to a featured course categories block.
 *
 * @param {Object} settings Block settings.
 * @param {string} name     Block name.
 */
function(e,s){if("sensei-lms/course-categories"!==s)return e;const t=e.edit;return e.attributes.align=!1,e={...e,edit:e=>"course"===e.context?.postType&&!!e.context?.queryId?(0/* ["default"] */,c.jsx)(a.A,{postId:e.context.postId,isFeaturedImage:!1,children:(0,c.jsx)(t,{...e})}):(0,c.jsx)(t,{...e})}}))}
/***/,
/***/68604:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>i
/* harmony export */});
/* harmony import */var o,r,n=t(51609);
/* harmony import */function l(){return l=Object.assign?Object.assign.bind():function(e){for(var s=1;s<arguments.length;s++){var t=arguments[s];for(var o in t)({}).hasOwnProperty.call(t,o)&&(e[o]=t[o])}return e},l.apply(null,arguments)}
/* harmony default export */const i=function(e){
return n.createElement("svg",l({viewBox:"0 0 24 24",xmlns:"http://www.w3.org/2000/svg"},e),o||(o=n.createElement("rect",{x:2.75,y:7.75,width:18.5,height:6.5,rx:3.25,stroke:"currentColor",strokeWidth:1.5,fill:"none"})),r||(r=n.createElement("path",{d:"M6 7.75h10.7l-6.5 6.5H6c-1.8 0-3.25-1.45-3.25-3.25S4.2 7.75 6 7.75Z"})))};
/***/},
/***/68815:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>a
/* harmony export */});
/* harmony import */var o=t(27723),r=t(63395),n=t(19629),l=t(48288),i=t(32189);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/* harmony default export */const a={...n,metadata:n,example:{attributes:{previewCategories:[{id:1,name:(0,o.__)("Music","sensei-lms")},{id:2,name:(0,o.__)("Movies","sensei-lms")}]}},icon:r/* ["default"] */.A,edit:l/* ["default"] */.A,save:i/* ["default"] */.A};
/***/},
/***/70108:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>l
/* harmony export */});
/* harmony import */var o=t(68604),r=t(62940),n=t(7614);
/* harmony import */
/**
 * Internal dependencies
 */
/* harmony default export */const l={...n,metadata:n,icon:o/* ["default"] */.A,edit:r/* ["default"] */.A};
/***/},
/***/70371:
/***/(e,s,t)=>{"use strict";
/* unused harmony export withQueryLoopPatternsAndSettingsHiddenForCourseList */
/* harmony import */var o=t(27723),r=t(52619),n=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
let l=!1;
/**
 * Check if a block already exists in the editor.
 *
 * @param {string} clientId The block client id.
 * @return {boolean} Whether the block exists in the editor.
 */const i=e=>!!document.getElementById("block-"+e);
/**
 * Hide pattern selector controls.
 */(0,r.addFilter)("editor.BlockEdit","sensei-lms/course-list-block",(e=>s=>{const t="core/query"===s.name,r=t&&s?.attributes?.className?.includes("wp-block-sensei-lms-course-list");
// Hide query loop toolbar settings for grid/list outlook.
if(r&&s.isSelected?l=!0:s.isSelected&&(l=!1),i(s.clientId)&&l){const e=(0,o.__)("Grid view","sensei-lms"),s=document.querySelector(`[aria-label="${e}"]`);if(s){s.parentNode.style.display="none"}}
// Hide query loop patterns for course list.
return l&&t&&!r&&!i(s.clientId)&&(
// Hide carousel control button and switch to grid view.
document.querySelectorAll(".block-editor-block-pattern-setup__display-controls").forEach((e=>{const s=e.querySelectorAll("button");
// Select Grid view.
s[1].click(),
// Hide all control buttons.
s.forEach((e=>{e.style.display="none"}))})),document.querySelectorAll(".block-editor-block-pattern-setup-list__list-item").forEach((e=>{[...e.querySelectorAll("div")].find((e=>"course-list-element"===e.innerText))||(e.style.display="none")}))),(0,n.jsx)(e,{...s})}))}
/***/,
/***/71127:
/***/(e,s,t)=>{"use strict";
/* unused harmony exports addColorSettings, removeColorSaveProps, removeColorEditProps, removeWrapperProps */
/* harmony import */var o=t(66087),r=t(52619),n=t(27723),l=t(29281),i=t(62540);
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
 * Check if block is a Sensei button.
 *
 * @param {Object|string} blockType Block settings or name.
 * @return {boolean} Is Sensei button.
 */
const a=e=>(e="string"==typeof e?e:e.name)&&e.startsWith("sensei-lms/button"),c=e=>({...e,className:e?.className?.replace(/\s*has-[\w-]*(color|background)/g,""),style:(0,o.omitBy)(e?.style,((e,s)=>s.match(/(color|background|background-color|border)/)))})
/**
 * Remove extra props from the save element wrapper added by the color support hook.
 *
 * @param {Object} props     Extra save props.
 * @param {Object} blockType Block settings.
 * @return {Object} props Extra save props.
 */;
/**
 * Add fallback Color settings and attributes if the color support key is not available.
 *
 * @param {Object} settings Block settings.
 * @return {Object} Block settings.
 */(0,r.addFilter)("blocks.getSaveContent.extraProps","sensei/button/removeColorSaveProps",((e,s)=>a(s)?c(e):e)),(0,r.addFilter)("blocks.registerBlockType","sensei/button/removeColorEditProps",(e=>{if(!a(e))return e;const s=e.getEditWrapperProps;return s&&(e.getEditWrapperProps=e=>{const t=s(e);return c(t)}),e})),(0,r.addFilter)("blocks.registerBlockType","sensei/button/addColorSettings",(e=>a(e)?(e.supports?.color&&!e.attributes?.backgroundColor&&(e.edit=(0,l/* .withColorSettings */.rt)({backgroundColor:{style:"background-color",label:(0,n.__)("Background color","sensei-lms")},textColor:{style:"color",label:(0,n.__)("Text color","sensei-lms")}})(e.edit),e.attributes={...e.attributes,backgroundColor:{type:"string"},customBackgroundColor:{type:"string"},textColor:{type:"string"},customTextColor:{type:"string"}}),e):e)),(0,r.addFilter)("editor.BlockListBlock","sensei/button/removeWrapperProps",(e=>s=>{let{name:t,wrapperProps:o}=s;return a(t)&&o&&(o=c(o)),(0,i.jsx)(e,{...s,wrapperProps:o})}),1)}
/***/,
/***/71406:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */KS:()=>/* binding */i
/* harmony export */,_N:()=>/* binding */a
/* harmony export */,xh:()=>/* binding */l
/* harmony export */});
/* unused harmony export getBorderRadiusProps */
/* harmony import */var o=t(4452),r=t.n(o),n=t(98157);
/* harmony import */
/**
 * Class and style attributes for the button.
 *
 * @param {{attributes}} props Block properties.
 * @return {{className, style}} Output HTML attributes.
 */
function l(e){const s=a(e),t=(0,n/* .getColorAndStyleProps */.g)(e),o=
/**
 * External dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Class and style attributes for border radius.
 *
 * @param {Object} props
 * @param {Object} props.attributes
 * @param {number} props.attributes.borderRadius Border radius attribute.
 * @return {{className, style}} Output HTML attributes.
 */
function({attributes:{borderRadius:e}}){return{className:{"no-border-radius":0===e},style:{borderRadius:e?e+"px":void 0}}}(e);return{className:r()({"wp-block-button__link":!s},o.className,t.className,e?.attributes?.buttonClassName),style:{...o.style,...t.style}}}
/**
 * Class and style attributes for the wrapper element.
 *
 * @param {Object} props                  Block properties.
 * @param {string} props.className        Block classname.
 * @param {Object} props.attributes       Block attributes.
 * @param {string} props.attributes.align Alignment attribute.
 * @return {{className}} Output HTML attributes.
 */function i({className:e,attributes:{align:s}}){return{className:r()(e,"wp-block-sensei-button","wp-block-button",`has-text-align-${s||"left"}`)}}
/**
 * Check if block has the 'Link' block style.
 *
 * @param {Object} props Block props.
 * @return {boolean} Is it a link block style.
 */const a=e=>/\bis-style-link\b/.test(e?.attributes?.className)
/***/},
/***/72613:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */e:()=>/* binding */b
/* harmony export */,u:()=>/* binding */g
/* harmony export */});
/* harmony import */var o=t(66087),r=t(4452),n=t.n(r),l=t(27723),i=t(74997),a=t(35479),c=(t(71127),t(90078)),u=t(21307),d=t(74862),p=t(29281),m=t(62540);
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
 * Button block styles.
 */
const g={Fill:{name:"default",label:(0,l.__)("Fill","sensei-lms")},Outline:{name:"outline",label:(0,l.__)("Outline","sensei-lms")},Link:{name:"link",label:(0,l.__)("Link","sensei-lms")}},b=({settings:e,invalidUsage:s,EditWrapper:t,...r})=>{r={alignmentOptions:{controls:["left","center","right","full"],default:"left"},...r};const b=e.styles?e.styles:[{...g.Fill,isDefault:!0},g.Outline],h=(0,o.find)(b,"isDefault")?.name,v=(0,p/* .withDefaultBlockStyle */.Sw)(h)(c/* ["default"] */.A),x=(0,p/* .withDefaultBlockStyle */.Sw)(h)(u/* ["default"] */.A);return(0,o.merge)({name:"sensei-lms/button",title:"Sensei Button",category:"sensei-lms",attributes:{text:{type:"string",source:"html",selector:"a,button"},align:{type:"string"},borderRadius:{type:"number"},style:{type:"object"},isPreview:{type:"boolean",default:!1},inContainer:{type:"boolean",default:!1},buttonClassName:{type:"array",default:[]}},usesContext:["postType"],supports:{__experimentalBorder:{color:!0,width:!0,style:!0},border:!0,color:{gradients:!0,link:!0,__experimentalDefaultControls:{background:!0,text:!0,link:!0}},__experimentalColor:{gradients:!0},align:!1,html:!1},icon:a/* ["default"] */.A,styles:b,edit(e){const{postType:o}=e.context,n=(0,m.jsx)(v,{...e,...r});if(s?.validPostTypes&&!s.validPostTypes.includes(o)){const e=s?.message||(0,l.__)("This block can only be used inside the Course List block.","sensei-lms");
return(0/* ["default"] */,m.jsx)(d.A,{message:e})}return t?(0,m.jsx)(t,{...e,children:n}):n},save:s=>(0,m.jsx)(x,{...s,...r,blockName:e.name}),getEditWrapperProps:({inContainer:s,align:t})=>s?{className:n()("sensei-buttons-container__button-block",(0,i.getBlockDefaultClassName)(e.name)+"__wrapper",{[`sensei-buttons-container__button-align-${t}`]:t})}:{},example:{attributes:{align:"center",isPreview:!0}}},e)};
/**
 * Create a block type settings object for custom button-based blocks.
 *
 * Settings are merged into block settings, the rest of the options are passed on to the save and edit components.
 *
 * @param {Object}   opts
 * @param {Object}   opts.settings     Block settings.
 * @param {Object}   opts.invalidUsage Info about whether this block is being used in the proper context.
 * @param {Function} opts.EditWrapper  Custom edit wrapper component.
 */}
/***/,
/***/74862:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>n
/* harmony export */});
/* harmony import */var o=t(94715),r=t(62540);
/* harmony import */
/* harmony default export */const n=
/**
 * WordPress dependencies
 */
function({message:e}){const s=(0,o.useBlockProps)();
return(0,r.jsx)("div",{...s,children:(0,r.jsx)(o.Warning,{children:e})})};
/***/},
/***/74997:
/***/e=>{"use strict";e.exports=window.wp.blocks}
/***/,
/***/76296:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>a
/* harmony export */});
/* harmony import */var o=t(27723),r=t(94715),n=t(72613),l=t(50594),i=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Continue Course block.
 */
/* harmony default export */const a=(0,n/* .createButtonBlockType */.e)({tagName:"a",settings:{name:"sensei-lms/button-continue-course",parent:["sensei-lms/course-actions"],title:(0,o.__)("Continue Course","sensei-lms"),description:(0,o.__)("Enable a student to pick up where they left off in a course.","sensei-lms"),keywords:[(0,o.__)("Button","sensei-lms"),(0,o.__)("Continue","sensei-lms"),(0,o.__)("Course","sensei-lms")],attributes:{text:{default:(0,o.__)("Continue","sensei-lms")}},styles:[{...n/* .BlockStyles */.u.Fill,isDefault:!0},n/* .BlockStyles */.u.Outline,n/* .BlockStyles */.u.Link]},EditWrapper:({children:e})=>(0,i.jsxs)(i.Fragment,{children:[(0,i.jsx)(r.BlockControls,{children:(0/* ["default"] */,i.jsx)(l.A,{useCourseStatusContext:!0})}),e]})});
/***/},
/***/77505:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */$x:()=>/* binding */n
/* harmony export */,y$:()=>/* binding */l
/* harmony export */});
/* unused harmony export composeFetchAction */
/* harmony import */var o=t(47143);
/* harmony import */
/**
 * WordPress dependencies
 */
// We register the store in the global scope to avoid registering it multiple times.
// The reason to be in the global scope is that some times we have different built files using the same source.
window.senseiStores=window.senseiStores||[];const{senseiStores:r}=window,n=(e,s)=>(t=s,o)=>(e[o.type]||e.DEFAULT)(o,t),l=(e,s)=>{if(r[e])return r[e];const t=(0,o.createReduxStore)(e,s);return(0,o.register)(t),r[e]=t,t};
/**
 * Compose an action creator with the given start, success and error actions.
 *
 * @param {string}   startAction   Start action type.
 * @param {Function} fetchFn       The action creator to be wrapped. Should return the resolved data.
 * @param {string}   successAction Success action type.
 * @param {string}   errorAction   Error action type.
 * @return {Function} The wrapped action creator.
 */}
/***/,
/***/77549:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */t:()=>/* binding */a
/* harmony export */});
/* unused harmony export getProbeStyles */
/* harmony import */var o=t(66087),r=t(86087),n=t(47143),l=t(83157);
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
const{getComputedStyle:i}=window,a=()=>{const e=(0,n.useSelect)((e=>e("core/editor").getEditorSettings().colors),[]),[s,t]=(0,r.useState)({});return(0,r.useEffect)((()=>{const s=c(),r={},n=(0,o.mapValues)((0,o.keyBy)(e,(e=>(0,l/* .hexToRGB */.i)(e.color))),"slug");Object.entries(s).forEach((([e,s])=>{const t=n[(0,l/* .hexToRGB */.i)(s)];t&&(r[e]={slug:t,color:s})})),t(r)}),[e]),s},c=(0,o.memoize)((()=>{
// Create temporary probe elements.
const e=document.createElement("div");e.className="editor-styles-wrapper sensei-probe-element";const s=document.createElement("div");s.className="wp-block-button";const t=document.createElement("div");t.className="wp-block-button__link",t.textContent="Probe",
// Set probe position outside the screen to be hidden.
e.style.position="fixed",e.style.top="-100vh",
// Add probe to the screen.
s.appendChild(t),e.appendChild(s),document.body.appendChild(e);
// Save styles.
const o={primaryColor:i(t).backgroundColor,primaryContrastColor:i(t).color};
// Remove probe.
return document.body.removeChild(e),o}));
/**
 * Get color object by probe.
 *
 * @return {Object} Object containing the color objects, where the key is the probe key.
 */}
/***/,
/***/81596:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>u
/* harmony export */});
/* harmony import */var o=t(27723),r=t(47143),n=t(56427),l=t(94715),i=t(74862),a=t(62540);
/* harmony import */function c({filters:e,types:s}){return!s||s.length<1?null:Object.keys(e).map((t=>{const o=e[t];return s.includes(t)?(0,a.jsx)(n.SelectControl,{options:o.options,onChange:()=>{},value:o.defaultOption},o.label):null}))}
/* harmony default export */const u=function({attributes:{types:e,defaultOptions:s},context:{query:t},setAttributes:u}){const d=
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
function(e){var s,t,n;const l=(0,r.useSelect)((e=>{const s=e("core").getEntityRecords("taxonomy","course-category",{per_page:-1});return null!=s?s:[]}),[]).map((e=>({label:e.name,value:e.id})));return{categories:{label:(0,o.__)("Categories","sensei-lms"),options:[{label:(0,o.__)("All Categories","sensei-lms"),value:-1},...l],defaultOption:null!==(s=e?.categories)&&void 0!==s?s:-1},featured:{label:(0,o.__)("Featured","sensei-lms"),options:[{label:(0,o.__)("All Courses","sensei-lms"),value:"all"},{label:(0,o.__)("Featured","sensei-lms"),value:"featured"}],defaultOption:null!==(t=e?.featured)&&void 0!==t?t:"all"},student_course:{label:(0,o.__)("Student Courses","sensei-lms"),options:[{label:(0,o.__)("All Courses","sensei-lms"),value:"all"},{label:(0,o.__)("Active","sensei-lms"),value:"active"},{label:(0,o.__)("Completed","sensei-lms"),value:"completed"}],defaultOption:null!==(n=e?.student_course)&&void 0!==n?n:"all"}}}(s),p=(0,l.useBlockProps)();return"course"!==t?.postType?(u({align:!1,className:"wp-block-sensei-lms-course-list-filter__warning"}),(0/* ["default"] */,a.jsx)(i.A,{message:(0,o.__)("The Course List Filter block can only be used inside the Course List block.","sensei-lms")})):(0,a.jsxs)("div",{...p,children:[(0,a.jsx)(l.InspectorControls,{children:(0,a.jsx)(n.PanelBody,{title:(0,o.__)("Filter Type","sensei-lms"),children:Object.keys(d).map((s=>(0,a.jsx)(n.ToggleControl,{label:d[s].label,checked:e.includes(s),onChange:t=>function(e,s,t,o){t({types:e?[...s,o]:s.filter((e=>e!==o))})}(t,e,u,s)},s)))})}),(0,a.jsx)(c,{filters:d,types:e})]})};
/***/},
/***/83157:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */i:()=>/* binding */o
/* harmony export */});
/**
 * Converts css color hex to rgb.
 *
 * @param {string} h The hex color string.
 *
 * @return {string} The rgb value.
 */
const o=e=>{
// Returns if it's not an hexadecimal.
if(!e||null===e.match("#"))return e;let s=0,t=0,o=0;const r=4===e.length?`#${e[1]+e[1]+e[2]+e[2]+e[3]+e[3]}`:e;return 7===r.length&&(s=parseInt(r.substr(1,2),16)||0,t=parseInt(r.substr(3,2),16)||0,o=parseInt(r.substr(5,2),16)||0),`rgb(${s}, ${t}, ${o})`};
/***/},
/***/85810:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */F:()=>/* reexport safe */o.A
/* harmony export */,d:()=>/* reexport safe */r.A
/* harmony export */});
/* harmony import */var o=t(76296),r=t(50176);
/* harmony import */}
/**
 * Internal dependencies
 */
/***/,
/***/86087:
/***/e=>{"use strict";e.exports=window.wp.element}
/***/,
/***/86760:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>a
/* harmony export */});
/* harmony import */var o=t(27723),r=t(94715),n=t(72613),l=t(50594),i=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Take course button block.
 */
/* harmony default export */const a=(0,n/* .createButtonBlockType */.e)({settings:{name:"sensei-lms/button-take-course",title:(0,o.__)("Course Signup","sensei-lms"),description:(0,o.__)("Enable a registered user to start the course. This block is only displayed if the user is not already enrolled.","sensei-lms"),keywords:[(0,o.__)("Start","sensei-lms"),(0,o.__)("Sign up","sensei-lms"),(0,o.__)("Signup","sensei-lms"),(0,o.__)("Enrol","sensei-lms"),(0,o.__)("Enroll","sensei-lms"),(0,o.__)("Course","sensei-lms"),(0,o.__)("Take course","sensei-lms")],attributes:{text:{default:(0,o.__)("Take Course","sensei-lms")}},example:{attributes:{align:"left"}}},invalidUsage:{message:(0,o.__)("The Course Signup block can only be used inside the Course List block.","sensei-lms"),validPostTypes:["course"]},EditWrapper:({children:e})=>(0,i.jsxs)(i.Fragment,{children:[(0,i.jsx)(r.BlockControls,{children:(0/* ["default"] */,i.jsx)(l.A,{useCourseStatusContext:!0})}),e]})});
/***/},
/***/89726:
/***/e=>{"use strict";e.exports=JSON.parse('{"$schema":"https://schemas.wp.org/trunk/block.json","apiVersion":2,"name":"sensei-lms/course-list-filter","title":"Course List Filter","description":"Filter courses in Course List block","category":"sensei-lms","textdomain":"sensei-lms","keywords":["course","categories","lessons","featured","filter"],"attributes":{"align":{"type":"string","default":"left"},"types":{"type":"array","default":["categories","featured","student_course"]},"defaultOptions":{"type":"object","default":{"categories":-1,"featured":"all","student_course":"all"}}},"usesContext":["queryId","query"],"supports":{"align":["left","right"],"html":false}}')}
/***/,
/***/90078:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>c
/* harmony export */});
/* harmony import */var o=t(47143),r=t(94715),n=t(27723),l=t(71406),i=t(44539),a=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Edit component for a Button block.
 *
 * @param {Object} props
 */
const c=e=>{const{placeholder:s,attributes:t,setAttributes:c}=e,{text:u}=t,{colors:d}=(0,o.useSelect)((e=>e("core/block-editor").getSettings()),[]),p=void 0!==e.text,m=(0,l/* .getButtonProps */.xh)({...e,colors:d});
return(0,a.jsxs)("div",{...(0,l/* .getButtonWrapperProps */.KS)(e),children:[p?(0,a.jsx)("div",{...m,children:e.text}):(0,a.jsx)(r.RichText,{placeholder:s||(0,n.__)("Add text…","sensei-lms"),value:u,onChange:e=>c({text:e}),...m,tagName:"div",identifier:"text",withoutInteractiveFormatting:!0}),(0/* ["default"] */,a.jsx)(i.A,{...e})]})};
/* harmony default export */}
/***/,
/***/94715:
/***/e=>{"use strict";e.exports=window.wp.blockEditor}
/***/,
/***/95861:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>a
/* harmony export */});
/* harmony import */var o=t(4452),r=t.n(o),n=t(27723),l=t(94715),i=t(62540);
/* harmony import */
/**
 * External dependencies
 */
/**
 * WordPress dependencies
 */
/**
 * Progress bar component.
 *
 * @param {Object}  props
 * @param {number}  props.totalCount              Total count for progress bar.
 * @param {number}  props.completedCount          Number of completed.
 * @param {boolean} props.hidePercentage          Hide completed percentage.
 * @param {Object}  props.wrapperAttributes       Wrapper HTML attributes.
 * @param {Object}  props.barWrapperAttributes    Bar wrapper HTML attributes.
 * @param {string}  props.countersClassName       Counters class name.
 * @param {string}  props.completedCountClassName Completed count class name.
 * @param {Object}  props.barAttributes           Bar HTML attributes.
 * @param {boolean} props.hideDefault             Hide default settings for edit view only.
 * @param {boolean} props.label                   Label.
 */
const a=({totalCount:e,completedCount:s,hidePercentage:t,wrapperAttributes:o,barWrapperAttributes:a,barAttributes:c,countersClassName:u,completedCountClassName:d,hideDefault:p,label:m})=>{const g=Math.round(s/e*100)||0,b=Math.max(p?0:3,g),h=(0,l.useBlockProps)(o);
return(0,i.jsxs)("div",{...h,children:[(0,i.jsx)("section",{className:r()("sensei-progress-bar__heading",u),children:(0,i.jsxs)("div",{className:r()("sensei-progress-bar__label",d),children:[(0,n.sprintf)(
// translators: Placeholder %1$d is the completed progress count, %2$d is the total count and %3$s is the label for progress bar.
// translators: Placeholder %1$d is the completed progress count, %2$d is the total count and %3$s is the label for progress bar.
(0,n.__)("%1$d of %2$d %3$s completed","sensei-lms"),s,e,m||""),!t&&` (${g}%)`]})}),(0,i.jsx)("div",{role:"progressbar","aria-valuenow":g,"aria-valuemin":"0","aria-valuemax":"100",...a,className:r()("sensei-progress-bar__bar",a?.className),children:(0,i.jsx)("div",{...c,className:r()("sensei-progress-bar__progress",c?.className),style:{...c?.style&&c.style,width:`${b}%`}})})]})};
/* harmony default export */}
/***/,
/***/98157:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */g:()=>/* binding */l
/* harmony export */});
/* unused harmony export getGradientClass */
/* harmony import */var o=t(4452),r=t.n(o),n=t(94715);
/* harmony import */
/**
 * External dependencies
 */
/**
 * WordPress dependencies
 */
/**
 * Get className for gradient.
 *
 * @param {string} gradientSlug
 * @return {string|undefined} Class.
 */
const l=({attributes:e,colors:s})=>{const{backgroundColor:t,borderColor:o,customBackgroundColor:l,textColor:i,customTextColor:a,gradient:c,style:u={}}=e,d=(0,n.getColorClassName)("background-color",t);u.color||(u.color={}),l&&(u.color.background=l),a&&(u.color.text=a);const p=(0,n.getColorClassName)("border-color",o),m=(e=>{if(e)return`has-${e}-gradient-background`})(c),g=(0,n.getColorClassName)("color",i),b=r()(g,m,p,{
// Don't apply the background class if there's a custom gradient
[d]:!u?.color?.gradient&&!!d,"has-text-color":i||u?.color?.text,"has-background":t||u?.color?.background||c||u?.color?.gradient,"has-border-color":o}),h=u?.color?.background||u?.color?.text||u?.color?.gradient?{background:u?.color?.gradient?u.color.gradient:void 0,backgroundColor:u?.color?.background?u.color.background:void 0,color:u?.color?.text?u.color.text:void 0}:{};
// This is needed only for themes that don't load their color stylesheets in the editor
// We force an inline style to apply the color.
if(u?.border?.color&&(h.borderColor=u.border.color),u?.border?.width&&(h.borderWidth=u.border.width),s){if(t){const e=(0,n.getColorObjectByAttributeValues)(s,t);h.backgroundColor=e.color}if(i){const e=(0,n.getColorObjectByAttributeValues)(s,i);h.color=e.color}}return{className:b||void 0,style:h}};
/**
 * Get className and style from color settings.
 *
 * Copied from Gutenberg color support hook.
 *
 * @param {Object} props
 * @param {Object} props.attributes Block Attributes.
 * @param {Object} props.colors     Theme color settings.
 */}
/***/
/******/},s={};
/************************************************************************/
/******/ // The module cache
/******/
/******/
/******/ // The require function
/******/function t(o){
/******/ // Check if module is in cache
/******/var r=s[o];
/******/if(void 0!==r)
/******/return r.exports;
/******/
/******/ // Create a new module (and put it into the cache)
/******/var n=s[o]={
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
/******/var s=e&&e.__esModule?
/******/()=>e.default
/******/:()=>e
/******/;
/******/return t.d(s,{a:s}),s;
/******/},
/******/ // define getter functions for harmony exports
/******/t.d=(e,s)=>{
/******/for(var o in s)
/******/t.o(s,o)&&!t.o(e,o)&&
/******/Object.defineProperty(e,o,{enumerable:!0,get:s[o]})
/******/;
/******/},
/******/t.o=(e,s)=>Object.prototype.hasOwnProperty.call(e,s)
/******/,
// This entry needs to be wrapped in an IIFE because it needs to be in strict mode.
(()=>{"use strict";
/* harmony import */var e=t(47056),s=t(67939),o=t(85810),r=t(68815),n=t(48308),l=t(51764),i=t(70108),a=t(86760),c=t(23371);
/* harmony import */
/**
 * Internal dependencies
 */
/**
 * Internal dependencies
 */
(0,s/* .registerCourseListBlock */.w6)(),(0,e/* ["default"] */.A)([o/* .ContinueCourse */.F,o/* .CourseActions */.d,r/* ["default"] */.A,n/* ["default"] */.A,l/* ["default"] */.A,i/* ["default"] */.A,a/* ["default"] */.A,c/* ["default"] */.A])})()})
/******/();