/******/(()=>{// webpackBootstrap
/******/var e={
/***/2:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */A:()=>/* binding */d
/* harmony export */});
/* harmony import */var o=n(93094),s=n(82370),r=n(26368),i=n(6433),a=n(74077),c=n(50780),l=n(12730),u=n(39246);
/* harmony import */ // Returns the composite rect of an element relative to its offsetParent.
// Composite means it takes into account transforms as well as layout.
function d(e,t,n){void 0===n&&(n=!1);var d=(0,i/* .isHTMLElement */.sb)(t),p=(0,i/* .isHTMLElement */.sb)(t)&&function(e){var t=e.getBoundingClientRect(),n=(0,u/* .round */.LI)(t.width)/e.offsetWidth||1,o=(0,u/* .round */.LI)(t.height)/e.offsetHeight||1;return 1!==n||1!==o}(t),f=(0,c/* ["default"] */.A)(t),m=(0,o/* ["default"] */.A)(e,p,n),h={scrollLeft:0,scrollTop:0},v={x:0,y:0};return(d||!d&&!n)&&(("body"!==(0,r/* ["default"] */.A)(t)||// https://github.com/popperjs/popper-core/issues/1078
// https://github.com/popperjs/popper-core/issues/1078
(0,l/* ["default"] */.A)(f))&&(h=(0,s/* ["default"] */.A)(t)),(0,i/* .isHTMLElement */.sb)(t)?((v=(0,o/* ["default"] */.A)(t,!0)).x+=t.clientLeft,v.y+=t.clientTop):f&&(v.x=(0,a/* ["default"] */.A)(f))),{x:m.left+h.scrollLeft-v.x,y:m.top+h.scrollTop-v.y,width:m.width,height:m.height}}
/***/},
/***/833:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */A:()=>d
/* harmony export */});
/* harmony import */var o=n(66087),s=n.n(o),r=n(47143),i=n(86087),a=n(37592),c=n(46458),l=n(86298),u=n(62540);
/* harmony import */
/* harmony default export */const d=
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
 * Renders a tour kit component for Sensei.
 *
 * @param {Object}     props                  Component props.
 * @param {string}     props.tourName         The unique name of the tour.
 * @param {string}     props.trackId          ID of tracking event (optional). Tracking will be enabled only when provided.
 * @param {TourStep[]} props.steps            An array of steps to include in the tour.
 * @param {Function}   [props.beforeEach]     A function to run before each step.
 * @param {Object}     [props.extraConfig={}] Additional configuration options for the tour kit.
 */
function({tourName:e,trackId:t,steps:n,beforeEach:o=()=>{},extraConfig:d={}}){const{showTour:p}=(0,r.useSelect)((e=>{const{shouldShowTour:t}=e(a/* .SENSEI_TOUR_STORE */.rr);return{showTour:t()}})),{setTourShowStatus:f}=(0/* .SENSEI_TOUR_STORE */,r.useDispatch)(a.rr),m=(0,i.useCallback)((e=>{if(t&&e<n.length){const o=n[e];window.sensei_log_event(t,{step:o.slug})}}),[t,n]),h=e=>{o(n[e]),(0,c/* .performStepAction */.yj)(e,n)},v={steps:n,closeHandler:()=>{(0,c/* .removeHighlightClasses */.NO)(),f(!1,!0,e)},options:{effects:{spotlight:null,
// spotlight: { // To enable spotlighting
// 	interactivity: {
// 		enabled: true, // Needed to allow the user to click inside the spotlighted element
// 	},
// },
liveResize:{mutation:!0,resize:!0,rootElementSelector:"#root"}},callbacks:{onNextStep:e=>{h(e+1)},onPreviousStep:e=>{h(e-1)},onGoToStep:e=>{e===n.length-1?h(0):(0,c/* .removeHighlightClasses */.NO)()},onMaximize:e=>{h(e)},onMinimize:()=>{(0,c/* .removeHighlightClasses */.NO)()},onStepViewOnce:e=>{0===e&&h(e),m(e)}}},placement:"bottom-start"};return p?(0/* ["default"] */,u.jsx)(l.A,{config:s().merge(v,d)}):null};
/***/},
/***/1455:
/***/e=>{"use strict";e.exports=window.wp.apiFetch}
/***/,
/***/2192:
/***/(e,t,n)=>{"use strict";
/**
 * @license React
 * react-jsx-runtime.production.min.js
 *
 * Copyright (c) Facebook, Inc. and its affiliates.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */var o=n(51609),s=Symbol.for("react.element"),r=Symbol.for("react.fragment"),i=Object.prototype.hasOwnProperty,a=o.__SECRET_INTERNALS_DO_NOT_USE_OR_YOU_WILL_BE_FIRED.ReactCurrentOwner,c={key:!0,ref:!0,__self:!0,__source:!0};function l(e,t,n){var o,r={},l=null,u=null;for(o in void 0!==n&&(l=""+n),void 0!==t.key&&(l=""+t.key),void 0!==t.ref&&(u=t.ref),t)i.call(t,o)&&!c.hasOwnProperty(o)&&(r[o]=t[o]);if(e&&e.defaultProps)for(o in t=e.defaultProps)void 0===r[o]&&(r[o]=t[o]);return{$$typeof:s,type:e,key:l,ref:u,props:r,_owner:a.current}}t.Fragment=r,t.jsx=l,t.jsxs=l}
/***/,
/***/2892:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */UD:()=>/* binding */f
/* harmony export */});
/* unused harmony export createPopper */
/* harmony import */var o=n(2),s=n(50231),r=n(29001),i=n(95740),a=n(19946),c=n(44767),l=n(31456),u=n(6433),d={placement:"bottom",modifiers:[],strategy:"absolute"};
/* harmony import */function p(){for(var e=arguments.length,t=new Array(e),n=0;n<e;n++)t[n]=arguments[n];return!t.some((function(e){return!(e&&"function"==typeof e.getBoundingClientRect)}))}function f(e){void 0===e&&(e={});var t=e,n=t.defaultModifiers,f=void 0===n?[]:n,m=t.defaultOptions,h=void 0===m?d:m;return function(e,t,n){void 0===n&&(n=h);var m={placement:"bottom",orderedModifiers:[],options:Object.assign({},d,h),modifiersData:{},elements:{reference:e,popper:t},attributes:{},styles:{}},v=[],g=!1,b={state:m,setOptions:function(n){var o="function"==typeof n?n(m.options):n;w(),m.options=Object.assign({},h,m.options,o),m.scrollParents={reference:(0,u/* .isElement */.vq)(e)?(0,r/* ["default"] */.A)(e):e.contextElement?(0,r/* ["default"] */.A)(e.contextElement):[],popper:(0,r/* ["default"] */.A)(t)};// Orders the modifiers based on their dependencies and `phase`
// properties
var s=(0,a/* ["default"] */.A)((0,l/* ["default"] */.A)([].concat(f,m.options.modifiers)));// Strip out disabled modifiers
return m.orderedModifiers=s.filter((function(e){return e.enabled})),m.orderedModifiers.forEach((function(e){var t=e.name,n=e.options,o=void 0===n?{}:n,s=e.effect;if("function"==typeof s){var r=s({state:m,name:t,instance:b,options:o}),i=function(){};v.push(r||i)}})),b.update()},
// Sync update – it will always be executed, even if not necessary. This
// is useful for low frequency updates where sync behavior simplifies the
// logic.
// For high frequency updates (e.g. `resize` and `scroll` events), always
// prefer the async Popper#update method
forceUpdate:function(){if(!g){var e=m.elements,t=e.reference,n=e.popper;// Don't proceed if `reference` or `popper` are not valid elements
// anymore
if(p(t,n)){// Store the reference and popper rects to be read by modifiers
m.rects={reference:(0,o/* ["default"] */.A)(t,(0,i/* ["default"] */.A)(n),"fixed"===m.options.strategy),popper:(0,s/* ["default"] */.A)(n)},// Modifiers have the ability to reset the current update cycle. The
// most common use case for this is the `flip` modifier changing the
// placement, which then needs to re-run all the modifiers, because the
// logic was previously ran for the previous placement and is therefore
// stale/incorrect
m.reset=!1,m.placement=m.options.placement,// On each update cycle, the `modifiersData` property for each modifier
// is filled with the initial data specified by the modifier. This means
// it doesn't persist and is fresh on each update.
// To ensure persistent data, use `${name}#persistent`
m.orderedModifiers.forEach((function(e){return m.modifiersData[e.name]=Object.assign({},e.data)}));for(var r=0;r<m.orderedModifiers.length;r++)if(!0!==m.reset){var a=m.orderedModifiers[r],c=a.fn,l=a.options,u=void 0===l?{}:l,d=a.name;"function"==typeof c&&(m=c({state:m,options:u,name:d,instance:b})||m)}else m.reset=!1,r=-1}}},
// Async and optimistically optimized update – it will not be executed if
// not necessary (debounced to run at most once-per-tick)
update:(0,c/* ["default"] */.A)((function(){return new Promise((function(e){b.forceUpdate(),e(m)}))})),destroy:function(){w(),g=!0}};if(!p(e,t))return b;function w(){v.forEach((function(e){return e()})),v=[]}return b.setOptions(n).then((function(e){!g&&n.onFirstUpdate&&n.onFirstUpdate(e)})),b}}}// eslint-disable-next-line import/no-unused-modules
/***/,
/***/4452:
/***/(e,t)=>{var n;
/*!
	Copyright (c) 2018 Jed Watson.
	Licensed under the MIT License (MIT), see
	http://jedwatson.github.io/classnames
*/
/* global define */!function(){"use strict";var o={}.hasOwnProperty;function s(){for(var e="",t=0;t<arguments.length;t++){var n=arguments[t];n&&(e=i(e,r(n)))}return e}function r(e){if("string"==typeof e||"number"==typeof e)return e;if("object"!=typeof e)return"";if(Array.isArray(e))return s.apply(null,e);if(e.toString!==Object.prototype.toString&&!e.toString.toString().includes("[native code]"))return e.toString();var t="";for(var n in e)o.call(e,n)&&e[n]&&(t=i(t,n));return t}function i(e,t){return t?e?e+" "+t:e+t:e}e.exports?(s.default=s,e.exports=s):void 0===(n=function(){return s}.apply(t,[]))||(e.exports=n)}()}
/***/,
/***/4650:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */Y:()=>/* binding */s
/* harmony export */});
/* harmony import */var o=n(23647);
/**
 * Function that returns a Popper modifier that observes the specified root element as well as
 * reference element for any changes. The reason for being a currying function is so that
 * we can customise the root element selector, otherwise observing at a higher than necessary
 * level might cause unnecessary performance penalties.
 *
 * The Popper modifier queues an asynchronous update on the Popper instance whenever either of the
 * Observers trigger its callback.
 * @returns custom Popper modifier
 */const s=({rootElementSelector:e,mutation:t=!1,resize:n=!1}={mutation:!1,resize:!1})=>({name:"liveResizeModifier",enabled:!0,phase:"main",fn:()=>{},effect:s=>{try{const{state:r,instance:i}=s,a=Symbol(),{reference:c}=r.elements;// augment types here because we are mutating the properties on the argument that is passed in
if(c[a]={resizeObserver:new ResizeObserver((()=>{i.update()})),mutationObserver:new MutationObserver((()=>{i.update()}))},n&&(c instanceof Element?c[a].resizeObserver.observe(c):(0,o/* .debug */.Y)("Error: ResizeObserver does not work with virtual elements, Tour Kit will not resize automatically if the size of the referenced element changes.")),t){const t=document.querySelector(e||"#wpwrap");t instanceof Element?c[a].mutationObserver.observe(t,{attributes:!0,characterData:!0,childList:!0,subtree:!0}):(0,o/* .debug */.Y)(`Error: ${e} selector did not find a valid DOM element, Tour Kit will not update automatically if the DOM layout changes.`)}return()=>{c[a].resizeObserver.disconnect(),c[a].mutationObserver.disconnect(),delete c[a]}}catch(e){(0,o/* .debug */.Y)("Error: Tour Kit live resize modifier failed unexpectedly:",e)}}})
//# sourceMappingURL=live-resize-modifier.js.map
/***/},
/***/5078:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */A:()=>r
/* harmony export */});
/* unused harmony export distanceAndSkiddingToXY */
/* harmony import */var o=n(68956),s=n(63458);
/* harmony import */ // eslint-disable-next-line import/no-unused-modules
/* harmony default export */const r={name:"offset",enabled:!0,phase:"main",requires:["popperOffsets"],fn:function(e){var t=e.state,n=e.options,r=e.name,i=n.offset,a=void 0===i?[0,0]:i,c=s/* .placements */.DD.reduce((function(e,n){return e[n]=
// eslint-disable-next-line import/no-unused-modules
function(e,t,n){var r=(0,o/* ["default"] */.A)(e),i=[s/* .left */.kb,s/* .top */.Mn].indexOf(r)>=0?-1:1,a="function"==typeof n?n(Object.assign({},t,{placement:e})):n,c=a[0],l=a[1];return c=c||0,l=(l||0)*i,[s/* .left */.kb,s/* .right */.pG].indexOf(r)>=0?{x:l,y:c}:{x:c,y:l}}(n,t.rects,a),e}),{}),l=c[t.placement],u=l.x,d=l.y;null!=t.modifiersData.popperOffsets&&(t.modifiersData.popperOffsets.x+=u,t.modifiersData.popperOffsets.y+=d),t.modifiersData[r]=c}};
/***/},
/***/5573:
/***/e=>{"use strict";e.exports=window.wp.primitives}
/***/,
/***/6061:
/***/(e,t,n)=>{"use strict";
/* harmony export */function o(e){return{scrollLeft:e.scrollLeft,scrollTop:e.scrollTop}}
/***/n.d(t,{
/* harmony export */A:()=>/* binding */o
/* harmony export */})},
/***/6433:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */Ng:()=>/* binding */i
/* harmony export */,sb:()=>/* binding */r
/* harmony export */,vq:()=>/* binding */s
/* harmony export */});
/* harmony import */var o=n(32639);function s(e){return e instanceof(0,o/* ["default"] */.A)(e).Element||e instanceof Element}function r(e){return e instanceof(0,o/* ["default"] */.A)(e).HTMLElement||e instanceof HTMLElement}function i(e){
// IE 11 has no ShadowRoot
return"undefined"!=typeof ShadowRoot&&(e instanceof(0,o/* ["default"] */.A)(e).ShadowRoot||e instanceof ShadowRoot)}
/***/},
/***/7130:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */A:()=>/* binding */s
/* harmony export */});
/* harmony import */var o=n(6433);function s(e,t){var n=t.getRootNode&&t.getRootNode();// First, attempt with faster native method
if(e.contains(t))return!0;// Give up, the result is false
if(n&&(0,o/* .isShadowRoot */.Ng)(n)){var s=t;do{if(s&&e.isSameNode(s))return!0;// $FlowFixMe[prop-missing]: need a better way to handle this...
s=s.parentNode||s.host}while(s)}return!1}
/***/},
/***/10888:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */A:()=>s
/* harmony export */});
/* harmony import */var o=n(86087);
/* harmony import */
/* harmony default export */const s=(0,o.forwardRef)((
/**
 * WordPress dependencies
 */
/** @typedef {{icon: JSX.Element, size?: number} & import('@wordpress/primitives').SVGProps} IconProps */
/**
 * Return an SVG icon.
 *
 * @param {IconProps}                                 props icon is the SVG component to render
 *                                                          size is a number specifiying the icon size in pixels
 *                                                          Other props will be passed to wrapped SVG component
 * @param {import('react').ForwardedRef<HTMLElement>} ref   The forwarded ref to the SVG element.
 *
 * @return {JSX.Element}  Icon component
 */
function({icon:e,size:t=24,...n},s){return(0,o.cloneElement)(e,{width:t,height:t,...n,ref:s})}));
//# sourceMappingURL=index.js.map
/***/},
/***/10912:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */A:()=>f
/* harmony export */});
/* harmony import */var o=n(62540),s=n(70974),r=n(56427),i=n(10888),a=n(91217),c=n(4452),l=n.n(c),u=n(36594),d=n(87063),p=n(79676);
/* harmony import */const f=({steps:e,currentStepIndex:t,onMinimize:n,onDismiss:c,onGoToStep:f,onNextStep:m,onPreviousStep:h,setInitialFocusedElement:v})=>{const{__}=(0,a/* .useI18n */.s9)(),g=e.length-1,{descriptions:b,heading:w,imgSrc:y,imgLink:x}=e[t].meta,A=t===g,k=b[(0,s/* .isMobile */.Fr)()?"mobile":"desktop"]??b.desktop,_=(0/* .MOBILE_BREAKPOINT */,s/* .getMediaQueryList */.hf)(s.Dy);return(0,o.jsxs)(r.Card,{className:"wpcom-tour-kit-step-card",isElevated:!0,children:[(0/* ["default"] */,o.jsx)(p.A,{onDismiss:c,onMinimize:n}),y&&(0,o.jsxs)(r.CardMedia,{className:"wpcom-tour-kit-step-card__media",children:[(0,o.jsxs)("picture",{children:[y.mobile&&(0,o.jsx)("source",{srcSet:y.mobile.src,type:y.mobile.type,media:_?.media}),(0,o.jsx)("img",{alt:__("Tour Media","default"),src:y.desktop?.src})]}),x&&(0,o.jsx)("a",{className:l()("wpcom-tour-kit-step-card__media-link",{"wpcom-tour-kit-step-card__media-link--playable":x.playable}),href:x.href,target:"_blank",rel:"noreferrer noopener",onClick:x.onClick,children:(0/* ["default"] */,o.jsx)(i.A,{icon:(0,o.jsx)("svg",{width:"27",height:"32",viewBox:"0 0 27 32",fill:"none",xmlns:"http://www.w3.org/2000/svg",children:(0,o.jsx)("path",{d:"M27 16L-1.4682e-06 31.5885L-1.05412e-07 0.411542L27 16Z",fill:"white"})}),size:27})})]}),(0,o.jsxs)(r.CardBody,{children:[(0,o.jsx)("h2",{className:"wpcom-tour-kit-step-card__heading",children:w}),(0,o.jsxs)("p",{className:"wpcom-tour-kit-step-card__description",children:[k,A?(0,o.jsx)(r.Button,{className:"wpcom-tour-kit-step-card__description",variant:"tertiary",onClick:()=>f(0),ref:v,children:__("Restart tour","default")}):null]})]}),(0,o.jsx)(r.CardFooter,{children:A?(0/* ["default"] */,o.jsx)(u.A,{}):(0/* ["default"] */,o.jsx)(d.A,{currentStepIndex:t,onDismiss:c,onGoToStep:f,onNextStep:m,onPreviousStep:h,setInitialFocusedElement:v,steps:e})})]})};
/* harmony default export */}
//# sourceMappingURL=wpcom-tour-kit-step-card.js.map
/***/,
/***/11226:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */A:()=>f
/* harmony export */});
/* unused harmony export mapToStyles */
/* harmony import */var o=n(63458),s=n(95740),r=n(32639),i=n(50780),a=n(71699),c=n(68956),l=n(11361),u=n(39246),d={top:"auto",right:"auto",bottom:"auto",left:"auto"};
/* harmony import */function p(e){var t,n=e.popper,c=e.popperRect,l=e.placement,p=e.variation,f=e.offsets,m=e.position,h=e.gpuAcceleration,v=e.adaptive,g=e.roundOffsets,b=e.isFixed,w=f.x,y=void 0===w?0:w,x=f.y,A=void 0===x?0:x,k="function"==typeof g?g({x:y,y:A}):{x:y,y:A};y=k.x,A=k.y;var _=f.hasOwnProperty("x"),C=f.hasOwnProperty("y"),S=o/* .left */.kb,j=o/* .top */.Mn,O=window;if(v){var E=(0,s/* ["default"] */.A)(n),M="clientHeight",z="clientWidth";if(E===(0,r/* ["default"] */.A)(n)&&(E=(0,i/* ["default"] */.A)(n),"static"!==(0,a/* ["default"] */.A)(E).position&&"absolute"===m&&(M="scrollHeight",z="scrollWidth")),l===o/* .top */.Mn||(l===o/* .left */.kb||l===o/* .right */.pG)&&p===o/* .end */._N)j=o/* .bottom */.sQ,A-=(b&&E===O&&O.visualViewport?O.visualViewport.height:// $FlowFixMe[prop-missing]
E[M])-c.height,A*=h?1:-1;if(l===o/* .left */.kb||(l===o/* .top */.Mn||l===o/* .bottom */.sQ)&&p===o/* .end */._N)S=o/* .right */.pG,y-=(b&&E===O&&O.visualViewport?O.visualViewport.width:// $FlowFixMe[prop-missing]
E[z])-c.width,y*=h?1:-1}var F,q=Object.assign({position:m},v&&d),P=!0===g?// Round the offsets to the nearest suitable subpixel based on the DPR.
// Zooming can change the DPR, but it seems to report a value that will
// cleanly divide the values into the appropriate subpixels.
function(e,t){var n=e.x,o=e.y,s=t.devicePixelRatio||1;return{x:(0,u/* .round */.LI)(n*s)/s||0,y:(0,u/* .round */.LI)(o*s)/s||0}}({x:y,y:A},(0,r/* ["default"] */.A)(n)):{x:y,y:A};return y=P.x,A=P.y,h?Object.assign({},q,((F={})[j]=C?"0":"",F[S]=_?"0":"",F.transform=(O.devicePixelRatio||1)<=1?"translate("+y+"px, "+A+"px)":"translate3d("+y+"px, "+A+"px, 0)",F)):Object.assign({},q,((t={})[j]=C?A+"px":"",t[S]=_?y+"px":"",t.transform="",t))}// eslint-disable-next-line import/no-unused-modules
/* harmony default export */const f={name:"computeStyles",enabled:!0,phase:"beforeWrite",fn:function(e){var t=e.state,n=e.options,o=n.gpuAcceleration,s=void 0===o||o,r=n.adaptive,i=void 0===r||r,a=n.roundOffsets,u=void 0===a||a,d={placement:(0,c/* ["default"] */.A)(t.placement),variation:(0,l/* ["default"] */.A)(t.placement),popper:t.elements.popper,popperRect:t.rects.popper,gpuAcceleration:s,isFixed:"fixed"===t.options.strategy};null!=t.modifiersData.popperOffsets&&(t.styles.popper=Object.assign({},t.styles.popper,p(Object.assign({},d,{offsets:t.modifiersData.popperOffsets,position:t.options.strategy,adaptive:i,roundOffsets:u})))),null!=t.modifiersData.arrow&&(t.styles.arrow=Object.assign({},t.styles.arrow,p(Object.assign({},d,{offsets:t.modifiersData.arrow,position:"absolute",adaptive:!1,roundOffsets:u})))),t.attributes.popper=Object.assign({},t.attributes.popper,{"data-popper-placement":t.placement})},data:{}};
/***/},
/***/11361:
/***/(e,t,n)=>{"use strict";
/* harmony export */function o(e){return e.split("-")[1]}
/***/n.d(t,{
/* harmony export */A:()=>/* binding */o
/* harmony export */})},
/***/12730:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */A:()=>/* binding */s
/* harmony export */});
/* harmony import */var o=n(71699);function s(e){
// Firefox wants us to check `-x` and `-y` variations as well
var t=(0,o/* ["default"] */.A)(e),n=t.overflow,s=t.overflowX,r=t.overflowY;return/auto|scroll|overlay|hidden/.test(n+r+s)}
/***/},
/***/14309:
/***/e=>{"use strict";e.exports=window.wp.editPost}
/***/,
/***/18271:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */A:()=>d
/* harmony export */});
/* harmony import */var o=n(62540),s=n(56427),r=n(86087),i=n(27723),a=n(10888),c=n(64624),l=n(91217),u=n(20114);
/* harmony import */const d=({steps:e,onMaximize:t,onDismiss:n,currentStepIndex:d})=>{const{__}=(0,l/* .useI18n */.s9)(),p=d+1,f=e.length-1+1;return(0,o.jsxs)(s.Flex,{gap:0,className:"wpcom-tour-kit-minimized",children:[(0,o.jsx)(s.Button,{onClick:t,"aria-label":__("Resume Tour","default"),children:(0,o.jsxs)(s.Flex,{gap:13,children:[(0,o.jsx)("p",{children:(0,r.createInterpolateElement)((0,i.sprintf)(
/* translators: 1: current page number, 2: total number of pages */
__("Resume tour <span>(%1$d/%2$d)</span>","default"),p,f),{span:(0,o.jsx)("span",{className:"wpcom-tour-kit-minimized__tour-index"})})}),(0/* ["default"] */,o.jsx)(a.A,{icon:u/* ["default"] */.A,size:24})]})}),(0,o.jsx)(s.Button,{onClick:n("close-btn-minimized"),"aria-label":__("Close Tour","default"),children:(0/* ["default"] */,o.jsx)(a.A,{icon:c/* ["default"] */.A,size:24})})]})};
/* harmony default export */}
//# sourceMappingURL=wpcom-tour-kit-minimized.js.map
/***/,
/***/19946:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */A:()=>/* binding */r
/* harmony export */});
/* harmony import */var o=n(63458);
// source: https://stackoverflow.com/questions/49875255
function s(e){var t=new Map,n=new Set,o=[];// On visiting object, check for its dependencies and visit them recursively
function s(e){n.add(e.name),[].concat(e.requires||[],e.requiresIfExists||[]).forEach((function(e){if(!n.has(e)){var o=t.get(e);o&&s(o)}})),o.push(e)}return e.forEach((function(e){t.set(e.name,e)})),e.forEach((function(e){n.has(e.name)||
// check for visited object
s(e)})),o}function r(e){
// order based on dependencies
var t=s(e);// order based on phase
return o/* .modifierPhases */.GM.reduce((function(e,n){return e.concat(t.filter((function(e){return e.phase===n})))}),[])}
/***/},
/***/20114:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */A:()=>r
/* harmony export */});
/* harmony import */var o=n(62540),s=n(5573);
/* harmony import */const r=(0,o.jsx)(s.SVG,{width:"24",height:"24",fill:"none",xmlns:"http://www.w3.org/2000/svg",children:(0,o.jsx)(s.Path,{fillRule:"evenodd",clipRule:"evenodd",d:"M14.086 5.412l3.476-.015c-.627.625-1.225 1.22-1.82 1.81l-.03.031c-.977.971-1.944 1.934-3.015 3.004l1.06 1.061c1.07-1.07 2.036-2.03 3.013-3.002l.03-.03 1.817-1.808-.03 3.448 1.5.013.046-5.28.007-.759-.76.003-5.301.024.007 1.5zM9.914 18.587l-3.476.016c.627-.625 1.225-1.22 1.82-1.81l.03-.031c.977-.971 1.944-1.934 3.015-3.004l-1.06-1.061c-1.07 1.069-2.036 2.03-3.012 3.001l-.001.001-.03.03-1.817 1.808.03-3.448-1.5-.013-.046 5.279-.007.76.76-.003 5.301-.024-.007-1.5z"})});
/* harmony default export */}
//# sourceMappingURL=maximize.js.map
/***/,
/***/21042:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */A:()=>/* binding */s
/* harmony export */});
/* harmony import */var o=n(32639);function s(e){var t=(0,o/* ["default"] */.A)(e);return{scrollLeft:t.pageXOffset,scrollTop:t.pageYOffset}}
/***/},
/***/21446:
/***/(e,t,n)=>{"use strict";
/* harmony export */function o(e){return"x"===e?"y":"x"}
/***/n.d(t,{
/* harmony export */A:()=>/* binding */o
/* harmony export */})},
/***/21671:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */A:()=>b
/* harmony export */});
/* harmony import */var o=n(62540),s=n(85840),r=n(86087),i=n(4452),a=n.n(i),c=n(75176),l=n(66072),u=n(23647),d=n(4650),p=n(79132),f=n(53286),m=n(62306),h=n(96822),v=n(24906);
/* harmony import */
/**
 * External Dependencies
 */
