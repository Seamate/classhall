/******/(()=>{// webpackBootstrap
/******/var e={
/***/1022:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>a
/* harmony export */});
/* harmony import */var n=t(5823),o=t(27723),i=t(72108),l=t(66087),r=t(62540);
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
/**
 * Lessons filter.
 *
 * @param {Object}   props
 * @param {Function} props.setFilters Filters state setter.
 */
const a=({setFilters:e})=>{
return(0,r.jsx)("ul",{className:"sensei-lms-existing-lessons-modal__filters",children:(0,r.jsx)("li",{children:(0/* ["default"] */,r.jsx)(i.A,{className:"sensei-lms-existing-lessons-modal__search-input",placeholder:(0,o.__)("Search lessons","sensei-lms"),iconRight:n/* ["default"] */.A,onChange:(s="search",t=400,(0,l.debounce)((t=>{e((e=>({...e,[s]:t})))}),t))})})});var s,t};
/* harmony default export */}
/***/,
/***/1027:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>i
/* harmony export */});
/* harmony import */var n=t(5573),o=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
const i=(0,o.jsx)(n.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24",children:(0,o.jsx)(n.Path,{d:"M16.7 7.1l-6.3 8.5-3.3-2.5-.9 1.2 4.5 3.4L17.9 8z"})});
/* harmony default export */}
//# sourceMappingURL=check.js.map
/***/,
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
 */var n=t(51609),o=Symbol.for("react.element"),i=Symbol.for("react.fragment"),l=Object.prototype.hasOwnProperty,r=n.__SECRET_INTERNALS_DO_NOT_USE_OR_YOU_WILL_BE_FIRED.ReactCurrentOwner,a={key:!0,ref:!0,__self:!0,__source:!0};function c(e,s,t){var n,i={},c=null,u=null;for(n in void 0!==t&&(c=""+t),void 0!==s.key&&(c=""+s.key),void 0!==s.ref&&(u=s.ref),s)l.call(s,n)&&!a.hasOwnProperty(n)&&(i[n]=s[n]);if(e&&e.defaultProps)for(n in s=e.defaultProps)void 0===i[n]&&(i[n]=s[n]);return{$$typeof:o,type:e,key:c,ref:u,props:i,_owner:r.current}}s.Fragment=i,s.jsx=c,s.jsxs=c}
/***/,
/***/2883:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */n:()=>/* binding */n
/* harmony export */});
/**
 * An enum of Status constants.
 */
const n={NOT_STARTED:"not-started",IN_PROGRESS:"in-progress",COMPLETED:"completed"};
/***/},
/***/4452:
/***/(e,s)=>{var t;
/*!
	Copyright (c) 2018 Jed Watson.
	Licensed under the MIT License (MIT), see
	http://jedwatson.github.io/classnames
*/
/* global define */!function(){"use strict";var n={}.hasOwnProperty;function o(){for(var e="",s=0;s<arguments.length;s++){var t=arguments[s];t&&(e=l(e,i(t)))}return e}function i(e){if("string"==typeof e||"number"==typeof e)return e;if("object"!=typeof e)return"";if(Array.isArray(e))return o.apply(null,e);if(e.toString!==Object.prototype.toString&&!e.toString.toString().includes("[native code]"))return e.toString();var s="";for(var t in e)n.call(e,t)&&e[t]&&(s=l(s,t));return s}function l(e,s){return s?e?e+" "+s:e+s:e}e.exports?(o.default=o,e.exports=o):void 0===(t=function(){return o}.apply(s,[]))||(e.exports=t)}()}
/***/,
/***/5573:
/***/e=>{"use strict";e.exports=window.wp.primitives}
/***/,
/***/5705:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */l:()=>/* binding */u
/* harmony export */});
/* harmony import */var n=t(47143),o=t(2883),i=t(66161),l=t(77505);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
const r={
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
*setModuleStatus(e,s){const t=yield(0,i.select)(u,"getTrackedLessons"),n=(yield(0,i.select)("core/block-editor","getClientIdsOfDescendants",[e])).filter((e=>t.includes(e)));if(0!==n.length)return o/* .Status */.n.COMPLETED!==s&&o/* .Status */.n.NOT_STARTED!==s?(yield*n.slice(1).map((e=>r.setLessonStatus(e,o/* .Status */.n.NOT_STARTED))),r.setLessonStatus(n[0],o/* .Status */.n.COMPLETED)):void(yield*n.map((e=>r.setLessonStatus(e,s))))},
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
   */,getLessonStatus:({completedLessons:e},s)=>e.includes(s)?o/* .Status */.n.COMPLETED:o/* .Status */.n.NOT_STARTED
/**
   * Returns the number of total and completed lessons of a module.
   *
   * @param {Object} state                  The state.
   * @param {Array}  state.completedLessons The ids of the completed lessons.
   * @param {Array}  state.trackedLessons   The ids of  all the lessons.
   * @param {string} moduleId               The module id.
   *
   * @return {Object} The module lesson counts.
   */,getModuleLessonCounts({completedLessons:e,trackedLessons:s},t){const o=(0,n.select)("core/block-editor").getClientIdsOfDescendants([t]).filter((e=>s.includes(e)));return{completedLessonsCount:o.filter((s=>e.includes(s))).length,totalLessonsCount:o.length}}},c={
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
SET_LESSON_STATUS:({lessonId:e,status:s},t)=>{let n=[...t.completedLessons];return o/* .Status */.n.COMPLETED===s?n.includes(e)||n.push(e):n=n.filter((s=>s!==e)),{...t,completedLessons:n}},
/**
   * Removes any lessons that don't exist in list of descendantIds.
   *
   * @param {Object} action               The action.
   * @param {Array}  action.descendantIds The ids of all descendants of the outline block.
   * @param {Object} state                The state.
   *
   * @return {Object} The new state.
   */
REMOVE_LESSONS:({descendantIds:e},s)=>{const t=s.completedLessons.filter((s=>e.includes(s))),n=s.trackedLessons.filter((s=>e.includes(s)));
// Do not update the state if no lessons were removed.
return n.length===s.trackedLessons.length&&t.length===s.completedLessons.length?s:{...s,completedLessons:t,trackedLessons:n}},
/**
   * Removes a lesson from the arrays of tracked lessons.
   *
   * @param {Object} action          The action.
   * @param {Array}  action.lessonId The ids of the lesson to ignore.
   * @param {Object} state           The state.
   *
   * @return {Object} The new state.
   */
IGNORE_LESSON:({lessonId:e},s)=>{const t=s.completedLessons.filter((s=>s!==e)),n=s.trackedLessons.filter((s=>s!==e));return{...s,completedLessons:t,trackedLessons:n}},
/**
   * Adds a lesson from the arrays of tracked lessons.
   *
   * @param {Object} action          The action.
   * @param {Array}  action.lessonId The ids of the lesson to track.
   * @param {Object} state           The state.
   *
   * @return {Object} The new state.
   */
TRACK_LESSON:({lessonId:e},s)=>{const t=[...s.trackedLessons];return t.includes(e)?s:(t.push(e),{...s,trackedLessons:t})},DEFAULT:(e,s)=>s},u=(0,l/* .createStore */.y$)("sensei/course-status",{reducer:(0,l/* .createReducerFromActionMap */.$x)(c,{completedLessons:[],trackedLessons:[]}),actions:r,selectors:a,controls:i.controls});
/**
 * Status store actions.
 */}
/***/,
/***/5823:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>i
/* harmony export */});
/* harmony import */var n=t(5573),o=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
const i=(0,o.jsx)(n.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24",children:(0,o.jsx)(n.Path,{d:"M13 5c-3.3 0-6 2.7-6 6 0 1.4.5 2.7 1.3 3.7l-3.8 3.8 1.1 1.1 3.8-3.8c1 .8 2.3 1.3 3.7 1.3 3.3 0 6-2.7 6-6S16.3 5 13 5zm0 10.5c-2.5 0-4.5-2-4.5-4.5s2-4.5 4.5-4.5 4.5 2 4.5 4.5-2 4.5-4.5 4.5z"})});
/* harmony default export */}
//# sourceMappingURL=search.js.map
/***/,
/***/9022:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>d
/* harmony export */});
/* harmony import */var n=t(94715),o=t(56427),i=t(47143),l=t(27723),r=t(2883),a=t(77522),c=t(48469),u=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Inspector controls for lesson block.
 *
 * @param {Object}   props                     Component props.
 * @param {string}   props.previewStatus       Status to preview.
 * @param {Function} props.setPreviewStatus    Set status to preview.
 * @param {Function} props.setAttributes       Callback method to set the lesson title font size.
 * @param {Function} props.attributes          The block attributes.
 * @param {number}   props.attributes.id       The lesson id.
 * @param {string}   props.attributes.fontSize The lesson block font size.
 * @param {string}   props.attributes.title    The lesson title.
 */
const d=({previewStatus:e,setPreviewStatus:s,setAttributes:t,attributes:{id:d,fontSize:m,title:p}})=>{const{fontSizes:h}=(0,i.useSelect)((e=>e("core/block-editor").getSettings()));
return(0,u.jsxs)(u.Fragment,{children:[(0,u.jsxs)(n.InspectorControls,{children:[d&&(0,u.jsxs)(o.PanelBody,{title:(0,l.__)("Lesson","sensei-lms"),children:[(0,u.jsx)("h2",{children:(0/* .EditLessonLink */,u.jsx)(c.d,{lessonId:d})}),(0,u.jsx)("p",{children:(0,l.__)("Edit details such as lesson content, prerequisite, quiz settings and more.","sensei-lms")})]}),(0,u.jsx)(o.PanelBody,{title:(0,l.__)("Typography","sensei-lms"),children:(0,u.jsx)(o.FontSizePicker,{__nextHasNoMarginBottom:!0,fontSizes:h,value:m,onChange:e=>{t({fontSize:e})}})}),(0,u.jsx)(o.PanelBody,{title:(0,l.__)("Status","sensei-lms"),initialOpen:!1,children:(0/* .StatusControl */,u.jsx)(a.A,{status:e,setStatus:s,options:[r/* .Status */.n.NOT_STARTED,r/* .Status */.n.COMPLETED],disabled:!p})})]}),(0,u.jsx)(n.BlockControls,{children:(0/* ["default"] */,u.jsx)(c.A,{lessonId:d,lessonTitle:p})})]})};
/* harmony default export */}
/***/,
/***/12035:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>i
/* harmony export */});
/* harmony import */var n=t(5573),o=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
const i=(0,o.jsx)(n.SVG,{viewBox:"0 0 24 24",xmlns:"http://www.w3.org/2000/svg",children:(0,o.jsx)(n.Path,{d:"M6.5 12.4L12 8l5.5 4.4-.9 1.2L12 10l-4.5 3.6-1-1.2z"})});
/* harmony default export */}
//# sourceMappingURL=chevron-up.js.map
/***/,
/***/12107:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>i
/* harmony export */});
/* harmony import */var n=t(5573),o=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
const i=(0,o.jsx)(n.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24",children:(0,o.jsx)(n.Path,{d:"M11 12.5V17.5H12.5V12.5H17.5V11H12.5V6H11V11H6V12.5H11Z"})});
/* harmony default export */}
//# sourceMappingURL=plus.js.map
/***/,
/***/12417:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>o
/* harmony export */});
/* harmony import */var n=t(86087);
/* harmony import */
/* harmony default export */const o=(0,n.forwardRef)((
/**
 * WordPress dependencies
 */
/** @typedef {{icon: JSX.Element, size?: number} & import('@wordpress/primitives').SVGProps} IconProps */
/**
 * Return an SVG icon.
 *
 * @param {IconProps}                                 props icon is the SVG component to render
 *                                                          size is a number specifying the icon size in pixels
 *                                                          Other props will be passed to wrapped SVG component
 * @param {import('react').ForwardedRef<HTMLElement>} ref   The forwarded ref to the SVG element.
 *
 * @return {JSX.Element}  Icon component
 */
function({icon:e,size:s=24,...t},o){return(0,n.cloneElement)(e,{width:s,height:s,...t,ref:o})}));
//# sourceMappingURL=index.js.map
/***/},
/***/14309:
/***/e=>{"use strict";e.exports=window.wp.editPost}
/***/,
/***/16012:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>l
/* harmony export */});
/* harmony import */var n,o=t(51609);
/* harmony import */function i(){return i=Object.assign?Object.assign.bind():function(e){for(var s=1;s<arguments.length;s++){var t=arguments[s];for(var n in t)({}).hasOwnProperty.call(t,n)&&(e[n]=t[n])}return e},i.apply(null,arguments)}
/* harmony default export */const l=function(e){
return o.createElement("svg",i({viewBox:"0 0 24 24",xmlns:"http://www.w3.org/2000/svg"},e),n||(n=o.createElement("path",{d:"M9 18.6 3.5 13l1-1L9 16.4l9.5-9.9 1 1z",fill:"currentColor"})))};
/***/},
/***/16643:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>a
/* harmony export */});
/* harmony import */var n=t(66087),o=t(47143),i=t(56427),l=t(27723),r=t(62540);
/* harmony import */
/**
 * External dependencies
 */
/**
 * WordPress dependencies
 */
/**
 * Select lessons by filters.
 *
 * @param {Function} select  Data select function.
 * @param {Object}   filters Filters object.
 * @return {Object[]} Lessons.
 */
const a=({clientId:e,filters:s,selectedLessons:t,setSelectedLessons:a})=>{
// Ids of the already added lessons.
const c=(0,o.useSelect)((s=>s("core/block-editor").getBlocks(e))).map((e=>e.attributes?.id));
// Lessons by current filter.
let u=(0,o.useSelect)((e=>((e,s)=>e("core").getEntityRecords("postType","lesson",{requestSource:"add_existing_lesson_modal",status:["publish","draft"],metaKey:"_lesson_course",metaValue:0,per_page:100,...(0,n.omitBy)(s,(e=>""===e))}))(e,s)),[s]);if(!u)
return(0,r.jsx)("div",{className:"sensei-lms-existing-lessons-modal__lessons sensei-lms-existing-lessons-modal__lessons--loading",children:(0,r.jsx)(i.Spinner,{})});
// Filter out already added lessons.
u=u.filter((e=>!c.includes(e.id)));const d=u.length>0&&u.every((e=>t.includes(e))),m=e=>s=>{a(s?s=>[...s,e]:s=>s.filter((s=>s.id!==e.id)))};
return(0,r.jsx)("div",{className:"sensei-lms-existing-lessons-modal__lessons",children:(0,r.jsxs)("table",{className:"sensei-lms-existing-lessons-modal__lessons-table",children:[(0,r.jsx)("thead",{children:(0,r.jsxs)("tr",{children:[(0,r.jsx)("th",{className:"sensei-lms-existing-lessons-modal__lesson-checkbox",children:(0,r.jsx)(i.CheckboxControl,{title:(0,l.__)("Toggle all visible lessons selection.","sensei-lms"),checked:d,onChange:e=>{a((s=>e?(0,n.uniq)([...s,...u]):s.filter((e=>!u.includes(e)))))}})}),(0,r.jsx)("th",{children:(0,l.__)("Lesson","sensei-lms")})]})}),(0,r.jsx)("tbody",{children:0===u.length?(0,r.jsx)("tr",{children:(0,r.jsx)("td",{colSpan:"2",children:(0,r.jsx)("p",{children:(0,l.__)("No lessons found.","sensei-lms")})})}):u.map((e=>{const s=e.id,n=e.title.raw;
return(0,r.jsxs)("tr",{children:[(0,r.jsx)("td",{children:(0,r.jsx)(i.CheckboxControl,{id:`existing-lesson-${s}`,title:n,checked:t.includes(e),onChange:m(e)})}),(0,r.jsx)("td",{className:"sensei-lms-existing-lessons-modal__lesson-title",children:(0,r.jsx)("label",{htmlFor:`existing-lesson-${s}`,title:n,children:n})})]},s)}))})]})})};
/**
 * Lessons for selection.
 *
 * @param {Object}   props
 * @param {string}   props.clientId           Outline block ID.
 * @param {Object}   props.filters            Filters object.
 * @param {Object[]} props.selectedLessons    Seleted lessons.
 * @param {Function} props.setSelectedLessons Seleted lessons state setter.
 */}
