/******/(()=>{// webpackBootstrap
/******/var e={
/***/1764:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>l
/* harmony export */});
/* harmony import */var r,n,i=t(51609);
/* harmony import */function o(){return o=Object.assign?Object.assign.bind():function(e){for(var s=1;s<arguments.length;s++){var t=arguments[s];for(var r in t)({}).hasOwnProperty.call(t,r)&&(e[r]=t[r])}return e},o.apply(null,arguments)}
/* harmony default export */const l=function(e){
return i.createElement("svg",o({viewBox:"0 0 24 24",fill:"none",xmlns:"http://www.w3.org/2000/svg"},e),r||(r=i.createElement("path",{fillRule:"evenodd",d:"M12 1.5C6.201 1.5 1.5 6.201 1.5 12S6.201 22.5 12 22.5 22.5 17.799 22.5 12 17.799 1.5 12 1.5zM0 12C0 5.373 5.373 0 12 0s12 5.373 12 12-5.373 12-12 12S0 18.627 0 12z",fill:"currentColor"})),n||(n=i.createElement("path",{d:"M0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12",fill:"currentColor"})))};
/***/},
/***/2120:
/***/e=>{"use strict";e.exports=JSON.parse('{"name":"sensei-lms/course-theme-course-progress-counter","category":"theme","apiVersion":2,"supports":{"align":true,"color":{"gradients":true,"link":true},"spacing":{"margin":true,"padding":true,"blockGap":true},"typography":{"fontSize":true,"lineHeight":true,"__experimentalFontFamily":true,"__experimentalFontWeight":true,"__experimentalFontStyle":true,"__experimentalTextTransform":true,"__experimentalTextDecoration":true,"__experimentalLetterSpacing":true,"__experimentalDefaultControls":{"fontSize":true}}}}')}
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
 */var r=t(51609),n=Symbol.for("react.element"),i=Symbol.for("react.fragment"),o=Object.prototype.hasOwnProperty,l=r.__SECRET_INTERNALS_DO_NOT_USE_OR_YOU_WILL_BE_FIRED.ReactCurrentOwner,a={key:!0,ref:!0,__self:!0,__source:!0};function c(e,s,t){var r,i={},c=null,u=null;for(r in void 0!==t&&(c=""+t),void 0!==s.key&&(c=""+s.key),void 0!==s.ref&&(u=s.ref),s)o.call(s,r)&&!a.hasOwnProperty(r)&&(i[r]=s[r]);if(e&&e.defaultProps)for(r in s=e.defaultProps)void 0===i[r]&&(i[r]=s[r]);return{$$typeof:n,type:e,key:c,ref:u,props:i,_owner:l.current}}s.Fragment=i,s.jsx=c,s.jsxs=c}
/***/,
/***/2397:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>u
/* harmony export */});
/* harmony import */var r=t(94715),n=t(27723),i=t(12417),o=t(76280),l=t(84173),a=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Factory function for generating the edit/save components of the spacer block.
 *
 * @param {Function} blockPropsFn useBlockProps|useBlockProps.save
 * @return {Function} Block edit/save component.
 */
const c=e=>()=>(0,a.jsx)("div",{...e({className:"sensei-course-theme__spacer-flex"})})
/**
 * Spacer block that fills available space in flex containers.
 */
/* harmony default export */,u={...l,title:(0,n.__)("Spacer (Auto)","sensei-lms"),scope:["inserter"],icon:{src:(0/* ["default"] */,a.jsx)(i.A,{icon:o/* ["default"] */.A}),foreground:"#43AF99"},description:(0,n.__)("Automatically fill space between blocks.","sensei-lms"),attributes:{},edit:c(r.useBlockProps),save:c(r.useBlockProps.save)}}
/***/,
/***/2619:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>l
/* harmony export */});
/* harmony import */var r=t(27723),n=t(98073),i=t(63822),o=t(48597);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/* harmony default export */const l={...n,icon:{src:(0/* ["default"] */,t(62540).jsx)(o.A,{width:"20",height:"20"}),foreground:"#43AF99"},title:(0,r.__)("Course Title","sensei-lms"),description:(0,r.__)("Display title of the course the current lesson or quiz belongs to.","sensei-lms"),edit:i/* .CourseTitleEdit */.I};
/***/},
/***/3511:
/***/e=>{"use strict";e.exports=JSON.parse('{"name":"sensei-lms/template-style","category":"theme","parent":[],"apiVersion":2,"attributes":{"content":{"source":"text","type":"string","selector":"style"}}}')}
/***/,
/***/3582:
/***/e=>{"use strict";e.exports=window.wp.coreData}
/***/,
/***/3723:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>_
/* harmony export */});
/* harmony import */var r=t(27723),n=t(94715),i=t(45380),o=t(48597),l=t(66752),a=t(99145),c=t(33216),u=t(4452),p=t.n(u),m=t(62540);
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
const d={attributes:{},icon:{src:(0/* ["default"] */,m.jsx)(o.A,{width:"20",height:"20"}),foreground:"#43AF99"}},_=[{...c,...d,title:(0,r.__)("Quiz Progress Bar","sensei-lms"),description:(0,r.__)("Display progress of questions answered in a quiz.","sensei-lms"),edit:()=>(0,m.jsxs)("div",{className:"sensei-progress-bar",children:[(0,m.jsx)("div",{className:"sensei-progress-bar__label",children:(0,r.__)("2 of 10 questions complete (20%)","sensei-lms")}),(0,m.jsx)("div",{role:"progressbar",className:"sensei-progress-bar__bar",children:(0,m.jsx)("div",{className:"sensei-progress-bar__progress",style:{width:"20%",backgroundColor:"var(--wp--preset--color--primary)"}})})]})},{...a,...d,title:(0,r.__)("Back to lesson","sensei-lms"),description:(0,r.__)("Return to the lesson the quiz belongs to.","sensei-lms"),edit:function(){const e=(0,n.useBlockProps)({className:p()("sensei-lms-href","sensei-lms-quiz-back-to-lesson")});
return(0,m.jsxs)("span",{...e,children:[(0/* ["default"] */,m.jsx)(i.A,{}),(0,r.__)("Back to lesson","sensei-lms")]})}},{...l,...d,title:(0,r.__)("Quiz Actions and Pagination","sensei-lms"),description:(0,r.__)("Display pagination and actions the learner can take for the current quiz page.","sensei-lms"),apiVersion:2,edit:function(){const e=(0,n.useBlockProps)({className:"sensei-quiz-pagination"});
return(0,m.jsxs)("div",{...e,children:[(0,m.jsx)("div",{className:"sensei-quiz-pagination__list",children:(0,m.jsxs)("ul",{className:"page-numbers",children:[(0,m.jsx)("li",{children:(0,m.jsx)("span",{className:"page-numbers current",children:"1"})}),(0,m.jsx)("li",{children:(0,m.jsx)("span",{className:"page-numbers",children:"2"})}),(0,m.jsx)("li",{children:(0,m.jsx)("span",{className:"page-numbers dots",children:"…"})}),(0,m.jsx)("li",{children:(0,m.jsx)("span",{className:"page-numbers",children:"10"})})]})}),(0,m.jsxs)("div",{className:"sensei-quiz-actions",children:[(0,m.jsxs)("div",{className:"sensei-quiz-actions-secondary",children:[(0,m.jsx)("div",{className:"sensei-quiz-action",children:(0,m.jsx)("div",{className:"button",children:(0,r.__)("Next","sensei-lms")})}),(0,m.jsx)("div",{className:"sensei-quiz-action",children:(0,m.jsx)("div",{className:"button quiz-submit save",children:(0,r.__)("Save","sensei-lms")})})]}),(0,m.jsx)("div",{className:"sensei-quiz-actions-primary wp-block-buttons",children:(0,m.jsx)("div",{className:"sensei-quiz-action wp-block-button sensei-course-button",children:(0,m.jsx)("div",{className:"wp-block-button__link button quiz-submit complete",children:(0,r.__)("Complete","sensei-lms")})})})]})]})}}];
/* harmony default export */}
/***/,
/***/4267:
/***/e=>{"use strict";e.exports=JSON.parse('{"name":"sensei-lms/course-content","category":"theme","supports":{"align":true,"color":{"gradients":true,"link":true},"spacing":{"margin":true,"padding":true,"blockGap":true},"typography":{"fontSize":true,"lineHeight":true},"__experimentalBorder":{"color":true,"radius":true,"style":true,"width":true}}}')}
/***/,
/***/4452:
/***/(e,s)=>{var t;
/*!
	Copyright (c) 2018 Jed Watson.
	Licensed under the MIT License (MIT), see
	http://jedwatson.github.io/classnames
*/
/* global define */!function(){"use strict";var r={}.hasOwnProperty;function n(){for(var e="",s=0;s<arguments.length;s++){var t=arguments[s];t&&(e=o(e,i(t)))}return e}function i(e){if("string"==typeof e||"number"==typeof e)return e;if("object"!=typeof e)return"";if(Array.isArray(e))return n.apply(null,e);if(e.toString!==Object.prototype.toString&&!e.toString.toString().includes("[native code]"))return e.toString();var s="";for(var t in e)r.call(e,t)&&e[t]&&(s=o(s,t));return s}function o(e,s){return s?e?e+" "+s:e+s:e}e.exports?(n.default=n,e.exports=n):void 0===(t=function(){return n}.apply(s,[]))||(e.exports=t)}()}
/***/,
/***/4855:
/***/e=>{"use strict";e.exports=JSON.parse('{"name":"sensei-lms/course-theme-notices","category":"theme","supports":{"align":true,"color":{"link":true},"spacing":{"margin":true,"padding":true,"blockGap":true},"typography":{"fontSize":true,"lineHeight":true},"__experimentalBorder":{"color":true,"radius":true,"style":true,"width":true}}}')}
/***/,
/***/5573:
/***/e=>{"use strict";e.exports=window.wp.primitives}
/***/,
/***/9843:
/***/e=>{"use strict";e.exports=JSON.parse('{"name":"sensei-lms/page-actions","category":"theme","apiVersion":2,"supports":{"align":true,"color":{"gradients":true,"link":true},"spacing":{"margin":true,"padding":true,"blockGap":false},"__experimentalBorder":{"color":true,"radius":true,"style":true,"width":true},"typography":{"fontSize":true,"__experimentalFontFamily":true,"__experimentalFontWeight":true,"__experimentalFontStyle":true,"__experimentalTextTransform":true,"__experimentalTextDecoration":true,"__experimentalLetterSpacing":true}}}')}
/***/,
/***/12417:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>n
/* harmony export */});
/* harmony import */var r=t(86087);
/* harmony import */
/* harmony default export */const n=(0,r.forwardRef)((
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
function({icon:e,size:s=24,...t},n){return(0,r.cloneElement)(e,{width:s,height:s,...t,ref:n})}));
//# sourceMappingURL=index.js.map
/***/},
/***/14505:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */l:()=>/* reexport safe */r.l
/* harmony export */});
/* harmony import */var r=t(90499);
/***/},
/***/15923:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>g
/* harmony export */});
/* harmony import */var r=t(94715),n=t(12417),i=t(31789),o=t(27723),l=t(4452),a=t.n(l),c=t(83079),u=t(49259),p=t(62540);
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
const m={Edit:(e,s)=>(0,r.useInnerBlocksProps)((0,r.useBlockProps)(e),s),Save:e=>r.useInnerBlocksProps.save(r.useBlockProps.save(e))},d=e=>u/* ["default"] */.Ay.find((s=>e===s.attributes.elementClass))
/**
   * Build block props from variation attributes and settings.
   *
   * @param {Object} variation          Variation definition.
   * @param {Object} props              Block props.
   * @param {string} props.className
   * @param {string} props.elementClass Class identifying the variation.
   */,_=(e,{className:s,elementClass:t,...r})=>{var n;const i=null===(n=e?.meta?.isFrame)||void 0===n||n?"sensei-course-theme__frame":"";return{...r,className:a()(i,s,t)}},h=(e,s)=>{var t;const{tagName:r,className:n,elementClass:i}=s.attributes,o=null!==(t=d(i))&&void 0!==t?t:{};
return(0,p.jsx)(r,{...e(_(o,{className:n,elementClass:i}),o?.meta?.innerBlocksProps)})};
/**
 * User interface block for Learning mode layout elements.
 *
 * @param {Function} useBlockPropsFn
 * @param {Object}   props           Block pros.
 */h.Edit=h.bind(null,m.Edit),h.Save=h.bind(null,m.Save);