/**
 * Internal Dependencies
 */
const g=(e,t)=>{"function"==typeof t&&t(e)},b=({config:e})=>{const[t,n]=(0,r.useState)(0),[i,b]=(0,r.useState)(null),[w,y]=(0,r.useState)(e.isMinimized??!1),[x,A]=(0,r.useState)(null),[k,_]=(0,r.useState)(!1),C=(0,r.useRef)(null),S=(0,s/* .useMobileBreakpoint */.lC)(),j=e.steps.length-1,O=e.steps[t].referenceElements,E=O?.[S?"mobile":"desktop"]||O?.desktop,M=E?document.querySelector(E):null;(0,r.useEffect)((()=>{e.isMinimized&&y(!0)}),[e.isMinimized]);const z=(0,r.useCallback)((()=>!1!==e.options?.effects?.arrowIndicator&&!(!M||w||!k)),[e.options?.effects?.arrowIndicator,w,M,k]),F=(0,r.useCallback)((()=>!!e.options?.effects?.spotlight&&!w),[e.options?.effects?.spotlight,w]),q=(0,r.useCallback)((()=>!(F()||!e.options?.effects?.overlay)&&!w),[e.options?.effects?.overlay,w,F]),P=(0,r.useCallback)((n=>()=>{e.closeHandler(e.steps,t,n)}),[e,t]),L=(0,r.useCallback)((()=>{let o=t;j>t&&(o=t+1,n(o)),g(o,e.options?.callbacks?.onNextStep)}),[e.options?.callbacks?.onNextStep,t,j]),T=(0,r.useCallback)((()=>{let o=t;t>0&&(o=t-1,n(o)),g(o,e.options?.callbacks?.onPreviousStep)}),[e.options?.callbacks?.onPreviousStep,t]),N=(0,r.useCallback)((t=>{n(t),g(t,e.options?.callbacks?.onGoToStep)}),[e.options?.callbacks?.onGoToStep,t]),D=(0,r.useCallback)((()=>{y(!0),g(t,e.options?.callbacks?.onMinimize)}),[e.options?.callbacks?.onMinimize,t]),R=(0,r.useCallback)((()=>{y(!1),g(t,e.options?.callbacks?.onMaximize)}),[e.options?.callbacks?.onMaximize,t]),{styles:B,attributes:I,update:V}=(0,c/* .usePopper */.E)(M,x,{strategy:"fixed",placement:e?.placement??"bottom",modifiers:[{name:"preventOverflow",options:{rootBoundary:"document",padding:16}},{name:"arrow",options:{padding:12}},{name:"offset",options:{offset:[0,z()?12:10]}},{name:"flip",options:{fallbackPlacements:["top","left","right"]}},(0,r.useMemo)((()=>(0,d/* .liveResizeModifier */.Y)(e.options?.effects?.liveResize)),[e.options?.effects?.liveResize]),...e.options?.popperModifiers||[]]}),W=!w&&M&&k?{style:B?.popper,...I?.popper}:null,G=!w&&M&&k?{style:B?.arrow,...I?.arrow}:null;
/*
     * Focus first interactive element when step renders.
     */
/*
     * Focus first interactive element when step renders.
     */
(0,r.useEffect)((()=>{setTimeout((()=>i?.focus()))}),[i]),
/*
     * Fixes issue with Popper misplacing the instance on mount
     * See: https://stackoverflow.com/questions/65585859/react-popper-incorrect-position-on-mount
     */
/*
     * Fixes issue with Popper misplacing the instance on mount
     * See: https://stackoverflow.com/questions/65585859/react-popper-incorrect-position-on-mount
     */
(0,r.useEffect)((()=>{
// If no reference element to position step near
M?(_(!1),V&&V().then((()=>_(!0))).catch((()=>_(!0)))):_(!0)}),[V,M]),(0,r.useEffect)((()=>{M&&e.options?.effects?.autoScroll&&M.scrollIntoView(e.options.effects.autoScroll)}),[e.options?.effects?.autoScroll,M]);const $=a()("tour-kit-frame",S?"is-mobile":"is-desktop",{"is-visible":k},(0,u/* .classParser */.e)(e.options?.classNames));return(0,l/* ["default"] */.A)(t,e.options?.callbacks?.onStepViewOnce),(0,r.useEffect)((()=>{e.options?.callbacks?.onStepView&&g(t,e.options?.callbacks?.onStepView)}),[e.options?.callbacks?.onStepView,t]),(0,o.jsxs)(o.Fragment,{children:[(0/* ["default"] */,o.jsx)(p.A,{onMinimize:D,onDismiss:P,onNextStepProgression:L,onPreviousStepProgression:T,tourContainerRef:C,isMinimized:w}),(0,o.jsxs)("div",{className:$,ref:C,children:[q()&&(0/* ["default"] */,o.jsx)(m.A,{visible:!0}),F()&&(0/* ["default"] */,o.jsx)(h.A,{referenceElement:M,liveResize:e.options?.effects?.liveResize||{},...e.options?.effects?.spotlight||{}}),(0,o.jsxs)("div",{className:"tour-kit-frame__container",ref:A,...W,children:[z()&&(0,o.jsx)("div",{className:"tour-kit-frame__arrow","data-popper-arrow":!0,...G}),w?(0/* ["default"] */,o.jsx)(f.A,{config:e,steps:e.steps,currentStepIndex:t,onMaximize:R,onDismiss:P}):(0/* ["default"] */,o.jsx)(v.A,{config:e,steps:e.steps,currentStepIndex:t,onMinimize:D,onDismiss:P,onNextStep:L,onPreviousStep:T,onGoToStep:N,setInitialFocusedElement:b})]})]})]})}}
//# sourceMappingURL=tour-kit-frame.js.map
/***/,
/***/22012:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */A:()=>r
/* harmony export */});
/* harmony import */var o=n(62540),s=n(5573);
/* harmony import */const r=(0,o.jsx)(s.SVG,{width:"24",height:"24",fill:"none",xmlns:"http://www.w3.org/2000/svg",children:(0,o.jsx)(s.Path,{fillRule:"evenodd",clipRule:"evenodd",d:"M13.131 19.12a.667.667 0 001.227-.417l-.436-4.989h3.88c.954 0 1.64-.916 1.37-1.831L17.42 5.919a.286.286 0 00-.274-.205H9.429v7.588l3.702 5.818zm-5.417-5.977V5.714h-2v7.429h2zm5.98 8a2.381 2.381 0 01-2.01-1.103l-3.297-5.183H4V4h13.145a2 2 0 011.919 1.436l1.753 5.963a3.143 3.143 0 01-3.015 4.03h-2.01l.274 3.125a2.381 2.381 0 01-2.372 2.589z",fill:"#000"})});
/* harmony default export */}
//# sourceMappingURL=thumbs_down.js.map
/***/,
/***/22214:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */A:()=>/* binding */a
/* harmony export */});
/* harmony import */var o=n(46063),s=n(12730),r=n(26368),i=n(6433);
/* harmony import */function a(e){return["html","body","#document"].indexOf((0,r/* ["default"] */.A)(e))>=0?e.ownerDocument.body:(0,i/* .isHTMLElement */.sb)(e)&&(0,s/* ["default"] */.A)(e)?e:a((0,o/* ["default"] */.A)(e))}
/***/},
/***/23647:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */Y:()=>/* binding */r
/* harmony export */,e:()=>/* binding */s
/* harmony export */});
/* harmony import */var o=n(87989);
/* harmony import */
/**
 * Helper to convert CSV of `classes` to an array.
 * @param classes String or array of classes to format.
 * @returns Array of classes
 */
