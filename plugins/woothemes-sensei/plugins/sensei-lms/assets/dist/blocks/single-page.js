/******/(()=>{// webpackBootstrap
/******/var e={
/***/1957:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>n
/* harmony export */});
/* harmony import */var r=t(50480),o=t(24743),l=t(81365);
/* harmony import */
/**
 * Internal dependencies
 */
/* harmony default export */const n={...o,metadata:o,example:{},icon:l/* ["default"] */.A,edit:r/* ["default"] */.A};
/***/},
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
 */var r=t(51609),o=Symbol.for("react.element"),l=Symbol.for("react.fragment"),n=Object.prototype.hasOwnProperty,i=r.__SECRET_INTERNALS_DO_NOT_USE_OR_YOU_WILL_BE_FIRED.ReactCurrentOwner,a={key:!0,ref:!0,__self:!0,__source:!0};function c(e,s,t){var r,l={},c=null,u=null;for(r in void 0!==t&&(c=""+t),void 0!==s.key&&(c=""+s.key),void 0!==s.ref&&(u=s.ref),s)n.call(s,r)&&!a.hasOwnProperty(r)&&(l[r]=s[r]);if(e&&e.defaultProps)for(r in s=e.defaultProps)void 0===l[r]&&(l[r]=s[r]);return{$$typeof:o,type:e,key:c,ref:u,props:l,_owner:i.current}}s.Fragment=l,s.jsx=c,s.jsxs=c}
/***/,
/***/2835:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>l
/* harmony export */});
/* harmony import */var r=t(5573),o=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
const l=(0,o.jsx)(r.SVG,{viewBox:"0 0 24 24",xmlns:"http://www.w3.org/2000/svg",children:(0,o.jsx)(r.Path,{d:"M4 4v1.5h16V4H4zm8 8.5h8V11h-8v1.5zM4 20h16v-1.5H4V20zm4-8c0-1.1-.9-2-2-2s-2 .9-2 2 .9 2 2 2 2-.9 2-2z"})});
/* harmony default export */}
//# sourceMappingURL=list.js.map
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
/* global define */!function(){"use strict";var r={}.hasOwnProperty;function o(){for(var e="",s=0;s<arguments.length;s++){var t=arguments[s];t&&(e=n(e,l(t)))}return e}function l(e){if("string"==typeof e||"number"==typeof e)return e;if("object"!=typeof e)return"";if(Array.isArray(e))return o.apply(null,e);if(e.toString!==Object.prototype.toString&&!e.toString.toString().includes("[native code]"))return e.toString();var s="";for(var t in e)r.call(e,t)&&e[t]&&(s=n(s,t));return s}function n(e,s){return s?e?e+" "+s:e+s:e}e.exports?(o.default=o,e.exports=o):void 0===(t=function(){return o}.apply(s,[]))||(e.exports=t)}()}
/***/,
/***/5573:
/***/e=>{"use strict";e.exports=window.wp.primitives}
/***/,
/***/7928:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>n
/* harmony export */});
/* harmony import */var r=t(86087),o=t(47143),l=t(27723);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Messages disabled notice component.
 * It's used as a wrapper to show the notice messages is disabled and the
 * Learner Messages block is in the editor.
 *
 * @param {Object} props                      Component props.
 * @param {Object} props.children             Children to be wrapped.
 * @param {Object} props.attributes           Block attributes.
 * @param {Object} props.attributes.isPreview Is preview component.
 */
const n=({children:e,attributes:{isPreview:s}})=>{const{createWarningNotice:t,removeNotice:n}=(0,o.useDispatch)("core/notices"),i=(0,o.useSelect)((e=>e("core/block-editor").getGlobalBlockCount("sensei-lms/button-learner-messages")));return(0,r.useEffect)((()=>{if(!s)return"1"===window.sensei_messages.disabled&&t((0,l.__)('You have added the "Student Messages Button" block to your editor, but messages are disabled in your settings.',"sensei-lms"),{id:"sensei-messages-disabled",actions:[{url:window.sensei_messages.settings_url,label:(0,l.__)("Go to disabled messages setting","sensei-lms")}]}),()=>{
// Check if it's the last one.
1===i&&n("sensei-messages-disabled")}}),[s,i,t,n]),e};
/* harmony default export */}
/***/,
/***/8473:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>n
/* harmony export */});
/* harmony import */var r=t(27723),o=t(3582),l=t(62540);
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
const n=({postId:e,isFeaturedImage:s,children:t})=>{const[n]=(0,o.useEntityProp)("postType","course","meta",e),[i]=(0,o.useEntityProp)("postType","course","featured_media",e),a=!!n._course_featured,c=i>0,u=s?"sensei-lms-course-list-featured-label__image-wrapper":"sensei-lms-course-list-featured-label__meta-wrapper",d=c&&s||!c&&!s;
return(0,l.jsxs)("div",{className:u,children:[a&&d&&(0,l.jsx)("span",{className:"sensei-lms-course-list-featured-label__text",children:(0,r.__)("Featured","sensei-lms")}),t]})};
/* harmony default export */}
/***/,
/***/12417:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>o
/* harmony export */});
/* harmony import */var r=t(86087);
/* harmony import */
/* harmony default export */const o=(0,r.forwardRef)((
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
function({icon:e,size:s=24,...t},o){return(0,r.cloneElement)(e,{width:s,height:s,...t,ref:o})}));
//# sourceMappingURL=index.js.map
/***/},
/***/13121:
/***/e=>{"use strict";e.exports=JSON.parse('{"name":"sensei-lms/course-results","title":"Course Results","description":"Show course results to students on the course completion page.","category":"sensei-lms","textdomain":"sensei-lms","keywords":["course","lessons","modules","results","completion"],"supports":{"html":false,"multiple":false,"defaultStylePicker":false},"attributes":{"id":{"type":"integer"},"moduleBorder":{"type":"boolean","default":true},"mainColor":{"type":"string"},"textColor":{"type":"string"},"borderColor":{"type":"string"},"customMainColor":{"type":"string"},"customTextColor":{"type":"string"},"customBorderColor":{"type":"string"},"borderColorValue":{"type":"string"},"defaultMainColor":{"type":"string"},"defaultTextColor":{"type":"string"},"defaultBorderColor":{"type":"string"}}}')}
/***/,
/***/13194:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */e:()=>/* binding */n
/* harmony export */});
/* harmony import */var r=t(27723),o=t(74997),l=t(52619);
/* harmony import */
/**
 * WordPress dependencies
 */
const n=()=>{const e={className:"more-courses",text:(0,r.__)("Find More Courses","sensei-lms")};(0,o.registerBlockVariation)("core/buttons",{name:"sensei-lms/course-completed-actions",title:(0,r.__)("Course Completed Actions","sensei-lms"),description:(0,r.__)("Prompt students to take action after completing a course.","sensei-lms"),category:"sensei-lms",keywords:[(0,r.__)("Course","sensei-lms"),(0,r.__)("Completed","sensei-lms"),(0,r.__)("Actions","sensei-lms"),(0,r.__)("Buttons","sensei-lms"),(0,r.__)("Find More Courses","sensei-lms"),(0,r.__)("View Certificate","sensei-lms")],innerBlocks:(0,l.applyFilters)("sensei-lms.Course.completedActions",[["core/button",e]]),attributes:{contentJustification:"center",anchor:"course-completed-actions"},isActive:(e,s)=>e.anchor===s.anchor}),(0,o.registerBlockVariation)("core/button",{name:"sensei-lms/more-courses-button",title:(0,r.__)("Find More Courses","sensei-lms"),description:(0,r.__)("Prompt students to find more courses.","sensei-lms"),keywords:[(0,r.__)("Courses","sensei-lms"),(0,r.__)("Archive","sensei-lms")],category:"sensei-lms",attributes:e,isActive:(e,s)=>e.className?.match(s.className)})};
/***/},
/***/16711:
/***/(e,s,t)=>{"use strict";
/* harmony import */t(51609);
/* harmony import */}
/***/,
/***/21307:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>c
/* harmony export */});
/* harmony import */var r=t(4452),o=t.n(r),l=t(94715),n=t(74997),i=t(71406),a=t(62540);
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
const c=({attributes:e,className:s,tagName:t,blockName:r})=>{const{text:c,inContainer:u,align:d}=e;let m=t;t||(m=(0,i/* .isLinkStyle */._N)({attributes:e})?"a":"button");const p=(0,a.jsx)("div",{...(0,i/* .getButtonWrapperProps */.KS)({className:s,attributes:e}),children:(0,a.jsx)(l.RichText.Content,{...(0,i/* .getButtonProps */.xh)({attributes:e}),tagName:m,value:c})});return u?(0,a.jsx)("div",{className:o()(s,"sensei-buttons-container__button-block",(0,n.getBlockDefaultClassName)(r)+"__wrapper",{[`sensei-buttons-container__button-align-${d}`]:d}),children:p}):p};
/* harmony default export */}
/***/,
/***/22342:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>p
/* harmony export */});
/* harmony import */var r=t(4452),o=t.n(r),l=t(29491),n=t(63059),i=t(29281),a=t(47143),c=t(27723),u=t(62540);
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
 * Sample lesson component.
 *
 * @param {Object} props              Component props.
 * @param {Array}  props.lessonNumber The lesson number to use in the sample title.
 */
