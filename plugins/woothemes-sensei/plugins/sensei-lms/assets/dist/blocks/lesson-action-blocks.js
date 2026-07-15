/******/(()=>{// webpackBootstrap
/******/var e={
/***/1027:
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */A:()=>r
/* harmony export */});
/* harmony import */var o=s(5573),n=s(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
const r=(0,n.jsx)(o.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24",children:(0,n.jsx)(o.Path,{d:"M16.7 7.1l-6.3 8.5-3.3-2.5-.9 1.2 4.5 3.4L17.9 8z"})});
/* harmony default export */}
//# sourceMappingURL=check.js.map
/***/,
/***/2192:
/***/(e,t,s)=>{"use strict";
/**
 * @license React
 * react-jsx-runtime.production.min.js
 *
 * Copyright (c) Facebook, Inc. and its affiliates.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */var o=s(51609),n=Symbol.for("react.element"),r=Symbol.for("react.fragment"),l=Object.prototype.hasOwnProperty,i=o.__SECRET_INTERNALS_DO_NOT_USE_OR_YOU_WILL_BE_FIRED.ReactCurrentOwner,a={key:!0,ref:!0,__self:!0,__source:!0};function c(e,t,s){var o,r={},c=null,u=null;for(o in void 0!==s&&(c=""+s),void 0!==t.key&&(c=""+t.key),void 0!==t.ref&&(u=t.ref),t)l.call(t,o)&&!a.hasOwnProperty(o)&&(r[o]=t[o]);if(e&&e.defaultProps)for(o in t=e.defaultProps)void 0===r[o]&&(r[o]=t[o]);return{$$typeof:n,type:e,key:c,ref:u,props:r,_owner:i.current}}t.Fragment=r,t.jsx=c,t.jsxs=c}
/***/,
/***/2567:
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */A:()=>a
/* harmony export */});
/* harmony import */var o=s(4452),n=s.n(o),r=s(56427),l=s(1027),i=s(62540);
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
const a=({options:e,optionsLabel:t,icon:s,value:o,onChange:a,toggleProps:c,getMenuItemProps:u,popoverProps:d,...m})=>{const p=e.find((e=>o===e.value));
return(0,i.jsx)(r.ToolbarDropdownMenu,{className:"sensei-toolbar-dropdown",popoverProps:{variant:"toolbar",position:"bottom right left",focusOnMount:!0,...d,className:n()(d?.className,"sensei-toolbar-dropdown__popover")},label:t,icon:null!=s?s:null,text:c?.children?c.children(p):p?.label,...m,children:({onClose:s})=>(0,i.jsx)(r.MenuGroup,{label:t,children:e.map((e=>{const t=e.value===p?.value,o=u?.(e);
return(0,i.jsx)(r.MenuItem,{role:"menuitemradio",isSelected:t,icon:t?l/* ["default"] */.A:null,className:n()("sensei-toolbar-dropdown__option",{"is-selected":t},o?.className),onClick:()=>{a(e.value),s()},children:e.label,...o},e.value)}))})})};
/* harmony default export */}
/***/,
/***/3088:
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */A:()=>r
/* harmony export */});
/* harmony import */var o=s(27723),n=s(72613);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Complete lesson button block.
 */
/* harmony default export */const r=(0,n/* .createButtonBlockType */.e)({settings:{name:"sensei-lms/button-lesson-completed",parent:["sensei-lms/lesson-actions"],title:(0,o.__)("Lesson Completed","sensei-lms"),description:(0,o.__)("This button becomes visible only when a lesson is completed. It has no other functionality other than indicating that the lesson is completed","sensei-lms"),keywords:[(0,o.__)("Completed","sensei-lms"),(0,o.__)("Finished","sensei-lms"),(0,o.__)("Lesson","sensei-lms"),(0,o.__)("Button","sensei-lms")],attributes:{text:{default:(0,o.__)("Completed","sensei-lms")}},styles:[n/* .BlockStyles */.u.Fill,{...n/* .BlockStyles */.u.Outline,isDefault:!0},n/* .BlockStyles */.u.Link]}});
/***/},
/***/3876:
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */A:()=>r
/* harmony export */});
/* harmony import */var o=s(27723),n=s(72613);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Next lesson button block.
 */
/* harmony default export */const r=(0,n/* .createButtonBlockType */.e)({settings:{name:"sensei-lms/button-next-lesson",title:(0,o.__)("Next Lesson","sensei-lms"),parent:["sensei-lms/lesson-actions"],description:(0,o.__)("Enable a student to move to the next lesson. This block is only displayed if the current lesson has been completed.","sensei-lms"),keywords:[(0,o.__)("Next","sensei-lms"),(0,o.__)("Continue","sensei-lms"),(0,o.__)("Lesson","sensei-lms"),(0,o.__)("Button","sensei-lms")],attributes:{text:{default:(0,o.__)("Next Lesson","sensei-lms")}},styles:[{...n/* .BlockStyles */.u.Fill,isDefault:!0},n/* .BlockStyles */.u.Outline,n/* .BlockStyles */.u.Link]}});
/***/},
/***/4452:
/***/(e,t)=>{var s;
/*!
	Copyright (c) 2018 Jed Watson.
	Licensed under the MIT License (MIT), see
	http://jedwatson.github.io/classnames
*/
/* global define */!function(){"use strict";var o={}.hasOwnProperty;function n(){for(var e="",t=0;t<arguments.length;t++){var s=arguments[t];s&&(e=l(e,r(s)))}return e}function r(e){if("string"==typeof e||"number"==typeof e)return e;if("object"!=typeof e)return"";if(Array.isArray(e))return n.apply(null,e);if(e.toString!==Object.prototype.toString&&!e.toString.toString().includes("[native code]"))return e.toString();var t="";for(var s in e)o.call(e,s)&&e[s]&&(t=l(t,s));return t}function l(e,t){return t?e?e+" "+t:e+t:e}e.exports?(n.default=n,e.exports=n):void 0===(s=function(){return n}.apply(t,[]))||(e.exports=s)}()}
/***/,
/***/5573:
/***/e=>{"use strict";e.exports=window.wp.primitives}
/***/,
/***/11038:
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */A:()=>i
/* harmony export */});
/* harmony import */var o=s(67372),n=s(36279),r=s(48394),l=s(19976);
/* harmony import */
/**
 * Internal dependencies
 */