function s(e){return e?.length?e.toString().split(","):null}const r=n.n(o)()("tour-kit");
//# sourceMappingURL=index.js.map
/***/},
/***/23891:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */A:()=>c
/* harmony export */});
/* harmony import */var o=n(62540),s=n(86087),r=n(97866),i=n(28685),a=n(21671);
/* harmony import */n(33649);
// import { TourKitContextProvider } from './tour-kit-context';
const c=({config:e,__temp__className:t})=>{const n=(0,s.useRef)(document.createElement("div")).current;return(0,s.useEffect)((()=>{const o=["tour-kit",...t?[t]:[]];n.classList.add(...o);const s=e.options?.portalParentElement||document.body;return s.appendChild(n),()=>{s.removeChild(n)}}),[t,n,e.options?.portalParentElement]),(0/* ["default"] */,o.jsx)(r.A,{children:(0/* ["default"] */,o.jsx)(i.A,{config:e,children:(0,o.jsx)("div",{children:(0,s.createPortal)((0/* ["default"] */,o.jsx)(a.A,{config:e}),n)})})})};
/* harmony default export */}
//# sourceMappingURL=tour-kit.js.map
/***/,
/***/23997:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */A:()=>/* binding */a
/* harmony export */});
/* harmony import */var o=n(11361),s=n(63458),r=n(93341),i=n(68956);
/* harmony import */function a(e,t){void 0===t&&(t={});var n=t,a=n.placement,c=n.boundary,l=n.rootBoundary,u=n.padding,d=n.flipVariations,p=n.allowedAutoPlacements,f=void 0===p?s/* .placements */.DD:p,m=(0,o/* ["default"] */.A)(a),h=m?d?s/* .variationPlacements */.Ol:s/* .variationPlacements */.Ol.filter((function(e){return(0,o/* ["default"] */.A)(e)===m})):s/* .basePlacements */.OM,v=h.filter((function(e){return f.indexOf(e)>=0}));0===v.length&&(v=h);// $FlowFixMe[incompatible-type]: Flow seems to have problems with two array unions...
var g=v.reduce((function(t,n){return t[n]=(0,r/* ["default"] */.A)(e,{placement:n,boundary:c,rootBoundary:l,padding:u})[(0,i/* ["default"] */.A)(n)],t}),{});return Object.keys(g).sort((function(e,t){return g[e]-g[t]}))}
/***/},
/***/24604:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */n4:()=>/* binding */m
/* harmony export */});
/* unused harmony export defaultModifiers */
/* harmony import */var o=n(2892),s=n(91792),r=n(52327),i=n(11226),a=n(35435),c=n(5078),l=n(83746),u=n(67541),d=n(81116),p=n(91661),f=[s/* ["default"] */.A,r/* ["default"] */.A,i/* ["default"] */.A,a/* ["default"] */.A,c/* ["default"] */.A,l/* ["default"] */.A,u/* ["default"] */.A,d/* ["default"] */.A,p/* ["default"] */.A],m=(0,o/* .popperGenerator */.UD)({defaultModifiers:f});
/* harmony import */}// eslint-disable-next-line import/no-unused-modules
// eslint-disable-next-line import/no-unused-modules
// eslint-disable-next-line import/no-unused-modules
/***/,
/***/24832:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */Es:()=>/* binding */r
/* harmony export */,PW:()=>/* binding */s
/* harmony export */});
/* unused harmony exports unwrapArray, safeInvoke, setRef */
/* harmony import */var o=n(51609),s=function(e){return e.reduce((function(e,t){var n=t[0],o=t[1];return e[n]=o,e}),{})},r="undefined"!=typeof window&&window.document&&window.document.createElement?o.useLayoutEffect:o.useEffect;
/* harmony import */}
/***/,
/***/24906:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */A:()=>c
/* harmony export */});
/* harmony import */var o=n(62540),s=n(85840),r=n(4452),i=n.n(r),a=n(23647);
/* harmony import */
/**
 * External Dependencies
 */
/**
 * Internal Dependencies
 */
const c=({config:e,steps:t,currentStepIndex:n,onMinimize:r,onDismiss:c,onNextStep:l,onPreviousStep:u,setInitialFocusedElement:d,onGoToStep:p})=>{const f=(0,s/* .useMobileBreakpoint */.lC)(),m=i()("tour-kit-step",`is-step-${n}`,(0,a/* .classParser */.e)(e.steps[n].options?.classNames?.[f?"mobile":"desktop"]));return(0,o.jsx)("div",{className:m,children:(0,o.jsx)(e.renderers.tourStep,{steps:t,currentStepIndex:n,onDismiss:c,onNextStep:l,onPreviousStep:u,onMinimize:r,setInitialFocusedElement:d,onGoToStep:p})})};
/* harmony default export */}
//# sourceMappingURL=tour-kit-step.js.map
/***/,
/***/26368:
/***/(e,t,n)=>{"use strict";
/* harmony export */function o(e){return e?(e.nodeName||"").toLowerCase():null}
/***/n.d(t,{
/* harmony export */A:()=>/* binding */o
/* harmony export */})},
/***/27723:
/***/e=>{"use strict";e.exports=window.wp.i18n}
/***/,
/***/28107:
/***/e=>{"use strict";e.exports=window.wp.dom}
/***/,
/***/28685:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */A:()=>a
/* harmony export */,h:()=>/* binding */i
/* harmony export */});
/* harmony import */var o=n(62540),s=n(86087);
/* harmony import */const r=(0,s.createContext)({}),i=()=>(0,s.useContext)(r)
/* harmony default export */,a=({config:e,children:t})=>(0,o.jsx)(r.Provider,{value:{config:e},children:t})}
//# sourceMappingURL=tour-kit-context.js.map
/***/,
/***/29001:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */A:()=>/* binding */a
/* harmony export */});
/* harmony import */var o=n(22214),s=n(46063),r=n(32639),i=n(12730);
/* harmony import */
/*
given a DOM element, return the list of all scroll parents, up the list of ancesors
until we get to the top window object. This list is what we attach scroll listeners
to, because if any of these parent elements scroll, we'll need to re-calculate the
reference element's position.
*/
function a(e,t){var n;void 0===t&&(t=[]);var c=(0,o/* ["default"] */.A)(e),l=c===(null==(n=e.ownerDocument)?void 0:n.body),u=(0,r/* ["default"] */.A)(c),d=l?[u].concat(u.visualViewport||[],(0,i/* ["default"] */.A)(c)?c:[]):c,p=t.concat(d);return l?p:// $FlowFixMe[incompatible-call]: isBody tells us target will be an HTMLElement here
p.concat(a((0,s/* ["default"] */.A)(d)))}
/***/},
/***/29323:
/***/(e,t,n)=>{"use strict";
/* harmony export */function o(e){return["top","bottom"].indexOf(e)>=0?"x":"y"}
/***/n.d(t,{
/* harmony export */A:()=>/* binding */o
/* harmony export */})},
/***/29459:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */A:()=>/* binding */s
/* harmony export */});
/* harmony import */var o=n(26368);function s(e){return["table","td","th"].indexOf((0,o/* ["default"] */.A)(e))>=0}
/***/},
/***/29491:
/***/e=>{"use strict";e.exports=window.wp.compose}
/***/,
/***/30427:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */A:()=>/* binding */a
/* harmony export */});
/* harmony import */var o=n(68956),s=n(11361),r=n(29323),i=n(63458);
/* harmony import */function a(e){var t,n=e.reference,a=e.element,c=e.placement,l=c?(0,o/* ["default"] */.A)(c):null,u=c?(0,s/* ["default"] */.A)(c):null,d=n.x+n.width/2-a.width/2,p=n.y+n.height/2-a.height/2;switch(l){case i/* .top */.Mn:t={x:d,y:n.y-a.height};break;case i/* .bottom */.sQ:t={x:d,y:n.y+n.height};break;case i/* .right */.pG:t={x:n.x+n.width,y:p};break;case i/* .left */.kb:t={x:n.x-a.width,y:p};break;default:t={x:n.x,y:n.y}}var f=l?(0,r/* ["default"] */.A)(l):null;if(null!=f){var m="y"===f?"height":"width";switch(u){case i/* .start */.ni:t[f]=t[f]-(n[m]/2-a[m]/2);break;case i/* .end */._N:t[f]=t[f]+(n[m]/2-a[m]/2)}}return t}
/***/},
/***/31456:
/***/(e,t,n)=>{"use strict";
/* harmony export */function o(e){var t=e.reduce((function(e,t){var n=e[t.name];return e[t.name]=n?Object.assign({},n,t,{options:Object.assign({},n.options,t.options),data:Object.assign({},n.data,t.data)}):t,e}),{});// IE11 does not support Object.values
return Object.keys(t).map((function(e){return t[e]}))}
/***/n.d(t,{
/* harmony export */A:()=>/* binding */o
/* harmony export */})},
/***/31482:
/***/(e,t,n)=>{"use strict";
/* harmony export */function o(){var e=navigator.userAgentData;return null!=e&&e.brands&&Array.isArray(e.brands)?e.brands.map((function(e){return e.brand+"/"+e.version})).join(" "):navigator.userAgent}
/***/n.d(t,{
/* harmony export */A:()=>/* binding */o
/* harmony export */})},
/***/32639:
/***/(e,t,n)=>{"use strict";
/* harmony export */function o(e){if(null==e)return window;if("[object Window]"!==e.toString()){var t=e.ownerDocument;return t&&t.defaultView||window}return e}
/***/n.d(t,{
/* harmony export */A:()=>/* binding */o
/* harmony export */})},
/***/33649:
/***/()=>{}
// extracted by mini-css-extract-plugin
/***/,
/***/35387:
/***/(e,t,n)=>{"use strict";
/* harmony export */function o(e,t){return t.reduce((function(t,n){return t[n]=e,t}),{})}
/***/n.d(t,{
/* harmony export */A:()=>/* binding */o
/* harmony export */})},
/***/35435:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */A:()=>r
/* harmony export */});
/* harmony import */var o=n(26368),s=n(6433);
/* harmony import */ // eslint-disable-next-line import/no-unused-modules
/* harmony default export */const r={name:"applyStyles",enabled:!0,phase:"write",fn:
// This modifier takes the styles prepared by the `computeStyles` modifier
// and applies them to the HTMLElements such as popper and arrow
function(e){var t=e.state;Object.keys(t.elements).forEach((function(e){var n=t.styles[e]||{},r=t.attributes[e]||{},i=t.elements[e];// arrow is optional + virtual elements
(0,s/* .isHTMLElement */.sb)(i)&&(0,o/* ["default"] */.A)(i)&&(// Flow doesn't support to extend this property, but it's the most
// effective way to apply styles to an HTMLElement
// $FlowFixMe[cannot-write]
Object.assign(i.style,n),Object.keys(r).forEach((function(e){var t=r[e];!1===t?i.removeAttribute(e):i.setAttribute(e,!0===t?"":t)})))}))},effect:function(e){var t=e.state,n={popper:{position:t.options.strategy,left:"0",top:"0",margin:"0"},arrow:{position:"absolute"},reference:{}};return Object.assign(t.elements.popper.style,n.popper),t.styles=n,t.elements.arrow&&Object.assign(t.elements.arrow.style,n.arrow),function(){Object.keys(t.elements).forEach((function(e){var r=t.elements[e],i=t.attributes[e]||{},a=Object.keys(t.styles.hasOwnProperty(e)?t.styles[e]:n[e]).reduce((function(e,t){return e[t]="",e}),{});// arrow is optional + virtual elements
(0,s/* .isHTMLElement */.sb)(r)&&(0,o/* ["default"] */.A)(r)&&(Object.assign(r.style,a),Object.keys(i).forEach((function(e){r.removeAttribute(e)})))}))}},requires:["computeStyles"]};
/***/},
/***/36594:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */A:()=>p
/* harmony export */});
/* harmony import */var o=n(62540),s=n(56427),r=n(86087),i=n(91217),a=n(4452),c=n.n(a),l=n(28685),u=n(22012),d=n(94601);
/* harmony import */const p=()=>{const[e,t]=(0,r.useState)(),n=(0,l/* .useTourKitContext */.h)().config,a=n.options?.tourRating?.useTourRating?.()??e,{__}=(0,i/* .useI18n */.s9)();let p=!1;if(!n.options?.tourRating?.enabled)return null;
// check is on tempRating to allow rerating in a restarted tour
p||void 0===e||(p=!0);const f=e=>{if(p)return;const o=e?"thumbs-up":"thumbs-down";o!==a&&(p=!0,t(o),n.options?.tourRating?.onTourRate?.(o))};return(0,o.jsxs)(o.Fragment,{children:[(0,o.jsx)("p",{className:"wpcom-tour-kit-rating__end-text",children:__("Did you find this guide helpful?","default")}),(0,o.jsxs)("div",{children:[(0,o.jsx)(s.Button,{"aria-label":__("Rate thumbs up","default"),className:c()("wpcom-tour-kit-rating__end-icon",{active:"thumbs-up"===a}),disabled:p,icon:d/* ["default"] */.A,onClick:()=>f(!0),iconSize:24}),(0,o.jsx)(s.Button,{"aria-label":__("Rate thumbs down","default"),className:c()("wpcom-tour-kit-rating__end-icon",{active:"thumbs-down"===a}),disabled:p,icon:u/* ["default"] */.A,onClick:()=>f(!1),iconSize:24})]})]})};
/* harmony default export */}
//# sourceMappingURL=wpcom-tour-kit-rating.js.map
/***/,
/***/37592:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */rr:()=>/* binding */c
/* harmony export */});
/* unused harmony exports DEFAULT_STATE, actions, selectors, reducers */
/* harmony import */var o=n(66161),s=n(1455),r=n.n(s),i=n(77505);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
const a={
/**
   * Sets whether the tour should be shown.
   *
   * @param {boolean} show            The lesson status.
   * @param {boolean} persistOnServer If the action should be persisted.
   * @param {string}  tourName        The unique name of the tour.
   *
   * @return {Object} The setTourShowStatus action.
   */
setTourShowStatus:(e,t,n)=>(t&&r()({path:"sensei-internal/v1/tour",method:"POST",data:{complete:!e,tour_id:n}}),{type:"SET_TOUR_SHOW_STATUS",showTour:e})},c=(0,i/* .createStore */.y$)("sensei/tour",{reducer:(0,i/* .createReducerFromActionMap */.$x)({
/**
   * Sets the show tour status.
   *
   * @param {Object}  action          The action.
   * @param {boolean} action.showTour If the tour should be shown.
   * @param {Object}  state           The state.
   *
   * @return {Object} The new state.
   */
SET_TOUR_SHOW_STATUS:({showTour:e},t)=>({...t,showTour:e}),DEFAULT:(e,t)=>t},{showTour:!0}),actions:a,selectors:{
/**
   * Get if the tour should be shown.
   *
   * @param {Object}  state          The state.
   * @param {boolean} state.showTour If the tour should be shown.
   *
   * @return {boolean} If the tour should be shown.
   */
shouldShowTour:({showTour:e})=>e},controls:o.controls});
/**
 * Tour store actions.
 */}