const d=({lessonNumber:e})=>(0,u.jsx)("li",{className:"wp-block-sensei-lms-course-results__lesson",children:(0,u.jsxs)("a",{href:"#",className:"wp-block-sensei-lms-course-results__lesson-link",children:[(0,u.jsx)("span",{className:"wp-block-sensei-lms-course-results__lesson-title",children:(0,c.sprintf)(/* translators: Mock lesson number. */ /* translators: Mock lesson number. */
(0,c.__)("Lesson %s","sensei-lms"),e)}),(0,u.jsx)("span",{className:"wp-block-sensei-lms-course-results__lesson-score",children:"xx%"})]})})
/**
 * Sample module component.
 *
 * @param {Object}  props              Component props.
 * @param {string}  props.moduleName   The name of the module.
 * @param {boolean} props.moduleBorder If modules have borders.
 * @param {string}  props.headerStyles The module header styles.
 * @param {string}  props.style        The style selected for the results block.
 */,m=({moduleName:e,moduleBorder:s,headerStyles:t,style:r})=>(0,u.jsxs)("section",{className:o()("wp-block-sensei-lms-course-results__module",{"wp-block-sensei-lms-course-results__module--has-border":s}),children:[(0,u.jsx)("header",{className:"wp-block-sensei-lms-course-results__module-header",style:t,children:(0,u.jsx)("h3",{className:"wp-block-sensei-lms-course-results__module-title",children:e})}),"minimal"===r&&(0,u.jsx)("div",{className:"wp-block-sensei-lms-course-results__separator"}),(0,u.jsx)("ul",{className:"wp-block-sensei-lms-course-results__lessons",children:[1,2].map(((e,s)=>(0,u.jsx)(d,{lessonNumber:e},s)))})]})