/***/,
/***/17811:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>i
/* harmony export */});
/* harmony import */var n=t(5573),o=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
const i=(0,o.jsx)(n.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24",children:(0,o.jsx)(n.Path,{d:"M10.6 6L9.4 7l4.6 5-4.6 5 1.2 1 5.4-6z"})});
/* harmony default export */}
//# sourceMappingURL=chevron-right.js.map
/***/,
/***/18457:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */F:()=>/* binding */a
/* harmony export */});
/* harmony import */var n=t(94715),o=t(56427),i=t(27723),l=t(94234),r=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
const a=({addBlock:e})=>(0,r.jsxs)(o.Placeholder,{className:"wp-block-sensei-lms-course-outline__placeholder",label:(0,i.__)("Course Outline","sensei-lms"),icon:(0,r.jsx)(n.BlockIcon,{icon:l/* ["default"] */.A.icon,showColors:!0}),instructions:(0,i.__)("Build and display a course outline. A course is made up of modules (optional) and lessons. You can use modules to group related lessons together.","sensei-lms"),children:[(0,r.jsx)(o.Button,{isDefault:!0,onClick:()=>e("module"),className:"is-large",children:(0,i.__)("Create a module","sensei-lms")}),(0,r.jsx)(o.Button,{isDefault:!0,onClick:()=>e("lesson"),className:"is-large",children:(0,i.__)("Create a lesson","sensei-lms")})]})
/***/},
/***/18537:
/***/e=>{"use strict";e.exports=window.wp.htmlEntities}
/***/,
/***/19235:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>l
/* harmony export */});
/* harmony import */var n=t(47143),o=t(45793),i=t(51609);
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
const l=()=>{const e=(0/* .EXTENSIONS_STORE */,n.select)(o.z).getSenseiProExtension();return(0,i.useMemo)((()=>({isActivated:Boolean(e?.is_activated)})),[e?.is_activated])};
/* harmony default export */}
/***/,
/***/19361:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>c
/* harmony export */});
/* harmony import */var n=t(4452),o=t.n(n),i=t(94715),l=t(86087),r=t(48558),a=t(62540);
/* harmony import */
/**
 * External dependencies
 */
/**
 * WordPress dependencies
 */
/**
 * Single line input component, used for the editor only.
 *
 * @param {Object}   props           Component props.
 * @param {Function} props.onChange  Change callback.
 * @param {Function} props.onKeyDown Keydown callback.
 * @param {Function} props.onEnter   Called on Enter.
 * @param {Function} props.onRemove  Called on Backspace when value is empty.
 * @param {string}   props.value     Input value.
 * @param {Object}   ref             Input element ref.
 */
const c=(0,l.forwardRef)((({onChange:e,onKeyDown:s,value:t,onEnter:n,onRemove:l,...c},u)=>(0,a.jsx)(i.PlainText,{ref:u,value:t,onChange:s=>{e(s.replace(/\n/g,""))},onKeyDown:e=>{switch(s&&s(e),e.keyCode){case r.ENTER:e.preventDefault(),n&&n(e);break;case r.BACKSPACE:l&&!t?.length&&(e.preventDefault(),l())}},...c,className:o()("sensei-lms-single-line-input",c.className)})));
/* harmony default export */}
/***/,
/***/21699:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>o
/* harmony export */});
/* harmony import */var n=t(62540);const o=({size:e=24,...s})=>(0,n.jsxs)("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24",height:e,width:e,fill:"none",...s,children:[(0,n.jsx)("path",{fill:"#1E1E1E",d:"M17.566 18.434L17 17l-.566 1.434L15 19l1.434.566L17 21l.566-1.434L19 19l-1.434-.566zM7.566 5.434L7 4l-.566 1.434L5 6l1.434.566L7 8l.566-1.434L9 6l-1.434-.566zM17.849 5.151L17 3l-.849 2.151L14 6l2.151.849L17 9l.849-2.151L20 6l-2.151-.849z"}),(0,n.jsx)("path",{fill:"#1E1E1E",fillRule:"evenodd",d:"M12.223 8.065a.75.75 0 00-.61 0l-5.168 2.297a.75.75 0 000 1.37l1.852.823v3.36c0 .254.128.49.34.628l.41-.628-.41.628v.001l.003.001.005.003.017.012a8.218 8.218 0 00.28.17c.185.108.444.252.744.397.57.276 1.4.613 2.165.623.793.01 1.658-.328 2.251-.608a10.93 10.93 0 001.067-.58l.018-.01.006-.004.002-.001v-.001l-.405-.63.406.63a.75.75 0 00.344-.63v-3.36l1.851-.824a.75.75 0 000-1.37l-5.168-2.297zm1.816 5.157l-1.816.807a.75.75 0 01-.61 0l-1.816-.807v2.27c.148.083.334.184.542.285.543.262 1.12.468 1.532.473.427.006 1.026-.198 1.592-.465.222-.104.42-.21.577-.297v-2.266zm-2.12-.699l-3.322-1.476 3.321-1.476 3.322 1.476-3.322 1.476z",clipRule:"evenodd"})]})
/* harmony default export */}
/***/,
/***/27723:
/***/e=>{"use strict";e.exports=window.wp.i18n}
/***/,
/***/27872:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>i
/* harmony export */});
/* harmony import */var n=t(94715),o=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
const i=()=>(0,o.jsx)(n.InnerBlocks.Content,{})
/* harmony default export */}
/***/,
/***/28016:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>i
/* harmony export */});
/* harmony import */var n=t(27723),o=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
const i=()=>(0,o.jsx)("span",{className:"sensei-pro-badge",children:(0,n.__)("Pro","sensei-lms")})
/* harmony default export */}
/***/,
/***/29165:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>n
/* harmony export */});
/**
 * Internal dependencies
 */
/* harmony default export */const n=t(19361).A;
/***/},
/***/29281:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */Lt:()=>/* binding */m
/* harmony export */,Sw:()=>/* binding */d
/* harmony export */,rt:()=>/* binding */c
/* harmony export */});
/* unused harmony export ColorSettings */
/* harmony import */var n=t(66087),o=t(86087),i=t(94715),l=t(27723),r=t(77549),a=t(62540);
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
const c=e=>s=>{const t=(0,n.mapValues)(e,(e=>e.style));return(0,i.withColors)(t)((t=>(0,a.jsxs)(a.Fragment,{children:[(0,a.jsx)(s,{...t}),(0,a.jsx)(u,{colorSettings:e,props:t})]})))},u=({colorSettings:e,props:s})=>{const t=Object.keys(e).map((t=>({value:s[t].color,label:e[t].label,onChange:o=>{s[`set${(0,n.upperFirst)(t)}`](o),e[t].onChange&&e[t].onChange({...s,colorValue:o})}}))),o=s.backgroundColor?.color?.includes("var")||s.textColor?.color?.includes("var"),r=s.backgroundColor&&s.textColor&&!o;
return(0,a.jsx)(i.InspectorControls,{children:(0,a.jsx)(i.PanelColorSettings,{title:(0,l.__)("Color settings","sensei-lms"),initialOpen:!1,colorSettings:t,children:r&&(0,a.jsx)(i.ContrastChecker,{textColor:s.textColor.color,backgroundColor:s.backgroundColor.color,isLargeText:!1})})})},d=(e="default")=>s=>t=>{let{className:n}=t;const o={};n&&n.includes("is-style-")||(n=o.className=[n,`is-style-${e}`].join(" "));const i=n.match(/is-style-(\w+)/);return i&&(o.blockStyle=i[1]),(0,a.jsx)(s,{...t,...o})}
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
 */,m=e=>s=>t=>{const{setAttributes:n,attributes:l}=t,c=(0,r/* .useColorsByProbe */.t)(),[u,d]=(0,o.useState)({}),m=Object.keys(e).map((e=>l[e]));return(0,o.useEffect)((()=>{const s={};Object.entries(e).forEach((([e,{style:t,probeKey:o}])=>{const r=c[o]||{},{slug:a}=r;if(a&&(s[e]={...r,className:(0,i.getColorClassName)(t,a)}),l[e]!==a){const s={};s[e]=a,
// Border color is not compatible with all themes as className, so the color value is needed.
"border-color"===t&&(s[`${e}Value`]=r.color),n(s)}})),d(s)}
// eslint-disable-next-line react-hooks/exhaustive-deps -- The deps are added dynamically because we get it dynamically from the attributes and we don't want add all attributes as dep.
),[c,n,...m]),(0,a.jsx)(s,{...t,...u})}
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
/***/30066:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>o
/* harmony export */});
/* harmony import */var n=t(62540);const o=()=>(0,n.jsxs)("div",{className:"wp-block-sensei-lms-course-outline__ai-image",children:[(0,n.jsx)("div",{className:"wp-block-sensei-lms-course-outline__ai-image__item",children:(0,n.jsx)("div",{style:{width:"78%"},className:"wp-block-sensei-lms-course-outline__ai-image__content"})}),(0,n.jsx)("div",{className:"wp-block-sensei-lms-course-outline__ai-image__item",children:(0,n.jsx)("div",{style:{width:"47%"},className:"wp-block-sensei-lms-course-outline__ai-image__content"})}),(0,n.jsx)("div",{className:"wp-block-sensei-lms-course-outline__ai-image__item",children:(0,n.jsx)("div",{style:{width:"25%"},className:"wp-block-sensei-lms-course-outline__ai-image__content"})})]})
/* harmony default export */}
/***/,
/***/31702:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>l
/* harmony export */});
/* harmony import */var n=t(56427),o=t(12107),i=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * A custom appender. It is a plus button with some text and pops a dropdown when clicked.
 *
 * @param {Object} props          Component properties.
 * @param {Array}  props.controls DropdownMenu controls.
 * @param {string} props.text     Text to display.
 * @param {string} props.label    Button label.
 */
const l=({controls:e,text:s,label:t})=>(0,i.jsxs)("div",{className:"sensei-lms-text-appender block-editor-default-block-appender",children:[(0,i.jsx)(n.DropdownMenu,{icon:o/* ["default"] */.A,toggleProps:{className:"block-editor-inserter__toggle",onMouseDown:e=>e.preventDefault()},label:t,controls:e,popoverProps:{position:"bottom center"},menuProps:{className:"sensei-lms-text-appender__menu"}}),(0,i.jsx)("p",{className:"sensei-lms-text-appender__placeholder","data-placeholder":s})]});
/* harmony default export */}
/***/,
/***/32054:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */K:()=>/* binding */r
/* harmony export */,Y:()=>/* binding */a
/* harmony export */});
/* harmony import */var n=t(66087),o=t(47143),i=t(36536),l=t.n(i);
/* harmony import */
/**
 * External dependencies
 */
/**
 * WordPress dependencies
 */
/**
 * Checks if a block has a registered style which matches with the supplied class.
 *
 * @param {Array}  blockStyles The block's registered styles.
 * @param {string} className   The class to check.
 *
 * @return {boolean} True if there is a match.
 */
const r=(e,s)=>{if(s){const e=s.match(/is-style-\w+/);if(e)return e[0]}const t=(0,n.find)(e,"isDefault");return t?"is-style-"+t.name:null},a=(e,s)=>{const{attributes:{className:t},name:n}=(0,o.select)("core/block-editor").getBlock(e),i=(0,o.select)("core/blocks").getBlockStyles(n);if(((e,s)=>e&&e.some((e=>"is-style-"+e.name===s)))(i,s)){const n=new(l())(t),a=r(i,t);a&&n.remove(a),n.add(s),(0,o.dispatch)("core/block-editor").updateBlockAttributes(e,{className:n.value})}};
/**
 * Returns the active style class from the given className.
 *
 * @param {Array}  styles    Block style variations.
 * @param {string} className Class name.
 *
 * @return {string} The active style class.
 */}
/***/,
/***/34198:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */$:()=>/* binding */n
/* harmony export */});
/* unused harmony export logLink */
/**
 * Send log event.
 *
 * @param {string} eventName  Event name.
 * @param {Array}  properties Event properties.
 */
const n=(e,s)=>{window.sensei_log_event(e,s)};
/**
 * Enable or disable event logging.
 *
 * @param {boolean} enabled Enabled state.
 */n.enable=e=>{window.sensei_event_logging.enabled=e}}
/***/,
/***/36536:
/***/e=>{"use strict";e.exports=window.wp.tokenList}
/***/,
/***/37e3:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>_
/* harmony export */});
/* harmony import */var n=t(94715),o=t(56427),i=t(27723),l=t(94234),r=t(21699),a=t(30066),c=t(16012),u=t(28016),d=t(66087),m=t(18457),p=t(62540);
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
/**
 * Placeholder for empty Course Outline block.
 *
 * @param {Function} addBlock Add block
 */