/* harmony default export */const g={...c,title:(0,o.__)("Interface Element","sensei-lms"),icon:{src:(0/* ["default"] */,p.jsx)(n.A,{icon:i/* ["default"] */.A}),foreground:"#43AF99"},edit:h.Edit,save:h.Save,variations:u/* ["default"] */.Ay};
/***/},
/***/16336:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>z
/* harmony export */});
/* harmony import */var r=t(27723),n=t(94715),i=t(45380),o=t(40427),l=t(64789),a=t(70548),c=t(48597),u=t(17757),p=t(4267),m=t(99945),d=t(2120),_=t(48330),h=t(4855),g=t(42317),x=t(89764),v=t(95057),f=t(84739),b=t(9843),y=t(39758),w=t(53450),j=t(59732),k=t(2619),N=t(30994),S=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
const A={category:"theme",attributes:{},icon:{src:(0/* ["default"] */,S.jsx)(c.A,{width:"20",height:"20"}),foreground:"#43AF99"}},z=[k/* ["default"] */.A,j/* ["default"] */.A,N/* ["default"] */.A,{...d,...A,title:(0,r.__)("Course Progress","sensei-lms"),description:(0,r.__)("Display number of completed and total lessons in the course.","sensei-lms"),edit:function(){const e=(0,n.useBlockProps)({className:"sensei-course-theme-course-progress"});
return(0,S.jsx)("div",{...e,children:(0,r.__)("2 of 10 lessons complete (20%)","sensei-lms")})}},{...x,...A,title:(0,r.__)("Previous & Next Lesson","sensei-lms"),description:(0,r.__)("Link to the previous and next lessons.","sensei-lms"),edit:()=>(0,S.jsxs)("div",{className:"sensei-course-theme-prev-next-lesson-container",children:[(0,S.jsx)("div",{className:"sensei-course-theme-prev-next-lesson-a sensei-course-theme-prev-next-lesson-a__prev",children:(0/* ["default"] */,S.jsx)(i.A,{})}),(0,S.jsx)("div",{className:"sensei-course-theme-prev-next-lesson-a sensei-course-theme-prev-next-lesson-a__next",children:(0/* ["default"] */,S.jsx)(o.A,{})})]})},{...y,...A,title:(0,r.__)("Sidebar Menu Toggle","sensei-lms"),description:(0,r.__)("Turn the Sidebar block into an overlay menu on mobile screens.","sensei-lms"),edit:()=>(0,S.jsx)("div",{className:"sensei-course-theme__sidebar-toggle",children:(0/* ["default"] */,S.jsx)(a.A,{})})},{
// Deprecated since Sensei 4.19.2.
..._,...A,title:(0,r.__)("Lesson Actions (Learning Mode)","sensei-lms"),description:(0,r.__)("(Deprecated) Display buttons for actions the learner can take for the current lesson.","sensei-lms"),attributes:{options:{type:"object",default:{}}},edit:()=>(0,S.jsxs)("div",{className:"sensei-course-theme-lesson-actions",children:[(0,S.jsx)("div",{className:"wp-block-button is-style-outline",children:(0,S.jsx)("div",{className:"wp-block-button__link wp-element-button sensei-course-theme__button is-secondary",children:(0,r.__)("Complete Lesson","sensei-lms")})}),(0,S.jsx)("div",{className:"wp-block-button",children:(0,S.jsx)("div",{className:"wp-block-button__link wp-element-button sensei-course-theme__button is-primary",children:(0,r.__)("Take Quiz","sensei-lms")})})]})},{...m,...A,title:(0,r.__)("Course Progress Bar","sensei-lms"),description:(0,r.__)("Display course progress.","sensei-lms"),edit:function(){const e=(0,n.useBlockProps)({className:"sensei-course-theme-course-progress-bar"});
return(0,S.jsx)("div",{...e,children:(0,S.jsx)("div",{className:"sensei-course-theme-course-progress-bar-inner",style:{width:"20%"}})})}},{...f,...A,title:(0,r.__)("Focus Mode Toggle","sensei-lms"),description:(0,r.__)("Toggle a minimalized view of Learning Mode.","sensei-lms"),edit:()=>(0,S.jsx)("div",{className:"sensei-course-theme__focus-mode-toggle",children:(0/* ["default"] */,S.jsx)(l.A,{className:"sensei-course-theme__focus-mode-toggle-icon"})})},{...g,...A,title:(0,r.__)("Post Title","sensei-lms"),description:(0,r.__)("Display title of the current lesson or quiz.","sensei-lms"),edit:()=>(0,S.jsx)("h1",{children:(0,r.__)("Lesson Title","sensei-lms")})},{...p,...A,title:(0,r.__)("Course Content","sensei-lms"),description:(0,r.__)("Display lesson or quiz content, if the learner has access to it.","sensei-lms"),edit:()=>(0,S.jsx)("p",{children:(0,r.__)("Course Content.","sensei-lms")})},{...h,...A,title:(0,r.__)("Notices","sensei-lms"),description:(0,r.__)("Display Sensei notices about the current lesson or quiz.","sensei-lms"),edit:()=>(0,S.jsx)("div",{className:"sensei-course-theme__frame sensei-lms-notice sensei-course-theme-lesson-quiz-notice",children:(0,S.jsx)("div",{className:"sensei-course-theme-lesson-quiz-notice__content",children:(0,r.__)("Notice","sensei-lms")})})},{...b,...A,title:(0,r.__)("Page Actions","sensei-lms"),description:(0,r.__)("Display pagination and related actions for the current page.","sensei-lms"),apiVersion:2,edit:function(){const e=(0,n.useBlockProps)({className:"sensei-course-theme__post-pagination"});
return(0,S.jsxs)("div",{...e,children:[(0,S.jsx)("span",{className:"post-page-numbers current",children:"1"}),(0,S.jsx)("a",{href:"#pseudo-link",className:"post-page-numbers",children:"2"})]})}},{...w,...A,title:(0,r.__)("Lesson Video","sensei-lms"),description:(0,r.__)("Displays the featured video if there is one for the lesson.","sensei-lms"),apiVersion:2,edit:function(){const e=(0,n.useBlockProps)({className:"sensei-course-theme-lesson-video"});
return(0,S.jsx)("div",{...e,style:{backgroundColor:"#000",color:"#fff",display:"flex",justifyContent:"center",alignItems:"center",height:"500px"},children:(0,S.jsx)("p",{className:"has-text-align-center",style:{fontSize:"100px"},children:"▶"})})}},{...u/* ["default"] */.A,...v,...A,description:(0,r.__)("Displays the lesson properties such as length and difficulty.","sensei-lms"),edit:function(){const e=(0,n.useBlockProps)({className:"wp-block-sensei-lms-lesson-properties"});
return(0,S.jsx)("div",{...e,children:(0,S.jsx)("span",{className:"wp-block-sensei-lms-lesson-properties__difficulty",children:(0,r.__)("The Learning Mode Lesson Properties block will display the lesson complexity and length. To set these properties, you need to add a Lesson Properties block to each individual lesson.","sensei-lms")})})}}];
/* harmony default export */}
/***/,
/***/17757:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>o
/* harmony export */});
/* harmony import */var r=t(50737),n=t(99423),i=t(81828);
/* harmony import */
/**
 * Internal dependencies
 */