/**
 * Edit course results block component.
 *
 * @param {Object}  props                         Component props.
 * @param {string}  props.className               Custom class name.
 * @param {Object}  props.defaultMainColor        Default main color.
 * @param {Object}  props.defaultTextColor        Default text color.
 * @param {Object}  props.defaultBorderColor      Default border color.
 * @param {Object}  props.mainColor               Header main color.
 * @param {Object}  props.textColor               Header text color.
 * @param {Object}  props.borderColor             Default border color.
 * @param {Object}  props.attributes              Block attributes.
 * @param {boolean} props.attributes.moduleBorder True if a modules should have a border.
 */,p=(0,l.compose)((0,i/* .withDefaultBlockStyle */.Sw)(),(0,i/* .withColorSettings */.rt)({mainColor:{style:"background-color",label:(0,c.__)("Module color","sensei-lms")},textColor:{style:"color",label:(0,c.__)("Module text color","sensei-lms")},borderColor:{style:"border-color",label:(0,c.__)("Module border color","sensei-lms"),onChange:({clientId:e,colorValue:s})=>(0,a.dispatch)("core/block-editor").updateBlockAttributes(e,{borderColorValue:s})}}),(0,i/* .withDefaultColor */.Lt)({defaultMainColor:{style:"background-color",probeKey:"primaryColor"},defaultTextColor:{style:"color",probeKey:"primaryContrastColor"},defaultBorderColor:{style:"border-color",probeKey:"primaryColor"}}))((e=>{const{className:s,defaultMainColor:t,defaultTextColor:r,defaultBorderColor:o,mainColor:l,textColor:i,borderColor:a,attributes:{moduleBorder:d}}=e,p=s.match(/is-style-(\w+)/)?.[1],b={default:{background:l?.color||t?.color,color:i?.color||r?.color},minimal:{color:i?.color}}[p],g={"--sensei-module-header-bg-color":b?.background||"inherit","--sensei-module-header-text-color":b?.color||"inherit","--sensei-module-header-separator-color":l?.color||"inherit","--sensei-module-border-color":a?.color||o?.color};
return(0,u.jsxs)(u.Fragment,{children:[(0/* ["default"] */,u.jsx)(n.A,{...e}),(0,u.jsxs)("section",{className:s,style:g,children:[(0,u.jsxs)("div",{className:"wp-block-sensei-lms-course-results__grade",children:[(0,u.jsx)("span",{className:"wp-block-sensei-lms-course-results__grade-label",children:(0,c.__)("Your Total Grade","sensei-lms")}),(0,u.jsx)("span",{className:"wp-block-sensei-lms-course-results__grade-score",children:"XX%"})]}),(0,u.jsx)("h2",{className:"wp-block-sensei-lms-course-results__course-title",children:(0,c.__)("Course Title","sensei-lms")}),(0,u.jsx)(m,{moduleName:(0,c.__)("Module A","sensei-lms"),moduleBorder:d,headerStyles:b,style:p}),(0,u.jsx)(m,{moduleName:(0,c.__)("Module B","sensei-lms"),moduleBorder:d,headerStyles:b,style:p}),(0,u.jsx)(m,{moduleName:(0,c.__)("Module C","sensei-lms"),moduleBorder:d,headerStyles:b,style:p})]})]})}))}
/***/,
/***/22747:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>l
/* harmony export */});
/* harmony import */var r=t(5573),o=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
const l=(0,o.jsx)(r.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24",children:(0,o.jsx)(r.Path,{d:"m3 5c0-1.10457.89543-2 2-2h13.5c1.1046 0 2 .89543 2 2v13.5c0 1.1046-.8954 2-2 2h-13.5c-1.10457 0-2-.8954-2-2zm2-.5h6v6.5h-6.5v-6c0-.27614.22386-.5.5-.5zm-.5 8v6c0 .2761.22386.5.5.5h6v-6.5zm8 0v6.5h6c.2761 0 .5-.2239.5-.5v-6zm0-8v6.5h6.5v-6c0-.27614-.2239-.5-.5-.5z",fillRule:"evenodd",clipRule:"evenodd"})});
/* harmony default export */}
//# sourceMappingURL=grid.js.map
/***/,
/***/24743:
/***/e=>{"use strict";e.exports=JSON.parse('{"name":"sensei-lms/learner-courses","title":"Student Courses","description":"Manage what students see on their dashboard. This block is only displayed to logged in students.","category":"sensei-lms","textdomain":"sensei-lms","keywords":["student courses","my courses","dashboard","courses","enrolled","learner","student"],"supports":{"html":false,"inserter":false},"attributes":{"options":{"type":"object","default":{"layoutView":"list","courseDescriptionEnabled":true,"featuredImageEnabled":false,"courseCategoryEnabled":false,"progressBarEnabled":true,"progressBarBorderRadius":10,"progressBarHeight":14}}}}')}
/***/,
/***/27723:
/***/e=>{"use strict";e.exports=window.wp.i18n}
/***/,
/***/28108:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>/* reexport safe */r.A
/* harmony export */,m:()=>/* reexport safe */o.A
/* harmony export */});
/* harmony import */var r=t(95861),o=t(30983);
/* harmony import */}
/***/,
/***/29281:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */Lt:()=>/* binding */m
/* harmony export */,Sw:()=>/* binding */d
/* harmony export */,rt:()=>/* binding */c
/* harmony export */});
/* unused harmony export ColorSettings */
/* harmony import */var r=t(66087),o=t(86087),l=t(94715),n=t(27723),i=t(77549),a=t(62540);
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
const c=e=>s=>{const t=(0,r.mapValues)(e,(e=>e.style));return(0,l.withColors)(t)((t=>(0,a.jsxs)(a.Fragment,{children:[(0,a.jsx)(s,{...t}),(0,a.jsx)(u,{colorSettings:e,props:t})]})))},u=({colorSettings:e,props:s})=>{const t=Object.keys(e).map((t=>({value:s[t].color,label:e[t].label,onChange:o=>{s[`set${(0,r.upperFirst)(t)}`](o),e[t].onChange&&e[t].onChange({...s,colorValue:o})}}))),o=s.backgroundColor?.color?.includes("var")||s.textColor?.color?.includes("var"),i=s.backgroundColor&&s.textColor&&!o;
return(0,a.jsx)(l.InspectorControls,{children:(0,a.jsx)(l.PanelColorSettings,{title:(0,n.__)("Color settings","sensei-lms"),initialOpen:!1,colorSettings:t,children:i&&(0,a.jsx)(l.ContrastChecker,{textColor:s.textColor.color,backgroundColor:s.backgroundColor.color,isLargeText:!1})})})},d=(e="default")=>s=>t=>{let{className:r}=t;const o={};r&&r.includes("is-style-")||(r=o.className=[r,`is-style-${e}`].join(" "));const l=r.match(/is-style-(\w+)/);return l&&(o.blockStyle=l[1]),(0,a.jsx)(s,{...t,...o})}
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
 */,m=e=>s=>t=>{const{setAttributes:r,attributes:n}=t,c=(0,i/* .useColorsByProbe */.t)(),[u,d]=(0,o.useState)({}),m=Object.keys(e).map((e=>n[e]));return(0,o.useEffect)((()=>{const s={};Object.entries(e).forEach((([e,{style:t,probeKey:o}])=>{const i=c[o]||{},{slug:a}=i;if(a&&(s[e]={...i,className:(0,l.getColorClassName)(t,a)}),n[e]!==a){const s={};s[e]=a,
// Border color is not compatible with all themes as className, so the color value is needed.
"border-color"===t&&(s[`${e}Value`]=i.color),r(s)}})),d(s)}
// eslint-disable-next-line react-hooks/exhaustive-deps -- The deps are added dynamically because we get it dynamically from the attributes and we don't want add all attributes as dep.
),[c,r,...m]),(0,a.jsx)(s,{...t,...u})}
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
/* harmony import */var r=t(94715),o=t(56427),l=t(27723),n=t(62540);
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
const i=({borderRadius:e,setBorderRadius:s,height:t,setHeight:i})=>(e=void 0===e?10:e,t=void 0===t?14:t,(0,n.jsx)(r.InspectorControls,{children:(0,n.jsxs)(o.PanelBody,{title:(0,l.__)("Progress bar settings","sensei-lms"),initialOpen:!1,className:"sensei-progress-bar-settings",children:[(0,n.jsx)(o.PanelRow,{children:(0,n.jsx)(o.RangeControl,{label:(0,l.__)("Border radius","sensei-lms"),value:e,onChange:s,min:0,max:15,allowReset:!0,initialPosition:10})}),(0,n.jsx)(o.PanelRow,{children:(0,n.jsx)(o.RangeControl,{label:(0,l.__)("Height","sensei-lms"),value:t,onChange:i,min:1,max:25,allowReset:!0,initialPosition:14})})]})}));
/* harmony default export */}
/***/,
/***/35479:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>l
/* harmony export */});
/* harmony import */var r=t(5573),o=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
const l=(0,o.jsx)(r.SVG,{viewBox:"0 0 24 24",xmlns:"http://www.w3.org/2000/svg",children:(0,o.jsx)(r.Path,{d:"M8 12.5h8V11H8v1.5Z M19 6.5H5a2 2 0 0 0-2 2V15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V8.5a2 2 0 0 0-2-2ZM5 8h14a.5.5 0 0 1 .5.5V15a.5.5 0 0 1-.5.5H5a.5.5 0 0 1-.5-.5V8.5A.5.5 0 0 1 5 8Z"})});
/* harmony default export */}
//# sourceMappingURL=button.js.map
/***/,
/***/43180:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>i
/* harmony export */});
/* harmony import */var r=t(27723),o=t(72613),l=t(7928);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
const n={text:{default:(0,r.__)("My Messages","sensei-lms")}},i=(0,o/* .createButtonBlockType */.e)({tagName:"a",settings:{name:"sensei-lms/button-learner-messages",description:(0,r.__)("Enable a student to view their messages. This block is only displayed if the student is logged in and private messaging is enabled.","sensei-lms"),title:(0,r.__)("Student Messages Button","sensei-lms"),attributes:n,styles:[o/* .BlockStyles */.u.Fill,{...o/* .BlockStyles */.u.Outline,isDefault:!0},o/* .BlockStyles */.u.Link],deprecated:[{attributes:n,save:()=>null}]},EditWrapper:l/* ["default"] */.A});
/**
 * Learner messages button block.
 */
/* harmony default export */}
/***/,
/***/44539:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>a
/* harmony export */});
/* harmony import */var r=t(94715),o=t(56427),l=t(27723),n=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
const i=({borderRadius:e,setAttributes:s})=>(0,n.jsx)(o.PanelBody,{title:(0,l.__)("Border settings","sensei-lms"),initialOpen:!1,children:(0,n.jsx)(o.RangeControl,{label:(0,l.__)("Border radius","sensei-lms"),value:e,min:0,max:50,allowReset:!0,onChange:e=>s({borderRadius:e})})})
/**
 * Settings component for a Button block.
 *
 * @param {Object} props
 */,a=e=>{const{attributes:s,setAttributes:t}=e,{borderRadius:o,align:a}=s;
return(0,n.jsxs)(n.Fragment,{children:[(0,n.jsx)(r.BlockControls,{children:(0,n.jsx)(r.BlockAlignmentToolbar,{label:(0,l.__)("Change button alignment","sensei-lms"),value:a||e.alignmentOptions?.default,onChange:e=>{e&&t({align:e})},...e.alignmentOptions})}),(0,n.jsx)(r.InspectorControls,{children:(0,n.jsx)(i,{borderRadius:o,setAttributes:t})})]})}}
/***/,
/***/45853:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>u
/* harmony export */});
/* harmony import */var r=t(94715),o=t(56427),l=t(2835),n=t(22747),i=t(27723),a=t(28108),c=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Learner Settings component.
 *
 * @param {Object}   props
 * @param {Object}   props.options    Block options attribute.
 * @param {Function} props.setOptions Set options function.
 */
