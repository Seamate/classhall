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
 */var r=t(51609),n=Symbol.for("react.element"),o=Symbol.for("react.fragment"),i=Object.prototype.hasOwnProperty,a=r.__SECRET_INTERNALS_DO_NOT_USE_OR_YOU_WILL_BE_FIRED.ReactCurrentOwner,l={key:!0,ref:!0,__self:!0,__source:!0};function c(e,s,t){var r,o={},c=null,u=null;for(r in void 0!==t&&(c=""+t),void 0!==s.key&&(c=""+s.key),void 0!==s.ref&&(u=s.ref),s)i.call(s,r)&&!l.hasOwnProperty(r)&&(o[r]=s[r]);if(e&&e.defaultProps)for(r in s=e.defaultProps)void 0===o[r]&&(o[r]=s[r]);return{$$typeof:n,type:e,key:c,ref:u,props:o,_owner:a.current}}s.Fragment=o,s.jsx=c,s.jsxs=c}
/***/,
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
/* global define */!function(){"use strict";var r={}.hasOwnProperty;function n(){for(var e="",s=0;s<arguments.length;s++){var t=arguments[s];t&&(e=i(e,o(t)))}return e}function o(e){if("string"==typeof e||"number"==typeof e)return e;if("object"!=typeof e)return"";if(Array.isArray(e))return n.apply(null,e);if(e.toString!==Object.prototype.toString&&!e.toString.toString().includes("[native code]"))return e.toString();var s="";for(var t in e)r.call(e,t)&&e[t]&&(s=i(s,t));return s}function i(e,s){return s?e?e+" "+s:e+s:e}e.exports?(n.default=n,e.exports=n):void 0===(t=function(){return n}.apply(s,[]))||(e.exports=t)}()}
/***/,
/***/5573:
/***/e=>{"use strict";e.exports=window.wp.primitives}
/***/,
/***/5823:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>o
/* harmony export */});
/* harmony import */var r=t(5573),n=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
const o=(0,n.jsx)(r.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24",children:(0,n.jsx)(r.Path,{d:"M13 5c-3.3 0-6 2.7-6 6 0 1.4.5 2.7 1.3 3.7l-3.8 3.8 1.1 1.1 3.8-3.8c1 .8 2.3 1.3 3.7 1.3 3.3 0 6-2.7 6-6S16.3 5 13 5zm0 10.5c-2.5 0-4.5-2-4.5-4.5s2-4.5 4.5-4.5 4.5 2 4.5 4.5-2 4.5-4.5 4.5z"})});
/* harmony default export */}
//# sourceMappingURL=search.js.map
/***/,
/***/18537:
/***/e=>{"use strict";e.exports=window.wp.htmlEntities}
/***/,
/***/21181:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>/* binding */n
/* harmony export */});
/* harmony import */var r=t(86087);
/* harmony import */
/**
 * WordPress dependencies
 */
// Solution borrowed from https://gist.github.com/kentcdodds/b36572b6e9227207e6c71fd80e63f3b4.
function n(){const e=(0,r.useRef)(),s=(0,r.useCallback)((()=>(e.current||(e.current=new AbortController),e.current)),[]);(0,r.useEffect)((()=>()=>s().abort()),[s]);return{getSignal:(0,r.useCallback)((()=>s().signal),[s])}}
/***/},
/***/27723:
/***/e=>{"use strict";e.exports=window.wp.i18n}
/***/,
/***/33205:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>o
/* harmony export */});
/* harmony import */var r=t(5573),n=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
const o=(0,n.jsx)(r.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24",children:(0,n.jsx)(r.Path,{d:"M13 19h-2v-2h2v2zm0-6h-2v-2h2v2zm0-6h-2V5h2v2z"})});
/* harmony default export */}
//# sourceMappingURL=more-vertical.js.map
/***/,
/***/37134:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>m
/* harmony export */});
/* unused harmony export CourseList */
/* harmony import */var r=t(56427),n=t(86087),o=t(18537),i=t(27723),a=t(3582),l=t(93301),c=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Callback for select or unselect courseItem
 *
 * @callback onChangeEvent
 * @param {boolean} isSelected Describes if the course was selected or unselected
 * @param {boolean} course     Course related to the triggered event
 */
/**
 * Loading course list component.
 */