/* harmony default export */const o={...n,metadata:n,icon:r/* ["default"] */.A,example:{attributes:{difficulty:"easy",length:10}},edit:i/* ["default"] */.A,save:()=>null};
/***/},
/***/21375:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */m:()=>/* binding */o
/* harmony export */});
/* harmony import */var r=t(27723),n=t(94715),i=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
const o=()=>{const e=(0,n.useBlockProps)();
return(0,i.jsx)("div",{...e,children:(0,i.jsx)("a",{href:"#exit-course-button-pseudo-link",onClick:e=>e.preventDefault(),children:(0,r.__)("Exit Course","sensei-lms")})})};
/***/},
/***/25516:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>o
/* harmony export */});
/* harmony import */var r,n=t(51609);
/* harmony import */function i(){return i=Object.assign?Object.assign.bind():function(e){for(var s=1;s<arguments.length;s++){var t=arguments[s];for(var r in t)({}).hasOwnProperty.call(t,r)&&(e[r]=t[r])}return e},i.apply(null,arguments)}
/* harmony default export */const o=function(e){
return n.createElement("svg",i({viewBox:"0 0 24 24",fill:"none",xmlns:"http://www.w3.org/2000/svg"},e),r||(r=n.createElement("path",{fillRule:"evenodd",clipRule:"evenodd",d:"M19.125 8h-1.188V5.714C17.938 2.56 15.277 0 12 0S6.062 2.56 6.062 5.714V8H4.875C3.569 8 2.5 9.029 2.5 10.286v11.428C2.5 22.971 3.569 24 4.875 24h14.25c1.306 0 2.375-1.029 2.375-2.286V10.286C21.5 9.029 20.431 8 19.125 8ZM8.438 5.714c0-1.897 1.59-3.428 3.562-3.428 1.971 0 3.563 1.531 3.563 3.428V8H8.438V5.714Zm-3.563 16h14.25V10.286H4.875v11.428Z",fill:"currentColor"})))};
/***/},
/***/27723:
/***/e=>{"use strict";e.exports=window.wp.i18n}
/***/,
/***/30281:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>o
/* harmony export */});
/* harmony import */var r,n=t(51609);
/* harmony import */function i(){return i=Object.assign?Object.assign.bind():function(e){for(var s=1;s<arguments.length;s++){var t=arguments[s];for(var r in t)({}).hasOwnProperty.call(t,r)&&(e[r]=t[r])}return e},i.apply(null,arguments)}
/* harmony default export */const o=function(e){
return n.createElement("svg",i({viewBox:"0 0 24 24",fill:"none",xmlns:"http://www.w3.org/2000/svg"},e),r||(r=n.createElement("path",{fillRule:"evenodd",clipRule:"evenodd",d:"M12 1.5C6.201 1.5 1.5 6.201 1.5 12S6.201 22.5 12 22.5 22.5 17.799 22.5 12 17.799 1.5 12 1.5ZM0 12C0 5.373 5.373 0 12 0s12 5.373 12 12-5.373 12-12 12S0 18.627 0 12Z",fill:"currentColor"})))};
/***/},
/***/30994:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>l
/* harmony export */});
/* harmony import */var r=t(92088),n=t(48597),i=t(34e3),o=t(27723);
/* harmony import */
/**
 * Internal dependencies
 */
/**
 * WordPress dependencies
 */
/* harmony default export */const l={...r,icon:{src:(0/* ["default"] */,t(62540).jsx)(n.A,{width:"20",height:"20"}),foreground:"#43AF99"},title:(0,o.__)("Module Title","sensei-lms"),description:(0,o.__)("Display title of the module the current lesson belongs to.","sensei-lms"),edit:i/* .ModuleTitleEdit */.b};
/***/},
/***/31789:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>i
/* harmony export */});
/* harmony import */var r=t(5573),n=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
const i=(0,n.jsx)(r.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24",children:(0,n.jsx)(r.Path,{d:"M18 5.5H6a.5.5 0 00-.5.5v3h13V6a.5.5 0 00-.5-.5zm.5 5H10v8h8a.5.5 0 00.5-.5v-7.5zm-10 0h-3V18a.5.5 0 00.5.5h2.5v-8zM6 4h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6a2 2 0 012-2z"})});
/* harmony default export */}
//# sourceMappingURL=layout.js.map
/***/,
/***/32047:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */U:()=>/* binding */n
/* harmony export */});
/* harmony import */var r=t(74997);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Makes sure the template blocks are only registered when in the site or widget editor, or editing the template from
 * the lesson page.
 *
 * @param {Array} blocks
 */