const u=({options:e,setOptions:s})=>{const t=[{optionKey:"featuredImageEnabled",label:(0,i.__)("Featured image","sensei-lms")},{optionKey:"courseCategoryEnabled",label:(0,i.__)("Category","sensei-lms")},{optionKey:"courseDescriptionEnabled",label:(0,i.__)("Description","sensei-lms")},{optionKey:"progressBarEnabled",label:(0,i.__)("Progress bar","sensei-lms")}],u=[{view:"list",label:(0,i.__)("List view","sensei-lms"),icon:l/* ["default"] */.A},{view:"grid",label:(0,i.__)("Grid view","sensei-lms"),icon:n/* ["default"] */.A}],d=[{optionKey:"primaryColor",label:(0,i.__)("Primary color","sensei-lms"),value:e.primaryColor||void 0},{optionKey:"accentColor",label:(0,i.__)("Accent color","sensei-lms"),value:e.accentColor||void 0}];
return(0,c.jsxs)(c.Fragment,{children:[(0,c.jsxs)(r.InspectorControls,{children:[(0,c.jsx)(o.PanelBody,{title:(0,i.__)("Course settings","sensei-lms"),initialOpen:!0,children:t.map((({optionKey:t,label:r})=>(0,c.jsx)(o.PanelRow,{children:(0,c.jsx)(o.ToggleControl,{checked:e[t],onChange:e=>{s({[t]:e})},label:r})},t)))}),(0,c.jsx)(o.PanelBody,{title:(0,i.__)("Styling","sensei-lms"),initialOpen:!0,children:(0,c.jsx)(o.PanelRow,{children:(0,c.jsx)(o.SelectControl,{label:(0,i.__)("Layout","sensei-lms"),options:u.map((({view:e,label:s})=>({value:e,label:s}))),value:e.layoutView,onChange:e=>{s({layoutView:e})}})})}),e.progressBarEnabled&&(0/* .ProgressBarSettings */,c.jsx)(a.m,{borderRadius:e.progressBarBorderRadius,setBorderRadius:e=>{s({progressBarBorderRadius:e})},height:e.progressBarHeight,setHeight:e=>{s({progressBarHeight:e})}}),(0,c.jsx)(r.PanelColorSettings,{title:(0,i.__)("Color settings","sensei-lms"),initialOpen:!1,colorSettings:d.map((({optionKey:e,...t})=>({...t,onChange:t=>{s({[e]:t})}})))})]}),(0,c.jsx)(r.BlockControls,{children:(0,c.jsx)(o.ToolbarGroup,{children:u.map((({view:t,label:r,icon:l})=>(0,c.jsx)(o.ToolbarButton,{extraProps:{"data-testid":t},isActive:t===e.layoutView,icon:l,label:r,onClick:()=>{s({layoutView:t})}},t)))})})]})};
/* harmony default export */}
/***/,
/***/47056:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>i
/* harmony export */});
/* harmony import */var r=t(66087),o=t(74997),l=t(48597),n=t(62540);
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
const i=e=>{(0,o.updateCategory)("sensei-lms",{icon:(0/* ["default"] */,n.jsx)(l.A,{width:"20",height:"20"})}),e.forEach((e=>{let{metadata:s,name:t,...l}=e;s&&(
// Remove the overlapping metadata keys from the settings object to make localization work.
// This is needed because only the metadata object is localized, but the overlapping keys will be overwritten by the settings object and the localization is lost.
l=(0,r.omit)(l,Object.keys(s))),
// The metadata object should be used for the `block.json` strings to be localized.
// See https://github.com/Automattic/sensei/pull/5782 for more details.
// The metadata object should be used for the `block.json` strings to be localized.
// See https://github.com/Automattic/sensei/pull/5782 for more details.
(0,o.registerBlockType)(s||t,l)}))};
/* harmony default export */}
/***/,
/***/47143:
/***/e=>{"use strict";e.exports=window.wp.data}
/***/,
/***/48597:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>i
/* harmony export */});
/* harmony import */var r,o,l=t(51609);
/* harmony import */function n(){return n=Object.assign?Object.assign.bind():function(e){for(var s=1;s<arguments.length;s++){var t=arguments[s];for(var r in t)({}).hasOwnProperty.call(t,r)&&(e[r]=t[r])}return e},n.apply(null,arguments)}
/* harmony default export */const i=function(e){
return l.createElement("svg",n({viewBox:"0 0 24 24",fill:"none",xmlns:"http://www.w3.org/2000/svg"},e),r||(r=l.createElement("circle",{cx:12,cy:12,r:12,fill:"#43AF99"})),o||(o=l.createElement("path",{fillRule:"evenodd",clipRule:"evenodd",d:"M9.835 15.38c.3-.23.179-.474.6-.563-.02.194.146.391.251.563-.109-.367-.002-.536.08-.72.347-.785-.662-1.293-1.35-1.418.235-.164.399-.327.694-.355a2.377 2.377 0 0 0-1.058.23c-1.112.531-1.993-.523-1.41-1.48.31-.51.664-.519.982-.865.077.178.103.372.075.564a.919.919 0 0 0 .049-.664c-.104-.336-.4-.338-.456-.821-.012-.101-.105.056-.263-.077-.038-.032-.113-.09-.163-.064-.085.044-.18.008-.232.034-.083.041-.109-.045-.2.016-.16.107-.178-.013-.332.005-.193.023-.32.261-.43.144-.102-.108-.206.075-.28.075-.05 0-.311.317-.426.028-.086-.216-.28.206-.382.063-.033-.046-.123.108-.18-.044-.014-.035 0-.078-.108-.027-.215.099-.138-.06-.207-.144-.083-.103-.113-.103-.068-.27.036-.133-.019-.33.2-.364.055-.008.107-.005.184-.148.096-.18.231-.093.207-.175-.036-.119.143-.28.226-.355.11-.103.254-.252.306-.396a.63.63 0 0 1 .102-.141c.081-.084.105-.003.227-.045.088-.03.02.053.106-.07.028-.038.105-.001.19-.039.259-.112.283-.11.347-.371.012-.05.025-.088.08-.083.109.01.134-.052.2-.05.061.001.083-.03.115-.068.18-.216.277-.055.357-.072.06-.012.022-.142.184-.102.23.057.155-.05.303-.015.174.041.186.19.306.225.143.042.211.198.307.196.337-.005.235.23.448.323-.16-.161.012-.421-.352-.455-.08-.007-.11-.127-.23-.183-.146-.067-.13-.21-.394-.27.068-.04.089.005.13-.073.058-.11.09-.046.113-.113.02-.063.006-.099.165-.155.165-.06.325-.195.472-.188.13.006.185-.08.177-.19-.008-.112-.033-.267.222-.22.153.029.15.003.15-.1-.002-.102.04-.165.174-.16.098.002.194-.003.231-.117.03-.091.207-.114.302-.148.317-.114.361.05.447-.095.07-.117.196-.317.337-.175.028.029.054.05.15-.056.08-.088.27-.2.337-.048.027.06.086.121.138.044a.08.08 0 0 1 .053-.039c.05-.01.079-.024.104-.036.218-.101.314-.095.213.125-.142.316.792-.192.532.151-.095.126.538.197.63.254.05.032.048.059.144.077.271.05.267.026.284.243.007.098.107.043.107.168 0 .535.472.266.549.399.012.022.032.042.079.042.149 0 .157-.03.224.089.027.047.05.072.127.096.12.037.112.05.068.138-.054.104.03.102.138.112.1.01.148.062.216.138.11.122.284.156.43.227.084.04.002.14.143.243.104.077.156.066.016.165-.59.418.22.305.446.694.051.087.118.195.216.295.225.23.1.293.221.437.07.083.015.063.13.137.272.175-.105.292-.319.212-.097-.035-.166-.085-.147-.025.016.049-.01.083-.052.12-.125.112.123.068.181.06.181-.025.664-.076.66.093-.005.22.136.27.25.284.185.024.238.057.34.226.092.152.145.07.288.205.097.093.217.258.02.282-.047.005-.099 0-.12.017a.411.411 0 0 1-.14.066c-.295.09.14.136.246.113.093-.02.209-.05.3-.027.057.015.062.08.244.107.06.01.036.099.006.16-.104.214.191.1.16.263-.017.093.11.245-.067.248-.057.001-.117-.015-.115.034.004.105-.165-.03-.317.115-.056.054-.19.092-.272-.009-.032-.038-.07-.069-.218-.023-.144.046-.242.204-.306-.04-.017-.064-.05-.065-.142-.097-.125-.043-.114-.258-.297-.12a.24.24 0 0 1-.214.039c-.144-.037-.303.012-.317-.096-.021-.179-.191-.305-.377-.296-.147.008-.278.034-.355-.137.057.195.207.208.382.208.144 0 .23.075.255.225.045.265.204.099.406.223.1.06.17.159.21.273.042.118.37-.024.282.258-.037.122-.107.168-.242.266-.4.294-.5.004-.618.239-.062.121-.063.031-.196.09-.22.098-.36-.128-.522-.045-.182.094-.168-.08-.352.037-.152.097-.308-.074-.38.192-.063.227-.322.232-.44.11-.189-.194-.132.229-.362.054-.123-.091-.213.043-.392.045-.33.005-.489-.282-.65-.107-.192.206-.331-.032-.334-.242-.003-.216-.777-.144-1.185-.256-.225-.062-.932.013-.702-.35-.372.39.456.366.682.455.136.053.245.095.377.114.13.296.214.617.227 1.007.043-.214.053-.433.028-.649-.043-.383.242.19.276.272.184.45-.022 1.278-.488 1.526a2.957 2.957 0 0 0-.562-.99c.256.392.616 1.192.327 1.65a1.023 1.023 0 0 1-.55-.483c.077.333.413.702.818.58.707-.213.704.233 1.641.307.682.111 1.654 0 2.118.037.254.02 1.32.197 1.315.465-.02 1.105-.438 1.164-1.539 1.268-.64.06-1.134.085-1.823.11-1.54.058-3.391.06-4.868 0-.724-.03-1.072-.036-1.841-.137-.769-.1-1.19-.363-1.178-1.187.005-.304.905-.594 1.2-.628.347-.039.901.005 1.405-.116.527-.127.747-.21 1.135-.508Zm5.347-6.052c-.167-.042-.051-.138-.339-.014-.17.073-.194-.13-.365-.094-.172.036-.242-.125-.499-.166-.318-.05-.088-.133-.592-.032-.097.02-.179-.09-.481-.052-.355.046-.23.084-.445-.115-.272-.251-.488-.082-.767-.184.216.166.368.019.622.221-.242.138-.523.802-.962.844.478.107.709.354 1.148.413.504.068.882.118 1.151.531.301.463.44.196.874.168.275-.017.282-.185.328-.362.063-.245.126-.256.31-.289.213-.037.163-.092.107-.156-.15-.172.019-.207.146-.244.222-.064.042-.075.042-.166-.278-.09-.063-.217.092-.273.169.105.242.087.317.073.109-.021.181.03.273-.028-.135.014-.163-.037-.278-.02-.051.007-.112.01-.219-.054-.18-.107-.27.048-.463 0Zm-2.28 1.64-1.09-.545c-1.316-.657-1.915.313-2.337 1.376l-.766.73c.549-.338.996-.714 1.574-.71.092 0 1.516.484 1.286-.092-.04-.104.09-.052.125-.201.04-.17.055-.141.195-.033.089.069.211.113.174-.048-.017-.072-.04-.137.28-.004.15.062.095-.064.303-.09.29-.034.228-.31.364-.349.076-.022.152.058.295-.077.05-.046.11-.089.232-.057-.143-.073-.22-.014-.292.03-.146.089-.204-.037-.343.07Zm-2.23-1.923c.16-.02.32-.036.482-.046a.13.13 0 0 0 .074-.06.111.111 0 0 0 .007-.09.268.268 0 0 1 .147-.206l-.002-.003c-.258.001-.466.1-.73.211-.052.022-.024.111-.118.213a.26.26 0 0 1-.201.235.136.136 0 0 0-.09.046.113.113 0 0 0-.026.092.252.252 0 0 1-.277.061c-.2-.077-.35-.065-.448.036a.39.39 0 0 1 .398.014c.134.066.3.031.39-.082a.132.132 0 0 1 .126-.098.421.421 0 0 0 .268-.323Z",fill:"#fff"})))};
/***/},
/***/50480:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>f
/* harmony export */});
/* harmony import */var r=t(4452),o=t.n(r),l=t(66087),n=t(47143),i=t(74997),a=t(86087),c=t(12417),u=t(76109),d=t(56427),m=t(94715),p=t(27723),b=t(28108),g=t(45853),_=t(67939),h=t(62540);
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
 * Deprecation notice component.
 *
 * @param {Object} props
 * @param {Object} props.clientId Block client ID.
 */
