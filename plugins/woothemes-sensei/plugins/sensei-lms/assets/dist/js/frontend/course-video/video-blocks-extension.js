/******/(()=>{// webpackBootstrap
/******/"use strict";
/******/var e={
/***/9737:
/***/(e,t,n)=>{
/* harmony export */n.d(t,{
/* harmony export */A:()=>r
/* harmony export */});
/**
 * Round a number with certain amount of decimal digits.
 *
 * @param {number} number The number to be rounded.
 * @param {number} digits The number of digits to appear after the decimal point.
 *
 * @return {number} Rounded number.
 */
const r=(e,t)=>{const n=Math.pow(10,t);return Math.round((e+Number.EPSILON)*n)/n};
/* harmony default export */}
/***/,
/***/23572:
/***/(e,t,n)=>{
/* harmony export */n.d(t,{
/* harmony export */k:()=>/* binding */i
/* harmony export */});
/* harmony import */var r=n(95656),o=n(53791);
/* harmony import */
/**
 * Internal dependencies
 */
/**
 * Initializes Vimeo block video player.
 *
 * @param {HTMLElement} iframe The iframe element of the Vimeo video block.
 */
const s=e=>{const t=new o/* ["default"] */.A(e),n="https://vimeo.com/"+e.src.split("?")[0].split("/").pop();
// iframe.src should be in the format:
// https://player.vimeo.com/video/VIDEO_ID?other-query-parameters=and-their-values
(0,r/* .registerVideo */.J)({pauseVideo:()=>{t.pause()},registerVideoEndHandler:e=>{t.on("ended",e)},url:n,blockElement:e.closest("figure")})},i=()=>{document.querySelectorAll(".wp-block-embed-vimeo iframe").forEach(s)}}
/***/,
/***/28908:
/***/(e,t,n)=>{
/* harmony export */n.d(t,{
/* harmony export */s:()=>/* binding */i
/* harmony export */});
/* harmony import */var r=n(95656),o=n(53791);
/* harmony import */
/**
 * Internal dependencies
 */
/**
 * Initializes the VideoPress block player.
 *
 * @param {HTMLIFrameElement} iframe The iframe of the VideoPress block.
 */
const s=e=>{const t=new o/* ["default"] */.A(e);(0,r/* .registerVideo */.J)({registerVideoEndHandler:e=>{t.on("ended",e)},pauseVideo:()=>{t.pause()},url:e.src.split("?")[0],blockElement:e.closest("figure")})},i=()=>{document.querySelectorAll(".wp-block-embed-videopress iframe, .wp-block-jetpack-videopress iframe").forEach(s)}}
/***/,
/***/38439:
/***/(e,t,n)=>{n.r(t),
/* harmony export */n.d(t,{
/* harmony export */ADAPTER_NAME:()=>/* binding */r
/* harmony export */,EMBED_PATTERN:()=>/* binding */o
/* harmony export */,getCurrentTime:()=>/* binding */a
/* harmony export */,getDuration:()=>/* binding */i
/* harmony export */,initializePlayer:()=>/* binding */s
/* harmony export */,onEnded:()=>/* binding */p
/* harmony export */,onTimeupdate:()=>/* binding */c
/* harmony export */,pause:()=>/* binding */l
/* harmony export */,play:()=>/* binding */u
/* harmony export */,setCurrentTime:()=>/* binding */d
/* harmony export */});
/**
 * Adapter name.
 */
const r="videopress",o=/(videopress|video\.wordpress)\.com\/.+/i,s=(e,t=window)=>new Promise((n=>{
// It was already initialized earlier.
const{duration:r}=e.dataset;if(r)return void n(e);t.addEventListener("message",(t=>{if(t.source!==e.contentWindow)return;const{data:r}=t;"videopress_durationchange"===r.event&&r.durationMs?(
// Set the duration to a dataset in order to be available later,
// and consider the initialization done.
e.dataset.duration=r.durationMs/1e3,
// If current time didn't return yet, set it to `0`.
e.dataset.currentTime||(e.dataset.currentTime=0),n(e)):"videopress_timeupdate"===r.event&&r.currentTimeMs?
// Set the current time to a dataset in order to be available later.
e.dataset.currentTime=r.currentTimeMs/1e3:"videopress_play"===r.event&&(
// Identify that video was already played.
e.dataset.hasPlayed="has-played")}))}))
/**
 * Get the video duration.
 *
 * @param {HTMLIFrameElement} player The player element.
 *
 * @return {Promise<number>} The duration of the video in seconds through a promise.
 */,i=e=>new Promise(((t,n)=>{const{duration:r}=e.dataset;r||n(new Error("Video duration not found")),t(parseFloat(r))}))
/**
 * Get the current video time.
 *
 * @param {HTMLIFrameElement} player The player element.
 *
 * @return {Promise<number>} The current video time in seconds through a promise.
 */,a=e=>new Promise(((t,n)=>{const{currentTime:r}=e.dataset;r?t(parseFloat(r)):n(new Error("Video current time not found"))}))
/**
 * Set the video to a current time.
 *
 * @param {HTMLIFrameElement} player  The player element.
 * @param {number}            seconds The video time in seconds to set.
 *
 * @return {Promise} A promise that resolves if the video was set to a current time successfully.
 */,d=(e,t)=>new Promise((n=>{const r=()=>{e.contentWindow.postMessage({event:"videopress_action_set_currenttime",currentTime:t},"*"),n()};e.dataset.hasPlayed?r():u(e).then((()=>l(e))).then(r)}))
/**
 * Play the video.
 *
 * @param {HTMLIFrameElement} player The player element.
 *
 * @return {Promise} A promise that resolves if the video play was sent successfully.
 */,u=e=>new Promise((t=>{e.contentWindow.postMessage({event:"videopress_action_play"},"*"),t()}))
/**
 * Pause the video.
 *
 * @param {HTMLIFrameElement} player The player element.
 *
 * @return {Promise} A promise that resolves if the video pause was sent successfully.
 */,l=e=>new Promise((t=>{e.contentWindow.postMessage({event:"videopress_action_pause"},"*"),t()}))
/**
 * Add an timeupdate event listener to the player.
 *
 * @param {HTMLIFrameElement} player   The player element.
 * @param {Function}          callback Listener callback.
 * @param {Window}            w        A custom window.
 *
 * @return {Function} The function to unsubscribe the event.
 */,c=(e,t,n=window)=>{const r=n=>{n.source===e.contentWindow&&"videopress_timeupdate"===n.data.event&&n.data.currentTimeMs&&t(n.data.currentTimeMs/1e3)};return n.addEventListener("message",r),()=>{n.removeEventListener("message",r)}},p=(e,t,n=window)=>{const r=n=>{n.source===e.contentWindow&&"videopress_ended"===n.data.event&&t()};return n.addEventListener("message",r),()=>{n.removeEventListener("message",r)}};
/**
 * The embed pattern to check if it's the respective type.
 */}
/***/,
/***/40839:
/***/(e,t,n)=>{
/* harmony export */n.d(t,{
/* harmony export */F:()=>/* binding */i
/* harmony export */});
/* harmony import */var r=n(95656),o=n(53791);
/* harmony import */
/**
 * Internal dependencies
 */
/**
 * Initializes the Video block player.
 *
 * @param {HTMLElement} video The video element of the Video block.
 */
const s=e=>{const t=new o/* ["default"] */.A(e);(0,r/* .registerVideo */.J)({registerVideoEndHandler:e=>{t.on("ended",e)},pauseVideo:()=>{t.pause()},url:e.src.split("?")[0],blockElement:e.closest("figure")})},i=()=>{document.querySelectorAll(".wp-block-video video").forEach(s)}}
/***/,
/***/52204:
/***/(e,t,n)=>{n.r(t),
/* harmony export */n.d(t,{
/* harmony export */ADAPTER_NAME:()=>/* binding */r
/* harmony export */,EMBED_PATTERN:()=>/* binding */o
/* harmony export */,getCurrentTime:()=>/* binding */a
/* harmony export */,getDuration:()=>/* binding */i
/* harmony export */,initializePlayer:()=>/* binding */s
/* harmony export */,onEnded:()=>/* binding */p
/* harmony export */,onTimeupdate:()=>/* binding */c
/* harmony export */,pause:()=>/* binding */l
/* harmony export */,play:()=>/* binding */u
/* harmony export */,setCurrentTime:()=>/* binding */d
/* harmony export */});
/**
 * Adapter name.
 */
const r="youtube",o=/(youtu\.be|youtube\.com)\/.+/i,s=(e,t=window)=>new Promise((n=>{t.senseiYouTubeIframeAPIReady.then((()=>{const r=t.YT.get(e.id)||new t.YT.Player(e),o=()=>{n(r)};r.getDuration?
// Just in case it's called after the player is ready.
o():r.addEventListener("onReady",o);
// Add a dataset to identify if video has played already.
const s=n=>{n.data===t.YT.PlayerState.PLAYING&&(e.dataset.hasPlayed="has-played",r.removeEventListener("onStateChange",s))};"has-played"!==e.dataset.hasPlayed&&r.addEventListener("onStateChange",s)}))}))
/**
 * Get the video duration.
 *
 * @param {Object} player The YouTube player instance.
 *
 * @return {Promise<number>} The duration of the video in seconds through a promise.
 */,i=e=>new Promise((t=>{t(e.getDuration())}))
/**
 * Get the current video time.
 *
 * @param {Object} player The YouTube player instance.
 *
 * @return {Promise<number>} The current video time in seconds through a promise.
 */,a=e=>new Promise((t=>{t(e.getCurrentTime())}))
/**
 * Set the video to a current time.
 *
 * @param {Object} player  The YouTube player instance.
 * @param {number} seconds The video time in seconds to set.
 *
 * @return {Promise} A promise that resolves if the video was set to a current time successfully.
 */,d=(e,t)=>new Promise((n=>{e.getIframe().dataset.hasPlayed?(e.seekTo(t),n()):u(e).then((()=>l(e))).then((()=>{e.seekTo(t),n()}))}))
/**
 * Play the video.
 *
 * @param {Object} player The YouTube player instance.
 *
 * @return {Promise} A promise that resolves if the video play was called successfully.
 */,u=e=>new Promise((t=>{e.playVideo(),t()}))
/**
 * Pause the video.
 *
 * @param {Object} player The YouTube player instance.
 *
 * @return {Promise} A promise that resolves if the video pause was called successfully.
 */,l=e=>new Promise((t=>{e.pauseVideo(),t()}))
/**
 * Add an timeupdate event listener to the player.
 *
 * @param {Object}   player   The YouTube player instance.
 * @param {Function} callback Listener callback.
 * @param {Window}   w        A custom window.
 *
 * @return {Function} The function to unsubscribe the event.
 */,c=(e,t,n=window)=>{let r;const o=e=>{r!==e&&(t(e),r=e)},s=setInterval((()=>{e.getPlayerState()!==n.YT.PlayerState.ENDED&&o(e.getCurrentTime())}),250),i=()=>{e.getPlayerState()===n.YT.PlayerState.ENDED&&o(e.getDuration())};
// Update the current time based on an interval.
return e.addEventListener("onStateChange",i),()=>{clearInterval(s),e.removeEventListener("onStateChange",i)}},p=(e,t,n=window)=>{const r=()=>{e.getPlayerState()===n.YT.PlayerState.ENDED&&t()};return e.addEventListener("onStateChange",r),()=>{e.removeEventListener("onStateChange",r)}};
/**
 * The embed pattern to check if it's the respective type.
 */}
/***/,
/***/52619:
/***/e=>{e.exports=window.wp.hooks;
/***/},
/***/53791:
/***/(e,t,n)=>{
/* harmony export */n.d(t,{
/* harmony export */A:()=>m
/* harmony export */});
/* unused harmony export useVideoDuration */
/* harmony import */n(86087);
/* harmony import */var r=n(78889),o=n(38439),s=n(52204),i=n(99697),a=n(9737);
/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
const d=r.ADAPTER_NAME,u=o.ADAPTER_NAME,l=s.ADAPTER_NAME,c=i.ADAPTER_NAME,p={[d]:r,[u]:o,[l]:s,[c]:i};
/**
 * Hook to get the video duration.
 *
 * @param {Object} player Player instance.
 *
 * @return {number|undefined} The video duration.
 */
const m=
/**
 * A class that abstracts the use of the player APIs: Video, VideoPress, YouTube, and Vimeo.
 */
class{
/**
   * Player constructor.
   *
   * @param {HTMLVideoElement|HTMLIFrameElement} element The player element.
   * @param {Window}                             w       A custom window.
   */
constructor(e,t=window){this.playerPromise=null,this.adapterName=null,this.element=e,this.w=t,this.setAdapter()}
/**
   * Set the player adapter.
   */setAdapter(){this.element instanceof this.w.HTMLVideoElement?this.adapterName=d:this.element instanceof this.w.HTMLIFrameElement&&(this.adapterName=Object.entries(p).find((([,{EMBED_PATTERN:e=null}])=>e&&this.element.src?.match(e)))?.[0]),this.adapterName||
// eslint-disable-next-line no-console -- We want to expose the element with problem.
console.error("Video adapter not found",this.element)}
/**
   * Get the adapter.
   *
   * @access private
   *
   * @return {Object} The adapter.
   */getAdapter(){return p[this.adapterName]}
/**
   * Get the video player.
   *
   * @return {Promise<Object|HTMLVideoElement|HTMLIFrameElement>} The video player through a promise.
   */getPlayer(){return this.playerPromise||(this.playerPromise=this.getAdapter()?.initializePlayer(this.element,this.w)||
// A promise that never resolves if it doesn't exist.
Promise.reject(new Error("Failed getting the player"))),this.playerPromise}
/**
   * Get the video duration.
   *
   * @return {Promise<number>} The duration of the video in seconds through a promise.
   */getDuration(){return this.getPlayer().then((e=>this.getAdapter().getDuration(e)))}
/**
   * Get the video current time.
   *
   * @return {Promise<number>} The current video time in seconds through a promise.
   */getCurrentTime(){return this.getPlayer().then((e=>this.getAdapter().getCurrentTime(e))).then((e=>(0,a/* ["default"] */.A)(e,3)))}
/**
   * Set the video to a current time.
   *
   * @param {number} seconds The video time in seconds to set.
   *
   * @return {Promise} A promise that resolves if the video was set to a current time successfully.
   */setCurrentTime(e){return this.getPlayer().then((t=>this.getAdapter().setCurrentTime(t,e)))}
/**
   * Play the video.
   *
   * @return {Promise} A promise that resolves if the video play was called successfully.
   */play(){return this.getPlayer().then((e=>this.getAdapter().play(e)))}
/**
   * Pause the video.
   *
   * @return {Promise} A promise that resolves if the video pause was called successfully.
   */pause(){return this.getPlayer().then((e=>this.getAdapter().pause(e)))}
/**
   * Add an event listener to the player.
   *
   * @param {string}   eventName Event name (supported: `timeupdate`).
   * @param {Function} callback  Listener callback.
   *
   * @throws Will throw an error if the event is not supported.
   *
   * @return {Promise<Function>} The function to unsubscribe the event through a promise.
   */on(e,t){
// Supported events.
const n={timeupdate:this.onTimeUpdate.bind(this),ended:this.onEnded.bind(this)}[e];if(!n)throw new Error(`Event ${e} not supported`);return n(t)}
/**
   * Wrapper to the `onTimeUpdate` event from the adapters.
   *
   * @access private
   *
   * @param {Function} callback Listener callback.
   *
   * @return {Promise<Function>} The function to unsubscribe the event through a promise.
   */onTimeUpdate(e){const t=t=>{e((0,a/* ["default"] */.A)(t,3))};return this.getPlayer().then((e=>this.getAdapter().onTimeupdate(e,t,this.w)))}
/**
   * Wrapper to the `onEnded` event from the adapters.
   *
   * @access private
   *
   * @param {Function} callback Listener callback.
   *
   * @return {Promise<Function>} The function to unsubscribe the event through a promise.
   */onEnded(e){return this.getPlayer().then((t=>this.getAdapter().onEnded(t,e,this.w)))}};
/* harmony default export */}
/***/,
/***/78889:
/***/(e,t,n)=>{n.r(t),
/* harmony export */n.d(t,{
/* harmony export */ADAPTER_NAME:()=>/* binding */r
/* harmony export */,getCurrentTime:()=>/* binding */i
/* harmony export */,getDuration:()=>/* binding */s
/* harmony export */,initializePlayer:()=>/* binding */o
/* harmony export */,onEnded:()=>/* binding */c
/* harmony export */,onTimeupdate:()=>/* binding */l
/* harmony export */,pause:()=>/* binding */u
/* harmony export */,play:()=>/* binding */d
/* harmony export */,setCurrentTime:()=>/* binding */a
/* harmony export */});
/**
 * Adapter name.
 */
const r="video-file",o=e=>new Promise((t=>{
// Return that it's ready when it can get the video duration.
isNaN(e.duration)||t(e),e.addEventListener("durationchange",(()=>{t(e)}),{once:!0})}))
/**
 * Get the video duration.
 *
 * @param {HTMLVideoElement} player The player element.
 *
 * @return {Promise<number>} The duration of the video in seconds through a promise.
 */,s=e=>new Promise((t=>{t(e.duration)}))
/**
 * Get the current video time.
 *
 * @param {HTMLVideoElement} player The player element.
 *
 * @return {Promise<number>} The current video time in seconds through a promise.
 */,i=e=>new Promise((t=>{t(e.currentTime)}))
/**
 * Set the video to a current time.
 *
 * @param {HTMLVideoElement} player  The player element.
 * @param {number}           seconds The video time in seconds to set.
 *
 * @return {Promise} A promise that resolves if the video was set to a current time successfully.
 */,a=(e,t)=>new Promise((n=>{e.currentTime=t,n()}))
/**
 * Play the video.
 *
 * @param {HTMLVideoElement} player The player element.
 *
 * @return {Promise} The native promise from the video play function.
 */,d=e=>e.play()
/**
 * Pause the video.
 *
 * @param {HTMLVideoElement} player The player element.
 *
 * @return {Promise} A promise that resolves if the video was paused successfully.
 */,u=e=>new Promise(((t,n)=>{e.pause(),e.paused&&t(),n(new Error("Video didn't pause"))}))
/**
 * Add an timeupdate event listener to the player.
 *
 * @param {HTMLVideoElement} player   The player element.
 * @param {Function}         callback Listener callback.
 *
 * @return {Function} The function to unsubscribe the event.
 */,l=(e,t)=>{const n=e=>{t(e.target.currentTime)};return e.addEventListener("timeupdate",n),()=>{e.removeEventListener("timeupdate",n)}},c=(e,t)=>(e.addEventListener("ended",t),()=>{e.removeEventListener("timeupdate",t)});
/**
 * Initialize the player.
 *
 * @param {HTMLVideoElement} element The player element.
 *
 * @return {Promise<HTMLVideoElement>} The video player through a promise.
 */}
/***/,
/***/86087:
/***/e=>{e.exports=window.wp.element;
/***/},
/***/95656:
/***/(e,t,n)=>{
/* harmony export */n.d(t,{
/* harmony export */J:()=>/* binding */d
/* harmony export */});
/* harmony import */var r=n(52619);
/* harmony import */
/**
 * WordPress dependencies
 */
/**
 * The Course Video Progression settings.
 */
const{courseVideoRequired:o,courseVideoAutoComplete:s,courseVideoAutoPause:i}=window.sensei.courseVideoSettings,a={},d=({pauseVideo:e=()=>{},registerVideoEndHandler:t=()=>{},url:n="",blockElement:i})=>{const d=i.hasAttribute("data-sensei-is-required"),c=i.hasAttribute("data-sensei-is-not-required");
// Block level setting overwrites the course level setting.
(d||o&&!c)&&(
/**
     * Called when a required video for the current lesson is registered.
     *
     * @since 4.4.3
     *
     * @hook sensei.videoProgression.registerVideo Hook used to run an arbitrary code when new required
     *                                             video for the current lesson is registered.
     * @param {Object}      video
     * @param {string}      video.url          The source url of the video.
     * @param {HTMLElement} video.blockElement The video block DOM element.
     */
/**
     * Called when a required video for the current lesson is registered.
     *
     * @since 4.4.3
     *
     * @hook sensei.videoProgression.registerVideo Hook used to run an arbitrary code when new required
     *                                             video for the current lesson is registered.
     * @param {Object}      video
     * @param {string}      video.url          The source url of the video.
     * @param {HTMLElement} video.blockElement The video block DOM element.
     */
(0,r.doAction)("sensei.videoProgression.registerVideo",{url:n,blockElement:i}),a[n]={pauseVideo:e,completed:!1},l()),t((()=>{
// Block level setting overwrites the course level setting.
(d||o&&!c)&&(
/**
       * Called when a required video for the current lesson is finished playing.
       *
       * @since 4.4.3
       *
       * @hook sensei.videoProgression.videoEnded Hook used to run an arbitrary code when a required video
       *                                          for the current lesson is finished playing.
       * @param {Object} video
       * @param {string} video.url The source url of the video.
       */
/**
       * Called when a required video for the current lesson is finished playing.
       *
       * @since 4.4.3
       *
       * @hook sensei.videoProgression.videoEnded Hook used to run an arbitrary code when a required video
       *                                          for the current lesson is finished playing.
       * @param {Object} video
       * @param {string} video.url The source url of the video.
       */
(0,r.doAction)("sensei.videoProgression.videoEnded",{url:n}),a[n].completed=!0,u()&&p()),s&&u()&&m()}))},u=()=>{let e=!0;for(const t in a)a[t].completed||(e=!1);
/**
   * Tells if all the required videos for the current lesson are finished playing or not.
   *
   * @since 4.4.3
   *
   * @hook sensei.videoProgression.allCompleted Hook used to tell if all the required videos for the current lesson have finished playing.
   *
   * @param {boolean} allCompleted Whether all the required videos for the current lesson are completed.
   */return e=(0,r.applyFilters)("sensei.videoProgression.allCompleted",e),e},l=()=>{(0,r.applyFilters)("sensei.videoProgression.preventLessonCompletion",!0)&&document.querySelectorAll('[data-id="complete-lesson-button"]').forEach((e=>{e.disabled=!0,e.addEventListener("click",c)}))},c=e=>(e.preventDefault(),!1),p=()=>{(0,r.applyFilters)("sensei.videoProgression.allowLessonCompletion",!0)&&document.querySelectorAll('[data-id="complete-lesson-button"]').forEach((e=>{e.removeEventListener("click",c),e.disabled=!1}))},m=()=>{const e=document.querySelector('[data-id="complete-lesson-button"]');e&&setTimeout((()=>{e.click()}),3e3)};
/**
 * Map of videos.
 */
/**
 * If pause video setting is set. Then attach an event listener
 * to detect user navigating away and pause the videos.
 */
i&&void 0!==document.hidden&&document.addEventListener("visibilitychange",(()=>{if(document.hidden)for(const e in a){const t=a[e].pauseVideo;"function"==typeof t&&t()}}),!1)
/***/},
/***/99697:
/***/(e,t,n)=>{n.r(t),
/* harmony export */n.d(t,{
/* harmony export */ADAPTER_NAME:()=>/* binding */r
/* harmony export */,EMBED_PATTERN:()=>/* binding */o
/* harmony export */,getCurrentTime:()=>/* binding */a
/* harmony export */,getDuration:()=>/* binding */i
/* harmony export */,initializePlayer:()=>/* binding */s
/* harmony export */,onEnded:()=>/* binding */p
/* harmony export */,onTimeupdate:()=>/* binding */c
/* harmony export */,pause:()=>/* binding */l
/* harmony export */,play:()=>/* binding */u
/* harmony export */,setCurrentTime:()=>/* binding */d
/* harmony export */});
/**
 * Adapter name.
 */
const r="vimeo",o=/vimeo\.com\/.+/i,s=(e,t=window)=>{const n=new t.Vimeo.Player(e),r=()=>{e.dataset.hasPlayed="has-played",n.off("play",r)};
// Add a dataset to identify if video has played already.
return"has-played"!==e.dataset.hasPlayed&&n.on("play",r),n.ready().then((()=>n))},i=e=>e.getDuration()
/**
 * Get the current video time.
 *
 * @param {Object} player The Vimeo player instance.
 *
 * @return {Promise<number>} The current video time in seconds through a promise.
 */,a=e=>e.getCurrentTime()
/**
 * Set the video to a current time.
 *
 * @param {Object} player  The Vimeo player instance.
 * @param {number} seconds The video time in seconds to set.
 *
 * @return {Promise} A promise that resolves if the video was set to a current time successfully.
 *                   (original return from Vimeo API).
 */,d=(e,t)=>e.element.dataset.hasPlayed?e.setCurrentTime(t):u(e).then((()=>l(e))).then((()=>e.setCurrentTime(t))),u=e=>e.play()
/**
 * Pause the video.
 *
 * @param {Object} player The Vimeo player instance.
 *
 * @return {Promise} A promise that resolves if the video was paused successfully.
 *                   (original return from Vimeo API).
 */,l=e=>e.pause()
/**
 * Add an timeupdate event listener to the player.
 *
 * @param {Object}   player   The Vimeo player instance.
 * @param {Function} callback Listener callback.
 *
 * @return {Function} The function to unsubscribe the event.
 */,c=(e,t)=>{const n=e=>{t(e.seconds)};return e.on("timeupdate",n),()=>{e.off("timeupdate",n)}},p=(e,t)=>(e.on("ended",t),()=>{e.off("ended",t)});
/**
 * The embed pattern to check if it's the respective type.
 */}
/***/,
/***/99821:
/***/(e,t,n)=>{
/* harmony export */n.d(t,{
/* harmony export */Z:()=>/* binding */i
/* harmony export */});
/* harmony import */var r=n(95656),o=n(53791);
/* harmony import */
/**
 * Internal dependencies
 */
/**
 * Initializes the YouTube video block player.
 *
 * @param {HTMLElement} iframe The iframe element of the YouTube video block.
 */
const s=e=>{const t=new o/* ["default"] */.A(e),n="https://www.youtube.com/watch?v="+e.src.split("?")[0].split("/").pop();
// iframe.src should be in the format:
// https://www.youtube.com/embed/VIDEO_ID?other-query-parameters=and-their-values&origin=https://example.com
(0,r/* .registerVideo */.J)({pauseVideo:()=>{t.pause()},registerVideoEndHandler:e=>{t.on("ended",e)},url:n,blockElement:e.closest("figure")})},i=()=>{document.querySelectorAll(".wp-block-embed-youtube iframe").forEach(s)}}
/***/
/******/},t={};
/************************************************************************/
/******/ // The module cache
/******/
/******/
/******/ // The require function
/******/function n(r){
/******/ // Check if module is in cache
/******/var o=t[r];
/******/if(void 0!==o)
/******/return o.exports;
/******/
/******/ // Create a new module (and put it into the cache)
/******/var s=t[r]={
/******/ // no module.id needed
/******/ // no module.loaded needed
/******/exports:{}
/******/};
/******/
/******/ // Execute the module function
/******/
/******/
/******/ // Return the exports of the module
/******/return e[r](s,s.exports,n),s.exports;
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
/******/for(var r in t)
/******/n.o(t,r)&&!n.o(e,r)&&
/******/Object.defineProperty(e,r,{enumerable:!0,get:t[r]})
/******/;
/******/},
/******/n.o=(e,t)=>Object.prototype.hasOwnProperty.call(e,t)
/******/,
/******/ // define __esModule on exports
/******/n.r=e=>{
/******/"undefined"!=typeof Symbol&&Symbol.toStringTag&&
/******/Object.defineProperty(e,Symbol.toStringTag,{value:"Module"})
/******/,Object.defineProperty(e,"__esModule",{value:!0})}
/******/;
/* harmony import */var r=n(99821),o=n(40839),s=n(23572),i=n(28908);
/* harmony import */
/**
 * Internal dependencies
 */
// Initialize video extensions only after all the resources are loaded.
// This makes sure that Required Blocks feature can hook into the
// Course Video Progression feature before it starts firing it's hooks.
window.addEventListener("load",(()=>{(0,i/* .initVideoPressExtension */.s)(),(0,o/* .initVideoExtension */.F)(),(0,s/* .initVimeoExtension */.k)(),(0,r/* .initYouTubeExtension */.Z)()}))})
/******/();