function n(e){e.forEach((e=>{const{name:s,...t}=e;(0,r.registerBlockType)(s,t)}))}
/***/},
/***/33216:
/***/e=>{"use strict";e.exports=JSON.parse('{"name":"sensei-lms/quiz-progress","category":"theme","supports":{"align":true,"color":true,"spacing":{"margin":true,"padding":true,"blockGap":true},"__experimentalBorder":{"color":true,"radius":true,"style":true,"width":true}}}')}
/***/,
/***/34e3:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */b:()=>/* binding */o
/* harmony export */});
/* harmony import */var r=t(27723),n=t(94715),i=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
const o=()=>{const e=(0,n.useBlockProps)();
return(0,i.jsx)("h3",{...e,children:(0,r.__)("Module","sensei-lms")})};
/***/},
/***/39758:
/***/e=>{"use strict";e.exports=JSON.parse('{"name":"sensei-lms/sidebar-toggle-button","category":"theme","supports":{"align":true,"spacing":{"margin":true,"padding":true,"blockGap":true}}}')}
/***/,
/***/40427:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>o
/* harmony export */});
/* harmony import */var r,n=t(51609);
/* harmony import */function i(){return i=Object.assign?Object.assign.bind():function(e){for(var s=1;s<arguments.length;s++){var t=arguments[s];for(var r in t)({}).hasOwnProperty.call(t,r)&&(e[r]=t[r])}return e},i.apply(null,arguments)}
/* harmony default export */const o=function(e){
return n.createElement("svg",i({viewBox:"0 0 24 24",fill:"none",xmlns:"http://www.w3.org/2000/svg"},e),r||(r=n.createElement("path",{d:"m10 7 5 5.5-5 5.5",stroke:"currentColor",strokeWidth:1.5})))};
/***/},
/***/41517:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>o
/* harmony export */});
/* harmony import */var r,n=t(51609);
/* harmony import */function i(){return i=Object.assign?Object.assign.bind():function(e){for(var s=1;s<arguments.length;s++){var t=arguments[s];for(var r in t)({}).hasOwnProperty.call(t,r)&&(e[r]=t[r])}return e},i.apply(null,arguments)}
/* harmony default export */const o=function(e){
return n.createElement("svg",i({viewBox:"0 0 24 24",fill:"none",xmlns:"http://www.w3.org/2000/svg"},e),r||(r=n.createElement("path",{fillRule:"evenodd",clipRule:"evenodd",d:"M12 24c6.628 0 12-5.372 12-12 0-6.627-5.372-12-12-12C5.373 0 0 5.373 0 12c0 6.628 5.373 12 12 12Zm-1.536-5.924 8.647-11.629-1.204-.895-8.2 11.027-4.411-3.28-.895 1.204 5.014 3.728.602.447.447-.602Z",fill:"currentColor"})))};
/***/},
/***/42317:
/***/e=>{"use strict";e.exports=JSON.parse('{"name":"sensei-lms/course-theme-post-title","category":"theme","supports":{"align":true,"color":true,"spacing":{"margin":true,"padding":true,"blockGap":true}}}')}
/***/,
/***/45278:
/***/e=>{"use strict";e.exports=JSON.parse('{"name":"sensei-lms/exit-course","category":"theme","apiVersion":2,"supports":{"align":true,"color":{"gradients":true},"spacing":{"margin":true,"padding":true,"blockGap":true},"typography":{"fontSize":true,"lineHeight":true,"__experimentalFontFamily":true,"__experimentalFontWeight":true,"__experimentalFontStyle":true,"__experimentalTextTransform":true,"__experimentalTextDecoration":true,"__experimentalLetterSpacing":true,"__experimentalDefaultControls":{"fontSize":true}},"__experimentalBorder":{"color":true,"radius":true,"style":true,"width":true}}}')}
/***/,
/***/45380:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>o
/* harmony export */});
/* harmony import */var r,n=t(51609);
/* harmony import */function i(){return i=Object.assign?Object.assign.bind():function(e){for(var s=1;s<arguments.length;s++){var t=arguments[s];for(var r in t)({}).hasOwnProperty.call(t,r)&&(e[r]=t[r])}return e},i.apply(null,arguments)}
/* harmony default export */const o=function(e){
return n.createElement("svg",i({viewBox:"0 0 24 24",fill:"none",xmlns:"http://www.w3.org/2000/svg"},e),r||(r=n.createElement("path",{d:"m14 7-5 5.5 5 5.5",stroke:"currentColor",strokeWidth:1.5})))};
/***/},
/***/48330:
/***/e=>{"use strict";e.exports=JSON.parse('{"name":"sensei-lms/course-theme-lesson-actions","category":"theme","supports":{"align":true,"color":{"gradients":true,"link":true,"background":false},"spacing":{"margin":true,"padding":true,"blockGap":true},"typography":{"fontSize":true,"lineHeight":true},"__experimentalBorder":{"color":true,"radius":true,"style":true,"width":true}}}')}
/***/,
/***/48597:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>l
/* harmony export */});
/* harmony import */var r,n,i=t(51609);
/* harmony import */function o(){return o=Object.assign?Object.assign.bind():function(e){for(var s=1;s<arguments.length;s++){var t=arguments[s];for(var r in t)({}).hasOwnProperty.call(t,r)&&(e[r]=t[r])}return e},o.apply(null,arguments)}
/* harmony default export */const l=function(e){
return i.createElement("svg",o({viewBox:"0 0 24 24",fill:"none",xmlns:"http://www.w3.org/2000/svg"},e),r||(r=i.createElement("circle",{cx:12,cy:12,r:12,fill:"#43AF99"})),n||(n=i.createElement("path",{fillRule:"evenodd",clipRule:"evenodd",d:"M9.835 15.38c.3-.23.179-.474.6-.563-.02.194.146.391.251.563-.109-.367-.002-.536.08-.72.347-.785-.662-1.293-1.35-1.418.235-.164.399-.327.694-.355a2.377 2.377 0 0 0-1.058.23c-1.112.531-1.993-.523-1.41-1.48.31-.51.664-.519.982-.865.077.178.103.372.075.564a.919.919 0 0 0 .049-.664c-.104-.336-.4-.338-.456-.821-.012-.101-.105.056-.263-.077-.038-.032-.113-.09-.163-.064-.085.044-.18.008-.232.034-.083.041-.109-.045-.2.016-.16.107-.178-.013-.332.005-.193.023-.32.261-.43.144-.102-.108-.206.075-.28.075-.05 0-.311.317-.426.028-.086-.216-.28.206-.382.063-.033-.046-.123.108-.18-.044-.014-.035 0-.078-.108-.027-.215.099-.138-.06-.207-.144-.083-.103-.113-.103-.068-.27.036-.133-.019-.33.2-.364.055-.008.107-.005.184-.148.096-.18.231-.093.207-.175-.036-.119.143-.28.226-.355.11-.103.254-.252.306-.396a.63.63 0 0 1 .102-.141c.081-.084.105-.003.227-.045.088-.03.02.053.106-.07.028-.038.105-.001.19-.039.259-.112.283-.11.347-.371.012-.05.025-.088.08-.083.109.01.134-.052.2-.05.061.001.083-.03.115-.068.18-.216.277-.055.357-.072.06-.012.022-.142.184-.102.23.057.155-.05.303-.015.174.041.186.19.306.225.143.042.211.198.307.196.337-.005.235.23.448.323-.16-.161.012-.421-.352-.455-.08-.007-.11-.127-.23-.183-.146-.067-.13-.21-.394-.27.068-.04.089.005.13-.073.058-.11.09-.046.113-.113.02-.063.006-.099.165-.155.165-.06.325-.195.472-.188.13.006.185-.08.177-.19-.008-.112-.033-.267.222-.22.153.029.15.003.15-.1-.002-.102.04-.165.174-.16.098.002.194-.003.231-.117.03-.091.207-.114.302-.148.317-.114.361.05.447-.095.07-.117.196-.317.337-.175.028.029.054.05.15-.056.08-.088.27-.2.337-.048.027.06.086.121.138.044a.08.08 0 0 1 .053-.039c.05-.01.079-.024.104-.036.218-.101.314-.095.213.125-.142.316.792-.192.532.151-.095.126.538.197.63.254.05.032.048.059.144.077.271.05.267.026.284.243.007.098.107.043.107.168 0 .535.472.266.549.399.012.022.032.042.079.042.149 0 .157-.03.224.089.027.047.05.072.127.096.12.037.112.05.068.138-.054.104.03.102.138.112.1.01.148.062.216.138.11.122.284.156.43.227.084.04.002.14.143.243.104.077.156.066.016.165-.59.418.22.305.446.694.051.087.118.195.216.295.225.23.1.293.221.437.07.083.015.063.13.137.272.175-.105.292-.319.212-.097-.035-.166-.085-.147-.025.016.049-.01.083-.052.12-.125.112.123.068.181.06.181-.025.664-.076.66.093-.005.22.136.27.25.284.185.024.238.057.34.226.092.152.145.07.288.205.097.093.217.258.02.282-.047.005-.099 0-.12.017a.411.411 0 0 1-.14.066c-.295.09.14.136.246.113.093-.02.209-.05.3-.027.057.015.062.08.244.107.06.01.036.099.006.16-.104.214.191.1.16.263-.017.093.11.245-.067.248-.057.001-.117-.015-.115.034.004.105-.165-.03-.317.115-.056.054-.19.092-.272-.009-.032-.038-.07-.069-.218-.023-.144.046-.242.204-.306-.04-.017-.064-.05-.065-.142-.097-.125-.043-.114-.258-.297-.12a.24.24 0 0 1-.214.039c-.144-.037-.303.012-.317-.096-.021-.179-.191-.305-.377-.296-.147.008-.278.034-.355-.137.057.195.207.208.382.208.144 0 .23.075.255.225.045.265.204.099.406.223.1.06.17.159.21.273.042.118.37-.024.282.258-.037.122-.107.168-.242.266-.4.294-.5.004-.618.239-.062.121-.063.031-.196.09-.22.098-.36-.128-.522-.045-.182.094-.168-.08-.352.037-.152.097-.308-.074-.38.192-.063.227-.322.232-.44.11-.189-.194-.132.229-.362.054-.123-.091-.213.043-.392.045-.33.005-.489-.282-.65-.107-.192.206-.331-.032-.334-.242-.003-.216-.777-.144-1.185-.256-.225-.062-.932.013-.702-.35-.372.39.456.366.682.455.136.053.245.095.377.114.13.296.214.617.227 1.007.043-.214.053-.433.028-.649-.043-.383.242.19.276.272.184.45-.022 1.278-.488 1.526a2.957 2.957 0 0 0-.562-.99c.256.392.616 1.192.327 1.65a1.023 1.023 0 0 1-.55-.483c.077.333.413.702.818.58.707-.213.704.233 1.641.307.682.111 1.654 0 2.118.037.254.02 1.32.197 1.315.465-.02 1.105-.438 1.164-1.539 1.268-.64.06-1.134.085-1.823.11-1.54.058-3.391.06-4.868 0-.724-.03-1.072-.036-1.841-.137-.769-.1-1.19-.363-1.178-1.187.005-.304.905-.594 1.2-.628.347-.039.901.005 1.405-.116.527-.127.747-.21 1.135-.508Zm5.347-6.052c-.167-.042-.051-.138-.339-.014-.17.073-.194-.13-.365-.094-.172.036-.242-.125-.499-.166-.318-.05-.088-.133-.592-.032-.097.02-.179-.09-.481-.052-.355.046-.23.084-.445-.115-.272-.251-.488-.082-.767-.184.216.166.368.019.622.221-.242.138-.523.802-.962.844.478.107.709.354 1.148.413.504.068.882.118 1.151.531.301.463.44.196.874.168.275-.017.282-.185.328-.362.063-.245.126-.256.31-.289.213-.037.163-.092.107-.156-.15-.172.019-.207.146-.244.222-.064.042-.075.042-.166-.278-.09-.063-.217.092-.273.169.105.242.087.317.073.109-.021.181.03.273-.028-.135.014-.163-.037-.278-.02-.051.007-.112.01-.219-.054-.18-.107-.27.048-.463 0Zm-2.28 1.64-1.09-.545c-1.316-.657-1.915.313-2.337 1.376l-.766.73c.549-.338.996-.714 1.574-.71.092 0 1.516.484 1.286-.092-.04-.104.09-.052.125-.201.04-.17.055-.141.195-.033.089.069.211.113.174-.048-.017-.072-.04-.137.28-.004.15.062.095-.064.303-.09.29-.034.228-.31.364-.349.076-.022.152.058.295-.077.05-.046.11-.089.232-.057-.143-.073-.22-.014-.292.03-.146.089-.204-.037-.343.07Zm-2.23-1.923c.16-.02.32-.036.482-.046a.13.13 0 0 0 .074-.06.111.111 0 0 0 .007-.09.268.268 0 0 1 .147-.206l-.002-.003c-.258.001-.466.1-.73.211-.052.022-.024.111-.118.213a.26.26 0 0 1-.201.235.136.136 0 0 0-.09.046.113.113 0 0 0-.026.092.252.252 0 0 1-.277.061c-.2-.077-.35-.065-.448.036a.39.39 0 0 1 .398.014c.134.066.3.031.39-.082a.132.132 0 0 1 .126-.098.421.421 0 0 0 .268-.323Z",fill:"#fff"})))};
/***/},
/***/49259:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */Ay:()=>p
/* harmony export */});
/* unused harmony exports FixedHeaderBlock, SidebarBlock, MainContentBlock, TwoColumnLayoutBlock, VideoContainerBlock, ContentFooterBlock */
/* harmony import */var r=t(27723),n=t(83079);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Settings shared between variations.
 */
