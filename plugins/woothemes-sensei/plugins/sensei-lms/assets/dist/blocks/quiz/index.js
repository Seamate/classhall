/******/(()=>{// webpackBootstrap
/******/var e={
/***/1027:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>r
/* harmony export */});
/* harmony import */var n=t(5573),i=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
const r=(0,i.jsx)(n.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24",children:(0,i.jsx)(n.Path,{d:"M16.7 7.1l-6.3 8.5-3.3-2.5-.9 1.2 4.5 3.4L17.9 8z"})});
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
 */var n=t(51609),i=Symbol.for("react.element"),r=Symbol.for("react.fragment"),o=Object.prototype.hasOwnProperty,l=n.__SECRET_INTERNALS_DO_NOT_USE_OR_YOU_WILL_BE_FIRED.ReactCurrentOwner,a={key:!0,ref:!0,__self:!0,__source:!0};function c(e,s,t){var n,r={},c=null,u=null;for(n in void 0!==t&&(c=""+t),void 0!==s.key&&(c=""+s.key),void 0!==s.ref&&(u=s.ref),s)o.call(s,n)&&!a.hasOwnProperty(n)&&(r[n]=s[n]);if(e&&e.defaultProps)for(n in s=e.defaultProps)void 0===r[n]&&(r[n]=s[n]);return{$$typeof:i,type:e,key:c,ref:u,props:r,_owner:l.current}}s.Fragment=r,s.jsx=c,s.jsxs=c}
/***/,
/***/2567:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>a
/* harmony export */});
/* harmony import */var n=t(4452),i=t.n(n),r=t(56427),o=t(1027),l=t(62540);
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
const a=({options:e,optionsLabel:s,icon:t,value:n,onChange:a,toggleProps:c,getMenuItemProps:u,popoverProps:d,...p})=>{const m=e.find((e=>n===e.value));
return(0,l.jsx)(r.ToolbarDropdownMenu,{className:"sensei-toolbar-dropdown",popoverProps:{variant:"toolbar",position:"bottom right left",focusOnMount:!0,...d,className:i()(d?.className,"sensei-toolbar-dropdown__popover")},label:s,icon:null!=t?t:null,text:c?.children?c.children(m):m?.label,...p,children:({onClose:t})=>(0,l.jsx)(r.MenuGroup,{label:s,children:e.map((e=>{const s=e.value===m?.value,n=u?.(e);
return(0,l.jsx)(r.MenuItem,{role:"menuitemradio",isSelected:s,icon:s?o/* ["default"] */.A:null,className:i()("sensei-toolbar-dropdown__option",{"is-selected":s},n?.className),onClick:()=>{a(e.value),t()},children:e.label,...n},e.value)}))})})};
/* harmony default export */}
/***/,
/***/4452:
/***/(e,s)=>{var t;
/*!
	Copyright (c) 2018 Jed Watson.
	Licensed under the MIT License (MIT), see
	http://jedwatson.github.io/classnames
*/
/* global define */!function(){"use strict";var n={}.hasOwnProperty;function i(){for(var e="",s=0;s<arguments.length;s++){var t=arguments[s];t&&(e=o(e,r(t)))}return e}function r(e){if("string"==typeof e||"number"==typeof e)return e;if("object"!=typeof e)return"";if(Array.isArray(e))return i.apply(null,e);if(e.toString!==Object.prototype.toString&&!e.toString.toString().includes("[native code]"))return e.toString();var s="";for(var t in e)n.call(e,t)&&e[t]&&(s=o(s,t));return s}function o(e,s){return s?e?e+" "+s:e+s:e}e.exports?(i.default=i,e.exports=i):void 0===(t=function(){return i}.apply(s,[]))||(e.exports=t)}()}
/***/,
/***/5573:
/***/e=>{"use strict";e.exports=window.wp.primitives}
/***/,
/***/5823:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>r
/* harmony export */});
/* harmony import */var n=t(5573),i=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
const r=(0,i.jsx)(n.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24",children:(0,i.jsx)(n.Path,{d:"M13 5c-3.3 0-6 2.7-6 6 0 1.4.5 2.7 1.3 3.7l-3.8 3.8 1.1 1.1 3.8-3.8c1 .8 2.3 1.3 3.7 1.3 3.3 0 6-2.7 6-6S16.3 5 13 5zm0 10.5c-2.5 0-4.5-2-4.5-4.5s2-4.5 4.5-4.5 4.5 2 4.5 4.5-2 4.5-4.5 4.5z"})});
/* harmony default export */}
//# sourceMappingURL=search.js.map
/***/,
/***/7973:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */z:()=>/* binding */r
/* harmony export */});
/* harmony import */var n=t(47143),i=t(65526);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Get the next question index.
 *
 * @param {string} clientId The client ID.
 *
 * @return {number} Next question index.
 */
const r=e=>{const s=(0,n.useSelect)((s=>s("core/block-editor").getBlocks(e)),[]),t=s.length&&s[s.length-1];return t&&(0,i/* .isQuestionEmpty */.cm)(t.attributes)?s.length-1:s.length};
/***/},
/***/10155:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */a:()=>/* binding */o
/* harmony export */});
/* harmony import */var n=t(47143),i=t(86087),r=t(66087);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * External dependencies
 */
/**
 * Get the question categories.
 *
 * @return {Object[]} Term objects.
 */
const o=()=>{const e=(0,n.useSelect)((e=>{const s=e("core").getEntityRecords("taxonomy","question-category",{per_page:-1});return null!=s?s:[]}),[]),s=(0,i.useMemo)((()=>(e||[]).map((e=>({...e,name:unescape(e.name)})))),[e]),t=(0,i.useMemo)((()=>(0,r.keyBy)(null!=s?s:[],"id")),[s]);return[s,e=>{var s;return!(!t||0===t.length)&&(null!==(s=t[e])&&void 0!==s&&s)}]};
/***/},
/***/12035:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>r
/* harmony export */});
/* harmony import */var n=t(5573),i=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
const r=(0,i.jsx)(n.SVG,{viewBox:"0 0 24 24",xmlns:"http://www.w3.org/2000/svg",children:(0,i.jsx)(n.Path,{d:"M6.5 12.4L12 8l5.5 4.4-.9 1.2L12 10l-4.5 3.6-1-1.2z"})});
/* harmony default export */}
//# sourceMappingURL=chevron-up.js.map
/***/,
/***/12107:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>r
/* harmony export */});
/* harmony import */var n=t(5573),i=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
const r=(0,i.jsx)(n.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24",children:(0,i.jsx)(n.Path,{d:"M11 12.5V17.5H12.5V12.5H17.5V11H12.5V6H11V11H6V12.5H11Z"})});
/* harmony default export */}
//# sourceMappingURL=plus.js.map
/***/,
/***/12417:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>i
/* harmony export */});
/* harmony import */var n=t(86087);
/* harmony import */
/* harmony default export */const i=(0,n.forwardRef)((
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
function({icon:e,size:s=24,...t},i){return(0,n.cloneElement)(e,{width:s,height:s,...t,ref:i})}));
//# sourceMappingURL=index.js.map
/***/},
/***/13804:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */c:()=>/* binding */l
/* harmony export */});
/* unused harmony export InputToggle */
/* harmony import */var n=t(4452),i=t.n(n),r=t(1027),o=t(62540);
/* harmony import */
/**
 * External dependencies
 */
/**
 * WordPress dependencies
 */
/**
 * Toggle component using divs.
 *
 * @param {Object}  props            Component props.
 * @param {string}  props.className  Class name for the wrapper.
 * @param {boolean} props.isChecked  Whether it's checked.
 * @param {boolean} props.isCheckbox Whether it's a checkbox.
 * @param {Object}  props.input      Input component.
 * @param {Object}  props.children   Component children.
 */
const l=({className:e,isChecked:s,isCheckbox:t,input:n,children:l,...a})=>(0,o.jsxs)("div",{className:i()("sensei-lms-question-block__option-toggle",e),...a,children:[n,(0,o.jsx)("div",{className:i()("sensei-lms-question-block__option-toggle__control",{"is-checked":s,"is-checkbox":t}),children:t&&r/* ["default"] */.A}),l]})
/**
 * Toggle component using input.
 *
 * @param {Object} props      Component props.
 * @param {string} props.type Input toggle type (`checkbox` or `radio`).
 */}
/***/,
/***/14309:
/***/e=>{"use strict";e.exports=window.wp.editPost}
/***/,
/***/15076:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>r
/* harmony export */});
/* harmony import */var n=t(27723),i=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Question block file upload answer component.
 */
const r=()=>(0,i.jsx)("div",{className:"wp-block-button is-style-outline sensei-lms-question-block__answer sensei-lms-question-block__answer--file-upload",children:(0,i.jsx)("div",{className:"wp-block-button__link wp-element-button",children:(0,n.__)("Choose File","sensei-lms")})});
/* harmony default export */}
/***/,
/***/18057:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>l
/* harmony export */});
/* harmony import */var n=t(56427),i=t(27723),r=t(96516),o=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Quiz block inserter for adding new or existing questions.
 */
const l=()=>(0,o.jsxs)("div",{className:"sensei-lms-quiz-block-settings__quiz-timer-promo",children:[(0,o.jsx)(n.ToggleControl,{disabled:!0,label:(0,i.__)("Quiz Timer","sensei-lms"),help:(0,i.__)("The quiz timer enables you to control how much time a student has to complete the quiz.","sensei-lms")}),(0,o.jsx)("p",{children:(0,o.jsx)(n.ExternalLink,{href:(0,r/* .getSenseiProUpsellUrl */.h)("quiz_timer"),children:(0,i.__)("Upgrade to Sensei Pro","sensei-lms")})})]});
/* harmony default export */}
/***/,
/***/19098:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>N
/* harmony export */});
/* harmony import */var n=t(94715),i=t(47143),r=t(86087),o=t(29491),l=t(27723),a=t(52619),c=t(54323),u=t(76809),d=t(55014),p=t(52019),m=t(23274),h=t(29165),g=t(77801),_=t(92859),b=t(43952),v=t(75125),x=t(85643),w=t(26381),k=t(86245),f=t(46087),j=t(34439),A=t(31824),y=t(57198),q=t(4452),C=t.n(q),S=t(62540);
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
let B=Object.entries(b/* ["default"] */.A).map((([e,s])=>({...s,label:s.title,value:e})));
/**
 * Filters the available question type options.
 *
 * @since 4.1.0
 *
 * @param {Array} options The available question type options.
 * @return {Array} The filtered question type options.
 */B=(0,a.applyFilters)("senseiQuestionTypeToolbarOptions",B);
/**
 * Format the question grade as `X points`.
 *
 * @param {number} grade Question grade.
 * @return {string} Grade text.
 */
const N=(0/* .withBlockMeta */,o.compose)(g.Hm,(0/* .validateQuestionBlock */,c/* .withBlockValidation */.N)(k.S))((e=>{const{attributes:{title:s,type:t,answer:o={},options:a,shared:c,editable:g=!0},setAttributes:q,clientId:N,context:P}=e,{removeBlock:E,selectBlock:I}=(0,i.useDispatch)("core/block-editor"),T=(0,r.useCallback)((()=>{const e=(0,i.select)("core/block-editor").getBlocks(N);e.length&&I(e[0].clientId)}),[N,I]),z=(0,m/* .useQuestionNumber */.f)(N),R=t&&b/* ["default"] */.A[t],F=R?.feedback,M=(0,_/* .useHasSelected */.bb)(e),O=P&&!("sensei-lms/quizId"in P),Q=s||M||O,V=!O&&(0,S.jsxs)("h2",{className:"sensei-lms-question-block__index",children:[z,"."]}),D=e.meta.showValidationErrors&&e.meta.validationErrors?.length,H=(0,S.jsx)("div",{className:"sensei-lms-question-block__grade grade",children:(U=a.grade,
// Translators: placeholder is the grade for the questions.
// Translators: placeholder is the grade for the questions.
(0,l.sprintf)((0,l._n)("%d point","%d points",U,"sensei-lms"),U))});var U;
/**
 * Quiz question block editor.
 *
 * @param {Object}   props
 * @param {Object}   props.attributes       Block attributes.
 * @param {Object}   props.attributes.title Question title.
 * @param {Function} props.setAttributes    Set block attributes.
 * @param {Object}   props.meta             Block metadata.
 */const[L,G]=(0,r.useState)(!1),W=(0,r.useMemo)((()=>({answer:o,setAttributes:q,AnswerBlock:R,hasSelected:M,canHaveFeedback:F,answerFeedback:{showAnswerFeedback:L,toggleAnswerFeedback:G},options:a})),[R,o,M,q,L,F,a]),$=(0,r.useMemo)((()=>[[d/* ["default"] */.A.name,{}],[p/* ["default"] */.A.name,{}],...F?[[u/* .answerFeedbackCorrectBlock */.f.name,{}],[u/* .answerFeedbackIncorrectBlock */.Q.name,{}]]:[]]),[F]),Z=(0,n.useBlockProps)({className:C()("sensei-lms-question-block",{"is-draft":!s,"is-invalid":D,"show-answer-feedback":L})});return g?(0,S.jsxs)("div",{...Z,children:[(0,S.jsxs)("div",{className:"sensei-lms-question-block__header",children:[V,O&&(0/* ["default"] */,S.jsx)(y.A,{...e}),(0,S.jsx)("h2",{className:"sensei-lms-question-block__title",children:(0/* ["default"] */,S.jsx)(h.A,{placeholder:(0,l.__)("Question Title","sensei-lms"),value:s,onChange:e=>q({title:e}),onEnter:T,onRemove:()=>E(N)})}),R.subtitle&&(0,S.jsx)(R.subtitle,{isQuestionSelected:M}),Q&&H]}),M&&c&&(0/* .SharedQuestionNotice */,S.jsx)(v.A7,{}),Q&&(0/* .QuestionContext */,S.jsx)(x.q.Provider,{value:W,children:(0,S.jsx)(n.InnerBlocks,{template:$,templateInsertUpdatesSelection:!1,templateLock:"all",renderAppender:null})}),(0/* .QuestionValidationNotice */,S.jsx)(v.uN,{...e,getErrorMessages:k/* .getQuestionBlockValidationErrorMessages */.v}),(0,S.jsxs)(n.BlockControls,{children:[(0/* .QuestionTypeToolbar */,S.jsx)(A.a,{value:t,onSelect:e=>q({type:e}),options:B}),(0/* .QuestionGradeToolbar */,S.jsx)(w.H,{value:a.grade,onChange:e=>q({options:{...a,grade:e}})})]}),(0/* ["default"] */,S.jsx)(j.A,{controls:R?.settings,...e})]}):(0/* ["default"] */,S.jsx)(f.A,{...e,questionGrade:H,questionIndex:V,AnswerBlock:R})}))}
/***/,
/***/19361:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>c
/* harmony export */});
/* harmony import */var n=t(4452),i=t.n(n),r=t(94715),o=t(86087),l=t(48558),a=t(62540);
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
const c=(0,o.forwardRef)((({onChange:e,onKeyDown:s,value:t,onEnter:n,onRemove:o,...c},u)=>(0,a.jsx)(r.PlainText,{ref:u,value:t,onChange:s=>{e(s.replace(/\n/g,""))},onKeyDown:e=>{switch(s&&s(e),e.keyCode){case l.ENTER:e.preventDefault(),n&&n(e);break;case l.BACKSPACE:o&&!t?.length&&(e.preventDefault(),o())}},...c,className:i()("sensei-lms-single-line-input",c.className)})));
/* harmony default export */}
/***/,
/***/20163:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */$W:()=>/* reexport safe */r.A
/* harmony export */,DH:()=>/* reexport safe */n.A
/* harmony export */,tu:()=>/* reexport safe */i.A
/* harmony export */});
/* harmony import */var n=t(89442),i=t(65195),r=t(88694);
/* harmony import */}
/***/,
/***/21293:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>c
/* harmony export */});
/* harmony import */var n=t(56427),i=t(86087),r=t(27723),o=t(29165),l=t(13804),a=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Answer option in a multiple choice type question block.
 *
 * @param {Object}   props
 * @param {Object}   props.attributes         Answer attributes.
 * @param {string}   props.attributes.label   Answer title.
 * @param {boolean}  props.attributes.correct Is this a right answer.
 * @param {Function} props.setAttributes      Update answer attributes.
 * @param {Function} props.onEnter            Add a new answer after this.
 * @param {Function} props.onRemove           Remove this answer.
 * @param {boolean}  props.hasFocus           Should this answer receive focus.
 * @param {boolean}  props.hasSelected        Is the question block selected.
 * @param {boolean}  props.isCheckbox         Should display as a checkbox
 */
const c=e=>{const{attributes:{label:s,correct:t},setAttributes:c,hasFocus:u,hasSelected:d,isCheckbox:p,...m}=e,h=(0,i.useRef)(null);(0,i.useEffect)((()=>{if(u){const e=h.current?.textarea||h.current;e?.focus()}}),[u,h]);
return(0,a.jsxs)("div",{className:"sensei-lms-question-block__multiple-choice-answer-option",children:[(0/* .OptionToggle */,a.jsx)(l.c,{isChecked:t,isCheckbox:p}),(0/* ["default"] */,a.jsx)(o.A,{ref:h,placeholder:(0,r.__)("Add Answer","sensei-lms"),className:"sensei-lms-question-block__multiple-choice-answer-option__input",onChange:e=>c({label:e}),value:s,...m}),d&&(0,a.jsx)("div",{className:"sensei-lms-question-block__answer--multiple-choice__toggle__wrapper",children:(0,a.jsxs)(n.Button,{isPrimary:!0,className:"sensei-lms-question-block__answer--multiple-choice__toggle",onClick:()=>c({correct:!t}),children:[t&&(0,r.__)("Right","sensei-lms"),!t&&(0,r.__)("Wrong","sensei-lms")]})})]})};
/* harmony default export */}
/***/,
/***/23274:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */f:()=>/* binding */i
/* harmony export */});
/* harmony import */var n=t(47143);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Get the current number (order) of the question block in a quiz.
 *
 * @param {string} clientId Block Client Id.
 * @return {number} Block index
 */