const h=({addBlocks:e,openTailoredModal:s=d.noop})=>(0,p.jsx)(o.Placeholder,{className:"wp-block-sensei-lms-course-outline__placeholder",label:(0,i.__)("Course Outline","sensei-lms"),icon:(0,p.jsx)(n.BlockIcon,{icon:l/* ["default"] */.A.icon,showColors:!0}),instructions:(0,i.__)("Build and display a course outline.","sensei-lms"),children:(0,p.jsxs)("div",{className:"wp-block-sensei-lms-course-outline__placeholder__options",children:[(0,p.jsxs)("button",{className:"wp-block-sensei-lms-course-outline__placeholder__option wp-block-sensei-lms-course-outline__placeholder__option-blank",onClick:()=>{e([{type:"lesson",title:(0,i.__)("Lesson 1","sensei-lms")},{type:"lesson",title:(0,i.__)("Lesson 2","sensei-lms")},{type:"lesson",title:(0,i.__)("Lesson 3","sensei-lms")}])},"aria-labelledby":"generate-blank",children:[(0,p.jsxs)("div",{className:"wp-block-sensei-lms-course-outline__placeholder__option__content",children:[(0,p.jsx)("div",{className:"wp-block-sensei-lms-course-outline__placeholder__option__content__intro",children:(0,p.jsx)("p",{children:(0,i.__)("Start with a blank canvas and create your own course outline.","sensei-lms")})}),(0,p.jsxs)("ul",{className:"wp-block-sensei-lms-course-outline__placeholder__option__content__details",children:[(0,p.jsx)("li",{children:(0,i.__)("Add Lessons and Modules","sensei-lms")}),(0,p.jsx)("li",{children:(0,i.__)("Reorder and edit anytime","sensei-lms")})]}),(0,p.jsxs)("ul",{className:"wp-block-sensei-lms-course-outline__placeholder__option__content__lessons",children:[(0,p.jsx)("li",{children:(0,i.__)("Lesson 1","sensei-lms")}),(0,p.jsx)("li",{children:(0,i.__)("Lesson 2","sensei-lms")})]})]}),(0,p.jsx)("figcaption",{className:"wp-block-sensei-lms-course-outline__placeholder__option__caption",id:"generate-blank",children:(0,i.__)("Start with blank","sensei-lms")})]}),(0,p.jsxs)("button",{className:"wp-block-sensei-lms-course-outline__placeholder__option is-ai","aria-labelledby":"generate-with-ai",onClick:()=>{s()},children:[(0,p.jsxs)("div",{className:"wp-block-sensei-lms-course-outline__placeholder__option__content",children:[(0,p.jsxs)("div",{className:"wp-block-sensei-lms-course-outline__placeholder__option__content__intro",children:[(0,p.jsx)("p",{children:(0,i.__)("Get AI's help to start with a tailored course outline.","sensei-lms")}),(0/* ["default"] */,p.jsx)(r.A,{className:"wp-block-sensei-lms-course-outline__placeholder__option__content__intro__icon"})]}),(0,p.jsxs)("ul",{className:"wp-block-sensei-lms-course-outline__placeholder__option__content__details",children:[(0,p.jsxs)("li",{children:[(0/* ["default"] */,p.jsx)(c.A,{width:24,height:24}),(0,i.__)("AI tailored outline based on your content","sensei-lms")]}),(0,p.jsxs)("li",{children:[(0/* ["default"] */,p.jsx)(c.A,{width:24,height:24}),(0,i.__)("Access to all Sensei Pro features","sensei-lms")]})]}),(0/* ["default"] */,p.jsx)(a.A,{})]}),(0,p.jsxs)("figcaption",{className:"wp-block-sensei-lms-course-outline__placeholder__option__caption",id:"generate-with-ai",children:[(0,i.__)("Generate with AI","sensei-lms"),(0/* ["default"] */,p.jsx)(u.A,{})]})]})]})}),_=({addBlock:e,addBlocks:s,openTailoredModal:t})=>window.sensei.featureFlags.course_outline_ai?(0,p.jsx)(h,{addBlocks:s,openTailoredModal:t}):(0/* .DeprecatedPlaceholder */,p.jsx)(m.F,{addBlock:e})}
/***/,
/***/40362:
/***/(e,s,t)=>{"use strict";
/**
 * Copyright (c) 2013-present, Facebook, Inc.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */var n=t(56441);function o(){}function i(){}i.resetWarningCache=o,e.exports=function(){function e(e,s,t,o,i,l){if(l!==n){var r=new Error("Calling PropTypes validators directly is not supported by the `prop-types` package. Use PropTypes.checkPropTypes() to call them. Read more at http://fb.me/use-check-prop-types");throw r.name="Invariant Violation",r}}function s(){return e}e.isRequired=e;
// Important!
// Keep this list in sync with production version in `./factoryWithTypeCheckers.js`.
var t={array:e,bigint:e,bool:e,func:e,number:e,object:e,string:e,symbol:e,any:e,arrayOf:s,element:e,elementType:e,instanceOf:s,node:e,objectOf:s,oneOf:s,oneOfType:s,shape:s,exact:s,checkPropTypes:i,resetWarningCache:o};return t.PropTypes=t,t}}
/***/,
/***/40913:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>r
/* harmony export */});
/* harmony import */var n=t(56427),o=t(27723),i=t(86087),l=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Lessons actions.
 *
 * @param {Object}   props
 * @param {Object[]} props.selectedLessons        Selected lessons.
 * @param {Function} props.setSelectedLessons     Selected lessons state setter.
 * @param {Function} props.onAdd                  Callback to add existing lessons.
 * @param {Function} props.closeModal             Close the modal.
 * @param {Function} props.setErrorAddingSelected Set when there has been an error adding selection.
 */
const r=({selectedLessons:e,setSelectedLessons:s,onAdd:t,closeModal:r,setErrorAddingSelected:a})=>{const[c,u]=(0,i.useState)(!1),d=0===e.length?(0,o.__)("Add Selected","sensei-lms"):(0,o.sprintf)(/* translators: Number of selected lessons. */ /* translators: Number of selected lessons. */
(0,o.__)("Add Selected (%s)","sensei-lms"),e.length),m=c||0===e.length;
return(0,l.jsxs)("ul",{className:"sensei-lms-existing-lessons-modal__actions",children:[e.length>0&&(0,l.jsx)("li",{children:(0,l.jsx)(n.Button,{isTertiary:!0,onClick:()=>{s([])},children:(0,o.__)("Clear Selected","sensei-lms")})}),(0,l.jsx)("li",{children:(0,l.jsx)(n.Button,{disabled:m,onClick:()=>{u(!0),t(e).then(r).catch((()=>{a(!0),u(!1)}))},isPrimary:!0,children:d})})]})};
/* harmony default export */}
/***/,
/***/41544:
/***/e=>{"use strict";e.exports=JSON.parse('{"name":"sensei-lms/course-outline","title":"Course Outline","description":"Manage your Sensei LMS course outline.","category":"sensei-lms","textdomain":"sensei-lms","keywords":["course","lessons","modules","outline","structure"],"supports":{"html":false,"multiple":false,"defaultStylePicker":false},"attributes":{"id":{"type":"integer"},"collapsibleModules":{"type":"boolean","default":true},"moduleBorder":{"type":"boolean","default":true},"isPreview":{"type":"boolean"}}}')}
/***/,
/***/41546:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */H:()=>/* binding */l
/* harmony export */});
/* harmony import */var n=t(74997),o=t(47143),i=t(48558);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Insert or navigate to next sibling block on Enter. Remove current block on Backspace if empty.
 *
 * @param {Object}   props
 * @param {Function} props.insertBlocksAfter Callback to insert sibling block.
 * @param {string}   props.name              Current block name
 * @param {string}   props.clientId          Current block ID
 * @param {Object}   props.attributes        Current block attributes
 * @param {string}   props.attributes.title  Current block title
 * @return {{onKeyDown}} Keydown event handler
 */
const l=({insertBlocksAfter:e,name:s,clientId:t,attributes:{title:l}})=>{const{selectNextBlock:r,removeBlock:a}=(0,o.useDispatch)("core/block-editor");
/**
   * Insert a new block on enter, unless there is already an empty new block after this one.
   */return{onKeyDown:c=>{switch(c.keyCode){case i.ENTER:(()=>{const i=(0,o.select)("core/block-editor"),l=i.getBlock(i.getNextBlockClientId());!l||l.attributes.title?e([(0,n.createBlock)(s)]):r(t)})();break;case i.BACKSPACE:(e=>{0===l.length&&(e.preventDefault(),a(t))})(c)}}}};
/***/},
/***/42086:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>r
/* harmony export */});
/* harmony import */var n=t(94715),o=t(56427),i=t(27723),l=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Inspector controls for module block.
 *
 * @param {Object}   props
 * @param {boolean}  props.bordered      Whether the border is enabled
 * @param {Function} props.setBordered   Callback to enable the border.
 * @param {string}   props.customSlug    Custom slug for the module.
 * @param {Function} props.setCustomSlug Callback to set the custom slug.
 */
const r=({bordered:e,setBordered:s,customSlug:t,setCustomSlug:r})=>(0,l.jsxs)(n.InspectorControls,{children:[(0,l.jsx)(o.PanelBody,{title:(0,i.__)("Border settings","sensei-lms"),initialOpen:!1,children:(0,l.jsx)(o.ToggleControl,{checked:e,onChange:s,label:(0,i.__)("Border","sensei-lms"),help:(0,i.__)("Toggle to enable the border.","sensei-lms")})}),(0,l.jsx)(o.PanelBody,{title:(0,i.__)("Custom slug","sensei-lms"),initialOpen:t||!1,children:(0,l.jsx)(o.TextControl,{className:"wp-block-sensei-lms-course-outline-module__slug-input",placeholder:(0,i.__)("Optional, keep empty for default","sensei-lms"),value:t,onChange:r})})]})
/* harmony default export */}
/***/,
/***/43005:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */f:()=>/* binding */p
/* harmony export */});
/* harmony import */var n=t(4452),o=t.n(n),i=t(47143),l=t(94715),r=t(56427),a=t(27723),c=t(2883),u=t(77522),d=t(5705),m=t(62540);
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
 * Module status preview with setting control.
 *
 * @param {Object} props          Component props
 * @param {string} props.clientId The module block id.
 */
const p=({clientId:e})=>{const{setModuleStatus:s}=(0/* .COURSE_STATUS_STORE */,i.useDispatch)(d.l),t=(0,i.useSelect)((s=>s(d/* .COURSE_STATUS_STORE */.l).getModuleLessonCounts(e)),[e]);let n=c/* .Status */.n.IN_PROGRESS;0===t.completedLessonsCount?n=c/* .Status */.n.NOT_STARTED:t.totalLessonsCount===t.completedLessonsCount&&t.totalLessonsCount>0&&(n=c/* .Status */.n.COMPLETED);const p=t.totalLessonsCount>1?[c/* .Status */.n.NOT_STARTED,c/* .Status */.n.IN_PROGRESS,c/* .Status */.n.COMPLETED]:[c/* .Status */.n.NOT_STARTED,c/* .Status */.n.COMPLETED],h=c/* .Status */.n.NOT_STARTED!==n,_=(0,m.jsx)("div",{className:o()("wp-block-sensei-lms-course-outline-module__progress-indicator",n),children:(0,m.jsx)("span",{className:"wp-block-sensei-lms-course-outline-module__progress-indicator__text",children:u/* .StatusLabels */.O[n]})});
return(0,m.jsxs)(m.Fragment,{children:[h&&_,(0,m.jsx)(l.InspectorControls,{children:(0,m.jsx)(r.PanelBody,{title:(0,a.__)("Status","sensei-lms"),initialOpen:!1,children:(0/* .StatusControl */,m.jsx)(u.A,{options:p,status:n,disabled:0===t.totalLessonsCount,setStatus:t=>{s(e,t)}})})})]})};
/***/},
/***/43656:
/***/e=>{"use strict";e.exports=window.wp.editor}
/***/,
/***/44927:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */H:()=>/* binding */r
/* harmony export */});
/* harmony import */var n=t(47143),o=t(86087),i=t(32054),l=t(90551);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Use shared module style and module border settings.
 *
 * @param {Object}   props
 * @param {string}   props.clientId                Outline block Id.
 * @param {string}   props.className               Outline block classes.
 * @param {boolean}  props.isPreview               Skip if it's a block preview.
 * @param {Object}   props.attributes              Outline block attributes.
 * @param {boolean}  props.attributes.moduleBorder Shared module border setting.
 * @param {Function} props.setAttributes           Update outline block attributes.
 * @return {{moduleBorder, setModuleBorder}} Module border setting and setter.
 */
const r=({clientId:e,className:s,isPreview:t,attributes:{moduleBorder:r},setAttributes:a})=>{const c=(0,o.useRef)(null),u=(0,n.useSelect)((e=>e("core/blocks").getBlockStyles("sensei-lms/course-outline")),[]),{updateBlockAttributes:d}=(0,n.useDispatch)("core/block-editor"),m=(0,i/* .getActiveStyleClass */.K)(u,s);(0,o.useEffect)((()=>{if(!t&&m&&c.current!==m){if(!c.current)return void(c.current=m);c.current=m,(0,l/* .getCourseInnerBlocks */.aE)(e,"sensei-lms/course-outline-module").forEach((e=>(0,i/* .applyStyleClass */.Y)(e.clientId,m)))}}),[e,t,m,c]);return{moduleBorder:r,setModuleBorder:s=>{(0,l/* .getCourseInnerBlocks */.aE)(e,"sensei-lms/course-outline-module").forEach((e=>{d(e.clientId,{borderedSelected:s})})),a({moduleBorder:s})}}};
/***/},
/***/45793:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */z:()=>/* binding */h
/* harmony export */});
/* unused harmony export isLoadingStatus */
/* harmony import */var n=t(66087),o=t(47143),i=t(66161),l=t(27723),r=t(77505),a=t(34198);
/* harmony import */t(61912);
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
 * Extension statuses.
 */