const x=({clientId:e})=>{const{replaceBlock:s}=(0,n.useDispatch)(m.store);
return(0,h.jsx)("div",{className:"wp-block-sensei-lms-learner-courses__deprecation-notice",children:(0,h.jsx)(m.Warning,{actions:[(0,h.jsx)(d.Button,{__next40pxDefaultSize:!0,variant:"primary",onClick:()=>{const t=(0,i.createBlock)("core/query",_/* .DEFAULT_ATTRIBUTES */.g2);s(e,t)},children:(0,p.__)("Replace","sensei-lms")},"replace-block-action"),(0,h.jsx)(d.Button,{__next40pxDefaultSize:!0,variant:"secondary",href:"https://senseilms.com/documentation/course-list-block/",target:"_blank",children:(0,p.__)("Read more","sensei-lms")},"read-more-action")],children:(0,p.__)("This is a legacy block. Use the Course List block for more customization and flexibility.","sensei-lms")})})},y=()=>(0,h.jsx)("div",{className:"wp-block-sensei-lms-learner-courses__courses-list__featured-image",role:"img","aria-label":"Featured image",children:(0/* ["default"] */,h.jsx)(c.A,{icon:u/* ["default"] */.A,size:48})})
/**
 * Wrapper for CSS variables & related classes.
 *
 * @param {Object} props
 * @param {string} props.tagName   HTML tag.
 * @param {Array}  props.variables CSS variables.
 * @param {Object} props.children  Children elements.
 * @param {string} props.className Classes.
 */,v=({tagName:e="div",variables:s,children:t,className:r,...n})=>(0,h.jsx)(e,{className:o()(r,{"has-sensei-primary-color":!!s.primaryColor,"has-sensei-accent-color":!!s.accentColor}),style:(0,l.omitBy)({"--sensei-progress-bar-height":s.progressBarHeight,"--sensei-progress-bar-border-radius":s.progressBarBorderRadius,"--sensei-primary-color":s.primaryColor,"--sensei-accent-color":s.accentColor},(e=>[void 0,null,"undefinedpx"].includes(e))),...n,children:t}),f=({clientId:e,className:s,attributes:{options:t},setAttributes:r})=>{const[l,n]=(0,a.useState)("all"),i=[{label:(0,p.__)("All Courses","sensei-lms"),value:"all"},{label:(0,p.__)("Active Courses","sensei-lms"),value:"active"},{label:(0,p.__)("Completed Courses","sensei-lms"),value:"completed"}];
return(0,h.jsxs)(h.Fragment,{children:[(0,h.jsxs)(v,{tagName:"section",className:s,variables:{primaryColor:t.primaryColor,accentColor:t.accentColor,progressBarHeight:`${t.progressBarHeight}px`,progressBarBorderRadius:`${t.progressBarBorderRadius}px`},children:[(0,h.jsx)(x,{clientId:e}),(0,h.jsx)("p",{className:"wp-block-sensei-lms-learner-courses__filter",children:i.map((({label:e,value:s})=>{return(0,h.jsx)("a",{href:`#${s}`,onClick:(t=s,e=>{e.preventDefault(),n(t)}),className:o()("wp-block-sensei-lms-learner-courses__filter__item",{active:s===l}),children:e},s);var t}))}),(0,h.jsx)("ul",{className:o()("wp-block-sensei-lms-learner-courses__courses-list",`wp-block-sensei-lms-learner-courses__courses-list--is-${t.layoutView}-view`),children:Array.from({length:2}).map(((e,s,r)=>{const o=
// All items should be in progress if active filter is selected.
"active"!==l&&(
//  Show last one as completed.
s===r.length-1||
//  Show all as completed if completed is filtered.
"completed"===l);
return(0,h.jsx)("li",{className:"wp-block-sensei-lms-learner-courses__courses-list__item course",children:(0,h.jsxs)("section",{className:"entry",children:[t.featuredImageEnabled&&(0,h.jsx)(y,{}),(0,h.jsxs)("div",{className:"wp-block-sensei-lms-learner-courses__courses-list__details",children:[(0,h.jsx)("h3",{className:"wp-block-sensei-lms-learner-courses__courses-list__title",children:(0,h.jsx)("a",{href:"#",children:(0,p.__)("Course Title","sensei-lms")})}),t.courseCategoryEnabled&&(0,h.jsx)("span",{className:"wp-block-sensei-lms-learner-courses__courses-list__category",children:(0,p.__)("Category Name","sensei-lms")}),t.courseDescriptionEnabled&&(0,h.jsx)("p",{className:"wp-block-sensei-lms-learner-courses__courses-list__description",children:(0,p.__)("This is a preview of the course description…","sensei-lms")}),t.progressBarEnabled&&(0/* ["default"] */,h.jsx)(b.A,{totalCount:3,completedCount:o?3:1,wrapperAttributes:{className:"wp-block-sensei-lms-course-progress"},hidePercentage:!0,label:(0,p.__)("lessons","sensei-lms")}),o&&(0,h.jsx)("div",{className:"sensei-results-links wp-block-buttons",children:(0,h.jsx)("div",{className:"wp-block-button",children:(0,h.jsx)("a",{className:"wp-block-button__link",href:"#",children:(0,p.__)("View Results","sensei-lms")})})})]})]})},s)}))})]}),(0/* ["default"] */,h.jsx)(g.A,{options:t,setOptions:e=>r({options:{...t,...e}})
// Courses placeholder map function.
})]})};
/**
 * Featured image placeholder element.
 */}
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
/***/60146:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>n
/* harmony export */});
/* harmony import */var r,o=t(51609);
/* harmony import */function l(){return l=Object.assign?Object.assign.bind():function(e){for(var s=1;s<arguments.length;s++){var t=arguments[s];for(var r in t)({}).hasOwnProperty.call(t,r)&&(e[r]=t[r])}return e},l.apply(null,arguments)}
/* harmony default export */const n=function(e){
return o.createElement("svg",l({width:24,height:24,fill:"none",xmlns:"http://www.w3.org/2000/svg"},e),r||(r=o.createElement("path",{fillRule:"evenodd",clipRule:"evenodd",d:"M19 4.5H5a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h14a.5.5 0 0 0 .5-.5V5a.5.5 0 0 0-.5-.5ZM5 3a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h4.511l-1.03 2.75H7a.75.75 0 0 0 0 1.5h10a.75.75 0 0 0 0-1.5h-1.48L14.489 16H19a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2H5Zm5 3.5 5 3-5 3v-6Zm3.918 12.25h-3.836l.938-2.5h1.96l.938 2.5Z",fill:"#1E1E1E"})))};
/***/},
/***/62540:
/***/(e,s,t)=>{"use strict";e.exports=t(2192)}
/***/,
/***/63059:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>i
/* harmony export */});
/* harmony import */var r=t(27723),o=t(94715),l=t(56427),n=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Inspector controls for course results block.
 *
 * @param {Object} props Block props.
 */