const i=e=>(0,n.useSelect)((s=>{const t=s("core/block-editor"),n=t.getBlockRootClientId(e);return(t.getBlocks(n)||[]).slice(0,t.getBlockIndex(e,n))}),[e]).reduce(((e,s)=>e+("category-question"===s.attributes.type&&s.attributes.options?.number||1)),0)+1;
/***/},
/***/25693:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>p
/* harmony export */});
/* harmony import */var n=t(94715),i=t(56427),r=t(27723),o=t(1455),l=t.n(o),a=t(86087),c=t(60817),u=t(10155),d=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Calculate the number of questions that are available in a category.
 *
 * @param {number}   categoryId The category id.
 * @param {Function} onError    Called when an error happens.
 *
 * @return {number|boolean} The number of questions in a category or false if unknown.
 */
const p=({attributes:{options:e={}},setAttributes:s})=>{var t,o;const p=(t,n={})=>s({...n,options:{...e,...t}}),[m,h]=(0,u/* .useQuestionCategories */.a)(),[g,_]=(0,a.useState)(null),b=((e,s)=>{const[t,n]=(0,a.useState)({});return(0,a.useEffect)((()=>{e&&!t.hasOwnProperty(e)&&l()({path:`/wp/v2/questions?question-category=${e}`,method:"GET",parse:!1}).then((s=>{t[e]=+s.headers.get("X-WP-Total"),n({...t})})).catch((e=>{e.json().then((e=>s(e.message)))}))}),[e,t,s]),!!t.hasOwnProperty(e)&&t[e]})(e.category,_),v=[{value:"",label:""},...(m||[]).map((e=>({value:e.id,label:e.name})))];
return(0,d.jsx)(n.InspectorControls,{children:(0,d.jsxs)(i.PanelBody,{title:(0,r.__)("Category Question Settings","sensei-lms"),initialOpen:!0,children:[!v.length&&(0,d.jsx)(i.Notice,{status:"warning",isDismissible:!1,children:(0,r.__)("No question categories exist.","sensei-lms")}),v.length>0&&(0,d.jsxs)(d.Fragment,{children:[(0,d.jsx)(i.SelectControl,{label:(0,r.__)("Category","sensei-lms"),options:v,value:null!==(t=e.category)&&void 0!==t?t:"",onChange:e=>{var s;const t=h(+e);p({category:null!==(s=+e)&&void 0!==s?s:null},{categoryName:t?.name}),_(null)}}),(0/* ["default"] */,d.jsx)(c.A,{label:(0,r.__)("Number of Questions","sensei-lms"),min:1,step:1,value:null!==(o=e.number)&&void 0!==o?o:1,onChange:e=>e&&p({number:e||1})}),null!==g&&(0,d.jsx)(i.Notice,{status:"error",isDismissible:!1,children:(0,r.sprintf)(
// translators: The underlying error message.
// translators: The underlying error message.
(0,r.__)("An error occurred while retrieving questions: %s","sensei-lms"),g)}),!1!==b&&null===g&&e.number>b&&(0,d.jsx)(i.Notice,{status:"warning",isDismissible:!1,children:(0,r.sprintf)(
// translators: Placeholder is number of questions in category.
// translators: Placeholder is number of questions in category.
(0,r._n)("The selected category has %d question.","The selected category has %d questions.",b,"sensei-lms"),b)})]})]})})};
/**
 * Category question block settings controls.
 *
 * @param {Object}   props                    Block props.
 * @param {Object}   props.attributes         Block attributes.
 * @param {Object}   props.attributes.options Block options attribute.
 * @param {Function} props.setAttributes      Update block attributes.
 */}
/***/,
/***/26381:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */H:()=>/* binding */o
/* harmony export */});
/* harmony import */var n=t(56427),i=t(68523),r=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Question grade toolbar control.
 *
 * @param {Object}   props
 * @param {number}   props.value    Grade value.
 * @param {Function} props.onChange Grade setter.
 */
const o=({value:e,onChange:s})=>(0,r.jsx)(r.Fragment,{children:(0,r.jsx)(n.ToolbarGroup,{className:"sensei-lms-question-block__grade-toolbar",children:(0,r.jsx)(n.ToolbarItem,{as:i/* .QuestionGradeControl */.l,value:e,onChange:s})})});
/***/},
/***/27723:
/***/e=>{"use strict";e.exports=window.wp.i18n}
/***/,
/***/28108:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>/* reexport safe */n.A
/* harmony export */});
/* harmony import */var n=t(95861);
/* harmony import */t(30983)}
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
/***/29374:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>p
/* harmony export */});
/* harmony import */var n=t(86087),i=t(56427),r=t(27723),o=t(50394),l=t(66719),a=t(35325),c=t(10155),u=t(32307),d=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Questions modal content.
 *
 * @param {Object}   props
 * @param {string}   props.clientId Quiz block ID.
 * @param {Function} props.onClose  Close callback.
 */
const p=({clientId:e,onClose:s})=>{const t=(0,u/* .useAddExistingQuestions */.D)(e),[p,m]=(0,n.useState)({search:"","question-type":"","question-category":""}),[h,g]=(0,n.useState)(!1),[_,b]=(0,n.useState)([]),[v]=(0,c/* .useQuestionCategories */.a)();
return(0,d.jsxs)(i.Modal,{className:"sensei-lms-quiz-block__questions-modal",title:(0,r.__)("Questions","sensei-lms"),onRequestClose:s,children:[h&&(0,d.jsx)(i.Notice,{status:"error",isDismissible:!1,className:"sensei-lms-quiz-block__questions-modal__notice",children:(0,r.__)("Unable to add the selected question(s). Please make sure you are still logged in and try again.","sensei-lms")}),(0/* ["default"] */,d.jsx)(o.A,{questionCategories:v,filters:p,setFilters:m}),(0/* ["default"] */,d.jsx)(l.A,{clientId:e,questionCategories:v,filters:p,selectedQuestionIds:_,setSelectedQuestionIds:b}),(0/* ["default"] */,d.jsx)(a.A,{selectedQuestionIds:_,setSelectedQuestionIds:b,onAdd:t,closeModal:s,setErrorAddingSelected:g})]})};
/* harmony default export */}
/***/,
/***/29491:
/***/e=>{"use strict";e.exports=window.wp.compose}
/***/,
/***/30983:
/***/(e,s,t)=>{"use strict";
/* harmony import */t(94715),t(56427),t(27723),t(62540)
/* harmony import */}
/***/,
/***/31702:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>o
/* harmony export */});
/* harmony import */var n=t(56427),i=t(12107),r=t(62540);
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
const o=({controls:e,text:s,label:t})=>(0,r.jsxs)("div",{className:"sensei-lms-text-appender block-editor-default-block-appender",children:[(0,r.jsx)(n.DropdownMenu,{icon:i/* ["default"] */.A,toggleProps:{className:"block-editor-inserter__toggle",onMouseDown:e=>e.preventDefault()},label:t,controls:e,popoverProps:{position:"bottom center"},menuProps:{className:"sensei-lms-text-appender__menu"}}),(0,r.jsx)("p",{className:"sensei-lms-text-appender__placeholder","data-placeholder":s})]});
/* harmony default export */}
/***/,
/***/31824:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */a:()=>/* binding */a
/* harmony export */});
/* harmony import */var n=t(56427),i=t(52619),r=t(27723),o=t(2567),l=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Question type selector toolbar control.
 *
 * @param {Object}   props
 * @param {string}   props.value    Selected type.
 * @param {Function} props.onSelect Selection callback.
 * @param {Array}    props.options  Question options.
 */
const a=({value:e,onSelect:s,options:t})=>(0,l.jsx)(n.ToolbarGroup,{className:"sensei-lms-question-block__type-selector__toolbar",children:(0/* ["default"] */,l.jsx)(o.A,{className:"sensei-lms-question-block__type-selector",label:(0,r.__)("Question Type","sensei-lms"),options:t,value:e,onChange:e=>s(e),optionsLabel:(0,r.__)("Question Type","sensei-lms"),popoverProps:{className:"sensei-lms-question-block__type-selector__popover"},toggleProps:{children:e=>(0,l.jsx)("b",{children:e?.title})},getMenuItemProps:e=>{let s=(0,l.jsxs)("div",{children:[(0,l.jsxs)("strong",{children:[" ",e.title]}),(0,l.jsx)("div",{className:"sensei-lms-question-block__type-selector__option__description",children:e.description})]});
/**
         * Filters the children of the menu item.
         *
         * @since 4.1.0
         *
         * @param {JSX.Element} children Menu element children.
         * @param {Object}      option   The question type option.
         * @return {JSX.Element} Retuns the filtered children for the menu item.
         */s=(0,i.applyFilters)("senseiQuestionTypeToolbarOptionChildren",s,e);const t={};return t.children=s,e.disabled&&(t.onClick=()=>{}),t}})});
/***/},
/***/32307:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */D:()=>/* binding */a
/* harmony export */});
/* harmony import */var n=t(47143),i=t(1455),r=t.n(i),o=t(65526),l=t(7973);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
const a=e=>{const s=(0,n.select)("core/block-editor").getBlocks(e),{insertBlock:t}=(0,n.useDispatch)("core/block-editor"),i=(0,l/* .useNextQuestionIndex */.z)(e);return n=>{const l=n.filter((e=>0===s.length||!(0,o/* .findQuestionBlock */.bE)(s,{id:e})));if(0===l.length)return Promise.resolve({});
// Put this before the auto-block.
let a=i;return r()({path:"/sensei-internal/v1/question-options?question_ids="+l.join(","),method:"GET"}).then((s=>{Array.isArray(s)&&s.length>0&&s.forEach((s=>{t((0,o/* .createQuestionBlock */.Cl)(s),a,e,!1),a++}))}))}};
/**
 * Add existing questions to the quiz block.
 *
 * @param {string} clientId The quiz block client id.
 * @return {Function} Function that takes an array of question IDs and returns a Promise.
 */}
/***/,
/***/32694:
/***/e=>{"use strict";e.exports=JSON.parse('{"name":"sensei-lms/quiz","title":"Quiz","apiVersion":2,"description":"Evaluate progress and strengthen understanding of course concepts.","category":"sensei-lms","textdomain":"sensei-lms","keywords":["exam","questions","test","assessment","evaluation"],"supports":{"html":false,"multiple":false},"attributes":{"id":{"type":"integer"},"options":{"type":"object","default":{"passRequired":false,"quizPassmark":0,"autoGrade":true,"allowRetakes":true,"randomQuestionOrder":false,"showQuestions":null,"failedShowAnswerFeedback":false,"failedShowCorrectAnswers":false,"failedIndicateIncorrect":false,"buttonTextColor":null,"buttonBackgroundColor":null,"pagination":{}}},"isPostTemplate":{"type":"boolean","default":false}},"example":{"innerBlocks":[{"name":"sensei-lms/quiz-question","attributes":{"title":"What are power chords?","answer":{"answers":[{"label":"  A chord consisting of a root note of the chord and a 5th","correct":true},{"label":"  A chord playing on an electric guitar","correct":false}]}}},{"name":"sensei-lms/quiz-question","attributes":{"title":"What part of the guitar do you adjust when tuning it?","answer":{"answers":[{"label":"  The Tuning Pegs","correct":true},{"label":"  The Fretboard","correct":false},{"label":"  The Neck","correct":false}]}}}]}}')}
/***/,
/***/34439:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>a
/* harmony export */});
/* harmony import */var n=t(94715),i=t(56427),r=t(27723),o=t(20163),l=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Question block settings controls.
 *
 * @param {Object}     props                    Block props.
 * @param {Function[]} props.controls           Additional setting controls.
 * @param {Object}     props.attributes         Block attributes.
 * @param {Object}     props.attributes.options Block options attribute.
 * @param {Function}   props.setAttributes      Update block attributes.
 */
const a=({controls:e=[],attributes:{options:s={}},setAttributes:t,...a})=>{const c=e=>t({options:{...s,...e}});
return(0,l.jsx)(n.InspectorControls,{children:(0,l.jsxs)(i.PanelBody,{title:(0,r.__)("Question settings","sensei-lms"),initialOpen:!0,children:[[o/* .QuestionGradeSettings */.tu,...e].map((e=>(0,l.jsx)(e,{...a,options:s,setOptions:c},e))),(0,l.jsx)(i.ToggleControl,{label:(0,r.__)("Hide Answer Feedback","sensei-lms"),checked:"yes"===s.hideAnswerFeedback,onChange:e=>c({hideAnswerFeedback:e?"yes":""}),help:(0,r.__)("Do not show any feedback when the student answers this question.","sensei-lms")})]})})};
/* harmony default export */}
/***/,
/***/34723:
/***/e=>{"use strict";e.exports=JSON.parse('{"name":"sensei-lms/quiz-question","title":"Question","apiVersion":2,"description":"The building block of all quizzes.","parent":["sensei-lms/quiz"],"category":"sensei-lms","textdomain":"sensei-lms","supports":{"html":false},"example":{"attributes":{"title":"What are power chords?","answer":{"answers":[{"label":"  A chord consisting of a root note of the chord and a 5th","correct":true},{"label":"  A chord playing on an electric guitar","correct":false}]}}},"attributes":{"id":{"type":"integer"},"title":{"type":"string"},"type":{"type":"string","default":"multiple-choice"},"answer":{"type":"object"},"options":{"type":"object","default":{"grade":1,"hideAnswerFeedback":""}},"editable":{"type":"boolean","default":true,"source":false}}}')}
/***/,
/***/35325:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>l
/* harmony export */});
/* harmony import */var n=t(56427),i=t(27723),r=t(86087),o=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Questions actions.
 *
 * @param {Object}   props
 * @param {number[]} props.selectedQuestionIds    Selected question IDs.
 * @param {Object}   props.setSelectedQuestionIds Selected question IDs state setter.
 * @param {Function} props.onAdd                  Callback to add existing questions.
 * @param {Function} props.closeModal             Close the modal.
 * @param {Function} props.setErrorAddingSelected Set when there has been an error adding selection.
 */
const l=({selectedQuestionIds:e,setSelectedQuestionIds:s,onAdd:t,closeModal:l,setErrorAddingSelected:a})=>{const[c,u]=(0,r.useState)(!1),d=0===e.length?(0,i.__)("Add Selected","sensei-lms"):(0,i.sprintf)(/* translators: Number of selected questions. */ /* translators: Number of selected questions. */
(0,i.__)("Add Selected (%s)","sensei-lms"),e.length);
return(0,o.jsxs)("ul",{className:"sensei-lms-quiz-block__questions-modal__actions",children:[e.length>0&&(0,o.jsx)("li",{children:(0,o.jsx)(n.Button,{isTertiary:!0,onClick:()=>{s([])},children:(0,i.__)("Clear Selected","sensei-lms")})}),(0,o.jsx)("li",{children:(0,o.jsx)(n.Button,{disabled:c,onClick:()=>{u(!0),t(e).then(l).catch((()=>{a(!0),u(!1)}))},isPrimary:!0,children:d})})]})};
/* harmony default export */}
/***/,
/***/37344:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */v:()=>/* binding */o
/* harmony export */});
/* harmony import */var n=t(1455),i=t.n(n),r=t(86087);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Get the question types.
 *
 * @return {Object[]} Term objects.
 */
const o=()=>{const[e,s]=(0,r.useState)([]);return(0,r.useEffect)((()=>{i()({path:"/wp/v2/question-type?per_page=-1"}).then(s)}),[s]),e};
/***/},
/***/37424:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>h
/* harmony export */});
/* harmony import */var n=t(27723),i=t(29491),r=t(23274),o=t(10155),l=t(25693),a=t(86087),c=t(77801),u=t(54323),d=t(66047),p=t(75125),m=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Quiz category question block editor.
 *
 * @param {Object}   props
 * @param {Object}   props.attributes              Block attributes.
 * @param {Object}   props.attributes.categoryName Category name.
 * @param {Function} props.setAttributes           Set block attributes.
 */
const h=(0/* .withBlockMeta */,i.compose)(c.Hm,(0/* .validateCategoryQuestionBlock */,u/* .withBlockValidation */.N)(d.s))((e=>{var s;const{attributes:{options:{number:t=1,category:i}},clientId:c,setAttributes:u}=e,h=(0,r/* .useQuestionNumber */.f)(c),[,g]=(0,o/* .useQuestionCategories */.a)(),_=t&&1!==t?`${h} - ${h+t-1}`:h,b=(0,m.jsxs)("h2",{className:"sensei-lms-question-block__index",children:[_,"."]}),v=null!==(s=g(i)?.name)&&void 0!==s?s:e.attributes.categoryName,x=v===e.attributes.categoryName;return(0,a.useEffect)((()=>{v&&!x&&u({categoryName:v})}),[v,x,u]),(0,m.jsxs)(m.Fragment,{children:[(0/* ["default"] */,m.jsx)(l.A,{...e}),(0,m.jsxs)("div",{className:"sensei-lms-question-block sensei-lms-category-question-block "+(i?"":"is-draft"),children:[b,(0,m.jsxs)("h2",{className:"sensei-lms-question-block__title",children:[v?(0,m.jsx)("strong",{children:v}):(0,n.__)("Category Question","sensei-lms"),v&&t>0&&" ("+(0,n.sprintf)(
// translators: placeholder is number of questions to show from category.
// translators: placeholder is number of questions to show from category.
(0,n._n)("%d question","%d questions",t,"sensei-lms"),t)+")"]})]}),(0/* .QuestionValidationNotice */,m.jsx)(p.uN,{...e,getErrorMessages:d/* .getCategoryQuestionBlockValidationErrorMessages */.P})]})}));
/* harmony default export */}
/***/,
/***/38289:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>r
/* harmony export */});
/* harmony import */var n=t(5573),i=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
const r=(0,i.jsx)(n.SVG,{viewBox:"0 0 24 24",xmlns:"http://www.w3.org/2000/svg",children:(0,i.jsx)(n.Path,{d:"M17.5 11.6L12 16l-5.5-4.4.9-1.2L12 14l4.5-3.6 1 1.2z"})});
/* harmony default export */}
//# sourceMappingURL=chevron-down.js.map
/***/,
/***/42632:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */a:()=>/* binding */i
/* harmony export */});
/* harmony import */var n=t(47143);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Returns a callback which opens the quiz settings.
 *
 * @param {string} clientId The quiz block client id.
 *
 * @return {Function} A callback which opens the quiz settings.
 */