/* harmony default export */const i={...o,metadata:o,example:{innerBlocks:[{name:"sensei-lms/button-lesson-completed"},{name:"sensei-lms/button-complete-lesson"},{name:"sensei-lms/button-next-lesson"},{name:"sensei-lms/button-reset-lesson"}]},icon:l/* ["default"] */.A,edit:n/* ["default"] */.A,save:r/* ["default"] */.A};
/***/},
/***/11051:
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */A:()=>r
/* harmony export */});
/* harmony import */var o=s(27723),n=s(72613);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Take Quiz button block.
 */
/* harmony default export */const r=(0,n/* .createButtonBlockType */.e)({settings:{name:"sensei-lms/button-view-quiz",title:(0,o.__)("Take Quiz","sensei-lms"),parent:["sensei-lms/lesson-actions"],description:(0,o.__)("Enable a student to take the quiz.","sensei-lms"),keywords:[(0,o.__)("Quiz","sensei-lms"),(0,o.__)("Lesson","sensei-lms"),(0,o.__)("Button","sensei-lms")],attributes:{text:{default:(0,o.__)("Take Quiz","sensei-lms")}},styles:[{...n/* .BlockStyles */.u.Fill,isDefault:!0},n/* .BlockStyles */.u.Outline,n/* .BlockStyles */.u.Link]}});
/***/},
/***/19695:
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */IB:()=>/* reexport safe */i.A
/* harmony export */,P5:()=>/* reexport safe */r.A
/* harmony export */,bz:()=>/* reexport safe */l.A
/* harmony export */,pV:()=>/* reexport safe */n.A
/* harmony export */,pl:()=>/* reexport safe */a.A
/* harmony export */,rJ:()=>/* reexport safe */o.A
/* harmony export */});
/* harmony import */var o=s(11038),n=s(56882),r=s(3876),l=s(31242),i=s(11051),a=s(3088);
/* harmony import */}
/**
 * Internal dependencies
 */
/***/,
/***/19976:
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */A:()=>l
/* harmony export */});
/* harmony import */var o,n=s(51609);
/* harmony import */function r(){return r=Object.assign?Object.assign.bind():function(e){for(var t=1;t<arguments.length;t++){var s=arguments[t];for(var o in s)({}).hasOwnProperty.call(s,o)&&(e[o]=s[o])}return e},r.apply(null,arguments)}
/* harmony default export */const l=function(e){
return n.createElement("svg",r({viewBox:"0 0 24 24",xmlns:"http://www.w3.org/2000/svg"},e),o||(o=n.createElement("path",{d:"M17 3H7c-1.1 0-2 .9-2 2v4c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm.5 6c0 .3-.2.5-.5.5H7c-.3 0-.5-.2-.5-.5V5c0-.3.2-.5.5-.5h10c.3 0 .5.2.5.5v4zm-8-1.2h5V6.2h-5v1.6zM17 13H7c-1.1 0-2 .9-2 2v4c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2v-4c0-1.1-.9-2-2-2zm.5 6c0 .3-.2.5-.5.5H7c-.3 0-.5-.2-.5-.5v-4c0-.3.2-.5.5-.5h10c.3 0 .5.2.5.5v4zm-8-1.2h5v-1.5h-5v1.5z",fill:"currentColor"})))};
/***/},
/***/21307:
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */A:()=>c
/* harmony export */});
/* harmony import */var o=s(4452),n=s.n(o),r=s(94715),l=s(74997),i=s(71406),a=s(62540);
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
const c=({attributes:e,className:t,tagName:s,blockName:o})=>{const{text:c,inContainer:u,align:d}=e;let m=s;s||(m=(0,i/* .isLinkStyle */._N)({attributes:e})?"a":"button");const p=(0,a.jsx)("div",{...(0,i/* .getButtonWrapperProps */.KS)({className:t,attributes:e}),children:(0,a.jsx)(r.RichText.Content,{...(0,i/* .getButtonProps */.xh)({attributes:e}),tagName:m,value:c})});return u?(0,a.jsx)("div",{className:n()(t,"sensei-buttons-container__button-block",(0,l.getBlockDefaultClassName)(o)+"__wrapper",{[`sensei-buttons-container__button-align-${d}`]:d}),children:p}):p};
/* harmony default export */}
/***/,
/***/24704:
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */A:()=>r
/* harmony export */});
/* harmony import */var o=s(47143),n=s(86087);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Has quiz hook.
 *
 * @return {boolean} If a quiz exists with questions.
 */