/***/,
/***/39246:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */LI:()=>/* binding */r
/* harmony export */,T9:()=>/* binding */o
/* harmony export */,jk:()=>/* binding */s
/* harmony export */});var o=Math.max,s=Math.min,r=Math.round}
/***/,
/***/41598:
/***/()=>{}
// extracted by mini-css-extract-plugin
/***/,
/***/42270:
/***/(e,t,n)=>{"use strict";
/* harmony export */function o(e){return Object.assign({},e,{left:e.x,top:e.y,right:e.x+e.width,bottom:e.y+e.height})}
/***/n.d(t,{
/* harmony export */A:()=>/* binding */o
/* harmony export */})},
/***/42827:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */A:()=>/* binding */a
/* harmony export */});
/* harmony import */var o=n(32639),s=n(50780),r=n(74077),i=n(62871);
/* harmony import */function a(e,t){var n=(0,o/* ["default"] */.A)(e),a=(0,s/* ["default"] */.A)(e),c=n.visualViewport,l=a.clientWidth,u=a.clientHeight,d=0,p=0;if(c){l=c.width,u=c.height;var f=(0,i/* ["default"] */.A)();(f||!f&&"fixed"===t)&&(d=c.offsetLeft,p=c.offsetTop)}return{width:l,height:u,x:d+(0,r/* ["default"] */.A)(e),y:p}}
/***/},
/***/44767:
/***/(e,t,n)=>{"use strict";
/* harmony export */function o(e){var t;return function(){return t||(t=new Promise((function(n){Promise.resolve().then((function(){t=void 0,n(e())}))}))),t}}
/***/n.d(t,{
/* harmony export */A:()=>/* binding */o
/* harmony export */})},
/***/45469:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */Ay:()=>/* binding */A
/* harmony export */,rK:()=>/* binding */x
/* harmony export */});
/* unused harmony exports getQuizBlock, getFirstQuestionBlock, getFirstBooleanQuestionBlock, focusOnQuizBlock, focusOnQuestionBlock, focusOnBooleanQuestionBlock, ensureBooleanQuestionIsInEditor */
/* harmony import */var o=n(27723),s=n(74997),r=n(86087),i=n(56427),a=n(47143),c=n(94715),l=n(14309),u=n(90551),d=n(46458),p=n(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
const f=()=>(0,u/* .getFirstBlockByName */.w)("sensei-lms/quiz",(0,a.select)(c.store).getBlocks()),m=()=>(0,u/* .getFirstBlockByName */.w)("sensei-lms/quiz-question",(0,a.select)(c.store).getBlocks()),h=()=>{const e=f();if(!e)return null;const t=(0,a.select)(c.store).getBlocks(e.clientId).find((e=>"boolean"===e.attributes.type));return t||null},v=()=>{const e=f();e&&(0,a.dispatch)(c.store).selectBlock(e.clientId)},g=()=>{const e=m();e&&(0,a.dispatch)(c.store).selectBlock(e.clientId)},b=()=>{const e=h();e&&(0,a.dispatch)(c.store).selectBlock(e.clientId)},w=()=>{null===h()&&y()},y=()=>{const e=f();if(e){const{insertBlock:t}=(0,a.dispatch)(c.store);t((0,s.createBlock)("sensei-lms/quiz-question",{type:"boolean"}),0,e.clientId)}},x=e=>{
// Close answer feedback as the happy path next step.
if("adding-answer-feedback"!==e.slug){const e=document.querySelector(".sensei-lms-question-block__answer-feedback-toggle__header");
// Click to close only when it's open.
e&&document.querySelector(".wp-block-sensei-lms-quiz-question.show-answer-feedback")&&e.click()}
// Close sidebar if's a mobile viewport.
if((window.innerWidth||document.documentElement.clientWidth)<782){const{closeGeneralSidebar:e}=(0,a.dispatch)(l.store);e()}};
/**
 * Returns the tour steps for the Quiz block.
 *
 * @return {Array.<TourStep>} An array containing the tour steps.
 */
function A(){return[{slug:"welcome",meta:{heading:(0,o.__)("Welcome to the Quiz block","sensei-lms"),descriptions:{desktop:(0,o.__)("Take this short tour to learn the fundamentals of the Quiz block.","sensei-lms"),mobile:null},referenceElements:{desktop:""}},options:{classNames:{desktop:"",mobile:""}},referenceElements:{desktop:""},action:()=>{(0,d/* .performStepActionsAsync */.ZM)([
// Focus on the Quiz block.
{action:()=>{v()}},
// Highlight quiz block.
{action:()=>{(0,d/* .highlightElementsWithBorders */.LP)(['[data-type="sensei-lms/quiz"]'])},delay:400}])}},{slug:"change-question-type",meta:{heading:(0,o.__)("Changing the question type","sensei-lms"),descriptions:{desktop:(0,o.__)("There are a variety of question types for you to choose from including Multiple Choice, True/False and File Upload. We’ll show how to configure a True/False question, but the other question types work similarly.","sensei-lms"),mobile:null}},options:{classNames:{desktop:"",mobile:""}},referenceElements:{desktop:""},action:()=>{(0,d/* .performStepActionsAsync */.ZM)([
// Focus on question block.
{action:()=>{g()}},
// Click on type selector.
{action:()=>{const e=".sensei-lms-question-block__type-selector button",t=document.querySelector(e);(0,d/* .highlightElementsWithBorders */.LP)([e]),t&&t.click()},delay:400},
// Highlight options and select true/false type.
{action:()=>{(0,d/* .highlightElementsWithBorders */.LP)([".sensei-lms-question-block__type-selector__popover"]);const e=m();(0,a.dispatch)(c.store).updateBlockAttributes(e.clientId,{type:"boolean"})},delay:400}])}},{slug:"adding-a-question",meta:{heading:(0,o.__)("Adding a question","sensei-lms"),descriptions:{desktop:(0,o.__)("Click on an existing question to select it. Then type your question in the Question Title field.","sensei-lms"),mobile:null}},options:{classNames:{desktop:"",mobile:""}},action:()=>{(0,d/* .performStepActionsAsync */.ZM)([
// Focus on question block.
{action:()=>{g()}},
// Focus on title field.
{action:()=>{const e=".sensei-lms-question-block__title .sensei-lms-single-line-input",t=document.querySelector(e);(0,d/* .highlightElementsWithBorders */.LP)([e]),t&&t.focus(),(0,d/* .scrollToCenter */.kB)(e)},delay:400}])}},{slug:"adding-question-description",meta:{heading:(0,o.__)("Adding a question description","sensei-lms"),descriptions:{desktop:(0,o.__)("Enter any additional details about the question in the Question Description. This is optional.","sensei-lms"),mobile:null}},options:{classNames:{desktop:"",mobile:""}},action:()=>{const e=".wp-block-sensei-lms-question-description .rich-text";(0,d/* .performStepActionsAsync */.ZM)([
// Focus on question block.
{action:()=>{g()}},
// Focus on description field.
{action:()=>{const t=document.querySelector(e);t&&t.focus(),(0,d/* .scrollToCenter */.kB)(e)},delay:400},
// Highlight description field.
{action:()=>{(0,d/* .highlightElementsWithBorders */.LP)([e])},delay:400}])}},{slug:"setting-correct-answer",meta:{heading:(0,o.__)("Setting the correct answer","sensei-lms"),descriptions:{desktop:(0,o.__)("Click the Right or Wrong toggle to set the correct answer.","sensei-lms"),mobile:null}},options:{classNames:{desktop:"",mobile:""}},action:()=>{(0,d/* .performStepActionsAsync */.ZM)([
// Focus on question block.
{action:()=>{w(),b()}},
// Highlight and focus correct answer toggle.
{action:()=>{(0,d/* .highlightElementsWithBorders */.LP)([".sensei-lms-question-block__answer--true-false__option:nth-child(1) .sensei-lms-question-block__answer--true-false__toggle",".sensei-lms-question-block__answer--true-false__option:nth-child(2) .sensei-lms-question-block__answer--true-false__toggle"]);const e=document.querySelector(".sensei-lms-question-block__answer--true-false__toggle");e&&e.focus()},delay:400}])}},{slug:"adding-answer-feedback",meta:{heading:(0,o.__)("Adding answer feedback","sensei-lms"),descriptions:{desktop:(0,o.__)("Add feedback by opening the Answer Feedback section of the question block. This feedback is shown after the quiz has been graded.","sensei-lms"),mobile:null}},options:{classNames:{desktop:"",mobile:""}},action:()=>{const e=".sensei-lms-question-block__answer-feedback-toggle__header";(0,d/* .performStepActionsAsync */.ZM)([
// Focus on question block.
{action:()=>{w(),b()}},
// Highlight answer feedback.
{action:()=>{(0,d/* .highlightElementsWithBorders */.LP)([e])},delay:400},
// Open answer feedback.
{action:()=>{const t=document.querySelector(e);
// Open answer feedback if it's not already open.
null===document.querySelector(".wp-block-sensei-lms-quiz-question.is-selected.show-answer-feedback")&&t&&(t.focus(),t.click())},delay:400},
// Focus on answer feedback field and highlight answer feedback areas.
{action:()=>{const e=".sensei-lms-question__answer-feedback__content .block-editor-rich-text__editable";document.querySelector(e).focus(),(0,d/* .scrollToCenter */.kB)(e),(0,d/* .highlightElementsWithBorders */.LP)([".sensei-lms-question__answer-feedback--correct",".sensei-lms-question__answer-feedback--incorrect"])},delay:400}])}},{slug:"adding-a-new-or-existing-question",meta:{heading:(0,o.__)("Adding a new or existing question","sensei-lms"),descriptions:{desktop:(0,o.__)("Click + to open the inserter. Then click the New Question or Existing Question(s) option.","sensei-lms"),mobile:null}},options:{classNames:{desktop:"",mobile:""}},action:()=>{const e=".wp-block-sensei-lms-quiz .block-editor-inserter__toggle";(0,d/* .performStepActionsAsync */.ZM)([
// Focus on quiz block.
{action:()=>{v()}},
// Click on the inserter.
{action:()=>{const t=document.querySelector(e);t&&t.click()},delay:400},
// Highlight inserter button.
{action:()=>{(0,d/* .scrollToCenter */.kB)(e),(0,d/* .highlightElementsWithBorders */.LP)([e])}},
// Highlight options.
{action:()=>{(0,d/* .highlightElementsWithBorders */.LP)([".components-dropdown-menu__popover"])},delay:400}])}},{slug:"configure-question-settings",meta:{heading:(0,o.__)("Configuring the question settings","sensei-lms"),descriptions:{desktop:(0,r.createInterpolateElement)((0,o.__)("Question settings are available in the sidebar after selecting a question. View the <link_to_question_block_doc>doc</link_to_question_block_doc> to learn more about each one.","sensei-lms"),{link_to_question_block_doc:(0,p.jsx)(i.ExternalLink,{href:"https://senseilms.com/documentation/questions/#settings",children:null})}),mobile:null}},options:{classNames:{desktop:"",mobile:""}},action:()=>{(0,d/* .performStepActionsAsync */.ZM)([
// Focus on question block.
{action:()=>{g()}},
// Highlight question block and open sidebar settings.
{action:()=>{(0,d/* .highlightElementsWithBorders */.LP)([".wp-block-sensei-lms-quiz-question"]);const{openGeneralSidebar:e}=(0,a.dispatch)(l.store);e("edit-post/block")},delay:400},
// Highlight sidebar.
{action:()=>{(0,d/* .highlightElementsWithBorders */.LP)([".block-editor-block-inspector .components-panel__body"],"inset")},delay:400}])}},{slug:"configure-quiz-settings",meta:{heading:(0,o.__)("Configuring the quiz settings","sensei-lms"),descriptions:{desktop:(0,r.createInterpolateElement)((0,o.__)("Quiz settings are available in the sidebar after clicking the Quiz settings link. View the <link_to_quiz_block_doc>doc</link_to_quiz_block_doc> to learn more about each one.","sensei-lms"),{link_to_quiz_block_doc:(0,p.jsx)(i.ExternalLink,{href:"https://senseilms.com/documentation/quizzes/#quiz-settings",children:null})}),mobile:null}},options:{classNames:{desktop:"",mobile:""}},action:()=>{const e=".sensei-lms-quiz-block__settings-quick-nav button";(0,d/* .performStepActionsAsync */.ZM)([
// Focus on quiz block.
{action:()=>{v()}},
// Click on settings to open.
{action:()=>{const t=document.querySelector(e);t&&(t.focus(),t.click())},delay:400},
// Highlight settings button.
{action:()=>{(0,d/* .highlightElementsWithBorders */.LP)([e])}},
// Highlight sidebar.
{action:()=>{(0,d/* .highlightElementsWithBorders */.LP)([".sensei-lms-quiz-block__settings-wrapper"],"inset")},delay:400}])}},{slug:"congratulations",meta:{heading:(0,o.__)("Congratulations!","sensei-lms"),descriptions:{desktop:(0,r.createInterpolateElement)((0,o.__)("You've mastered the basics. View the quiz <link_to_quiz_doc>docs</link_to_quiz_doc> to learn more","sensei-lms"),{link_to_quiz_doc:(0,p.jsx)(i.ExternalLink,{href:"https://senseilms.com/documentation/quizzes/",children:null})}),mobile:null}},options:{classNames:{desktop:"",mobile:""}},action:()=>{
// Run the clean up.
// Run the clean up.
(0,d/* .performStepActionsAsync */.ZM)([])}}]}
/***/},
/***/46063:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */A:()=>/* binding */i
/* harmony export */});
/* harmony import */var o=n(26368),s=n(50780),r=n(6433);
/* harmony import */function i(e){return"html"===(0,o/* ["default"] */.A)(e)?e:// this is a quicker (but less type safe) way to save quite some bytes from the bundle
// $FlowFixMe[incompatible-return]
// $FlowFixMe[prop-missing]
e.assignedSlot||// step into the shadow DOM of the parent of a slotted node
e.parentNode||(// DOM Element detected
// DOM Element detected
(0,r/* .isShadowRoot */.Ng)(e)?e.host:null)||// ShadowRoot detected
// $FlowFixMe[incompatible-call]: HTMLElement is a Node
// ShadowRoot detected
// $FlowFixMe[incompatible-call]: HTMLElement is a Node
(0,s/* ["default"] */.A)(e)}
/***/},
/***/46458:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */LP:()=>/* binding */r
/* harmony export */,NO:()=>/* binding */i
/* harmony export */,ZM:()=>/* binding */l
/* harmony export */,kB:()=>/* binding */u
/* harmony export */,yj:()=>/* binding */s
/* harmony export */});
/* unused harmony exports HIGHLIGHT_CLASS, waitForElement */
/**
 * Internal dependencies
 */
const o="sensei-tour-highlight";
/**
 * Performs the action for the step.
 *
 * @param {number}           index The index of the step.
 * @param {Array.<TourStep>} steps The steps array.
 */function s(e,t){if(e<t.length){const n=t[e];n.action&&n.action()}}
/**
 * Highlights the elements with a border.
 *
 * @param {Array}  selectors An array of selectors to highlight.
 * @param {string} modifier  A modifier to add to the highlight class.
 */function r(e,t=""){e.forEach((function(e){const n=document.querySelector(e);n&&(n.classList.add(o),t&&n.classList.add(o+"--"+t))}))}
/**
 * Removes the highlight classes from the elements.
 */function i(){document.querySelectorAll(".sensei-tour-highlight").forEach((function(e){
// Remove class and modifiers.
[...e.classList].forEach((t=>{t.startsWith(o)&&e.classList.remove(t)}))}))}let a=null,c=null;
/**
 * Performs step actions one after another.
 *
 * @param {Array} stepActions An array of selectors to highlight.
 */
async function l(e){i(),
// Clear the timeout and reject the last promise if it exists, so it stops the step if actions from another step started.
clearTimeout(a),c&&c();try{for(const t of e)t&&await new Promise(((e,n)=>{var o;c=n,a=setTimeout((()=>{t.action(),e()}),null!==(o=t.delay)&&void 0!==o?o:0)}))}catch(e){
// Do nothing.
}}
/**
 * Waits for an element to be available in the DOM.
 *
 * @param {string} selector  The selector to wait for.
 * @param {number} maxChecks The maximum number of checks to perform.
 * @param {number} delay     The delay between checks.
 *
 * @return {Promise<unknown>} A promise that resolves when the element is available.
 */
/**
 * Scrolls element to the center for better visibility.
 *
 * @param {string} selector
 */
const u=e=>{const t=document.querySelector(e);t&&t.scrollIntoView({behavior:"smooth",block:"center",inline:"center"})};
/***/},
/***/47143:
/***/e=>{"use strict";e.exports=window.wp.data}
/***/,
/***/49777:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */A:()=>r
/* harmony export */});
/* harmony import */var o=n(62540),s=n(10912);
/* harmony import */const r=({steps:e,currentStepIndex:t,onDismiss:n,onNextStep:r,onPreviousStep:i,onMinimize:a,setInitialFocusedElement:c,onGoToStep:l})=>(0/* ["default"] */,o.jsx)(s.A,{steps:e,currentStepIndex:t,onDismiss:n,onMinimize:a,onGoToStep:l,onNextStep:r,onPreviousStep:i,setInitialFocusedElement:c});
/* harmony default export */}
//# sourceMappingURL=wpcom-tour-kit-step.js.map
/***/,
/***/50004:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */A:()=>/* binding */s
/* harmony export */});var o={left:"right",right:"left",bottom:"top",top:"bottom"};function s(e){return e.replace(/left|right|bottom|top/g,(function(e){return o[e]}))}
/***/},
/***/50231:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */A:()=>/* binding */s
/* harmony export */});
/* harmony import */var o=n(93094);
// Returns the layout rect of an element relative to its offsetParent. Layout
// means it doesn't take into account transforms.
function s(e){var t=(0,o/* ["default"] */.A)(e),n=e.offsetWidth,s=e.offsetHeight;// Use the clientRect sizes if it's not been transformed.
// Fixes https://github.com/popperjs/popper-core/issues/1223
return Math.abs(t.width-n)<=1&&(n=t.width),Math.abs(t.height-s)<=1&&(s=t.height),{x:e.offsetLeft,y:e.offsetTop,width:n,height:s}}
/***/},
/***/50780:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */A:()=>/* binding */s
/* harmony export */});
/* harmony import */var o=n(6433);function s(e){
// $FlowFixMe[incompatible-return]: assume body is always available
return(((0,o/* .isElement */.vq)(e)?e.ownerDocument:// $FlowFixMe[prop-missing]
e.document)||window.document).documentElement}
/***/},
/***/51236:
/***/(e,t,n)=>{e.exports=
/**
 * This is the common logic for both the Node.js and web browser
 * implementations of `debug()`.
 */
function(e){
/**
	* Create a debugger with the given `namespace`.
	*
	* @param {String} namespace
	* @return {Function}
	* @api public
	*/
function t(e){let n,s,r,i=null;function a(...e){
// Disabled?
if(!a.enabled)return;const o=a,s=Number(new Date),r=s-(n||s);
// Set `diff` timestamp
o.diff=r,o.prev=n,o.curr=s,n=s,e[0]=t.coerce(e[0]),"string"!=typeof e[0]&&
// Anything else let's inspect with %O
e.unshift("%O");
// Apply any `formatters` transformations
let i=0;e[0]=e[0].replace(/%([a-zA-Z%])/g,((n,s)=>{
// If we encounter an escaped % then don't increase the array index
if("%%"===n)return"%";i++;const r=t.formatters[s];if("function"==typeof r){const t=e[i];n=r.call(o,t),
// Now we need to remove `args[index]` since it's inlined in the `format`
e.splice(i,1),i--}return n})),
// Apply env-specific formatting (colors, etc.)
t.formatArgs.call(o,e);(o.log||t.log).apply(o,e)}return a.namespace=e,a.useColors=t.useColors(),a.color=t.selectColor(e),a.extend=o,a.destroy=t.destroy,// XXX Temporary. Will be removed in the next major release.
Object.defineProperty(a,"enabled",{enumerable:!0,configurable:!1,get:()=>null!==i?i:(s!==t.namespaces&&(s=t.namespaces,r=t.enabled(e)),r),set:e=>{i=e}}),
// Env-specific initialization logic for debug instances
"function"==typeof t.init&&t.init(a),a}function o(e,n){const o=t(this.namespace+(void 0===n?":":n)+e);return o.log=this.log,o}
/**
	* Enables a debug mode by namespaces. This can include modes
	* separated by a colon and wildcards.
	*
	* @param {String} namespaces
	* @api public
	*/
/**
	* Convert regexp to namespace
	*
	* @param {RegExp} regxep
	* @return {String} namespace
	* @api private
	*/
function s(e){return e.toString().substring(2,e.toString().length-2).replace(/\.\*\?$/,"*")}
/**
	* Coerce `val`.
	*
	* @param {Mixed} val
	* @return {Mixed}
	* @api private
	*/return t.debug=t,t.default=t,t.coerce=function(e){if(e instanceof Error)return e.stack||e.message;return e}
/**
	* XXX DO NOT USE. This is a temporary stub function.
	* XXX It WILL be removed in the next major release.
	*/,t.disable=
/**
	* Disable debug output.
	*
	* @return {String} namespaces
	* @api public
	*/
function(){const e=[...t.names.map(s),...t.skips.map(s).map((e=>"-"+e))].join(",");return t.enable(""),e}
/**
	* Returns true if the given mode name is enabled, false otherwise.
	*
	* @param {String} name
	* @return {Boolean}
	* @api public
	*/,t.enable=function(e){let n;t.save(e),t.namespaces=e,t.names=[],t.skips=[];const o=("string"==typeof e?e:"").split(/[\s,]+/),s=o.length;for(n=0;n<s;n++)o[n]&&("-"===(e=o[n].replace(/\*/g,".*?"))[0]?t.skips.push(new RegExp("^"+e.slice(1)+"$")):t.names.push(new RegExp("^"+e+"$")))},t.enabled=function(e){if("*"===e[e.length-1])return!0;let n,o;for(n=0,o=t.skips.length;n<o;n++)if(t.skips[n].test(e))return!1;for(n=0,o=t.names.length;n<o;n++)if(t.names[n].test(e))return!0;return!1},t.humanize=n(76301),t.destroy=function(){console.warn("Instance method `debug.destroy()` is deprecated and no longer does anything. It will be removed in the next major version of `debug`.")},Object.keys(e).forEach((n=>{t[n]=e[n]})),
/**
	* The currently active debug mode names, and names to skip.
	*/
t.names=[],t.skips=[],
/**
	* Map of special "%n" handling functions, for the debug "format" argument.
	*
	* Valid key names are a single, lower or upper-case letter, i.e. "n" and "N".
	*/
t.formatters={},t.selectColor=
/**
	* Selects a color for a debug namespace
	* @param {String} namespace The namespace string for the debug instance to be colored
	* @return {Number|String} An ANSI color code for the given namespace
	* @api private
	*/
function(e){let n=0;for(let t=0;t<e.length;t++)n=(n<<5)-n+e.charCodeAt(t),n|=0;return t.colors[Math.abs(n)%t.colors.length]},t.enable(t.load()),t}}
/***/,
/***/51609:
/***/e=>{"use strict";e.exports=window.React}
/***/,
/***/52327:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */A:()=>s
/* harmony export */});
/* harmony import */var o=n(30427);// eslint-disable-next-line import/no-unused-modules
/* harmony default export */const s={name:"popperOffsets",enabled:!0,phase:"read",fn:function(e){var t=e.state,n=e.name;
// Offsets are the actual position the popper needs to have to be
// properly positioned near its reference element
// This is the most basic placement, and will be adjusted by
// the modifiers in the next step
t.modifiersData[n]=(0,o/* ["default"] */.A)({reference:t.rects.reference,element:t.rects.popper,strategy:"absolute",placement:t.placement})},data:{}};
/***/},
/***/53286:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */A:()=>s
/* harmony export */});
/* harmony import */var o=n(62540);const s=({config:e,steps:t,currentStepIndex:n,onMaximize:s,onDismiss:r})=>(0,o.jsx)("div",{className:"tour-kit-minimized",children:(0,o.jsx)(e.renderers.tourMinimized,{steps:t,currentStepIndex:n,onMaximize:s,onDismiss:r})});
/* harmony default export */}
//# sourceMappingURL=tour-kit-minimized.js.map
/***/,
/***/54664:
/***/(e,t,n)=>{"use strict";
/* harmony export */function o(){return{top:0,right:0,bottom:0,left:0}}
/***/n.d(t,{
/* harmony export */A:()=>/* binding */o
/* harmony export */})},
/***/56427:
/***/e=>{"use strict";e.exports=window.wp.components}
/***/,
/***/57127:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */P:()=>/* binding */r
/* harmony export */,u:()=>/* binding */s
/* harmony export */});
/* harmony import */var o=n(39246);function s(e,t,n){return(0,o/* .max */.T9)(e,(0,o/* .min */.jk)(t,n))}function r(e,t,n){var o=s(e,t,n);return o>n?n:o}
/***/},
/***/57610:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */A:()=>s
/* harmony export */});
/* harmony import */var o=n(86087);
/* harmony import */
/* eslint-disable jsdoc/require-param */
/**
 * External Dependencies
 */