const i=e=>{const{openGeneralSidebar:s}=(0,n.useDispatch)("core/edit-post"),{selectBlock:t}=(0,n.useDispatch)("core/block-editor");return()=>{t(e),s("edit-post/block")}};
/***/},
/***/43656:
/***/e=>{"use strict";e.exports=window.wp.editor}
/***/,
/***/43952:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>h
/* harmony export */});
/* unused harmony export unfilteredQuestionTypes */
/* harmony import */var n=t(27723),i=t(52619),r=t(15076),o=t(44856),l=t(49500),a=t(76220),c=t(60929),u=t(56536),d=t(20163);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * @typedef QuestionType
 *
 * @property {string}   title       Question type name.
 * @property {string}   description Question type description.
 * @property {Function} edit        Editor component.
 * @property {boolean}  feedback    Question type can have answer feedback.
 * @property {Function} validate    Validation callback.
 * @property {Object}   messages    Message string.s
 */
/**
 * Question type definitions.
 *
 * @type {Object.<string, QuestionType>}
 */
const p={"multiple-choice":{title:(0,n.__)("Multiple Choice","sensei-lms"),description:(0,n.__)("Select from a list of options.","sensei-lms"),edit:a/* ["default"] */.A,view:a/* ["default"] */.A.view,settings:[d/* .QuestionMultipleChoiceSettings */.$W],feedback:!0,validate:({answers:e=[]}={})=>({noAnswers:e.filter((e=>e.label)).length<2,noRightAnswer:!e.some((e=>e.correct&&e.label)),noRightAnswerWhitespace:!e.some((e=>e.correct&&e.label.trim())),noWrongAnswer:!e.some((e=>!e.correct&&e.label)),noWrongAnswerWhitespace:!e.some((e=>!e.correct&&e.label.trim()))}),messages:{noAnswers:(0,n.__)("Add at least one right and one wrong answer.","sensei-lms"),noRightAnswer:(0,n.__)("Add a right answer to this question.","sensei-lms"),noRightAnswerWhitespace:(0,n.__)("The value of the right answer can not be blank space.","sensei-lms"),noWrongAnswer:(0,n.__)("Add a wrong answer to this question. Value can not be blank space.","sensei-lms"),noWrongAnswerWhitespace:(0,n.__)("The value of the wrong answer can not be blank space.","sensei-lms")}},boolean:{title:(0,n.__)("True/False","sensei-lms"),description:(0,n.__)("Select whether a statement is true or false.","sensei-lms"),edit:u/* ["default"] */.A,view:u/* ["default"] */.A.view,feedback:!0,settings:[]},"gap-fill":{title:(0,n.__)("Gap Fill","sensei-lms"),description:(0,n.__)("Fill in the blank.","sensei-lms"),edit:o/* ["default"] */.A,view:o/* ["default"] */.A.view,feedback:!0,settings:[],validate:({before:e,after:s,gap:t}={})=>({noGap:!t?.filter((e=>""!==e)).length,noGapWhitespace:!t?.filter((e=>""!==e.trim())).length,noBeforeAndNoAfter:!e&&!s,noBeforeAndNoAfterWhitespace:!e?.trim()&&!s?.trim()}),messages:{noGap:(0,n.__)("Add a right answer to this question.","sensei-lms"),noGapWhitespace:(0,n.__)("The value of a right answer can not be blank space.","sensei-lms"),noBeforeAndNoAfter:(0,n.__)("Add text before or after the gap. Value can not be blank space.","sensei-lms"),noBeforeAndNoAfterWhitespace:(0,n.__)("Value of the text before or after the gap can not be blank space.","sensei-lms")}},"single-line":{title:(0,n.__)("Single Line","sensei-lms"),description:(0,n.__)("Short answer to an open-ended question.","sensei-lms"),edit:c/* ["default"] */.A,view:c/* ["default"] */.A,settings:[d/* .QuestionGradingNotesSettings */.DH]},"multi-line":{title:(0,n.__)("Multi Line","sensei-lms"),description:(0,n.__)("Long answer to an open-ended question.","sensei-lms"),edit:l/* ["default"] */.A,view:l/* ["default"] */.A,settings:[d/* .QuestionGradingNotesSettings */.DH]},"file-upload":{title:(0,n.__)("File Upload","sensei-lms"),description:(0,n.__)("Upload a file or document.","sensei-lms"),edit:r/* ["default"] */.A,view:r/* ["default"] */.A,settings:[d/* .QuestionGradingNotesSettings */.DH]}},m={QuestionGradingNotesSettings:d/* .QuestionGradingNotesSettings */.DH},h=(0,i.applyFilters)("sensei-lms.Question.questionTypes",p,m);
// Commonly used core settings for use in custom question types.
}
/***/,
/***/44856:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>a
/* harmony export */});
/* harmony import */var n=t(56427),i=t(27723),r=t(19361),o=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Question block gap fill answer component.
 *
 * @param {Object}   props
 * @param {Object}   props.attributes
 * @param {string}   props.attributes.before Text before the gap.
 * @param {string}   props.attributes.after  Text after the gap.
 * @param {string[]} props.attributes.gap    Right answers.
 * @param {Function} props.setAttributes
 * @param {boolean}  props.hasSelected       Is the question block selected.
 */
const l=({attributes:{before:e,after:s,gap:t},setAttributes:l,hasSelected:a})=>(0,o.jsxs)("ul",{className:"sensei-lms-question-block__answer sensei-lms-question-block__answer--gap-fill",children:[(0,o.jsx)("li",{children:(0/* ["default"] */,o.jsx)(r.A,{className:"sensei-lms-question-block__answer--gap-fill__text",placeholder:(0,i.__)("Text before the gap","sensei-lms"),value:e,onChange:e=>l({before:e})})}),(0,o.jsxs)("li",{className:"sensei-lms-question-block__answer--gap-fill__right-answers",onBlur:({target:e})=>{e?.value&&(l({gap:[...null!=t?t:[],e.value]}),c(e,""))},children:[(0,o.jsx)(n.FormTokenField,{className:"sensei-lms-question-block__text-input-placeholder",value:t||[],label:!1,onChange:e=>l({gap:e})}),a&&(0,o.jsx)("div",{className:"sensei-lms-question-block__answer--gap-fill__hint",children:(0,i.__)("Add right answers. Separate with commas or the Enter key.","sensei-lms")})]}),(0,o.jsx)("li",{children:(0/* ["default"] */,o.jsx)(r.A,{className:"sensei-lms-question-block__answer--gap-fill__text",placeholder:(0,i.__)("Text after the gap","sensei-lms"),value:s,onChange:e=>l({after:e})})})]});
/**
 * Read-only answer component gap fill question block.
 *
 * @param {Object}   props
 * @param {Object}   props.attributes
 * @param {string}   props.attributes.before Text before the gap.
 * @param {string}   props.attributes.after  Text after the gap.
 * @param {string[]} props.attributes.gap    Right answers.
 */l.view=({attributes:{before:e,after:s,gap:t}})=>(0,o.jsxs)("ul",{className:"sensei-lms-question-block__answer sensei-lms-question-block__answer--gap-fill",children:[(0,o.jsx)("li",{children:e}),(0,o.jsx)("li",{className:"sensei-lms-question-block__answer--gap-fill__right-answers sensei-lms-question-block__text-input-placeholder",children:t.map((e=>(0,o.jsx)("span",{className:"sensei-lms-question-block__answer--gap-fill__token",children:e},e)))}),(0,o.jsx)("li",{children:s})]});
/* harmony default export */const a=l,c=(e,s)=>{delete e.value,e.value=s,e.dispatchEvent(new window.Event("change",{bubbles:!0}))};
/**
 * Update input value, making sure React event handlers are triggered.
 *
 * @param {HTMLInputElement} node       Input element.
 * @param {string}           inputValue New input value.
 */}
/***/,
/***/46087:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>d
/* harmony export */});
/* harmony import */var n=t(94715),i=t(74997),r=t(56427),o=t(47143),l=t(86087),a=t(27723),c=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Read-only question block.
 *
 * @param {Object}  props
 * @param {string}  props.clientId
 * @param {Object}  props.attributes
 * @param {string}  props.attributes.title    Question title.
 * @param {Object}  props.attributes.answer   Answer attributes.
 * @param {boolean} props.attributes.editable Is editing enabled.
 * @param {Element} props.questionIndex       Index element.
 * @param {Element} props.questionGrade       Grade label element.
 * @param {Element} props.AnswerBlock         Answer component config.
 */
const u=()=>(0,c.jsxs)(c.Fragment,{children:[(0,c.jsx)(n.BlockControls,{children:(0,c.jsx)(r.Toolbar,{children:(0,c.jsx)(r.ToolbarButton,{disabled:!0,children:(0,a.__)("Locked","sensei-lms")})})}),(0,c.jsx)(n.InspectorControls,{children:(0,c.jsx)(r.PanelBody,{title:(0,a.__)("Question Details","sensei-lms"),initialOpen:!0,children:(0,c.jsx)("div",{children:(0,a.__)("You are not allowed to edit this question.","sensei-lms")})})})]})
/* harmony default export */,d=({clientId:e,attributes:{title:s,answer:t,editable:n},questionIndex:r,questionGrade:a,AnswerBlock:d})=>{const p=(0,o.useSelect)((s=>s("core/block-editor").getBlock(e)),[e]);
return(0,c.jsxs)("div",{className:"sensei-lms-question-block",children:[r,(0,c.jsx)("h2",{className:"sensei-lms-question-block__title",children:s}),a,(0,c.jsx)(l.RawHTML,{children:(0,i.getBlockContent)(p)}),d?.view&&(0,c.jsx)(d.view,{attributes:t}),!n&&(0,c.jsx)(u,{})]})};
/**
 * Display toolbar and sidebar notices that the question is not editable.
 */}
/***/,
/***/46280:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */n:()=>/* binding */l
/* harmony export */});
/* harmony import */var n=t(74997),i=t(47143),r=t(86087),o=t(66087);
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
const l=({name:e,attributes:s={},selectFirstBlock:t=!1,isEmptyBlock:l},a)=>{const{clientId:c}=a,{__unstableMarkNextChangeAsNotPersistent:u=o.noop,insertBlock:d}=(0,i.useDispatch)("core/block-editor"),p=(0,i.useSelect)((e=>e("core/block-editor").getBlocks(c))),m=0===p.length,h=(0,r.useCallback)((()=>{const i=(0,n.createBlock)(e,s),r=m&&t;u(),d(i,void 0,c,r)}),[u,d,c,e,s,m,t]),g=p.length&&p[p.length-1],_=g&&l(g.attributes);
// console.log( 'dentro', useDispatch );
(0,r.useEffect)((()=>{_||h()}),[_,h])};
/***/},
/***/46602:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>l
/* harmony export */});
/* harmony import */var n,i,r=t(51609);
/* harmony import */function o(){return o=Object.assign?Object.assign.bind():function(e){for(var s=1;s<arguments.length;s++){var t=arguments[s];for(var n in t)({}).hasOwnProperty.call(t,n)&&(e[n]=t[n])}return e},o.apply(null,arguments)}
/* harmony default export */const l=function(e){
return r.createElement("svg",o({width:24,height:24,xmlns:"http://www.w3.org/2000/svg"},e),n||(n=r.createElement("path",{fillRule:"evenodd",clipRule:"evenodd",d:"M11.929 18.5a6 6 0 1 0 0-12 6 6 0 0 0 0 12Zm0-3a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z",fill:"currentColor"})),i||(i=r.createElement("path",{fillRule:"evenodd",clipRule:"evenodd",d:"M11.276 4.5a1 1 0 0 0-.987.836L9.93 7.5h4l-.361-2.164a1 1 0 0 0-.986-.836h-1.306Zm1.306 16a1 1 0 0 0 .986-.836l.36-2.164h-4l.361 2.164a1 1 0 0 0 .987.836h1.306ZM18.53 7.934a1 1 0 0 0-1.217-.436l-2.055.77 2 3.464 1.694-1.395a1 1 0 0 0 .23-1.272l-.652-1.13ZM5.326 17.065a1 1 0 0 0 1.217.436l2.055-.77-2-3.463-1.694 1.394a1 1 0 0 0-.23 1.272l.652 1.131ZM4.675 9.066a1 1 0 0 0 .23 1.272l1.694 1.394 2-3.464-2.055-.77a1 1 0 0 0-1.217.437l-.652 1.13Zm14.509 6.869a1 1 0 0 0-.23-1.272l-1.695-1.395-2 3.464 2.055.77a1 1 0 0 0 1.217-.436l.653-1.131Z",fill:"currentColor"})))};
/***/},
/***/46735:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>d
/* harmony export */});
/* harmony import */var n=t(94715),i=t(27723),r=t(86087),o=t(4452),l=t.n(o),a=t(85643),c=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * External dependencies
 */
/**
 * Internal dependencies
 */
const u={correct:{title:(0,i.__)("Correct","sensei-lms"),placeholder:(0,i.__)("Show a message when the question is answered correctly. Type / to choose a block.","sensei-lms")},incorrect:{title:(0,i.__)("Incorrect","sensei-lms"),placeholder:(0,i.__)("Show a message when the question is answered incorrectly. Type / to choose a block.","sensei-lms")}},d=({type:e})=>{const{title:s,placeholder:t}=u[e],i=(0/* .QuestionContext */,r.useContext)(a.q),{hideAnswerFeedback:o}=i.options;return o?"":(0,c.jsxs)("div",{className:l()("sensei-lms-question__answer-feedback",`sensei-lms-question__answer-feedback--${e}`),children:[(0,c.jsxs)("div",{className:"sensei-lms-question__answer-feedback__header",children:[(0,c.jsx)("span",{className:"sensei-lms-question__answer-feedback__icon"}),(0,c.jsx)("span",{children:s})]}),(0,c.jsx)("div",{className:"sensei-lms-question__answer-feedback__content",children:(0,c.jsx)(n.InnerBlocks,{template:[["core/paragraph",{placeholder:t}]],templateInsertUpdatesSelection:!1,templateLock:!1})})]})};
/**
 * Answer Feedback control.
 *
 * @param {Object} props
 * @param {string} props.type correct or incorrect
 */}
