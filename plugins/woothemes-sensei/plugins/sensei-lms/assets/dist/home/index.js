/******/(()=>{// webpackBootstrap
/******/var e={
/***/1027:
/***/(e,s,n)=>{"use strict";
/* harmony export */n.d(s,{
/* harmony export */A:()=>r
/* harmony export */});
/* harmony import */var t=n(5573),i=n(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
const r=(0,i.jsx)(t.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24",children:(0,i.jsx)(t.Path,{d:"M16.7 7.1l-6.3 8.5-3.3-2.5-.9 1.2 4.5 3.4L17.9 8z"})});
/* harmony default export */}
//# sourceMappingURL=check.js.map
/***/,
/***/1455:
/***/e=>{"use strict";e.exports=window.wp.apiFetch}
/***/,
/***/1750:
/***/(e,s,n)=>{"use strict";
/* harmony export */n.d(s,{
/* harmony export */A:()=>p
/* harmony export */});
/* harmony import */var t=n(4452),i=n.n(t),r=n(56427),l=n(86087),a=n(1455),o=n.n(a),c=n(52929),d=n(9330),u=n(47959),m=n(54844),h=n(46316),_=n(28625),x=n(62540);
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
 * Hook to update the state to ready when all tasks are completed.
 *
 * @param {boolean} isServerCompleted   Whether tasks were already completed in the server.
 * @param {number}  totalTasks          Number of tasks.
 * @param {number}  totalCompletedTasks Number of completed tasks.
 */
const p=({data:e})=>{const s=Object.values(e.items),n=s.sort(((e,s)=>e.priority-s.priority)),t=n.filter((e=>e.done)),{ready:a,readyError:p}=((e,s,n)=>{const[t,i]=(0,l.useState)(e),[r,a]=(0,l.useState)(!1);return(0,l.useEffect)((()=>{t||n!==s||setTimeout((()=>{o()({path:"/sensei-internal/v1/home/tasks/complete",method:"POST"}).then((()=>{i(!0)})).catch((e=>{a(e)}))}),1500)}),[s,n,t]),{ready:t,readyError:r}})(e.is_completed,s.length,t.length),{dismissed:g,onDismiss:v}=(()=>{const[e,s]=(0,l.useState)(!1);return{dismissed:e,onDismiss:()=>{s(!0)}}})(),{colRef:f,colStyle:j}=(()=>{const e=(0,l.useRef)(),[s,n]=(0,l.useState)({});return(0,l.useEffect)((()=>{e.current&&n({overflow:"hidden",maxHeight:e.current.offsetHeight})}),[]),{colRef:e,colStyle:s}})();if(window.sensei_home.tasks_dismissed)return null;let w;return w=p?(0,x.jsx)(r.Notice,{status:"error",isDismissible:!1,children:p.message}):a?(0/* ["default"] */,x.jsx)(_.A,{coursePermalink:e.course?.permalink,onDismiss:v}):(0,x.jsxs)(x.Fragment,{children:[(0,x.jsxs)("div",{className:"sensei-home-tasks-section__content",children:[(0/* ["default"] */,x.jsx)(u.A,{totalTasks:s.length,completedTasks:t.length}),(0/* ["default"] */,x.jsx)(m.A,{items:n})]}),(0,x.jsx)("div",{className:"sensei-home-tasks-section__first-course",children:(0/* ["default"] */,x.jsx)(h.A,{siteTitle:e.site?.title,siteImage:e.site?.image,courseTitle:e.course?.title,courseImage:e.course?.image})})]}),(0/* .Col */,x.jsx)(c.f,{as:"section",className:i()("sensei-home__section",{"sensei-home__section--dismissed":g}),cols:12,ref:f,style:j,children:(0/* ["default"] */,x.jsx)(d.A,{className:i()("sensei-home-tasks-section",{"sensei-home-tasks-section--ready":a}),insideClassName:"sensei-home-tasks-section__inside",children:w})})};
/**
 * Dismiss hook.
 *
 * @return {{dismissed:boolean, onDismiss:Function}} Object with dismissed and onDismiss callback.
 */}
/***/,
/***/2192:
/***/(e,s,n)=>{"use strict";
/**
 * @license React
 * react-jsx-runtime.production.min.js
 *
 * Copyright (c) Facebook, Inc. and its affiliates.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */var t=n(51609),i=Symbol.for("react.element"),r=Symbol.for("react.fragment"),l=Object.prototype.hasOwnProperty,a=t.__SECRET_INTERNALS_DO_NOT_USE_OR_YOU_WILL_BE_FIRED.ReactCurrentOwner,o={key:!0,ref:!0,__self:!0,__source:!0};function c(e,s,n){var t,r={},c=null,d=null;for(t in void 0!==n&&(c=""+n),void 0!==s.key&&(c=""+s.key),void 0!==s.ref&&(d=s.ref),s)l.call(s,t)&&!o.hasOwnProperty(t)&&(r[t]=s[t]);if(e&&e.defaultProps)for(t in s=e.defaultProps)void 0===r[t]&&(r[t]=s[t]);return{$$typeof:i,type:e,key:c,ref:d,props:r,_owner:a.current}}s.Fragment=r,s.jsx=c,s.jsxs=c}
/***/,
/***/4452:
/***/(e,s)=>{var n;
/*!
	Copyright (c) 2018 Jed Watson.
	Licensed under the MIT License (MIT), see
	http://jedwatson.github.io/classnames
*/
/* global define */!function(){"use strict";var t={}.hasOwnProperty;function i(){for(var e="",s=0;s<arguments.length;s++){var n=arguments[s];n&&(e=l(e,r(n)))}return e}function r(e){if("string"==typeof e||"number"==typeof e)return e;if("object"!=typeof e)return"";if(Array.isArray(e))return i.apply(null,e);if(e.toString!==Object.prototype.toString&&!e.toString.toString().includes("[native code]"))return e.toString();var s="";for(var n in e)t.call(e,n)&&e[n]&&(s=l(s,n));return s}function l(e,s){return s?e?e+" "+s:e+s:e}e.exports?(i.default=i,e.exports=i):void 0===(n=function(){return i}.apply(s,[]))||(e.exports=n)}()}
/***/,
/***/5075:
/***/(e,s,n)=>{"use strict";
/* harmony export */n.d(s,{
/* harmony export */A:()=>a
/* harmony export */});
/* harmony import */var t=n(27723),i=n(9330),r=n(71921),l=n(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Latest News section component.
 *
 * @param {Object} props
 * @param {Object} props.data
 */
const a=({data:e})=>e?(0/* ["default"] */,l.jsxs)(i.A,{title:(0,t.__)("Latest News","sensei-lms"),className:"sensei-home-latest-news",children:[(0,l.jsx)("ul",{children:e.items.map(((e,s)=>(0,l.jsxs)("li",{children:[(0/* ["default"] */,l.jsx)(r.A,{label:e.title,url:e.url}),(0,l.jsx)("div",{className:"sensei-home-latest-news__date",children:e.date})]},s)))}),e.more_url&&(0,l.jsx)("div",{className:"sensei-home-latest-news__more-link",children:(0/* ["default"] */,l.jsx)(r.A,{label:(0,t.__)("See more","sensei-lms"),url:e.more_url})})]}):null;
/* harmony default export */}
/***/,
/***/5573:
/***/e=>{"use strict";e.exports=window.wp.primitives}
/***/,
/***/9330:
/***/(e,s,n)=>{"use strict";
/* harmony export */n.d(s,{
/* harmony export */A:()=>a
/* harmony export */});
/* harmony import */var t=n(4452),i=n.n(t),r=n(62540);
/* harmony import */
/**
 * External dependencies
 */
/**
 * Renders the section title, or null if there's no section title.
 *
 * @param {Object}           props       Component props.
 * @param {string|undefined} props.title The title of the section, if defined.
 */
const l=({title:e})=>e?(0,r.jsx)("div",{className:"postbox-header",children:(0,r.jsx)("h2",{className:"hndle",children:e})}):null,a=({className:e,insideClassName:s,title:n,children:t})=>(0,r.jsxs)("div",{className:i()("postbox",e),children:[(0,r.jsx)(l,{title:n}),(0,r.jsx)("div",{className:i()("inside",s),children:t})]});
/**
 * Component that looks like a metabox, but it's not a metabox.
 *
 * @param {Object}       props                 Component props.
 * @param {string}       props.className       Wrapper class name.
 * @param {string}       props.insideClassName Inside class name.
 * @param {string}       props.title           Section title.
 * @param {Object|Array} props.children        Section content.
 */}
/***/,
/***/12417:
/***/(e,s,n)=>{"use strict";
/* harmony export */n.d(s,{
/* harmony export */A:()=>i
/* harmony export */});
/* harmony import */var t=n(86087);
/* harmony import */
/* harmony default export */const i=(0,t.forwardRef)((
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
function({icon:e,size:s=24,...n},i){return(0,t.cloneElement)(e,{width:s,height:s,...n,ref:i})}));
//# sourceMappingURL=index.js.map
/***/},
/***/12980:
/***/(e,s,n)=>{"use strict";
/* harmony export */n.d(s,{
/* harmony export */A:()=>a
/* harmony export */});
/* harmony import */var t=n(27723),i=n(48597),r=n(66863),l=n(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
const a=()=>(0,l.jsx)("header",{children:(0,l.jsxs)("h1",{className:"wp-heading-inline sensei-home-title",children:[(0,l.jsx)("span",{className:"screen-reader-text",children:(0,t.__)("Sensei","sensei-lms")}),(0/* ["default"] */,l.jsx)(i.A,{className:"sensei-home-title__logo"}),(0/* ["default"] */,l.jsx)(r.A,{className:"sensei-home-title__logotype"})]})})
/* harmony default export */}
/***/,
/***/13296:
/***/(e,s,n)=>{"use strict";
/* harmony export */n.d(s,{
/* harmony export */$:()=>/* binding */t
/* harmony export */,J:()=>/* binding */r
/* harmony export */});
/**
 * Add UTM codes to url for SenseiLMS.com.
 *
 * @param {string} url
 * @return {string} The url with UTMs added.
 */
const t=e=>{try{const s=new URL(e);return"senseilms.com"!==s.hostname||s.searchParams.has("utm_source")||s.searchParams.has("utm_medium")||s.searchParams.has("utm_campaign")||(s.searchParams.set("utm_source","plugin_sensei"),s.searchParams.set("utm_medium","upsell"),s.searchParams.set("utm_campaign","sensei_home")),s.toString()}catch{return e}},i=e=>{const s=document.createElement("a");return s.href=e,s.hostname},r=e=>i(window.location)!==i(e);
/**
 * Return hostname for a given URL.
 *
 * @param {string} url URL to parse.
 * @return {string} The hostname for the given URL.
 */}
/***/,
/***/16012:
/***/(e,s,n)=>{"use strict";
/* harmony export */n.d(s,{
/* harmony export */A:()=>l
/* harmony export */});
/* harmony import */var t,i=n(51609);
/* harmony import */function r(){return r=Object.assign?Object.assign.bind():function(e){for(var s=1;s<arguments.length;s++){var n=arguments[s];for(var t in n)({}).hasOwnProperty.call(n,t)&&(e[t]=n[t])}return e},r.apply(null,arguments)}
/* harmony default export */const l=function(e){
return i.createElement("svg",r({viewBox:"0 0 24 24",xmlns:"http://www.w3.org/2000/svg"},e),t||(t=i.createElement("path",{d:"M9 18.6 3.5 13l1-1L9 16.4l9.5-9.9 1 1z",fill:"currentColor"})))};
/***/},
/***/17038:
/***/(e,s,n)=>{"use strict";
/* harmony export */n.d(s,{
/* harmony export */A:()=>m
/* harmony export */});
/* harmony import */var t=n(27723),i=n(56427),r=n(47143),l=n(52929),a=n(87675),o=n(9330),c=n(45793),d=n(13296),u=n(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Extensions section component.
 */
const m=()=>{const{extensions:e,isExtensionsLoading:s}=(0,r.useSelect)((e=>{const s=e(c/* .EXTENSIONS_STORE */.z);return{isExtensionsLoading:!s.hasFinishedResolution("getExtensions"),extensions:s.getExtensions().filter((e=>"sensei-pro"!==e.product_slug))}}),[]);return s?(0,u.jsx)("div",{className:"sensei-home__loader",children:(0,u.jsx)(i.Spinner,{})}):0===e.length?null:(0/* ["default"] */,u.jsx)(o.A,{title:(0,t.__)("Extensions","sensei-lms"),children:(0/* .Grid */,u.jsx)(l.x,{children:e.map((e=>(e.link&&(e.link=(0,d/* .addUtms */.$)(e.link)),(0/* .Col */,u.jsx)(l.f,{className:"sensei-extensions__card-wrapper",cols:4,children:(0/* ["default"] */,u.jsx)(a.A,{...e})},e.product_slug))))})})};
/* harmony default export */}
/***/,
/***/18537:
/***/e=>{"use strict";e.exports=window.wp.htmlEntities}
/***/,
/***/18680:
/***/e=>{"use strict";e.exports="assets/dist/images/sensei-pro-ad-stars-7331781ebe5bf9253c94.png"}
/***/,
/***/25516:
/***/(e,s,n)=>{"use strict";
/* harmony export */n.d(s,{
/* harmony export */A:()=>l
/* harmony export */});
/* harmony import */var t,i=n(51609);
/* harmony import */function r(){return r=Object.assign?Object.assign.bind():function(e){for(var s=1;s<arguments.length;s++){var n=arguments[s];for(var t in n)({}).hasOwnProperty.call(n,t)&&(e[t]=n[t])}return e},r.apply(null,arguments)}
/* harmony default export */const l=function(e){
return i.createElement("svg",r({viewBox:"0 0 24 24",fill:"none",xmlns:"http://www.w3.org/2000/svg"},e),t||(t=i.createElement("path",{fillRule:"evenodd",clipRule:"evenodd",d:"M19.125 8h-1.188V5.714C17.938 2.56 15.277 0 12 0S6.062 2.56 6.062 5.714V8H4.875C3.569 8 2.5 9.029 2.5 10.286v11.428C2.5 22.971 3.569 24 4.875 24h14.25c1.306 0 2.375-1.029 2.375-2.286V10.286C21.5 9.029 20.431 8 19.125 8ZM8.438 5.714c0-1.897 1.59-3.428 3.562-3.428 1.971 0 3.563 1.531 3.563 3.428V8H8.438V5.714Zm-3.563 16h14.25V10.286H4.875v11.428Z",fill:"currentColor"})))};
/***/},
/***/27723:
/***/e=>{"use strict";e.exports=window.wp.i18n}
/***/,
/***/28625:
/***/(e,s,n)=>{"use strict";
/* harmony export */n.d(s,{
/* harmony export */A:()=>u
/* harmony export */});
/* harmony import */var t=n(27723),i=n(56427),r=n(56009),l=n(16012),a=n(55338),o=n(57384),c=n(58663),d=n(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Tasks ready component.
 *
 * @param {Object}   props                 Component props.
 * @param {string}   props.coursePermalink Course permalink.
 * @param {Function} props.onDismiss       Dismiss callback.
 */
const u=({coursePermalink:e,onDismiss:s})=>{const n=encodeURIComponent(e),u=`https://www.facebook.com/sharer/sharer.php?u=${n}`,m=(0,t.sprintf)("https://www.tumblr.com/widgets/share/tool?posttype=link&caption=%1$s&content=%2$s&canonicalUrl=%2$s",(0,t.__)("My new course is ready!","sensei-lms"),n),h=`https://twitter.com/intent/tweet?text=${(0,t.sprintf)(
// translators: placeholder is the share link.
// translators: placeholder is the share link.
(0,t.__)("My new course is ready! Check it here: %s","sensei-lms"),n)}`;
// Prepare social media links.
return(0,d.jsxs)("div",{role:"alert",className:"sensei-home-ready",children:[(0,d.jsx)("button",{className:"sensei-home-ready__dismiss",title:(0,t.__)("Dismiss tasks","sensei-lms"),onClick:()=>{s();const e=new window.FormData;e.append("_wpnonce",window.sensei_home.dismiss_tasks_nonce),e.append("action","sensei_home_tasks_dismiss"),window.fetch(window.ajaxurl,{method:"POST",body:e})},children:(0,d.jsx)(i.Icon,{icon:r/* ["default"] */.A})}),(0,d.jsx)("div",{className:"sensei-home-ready__check-icon",children:(0/* ["default"] */,d.jsx)(l.A,{})}),(0,d.jsx)("p",{className:"sensei-home-ready__text",children:(0,t.__)("Your new course is ready to meet its students! Share it with the world.","sensei-lms")}),(0,d.jsxs)("ul",{className:"sensei-home-ready__social-links",children:[(0,d.jsx)("li",{children:(0,d.jsxs)("a",{className:"sensei-home-ready__social-link",href:u,target:"_blank",rel:"noreferrer",children:[(0/* ["default"] */,d.jsx)(a.A,{}),(0,d.jsx)("span",{className:"screen-reader-text",children:(0,t.__)("Facebook","sensei-lms")})]})}),(0,d.jsx)("li",{children:(0,d.jsxs)("a",{className:"sensei-home-ready__social-link",href:h,target:"_blank",rel:"noreferrer",children:[(0/* ["default"] */,d.jsx)(c.A,{}),(0,d.jsx)("span",{className:"screen-reader-text",children:(0,t.__)("Twitter","sensei-lms")})]})}),(0,d.jsx)("li",{children:(0,d.jsxs)("a",{className:"sensei-home-ready__social-link",href:m,target:"_blank",rel:"noreferrer",children:[(0/* ["default"] */,d.jsx)(o.A,{}),(0,d.jsx)("span",{className:"screen-reader-text",children:(0,t.__)("Tumblr","sensei-lms")})]})})]})]})};
/* harmony default export */}
/***/,
/***/29182:
/***/(e,s,n)=>{"use strict";
/* harmony export */n.d(s,{
/* harmony export */A:()=>d
/* harmony export */,E:()=>/* binding */u
/* harmony export */});
/* harmony import */var t=n(27723),i=n(47143),r=n(56427),l=n(1027),a=n(45793),o=n(79966),c=n(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Extension actions component.
 *
 * @param {Object} props         Component props.
 * @param {Array}  props.actions Actions array containing objects with props for link or button.
 */
const d=({actions:e})=>(0,c.jsx)("ul",{className:"sensei-home__card__extension-actions",children:e.map((({key:e,children:s,...n})=>(0,c.jsx)("li",{className:"sensei-home__card__extension-actions__item",children:(0,c.jsx)(r.Button,{isPrimary:!n.href,isSecondary:!!n.href,...n,children:s})},e)))})
/* harmony default export */,u=e=>{const{installExtension:s,updateExtensions:n}=(0/* .EXTENSIONS_STORE */,i.useDispatch)(a.z);if(!e.product_slug)return null;let r={key:"main-button"};if((0,a/* .isLoadingStatus */.R)(e.status))r={children:(0,t.__)("In progress…","sensei-lms"),className:"sensei-home__rotating-icon",icon:o/* ["default"] */.A,disabled:!0,...r};else if(e.has_update)r={children:(0,t.__)("Update","sensei-lms"),onClick:()=>n([e.product_slug]),disabled:!e.can_update,...r};else if(e.is_installed)r={children:(0,t.__)("Installed","sensei-lms"),icon:l/* ["default"] */.A,disabled:!0,...r};else{const n="0"!==e.price&&0!==e.price?e.price:(0,t.__)("Free","sensei-lms");r={children:`${(0,t.__)("Install","sensei-lms")} - ${n}`,onClick:()=>{s(e.product_slug)},...r}}let c=[r];const d=e.is_installed&&e.has_update?e.changelog_url:e.link;return d&&(c=[...c,{key:"more-details",href:d,target:"_blank",rel:"noreferrer external",children:(0,t.__)("More details","sensei-lms")}]),c}}
/***/,
/***/29661:
/***/(e,s,n)=>{"use strict";
/* harmony export */n.d(s,{
/* harmony export */A:()=>u
/* harmony export */});
/* harmony import */var t=n(27723),i=n(47143),r=n(45793),l=n(52929),a=n(53772),o=n(18680),c=n(96516),d=n(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Sensei Pro Ad to be shown on Sensei Home.
 *
 * @param {boolean} show Whether to show or not the ad.
 */
const u=({show:e})=>{const{senseiProExtension:s}=(0,i.useSelect)((e=>({senseiProExtension:e(r/* .EXTENSIONS_STORE */.z).getSenseiProExtension()})),[]);return s&&e?(0/* .Col */,d.jsx)(l.f,{as:"section",className:"sensei-home__section",cols:12,children:(0,d.jsxs)("article",{className:"sensei-home__sensei-pro-ad",children:[(0,d.jsx)("section",{className:"sensei-home__sensei-pro-ad__column",children:(0,d.jsxs)("div",{className:"sensei-home__sensei-pro-ad__content",children:[(0,d.jsx)("header",{className:"sensei-home__sensei-pro-ad__header",children:(0,d.jsx)("h2",{className:"sensei-home__sensei-pro-ad__title",children:(0,t.__)("Better courses with Sensei Pro","sensei-lms")})}),(0,d.jsxs)("div",{className:"sensei-home__sensei-pro-ad__description",children:[(0,d.jsx)("p",{children:(0,t.__)("Get everything you need to sell courses and take your lessons to the next level.","sensei-lms")}),(0,d.jsxs)("div",{className:"sensei-home__sensei-pro-ad__price",children:[(0,d.jsx)("h3",{className:"sensei-home__sensei-pro-ad__price__title",children:(0,t.sprintf)(
// translators: placeholder is the price.
// translators: placeholder is the price.
(0,t.__)("%s USD","sensei-lms"),s.price.replace(".00",""))}),(0,d.jsx)("p",{children:(0,t.__)("per year, 1 site","sensei-lms")})]}),(0,d.jsxs)("ul",{children:[(0,d.jsx)("li",{children:(0,t.__)("Sell courses with WooCommerce","sensei-lms")}),(0,d.jsx)("li",{children:(0,t.__)("Schedule and drip courses and lessons","sensei-lms")}),(0,d.jsx)("li",{children:(0,t.__)("Manage groups and cohorts","sensei-lms")}),(0,d.jsx)("li",{children:(0,t.__)("Create interactive videos and lessons","sensei-lms")}),(0,d.jsx)("li",{children:(0,t.__)("Add advanced quiz features","sensei-lms")}),(0,d.jsx)("li",{children:(0,t.__)("Contact our experts for help","sensei-lms")})]}),(0,d.jsx)("a",{href:(0,c/* .getSenseiProCheckoutUrl */.u)("home"),target:"_blank",rel:"noreferrer external",className:"sensei-home__sensei-pro-ad__button is-primary is-large components-button",children:(0,t.__)("Get Sensei Pro","sensei-lms")}),(0,d.jsx)("a",{href:(0,c/* .getSenseiProUpsellUrl */.h)("home"),target:"_blank",rel:"noreferrer external",className:"sensei-home__sensei-pro-ad__button is-secondary is-large components-button",children:(0,t.__)("Learn More","sensei-lms")})]})]})}),(0,d.jsx)("section",{className:"sensei-home__sensei-pro-ad__column","aria-hidden":"true",children:(0,d.jsxs)("div",{className:"sensei-home__sensei-pro-ad__card",children:[(0,d.jsx)("img",{src:window.sensei.pluginUrl+a,alt:(0,t.__)("Photo of Gonzalo de la Campa smiling","sensei-lms"),className:"sensei-home__sensei-pro-ad__card--image"}),(0,d.jsx)("blockquote",{className:"sensei-home__sensei-pro-ad__card--quote",children:(0,t.__)("Thanks to Sensei Pro, I have been able to generate recurring income every month.","sensei-lms")}),(0,d.jsxs)("div",{className:"sensei-home__sensei-pro-ad__card--author",children:["Gonzalo de la Campa |"," ",(0,t.__)("WordPress Educator","sensei-lms"),(0,d.jsx)("img",{src:window.sensei.pluginUrl+o,alt:(0,t.__)("Image containing five stars, representing the rating of the plugin","sensei-lms"),className:"sensei-home__sensei-pro-ad__card--stars"})]})]})})]})}):null};
/* harmony default export */}
/***/,
/***/32406:
/***/(e,s,n)=>{"use strict";
/* harmony export */n.d(s,{
/* harmony export */DN:()=>/* binding */t
/* harmony export */});
/* unused harmony exports API_SPECIAL_ACTIVE_JOB_ID, FETCH_FROM_API, WAIT, START_LOAD_CURRENT_JOB_STATE, SUCCESS_LOAD_CURRENT_JOB_STATE, ERROR_LOAD_CURRENT_JOB_STATE, SET_JOB_STATE, START_IMPORT, SUCCESS_START_IMPORT, ERROR_START_IMPORT, START_UPLOAD_IMPORT_DATA_FILE, SUCCESS_UPLOAD_IMPORT_DATA_FILE, ERROR_UPLOAD_IMPORT_DATA_FILE, START_DELETE_IMPORT_DATA_FILE, SUCCESS_DELETE_IMPORT_DATA_FILE, ERROR_DELETE_IMPORT_DATA_FILE, SET_IMPORT_LOG, ERROR_FETCH_IMPORT_LOG, RESET_STATE */
/**
 * Data import constants.
 */
const t="/sensei-internal/v1/import/"}
/***/,
/***/32524:
/***/(e,s,n)=>{"use strict";
/* harmony export */n.d(s,{
/* harmony export */A:()=>_
/* harmony export */});
/* harmony import */var t=n(86087),i=n(4452),r=n.n(i),l=n(78661),a=n(71921),o=n(62540);
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
const c="sensei-notice--is-hidden",d=({action:e})=>{var s,n;if(!e||!e.label||!e.url&&!e.tasks)return null;const i=null===(s=e.primary)||void 0===s||s?"button-primary":"button-secondary",l={};return e.tasks&&(l["data-sensei-notice-tasks"]=JSON.stringify(e.tasks)),(0,o.jsx)("a",{href:e.url,target:null!==(n=e.target)&&void 0!==n?n:"_self",rel:"noopener noreferrer",className:r()("button",i),...l,children:(0,o.jsx)(t.RawHTML,{children:e.label})})},u=({actions:e})=>e&&Array.isArray(e)&&e.length?(0,o.jsx)("div",{className:"sensei-notice__actions",children:e.map((e=>(0,o.jsx)(d,{action:e},e.label)))}):null,m=({infoLink:e})=>{if(!e)return null;const s={};return e.tasks&&(s["sensei-notice-tasks"]=JSON.stringify(e.tasks)),(0/* ["default"] */,o.jsx)(a.A,{label:e.label,url:e.url,dataSet:s})},h=({noticeId:e,notice:s,dismissNonce:n})=>{let i="";s.level&&(i="sensei-notice--"+s.level);const a=s.dismissible&&n,{parent_id:d}=s,h={className:r()("notice","sensei-notice",i,{"is-dismissible":a,[c]:!!d}),"data-sensei-notice-id":e};a&&(h["data-dismiss-action"]="sensei_dismiss_notice",h["data-dismiss-notice"]=null!=d?d:e,h["data-dismiss-nonce"]=n);const _=(s.heading?`<div class="sensei-notice__heading">${s.heading}</div>`:"")+s.message;
return(0,o.jsxs)("div",{...h,children:[(0,o.jsxs)("div",{className:"sensei-notice__content",children:[(0/* ["default"] */,o.jsx)(l.A,{className:"sensei-notice__icon"}),(0,o.jsx)(t.RawHTML,{children:_})]}),(0,o.jsx)(m,{infoLink:s.info_link}),(0,o.jsx)(u,{actions:s.actions})]})},_=({notices:e,dismissNonce:s})=>(0,o.jsx)(o.Fragment,{children:Object.entries(e).map((([e,n])=>(0,o.jsx)(h,{notice:n,noticeId:e,dismissNonce:s},e)))});
/**
 * Component to render an action of a given notice.
 *
 * @param {Object} props        Component props.
 * @param {Object} props.action The action to render.
 */}
/***/,
/***/34198:
/***/(e,s,n)=>{"use strict";
/* harmony export */n.d(s,{
/* harmony export */$:()=>/* binding */t
/* harmony export */});
/* unused harmony export logLink */
/**
 * Send log event.
 *
 * @param {string} eventName  Event name.
 * @param {Array}  properties Event properties.
 */
const t=(e,s)=>{window.sensei_log_event(e,s)};
/**
 * Enable or disable event logging.
 *
 * @param {boolean} enabled Enabled state.
 */t.enable=e=>{window.sensei_event_logging.enabled=e}}
/***/,
/***/34629:
/***/(e,s,n)=>{"use strict";
/* harmony export */n.d(s,{
/* harmony export */A:()=>_
/* harmony export */});
/* harmony import */var t=n(27723),i=n(86087),r=n(18537),l=n(9330),a=n(52929),o=n(71921),c=n(58688),d=n(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
const u={"sensei://install-demo-course":c/* ["default"] */.A},m=({item:e})=>{let{url:s,title:n}=e,t=null;const[l,a]=(0,i.useState)(!1),[c,m]=(0,i.useState)(!1),h=u[s];return h&&(s="#",t=e=>{e.preventDefault(),a(!0)}),c?null:(0,d.jsx)("li",{children:l?(0,d.jsx)(h,{restoreLink:()=>a(!1),remove:()=>m(!0)}):(0/* ["default"] */,d.jsx)(o.A,{url:s,onClick:t,label:(0,r.decodeEntities)(n)})})},h=({data:e})=>(0,d.jsxs)(d.Fragment,{children:[(0,d.jsx)("h3",{className:"sensei-home__quick-links__title",children:e.title}),(0,d.jsx)("ul",{children:e.items.map((e=>(0,d.jsx)(m,{item:e},e.url)))})]})
/**
 * Returns an array with the column size of a given set of columns, distributed over a given total.
 *
 * @param {number} columnCount The number of columns to return the size for.
 * @param {number} columnTotal The total size of the columns. By default, it's 12.
 * @return {number[]} An array containing the sizes of each column.
 */,_=({quickLinks:e})=>{var s;const n=((e,s=12)=>{const n=Math.floor(e?s/e:0),t=new Array(e).fill(n);return t[t.length-1]+=s%n,t})(null!==(s=e?.length)&&void 0!==s?s:0);
return(0/* ["default"] */,d.jsx)(l.A,{title:(0,t.__)("Quick Links","sensei-lms"),className:"sensei-home__quick-links",children:(0/* .Grid */,d.jsx)(a.x,{children:n.map(((s,n)=>(0/* .Col */,d.jsx)(a.f,{cols:s,children:(0,d.jsx)(h,{data:e[n]})},e[n].title)))})})};
/**
 * Component that shows a Quick Link.
 *
 * @param {Object} props      Component props.
 * @param {Object} props.item The item to show.
 */}
/***/,
/***/40427:
/***/(e,s,n)=>{"use strict";
/* harmony export */n.d(s,{
/* harmony export */A:()=>l
/* harmony export */});
/* harmony import */var t,i=n(51609);
/* harmony import */function r(){return r=Object.assign?Object.assign.bind():function(e){for(var s=1;s<arguments.length;s++){var n=arguments[s];for(var t in n)({}).hasOwnProperty.call(n,t)&&(e[t]=n[t])}return e},r.apply(null,arguments)}
/* harmony default export */const l=function(e){
return i.createElement("svg",r({viewBox:"0 0 24 24",fill:"none",xmlns:"http://www.w3.org/2000/svg"},e),t||(t=i.createElement("path",{d:"m10 7 5 5.5-5 5.5",stroke:"currentColor",strokeWidth:1.5})))};
/***/},
/***/44420:
/***/(e,s,n)=>{"use strict";
/* harmony export */n.d(s,{
/* harmony export */A:()=>r
/* harmony export */});
/* harmony import */var t=n(5573),i=n(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
const r=(0,i.jsx)(t.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24",children:(0,i.jsx)(t.Path,{d:"M12 4.75a7.25 7.25 0 100 14.5 7.25 7.25 0 000-14.5zM3.25 12a8.75 8.75 0 1117.5 0 8.75 8.75 0 01-17.5 0zM12 8.75a1.5 1.5 0 01.167 2.99c-.465.052-.917.44-.917 1.01V14h1.5v-.845A3 3 0 109 10.25h1.5a1.5 1.5 0 011.5-1.5zM11.25 15v1.5h1.5V15h-1.5z"})});
/* harmony default export */}
//# sourceMappingURL=help.js.map
/***/,
/***/44656:
/***/(e,s,n)=>{"use strict";
/* harmony export */n.d(s,{
/* harmony export */A:()=>_
/* harmony export */});
/* harmony import */var t=n(4452),i=n.n(t),r=n(27723),l=n(12417),a=n(44420),o=n(9330),c=n(25516),d=n(71921),u=n(62540);
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
 * Component representing each of the items under a Help Category.
 *
 * @param {Object}      props           Component properties.
 * @param {string}      props.title     The title.
 * @param {string|null} props.url       Optional url. When missing the title will not be clickable.
 * @param {Object|null} props.extraLink An extra link that will be displayed next to the main title.
 */
const m=({title:e,url:s,extraLink:n})=>{const t=null!==s;
return(0,u.jsxs)("li",{className:"sensei-home__help-item",children:[(0,u.jsx)("div",{className:"sensei-home__help-item__icon",children:t?(0/* ["default"] */,u.jsx)(l.A,{icon:a/* ["default"] */.A}):(0/* ["default"] */,u.jsx)(c.A,{className:"sensei-home__help-item__icon__lock"})}),(0,u.jsxs)("div",{className:i()("sensei-home__help-item__title",{"sensei-home__help-item__title--disabled":!t}),children:[t?(0/* ["default"] */,u.jsx)(d.A,{label:e,url:s}):(0,u.jsx)("span",{children:e}),n&&(0/* ["default"] */,u.jsx)(d.A,{label:n.label,url:n.url})]})]})},h=({title:e,items:s})=>(0,u.jsxs)("div",{className:"sensei-home__help-category",children:[(0,u.jsx)("h3",{children:e}),(0,u.jsx)("ul",{children:s.map(((e,s)=>(0,u.jsx)(m,{title:e.title,url:e.url,icon:e.icon,extraLink:e.extra_link},s)))})]}),_=({categories:e})=>void 0===e?null:(0/* ["default"] */,u.jsx)(o.A,{title:(0,r.__)("Get Help","sensei-lms"),children:e.map(((e,s)=>(0,u.jsx)(h,{title:e.title,items:e.items},s)))});
/**
 * Help Category component. It's composed by a title and a list of items.
 *
 * @param {Object}   props       Component properties.
 * @param {string}   props.title The title.
 * @param {Object[]} props.items List of items under the specific category.
 */}
/***/,
/***/45793:
/***/(e,s,n)=>{"use strict";
/* harmony export */n.d(s,{
/* harmony export */R:()=>/* binding */d
/* harmony export */,z:()=>/* binding */x
/* harmony export */});
/* harmony import */var t=n(66087),i=n(47143),r=n(66161),l=n(27723),a=n(77505),o=n(34198);
/* harmony import */n(61912);
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
const c={IN_PROGRESS:"in-progress",IN_QUEUE:"in-queue"},d=e=>[c.IN_PROGRESS,c.IN_QUEUE].includes(e)
/**
 * Extension store actions.
 */,u={
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
*installExtension(e){(0,o/* .logEvent */.$)("extensions_install",{slug:e}),yield u.runProcess({slugs:[e],actionType:"install"})},
/**
   * Updates the provided extensions.
   *
   * @param {string[]} slugs The extension slugs to update.
   */
*updateExtensions(e){e.map((e=>(0,o/* .logEvent */.$)("extensions_update",{slug:e}))),yield u.runProcess({slugs:e,actionType:"update"})},
/**
   * Run extension process (install or update).
   *
   * @param {Object}   process            The process.
   * @param {string[]} process.slugs      Extension slugs.
   * @param {string}   process.actionType Action type (`install` or `update`).
   */
*runProcess(e){const{slugs:s,actionType:n}=e;
// Add to process to queue and skip if a process is already running.
if((yield(0,i.select)(x).getExtensionsByStatus(c.IN_PROGRESS)).length>0)return void(yield u.addToQueue(e));let a,o,d;yield u.setExtensionsStatus(s,c.IN_PROGRESS),"update"===n?(a={plugins:s},o=(0,l.__)("Update completed successfully!","sensei-lms"),
// translators: Placeholder is the underlying error message.
d=(0,l.__)("There was an error while updating the plugin: %1$s","sensei-lms")):(a={plugin:s[0]},o=(0,l.__)("Installation completed successfully!","sensei-lms"),
// translators: Placeholder is the underlying error message.
d=(0,l.__)("There was an error while installing the plugin: %1$s","sensei-lms"));try{const e=yield(0,r.apiFetch)({path:`/sensei-internal/v1/sensei-extensions/${n}`,method:"POST",data:a});yield u.setError(null),yield u.setEntities({extensions:(0,t.keyBy)(e.completed,"product_slug")}),yield(0,i.dispatch)("core/notices").createNotice("success",o,{type:"snackbar"})}catch(e){yield u.setError((0,l.sprintf)(d,e.message))}finally{yield u.setExtensionsStatus(s,""),yield u.removeFromQueue(e);const n=yield(0,i.select)(x).getNextProcess();n&&(yield u.runProcess(n))}},
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
setError:e=>({type:"SET_ERROR",error:e})},m={getExtensions:({extensionSlugs:e,entities:s})=>e.map((e=>s.extensions[e])),getExtensionsByStatus:(e,s)=>m.getExtensions(e).filter((e=>s===e.status)),getSenseiProExtension:(0,i.createRegistrySelector)((e=>()=>e(x).getExtensions().find((e=>"sensei-pro"===e.product_slug)))),getEntities:({entities:e},s)=>e[s],getConnectionStatus:({connected:e})=>e,getNextProcess:({queue:e})=>e[0]||null,getError:({error:e})=>e},h={
/**
   * Loads the extensions during initialization.
   */
*getExtensions(){const e=yield(0,r.apiFetch)({path:"/sensei-internal/v1/sensei-extensions?type=plugin"});yield u.setEntities({extensions:(0,t.keyBy)(e.extensions,"product_slug")}),yield u.setExtensions(e.extensions.map((e=>e.product_slug)))}},_={SET_EXTENSIONS:({extensionSlugs:e},s)=>({...s,extensionSlugs:e}),SET_EXTENSIONS_STATUS:({slugs:e,status:s},n)=>({...n,entities:{...n.entities,extensions:Object.keys(n.entities.extensions).reduce(((t,i)=>({...t,[i]:{...n.entities.extensions[i],status:e.includes(i)?s:n.entities.extensions[i].status}})),{})}}),SET_CONNECTION_STATUS:({connected:e},s)=>({...s,connected:e}),SET_LAYOUT:({layout:e},s)=>({...s,layout:e}),SET_ENTITIES:({entities:e},s)=>({...s,entities:(0,t.merge)({},s.entities,e)}),ADD_TO_QUEUE:({process:e},s)=>({...s,queue:[...s.queue,e]}),REMOVE_FROM_QUEUE:({process:e},s)=>({...s,queue:s.queue.filter((s=>!(0,t.isEqual)(s,e)))}),SET_ERROR:({error:e},s)=>({...s,error:e}),DEFAULT:(e,s)=>s},x=(0,a/* .createStore */.y$)("sensei/extensions",{reducer:(0,a/* .createReducerFromActionMap */.$x)(_,{
/**
   * Extensions list. It is mapped with the entities and served through the selectors.
   */
extensionSlugs:[],
/**
   * Store entities to be used based on the entities key (it can be accessed directly,
   * or mapped based in a key list).
   */
entities:{extensions:{}},connected:!1,layout:[],queue:[],error:null}),actions:u,selectors:m,resolvers:h,controls:r.controls});
/**
 * Default store state.
 */}
/***/,
/***/46316:
/***/(e,s,n)=>{"use strict";
/* harmony export */n.d(s,{
/* harmony export */A:()=>i
/* harmony export */});
/* harmony import */var t=n(62540);
/**
 * First Course component.
 *
 * @param {Object} props             Component props.
 * @param {string} props.siteTitle   Site title.
 * @param {string} props.siteImage   Site image.
 * @param {string} props.courseTitle Course title.
 * @param {string} props.courseImage Course image.
 */const i=({siteTitle:e,siteImage:s,courseTitle:n,courseImage:i})=>(0,t.jsxs)("section",{className:"sensei-home-first-course",children:[(0,t.jsxs)("header",{className:"sensei-home-first-course__site-header",children:[s&&(0,t.jsx)("img",{className:"sensei-home-first-course__site-logo",src:s,alt:"Site logo"}),e||(0,t.jsx)("div",{className:"sensei-home-first-course__site-title-placeholder"})]}),(0,t.jsxs)("div",{className:"sensei-home-first-course__content",children:[(0,t.jsx)("h3",{className:"sensei-home-first-course__course-title",children:n||(0,t.jsx)("div",{className:"sensei-home-first-course__course-title-placeholder"})}),(0,t.jsx)("div",{className:"sensei-home-first-course__featured-image",style:i&&{backgroundImage:`url("${i}")`}})]})]})
/* harmony default export */}
/***/,
/***/46979:
/***/(e,s,n)=>{"use strict";
/* harmony export */n.d(s,{
/* harmony export */x:()=>/* binding */i
/* harmony export */});
/* harmony import */var t=n(86087);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Use Sensei color theme.
 *
 * Requires enqueueing the sensei-wp-components stylesheet.
 */
function i(){(0,t.useLayoutEffect)((()=>(document.body.classList.add("sensei-color"),()=>document.body.classList.remove("sensei-color"))))}
/***/},
/***/47143:
/***/e=>{"use strict";e.exports=window.wp.data}
/***/,
/***/47204:
/***/(e,s,n)=>{"use strict";
/* harmony export */n.d(s,{
/* harmony export */A:()=>w
/* harmony export */});
/* harmony import */var t=n(52619),i=n(56427),r=n(1455),l=n.n(r),a=n(86087),o=n(27723),c=n(46979),d=n(29661),u=n(12980),m=n(52929),h=n(34629),_=n(1750),x=n(44656),p=n(50559),g=n(5075),v=n(17038),f=(n(61912),n(32524)),j=n(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
const w=()=>{var e;(0,c/* .useSenseiColorTheme */.x)();const[s,n]=(0,a.useState)({}),[r,w]=(0,a.useState)(null),[y,N]=(0,a.useState)(!0);(0,a.useEffect)((()=>{!async function(){try{const e=await l()({path:"/sensei-internal/v1/home",method:"GET"});n(e),N(!1)}catch(e){w(e),N(!1)}}()}),[]);let E=null;const k=null!==(e=s?.notices)&&void 0!==e?e:{};E=y?(0,j.jsx)(i.Spinner,{}):r?(0/* .Col */,j.jsx)(m.f,{as:"section",className:"sensei-home__section",cols:12,children:(0,j.jsxs)(i.Notice,{status:"error",isDismissible:!1,children:[(0,o.__)("An error has occurred while fetching the data. Please try again later!","sensei-lms"),(0,j.jsx)("br",{}),(0,o.__)("Error details:","sensei-lms")," ",r.message]})}):(0,j.jsxs)(j.Fragment,{children:[s.tasks&&(0/* ["default"] */,j.jsx)(_.A,{data:s.tasks}),s.quick_links&&s.quick_links.length>0&&(0/* .Col */,j.jsx)(m.f,{as:"section",className:"sensei-home__section",cols:6,children:(0/* ["default"] */,j.jsx)(h.A,{quickLinks:s.quick_links})}),s.help&&s.help.length>0&&(0/* .Col */,j.jsx)(m.f,{as:"section",className:"sensei-home__section",cols:6,children:(0/* ["default"] */,j.jsx)(x.A,{categories:s.help})}),s.promo_banner&&(0/* ["default"] */,j.jsx)(d.A,{show:s.promo_banner.is_visible}),s.guides&&s.guides?.items.length>0&&(0/* .Col */,j.jsx)(m.f,{as:"section",className:"sensei-home__section",cols:6,children:(0/* ["default"] */,j.jsx)(p.A,{data:s.guides})}),s.news&&s.news?.items.length>0&&(0/* .Col */,j.jsx)(m.f,{as:"section",className:"sensei-home__section",cols:6,children:(0/* ["default"] */,j.jsx)(g.A,{data:s.news})}),s.show_extensions&&(0/* .Col */,j.jsx)(m.f,{as:"section",className:"sensei-home__section sensei-home__section__extensions",cols:12,children:(0/* ["default"] */,j.jsx)(v.A,{})})]});const{dismissNoticesNonce:b}=window.sensei_home,S=(0,t.applyFilters)("sensei.home.top",null);
/**
   * Filters the component that will be injected on the top of the Sensei Home
   *
   * @since 4.8.0
   * @param {JSX.Element} element The element to be injected
   * @return {JSX.Element} Filtered element.
   */
return(0,j.jsx)(j.Fragment,{children:(0/* .Grid */,j.jsxs)(m.x,{as:"main",className:"sensei-home",children:[(0/* .Col */,j.jsx)(m.f,{as:"section",className:"sensei-home__section",cols:12,children:(0/* ["default"] */,j.jsx)(u.A,{})}),Object.keys(k).length>0?(0/* .Col */,j.jsx)(m.f,{as:"section",className:"sensei-home__section sensei-home__notices",cols:12,children:(0/* ["default"] */,j.jsx)(f.A,{notices:k,dismissNonce:b})}):null,S,E]})})};
/* harmony default export */}
/***/,
/***/47959:
/***/(e,s,n)=>{"use strict";
/* harmony export */n.d(s,{
/* harmony export */A:()=>r
/* harmony export */});
/* harmony import */var t=n(27723),i=n(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Progress component.
 *
 * @param {Object} props                Component props.
 * @param {number} props.totalTasks     Number of tasks.
 * @param {number} props.completedTasks Number of completed tasks.
 */
const r=({totalTasks:e,completedTasks:s})=>{const n=Math.round(s/e*100);
return(0,i.jsxs)("div",{className:"sensei-home-task-progress",children:[(0,i.jsxs)("div",{className:"sensei-home-task-progress__number",children:[n,"%"]}),(0,i.jsx)("div",{className:"sensei-home-task-progress__bar",children:(0,i.jsx)("div",{role:"progressbar","aria-label":(0,t.__)("Sensei Onboarding Progress","sensei-lms"),"aria-valuenow":n,className:"sensei-home-task-progress__bar-filled",style:{width:`${n}%`}})})]})};
/* harmony default export */}
/***/,
/***/48597:
/***/(e,s,n)=>{"use strict";
/* harmony export */n.d(s,{
/* harmony export */A:()=>a
/* harmony export */});
/* harmony import */var t,i,r=n(51609);
/* harmony import */function l(){return l=Object.assign?Object.assign.bind():function(e){for(var s=1;s<arguments.length;s++){var n=arguments[s];for(var t in n)({}).hasOwnProperty.call(n,t)&&(e[t]=n[t])}return e},l.apply(null,arguments)}
/* harmony default export */const a=function(e){
return r.createElement("svg",l({viewBox:"0 0 24 24",fill:"none",xmlns:"http://www.w3.org/2000/svg"},e),t||(t=r.createElement("circle",{cx:12,cy:12,r:12,fill:"#43AF99"})),i||(i=r.createElement("path",{fillRule:"evenodd",clipRule:"evenodd",d:"M9.835 15.38c.3-.23.179-.474.6-.563-.02.194.146.391.251.563-.109-.367-.002-.536.08-.72.347-.785-.662-1.293-1.35-1.418.235-.164.399-.327.694-.355a2.377 2.377 0 0 0-1.058.23c-1.112.531-1.993-.523-1.41-1.48.31-.51.664-.519.982-.865.077.178.103.372.075.564a.919.919 0 0 0 .049-.664c-.104-.336-.4-.338-.456-.821-.012-.101-.105.056-.263-.077-.038-.032-.113-.09-.163-.064-.085.044-.18.008-.232.034-.083.041-.109-.045-.2.016-.16.107-.178-.013-.332.005-.193.023-.32.261-.43.144-.102-.108-.206.075-.28.075-.05 0-.311.317-.426.028-.086-.216-.28.206-.382.063-.033-.046-.123.108-.18-.044-.014-.035 0-.078-.108-.027-.215.099-.138-.06-.207-.144-.083-.103-.113-.103-.068-.27.036-.133-.019-.33.2-.364.055-.008.107-.005.184-.148.096-.18.231-.093.207-.175-.036-.119.143-.28.226-.355.11-.103.254-.252.306-.396a.63.63 0 0 1 .102-.141c.081-.084.105-.003.227-.045.088-.03.02.053.106-.07.028-.038.105-.001.19-.039.259-.112.283-.11.347-.371.012-.05.025-.088.08-.083.109.01.134-.052.2-.05.061.001.083-.03.115-.068.18-.216.277-.055.357-.072.06-.012.022-.142.184-.102.23.057.155-.05.303-.015.174.041.186.19.306.225.143.042.211.198.307.196.337-.005.235.23.448.323-.16-.161.012-.421-.352-.455-.08-.007-.11-.127-.23-.183-.146-.067-.13-.21-.394-.27.068-.04.089.005.13-.073.058-.11.09-.046.113-.113.02-.063.006-.099.165-.155.165-.06.325-.195.472-.188.13.006.185-.08.177-.19-.008-.112-.033-.267.222-.22.153.029.15.003.15-.1-.002-.102.04-.165.174-.16.098.002.194-.003.231-.117.03-.091.207-.114.302-.148.317-.114.361.05.447-.095.07-.117.196-.317.337-.175.028.029.054.05.15-.056.08-.088.27-.2.337-.048.027.06.086.121.138.044a.08.08 0 0 1 .053-.039c.05-.01.079-.024.104-.036.218-.101.314-.095.213.125-.142.316.792-.192.532.151-.095.126.538.197.63.254.05.032.048.059.144.077.271.05.267.026.284.243.007.098.107.043.107.168 0 .535.472.266.549.399.012.022.032.042.079.042.149 0 .157-.03.224.089.027.047.05.072.127.096.12.037.112.05.068.138-.054.104.03.102.138.112.1.01.148.062.216.138.11.122.284.156.43.227.084.04.002.14.143.243.104.077.156.066.016.165-.59.418.22.305.446.694.051.087.118.195.216.295.225.23.1.293.221.437.07.083.015.063.13.137.272.175-.105.292-.319.212-.097-.035-.166-.085-.147-.025.016.049-.01.083-.052.12-.125.112.123.068.181.06.181-.025.664-.076.66.093-.005.22.136.27.25.284.185.024.238.057.34.226.092.152.145.07.288.205.097.093.217.258.02.282-.047.005-.099 0-.12.017a.411.411 0 0 1-.14.066c-.295.09.14.136.246.113.093-.02.209-.05.3-.027.057.015.062.08.244.107.06.01.036.099.006.16-.104.214.191.1.16.263-.017.093.11.245-.067.248-.057.001-.117-.015-.115.034.004.105-.165-.03-.317.115-.056.054-.19.092-.272-.009-.032-.038-.07-.069-.218-.023-.144.046-.242.204-.306-.04-.017-.064-.05-.065-.142-.097-.125-.043-.114-.258-.297-.12a.24.24 0 0 1-.214.039c-.144-.037-.303.012-.317-.096-.021-.179-.191-.305-.377-.296-.147.008-.278.034-.355-.137.057.195.207.208.382.208.144 0 .23.075.255.225.045.265.204.099.406.223.1.06.17.159.21.273.042.118.37-.024.282.258-.037.122-.107.168-.242.266-.4.294-.5.004-.618.239-.062.121-.063.031-.196.09-.22.098-.36-.128-.522-.045-.182.094-.168-.08-.352.037-.152.097-.308-.074-.38.192-.063.227-.322.232-.44.11-.189-.194-.132.229-.362.054-.123-.091-.213.043-.392.045-.33.005-.489-.282-.65-.107-.192.206-.331-.032-.334-.242-.003-.216-.777-.144-1.185-.256-.225-.062-.932.013-.702-.35-.372.39.456.366.682.455.136.053.245.095.377.114.13.296.214.617.227 1.007.043-.214.053-.433.028-.649-.043-.383.242.19.276.272.184.45-.022 1.278-.488 1.526a2.957 2.957 0 0 0-.562-.99c.256.392.616 1.192.327 1.65a1.023 1.023 0 0 1-.55-.483c.077.333.413.702.818.58.707-.213.704.233 1.641.307.682.111 1.654 0 2.118.037.254.02 1.32.197 1.315.465-.02 1.105-.438 1.164-1.539 1.268-.64.06-1.134.085-1.823.11-1.54.058-3.391.06-4.868 0-.724-.03-1.072-.036-1.841-.137-.769-.1-1.19-.363-1.178-1.187.005-.304.905-.594 1.2-.628.347-.039.901.005 1.405-.116.527-.127.747-.21 1.135-.508Zm5.347-6.052c-.167-.042-.051-.138-.339-.014-.17.073-.194-.13-.365-.094-.172.036-.242-.125-.499-.166-.318-.05-.088-.133-.592-.032-.097.02-.179-.09-.481-.052-.355.046-.23.084-.445-.115-.272-.251-.488-.082-.767-.184.216.166.368.019.622.221-.242.138-.523.802-.962.844.478.107.709.354 1.148.413.504.068.882.118 1.151.531.301.463.44.196.874.168.275-.017.282-.185.328-.362.063-.245.126-.256.31-.289.213-.037.163-.092.107-.156-.15-.172.019-.207.146-.244.222-.064.042-.075.042-.166-.278-.09-.063-.217.092-.273.169.105.242.087.317.073.109-.021.181.03.273-.028-.135.014-.163-.037-.278-.02-.051.007-.112.01-.219-.054-.18-.107-.27.048-.463 0Zm-2.28 1.64-1.09-.545c-1.316-.657-1.915.313-2.337 1.376l-.766.73c.549-.338.996-.714 1.574-.71.092 0 1.516.484 1.286-.092-.04-.104.09-.052.125-.201.04-.17.055-.141.195-.033.089.069.211.113.174-.048-.017-.072-.04-.137.28-.004.15.062.095-.064.303-.09.29-.034.228-.31.364-.349.076-.022.152.058.295-.077.05-.046.11-.089.232-.057-.143-.073-.22-.014-.292.03-.146.089-.204-.037-.343.07Zm-2.23-1.923c.16-.02.32-.036.482-.046a.13.13 0 0 0 .074-.06.111.111 0 0 0 .007-.09.268.268 0 0 1 .147-.206l-.002-.003c-.258.001-.466.1-.73.211-.052.022-.024.111-.118.213a.26.26 0 0 1-.201.235.136.136 0 0 0-.09.046.113.113 0 0 0-.026.092.252.252 0 0 1-.277.061c-.2-.077-.35-.065-.448.036a.39.39 0 0 1 .398.014c.134.066.3.031.39-.082a.132.132 0 0 1 .126-.098.421.421 0 0 0 .268-.323Z",fill:"#fff"})))};
/***/},
/***/50559:
/***/(e,s,n)=>{"use strict";
/* harmony export */n.d(s,{
/* harmony export */A:()=>a
/* harmony export */});
/* harmony import */var t=n(27723),i=n(9330),r=n(71921),l=n(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Sensei Guides section component.
 *
 * @param {Object} props
 * @param {Object} props.data
 */
const a=({data:e})=>e?(0/* ["default"] */,l.jsxs)(i.A,{title:(0,t.__)("Sensei Guides","sensei-lms"),className:"sensei-home-guides",children:[(0,l.jsx)("ul",{children:e.items.map(((e,s)=>(0,l.jsx)("li",{children:(0/* ["default"] */,l.jsx)(r.A,{label:e.title,url:e.url})},s)))}),e.more_url&&(0,l.jsx)("div",{className:"sensei-home-guides__more-link",children:(0/* ["default"] */,l.jsx)(r.A,{label:(0,t.__)("See more","sensei-lms"),url:e.more_url})})]}):null;
/* harmony default export */}
/***/,
/***/51135:
/***/(e,s,n)=>{"use strict";
/* harmony export */n.d(s,{
/* harmony export */A:()=>r
/* harmony export */});
/* harmony import */var t=n(5573),i=n(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
const r=(0,i.jsx)(t.SVG,{viewBox:"0 0 24 24",xmlns:"http://www.w3.org/2000/svg",children:(0,i.jsx)(t.Path,{fillRule:"evenodd",clipRule:"evenodd",d:"M5.5 12a6.5 6.5 0 1 0 13 0 6.5 6.5 0 0 0-13 0ZM12 4a8 8 0 1 0 0 16 8 8 0 0 0 0-16Zm.75 4v1.5h-1.5V8h1.5Zm0 8v-5h-1.5v5h1.5Z"})});
/* harmony default export */}
//# sourceMappingURL=info.js.map
/***/,
/***/51609:
/***/e=>{"use strict";e.exports=window.React}
/***/,
/***/52619:
/***/e=>{"use strict";e.exports=window.wp.hooks}
/***/,
/***/52929:
/***/(e,s,n)=>{"use strict";
/* harmony export */n.d(s,{
/* harmony export */f:()=>/* binding */o
/* harmony export */,x:()=>/* binding */a
/* harmony export */});
/* harmony import */var t=n(4452),i=n.n(t),r=n(86087),l=n(62540);
/* harmony import */
/**
 * External dependencies
 */
/**
 * WordPress dependencies
 */
/**
 * Grid component.
 *
 * @param {Object} props           Component props.
 * @param {Array}  props.as        Tag or component to render as wrapper.
 * @param {Array}  props.className Class name to be added in the wrapper.
 * @param {Object} props.children  Children.
 */
const a=({as:e="div",className:s,children:n})=>(0,l.jsx)(e,{className:i()(s,"sensei-home__grid"),children:n})
/**
 * Col component (should be used inside the Grid).
 *
 * @param {Object}       props           Component props.
 * @param {Array}        props.as        Tag or component to render as wrapper.
 * @param {Array|string} props.className Class name to be added in the wrapper.
 * @param {number}       props.cols      Number of columns to use.
 * @param {Object}       props.children  Children.
 * @param {Object}       ref             Component ref.
 */,o=(0,r.forwardRef)((({as:e="div",className:s,cols:n=12,children:t,...r},a)=>(0,l.jsx)(e,{className:i()(s,"sensei-home__grid__col",`--col-${n}`),...r,ref:a,children:t})))}
/***/,
/***/53772:
/***/e=>{"use strict";e.exports="assets/dist/images/sensei-pro-ad-image-183d1f1d7116e39b75b9.png"}
/***/,
/***/54844:
/***/(e,s,n)=>{"use strict";
/* harmony export */n.d(s,{
/* harmony export */A:()=>l
/* harmony export */});
/* harmony import */var t=n(27723),i=n(65949),r=n(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Tasks component.
 *
 * @param {Object}   props       Component props.
 * @param {Object[]} props.items The tasks.
 */
const l=({items:e})=>(0,r.jsxs)("div",{className:"sensei-home-tasks",children:[(0,r.jsx)("h1",{className:"sensei-home-tasks__title",children:(0,t.__)("Welcome to your new Sensei course site.","sensei-lms")}),(0,r.jsx)("p",{className:"sensei-home-tasks__description",children:(0,t.__)("Keep the momentum going and let’s get your first Course in front of your students.","sensei-lms")}),(0,r.jsx)("ul",{className:"sensei-home-tasks__list",children:e.map((e=>(0/* ["default"] */,r.jsx)(i.A,{title:e.title,url:e.url,done:e.done,disabled:e.disabled,info:e.info},e.id)))})]})
/* harmony default export */}
/***/,
/***/55338:
/***/(e,s,n)=>{"use strict";
/* harmony export */n.d(s,{
/* harmony export */A:()=>l
/* harmony export */});
/* harmony import */var t,i=n(51609);
/* harmony import */function r(){return r=Object.assign?Object.assign.bind():function(e){for(var s=1;s<arguments.length;s++){var n=arguments[s];for(var t in n)({}).hasOwnProperty.call(n,t)&&(e[t]=n[t])}return e},r.apply(null,arguments)}
/* harmony default export */const l=function(e){
return i.createElement("svg",r({viewBox:"0 0 24 24",fill:"none",xmlns:"http://www.w3.org/2000/svg"},e),t||(t=i.createElement("path",{d:"M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0Zm3 8h-1.35c-.538 0-.65.221-.65.778V10h2l-.209 2H13v7h-3v-7H8v-2h2V7.692C10 5.923 10.931 5 13.029 5H15v3Z",fill:"currentColor"})))};
/***/},
/***/56009:
/***/(e,s,n)=>{"use strict";
/* harmony export */n.d(s,{
/* harmony export */A:()=>r
/* harmony export */});
/* harmony import */var t=n(5573),i=n(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
const r=(0,i.jsx)(t.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24",children:(0,i.jsx)(t.Path,{d:"M12 13.06l3.712 3.713 1.061-1.06L13.061 12l3.712-3.712-1.06-1.06L12 10.938 8.288 7.227l-1.061 1.06L10.939 12l-3.712 3.712 1.06 1.061L12 13.061z"})});
/* harmony default export */}
//# sourceMappingURL=close-small.js.map
/***/,
/***/56427:
/***/e=>{"use strict";e.exports=window.wp.components}
/***/,
/***/57384:
/***/(e,s,n)=>{"use strict";
/* harmony export */n.d(s,{
/* harmony export */A:()=>l
/* harmony export */});
/* harmony import */var t,i=n(51609);
/* harmony import */function r(){return r=Object.assign?Object.assign.bind():function(e){for(var s=1;s<arguments.length;s++){var n=arguments[s];for(var t in n)({}).hasOwnProperty.call(n,t)&&(e[t]=n[t])}return e},r.apply(null,arguments)}
/* harmony default export */const l=function(e){
return i.createElement("svg",r({viewBox:"0 0 24 24",fill:"none",xmlns:"http://www.w3.org/2000/svg"},e),t||(t=i.createElement("path",{d:"M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0Zm2.737 15.722.581 1.721-.014.062c-.438.421-1.49.733-2.35.748l-.098.001c-2.828 0-3.313-2.16-3.313-3.435v-4.106l-.059-.059H7.862l-.059-.059-.014-1.786.037-.054c1.462-.569 2.278-1.514 2.492-3.263.013-.097.094-.1.094-.1h2.011l.059.059v2.81l.059.059h2.219l.058.059v2.217l-.058.059h-2.229l-.057.059v3.911c.014.839.417 1.265 1.205 1.265.316 0 .65-.074.982-.201l.076.033Z",fill:"currentColor"})))};
/***/},
/***/58663:
/***/(e,s,n)=>{"use strict";
/* harmony export */n.d(s,{
/* harmony export */A:()=>l
/* harmony export */});
/* harmony import */var t,i=n(51609);
/* harmony import */function r(){return r=Object.assign?Object.assign.bind():function(e){for(var s=1;s<arguments.length;s++){var n=arguments[s];for(var t in n)({}).hasOwnProperty.call(n,t)&&(e[t]=n[t])}return e},r.apply(null,arguments)}
/* harmony default export */const l=function(e){
return i.createElement("svg",r({viewBox:"0 0 24 24",fill:"none",xmlns:"http://www.w3.org/2000/svg"},e),t||(t=i.createElement("path",{d:"M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0Zm6.066 9.645c.183 4.04-2.83 8.544-8.164 8.544A8.127 8.127 0 0 1 5.5 16.898a5.778 5.778 0 0 0 4.252-1.189 2.879 2.879 0 0 1-2.684-1.995 2.88 2.88 0 0 0 1.298-.049c-1.381-.278-2.335-1.522-2.304-2.853.388.215.83.344 1.301.359a2.877 2.877 0 0 1-.889-3.835 8.153 8.153 0 0 0 5.92 3.001 2.876 2.876 0 0 1 4.895-2.62 5.73 5.73 0 0 0 1.824-.697 2.884 2.884 0 0 1-1.263 1.589 5.73 5.73 0 0 0 1.649-.453 5.765 5.765 0 0 1-1.433 1.489Z",fill:"currentColor"})))};
/***/},
/***/58688:
/***/(e,s,n)=>{"use strict";
/* harmony export */n.d(s,{
/* harmony export */A:()=>u
/* harmony export */});
/* harmony import */var t=n(86087),i=n(1455),r=n.n(i),l=n(27723),a=n(56427),o=n(74153),c=n(71921),d=n(62540);
/* harmony import */
/* harmony default export */const u=
/**
 * Component to Install Demo Course. Invoked when clicking on a link pointing to "sensei://install-demo-course".
 *
 * @param {Object}   props             Component props.
 * @param {Function} props.remove      Function to call to remove the item from the Quick Links Column.
 * @param {Function} props.restoreLink Function to call to restore the link on the Quick Links Column.
 */
function({remove:e,restoreLink:s}){const[n,i,u]=(()=>{const[e,s]=(0,t.useState)(!1),[n,i]=(0,t.useState)(null),[l,a]=(0,t.useState)(0),c=()=>{a(0),s(!0),i(null)};
// Logs polling.
// Logs polling.
return(0,t.useEffect)((()=>{n&&r()({path:(0,o/* .buildJobEndpointUrl */.O)(n,["process"]),method:"POST"}).then((e=>{"completed"!==e.status.status?a((e=>(e+1)%3)):a(-1)})).catch(c)}),[n,l]),
// Start installation job.
// Start installation job.
(0,t.useEffect)((()=>{r()({path:(0,o/* .buildJobEndpointUrl */.O)(null,["start-sample"]),method:"POST"}).then((e=>{i(e.id)})).catch(c)}),[]),[n,l,e]})(),[m,h]=(0,t.useState)(!1);if((0,t.useEffect)((()=>{let e=null;u?e=s:!u&&i<0&&(e=()=>h(!0)),e&&setTimeout(e,2e3)}),[u,i,e,s]),u)return(0,l.__)("Error while installing. Try again.","sensei-lms");if(m){const{setupSampleCourseNonce:e}=window.sensei_home;
return(0/* ["default"] */,d.jsx)(c.A,{url:`?redirect_imported_sample=1&job_id=${n}&nonce=${e}`,label:(0,l.__)("Edit Demo Course","sensei-lms")})}return i<0?(0,l.__)("Installed","sensei-lms"):(0,d.jsxs)(d.Fragment,{children:[(0,d.jsx)(a.Spinner,{}),(0,l.__)("Installing","sensei-lms")]})};
/***/},
/***/61912:
/***/(e,s,n)=>{"use strict";
/* unused harmony export preloadedDataUsedOnceMiddleware */
/* harmony import */var t=n(93832),i=n(1455);
/* harmony import */n.n(i)().use(
/**
 * WordPress dependencies
 */
/**
 * Use data preloaded with createPreloadingMiddleware only once.
 */
function(){const e={};return(s,n)=>("string"!=typeof s.path||"GET"!==s.method&&s.method||(e[s.path]?s.path=(0,t.addQueryArgs)(s.path,{__skip_preload:1}):e[s.path]=!0),n(s))}())}
/***/,
/***/62540:
/***/(e,s,n)=>{"use strict";e.exports=n(2192)}
/***/,
/***/65949:
/***/(e,s,n)=>{"use strict";
/* harmony export */n.d(s,{
/* harmony export */A:()=>h
/* harmony export */});
/* harmony import */var t=n(4452),i=n.n(t),r=n(12417),l=n(68576),a=n(51135),o=n(56427),c=n(16012),d=n(40427),u=n(13296),m=n(62540);
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
 * WordPress dependencies
 */
/**
 * Tasks item component.
 *
 * @param {Object}  props          Component props.
 * @param {string}  props.title    Item title.
 * @param {string}  props.url      Item URL.
 * @param {boolean} props.done     Whether item is completed.
 * @param {boolean} props.disabled Whether item is disabled.
 * @param {boolean} props.info     Info text.
 */
const h=({title:e,url:s,done:n,info:t,disabled:h})=>{const _=!n&&!h,x=_?"a":"span",p=(0,u/* .isUrlExternal */.J)(s)||s?.indexOf("external=true")>=0,g=!n&&{href:s,target:p?"_blank":void 0,rel:p?"noreferrer":void 0};
return(0,m.jsx)("li",{className:i()("sensei-home-tasks__item",{"sensei-home-tasks__item--disabled":!_}),children:(0,m.jsxs)(x,{className:"sensei-home-tasks__link",...g,children:[n&&(0/* ["default"] */,m.jsx)(c.A,{className:"sensei-home-tasks__check-icon"}),(0,m.jsxs)("span",{className:"sensei-home-tasks__item-title",children:[e,p&&_&&(0/* ["default"] */,m.jsx)(r.A,{icon:l/* ["default"] */.A,className:"sensei-home-tasks__external-icon sensei-home-tasks__icon-with-current-color"})]}),t&&(0,m.jsx)(o.Tooltip,{text:t,children:(0/* ["default"] */,m.jsx)(r.A,{className:"sensei-home-tasks__icon-with-current-color",icon:a/* ["default"] */.A})}),_&&(0/* ["default"] */,m.jsx)(d.A,{className:"sensei-home-tasks__link-chevron"})]})})};
/* harmony default export */}
/***/,
/***/66087:
/***/e=>{"use strict";e.exports=window.lodash}
/***/,
/***/66161:
/***/e=>{"use strict";e.exports=window.wp.dataControls}
/***/,
/***/66863:
/***/(e,s,n)=>{"use strict";
/* harmony export */n.d(s,{
/* harmony export */A:()=>l
/* harmony export */});
/* harmony import */var t,i=n(51609);
/* harmony import */function r(){return r=Object.assign?Object.assign.bind():function(e){for(var s=1;s<arguments.length;s++){var n=arguments[s];for(var t in n)({}).hasOwnProperty.call(n,t)&&(e[t]=n[t])}return e},r.apply(null,arguments)}
/* harmony default export */const l=function(e){
return i.createElement("svg",r({viewBox:"0 0 24 6",fill:"none",xmlns:"http://www.w3.org/2000/svg"},e),t||(t=i.createElement("path",{d:"M1.31 6c.903 0 1.427-.49 1.427-1.257 0-.972-.864-1.25-1.488-1.461-.34-.106-.601-.188-.601-.36 0-.285.293-.481.732-.481.501 0 .91.18 1.233.465.008-.057.008-.114.008-.171-.015-.547-.462-.85-1.226-.85C.585 1.886 0 2.409 0 3.2c0 .963.894 1.265 1.519 1.478.339.114.601.204.601.359 0 .27-.324.449-.763.449-.47 0-.902-.172-1.303-.506v.106C.062 5.706.532 6 1.311 6ZM6.011 6c.432 0 .71-.082.933-.229a.93.93 0 0 0 .378-.571c-.277.139-.555.196-.91.196-.84 0-1.364-.53-1.364-1.461v-.188H7.43c.008-.065.008-.139.008-.204 0-1.004-.594-1.657-1.55-1.657-1.071 0-1.866.898-1.866 2.13 0 1.282.78 1.984 1.99 1.984Zm-.948-2.506c.031-.523.285-1.11.771-1.11.494 0 .625.506.632 1.012l-1.403.098ZM10.693 5.935h1.874c-.37-.172-.463-.319-.463-.645V3.102c0-.743-.393-1.216-1.08-1.216-.623 0-1.024.31-1.202 1.06V1.789l-1.295.44c.116.254.231.499.355.743V5.25c0 .327-.124.514-.463.686h1.866c-.37-.172-.463-.36-.463-.686V2.971c.193-.236.409-.35.702-.35.385 0 .632.228.632.685V5.29c0 .326-.123.473-.463.645ZM15.003 6c.902 0 1.426-.49 1.426-1.257 0-.972-.864-1.25-1.488-1.461-.34-.106-.601-.188-.601-.36 0-.285.293-.481.732-.481.501 0 .91.18 1.233.465.008-.057.008-.114.008-.171-.015-.547-.462-.85-1.226-.85-.81 0-1.395.523-1.395 1.315 0 .963.894 1.265 1.519 1.478.339.114.601.204.601.359 0 .27-.324.449-.763.449-.47 0-.902-.172-1.303-.506v.106c.008.62.478.914 1.257.914ZM19.703 6c.432 0 .71-.082.933-.229a.93.93 0 0 0 .378-.571c-.277.139-.555.196-.91.196-.84 0-1.364-.53-1.364-1.461v-.188h2.382c.008-.065.008-.139.008-.204 0-1.004-.594-1.657-1.55-1.657-1.071 0-1.865.898-1.865 2.13 0 1.282.778 1.984 1.988 1.984Zm-.948-2.506c.031-.523.286-1.11.771-1.11.494 0 .625.506.632 1.012l-1.403.098ZM22.998 1.184c.293 0 .57-.27.57-.588 0-.318-.285-.596-.57-.596-.324 0-.57.278-.57.596 0 .31.285.588.57.588Zm-.864 4.75H24c-.37-.17-.463-.358-.463-.685V1.788l-1.295.44c.116.254.232.499.355.743V5.25c0 .327-.123.514-.463.686Z",fill:"currentColor"})))};
/***/},
/***/68576:
/***/(e,s,n)=>{"use strict";
/* harmony export */n.d(s,{
/* harmony export */A:()=>r
/* harmony export */});
/* harmony import */var t=n(5573),i=n(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
const r=(0,i.jsx)(t.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24",children:(0,i.jsx)(t.Path,{d:"M19.5 4.5h-7V6h4.44l-5.97 5.97 1.06 1.06L18 7.06v4.44h1.5v-7Zm-13 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-3H17v3a.5.5 0 0 1-.5.5h-10a.5.5 0 0 1-.5-.5v-10a.5.5 0 0 1 .5-.5h3V5.5h-3Z"})});
/* harmony default export */}
//# sourceMappingURL=external.js.map
/***/,
/***/71921:
/***/(e,s,n)=>{"use strict";
/* harmony export */n.d(s,{
/* harmony export */A:()=>a
/* harmony export */});
/* harmony import */var t=n(12417),i=n(68576),r=n(13296),l=n(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Link component. Will add an external link icon if the url is for an external domain.
 *
 * @param {Object}   props         Component props.
 * @param {string}   props.label   The label for the link.
 * @param {string}   props.url     The target URL.
 * @param {Function} props.onClick The event listener for the click event.
 * @param {Object}   props.dataSet Data attributes to add to the link.
 */
const a=({label:e,url:s,onClick:n,dataSet:a})=>{const o=(0,r/* .isUrlExternal */.J)(s),c={href:(0,r/* .addUtms */.$)(s),target:o?"_blank":void 0,rel:o?"noreferrer":void 0,onClick:n};if(a)for(const[e,s]of Object.entries(a))c["data-"+e]=s;
return(0,l.jsx)("div",{className:"sensei-home__link",children:(0,l.jsxs)("a",{...c,children:[e,o&&(0/* ["default"] */,l.jsx)(t.A,{icon:i/* ["default"] */.A,className:"sensei-home__link__external-icon"})]})})};
/* harmony default export */}
/***/,
/***/74153:
/***/(e,s,n)=>{"use strict";
/* harmony export */n.d(s,{
/* harmony export */O:()=>/* binding */i
/* harmony export */});
/* harmony import */var t=n(32406);
/**
 * Internal dependencies
 */
/**
 * Build a URL for a job specific route.
 *
 * @param {string?} jobId Job identifier.
 * @param {Array?}  parts Parts of the URL.
 * @return {string} Combined URL.
 */const i=(e,s=null)=>{const n=[...e?[e]:[],...s||[]].join("/");return t/* .API_BASE_PATH */.DN+n};
/***/},
/***/77505:
/***/(e,s,n)=>{"use strict";
/* harmony export */n.d(s,{
/* harmony export */$x:()=>/* binding */r
/* harmony export */,y$:()=>/* binding */l
/* harmony export */});
/* unused harmony export composeFetchAction */
/* harmony import */var t=n(47143);
/* harmony import */
/**
 * WordPress dependencies
 */
// We register the store in the global scope to avoid registering it multiple times.
// The reason to be in the global scope is that some times we have different built files using the same source.
window.senseiStores=window.senseiStores||[];const{senseiStores:i}=window,r=(e,s)=>(n=s,t)=>(e[t.type]||e.DEFAULT)(t,n),l=(e,s)=>{if(i[e])return i[e];const n=(0,t.createReduxStore)(e,s);return(0,t.register)(n),i[e]=n,n};
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
/***/78661:
/***/(e,s,n)=>{"use strict";
/* harmony export */n.d(s,{
/* harmony export */A:()=>a
/* harmony export */});
/* harmony import */var t,i,r=n(51609);
/* harmony import */function l(){return l=Object.assign?Object.assign.bind():function(e){for(var s=1;s<arguments.length;s++){var n=arguments[s];for(var t in n)({}).hasOwnProperty.call(n,t)&&(e[t]=n[t])}return e},l.apply(null,arguments)}
/* harmony default export */const a=function(e){
return r.createElement("svg",l({viewBox:"0 0 34 34",fill:"none",xmlns:"http://www.w3.org/2000/svg"},e),t||(t=r.createElement("circle",{cx:17,cy:17,r:17,fill:"#26212E"})),i||(i=r.createElement("path",{fillRule:"evenodd",clipRule:"evenodd",d:"M14.03 21.746c.398-.33.237-.679.797-.807-.025.278.194.56.334.807-.145-.526-.003-.768.106-1.032.463-1.125-.88-1.853-1.796-2.031.313-.236.531-.469.924-.51a2.975 2.975 0 0 0-1.408.33c-1.48.762-2.652-.75-1.876-2.12.413-.732.884-.744 1.307-1.24.102.255.136.533.1.808a1.41 1.41 0 0 0 .064-.952c-.138-.48-.533-.484-.606-1.176-.016-.145-.14.081-.35-.11-.05-.046-.15-.128-.217-.091-.113.063-.24.011-.309.047-.11.06-.144-.064-.266.024-.214.153-.236-.019-.442.008-.257.033-.425.374-.572.205-.135-.154-.273.109-.371.109-.068 0-.415.454-.568.04-.115-.31-.372.294-.509.09-.043-.066-.163.154-.24-.064-.017-.05.002-.111-.142-.04-.286.143-.185-.085-.276-.205-.11-.148-.15-.148-.09-.387.047-.19-.026-.473.265-.521.075-.012.143-.008.245-.212.128-.257.308-.134.276-.25-.048-.171.19-.402.3-.51.147-.147.34-.36.407-.567a.905.905 0 0 1 .137-.202c.108-.12.14-.004.302-.064.117-.043.026.075.141-.1.037-.056.139-.003.252-.056.344-.161.376-.159.462-.533.016-.07.033-.125.106-.118.145.014.178-.074.268-.072.08.002.109-.043.152-.097.238-.31.369-.079.474-.103.082-.019.03-.204.245-.146.307.082.207-.074.404-.023.232.06.248.272.407.323.19.06.28.284.408.281.448-.007.313.33.596.462-.213-.23.016-.602-.468-.65-.108-.011-.145-.183-.306-.263-.194-.096-.174-.302-.524-.386.09-.06.118.006.173-.106.077-.157.12-.065.15-.162.028-.09.008-.141.22-.222.22-.085.432-.28.628-.27.173.01.245-.114.235-.27-.01-.162-.043-.384.296-.316.204.04.2.004.199-.143-.002-.148.053-.237.231-.23.13.003.259-.004.308-.168.039-.13.276-.163.402-.213.422-.163.48.072.595-.135.094-.168.26-.455.447-.25.038.04.073.07.2-.081.106-.127.359-.287.45-.069.035.086.114.174.182.063.014-.022.03-.046.07-.056.069-.015.106-.034.14-.051.29-.146.416-.136.284.18-.19.452 1.053-.277.707.215-.127.18.715.283.838.365.067.045.064.083.192.11.36.07.355.036.377.347.01.14.143.062.143.241 0 .767.627.381.73.572.017.032.043.06.105.06.198 0 .21-.041.299.127.036.069.066.103.169.138.159.053.149.073.09.198-.072.149.04.146.184.16.132.014.196.09.287.198.147.175.377.224.572.326.111.057.002.2.19.348.138.11.208.094.022.236-.786.6.292.437.593.994.068.125.158.28.287.424.3.329.132.42.294.626.094.118.02.09.174.196.36.251-.14.418-.424.304-.13-.051-.221-.122-.196-.037.02.07-.015.12-.07.173-.166.16.163.098.242.086.24-.037.882-.11.877.133-.006.316.182.387.333.407.246.035.316.082.452.323.122.218.194.101.383.295.13.132.29.369.027.403-.063.008-.131.001-.16.025a.529.529 0 0 1-.186.095c-.393.129.185.194.327.161.125-.028.279-.07.399-.037.076.02.083.113.325.152.08.014.048.141.008.23-.139.307.255.144.214.376-.024.134.145.35-.09.355-.076.002-.155-.02-.153.049.005.151-.22-.042-.422.166-.075.077-.253.13-.362-.013-.042-.055-.093-.1-.29-.033-.192.065-.322.291-.407-.058-.022-.092-.067-.094-.19-.139-.165-.062-.15-.37-.394-.171a.3.3 0 0 1-.285.055c-.192-.053-.403.017-.421-.137a.481.481 0 0 0-.502-.425c-.196.011-.37.048-.473-.196.077.28.275.298.508.298.193 0 .306.108.34.323.06.379.272.14.54.319a.729.729 0 0 1 .28.39c.056.17.493-.033.375.371-.05.174-.142.24-.322.38-.533.422-.666.006-.823.343-.081.174-.084.045-.26.13-.293.14-.48-.184-.695-.066-.242.136-.223-.114-.468.054-.203.139-.41-.106-.507.275-.083.325-.427.332-.584.158-.251-.278-.176.327-.482.078-.163-.132-.283.06-.522.064-.44.006-.65-.404-.864-.154-.255.296-.44-.046-.445-.347-.004-.309-1.034-.206-1.576-.366-.3-.09-1.241.019-.935-.502-.494.56.608.525.908.652.18.075.326.137.501.163.173.424.285.884.302 1.444.058-.308.07-.621.038-.93-.057-.55.322.272.367.39.245.645-.03 1.83-.649 2.186a4.329 4.329 0 0 0-.748-1.418c.34.56.82 1.707.436 2.363a1.398 1.398 0 0 1-.731-.691c.101.477.548 1.006 1.087.83.94-.304.937.334 2.184.44.906.16 2.2 0 2.818.054.337.029 1.755.282 1.749.665-.026 1.584-.583 1.668-2.048 1.817a36.17 36.17 0 0 1-2.425.16 83.155 83.155 0 0 1-6.477-.003c-.964-.042-1.427-.05-2.45-.195-1.023-.145-1.584-.52-1.568-1.702.007-.435 1.205-.85 1.596-.898.463-.057 1.2.007 1.871-.167.7-.182.994-.302 1.51-.728zm7.113-8.672c-.222-.06-.068-.197-.45-.02-.226.105-.259-.186-.487-.134-.229.051-.322-.18-.663-.238-.423-.073-.118-.191-.788-.046-.13.027-.238-.13-.64-.074-.472.065-.307.12-.592-.165-.362-.36-.649-.119-1.02-.264.286.238.489.027.827.317-.321.197-.696 1.149-1.28 1.209.636.153.943.507 1.527.592.671.096 1.173.168 1.532.76.401.664.585.281 1.163.241.366-.025.375-.265.436-.519.084-.35.168-.367.413-.414.283-.053.216-.132.142-.223-.2-.246.025-.296.194-.35.296-.092.057-.107.057-.238-.37-.128-.085-.31.121-.39.225.149.323.124.422.104.145-.03.242.043.364-.041-.18.02-.217-.052-.37-.03-.068.011-.15.016-.291-.075-.239-.154-.36.068-.617-.002zm-3.033 2.35-1.452-.781c-1.75-.94-2.547.448-3.109 1.971l-1.018 1.046c.73-.483 1.325-1.022 2.093-1.018.123.001 2.018.695 1.713-.13-.055-.15.118-.076.166-.289.053-.244.072-.202.26-.046.117.098.28.162.23-.07-.022-.103-.052-.195.372-.005.201.09.127-.092.404-.128.386-.05.303-.446.485-.5.1-.032.202.081.392-.111.066-.067.145-.128.31-.083-.191-.104-.293-.02-.39.044-.195.127-.27-.053-.456.1zm-2.967-2.756c.213-.029.426-.051.64-.066a.176.176 0 0 0 .1-.084.17.17 0 0 0 .009-.13.384.384 0 0 1 .195-.296l-.002-.004c-.343.002-.62.142-.971.303-.07.032-.033.159-.157.304a.366.366 0 0 1-.269.337.177.177 0 0 0-.12.066.17.17 0 0 0-.034.132.319.319 0 0 1-.368.088c-.266-.11-.465-.094-.596.052a.488.488 0 0 1 .53.02.41.41 0 0 0 .519-.118.179.179 0 0 1 .167-.141c.188-.076.307-.231.357-.463z",fill:"#fff"})))};
/***/},
/***/79966:
/***/(e,s,n)=>{"use strict";
/* harmony export */n.d(s,{
/* harmony export */A:()=>l
/* harmony export */});
/* harmony import */var t,i=n(51609);
/* harmony import */function r(){return r=Object.assign?Object.assign.bind():function(e){for(var s=1;s<arguments.length;s++){var n=arguments[s];for(var t in n)({}).hasOwnProperty.call(n,t)&&(e[t]=n[t])}return e},r.apply(null,arguments)}
/* harmony default export */const l=function(e){
return i.createElement("svg",r({xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24"},e),t||(t=i.createElement("path",{fillRule:"evenodd",clipRule:"evenodd",d:"m7.622 18.42-.634.433.406.598 2.78 4.102 1.268-.866-1.748-2.579c2.978.999 6.425.147 8.636-2.415 2.449-2.836 2.599-6.863.601-9.763l-1.026 1.188c1.4 2.325 1.203 5.408-.697 7.608-1.861 2.157-4.801 2.822-7.278 1.869l2.029-1.385.64-.438-.81-1.197-.641.438-3.526 2.407ZM16.435 5.996l.634-.433-.405-.598-2.78-4.102-1.27.866 1.75 2.58c-2.979-1-6.426-.148-8.637 2.414-2.449 2.837-2.599 6.863-.601 9.763l1.026-1.188c-1.4-2.325-1.203-5.408.697-7.608 1.861-2.157 4.801-2.822 7.278-1.868l-2.029 1.384-.64.438.81 1.197.641-.438 3.526-2.407Z",fill:"currentColor"})))};
/***/},
/***/86087:
/***/e=>{"use strict";e.exports=window.wp.element}
/***/,
/***/87675:
/***/(e,s,n)=>{"use strict";
/* harmony export */n.d(s,{
/* harmony export */A:()=>o
/* harmony export */});
/* harmony import */var t=n(4452),i=n.n(t),r=n(27723),l=n(29182),a=n(62540);
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
 * Extensions card component.
 *
 * @param {Object}   props               Component props.
 * @param {string}   props.title         Card title (extension title will be used as fallback).
 * @param {string}   props.excerpt       Card excerpt (extension excerpt will be used as fallback).
 * @param {string}   props.badgeLabel    Badge label (will check extension update if it's not defined).
 * @param {string}   props.image         Card image.
 * @param {Object}   props.htmlProps     Wrapper extra props.
 * @param {Object[]} props.customActions Array with custom actions containing the link props.
 */
const o=e=>{const{title:s,excerpt:n,badgeLabel:t,htmlProps:o,customActions:c,image:d}=e,u=(0,l/* .useExtensionActions */.E)(e),m=c||u,h=d&&`url(${d})`;
return(0,a.jsxs)("article",{...o,className:i()("sensei-home__card",o?.className),children:[(0,a.jsxs)("header",{className:"sensei-home__card__header",children:[(0,a.jsx)("h3",{className:"sensei-home__card__title",children:s}),(t||e?.has_update)&&(0,a.jsx)("small",{className:"sensei-home__card__new-badge",children:t||(0,r.__)("New version","sensei-lms")})]}),(0,a.jsx)("div",{className:"sensei-home__card__image",style:{backgroundImage:h}}),(0,a.jsxs)("div",{className:"sensei-home__card__body",children:[(0,a.jsx)("p",{className:"sensei-home__card__description",children:n}),m&&(0/* ["default"] */,a.jsx)(l.A,{actions:m})]})]})};
/* harmony default export */}
/***/,
/***/93832:
/***/e=>{"use strict";e.exports=window.wp.url}
/***/,
/***/96516:
/***/(e,s,n)=>{"use strict";
/* harmony export */n.d(s,{
/* harmony export */h:()=>/* binding */t
/* harmony export */,u:()=>/* binding */i
/* harmony export */});
/**
 * Get the Sensei Pro upgrade URL.
 *
 * @param {string} campaign The campaign name.
 *
 * @return {string} The upgrade URL.
 */
const t=(e="")=>{const{upsellUrl:s}=window.sensei_admin;return`${s}?${new URLSearchParams({utm_source:"plugin_sensei",utm_medium:"upsell",utm_campaign:e}).toString()}`},i=(e="")=>{const{checkoutUrl:s}=window.sensei_admin;return`${s}?${new URLSearchParams({utm_source:"plugin_sensei",utm_medium:"checkout",utm_campaign:e}).toString()}`};
/**
 * Get the Sensei Pro checkout URL.
 *
 * @param {string} campaign The campaign name.
 *
 * @return {string} The checkout URL.
 */}
/***/
/******/},s={};
/************************************************************************/
/******/ // The module cache
/******/
/******/
/******/ // The require function
/******/function n(t){
/******/ // Check if module is in cache
/******/var i=s[t];
/******/if(void 0!==i)
/******/return i.exports;
/******/
/******/ // Create a new module (and put it into the cache)
/******/var r=s[t]={
/******/ // no module.id needed
/******/ // no module.loaded needed
/******/exports:{}
/******/};
/******/
/******/ // Execute the module function
/******/
/******/
/******/ // Return the exports of the module
/******/return e[t](r,r.exports,n),r.exports;
/******/}
/******/
/************************************************************************/
/******/ /* webpack/runtime/compat get default export */
/******/
/******/ // getDefaultExport function for compatibility with non-harmony modules
/******/n.n=e=>{
/******/var s=e&&e.__esModule?
/******/()=>e.default
/******/:()=>e
/******/;
/******/return n.d(s,{a:s}),s;
/******/},
/******/ // define getter functions for harmony exports
/******/n.d=(e,s)=>{
/******/for(var t in s)
/******/n.o(s,t)&&!n.o(e,t)&&
/******/Object.defineProperty(e,t,{enumerable:!0,get:s[t]})
/******/;
/******/},
/******/n.o=(e,s)=>Object.prototype.hasOwnProperty.call(e,s)
/******/,
// This entry needs to be wrapped in an IIFE because it needs to be in strict mode.
(()=>{"use strict";
/* harmony import */var e=n(86087),s=n(47204),t=n(62540);
/* harmony import */(0,e.createRoot)(document.getElementById("sensei-home-page")).render((0/* ["default"] */,t.jsx)(s.A,{}))})()})
/******/();