/**
 * A hook the applies the respective callbacks in response to keydown events.
 */
const s=({onEscape:e,onArrowRight:t,onArrowLeft:n})=>{const s=(0,o.useCallback)((o=>{let s=!1;switch(o.key){case"Escape":e&&(e(),s=!0);break;case"ArrowRight":t&&(t(),s=!0);break;case"ArrowLeft":n&&(n(),s=!0)}s&&(o.preventDefault(),o.stopPropagation())}),[e,t,n]);(0,o.useEffect)((()=>(document.addEventListener("keydown",s),()=>{document.removeEventListener("keydown",s)})),[s])};
/* harmony default export */}
//# sourceMappingURL=use-keydown-handler.js.map
/***/,
/***/59885:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */A:()=>s
/* harmony export */});
/* harmony import */var o=n(86087);
/* harmony import */
/**
 * External Dependencies
 */
/**
 * A hook that returns true/false if ref node receives focus by either tabbing or clicking into any of its children.
 * @param ref React.MutableRefObject< null | HTMLElement >
 */
const s=e=>{const[t,n]=(0,o.useState)(!1),s=(0,o.useCallback)((()=>{document.hasFocus()&&e.current?.contains(document.activeElement)?n(!0):n(!1)}),[e]),r=(0,o.useCallback)((t=>{e.current?.contains(t.target)?n(!0):n(!1)}),[e]),i=(0,o.useCallback)((t=>{"Tab"===t.key&&(e.current?.contains(t.target)?n(!0):n(!1))}),[e]);return(0,o.useEffect)((()=>(document.addEventListener("focusin",s),document.addEventListener("mousedown",r),document.addEventListener("keyup",i),()=>{document.removeEventListener("focusin",s),document.removeEventListener("mousedown",r),document.removeEventListener("keyup",i)})),[e,s,i,r]),t};
/* harmony default export */}
//# sourceMappingURL=use-focus-handler.js.map
/***/,
/***/60751:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */A:()=>/* binding */b
/* harmony export */});
/* harmony import */var o=n(63458),s=n(42827),r=n(81916),i=n(29001),a=n(95740),c=n(50780),l=n(71699),u=n(6433),d=n(93094),p=n(46063),f=n(7130),m=n(26368),h=n(42270),v=n(39246);
/* harmony import */function g(e,t,n){return t===o/* .viewport */.R9?(0,h/* ["default"] */.A)((0,s/* ["default"] */.A)(e,n)):(0,u/* .isElement */.vq)(t)?function(e,t){var n=(0,d/* ["default"] */.A)(e,!1,"fixed"===t);return n.top=n.top+e.clientTop,n.left=n.left+e.clientLeft,n.bottom=n.top+e.clientHeight,n.right=n.left+e.clientWidth,n.width=e.clientWidth,n.height=e.clientHeight,n.x=n.left,n.y=n.top,n}(t,n):(0,h/* ["default"] */.A)((0,r/* ["default"] */.A)((0,c/* ["default"] */.A)(e)))}// A "clipping parent" is an overflowable container with the characteristic of
// clipping (or hiding) overflowing elements with a position different from
// `initial`
// Gets the maximum area that the element is visible in due to any number of
// clipping parents
function b(e,t,n,o){var s="clippingParents"===t?function(e){var t=(0,i/* ["default"] */.A)((0,p/* ["default"] */.A)(e)),n=["absolute","fixed"].indexOf((0,l/* ["default"] */.A)(e).position)>=0&&(0,u/* .isHTMLElement */.sb)(e)?(0,a/* ["default"] */.A)(e):e;return(0,u/* .isElement */.vq)(n)?t.filter((function(e){return(0,u/* .isElement */.vq)(e)&&(0,f/* ["default"] */.A)(e,n)&&"body"!==(0,m/* ["default"] */.A)(e)})):[];// $FlowFixMe[incompatible-return]: https://github.com/facebook/flow/issues/1414
}(e):[].concat(t),r=[].concat(s,[n]),c=r[0],d=r.reduce((function(t,n){var s=g(e,n,o);return t.top=(0,v/* .max */.T9)(s.top,t.top),t.right=(0,v/* .min */.jk)(s.right,t.right),t.bottom=(0,v/* .min */.jk)(s.bottom,t.bottom),t.left=(0,v/* .max */.T9)(s.left,t.left),t}),g(e,c,o));return d.width=d.right-d.left,d.height=d.bottom-d.top,d.x=d.left,d.y=d.top,d}
/***/},
/***/62306:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */A:()=>i
/* harmony export */});
/* harmony import */var o=n(62540),s=n(4452),r=n.n(s);
/* harmony import */
/**
 * External Dependencies
 */
const i=({visible:e})=>(0,o.jsx)("div",{className:r()("tour-kit-overlay",{"is-visible":e})});
/* harmony default export */}
//# sourceMappingURL=tour-kit-overlay.js.map
/***/,
/***/62540:
/***/(e,t,n)=>{"use strict";e.exports=n(2192)}
/***/,
/***/62871:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */A:()=>/* binding */s
/* harmony export */});
/* harmony import */var o=n(31482);function s(){return!/^((?!chrome|android).)*safari/i.test((0,o/* ["default"] */.A)())}
/***/},
/***/63095:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */A:()=>/* binding */s
/* harmony export */});var o={start:"end",end:"start"};function s(e){return e.replace(/start|end/g,(function(e){return o[e]}))}
/***/},
/***/63458:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */DD:()=>/* binding */v
/* harmony export */,GM:()=>/* binding */g
/* harmony export */,Mn:()=>/* binding */o
/* harmony export */,OM:()=>/* binding */c
/* harmony export */,Ol:()=>/* binding */h
/* harmony export */,R9:()=>/* binding */p
/* harmony export */,WY:()=>/* binding */d
/* harmony export */,_N:()=>/* binding */u
/* harmony export */,ir:()=>/* binding */m
/* harmony export */,kb:()=>/* binding */i
/* harmony export */,ni:()=>/* binding */l
/* harmony export */,pG:()=>/* binding */r
/* harmony export */,qZ:()=>/* binding */a
/* harmony export */,sQ:()=>/* binding */s
/* harmony export */,xf:()=>/* binding */f
/* harmony export */});
/* unused harmony exports beforeRead, read, afterRead, beforeMain, main, afterMain, beforeWrite, write, afterWrite */
var o="top",s="bottom",r="right",i="left",a="auto",c=[o,s,r,i],l="start",u="end",d="clippingParents",p="viewport",f="popper",m="reference",h=c.reduce((function(e,t){return e.concat([t+"-"+l,t+"-"+u])}),[]),v=[].concat(c,[a]).reduce((function(e,t){return e.concat([t,t+"-"+l,t+"-"+u])}),[]),g=["beforeRead","read","afterRead","beforeMain","main","afterMain","beforeWrite","write","afterWrite"]}
/***/,
/***/64624:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */A:()=>r
/* harmony export */});
/* harmony import */var o=n(51609),s=n(5573);
/* harmony import */
/**
 * WordPress dependencies
 */
const r=(0,o.createElement)(s.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24"},(0,o.createElement)(s.Path,{d:"M13 11.8l6.1-6.3-1-1-6.1 6.2-6.1-6.2-1 1 6.1 6.3-6.5 6.7 1 1 6.5-6.6 6.5 6.6 1-1z"}));
/* harmony default export */}
//# sourceMappingURL=close.js.map
/***/,
/***/65970:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */A:()=>r
/* harmony export */});
/* harmony import */var o=n(28107),s=n(86087);
/* harmony import */
/**
 * External Dependencies
 */
/**
 * A hook that constraints tabbing/focus on focuable elements in the given element ref.
 * @param ref React.MutableRefObject< null | HTMLElement >
 */
const r=e=>{const[t,n]=(0,s.useState)(),[r,i]=(0,s.useState)(),a=(0,s.useCallback)((e=>{let n=!1;"Tab"===e.key&&(e.shiftKey?
// Shift + Tab
document.activeElement===t&&(r?.focus(),n=!0):document.activeElement===r&&(
// Tab
t?.focus(),n=!0)),n&&(e.preventDefault(),e.stopPropagation())}),[t,r]);(0,s.useEffect)((()=>{const t=e.current?o.focus.focusable.find(e.current):[];return t&&t.length&&(n(t[0]),i(t[t.length-1])),document.addEventListener("keydown",a),()=>{document.removeEventListener("keydown",a)}}),[e,a])};
/* harmony default export */}
//# sourceMappingURL=use-focus-trap.js.map
/***/,
/***/66072:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */A:()=>s
/* harmony export */});
/* harmony import */var o=n(86087);
/* harmony import */
/**
 * External Dependencies
 */
const s=(e,t)=>{const[n,s]=(0,o.useState)([]);(0,o.useEffect)((()=>{n.includes(e)||(s((t=>[...t,e])),t?.(e))}),[e,t,n])};
/* harmony default export */}
//# sourceMappingURL=use-step-tracking.js.map
/***/,
/***/66087:
/***/e=>{"use strict";e.exports=window.lodash}
/***/,
/***/66161:
/***/e=>{"use strict";e.exports=window.wp.dataControls}
/***/,
/***/67541:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */A:()=>m
/* harmony export */});
/* harmony import */var o=n(63458),s=n(68956),r=n(29323),i=n(21446),a=n(57127),c=n(50231),l=n(95740),u=n(93341),d=n(11361),p=n(54664),f=n(39246);
/* harmony import */ // eslint-disable-next-line import/no-unused-modules
/* harmony default export */const m={name:"preventOverflow",enabled:!0,phase:"main",fn:function(e){var t=e.state,n=e.options,m=e.name,h=n.mainAxis,v=void 0===h||h,g=n.altAxis,b=void 0!==g&&g,w=n.boundary,y=n.rootBoundary,x=n.altBoundary,A=n.padding,k=n.tether,_=void 0===k||k,C=n.tetherOffset,S=void 0===C?0:C,j=(0,u/* ["default"] */.A)(t,{boundary:w,rootBoundary:y,padding:A,altBoundary:x}),O=(0,s/* ["default"] */.A)(t.placement),E=(0,d/* ["default"] */.A)(t.placement),M=!E,z=(0,r/* ["default"] */.A)(O),F=(0,i/* ["default"] */.A)(z),q=t.modifiersData.popperOffsets,P=t.rects.reference,L=t.rects.popper,T="function"==typeof S?S(Object.assign({},t.rects,{placement:t.placement})):S,N="number"==typeof T?{mainAxis:T,altAxis:T}:Object.assign({mainAxis:0,altAxis:0},T),D=t.modifiersData.offset?t.modifiersData.offset[t.placement]:null,R={x:0,y:0};if(q){if(v){var B,I="y"===z?o/* .top */.Mn:o/* .left */.kb,V="y"===z?o/* .bottom */.sQ:o/* .right */.pG,W="y"===z?"height":"width",G=q[z],$=G+j[I],H=G-j[V],U=_?-L[W]/2:0,Q=E===o/* .start */.ni?P[W]:L[W],Z=E===o/* .start */.ni?-L[W]:-P[W],Y=t.elements.arrow,K=_&&Y?(0,c/* ["default"] */.A)(Y):{width:0,height:0},J=t.modifiersData["arrow#persistent"]?t.modifiersData["arrow#persistent"].padding:(0,p/* ["default"] */.A)(),X=J[I],ee=J[V],te=(0,a/* .within */.u)(0,P[W],K[W]),ne=M?P[W]/2-U-te-X-N.mainAxis:Q-te-X-N.mainAxis,oe=M?-P[W]/2+U+te+ee+N.mainAxis:Z+te+ee+N.mainAxis,se=t.elements.arrow&&(0,l/* ["default"] */.A)(t.elements.arrow),re=se?"y"===z?se.clientTop||0:se.clientLeft||0:0,ie=null!=(B=null==D?void 0:D[z])?B:0,ae=G+ne-ie-re,ce=G+oe-ie,le=(0,a/* .within */.u)(_?(0,f/* .min */.jk)($,ae):$,G,_?(0,f/* .max */.T9)(H,ce):H);q[z]=le,R[z]=le-G}if(b){var ue,de="x"===z?o/* .top */.Mn:o/* .left */.kb,pe="x"===z?o/* .bottom */.sQ:o/* .right */.pG,fe=q[F],me="y"===F?"height":"width",he=fe+j[de],ve=fe-j[pe],ge=-1!==[o/* .top */.Mn,o/* .left */.kb].indexOf(O),be=null!=(ue=null==D?void 0:D[F])?ue:0,we=ge?he:fe-P[me]-L[me]-be+N.altAxis,ye=ge?fe+P[me]+L[me]-be-N.altAxis:ve,xe=_&&ge?(0,a/* .withinMaxClamp */.P)(we,fe,ye):(0,a/* .within */.u)(_?we:he,fe,_?ye:ve);q[F]=xe,R[F]=xe-fe}t.modifiersData[m]=R}},requiresIfExists:["offset"]};
/***/},
/***/68956:
/***/(e,t,n)=>{"use strict";
/* harmony export */function o(e){return e.split("-")[0]}
/***/n.d(t,{
/* harmony export */A:()=>/* binding */o
/* harmony export */})},
/***/69037:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */A:()=>c
/* harmony export */});
/* harmony import */var o=n(62540),s=n(27723),r=n(4452),i=n.n(r),a=n(66087);
/* harmony import */n(41598);const c=({activePageIndex:e,numberOfPages:t,onChange:n,classNames:r,children:c})=>{const l=i()("pagination-control",r);return(0,o.jsxs)("ul",{className:l,"aria-label":(0,s.__)("Pagination control"),children:[(0,a.times)(t,(r=>(0,o.jsx)("li",{"aria-current":r===e?"page":void 0,children:(0,o.jsx)("button",{className:i()("pagination-control__page",{"is-current":r===e}),disabled:r===e,"aria-label":(0,s.sprintf)(
/* translators: 1: current page number 2: total number of pages */
/* translators: 1: current page number 2: total number of pages */
(0,s.__)("Page %1$d of %2$d"),r+1,t),onClick:()=>n(r)})},`${t}-${r}`))),c&&(0,o.jsx)("li",{className:"pagination-control__last-item",children:c})]})};
/* harmony default export */}
//# sourceMappingURL=index.js.map
/***/,
/***/70974:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */Dy:()=>/* binding */s
/* harmony export */,Fr:()=>/* binding */m
/* harmony export */,hO:()=>/* binding */p
/* harmony export */,hf:()=>/* binding */d
/* harmony export */,jK:()=>/* binding */r
/* harmony export */,xV:()=>/* binding */f
/* harmony export */});
/* unused harmony exports subscribeIsMobile, isDesktop, subscribeIsDesktop, getWindowInnerWidth, isTabletResolution, DEVICE_MOBILE, DEVICE_TABLET, DEVICE_DESKTOP, resolveDeviceTypeByViewPort */
// Determine whether a user is viewing calypso from a device within a
// particular mobile-first responsive breakpoint, matching our existing media
// queries. [1]
// This function takes a string matching one of our mobile-first breakpoints
// and returns a boolean based on whether the current `window.innerWidth`
// matches. This is used to segment behavior based on device or browser size,
// but should not be used in place of css for design.
// Valid breakpoints include:
// - '<480px'
// - '<660px'
// - '<800px'
// - '<960px'
// - '<1040px'
// - '<1280px'
// - '<1400px'
// - '>480px'
// - '>660px'
// - '>800px'
// - '>960px'
// - '>1040px'
// - '>1280px'
// - '>1400px'
// - '480px-660px'
// - '480px-960px'
// - '660px-960px'
// As implemented in our sass media query mixins, minimums are exclusive, while
// maximums are inclusive. i.e.,
// - '>480px' is equivalent to `@media (min-width: 481px)`
// - '<960px' is equivalent to `@media (max-width: 960px)`
// - '480px-960px' is equivalent to `@media (max-width: 960px) and (min-width: 481px)`
// [1] https://github.com/Automattic/wp-calypso/blob/HEAD/docs/coding-guidelines/css.md#media-queries
// FIXME: We can't detect window size on the server, so until we have more intelligent detection,
// use 769, which is just above the general maximum mobile screen width.
const o=769,s="<480px",r=">960px",i="undefined"==typeof window||!window.matchMedia,a=()=>null;function c(e){return{addListener:()=>{},removeListener:()=>{},...e}}function l(e){const{min:t,max:n}=e??{};return void 0!==t&&void 0!==n?i?c({matches:o>t&&o<=n}):window.matchMedia(`(min-width: ${t+1}px) and (max-width: ${n}px)`):void 0!==t?i?c({matches:o>t}):window.matchMedia(`(min-width: ${t+1}px)`):void 0!==n&&(i?c({matches:o<=n}):window.matchMedia(`(max-width: ${n}px)`))}const u={"<480px":l({max:480}),"<660px":l({max:660}),"<782px":l({max:782}),"<800px":l({max:800}),"<960px":l({max:960}),"<1040px":l({max:1040}),"<1280px":l({max:1280}),"<1400px":l({max:1400}),">480px":l({min:480}),">660px":l({min:660}),">782px":l({min:782}),">800px":l({min:800}),">960px":l({min:960}),">1040px":l({min:1040}),">1280px":l({min:1280}),">1400px":l({min:1400}),"480px-660px":l({min:480,max:660}),"660px-960px":l({min:660,max:960}),"480px-960px":l({min:480,max:960})};function d(e){if(u.hasOwnProperty(e))return u[e];try{
// eslint-disable-next-line no-console
console.warn("Undefined breakpoint used in `mobile-first-breakpoint`",e)}catch(e){}}
/**
 * Returns whether the current window width matches a breakpoint.
 *
 * @param {string} breakpoint The breakpoint to consider.
 * @returns {boolean|undefined} Whether the provided breakpoint is matched.
 */function p(e){const t=d(e);return t?t.matches:void 0}