/***/,
/***/47056:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>l
/* harmony export */});
/* harmony import */var n=t(66087),i=t(74997),r=t(48597),o=t(62540);
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
const l=e=>{(0,i.updateCategory)("sensei-lms",{icon:(0/* ["default"] */,o.jsx)(r.A,{width:"20",height:"20"})}),e.forEach((e=>{let{metadata:s,name:t,...r}=e;s&&(
// Remove the overlapping metadata keys from the settings object to make localization work.
// This is needed because only the metadata object is localized, but the overlapping keys will be overwritten by the settings object and the localization is lost.
r=(0,n.omit)(r,Object.keys(s))),
// The metadata object should be used for the `block.json` strings to be localized.
// See https://github.com/Automattic/sensei/pull/5782 for more details.
// The metadata object should be used for the `block.json` strings to be localized.
// See https://github.com/Automattic/sensei/pull/5782 for more details.
(0,i.registerBlockType)(s||t,r)}))};
/* harmony default export */}
/***/,
/***/47143:
/***/e=>{"use strict";e.exports=window.wp.data}
/***/,
/***/48558:
/***/e=>{"use strict";e.exports=window.wp.keycodes}
/***/,
/***/48597:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>l
/* harmony export */});
/* harmony import */var n,i,r=t(51609);
/* harmony import */function o(){return o=Object.assign?Object.assign.bind():function(e){for(var s=1;s<arguments.length;s++){var t=arguments[s];for(var n in t)({}).hasOwnProperty.call(t,n)&&(e[n]=t[n])}return e},o.apply(null,arguments)}
/* harmony default export */const l=function(e){
return r.createElement("svg",o({viewBox:"0 0 24 24",fill:"none",xmlns:"http://www.w3.org/2000/svg"},e),n||(n=r.createElement("circle",{cx:12,cy:12,r:12,fill:"#43AF99"})),i||(i=r.createElement("path",{fillRule:"evenodd",clipRule:"evenodd",d:"M9.835 15.38c.3-.23.179-.474.6-.563-.02.194.146.391.251.563-.109-.367-.002-.536.08-.72.347-.785-.662-1.293-1.35-1.418.235-.164.399-.327.694-.355a2.377 2.377 0 0 0-1.058.23c-1.112.531-1.993-.523-1.41-1.48.31-.51.664-.519.982-.865.077.178.103.372.075.564a.919.919 0 0 0 .049-.664c-.104-.336-.4-.338-.456-.821-.012-.101-.105.056-.263-.077-.038-.032-.113-.09-.163-.064-.085.044-.18.008-.232.034-.083.041-.109-.045-.2.016-.16.107-.178-.013-.332.005-.193.023-.32.261-.43.144-.102-.108-.206.075-.28.075-.05 0-.311.317-.426.028-.086-.216-.28.206-.382.063-.033-.046-.123.108-.18-.044-.014-.035 0-.078-.108-.027-.215.099-.138-.06-.207-.144-.083-.103-.113-.103-.068-.27.036-.133-.019-.33.2-.364.055-.008.107-.005.184-.148.096-.18.231-.093.207-.175-.036-.119.143-.28.226-.355.11-.103.254-.252.306-.396a.63.63 0 0 1 .102-.141c.081-.084.105-.003.227-.045.088-.03.02.053.106-.07.028-.038.105-.001.19-.039.259-.112.283-.11.347-.371.012-.05.025-.088.08-.083.109.01.134-.052.2-.05.061.001.083-.03.115-.068.18-.216.277-.055.357-.072.06-.012.022-.142.184-.102.23.057.155-.05.303-.015.174.041.186.19.306.225.143.042.211.198.307.196.337-.005.235.23.448.323-.16-.161.012-.421-.352-.455-.08-.007-.11-.127-.23-.183-.146-.067-.13-.21-.394-.27.068-.04.089.005.13-.073.058-.11.09-.046.113-.113.02-.063.006-.099.165-.155.165-.06.325-.195.472-.188.13.006.185-.08.177-.19-.008-.112-.033-.267.222-.22.153.029.15.003.15-.1-.002-.102.04-.165.174-.16.098.002.194-.003.231-.117.03-.091.207-.114.302-.148.317-.114.361.05.447-.095.07-.117.196-.317.337-.175.028.029.054.05.15-.056.08-.088.27-.2.337-.048.027.06.086.121.138.044a.08.08 0 0 1 .053-.039c.05-.01.079-.024.104-.036.218-.101.314-.095.213.125-.142.316.792-.192.532.151-.095.126.538.197.63.254.05.032.048.059.144.077.271.05.267.026.284.243.007.098.107.043.107.168 0 .535.472.266.549.399.012.022.032.042.079.042.149 0 .157-.03.224.089.027.047.05.072.127.096.12.037.112.05.068.138-.054.104.03.102.138.112.1.01.148.062.216.138.11.122.284.156.43.227.084.04.002.14.143.243.104.077.156.066.016.165-.59.418.22.305.446.694.051.087.118.195.216.295.225.23.1.293.221.437.07.083.015.063.13.137.272.175-.105.292-.319.212-.097-.035-.166-.085-.147-.025.016.049-.01.083-.052.12-.125.112.123.068.181.06.181-.025.664-.076.66.093-.005.22.136.27.25.284.185.024.238.057.34.226.092.152.145.07.288.205.097.093.217.258.02.282-.047.005-.099 0-.12.017a.411.411 0 0 1-.14.066c-.295.09.14.136.246.113.093-.02.209-.05.3-.027.057.015.062.08.244.107.06.01.036.099.006.16-.104.214.191.1.16.263-.017.093.11.245-.067.248-.057.001-.117-.015-.115.034.004.105-.165-.03-.317.115-.056.054-.19.092-.272-.009-.032-.038-.07-.069-.218-.023-.144.046-.242.204-.306-.04-.017-.064-.05-.065-.142-.097-.125-.043-.114-.258-.297-.12a.24.24 0 0 1-.214.039c-.144-.037-.303.012-.317-.096-.021-.179-.191-.305-.377-.296-.147.008-.278.034-.355-.137.057.195.207.208.382.208.144 0 .23.075.255.225.045.265.204.099.406.223.1.06.17.159.21.273.042.118.37-.024.282.258-.037.122-.107.168-.242.266-.4.294-.5.004-.618.239-.062.121-.063.031-.196.09-.22.098-.36-.128-.522-.045-.182.094-.168-.08-.352.037-.152.097-.308-.074-.38.192-.063.227-.322.232-.44.11-.189-.194-.132.229-.362.054-.123-.091-.213.043-.392.045-.33.005-.489-.282-.65-.107-.192.206-.331-.032-.334-.242-.003-.216-.777-.144-1.185-.256-.225-.062-.932.013-.702-.35-.372.39.456.366.682.455.136.053.245.095.377.114.13.296.214.617.227 1.007.043-.214.053-.433.028-.649-.043-.383.242.19.276.272.184.45-.022 1.278-.488 1.526a2.957 2.957 0 0 0-.562-.99c.256.392.616 1.192.327 1.65a1.023 1.023 0 0 1-.55-.483c.077.333.413.702.818.58.707-.213.704.233 1.641.307.682.111 1.654 0 2.118.037.254.02 1.32.197 1.315.465-.02 1.105-.438 1.164-1.539 1.268-.64.06-1.134.085-1.823.11-1.54.058-3.391.06-4.868 0-.724-.03-1.072-.036-1.841-.137-.769-.1-1.19-.363-1.178-1.187.005-.304.905-.594 1.2-.628.347-.039.901.005 1.405-.116.527-.127.747-.21 1.135-.508Zm5.347-6.052c-.167-.042-.051-.138-.339-.014-.17.073-.194-.13-.365-.094-.172.036-.242-.125-.499-.166-.318-.05-.088-.133-.592-.032-.097.02-.179-.09-.481-.052-.355.046-.23.084-.445-.115-.272-.251-.488-.082-.767-.184.216.166.368.019.622.221-.242.138-.523.802-.962.844.478.107.709.354 1.148.413.504.068.882.118 1.151.531.301.463.44.196.874.168.275-.017.282-.185.328-.362.063-.245.126-.256.31-.289.213-.037.163-.092.107-.156-.15-.172.019-.207.146-.244.222-.064.042-.075.042-.166-.278-.09-.063-.217.092-.273.169.105.242.087.317.073.109-.021.181.03.273-.028-.135.014-.163-.037-.278-.02-.051.007-.112.01-.219-.054-.18-.107-.27.048-.463 0Zm-2.28 1.64-1.09-.545c-1.316-.657-1.915.313-2.337 1.376l-.766.73c.549-.338.996-.714 1.574-.71.092 0 1.516.484 1.286-.092-.04-.104.09-.052.125-.201.04-.17.055-.141.195-.033.089.069.211.113.174-.048-.017-.072-.04-.137.28-.004.15.062.095-.064.303-.09.29-.034.228-.31.364-.349.076-.022.152.058.295-.077.05-.046.11-.089.232-.057-.143-.073-.22-.014-.292.03-.146.089-.204-.037-.343.07Zm-2.23-1.923c.16-.02.32-.036.482-.046a.13.13 0 0 0 .074-.06.111.111 0 0 0 .007-.09.268.268 0 0 1 .147-.206l-.002-.003c-.258.001-.466.1-.73.211-.052.022-.024.111-.118.213a.26.26 0 0 1-.201.235.136.136 0 0 0-.09.046.113.113 0 0 0-.026.092.252.252 0 0 1-.277.061c-.2-.077-.35-.065-.448.036a.39.39 0 0 1 .398.014c.134.066.3.031.39-.082a.132.132 0 0 1 .126-.098.421.421 0 0 0 .268-.323Z",fill:"#fff"})))};
/***/},
/***/49236:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>a
/* harmony export */});
/* harmony import */var n=t(94715),i=t(87642),r=t(82376),o=t(32694),l=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Quiz block definition.
 */
const a={...o,metadata:o,icon:i/* ["default"] */.A,providesContext:{"sensei-lms/quizId":"id"},edit:r/* ["default"] */.A,save:()=>(0,l.jsx)(n.InnerBlocks.Content,{})};
/* harmony default export */}
/***/,
/***/49500:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>i
/* harmony export */});
/* harmony import */var n=t(62540);
/**
 * Question block multi-line answer component.
 */const i=()=>(0,n.jsx)("div",{className:"sensei-lms-question-block__answer sensei-lms-question-block__answer--multi-line",children:(0,n.jsx)("div",{className:"sensei-lms-question-block__text-input-placeholder multi-line"})});
/* harmony default export */}
/***/,
/***/50394:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>p
/* harmony export */});
/* harmony import */var n=t(56427),i=t(5823),r=t(27723),o=t(86087),l=t(72108),a=t(43952),c=t(37344),u=t(66087),d=t(62540);
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
 * Questions filter.
 *
 * @param {Object}   props
 * @param {Array}    props.questionCategories Question categories.
 * @param {Object}   props.filters            Filters object.
 * @param {Function} props.setFilters         Filters state setter.
 */
const p=({questionCategories:e,filters:s,setFilters:t})=>{const{searchValue:p}=(0,o.useState)(s.search),m=(0,c/* .useQuestionTypes */.v)(),h=(e,s)=>(0,u.debounce)((s=>{t((t=>({...t,[e]:s})))}),s),g=[{value:"",label:(0,r.__)("Type","sensei-lms")},...(m||[]).map((e=>({value:e.id,label:a/* ["default"] */.A[e.slug]?.title})))],_=[{value:"",label:(0,r.__)("Category","sensei-lms")},...(e||[]).map((e=>({value:e.id,label:e.name})))];
return(0,d.jsxs)("ul",{className:"sensei-lms-quiz-block__questions-modal__filters",children:[(0,d.jsx)("li",{children:(0,d.jsx)(n.SelectControl,{options:g,value:s["question-type"],onChange:h("question-type",0)})}),(0,d.jsx)("li",{children:(0,d.jsx)(n.SelectControl,{options:_,value:s["question-category"],onChange:h("question-category",0)})}),(0,d.jsx)("li",{children:(0/* ["default"] */,d.jsx)(l.A,{className:"sensei-lms-quiz-block__questions-modal__search-input",placeholder:(0,r.__)("Search questions","sensei-lms"),iconRight:i/* ["default"] */.A,value:p,onChange:h("search",400)})})]})};
/* harmony default export */}
/***/,
/***/51135:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>r
/* harmony export */});
/* harmony import */var n=t(5573),i=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
const r=(0,i.jsx)(n.SVG,{viewBox:"0 0 24 24",xmlns:"http://www.w3.org/2000/svg",children:(0,i.jsx)(n.Path,{fillRule:"evenodd",clipRule:"evenodd",d:"M5.5 12a6.5 6.5 0 1 0 13 0 6.5 6.5 0 0 0-13 0ZM12 4a8 8 0 1 0 0 16 8 8 0 0 0 0-16Zm.75 4v1.5h-1.5V8h1.5Zm0 8v-5h-1.5v5h1.5Z"})});
/* harmony default export */}
//# sourceMappingURL=info.js.map
/***/,
/***/51609:
/***/e=>{"use strict";e.exports=window.React}
/***/,
/***/52019:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>a
/* harmony export */});
/* harmony import */var n=t(94715),i=t(67357),r=t(74905),o=t(64261),l=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Question answers block.
 */
/* harmony default export */const a={...r,metadata:r,icon:o/* ["default"] */.A,edit:i/* ["default"] */.A,save:()=>(0,l.jsx)(n.InnerBlocks.Content,{})};
/***/},
/***/52485:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>_
/* harmony export */});
/* harmony import */var n=t(94715),i=t(56427),r=t(47143),o=t(86087),l=t(52619),a=t(27723),c=t(60817),u=t(65526),d=t(94542),p=t(18057),m=t(42632),h=t(46602),g=t(62540);
/* harmony import */
/* eslint-disable camelcase */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Quiz settings.
 *
 * @param {Object}   props                    Block props.
 * @param {Object}   props.attributes         Block attributes
 * @param {Object}   props.attributes.options Current setting options.
 * @param {Function} props.setAttributes      Set attributes function.
 * @param {string}   props.clientId           Block ID.
 */
const _=({attributes:{options:e},setAttributes:s,clientId:t})=>{const{passRequired:_,quizPassmark:b,autoGrade:v,allowRetakes:x,randomQuestionOrder:w,showQuestions:k,failedShowAnswerFeedback:f,failedShowCorrectAnswers:j,failedIndicateIncorrect:A,buttonTextColor:y,buttonBackgroundColor:q,pagination:C}=e,S=t=>n=>s({options:{...e,[t]:n}})
// Update the pagination options function used for block settings.
,B=t=>s({options:{...e,pagination:{...C,...t}}}),N=(0,m/* .useOpenQuizSettings */.a)(t),P=(0,r.useSelect)((e=>e("core/block-editor").getBlock(t).innerBlocks.filter((e=>!(0,u/* .isQuestionEmpty */.cm)(e.attributes)))),[t]).reduce(((e,s)=>e+("category-question"===s.attributes.type?s.attributes.options.number:1)),0),E=(0,l.applyFilters)("senseiQuizTimerHide",!1);return(0,o.useEffect)((()=>{k>P&&s({options:{...e,showQuestions:P}})}),[e,P,s,k]),(0,g.jsxs)(g.Fragment,{children:[(0,g.jsx)("div",{className:"sensei-lms-quiz-block__settings-quick-nav",children:(0,g.jsx)(i.Button,{onClick:N,icon:h/* ["default"] */.A,children:(0,a.__)("Quiz settings","sensei-lms")})}),(0,g.jsx)(n.InspectorControls,{children:(0,g.jsxs)("div",{className:"sensei-lms-quiz-block__settings-wrapper",children:[(0,g.jsxs)(i.PanelBody,{title:(0,a.__)("Quiz settings","sensei-lms"),initialOpen:!0,children:[(0,g.jsx)(i.PanelRow,{children:(0,g.jsx)(i.ToggleControl,{checked:_,onChange:S("passRequired"),label:(0,a.__)("Pass Required","sensei-lms")})}),_&&(0,g.jsxs)(g.Fragment,{children:[(0,g.jsx)(i.PanelRow,{children:(0,g.jsx)(i.RangeControl,{label:(0,a.__)("Passing Grade (%)","sensei-lms"),value:b,onChange:S("quizPassmark"),min:0,max:100,initialPosition:100})}),(0,g.jsx)(i.PanelRow,{children:(0,g.jsxs)("div",{children:[(0,g.jsx)(i.BaseControl,{id:"sensei-lms-quiz-block-failed-feedback-options",className:"sensei-lms-subsection-control",help:(0,a.__)("What students see when reviewing their quiz after grading.","sensei-lms"),children:(0,g.jsx)("h3",{children:(0,a.__)("If student does not pass quiz","sensei-lms")})}),(0,g.jsx)(i.ToggleControl,{checked:A,onChange:S("failedIndicateIncorrect"),label:(0,a.__)("Indicate which questions are incorrect.","sensei-lms")}),(0,g.jsx)(i.ToggleControl,{checked:j,onChange:S("failedShowCorrectAnswers"),label:(0,a.__)("Show correct answers.","sensei-lms")}),(0,g.jsx)(i.ToggleControl,{checked:f,onChange:S("failedShowAnswerFeedback"),label:(0,a.__)("Show “Answer Feedback” text.","sensei-lms")})]})}),(0,g.jsx)("hr",{})]}),(0,g.jsx)(i.PanelRow,{children:(0,g.jsx)(i.ToggleControl,{checked:v,onChange:S("autoGrade"),label:(0,a.__)("Auto Grade","sensei-lms"),help:(0,a.__)("Automatically grade Multiple Choice, True/False and Gap Fill questions that have a non-zero point value.","sensei-lms")})}),(0,g.jsx)(i.PanelRow,{children:(0,g.jsx)(i.ToggleControl,{checked:x,onChange:S("allowRetakes"),label:(0,a.__)("Allow Retakes","sensei-lms")})}),(0,g.jsx)(i.PanelRow,{children:(0,g.jsx)(i.ToggleControl,{checked:w,onChange:S("randomQuestionOrder"),label:(0,a.__)("Random Question Order","sensei-lms")})}),w&&(0,g.jsx)(o.Fragment,{children:(0,g.jsx)(i.PanelRow,{children:(0/* ["default"] */,g.jsx)(c.A,{id:"sensei-quiz-settings-show-questions",label:(0,a.__)("Number of Questions","sensei-lms"),help:(0,a.__)("Display a random selection of questions.","sensei-lms"),allowReset:!0,resetLabel:(0,a.__)("All","sensei-lms"),min:0,max:P,step:1,value:k,placeholder:(0,a.__)("All","sensei-lms"),onChange:S("showQuestions")})})}),(0,g.jsx)(i.Slot,{name:"SenseiQuizSettings"}),!E&&(0,g.jsx)(i.PanelRow,{children:(0/* ["default"] */,g.jsx)(p.A,{})})]}),(0/* .PaginationSidebarSettings */,g.jsx)(d.c,{settings:C,updatePagination:B}),(0,g.jsx)(n.PanelColorSettings,{title:(0,a.__)("Color settings","sensei-lms"),initialOpen:!1,colorSettings:[{value:y||void 0,onChange:S("buttonTextColor"),label:(0,a.__)("Button text color","sensei-lms")},{value:q||void 0,onChange:S("buttonBackgroundColor"),label:(0,a.__)("Button background color","sensei-lms")},{value:C?.progressBarColor||void 0,onChange:e=>B({progressBarColor:e}),label:(0,a.__)("Progress bar color","sensei-lms")},{value:C?.progressBarBackground||void 0,onChange:e=>B({progressBarBackground:e}),label:(0,a.__)("Progress bar background color","sensei-lms")}]})]})}),(0,g.jsx)(n.BlockControls,{children:(0/* .PaginationToolbarSettings */,g.jsx)(d.t,{settings:C,updatePagination:B})})]})};
/* harmony default export */}
/***/,
/***/52619:
/***/e=>{"use strict";e.exports=window.wp.hooks}
/***/,
/***/54323:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */N:()=>/* binding */o
/* harmony export */});
/* unused harmony export useBlockValidation */
/* harmony import */var n=t(86087),i=t(29491),r=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Validate block attributes. Requires block metadata.
 *
 * @param {Function} validateBlock    Validate function.
 * @param {Object}   props
 * @param {string}   props.attributes Block attributes.
 * @param {Function} props.setMeta    Block meta setter.
 */
const o=e=>(0,i.createHigherOrderComponent)((s=>t=>(((e,{attributes:s,setMeta:t})=>{(0,n.useEffect)((()=>{const n=l(e(s));t({validationErrors:n})}),[e,s,t])})(e,t),(0,r.jsx)(s,{...t}))),"withBlockValidation")
/**
 * Get errors from validation result.
 *
 * @param {Object} result Validation result.
 * @return {Array} Items that have failed validation.
 */,l=(e={})=>Object.entries(e).filter((([,e])=>e)).map((([e])=>e))
/***/;
/**
 * Validate block attributes. Requires block metadata.
 *
 * @param {Function} validateBlock Validate function.
 */},
/***/54675:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */S:()=>/* binding */d
/* harmony export */});
/* unused harmony export QUIZ_STORE */
/* harmony import */var n=t(66087),i=t(47143),r=t(86087),o=t(27723),l=t(63492),a=t(65526);
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
const c="sensei/quiz-structure",u=["categories","shared","options.studentHelp","media","categoryName","lock"];
/**
 * Syncronize this block with quiz data.
 *
 * @param {Object} props
 * @param {string} props.clientId Block ID.
 */
