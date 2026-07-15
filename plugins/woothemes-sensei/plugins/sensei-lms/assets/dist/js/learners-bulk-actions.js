/******/(()=>{// webpackBootstrap
/******/ // The require scope
/******/var e={};
/******/
/************************************************************************/
/******/ /* webpack/runtime/global */
/******/
/******/e.g=function(){
/******/if("object"==typeof globalThis)return globalThis;
/******/try{
/******/return this||new Function("return this")();
/******/}catch(e){
/******/if("object"==typeof window)return window;
/******/}
/******/}(),
/******/
/************************************************************************/
jQuery(document).ready((function(){var t,n,s,r,a=jQuery.noConflict();!function(t){const{__}=wp.i18n;var n=a("#bulk-action-user-ids"),s=a("#bulk-action-selector-top"),r=a(".sensei-course-select"),i=a(".sensei-bulk-action-select"),c=a(".sensei_user_select_id"),o=a("#cb-select-all-1"),l=a(".sensei-students__enrolled-courses-more-link"),u=a("#cb-select-all-2"),d=a("#sensei-bulk-learner-actions-modal-toggle"),h=function(e,n){e.on("click",(function(){t.resetSelectedUserIds(),e.is(":checked")?(n.attr("checked","checked"),c.attr("checked","checked"),c.each((function(e,n){t.updateSelectedUserIdsFromCheckbox(a(n))}))):(c.removeAttr("checked"),n.removeAttr("checked")),f()}))},f=function(){var s=t.validator(),r=s.validateBulkAction(),a=s.validateSelectedUserIds();e.g.dispatchEvent(new CustomEvent("enableDisableCourseSelectionToggle",{detail:{enable:r.isValid&&a.isValid}})),n.val(JSON.stringify(t.getUserIds()))};r.select2({placeholder:window.sensei_learners_bulk_data.select_course_placeholder,width:"200px"}),i.select2({minimumResultsForSearch:-1,width:"200px"}),c.on("change",(function(e){var n=a(this);e.preventDefault(),e.stopPropagation(),t.updateSelectedUserIdsFromCheckbox(n),f()})),h(o,u),h(u,o),d.attr("disabled",!0),l.on("click",(function(e){e.preventDefault(),e.stopPropagation(),a(e.target).addClass("hidden").prev().removeClass("hidden");let t=a(e.target).attr("data-user-id"),n=a(e.target).attr("data-nonce"),s=a(e.target).prev(),r={action:"get_course_list",user_id:t,nonce:n};a.ajax({type:"POST",url:ajax_object.ajax_url,data:r,success:function(e){s.append(e.data)},error:function(e){s.append("<p>"+__("There was an error fetching courses:","sensei-lms")+e.statusText+": "+e.status+"</p>")}})})),s.on("change",(function(){t.setAction(s.val().trim()),f()}))}((t=[],n=[],s="",r={isValid:!0,reason:""},{updateSelectedUserIdsFromCheckbox:function(e){var n=parseInt(e.val(),10),s=t.indexOf(n);return e.is(":checked")?s<0&&t.push(n):s>-1&&t.splice(s,1),this},getUserIds:function(){return t},setAction:function(e){return s=e,this},setCourseIds:function(e){var t,s,r;return t=e,s=function(e){return parseInt(e,10)},r=[],a.each(t,(function(e,t){r.push(s(t))})),n=r,this},resetSelectedUserIds:function(){return t=[],this},resetAll:function(){return this.resetSelectedUserIds(),n=[],s="",this},validator:function(){return{validateBulkAction:function(){return""==s||0==s?{isValid:!1,reason:"Select an action"}:r},validateCourseIds:function(){return 0===(e=n,t=function(e){return!isNaN(e)},s=[],a.each(e,(function(e,n){t(n)&&s.push(n)})),s).length?{isValid:!1,reason:"Select a course"}:r;var e,t,s},validateSelectedUserIds:function(){return 0===t.length?{isValid:!1,reason:"Select some learners"}:r},validate:function(){for(var e,t=[this.validateSelectedUserIds,this.validateBulkAction,this.validateCourseIds];t.length>0;)if(!(e=t.shift().call(this)).isValid)return e;return r}}},validate:function(){return this.validator().validate()}}))}))})
/******/();