const r=()=>{const[e,t]=(0,n.useState)((()=>{const e=document.getElementById("question_counter");return e?parseInt(e.value,10)>0:null}));(0,n.useEffect)((()=>{const e=e=>{t(e.detail.questions>0)};return window.addEventListener("sensei-quiz-editor-question-count-updated",e),()=>{window.removeEventListener("sensei-quiz-editor-question-count-updated",e)}}),[]);const{_quiz_has_questions:s}=(0,o.useSelect)((e=>e("core/editor").getEditedPostAttribute("meta")))||{};return null!==e?e:s};
/* harmony default export */}
/***/,
/***/26767:
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */B8:()=>/* binding */r
/* harmony export */,Gd:()=>/* binding */o
/* harmony export */,Jq:()=>/* binding */l
/* harmony export */,LB:()=>/* binding */a
/* harmony export */,fw:()=>/* binding */i
/* harmony export */,tt:()=>/* binding */n
/* harmony export */});
// The action blocks, ordered.
const o=["sensei-lms/button-complete-lesson","sensei-lms/button-view-quiz","sensei-lms/button-lesson-completed","sensei-lms/button-next-lesson","sensei-lms/button-reset-lesson"],n={"sensei-lms/button-complete-lesson":{inContainer:!0},"sensei-lms/button-lesson-completed":{inContainer:!0},"sensei-lms/button-next-lesson":{inContainer:!0},"sensei-lms/button-reset-lesson":{inContainer:!0},"sensei-lms/button-view-quiz":{inContainer:!0}},r=o.map((e=>[e,{...n[e]}])),l="completed",i="in-progress",a={[l]:["sensei-lms/button-next-lesson","sensei-lms/button-lesson-completed","sensei-lms/button-reset-lesson"],[i]:["sensei-lms/button-view-quiz","sensei-lms/button-complete-lesson"]}}
/***/,
/***/27723:
/***/e=>{"use strict";e.exports=window.wp.i18n}
/***/,
/***/29281:
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */Sw:()=>/* binding */c
/* harmony export */,rt:()=>/* binding */i
/* harmony export */});
/* unused harmony exports ColorSettings, withDefaultColor */
/* harmony import */var o=s(66087),n=(s(86087),s(94715)),r=s(27723),l=(s(77549),s(62540));
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
const i=e=>t=>{const s=(0,o.mapValues)(e,(e=>e.style));return(0,n.withColors)(s)((s=>(0,l.jsxs)(l.Fragment,{children:[(0,l.jsx)(t,{...s}),(0,l.jsx)(a,{colorSettings:e,props:s})]})))},a=({colorSettings:e,props:t})=>{const s=Object.keys(e).map((s=>({value:t[s].color,label:e[s].label,onChange:n=>{t[`set${(0,o.upperFirst)(s)}`](n),e[s].onChange&&e[s].onChange({...t,colorValue:n})}}))),i=t.backgroundColor?.color?.includes("var")||t.textColor?.color?.includes("var"),a=t.backgroundColor&&t.textColor&&!i;
return(0,l.jsx)(n.InspectorControls,{children:(0,l.jsx)(n.PanelColorSettings,{title:(0,r.__)("Color settings","sensei-lms"),initialOpen:!1,colorSettings:s,children:a&&(0,l.jsx)(n.ContrastChecker,{textColor:t.textColor.color,backgroundColor:t.backgroundColor.color,isLargeText:!1})})})},c=(e="default")=>t=>s=>{let{className:o}=s;const n={};o&&o.includes("is-style-")||(o=n.className=[o,`is-style-${e}`].join(" "));const r=o.match(/is-style-(\w+)/);return r&&(n.blockStyle=r[1]),(0,l.jsx)(t,{...s,...n})}
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
 */;
/**
 * Color setting inspector controls.
 *
 * @param {Object} params
 * @param {Object} params.colorSettings Color definitions.
 * @param {Object} params.props         Component props
 * @class
 */}
/***/,
/***/31242:
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */A:()=>r
/* harmony export */});
/* harmony import */var o=s(27723),n=s(72613);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Reset lesson button block.
 */
/* harmony default export */const r=(0,n/* .createButtonBlockType */.e)({settings:{name:"sensei-lms/button-reset-lesson",title:(0,o.__)("Reset Lesson","sensei-lms"),parent:["sensei-lms/lesson-actions"],description:(0,o.__)("Enable a student to reset their progress. This block is only displayed if the lesson is completed and has no quiz, or the quiz is completed and retakes are enabled.","sensei-lms"),keywords:[(0,o.__)("Reset","sensei-lms"),(0,o.__)("Restart","sensei-lms"),(0,o.__)("Revert","sensei-lms"),(0,o.__)("Progress","sensei-lms"),(0,o.__)("Lesson","sensei-lms"),(0,o.__)("Button","sensei-lms")],attributes:{text:{default:(0,o.__)("Reset Lesson","sensei-lms")},buttonClassName:{default:["sensei-stop-double-submission"]}},styles:[n/* .BlockStyles */.u.Fill,{...n/* .BlockStyles */.u.Outline,isDefault:!0},n/* .BlockStyles */.u.Link]}});
/***/},
/***/31436:
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */A:()=>l
/* harmony export */});
/* harmony import */var o=s(86087),n=s(47143),r=s(26767);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Preview state hook.
 *
 * @param {string} defaultPreviewState Default preview state.
 *
 * @return {Array} Array containing preview state and change handler, respectively.
 */