const i={scope:["inserter"],isActive:["elementClass"]},o=["core/group",{style:{spacing:{padding:{right:"24px",left:"24px"},margin:{top:"0px",bottom:"0px"}}},layout:{type:"flex",flexWrap:"nowrap",justifyContent:"space-between"}}],l=(e,s)=>[n.name,{...e.attributes,...s}]
/**
 * Fixed header UI block variation definition.
 */,a={...i,name:"sensei-lms/learning-mode-header",title:(0,r.__)("Fixed Header","sensei-lms"),description:(0,r.__)("Header area that stays fixed on top of the screen.","sensei-lms"),isDefault:!0,attributes:{elementClass:"sensei-course-theme__header"},innerBlocks:[o],meta:{isFrame:!0}},c={...i,name:"sensei-lms/sidebar",title:(0,r.__)("Sidebar Menu","sensei-lms"),description:(0,r.__)('A sidebar displayed as an overlay menu on mobile screens. Add the "Sidebar Toggle" block to a header to allow opening and closing.',"sensei-lms"),attributes:{elementClass:"sensei-course-theme__sidebar"},meta:{isFrame:!0}},u={...i,name:"sensei-lms/main-content",title:(0,r.__)("Main Content","sensei-lms"),description:(0,r.__)("Content Area.","sensei-lms"),attributes:{elementClass:"sensei-course-theme__main-content"},meta:{isFrame:!1}},p=[a,{...i,name:"sensei-lms/main-columns",title:(0,r.__)("Two-column Layout","sensei-lms"),description:(0,r.__)("Layout with a fixed left or right sidebar.","sensei-lms"),attributes:{elementClass:"sensei-course-theme__columns"},innerBlocks:[l(u,{lock:{remove:!0,move:!1}}),l(c,{lock:{remove:!0,move:!1}})],meta:{innerBlocksProps:{orientation:"horizontal",allowedBlocks:[],renderAppender:!1},isFrame:!1}},u,c,{...i,name:"sensei-lms/video-container",title:(0,r.__)("Video Container","sensei-lms"),description:(0,r.__)("Container for a video with a sidebar.","sensei-lms"),attributes:{elementClass:"sensei-course-theme__video-container"},innerBlocks:[["core/video",[]],l(c,{lock:{remove:!0,move:!1}})],meta:{innerBlocksProps:{orientation:"horizontal"},isFrame:!1}},{...i,name:"sensei-lms/content-footer",title:(0,r.__)("Content Footer","sensei-lms"),description:(0,r.__)("Navigation area below the content.","sensei-lms"),attributes:{elementClass:"sensei-course-theme__content-footer"},innerBlocks:[o],meta:{isFrame:!0}}]}