const i=e=>{const{attributes:{moduleBorder:s},setAttributes:t}=e;
return(0,n.jsx)(o.InspectorControls,{children:(0,n.jsx)(l.PanelBody,{title:(0,r.__)("Modules","sensei-lms"),initialOpen:!0,children:(0,n.jsx)(l.ToggleControl,{checked:s,onChange:e=>t({moduleBorder:e}),label:(0,r.__)("Border","sensei-lms"),help:(0,r.__)("Toggle the border for all modules.","sensei-lms")})})})};
/* harmony default export */}
/***/,
/***/66087:
/***/e=>{"use strict";e.exports=window.lodash}
/***/,
/***/67939:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */g2:()=>/* binding */a
/* harmony export */});
/* unused harmony exports registerCourseListBlock, addWrapperAroundFeaturedImageBlock, addWrapperAroundCourseCategoriesBlock */
/* harmony import */var r=t(27723),o=(t(74997),t(47143)),l=t(52619),n=(t(70371),t(16711),t(8473)),i=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
const a={className:"wp-block-sensei-lms-course-list",query:{perPage:3,pages:0,offset:0,postType:"course",order:"desc",orderBy:"date",author:"",search:"",exclude:[],sticky:"",inherit:!1}},c=(0,o.subscribe)((()=>{const e=document.querySelector(".interface-interface-skeleton__sidebar");e&&(u(e),c())})),u=e=>{
// pass in the settings panel node, as well as the options.
new MutationObserver((()=>{const e=(0,o.select)("core/block-editor").getSelectedBlock();"core/query"===e?.name&&e?.attributes?.className?.includes("wp-block-sensei-lms-course-list")&&d()})).observe(e,{childList:!0,subtree:!0})},d=()=>{const e=document.querySelectorAll(".components-input-control__label,.components-toggle-control__label");e&&0!==e.length&&Array.from(e).forEach((e=>{[/* eslint-disable-next-line @wordpress/i18n-text-domain */ /* eslint-disable-next-line @wordpress/i18n-text-domain */
(0,r.__)("Post type").toLowerCase(),/* eslint-disable-next-line @wordpress/i18n-text-domain */ /* eslint-disable-next-line @wordpress/i18n-text-domain */
(0,r.__)("Inherit query from template").toLowerCase()].includes(e.textContent.toLowerCase())&&(e.closest(".components-base-control").style.display="none")}))};(0,l.addFilter)("blocks.registerBlockType","sensei-lms/course-list-block",(
/**
 * Add a HOC to a featured image block.
 *
 * @param {Object} settings Block settings.
 * @param {string} name     Block name.
 */
function(e,s){if("core/post-featured-image"!==s)return e;const t=e.edit;return e={...e,edit:e=>"course"===e.context?.postType&&!!e.context?.queryId?(0/* ["default"] */,i.jsx)(n.A,{postId:e.context.postId,isFeaturedImage:!0,children:(0,i.jsx)(t,{...e})}):(0,i.jsx)(t,{...e})}})),(0,l.addFilter)("blocks.registerBlockType","sensei-lms/course-categories",(
/**
 * Add a HOC to a featured course categories block.
 *
 * @param {Object} settings Block settings.
 * @param {string} name     Block name.
 */
function(e,s){if("sensei-lms/course-categories"!==s)return e;const t=e.edit;return e.attributes.align=!1,e={...e,edit:e=>"course"===e.context?.postType&&!!e.context?.queryId?(0/* ["default"] */,i.jsx)(n.A,{postId:e.context.postId,isFeaturedImage:!1,children:(0,i.jsx)(t,{...e})}):(0,i.jsx)(t,{...e})}}))}
/***/,
/***/70371:
/***/(e,s,t)=>{"use strict";
/* unused harmony export withQueryLoopPatternsAndSettingsHiddenForCourseList */
/* harmony import */var r=t(27723),o=t(52619),l=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
let n=!1;
/**
 * Check if a block already exists in the editor.
 *
 * @param {string} clientId The block client id.
 * @return {boolean} Whether the block exists in the editor.
 */const i=e=>!!document.getElementById("block-"+e);
/**
 * Hide pattern selector controls.
 */(0,o.addFilter)("editor.BlockEdit","sensei-lms/course-list-block",(e=>s=>{const t="core/query"===s.name,o=t&&s?.attributes?.className?.includes("wp-block-sensei-lms-course-list");
// Hide query loop toolbar settings for grid/list outlook.
if(o&&s.isSelected?n=!0:s.isSelected&&(n=!1),i(s.clientId)&&n){const e=(0,r.__)("Grid view","sensei-lms"),s=document.querySelector(`[aria-label="${e}"]`);if(s){s.parentNode.style.display="none"}}
// Hide query loop patterns for course list.
return n&&t&&!o&&!i(s.clientId)&&(
// Hide carousel control button and switch to grid view.
document.querySelectorAll(".block-editor-block-pattern-setup__display-controls").forEach((e=>{const s=e.querySelectorAll("button");
// Select Grid view.
s[1].click(),
// Hide all control buttons.
s.forEach((e=>{e.style.display="none"}))})),document.querySelectorAll(".block-editor-block-pattern-setup-list__list-item").forEach((e=>{[...e.querySelectorAll("div")].find((e=>"course-list-element"===e.innerText))||(e.style.display="none")}))),(0,l.jsx)(e,{...s})}))}
/***/,
/***/71127:
/***/(e,s,t)=>{"use strict";
/* unused harmony exports addColorSettings, removeColorSaveProps, removeColorEditProps, removeWrapperProps */
/* harmony import */var r=t(66087),o=t(52619),l=t(27723),n=t(29281),i=t(62540);
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
const a=e=>(e="string"==typeof e?e:e.name)&&e.startsWith("sensei-lms/button"),c=e=>({...e,className:e?.className?.replace(/\s*has-[\w-]*(color|background)/g,""),style:(0,r.omitBy)(e?.style,((e,s)=>s.match(/(color|background|background-color|border)/)))})
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
 */(0,o.addFilter)("blocks.getSaveContent.extraProps","sensei/button/removeColorSaveProps",((e,s)=>a(s)?c(e):e)),(0,o.addFilter)("blocks.registerBlockType","sensei/button/removeColorEditProps",(e=>{if(!a(e))return e;const s=e.getEditWrapperProps;return s&&(e.getEditWrapperProps=e=>{const t=s(e);return c(t)}),e})),(0,o.addFilter)("blocks.registerBlockType","sensei/button/addColorSettings",(e=>a(e)?(e.supports?.color&&!e.attributes?.backgroundColor&&(e.edit=(0,n/* .withColorSettings */.rt)({backgroundColor:{style:"background-color",label:(0,l.__)("Background color","sensei-lms")},textColor:{style:"color",label:(0,l.__)("Text color","sensei-lms")}})(e.edit),e.attributes={...e.attributes,backgroundColor:{type:"string"},customBackgroundColor:{type:"string"},textColor:{type:"string"},customTextColor:{type:"string"}}),e):e)),(0,o.addFilter)("editor.BlockListBlock","sensei/button/removeWrapperProps",(e=>s=>{let{name:t,wrapperProps:r}=s;return a(t)&&r&&(r=c(r)),(0,i.jsx)(e,{...s,wrapperProps:r})}),1)}