/**
 * Registers a listener to be notified of changes to breakpoint matching status.
 *
 * @param {string} breakpoint The breakpoint to consider.
 * @param {Function} listener The listener to be called on change.
 * @returns {Function} The function to be called when unsubscribing.
 */function f(e,t){if(!t)return a;const n=d(e);if(n&&!i){const e=e=>t(e.matches);
// Return unsubscribe function.
return n.addListener(e),()=>n.removeListener(e)}return a}
/**
 * Returns whether the current window width matches the mobile breakpoint.
 *
 * @returns {boolean|undefined} Whether the mobile breakpoint is matched.
 */function m(){return p(s)}
/**
 * Registers a listener to be notified of changes to mobile breakpoint matching status.
 *
 * @param {Function} listener The listener to be called on change.
 * @returns {Function} The registered subscription; undefined if none.
 */}
/******************************************/
//# sourceMappingURL=index.js.map
/***/,
/***/71699:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */A:()=>/* binding */s
/* harmony export */});
/* harmony import */var o=n(32639);function s(e){return(0,o/* ["default"] */.A)(e).getComputedStyle(e)}
/***/},
/***/74077:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */A:()=>/* binding */i
/* harmony export */});
/* harmony import */var o=n(93094),s=n(50780),r=n(21042);
/* harmony import */function i(e){
// If <html> has a CSS width greater than the viewport, then this will be
// incorrect for RTL.
// Popper 1 is broken in this case and never had a bug report so let's assume
// it's not an issue. I don't think anyone ever specifies width on <html>
// anyway.
// Browsers where the left scrollbar doesn't cause an issue report `0` for
// this (e.g. Edge 2019, IE11, Safari)
return(0,o/* ["default"] */.A)((0,s/* ["default"] */.A)(e)).left+(0,r/* ["default"] */.A)(e).scrollLeft}
/***/},
/***/74724:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */q:()=>/* binding */r
/* harmony export */});
/* harmony import */var o=n(62540),s=n(96822);
/* harmony import */const r=({enabled:e=!1,rootElementSelector:t="#wpwrap"})=>e?(0,o.jsx)("style",{children:`\n    .${s/* .SPOTLIT_ELEMENT_CLASS */.E}, .${s/* .SPOTLIT_ELEMENT_CLASS */.E} * {\n        pointer-events: auto;\n    }\n    .tour-kit-frame__container button {\n        pointer-events: auto;\n    }\n    .tour-kit-spotlight, .tour-kit-overlay {\n        pointer-events: none;\n    }\n    ${t} :not(.${s/* .SPOTLIT_ELEMENT_CLASS */.E}, .${s/* .SPOTLIT_ELEMENT_CLASS */.E} *) {\n        pointer-events: none;\n    }\n    `}):null;
//# sourceMappingURL=tour-kit-spotlight-interactivity.js.map
/***/},
/***/74997:
/***/e=>{"use strict";e.exports=window.wp.blocks}
/***/,
/***/75176:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */E:()=>/* binding */u
/* harmony export */});
/* harmony import */var o=n(51609),s=n(75795),r=n(24604),i=n(97383),a=n.n(i),c=n(24832),l=[],u=function(e,t,n){void 0===n&&(n={});var i=o.useRef(null),u={onFirstUpdate:n.onFirstUpdate,placement:n.placement||"bottom",strategy:n.strategy||"absolute",modifiers:n.modifiers||l},d=o.useState({styles:{popper:{position:u.strategy,left:"0",top:"0"},arrow:{position:"absolute"}},attributes:{}}),p=d[0],f=d[1],m=o.useMemo((function(){return{name:"updateState",enabled:!0,phase:"write",fn:function(e){var t=e.state,n=Object.keys(t.elements);s.flushSync((function(){f({styles:(0,c/* .fromEntries */.PW)(n.map((function(e){return[e,t.styles[e]||{}]}))),attributes:(0,c/* .fromEntries */.PW)(n.map((function(e){return[e,t.attributes[e]]})))})}))},requires:["computeStyles"]}}),[]),h=o.useMemo((function(){var e={onFirstUpdate:u.onFirstUpdate,placement:u.placement,strategy:u.strategy,modifiers:[].concat(u.modifiers,[m,{name:"applyStyles",enabled:!1}])};return a()(i.current,e)?i.current||e:(i.current=e,e)}),[u.onFirstUpdate,u.placement,u.strategy,u.modifiers,m]),v=o.useRef();return(0,c/* .useIsomorphicLayoutEffect */.Es)((function(){v.current&&v.current.setOptions(h)}),[h]),(0,c/* .useIsomorphicLayoutEffect */.Es)((function(){if(null!=e&&null!=t){var o=(n.createPopper||r/* .createPopper */.n4)(e,t,h);return v.current=o,function(){o.destroy(),v.current=null}}}),[e,t,n.createPopper]),{state:v.current?v.current.state:null,styles:p.styles,attributes:p.attributes,update:v.current?v.current.update:null,forceUpdate:v.current?v.current.forceUpdate:null}};
/* harmony import */}
/***/,
/***/75795:
/***/e=>{"use strict";e.exports=window.ReactDOM}
/***/,
/***/76301:
/***/e=>{
/**
 * Helpers.
 */
var t=1e3,n=60*t,o=60*n,s=24*o,r=7*s,i=365.25*s;
/**
 * Pluralization helper.
 */
function a(e,t,n,o){var s=t>=1.5*n;return Math.round(e/n)+" "+o+(s?"s":"")}
/***/
/**
 * Parse or format the given `val`.
 *
 * Options:
 *
 *  - `long` verbose formatting [false]
 *
 * @param {String|Number} val
 * @param {Object} [options]
 * @throws {Error} throw an error if val is not a non-empty string or a number
 * @return {String|Number}
 * @api public
 */
e.exports=function(e,c){c=c||{};var l=typeof e;if("string"===l&&e.length>0)
/**
 * Parse the given `str` and return milliseconds.
 *
 * @param {String} str
 * @return {Number}
 * @api private
 */
return function(e){if((e=String(e)).length>100)return;var a=/^(-?(?:\d+)?\.?\d+) *(milliseconds?|msecs?|ms|seconds?|secs?|s|minutes?|mins?|m|hours?|hrs?|h|days?|d|weeks?|w|years?|yrs?|y)?$/i.exec(e);if(!a)return;var c=parseFloat(a[1]);switch((a[2]||"ms").toLowerCase()){case"years":case"year":case"yrs":case"yr":case"y":return c*i;case"weeks":case"week":case"w":return c*r;case"days":case"day":case"d":return c*s;case"hours":case"hour":case"hrs":case"hr":case"h":return c*o;case"minutes":case"minute":case"mins":case"min":case"m":return c*n;case"seconds":case"second":case"secs":case"sec":case"s":return c*t;case"milliseconds":case"millisecond":case"msecs":case"msec":case"ms":return c;default:return}}
/**
 * Short format for `ms`.
 *
 * @param {Number} ms
 * @return {String}
 * @api private
 */(e);if("number"===l&&isFinite(e))return c.long?
/**
 * Long format for `ms`.
 *
 * @param {Number} ms
 * @return {String}
 * @api private
 */
function(e){var r=Math.abs(e);if(r>=s)return a(e,r,s,"day");if(r>=o)return a(e,r,o,"hour");if(r>=n)return a(e,r,n,"minute");if(r>=t)return a(e,r,t,"second");return e+" ms"}(e):function(e){var r=Math.abs(e);if(r>=s)return Math.round(e/s)+"d";if(r>=o)return Math.round(e/o)+"h";if(r>=n)return Math.round(e/n)+"m";if(r>=t)return Math.round(e/t)+"s";return e+"ms"}(e);throw new Error("val is not a non-empty string or a valid number. val="+JSON.stringify(e))}},
/***/77505:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */$x:()=>/* binding */r
/* harmony export */,y$:()=>/* binding */i
/* harmony export */});
/* unused harmony export composeFetchAction */
/* harmony import */var o=n(47143);
/* harmony import */
/**
 * WordPress dependencies
 */
// We register the store in the global scope to avoid registering it multiple times.
// The reason to be in the global scope is that some times we have different built files using the same source.
window.senseiStores=window.senseiStores||[];const{senseiStores:s}=window,r=(e,t)=>(n=t,o)=>(e[o.type]||e.DEFAULT)(o,n),i=(e,t)=>{if(s[e])return s[e];const n=(0,o.createReduxStore)(e,t);return(0,o.register)(n),s[e]=n,n};
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
/***/78389:
/***/()=>{}
// extracted by mini-css-extract-plugin
/***/,
/***/79088:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */A:()=>r
/* harmony export */});
/* harmony import */var o=n(62540),s=n(5573);
/* harmony import */const r=(0,o.jsx)(s.SVG,{width:"24",height:"24",fill:"none",xmlns:"http://www.w3.org/2000/svg",children:(0,o.jsx)(s.Path,{fillRule:"evenodd",clipRule:"evenodd",d:"M18.514 9.988l-3.476.016c.627-.626 1.225-1.22 1.82-1.811l.03-.03v-.001c.977-.971 1.944-1.933 3.015-3.004l-1.06-1.06c-1.07 1.069-2.037 2.03-3.013 3.001l-.03.03-1.818 1.809.03-3.449-1.5-.013-.045 5.28-.007.76.76-.004 5.301-.024-.007-1.5zM5.486 14.012l3.477-.016-1.82 1.811-.03.03c-.977.972-1.945 1.934-3.015 3.005l1.06 1.06c1.07-1.068 2.035-2.03 3.012-3V16.9l.03-.03 1.818-1.809-.03 3.449 1.5.013.046-5.28.006-.76-.76.004-5.3.024.006 1.5z",fill:"#fff"})});
/* harmony default export */}
//# sourceMappingURL=minimize.js.map
/***/,
/***/79132:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */A:()=>a
/* harmony export */});
/* harmony import */var o=n(62540),s=n(59885),r=n(65970),i=n(57610);
/* harmony import */
/**
 * Internal dependencies
 */
const a=({onMinimize:e,onDismiss:t,onNextStepProgression:n,onPreviousStepProgression:a,tourContainerRef:c,isMinimized:l})=>(0,s/* ["default"] */.A)(c)?l?(0,o.jsx)((function(){return(0,i/* ["default"] */.A)({onEscape:t("esc-key-minimized")}),null}),{}):(0,o.jsx)((function(){return(0,i/* ["default"] */.A)({onEscape:e,onArrowRight:n,onArrowLeft:a}),(0,r/* ["default"] */.A)(c),null}),{}):null;
/* harmony default export */}
//# sourceMappingURL=keyboard-navigation.js.map
/***/,
/***/79676:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */A:()=>c
/* harmony export */});
/* harmony import */var o=n(62540),s=n(56427),r=n(64624),i=n(91217),a=n(79088);
/* harmony import */const c=({onMinimize:e,onDismiss:t})=>{const{__}=(0,i/* .useI18n */.s9)();return(0,o.jsx)("div",{className:"wpcom-tour-kit-step-card-overlay-controls",children:(0,o.jsxs)(s.Flex,{children:[(0,o.jsx)(s.Button,{label:__("Minimize Tour","default"),variant:"primary",className:"wpcom-tour-kit-step-card-overlay-controls__minimize-icon",icon:a/* ["default"] */.A,iconSize:24,onClick:e}),(0,o.jsx)(s.Button,{label:__("Close Tour","default"),variant:"primary",icon:r/* ["default"] */.A,iconSize:24,onClick:t("close-btn")})]})})};
/* harmony default export */}
//# sourceMappingURL=wpcom-tour-kit-step-card-overlay-controls.js.map
/***/,
/***/81116:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */A:()=>p
/* harmony export */});
/* harmony import */var o=n(68956),s=n(50231),r=n(7130),i=n(95740),a=n(29323),c=n(57127),l=n(89450),u=n(35387),d=n(63458);
/* harmony import */ // eslint-disable-next-line import/no-unused-modules
/* harmony default export */const p={name:"arrow",enabled:!0,phase:"main",fn:function(e){var t,n=e.state,r=e.name,p=e.options,f=n.elements.arrow,m=n.modifiersData.popperOffsets,h=(0,o/* ["default"] */.A)(n.placement),v=(0,a/* ["default"] */.A)(h),g=[d/* .left */.kb,d/* .right */.pG].indexOf(h)>=0?"height":"width";if(f&&m){var b=function(e,t){return e="function"==typeof e?e(Object.assign({},t.rects,{placement:t.placement})):e,(0,l/* ["default"] */.A)("number"!=typeof e?e:(0,u/* ["default"] */.A)(e,d/* .basePlacements */.OM))}(p.padding,n),w=(0,s/* ["default"] */.A)(f),y="y"===v?d/* .top */.Mn:d/* .left */.kb,x="y"===v?d/* .bottom */.sQ:d/* .right */.pG,A=n.rects.reference[g]+n.rects.reference[v]-m[v]-n.rects.popper[g],k=m[v]-n.rects.reference[v],_=(0,i/* ["default"] */.A)(f),C=_?"y"===v?_.clientHeight||0:_.clientWidth||0:0,S=A/2-k/2,j=b[y],O=C-w[g]-b[x],E=C/2-w[g]/2+S,M=(0,c/* .within */.u)(j,E,O),z=v;n.modifiersData[r]=((t={})[z]=M,t.centerOffset=M-E,t)}},effect:function(e){var t=e.state,n=e.options.element,o=void 0===n?"[data-popper-arrow]":n;null!=o&&("string"!=typeof o||(o=t.elements.popper.querySelector(o)))&&(0,r/* ["default"] */.A)(t.elements.popper,o)&&(t.elements.arrow=o);// CSS selector
},requires:["popperOffsets"],requiresIfExists:["preventOverflow"]};
/***/},
/***/81916:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */A:()=>/* binding */c
/* harmony export */});
/* harmony import */var o=n(50780),s=n(71699),r=n(74077),i=n(21042),a=n(39246);
/* harmony import */
// Gets the entire size of the scrollable document area, even extending outside
// of the `<html>` and `<body>` rect bounds if horizontally scrollable
function c(e){var t,n=(0,o/* ["default"] */.A)(e),c=(0,i/* ["default"] */.A)(e),l=null==(t=e.ownerDocument)?void 0:t.body,u=(0,a/* .max */.T9)(n.scrollWidth,n.clientWidth,l?l.scrollWidth:0,l?l.clientWidth:0),d=(0,a/* .max */.T9)(n.scrollHeight,n.clientHeight,l?l.scrollHeight:0,l?l.clientHeight:0),p=-c.scrollLeft+(0,r/* ["default"] */.A)(e),f=-c.scrollTop;return"rtl"===(0,s/* ["default"] */.A)(l||n).direction&&(p+=(0,a/* .max */.T9)(n.clientWidth,l?l.clientWidth:0)-u),{width:u,height:d,x:p,y:f}}
/***/},
/***/82370:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */A:()=>/* binding */a
/* harmony export */});
/* harmony import */var o=n(21042),s=n(32639),r=n(6433),i=n(6061);
/* harmony import */function a(e){return e!==(0,s/* ["default"] */.A)(e)&&(0,r/* .isHTMLElement */.sb)(e)?(0,i/* ["default"] */.A)(e):(0,o/* ["default"] */.A)(e)}
/***/},
/***/83746:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */A:()=>u
/* harmony export */});
/* harmony import */var o=n(50004),s=n(68956),r=n(63095),i=n(93341),a=n(23997),c=n(63458),l=n(11361);
/* harmony import */ // eslint-disable-next-line import/no-unused-modules
/* harmony default export */const u={name:"flip",enabled:!0,phase:"main",fn:function(e){var t=e.state,n=e.options,u=e.name;if(!t.modifiersData[u]._skip){for(var d=n.mainAxis,p=void 0===d||d,f=n.altAxis,m=void 0===f||f,h=n.fallbackPlacements,v=n.padding,g=n.boundary,b=n.rootBoundary,w=n.altBoundary,y=n.flipVariations,x=void 0===y||y,A=n.allowedAutoPlacements,k=t.options.placement,_=(0,s/* ["default"] */.A)(k),C=h||(_===k||!x?[(0,o/* ["default"] */.A)(k)]:
// eslint-disable-next-line import/no-unused-modules
function(e){if((0,s/* ["default"] */.A)(e)===c/* .auto */.qZ)return[];var t=(0,o/* ["default"] */.A)(e);return[(0,r/* ["default"] */.A)(e),t,(0,r/* ["default"] */.A)(t)]}(k)),S=[k].concat(C).reduce((function(e,n){return e.concat((0,s/* ["default"] */.A)(n)===c/* .auto */.qZ?(0,a/* ["default"] */.A)(t,{placement:n,boundary:g,rootBoundary:b,padding:v,flipVariations:x,allowedAutoPlacements:A}):n)}),[]),j=t.rects.reference,O=t.rects.popper,E=new Map,M=!0,z=S[0],F=0;F<S.length;F++){var q=S[F],P=(0,s/* ["default"] */.A)(q),L=(0,l/* ["default"] */.A)(q)===c/* .start */.ni,T=[c/* .top */.Mn,c/* .bottom */.sQ].indexOf(P)>=0,N=T?"width":"height",D=(0,i/* ["default"] */.A)(t,{placement:q,boundary:g,rootBoundary:b,altBoundary:w,padding:v}),R=T?L?c/* .right */.pG:c/* .left */.kb:L?c/* .bottom */.sQ:c/* .top */.Mn;j[N]>O[N]&&(R=(0,o/* ["default"] */.A)(R));var B=(0,o/* ["default"] */.A)(R),I=[];if(p&&I.push(D[P]<=0),m&&I.push(D[R]<=0,D[B]<=0),I.every((function(e){return e}))){z=q,M=!1;break}E.set(q,I)}if(M)for(
// `2` may be desired in some cases – research later
var V=function(e){var t=S.find((function(t){var n=E.get(t);if(n)return n.slice(0,e).every((function(e){return e}))}));if(t)return z=t,"break"},W=x?3:1;W>0;W--){if("break"===V(W))break}t.placement!==z&&(t.modifiersData[u]._skip=!0,t.placement=z,t.reset=!0)}},requiresIfExists:["offset"],data:{_skip:!1}};
/***/},
/***/85840:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */lC:()=>/* binding */c
/* harmony export */});
/* unused harmony exports useBreakpoint, useDesktopBreakpoint, withBreakpoint, withMobileBreakpoint, withDesktopBreakpoint */
/* harmony import */var o=n(70974),s=n(29491),r=n(51609),i=n(62540);
/* harmony import */
/**
 * React hook for getting the status for a breakpoint and keeping it updated.
 * @param {string} breakpoint The breakpoint to consider.
 * @returns {boolean} The current status for the breakpoint.
 */