/***/,
/***/50737:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>l
/* harmony export */});
/* harmony import */var r,n,i=t(51609);
/* harmony import */function o(){return o=Object.assign?Object.assign.bind():function(e){for(var s=1;s<arguments.length;s++){var t=arguments[s];for(var r in t)({}).hasOwnProperty.call(t,r)&&(e[r]=t[r])}return e},o.apply(null,arguments)}
/* harmony default export */const l=function(e){
return i.createElement("svg",o({xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24"},e),r||(r=i.createElement("path",{d:"M16.181 17.381a7.61 7.61 0 0 1-2.13.133L15.778 20H18l-1.819-2.619zm-5.479-.953a7.712 7.712 0 0 1-2.12-1.928H5.5v-9h2.759A7.793 7.793 0 0 1 9.523 4H4v12h4.778L6 20h2.222l2.48-3.572zM15.541 8.944h-1.5v3.997h1.5V8.944zm0-1h-1.5V6.55h1.5v1.395z"})),n||(n=i.createElement("path",{d:"M20.79 9.768c0 3.425-2.714 6.269-6.145 6.269-3.43 0-6.145-2.844-6.145-6.269 0-3.424 2.714-6.268 6.145-6.268 3.43 0 6.145 2.844 6.145 6.268zm-6.145 4.769c2.565 0 4.645-2.135 4.645-4.769C19.29 7.135 17.21 5 14.645 5 12.08 5 10 7.135 10 9.768c0 2.634 2.08 4.769 4.645 4.769z"})))};
/***/},
/***/51609:
/***/e=>{"use strict";e.exports=window.React}
/***/,
/***/52619:
/***/e=>{"use strict";e.exports=window.wp.hooks}
/***/,
/***/53450:
/***/e=>{"use strict";e.exports=JSON.parse('{"name":"sensei-lms/course-theme-lesson-video","category":"theme","supports":{"align":true,"alignWide":true,"color":{"gradients":true,"link":true,"background":false},"spacing":{"margin":true,"padding":true,"blockGap":true},"typography":{"fontSize":true,"lineHeight":true},"__experimentalBorder":{"color":true,"radius":true,"style":true,"width":true}}}')}
/***/,
/***/53673:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>n
/* harmony export */});
/* harmony import */var r=t(2397);
/* harmony import */
/**
 * Internal dependencies
 */
/* harmony default export */const n=[t(15923).A,r/* ["default"] */.A];
/***/},
/***/56427:
/***/e=>{"use strict";e.exports=window.wp.components}
/***/,
/***/57010:
/***/e=>{"use strict";e.exports=JSON.parse('{"name":"sensei-lms/course-navigation","apiVersion":2,"category":"theme","supports":{"align":true,"color":{"gradients":true,"link":true},"spacing":{"margin":true,"padding":true,"blockGap":true},"typography":{"fontSize":true,"lineHeight":true,"__experimentalFontFamily":true,"__experimentalFontWeight":true,"__experimentalFontStyle":true,"__experimentalTextTransform":true,"__experimentalTextDecoration":true,"__experimentalLetterSpacing":true,"__experimentalDefaultControls":{"fontSize":true}},"__experimentalBorder":{"color":true,"radius":true,"style":true,"width":true}}}')}
/***/,
/***/59732:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>l
/* harmony export */});
/* harmony import */var r=t(45278),n=t(48597),i=t(21375),o=t(27723);
/* harmony import */
/**
 * Internal dependencies
 */
/**
 * WordPress dependencies
 */
/* harmony default export */const l={...r,icon:{src:(0/* ["default"] */,t(62540).jsx)(n.A,{width:"20",height:"20"}),foreground:"#43AF99"},title:(0,o.__)("Exit Course","sensei-lms"),description:(0,o.__)("Exit Learning Mode and return to the course page.","sensei-lms"),edit:i/* .ExitCourseEdit */.m};
/***/},
/***/60817:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>a
/* harmony export */});
/* harmony import */var r=t(4452),n=t.n(r),i=t(56427),o=t(27723),l=t(62540);
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
const a=({className:e,id:s,label:t,value:r,help:a,allowReset:c=!1,resetLabel:u,onChange:p,suffix:m,hideLabelFromVision:d,..._})=>(0,l.jsx)(i.BaseControl,{id:s,label:t,help:a,hideLabelFromVision:d,children:(0,l.jsxs)("div",{className:"sensei-number-control",children:[(0,l.jsxs)("div",{className:"sensei-number-control__input-container",children:[(0,l.jsx)("input",{className:n()("sensei-number-control__input components-text-control__input",e),type:"number",id:s,onChange:e=>{p(parseInt(e.target.value,10)||_.min||0)},value:null===r?"":r,..._}),m&&(0,l.jsx)("span",{className:"sensei-number-control__input-suffix",children:m})]}),c&&(0,l.jsx)(i.Button,{className:"sensei-number-control__button",isSmall:!0,isSecondary:!0,onClick:()=>p(null),children:u||(0,o.__)("Reset","sensei-lms")})]})});
/* harmony default export */}
/***/,
/***/62540:
/***/(e,s,t)=>{"use strict";e.exports=t(2192)}
/***/,
/***/63822:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */I:()=>/* binding */o
/* harmony export */});
/* harmony import */var r=t(27723),n=t(94715),i=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
const o=()=>{const e=(0,n.useBlockProps)();
// Todo: Add the heading level selection, similar to this https://github.com/WordPress/gutenberg/blob/trunk/packages/block-library/src/site-title/edit/index.js#L98-L103.
return(0,i.jsx)("h2",{...e,children:(0,r.__)("Course Title","sensei-lms")})};
/***/},
/***/64724:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */K:()=>/* binding */i
/* harmony export */});
/* harmony import */var r=t(52619),n=t(27723);
/* harmony import */
/**
 * WordPress dependencies
 */