/***/,
/***/71406:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */KS:()=>/* binding */i
/* harmony export */,_N:()=>/* binding */a
/* harmony export */,xh:()=>/* binding */n
/* harmony export */});
/* unused harmony export getBorderRadiusProps */
/* harmony import */var r=t(4452),o=t.n(r),l=t(98157);
/* harmony import */
/**
 * Class and style attributes for the button.
 *
 * @param {{attributes}} props Block properties.
 * @return {{className, style}} Output HTML attributes.
 */
function n(e){const s=a(e),t=(0,l/* .getColorAndStyleProps */.g)(e),r=
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
function({attributes:{borderRadius:e}}){return{className:{"no-border-radius":0===e},style:{borderRadius:e?e+"px":void 0}}}(e);return{className:o()({"wp-block-button__link":!s},r.className,t.className,e?.attributes?.buttonClassName),style:{...r.style,...t.style}}}
/**
 * Class and style attributes for the wrapper element.
 *
 * @param {Object} props                  Block properties.
 * @param {string} props.className        Block classname.
 * @param {Object} props.attributes       Block attributes.
 * @param {string} props.attributes.align Alignment attribute.
 * @return {{className}} Output HTML attributes.
 */function i({className:e,attributes:{align:s}}){return{className:o()(e,"wp-block-sensei-button","wp-block-button",`has-text-align-${s||"left"}`)}}
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
/* harmony export */e:()=>/* binding */g
/* harmony export */,u:()=>/* binding */b
/* harmony export */});
/* harmony import */var r=t(66087),o=t(4452),l=t.n(o),n=t(27723),i=t(74997),a=t(35479),c=(t(71127),t(90078)),u=t(21307),d=t(74862),m=t(29281),p=t(62540);
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
const b={Fill:{name:"default",label:(0,n.__)("Fill","sensei-lms")},Outline:{name:"outline",label:(0,n.__)("Outline","sensei-lms")},Link:{name:"link",label:(0,n.__)("Link","sensei-lms")}},g=({settings:e,invalidUsage:s,EditWrapper:t,...o})=>{o={alignmentOptions:{controls:["left","center","right","full"],default:"left"},...o};const g=e.styles?e.styles:[{...b.Fill,isDefault:!0},b.Outline],_=(0,r.find)(g,"isDefault")?.name,h=(0,m/* .withDefaultBlockStyle */.Sw)(_)(c/* ["default"] */.A),x=(0,m/* .withDefaultBlockStyle */.Sw)(_)(u/* ["default"] */.A);return(0,r.merge)({name:"sensei-lms/button",title:"Sensei Button",category:"sensei-lms",attributes:{text:{type:"string",source:"html",selector:"a,button"},align:{type:"string"},borderRadius:{type:"number"},style:{type:"object"},isPreview:{type:"boolean",default:!1},inContainer:{type:"boolean",default:!1},buttonClassName:{type:"array",default:[]}},usesContext:["postType"],supports:{__experimentalBorder:{color:!0,width:!0,style:!0},border:!0,color:{gradients:!0,link:!0,__experimentalDefaultControls:{background:!0,text:!0,link:!0}},__experimentalColor:{gradients:!0},align:!1,html:!1},icon:a/* ["default"] */.A,styles:g,edit(e){const{postType:r}=e.context,l=(0,p.jsx)(h,{...e,...o});if(s?.validPostTypes&&!s.validPostTypes.includes(r)){const e=s?.message||(0,n.__)("This block can only be used inside the Course List block.","sensei-lms");
return(0/* ["default"] */,p.jsx)(d.A,{message:e})}return t?(0,p.jsx)(t,{...e,children:l}):l},save:s=>(0,p.jsx)(x,{...s,...o,blockName:e.name}),getEditWrapperProps:({inContainer:s,align:t})=>s?{className:l()("sensei-buttons-container__button-block",(0,i.getBlockDefaultClassName)(e.name)+"__wrapper",{[`sensei-buttons-container__button-align-${t}`]:t})}:{},example:{attributes:{align:"center",isPreview:!0}}},e)};
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
/* harmony export */A:()=>l
/* harmony export */});
/* harmony import */var r=t(94715),o=t(62540);
/* harmony import */
/* harmony default export */const l=
/**
 * WordPress dependencies
 */
function({message:e}){const s=(0,r.useBlockProps)();
return(0,o.jsx)("div",{...s,children:(0,o.jsx)(r.Warning,{children:e})})};
/***/},
/***/74997:
/***/e=>{"use strict";e.exports=window.wp.blocks}
/***/,
/***/75851:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>i
/* harmony export */});
/* harmony import */var r=t(27723),o=t(60146),l=t(13121),n=t(22342);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/* harmony default export */const i={...l,metadata:l,styles:[{name:"default",label:(0,r.__)("Filled","sensei-lms"),isDefault:!0},{name:"minimal",label:(0,r.__)("Minimal","sensei-lms")}],example:{attributes:{}},icon:o/* ["default"] */.A,edit:n/* ["default"] */.A};
/***/},
/***/76109:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>l
/* harmony export */});
/* harmony import */var r=t(5573),o=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
const l=(0,o.jsx)(r.SVG,{viewBox:"0 0 24 24",xmlns:"http://www.w3.org/2000/svg",children:(0,o.jsx)(r.Path,{d:"M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM5 4.5h14c.3 0 .5.2.5.5v8.4l-3-2.9c-.3-.3-.8-.3-1 0L11.9 14 9 12c-.3-.2-.6-.2-.8 0l-3.6 2.6V5c-.1-.3.1-.5.4-.5zm14 15H5c-.3 0-.5-.2-.5-.5v-2.4l4.1-3 3 1.9c.3.2.7.2.9-.1L16 12l3.5 3.4V19c0 .3-.2.5-.5.5z"})});
/* harmony default export */}
//# sourceMappingURL=image.js.map
/***/,
/***/77549:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */t:()=>/* binding */a
/* harmony export */});
/* unused harmony export getProbeStyles */
/* harmony import */var r=t(66087),o=t(86087),l=t(47143),n=t(83157);
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
const{getComputedStyle:i}=window,a=()=>{const e=(0,l.useSelect)((e=>e("core/editor").getEditorSettings().colors),[]),[s,t]=(0,o.useState)({});return(0,o.useEffect)((()=>{const s=c(),o={},l=(0,r.mapValues)((0,r.keyBy)(e,(e=>(0,n/* .hexToRGB */.i)(e.color))),"slug");Object.entries(s).forEach((([e,s])=>{const t=l[(0,n/* .hexToRGB */.i)(s)];t&&(o[e]={slug:t,color:s})})),t(o)}),[e]),s},c=(0,r.memoize)((()=>{
// Create temporary probe elements.
const e=document.createElement("div");e.className="editor-styles-wrapper sensei-probe-element";const s=document.createElement("div");s.className="wp-block-button";const t=document.createElement("div");t.className="wp-block-button__link",t.textContent="Probe",
// Set probe position outside the screen to be hidden.
e.style.position="fixed",e.style.top="-100vh",
// Add probe to the screen.
s.appendChild(t),e.appendChild(s),document.body.appendChild(e);
// Save styles.
const r={primaryColor:i(t).backgroundColor,primaryContrastColor:i(t).color};
// Remove probe.
return document.body.removeChild(e),r}));
/**
 * Get color object by probe.
 *
 * @return {Object} Object containing the color objects, where the key is the probe key.
 */}