function a(e){const[t,n]=(0,r.useState)((()=>({isActive:(0,o/* .isWithinBreakpoint */.hO)(e),breakpoint:e})));return(0,r.useEffect)((()=>(0,o/* .subscribeIsWithinBreakpoint */.xV)(e,(function(t){n((n=>
// Ensure we bail out without rendering if nothing changes, by preserving state.
n.isActive===t&&n.breakpoint===e?n:{isActive:t,breakpoint:e}))}))),[e]),e===t.breakpoint?t.isActive:(0,o/* .isWithinBreakpoint */.hO)(e)}
/**
 * React hook for getting the status for the mobile breakpoint and keeping it
 * updated.
 * @returns {boolean} The current status for the breakpoint.
 */function c(){return a(o/* .MOBILE_BREAKPOINT */.Dy)}
/**
 * React hook for getting the status for the desktop breakpoint and keeping it
 * updated.
 * @returns {boolean} The current status for the breakpoint.
 */
/**
 * React higher order component for getting the status for a breakpoint and
 * keeping it updated.
 * @param {string} breakpoint The breakpoint to consider.
 * @returns {Function} A function that given a component returns the
 * wrapped component.
 */
(0,s.createHigherOrderComponent)((e=>(0,r.forwardRef)(((t,n)=>{const s=a(o/* .MOBILE_BREAKPOINT */.Dy);
return(0,i.jsx)(e,{...t,isBreakpointActive:s,ref:n})}))),"WithMobileBreakpoint"),(0,s.createHigherOrderComponent)((e=>(0,r.forwardRef)(((t,n)=>{const s=a(o/* .DESKTOP_BREAKPOINT */.jK);
return(0,i.jsx)(e,{...t,isBreakpointActive:s,ref:n})}))),"WithDesktopBreakpoint")
/**
 * React higher order component for getting the status for the mobile
 * breakpoint and keeping it updated.
 * @param {import('react').Component|Function} Wrapped The component to wrap.
 * @returns {Function} The wrapped component.
 */}
/***/,
/***/86087:
/***/e=>{"use strict";e.exports=window.wp.element}
/***/,
/***/86298:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */A:()=>c
/* harmony export */});
/* harmony import */var o=n(62540),s=n(23891),r=n(95162),i=n(18271),a=n(49777);
/* harmony import */n(78389);const c=({config:e})=>((0,r/* ["default"] */.A)(e.steps),(0/* ["default"] */,o.jsx)(s.A,{__temp__className:"wpcom-tour-kit",config:{...e,renderers:{tourStep:a/* ["default"] */.A,tourMinimized:i/* ["default"] */.A}}}));
/* harmony default export */}
//# sourceMappingURL=wpcom-tour-kit.js.map
/***/,
/***/87063:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */A:()=>a
/* harmony export */});
/* harmony import */var o=n(62540),s=n(69037),r=n(56427),i=n(91217);
/* harmony import */const a=({currentStepIndex:e,onDismiss:t,onGoToStep:n,onNextStep:a,onPreviousStep:c,setInitialFocusedElement:l,steps:u})=>{const{__}=(0,i/* .useI18n */.s9)(),d=0===e,p=u.length-1;return(0,o.jsx)(o.Fragment,{children:(0/* ["default"] */,o.jsx)(s.A,{activePageIndex:e,numberOfPages:p+1,onChange:n,children:d?(0,o.jsxs)("div",{children:[(0,o.jsx)(r.Button,{variant:"tertiary",onClick:t("no-thanks-btn"),children:__("Skip","default")}),(0,o.jsx)(r.Button,{className:"wpcom-tour-kit-step-card-navigation__next-btn",variant:"primary",onClick:a,ref:l,children:__("Take the tour","default")})]}):(0,o.jsxs)("div",{children:[(0,o.jsx)(r.Button,{variant:"tertiary",onClick:c,children:__("Back","default")}),(0,o.jsx)(r.Button,{className:"wpcom-tour-kit-step-card-navigation__next-btn",variant:"primary",onClick:a,ref:l,children:__("Next","default")})]})})})};
/* harmony default export */}
//# sourceMappingURL=wpcom-tour-kit-step-card-navigation.js.map
/***/,
/***/87989:
/***/(e,t,n)=>{
/* eslint-env browser */
/**
 * This is the web browser implementation of `debug()`.
 */
t.formatArgs=
/**
 * Colorize log arguments if enabled.
 *
 * @api public
 */
function(t){if(t[0]=(this.useColors?"%c":"")+this.namespace+(this.useColors?" %c":" ")+t[0]+(this.useColors?"%c ":" ")+"+"+e.exports.humanize(this.diff),!this.useColors)return;const n="color: "+this.color;t.splice(1,0,n,"color: inherit");
// The final "%c" is somewhat tricky, because there could be other
// arguments passed either before or after the %c, so we need to
// figure out the correct index to insert the CSS into
let o=0,s=0;t[0].replace(/%[a-zA-Z%]/g,(e=>{"%%"!==e&&(o++,"%c"===e&&(
// We only are interested in the *last* %c
// (the user may have provided their own)
s=o))})),t.splice(s,0,n)}
/**
 * Invokes `console.debug()` when available.
 * No-op when `console.debug` is not a "function".
 * If `console.debug` is not available, falls back
 * to `console.log`.
 *
 * @api public
 */,t.save=
/**
 * Save `namespaces`.
 *
 * @param {String} namespaces
 * @api private
 */
function(e){try{e?t.storage.setItem("debug",e):t.storage.removeItem("debug")}catch(e){
// Swallow
// XXX (@Qix-) should we be logging these?
}}
/**
 * Load `namespaces`.
 *
 * @return {String} returns the previously persisted debug modes
 * @api private
 */,t.load=function(){let e;try{e=t.storage.getItem("debug")}catch(e){
// Swallow
// XXX (@Qix-) should we be logging these?
}
// If debug isn't set in LS, and we're in Electron, try to load $DEBUG
!e&&"undefined"!=typeof process&&"env"in process&&(e=process.env.DEBUG);return e}
/**
 * Localstorage attempts to return the localstorage.
 *
 * This is necessary because safari throws
 * when a user disables cookies/localstorage
 * and you attempt to access it.
 *
 * @return {LocalStorage}
 * @api private
 */,t.useColors=
/**
 * Currently only WebKit-based Web Inspectors, Firefox >= v31,
 * and the Firebug extension (any Firefox version) are known
 * to support "%c" CSS customizations.
 *
 * TODO: add a `localStorage` variable to explicitly enable/disable colors
 */
// eslint-disable-next-line complexity
function(){
// NB: In an Electron preload script, document will be defined but not fully
// initialized. Since we know we're in Chrome, we'll just detect this case
// explicitly
if("undefined"!=typeof window&&window.process&&("renderer"===window.process.type||window.process.__nwjs))return!0;
// Internet Explorer and Edge do not support colors.
if("undefined"!=typeof navigator&&navigator.userAgent&&navigator.userAgent.toLowerCase().match(/(edge|trident)\/(\d+)/))return!1;
// Is webkit? http://stackoverflow.com/a/16459606/376773
// document is undefined in react-native: https://github.com/facebook/react-native/pull/1632
return"undefined"!=typeof document&&document.documentElement&&document.documentElement.style&&document.documentElement.style.WebkitAppearance||
// Is firebug? http://stackoverflow.com/a/398120/376773
"undefined"!=typeof window&&window.console&&(window.console.firebug||window.console.exception&&window.console.table)||
// Is firefox >= v31?
// https://developer.mozilla.org/en-US/docs/Tools/Web_Console#Styling_messages
"undefined"!=typeof navigator&&navigator.userAgent&&navigator.userAgent.toLowerCase().match(/firefox\/(\d+)/)&&parseInt(RegExp.$1,10)>=31||
// Double check webkit in userAgent just in case we are in a worker
"undefined"!=typeof navigator&&navigator.userAgent&&navigator.userAgent.toLowerCase().match(/applewebkit\/(\d+)/)},t.storage=function(){try{
// TVMLKit (Apple TV JS Runtime) does not have a window object, just localStorage in the global context
// The Browser also has localStorage in the global context.
return localStorage}catch(e){
// Swallow
// XXX (@Qix-) should we be logging these?
}}(),t.destroy=(()=>{let e=!1;return()=>{e||(e=!0,console.warn("Instance method `debug.destroy()` is deprecated and no longer does anything. It will be removed in the next major version of `debug`."))}})(),
/**
 * Colors.
 */
t.colors=["#0000CC","#0000FF","#0033CC","#0033FF","#0066CC","#0066FF","#0099CC","#0099FF","#00CC00","#00CC33","#00CC66","#00CC99","#00CCCC","#00CCFF","#3300CC","#3300FF","#3333CC","#3333FF","#3366CC","#3366FF","#3399CC","#3399FF","#33CC00","#33CC33","#33CC66","#33CC99","#33CCCC","#33CCFF","#6600CC","#6600FF","#6633CC","#6633FF","#66CC00","#66CC33","#9900CC","#9900FF","#9933CC","#9933FF","#99CC00","#99CC33","#CC0000","#CC0033","#CC0066","#CC0099","#CC00CC","#CC00FF","#CC3300","#CC3333","#CC3366","#CC3399","#CC33CC","#CC33FF","#CC6600","#CC6633","#CC9900","#CC9933","#CCCC00","#CCCC33","#FF0000","#FF0033","#FF0066","#FF0099","#FF00CC","#FF00FF","#FF3300","#FF3333","#FF3366","#FF3399","#FF33CC","#FF33FF","#FF6600","#FF6633","#FF9900","#FF9933","#FFCC00","#FFCC33"],t.log=console.debug||console.log||(()=>{}),e.exports=n(51236)(t);const{formatters:o}=e.exports;
/**
 * Map %j to `JSON.stringify()`, since no Web Inspectors do that by default.
 */o.j=function(e){try{return JSON.stringify(e)}catch(e){return"[UnexpectedJSONParseError]: "+e.message}}}
/***/,
/***/89450:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */A:()=>/* binding */s
/* harmony export */});
/* harmony import */var o=n(54664);function s(e){return Object.assign({},(0,o/* ["default"] */.A)(),e)}
/***/},
/***/90551:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */w:()=>/* binding */i
/* harmony export */});
/* unused harmony exports blockNames, blockTypes, syncStructureToBlocks, extractStructure, getCourseInnerBlocks */
/* harmony import */n(74997),n(47143)
/* harmony import */;var o=n(66087);
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
const s={module:"sensei-lms/course-outline-module",lesson:"sensei-lms/course-outline-lesson"},r=(0,o.invert)(s),i=((0,o.curry)(((e,t)=>{const{name:n,attributes:o}=t,s=Object.keys(r).includes(n),i="module"===e.type;return!!s&&(i?[e.title,e.lastTitle].includes(o.title):o.id?e.id===o.id:void 0)})),(e,t)=>{for(let n=0;n<t.length;n++){const o=t[n];if(e===o.name)return o;if(o.innerBlocks&&o.innerBlocks.length>0){const t=i(e,o.innerBlocks);if(t)return t}}return!1})}
/***/,
/***/91217:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */s9:()=>/* binding */a
/* harmony export */});
/* unused harmony exports I18nProvider, withI18n */
/* harmony import */n(51609);
/* harmony import */var o=n(86087),s=n(27723);
/**
 * External dependencies
 */
/**
 * WordPress dependencies
 */
/**
 * Utility to make a new context value
 *
 * @param i18n
 */
function r(e){return{__:e.__.bind(e),_x:e._x.bind(e),_n:e._n.bind(e),_nx:e._nx.bind(e),isRTL:e.isRTL.bind(e),hasTranslation:e.hasTranslation.bind(e)}}const i=(0,o.createContext)(r(s.defaultI18n));
/**
 * The `I18nProvider` should be mounted above any localized components:
 *
 * @example
 * ```js
 * import { createI18n } from '@wordpress/i18n';
 * import { I18nProvider } from '@wordpress/react-i18n';
 * const i18n = createI18n();
 *
 * ReactDom.render(
 * 	<I18nProvider i18n={ i18n }>
 * 		<App />
 * 	</I18nProvider>,
 * 	el
 * );
 * ```
 *
 * You can also instantiate the provider without the `i18n` prop. In that case it will use the
 * default `I18n` instance exported from `@wordpress/i18n`.
 *
 * @param props i18n provider props.
 * @return Children wrapped in the I18nProvider.
 */
/**
 * React hook providing access to i18n functions. It exposes the `__`, `_x`, `_n`, `_nx`,
 * `isRTL` and `hasTranslation` functions from [`@wordpress/i18n`](../i18n).
 * Refer to their documentation there.
 *
 * @example
 * ```js
 * import { useI18n } from '@wordpress/react-i18n';
 *
 * function MyComponent() {
 * 	const { __ } = useI18n();
 * 	return __( 'Hello, world!' );
 * }
 * ```
 */
const a=()=>(0,o.useContext)(i)
/**
 * React higher-order component that passes the i18n translate functions (the same set
 * as exposed by the `useI18n` hook) to the wrapped component as props.
 *
 * @example
 * ```js
 * import { withI18n } from '@wordpress/react-i18n';
 *
 * function MyComponent( { __ } ) {
 * 	return __( 'Hello, world!' );
 * }
 *
 * export default withI18n( MyComponent );
 * ```
 *
 * @param InnerComponent React component to be wrapped and receive the i18n functions like `__`
 * @return The wrapped component
 */}