const l=e=>{const[t,s]=(0,o.useState)(e),l=(0,n.useSelect)((e=>e("core/block-editor").getSelectedBlock()));
// Update the preview state based on the block selection.
// Update the preview state based on the block selection.
return(0,o.useEffect)((()=>{if(!r/* .ACTION_BLOCKS */.Gd.includes(l?.name))return;const e=Object.keys(r/* .PREVIEW_STATE */.LB).find((e=>r/* .PREVIEW_STATE */.LB[e].includes(l.name)));e!==t&&s(e)}),[l,t]),[t,s]};
/* harmony default export */}
/***/,
/***/32634:
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */A:()=>c
/* harmony export */});
/* harmony import */var o=s(94715),n=s(56427),r=s(27723),l=s(2567),i=s(26767),a=s(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * @typedef {Object} ToggleBlock
 *
 * @property {string}   label    Toggle label.
 * @property {boolean}  active   Whether block is active.
 * @property {Function} onToggle Toggle function.
 */
/**
 * Inspector controls for lesson actions block.
 *
 * @param {Object}        props
 * @param {ToggleBlock[]} props.toggleBlocks    Blocks to toggle.
 * @param {string}        props.previewState    Preview state.
 * @param {Function}      props.onPreviewChange Preview change callback.
 */
const c=({toggleBlocks:e,previewState:t,onPreviewChange:s})=>(0,a.jsxs)(a.Fragment,{children:[(0,a.jsx)(o.BlockControls,{children:(0,a.jsx)(n.ToolbarGroup,{children:(0/* ["default"] */,a.jsx)(l.A,{options:[{label:(0,r.__)("In Progress","sensei-lms"),value:i/* .IN_PROGRESS_PREVIEW */.fw},{label:(0,r.__)("Completed","sensei-lms"),value:i/* .COMPLETED_PREVIEW */.Jq}],optionsLabel:(0,r.__)("Preview lesson state","sensei-lms"),value:t,onChange:s})})}),(0,a.jsx)(o.InspectorControls,{children:(0,a.jsx)(n.PanelBody,{title:(0,r.__)("Additional Actions","sensei-lms"),children:e.map((e=>(0,a.jsx)(n.ToggleControl,{checked:e.active,onChange:e.onToggle,label:e.label},e.label)))})})]})
/* harmony default export */}
/***/,
/***/35479:
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */A:()=>r
/* harmony export */});
/* harmony import */var o=s(5573),n=s(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
const r=(0,n.jsx)(o.SVG,{viewBox:"0 0 24 24",xmlns:"http://www.w3.org/2000/svg",children:(0,n.jsx)(o.Path,{d:"M8 12.5h8V11H8v1.5Z M19 6.5H5a2 2 0 0 0-2 2V15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V8.5a2 2 0 0 0-2-2ZM5 8h14a.5.5 0 0 1 .5.5V15a.5.5 0 0 1-.5.5H5a.5.5 0 0 1-.5-.5V8.5A.5.5 0 0 1 5 8Z"})});
/* harmony default export */}
//# sourceMappingURL=button.js.map
/***/,
/***/36279:
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */A:()=>v
/* harmony export */});
/* harmony import */var o=s(4452),n=s.n(o),r=s(94715),l=s(27723),i=s(31436),a=s(60381),c=s(24704),u=s(99023),d=s(32634),m=s(26767),p=s(47143),b=s(43656),g=s(62540);
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
const _=window?.sensei?.courseThemeEnabled||!1,v=e=>{const{className:t,clientId:s,setAttributes:o,attributes:{toggledBlocks:v}}=e,[h,x]=(0/* .IN_PROGRESS_PREVIEW */,i/* ["default"] */.A)(m.fw),{isSiteEditor:k}=(0,p.useSelect)((e=>{const t=e(b.store).getCurrentPostId();return{isSiteEditor:!Number.isInteger(t)}})),f=(0,a/* ["default"] */.A)({parentClientId:s,setAttributes:o,toggledBlocks:v,blocks:[{blockName:"sensei-lms/button-reset-lesson",label:(0,l.__)("Reset Lesson","sensei-lms")}]}),w=(0,c/* ["default"] */.A)(),y=w||k?"has-quiz":"no-quiz",C=(0,u/* ["default"] */.A)(w)?"allowed":"not-allowed",j=k?"site-editor":"lesson-editor";if(_)return null;
// Filter inner blocks based on the settings.
const A=m/* .INNER_BLOCKS_TEMPLATE */.B8.filter((e=>!1!==v[e[0]]));
return(0,g.jsxs)(g.Fragment,{children:[(0/* ["default"] */,g.jsx)(d.A,{previewState:h,onPreviewChange:x,toggleBlocks:f}),(0,g.jsx)("div",{className:n()(t,`wp-block-sensei-lms-lesson-actions__preview-${h}`,`wp-block-sensei-lms-lesson-actions__${y}`,`wp-block-sensei-lms-lesson-actions__complete_lessons-${C}`,`wp-block-sensei-lms-lesson-actions__preview-${j}`),children:(0,g.jsx)("div",{className:"sensei-buttons-container",children:(0,g.jsx)(r.InnerBlocks,{allowedBlocks:m/* .ACTION_BLOCKS */.Gd,template:A,templateLock:"all",templateInsertUpdatesSelection:!1})})})]})};
/**
 * Edit lesson actions block component.
 *
 * @param {Object}   props
 * @param {string}   props.className                Custom class name.
 * @param {string}   props.clientId                 Block ID.
 * @param {Function} props.setAttributes            Block set attributes function.
 * @param {Object}   props.attributes               Block attributes.
 * @param {Object}   props.attributes.toggledBlocks Toggled blocks, where the key is the block name.
 */}