const c={IN_PROGRESS:"in-progress",IN_QUEUE:"in-queue"},u={
/**
   * Sets the extensions list.
   *
   * @param {Array} extensionSlugs The extensions slugs array.
   */
setExtensions:e=>({type:"SET_EXTENSIONS",extensionSlugs:e}),
/**
   * Sets entities.
   *
   * @param {Object} entities Entities to set.
   */
setEntities:e=>({type:"SET_ENTITIES",entities:e}),
/**
   * Install extensions.
   *
   * @param {string} slug The extension slug to install.
   */
*installExtension(e){(0,a/* .logEvent */.$)("extensions_install",{slug:e}),yield u.runProcess({slugs:[e],actionType:"install"})},
/**
   * Updates the provided extensions.
   *
   * @param {string[]} slugs The extension slugs to update.
   */
*updateExtensions(e){e.map((e=>(0,a/* .logEvent */.$)("extensions_update",{slug:e}))),yield u.runProcess({slugs:e,actionType:"update"})},
/**
   * Run extension process (install or update).
   *
   * @param {Object}   process            The process.
   * @param {string[]} process.slugs      Extension slugs.
   * @param {string}   process.actionType Action type (`install` or `update`).
   */
*runProcess(e){const{slugs:s,actionType:t}=e;
// Add to process to queue and skip if a process is already running.
if((yield(0,o.select)(h).getExtensionsByStatus(c.IN_PROGRESS)).length>0)return void(yield u.addToQueue(e));let r,a,d;yield u.setExtensionsStatus(s,c.IN_PROGRESS),"update"===t?(r={plugins:s},a=(0,l.__)("Update completed successfully!","sensei-lms"),
// translators: Placeholder is the underlying error message.
d=(0,l.__)("There was an error while updating the plugin: %1$s","sensei-lms")):(r={plugin:s[0]},a=(0,l.__)("Installation completed successfully!","sensei-lms"),
// translators: Placeholder is the underlying error message.
d=(0,l.__)("There was an error while installing the plugin: %1$s","sensei-lms"));try{const e=yield(0,i.apiFetch)({path:`/sensei-internal/v1/sensei-extensions/${t}`,method:"POST",data:r});yield u.setError(null),yield u.setEntities({extensions:(0,n.keyBy)(e.completed,"product_slug")}),yield(0,o.dispatch)("core/notices").createNotice("success",a,{type:"snackbar"})}catch(e){yield u.setError((0,l.sprintf)(d,e.message))}finally{yield u.setExtensionsStatus(s,""),yield u.removeFromQueue(e);const t=yield(0,o.select)(h).getNextProcess();t&&(yield u.runProcess(t))}},
/**
   * Set extensions in progress.
   *
   * @param {string} slugs  Extensions in progress.
   * @param {string} status Status.
   */
setExtensionsStatus:(e,s)=>({type:"SET_EXTENSIONS_STATUS",slugs:e,status:s}),
/**
   * Set the extensions layout.
   *
   * @param {Array} layout Extensions layout.
   */
setLayout:(e=[])=>({type:"SET_LAYOUT",layout:e}),
/**
   * Add process (update/install) to queue.
   *
   * @param {Object}   process            The process.
   * @param {string}   process.actionType Action type.
   * @param {string[]} process.slugs      Extension slugs.
   */
*addToQueue(e){return yield u.setExtensionsStatus(e.slugs,c.IN_QUEUE),{type:"ADD_TO_QUEUE",process:e}},
/**
   * Add process (update/install) to queue.
   *
   * @param {Object}   process       The process.
   * @param {string}   process.type  Process type.
   * @param {string[]} process.slugs Extension slugs.
   */
removeFromQueue:e=>({type:"REMOVE_FROM_QUEUE",process:e}),
/**
   * Set the error message.
   *
   * @param {string} error The error.
   */
setError:e=>({type:"SET_ERROR",error:e})},d={getExtensions:({extensionSlugs:e,entities:s})=>e.map((e=>s.extensions[e])),getExtensionsByStatus:(e,s)=>d.getExtensions(e).filter((e=>s===e.status)),getSenseiProExtension:(0,o.createRegistrySelector)((e=>()=>e(h).getExtensions().find((e=>"sensei-pro"===e.product_slug)))),getEntities:({entities:e},s)=>e[s],getConnectionStatus:({connected:e})=>e,getNextProcess:({queue:e})=>e[0]||null,getError:({error:e})=>e},m={
/**
   * Loads the extensions during initialization.
   */
*getExtensions(){const e=yield(0,i.apiFetch)({path:"/sensei-internal/v1/sensei-extensions?type=plugin"});yield u.setEntities({extensions:(0,n.keyBy)(e.extensions,"product_slug")}),yield u.setExtensions(e.extensions.map((e=>e.product_slug)))}},p={SET_EXTENSIONS:({extensionSlugs:e},s)=>({...s,extensionSlugs:e}),SET_EXTENSIONS_STATUS:({slugs:e,status:s},t)=>({...t,entities:{...t.entities,extensions:Object.keys(t.entities.extensions).reduce(((n,o)=>({...n,[o]:{...t.entities.extensions[o],status:e.includes(o)?s:t.entities.extensions[o].status}})),{})}}),SET_CONNECTION_STATUS:({connected:e},s)=>({...s,connected:e}),SET_LAYOUT:({layout:e},s)=>({...s,layout:e}),SET_ENTITIES:({entities:e},s)=>({...s,entities:(0,n.merge)({},s.entities,e)}),ADD_TO_QUEUE:({process:e},s)=>({...s,queue:[...s.queue,e]}),REMOVE_FROM_QUEUE:({process:e},s)=>({...s,queue:s.queue.filter((s=>!(0,n.isEqual)(s,e)))}),SET_ERROR:({error:e},s)=>({...s,error:e}),DEFAULT:(e,s)=>s},h=(0,r/* .createStore */.y$)("sensei/extensions",{reducer:(0,r/* .createReducerFromActionMap */.$x)(p,{
/**
   * Extensions list. It is mapped with the entities and served through the selectors.
   */
extensionSlugs:[],
/**
   * Store entities to be used based on the entities key (it can be accessed directly,
   * or mapped based in a key list).
   */
entities:{extensions:{}},connected:!1,layout:[],queue:[],error:null}),actions:u,selectors:d,resolvers:m,controls:i.controls});
/**
 * Default store state.
 */}
/***/,
/***/46280:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */n:()=>/* binding */r
/* harmony export */});
/* harmony import */var n=t(74997),o=t(47143),i=t(86087),l=t(66087);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * External dependencies
 */
/**
 * Insert an empty inner block to the end of the block when it's selected.
 *
 * @param {Object}   opts
 * @param {string}   opts.name             Block to be inserted.
 * @param {boolean}  opts.selectFirstBlock Select inserted block if it's the first one.
 * @param {Object}   opts.attributes       Attributes of a new block.
 * @param {Function} opts.isEmptyBlock     Callback to check if block is empty.
 * @param {Object}   parentProps           Block properties.
 */
const r=({name:e,attributes:s={},selectFirstBlock:t=!1,isEmptyBlock:r},a)=>{const{clientId:c}=a,{__unstableMarkNextChangeAsNotPersistent:u=l.noop,insertBlock:d}=(0,o.useDispatch)("core/block-editor"),m=(0,o.useSelect)((e=>e("core/block-editor").getBlocks(c))),p=0===m.length,h=(0,i.useCallback)((()=>{const o=(0,n.createBlock)(e,s),i=p&&t;u(),d(o,void 0,c,i)}),[u,d,c,e,s,p,t]),_=m.length&&m[m.length-1],g=_&&r(_.attributes);
// console.log( 'dentro', useDispatch );
(0,i.useEffect)((()=>{g||h()}),[g,h])};
/***/},
/***/47056:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>r
/* harmony export */});
/* harmony import */var n=t(66087),o=t(74997),i=t(48597),l=t(62540);
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
const r=e=>{(0,o.updateCategory)("sensei-lms",{icon:(0/* ["default"] */,l.jsx)(i.A,{width:"20",height:"20"})}),e.forEach((e=>{let{metadata:s,name:t,...i}=e;s&&(
// Remove the overlapping metadata keys from the settings object to make localization work.
// This is needed because only the metadata object is localized, but the overlapping keys will be overwritten by the settings object and the localization is lost.
i=(0,n.omit)(i,Object.keys(s))),
// The metadata object should be used for the `block.json` strings to be localized.
// See https://github.com/Automattic/sensei/pull/5782 for more details.
// The metadata object should be used for the `block.json` strings to be localized.
// See https://github.com/Automattic/sensei/pull/5782 for more details.
(0,o.registerBlockType)(s||t,i)}))};
/* harmony default export */}
/***/,
/***/47143:
/***/e=>{"use strict";e.exports=window.wp.data}
/***/,
/***/47456:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>u
/* harmony export */});
/* harmony import */var n=t(94715),o=t(27723),i=t(73629),l=t(88451),r=t(92335),a=t(55434),c=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/* harmony default export */const u={...a,metadata:a,icon:i/* ["default"] */.A,example:{attributes:{title:(0,o.__)("Module","sensei-lms"),description:(0,o.__)("About Module","sensei-lms")},innerBlocks:[{name:"sensei-lms/course-outline-lesson",attributes:{title:(0,o.__)("Lesson","sensei-lms"),id:1,draft:!1,isExample:!0}}]},styles:[{name:"default",label:(0,o.__)("Filled","sensei-lms"),isDefault:!0},{name:"minimal",label:(0,o.__)("Minimal","sensei-lms")}],transforms:r/* ["default"] */.A,edit:l/* ["default"] */.A,save:()=>(0,c.jsx)(n.InnerBlocks.Content,{})};
/***/},
/***/48469:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>p
/* harmony export */,d:()=>/* binding */m
/* harmony export */});
/* harmony import */var n=t(56427),o=t(86087),i=t(47143),l=t(14309),r=t(43656),a=t(27723),c=t(73765),u=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
const d=e=>`post.php?post=${e}&action=edit`
/**
 * Link to edit the Lesson in a new tab.
 *
 * @param {Object} props          Component props.
 * @param {number} props.lessonId The lesson ID.
 * @param {Object} forwardedRef   The forwarded ref.
 */,m=(0,o.forwardRef)((({lessonId:e,...s},t)=>(0,u.jsx)("a",{ref:t,href:d(e),className:"wp-block-sensei-lms-course-outline-lesson__edit",...s,children:(0,a.__)("Edit lesson","sensei-lms")}))),p=({lessonId:e,lessonTitle:s})=>{
// Determine whether we are currently saving.
const{isSavingPost:t,isSavingMetaBoxes:o,isSavingStructure:d}=(0,i.useSelect)((e=>({isSavingPost:e(r.store).isSavingPost(),isSavingMetaBoxes:e(l.store).isSavingMetaBoxes(),isSavingStructure:e(c/* .COURSE_STORE */.u).getIsSavingStructure()}))),{savePost:p}=(0,i.useDispatch)(r.store);
// Function to trigger saving the post.
// If we don't have an ID or a title yet, don't render anything.
if(!e&&!s)return null;
// Component for the "Save and edit lesson" button.
const h=(0,u.jsx)(n.ToolbarItem,{as:n.Button,onClick:p,className:"wp-block-sensei-lms-course-outline-lesson__save",children:(0,a.__)("Save to edit lesson","sensei-lms")}),_=(0,u.jsx)(n.ToolbarItem,{as:n.Spinner});
// Spinner.
let g=h;return e?g=(0,u.jsx)(n.ToolbarItem,{as:m,lessonId:e}):(t||d||o)&&(g=_),(0,u.jsx)(n.ToolbarGroup,{className:"components-button",children:g})}}
/***/,
/***/48558:
/***/e=>{"use strict";e.exports=window.wp.keycodes}
/***/,
/***/48597:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>r
/* harmony export */});
/* harmony import */var n,o,i=t(51609);
/* harmony import */function l(){return l=Object.assign?Object.assign.bind():function(e){for(var s=1;s<arguments.length;s++){var t=arguments[s];for(var n in t)({}).hasOwnProperty.call(t,n)&&(e[n]=t[n])}return e},l.apply(null,arguments)}
/* harmony default export */const r=function(e){
return i.createElement("svg",l({viewBox:"0 0 24 24",fill:"none",xmlns:"http://www.w3.org/2000/svg"},e),n||(n=i.createElement("circle",{cx:12,cy:12,r:12,fill:"#43AF99"})),o||(o=i.createElement("path",{fillRule:"evenodd",clipRule:"evenodd",d:"M9.835 15.38c.3-.23.179-.474.6-.563-.02.194.146.391.251.563-.109-.367-.002-.536.08-.72.347-.785-.662-1.293-1.35-1.418.235-.164.399-.327.694-.355a2.377 2.377 0 0 0-1.058.23c-1.112.531-1.993-.523-1.41-1.48.31-.51.664-.519.982-.865.077.178.103.372.075.564a.919.919 0 0 0 .049-.664c-.104-.336-.4-.338-.456-.821-.012-.101-.105.056-.263-.077-.038-.032-.113-.09-.163-.064-.085.044-.18.008-.232.034-.083.041-.109-.045-.2.016-.16.107-.178-.013-.332.005-.193.023-.32.261-.43.144-.102-.108-.206.075-.28.075-.05 0-.311.317-.426.028-.086-.216-.28.206-.382.063-.033-.046-.123.108-.18-.044-.014-.035 0-.078-.108-.027-.215.099-.138-.06-.207-.144-.083-.103-.113-.103-.068-.27.036-.133-.019-.33.2-.364.055-.008.107-.005.184-.148.096-.18.231-.093.207-.175-.036-.119.143-.28.226-.355.11-.103.254-.252.306-.396a.63.63 0 0 1 .102-.141c.081-.084.105-.003.227-.045.088-.03.02.053.106-.07.028-.038.105-.001.19-.039.259-.112.283-.11.347-.371.012-.05.025-.088.08-.083.109.01.134-.052.2-.05.061.001.083-.03.115-.068.18-.216.277-.055.357-.072.06-.012.022-.142.184-.102.23.057.155-.05.303-.015.174.041.186.19.306.225.143.042.211.198.307.196.337-.005.235.23.448.323-.16-.161.012-.421-.352-.455-.08-.007-.11-.127-.23-.183-.146-.067-.13-.21-.394-.27.068-.04.089.005.13-.073.058-.11.09-.046.113-.113.02-.063.006-.099.165-.155.165-.06.325-.195.472-.188.13.006.185-.08.177-.19-.008-.112-.033-.267.222-.22.153.029.15.003.15-.1-.002-.102.04-.165.174-.16.098.002.194-.003.231-.117.03-.091.207-.114.302-.148.317-.114.361.05.447-.095.07-.117.196-.317.337-.175.028.029.054.05.15-.056.08-.088.27-.2.337-.048.027.06.086.121.138.044a.08.08 0 0 1 .053-.039c.05-.01.079-.024.104-.036.218-.101.314-.095.213.125-.142.316.792-.192.532.151-.095.126.538.197.63.254.05.032.048.059.144.077.271.05.267.026.284.243.007.098.107.043.107.168 0 .535.472.266.549.399.012.022.032.042.079.042.149 0 .157-.03.224.089.027.047.05.072.127.096.12.037.112.05.068.138-.054.104.03.102.138.112.1.01.148.062.216.138.11.122.284.156.43.227.084.04.002.14.143.243.104.077.156.066.016.165-.59.418.22.305.446.694.051.087.118.195.216.295.225.23.1.293.221.437.07.083.015.063.13.137.272.175-.105.292-.319.212-.097-.035-.166-.085-.147-.025.016.049-.01.083-.052.12-.125.112.123.068.181.06.181-.025.664-.076.66.093-.005.22.136.27.25.284.185.024.238.057.34.226.092.152.145.07.288.205.097.093.217.258.02.282-.047.005-.099 0-.12.017a.411.411 0 0 1-.14.066c-.295.09.14.136.246.113.093-.02.209-.05.3-.027.057.015.062.08.244.107.06.01.036.099.006.16-.104.214.191.1.16.263-.017.093.11.245-.067.248-.057.001-.117-.015-.115.034.004.105-.165-.03-.317.115-.056.054-.19.092-.272-.009-.032-.038-.07-.069-.218-.023-.144.046-.242.204-.306-.04-.017-.064-.05-.065-.142-.097-.125-.043-.114-.258-.297-.12a.24.24 0 0 1-.214.039c-.144-.037-.303.012-.317-.096-.021-.179-.191-.305-.377-.296-.147.008-.278.034-.355-.137.057.195.207.208.382.208.144 0 .23.075.255.225.045.265.204.099.406.223.1.06.17.159.21.273.042.118.37-.024.282.258-.037.122-.107.168-.242.266-.4.294-.5.004-.618.239-.062.121-.063.031-.196.09-.22.098-.36-.128-.522-.045-.182.094-.168-.08-.352.037-.152.097-.308-.074-.38.192-.063.227-.322.232-.44.11-.189-.194-.132.229-.362.054-.123-.091-.213.043-.392.045-.33.005-.489-.282-.65-.107-.192.206-.331-.032-.334-.242-.003-.216-.777-.144-1.185-.256-.225-.062-.932.013-.702-.35-.372.39.456.366.682.455.136.053.245.095.377.114.13.296.214.617.227 1.007.043-.214.053-.433.028-.649-.043-.383.242.19.276.272.184.45-.022 1.278-.488 1.526a2.957 2.957 0 0 0-.562-.99c.256.392.616 1.192.327 1.65a1.023 1.023 0 0 1-.55-.483c.077.333.413.702.818.58.707-.213.704.233 1.641.307.682.111 1.654 0 2.118.037.254.02 1.32.197 1.315.465-.02 1.105-.438 1.164-1.539 1.268-.64.06-1.134.085-1.823.11-1.54.058-3.391.06-4.868 0-.724-.03-1.072-.036-1.841-.137-.769-.1-1.19-.363-1.178-1.187.005-.304.905-.594 1.2-.628.347-.039.901.005 1.405-.116.527-.127.747-.21 1.135-.508Zm5.347-6.052c-.167-.042-.051-.138-.339-.014-.17.073-.194-.13-.365-.094-.172.036-.242-.125-.499-.166-.318-.05-.088-.133-.592-.032-.097.02-.179-.09-.481-.052-.355.046-.23.084-.445-.115-.272-.251-.488-.082-.767-.184.216.166.368.019.622.221-.242.138-.523.802-.962.844.478.107.709.354 1.148.413.504.068.882.118 1.151.531.301.463.44.196.874.168.275-.017.282-.185.328-.362.063-.245.126-.256.31-.289.213-.037.163-.092.107-.156-.15-.172.019-.207.146-.244.222-.064.042-.075.042-.166-.278-.09-.063-.217.092-.273.169.105.242.087.317.073.109-.021.181.03.273-.028-.135.014-.163-.037-.278-.02-.051.007-.112.01-.219-.054-.18-.107-.27.048-.463 0Zm-2.28 1.64-1.09-.545c-1.316-.657-1.915.313-2.337 1.376l-.766.73c.549-.338.996-.714 1.574-.71.092 0 1.516.484 1.286-.092-.04-.104.09-.052.125-.201.04-.17.055-.141.195-.033.089.069.211.113.174-.048-.017-.072-.04-.137.28-.004.15.062.095-.064.303-.09.29-.034.228-.31.364-.349.076-.022.152.058.295-.077.05-.046.11-.089.232-.057-.143-.073-.22-.014-.292.03-.146.089-.204-.037-.343.07Zm-2.23-1.923c.16-.02.32-.036.482-.046a.13.13 0 0 0 .074-.06.111.111 0 0 0 .007-.09.268.268 0 0 1 .147-.206l-.002-.003c-.258.001-.466.1-.73.211-.052.022-.024.111-.118.213a.26.26 0 0 1-.201.235.136.136 0 0 0-.09.046.113.113 0 0 0-.026.092.252.252 0 0 1-.277.061c-.2-.077-.35-.065-.448.036a.39.39 0 0 1 .398.014c.134.066.3.031.39-.082a.132.132 0 0 1 .126-.098.421.421 0 0 0 .268-.323Z",fill:"#fff"})))};
/***/},
/***/49723:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */v:()=>/* binding */l
/* harmony export */});
/* harmony import */var n=t(47143),o=t(86087),i=t(5705);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * A hook to update the status store when a lesson is removed.
 *
 * @param {string}  clientId  The outline block id.
 * @param {boolean} isPreview Whether the block is currently in preview mode.
 */