//# sourceMappingURL=index.js.map
/***/,
/***/91661:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */A:()=>a
/* harmony export */});
/* harmony import */var o=n(63458),s=n(93341);
/* harmony import */function r(e,t,n){return void 0===n&&(n={x:0,y:0}),{top:e.top-t.height-n.y,right:e.right-t.width+n.x,bottom:e.bottom-t.height+n.y,left:e.left-t.width-n.x}}function i(e){return[o/* .top */.Mn,o/* .right */.pG,o/* .bottom */.sQ,o/* .left */.kb].some((function(t){return e[t]>=0}))}// eslint-disable-next-line import/no-unused-modules
/* harmony default export */const a={name:"hide",enabled:!0,phase:"main",requiresIfExists:["preventOverflow"],fn:function(e){var t=e.state,n=e.name,o=t.rects.reference,a=t.rects.popper,c=t.modifiersData.preventOverflow,l=(0,s/* ["default"] */.A)(t,{elementContext:"reference"}),u=(0,s/* ["default"] */.A)(t,{altBoundary:!0}),d=r(l,o),p=r(u,a,c),f=i(d),m=i(p);t.modifiersData[n]={referenceClippingOffsets:d,popperEscapeOffsets:p,isReferenceHidden:f,hasPopperEscaped:m},t.attributes.popper=Object.assign({},t.attributes.popper,{"data-popper-reference-hidden":f,"data-popper-escaped":m})}};
/***/},
/***/91792:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */A:()=>r
/* harmony export */});
/* harmony import */var o=n(32639),s={passive:!0};
// eslint-disable-next-line import/no-unused-modules
// eslint-disable-next-line import/no-unused-modules
/* harmony default export */const r={name:"eventListeners",enabled:!0,phase:"write",fn:function(){},effect:function(e){var t=e.state,n=e.instance,r=e.options,i=r.scroll,a=void 0===i||i,c=r.resize,l=void 0===c||c,u=(0,o/* ["default"] */.A)(t.elements.popper),d=[].concat(t.scrollParents.reference,t.scrollParents.popper);return a&&d.forEach((function(e){e.addEventListener("scroll",n.update,s)})),l&&u.addEventListener("resize",n.update,s),function(){a&&d.forEach((function(e){e.removeEventListener("scroll",n.update,s)})),l&&u.removeEventListener("resize",n.update,s)}},data:{}};
/***/},
/***/92279:
/***/e=>{"use strict";e.exports=window.wp.plugins}
/***/,
/***/93094:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */A:()=>/* binding */a
/* harmony export */});
/* harmony import */var o=n(6433),s=n(39246),r=n(32639),i=n(62871);
/* harmony import */function a(e,t,n){void 0===t&&(t=!1),void 0===n&&(n=!1);var a=e.getBoundingClientRect(),c=1,l=1;t&&(0,o/* .isHTMLElement */.sb)(e)&&(c=e.offsetWidth>0&&(0,s/* .round */.LI)(a.width)/e.offsetWidth||1,l=e.offsetHeight>0&&(0,s/* .round */.LI)(a.height)/e.offsetHeight||1);var u=((0,o/* .isElement */.vq)(e)?(0,r/* ["default"] */.A)(e):window).visualViewport,d=!(0,i/* ["default"] */.A)()&&n,p=(a.left+(d&&u?u.offsetLeft:0))/c,f=(a.top+(d&&u?u.offsetTop:0))/l,m=a.width/c,h=a.height/l;return{width:m,height:h,top:f,right:p+m,bottom:f+h,left:p,x:p,y:f}}
/***/},
/***/93341:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */A:()=>/* binding */p
/* harmony export */});
/* harmony import */var o=n(60751),s=n(50780),r=n(93094),i=n(30427),a=n(42270),c=n(63458),l=n(6433),u=n(89450),d=n(35387);
/* harmony import */
// eslint-disable-next-line import/no-unused-modules
function p(e,t){void 0===t&&(t={});var n=t,p=n.placement,f=void 0===p?e.placement:p,m=n.strategy,h=void 0===m?e.strategy:m,v=n.boundary,g=void 0===v?c/* .clippingParents */.WY:v,b=n.rootBoundary,w=void 0===b?c/* .viewport */.R9:b,y=n.elementContext,x=void 0===y?c/* .popper */.xf:y,A=n.altBoundary,k=void 0!==A&&A,_=n.padding,C=void 0===_?0:_,S=(0,u/* ["default"] */.A)("number"!=typeof C?C:(0,d/* ["default"] */.A)(C,c/* .basePlacements */.OM)),j=x===c/* .popper */.xf?c/* .reference */.ir:c/* .popper */.xf,O=e.rects.popper,E=e.elements[k?j:x],M=(0,o/* ["default"] */.A)((0,l/* .isElement */.vq)(E)?E:E.contextElement||(0,s/* ["default"] */.A)(e.elements.popper),g,w,h),z=(0,r/* ["default"] */.A)(e.elements.reference),F=(0,i/* ["default"] */.A)({reference:z,element:O,strategy:"absolute",placement:f}),q=(0,a/* ["default"] */.A)(Object.assign({},O,F)),P=x===c/* .popper */.xf?q:z,L={top:M.top-P.top+S.top,bottom:P.bottom-M.bottom+S.bottom,left:M.left-P.left+S.left,right:P.right-M.right+S.right},T=e.modifiersData.offset;// Offsets can be applied only to the popper element
if(x===c/* .popper */.xf&&T){var N=T[f];Object.keys(L).forEach((function(e){var t=[c/* .right */.pG,c/* .bottom */.sQ].indexOf(e)>=0?1:-1,n=[c/* .top */.Mn,c/* .bottom */.sQ].indexOf(e)>=0?"y":"x";L[e]+=N[n]*t}))}return L}
/***/},
/***/94601:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */A:()=>r
/* harmony export */});
/* harmony import */var o=n(62540),s=n(5573);
/* harmony import */const r=(0,o.jsx)(s.SVG,{width:"24",height:"24",fill:"none",xmlns:"http://www.w3.org/2000/SVG",children:(0,o.jsx)(s.Path,{fillRule:"evenodd",clipRule:"evenodd",d:"M13.131 4.023a.667.667 0 011.227.416l-.436 4.99h3.88c.954 0 1.64.916 1.37 1.831l-1.753 5.963a.286.286 0 01-.274.206H9.429V9.84l3.702-5.818zM7.714 10v7.428h-2V10h2zm5.98-8c-.814 0-1.572.416-2.01 1.103L8.388 8.286H4v10.857h13.145a2 2 0 001.919-1.436l1.753-5.963a3.143 3.143 0 00-3.015-4.03h-2.01l.274-3.125A2.381 2.381 0 0013.694 2z",fill:"#000"})});
/* harmony default export */}
//# sourceMappingURL=thumbs_up.js.map
/***/,
/***/94715:
/***/e=>{"use strict";e.exports=window.wp.blockEditor}
/***/,
/***/95162:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */A:()=>/* binding */s
/* harmony export */});
/* harmony import */var o=n(86087);
/* harmony import */function s(e){(0,o.useEffect)((()=>{e.forEach((e=>{e.meta.imgSrc?.mobile&&((new window.Image).src=e.meta.imgSrc.mobile.src),e.meta.imgSrc?.desktop&&((new window.Image).src=e.meta.imgSrc.desktop.src)}))}),[e])}
//# sourceMappingURL=use-prefetch-tour-assets.js.map
/***/},
/***/95740:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */A:()=>/* binding */d
/* harmony export */});
/* harmony import */var o=n(32639),s=n(26368),r=n(71699),i=n(6433),a=n(29459),c=n(46063),l=n(31482);
/* harmony import */function u(e){return(0,i/* .isHTMLElement */.sb)(e)&&// https://github.com/popperjs/popper-core/issues/837
// https://github.com/popperjs/popper-core/issues/837
"fixed"!==(0,r/* ["default"] */.A)(e).position?e.offsetParent:null}// `.offsetParent` reports `null` for fixed elements, while absolute elements
// return the containing block
// Gets the closest ancestor positioned element. Handles some edge cases,
// such as table ancestors and cross browser bugs.
function d(e){for(var t=(0,o/* ["default"] */.A)(e),n=u(e);n&&(0,a/* ["default"] */.A)(n)&&"static"===(0,r/* ["default"] */.A)(n).position;)n=u(n);return n&&("html"===(0,s/* ["default"] */.A)(n)||"body"===(0,s/* ["default"] */.A)(n)&&"static"===(0,r/* ["default"] */.A)(n).position)?t:n||function(e){var t=/firefox/i.test((0,l/* ["default"] */.A)());if(/Trident/i.test((0,l/* ["default"] */.A)())&&(0,i/* .isHTMLElement */.sb)(e)&&"fixed"===(0,r/* ["default"] */.A)(e).position)return null;var n=(0,c/* ["default"] */.A)(e);for((0,i/* .isShadowRoot */.Ng)(n)&&(n=n.host);(0,i/* .isHTMLElement */.sb)(n)&&["html","body"].indexOf((0,s/* ["default"] */.A)(n))<0;){var o=(0,r/* ["default"] */.A)(n);// This is non-exhaustive but covers the most common CSS properties that
// create a containing block.
// https://developer.mozilla.org/en-US/docs/Web/CSS/Containing_block#identifying_the_containing_block
if("none"!==o.transform||"none"!==o.perspective||"paint"===o.contain||-1!==["transform","perspective"].indexOf(o.willChange)||t&&"filter"===o.willChange||t&&o.filter&&"none"!==o.filter)return n;n=n.parentNode}return null}(e)||t}
/***/},
/***/96822:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */A:()=>p
/* harmony export */,E:()=>/* binding */d
/* harmony export */});
/* harmony import */var o=n(62540),s=n(86087),r=n(4452),i=n.n(r),a=n(75176),c=n(4650),l=n(62306),u=n(74724);
/* harmony import */const d="wp-tour-kit-spotlit",p=({referenceElement:e,styles:t,interactivity:n,liveResize:r})=>{const[p,f]=(0,s.useState)(null),m=e?.getBoundingClientRect(),h=[{name:"flip",enabled:!1},{name:"preventOverflow",options:{mainAxis:!1}},(0,s.useMemo)((()=>({name:"offset",options:{offset:({placement:e,reference:t,popper:n})=>"bottom"===e?[0,-(t.height+(n.height-t.height)/2)]:[0,0]}})),[]),
// useMemo because https://popper.js.org/react-popper/v2/faq/#why-i-get-render-loop-whenever-i-put-a-function-inside-the-popper-configuration
// useMemo because https://popper.js.org/react-popper/v2/faq/#why-i-get-render-loop-whenever-i-put-a-function-inside-the-popper-configuration
(0,s.useMemo)((()=>(0,c/* .liveResizeModifier */.Y)(r)),[r])],{styles:v,attributes:g}=(0,a/* .usePopper */.E)(e,p,{strategy:"fixed",placement:"bottom",modifiers:h}),b=m?{width:`${m.width}px`,height:`${m.height}px`}:null,w=e?{style:{...b&&b,...v?.popper,...t&&t},...g?.popper}:null;
/**
     * Add a .wp-spotlit class to the referenced element so that we can
     * apply CSS styles to it, for whatever purposes such as interactivity
     */
/**
     * Add a .wp-spotlit class to the referenced element so that we can
     * apply CSS styles to it, for whatever purposes such as interactivity
     */
return(0,s.useEffect)((()=>(e?.classList.add(d),()=>{e?.classList.remove(d)})),[e]),(0,o.jsxs)(o.Fragment,{children:[(0/* .SpotlightInteractivity */,o.jsx)(u.q,{...n}),(0/* ["default"] */,o.jsx)(l.A,{visible:!w}),(0,o.jsx)("div",{className:i()("tour-kit-spotlight",{"is-visible":!!w}),ref:f,...w})]})}}
//# sourceMappingURL=tour-kit-spotlight.js.map
/***/,
/***/97383:
/***/e=>{
/* global Map:readonly, Set:readonly, ArrayBuffer:readonly */
var t="undefined"!=typeof Element,n="function"==typeof Map,o="function"==typeof Set,s="function"==typeof ArrayBuffer&&!!ArrayBuffer.isView;
// Note: We **don't** need `envHasBigInt64Array` in fde es6/index.js
function r(e,i){
// START: fast-deep-equal es6/index.js 3.1.3
if(e===i)return!0;if(e&&i&&"object"==typeof e&&"object"==typeof i){if(e.constructor!==i.constructor)return!1;var a,c,l,u;if(Array.isArray(e)){if((a=e.length)!=i.length)return!1;for(c=a;0!=c--;)if(!r(e[c],i[c]))return!1;return!0}
// START: Modifications:
// 1. Extra `has<Type> &&` helpers in initial condition allow es6 code
//    to co-exist with es5.
// 2. Replace `for of` with es5 compliant iteration using `for`.
//    Basically, take:

//    ```js
//    for (i of a.entries())
//      if (!b.has(i[0])) return false;
//    ```

//    ... and convert to:

//    ```js
//    it = a.entries();
//    while (!(i = it.next()).done)
//      if (!b.has(i.value[0])) return false;
//    ```

//    **Note**: `i` access switches to `i.value`.
if(n&&e instanceof Map&&i instanceof Map){if(e.size!==i.size)return!1;for(u=e.entries();!(c=u.next()).done;)if(!i.has(c.value[0]))return!1;for(u=e.entries();!(c=u.next()).done;)if(!r(c.value[1],i.get(c.value[0])))return!1;return!0}if(o&&e instanceof Set&&i instanceof Set){if(e.size!==i.size)return!1;for(u=e.entries();!(c=u.next()).done;)if(!i.has(c.value[0]))return!1;return!0}
// END: Modifications
if(s&&ArrayBuffer.isView(e)&&ArrayBuffer.isView(i)){if((a=e.length)!=i.length)return!1;for(c=a;0!=c--;)if(e[c]!==i[c])return!1;return!0}if(e.constructor===RegExp)return e.source===i.source&&e.flags===i.flags;
// START: Modifications:
// Apply guards for `Object.create(null)` handling. See:
// - https://github.com/FormidableLabs/react-fast-compare/issues/64
// - https://github.com/epoberezkin/fast-deep-equal/issues/49
if(e.valueOf!==Object.prototype.valueOf&&"function"==typeof e.valueOf&&"function"==typeof i.valueOf)return e.valueOf()===i.valueOf();if(e.toString!==Object.prototype.toString&&"function"==typeof e.toString&&"function"==typeof i.toString)return e.toString()===i.toString();
// END: Modifications
if((a=(l=Object.keys(e)).length)!==Object.keys(i).length)return!1;for(c=a;0!=c--;)if(!Object.prototype.hasOwnProperty.call(i,l[c]))return!1;
// END: fast-deep-equal
// START: react-fast-compare
// custom handling for DOM elements
if(t&&e instanceof Element)return!1;
// custom handling for React/Preact
for(c=a;0!=c--;)if(("_owner"!==l[c]&&"__v"!==l[c]&&"__o"!==l[c]||!e.$$typeof)&&!r(e[l[c]],i[l[c]]))return!1;
// all other properties should be traversed as usual
// END: react-fast-compare
// START: fast-deep-equal
return!0}return e!=e&&i!=i}
// end fast-deep-equal
e.exports=function(e,t){try{return r(e,t)}catch(e){if((e.message||"").match(/stack|recursion/i))
// warn on circular references, don't crash
// browsers give this different errors name and messages:
// chrome/safari: "RangeError", "Maximum call stack size exceeded"
// firefox: "InternalError", too much recursion"
// edge: "Error", "Out of stack space"
return console.warn("react-fast-compare cannot handle circular refs"),!1;
// some other error. we should definitely know about these
throw e}}}
/***/,
/***/97866:
/***/(e,t,n)=>{"use strict";
/* harmony export */n.d(t,{
/* harmony export */A:()=>a
/* harmony export */});
/* harmony import */var o=n(62540),s=n(51609),r=n.n(s);
/* harmony import */class i extends r().Component{state={hasError:!1};static getDerivedStateFromError(){
// Update state so the next render will show the fallback UI.
return{hasError:!0}}componentDidCatch(e,t){
// You can also log the error to an error reporting service
// eslint-disable-next-line no-console
console.error(e,t)}render(){return this.state.hasError?(0,o.jsx)("h1",{children:"Something went wrong."}):this.props.children}}
/* harmony default export */const a=i;
//# sourceMappingURL=error-boundary.js.map
/***/
/******/}},t={};
/************************************************************************/
/******/ // The module cache
/******/
/******/
/******/ // The require function
/******/function n(o){
/******/ // Check if module is in cache
/******/var s=t[o];
/******/if(void 0!==s)
/******/return s.exports;
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
/******/return e[o](r,r.exports,n),r.exports;
/******/}
/******/
/************************************************************************/
/******/ /* webpack/runtime/compat get default export */
/******/
/******/ // getDefaultExport function for compatibility with non-harmony modules
/******/n.n=e=>{
/******/var t=e&&e.__esModule?
/******/()=>e.default
/******/:()=>e
/******/;
/******/return n.d(t,{a:t}),t;
/******/},
/******/ // define getter functions for harmony exports
/******/n.d=(e,t)=>{
/******/for(var o in t)
/******/n.o(t,o)&&!n.o(e,o)&&
/******/Object.defineProperty(e,o,{enumerable:!0,get:t[o]})
/******/;
/******/},
/******/n.o=(e,t)=>Object.prototype.hasOwnProperty.call(e,t)
/******/,
// This entry needs to be wrapped in an IIFE because it needs to be in strict mode.
(()=>{"use strict";
/* unused harmony export default */
/* harmony import */var e=n(47143),t=n(92279),o=n(90551),s=n(833),r=n(45469),i=n(86087),a=n(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
const c="sensei-lesson-tour";function l(){const{quizBlock:t}=(0,e.useSelect)((e=>{const{getBlocks:t}=e("core/block-editor"),n=t();return{quizBlock:(0,o/* .getFirstBlockByName */.w)("sensei-lms/quiz",n)}})),[n]=(0,i.useState)((0,r/* ["default"] */.Ay)());return t?(0/* ["default"] */,a.jsx)(s.A,{trackId:"lesson_quiz_onboarding_step_complete",tourName:c,steps:n,beforeEach:r/* .beforeEach */.rK}):null}(0,t.registerPlugin)(c,{render:()=>(0,a.jsx)(l,{})})})()})
/******/();