function d({clientId:e}){const{setBlock:s,loadStructure:t}=(0,i.useDispatch)(c);(0,r.useEffect)((()=>(s(e),t(),()=>{s(null)})),[s,t,e])}(0,l/* .registerStructureStore */.W)({storeName:c,*getEndpoint(){return`lesson-quiz/${yield(0,i.select)("core/editor").getCurrentPostId()}?context=edit`},
/**
   * Update Quiz block with settings and questions.
   *
   * @param {Object} structure Quiz structure.
   */
*updateBlock(e){const s=yield(0,i.select)(c).getBlock();if(!s||!e)return;if(!(yield(0,i.select)("core/block-editor").getBlock(s)))return;if(yield(0,i.dispatch)("core/block-editor").updateBlockAttributes(s,{options:(0,a/* .normalizeAttributes */.BI)(e.options,n.camelCase)}),!e.questions?.length)return;const t=yield(0,i.select)("core/block-editor").getBlocks(s);yield(0,i.dispatch)("core/block-editor").replaceInnerBlocks(s,(0,a/* .syncQuestionBlocks */.ui)(e.questions,t),!1)},
/**
   * Checks if quiz block exists.
   */
blockExists(){const e=(0,i.select)(c).getBlock();return!!(0,i.select)("core/block-editor").getBlock(e)},
/**
   * Parse question blocks and quiz settings from Quiz block.
   *
   * @throws {Object} Quiz structure.
   */
readBlock(){const e=(0,i.select)(c).getBlock();if(!e)return;const s=(0,i.select)("core/block-editor").getBlock(e);if(!s)return;const t=(0,a/* .normalizeAttributes */.BI)(s.attributes.options,n.snakeCase),r=(0,i.select)("core/editor").getCurrentPost(),o=(0,i.select)(c).getServerStructure(),l=(0,i.select)("core/block-editor").getBlocks(e);let d=[];if(0<l.length&&o){const e=(0,a/* .parseQuestionBlocks */.gI)(l),s=(0,n.keyBy)(o.questions,"id");d=e.map((e=>
// Avoid overriding non-editable question.
!1===e.editable?s[e.id]:(0,n.omit)(e,u)))}return{lesson_status:r?.status,lesson_title:r?.title,options:t,questions:d}},*fetchError(e){const s=(0,o.sprintf)(/* translators: Error message. */ /* translators: Error message. */
(0,o.__)("Quiz settings and questions could not be loaded. %s","sensei-lms"),e.message);yield(0,i.dispatch)("core/notices").createErrorNotice(s,{id:"quiz-structure-save-error"})},
/**
   * Display save error notice.
   *
   * @param {Object} error
   */
*saveError(e){const s=(0,o.sprintf)(/* translators: Error message. */ /* translators: Error message. */
(0,o.__)("Quiz settings and questions could not be updated. %s","sensei-lms"),e.message);yield(0,i.dispatch)("core/notices").createErrorNotice(s,{id:"quiz-structure-save-error"})},
/**
   * Clear error notices.
   */
clearError(){(0,i.dispatch)("core/notices").removeNotice("quiz-structure-save-error")},
/**
   * Remove derived elements from quiz response.
   *
   * @param {Object} structure The quiz response.
   *
   * @return {Object} The modified response.
   */
setServerStructure:e=>e?{...e,questions:e.questions.map((e=>(0,n.omit)(e,u)))}:{}})}
/***/,
/***/55014:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>a
/* harmony export */});
/* harmony import */var n=t(94715),i=t(89619),r=t(56292),o=t(64261),l=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Question description block.
 */
/* harmony default export */const a={...r,metadata:r,icon:o/* ["default"] */.A,usesContext:["sensei-lms/quizId"],edit:i/* ["default"] */.A,save:()=>(0,l.jsx)(n.InnerBlocks.Content,{})};
/***/},
/***/56003:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>/* binding */r
/* harmony export */});
// Unique ID creation requires a high quality random # generator. In the browser we therefore
// require the crypto API and do not support built-in fallback to lower quality random number
// generators (like Math.random()).
// getRandomValues needs to be invoked in a context where "this" is a Crypto implementation. Also,
// find the complete implementation of crypto (msCrypto) on IE11.
var n="undefined"!=typeof crypto&&crypto.getRandomValues&&crypto.getRandomValues.bind(crypto)||"undefined"!=typeof msCrypto&&"function"==typeof msCrypto.getRandomValues&&msCrypto.getRandomValues.bind(msCrypto),i=new Uint8Array(16);// eslint-disable-line no-undef
function r(){if(!n)throw new Error("crypto.getRandomValues() not supported. See https://github.com/uuidjs/uuid#getrandomvalues-not-supported");return n(i)}
/***/},
/***/56292:
/***/e=>{"use strict";e.exports=JSON.parse('{"name":"sensei-lms/question-description","apiVersion":2,"title":"Description","description":"Question Description.","parent":["sensei-lms/quiz-question"],"category":"sensei-lms","textdomain":"sensei-lms","supports":{"html":false},"attributes":{"id":{"type":"integer"}}}')}
/***/,
/***/56427:
/***/e=>{"use strict";e.exports=window.wp.components}
/***/,
/***/56536:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>a
/* harmony export */});
/* harmony import */var n=t(56427),i=t(27723),r=t(13804),o=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Answer component for question blocks with true/false type.
 *
 * @param {Object}   props
 * @param {Object}   props.attributes
 * @param {boolean}  props.attributes.correct The correct answer.
 * @param {Function} props.setAttributes
 * @param {boolean}  props.hasSelected        Is question block selected.
 */
const l=({attributes:{correct:e=!0},setAttributes:s,hasSelected:t})=>{const l=[{label:(0,i.__)("True","sensei-lms"),value:!0},{label:(0,i.__)("False","sensei-lms"),value:!1}];
return(0,o.jsx)("ul",{className:"sensei-lms-question-block__answer sensei-lms-question-block__answer--true-false",children:l.map((({label:l,value:a})=>(0,o.jsxs)("li",{className:"sensei-lms-question-block__answer--true-false__option",children:[(0/* .OptionToggle */,o.jsx)(r.c,{isChecked:e===a,children:(0,o.jsx)("span",{children:l})}),t&&(0,o.jsx)("div",{className:"sensei-lms-question-block__answer--multiple-choice__toggle__wrapper",children:(0,o.jsxs)(n.Button,{isPrimary:!0,className:"sensei-lms-question-block__answer--true-false__toggle",onClick:()=>s({correct:a===e?!a:a}),children:[e===a&&(0,i.__)("Right","sensei-lms"),e!==a&&(0,i.__)("Wrong","sensei-lms")]})})]},a)))})};
/**
 * Read-only answer component true/false question block.
 *
 * @param {Object}  props
 * @param {Object}  props.attributes
 * @param {boolean} props.attributes.correct The correct answer.
 */l.view=({attributes:{correct:e=!0}})=>{const s=[{label:(0,i.__)("True","sensei-lms"),value:!0},{label:(0,i.__)("False","sensei-lms"),value:!1}];
return(0,o.jsx)("ul",{className:"sensei-lms-question-block__answer sensei-lms-question-block__answer--true-false",children:s.map((({label:s,value:t})=>(0,o.jsx)("li",{className:"sensei-lms-question-block__answer--true-false__option",children:(0/* .OptionToggle */,o.jsx)(r.c,{isChecked:e===t,children:(0,o.jsx)("span",{children:s})})},t)))})};
/* harmony default export */const a=l;
/***/},
/***/57198:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>p
/* harmony export */});
/* harmony import */var n=t(56427),i=t(86087),r=t(27723),o=t(14309),l=t(43656),a=t(92859),c=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
const u=l.PluginPostStatusInfo||o.PluginPostStatusInfo,d=l.PluginPrePublishPanel||o.PluginPrePublishPanel,p=e=>{const{meta:{validationErrors:s,showValidationErrors:t},setMeta:o}=e,l=(0,i.useCallback)(((e=!0)=>{o({showValidationErrors:e})}),[o]);if((0,a/* .usePostSavingEffect */.X9)((()=>l(!1)),[l]),!s?.length)return null;const p=(0,c.jsx)(n.Notice,{isDismissible:!1,status:"warning",className:"sensei-lms-quiz-block__pre-publish-validation__notice",actions:t?[]:[{label:(0,r.__)("View issues","sensei-lms"),onClick:()=>l(!0),className:"is-link"}],children:(0,r.__)("This question is incomplete.","sensei-lms")});
return(0,c.jsxs)(c.Fragment,{children:[(0,c.jsx)(u,{children:p}),(0,c.jsxs)(d,{title:(0,r.__)("Validation","sensei-lms"),initialOpen:!0,children:[(0/* .Effect */,c.jsx)(a.Mj,{onMount:l}),p,(0,c.jsx)("p",{children:(0,r.__)("Incomplete questions added to a quiz won't be displayed to the student.","sensei-lms")})]})]})}}
/***/,
/***/60798:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>r
/* harmony export */});
/* harmony import */var n=t(56003),i=t(96603);
/* harmony import */
/* harmony default export */const r=function(e,s,t){var r=s&&t||0;"string"==typeof e&&(s="binary"===e?new Array(16):null,e=null);var o=(e=e||{}).random||(e.rng||n/* ["default"] */.A)();// Per 4.4, set bits for version and `clock_seq_hi_and_reserved`
// Copy bytes to buffer, if provided
if(o[6]=15&o[6]|64,o[8]=63&o[8]|128,s)for(var l=0;l<16;++l)s[r+l]=o[l];return s||(0,i/* ["default"] */.A)(o)};
/***/},
/***/60817:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>a
/* harmony export */});
/* harmony import */var n=t(4452),i=t.n(n),r=t(56427),o=t(27723),l=t(62540);
/* harmony import */
/**
 * External dependencies
 */
/**
 * WordPress dependencies
 */
/**
 * Number control component.
 *
 * @param {Object}   props                     Component props.
 * @param {string}   [props.className]         Additional classnames for the input.
 * @param {string}   [props.id]                Component id used to connect label and input - required if label is set.
 * @param {string}   [props.label]             Input label.
 * @param {number}   [props.value]             Input value.
 * @param {string}   [props.help]              Help text.
 * @param {boolean}  [props.allowReset=false]  Whether reset is allowed.
 * @param {string}   [props.resetLabel]        Reset button custom label.
 * @param {Function} props.onChange            Change function, which receives number as argument.
 * @param {string}   props.suffix              Input suffix.
 * @param {boolean}  props.hideLabelFromVision Hides label.
 */
const a=({className:e,id:s,label:t,value:n,help:a,allowReset:c=!1,resetLabel:u,onChange:d,suffix:p,hideLabelFromVision:m,...h})=>(0,l.jsx)(r.BaseControl,{id:s,label:t,help:a,hideLabelFromVision:m,children:(0,l.jsxs)("div",{className:"sensei-number-control",children:[(0,l.jsxs)("div",{className:"sensei-number-control__input-container",children:[(0,l.jsx)("input",{className:i()("sensei-number-control__input components-text-control__input",e),type:"number",id:s,onChange:e=>{d(parseInt(e.target.value,10)||h.min||0)},value:null===n?"":n,...h}),p&&(0,l.jsx)("span",{className:"sensei-number-control__input-suffix",children:p})]}),c&&(0,l.jsx)(r.Button,{className:"sensei-number-control__button",isSmall:!0,isSecondary:!0,onClick:()=>d(null),children:u||(0,o.__)("Reset","sensei-lms")})]})});
/* harmony default export */}
/***/,
/***/60929:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>r
/* harmony export */});
/* harmony import */var n=t(27723),i=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Question block single-line answer component.
 *
 * @param {Object} props
 * @param {Object} props.children
 */
const r=({children:e})=>(0,i.jsxs)("div",{className:"sensei-lms-question-block__answer sensei-lms-question-block__answer--single-line",children:[(0,i.jsx)("small",{className:"sensei-lms-question-block__input-label",children:(0,n.__)("Answer:","sensei-lms")}),(0,i.jsx)("div",{className:"sensei-lms-question-block__text-input-placeholder",children:e})]});
/* harmony default export */}
/***/,
/***/61912:
/***/(e,s,t)=>{"use strict";
/* unused harmony export preloadedDataUsedOnceMiddleware */
/* harmony import */var n=t(93832),i=t(1455);
/* harmony import */t.n(i)().use(
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
/***/63160:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>c
/* harmony export */});
/* harmony import */var n=t(94715),i=t(27723),r=t(37424),o=t(79794),l=t(64261),a=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Quiz category question block definition.
 */
/* harmony default export */const c={...o,metadata:o,icon:l/* ["default"] */.A,usesContext:["sensei-lms/quizId"],example:{attributes:{categoryName:(0,i.__)("Example Category","sensei-lms")}},edit:r/* ["default"] */.A,save:()=>(0,a.jsx)(n.InnerBlocks.Content,{}),messages:{noCategory:(0,i.__)("Assign a category to this question.","sensei-lms")}};
/***/},
/***/63492:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */W:()=>/* binding */l
/* harmony export */});
/* harmony import */var n=t(66087),i=t(66161),r=t(47143),o=t(77505);
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
function l({storeName:e,getEndpoint:s,saveError:t,fetchError:l,clearError:a,updateBlock:c,blockExists:u,readBlock:d,setServerStructure:p,registry:m,...h}){const g=m?m.dispatch:r.dispatch,_=m?m.select:r.select,b=m?m.subscribe:r.subscribe,v={
/**
     * Fetch structure data from REST API.
     */
*loadStructure(){try{const e=yield*s(),t=yield(0,i.apiFetch)({path:`/sensei-internal/v1/${e}`,method:"GET"});yield v.setResult(t)}catch(e){yield l?.(e)}},
/**
     * Persist editor's structure to the REST API.
     */
*saveStructure(){const n=yield _(e).getEditorStructure();try{const e=yield*s(),t=yield(0,i.apiFetch)({path:`/sensei-internal/v1/${e}`,method:"POST",data:n});yield v.setResult(t)}catch(e){yield t?.(e)}},
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
*savePost(){yield{type:"SAVE_POST"},yield g("core/editor").savePost()},
/**
     * Post is saving. Save the structure too if it has changed.
     */
*startPostSave(){yield{type:"START_SAVE"};const s=d();yield v.setEditorStructure(s),yield a?.(),s&&(_(e).hasUnsavedEditorChanges()&&(yield*v.saveStructure()),yield{type:"FINISH_SAVE"})},
/**
     * Finished saving post and structure.
     * Check if either needs to be saved again due to new changes.
     */
*finishPostSave(){yield{type:"FINISH_POST_SAVE"};const{hasUnsavedServerUpdates:s}=_(e);s()&&(yield*v.savePost())},
/**
     * Set linked block.
     *
     * @param {string} clientId Block ID.
     */
*setBlock(e){yield{type:"SET_BLOCK",clientId:e}}},x={SET_SERVER_STRUCTURE:({serverStructure:e},s)=>{const t=!s.editorStructure,i=p?p(e):e,r=!t&&!(0,n.isEqual)(i,s.editorStructure);return{...s,serverStructure:i,hasUnsavedServerUpdates:r,hasUnsavedEditorChanges:!1}},SET_EDITOR_STRUCTURE:({editorStructure:e},s)=>{const t=!(0,n.isEqual)(s.serverStructure,e);return{...s,editorStructure:e,hasUnsavedEditorChanges:t&&!!e}},START_SAVE:(e,s)=>({...s,isSavingStructure:!0}),FINISH_SAVE:(e,s)=>({...s,isSavingStructure:!1}),SAVE_POST:(e,s)=>({...s,hasUnsavedServerUpdates:!1}),SET_BLOCK:({clientId:e},s)=>({...s,clientId:e}),DEFAULT:(e,s)=>s},w=m?m.registerStore:r.registerStore;return{unsubscribe:(()=>{let s=!1,t=!1,n=!1;return b((function(){const i=_("core/editor"),r=_("core/edit-post");if(!i||!r)return;
// Check if the block exists.
if(!u())return;const o=_(e).getIsSavingStructure(),l=i.isSavingPost()&&!i.isAutosavingPost();l&&(t=!0);const a=r.isSavingMetaBoxes();a&&(n=!0),s||l||a||!t||!n?s&&!o&&(
// Call finishPostSave when structure has finished saving.
s=!1,g(e).finishPostSave()):(
// Start saving structure when post has finished saving.
s=!0,t=!1,n=!1,g(e).startPostSave())}))})(),store:w(e,{reducer:(0,o/* .createReducerFromActionMap */.$x)({...x,...h?.reducers},{serverStructure:null,editorStructure:null,isSavingStructure:!1,hasUnsavedServerUpdates:!1,hasUnsavedEditorChanges:!1,clientId:null}),actions:{...v,...h?.actions},selectors:{hasUnsavedServerUpdates:({hasUnsavedServerUpdates:e})=>e,hasUnsavedEditorChanges:({hasUnsavedEditorChanges:e})=>e,getIsSavingStructure:({isSavingStructure:e})=>e,getServerStructure:({serverStructure:e})=>e,getEditorStructure:({editorStructure:e})=>e,getBlock:({clientId:e})=>e,...h?.selectors},controls:{...i.controls,...h?.controls}})}}
/***/},
/***/64261:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>l
/* harmony export */});
/* harmony import */var n,i,r=t(51609);
/* harmony import */function o(){return o=Object.assign?Object.assign.bind():function(e){for(var s=1;s<arguments.length;s++){var t=arguments[s];for(var n in t)({}).hasOwnProperty.call(t,n)&&(e[n]=t[n])}return e},o.apply(null,arguments)}
/* harmony default export */const l=function(e){
return r.createElement("svg",o({xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24"},e),n||(n=r.createElement("path",{d:"M12.408 7.277A2.999 2.999 0 0 0 9 10.25h1.5c0-.677.375-1.14.886-1.37.512-.228 1.11-.198 1.614.253.504.45.6 1.04.43 1.574-.171.534-.592.958-1.264 1.033l.021-.002a1.034 1.034 0 0 0-.937.99V14h1.5v-.95c1.02-.28 1.817-.979 2.107-1.888a2.998 2.998 0 0 0-2.449-3.885z"})),i||(i=r.createElement("path",{d:"M6 4c-1.096 0-2 .904-2 2v12c0 1.096.904 2 2 2h12c1.096 0 2-.904 2-2V6c0-1.096-.904-2-2-2H6zm0 1.5h12c.284 0 .5.216.5.5v12a.49.49 0 0 1-.5.5H6a.49.49 0 0 1-.5-.5V6c0-.284.216-.5.5-.5zm5.25 9.5v1.5h1.5V15h-1.5z"})))};
/***/},
/***/65195:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>o
/* harmony export */});
/* harmony import */var n=t(27723),i=t(68523),r=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Question block grade settings.
 *
 * @param {Object}   props
 * @param {Object}   props.options
 * @param {number}   props.options.grade Question grade.
 * @param {Function} props.setOptions
 */
const o=({options:{grade:e=1},setOptions:s})=>(0/* .QuestionGradeControl */,r.jsx)(i.l,{label:(0,n.__)("Grade","sensei-lms"),value:e,onChange:e=>s({grade:null!=e?e:1}),allowReset:!0});
/* harmony default export */}
/***/,
/***/65470:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>/* export default binding */o
/* harmony export */});
/** @typedef {(...args: any[]) => *[]} GetDependants */
/** @typedef {() => void} Clear */
/**
 * @typedef {{
 *   getDependants: GetDependants,
 *   clear: Clear
 * }} EnhancedSelector
 */