const l=function(e,s){const t=(0,n.useSelect)((s=>s("core/block-editor").getClientIdsOfDescendants([e])),[e]),{stopTrackingRemovedLessons:l}=(0/* .COURSE_STATUS_STORE */,n.useDispatch)(i.l);(0,o.useEffect)((()=>{s||l(t)}),[e,t,s,l])};
/***/},
/***/51609:
/***/e=>{"use strict";e.exports=window.React}
/***/,
/***/52619:
/***/e=>{"use strict";e.exports=window.wp.hooks}
/***/,
/***/55434:
/***/e=>{"use strict";e.exports=JSON.parse('{"name":"sensei-lms/course-outline-module","title":"Module","description":"Group related lessons together.","category":"sensei-lms","textdomain":"sensei-lms","keywords":["module","course module","group","lessons"],"parent":["sensei-lms/course-outline"],"supports":{"html":false},"attributes":{"id":{"type":"integer"},"title":{"type":"string","default":""},"description":{"type":"string","default":""},"teacher":{"type":"string","default":""},"teacherId":{"type":"string","default":""},"lastTitle":{"type":"string","default":""},"slug":{"type":"string","default":""},"mainColor":{"type":"string"},"customMainColor":{"type":"string"},"defaultMainColor":{"type":"string"},"textColor":{"type":"string"},"customTextColor":{"type":"string"},"defaultTextColor":{"type":"string"},"borderColor":{"type":"string"},"customBorderColor":{"type":"string"},"borderColorValue":{"type":"string"},"defaultBorderColor":{"type":"string"},"defaultBorderColorValue":{"type":"string"},"className":{"type":"string"},"customClassName":{"type":"string"},"borderedSelected":{"type":"boolean"}}}')}
/***/,
/***/56427:
/***/e=>{"use strict";e.exports=window.wp.components}
/***/,
/***/56441:
/***/e=>{"use strict";
/**
 * Copyright (c) 2013-present, Facebook, Inc.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */e.exports="SECRET_DO_NOT_PASS_THIS_OR_YOU_WILL_BE_FIRED"}
/***/,
/***/59870:
/***/e=>{"use strict";e.exports=JSON.parse('{"name":"sensei-lms/course-outline-lesson","title":"Lesson","description":"Where your course content lives.","category":"sensei-lms","textdomain":"sensei-lms","keywords":["course","lesson"],"parent":["sensei-lms/course-outline","sensei-lms/course-outline-module"],"attributes":{"id":{"type":"integer"},"title":{"type":"string","default":""},"initialContent":{"type":"string","default":""},"draft":{"type":"boolean","default":true},"backgroundColor":{"type":"string"},"customBackgroundColor":{"type":"string"},"textColor":{"type":"string"},"customTextColor":{"type":"string"},"fontSize":{"type":"number"},"isExample":{"type":"boolean","default":false},"placeholder":{"type":"string"}},"supports":{"html":false,"customClassName":true}}')}
/***/,
/***/60146:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>l
/* harmony export */});
/* harmony import */var n,o=t(51609);
/* harmony import */function i(){return i=Object.assign?Object.assign.bind():function(e){for(var s=1;s<arguments.length;s++){var t=arguments[s];for(var n in t)({}).hasOwnProperty.call(t,n)&&(e[n]=t[n])}return e},i.apply(null,arguments)}
/* harmony default export */const l=function(e){
return o.createElement("svg",i({width:24,height:24,fill:"none",xmlns:"http://www.w3.org/2000/svg"},e),n||(n=o.createElement("path",{fillRule:"evenodd",clipRule:"evenodd",d:"M19 4.5H5a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h14a.5.5 0 0 0 .5-.5V5a.5.5 0 0 0-.5-.5ZM5 3a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h4.511l-1.03 2.75H7a.75.75 0 0 0 0 1.5h10a.75.75 0 0 0 0-1.5h-1.48L14.489 16H19a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2H5Zm5 3.5 5 3-5 3v-6Zm3.918 12.25h-3.836l.938-2.5h1.96l.938 2.5Z",fill:"#1E1E1E"})))};
/***/},
/***/61912:
/***/(e,s,t)=>{"use strict";
/* unused harmony export preloadedDataUsedOnceMiddleware */
/* harmony import */var n=t(93832),o=t(1455);
/* harmony import */t.n(o)().use(
/**
 * WordPress dependencies
 */
/**
 * Use data preloaded with createPreloadingMiddleware only once.
 */
function(){const e={};return(s,t)=>("string"!=typeof s.path||"GET"!==s.method&&s.method||(e[s.path]?s.path=(0,n.addQueryArgs)(s.path,{__skip_preload:1}):e[s.path]=!0),t(s))}())}
/***/,
/***/62540:
/***/(e,s,t)=>{"use strict";e.exports=t(2192)}
/***/,
/***/62688:
/***/(e,s,t)=>{
// By explicitly using `prop-types` you are opting into new production behavior.
// http://fb.me/prop-types-in-prod
e.exports=t(40362)()}
/***/,
/***/63492:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */W:()=>/* binding */r
/* harmony export */});
/* harmony import */var n=t(66087),o=t(66161),i=t(47143),l=t(77505);
/* harmony import */t(61912);
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
 * Register structure store and subscribe to block editor save.
 *
 * @param {Object}   opts
 * @param {string}   opts.storeName          Name of store.
 * @param {Function} opts.getEndpoint        REST API endpoint.
 * @param {Function} opts.saveError          Handler for displaying save errors.
 * @param {Function} opts.fetchError         Handler for displaying fetch errors.
 * @param {Function} opts.clearError         Handler for clearing errors.
 * @param {Function} opts.updateBlock        Update block with given structure.
 * @param {Function} opts.blockExists        Check if block exists.
 * @param {Function} opts.readBlock          Extract structure from block.
 * @param {Function} opts.setServerStructure Set the server structure which is used to track differences.
 * @param {Object}   opts.registry           Data registry.
 */
function r({storeName:e,getEndpoint:s,saveError:t,fetchError:r,clearError:a,updateBlock:c,blockExists:u,readBlock:d,setServerStructure:m,registry:p,...h}){const _=p?p.dispatch:i.dispatch,g=p?p.select:i.select,f=p?p.subscribe:i.subscribe,v={
/**
     * Fetch structure data from REST API.
     */
*loadStructure(){try{const e=yield*s(),t=yield(0,o.apiFetch)({path:`/sensei-internal/v1/${e}`,method:"GET"});yield v.setResult(t)}catch(e){yield r?.(e)}},
/**
     * Persist editor's structure to the REST API.
     */
*saveStructure(){const n=yield g(e).getEditorStructure();try{const e=yield*s(),t=yield(0,o.apiFetch)({path:`/sensei-internal/v1/${e}`,method:"POST",data:n});yield v.setResult(t)}catch(e){yield t?.(e)}},
/**
     * Set fetched structure.
     *
     * @param {Array} serverStructure
     */
*setResult(e){yield v.setServerStructure(e),yield c(e)},
/**
     * Keep last fetched server state for comparison.
     *
     * @param {Array} serverStructure
     */
setServerStructure:e=>({type:"SET_SERVER_STRUCTURE",serverStructure:e}),
/**
     * Keep last editor state.
     *
     * @param {Array} editorStructure
     */
setEditorStructure:e=>({type:"SET_EDITOR_STRUCTURE",editorStructure:e}),
/**
     * Initiate saving the post.
     */
*savePost(){yield{type:"SAVE_POST"},yield _("core/editor").savePost()},
/**
     * Post is saving. Save the structure too if it has changed.
     */
*startPostSave(){yield{type:"START_SAVE"};const s=d();yield v.setEditorStructure(s),yield a?.(),s&&(g(e).hasUnsavedEditorChanges()&&(yield*v.saveStructure()),yield{type:"FINISH_SAVE"})},
/**
     * Finished saving post and structure.
     * Check if either needs to be saved again due to new changes.
     */
*finishPostSave(){yield{type:"FINISH_POST_SAVE"};const{hasUnsavedServerUpdates:s}=g(e);s()&&(yield*v.savePost())},
/**
     * Set linked block.
     *
     * @param {string} clientId Block ID.
     */
*setBlock(e){yield{type:"SET_BLOCK",clientId:e}}},y={SET_SERVER_STRUCTURE:({serverStructure:e},s)=>{const t=!s.editorStructure,o=m?m(e):e,i=!t&&!(0,n.isEqual)(o,s.editorStructure);return{...s,serverStructure:o,hasUnsavedServerUpdates:i,hasUnsavedEditorChanges:!1}},SET_EDITOR_STRUCTURE:({editorStructure:e},s)=>{const t=!(0,n.isEqual)(s.serverStructure,e);return{...s,editorStructure:e,hasUnsavedEditorChanges:t&&!!e}},START_SAVE:(e,s)=>({...s,isSavingStructure:!0}),FINISH_SAVE:(e,s)=>({...s,isSavingStructure:!1}),SAVE_POST:(e,s)=>({...s,hasUnsavedServerUpdates:!1}),SET_BLOCK:({clientId:e},s)=>({...s,clientId:e}),DEFAULT:(e,s)=>s},b=p?p.registerStore:i.registerStore;return{unsubscribe:(()=>{let s=!1,t=!1,n=!1;return f((function(){const o=g("core/editor"),i=g("core/edit-post");if(!o||!i)return;
// Check if the block exists.
if(!u())return;const l=g(e).getIsSavingStructure(),r=o.isSavingPost()&&!o.isAutosavingPost();r&&(t=!0);const a=i.isSavingMetaBoxes();a&&(n=!0),s||r||a||!t||!n?s&&!l&&(
// Call finishPostSave when structure has finished saving.
s=!1,_(e).finishPostSave()):(
// Start saving structure when post has finished saving.
s=!0,t=!1,n=!1,_(e).startPostSave())}))})(),store:b(e,{reducer:(0,l/* .createReducerFromActionMap */.$x)({...y,...h?.reducers},{serverStructure:null,editorStructure:null,isSavingStructure:!1,hasUnsavedServerUpdates:!1,hasUnsavedEditorChanges:!1,clientId:null}),actions:{...v,...h?.actions},selectors:{hasUnsavedServerUpdates:({hasUnsavedServerUpdates:e})=>e,hasUnsavedEditorChanges:({hasUnsavedEditorChanges:e})=>e,getIsSavingStructure:({isSavingStructure:e})=>e,getServerStructure:({serverStructure:e})=>e,getEditorStructure:({editorStructure:e})=>e,getBlock:({clientId:e})=>e,...h?.selectors},controls:{...o.controls,...h?.controls}})}}
/***/},
/***/66087:
/***/e=>{"use strict";e.exports=window.lodash}
/***/,
/***/66161:
/***/e=>{"use strict";e.exports=window.wp.dataControls}
/***/,
/***/69885:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>S
/* harmony export */,N:()=>/* binding */b
/* harmony export */});
/* harmony import */var n=t(94715),o=t(29491),i=t(47143),l=t(86087),r=t(92856),a=t(29281),c=t(49723),u=t(73765),d=t(91701),m=t(82414),p=t(96562),h=t(37e3),_=t(19235),g=t(52619),f=t(96516),v=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
const y=["sensei-lms/course-outline-module","sensei-lms/course-outline-lesson"],b=(0,l.createContext)(),S=(0,o.compose)((0,a/* .withDefaultBlockStyle */.Sw)())((e=>{const{clientId:s,className:t,attributes:o,setAttributes:a}=e,{loadStructure:S}=(0/* .COURSE_STORE */,i.useDispatch)(u.u),{isActivated:x}=(0,_/* ["default"] */.A)(),w=(0,g.applyFilters)("senseiCourseOutlineGeneratorUpsellRemove",x);(0,l.useEffect)((()=>{o.isPreview||S()}),[o.isPreview,S]);const{setBlocks:E}=(0,d/* .useBlocksCreator */.k)(s),{isEmpty:k}=(0,i.useSelect)((e=>({isEmpty:!e(n.store).getBlocks(s).length})),[s]);(0,c/* .useCourseLessonsStatusSync */.v)(s,o.isPreview);const[C,j]=(0,l.useState)(!1),T=(0,l.useCallback)((()=>(0/* ["default"] */,v.jsx)(m.A,{clientId:s,openModal:()=>j(!0)})),[s]),A=(0,l.useCallback)((()=>{w?window.location.hash="generate-course-outline-using-ai":window.location.href=(0,f/* .getSenseiProUpsellUrl */.h)("outline_edit")}),[w]);
return(0,v.jsxs)("div",{children:[k?(0/* ["default"] */,v.jsx)(h.A,{addBlock:e=>E([{type:e}],!0),addBlocks:E,openTailoredModal:A}):(0,v.jsxs)(b.Provider,{value:{outlineAttributes:o,outlineSetAttributes:a,outlineClassName:t},children:[(0/* ["default"] */,v.jsx)(r.A,{...e}),(0,v.jsx)("section",{className:t,children:(0,v.jsx)(n.InnerBlocks,{allowedBlocks:y,renderAppender:T})})]}),C&&(0/* ["default"] */,v.jsx)(p.A,{clientId:s,onClose:()=>j(!1)})]})}));
/**
 * A React context which contains the attributes and the setAttributes callback of the Outline block.
 */}
