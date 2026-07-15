/******/(()=>{// webpackBootstrap
/******/"use strict";
/******/var e={
/***/1455:
/***/e=>{e.exports=window.wp.apiFetch;
/***/},
/***/1486:
/***/(e,s,t)=>{
/* harmony export */t.d(s,{
/* harmony export */A:()=>l
/* harmony export */});
/* harmony import */var n=t(56427),i=t(27723),o=t(96516),r=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Course access period promo sidebar component.
 */
const l=()=>(0,r.jsx)(n.PanelBody,{title:(0,i.__)("Access Period","sensei-lms"),initialOpen:!0,children:(0,r.jsxs)("div",{className:"sensei-course-access-period-promo",children:[(0,r.jsx)("p",{children:(0,r.jsx)(n.ExternalLink,{href:(0,o/* .getSenseiProUpsellUrl */.h)("course_access_period"),children:(0,i.__)("Upgrade to Sensei Pro","sensei-lms")})}),(0,r.jsxs)("div",{className:"sensei-course-access-period-promo__holder",children:[(0,r.jsx)("p",{children:(0,i.__)("Set how long learners will have access to this course.","sensei-lms")}),(0,r.jsx)(n.SelectControl,{label:(0,i.__)("Expiration","sensei-lms"),options:[{label:(0,i.__)("No expiration","sensei-lms")},{label:(0,i.__)("Expires after","sensei-lms")}]})]})]})});
/* harmony default export */}
/***/,
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
var n=t(51609),i=Symbol.for("react.element"),o=Symbol.for("react.fragment"),r=Object.prototype.hasOwnProperty,l=n.__SECRET_INTERNALS_DO_NOT_USE_OR_YOU_WILL_BE_FIRED.ReactCurrentOwner,a={key:!0,ref:!0,__self:!0,__source:!0};function c(e,s,t){var n,o={},c=null,d=null;for(n in void 0!==t&&(c=""+t),void 0!==s.key&&(c=""+s.key),void 0!==s.ref&&(d=s.ref),s)r.call(s,n)&&!a.hasOwnProperty(n)&&(o[n]=s[n]);if(e&&e.defaultProps)for(n in s=e.defaultProps)void 0===o[n]&&(o[n]=s[n]);return{$$typeof:i,type:e,key:c,ref:d,props:o,_owner:l.current}}s.Fragment=o,s.jsx=c,s.jsxs=c}
/***/,
/***/3582:
/***/e=>{e.exports=window.wp.coreData;
/***/},
/***/14136:
/***/(e,s,t)=>{
/* harmony export */t.d(s,{
/* harmony export */A:()=>h
/* harmony export */});
/* harmony import */var n=t(27723),i=t(47143),o=t(56427),r=t(3582),l=t(1455),a=t.n(l),c=t(86087),d=t(52619),u=t(96516),p=t(45953),m=t(90551),_=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
const h=()=>{const e=(0,i.useSelect)((e=>e("core/editor").getCurrentPost())),[s,t]=(0,c.useState)(window.sensei.courseSettingsSidebar.author);let l=window.sensei.courseSettingsSidebar.courses;l&&l.length&&(l=l.map((e=>({label:e.post_title,value:e.ID}))),l.push({label:(0,n.__)("None","sensei-lms"),value:0}));let h=window.sensei.courseSettingsSidebar.teachers;h&&h.length&&(h=h.map((e=>({label:e.display_name,value:e.ID}))));const[g,b]=(0,r.useEntityProp)("postType","course","meta"),x=g._course_featured,w=g._course_prerequisite,f=g.disable_notification,v=g._sensei_self_enrollment_not_allowed,j=g._open_access;(0,c.useEffect)((()=>(0,p/* ["default"] */.A)({onSaveStart:()=>{if(s!==e.author){const t=(0,m/* .getFirstBlockByName */.w)("sensei-lms/course-outline",(0,i.select)("core/block-editor").getBlocks()),n=t&&(0,m/* .extractStructure */.xn)(t.innerBlocks).filter((e=>e.slug)).map((e=>e.slug));a()({path:"/sensei-internal/v1/course-utils/update-teacher",method:"PUT",data:{[window.sensei.courseSettingsSidebar.nonce_name]:window.sensei.courseSettingsSidebar.nonce_value,post_id:e.id,teacher:s,custom_slugs:JSON.stringify(n)}}).catch((e=>{e.message&&(0,i.dispatch)("core/notices").createNotice("warning",e.message,{isDismissible:!0})}))}}})));
/**
   * Allows to show or hide the multiple teachers upgrade.
   *
   * @since 4.9.0
   *
   * @param {boolean} Whether the upgrade should be hidden or not. Default false. True will hide the upgrade.
   */
const S=(0,d.applyFilters)("senseiCourseSettingsMultipleTeachersUpgradeHide",!1),P=(0,c.useMemo)((()=>(0,d.applyFilters)("senseiCourseSettingsTeachersAfter",(()=>null))),[]);
/**
   * Returns the component to render after the teacher course setting.
   *
   * @since 4.9.0
   *
   * @param {Function} The existing component hooked into the filter.
   */
return(0,_.jsxs)(o.PanelBody,{title:(0,n.__)("General","sensei-lms"),initialOpen:!0,children:[(0,_.jsx)("h3",{children:(0,n.__)("Teacher","sensei-lms")}),h.length?(0,_.jsx)(o.SelectControl,{value:s,options:h,onChange:s=>{s=parseInt(s),t(s),(0,i.dispatch)("core").editEntityRecord("postType","course",e.id,{author:s})}}):null,!S&&(0,_.jsxs)("div",{className:"sensei-course-coteachers-wrapper",children:[(0,n.__)("Multiple teachers?","sensei-lms")," ",(0,_.jsx)(o.ExternalLink,{href:(0,u/* .getSenseiProUpsellUrl */.h)("co-teachers"),children:(0,n.__)("Upgrade to Sensei Pro","sensei-lms")})]}),(0,_.jsx)(P,{courseAuthorId:s,courseId:e.id}),(0,_.jsx)(o.HorizontalRule,{}),(0,_.jsx)("h3",{children:(0,n.__)("Course Prerequisite","sensei-lms")}),l.length?null:(0,_.jsx)("p",{children:(0,n.__)("No courses exist yet. Please add some first.","sensei-lms")}),l.length?(0,_.jsx)(o.SelectControl,{value:w,options:l,onChange:e=>b({...g,_course_prerequisite:e})}):null,(0,_.jsx)(o.HorizontalRule,{}),(0,_.jsx)("h3",{children:(0,n.__)("Enrollment","sensei-lms")}),(0,_.jsx)(o.CheckboxControl,{label:(0,n.__)("Don't allow self-enrollment","sensei-lms"),checked:v,onChange:e=>b({...g,_sensei_self_enrollment_not_allowed:e}),help:(0,n.__)("Students need to be manually enrolled by teachers or administrators. Not available for paid courses.","sensei-lms")}),window.sensei.courseSettingsSidebar.features?.open_access&&(0,_.jsxs)(_.Fragment,{children:[(0,_.jsx)(o.HorizontalRule,{}),(0,_.jsx)("h3",{children:(0,n.__)("Access","sensei-lms")}),(0,_.jsx)(o.CheckboxControl,{label:(0,n.__)("Open access","sensei-lms"),checked:j,onChange:e=>b({...g,_open_access:e}),help:(0,n.__)("Visitors can take this course without signing up. Not available for paid courses.","sensei-lms")})]}),(0,_.jsx)(o.HorizontalRule,{}),(0,_.jsx)("h3",{children:(0,n.__)("Featured Course","sensei-lms")}),(0,_.jsx)(o.CheckboxControl,{label:(0,n.__)("Feature this course","sensei-lms"),checked:"featured"==x,onChange:e=>b({...g,_course_featured:e?"featured":""})}),(0,_.jsx)(o.HorizontalRule,{}),(0,_.jsx)("h3",{children:(0,n.__)("Course Notifications","sensei-lms")}),(0,_.jsx)(o.CheckboxControl,{label:(0,n.__)("Disable notifications on this course","sensei-lms"),checked:f,onChange:e=>b({...g,disable_notification:e})}),(0,_.jsx)(o.HorizontalRule,{}),(0,_.jsx)("h3",{children:(0,n.__)("Course Management","sensei-lms")}),(0,_.jsx)("p",{children:(0,_.jsx)("a",{href:`/wp-admin/admin.php?page=sensei_learners&course_id=${e.id}&view=learners`,children:(0,n.__)("Manage Students","sensei-lms")})}),(0,_.jsx)("p",{children:(0,_.jsx)("a",{href:`/wp-admin/admin.php?page=sensei_grading&course_id=${e.id}&view=learners`,children:(0,n.__)("Manage Grading","sensei-lms")})})]})};
/* harmony default export */}
/***/,
/***/14309:
/***/e=>{e.exports=window.wp.editPost;
/***/},
/***/19899:
/***/(e,s,t)=>{
/* harmony export */t.d(s,{
/* harmony export */A:()=>l
/* harmony export */});
/* harmony import */var n=t(27723),i=t(56427),o=t(65471),r=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Video-Based Course Sidebar component.
 */
const l=()=>{const[e,s]=(0,o/* ["default"] */.A)("sensei_course_video_autocomplete"),[t,l]=(0,o/* ["default"] */.A)("sensei_course_video_autopause"),[a,c]=(0,o/* ["default"] */.A)("sensei_course_video_required");
return(0,r.jsxs)(i.PanelBody,{title:(0,n.__)("Video","sensei-lms"),initialOpen:!0,children:[(0,r.jsx)(i.ToggleControl,{label:(0,n.__)("Autocomplete lesson","sensei-lms"),checked:e,onChange:s,help:(0,n.__)("Complete lesson when video ends.","sensei-lms")}),(0,r.jsx)(i.ToggleControl,{label:(0,n.__)("Autopause","sensei-lms"),checked:t,onChange:l,help:(0,n.__)("Pause video when student navigates away.","sensei-lms")}),(0,r.jsx)(i.ToggleControl,{label:(0,n.__)("Required","sensei-lms"),checked:a,onChange:c,help:(0,n.__)("Video must be viewed before completing the lesson.","sensei-lms")})]})};
/* harmony default export */}
/***/,
/***/27723:
/***/e=>{e.exports=window.wp.i18n;
/***/},
/***/38139:
/***/(e,s,t)=>{
/* harmony export */t.d(s,{
/* harmony export */AV:()=>/* binding */x
/* harmony export */,Fk:()=>/* binding */b
/* harmony export */,QX:()=>/* binding */g
/* harmony export */,cz:()=>/* binding */w
/* harmony export */});
/* harmony import */var n=t(52619),i=t(14309),o=t(43656),r=t(27723),l=t(47143),a=t(56427),c=t(55956),d=t(1486),u=t(79347),p=t(19899),m=t(14136),_=t(48597),h=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
o.PluginDocumentSettingPanel||(o.PluginDocumentSettingPanel=i.PluginDocumentSettingPanel),o.PluginSidebar||(o.PluginSidebar=i.PluginSidebar),o.PluginSidebarMoreMenuItem||(o.PluginSidebarMoreMenuItem=i.PluginSidebarMoreMenuItem);const g="sensei-lms-course-settings-sidebar",b="sensei-lms-document-settings-sidebar",x=()=>{
/**
   * Filter to show or hide course pricing component.
   *
   * @since 4.9.0
   *
   * @hook  senseiCoursePricingHide This hook allows to pass a boolean value for hiding course pricing upsell.
   * @return {boolean} 			  Hide the component.
   */
const e=(0,n.applyFilters)("senseiCoursePricingHide",!1),s=(0,n.applyFilters)("senseiCourseAccessPeriodHide",!1);
/**
   * Filter to show or hide course expiration component.
   *
   * @since 4.9.0
   *
   * @hook  senseiCourseAccessPeriodHide This hook allows to pass a boolean value for hiding course expiration (access period) upsell.
   * @return {boolean} 				   Hide the component.
   */
return(0,h.jsxs)(h.Fragment,{children:[(0,h.jsx)(o.PluginSidebarMoreMenuItem,{target:g,icon:(0/* ["default"] */,h.jsx)(_.A,{height:"20",width:"20"}),children:(0,r.__)("Course Settings","sensei-lms")}),(0,h.jsxs)(o.PluginSidebar,{name:g,title:(0,r.__)("Course Settings","sensei-lms"),icon:(0/* ["default"] */,h.jsx)(_.A,{height:"20",width:"20"}),children:[!e&&(0/* ["default"] */,h.jsx)(c.A,{}),!s&&(0/* ["default"] */,h.jsx)(d.A,{}),(0,h.jsx)(a.Slot,{name:"SenseiCourseSidebar"}),(0/* ["default"] */,h.jsx)(u.A,{}),(0/* ["default"] */,h.jsx)(p.A,{}),(0/* ["default"] */,h.jsx)(m.A,{})]})]})},w=()=>{if((0,l.useSelect)((e=>(e(o.store).isEditorPanelOpened?e(o.store).isEditorPanelOpened:e(i.store).isEditorPanelOpened)(`${b}/${b}`)))){const e=(0,l.dispatch)(o.store).toggleEditorPanelOpened?(0,l.dispatch)(o.store).toggleEditorPanelOpened:(0,l.dispatch)(i.store).toggleEditorPanelOpened;
// when 'Course Settings' is clicked, isSenseiEditorPanelOpen returns true, so we open the 'Course Settings'
// plugin sidebar and then close the 'Sensei Settings' panel which sets isSenseiEditorPanelOpen back to false.
(0,l.dispatch)(i.store).openGeneralSidebar(`${g}/${g}`),e(`${b}/${b}`)}
return(0,h.jsx)(o.PluginDocumentSettingPanel,{name:b,title:(0,r.__)("Course Settings","sensei-lms"),className:"sensei-plugin-document-setting-panel"})}}
/***/,
/***/41544:
/***/e=>{e.exports=JSON.parse('{"name":"sensei-lms/course-outline"}');
/***/},
/***/43656:
/***/e=>{e.exports=window.wp.editor;
/***/},
/***/45953:
/***/(e,s,t)=>{
/* harmony export */t.d(s,{
/* harmony export */A:()=>i
/* harmony export */});
/* harmony import */var n=t(47143);
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
const i=({subscribeListener:e=()=>{},onSetDirty:s=()=>{},onSaveStart:t=()=>{},onSave:i=()=>{}})=>{const o=(0,n.select)("core/editor");let r=!1,l=!1;return(0,n.subscribe)((()=>{e();const n=o.isEditedPostDirty(),a=o.isSavingPost()&&!o.isAutosavingPost();!l&&n?(
// If editor becomes dirty.
l=!0,s()):l=n,r&&!a?(
// If it completed a saving.
r=a,i()):!r&&a?(
// If it started saving.
r=a,t()):r=a}))};
/* harmony default export */}
/***/,
/***/47143:
/***/e=>{e.exports=window.wp.data;
/***/},
/***/48310:
/***/(e,s,t)=>{
/* harmony export */t.d(s,{
/* harmony export */CJ:()=>/* binding */n
/* harmony export */,uX:()=>/* binding */i
/* harmony export */});
/* unused harmony export SENSEI_PREVIEW_QUERY */
const n="sensei-theme",i="wordpress-theme"}
/***/,
/***/48597:
/***/(e,s,t)=>{
/* harmony export */t.d(s,{
/* harmony export */A:()=>l
/* harmony export */});
/* harmony import */var n,i,o=t(51609);
/* harmony import */function r(){return r=Object.assign?Object.assign.bind():function(e){for(var s=1;s<arguments.length;s++){var t=arguments[s];for(var n in t)({}).hasOwnProperty.call(t,n)&&(e[n]=t[n])}return e},r.apply(null,arguments)}
/* harmony default export */const l=function(e){
return o.createElement("svg",r({viewBox:"0 0 24 24",fill:"none",xmlns:"http://www.w3.org/2000/svg"},e),n||(n=o.createElement("circle",{cx:12,cy:12,r:12,fill:"#43AF99"})),i||(i=o.createElement("path",{fillRule:"evenodd",clipRule:"evenodd",d:"M9.835 15.38c.3-.23.179-.474.6-.563-.02.194.146.391.251.563-.109-.367-.002-.536.08-.72.347-.785-.662-1.293-1.35-1.418.235-.164.399-.327.694-.355a2.377 2.377 0 0 0-1.058.23c-1.112.531-1.993-.523-1.41-1.48.31-.51.664-.519.982-.865.077.178.103.372.075.564a.919.919 0 0 0 .049-.664c-.104-.336-.4-.338-.456-.821-.012-.101-.105.056-.263-.077-.038-.032-.113-.09-.163-.064-.085.044-.18.008-.232.034-.083.041-.109-.045-.2.016-.16.107-.178-.013-.332.005-.193.023-.32.261-.43.144-.102-.108-.206.075-.28.075-.05 0-.311.317-.426.028-.086-.216-.28.206-.382.063-.033-.046-.123.108-.18-.044-.014-.035 0-.078-.108-.027-.215.099-.138-.06-.207-.144-.083-.103-.113-.103-.068-.27.036-.133-.019-.33.2-.364.055-.008.107-.005.184-.148.096-.18.231-.093.207-.175-.036-.119.143-.28.226-.355.11-.103.254-.252.306-.396a.63.63 0 0 1 .102-.141c.081-.084.105-.003.227-.045.088-.03.02.053.106-.07.028-.038.105-.001.19-.039.259-.112.283-.11.347-.371.012-.05.025-.088.08-.083.109.01.134-.052.2-.05.061.001.083-.03.115-.068.18-.216.277-.055.357-.072.06-.012.022-.142.184-.102.23.057.155-.05.303-.015.174.041.186.19.306.225.143.042.211.198.307.196.337-.005.235.23.448.323-.16-.161.012-.421-.352-.455-.08-.007-.11-.127-.23-.183-.146-.067-.13-.21-.394-.27.068-.04.089.005.13-.073.058-.11.09-.046.113-.113.02-.063.006-.099.165-.155.165-.06.325-.195.472-.188.13.006.185-.08.177-.19-.008-.112-.033-.267.222-.22.153.029.15.003.15-.1-.002-.102.04-.165.174-.16.098.002.194-.003.231-.117.03-.091.207-.114.302-.148.317-.114.361.05.447-.095.07-.117.196-.317.337-.175.028.029.054.05.15-.056.08-.088.27-.2.337-.048.027.06.086.121.138.044a.08.08 0 0 1 .053-.039c.05-.01.079-.024.104-.036.218-.101.314-.095.213.125-.142.316.792-.192.532.151-.095.126.538.197.63.254.05.032.048.059.144.077.271.05.267.026.284.243.007.098.107.043.107.168 0 .535.472.266.549.399.012.022.032.042.079.042.149 0 .157-.03.224.089.027.047.05.072.127.096.12.037.112.05.068.138-.054.104.03.102.138.112.1.01.148.062.216.138.11.122.284.156.43.227.084.04.002.14.143.243.104.077.156.066.016.165-.59.418.22.305.446.694.051.087.118.195.216.295.225.23.1.293.221.437.07.083.015.063.13.137.272.175-.105.292-.319.212-.097-.035-.166-.085-.147-.025.016.049-.01.083-.052.12-.125.112.123.068.181.06.181-.025.664-.076.66.093-.005.22.136.27.25.284.185.024.238.057.34.226.092.152.145.07.288.205.097.093.217.258.02.282-.047.005-.099 0-.12.017a.411.411 0 0 1-.14.066c-.295.09.14.136.246.113.093-.02.209-.05.3-.027.057.015.062.08.244.107.06.01.036.099.006.16-.104.214.191.1.16.263-.017.093.11.245-.067.248-.057.001-.117-.015-.115.034.004.105-.165-.03-.317.115-.056.054-.19.092-.272-.009-.032-.038-.07-.069-.218-.023-.144.046-.242.204-.306-.04-.017-.064-.05-.065-.142-.097-.125-.043-.114-.258-.297-.12a.24.24 0 0 1-.214.039c-.144-.037-.303.012-.317-.096-.021-.179-.191-.305-.377-.296-.147.008-.278.034-.355-.137.057.195.207.208.382.208.144 0 .23.075.255.225.045.265.204.099.406.223.1.06.17.159.21.273.042.118.37-.024.282.258-.037.122-.107.168-.242.266-.4.294-.5.004-.618.239-.062.121-.063.031-.196.09-.22.098-.36-.128-.522-.045-.182.094-.168-.08-.352.037-.152.097-.308-.074-.38.192-.063.227-.322.232-.44.11-.189-.194-.132.229-.362.054-.123-.091-.213.043-.392.045-.33.005-.489-.282-.65-.107-.192.206-.331-.032-.334-.242-.003-.216-.777-.144-1.185-.256-.225-.062-.932.013-.702-.35-.372.39.456.366.682.455.136.053.245.095.377.114.13.296.214.617.227 1.007.043-.214.053-.433.028-.649-.043-.383.242.19.276.272.184.45-.022 1.278-.488 1.526a2.957 2.957 0 0 0-.562-.99c.256.392.616 1.192.327 1.65a1.023 1.023 0 0 1-.55-.483c.077.333.413.702.818.58.707-.213.704.233 1.641.307.682.111 1.654 0 2.118.037.254.02 1.32.197 1.315.465-.02 1.105-.438 1.164-1.539 1.268-.64.06-1.134.085-1.823.11-1.54.058-3.391.06-4.868 0-.724-.03-1.072-.036-1.841-.137-.769-.1-1.19-.363-1.178-1.187.005-.304.905-.594 1.2-.628.347-.039.901.005 1.405-.116.527-.127.747-.21 1.135-.508Zm5.347-6.052c-.167-.042-.051-.138-.339-.014-.17.073-.194-.13-.365-.094-.172.036-.242-.125-.499-.166-.318-.05-.088-.133-.592-.032-.097.02-.179-.09-.481-.052-.355.046-.23.084-.445-.115-.272-.251-.488-.082-.767-.184.216.166.368.019.622.221-.242.138-.523.802-.962.844.478.107.709.354 1.148.413.504.068.882.118 1.151.531.301.463.44.196.874.168.275-.017.282-.185.328-.362.063-.245.126-.256.31-.289.213-.037.163-.092.107-.156-.15-.172.019-.207.146-.244.222-.064.042-.075.042-.166-.278-.09-.063-.217.092-.273.169.105.242.087.317.073.109-.021.181.03.273-.028-.135.014-.163-.037-.278-.02-.051.007-.112.01-.219-.054-.18-.107-.27.048-.463 0Zm-2.28 1.64-1.09-.545c-1.316-.657-1.915.313-2.337 1.376l-.766.73c.549-.338.996-.714 1.574-.71.092 0 1.516.484 1.286-.092-.04-.104.09-.052.125-.201.04-.17.055-.141.195-.033.089.069.211.113.174-.048-.017-.072-.04-.137.28-.004.15.062.095-.064.303-.09.29-.034.228-.31.364-.349.076-.022.152.058.295-.077.05-.046.11-.089.232-.057-.143-.073-.22-.014-.292.03-.146.089-.204-.037-.343.07Zm-2.23-1.923c.16-.02.32-.036.482-.046a.13.13 0 0 0 .074-.06.111.111 0 0 0 .007-.09.268.268 0 0 1 .147-.206l-.002-.003c-.258.001-.466.1-.73.211-.052.022-.024.111-.118.213a.26.26 0 0 1-.201.235.136.136 0 0 0-.09.046.113.113 0 0 0-.026.092.252.252 0 0 1-.277.061c-.2-.077-.35-.065-.448.036a.39.39 0 0 1 .398.014c.134.066.3.031.39-.082a.132.132 0 0 1 .126-.098.421.421 0 0 0 .268-.323Z",fill:"#fff"})))};
/***/},
/***/51609:
/***/e=>{e.exports=window.React;
/***/},
/***/52619:
/***/e=>{e.exports=window.wp.hooks;
/***/},
/***/55434:
/***/e=>{e.exports=JSON.parse('{"name":"sensei-lms/course-outline-module"}');
/***/},
/***/55956:
/***/(e,s,t)=>{
/* harmony export */t.d(s,{
/* harmony export */A:()=>c
/* harmony export */});
/* harmony import */var n=t(27723),i=t(52619),o=t(89877),r=t(56427),l=t(96516),a=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
/**
 * Course Pricing Promo Sidebar component.
 */
const c=()=>{
/**
   * Filters to get description for pricing component.
   *
   * @since 4.1.0
   *
   * @hook  senseiCoursePricingDescription This hook allows to pass a string value for the course pricing promo description.
   * @return {string} 					 Description text for course pricing promo sidebar.
   */
const e=(0,i.applyFilters)("senseiCoursePricingDescription",(0,n.__)("Sell this course using WooCommerce - integrates with subscriptions, memberships, affiliates, and more.","sensei-lms"));
return(0,a.jsxs)(r.PanelBody,{title:(0,n.__)("Pricing","sensei-lms"),initialOpen:!0,children:[(0,a.jsxs)("p",{children:[" ",(0,o.escapeHTML)(e)," "]}),(0,a.jsx)("p",{children:(0,a.jsx)(r.ExternalLink,{href:(0,l/* .getSenseiProUpsellUrl */.h)("course_pricing"),children:(0,n.__)("Upgrade to Sensei Pro","sensei-lms")})}),(0,a.jsx)("p",{className:"sensei-pricing-promo__upgrade-new-course-text",children:(0,n.__)("To access this course, learners will need to purchase one of the assigned products.","sensei-lms")}),(0,a.jsxs)("div",{className:"sensei-pricing-promo__upgrade-new-course",children:[(0,a.jsx)("p",{className:"sensei-pricing-promo__upgrade-new-course-text",children:(0,n.__)("You don't have any products yet. Get started by creating a new WooCommerce product.","sensei-lms")}),(0,a.jsx)(r.Button,{className:"sensei-pricing-promo__upgrade_new_course_mock_button",disabled:!0,children:(0,n.__)("Create a product","sensei-lms")})]})]})};
/* harmony default export */}
/***/,
/***/56427:
/***/e=>{e.exports=window.wp.components;
/***/},
/***/59870:
/***/e=>{e.exports=JSON.parse('{"name":"sensei-lms/course-outline-lesson"}');
/***/},
/***/62540:
/***/(e,s,t)=>{e.exports=t(2192)}
/***/,
/***/65471:
/***/(e,s,t)=>{
/* harmony export */t.d(s,{
/* harmony export */A:()=>i
/* harmony export */});
/* harmony import */var n=t(3582);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * A hook that provides a value from course meta and a setter for that value.
 *
 * @param {string} metaName The name of the meta.
 *
 * @return {Array} An array containing the value and the setter.
 */
const i=e=>{const[s,t]=(0,n.useEntityProp)("postType","course","meta");return[s[e],s=>t({[e]:s})]};
/* harmony default export */}
/***/,
/***/66087:
/***/e=>{e.exports=window.lodash;
/***/},
/***/74997:
/***/e=>{e.exports=window.wp.blocks;
/***/},
/***/79347:
/***/(e,s,t)=>{
/* harmony export */t.d(s,{
/* harmony export */A:()=>u
/* harmony export */});
/* harmony import */var n=t(27723),i=t(56427),o=t(65471),r=t(48310),l=t(41544),a=t(55434),c=t(59870),d=t(62540);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
l.name,a.name,c.name;const u=()=>{const e=window.sensei?.senseiSettings?.sensei_learning_mode_all||!1,[s,t]=(0,o/* ["default"] */.A)("_course_theme");
return(0,d.jsx)(i.PanelBody,{title:(0,n.__)("Learning Mode","sensei-lms"),initialOpen:!0,children:e?(0,d.jsx)("p",{children:(0,d.jsx)("a",{href:"/wp-admin/admin.php?page=sensei-settings&tab=appearance-settings",children:(0,n.__)("Learning Mode is enabled globally.","sensei-lms")})}):(0,d.jsxs)(d.Fragment,{children:[(0,d.jsx)(i.ToggleControl,{label:(0,n.__)("Enable Learning Mode","sensei-lms"),help:(0,n.__)("Show an immersive and distraction-free view for lessons and quizzes.","sensei-lms"),checked:s===r/* .SENSEI_THEME */.CJ,onChange:e=>t(e?r/* .SENSEI_THEME */.CJ:r/* .WORDPRESS_THEME */.uX)}),(0,d.jsx)("p",{children:(0,d.jsx)("a",{href:"/wp-admin/admin.php?page=sensei-settings&tab=appearance-settings",children:(0,n.__)("Change Template","sensei-lms")})})]})})}}
/***/,
/***/82127:
/***/(e,s,t)=>{
/* harmony export */t.d(s,{
/* harmony export */b:()=>/* binding */x
/* harmony export */});
/* harmony import */var n=t(47143),i=t(27723),o=t(94715),r=t(14309),l=t(43656),a=t(45953);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
// Sensei blocks by post type.
const c={course:{outline:"sensei-lms/course-outline",takeCourse:"sensei-lms/button-take-course",contactTeacher:"sensei-lms/button-contact-teacher",courseProgress:"sensei-lms/course-progress",viewResults:"sensei-lms/button-view-results"},lesson:{lessonActions:"sensei-lms/lesson-actions",lessonProperties:"sensei-lms/lesson-properties",contactTeacher:"sensei-lms/button-contact-teacher",featuredVideo:"sensei-lms/featured-video"}},d={course:{"meta-box-course-lessons":[c.course.outline],"meta-box-module_course_mb":[c.course.outline],"meta-box-course-video":Object.values(c.course)},lesson:{"meta-box-lesson-info":[c.lesson.lessonProperties]}},u=(0,n.select)(o.store),p=(0,n.select)(l.store),m=(0,n.dispatch)(l.store),_=(0,n.select)(r.store),h=(0,n.dispatch)(r.store),g=p.isEditorPanelEnabled?p.isEditorPanelEnabled:_.isEditorPanelEnabled,b=m.toggleEditorPanelEnabled?m.toggleEditorPanelEnabled:h.toggleEditorPanelEnabled,x=e=>{if(!u)return;const{createWarningNotice:s,removeNotice:t}=(0,n.dispatch)("core/notices");let o;(0,a/* ["default"] */.A)({subscribeListener:()=>{const e=u.getBlocks();
// Check if blocks were changed.
e!==o&&(o=e,r(),l())}});
/**
   * Check whether it has Sensei blocks.
   */
const r=()=>{Object.entries(d[e]).forEach((([e,s])=>{!p(s)!==g(e)&&b(e)})),
// Prevent submit course modules.
document.querySelectorAll("#module_course_mb input").forEach((e=>{e.disabled=!g("meta-box-module_course_mb")})),
// Don't submit lesson length and complexity values in metaboxes.
document.querySelectorAll("#lesson-info input, #lesson-info select").forEach((e=>{e.disabled=!g("meta-box-lesson-info")}))},l=()=>{const n=p(Object.values(c[e])),o=window?.sensei?.courseThemeEnabled;n||o?t("sensei-using-template"):s((0,i.__)("It looks like this course page doesn't have any Sensei blocks. This means that content will be handled by custom templates.","sensei-lms"),{id:"sensei-using-template",isDismissible:!0,actions:[{label:(0,i.__)("Learn more","sensei-lms"),url:"https://senseilms.com/documentation/course-page-blocks/"}]})},p=e=>e.some((e=>u.getGlobalBlockCount(e)>0));
/**
   * Toggle metaboxes if a replacement block is present or not.
   */};
// Metabox replacements.
}
/***/,
/***/86087:
/***/e=>{e.exports=window.wp.element;
/***/},
/***/89877:
/***/e=>{e.exports=window.wp.escapeHtml;
/***/},
/***/90551:
/***/(e,s,t)=>{
/* harmony export */t.d(s,{
/* harmony export */w:()=>/* binding */l
/* harmony export */,xn:()=>/* binding */r
/* harmony export */});
/* unused harmony exports blockNames, blockTypes, syncStructureToBlocks, getCourseInnerBlocks */
/* harmony import */t(74997),t(47143)
/* harmony import */;var n=t(66087);
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
const i={module:"sensei-lms/course-outline-module",lesson:"sensei-lms/course-outline-lesson"},o=(0,n.invert)(i),r=((0,n.curry)(((e,s)=>{const{name:t,attributes:n}=s,i=Object.keys(o).includes(t),r="module"===e.type;return!!i&&(r?[e.title,e.lastTitle].includes(n.title):n.id?e.id===n.id:void 0)})),e=>{const s={module:e=>({description:e.attributes.description,lessons:r(e.innerBlocks),teacher:e.attributes.teacher,teacherId:e.attributes.teacherId,lastTitle:e.attributes.lastTitle,slug:e.attributes.slug}),lesson:e=>({draft:e.attributes.draft,preview:e.attributes.preview,initialContent:e.attributes.initialContent})};return e.map((e=>{const t=o[e.name];return{type:t,id:e.attributes.id,title:e.attributes.title,...s[t](e)}})).filter((e=>"module"===e.type||!!e.title))}),l=(e,s)=>{for(let t=0;t<s.length;t++){const n=s[t];if(e===n.name)return n;if(n.innerBlocks&&n.innerBlocks.length>0){const s=l(e,n.innerBlocks);if(s)return s}}return!1}}
/***/,
/***/92279:
/***/e=>{e.exports=window.wp.plugins;
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
/***/,
/***/98490:
/***/e=>{e.exports=window.wp.domReady;
/***/
/******/}},s={};
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
/******/var o=s[n]={
/******/ // no module.id needed
/******/ // no module.loaded needed
/******/exports:{}
/******/};
/******/
/******/ // Execute the module function
/******/
/******/
/******/ // Return the exports of the module
/******/return e[n](o,o.exports,t),o.exports;
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
/* harmony import */var n=t(47143),i=t(98490),o=t.n(i),r=t(92279),l=t(82127),a=t(90551),c=t(38139);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
(()=>{const e=(0,n.select)("core/edit-post"),s=(0,n.select)("core/editor"),t=document.getElementsByName("sensei-course-teacher-author"),i=document.getElementsByName("course_module_custom_slugs");if(e&&t.length){let o=!1;(0,n.subscribe)((()=>{if(s.isSavingPost()&&!s.isAutosavingPost()&&!e.isSavingMetaBoxes()&&i){const e=(0,a/* .getFirstBlockByName */.w)("sensei-lms/course-outline",(0,n.select)("core/block-editor").getBlocks()),s=e&&(0,a/* .extractStructure */.xn)(e.innerBlocks).filter((e=>e.slug)).map((e=>e.slug));i[0].value=JSON.stringify(s)}if(e.isSavingMetaBoxes()!==o&&(o=e.isSavingMetaBoxes(),!o)){const e=t[0].value;e&&(document.getElementsByName("post_author_override")[0].value=e)}}))}})(),o()((()=>{(0,l/* .startBlocksTogglingControl */.b)("course"),jQuery("#course-prerequisite-options").select2({width:"100%"});const e=e=>s=>{var t={course_status:s.target.dataset.courseStatus};
// Get course status from post state if it's available.
wp.data&&wp.data.select("core/editor")&&(t.course_status=wp.data.select("core/editor").getCurrentPostAttribute("status")),sensei_log_event(e,t)}
// Log when the "Add Lesson" link is clicked.;
document.querySelector("a.add-course-lesson")?.addEventListener("click",e("course_add_lesson_click")),
// Log when the "Edit Lesson" link is clicked.
document.querySelector("a.edit-lesson-action")?.addEventListener("click",e("course_edit_lesson_click"))})),
/**
 * Plugins
 */
/**
 * Plugins
 */
(0/* .pluginSidebarHandle */,r.registerPlugin)(c.QX,{render:c/* .CourseSidebar */.AV}),(0/* .pluginDocumentHandle */,r.registerPlugin)(c.Fk,{render:c/* .SenseiSettingsDocumentSidebar */.cz,icon:null})})
/******/();