/***/,
/***/43656:
/***/e=>{"use strict";e.exports=window.wp.editor}
/***/,
/***/44539:
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */A:()=>a
/* harmony export */});
/* harmony import */var o=s(94715),n=s(56427),r=s(27723),l=s(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
const i=({borderRadius:e,setAttributes:t})=>(0,l.jsx)(n.PanelBody,{title:(0,r.__)("Border settings","sensei-lms"),initialOpen:!1,children:(0,l.jsx)(n.RangeControl,{label:(0,r.__)("Border radius","sensei-lms"),value:e,min:0,max:50,allowReset:!0,onChange:e=>t({borderRadius:e})})})
/**
 * Settings component for a Button block.
 *
 * @param {Object} props
 */,a=e=>{const{attributes:t,setAttributes:s}=e,{borderRadius:n,align:a}=t;
return(0,l.jsxs)(l.Fragment,{children:[(0,l.jsx)(o.BlockControls,{children:(0,l.jsx)(o.BlockAlignmentToolbar,{label:(0,r.__)("Change button alignment","sensei-lms"),value:a||e.alignmentOptions?.default,onChange:e=>{e&&s({align:e})},...e.alignmentOptions})}),(0,l.jsx)(o.InspectorControls,{children:(0,l.jsx)(i,{borderRadius:n,setAttributes:s})})]})}}
/***/,
/***/47056:
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */A:()=>i
/* harmony export */});
/* harmony import */var o=s(66087),n=s(74997),r=s(48597),l=s(62540);
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
const i=e=>{(0,n.updateCategory)("sensei-lms",{icon:(0/* ["default"] */,l.jsx)(r.A,{width:"20",height:"20"})}),e.forEach((e=>{let{metadata:t,name:s,...r}=e;t&&(
// Remove the overlapping metadata keys from the settings object to make localization work.
// This is needed because only the metadata object is localized, but the overlapping keys will be overwritten by the settings object and the localization is lost.
r=(0,o.omit)(r,Object.keys(t))),
// The metadata object should be used for the `block.json` strings to be localized.
// See https://github.com/Automattic/sensei/pull/5782 for more details.
// The metadata object should be used for the `block.json` strings to be localized.
// See https://github.com/Automattic/sensei/pull/5782 for more details.
(0,n.registerBlockType)(t||s,r)}))};
/* harmony default export */}
/***/,
/***/47143:
/***/e=>{"use strict";e.exports=window.wp.data}
/***/,
/***/48394:
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */A:()=>r
/* harmony export */});
/* harmony import */var o=s(94715),n=s(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
const r=({className:e})=>(0,n.jsx)("div",{className:e,children:(0,n.jsx)("div",{className:"sensei-buttons-container",children:(0,n.jsx)(o.InnerBlocks.Content,{})})})
/* harmony default export */}
/***/,
/***/48597:
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */A:()=>i
/* harmony export */});
/* harmony import */var o,n,r=s(51609);
/* harmony import */function l(){return l=Object.assign?Object.assign.bind():function(e){for(var t=1;t<arguments.length;t++){var s=arguments[t];for(var o in s)({}).hasOwnProperty.call(s,o)&&(e[o]=s[o])}return e},l.apply(null,arguments)}
/* harmony default export */const i=function(e){
return r.createElement("svg",l({viewBox:"0 0 24 24",fill:"none",xmlns:"http://www.w3.org/2000/svg"},e),o||(o=r.createElement("circle",{cx:12,cy:12,r:12,fill:"#43AF99"})),n||(n=r.createElement("path",{fillRule:"evenodd",clipRule:"evenodd",d:"M9.835 15.38c.3-.23.179-.474.6-.563-.02.194.146.391.251.563-.109-.367-.002-.536.08-.72.347-.785-.662-1.293-1.35-1.418.235-.164.399-.327.694-.355a2.377 2.377 0 0 0-1.058.23c-1.112.531-1.993-.523-1.41-1.48.31-.51.664-.519.982-.865.077.178.103.372.075.564a.919.919 0 0 0 .049-.664c-.104-.336-.4-.338-.456-.821-.012-.101-.105.056-.263-.077-.038-.032-.113-.09-.163-.064-.085.044-.18.008-.232.034-.083.041-.109-.045-.2.016-.16.107-.178-.013-.332.005-.193.023-.32.261-.43.144-.102-.108-.206.075-.28.075-.05 0-.311.317-.426.028-.086-.216-.28.206-.382.063-.033-.046-.123.108-.18-.044-.014-.035 0-.078-.108-.027-.215.099-.138-.06-.207-.144-.083-.103-.113-.103-.068-.27.036-.133-.019-.33.2-.364.055-.008.107-.005.184-.148.096-.18.231-.093.207-.175-.036-.119.143-.28.226-.355.11-.103.254-.252.306-.396a.63.63 0 0 1 .102-.141c.081-.084.105-.003.227-.045.088-.03.02.053.106-.07.028-.038.105-.001.19-.039.259-.112.283-.11.347-.371.012-.05.025-.088.08-.083.109.01.134-.052.2-.05.061.001.083-.03.115-.068.18-.216.277-.055.357-.072.06-.012.022-.142.184-.102.23.057.155-.05.303-.015.174.041.186.19.306.225.143.042.211.198.307.196.337-.005.235.23.448.323-.16-.161.012-.421-.352-.455-.08-.007-.11-.127-.23-.183-.146-.067-.13-.21-.394-.27.068-.04.089.005.13-.073.058-.11.09-.046.113-.113.02-.063.006-.099.165-.155.165-.06.325-.195.472-.188.13.006.185-.08.177-.19-.008-.112-.033-.267.222-.22.153.029.15.003.15-.1-.002-.102.04-.165.174-.16.098.002.194-.003.231-.117.03-.091.207-.114.302-.148.317-.114.361.05.447-.095.07-.117.196-.317.337-.175.028.029.054.05.15-.056.08-.088.27-.2.337-.048.027.06.086.121.138.044a.08.08 0 0 1 .053-.039c.05-.01.079-.024.104-.036.218-.101.314-.095.213.125-.142.316.792-.192.532.151-.095.126.538.197.63.254.05.032.048.059.144.077.271.05.267.026.284.243.007.098.107.043.107.168 0 .535.472.266.549.399.012.022.032.042.079.042.149 0 .157-.03.224.089.027.047.05.072.127.096.12.037.112.05.068.138-.054.104.03.102.138.112.1.01.148.062.216.138.11.122.284.156.43.227.084.04.002.14.143.243.104.077.156.066.016.165-.59.418.22.305.446.694.051.087.118.195.216.295.225.23.1.293.221.437.07.083.015.063.13.137.272.175-.105.292-.319.212-.097-.035-.166-.085-.147-.025.016.049-.01.083-.052.12-.125.112.123.068.181.06.181-.025.664-.076.66.093-.005.22.136.27.25.284.185.024.238.057.34.226.092.152.145.07.288.205.097.093.217.258.02.282-.047.005-.099 0-.12.017a.411.411 0 0 1-.14.066c-.295.09.14.136.246.113.093-.02.209-.05.3-.027.057.015.062.08.244.107.06.01.036.099.006.16-.104.214.191.1.16.263-.017.093.11.245-.067.248-.057.001-.117-.015-.115.034.004.105-.165-.03-.317.115-.056.054-.19.092-.272-.009-.032-.038-.07-.069-.218-.023-.144.046-.242.204-.306-.04-.017-.064-.05-.065-.142-.097-.125-.043-.114-.258-.297-.12a.24.24 0 0 1-.214.039c-.144-.037-.303.012-.317-.096-.021-.179-.191-.305-.377-.296-.147.008-.278.034-.355-.137.057.195.207.208.382.208.144 0 .23.075.255.225.045.265.204.099.406.223.1.06.17.159.21.273.042.118.37-.024.282.258-.037.122-.107.168-.242.266-.4.294-.5.004-.618.239-.062.121-.063.031-.196.09-.22.098-.36-.128-.522-.045-.182.094-.168-.08-.352.037-.152.097-.308-.074-.38.192-.063.227-.322.232-.44.11-.189-.194-.132.229-.362.054-.123-.091-.213.043-.392.045-.33.005-.489-.282-.65-.107-.192.206-.331-.032-.334-.242-.003-.216-.777-.144-1.185-.256-.225-.062-.932.013-.702-.35-.372.39.456.366.682.455.136.053.245.095.377.114.13.296.214.617.227 1.007.043-.214.053-.433.028-.649-.043-.383.242.19.276.272.184.45-.022 1.278-.488 1.526a2.957 2.957 0 0 0-.562-.99c.256.392.616 1.192.327 1.65a1.023 1.023 0 0 1-.55-.483c.077.333.413.702.818.58.707-.213.704.233 1.641.307.682.111 1.654 0 2.118.037.254.02 1.32.197 1.315.465-.02 1.105-.438 1.164-1.539 1.268-.64.06-1.134.085-1.823.11-1.54.058-3.391.06-4.868 0-.724-.03-1.072-.036-1.841-.137-.769-.1-1.19-.363-1.178-1.187.005-.304.905-.594 1.2-.628.347-.039.901.005 1.405-.116.527-.127.747-.21 1.135-.508Zm5.347-6.052c-.167-.042-.051-.138-.339-.014-.17.073-.194-.13-.365-.094-.172.036-.242-.125-.499-.166-.318-.05-.088-.133-.592-.032-.097.02-.179-.09-.481-.052-.355.046-.23.084-.445-.115-.272-.251-.488-.082-.767-.184.216.166.368.019.622.221-.242.138-.523.802-.962.844.478.107.709.354 1.148.413.504.068.882.118 1.151.531.301.463.44.196.874.168.275-.017.282-.185.328-.362.063-.245.126-.256.31-.289.213-.037.163-.092.107-.156-.15-.172.019-.207.146-.244.222-.064.042-.075.042-.166-.278-.09-.063-.217.092-.273.169.105.242.087.317.073.109-.021.181.03.273-.028-.135.014-.163-.037-.278-.02-.051.007-.112.01-.219-.054-.18-.107-.27.048-.463 0Zm-2.28 1.64-1.09-.545c-1.316-.657-1.915.313-2.337 1.376l-.766.73c.549-.338.996-.714 1.574-.71.092 0 1.516.484 1.286-.092-.04-.104.09-.052.125-.201.04-.17.055-.141.195-.033.089.069.211.113.174-.048-.017-.072-.04-.137.28-.004.15.062.095-.064.303-.09.29-.034.228-.31.364-.349.076-.022.152.058.295-.077.05-.046.11-.089.232-.057-.143-.073-.22-.014-.292.03-.146.089-.204-.037-.343.07Zm-2.23-1.923c.16-.02.32-.036.482-.046a.13.13 0 0 0 .074-.06.111.111 0 0 0 .007-.09.268.268 0 0 1 .147-.206l-.002-.003c-.258.001-.466.1-.73.211-.052.022-.024.111-.118.213a.26.26 0 0 1-.201.235.136.136 0 0 0-.09.046.113.113 0 0 0-.026.092.252.252 0 0 1-.277.061c-.2-.077-.35-.065-.448.036a.39.39 0 0 1 .398.014c.134.066.3.031.39-.082a.132.132 0 0 1 .126-.098.421.421 0 0 0 .268-.323Z",fill:"#fff"})))};
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
/***/56882:
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */A:()=>r
/* harmony export */});
/* harmony import */var o=s(27723),n=s(72613);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Complete lesson button block.
 */