/***/,
/***/71437:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */V:()=>/* binding */i
/* harmony export */});
/* unused harmony export findLessonBlock */
/* harmony import */var n=t(74997),o=t(47143);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Lesson type definition.
 *
 * @typedef {Object} Lesson
 * @property {number} id    Lesson ID.
 * @property {string} title Lesson title
 */
/**
 * Find a lesson block based on lesson ID, or title if ID is missing.
 *
 * @param {Array}  blocks
 * @param {Lesson} item
 */
const i=e=>{const s=(0,o.useSelect)((()=>(0,o.select)("core/block-editor").getBlocks(e)),[]),{insertBlock:t}=(0,o.useDispatch)("core/block-editor"),i=(0,o.useSelect)((()=>(0,o.select)("core/block-editor").getBlockCount(e)),[]);return o=>{if(0===o.filter((e=>0===s.length||!((e,{id:s,title:t})=>e.find((({attributes:e})=>s===e.id||!e.id&&e.title&&e.title===t)))(s,{id:e.id}))).length)return Promise.resolve({});
// Put this before the auto-block.
let l=i;return o.forEach((s=>{t((0,n.createBlock)("sensei-lms/course-outline-lesson",{id:s.id,type:"lesson",title:s.title.raw,draft:"draft"===s.post_status}),l,e,!1),l++})),Promise.resolve({})}};
/**
 * Add existing lessons to the course outline block.
 *
 * @param {string} clientId The quiz block client id.
 * @return {Function} Function that takes an array of lesson IDs and returns a Promise.
 */}
/***/,
/***/72108:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>r
/* harmony export */});
/* harmony import */var n=t(4452),o=t.n(n),i=t(56427),l=t(62540);
/* harmony import */
/**
 * External dependencies
 */
/**
 * WordPress dependencies
 */
/**
 * Input control component.
 *
 * It can use or be replaced by the
 * WordPress [InputControl]{@link https://github.com/WordPress/gutenberg/tree/trunk/packages/components/src/input-control} when it's stable.
 *
 * @param {Object}   props             Component props.
 * @param {string}   [props.className] Additional classnames for the input.
 * @param {string}   [props.id]        Component id used to connect label and input - required if label is set.
 * @param {string}   [props.label]     Input label.
 * @param {number}   [props.value]     Input value.
 * @param {string}   [props.help]      Help text.
 * @param {string}   [props.iconRight] Icon right.
 * @param {Function} [props.onChange]  Change function.
 */
const r=({className:e,id:s,label:t,value:n,help:r,iconRight:a,onChange:c,...u})=>(0,l.jsx)(i.BaseControl,{id:s,label:t,help:r,children:(0,l.jsxs)("div",{className:"sensei-input-control",children:[(0,l.jsx)("input",{className:o()("sensei-input-control__input",{"sensei-input-control__input--with-icon-right":a},e),type:"text",id:s,value:null===n?"":n,onChange:e=>c(e.target.value),...u}),a&&(0,l.jsx)("span",{className:"sensei-input-control__icon",children:(0,l.jsx)(i.Icon,{icon:a})})]})})
/* harmony default export */}
/***/,
/***/73629:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>r
/* harmony export */});
/* harmony import */var n,o,i=t(51609);
/* harmony import */function l(){return l=Object.assign?Object.assign.bind():function(e){for(var s=1;s<arguments.length;s++){var t=arguments[s];for(var n in t)({}).hasOwnProperty.call(t,n)&&(e[n]=t[n])}return e},l.apply(null,arguments)}
/* harmony default export */const r=function(e){
return i.createElement("svg",l({viewBox:"0 0 24 24",xmlns:"http://www.w3.org/2000/svg"},e),n||(n=i.createElement("path",{fillRule:"evenodd",clipRule:"evenodd",d:"M18.5 5.5v9h-13v-9h13zM20 16H4V4h16v12z"})),o||(o=i.createElement("path",{fillRule:"evenodd",clipRule:"evenodd",d:"M9 12h6V8H9v4zm-3 8h2.222L11 16H8.778L6 20zm12 0h-2.222L13 16h2.222L18 20z"})))};
/***/},
/***/73765:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */u:()=>/* binding */a
/* harmony export */});
/* harmony import */var n=t(47143),o=t(27723),i=t(63492),l=t(90551);
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
const r=()=>(0,l/* .getFirstBlockByName */.w)("sensei-lms/course-outline",(0,n.select)("core/block-editor").getBlocks()),a="sensei/course-structure";(0,i/* .registerStructureStore */.W)({storeName:a,*getEndpoint(){return`course-structure/${yield(0,n.select)("core/editor").getCurrentPostId()}?context=edit`},*updateBlock(e){const{clientId:s=null}=r();if(!s||!e||0===e.length)return;const t=yield(0,n.select)("core/block-editor").getBlocks(s);yield(0,n.dispatch)("core/block-editor").replaceInnerBlocks(s,(0,l/* .syncStructureToBlocks */.eE)(e,t),!1)},blockExists:()=>!!r(),readBlock:()=>{const e=r();return e?{structure:(0,l/* .extractStructure */.xn)(e.innerBlocks)}:null},*saveError(e){const s=(0,o.sprintf)(/* translators: Error message. */ /* translators: Error message. */
(0,o.__)("Course modules and lessons could not be updated. %s","sensei-lms"),e.message);yield(0,n.dispatch)("core/notices").createErrorNotice(s,{id:"course-outline-save-error"})},clearError(){
// Clear error notices.
// Clear error notices.
(0,n.dispatch)("core/notices").removeNotice("course-outline-save-error")},
/**
   * Prepend structure in server's response.
   *
   * @param {Object} structure The structure response.
   *
   * @return {Object} The modified response.
   */
setServerStructure:e=>e?{structure:e}:{}})}
/***/,
/***/74997:
/***/e=>{"use strict";e.exports=window.wp.blocks}
/***/,
/***/77505:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */$x:()=>/* binding */i
/* harmony export */,y$:()=>/* binding */l
/* harmony export */});
/* unused harmony export composeFetchAction */
/* harmony import */var n=t(47143);
/* harmony import */
/**
 * WordPress dependencies
 */
// We register the store in the global scope to avoid registering it multiple times.
// The reason to be in the global scope is that some times we have different built files using the same source.
window.senseiStores=window.senseiStores||[];const{senseiStores:o}=window,i=(e,s)=>(t=s,n)=>(e[n.type]||e.DEFAULT)(n,t),l=(e,s)=>{if(o[e])return o[e];const t=(0,n.createReduxStore)(e,s);return(0,n.register)(t),o[e]=t,t};
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
/***/77522:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>/* binding */a
/* harmony export */,O:()=>/* binding */r
/* harmony export */});
/* harmony import */var n=t(56427),o=t(27723),i=t(2883),l=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Labels for each of the statuses.
 */
const r={[i/* .Status */.n.NOT_STARTED]:(0,o.__)("Not Started","sensei-lms"),[i/* .Status */.n.IN_PROGRESS]:(0,o.__)("In Progress","sensei-lms"),[i/* .Status */.n.COMPLETED]:(0,o.__)("Completed","sensei-lms")},a=({options:e=[i/* .Status */.n.IN_PROGRESS,i/* .Status */.n.COMPLETED],status:s,setStatus:t,disabled:a,...c})=>{const u=e.map((e=>({label:r[e],value:e})));let d=(0,l.jsx)(n.RadioControl,{className:"wp-block-sensei-lms-course-outline-status-control",help:(0,o.__)("Preview a status. The actual status that the student sees is determined by their progress in the course.","sensei-lms"),...c,options:u,selected:s,onChange:e=>t(e)});return a&&(d=(0,l.jsx)(n.Disabled,{children:d})),d};
/**
 * A component which controls the status preview for a block. It contains a group of buttons and a description.
 *
 * @param {Object}   props           Component props. Extras will be handed through to the `SelectControl` component.
 * @param {Array}    props.options   The ordered Status constants to include.
 * @param {string}   props.status    The index of the current status.
 * @param {Function} props.setStatus A callback which is called with the index when a status is selected.
 * @param {boolean}  props.disabled  Flag which disables the controls.
 */}
/***/,
/***/77549:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */t:()=>/* binding */a
/* harmony export */});
/* unused harmony export getProbeStyles */
/* harmony import */var n=t(66087),o=t(86087),i=t(47143),l=t(83157);
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
const{getComputedStyle:r}=window,a=()=>{const e=(0,i.useSelect)((e=>e("core/editor").getEditorSettings().colors),[]),[s,t]=(0,o.useState)({});return(0,o.useEffect)((()=>{const s=c(),o={},i=(0,n.mapValues)((0,n.keyBy)(e,(e=>(0,l/* .hexToRGB */.i)(e.color))),"slug");Object.entries(s).forEach((([e,s])=>{const t=i[(0,l/* .hexToRGB */.i)(s)];t&&(o[e]={slug:t,color:s})})),t(o)}),[e]),s},c=(0,n.memoize)((()=>{
// Create temporary probe elements.
const e=document.createElement("div");e.className="editor-styles-wrapper sensei-probe-element";const s=document.createElement("div");s.className="wp-block-button";const t=document.createElement("div");t.className="wp-block-button__link",t.textContent="Probe",
// Set probe position outside the screen to be hidden.
e.style.position="fixed",e.style.top="-100vh",
// Add probe to the screen.
s.appendChild(t),e.appendChild(s),document.body.appendChild(e);
// Save styles.
const n={primaryColor:r(t).backgroundColor,primaryContrastColor:r(t).color};
// Remove probe.
return document.body.removeChild(e),n}));
/**
 * Get color object by probe.
 *
 * @return {Object} Object containing the color objects, where the key is the probe key.
 */}
/***/,
/***/82414:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>d
/* harmony export */});
/* harmony import */var n=t(74997),o=t(47143),i=t(86087),l=t(27723),r=t(94077),a=t(73629),c=t(31702),u=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Outline block appender for adding a lesson or a module.
 *
 * @param {Object}   props
 * @param {string}   props.clientId  Outline block ID.
 * @param {Function} props.openModal Open modal callback.
 */
const d=({clientId:e,openModal:s})=>{const{insertBlock:t,selectBlock:d}=(0,o.useDispatch)("core/block-editor"),m=(0,o.useSelect)((s=>s("core/block-editor").getBlockCount(e)),[]),p=(0,i.useCallback)(((s,o={})=>{const i=(0,n.createBlock)(s,o);t(i,m,e,!0).then((()=>d(i.clientId)))}),[t,d,m,e]),h=[{title:(0,l.__)("Lesson","sensei-lms"),icon:r/* ["default"] */.A,onClick:()=>p("sensei-lms/course-outline-lesson",{placeholder:(0,l.__)("Lesson name","sensei-lms")})},{title:(0,l.__)("Existing Lesson(s)","sensei-lms"),icon:r/* ["default"] */.A,onClick:s},{title:(0,l.__)("Module","sensei-lms"),icon:a/* ["default"] */.A,onClick:()=>p("sensei-lms/course-outline-module")}],_=(0,l.__)("Add Module or Lesson","sensei-lms");
return(0/* ["default"] */,u.jsx)(c.A,{controls:h,text:_,label:_})};
/* harmony default export */}
/***/,
/***/83157:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */i:()=>/* binding */n
/* harmony export */});
/**
 * Converts css color hex to rgb.
 *
 * @param {string} h The hex color string.
 *
 * @return {string} The rgb value.
 */