const u=()=>(0,c.jsx)("li",{className:"sensei-student-modal__course-list--loading",children:(0,c.jsx)(r.Spinner,{})})
/**
 * Empty course list component.
 */,d=()=>(0,c.jsx)("li",{className:"sensei-student-modal__course-list--empty",children:(0,i.__)("No courses found.","sensei-lms")})
/**
 * Course item.
 *
 * @param {Object}        props
 * @param {Object}        props.course   Course
 * @param {boolean}       props.checked  Checkbox state
 * @param {onChangeEvent} props.onChange Event triggered when the a course is select/unselected
 */,p=({course:e,checked:s=!1,onChange:t})=>{const i=e?.id,a=(0,o.decodeEntities)(e?.title?.rendered),[l,u]=(0,n.useState)(s),d=(0,n.useCallback)((s=>{u(s),t({isSelected:s,course:e})}),[e,t]);
return(0,c.jsxs)("li",{className:"sensei-student-modal__course-list__item",children:[(0,c.jsx)(r.CheckboxControl,{id:`course-${i}`,title:a,checked:l,onChange:d}),(0,c.jsx)("label",{htmlFor:`course-${i}`,title:a,children:a})]},i)},m=({searchQuery:e,onChange:s})=>{const t=(0,n.useRef)([]),r=(0,n.useCallback)((({isSelected:e,course:r})=>{t.current=e?[...t.current,r]:t.current.filter((e=>e.id!==r.id)),s(t.current)}),[s]),{courses:o,isFetching:m}=(0,l/* ["default"] */.A)((s=>{const t=s(a.store),r={per_page:100,search:e,filter:"teacher"};return{courses:t.getEntityRecords("postType","course",r)||[],isFetching:!t.hasFinishedResolution("getEntityRecords",["postType","course",r])}}),[e],500);
return(0,c.jsxs)(c.Fragment,{children:[(0,c.jsx)("span",{className:"sensei-student-modal__course-list__header",children:(0,i.__)("Your Courses","sensei-lms")}),(0,c.jsxs)("ul",{className:"sensei-student-modal__course-list",children:[m&&(0,c.jsx)(u,{}),!m&&0===o.length&&(0,c.jsx)(d,{}),!m&&0<o.length&&o.map((e=>(0,c.jsx)(p,{course:e,onChange:r,checked:t.current.length>0&&t.current.find((({id:s})=>s===e.id))},e.id)))]})]})}}
/***/,
/***/47143:
/***/e=>{"use strict";e.exports=window.wp.data}
/***/,
/***/51609:
/***/e=>{"use strict";e.exports=window.React}
/***/,
/***/52619:
/***/e=>{"use strict";e.exports=window.wp.hooks}
/***/,
/***/56427:
/***/e=>{"use strict";e.exports=window.wp.components}
/***/,
/***/62540:
/***/(e,s,t)=>{"use strict";e.exports=t(2192)}
/***/,
/***/66087:
/***/e=>{"use strict";e.exports=window.lodash}
/***/,
/***/69946:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>h
/* harmony export */});
/* unused harmony export StudentModal */
/* harmony import */var r=t(56427),n=t(86087),o=t(5823),i=t(27723),a=t(89877),l=t(1455),c=t.n(l),u=t(37134),d=t(72108),p=t(21181),m=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
const h=({action:e,onClose:s,students:t,studentDisplayName:l})=>{const{description:h,buttonLabel:_,errorMessage:g,isDestructive:w,sendAction:f}=((e,s,t)=>{const r=(0,a.escapeHTML)(t);return{add:{description:s>1?(0,i.sprintf)(
// Translators: placeholder is the number of selected students.
// Translators: placeholder is the number of selected students.
(0,i.__)("Select the course(s) you would like to add <strong>%d students</strong> to:","sensei-lms"),s):(0,i.sprintf)(
// Translators: placeholder is the student's name.
// Translators: placeholder is the student's name.
(0,i.__)("Select the course(s) you would like to add <strong>%s</strong> to:","sensei-lms"),r),buttonLabel:(0,i.__)("Add to Course","sensei-lms"),errorMessage:e=>(0,i._n)("Unable to add student. Please try again.","Unable to add students. Please try again.",e.length,"sensei-lms"),sendAction:(e,s,{signal:t})=>c()({path:"/sensei-internal/v1/course-students/batch",method:"POST",data:{student_ids:e,course_ids:s},signal:t}),isDestructive:!1},remove:{description:s>1?(0,i.sprintf)(
// Translators: placeholder is the number of selected students.
// Translators: placeholder is the number of selected students.
(0,i.__)("Select the course(s) you would like to remove <strong>%d students</strong> from:","sensei-lms"),s):(0,i.sprintf)(
// Translators: placeholder is the student's name.
// Translators: placeholder is the student's name.
(0,i.__)("Select the course(s) you would like to remove <strong>%s</strong> from:","sensei-lms"),r),buttonLabel:(0,i.__)("Remove from Course","sensei-lms"),errorMessage:e=>(0,i._n)("Unable to remove student. Please try again.","Unable to remove students. Please try again.",e.length,"sensei-lms"),sendAction:(e,s,{signal:t})=>c()({path:"/sensei-internal/v1/course-students/batch",method:"DELETE",data:{student_ids:e,course_ids:s},signal:t}),isDestructive:!0},"reset-progress":{
// Translators: placeholder is the number of selected students for plural, student's name for singular.
description:s>1?(0,i.sprintf)(
// Translators: placeholder is the number of selected students.
// Translators: placeholder is the number of selected students.
(0,i.__)("Select the course(s) you would like to reset progress from for <strong>%d students</strong>:","sensei-lms"),s):(0,i.sprintf)(
// Translators: placeholder is the student's name.
// Translators: placeholder is the student's name.
(0,i.__)("Select the course(s) you would like to reset progress from for <strong>%s</strong>:","sensei-lms"),r),buttonLabel:(0,i.__)("Reset Progress","sensei-lms"),errorMessage:e=>(0,i._n)("Unable to reset progress for this student. Please try again.","Unable to reset progress for these students. Please try again.",e.length,"sensei-lms"),sendAction:(e,s,{signal:t})=>c()({path:"/sensei-internal/v1/course-progress/batch",method:"DELETE",data:{student_ids:e,course_ids:s},signal:t}),isDestructive:!0}}[e]})(e,t.length,l),[v,x]=(0,n.useState)([]),[y,b]=(0,n.useState)(""),[j,S]=(0,n.useState)(!1),[C,k]=(0,n.useState)(!1),{getSignal:A}=(0,p/* ["default"] */.A)(),N=(0,n.useCallback)((async()=>{S(!0);try{await f(t,v.map((e=>e.id)),{signal:A()}),s(!0)}catch(e){A().aborted||(k(!0),S(!1))}}),[f,t,v,s,A]);
return(0,m.jsxs)(r.Modal,{className:"sensei-student-modal",title:(0,i.__)("Choose Course","sensei-lms"),onRequestClose:()=>s(),children:[(0,m.jsx)(n.RawHTML,{children:h}),(0/* ["default"] */,m.jsx)(d.A,{iconRight:o/* ["default"] */.A,onChange:e=>b(e),placeholder:(0,i.__)("Search courses","sensei-lms"),value:y}),(0/* ["default"] */,m.jsx)(u.A,{searchQuery:y,onChange:e=>{x(e)}}),C&&(0,m.jsx)(r.Notice,{status:"error",isDismissible:!1,className:"sensei-student-modal__notice",children:g(t)}),(0,m.jsx)("div",{className:"sensei-student-modal__action",children:(0,m.jsxs)(r.Button,{className:"sensei-student-modal__action",variant:w?"":"primary",onClick:()=>N(),disabled:j||0===v.length,isDestructive:w,children:[j&&(0,m.jsx)(r.Spinner,{}),_]})})]})};
/**
 * Student Actions Modal.
 *
 * @param {Object}   props
 * @param {Object}   props.action             Action that is being performed.
 * @param {Function} props.onClose            Close callback.
 * @param {Array}    props.students           A list of Student ids related to the action should be applied.
 * @param {string}   props.studentDisplayName Name of the student, shown when there's only one student.
 */}
