/******/(()=>{// webpackBootstrap
/******/"use strict";
/******/var e={
/***/14309:
/***/e=>{e.exports=window.wp.editPost;
/***/},
/***/27723:
/***/e=>{e.exports=window.wp.i18n;
/***/},
/***/43656:
/***/e=>{e.exports=window.wp.editor;
/***/},
/***/45953:
/***/(e,s,o)=>{
/* harmony export */o.d(s,{
/* harmony export */A:()=>n
/* harmony export */});
/* harmony import */var t=o(47143);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Helper function to fire callbacks on editor lifecycles.
 *
 * @param {Object}   options
 * @param {Function} options.subscribeListener Callback called everytime the subscribe listener is called.
 * @param {Function} options.onSetDirty        Callback called when the editor becomes dirty.
 * @param {Function} options.onSaveStart       Callback called when editor starts saving.
 * @param {Function} options.onSave            Callback called when a save is completed.
 *
 * @return {Function} Unsubscribe function.
 */
const n=({subscribeListener:e=()=>{},onSetDirty:s=()=>{},onSaveStart:o=()=>{},onSave:n=()=>{}})=>{const r=(0,t.select)("core/editor");let i=!1,l=!1;return(0,t.subscribe)((()=>{e();const t=r.isEditedPostDirty(),c=r.isSavingPost()&&!r.isAutosavingPost();!l&&t?(
// If editor becomes dirty.
l=!0,s()):l=t,i&&!c?(
// If it completed a saving.
i=c,n()):!i&&c?(
// If it started saving.
i=c,o()):i=c}))};
/* harmony default export */}
/***/,
/***/47143:
/***/e=>{e.exports=window.wp.data;
/***/},
/***/82127:
/***/(e,s,o)=>{
/* harmony export */o.d(s,{
/* harmony export */b:()=>/* binding */g
/* harmony export */});
/* harmony import */var t=o(47143),n=o(27723),r=o(94715),i=o(14309),l=o(43656),c=o(45953);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
// Sensei blocks by post type.
const a={course:{outline:"sensei-lms/course-outline",takeCourse:"sensei-lms/button-take-course",contactTeacher:"sensei-lms/button-contact-teacher",courseProgress:"sensei-lms/course-progress",viewResults:"sensei-lms/button-view-results"},lesson:{lessonActions:"sensei-lms/lesson-actions",lessonProperties:"sensei-lms/lesson-properties",contactTeacher:"sensei-lms/button-contact-teacher",featuredVideo:"sensei-lms/featured-video"}},u={course:{"meta-box-course-lessons":[a.course.outline],"meta-box-module_course_mb":[a.course.outline],"meta-box-course-video":Object.values(a.course)},lesson:{"meta-box-lesson-info":[a.lesson.lessonProperties]}},d=(0,t.select)(r.store),p=(0,t.select)(l.store),b=(0,t.dispatch)(l.store),m=(0,t.select)(i.store),w=(0,t.dispatch)(i.store),h=p.isEditorPanelEnabled?p.isEditorPanelEnabled:m.isEditorPanelEnabled,v=b.toggleEditorPanelEnabled?b.toggleEditorPanelEnabled:w.toggleEditorPanelEnabled,g=e=>{if(!d)return;const{createWarningNotice:s,removeNotice:o}=(0,t.dispatch)("core/notices");let r;(0,c/* ["default"] */.A)({subscribeListener:()=>{const e=d.getBlocks();
// Check if blocks were changed.
e!==r&&(r=e,i(),l())}});
/**
   * Check whether it has Sensei blocks.
   */
const i=()=>{Object.entries(u[e]).forEach((([e,s])=>{!p(s)!==h(e)&&v(e)})),
// Prevent submit course modules.
document.querySelectorAll("#module_course_mb input").forEach((e=>{e.disabled=!h("meta-box-module_course_mb")})),
// Don't submit lesson length and complexity values in metaboxes.
document.querySelectorAll("#lesson-info input, #lesson-info select").forEach((e=>{e.disabled=!h("meta-box-lesson-info")}))},l=()=>{const t=p(Object.values(a[e])),r=window?.sensei?.courseThemeEnabled;t||r?o("sensei-using-template"):s((0,n.__)("It looks like this course page doesn't have any Sensei blocks. This means that content will be handled by custom templates.","sensei-lms"),{id:"sensei-using-template",isDismissible:!0,actions:[{label:(0,n.__)("Learn more","sensei-lms"),url:"https://senseilms.com/documentation/course-page-blocks/"}]})},p=e=>e.some((e=>d.getGlobalBlockCount(e)>0));
/**
   * Toggle metaboxes if a replacement block is present or not.
   */};
// Metabox replacements.
}
/***/,
/***/94715:
/***/e=>{e.exports=window.wp.blockEditor;
/***/},
/***/98490:
/***/e=>{e.exports=window.wp.domReady;
/***/
/******/}},s={};
/************************************************************************/
/******/ // The module cache
/******/
/******/
/******/ // The require function
/******/function o(t){
/******/ // Check if module is in cache
/******/var n=s[t];
/******/if(void 0!==n)
/******/return n.exports;
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
/******/return e[t](r,r.exports,o),r.exports;
/******/}
/******/
/************************************************************************/
/******/ /* webpack/runtime/compat get default export */
/******/
/******/ // getDefaultExport function for compatibility with non-harmony modules
/******/o.n=e=>{
/******/var s=e&&e.__esModule?
/******/()=>e.default
/******/:()=>e
/******/;
/******/return o.d(s,{a:s}),s;
/******/},
/******/ // define getter functions for harmony exports
/******/o.d=(e,s)=>{
/******/for(var t in s)
/******/o.o(s,t)&&!o.o(e,t)&&
/******/Object.defineProperty(e,t,{enumerable:!0,get:s[t]})
/******/;
/******/},
/******/o.o=(e,s)=>Object.prototype.hasOwnProperty.call(e,s)
/******/;
/* harmony import */var t=o(98490),n=o.n(t),r=o(82127);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
n()((()=>{(0,r/* .startBlocksTogglingControl */.b)("lesson");
// Lessons Write Panel.
const e=jQuery("#lesson-complexity-options");e.length>0&&e.select2({width:"resolve"});const s=jQuery("#lesson-prerequisite-options");s.length>0&&s.select2({width:"resolve"});const o=jQuery("#lesson-course-options");o.length>0&&o.select2({width:"resolve"});const t=jQuery("#lesson-module-options");t.length>0&&t.select2({width:"resolve"}),
// Refresh the prerequisite meta box when the course changes in order to get the relevant prerequisites.
jQuery("#lesson-course-options").on("change",(function(){
// Try to get the lesson ID from the wp data store. If not present, fallback to getting it from the DOM.
const e=wp.data.select("core/editor")?.getCurrentPostId()||jQuery("#post_ID").val(),s=jQuery(this).val();jQuery.get(ajaxurl,{action:"get_prerequisite_meta_box_content",lesson_id:e,course_id:s,security:window.sensei_lesson_metadata.get_prerequisite_meta_box_content_nonce},(function(e){""!==e&&(
// Replace the meta box and re-initialize select2.
jQuery("> .inside","#lesson-prerequisite").html(e),jQuery("#lesson-prerequisite-options").select2({width:"resolve"}))}))}))}))})
/******/();