const n=e=>{
// Returns if it's not an hexadecimal.
if(!e||null===e.match("#"))return e;let s=0,t=0,n=0;const o=4===e.length?`#${e[1]+e[1]+e[2]+e[2]+e[3]+e[3]}`:e;return 7===o.length&&(s=parseInt(o.substr(1,2),16)||0,t=parseInt(o.substr(3,2),16)||0,n=parseInt(o.substr(5,2),16)||0),`rgb(${s}, ${t}, ${n})`};
/***/},
/***/86087:
/***/e=>{"use strict";e.exports=window.wp.element}
/***/,
/***/88451:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>x
/* harmony export */});
/* unused harmony export ModuleEdit */
/* harmony import */var n=t(4452),o=t.n(n),i=t(91038),l=t(94715),r=t(12417),a=t(12035),c=t(29491),u=t(86087),d=t(47143),m=t(27723),p=t(18537),h=t(29281),_=t(46280),g=t(69885),f=t(29165),v=t(43005),y=t(42086),b=t(62540);
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
const S=["sensei-lms/course-outline-lesson"],x=(0,c.compose)((0,h/* .withColorSettings */.rt)({mainColor:{style:"background-color",label:(0,m.__)("Main color","sensei-lms")},textColor:{style:"color",label:(0,m.__)("Text color","sensei-lms")},borderColor:{style:"border-color",label:(0,m.__)("Border color","sensei-lms"),onChange:({clientId:e,colorValue:s})=>(0,d.dispatch)("core/block-editor").updateBlockAttributes(e,{borderColorValue:s})}}),(0,h/* .withDefaultColor */.Lt)({defaultMainColor:{style:"background-color",probeKey:"primaryColor"},defaultTextColor:{style:"color",probeKey:"primaryContrastColor"},defaultBorderColor:{style:"border-color",probeKey:"primaryColor"}}))((e=>{const{clientId:s,className:t,attributes:{title:n,description:c,borderedSelected:d,borderColorValue:h,teacher:x,slug:w},mainColor:E,defaultMainColor:k,textColor:C,defaultTextColor:j,defaultBorderColor:T,setAttributes:A}=e,{outlineAttributes:{collapsibleModules:N,moduleBorder:O},outlineClassName:L}=(0/* .OutlineAttributesContext */,u.useContext)(g.N)||{outlineAttributes:{},outlineClassName:""};(0,_/* .useAutoInserter */.n)({name:"sensei-lms/course-outline-lesson",isEmptyBlock:e=>!e.title},e);
/**
   * Handle update name.
   *
   * @param {string} value Name value.
   */
const[B,I]=(0,u.useState)(!0),P=/is-style-(\w+)/,R=t.match(P)?.[1]||L.match(P)?.[1],M={default:{background:E?.color||k?.color,color:C?.color||j?.color},minimal:{color:C?.color}}[R];
/**
   * Handle update name.
   *
   * @param {string} value Name value.
   */
// Minimal border element.
let D;"minimal"===R&&(D=(0,b.jsx)("div",{className:"wp-block-sensei-lms-course-outline-module__name__minimal-border",style:{background:E?.color||k?.color}})),(0,u.useEffect)((()=>{const e=document.querySelector('select[name="sensei-course-teacher-author"]');e&&e.addEventListener("change",(e=>{A({teacherId:e.target.value})}))}),
// eslint-disable-next-line react-hooks/exhaustive-deps
[]);const U=void 0!==d?d:O;
return(0,b.jsxs)(b.Fragment,{children:[(0/* ["default"] */,b.jsx)(y.A,{bordered:U,setBordered:e=>A({borderedSelected:e}),customSlug:w,setCustomSlug:e=>{A({slug:e})}}),(0,b.jsxs)("section",{className:o()(t,{"wp-block-sensei-lms-course-outline-module-bordered":U}),style:{borderColor:h||T?.color},children:[(0,b.jsxs)("header",{className:"wp-block-sensei-lms-course-outline-module__header",style:M,children:[(0,b.jsxs)("h2",{className:"wp-block-sensei-lms-course-outline-module__title",children:[(0/* ["default"] */,b.jsx)(f.A,{className:"wp-block-sensei-lms-course-outline-module__title-input",placeholder:(0,m.__)("Module name","sensei-lms"),value:(0,p.decodeEntities)(n),onChange:e=>{A({title:e})}}),w&&(0,b.jsxs)(b.Fragment,{children:[(0,b.jsx)("br",{}),(0,b.jsxs)("span",{className:"custom-slug",children:["(",w,")"]})]})]}),x&&(0,b.jsxs)("span",{className:"teacher-name",children:["(",x,")"]}),(0/* .ModuleStatus */,b.jsx)(v.f,{clientId:s}),N&&(0,b.jsxs)("button",{type:"button",className:o()("wp-block-sensei-lms-course-outline__arrow",{"sensei-collapsed":!B}),onClick:()=>I(!B),children:[(0/* ["default"] */,b.jsx)(r.A,{icon:a/* ["default"] */.A}),(0,b.jsx)("span",{className:"screen-reader-text",children:(0,m.__)("Toggle module content","sensei-lms")})]})]}),D,(0/* ["default"] */,b.jsxs)(i.A,{className:"wp-block-sensei-lms-collapsible",duration:500,animateOpacity:!0,height:!N||B?"auto":0,children:[(0,b.jsx)("div",{className:"wp-block-sensei-lms-course-outline-module__description",children:(0,b.jsx)(l.RichText,{className:"wp-block-sensei-lms-course-outline-module__description-input",placeholder:(0,m.__)("Module description","sensei-lms"),value:c,onChange:e=>{A({description:e})}})}),(0,b.jsx)("h3",{className:"wp-block-sensei-lms-course-outline-module__lessons-title",children:(0,m.__)("Lessons","sensei-lms")}),(0,b.jsx)(l.InnerBlocks,{allowedBlocks:S,templateInsertUpdatesSelection:!1,renderAppender:()=>null})]})]})]})}));
/**
 * Edit module block component.
 *
 * @param {Object}   props                             Component props.
 * @param {string}   props.clientId                    The module block id.
 * @param {string}   props.className                   Custom class name.
 * @param {Object}   props.attributes                  Block attributes.
 * @param {string}   props.attributes.title            Module title.
 * @param {string}   props.attributes.description      Module description.
 * @param {boolean}  props.attributes.borderedSelected The border setting selected by the user.
 * @param {string}   props.attributes.borderColorValue The border color.
 * @param {Object}   props.mainColor                   Header main color.
 * @param {Object}   props.defaultMainColor            Default main color.
 * @param {Object}   props.textColor                   Header text color.
 * @param {Object}   props.defaultTextColor            Default text color.
 * @param {Object}   props.defaultBorderColor          Default border color.
 * @param {Function} props.setAttributes               Block set attributes function.
 * @param {string}   props.name                        Name of the block.
 */}
/***/,
/***/89120:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */y:()=>/* binding */l
/* harmony export */});
/* harmony import */var n=t(47143),o=t(86087),i=t(5705);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Get or set the lesson's preview status.
 *
 * @param {Object}  props
 * @param {Object}  props.attributes           Block attributes
 * @param {boolean} props.attributes.isExample Ignore for example blocks
 * @param {string}  props.attributes.title     Block title
 * @param {string}  props.clientId             Block ID
 * @return {{setPreviewStatus: Function, previewStatus: string}} Preview status and control function.
 */
const l=({attributes:{isExample:e,title:s},clientId:t})=>{const{setLessonStatus:l,trackLesson:r,ignoreLesson:a}=(0/* .COURSE_STATUS_STORE */,n.useDispatch)(i.l);
// If the lesson has a title and it isn't an example, add it to the tracked lessons in the status store.
(0,o.useEffect)((()=>{e||(s.length>0?r(t):a(t))}),[t,r,a,s,e]);return{setPreviewStatus:e=>l(t,e),previewStatus:(0,n.useSelect)((e=>e(i/* .COURSE_STATUS_STORE */.l).getLessonStatus(t)),[t])}};
/***/},
/***/90551:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */aE:()=>/* binding */p
/* harmony export */,eE:()=>/* binding */a
/* harmony export */,w:()=>/* binding */m
/* harmony export */,xn:()=>/* binding */d
/* harmony export */});
/* unused harmony exports blockNames, blockTypes */
/* harmony import */var n=t(74997),o=t(47143),i=t(66087);
/* harmony import */
/**
 * External dependencies
 */
/**
 * WordPress dependencies
 */
/**
 * Course structure data.
 *
 * @global
 * @typedef {Array.<(CourseLessonData|CourseModuleData)>} CourseStructure
 */
/**
 * @typedef CourseModuleData
 * @param {string}             type        Block type ('module')
 * @param {string?}            title       Module title
 * @param {number?}            id          Module ID
 * @param {string?}            description Module description
 * @param {CourseLessonData[]} lessons     Module lessons
 */
/**
 * @typedef CourseLessonData
 * @param {string}  type           Block type ('lesson')
 * @param {string?} title          Lesson title
 * @param {number?} id             Lesson ID
 * @param {string?} initialContent Initial lesson content.
 */
const l={module:"sensei-lms/course-outline-module",lesson:"sensei-lms/course-outline-lesson"},r=(0,i.invert)(l),a=(e,s)=>(e||[]).map((e=>{let{type:t,lessons:o,...i}=e,r=u(s,e);return e.id&&(i={...i}),r?r.attributes={...r.attributes,...i}:r=(0,n.createBlock)(l[t],i),"module"===t&&(r.innerBlocks=a(o,r.innerBlocks)),r})),c=(0,i.curry)(((e,s)=>{const{name:t,attributes:n}=s,o=Object.keys(r).includes(t),i="module"===e.type;return!!o&&(i?[e.title,e.lastTitle].includes(n.title):n.id?e.id===n.id:void 0)})),u=(e,s)=>{const t=e.find(c(s));return t||"lesson"!==s.type?t:((e,s)=>e.reduce(((e,t)=>e||t.innerBlocks.find(s)),!1))
/**
 * Find the block for a given lesson/module item.
 *
 * @param {Object[]}                                    blocks     Block.
 * @param {Array.<(CourseLessonData|CourseModuleData)>} courseData Course item.
 * @return {Object} The block, if found.
 */(e,c(s))},d=e=>{const s={module:e=>({description:e.attributes.description,lessons:d(e.innerBlocks),teacher:e.attributes.teacher,teacherId:e.attributes.teacherId,lastTitle:e.attributes.lastTitle,slug:e.attributes.slug}),lesson:e=>({draft:e.attributes.draft,preview:e.attributes.preview,initialContent:e.attributes.initialContent})};return e.map((e=>{const t=r[e.name];return{type:t,id:e.attributes.id,title:e.attributes.title,...s[t](e)}})).filter((e=>"module"===e.type||!!e.title))},m=(e,s)=>{for(let t=0;t<s.length;t++){const n=s[t];if(e===n.name)return n;if(n.innerBlocks&&n.innerBlocks.length>0){const s=m(e,n.innerBlocks);if(s)return s}}return!1},p=(e,s)=>{let t=(0,o.select)("core/block-editor").getBlocks(e);return t=t.reduce(((e,s)=>[...e,...s.innerBlocks]),t),t.filter((({name:e})=>s===e))}}
/***/,
/***/91038:
/***/(e,s,t)=>{"use strict";var n="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},o=Object.assign||function(e){for(var s=1;s<arguments.length;s++){var t=arguments[s];for(var n in t)Object.prototype.hasOwnProperty.call(t,n)&&(e[n]=t[n])}return e},i=function(){function e(e,s){for(var t=0;t<s.length;t++){var n=s[t];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(e,n.key,n)}}return function(s,t,n){return t&&e(s.prototype,t),n&&e(s,n),s}}(),l=c(t(51609)),r=c(t(62688)),a=c(t(4452));function c(e){return e&&e.__esModule?e:{default:e}}function u(e,s,t){return s in e?Object.defineProperty(e,s,{value:t,enumerable:!0,configurable:!0,writable:!0}):e[s]=t,e}var d={animating:"rah-animating",animatingUp:"rah-animating--up",animatingDown:"rah-animating--down",animatingToHeightZero:"rah-animating--to-height-zero",animatingToHeightAuto:"rah-animating--to-height-auto",animatingToHeightSpecific:"rah-animating--to-height-specific",static:"rah-static",staticHeightZero:"rah-static--height-zero",staticHeightAuto:"rah-static--height-auto",staticHeightSpecific:"rah-static--height-specific"},m=["animateOpacity","animationStateClasses","applyInlineTransitions","children","contentClassName","delay","duration","easing","height","onAnimationEnd","onAnimationStart"];function p(e){for(var s=arguments.length,t=Array(s>1?s-1:0),n=1;n<s;n++)t[n-1]=arguments[n];if(!t.length)return e;for(var o={},i=Object.keys(e),l=0;l<i.length;l++){var r=i[l];-1===t.indexOf(r)&&(o[r]=e[r])}return o}
// Start animation helper using nested requestAnimationFrames
function h(e){e.forEach((function(e){return cancelAnimationFrame(e)}))}function _(e){return!isNaN(parseFloat(e))&&isFinite(e)}function g(e){
// Percentage height
return"string"==typeof e&&e.search("%")===e.length-1&&_(e.substr(0,e.length-1))}function f(e,s){e&&"function"==typeof e&&e(s)}var v=function(e){function s(e){!function(e,s){if(!(e instanceof s))throw new TypeError("Cannot call a class as a function")}(this,s);var t=function(e,s){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!s||"object"!=typeof s&&"function"!=typeof s?e:s}(this,(s.__proto__||Object.getPrototypeOf(s)).call(this,e));t.animationFrameIDs=[];var n="auto",i="visible";_(e.height)?(
// If value is string "0" make sure we convert it to number 0
n=e.height<0||"0"===e.height?0:e.height,i="hidden"):g(e.height)&&(
// If value is string "0%" make sure we convert it to number 0
n="0%"===e.height?0:e.height,i="hidden"),t.animationStateClasses=o({},d,e.animationStateClasses);var l=t.getStaticStateClasses(n);return t.state={animationStateClasses:l,height:n,overflow:i,shouldUseTransitions:!1},t}return function(e,s){if("function"!=typeof s&&null!==s)throw new TypeError("Super expression must either be null or a function, not "+typeof s);e.prototype=Object.create(s&&s.prototype,{constructor:{value:e,enumerable:!1,writable:!0,configurable:!0}}),s&&(Object.setPrototypeOf?Object.setPrototypeOf(e,s):e.__proto__=s)}(s,e),i(s,[{key:"componentDidMount",value:function(){var e=this.state.height;
// Hide content if height is 0 (to prevent tabbing into it)
// Check for contentElement is added cause this would fail in tests (react-test-renderer)
// Read more here: https://github.com/Stanko/react-animate-height/issues/17
this.contentElement&&this.contentElement.style&&this.hideContent(e)}},{key:"componentDidUpdate",value:function(e,s){var t,n,o=this,i=this.props,l=i.delay,r=i.duration,c=i.height,d=i.onAnimationEnd,m=i.onAnimationStart;
// Check if 'height' prop has changed
if(this.contentElement&&c!==e.height){var p;
// Remove display: none from the content div
// if it was hidden to prevent tabbing into it
this.showContent(s.height),
// Cache content height
this.contentElement.style.overflow="hidden";var v=this.contentElement.offsetHeight;this.contentElement.style.overflow="";
// set total animation time
var y=r+l,b=null,S={height:null,// it will be always set to either 'auto' or specific number
overflow:"hidden"},x="auto"===s.height;_(c)?(
// If value is string "0" make sure we convert it to number 0
b=c<0||"0"===c?0:c,S.height=b):g(c)?(
// If value is string "0%" make sure we convert it to number 0
b="0%"===c?0:c,S.height=b):(
// If not, animate to content height
// and then reset to auto
b=v,// TODO solve contentHeight = 0
S.height="auto",S.overflow=null),x&&(
// This is the height to be animated to
S.height=b,
// If previous height was 'auto'
// set starting height explicitly to be able to use transition
b=v);
// Animation classes
var w=(0,a.default)((u(p={},this.animationStateClasses.animating,!0),u(p,this.animationStateClasses.animatingUp,"auto"===e.height||c<e.height),u(p,this.animationStateClasses.animatingDown,"auto"===c||c>e.height),u(p,this.animationStateClasses.animatingToHeightZero,0===S.height),u(p,this.animationStateClasses.animatingToHeightAuto,"auto"===S.height),u(p,this.animationStateClasses.animatingToHeightSpecific,S.height>0),p)),E=this.getStaticStateClasses(S.height);
// Animation classes to be put after animation is complete
// Set starting height and animating classes
// We are safe to call set state as it will not trigger infinite loop
// because of the "height !== prevProps.height" check
this.setState({// eslint-disable-line react/no-did-update-set-state
animationStateClasses:w,height:b,overflow:"hidden",
// When animating from 'auto' we first need to set fixed height
// that change should be animated
shouldUseTransitions:!x}),
// Clear timeouts
clearTimeout(this.timeoutID),clearTimeout(this.animationClassesTimeoutID),x?(
// When animating from 'auto' we use a short timeout to start animation
// after setting fixed height above
S.shouldUseTransitions=!0,h(this.animationFrameIDs),this.animationFrameIDs=(t=function(){o.setState(S),
// ANIMATION STARTS, run a callback if it exists
f(m,{newHeight:S.height})},(n=[])[0]=requestAnimationFrame((function(){n[1]=requestAnimationFrame((function(){t()}))})),n),
// Set static classes and remove transitions when animation ends
this.animationClassesTimeoutID=setTimeout((function(){o.setState({animationStateClasses:E,shouldUseTransitions:!1}),
// ANIMATION ENDS
// Hide content if height is 0 (to prevent tabbing into it)
o.hideContent(S.height),
// Run a callback if it exists
f(d,{newHeight:S.height})}),y)):(
// ANIMATION STARTS, run a callback if it exists
f(m,{newHeight:b}),
// Set end height, classes and remove transitions when animation is complete
this.timeoutID=setTimeout((function(){S.animationStateClasses=E,S.shouldUseTransitions=!1,o.setState(S),
// ANIMATION ENDS
// If height is auto, don't hide the content
// (case when element is empty, therefore height is 0)
"auto"!==c&&
// Hide content if height is 0 (to prevent tabbing into it)
o.hideContent(b),
// Run a callback if it exists
f(d,{newHeight:b})}),y))}}},{key:"componentWillUnmount",value:function(){h(this.animationFrameIDs),clearTimeout(this.timeoutID),clearTimeout(this.animationClassesTimeoutID),this.timeoutID=null,this.animationClassesTimeoutID=null,this.animationStateClasses=null}},{key:"showContent",value:function(e){0===e&&(this.contentElement.style.display="")}},{key:"hideContent",value:function(e){0===e&&(this.contentElement.style.display="none")}},{key:"getStaticStateClasses",value:function(e){var s;return(0,a.default)((u(s={},this.animationStateClasses.static,!0),u(s,this.animationStateClasses.staticHeightZero,0===e),u(s,this.animationStateClasses.staticHeightSpecific,e>0),u(s,this.animationStateClasses.staticHeightAuto,"auto"===e),s))}},{key:"render",value:function(){var e,s=this,t=this.props,n=t.animateOpacity,i=t.applyInlineTransitions,r=t.children,c=t.className,d=t.contentClassName,h=t.delay,_=t.duration,g=t.easing,f=t.id,v=t.style,y=this.state,b=y.height,S=y.overflow,x=y.animationStateClasses,w=y.shouldUseTransitions,E=o({},v,{height:b,overflow:S||v.overflow});w&&i&&(E.transition="height "+_+"ms "+g+" "+h+"ms",
// Include transition passed through styles
v.transition&&(E.transition=v.transition+", "+E.transition),
// Add webkit vendor prefix still used by opera, blackberry...
E.WebkitTransition=E.transition);var k={};n&&(k.transition="opacity "+_+"ms "+g+" "+h+"ms",
// Add webkit vendor prefix still used by opera, blackberry...
k.WebkitTransition=k.transition,0===b&&(k.opacity=0));var C=(0,a.default)((u(e={},x,!0),u(e,c,c),e)),j=void 0!==this.props["aria-hidden"]?this.props["aria-hidden"]:0===b;
// Check if user passed aria-hidden prop
return l.default.createElement("div",o({},p.apply(void 0,[this.props].concat(m)),{"aria-hidden":j,className:C,id:f,style:E}),l.default.createElement("div",{className:d,style:k,ref:function(e){return s.contentElement=e}},r))}}]),s}(l.default.Component);v.propTypes={"aria-hidden":r.default.bool,animateOpacity:r.default.bool,animationStateClasses:r.default.object,applyInlineTransitions:r.default.bool,children:r.default.any.isRequired,className:r.default.string,contentClassName:r.default.string,delay:r.default.number,duration:r.default.number,easing:r.default.string,height:function(e,s,t){var o=e[s];return"number"==typeof o&&o>=0||g(o)||"auto"===o?null:new TypeError('value "'+o+'" of type "'+(void 0===o?"undefined":n(o))+'" is invalid type for '+s+" in "+t+'. It needs to be a positive number, string "auto" or percentage string (e.g. "15%").')},id:r.default.string,onAnimationEnd:r.default.func,onAnimationStart:r.default.func,style:r.default.object},v.defaultProps={animateOpacity:!1,animationStateClasses:d,applyInlineTransitions:!0,duration:250,delay:0,easing:"ease",style:{}},s.A=v}
/***/,
/***/91701:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */k:()=>/* binding */r
/* harmony export */});
/* harmony import */var n=t(66087),o=t(47143),i=t(86087),l=t(90551);
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
 * Blocks creator hook.
 * It adds blocks dynamically to the InnerBlock.
 *
 * @param {string} clientId Block client ID.
 */