/**
 * Internal cache entry.
 *
 * @typedef CacheNode
 *
 * @property {?CacheNode|undefined} [prev] Previous node.
 * @property {?CacheNode|undefined} [next] Next node.
 * @property {*[]} args Function arguments for cache entry.
 * @property {*} val Function result.
 */
/**
 * @typedef Cache
 *
 * @property {Clear} clear Function to clear cache.
 * @property {boolean} [isUniqueByDependants] Whether dependants are valid in
 * considering cache uniqueness. A cache is unique if dependents are all arrays
 * or objects.
 * @property {CacheNode?} [head] Cache head.
 * @property {*[]} [lastDependants] Dependants from previous invocation.
 */
/**
 * Arbitrary value used as key for referencing cache object in WeakMap tree.
 *
 * @type {{}}
 */
var n={};
/**
 * Returns the first argument as the sole entry in an array.
 *
 * @template T
 *
 * @param {T} value Value to return.
 *
 * @return {[T]} Value returned as entry in array.
 */function i(e){return[e]}
/**
 * Returns true if the value passed is object-like, or false otherwise. A value
 * is object-like if it can support property assignment, e.g. object or array.
 *
 * @param {*} value Value to test.
 *
 * @return {boolean} Whether value is object-like.
 */
/**
 * Returns true if entries within the two arrays are strictly equal by
 * reference from a starting index.
 *
 * @param {*[]} a First array.
 * @param {*[]} b Second array.
 * @param {number} fromIndex Index from which to start comparison.
 *
 * @return {boolean} Whether arrays are shallowly equal.
 */
function r(e,s,t){var n;if(e.length!==s.length)return!1;for(n=t;n<e.length;n++)if(e[n]!==s[n])return!1;return!0}
/**
 * Returns a memoized selector function. The getDependants function argument is
 * called before the memoized selector and is expected to return an immutable
 * reference or array of references on which the selector depends for computing
 * its own return value. The memoize cache is preserved only as long as those
 * dependant references remain the same. If getDependants returns a different
 * reference(s), the cache is cleared and the selector value regenerated.
 *
 * @template {(...args: *[]) => *} S
 *
 * @param {S} selector Selector function.
 * @param {GetDependants=} getDependants Dependant getter returning an array of
 * references used in cache bust consideration.
 */
/* harmony default export */function o(e,s){
/** @type {WeakMap<*,*>} */
var t,o=s||i;
/** @type {GetDependants} */
/**
	 * Resets root memoization cache.
	 */
function l(){t=new WeakMap}
/* eslint-disable jsdoc/check-param-names */
/**
	 * The augmented selector call, considering first whether dependants have
	 * changed before passing it to underlying memoize function.
	 *
	 * @param {*}    source    Source object for derivation.
	 * @param {...*} extraArgs Additional arguments to pass to selector.
	 *
	 * @return {*} Selector result.
	 */
/* eslint-enable jsdoc/check-param-names */function a(){var s,i,l,a,c,u=arguments.length;
// Create copy of arguments (avoid leaking deoptimization).
for(a=new Array(u),l=0;l<u;l++)a[l]=arguments[l];for(s=
/**
	 * Returns the cache for a given dependants array. When possible, a WeakMap
	 * will be used to create a unique cache for each set of dependants. This
	 * is feasible due to the nature of WeakMap in allowing garbage collection
	 * to occur on entries where the key object is no longer referenced. Since
	 * WeakMap requires the key to be an object, this is only possible when the
	 * dependant is object-like. The root cache is created as a hierarchy where
	 * each top-level key is the first entry in a dependants set, the value a
	 * WeakMap where each key is the next dependant, and so on. This continues
	 * so long as the dependants are object-like. If no dependants are object-
	 * like, then the cache is shared across all invocations.
	 *
	 * @see isObjectLike
	 *
	 * @param {*[]} dependants Selector dependants.
	 *
	 * @return {Cache} Cache object.
	 */
function(e){var s,i,r,o,l,a=t,c=!0;for(s=0;s<e.length;s++){
// Can only compose WeakMap from object-like key.
if(!(l=i=e[s])||"object"!=typeof l){c=!1;break}
// Does current segment of cache already have a WeakMap?
a.has(i)?
// Traverse into nested WeakMap.
a=a.get(i):(
// Create, set, and traverse into a new one.
r=new WeakMap,a.set(i,r),a=r)}
// We use an arbitrary (but consistent) object as key for the last item
// in the WeakMap to serve as our running cache.
return a.has(n)||((o=
/**
 * Creates and returns a new cache object.
 *
 * @return {Cache} Cache object.
 */
function(){
/** @type {Cache} */
var e={clear:function(){e.head=null}};return e}()).isUniqueByDependants=c,a.set(n,o)),a.get(n)}(c=o.apply(null,a)),
// If not guaranteed uniqueness by dependants (primitive type), shallow
// compare against last dependants and, if references have changed,
// destroy cache to recalculate result.
s.isUniqueByDependants||(s.lastDependants&&!r(c,s.lastDependants,0)&&s.clear(),s.lastDependants=c),i=s.head;i;){
// Check whether node arguments match arguments
if(r(i.args,a,1))
// Return immediately
// At this point we can assume we've found a match
// Surface matched node to head if not already
return i!==s.head&&(
// Adjust siblings to point to each other.
/** @type {CacheNode} */i.prev.next=i.next,i.next&&(i.next.prev=i.prev),i.next=s.head,i.prev=null,
/** @type {CacheNode} */s.head.prev=i,s.head=i),i.val;i=i.next}
// No cached value found. Continue to insertion phase:
return i=/** @type {CacheNode} */{
// Generate the result from original function
val:e.apply(null,a)},
// Avoid including the source object in the cache.
a[0]=null,i.args=a,
// Don't need to check whether node is already head, since it would
// have been returned above already if it was
// Shift existing head down list
s.head&&(s.head.prev=i,i.next=s.head),s.head=i,i.val}return a.getDependants=o,a.clear=l,l(),/** @type {S & EnhancedSelector} */a}
/***/},
/***/65526:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */BI:()=>/* binding */p
/* harmony export */,Cl:()=>/* binding */u
/* harmony export */,bE:()=>/* binding */d
/* harmony export */,cm:()=>/* binding */m
/* harmony export */,gI:()=>/* binding */c
/* harmony export */,ui:()=>/* binding */a
/* harmony export */});
/* harmony import */var n=t(74997),i=t(47143),r=t(75057),o=t(63160),l=t(66087);
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
 * Quiz settings and questions data.
 *
 * @typedef {Object} QuizStructure
 * @property {Object}         settings  Quiz settings.
 * @property {QuizQuestion[]} questions Questions.
 */
/**
 * Quiz question data.
 *
 * @typedef {Object} QuizQuestion
 * @property {number} id          Question ID.
 * @property {string} type        Question type
 * @property {string} title       Question title
 * @property {string} description Question description blocks
 * @property {Object} answers     Question answer settings
 * @property {Object} options     Question options.
 */
/**
 * Quiz category question data.
 *
 * @typedef {Object} QuizCategoryQuestion
 * @property {number} id               Question ID.
 * @property {string} type             Question type
 * @property {Object} options          Question settings
 * @property {number} options.category Category for question.
 * @property {number} options.number   Number of questions to show from category.
 */
/**
 * Create blocks based on the structure, keeping existing block attributes.
 *
 * Matches blocks based on question ID.
 *
 * @param {QuizQuestion[]} structure Quiz questions.
 * @param {Object[]}       blocks    Existing blocks.
 * @return {Object[]} Updated blocks.
 */
function a(e,s){return e&&0!==e.length?(e||[]).map((e=>{const{description:t,...r}=e;let o=s?d(s,e):null;if(o){o.attributes={...o.attributes,...r};const e=t&&(0,n.rawHandler)({HTML:t})||[];(0,i.dispatch)("core/block-editor").replaceInnerBlocks(o.clientId,e)}else o=u(e);return o})):[(0,n.createBlock)("sensei-lms/quiz-question",{})]}
/**
 * Manually run our deprecated migrations for the question block.
 *
 * @param {Object} attributes  Block attributes.
 * @param {Array}  innerBlocks Inner blocks.
 * @return {Array} Tuple of attributes and innerBlocks
 */
/**
 * Convert blocks to question structure.
 *
 * @param {Object[]} blocks Blocks.
 *
 * @return {QuizQuestion[]} Question structure
 */
function c(e){const s=e?.map((e=>{const s=(0,l.omit)(e.attributes,["className"]);return"category-question"===e.attributes.type?s:{...s,description:(0,n.getBlockContent)(e)}}));if(0===s.length)return s;const t=s.pop();return m(t)||s.push(t),s}
/**
 * Create a new question block.
 *
 * @param {Object} question Question item.
 *
 * @return {QuizQuestion} Block.
 */function u(e){if("category-question"===e.type)return(0/* ["default"] */,n.createBlock)(o.A.name,e,[]);const[s,t]=function(e,s){return r/* ["default"] */.A.deprecated.forEach((t=>{
// Check our flag for deprecations that should run here.
t.onProgrammaticCreation&&t.isEligible(e,s)&&([e,s]=t.migrate(e,s))})),[e,s]}(e,e.description&&(0,n.rawHandler)({HTML:e.description})||[]);return(0/* ["default"] */,n.createBlock)(r.A.name,s,t)}
/**
 * Find a question block based on question ID, or title if ID is missing.
 *
 * @param {Array}                             blocks
 * @param {QuizQuestion|QuizCategoryQuestion} item
 */const d=(e,{id:s,title:t,options:n})=>{const i=n?.category;return e.find((({attributes:e})=>s===e.id||!e.id&&e.title&&e.title===t||!e.id&&e.options?.category&&e.options?.category===i))},p=(e,s)=>{const t=(0,l.mapKeys)(e,((e,t)=>s(t)));return(0,l.mapValues)(t,(e=>(0,l.isObject)(e)?p(e,s):e))},m=e=>"category-question"===e.type?!e.options.category:!e.title;
/**
 * Normalize an object by applying a mapping function to it's keys, including nested ones.
 *
 * @param {Object}   options     Options object to normalize.
 * @param {Function} mapFunction Function to apply.
 */}
/***/,
/***/66047:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */P:()=>/* binding */r
/* harmony export */,s:()=>/* binding */i
/* harmony export */});
/* harmony import */var n=t(63160);
/**
 * Internal dependencies
 */
/**
 * Validate category question block.
 *
 * @param {Object} attributes Block attributes.
 * @return {Array} Validation errors.
 */const i=e=>{const{options:s}=e;return{noCategory:!(s?.category>0)}},r=e=>e.map((e=>n/* ["default"] */.A.messages[e]))
/***/;
/**
 * Get messages for the validation errors.
 *
 * @param {string} errors Error codes.
 * @return {string} Error message.
 */},
/***/66087:
/***/e=>{"use strict";e.exports=window.lodash}
/***/,
/***/66161:
/***/e=>{"use strict";e.exports=window.wp.dataControls}
/***/,
/***/66719:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>c
/* harmony export */});
/* harmony import */var n=t(66087),i=t(47143),r=t(56427),o=t(27723),l=t(43952),a=t(62540);
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
 * Questions for selection.
 *
 * @param {Object}   props
 * @param {string}   props.clientId               Quiz block ID.
 * @param {Array}    props.questionCategories     Question categories.
 * @param {Object}   props.filters                Filters object.
 * @param {number[]} props.selectedQuestionIds    Seleted question IDs.
 * @param {Object}   props.setSelectedQuestionIds Seleted question IDs state setter.
 */
const c=({clientId:e,questionCategories:s,filters:t,selectedQuestionIds:c,setSelectedQuestionIds:u})=>{
// Ids of the already added questions.
const d=(0,i.useSelect)((s=>s("core/block-editor").getBlocks(e))).map((e=>e.attributes?.id));
// Questions by current filter.
let p=(0,i.useSelect)((e=>e("core").getEntityRecords("postType","question",{per_page:100,...(0,n.omitBy)(t,(e=>""===e))})),[t]);if(!p||!s)
return(0,a.jsx)("div",{className:"sensei-lms-quiz-block__questions-modal__questions sensei-lms-quiz-block__questions-modal__questions--loading",children:(0,a.jsx)(r.Spinner,{})});
// Filter out already added questions.
p=p.filter((e=>!d.includes(e.id)));const m=(0,n.keyBy)(s,"id"),h=p.length>0&&p.every((e=>c.includes(e.id))),g=e=>s=>{u(s?s=>[...s,e]:s=>s.filter((s=>s!==e)))};
return(0,a.jsx)("div",{className:"sensei-lms-quiz-block__questions-modal__questions",children:(0,a.jsxs)("table",{className:"sensei-lms-quiz-block__questions-modal__table",children:[(0,a.jsx)("thead",{children:(0,a.jsxs)("tr",{children:[(0,a.jsx)("th",{className:"sensei-lms-quiz-block__questions-modal__question-checkbox",children:(0,a.jsx)(r.CheckboxControl,{title:(0,o.__)("Toggle all visible questions selection.","sensei-lms"),checked:h,onChange:e=>{const s=p.map((e=>e.id));u((t=>e?(0,n.uniq)([...t,...s]):t.filter((e=>!s.includes(e)))))}})}),(0,a.jsx)("th",{children:(0,o.__)("Question","sensei-lms")}),(0,a.jsx)("th",{children:(0,o.__)("Type","sensei-lms")}),(0,a.jsx)("th",{children:(0,o.__)("Category","sensei-lms")})]})}),(0,a.jsx)("tbody",{children:0===p.length?(0,a.jsx)("tr",{children:(0,a.jsx)("td",{colSpan:"4",children:(0,a.jsx)("p",{children:(0,o.__)("No questions found.","sensei-lms")})})}):p.map((e=>{const s=l/* ["default"] */.A[e["question-type-slug"]]?.title,t=e["question-category"].map((e=>m[e]?.name)).join(", "),n=e.id,i=e.title.raw;
return(0,a.jsxs)("tr",{children:[(0,a.jsx)("td",{children:(0,a.jsx)(r.CheckboxControl,{id:`question-${n}`,title:i,checked:c.includes(n),onChange:g(n)})}),(0,a.jsx)("td",{className:"sensei-lms-quiz-block__questions-modal__question-title",children:(0,a.jsx)("label",{htmlFor:`question-${n}`,title:i,children:i})}),(0,a.jsx)("td",{children:s}),(0,a.jsx)("td",{children:t})]},e.id)}))})]})})};
/* harmony default export */}
/***/,
/***/67357:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>a
/* harmony export */});
/* harmony import */var n=t(86087),i=t(80304),r=t(85643),o=t(94715),l=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Question Description control.
 *
 */
const a=()=>{const{answer:e,setAttributes:s,AnswerBlock:t,hasSelected:a,canHaveFeedback:c}=(0/* .QuestionContext */,n.useContext)(r.q),u=(0,o.useBlockProps)({className:"sensei-lms-question-answers-block"});
return(0,l.jsx)("div",{...u,children:t?.edit&&(0,l.jsxs)(l.Fragment,{children:[(0,l.jsx)(t.edit,{attributes:e,setAttributes:t=>s({answer:{...e,...t}}),hasSelected:a}),c&&a&&(0/* .AnswerFeedbackToggle */,l.jsx)(i.I,{})]})})};
/* harmony default export */}
/***/,
/***/68523:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */l:()=>/* binding */a
/* harmony export */});
/* harmony import */var n=t(86087),i=t(27723),r=t(60798),o=t(60817),l=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * External dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Question Grade control. Number spinner with points suffix.
 *
 * @param {Object} props NumberControl props.
 */
const a=e=>{const s=(0,n.useMemo)((()=>(0,r/* ["default"] */.A)()),[]);
return(0/* ["default"] */,l.jsx)(o.A,{id:s,min:0,step:1,...e,suffix:(0,i._n)("Point","Points",e.value,"sensei-lms")})};
/***/},
/***/70251:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>m
/* harmony export */});
/* harmony import */var n=t(74997),i=t(47143),r=t(27723),o=t(87642),l=t(75057),a=t(63160),c=t(7973),u=t(31702),d=t(52619),p=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Quiz block inserter for adding new or existing questions.
 *
 * @param {Object}   props
 * @param {string}   props.clientId  Quiz block ID.
 * @param {Function} props.openModal Open modal callback.
 */
const m=({clientId:e,openModal:s})=>{const{insertBlock:t}=(0,i.useDispatch)("core/block-editor"),m=(0,c/* .useNextQuestionIndex */.z)(e),h=s=>{t((0,n.createBlock)(s.name),m,e,!0)},g=(0,d.applyFilters)("sensei-lms.Quiz.appender-controls",[{id:"new-question",title:(0,r.__)("New Question","sensei-lms"),icon:l/* ["default"] */.A.icon,onClick:()=>h(l/* ["default"] */.A)},{id:"category-question",title:(0,r.__)("Category Question(s)","sensei-lms"),icon:o/* ["default"] */.A,onClick:()=>h(a/* ["default"] */.A)},{id:"existing-question",title:(0,r.__)("Existing Question(s)","sensei-lms"),icon:o/* ["default"] */.A,onClick:s}]),_=(0,r.__)("Add new or existing question(s)","sensei-lms");
return(0/* ["default"] */,p.jsx)(u.A,{controls:g,text:_,label:_})};
/* harmony default export */}
/***/,
/***/72108:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>l
/* harmony export */});
/* harmony import */var n=t(4452),i=t.n(n),r=t(56427),o=t(62540);
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
const l=({className:e,id:s,label:t,value:n,help:l,iconRight:a,onChange:c,...u})=>(0,o.jsx)(r.BaseControl,{id:s,label:t,help:l,children:(0,o.jsxs)("div",{className:"sensei-input-control",children:[(0,o.jsx)("input",{className:i()("sensei-input-control__input",{"sensei-input-control__input--with-icon-right":a},e),type:"text",id:s,value:null===n?"":n,onChange:e=>c(e.target.value),...u}),a&&(0,o.jsx)("span",{className:"sensei-input-control__icon",children:(0,o.jsx)(r.Icon,{icon:a})})]})})
/* harmony default export */}
/***/,
/***/74905:
/***/e=>{"use strict";e.exports=JSON.parse('{"name":"sensei-lms/question-answers","apiVersion":2,"title":"Answers","description":"Question Answers.","parent":["sensei-lms/quiz-question"],"category":"sensei-lms","textdomain":"sensei-lms","supports":{"html":false},"attributes":{}}')}
/***/,
/***/74997:
/***/e=>{"use strict";e.exports=window.wp.blocks}
/***/,
/***/75057:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>u
/* harmony export */});
/* harmony import */var n=t(94715),i=t(27723),r=t(19098),o=t(93683),l=t(34723),a=t(64261),c=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Quiz question block definition.
 */