/***/,
/***/81365:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>i
/* harmony export */});
/* harmony import */var r,o,l=t(51609);
/* harmony import */function n(){return n=Object.assign?Object.assign.bind():function(e){for(var s=1;s<arguments.length;s++){var t=arguments[s];for(var r in t)({}).hasOwnProperty.call(t,r)&&(e[r]=t[r])}return e},n.apply(null,arguments)}
/* harmony default export */const i=function(e){
return l.createElement("svg",n({viewBox:"0 0 24 24",fill:"none",xmlns:"http://www.w3.org/2000/svg"},e),r||(r=l.createElement("path",{stroke:"currentColor",fill:"transparent",strokeWidth:1.5,d:"M19.25 14.75v-10H4.75v10z"})),o||(o=l.createElement("path",{fill:"currentColor",fillRule:"evenodd",clipRule:"evenodd",d:"M8 12h8V8H8v4ZM7.221 19.862l3.558-4.991L9.558 14 6 18.99l1.221.872ZM16.558 19.862 13 14.87 14.222 14l3.557 4.99-1.221.872Z"})))};
/***/},
/***/83157:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */i:()=>/* binding */r
/* harmony export */});
/**
 * Converts css color hex to rgb.
 *
 * @param {string} h The hex color string.
 *
 * @return {string} The rgb value.
 */
const r=e=>{
// Returns if it's not an hexadecimal.
if(!e||null===e.match("#"))return e;let s=0,t=0,r=0;const o=4===e.length?`#${e[1]+e[1]+e[2]+e[2]+e[3]+e[3]}`:e;return 7===o.length&&(s=parseInt(o.substr(1,2),16)||0,t=parseInt(o.substr(3,2),16)||0,r=parseInt(o.substr(5,2),16)||0),`rgb(${s}, ${t}, ${r})`};
/***/},
/***/86087:
/***/e=>{"use strict";e.exports=window.wp.element}
/***/,
/***/90078:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */A:()=>c
/* harmony export */});
/* harmony import */var r=t(47143),o=t(94715),l=t(27723),n=t(71406),i=t(44539),a=t(62540);
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
const c=e=>{const{placeholder:s,attributes:t,setAttributes:c}=e,{text:u}=t,{colors:d}=(0,r.useSelect)((e=>e("core/block-editor").getSettings()),[]),m=void 0!==e.text,p=(0,n/* .getButtonProps */.xh)({...e,colors:d});
return(0,a.jsxs)("div",{...(0,n/* .getButtonWrapperProps */.KS)(e),children:[m?(0,a.jsx)("div",{...p,children:e.text}):(0,a.jsx)(o.RichText,{placeholder:s||(0,l.__)("Add text…","sensei-lms"),value:u,onChange:e=>c({text:e}),...p,tagName:"div",identifier:"text",withoutInteractiveFormatting:!0}),(0/* ["default"] */,a.jsx)(i.A,{...e})]})};
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
/* harmony import */var r=t(4452),o=t.n(r),l=t(27723),n=t(94715),i=t(62540);
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
const a=({totalCount:e,completedCount:s,hidePercentage:t,wrapperAttributes:r,barWrapperAttributes:a,barAttributes:c,countersClassName:u,completedCountClassName:d,hideDefault:m,label:p})=>{const b=Math.round(s/e*100)||0,g=Math.max(m?0:3,b),_=(0,n.useBlockProps)(r);
return(0,i.jsxs)("div",{..._,children:[(0,i.jsx)("section",{className:o()("sensei-progress-bar__heading",u),children:(0,i.jsxs)("div",{className:o()("sensei-progress-bar__label",d),children:[(0,l.sprintf)(
// translators: Placeholder %1$d is the completed progress count, %2$d is the total count and %3$s is the label for progress bar.
// translators: Placeholder %1$d is the completed progress count, %2$d is the total count and %3$s is the label for progress bar.
(0,l.__)("%1$d of %2$d %3$s completed","sensei-lms"),s,e,p||""),!t&&` (${b}%)`]})}),(0,i.jsx)("div",{role:"progressbar","aria-valuenow":b,"aria-valuemin":"0","aria-valuemax":"100",...a,className:o()("sensei-progress-bar__bar",a?.className),children:(0,i.jsx)("div",{...c,className:o()("sensei-progress-bar__progress",c?.className),style:{...c?.style&&c.style,width:`${g}%`}})})]})};
/* harmony default export */}
/***/,
/***/98157:
/***/(e,s,t)=>{"use strict";
/* harmony export */t.d(s,{
/* harmony export */g:()=>/* binding */n
/* harmony export */});
/* unused harmony export getGradientClass */
/* harmony import */var r=t(4452),o=t.n(r),l=t(94715);
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
const n=({attributes:e,colors:s})=>{const{backgroundColor:t,borderColor:r,customBackgroundColor:n,textColor:i,customTextColor:a,gradient:c,style:u={}}=e,d=(0,l.getColorClassName)("background-color",t);u.color||(u.color={}),n&&(u.color.background=n),a&&(u.color.text=a);const m=(0,l.getColorClassName)("border-color",r),p=(e=>{if(e)return`has-${e}-gradient-background`})(c),b=(0,l.getColorClassName)("color",i),g=o()(b,p,m,{
// Don't apply the background class if there's a custom gradient
[d]:!u?.color?.gradient&&!!d,"has-text-color":i||u?.color?.text,"has-background":t||u?.color?.background||c||u?.color?.gradient,"has-border-color":r}),_=u?.color?.background||u?.color?.text||u?.color?.gradient?{background:u?.color?.gradient?u.color.gradient:void 0,backgroundColor:u?.color?.background?u.color.background:void 0,color:u?.color?.text?u.color.text:void 0}:{};
// This is needed only for themes that don't load their color stylesheets in the editor
// We force an inline style to apply the color.
if(u?.border?.color&&(_.borderColor=u.border.color),u?.border?.width&&(_.borderWidth=u.border.width),s){if(t){const e=(0,l.getColorObjectByAttributeValues)(s,t);_.backgroundColor=e.color}if(i){const e=(0,l.getColorObjectByAttributeValues)(s,i);_.color=e.color}}return{className:g||void 0,style:_}};
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
/******/function t(r){
/******/ // Check if module is in cache
/******/var o=s[r];
/******/if(void 0!==o)
/******/return o.exports;
/******/
/******/ // Create a new module (and put it into the cache)
/******/var l=s[r]={
/******/ // no module.id needed
/******/ // no module.loaded needed
/******/exports:{}
/******/};
/******/
/******/ // Execute the module function
/******/
/******/
/******/ // Return the exports of the module
/******/return e[r](l,l.exports,t),l.exports;
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
/* harmony import */var e=t(47056),s=t(1957),r=t(43180),o=t(13194),l=t(75851);
/* harmony import */
/**
 * Internal dependencies
 */
/**
 * Internal dependencies
 */
(0,o/* .registerCourseCompletedActionsBlock */.e)(),(0,e/* ["default"] */.A)([s/* ["default"] */.A,r/* ["default"] */.A,l/* ["default"] */.A])})()})
/******/();