/* harmony default export */const r=(0,n/* .createButtonBlockType */.e)({settings:{name:"sensei-lms/button-complete-lesson",parent:["sensei-lms/lesson-actions"],title:(0,o.__)("Complete Lesson","sensei-lms"),description:(0,o.__)("Enable a student to mark the lesson as complete. This block is only displayed if the lesson has no quiz or the quiz is optional.","sensei-lms"),keywords:[(0,o.__)("Complete","sensei-lms"),(0,o.__)("Finish","sensei-lms"),(0,o.__)("Lesson","sensei-lms"),(0,o.__)("Button","sensei-lms")],attributes:{text:{default:(0,o.__)("Complete Lesson","sensei-lms")},buttonClassName:{default:["sensei-stop-double-submission"]}},styles:[{...n/* .BlockStyles */.u.Fill,isDefault:!0},n/* .BlockStyles */.u.Outline,n/* .BlockStyles */.u.Link]}});
/***/},
/***/60381:
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */A:()=>i
/* harmony export */});
/* harmony import */var o=s(86087),n=s(47143),r=s(74997),l=s(26767);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Toggle blocks hook.
 *
 * @param {Object}   options                Hook options.
 * @param {string}   options.parentClientId Parent client ID.
 * @param {Function} options.setAttributes  Set attributes function.
 * @param {Object}   options.toggledBlocks  Toggled blocks, where the key is the block name.
 * @param {Object[]} options.blocks         Blocks to prepare to toggle.
 *
 * @return {Object[]} Blocks prepared to toggle.
 */
