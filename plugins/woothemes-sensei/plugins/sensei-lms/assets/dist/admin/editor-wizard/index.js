/******/(()=>{// webpackBootstrap
/******/"use strict";
/******/var e={
/***/1455:
/***/e=>{e.exports=window.wp.apiFetch;
/***/},
/***/2192:
/***/(e,s,t)=>{
/**
 * @license React
 * react-jsx-runtime.production.min.js
 *
 * Copyright (c) Facebook, Inc. and its affiliates.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */
var n=t(51609),i=Symbol.for("react.element"),r=Symbol.for("react.fragment"),o=Object.prototype.hasOwnProperty,l=n.__SECRET_INTERNALS_DO_NOT_USE_OR_YOU_WILL_BE_FIRED.ReactCurrentOwner,a={key:!0,ref:!0,__self:!0,__source:!0};function c(e,s,t){var n,r={},c=null,d=null;for(n in void 0!==t&&(c=""+t),void 0!==s.key&&(c=""+s.key),void 0!==s.ref&&(d=s.ref),s)o.call(s,n)&&!a.hasOwnProperty(n)&&(r[n]=s[n]);if(e&&e.defaultProps)for(n in s=e.defaultProps)void 0===r[n]&&(r[n]=s[n]);return{$$typeof:i,type:e,key:c,ref:d,props:r,_owner:l.current}}s.Fragment=r,s.jsx=c,s.jsxs=c}
/***/,
/***/4446:
/***/(e,s,t)=>{
/* harmony export */t.d(s,{
/* harmony export */A:()=>o
/* harmony export */});
/* harmony import */var n=t(56427),i=t(27723),r=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Text control with input limited by a given maximum length.
 *
 * @param {Object}  props           Component properties.
 * @param {string}  props.value     Value for the field.
 * @param {number}  props.maxLength Maximum length for the field.
 * @param {boolean} props.multiline Whether if multiline input (textarea) must be used or not.
 */
const o=({value:e,maxLength:s,multiline:t=!1,...o})=>{const l=t?n.TextareaControl:n.TextControl;
return(0,r.jsx)(l,{help:(0,i.sprintf)(
// translators: %1$d number of characters introduced, %2$d number of total characters allowed.
// translators: %1$d number of characters introduced, %2$d number of total characters allowed.
(0,i.__)("Characters: %1$d/%2$d","sensei-lms"),e.length,s),value:e,maxLength:s,...o})};
/* harmony default export */}
/***/,
/***/16012:
/***/(e,s,t)=>{
/* harmony export */t.d(s,{
/* harmony export */A:()=>o
/* harmony export */});
/* harmony import */var n,i=t(51609);
/* harmony import */function r(){return r=Object.assign?Object.assign.bind():function(e){for(var s=1;s<arguments.length;s++){var t=arguments[s];for(var n in t)({}).hasOwnProperty.call(t,n)&&(e[n]=t[n])}return e},r.apply(null,arguments)}
/* harmony default export */const o=function(e){
return i.createElement("svg",r({viewBox:"0 0 24 24",xmlns:"http://www.w3.org/2000/svg"},e),n||(n=i.createElement("path",{d:"M9 18.6 3.5 13l1-1L9 16.4l9.5-9.9 1 1z",fill:"currentColor"})))};
/***/},
/***/17676:
/***/e=>{e.exports="assets/dist/images/sensei-pro-upsell-e5b3b5f85deaf2759678.png";
/***/},
/***/23689:
/***/(e,s,t)=>{
/* harmony export */t.d(s,{
/* harmony export */A:()=>a
/* harmony export */});
/* harmony import */var n=t(27723),i=t(47143),r=t(30717),o=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Course patterns step.
 *
 * @param {Object} props            Component props.
 * @param {Object} props.wizardData Wizard data.
 */
const l=({wizardData:e,...s})=>{const{user:t}=(0,i.useSelect)((e=>({user:e("core").getCurrentUser()}))),l={};return e.title&&(l["sensei-content-title"]=e.title),e.description&&(l["sensei-content-description"]=e.description),t.name&&(l["sensei-content-author"]=`<strong>${t.name}</strong>`),(0/* ["default"] */,o.jsx)(r.A,{title:(0,n.__)("Course Layout","sensei-lms"),replaces:l,...s})};l.Actions=r/* ["default"] */.A.Actions;
/* harmony default export */const a=l;
/***/},
/***/27723:
/***/e=>{e.exports=window.wp.i18n;
/***/},
/***/28678:
/***/(e,s,t)=>{
/* harmony export */t.d(s,{
/* harmony export */A:()=>u
/* harmony export */});
/* harmony import */var n=t(27723),i=t(56427),r=t(43656),o=t(47143),l=t(4446),a=t(56184),c=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Initial step for course creation wizard.
 *
 * @param {Object}   props
 * @param {Object}   props.wizardData    Wizard data.
 * @param {Function} props.setWizardData Wizard data setter.
 */
const d=({wizardData:e,setWizardData:s})=>{var t,i;const{editPost:d}=(0,o.useDispatch)(r.store);
return(0,c.jsxs)("div",{className:"sensei-editor-wizard-modal__columns",children:[(0,c.jsxs)("div",{className:"sensei-editor-wizard-modal__content",children:[(0,c.jsx)("h1",{className:"sensei-editor-wizard-step__title",children:(0,n.__)("Create your course","sensei-lms")}),(0,c.jsx)("p",{className:"sensei-editor-wizard-step__description",children:(0,n.__)("Keep your Course Title short as it will get displayed in different places around your website. You can easily change both later.","sensei-lms")}),(0,c.jsxs)("div",{className:"sensei-editor-wizard-step__form",children:[(0/* ["default"] */,c.jsx)(l.A,{className:"sensei-editor-wizard-step__form-control",label:(0,n.__)("Course Title","sensei-lms"),value:null!==(t=e.title)&&void 0!==t?t:"",onChange:t=>{s({...e,title:t}),d({title:t})},maxLength:40,autoFocus:!0}),(0/* ["default"] */,c.jsx)(l.A,{className:"sensei-editor-wizard-step__form-control",label:(0,n.__)("Course Description","sensei-lms"),value:null!==(i=e.description)&&void 0!==i?i:"",onChange:t=>{s({...e,description:t}),d({excerpt:t})},maxLength:350,multiline:!0})]})]}),(0,c.jsx)("div",{className:"sensei-editor-wizard-modal__illustration",children:(0,c.jsx)("img",{src:window.sensei.pluginUrl+a,alt:(0,n.__)("Illustration of course sample with some placeholders.","sensei-lms"),className:"sensei-editor-wizard-modal__illustration-image"})})]})};d.Actions=({goToNextStep:e})=>(0,c.jsx)(i.Button,{isPrimary:!0,onClick:e,children:(0,n.__)("Continue","sensei-lms")});
/* harmony default export */const u=d;
/***/},
/***/29080:
/***/(e,s,t)=>{
/* harmony export */t.d(s,{
/* harmony export */A:()=>p
/* harmony export */});
/* harmony import */var n=t(27723),i=t(86087),r=t(30717),o=t(48597),l=t(96516),a=t(66920),c=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Lesson patterns step.
 *
 * @param {Object} props            Component props.
 * @param {Object} props.wizardData Wizard data.
 */
const d=({wizardData:e,...s})=>{const t={};e.title&&(t["sensei-content-title"]=e.title),e.description&&(t["sensei-content-description"]=e.description);const o=(0,a/* .useHideEditorWizardUpsell */.bC)();
return(0,c.jsxs)(i.Fragment,{children:[(0/* ["default"] */,c.jsx)(r.A,{title:(0,n.__)("Lesson Layout","sensei-lms"),replaces:t,patternsToExclude:["sensei-lms/default"],...s}),(0/* ["default"] */,c.jsx)(r.A.UpsellFill,{children:o?null:(0,c.jsx)(u,{})})]})},u=()=>(0,c.jsxs)("div",{className:"sensei-editor-wizard-patterns-upsell",children:[(0/* ["default"] */,c.jsx)(o.A,{className:"sensei-editor-wizard-patterns-upsell__logo"}),(0,c.jsxs)("div",{className:"sensei-editor-wizard-patterns-upsell__text",children:[(0,c.jsx)("b",{className:"sensei-editor-wizard-patterns-upsell__title",children:(0,n.__)("Want More Lesson Layouts?","sensei-lms")}),(0,c.jsx)("br",{}),(0,n.__)("Get flashcards, timed quizzes, image hotspots, and more with Sensei Pro.","sensei-lms")," ",(0,c.jsx)("a",{className:"sensei-editor-wizard-patterns-upsell__link",href:(0,l/* .getSenseiProUpsellUrl */.h)("lesson_patterns_editor_wizard"),rel:"noreferrer external",target:"blank",children:(0,n.__)("Learn more.","sensei-lms")})]})]});
/**
 * The Pattern Upsell block, which is shown only for Sensei Free users.
 */d.Actions=r/* ["default"] */.A.Actions;
/* harmony default export */const p=d;
/***/},
/***/30717:
/***/(e,s,t)=>{
/* harmony export */t.d(s,{
/* harmony export */A:()=>_
/* harmony export */});
/* harmony import */var n=t(56427),i=t(43656),r=t(47143),o=t(27723),l=t(31615),a=t(66920),c=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
const{Fill:d,Slot:u}=(0,n.createSlotFill)("Patterns Upsell"),p=e=>{const{title:s,replaces:t,patternsToExclude:n,onCompletion:o}=e,{resetEditorBlocks:d,editPost:p}=(0,r.useDispatch)(i.store),_=(0,a/* .useLogEvent */._B)(),m=(0,r.useSelect)((e=>e(i.store).getEditorSettings())).availableTemplates;
return(0,c.jsxs)("div",{className:"sensei-editor-wizard-modal__content",children:[(0,c.jsx)("h1",{className:"sensei-editor-wizard-step__sticky-title",children:s}),(0,c.jsx)(u,{}),(0/* ["default"] */,c.jsx)(l.A,{patternsToExclude:n,onChoose:(e,s,n)=>{const i=t?(0,a/* .replacePlaceholders */.Lb)(e,t):e;d(i),o(),
//Auto select a template if the pattern specifies an available one.
n&&Object.keys(m).includes(n)&&p({template:n}),_("editor_wizard_choose_pattern",{name:s})}})]})};
/**
 * Choose patterns step.
 *
 * @param {Object}   props                   Component props.
 * @param {string}   props.title             Step title.
 * @param {Object}   props.replaces          Object containing content to be replaced. The keys are the block classNames to find. The values are the content to be replaced.
 * @param {Array}    props.patternsToExclude Array of patterns to exclude.
 * @param {Function} props.onCompletion      On completion callback.
 */p.Actions=({skipWizard:e})=>{const s=(0,a/* .useLogEvent */._B)();
return(0,c.jsx)(n.Button,{isTertiary:!0,onClick:()=>{e(),s("editor_wizard_start_with_default_layout")},children:(0,o.__)("Start with default layout","sensei-lms")})},
/**
 * Component to fill the Patterns Upsell section
 */
p.UpsellFill=d;
/* harmony default export */const _=p;
/***/},
/***/31615:
/***/(e,s,t)=>{
/* harmony export */t.d(s,{
/* harmony export */A:()=>m
/* harmony export */});
/* harmony import */var n=t(94715),i=t(47143),r=t(52619),o=t(27723),l=t(48558),a=t(74997),c=t(86087),d=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * It returns events to fire the click event on click, pressing enter, and pressing space.
 *
 * @param {Function} fn Click callback.
 *
 * @return {Object} Object with props to add in the React element.
 */
const u=e=>{const s=(0,a.getBlockType)(e.name)?.example,t=s&&"core/group"!==e.name?s.innerBlocks:e.innerBlocks;return s?(0,a.getBlockFromExample)(e.name,{attributes:{...s.attributes,...e.attributes},innerBlocks:t}):e},p=e=>"sensei-lms/lesson-actions"!==e.name
/**
 * No patterns warning component.
 */,_=()=>{
/**
   * Filters the warning message when no layouts are available.
   *
   * @param {string} message Default warning message.
   * @return {string} Filtered warning message.
   */
const e=(0,r.applyFilters)("sensei.editorWizard.noLayoutsWarning",(0,o.__)("No layouts available for this theme.","sensei-lms"));
return(0,d.jsx)("div",{className:"sensei-patterns-list__warning",children:(0,d.jsx)("div",{className:"sensei-patterns-list__warning-title",children:e})})},m=({patternsToExclude:e=[],onChoose:s})=>{const{patterns:t}=(0,i.useSelect)((e=>({patterns:e(n.store)?.getPatternsByBlockTypes("sensei-lms/post-content")||e(n.store).__experimentalGetPatternsByBlockTypes("sensei-lms/post-content")}))),r=(0,c.useCallback)((({name:s,categories:t})=>!e.includes(s)&&t&&t.includes("sensei-lms")),[e]);return t&&0!==t.length?(0,d.jsx)("div",{className:"sensei-patterns-list",role:"listbox","aria-label":(0,o.__)("Sensei block patterns","sensei-lms"),children:t.filter(r).map((({name:e,title:t,description:i,blocks:r,viewportWidth:o,template:a})=>{

// eslint-disable-next-line jsx-a11y/click-events-have-key-events, jsx-a11y/no-static-element-interactions

// eslint-disable-next-line jsx-a11y/click-events-have-key-events, jsx-a11y/no-static-element-interactions
return(0,d.jsxs)("div",{className:"sensei-patterns-list__item",title:i,role:"option",tabIndex:0,...(c=()=>{s(r,e,a)},{onClick:c,onKeyUp:e=>{[l.ENTER,l.SPACE].includes(e.keyCode)&&c(e)}}),children:[(0,d.jsx)("div",{className:"sensei-patterns-list__item-preview",children:(0,d.jsx)(n.BlockPreview,{additionalStyles:[{css:"body { padding: 30px; }"}],blocks:r.filter(p).map(u),viewportWidth:null!=o?o:800})}),(0,d.jsx)("div",{className:"sensei-patterns-list__item-title",children:t})]},e);var c;
/**
 * Use the block's example option for the block's content in the pattern preview.
 *
 * @param {Object} block Block instance.
 * @return {Object} Block instance.
 */}))}):(0,d.jsx)(_,{})}}
/***/,
/***/34198:
/***/(e,s,t)=>{
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
/***/37592:
/***/(e,s,t)=>{
/* harmony export */t.d(s,{
/* harmony export */rr:()=>/* binding */a
/* harmony export */});
/* unused harmony exports DEFAULT_STATE, actions, selectors, reducers */
/* harmony import */var n=t(66161),i=t(1455),r=t.n(i),o=t(77505);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
const l={
/**
   * Sets whether the tour should be shown.
   *
   * @param {boolean} show            The lesson status.
   * @param {boolean} persistOnServer If the action should be persisted.
   * @param {string}  tourName        The unique name of the tour.
   *
   * @return {Object} The setTourShowStatus action.
   */
setTourShowStatus:(e,s,t)=>(s&&r()({path:"sensei-internal/v1/tour",method:"POST",data:{complete:!e,tour_id:t}}),{type:"SET_TOUR_SHOW_STATUS",showTour:e})},a=(0,o/* .createStore */.y$)("sensei/tour",{reducer:(0,o/* .createReducerFromActionMap */.$x)({
/**
   * Sets the show tour status.
   *
   * @param {Object}  action          The action.
   * @param {boolean} action.showTour If the tour should be shown.
   * @param {Object}  state           The state.
   *
   * @return {Object} The new state.
   */
SET_TOUR_SHOW_STATUS:({showTour:e},s)=>({...s,showTour:e}),DEFAULT:(e,s)=>s},{showTour:!0}),actions:l,selectors:{
/**
   * Get if the tour should be shown.
   *
   * @param {Object}  state          The state.
   * @param {boolean} state.showTour If the tour should be shown.
   *
   * @return {boolean} If the tour should be shown.
   */
shouldShowTour:({showTour:e})=>e},controls:n.controls});
/**
 * Tour store actions.
 */}
/***/,
/***/43656:
/***/e=>{e.exports=window.wp.editor;
/***/},
/***/45793:
/***/(e,s,t)=>{
/* harmony export */t.d(s,{
/* harmony export */z:()=>/* binding */m
/* harmony export */});
/* unused harmony export isLoadingStatus */
/* harmony import */var n=t(66087),i=t(47143),r=t(66161),o=t(27723),l=t(77505),a=t(34198);
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
const c={IN_PROGRESS:"in-progress",IN_QUEUE:"in-queue"},d={
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
*installExtension(e){(0,a/* .logEvent */.$)("extensions_install",{slug:e}),yield d.runProcess({slugs:[e],actionType:"install"})},
/**
   * Updates the provided extensions.
   *
   * @param {string[]} slugs The extension slugs to update.
   */
*updateExtensions(e){e.map((e=>(0,a/* .logEvent */.$)("extensions_update",{slug:e}))),yield d.runProcess({slugs:e,actionType:"update"})},
/**
   * Run extension process (install or update).
   *
   * @param {Object}   process            The process.
   * @param {string[]} process.slugs      Extension slugs.
   * @param {string}   process.actionType Action type (`install` or `update`).
   */
*runProcess(e){const{slugs:s,actionType:t}=e;
// Add to process to queue and skip if a process is already running.
if((yield(0,i.select)(m).getExtensionsByStatus(c.IN_PROGRESS)).length>0)return void(yield d.addToQueue(e));let l,a,u;yield d.setExtensionsStatus(s,c.IN_PROGRESS),"update"===t?(l={plugins:s},a=(0,o.__)("Update completed successfully!","sensei-lms"),
// translators: Placeholder is the underlying error message.
u=(0,o.__)("There was an error while updating the plugin: %1$s","sensei-lms")):(l={plugin:s[0]},a=(0,o.__)("Installation completed successfully!","sensei-lms"),
// translators: Placeholder is the underlying error message.
u=(0,o.__)("There was an error while installing the plugin: %1$s","sensei-lms"));try{const e=yield(0,r.apiFetch)({path:`/sensei-internal/v1/sensei-extensions/${t}`,method:"POST",data:l});yield d.setError(null),yield d.setEntities({extensions:(0,n.keyBy)(e.completed,"product_slug")}),yield(0,i.dispatch)("core/notices").createNotice("success",a,{type:"snackbar"})}catch(e){yield d.setError((0,o.sprintf)(u,e.message))}finally{yield d.setExtensionsStatus(s,""),yield d.removeFromQueue(e);const t=yield(0,i.select)(m).getNextProcess();t&&(yield d.runProcess(t))}},
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
*addToQueue(e){return yield d.setExtensionsStatus(e.slugs,c.IN_QUEUE),{type:"ADD_TO_QUEUE",process:e}},
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
setError:e=>({type:"SET_ERROR",error:e})},u={getExtensions:({extensionSlugs:e,entities:s})=>e.map((e=>s.extensions[e])),getExtensionsByStatus:(e,s)=>u.getExtensions(e).filter((e=>s===e.status)),getSenseiProExtension:(0,i.createRegistrySelector)((e=>()=>e(m).getExtensions().find((e=>"sensei-pro"===e.product_slug)))),getEntities:({entities:e},s)=>e[s],getConnectionStatus:({connected:e})=>e,getNextProcess:({queue:e})=>e[0]||null,getError:({error:e})=>e},p={
/**
   * Loads the extensions during initialization.
   */
*getExtensions(){const e=yield(0,r.apiFetch)({path:"/sensei-internal/v1/sensei-extensions?type=plugin"});yield d.setEntities({extensions:(0,n.keyBy)(e.extensions,"product_slug")}),yield d.setExtensions(e.extensions.map((e=>e.product_slug)))}},_={SET_EXTENSIONS:({extensionSlugs:e},s)=>({...s,extensionSlugs:e}),SET_EXTENSIONS_STATUS:({slugs:e,status:s},t)=>({...t,entities:{...t.entities,extensions:Object.keys(t.entities.extensions).reduce(((n,i)=>({...n,[i]:{...t.entities.extensions[i],status:e.includes(i)?s:t.entities.extensions[i].status}})),{})}}),SET_CONNECTION_STATUS:({connected:e},s)=>({...s,connected:e}),SET_LAYOUT:({layout:e},s)=>({...s,layout:e}),SET_ENTITIES:({entities:e},s)=>({...s,entities:(0,n.merge)({},s.entities,e)}),ADD_TO_QUEUE:({process:e},s)=>({...s,queue:[...s.queue,e]}),REMOVE_FROM_QUEUE:({process:e},s)=>({...s,queue:s.queue.filter((s=>!(0,n.isEqual)(s,e)))}),SET_ERROR:({error:e},s)=>({...s,error:e}),DEFAULT:(e,s)=>s},m=(0,l/* .createStore */.y$)("sensei/extensions",{reducer:(0,l/* .createReducerFromActionMap */.$x)(_,{
/**
   * Extensions list. It is mapped with the entities and served through the selectors.
   */
extensionSlugs:[],
/**
   * Store entities to be used based on the entities key (it can be accessed directly,
   * or mapped based in a key list).
   */
entities:{extensions:{}},connected:!1,layout:[],queue:[],error:null}),actions:d,selectors:u,resolvers:p,controls:r.controls});
/**
 * Default store state.
 */}
/***/,
/***/45998:
/***/(e,s,t)=>{
/* harmony export */t.d(s,{
/* harmony export */A:()=>u
/* harmony export */});
/* harmony import */var n=t(47143),i=t(43656),r=t(28678),o=t(48332),l=t(23689),a=t(46069),c=t(29080),d=t(66920);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Returns the list of components (representing steps) for the Editor Wizard according to the post type and if
 * Sensei Pro is activated or not.
 *
 * @return {Array} The list of components to show to the user.
 */
const u=()=>{const e={course:[r/* ["default"] */.A,o/* ["default"] */.A,l/* ["default"] */.A],lesson:[a/* ["default"] */.A,c/* ["default"] */.A]},{postType:s}=(0,n.useSelect)((e=>({postType:e(i.store)?.getCurrentPostType()})),[]);return(0,d/* .useHideEditorWizardUpsell */.bC)()&&(e.course=e.course.filter((e=>e!==o/* ["default"] */.A))),e[s]};
/* harmony default export */}
/***/,
/***/46069:
/***/(e,s,t)=>{
/* harmony export */t.d(s,{
/* harmony export */A:()=>_
/* harmony export */});
/* harmony import */var n=t(56427),i=t(47143),r=t(43656),o=t(86087),l=t(27723),a=t(4446),c=t(56184),d=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Initial step for lesson creation wizard.
 *
 * @param {Object}   props
 * @param {Object}   props.wizardData    Wizard data.
 * @param {Function} props.setWizardData Wizard data setter.
 */
const u=({wizardData:e,setWizardData:s})=>{const[t,n]=p(e,s),r=(0,i.useSelect)((e=>e("core/editor").getCurrentPostAttribute("meta")));return(0,o.useEffect)((()=>{r&&r._initial_content&&s({...e,description:r._initial_content})}),[r]),(0,d.jsxs)("div",{className:"sensei-editor-wizard-modal__columns",children:[(0,d.jsxs)("div",{className:"sensei-editor-wizard-modal__content",children:[(0,d.jsx)("h1",{className:"sensei-editor-wizard-step__title",children:(0,l.__)("Create your lesson","sensei-lms")}),(0,d.jsx)("p",{className:"sensei-editor-wizard-step__description",children:(0,l.__)("It is best to keep your Lesson Title short because it will show in your course outline and navigation. You can easily change both later.","sensei-lms")}),(0,d.jsx)("div",{className:"sensei-editor-wizard-step__form",children:(0/* ["default"] */,d.jsx)(a.A,{className:"sensei-editor-wizard-step__form-control",label:(0,l.__)("Lesson Title","sensei-lms"),value:t,onChange:n,maxLength:40,autoFocus:!0})})]}),(0,d.jsx)("div",{className:"sensei-editor-wizard-modal__illustration",children:(0,d.jsx)("img",{src:window.sensei.pluginUrl+c,className:"sensei-editor-wizard-modal__illustration-image",alt:(0,l.__)("Illustration of lesson sample with some placeholders.","sensei-lms")})})]})};
/**
 * Actions for the LessonDetailsStep.
 *
 * @param {Function} goToNextStep Invoke to go to the next step.
 */u.Actions=({goToNextStep:e})=>(0,d.jsx)(n.Button,{isPrimary:!0,onClick:e,children:(0,l.__)("Continue","sensei-lms")});
/**
 * Load the post title from the Editor Store.
 *
 * @param {Object}   wizardData    The wizard data.
 * @param {Function} setWizardData Function to update the wizard data.
 */
const p=(e,s)=>{var t;const{editPost:n}=(0,i.useDispatch)(r.store),{postTitle:o}=(0,i.useSelect)((e=>({postTitle:e(r.store)?.getEditedPostAttribute("title")})));return[null!==(t=e.title)&&void 0!==t?t:o,t=>{s({...e,title:t}),n({title:t})}]},_=u;
/* harmony default export */}
/***/,
/***/47143:
/***/e=>{e.exports=window.wp.data;
/***/},
/***/48332:
/***/(e,s,t)=>{
/* harmony export */t.d(s,{
/* harmony export */A:()=>_
/* harmony export */});
/* harmony import */var n=t(56427),i=t(27723),r=t(47143),o=t(45793),l=t(17676),a=t(16012),c=t(96516),d=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Upgrade step during course creation wizard.
 */
const u=()=>{const{senseiProExtension:e}=(0,r.useSelect)((e=>({senseiProExtension:e(o/* .EXTENSIONS_STORE */.z).getSenseiProExtension()})),[]);
return(0,d.jsxs)("div",{className:"sensei-editor-wizard-modal__columns",children:[(0,d.jsxs)("div",{className:"sensei-editor-wizard-modal__content",children:[(0,d.jsx)("h1",{className:"sensei-editor-wizard-step__title",children:(0,i.__)("Sell with Sensei Pro","sensei-lms")}),(0,d.jsx)("p",{className:"sensei-editor-wizard-step__description",children:(0,i.__)("Do you want to sell this course? This requires Sensei Pro which also unlocks many useful features.","sensei-lms")}),(0,d.jsx)("strong",{className:"sensei-editor-wizard-modal-upsell__price",children:(0,i.sprintf)(
// translators: placeholder is the price.
// translators: placeholder is the price.
(0,i.__)("%s USD","sensei-lms"),e.price.replace(".00",""))}),(0,d.jsx)("span",{className:"sensei-editor-wizard-modal-upsell__price-detail",children:(0,i.__)("per year, 1 site","sensei-lms")}),(0,d.jsxs)("ul",{className:"sensei-editor-wizard-modal-upsell__features",children:[(0,d.jsx)(p,{children:(0,i.__)("WooCommerce integration","sensei-lms")}),(0,d.jsx)(p,{children:(0,i.__)("Schedule 'drip' content","sensei-lms")}),(0,d.jsx)(p,{children:(0,i.__)("Set expiration date of courses","sensei-lms")}),(0,d.jsx)(p,{children:(0,i.__)("Quiz timer","sensei-lms")}),(0,d.jsx)(p,{children:(0,i.__)("Flashcards, Image Hotspots, and Checklists","sensei-lms")}),(0,d.jsx)(p,{children:(0,i.__)("1 year of updates & support","sensei-lms")})]})]}),(0,d.jsx)("div",{className:"sensei-editor-wizard-modal__illustration",children:(0,d.jsx)("img",{src:window.sensei.pluginUrl+l,alt:(0,i.__)('Illustration of a course listing with the pricing defined and with the button "Purchase Button"',"sensei-lms"),className:"sensei-editor-wizard-modal__illustration-image"})})]})},p=({children:e})=>(0,d.jsxs)("li",{className:"sensei-editor-wizard-modal-upsell__feature-item",children:[(0/* ["default"] */,d.jsx)(a.A,{className:"sensei-editor-wizard-modal-upsell__feature-item-icon"}),e]});
/**
 * Item of the feature list in the Upgrade Step
 *
 * @param {Object} props          Component Props
 * @param {string} props.children Text to be included after the feature item icon
 */u.Actions=({goToNextStep:e})=>(0,d.jsxs)(d.Fragment,{children:[(0,d.jsx)(n.Button,{isTertiary:!0,onClick:e,className:"sensei-editor-wizard-modal-upsell__button",children:(0,i.__)("Continue with Sensei Free","sensei-lms")}),(0,d.jsx)(n.Button,{isPrimary:!0,onClick:()=>{window.open((0,c/* .getSenseiProUpsellUrl */.h)("course_editor_wizard"),"sensei-pricing","noreferrer"),e()},target:"_blank",className:"sensei-editor-wizard-modal-upsell__button",children:(0,i.__)("Get Sensei Pro","sensei-lms")})]});
/* harmony default export */const _=u;
/***/},
/***/48558:
/***/e=>{e.exports=window.wp.keycodes;
/***/},
/***/48597:
/***/(e,s,t)=>{
/* harmony export */t.d(s,{
/* harmony export */A:()=>l
/* harmony export */});
/* harmony import */var n,i,r=t(51609);
/* harmony import */function o(){return o=Object.assign?Object.assign.bind():function(e){for(var s=1;s<arguments.length;s++){var t=arguments[s];for(var n in t)({}).hasOwnProperty.call(t,n)&&(e[n]=t[n])}return e},o.apply(null,arguments)}
/* harmony default export */const l=function(e){
return r.createElement("svg",o({viewBox:"0 0 24 24",fill:"none",xmlns:"http://www.w3.org/2000/svg"},e),n||(n=r.createElement("circle",{cx:12,cy:12,r:12,fill:"#43AF99"})),i||(i=r.createElement("path",{fillRule:"evenodd",clipRule:"evenodd",d:"M9.835 15.38c.3-.23.179-.474.6-.563-.02.194.146.391.251.563-.109-.367-.002-.536.08-.72.347-.785-.662-1.293-1.35-1.418.235-.164.399-.327.694-.355a2.377 2.377 0 0 0-1.058.23c-1.112.531-1.993-.523-1.41-1.48.31-.51.664-.519.982-.865.077.178.103.372.075.564a.919.919 0 0 0 .049-.664c-.104-.336-.4-.338-.456-.821-.012-.101-.105.056-.263-.077-.038-.032-.113-.09-.163-.064-.085.044-.18.008-.232.034-.083.041-.109-.045-.2.016-.16.107-.178-.013-.332.005-.193.023-.32.261-.43.144-.102-.108-.206.075-.28.075-.05 0-.311.317-.426.028-.086-.216-.28.206-.382.063-.033-.046-.123.108-.18-.044-.014-.035 0-.078-.108-.027-.215.099-.138-.06-.207-.144-.083-.103-.113-.103-.068-.27.036-.133-.019-.33.2-.364.055-.008.107-.005.184-.148.096-.18.231-.093.207-.175-.036-.119.143-.28.226-.355.11-.103.254-.252.306-.396a.63.63 0 0 1 .102-.141c.081-.084.105-.003.227-.045.088-.03.02.053.106-.07.028-.038.105-.001.19-.039.259-.112.283-.11.347-.371.012-.05.025-.088.08-.083.109.01.134-.052.2-.05.061.001.083-.03.115-.068.18-.216.277-.055.357-.072.06-.012.022-.142.184-.102.23.057.155-.05.303-.015.174.041.186.19.306.225.143.042.211.198.307.196.337-.005.235.23.448.323-.16-.161.012-.421-.352-.455-.08-.007-.11-.127-.23-.183-.146-.067-.13-.21-.394-.27.068-.04.089.005.13-.073.058-.11.09-.046.113-.113.02-.063.006-.099.165-.155.165-.06.325-.195.472-.188.13.006.185-.08.177-.19-.008-.112-.033-.267.222-.22.153.029.15.003.15-.1-.002-.102.04-.165.174-.16.098.002.194-.003.231-.117.03-.091.207-.114.302-.148.317-.114.361.05.447-.095.07-.117.196-.317.337-.175.028.029.054.05.15-.056.08-.088.27-.2.337-.048.027.06.086.121.138.044a.08.08 0 0 1 .053-.039c.05-.01.079-.024.104-.036.218-.101.314-.095.213.125-.142.316.792-.192.532.151-.095.126.538.197.63.254.05.032.048.059.144.077.271.05.267.026.284.243.007.098.107.043.107.168 0 .535.472.266.549.399.012.022.032.042.079.042.149 0 .157-.03.224.089.027.047.05.072.127.096.12.037.112.05.068.138-.054.104.03.102.138.112.1.01.148.062.216.138.11.122.284.156.43.227.084.04.002.14.143.243.104.077.156.066.016.165-.59.418.22.305.446.694.051.087.118.195.216.295.225.23.1.293.221.437.07.083.015.063.13.137.272.175-.105.292-.319.212-.097-.035-.166-.085-.147-.025.016.049-.01.083-.052.12-.125.112.123.068.181.06.181-.025.664-.076.66.093-.005.22.136.27.25.284.185.024.238.057.34.226.092.152.145.07.288.205.097.093.217.258.02.282-.047.005-.099 0-.12.017a.411.411 0 0 1-.14.066c-.295.09.14.136.246.113.093-.02.209-.05.3-.027.057.015.062.08.244.107.06.01.036.099.006.16-.104.214.191.1.16.263-.017.093.11.245-.067.248-.057.001-.117-.015-.115.034.004.105-.165-.03-.317.115-.056.054-.19.092-.272-.009-.032-.038-.07-.069-.218-.023-.144.046-.242.204-.306-.04-.017-.064-.05-.065-.142-.097-.125-.043-.114-.258-.297-.12a.24.24 0 0 1-.214.039c-.144-.037-.303.012-.317-.096-.021-.179-.191-.305-.377-.296-.147.008-.278.034-.355-.137.057.195.207.208.382.208.144 0 .23.075.255.225.045.265.204.099.406.223.1.06.17.159.21.273.042.118.37-.024.282.258-.037.122-.107.168-.242.266-.4.294-.5.004-.618.239-.062.121-.063.031-.196.09-.22.098-.36-.128-.522-.045-.182.094-.168-.08-.352.037-.152.097-.308-.074-.38.192-.063.227-.322.232-.44.11-.189-.194-.132.229-.362.054-.123-.091-.213.043-.392.045-.33.005-.489-.282-.65-.107-.192.206-.331-.032-.334-.242-.003-.216-.777-.144-1.185-.256-.225-.062-.932.013-.702-.35-.372.39.456.366.682.455.136.053.245.095.377.114.13.296.214.617.227 1.007.043-.214.053-.433.028-.649-.043-.383.242.19.276.272.184.45-.022 1.278-.488 1.526a2.957 2.957 0 0 0-.562-.99c.256.392.616 1.192.327 1.65a1.023 1.023 0 0 1-.55-.483c.077.333.413.702.818.58.707-.213.704.233 1.641.307.682.111 1.654 0 2.118.037.254.02 1.32.197 1.315.465-.02 1.105-.438 1.164-1.539 1.268-.64.06-1.134.085-1.823.11-1.54.058-3.391.06-4.868 0-.724-.03-1.072-.036-1.841-.137-.769-.1-1.19-.363-1.178-1.187.005-.304.905-.594 1.2-.628.347-.039.901.005 1.405-.116.527-.127.747-.21 1.135-.508Zm5.347-6.052c-.167-.042-.051-.138-.339-.014-.17.073-.194-.13-.365-.094-.172.036-.242-.125-.499-.166-.318-.05-.088-.133-.592-.032-.097.02-.179-.09-.481-.052-.355.046-.23.084-.445-.115-.272-.251-.488-.082-.767-.184.216.166.368.019.622.221-.242.138-.523.802-.962.844.478.107.709.354 1.148.413.504.068.882.118 1.151.531.301.463.44.196.874.168.275-.017.282-.185.328-.362.063-.245.126-.256.31-.289.213-.037.163-.092.107-.156-.15-.172.019-.207.146-.244.222-.064.042-.075.042-.166-.278-.09-.063-.217.092-.273.169.105.242.087.317.073.109-.021.181.03.273-.028-.135.014-.163-.037-.278-.02-.051.007-.112.01-.219-.054-.18-.107-.27.048-.463 0Zm-2.28 1.64-1.09-.545c-1.316-.657-1.915.313-2.337 1.376l-.766.73c.549-.338.996-.714 1.574-.71.092 0 1.516.484 1.286-.092-.04-.104.09-.052.125-.201.04-.17.055-.141.195-.033.089.069.211.113.174-.048-.017-.072-.04-.137.28-.004.15.062.095-.064.303-.09.29-.034.228-.31.364-.349.076-.022.152.058.295-.077.05-.046.11-.089.232-.057-.143-.073-.22-.014-.292.03-.146.089-.204-.037-.343.07Zm-2.23-1.923c.16-.02.32-.036.482-.046a.13.13 0 0 0 .074-.06.111.111 0 0 0 .007-.09.268.268 0 0 1 .147-.206l-.002-.003c-.258.001-.466.1-.73.211-.052.022-.024.111-.118.213a.26.26 0 0 1-.201.235.136.136 0 0 0-.09.046.113.113 0 0 0-.026.092.252.252 0 0 1-.277.061c-.2-.077-.35-.065-.448.036a.39.39 0 0 1 .398.014c.134.066.3.031.39-.082a.132.132 0 0 1 .126-.098.421.421 0 0 0 .268-.323Z",fill:"#fff"})))};
/***/},
/***/51609:
/***/e=>{e.exports=window.React;
/***/},
/***/52619:
/***/e=>{e.exports=window.wp.hooks;
/***/},
/***/56184:
/***/e=>{e.exports="assets/dist/images/details-step-f1c97616a252e4defc7b.png";
/***/},
/***/56427:
/***/e=>{e.exports=window.wp.components;
/***/},
/***/61912:
/***/(e,s,t)=>{
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
/***/(e,s,t)=>{e.exports=t(2192)}
/***/,
/***/66087:
/***/e=>{e.exports=window.lodash;
/***/},
/***/66161:
/***/e=>{e.exports=window.wp.dataControls;
/***/},
/***/66920:
/***/(e,s,t)=>{
/* harmony export */t.d(s,{
/* harmony export */Lb:()=>/* binding */c
/* harmony export */,Sc:()=>/* binding */d
/* harmony export */,_B:()=>/* binding */p
/* harmony export */,bC:()=>/* binding */_
/* harmony export */,rj:()=>/* binding */u
/* harmony export */});
/* harmony import */var n=t(47143),i=t(86087),r=t(94715),o=t(43656),l=t(52619),a=t(45793);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Update blocks content, replacing the placeholders with a content.
 *
 * @param {Object[]} blocks   Blocks to replace with the new content.
 * @param {Object}   replaces Object containing content to be replaced. The keys are the block classNames to find. The values are the content to be replaced.
 *
 * @return {Object[]} Blocks with the placeholders filled.
 */
const c=(e,s)=>e.map((e=>{const{className:t=""}=e.attributes;return Object.entries(s).forEach((([s,n])=>{t.includes(s)&&(e.attributes.content=n)})),e.innerBlocks&&(e.innerBlocks=c(e.innerBlocks,s)),e}))
/**
 * A React Hook to observe if a modal is open based on the body class.
 *
 * @param {boolean} shouldObserve If it should observe the changes.
 *
 * @return {boolean|undefined} Whether a modal is open, or `undefined` if it's not initialized yet.
 */,d=()=>{const[e,s]=(0,i.useState)(!1),[t,n]=(0,i.useState)(!1),r=(e=>{const[s,t]=(0,i.useState)();return(0,i.useEffect)((()=>{if(!e)return;
// Initialize state after modals are open or not.
setTimeout((()=>{t(document.body.classList.contains("modal-open"))}),1);const s=new window.MutationObserver((()=>{t(document.body.classList.contains("modal-open"))}));return s.observe(document.body,{attributes:!0,attributeFilter:["class"]}),()=>{s.disconnect()}}),[e]),s})(!t);return(0,i.useLayoutEffect)((()=>{t?s(!1):!1===r&&
// If no modal is open, it's time to open.
s(!0)}),[t,r]),[e,n]},u=e=>{const{patterns:s}=(0,n.useSelect)((e=>({patterns:e(r.store)?.getPatternsByBlockTypes("sensei-lms/post-content")||e(r.store).__experimentalGetPatternsByBlockTypes("sensei-lms/post-content")}))),{template:t}=(0,n.useSelect)((e=>({template:e(r.store).getTemplate()}))),{resetBlocks:i}=(0,n.useDispatch)(r.store),o=s.find((e=>e.name===t?.[0]?.[1]?.slug));
// Set default pattern with replaced content.
return()=>{if(!o)return;const s=c(o.blocks,e);i(s)}},p=()=>{const{postType:e}=(0,n.useSelect)((e=>({postType:e(o.store).getCurrentPostType()})),[]);return(s,t)=>{window.sensei_log_event(s,{post_type:e,...t})}},_=()=>{const{senseiProExtension:e}=(0,n.useSelect)((e=>({senseiProExtension:e(a/* .EXTENSIONS_STORE */.z).getSenseiProExtension()})),[]);
/**
   * Filters if the editor wizard upsells should show or not
   *
   * @since 4.1.0
   *
   * @param {boolean} hideEditorWizardUpsell Whether to hide the editor wizard upsells.
   * @return {boolean} Whether to hide the editor wizard upsells.
   */return(0,l.applyFilters)("senseiEditorWizardUpsellHide",!e||!0===e.is_activated)}}
/***/,
/***/74454:
/***/(e,s,t)=>{
/* harmony export */t.d(s,{
/* harmony export */A:()=>p
/* harmony export */});
/* harmony import */var n=t(47143),i=t(56427),r=t(86087),o=t(43656),l=t(76522),a=t(45998),c=t(66920),d=(t(61912),t(37592)),u=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Editor wizard modal component.
 */
const p=()=>{const e=(0,r.useState)({}),s=e[0],{editPost:t,savePost:p}=(0,n.useDispatch)(o.store),{setTourShowStatus:_}=(0/* .SENSEI_TOUR_STORE */,n.useDispatch)(d.rr),m=(0,c/* .useLogEvent */._B)(),[w,x]=(0,c/* .useWizardOpenState */.Sc)(),h=(0,a/* ["default"] */.A)(),g=(0,c/* .useSetDefaultPattern */.rj)({"sensei-content-description":s.description}),y=()=>{x(!0),t({meta:{_new_post:!1}}),p(),_(!0)},S=()=>{g(),y()};return(0,r.useEffect)((()=>{_(!1)}),[_]),w&&(0,u.jsx)(i.Modal,{className:"sensei-editor-wizard-modal",onRequestClose:()=>{S(),m("editor_wizard_close_modal")},children:(0/* ["default"] */,u.jsx)(l.A,{steps:h,wizardDataState:e,onCompletion:y,skipWizard:S})})};
/* harmony default export */}
/***/,
/***/74997:
/***/e=>{e.exports=window.wp.blocks;
/***/},
/***/76522:
/***/(e,s,t)=>{
/* harmony export */t.d(s,{
/* harmony export */A:()=>l
/* harmony export */});
/* harmony import */var n=t(86087),i=t(27723),r=t(66920),o=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Wizard component.
 *
 * @param {Object}   props
 * @param {Array}    props.steps           Array with the steps that will be rendered.
 * @param {Array}    props.wizardDataState Wizard Data and wizard data setter.
 * @param {Function} props.onCompletion    Callback to call when wizard is completed.
 * @param {Function} props.skipWizard      Function to skip wizard.
 */
const l=({steps:e,wizardDataState:s,onCompletion:t,skipWizard:l})=>{const[a,c]=(0,n.useState)(0),[d,u]=s,p=(0,r/* .useLogEvent */._B)(),_=e[a];
return(0,o.jsxs)("div",{className:"sensei-editor-wizard",children:[(0,o.jsx)(_,{wizardData:d,setWizardData:u,onCompletion:t}),(0,o.jsxs)("div",{className:"sensei-editor-wizard__footer",children:[(0,o.jsx)("div",{className:"sensei-editor-wizard__progress",children:(0,i.sprintf)(
// translators: %1$d Current step number, %2$d Number of steps.
// translators: %1$d Current step number, %2$d Number of steps.
(0,i.__)("Step %1$d of %2$d","sensei-lms"),a+1,e.length)}),_.Actions&&(0,o.jsx)("div",{className:"sensei-editor-wizard__actions",children:(0,o.jsx)(_.Actions,{goToNextStep:()=>{const s=a+1;s<e.length?(c(s),p("editor_wizard_navigate_to_next_step",{navigated_to:e[s].name})):t(d)},skipWizard:l})})]})]})};
/* harmony default export */}
/***/,
/***/77505:
/***/(e,s,t)=>{
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
/***/86087:
/***/e=>{e.exports=window.wp.element;
/***/},
/***/92279:
/***/e=>{e.exports=window.wp.plugins;
/***/},
/***/93832:
/***/e=>{e.exports=window.wp.url;
/***/},
/***/94715:
/***/e=>{e.exports=window.wp.blockEditor;
/***/},
/***/96516:
/***/(e,s,t)=>{
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
/******/;
/* harmony import */var n=t(92279),i=t(52619),r=t(74454);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
// Hide welcome tour from WPCOM.
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
// Hide welcome tour from WPCOM.
(0,i.addFilter)("a8c.WpcomBlockEditorWelcomeTour.show","sensei-lms/editor-wizard",(()=>!1)),(0,n.registerPlugin)("sensei-editor-wizard-plugin",{render:r/* ["default"] */.A,icon:null})})
/******/();