const i=(0,r.applyFilters)("sensei-lms.Lesson.difficulties",[{label:(0,n.__)("None","sensei-lms"),value:""},{label:(0,n.__)("Easy","sensei-lms"),value:"easy"},{label:(0,n.__)("Standard","sensei-lms"),value:"std"},{label:(0,n.__)("Hard","sensei-lms"),value:"hard"}]);
/***/},
/***/64789:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>l
/* harmony export */});
/* harmony import */var r,n,i=t(51609);
/* harmony import */function o(){return o=Object.assign?Object.assign.bind():function(e){for(var s=1;s<arguments.length;s++){var t=arguments[s];for(var r in t)({}).hasOwnProperty.call(t,r)&&(e[r]=t[r])}return e},o.apply(null,arguments)}
/* harmony default export */const l=function(e){
return i.createElement("svg",o({viewBox:"0 0 24 24",fill:"none",xmlns:"http://www.w3.org/2000/svg"},e),r||(r=i.createElement("path",{fillRule:"evenodd",clipRule:"evenodd",d:"M13.148 23.875 24 11.938 13.148 0 10.94 2.006l9.029 9.932-9.03 9.931 2.208 2.006Z",fill:"currentColor"})),n||(n=i.createElement("path",{fillRule:"evenodd",clipRule:"evenodd",d:"m3.207 23.875 10.852-11.937L3.207 0 1 2.006l9.029 9.932L1 21.869l2.207 2.006Z",fill:"currentColor"})))};
/***/},
/***/66752:
/***/e=>{"use strict";e.exports=JSON.parse('{"name":"sensei-lms/quiz-actions","category":"theme","supports":{}}')}
/***/,
/***/67659:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>i
/* harmony export */});
/* harmony import */var r=t(5573),n=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
const i=(0,n.jsx)(r.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24",children:(0,n.jsx)(r.Path,{d:"M4 20h8v-1.5H4V20zM18.9 3.5c-.6-.6-1.5-.6-2.1 0l-7.2 7.2c-.4-.1-.7 0-1.1.1-.5.2-1.5.7-1.9 2.2-.4 1.7-.8 2.2-1.1 2.7-.1.1-.2.3-.3.4l-.6 1.1H6c2 0 3.4-.4 4.7-1.4.8-.6 1.2-1.4 1.3-2.3 0-.3 0-.5-.1-.7L19 5.7c.5-.6.5-1.6-.1-2.2zM9.7 14.7c-.7.5-1.5.8-2.4 1 .2-.5.5-1.2.8-2.3.2-.6.4-1 .8-1.1.5-.1 1 .1 1.3.3.2.2.3.5.2.8 0 .3-.1.9-.7 1.3z"})});
/* harmony default export */}
//# sourceMappingURL=brush.js.map
/***/,
/***/70548:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>o
/* harmony export */});
/* harmony import */var r,n=t(51609);
/* harmony import */function i(){return i=Object.assign?Object.assign.bind():function(e){for(var s=1;s<arguments.length;s++){var t=arguments[s];for(var r in t)({}).hasOwnProperty.call(t,r)&&(e[r]=t[r])}return e},i.apply(null,arguments)}
/* harmony default export */const o=function(e){
return n.createElement("svg",i({xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24"},e),r||(r=n.createElement("path",{d:"M5 5v1.5h14V5H5zm0 7.8h14v-1.5H5v1.5zM5 19h14v-1.5H5V19z",fill:"currentColor"})))};
/***/},
/***/73900:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>o
/* harmony export */});
/* harmony import */var r,n=t(51609);
/* harmony import */function i(){return i=Object.assign?Object.assign.bind():function(e){for(var s=1;s<arguments.length;s++){var t=arguments[s];for(var r in t)({}).hasOwnProperty.call(t,r)&&(e[r]=t[r])}return e},i.apply(null,arguments)}
/* harmony default export */const o=function(e){
return n.createElement("svg",i({viewBox:"0 0 24 24",xmlns:"http://www.w3.org/2000/svg"},e),r||(r=n.createElement("path",{d:"M6.5 12.4 12 8l5.5 4.4-.9 1.2L12 10l-4.5 3.6-1-1.2z",fill:"currentColor"})))};
/***/},
/***/74997:
/***/e=>{"use strict";e.exports=window.wp.blocks}
/***/,
/***/75516:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>o
/* harmony export */});
/* harmony import */var r,n=t(51609);
/* harmony import */function i(){return i=Object.assign?Object.assign.bind():function(e){for(var s=1;s<arguments.length;s++){var t=arguments[s];for(var r in t)({}).hasOwnProperty.call(t,r)&&(e[r]=t[r])}return e},i.apply(null,arguments)}
/* harmony default export */const o=function(e){
return n.createElement("svg",i({viewBox:"0 0 24 24",fill:"none",xmlns:"http://www.w3.org/2000/svg"},e),r||(r=n.createElement("path",{fillRule:"evenodd",d:"M0 12.5c1.887-5.268 6.546-9 12-9s10.113 3.732 12 9c-1.887 5.268-6.546 9-12 9s-10.113-3.732-12-9zm21.623 0c-1.8-4.044-5.487-6.6-9.622-6.6s-7.822 2.556-9.622 6.6c1.8 4.044 5.487 6.6 9.623 6.6s7.823-2.556 9.622-6.6zM12 9.5c1.506 0 2.727 1.344 2.727 3s-1.223 3-2.727 3-2.727-1.344-2.727-3 1.223-3 2.727-3zm-4.909 3c0-2.976 2.204-5.4 4.91-5.4s4.91 2.424 4.91 5.4-2.204 5.4-4.91 5.4-4.909-2.424-4.909-5.4z",fill:"currentColor"})))};
/***/},
/***/76280:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>i
/* harmony export */});
/* harmony import */var r=t(5573),n=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
const i=(0,n.jsx)(r.SVG,{viewBox:"0 0 24 24",xmlns:"http://www.w3.org/2000/svg",children:(0,n.jsx)(r.Path,{d:"M7 18h4.5v1.5h-7v-7H6V17L17 6h-4.5V4.5h7v7H18V7L7 18Z"})});
/* harmony default export */}
//# sourceMappingURL=resize-corner-n-e.js.map
/***/,
/***/81828:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>_
/* harmony export */});
/* harmony import */var r=t(4452),n=t.n(r),i=t(86087),o=t(3582),l=t(94715),a=t(56427),c=t(27723),u=t(60817),p=t(64724),m=t(62540);
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
const d=window?.sensei?.courseThemeEnabled||!1,_=e=>{const{className:s}=e,[t,r]=(0,o.useEntityProp)("postType","lesson","meta"),{_lesson_complexity:_="",_lesson_length:h=10}=t||{},g=!t,x=(0,i.useCallback)(((e,s)=>{r({...t,[e]:s})}),[t,r]);
return(0,m.jsxs)(m.Fragment,{children:[!g&&(0,m.jsx)(l.InspectorControls,{children:(0,m.jsxs)(a.PanelBody,{title:(0,c.__)("Properties","sensei-lms"),children:[(0/* ["default"] */,m.jsx)(u.A,{id:"sensei-lesson-length",label:(0,c.__)("Length","sensei-lms"),min:0,step:1,value:h,onChange:e=>x("_lesson_length",e),suffix:(0,c._n)("minute","minutes",h,"sensei-lms")}),(0,m.jsx)(a.SelectControl,{label:(0,c.__)("Difficulty","sensei-lms"),options:p/* .DIFFICULTIES */.K.map((({label:e,value:s})=>({label:e,value:s}))),value:_,onChange:e=>x("_lesson_complexity",e)})]})}),d?(0,m.jsx)(a.Notice,{status:"warning",isDismissible:!1,children:(0,c.__)("Since Learning Mode is activated, use this block to add the properties to each lesson and make sure your Lesson template contains the Lesson Properties block.","sensei-lms")}):(0,m.jsxs)("div",{className:s,children:[(0,m.jsx)("span",{className:n()("wp-block-sensei-lms-lesson-properties__length",{disabled:!h}),children:(0,c.__)("Length","sensei-lms")+": "+h+" "+(0,c._n)("minute","minutes",h,"sensei-lms")}),(0,m.jsx)("span",{className:n()("wp-block-sensei-lms-lesson-properties__separator",{disabled:!h||!_}),children:"|"}),(0,m.jsx)("span",{className:n()("wp-block-sensei-lms-lesson-properties__difficulty",{disabled:!_}),children:(0,c.__)("Difficulty","sensei-lms")+": "+p/* .DIFFICULTIES */.K.find((e=>_===e.value))?.label})]})]})}}
/***/,
/***/83079:
/***/e=>{"use strict";e.exports=JSON.parse('{"name":"sensei-lms/ui","category":"theme","apiVersion":2,"supports":{"align":true,"alignWide":true,"color":{"gradients":true,"link":true,"__experimentalDefaultControls":{"background":true,"text":true,"link":true}},"spacing":{"margin":true,"padding":true,"blockGap":true},"__experimentalLayout":true,"__experimentalBorder":{"color":true,"radius":true,"style":true,"width":true},"typography":{"fontSize":true,"lineHeight":true}},"attributes":{"tagName":{"type":"string","default":"div"},"elementClass":{"type":"string","default":""}}}')}
/***/,
/***/84173:
/***/e=>{"use strict";e.exports=JSON.parse('{"name":"sensei-lms/spacer-flex","category":"theme","apiVersion":2,"supports":{}}')}
/***/,
/***/84739:
/***/e=>{"use strict";e.exports=JSON.parse('{"name":"sensei-lms/focus-mode-toggle","category":"theme","supports":{"align":true,"color":true}}')}
/***/,
/***/86087:
/***/e=>{"use strict";e.exports=window.wp.element}
/***/,
/***/89764:
/***/e=>{"use strict";e.exports=JSON.parse('{"name":"sensei-lms/course-theme-prev-next-lesson","category":"theme","supports":{"align":true,"color":{"gradients":true,"link":true},"spacing":{"margin":true,"padding":true,"blockGap":true},"typography":{"fontSize":true,"lineHeight":true,"__experimentalFontFamily":true,"__experimentalFontWeight":true,"__experimentalFontStyle":true,"__experimentalTextTransform":true,"__experimentalTextDecoration":true,"__experimentalLetterSpacing":true,"__experimentalDefaultControls":{"fontSize":true}},"__experimentalBorder":{"color":true,"radius":true,"style":true,"width":true}}}')}
/***/,
/***/90499:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */l:()=>/* binding */c
/* harmony export */});
/* harmony import */var r=t(27723),n=t(56427),i=t(67659),o=t(3511),l=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
const a=({attributes:e})=>(0,l.jsx)("style",{dangerouslySetInnerHTML:{__html:e.content}}),c={...o,title:(0,r.__)("Template Style","sensei-lms"),icon:{src:(0,l.jsx)(n.Icon,{icon:i/* ["default"] */.A}),foreground:"#43AF99"},edit:a,save:a}}
/***/,
/***/92088:
/***/e=>{"use strict";e.exports=JSON.parse('{"name":"sensei-lms/course-theme-lesson-module","category":"theme","apiVersion":2,"attributes":{"className":"some-className"},"supports":{"align":true,"color":{"gradients":true,"link":true},"spacing":{"margin":true,"padding":true,"blockGap":true},"typography":{"fontSize":true,"lineHeight":true,"__experimentalFontFamily":true,"__experimentalFontWeight":true,"__experimentalFontStyle":true,"__experimentalTextTransform":true,"__experimentalTextDecoration":true,"__experimentalLetterSpacing":true,"__experimentalDefaultControls":{"fontSize":true}}}}')}
/***/,
/***/92675:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>f
/* harmony export */});
/* harmony import */var r=t(27723),n=t(73900),i=t(30281),o=t(1764),l=t(41517),a=t(25516),c=t(75516),u=t(57010),p=t(48597),m=t(94715),d=t(62540),_=t(51609);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
const h={"not-started":i/* ["default"] */.A,"in-progress":o/* ["default"] */.A,ungraded:o/* ["default"] */.A,completed:l/* ["default"] */.A,failed:o/* ["default"] */.A,locked:a/* ["default"] */.A,preview:c/* ["default"] */.A},g=[{title:(0,r.__)("Module A","sensei-lms"),lessons:[{title:(0,r.__)("First Lesson","sensei-lms"),status:"preview"},{title:(0,r.__)("Second Lesson","sensei-lms"),status:"completed",quiz:!0},{title:(0,r.__)("Third Lesson","sensei-lms"),status:"in-progress",quiz:!0},{title:(0,r.__)("Fourth Lesson","sensei-lms"),status:"not-started",quiz:!0}]},{title:(0,r.__)("Module B","sensei-lms"),lessons:[{title:(0,r.__)("Fifth Lesson","sensei-lms"),status:"not-started",quiz:!0},{title:(0,r.__)("Sixth Lesson","sensei-lms"),status:"locked"},{title:(0,r.__)("Seventh Lesson","sensei-lms"),status:"locked"}]}],x=({title:e,lessons:s})=>(0,d.jsxs)("section",{className:"sensei-lms-course-navigation-module sensei-collapsible",children:[(0,d.jsx)("div",{className:"sensei-lms-course-navigation-module__header",children:(0,d.jsxs)("button",{className:"sensei-collapsible__toggle",children:[(0,d.jsx)("h3",{className:"sensei-lms-course-navigation-module__title",children:e}),(0/* ["default"] */,d.jsx)(n.A,{className:"sensei-lms-course-navigation-module__collapsible-icon"})]})}),(0,d.jsx)("ol",{className:"sensei-lms-course-navigation-module__lessons sensei-collapsible__content",children:s.map((e=>(0,_.createElement)(v,{...e,key:e.title})))}),(0,d.jsx)("div",{className:"sensei-lms-course-navigation-module__summary",children:(0,r.__)("2 lessons, 0 quizzes","sensei-lms")})]})
/**
 * Render a lesson.
 *
 * @param {Object}  props
 * @param {string}  props.title
 * @param {boolean} props.quiz
 * @param {string}  props.status
 */,v=({title:e,quiz:s,status:t})=>{const n=h[t];
return(0,d.jsxs)("li",{className:`sensei-lms-course-navigation-lesson status-${t}`,children:[(0,d.jsxs)("a",{className:"sensei-lms-course-navigation-lesson__link",href:"#pseudo-link",children:[(0,d.jsx)(n,{className:"sensei-lms-course-navigation-lesson__status"}),(0,d.jsx)("span",{className:"sensei-lms-href sensei-lms-course-navigation-lesson__title",children:e})]}),s&&(0,d.jsx)("a",{className:"sensei-lms-href sensei-lms-course-navigation-lesson__extra",href:"#pseudo-link",children:(0,r.__)("Quiz","sensei-lms")})]})},f={...u,icon:{src:(0/* ["default"] */,d.jsx)(p.A,{width:"20",height:"20"}),foreground:"#43AF99"},attributes:{},title:(0,r.__)("Course Navigation","sensei-lms"),edit:function(){const e=(0,m.useBlockProps)({className:"sensei-lms-course-navigation"});
return(0,d.jsx)("div",{...e,children:(0,d.jsx)("div",{className:"sensei-lms-course-navigation__modules",children:g.map((e=>(0,_.createElement)(x,{...e,key:e.title})))})})}}}
/***/,
/***/94715:
/***/e=>{"use strict";e.exports=window.wp.blockEditor}
/***/,
/***/95057:
/***/e=>{"use strict";e.exports=JSON.parse('{"name":"sensei-lms/learning-mode-lesson-properties","category":"theme","supports":{"align":true,"color":true,"spacing":{"margin":true,"padding":true,"blockGap":true},"typography":{"fontSize":true,"lineHeight":true}}}')}
/***/,
/***/98073:
/***/e=>{"use strict";e.exports=JSON.parse('{"name":"sensei-lms/course-title","category":"theme","apiVersion":2,"supports":{"align":true,"color":true,"spacing":{"margin":true,"padding":true,"blockGap":true},"typography":{"fontSize":true,"lineHeight":true,"__experimentalFontFamily":true,"__experimentalFontWeight":true,"__experimentalFontStyle":true,"__experimentalTextTransform":true,"__experimentalTextDecoration":true,"__experimentalLetterSpacing":true,"__experimentalDefaultControls":{"fontSize":true}}}}')}
/***/,
/***/99145:
/***/e=>{"use strict";e.exports=JSON.parse('{"name":"sensei-lms/quiz-back-to-lesson","apiVersion":2,"category":"theme","supports":{"align":true,"color":{"gradients":true,"link":true},"spacing":{"margin":true,"padding":true,"blockGap":true},"typography":{"fontSize":true,"lineHeight":true}}}')}
/***/,
/***/99423:
/***/e=>{"use strict";e.exports=JSON.parse('{"name":"sensei-lms/lesson-properties","title":"Lesson Properties","description":"Add lesson properties such as length and difficulty.","category":"sensei-lms","textdomain":"sensei-lms","keywords":["metadata","length","complexity","difficulty","lesson information","lesson properties"]}')}
/***/,
/***/99945:
/***/e=>{"use strict";e.exports=JSON.parse('{"name":"sensei-lms/course-theme-course-progress-bar","apiVersion":2,"category":"theme","supports":{"align":true,"color":true}}')}
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
/******/var i=s[r]={
/******/ // no module.id needed
/******/ // no module.loaded needed
/******/exports:{}
/******/};
/******/
/******/ // Execute the module function
/******/
/******/
/******/ // Return the exports of the module
/******/return e[r](i,i.exports,t),i.exports;
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
/* harmony import */var e=t(32047),s=t(92675),r=t(53673),n=t(16336),i=t(3723),o=t(14505);
/* harmony import */
/**
 * Internal dependencies
 */
const l=[...n/* ["default"] */.A,...i/* ["default"] */.A,...r/* ["default"] */.A,s/* ["default"] */.A,o/* .templateStyleBlock */.l];(0,e/* .registerTemplateBlocks */.U)(l)})()})
/******/();