const i=({parentClientId:e,setAttributes:t,toggledBlocks:s,blocks:i})=>{const a=(0,n.useSelect)((t=>t("core/block-editor").getBlock(e)),[]),{replaceInnerBlocks:c}=(0,n.useDispatch)("core/block-editor"),[u,d]=(0,o.useState)({});return i.map((o=>{return{active:!1!==s[o.blockName],onToggle:(n=o.blockName,o=>{const i=a.innerBlocks.find((e=>e.name===n));let m=null;o&&!i?
// Add block using the default attributes, and the previous attributes if it exists.
m=[...a.innerBlocks,(0,r.createBlock)(n,{...l/* .BLOCKS_DEFAULT_ATTRIBUTES */.tt[n],...u[n]})].sort(((e,t)=>l/* .ACTION_BLOCKS */.Gd.indexOf(e.name)-l/* .ACTION_BLOCKS */.Gd.indexOf(t.name))):!o&&i&&(
// Remove block.
m=a.innerBlocks.filter((e=>e.name!==n)),
// Save block attributes to restore, if needed.
d((e=>({...e,[n]:i.attributes})))),m&&c(e,m,!1),t({toggledBlocks:{...s,[n]:o}})}),label:o.label};var n}))};
/* harmony default export */}
/***/,
/***/62540:
/***/(e,t,s)=>{"use strict";e.exports=s(2192)}
/***/,
/***/66087:
/***/e=>{"use strict";e.exports=window.lodash}
/***/,
/***/67372:
/***/e=>{"use strict";e.exports=JSON.parse('{"name":"sensei-lms/lesson-actions","title":"Lesson Actions","description":"Enable a student to perform specific actions for a lesson.","category":"sensei-lms","textdomain":"sensei-lms","keywords":["lesson","actions","buttons","complete","next","reset"],"supports":{"html":false},"attributes":{"toggledBlocks":{"type":"object","default":{"sensei-lms/button-reset-lesson":true}}}}')}
/***/,
/***/71127:
/***/(e,t,s)=>{"use strict";
/* unused harmony exports addColorSettings, removeColorSaveProps, removeColorEditProps, removeWrapperProps */
/* harmony import */var o=s(66087),n=s(52619),r=s(27723),l=s(29281),i=s(62540);
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
const a=e=>(e="string"==typeof e?e:e.name)&&e.startsWith("sensei-lms/button"),c=e=>({...e,className:e?.className?.replace(/\s*has-[\w-]*(color|background)/g,""),style:(0,o.omitBy)(e?.style,((e,t)=>t.match(/(color|background|background-color|border)/)))})
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
 */(0,n.addFilter)("blocks.getSaveContent.extraProps","sensei/button/removeColorSaveProps",((e,t)=>a(t)?c(e):e)),(0,n.addFilter)("blocks.registerBlockType","sensei/button/removeColorEditProps",(e=>{if(!a(e))return e;const t=e.getEditWrapperProps;return t&&(e.getEditWrapperProps=e=>{const s=t(e);return c(s)}),e})),(0,n.addFilter)("blocks.registerBlockType","sensei/button/addColorSettings",(e=>a(e)?(e.supports?.color&&!e.attributes?.backgroundColor&&(e.edit=(0,l/* .withColorSettings */.rt)({backgroundColor:{style:"background-color",label:(0,r.__)("Background color","sensei-lms")},textColor:{style:"color",label:(0,r.__)("Text color","sensei-lms")}})(e.edit),e.attributes={...e.attributes,backgroundColor:{type:"string"},customBackgroundColor:{type:"string"},textColor:{type:"string"},customTextColor:{type:"string"}}),e):e)),(0,n.addFilter)("editor.BlockListBlock","sensei/button/removeWrapperProps",(e=>t=>{let{name:s,wrapperProps:o}=t;return a(s)&&o&&(o=c(o)),(0,i.jsx)(e,{...t,wrapperProps:o})}),1)}
/***/,
/***/71406:
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */KS:()=>/* binding */i
/* harmony export */,_N:()=>/* binding */a
/* harmony export */,xh:()=>/* binding */l
/* harmony export */});
/* unused harmony export getBorderRadiusProps */
/* harmony import */var o=s(4452),n=s.n(o),r=s(98157);
/* harmony import */
/**
 * Class and style attributes for the button.
 *
 * @param {{attributes}} props Block properties.
 * @return {{className, style}} Output HTML attributes.
 */
function l(e){const t=a(e),s=(0,r/* .getColorAndStyleProps */.g)(e),o=
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
function({attributes:{borderRadius:e}}){return{className:{"no-border-radius":0===e},style:{borderRadius:e?e+"px":void 0}}}(e);return{className:n()({"wp-block-button__link":!t},o.className,s.className,e?.attributes?.buttonClassName),style:{...o.style,...s.style}}}
/**
 * Class and style attributes for the wrapper element.
 *
 * @param {Object} props                  Block properties.
 * @param {string} props.className        Block classname.
 * @param {Object} props.attributes       Block attributes.
 * @param {string} props.attributes.align Alignment attribute.
 * @return {{className}} Output HTML attributes.
 */function i({className:e,attributes:{align:t}}){return{className:n()(e,"wp-block-sensei-button","wp-block-button",`has-text-align-${t||"left"}`)}}
/**
 * Check if block has the 'Link' block style.
 *
 * @param {Object} props Block props.
 * @return {boolean} Is it a link block style.
 */const a=e=>/\bis-style-link\b/.test(e?.attributes?.className)
/***/},
/***/72613:
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */e:()=>/* binding */g
/* harmony export */,u:()=>/* binding */b
/* harmony export */});
/* harmony import */var o=s(66087),n=s(4452),r=s.n(n),l=s(27723),i=s(74997),a=s(35479),c=(s(71127),s(90078)),u=s(21307),d=s(74862),m=s(29281),p=s(62540);
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
const b={Fill:{name:"default",label:(0,l.__)("Fill","sensei-lms")},Outline:{name:"outline",label:(0,l.__)("Outline","sensei-lms")},Link:{name:"link",label:(0,l.__)("Link","sensei-lms")}},g=({settings:e,invalidUsage:t,EditWrapper:s,...n})=>{n={alignmentOptions:{controls:["left","center","right","full"],default:"left"},...n};const g=e.styles?e.styles:[{...b.Fill,isDefault:!0},b.Outline],_=(0,o.find)(g,"isDefault")?.name,v=(0,m/* .withDefaultBlockStyle */.Sw)(_)(c/* ["default"] */.A),h=(0,m/* .withDefaultBlockStyle */.Sw)(_)(u/* ["default"] */.A);return(0,o.merge)({name:"sensei-lms/button",title:"Sensei Button",category:"sensei-lms",attributes:{text:{type:"string",source:"html",selector:"a,button"},align:{type:"string"},borderRadius:{type:"number"},style:{type:"object"},isPreview:{type:"boolean",default:!1},inContainer:{type:"boolean",default:!1},buttonClassName:{type:"array",default:[]}},usesContext:["postType"],supports:{__experimentalBorder:{color:!0,width:!0,style:!0},border:!0,color:{gradients:!0,link:!0,__experimentalDefaultControls:{background:!0,text:!0,link:!0}},__experimentalColor:{gradients:!0},align:!1,html:!1},icon:a/* ["default"] */.A,styles:g,edit(e){const{postType:o}=e.context,r=(0,p.jsx)(v,{...e,...n});if(t?.validPostTypes&&!t.validPostTypes.includes(o)){const e=t?.message||(0,l.__)("This block can only be used inside the Course List block.","sensei-lms");
return(0/* ["default"] */,p.jsx)(d.A,{message:e})}return s?(0,p.jsx)(s,{...e,children:r}):r},save:t=>(0,p.jsx)(h,{...t,...n,blockName:e.name}),getEditWrapperProps:({inContainer:t,align:s})=>t?{className:r()("sensei-buttons-container__button-block",(0,i.getBlockDefaultClassName)(e.name)+"__wrapper",{[`sensei-buttons-container__button-align-${s}`]:s})}:{},example:{attributes:{align:"center",isPreview:!0}}},e)};
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
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */A:()=>r
/* harmony export */});
/* harmony import */var o=s(94715),n=s(62540);
/* harmony import */
/* harmony default export */const r=
/**
 * WordPress dependencies
 */