const r=e=>{const{replaceInnerBlocks:s}=(0,o.useDispatch)("core/block-editor"),{getBlocks:t}=(0,o.useSelect)((e=>e("core/block-editor")),[]);return{setBlocks:(0,i.useCallback)(((o,i=!1)=>{const r=t(e),a=(0,l/* .extractStructure */.xn)(r);(0,n.isEqual)(a,o)||s(e,(0,l/* .syncStructureToBlocks */.eE)(o,r),i)}),[e,s,t])}};
/***/},
/***/92335:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>o
/* harmony export */});
/* harmony import */var n=t(74997);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Module block transform.
 */
/* harmony default export */const o={from:[{type:"block",blocks:["sensei-lms/course-outline-lesson"],isMultiBlock:!0,
/**
     * Group selected lesson blocks into a module.
     *
     * @param {Object[]} blocks Attributes of the selected blocks.
     */
transform(e){const s=e.map((e=>(0,n.createBlock)("sensei-lms/course-outline-lesson",e)));return(0,n.createBlock)("sensei-lms/course-outline-module",{},s)}}]};
/***/},
/***/92856:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>a
/* harmony export */});
/* harmony import */var n=t(27723),o=t(94715),i=t(56427),l=t(44927),r=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Inspector controls for outline block.
 *
 * @param {Object} props Block props.
 */
const a=e=>{const{attributes:s,setAttributes:t}=e,{moduleBorder:a,setModuleBorder:c}=(0,l/* .useSharedModuleStyles */.H)(e);
return(0,r.jsx)(o.InspectorControls,{children:(0,r.jsxs)(i.PanelBody,{title:(0,n.__)("Modules","sensei-lms"),initialOpen:!1,children:[(0,r.jsx)(i.ToggleControl,{checked:s.collapsibleModules,onChange:e=>t({collapsibleModules:e}),label:(0,n.__)("Collapsible modules","sensei-lms"),help:(0,n.__)("Modules can be collapsed or expanded.","sensei-lms")}),(0,r.jsx)(i.ToggleControl,{checked:a,onChange:c,label:(0,n.__)("Border","sensei-lms"),help:(0,n.__)("Toggle the border for all modules.","sensei-lms")})]})})};
/* harmony default export */}
/***/,
/***/93832:
/***/e=>{"use strict";e.exports=window.wp.url}
/***/,
/***/94077:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>l
/* harmony export */});
/* harmony import */var n,o=t(51609);
/* harmony import */function i(){return i=Object.assign?Object.assign.bind():function(e){for(var s=1;s<arguments.length;s++){var t=arguments[s];for(var n in t)({}).hasOwnProperty.call(t,n)&&(e[n]=t[n])}return e},i.apply(null,arguments)}
/* harmony default export */const l=function(e){
return o.createElement("svg",i({viewBox:"0 0 24 24",xmlns:"http://www.w3.org/2000/svg"},e),n||(n=o.createElement("path",{d:"M4 4v12h4.777L6 20h2.223L11 16h2l2.777 4H18l-2.777-4H20V4zm1.5 1.5h13v9h-13zM9 8v1.5h6V8zm0 3v1.5h6V11z",clipRule:"evenodd",fillRule:"evenodd"})))};
/***/},
/***/94234:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>a
/* harmony export */});
/* harmony import */var n=t(27723),o=t(60146),i=t(41544),l=t(69885),r=t(27872);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/* harmony default export */const a={...i,metadata:i,styles:[{name:"default",label:(0,n.__)("Filled","sensei-lms"),isDefault:!0},{name:"minimal",label:(0,n.__)("Minimal","sensei-lms")}],example:{attributes:{isPreview:!0},innerBlocks:[{name:"sensei-lms/course-outline-lesson",attributes:{title:(0,n.__)("Lesson 1","sensei-lms"),id:1,draft:!1,isExample:!0}},{name:"sensei-lms/course-outline-lesson",attributes:{title:(0,n.__)("Lesson 2","sensei-lms"),id:2,draft:!1,isExample:!0}},{name:"sensei-lms/course-outline-lesson",attributes:{title:(0,n.__)("Lesson 3","sensei-lms"),id:3,draft:!1,isExample:!0}}]},icon:o/* ["default"] */.A,edit:l/* ["default"] */.A,save:r/* ["default"] */.A};
/***/},
/***/94715:
/***/e=>{"use strict";e.exports=window.wp.blockEditor}
/***/,
/***/96083:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */E:()=>/* reexport safe */n.A
/* harmony export */,ev:()=>/* reexport safe */i.A
/* harmony export */,ib:()=>/* reexport safe */o.A
/* harmony export */});
/* harmony import */var n=t(94234),o=t(47456),i=t(98172);
/* harmony import */t(73765),t(5705)}
/**
 * Internal dependencies
 */
/***/,
/***/96516:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */h:()=>/* binding */n
/* harmony export */});
/* unused harmony export getSenseiProCheckoutUrl */
/**
 * Get the Sensei Pro upgrade URL.
 *
 * @param {string} campaign The campaign name.
 *
 * @return {string} The upgrade URL.
 */
const n=(e="")=>{const{upsellUrl:s}=window.sensei_admin;return`${s}?${new URLSearchParams({utm_source:"plugin_sensei",utm_medium:"upsell",utm_campaign:e}).toString()}`};
/**
 * Get the Sensei Pro checkout URL.
 *
 * @param {string} campaign The campaign name.
 *
 * @return {string} The checkout URL.
 */}
/***/,
/***/96562:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>d
/* harmony export */});
/* harmony import */var n=t(86087),o=t(56427),i=t(27723),l=t(1022),r=t(16643),a=t(40913),c=t(71437),u=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Lessons modal content.
 *
 * @param {Object}   props
 * @param {string}   props.clientId Outline block ID.
 * @param {Function} props.onClose  Close callback.
 */
const d=({clientId:e,onClose:s})=>{const t=(0,c/* .useAddExistingLessons */.V)(e),[d,m]=(0,n.useState)({search:""}),[p,h]=(0,n.useState)(!1),[_,g]=(0,n.useState)([]);
return(0,u.jsxs)(o.Modal,{className:"sensei-lms-existing-lessons-modal",title:(0,i.__)("Available Lessons","sensei-lms"),onRequestClose:s,children:[p&&(0,u.jsx)(o.Notice,{status:"error",isDismissible:!1,className:"sensei-lms-existing-lessons-modal__notice",children:(0,i.__)("Unable to add the selected lesson(s). Please make sure you are still logged in and try again.","sensei-lms")}),(0/* ["default"] */,u.jsx)(l.A,{setFilters:m}),(0/* ["default"] */,u.jsx)(r.A,{clientId:e,filters:d,selectedLessons:_,setSelectedLessons:g}),(0/* ["default"] */,u.jsx)(a.A,{selectedLessons:_,setSelectedLessons:g,onAdd:t,closeModal:s,setErrorAddingSelected:h})]})};
/* harmony default export */}
/***/,
/***/98172:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>r
/* harmony export */});
/* harmony import */var n=t(27723),o=t(94077),i=t(98411),l=t(59870);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/* harmony default export */const r={...l,metadata:l,icon:o/* ["default"] */.A,example:{attributes:{title:(0,n.__)("Start learning","sensei-lms")}},edit:i/* ["default"] */.A};
/***/},
/***/98411:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>g
/* harmony export */});
/* unused harmony export LessonEdit */
/* harmony import */var n=t(4452),o=t.n(n),i=t(12417),l=t(1027),r=t(17811),a=t(27723),c=t(29281),u=t(41546),d=t(29165),m=t(2883),p=t(9022),h=t(89120),_=t(62540);
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
 * Edit lesson block component.
 *
 * @param {Object}   props                     Component props.
 * @param {string}   props.className           Custom class name.
 * @param {Object}   props.attributes          Block attributes.
 * @param {string}   props.attributes.title    Lesson title.
 * @param {number}   props.attributes.id       Lesson Post ID
 * @param {number}   props.attributes.fontSize Lesson title font size.
 * @param {boolean}  props.attributes.draft    Draft status of lesson.
 * @param {boolean}  props.attributes.preview  Whether lesson has preview enabled.
 * @param {Object}   props.backgroundColor     Background color object.
 * @param {Object}   props.textColor           Text color object.
 * @param {Function} props.setAttributes       Block set attributes function.
 */
const g=(0,c/* .withColorSettings */.rt)({backgroundColor:{style:"background-color",label:(0,a.__)("Background color","sensei-lms")},textColor:{style:"color",label:(0,a.__)("Text color","sensei-lms")}})((e=>{const{className:s,attributes:{title:t,id:n,fontSize:c,draft:g,preview:f,placeholder:v},backgroundColor:y,textColor:b,setAttributes:S}=e,{onKeyDown:x}=(0,u/* .useKeydownInserter */.H)(e),w=(0,h/* .useLessonPreviewStatus */.y)(e);
/**
   * Update lesson title.
   *
   * @param {string} value Lesson title.
   */let E="";!n&&t.length?E=(0,a.__)("Unsaved","sensei-lms"):n&&g&&(E=(0,a.__)("Draft","sensei-lms"));const k={className:o()(s,y?.class,b?.class,{completed:w.previewStatus===m/* .Status */.n.COMPLETED,"is-auto-draft":!n&&!t}),style:{backgroundColor:y?.color,color:b?.color}},C=o()("wp-block-sensei-lms-course-outline-lesson__input-container",{"wp-block-sensei-lms-course-outline-lesson__no-status":!E});
return(0,_.jsxs)(_.Fragment,{children:[(0/* ["default"] */,_.jsx)(p.A,{...e,...w}),(0,_.jsxs)("div",{...k,"data-lesson-id":n,children:[(0/* ["default"] */,_.jsx)(i.A,{icon:l/* ["default"] */.A,className:"wp-block-sensei-lms-course-outline-lesson__status"}),(0,_.jsxs)("div",{className:C,children:[(0/* ["default"] */,_.jsx)(d.A,{className:"wp-block-sensei-lms-course-outline-lesson__input",placeholder:v||(0,a.__)("Add Lesson","sensei-lms"),value:t,onChange:e=>{S({title:e})},onKeyDown:x,style:{fontSize:c}}),E&&(0,_.jsx)("div",{className:"wp-block-sensei-lms-course-outline-lesson__post-status",children:E})]}),f&&(0,_.jsx)("span",{className:"wp-block-sensei-lms-course-outline-lesson__badge",children:(0,a.__)("Preview","sensei-lms")}),(0/* ["default"] */,_.jsx)(i.A,{icon:r/* ["default"] */.A,className:"wp-block-sensei-lms-course-outline-lesson__chevron"})]})]})}));
/* harmony default export */}
/***/
/******/},s={};
/************************************************************************/
/******/ // The module cache
/******/
/******/
/******/ // The require function
/******/function t(n){
/******/ // Check if module is in cache
/******/var o=s[n];
/******/if(void 0!==o)
/******/return o.exports;
/******/
/******/ // Create a new module (and put it into the cache)
/******/var i=s[n]={
/******/ // no module.id needed
/******/ // no module.loaded needed
/******/exports:{}
/******/};
/******/
/******/ // Execute the module function
/******/
/******/
/******/ // Return the exports of the module
/******/return e[n](i,i.exports,t),i.exports;
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
/******/for(var n in s)
/******/t.o(s,n)&&!t.o(e,n)&&
/******/Object.defineProperty(e,n,{enumerable:!0,get:s[n]})
/******/;
/******/},
/******/t.o=(e,s)=>Object.prototype.hasOwnProperty.call(e,s)
/******/,
// This entry needs to be wrapped in an IIFE because it needs to be in strict mode.
(()=>{"use strict";
/* harmony import */var e=t(47056),s=t(96083);
/* harmony import */
/**
 * Internal dependencies
 */
/**
 * Internal dependencies
 */
(0,e/* ["default"] */.A)([s/* .OutlineBlock */.E,s/* .ModuleBlock */.ib,s/* .LessonBlock */.ev])})()})
/******/();