/***/,
/***/72108:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>a
/* harmony export */});
/* harmony import */var r=t(4452),n=t.n(r),o=t(56427),i=t(62540);
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
const a=({className:e,id:s,label:t,value:r,help:a,iconRight:l,onChange:c,...u})=>(0,i.jsx)(o.BaseControl,{id:s,label:t,help:a,children:(0,i.jsxs)("div",{className:"sensei-input-control",children:[(0,i.jsx)("input",{className:n()("sensei-input-control__input",{"sensei-input-control__input--with-icon-right":l},e),type:"text",id:s,value:null===r?"":r,onChange:e=>c(e.target.value),...u}),l&&(0,i.jsx)("span",{className:"sensei-input-control__icon",children:(0,i.jsx)(o.Icon,{icon:l})})]})})
/* harmony default export */}
/***/,
/***/86087:
/***/e=>{"use strict";e.exports=window.wp.element}
/***/,
/***/89877:
/***/e=>{"use strict";e.exports=window.wp.escapeHtml}
/***/,
/***/93301:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>i
/* harmony export */});
/* harmony import */var r=t(66087),n=t(47143),o=t(86087);
/* harmony import */
/**
 * External dependencies
 */
/**
 * WordPress dependencies
 */
/**
 * Use select hook with debounce.
 *
 * @param {Function} mapSelect Map select function.
 * @param {Array}    deps      Use select dependencies.
 * @param {number}   wait      Wait time for the debounce.
 *
 * @return {*} Returns what useSelect returns through the mapSelect argument.
 */