function({message:e}){const t=(0,o.useBlockProps)();
return(0,n.jsx)("div",{...t,children:(0,n.jsx)(o.Warning,{children:e})})};
/***/},
/***/74997:
/***/e=>{"use strict";e.exports=window.wp.blocks}
/***/,
/***/77549:
/***/(e,t,s)=>{"use strict";
/* unused harmony exports useColorsByProbe, getProbeStyles */
/* harmony import */var o=s(66087);
/* harmony import */s(86087),s(47143);
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
 */(0,o.memoize)((()=>{
// Create temporary probe elements.
const e=document.createElement("div");e.className="editor-styles-wrapper sensei-probe-element";const t=document.createElement("div");t.className="wp-block-button";const s=document.createElement("div");s.className="wp-block-button__link",s.textContent="Probe",
// Set probe position outside the screen to be hidden.
e.style.position="fixed",e.style.top="-100vh",
// Add probe to the screen.
t.appendChild(s),e.appendChild(t),document.body.appendChild(e);
// Save styles.
const o={primaryColor:n(s).backgroundColor,primaryContrastColor:n(s).color};
// Remove probe.
return document.body.removeChild(e),o}))}
/***/,
/***/86087:
/***/e=>{"use strict";e.exports=window.wp.element}
/***/,
/***/90078:
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */A:()=>c
/* harmony export */});
/* harmony import */var o=s(47143),n=s(94715),r=s(27723),l=s(71406),i=s(44539),a=s(62540);
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
const c=e=>{const{placeholder:t,attributes:s,setAttributes:c}=e,{text:u}=s,{colors:d}=(0,o.useSelect)((e=>e("core/block-editor").getSettings()),[]),m=void 0!==e.text,p=(0,l/* .getButtonProps */.xh)({...e,colors:d});
return(0,a.jsxs)("div",{...(0,l/* .getButtonWrapperProps */.KS)(e),children:[m?(0,a.jsx)("div",{...p,children:e.text}):(0,a.jsx)(n.RichText,{placeholder:t||(0,r.__)("Add text…","sensei-lms"),value:u,onChange:e=>c({text:e}),...p,tagName:"div",identifier:"text",withoutInteractiveFormatting:!0}),(0/* ["default"] */,a.jsx)(i.A,{...e})]})};
/* harmony default export */}
/***/,
/***/94715:
/***/e=>{"use strict";e.exports=window.wp.blockEditor}
/***/,
/***/98157:
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */g:()=>/* binding */l
/* harmony export */});
/* unused harmony export getGradientClass */
/* harmony import */var o=s(4452),n=s.n(o),r=s(94715);
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
const l=({attributes:e,colors:t})=>{const{backgroundColor:s,borderColor:o,customBackgroundColor:l,textColor:i,customTextColor:a,gradient:c,style:u={}}=e,d=(0,r.getColorClassName)("background-color",s);u.color||(u.color={}),l&&(u.color.background=l),a&&(u.color.text=a);const m=(0,r.getColorClassName)("border-color",o),p=(e=>{if(e)return`has-${e}-gradient-background`})(c),b=(0,r.getColorClassName)("color",i),g=n()(b,p,m,{
// Don't apply the background class if there's a custom gradient
[d]:!u?.color?.gradient&&!!d,"has-text-color":i||u?.color?.text,"has-background":s||u?.color?.background||c||u?.color?.gradient,"has-border-color":o}),_=u?.color?.background||u?.color?.text||u?.color?.gradient?{background:u?.color?.gradient?u.color.gradient:void 0,backgroundColor:u?.color?.background?u.color.background:void 0,color:u?.color?.text?u.color.text:void 0}:{};
// This is needed only for themes that don't load their color stylesheets in the editor
// We force an inline style to apply the color.
if(u?.border?.color&&(_.borderColor=u.border.color),u?.border?.width&&(_.borderWidth=u.border.width),t){if(s){const e=(0,r.getColorObjectByAttributeValues)(t,s);_.backgroundColor=e.color}if(i){const e=(0,r.getColorObjectByAttributeValues)(t,i);_.color=e.color}}return{className:g||void 0,style:_}};
/**
 * Get className and style from color settings.
 *
 * Copied from Gutenberg color support hook.
 *
 * @param {Object} props
 * @param {Object} props.attributes Block Attributes.
 * @param {Object} props.colors     Theme color settings.
 */}
/***/,
/***/99023:
/***/(e,t,s)=>{"use strict";
/* harmony export */s.d(t,{
/* harmony export */A:()=>n
/* harmony export */});
/* harmony import */var o=s(86087);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Hook to check if a lesson can be completed manually.
 *
 * @param {boolean} hasQuiz If a lesson has a quiz.
 *
 * @return {boolean} If a lesson can be marked as completed by student.
 */
const n=e=>{const t=document.getElementById("pass_required"),[s,n]=(0,o.useState)((()=>!t||!t.checked));return(0,o.useEffect)((()=>{
// Ignore if the checkbox isn't present.
if(!t)return;const e=()=>{n(!t.checked)};return t.addEventListener("change",e),()=>{t.removeEventListener("change",e)}}),[t]),!e||s};
/* harmony default export */}
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
/* harmony import */var e=s(19695);
/* harmony import */
/**
 * Internal dependencies
 */
/**
 * Internal dependencies
 */
(0,s(47056).A)([e/* .LessonActionsBlock */.rJ,e/* .LessonCompletedBlock */.pl,e/* .CompleteLessonBlock */.pV,e/* .NextLessonBlock */.P5,e/* .TakeQuizBlock */.IB,e/* .ResetLessonBlock */.bz])})()})
/******/();