/* harmony default export */const u={...l,metadata:l,icon:a/* ["default"] */.A,usesContext:["sensei-lms/quizId"],deprecated:o/* ["default"] */.A,edit:r/* ["default"] */.A,save:()=>(0,c.jsx)(n.InnerBlocks.Content,{}),messages:{noTitle:(0,i.__)("Add a title to this question.","sensei-lms")}};
/***/},
/***/75125:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A7:()=>/* binding */c
/* harmony export */,uN:()=>/* binding */u
/* harmony export */});
/* unused harmony export BlockValidationNotice */
/* harmony import */var n=t(56427),i=t(27723),r=t(12417),o=t(51135),l=t(84981),a=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Display a notice about the question being shared across quizzes.
 */
const c=()=>(0,a.jsxs)("div",{className:"sensei-lms-question-block__notice",children:[(0/* ["default"] */,a.jsx)(r.A,{icon:o/* ["default"] */.A}),(0,a.jsx)(n.Tooltip,{text:(0,i.__)("Any updates made to this question will also update it in any other quiz that includes it.","sensei-lms"),children:(0,a.jsx)("span",{children:(0,i.__)("Shared Question","sensei-lms")})})]})
/**
 * Display validation notice for the question block if there are errors.
 *
 * @param {Object}   props
 * @param {Object}   props.meta
 * @param {Object}   props.attributes
 * @param {string}   props.attributes.type           Question type.
 * @param {Array}    props.meta.validationErrors     Validation errors  codes
 * @param {boolean}  props.meta.showValidationErrors Display validation errors.
 * @param {Function} props.getErrorMessages          Get validation error messages.
 */,u=({attributes:{type:e},meta:{validationErrors:s,showValidationErrors:t},getErrorMessages:n})=>{if(!t||!s?.length)return null;const i=n(s,e);
return(0,a.jsx)(d,{errors:i})},d=({errors:e=[]})=>{if(!e||!e.length)return null;const s=e[0];
return(0,a.jsxs)(n.Notice,{isDismissible:!1,status:"warning",className:"sensei-lms-block-validation-notice",children:[(0/* ["default"] */,a.jsx)(l.A,{className:"sensei-lms-block-validation-notice__icon"}),s]})}}
/***/,
/***/76220:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>p
/* harmony export */});
/* harmony import */var n=t(86087),i=t(4452),r=t.n(i),o=t(21293),l=t(13804),a=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * External dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Default answer options for new blocks.
 */
const c=[{label:"",correct:!0},{label:"",correct:!1}],u=e=>e.filter((e=>e.correct)).length>1
/**
 * Answer component for question blocks with multiple choice type.
 *
 * @param {Object}   props
 * @param {Object}   props.attributes
 * @param {Function} props.setAttributes
 * @param {Array}    props.attributes.answers Answers.
 */,d=e=>{const{setAttributes:s,hasSelected:t}=e;let{attributes:{answers:i=[]}}=e;0===i.length&&(i=c);const r=u(i),l=!i[i.length-1]?.label,p=[...i];t&&!l&&p.push({label:"",correct:!1})
/**
   * Add a new answer option.
   *
   * @param {number} index Answer position
   */;const[m,h]=(0,n.useState)(null);
/**
   * Remove an answer option.
   *
   * @param {number} index Answer position
   */
return(0,a.jsx)(d.Options,{answers:p,children:(e,n)=>(0/* ["default"] */,a.jsx)(o.A,{hasFocus:n===m,isCheckbox:r,attributes:e,setAttributes:e=>((e,t)=>{{const n=[...i];n[e]={...n[e],...t},s({answers:n})}})(n,e),onEnter:()=>(e=>{const t=[...i];t.splice(e+1,0,{label:"",correct:!1}),s({answers:t}),h(e+1)})(n),onRemove:()=>(e=>{
// Do not allow the user to remove all the answers.
if(1===i.length)return;h(e-1);const t=[...i];t.splice(e,1),s({answers:t})})(n),hasSelected:t})})};
/**
 * Check if there are more than one right answers.
 *
 * @param {Array} answers
 */
/**
 * Render a list of answer options.
 *
 * @param {Object}   props
 * @param {Array}    props.answers  Answer list.
 * @param {Function} props.children Answer render function
 */
d.Options=({answers:e,children:s})=>(0,a.jsx)("ol",{className:"sensei-lms-question-block__answer sensei-lms-question-block__answer--multiple-choice",children:e.map(((e,t)=>(0,a.jsx)("li",{className:r()("sensei-lms-question-block__answer--multiple-choice__option",{"is-draft":!e.label}),children:s(e,t)},t)))})
/**
 * Read-only multiple choice answer component.
 *
 * @param {Object} props
 * @param {Object} props.attributes
 * @param {Array}  props.attributes.answers Answers.
 */,d.view=({attributes:{answers:e=[]}})=>{const s=u(e);
return(0,a.jsx)(d.Options,{answers:e,children:e=>(0,a.jsxs)(a.Fragment,{children:[(0/* .OptionToggle */,a.jsx)(l.c,{isChecked:e.correct,isCheckbox:s}),e.label]})})};
/* harmony default export */const p=d;
/***/},
/***/76809:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */Q:()=>/* binding */u
/* harmony export */,f:()=>/* binding */c
/* harmony export */});
/* harmony import */var n=t(94715),i=t(27723),r=t(46735),o=t(64261),l=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
const a={parent:["sensei-lms/quiz-question"],category:"sensei-lms",supports:{html:!1},attributes:{id:{type:"integer"}}},c={...a,name:"sensei-lms/quiz-question-feedback-correct",title:(0,i.__)("Correct Answer Feedback","sensei-lms"),icon:o/* ["default"] */.A,description:(0,i.__)("Display correct answer feedback.","sensei-lms"),edit:e=>(0,r/* ["default"] */.A)({...e,type:"correct"}),save:()=>(0,l.jsx)(n.InnerBlocks.Content,{})},u={...a,name:"sensei-lms/quiz-question-feedback-incorrect",title:(0,i.__)("Incorrect Answer Feedback","sensei-lms"),icon:o/* ["default"] */.A,description:(0,i.__)("Display incorrect answer feedback.","sensei-lms"),edit:e=>(0,r/* ["default"] */.A)({...e,type:"incorrect"}),save:()=>(0,l.jsx)(n.InnerBlocks.Content,{})};
/**
 * Correct Answer Feedback block definition.
 */}
/***/,
/***/77505:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */$x:()=>/* binding */r
/* harmony export */,y$:()=>/* binding */o
/* harmony export */});
/* unused harmony export composeFetchAction */
/* harmony import */var n=t(47143);
/* harmony import */
/**
 * WordPress dependencies
 */
// We register the store in the global scope to avoid registering it multiple times.
// The reason to be in the global scope is that some times we have different built files using the same source.
window.senseiStores=window.senseiStores||[];const{senseiStores:i}=window,r=(e,s)=>(t=s,n)=>(e[n.type]||e.DEFAULT)(n,t),o=(e,s)=>{if(i[e])return i[e];const t=(0,n.createReduxStore)(e,s);return(0,n.register)(t),i[e]=t,t};
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
/***/77801:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */Hm:()=>/* binding */_
/* harmony export */,Wu:()=>/* binding */d
/* harmony export */,ou:()=>/* binding */h
/* harmony export */});
/* unused harmony exports useBlockMeta, useBlockMetaContext, setBlockMeta */
/* harmony import */var n=t(66087),i=t(65470),r=t(29491),o=t(47143),l=t(86087),a=t(77505),c=t(62540);
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
 * Block metadata store definition.
 */
const u={reducer:(0,a/* .createReducerFromActionMap */.$x)({SET_BLOCK_META:({clientId:e,metadata:s},t)=>({...t,[e]:{...t[e]||{},...s}}),CLEAR:(e,s)=>s?{...e,[s]:void 0}:{},DEFAULT:e=>e},{}),actions:{
/**
     * Set metadata for a block.
     *
     * Input is merged with existing metadata.
     *
     * @param {string} clientId Block ID.
     * @param {string} metadata Changed block metadata.
     */
setBlockMeta:(e,s)=>({type:"SET_BLOCK_META",clientId:e,metadata:s}),
/**
     * Clear metadata for the block or all blocks.
     *
     * @param {string} [clientId] Block ID, or null to clear all blocks.
     */
clear:(e=null)=>({type:"CLEAR",clientId:e})},selectors:{
/**
     * Get metadata for a block.
     *
     * @param {Object} state
     * @param {string} clientId Block ID.
     * @param {string} [key]    Only return metadata for the given key.
     * @return {*} Block metadata.
     */
getBlockMeta:(e,s,t=null)=>t?e[s]?.[t]:e[s]
/**
     * Get metadata for multiple blocks.
     *
     * @param {Object}   state
     * @param {string[]} clientIds Block ID.
     * @param {string}   [key]     Only return metadata for the given key.
     * @return {Object} Blocks metadata, indexed by block ID.
     */,getMultipleBlockMeta:(0,i/* ["default"] */.A)(((e,s=[],t=null)=>{const i=s?.length?(0,n.pick)(e,s):e;return t?(0,n.mapValues)(i,t):i}),(e=>[e]))}},d=(0,a/* .createStore */.y$)("sensei/block-metadata",u),p=(0,l.createContext)({}),m=e=>{const s=(0,o.useSelect)((s=>s(d).getBlockMeta(e)),[e]),{setBlockMeta:t}=(0,o.useDispatch)(d),n=g(),i=(0,l.useCallback)((s=>t(e,s)),[e,t]);return[(0,l.useMemo)((()=>({...n,...s})),[s,n]),i]},h=(0,r.createHigherOrderComponent)((e=>_((s=>{const[t]=m(s.clientId);
return(0,c.jsx)(p.Provider,{value:t,children:(0,c.jsx)(e,{...s})})}))),"withBlockMetaProvider"),g=()=>(0,l.useContext)(p)
/**
 * Attach metadata store to the block.
 * Provides the following props:
 *
 * @property {Object}   meta    Block metadata.
 * @property {Function} setMeta Block metadata setter.
 */,_=(0,r.createHigherOrderComponent)((e=>s=>{const[t,n]=m(s.clientId);
return(0,c.jsx)(e,{...s,meta:t,setMeta:n})}),"withBlockMeta");
/**
 * Block metadata store.
 *
 * @type {string|Object}
 */}
/***/,
/***/79794:
/***/e=>{"use strict";e.exports=JSON.parse('{"name":"sensei-lms/quiz-category-question","title":"Category Question","description":"Pull questions from a question category.","parent":["sensei-lms/quiz"],"category":"sensei-lms","textdomain":"sensei-lms","supports":{"html":false},"attributes":{"id":{"type":"integer"},"type":{"type":"string","default":"category-question"},"categoryName":{"type":"string"},"options":{"type":"object","default":{"category":null,"number":1}}}}')}
/***/,
/***/80304:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */I:()=>/* binding */p
/* harmony export */});
/* harmony import */var n=t(86087),i=t(12417),r=t(12035),o=t(38289),l=t(27723),a=t(4452),c=t.n(a),u=t(85643),d=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * External dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Toggle control for showing answer feedback blocks.
 */
const p=()=>{const{answerFeedback:{showAnswerFeedback:e,toggleAnswerFeedback:s},options:{hideAnswerFeedback:t}}=(0/* .QuestionContext */,n.useContext)(u.q);return t?"":(0,d.jsxs)("div",{className:c()("sensei-lms-question-block__answer-feedback-toggle",{"is-visible":e}),children:[(0,d.jsxs)("button",{className:"sensei-lms-question-block__answer-feedback-toggle__header",onClick:()=>s(!e),children:[(0,l.__)("Answer Feedback","sensei-lms"),(0/* ["default"] */,d.jsx)(i.A,{className:"sensei-lms-question-block__answer-feedback-toggle__icon",icon:e?r/* ["default"] */.A:o/* ["default"] */.A})]}),(0,d.jsx)("div",{className:"sensei-lms-question-block__answer-feedback-toggle__help",children:(0,l.__)("Show feedback once the question is answered.","sensei-lms")})]})};
/***/},
/***/82376:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>w
/* harmony export */});
/* harmony import */var n=t(94715),i=t(27723),r=t(86087),o=t(77801),l=t(46280),a=t(75057),c=t(54675),u=t(98263),d=t(70251),p=t(29374),m=t(52485),h=t(93086),g=t(65526),_=t(93080),b=t(56427),v=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
const x=["sensei-lms/quiz-question","sensei-lms/quiz-category-question"],w=(0,o/* .withBlockMetaProvider */.ou)((e=>{const{clientId:s}=e;(0,c/* .useQuizStructure */.S)(e),(0,l/* .useAutoInserter */.n)({name:a/* ["default"] */.A.name,selectFirstBlock:!e.attributes.isPostTemplate,isEmptyBlock:g/* .isQuestionEmpty */.cm},e),(0,h/* .useUpdateQuizHasQuestionsMeta */.m)(s);const[t,o]=(0,r.useState)(!1),w=(0,r.useCallback)((()=>(0/* ["default"] */,v.jsx)(d.A,{clientId:s,openModal:()=>o(!0)})),[s]),k=e?.attributes?.options?.pagination,f=k?.paginationNumber&&k?.showProgressBar,j=(0,n.useBlockProps)();
return(0,v.jsxs)("div",{...j,children:[(0/* ["default"] */,v.jsx)(u.A,{...e}),(0,v.jsxs)("div",{className:"sensei-lms-quiz-block__separator",children:[(0,v.jsx)(b.Slot,{name:"SenseiQuizHeader"}),(0,v.jsx)("span",{children:(0,v.jsx)("span",{children:(0,i.__)("Lesson Quiz","sensei-lms")})})]}),(0,v.jsx)(b.Slot,{name:"SenseiQuizBlockTop"}),f&&(0/* ["default"] */,v.jsx)(_.A,{pagination:k}),(0,v.jsx)(n.InnerBlocks,{allowedBlocks:x,templateInsertUpdatesSelection:!1,renderAppender:w}),t&&(0/* ["default"] */,v.jsx)(p.A,{clientId:s,onClose:()=>o(!1)
/* Temporary solution. See https://github.com/WordPress/gutenberg/pull/29911 */}),(0,v.jsx)("div",{className:"sensei-lms-quiz-block__separator"}),(0/* ["default"] */,v.jsx)(m.A,{...e})]})}));
/**
 * Quiz block editor.
 *
 * @param {Object} props
 */}
/***/,
/***/84981:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>l
/* harmony export */});
/* harmony import */var n,i,r=t(51609);
/* harmony import */function o(){return o=Object.assign?Object.assign.bind():function(e){for(var s=1;s<arguments.length;s++){var t=arguments[s];for(var n in t)({}).hasOwnProperty.call(t,n)&&(e[n]=t[n])}return e},o.apply(null,arguments)}
/* harmony default export */const l=function(e){
return r.createElement("svg",o({xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24"},e),n||(n=r.createElement("path",{d:"M13 7h-2v6h2V7zm0 8h-2v2h2v-2z"})),i||(i=r.createElement("path",{d:"M12 4.75a7.25 7.25 0 1 0 0 14.5 7.25 7.25 0 0 0 0-14.5zM3.25 12a8.75 8.75 0 1 1 17.5 0 8.75 8.75 0 0 1-17.5 0z"})))};
/***/},
/***/85643:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */q:()=>/* binding */i
/* harmony export */});
/* harmony import */var n=t(86087);
/* harmony import */
/**
 * WordPress dependencies
 */
const i=(0,n.createContext)({});
/***/},
/***/86087:
/***/e=>{"use strict";e.exports=window.wp.element}
/***/,
/***/86245:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */S:()=>/* binding */r
/* harmony export */,v:()=>/* binding */o
/* harmony export */});
/* harmony import */var n=t(75057),i=t(43952);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Validate question block
 *
 * @param {Object} attributes Block attributes.
 * @return {Array} Validation errors.
 */
const r=e=>{const{id:s,type:t,title:n,answer:r}=e,o=t&&i/* ["default"] */.A[t],l=o.validate?.(r)||{},a=n?.length;return!a&&!r&&!s?{}:{noTitle:!a,...l}},o=(e,s)=>e.map((e=>i/* ["default"] */.A?.[s]?.messages?.[e]||n/* ["default"] */.A.messages[e]))
/***/;
/**
 * Get messages for the validation errors.
 *
 * @param {string} errors       Error codes.
 * @param {string} questionType Question type.
 * @return {string} Error message.
 */},
/***/87642:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>a
/* harmony export */});
/* harmony import */var n,i,r,o=t(51609);
/* harmony import */function l(){return l=Object.assign?Object.assign.bind():function(e){for(var s=1;s<arguments.length;s++){var t=arguments[s];for(var n in t)({}).hasOwnProperty.call(t,n)&&(e[n]=t[n])}return e},l.apply(null,arguments)}
/* harmony default export */const a=function(e){
return o.createElement("svg",l({viewBox:"0 0 24 24",fill:"none",xmlns:"http://www.w3.org/2000/svg"},e),n||(n=o.createElement("path",{fill:"transparent",stroke:"currentColor",strokeWidth:1.5,d:"M21 8v11c0 1.105-.894 2-1.999 2H6"})),i||(i=o.createElement("rect",{x:3.75,y:3.75,width:13.5,height:13.5,rx:.875,stroke:"currentColor",strokeWidth:1.5,fill:"transparent"})),r||(r=o.createElement("path",{fill:"currentColor",fillRule:"evenodd",clipRule:"evenodd",d:"M12 9a1.5 1.5 0 0 0-3 0H7.5a3 3 0 1 1 3.75 2.905v.845h-1.5V11.5c0-.57.452-.958.917-1.01A1.5 1.5 0 0 0 12 9Zm-2.25 4.75v1.5h1.5v-1.5h-1.5Z"})))};
/***/},
/***/88694:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>o
/* harmony export */});
/* harmony import */var n=t(56427),i=t(27723),r=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Question block settings for multiple choice questions.
 *
 * @param {Object}   props
 * @param {Object}   props.options             Multiple choice question options.
 * @param {boolean}  props.options.randomOrder Display options in random order.
 * @param {Function} props.setOptions          Sets the options.
 */