const i=(e,s,t)=>{const[i,a]=(0,o.useState)(s),l=(0,o.useCallback)((0,r.debounce)(a,t),[a,t]);
// eslint-disable-next-line react-hooks/exhaustive-deps -- Using debounce as callback.
return(0,o.useEffect)((()=>{l(s);
// eslint-disable-next-line react-hooks/exhaustive-deps -- Dependencies coming from args.
}),s),(0,n.useSelect)(e,i)};
/* harmony default export */}
/***/
/******/},s={};
/************************************************************************/
/******/ // The module cache
/******/
/******/
/******/ // The require function
/******/function t(r){
/******/ // Check if module is in cache
/******/var n=s[r];
/******/if(void 0!==n)
/******/return n.exports;
/******/
/******/ // Create a new module (and put it into the cache)
/******/var o=s[r]={
/******/ // no module.id needed
/******/ // no module.loaded needed
/******/exports:{}
/******/};
/******/
/******/ // Execute the module function
/******/
/******/
/******/ // Return the exports of the module
/******/return e[r](o,o.exports,t),o.exports;
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
/******/for(var r in s)
/******/t.o(s,r)&&!t.o(e,r)&&
/******/Object.defineProperty(e,r,{enumerable:!0,get:s[r]})
/******/;
/******/},
/******/t.o=(e,s)=>Object.prototype.hasOwnProperty.call(e,s)
/******/,
// This entry needs to be wrapped in an IIFE because it needs to be in strict mode.
(()=>{"use strict";
/* unused harmony export StudentActionMenu */
/* harmony import */var e=t(56427),s=t(86087),r=t(33205),n=t(52619),o=t(27723),i=t(69946),a=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Student action menu.
 *
 * @param {Object} props
 * @param {string} props.studentId          Student's user id
 * @param {string} props.studentName        Student's user name.
 * @param {string} props.studentDisplayName Student's displayName.
 */
const l=({studentId:t,studentName:l,studentDisplayName:c})=>{const[u,d]=(0,s.useState)(""),[p,m]=(0,s.useState)(!1),h=e=>{e&&window.location.reload(),m(!1)},_=[{title:(0,o.__)("Add to Course","sensei-lms"),onClick:()=>w()},{title:(0,o.__)("Remove from Course","sensei-lms"),onClick:()=>f()},{title:(0,o.__)("Reset Progress","sensei-lms"),onClick:()=>v()},{title:(0,o.__)("Grading","sensei-lms"),onClick:()=>window.open(`admin.php?page=sensei_grading&view=ungraded&s=${l}`,"_self")}],g=(0,n.applyFilters)("senseiStudentActionMenuControls",_,d,m),w=()=>{d("add"),m(!0)},f=()=>{d("remove"),m(!0)},v=()=>{d("reset-progress"),m(!0)},x=(0/* ["default"] */,a.jsx)(i.A,{action:u,onClose:h,students:[t],studentDisplayName:c}),y=(0,n.applyFilters)("senseiStudentBulkActionModal",x,u,h,[t],c);
return(0,a.jsxs)(a.Fragment,{children:[(0,a.jsx)(e.DropdownMenu,{icon:r/* ["default"] */.A,label:(0,o.__)("Select an action","sensei-lms"),controls:g}),p&&y]})};Array.from(document.getElementsByClassName("student-action-menu")).forEach((e=>{(0,s.createRoot)(e).render((0,a.jsx)(l,{studentId:e?.dataset?.userId,studentName:e?.dataset?.userName,studentDisplayName:e?.dataset?.userDisplayName}))}))})()})
/******/();