const o=({options:{randomOrder:e=!1},setOptions:s})=>(0,r.jsx)(n.CheckboxControl,{label:(0,i.__)("Random Order","sensei-lms"),checked:e,onChange:e=>s({randomOrder:e})})
/* harmony default export */}
/***/,
/***/89442:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>o
/* harmony export */});
/* harmony import */var n=t(56427),i=t(27723),r=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Question block grading notes settings control.
 *
 * @param {Object}   props
 * @param {Object}   props.options
 * @param {string}   props.options.teacherNotes Notes for teacher when grading.
 * @param {Function} props.setOptions
 */
const o=({options:{teacherNotes:e},setOptions:s})=>(0,r.jsx)(n.TextareaControl,{label:(0,i.__)("Grading Notes","sensei-lms"),onChange:e=>s({teacherNotes:e}),value:e||"",help:(0,i.__)("Displayed to the teacher when grading the question.","sensei-lms")})
/* harmony default export */}
/***/,
/***/89619:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>a
/* harmony export */});
/* harmony import */var n=t(94715),i=t(29491),r=t(27723),o=t(77801),l=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Question Description control.
 */
const a=(0/* .withBlockMeta */,i.compose)(o.Hm)((()=>{const e=(0,n.useBlockProps)({className:"sensei-lms-question-description-block"});
return(0,l.jsx)("div",{...e,children:(0,l.jsx)(n.InnerBlocks,{template:[["core/paragraph",{placeholder:(0,r.__)("Add question description or type / to choose a block.","sensei-lms")}]],templateInsertUpdatesSelection:!1,templateLock:!1})})}));
/* harmony default export */}
/***/,
/***/92859:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */Mj:()=>/* binding */o
/* harmony export */,X9:()=>/* binding */l
/* harmony export */,bb:()=>/* binding */r
/* harmony export */});
/* harmony import */var n=t(47143),i=t(86087);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Are the block or any of it's descendants selected.
 *
 * @param {Object}  props
 * @param {boolean} props.isSelected Block selected
 * @param {string}  props.clientId   Block ID
 * @return {boolean} Selection state
 */
const r=({isSelected:e,clientId:s})=>(0,n.useSelect)((e=>e("core/block-editor").hasSelectedInnerBlock(s,!0)),[s])||e,o=({onMount:e})=>((0,i.useEffect)((()=>{e()}),[e]),null),l=(e,s=[])=>{const t=(0,n.useSelect)((e=>e("core/editor").isSavingPost()&&!e("core/editor").isAutosavingPost()));(0,i.useEffect)((()=>{t&&e();
// eslint-disable-next-line react-hooks/exhaustive-deps
}),[t,...s])};
/**
 * Run callback when component is mounted.
 *
 * @param {Object}   props
 * @param {Function} props.onMount
 */}
/***/,
/***/93080:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>o
/* harmony export */});
/* harmony import */var n=t(27723),i=t(28108),r=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Progress bar in lesson edit view.
 *
 * @param {Object} props
 */
const o=e=>{const{pagination:s}=e,t={style:{...s?.progressBarColor&&{backgroundColor:s.progressBarColor}}},o={style:{...s?.progressBarBackground&&{backgroundColor:s.progressBarBackground},...s?.progressBarHeight&&{height:s.progressBarHeight},...s?.progressBarRadius&&{borderRadius:s.progressBarRadius}}};
return(0/* ["default"] */,r.jsx)(i.A,{totalCount:10,completedCount:2,wrapperAttributes:{className:"sensei-lms-quiz-block__progress-bar wp-block"},barAttributes:t,label:(0,n.__)("questions","sensei-lms"),barWrapperAttributes:o})};
/* harmony default export */}
/***/,
/***/93086:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */m:()=>/* binding */a
/* harmony export */});
/* harmony import */var n=t(86087),i=t(47143),r=t(94715),o=t(43656),l=t(65526);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Monitor for questions and disable the lesson quiz when none have been added.
 *
 * @param {string} clientId The quiz block client id.
 */
const a=e=>{const s="_quiz_has_questions",t=(0,i.select)(r.store).getBlocks(e).filter((e=>!(0,l/* .isQuestionEmpty */.cm)(e.attributes))),{editedValue:a}=(0,i.useSelect)((e=>({editedValue:e(o.store).getEditedPostAttribute("meta")[s]}))),{editPost:c}=(0,i.useDispatch)(o.store),u=(0,n.useCallback)((e=>c({meta:{[s]:e?1:0}})),[c]);
// It doesn't use the `useSelect` to get the blocks from the main registry.
// It avoids getting the blocks from the preview thumbnails.
// Monitor for valid questions.
// Monitor for valid questions.
(0,n.useEffect)((()=>{!a&&t.length&&u(!0),a&&!t.length&&u(!1)}),[t.length,a,u]),
// Monitor for quiz block removal.
// Monitor for quiz block removal.
(0,n.useEffect)((()=>()=>{u(!1)}),[u])};
/***/},
/***/93683:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>p
/* harmony export */});
/* harmony import */var n=t(94715),i=t(74997),r=t(86087),o=t(66087),l=t(76809),a=t(55014),c=t(52019),u=t(34723),d=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * External dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Helper method to get a related block for each type of media.
 *
 * @param {Object}   media       Question media.
 * @param {number}   media.id    Media attachment id.
 * @param {string}   media.url   Media attachment url.
 * @param {string}   media.type  Media attachment type.
 * @param {Function} media.title Media attachment title.
 */
const p=[{onProgrammaticCreation:!0,isEligible(e,s){let t=!0;return e.options?.answerFeedback&&(t=!0),s.map((e=>([a/* ["default"] */.A.name,l/* .answerFeedbackCorrectBlock */.f.name,l/* .answerFeedbackIncorrectBlock */.Q.name].includes(e.name)&&(t=!1),!0))),t},attributes:{...u.attributes},migrate(e,s){const t=[];
// Shift the description into the new question description block container.
return t.push((0/* ["default"] */,i.createBlock)(a.A.name,{},s),(0/* ["default"] */,i.createBlock)(c.A.name,{})),
// Replace the answerFeedback attribute with dedicated blocks.
e.options?.answerFeedback&&(t.push((0/* .answerFeedbackCorrectBlock */,i.createBlock)(l.f.name,{},[(0,i.createBlock)("core/paragraph",{content:e.options.answerFeedback})])),t.push((0/* .answerFeedbackIncorrectBlock */,i.createBlock)(l.Q.name,{},[(0,i.createBlock)("core/paragraph",{content:e.options.answerFeedback})]))),[{...e,options:(0,o.omit)(e.options,"answerFeedback")},t]},save:()=>(0,d.jsx)(n.InnerBlocks.Content,{})},{onProgrammaticCreation:!0,isEligible:e=>e.media||"file-upload"===e.type&&!!e.options?.studentHelp,attributes:{...u.attributes,media:{type:"object"}},migrate(e,s){const t=[...s];
// Add the media to the description (if it exists).
return e.media&&t.push((e=>{switch(e.type){case"image":return(0,i.createBlock)("core/image",{id:e.id,url:e.url});case"audio":return(0,i.createBlock)("core/audio",{id:e.id,src:e.url});case"video":return(0,i.createBlock)("core/video",{id:e.id,src:e.url});default:const s=(0,d.jsx)("a",{href:e.url,children:e.title});return(0,i.createBlock)("core/paragraph",{content:(0,r.renderToString)(s)})}})(e.media)),
// Add the student help text to the description (if it exists).
"file-upload"===e.type&&e.options?.studentHelp&&t.push((0,i.createBlock)("core/paragraph",{content:e.options.studentHelp})),[{...(0,o.omit)(e,"media"),options:(0,o.omit)(e.options,"studentHelp")},t]},save:()=>(0,d.jsx)(n.InnerBlocks.Content,{})}];
/* harmony default export */}
/***/,
/***/93832:
/***/e=>{"use strict";e.exports=window.wp.url}
/***/,
/***/94542:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */c:()=>/* binding */m
/* harmony export */,t:()=>/* binding */h
/* harmony export */});
/* harmony import */var n=t(56427),i=t(27723),r=t(60817),o=t(2567),l=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
const a="single",c="multi",u=[{label:(0,i.__)("Single page","sensei-lms"),value:a},{label:(0,i.__)("Multi-page","sensei-lms"),value:c}],d=e=>s=>{e({paginationNumber:s===c?1:null})}
/**
 * A component which contains a NumberControl and the 'per page' accompanying text.
 *
 * @param {Object}   props                  Component props.
 * @param {Object}   props.settings         Pagination settings object.
 * @param {Function} props.updatePagination Update pagination options function.
 */,p=({settings:e,updatePagination:s,...t})=>{const{paginationNumber:n}=e;
return(0,l.jsxs)(l.Fragment,{children:[(0/* ["default"] */,l.jsx)(r.A,{label:(0,i.__)("Number of Questions","sensei-lms"),min:1,step:1,hideLabelFromVision:!0,suffix:(0,i._n)("question","questions",n,"sensei-lms"),value:n,onChange:e=>s({paginationNumber:e}),...t}),(0,l.jsx)("span",{children:(0,i.__)("per page","sensei-lms")})]})},m=({settings:e,updatePagination:s})=>{const{paginationNumber:t,showProgressBar:o,progressBarRadius:m,progressBarHeight:h}=e;
return(0,l.jsx)(l.Fragment,{children:(0,l.jsxs)(n.PanelBody,{title:(0,i.__)("Pagination","sensei-lms"),initialOpen:!0,children:[(0,l.jsx)(n.PanelRow,{className:"sensei-lms-quiz-block-settings__pagination",children:(0,l.jsx)(n.SelectControl,{label:(0,i.__)("Pagination","sensei-lms"),hideLabelFromVision:!0,value:null===t?a:c,options:u,onChange:d(s)})}),null!==t&&(0,l.jsx)(n.PanelRow,{className:"sensei-lms-quiz-block-settings__question-count",children:(0,l.jsx)(p,{settings:e,updatePagination:s})}),null!==t&&(0,l.jsxs)(l.Fragment,{children:[(0,l.jsx)(n.PanelRow,{children:(0,l.jsx)(n.ToggleControl,{checked:o,label:(0,i.__)("Show Progress Bar","sensei-lms"),value:m,onChange:e=>s({showProgressBar:e})})}),(0,l.jsxs)(n.PanelRow,{className:"sensei-lms-quiz-block-settings__progress-bar",children:[(0/* ["default"] */,l.jsx)(r.A,{label:(0,i.__)("Radius","sensei-lms"),min:1,step:1,suffix:(0,i.__)("PX","sensei-lms"),value:m,onChange:e=>s({progressBarRadius:e})}),(0/* ["default"] */,l.jsx)(r.A,{label:(0,i.__)("Height","sensei-lms"),min:1,step:1,suffix:(0,i.__)("PX","sensei-lms"),value:h,onChange:e=>s({progressBarHeight:e})})]})]})]})})},h=({settings:e,updatePagination:s})=>{const{paginationNumber:t}=e;
return(0,l.jsxs)(l.Fragment,{children:[(0,l.jsx)(n.ToolbarGroup,{children:(0/* ["default"] */,l.jsx)(o.A,{options:u,optionsLabel:(0,i.__)("Quiz pagination","sensei-lms"),value:null===t?a:c,onChange:d(s)})}),null!==t&&(0,l.jsx)(n.ToolbarGroup,{className:"sensei-lms-quiz-block__toolbar-group",children:(0,l.jsx)(n.ToolbarItem,{as:p,settings:e,updatePagination:s})})]})}}
/***/,
/***/94715:
/***/e=>{"use strict";e.exports=window.wp.blockEditor}
/***/,
/***/95861:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>a
/* harmony export */});
/* harmony import */var n=t(4452),i=t.n(n),r=t(27723),o=t(94715),l=t(62540);
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
const a=({totalCount:e,completedCount:s,hidePercentage:t,wrapperAttributes:n,barWrapperAttributes:a,barAttributes:c,countersClassName:u,completedCountClassName:d,hideDefault:p,label:m})=>{const h=Math.round(s/e*100)||0,g=Math.max(p?0:3,h),_=(0,o.useBlockProps)(n);
return(0,l.jsxs)("div",{..._,children:[(0,l.jsx)("section",{className:i()("sensei-progress-bar__heading",u),children:(0,l.jsxs)("div",{className:i()("sensei-progress-bar__label",d),children:[(0,r.sprintf)(
// translators: Placeholder %1$d is the completed progress count, %2$d is the total count and %3$s is the label for progress bar.
// translators: Placeholder %1$d is the completed progress count, %2$d is the total count and %3$s is the label for progress bar.
(0,r.__)("%1$d of %2$d %3$s completed","sensei-lms"),s,e,m||""),!t&&` (${h}%)`]})}),(0,l.jsx)("div",{role:"progressbar","aria-valuenow":h,"aria-valuemin":"0","aria-valuemax":"100",...a,className:i()("sensei-progress-bar__bar",a?.className),children:(0,l.jsx)("div",{...c,className:i()("sensei-progress-bar__progress",c?.className),style:{...c?.style&&c.style,width:`${g}%`}})})]})};
/* harmony default export */}
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
/***/96603:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>r
/* harmony export */});for(
/**
 * Convert array of 16 byte values to UUID string format of the form:
 * XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX
 */
var n=[],i=0;i<256;++i)n[i]=(i+256).toString(16).substr(1);
/* harmony default export */const r=function(e,s){var t=s||0,i=n;// join used to fix memory issue caused by concatenation: https://bugs.chromium.org/p/v8/issues/detail?id=3175#c4
return[i[e[t++]],i[e[t++]],i[e[t++]],i[e[t++]],"-",i[e[t++]],i[e[t++]],"-",i[e[t++]],i[e[t++]],"-",i[e[t++]],i[e[t++]],"-",i[e[t++]],i[e[t++]],i[e[t++]],i[e[t++]],i[e[t++]],i[e[t++]]].join("")};
/***/},
/***/98263:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>_
/* harmony export */});
/* harmony import */var n=t(56427),i=t(47143),r=t(14309),o=t(43656),l=t(86087),a=t(27723),c=t(94715),u=t(77801),d=t(92859),p=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
const m=o.PluginPostStatusInfo||r.PluginPostStatusInfo,h=o.PluginPrePublishPanel||r.PluginPrePublishPanel,g=({count:e,onClick:s})=>(0,p.jsx)("div",{children:(0,p.jsx)(n.Notice,{isDismissible:!1,status:"warning",className:"sensei-lms-quiz-block__pre-publish-validation__notice",actions:[{label:(0,a.__)("View issues","sensei-lms"),onClick:s,className:"is-link"}],children:(0,a.sprintf)(
// Translators: placeholder is the numer of incomplete questions.
// Translators: placeholder is the numer of incomplete questions.
(0,a._n)("There is %d incomplete question in this lesson's quiz.","There are %d incomplete questions in this lesson's quiz.",e,"sensei-lms"),e)})})
/**
 * Collect and act on validation results for the questions in the quiz.
 *
 * Displays notices in the pre-publish and post status panels if there are incomplete questions.
 *
 * @param {Object}   props
 * @param {string}   props.clientId
 * @param {Function} props.setMeta
 */,_=({clientId:e,setMeta:s})=>{const t=(e=>{const{questionBlocks:s}=(0,i.useSelect)((s=>({questionBlocks:s(c.store).getBlocks(e)})),[e]),t=(0,l.useMemo)((()=>s.map((e=>e.clientId))),[s]),{errors:n}=(0,i.useSelect)((e=>({errors:e(u/* .BLOCK_META_STORE */.Wu).getMultipleBlockMeta(t,"validationErrors")})),[e,t]);return(0,l.useMemo)((()=>s.map((e=>({...e,errors:n[e.clientId]}))).filter((e=>e.errors?.length))),[s,n])})(e),n=(0,l.useCallback)(((e=!0)=>{s({showValidationErrors:e})}),[s]),{selectBlock:r}=(0,i.useDispatch)(c.store);if((0,d/* .usePostSavingEffect */.X9)((()=>n(!1)),[n]),!t.length)return null;const o=(0,p.jsx)(g,{onClick:()=>{t.length&&(n(!0),r(t[0].clientId))},count:t.length});
return(0,p.jsxs)(p.Fragment,{children:[(0,p.jsx)(m,{children:o}),(0,p.jsxs)(h,{title:(0,a.__)("Lesson Quiz","sensei-lms"),initialOpen:!0,children:[(0/* .Effect */,p.jsx)(d.Mj,{onMount:n}),o,(0,p.jsx)("p",{children:(0,a.__)("Incomplete questions won't be displayed to the student when taking the quiz.","sensei-lms")})]})]})}}
/***/
/******/},s={};
/************************************************************************/
/******/ // The module cache
/******/
/******/
/******/ // The require function
/******/function t(n){
/******/ // Check if module is in cache
/******/var i=s[n];
/******/if(void 0!==i)
/******/return i.exports;
/******/
/******/ // Create a new module (and put it into the cache)
/******/var r=s[n]={
/******/ // no module.id needed
/******/ // no module.loaded needed
/******/exports:{}
/******/};
/******/
/******/ // Execute the module function
/******/
/******/
/******/ // Return the exports of the module
/******/return e[n](r,r.exports,t),r.exports;
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
/* harmony import */var e=t(47056),s=t(76809),n=t(55014),i=t(52019),r=t(75057),o=t(63160),l=t(49236);
/* harmony import */t(54675);
/**
 * Internal dependencies
 */
const a=[l/* ["default"] */.A,r/* ["default"] */.A,o/* ["default"] */.A,n/* ["default"] */.A,s/* .answerFeedbackCorrectBlock */.f,s/* .answerFeedbackIncorrectBlock */.Q,i/* ["default"] */.A];(0,e/* ["default"] */.A)(a)})()})
/******/();