=== WP Content Copy Protection & No Right Click (premium) ===
Contributors: wp-buy	
Tags: content, content copy protection, content protection, copy protection, prevent copy, protect blog, image protect, image protection, no right click, plagiarism, secure, theft
Requires at least: 4.6
Tested up to: 7.0
Stable tag: 17.4

This wp plugin protects the content of the posts from being copied by any other web site author, you don't want your content to spread without your permission!!


== Description ==
This wp plugin protects the content of the posts from being copied by any other web site author, you don't want your content to spread without your permission!!

**Improve your SEO score in Google and Yahoo and other SE's**:
Our plugin protects your content from being copied by any other web sites so your posts will still unique content, this is the best option for SEO

**Don't Let Your Stories Go to web thief!**
The plugin will keep your posts and home page protected by multiple techniques (JavaScript + CSS), this techniques does not found in any other WordPress plugin and you will own it for free with this plugin

**Easy to Install**:
Read the installation steps to find that this plugin does not need any coding or theme editing, just use your mouse.

**The Pro Edition Features include:**
1. Protect your content from selection and copy.
2. No one can right-click on images from your site if you want
3. Get full control on Right-click or context menu
4. Show alert messages, when the user made right click on images, text boxes, links, plain text.. etc
5. Disable the keys  CTRL+A, CTRL+C, CTRL+X, CTRL+S, or CTRL+V.
6. Advanced and easy to use control panel.    
7. Admin can exclude Home page Or Single posts from being copy protected
8. Admin can disable copy protection for admin users.
9. Aggressive image protection (it's not easy or it's impossible for expert users to steal your images !!)
10. Compatible with all major theme frameworks
11. Compatible with all major browsers


== Screenshots ==
1. WP Content Copy Protection premium admin page

== Installation Guide ==
**Installation steps**
1.Download the package.
2.Extract the contents of WP-Content-Copy-Protection.zip to wp-content/plugins/ folder  You should get a folder called WP-Content-Copy-Protection
3.Activate the Plugin in WP-Admin.
4.Goto Settings > **WP-Content-Copy-Protection** to configure options.
5.You will find **4 options** to protect your content,images,homepage and css protection. dont forget to **save** the changes before exit
Thanks!

== Changelog ==
=17.4=
<ul>
<li>Fixed: Watermarking error-log message loop</li>
<li>Tested with latest wordpress version 7.0</li>
</ul>
=17.3=
<ul>
<li>Fixed: Watermarking rules logic for social media sharing and some other fixes</li>
</ul>
=17.2=
<ul>
<li>Fixed overlay misalignment on absolutely positioned images by transferring all positioning properties (top, left, transform, inset) to the wrapper element instead of duplicating them.</li>
<li>Fixed incorrect overlay dimensions caused by reading HTML attributes instead of actual rendered size, now using getBoundingClientRect() to capture true on-screen pixel dimensions.</li>
<li>Added responsive resize listener to re-sync overlay and wrapper dimensions dynamically when the viewport size changes.</li>
</ul>
=17.1=
<ul>
<li>Fix watermarking issue on Color Mode: Palette (P) images</li>
</ul>
=17.0=
<ul>
<li>Fix custom css style option issue</li>
</ul>
=16.9=
<ul>
<li>Fix watermark central text color issue</li>
</ul>
=16.8=
<ul>
<li>Fix for watermark issue</li>
</ul>
=16.7=
<ul>
<li>Fix for portfolio post types issue</li>
<li>New informaion menue at the top admin bar to know more about the protection status</li>
<li>Added color coding (Red, Green, Yellow) for Yes/No, On/Off, Active/Inactive texts.</li>
<li>Added new info item showing blocked CTRL+ keys (Ctrl+S, Ctrl+A, Ctrl+C, Ctrl+X, Ctrl+V, Ctrl+U, F12).</li>
<li>Mapped protection settings (e.g., ctrl_s_protection) to "checked" values for detection.</li>
<li>Improved information submenu by including more meaningful system settings from $wccp_pro_settings.</li>
<li>Refactored code to keep arrays consistent and easier to extend for future info items.</li>
</ul>
=16.6=
<ul>
<li>Fix compatapility issue with some statistics plugins</li>
<li>Fix some CSS issues inside our plugin admin page</li>
</ul>
=16.4=
<ul>
<li>🚨 Important: This is a major update, so please check your settings after applying it! 🚨</li>
<li>12 deprecated options inside the options array have been replaced with new ones.</li>
<li>Selection Protection now works based on any public post_type.</li>
<li>Right-Click Protection now works based on any public post_type.</li>
<li>CSS Protection options are now merged into the selection tab and function together as a single feature.</li>
<li>Overlay Protection now works based on any public post_type.</li>
<li>You can now control the watermark stamp space over the image (%) using a percentage value.</li>
<li>Compatibility with PHP 8.2 & 8.3 has been added to reduce errors and fix all deprecated functions.</li>
<li>The "Copy Code" button now works for pre tags containing code tags inside.</li>
<li>The (.htaccess) file has been moved from the uploads folder to the wp-content folder.</li>
<li>The wp-color-picker has been replaced with the default browser color picker, which is faster and more efficient.</li>
<li>The plugin now uses a dynamic folder name in case the plugin folder name is changed for any reason.</li>
<li>Overlay Protection has been optimized.</li>
<li>Added the ability to watermark single-frame GIF images correctly.</li>
<li>Reduced transparency for GIF images when a watermark logo is applied to them.</li>
<li>Added the ability to control the logo size over images (by percentage, depending on the logo's size).</li>
<li>Arabic language support has been added for watermark text over images.</li>
<li>Images can now be watermarked even if the `.htaccess` file is not supported by your server.</li>
<li>A new admin page called "Watermark Testing" has been added to test the watermarking feature for all major image types.</li>
<li>Six new tests have been included in this admin page.</li>
<li>You can now view the `.htaccess` file content with one click—this is especially useful when providing information for support.</li>
<li>The "Server Data" button provides detailed information about your server, eliminating the need to contact your web hosting company.</li>
<li>Watermarking will not appear in the (Preview Post Box) thumbnail image shown by some SEO plugins when editing posts.</li>
<li>Watermarking will not appear on the (Image Gallery Page).</li>
<li>Watermarking will not appear on the (Edit post Page) or (SEO preview plugins included there)</li>
<li>Fix (URL Exclude List) option</li>
<li>New feature inside the plugin control panel to test the watermarking for all major image types</li>
<li>New feature is called (watermark testing) and link to it is located under the plugin menu main link</li>
<li>Six new tests has been included inside the (watermark testing) page</li>
<li>Watermarking speed increased by 78%, Thanks to the use of AI tools to improve the speed of the code.</li>
<li>New htaccess rule to block all PHP files in wp-content and its subfolders, except watermark.php</li>
<li>New Feature: Advanced .htaccess Rule to Block Image-Grabbing Browser Extensions</li>
<li>Tested with latest wordpress version 6.8.2</li>
</ul>
=15.6=
<ul>
<li>Fix style error inside customizer.php theme options page</li>
<li>Tested with latest wordpress version 6.7.2</li>
</ul>
=15.5=
<ul>
<li>Use (Require all granted) instead of (Allow from all) inside htaccess file</li>
<li>Checking with wordpress version 6.6.2</li>
</ul>
=15.4=
<ul>
<li>Add the ability to differentiate between main domain and subdomain when watermarking images</li>
</ul>
=15.3=
<ul>
<li>Hide protection icon on top admin bar for non-admin user roles</li>
<li>Sanitize the settings when saving them using wp_kses</li>
</ul>
=15.2=
<ul>
<li>Fix Open Redirect issue to prevent malicious actors to use the site to redirect visitors to malicious URLs</li>
<li>PHP page no-js.php has been removed , there is no need for it after the new fix</li>
<li>Tested with last wordpress version 6.6.1</li>
</ul>
=15.1=
<ul>
<li>Alert message fix</li>
<li>Tested with last wordpress version 6.5.5</li>
</ul>
=15.0=
<ul>
<li>Fix PHP Warning related to $post_type functions.php on line 1060</li>
</ul>
=14.9=
<ul>
<li>Fix error related to $post_type when preparing protection functions</li>
<li>Fix watermark logo out of control big size with PHP 8.1</li>
<li>Tested with last wordpress version 6.5.3</li>
</ul>
=14.8=
<ul>
<li>Tested with last wordpress version 6.4.3</li>
</ul>
=14.5=
<ul>
<li>Add protection for product post types</li>
<li>Add protection for unknown post types</li>
<li>Tested with latest wordpress version 6.2.2</li>
</ul>
=14.4=
<ul>
<li>Media library images inside admin panel are now shown without watermark</li>
<li>Wide fixes for JS defer options inside caching plugins</li>
<li>Watermarking htaccess file updates</li>
<li>Watermarking fixes with php 8.2</li>
<li>Tested with latest wordpress version 6.2</li>
</ul>
=14.2=
<ul>
<li>ZeptoJS supported now</li>
<li>JQuery.slim.min is also supported now</li>
</ul>
=13.4=
<ul>
<li>(DevTools killer) error has been fixed</li>
<li>Stop unwanted console.log data</li>
<li>Overlay protection has been fixed, it now works only over post images and attatchments</li>
</ul>
=13.3=
<ul>
<li>Code block selection improvements</li>
<li>When selecting text on code blocks, the copy button over that block only will be activated</li>
<li>Right click error when clicking on some empty spaces has been solved</li>
<li>Improvements for JavaScript selection protection techniques</li>
<li>Include files by absolute path is now the main way instead of relative path</li>
</ul>
=13.2=
<ul>
<li>Print protection can be excluded by usertype</li>
<li>Some fixes for the main array</li>
<li>Developer tools killer function is now stronger than before</li>
</ul>
=12.7=
<ul>
<li>Watermarking webp images support & fix</li>
<li>Fix PHP issue array_key_exists error notice</li>
<li>check with the latest version 6.0.1 of wordpress</li>
</ul>
=12.6=
<ul>
<li>Fix PHP issue</li>
</ul>
=12.5=
<ul>
<li>Fix PHP error in the main file (related to str_contains function)</li>
<li>Fix selection code</li>
<li>Fix CSS code</li>
<li>Rearrange some control panel options</li>
<li>Add new option to allow/disable selection on code blocks</li>
<li>Add new option to show copy button over the code blocks</li>
</ul>
=12.4=
<ul>
<li>Fix selection code</li>
<li>Make changes to the general work mechanism</li>
<li>change some defaults</li>
</ul>
=12.3=
<ul>
<li>Fix code selection ability inside code blocks and content editable areas</li>
<li>Fix Z-Index for the copy button</li>
<li>console.log is now just only when developer mode is ON</li>
</ul>
=12.2=
<ul>
<li>Fix favicon issue</li>
</ul>
=12.1=
<ul>
<li>Check for the new WordPress version 6.0</li>
<li>Change the control panel icon set</li>
<li>New option to control the alert message font size</li>
<li>new add button for URL Exclude List option</li>
<li>New option to allow exclusion by post type</li>
<li>New option to allow exclusion by post category</li>
<li>Some deprecated functions have been deleted</li>
<li>New option to control the message that must be shown when JavaScript is disabled</li>
<li>New option to exclude any page from protection from an icon inside its admin bar</li>
<li>New option to include any excluded page to be protected again from an icon inside its admin ba</li>
<li>Improvements for URL included list option</li>
<li>Improvements for the (prevent print screen key) function</li>
<li>the option Print page disabled message has been fixed</li>
</ul>
=11.4=
<ul>
<li>fix copy button place to be shown out of code text inside code blocks</li>
</ul>
=11.2=
<ul>
<li>fix print screen prevent function</li>
<li>Improvments for the [Copy Code] button</li>
<li>Check for the new wordpress version</li>
</ul>
=11.1=
<ul>
<li>Allow selection inside CODE blocks</li>
<li>Allow copy from CODE blocks</li>
</ul>
=11.0=
<ul>
<li>Fix text cursor issue on submit buttons</li>
<li>Fix permissions issue</li>
</ul>
=10.9=
<ul>
<li>Fix caching functions</li>
<li>Fix css functions on custom devices</li>
</ul>
=10.8=
<ul>
<li>Fix default options</li>
</ul>
=10.7=
<ul>
<li>Fix pointer events error causing issues when click on images, videos , some links and sliders</li>
</ul>
=10.6=
<ul>
<li>Improve CSS protection functionality</li>
<li>Prevent the use of google chrome developer tools</li>
<li>Prevent the use of some browser extensions</li>
<li>Prevent the use of firefox developer tools</li>
<li>Support watermarking by russian laguage</li>
<li>Support watermarking by Arabic laguage</li>
<li>Support watermarking directon text for RTL laguages</li>
<li>fix error with old php versions</li>
<li>fix error when using developer mode</li>
<li>Using nounce to secure tje admin form</li>
<li>Add new option to control the cookie, our cookie called wccp_pro_functionality</li>
<li>Change some tab icons</li>
<li>Add new tab called beta options</li>
<li>Add new options inside beta options to stop developer tools and browser extensions</li>
</ul>
=10.3=
<ul>
<li>fix error with old php versions</li>
</ul>
=10.2=
<ul>
<li>fix the update problem</li>
</ul>
=10.1=
<ul>
<li>Watermarking code location changed from the main htaccess file to be inside the uploads folder</li>
<li>important JS fix</li>
<li>important Css fix</li>
<li>Print ctrl=p protection improvment</li>
<li>Overlay protection improvments</li>
<li>Protection imporovmets for iphone & ipad devices</li>
</ul>
=9.9=
<ul>
<li>Fix color picker error</li>
<li>some JS fix</li>
</ul>
=9.8=
<ul>
<li>select text protection improved</li>
<li>New option (inside 2nd tab) to control Drag/Drop for images only</li>
<li>JS drag drop old function improved</li>
<li>some JS fix</li>
</ul>
=9.7=
<ul>
<li>Now compatible with (elemenator page builder) plugin</li>
<li>Now compatible with (siteorigin live editor page builder) plugin</li>
<li>Now compatible with (WordPress Page Builder – Beaver Builder) plugin</li>
<li>Now compatible with (Wordpress internal preview mode)</li>
<li>New control panel (restore defaults) button added</li>
<li>New control panel (preview alert message) button added</li>
<li>New name for the top bar icon to fix its default choice in the previous version</li>
<li>Translation file updated</li>
<li>Disable (CTRL + Shift + I) developer tools shortcut key</li>
<li>Some fixes</li>
<li>Important fix for content editable tags</li>
<li>Now compatible with wpDiscuz plugin & some chat wordpress plugins</li>
<li>Top bar icon  has been returned, as it was inside previous version 2.6</li>
<li>New option inside main settings to control the visibility of the top bar icon</li>
<li>Stop the auto loading for the alert (warning.png) icon</li>
<li>Some linguistic mistakes were corrected</li>
</ul>
=9.6=
<ul>
<li>Code fix for image & video overlay protection</li>
</ul>
=9.5=
<ul>
<li>Change the place of (exclude by user type) option, its now the first option inside the exclusion tab</li>
<li>Plugin private admin page styles just run when amin page loaded</li>
<li>Fix for exclude by user type feature to work better with Ultimate Members plugin</li>
<li>Code fix to allow users to drag & drop images when editing thier profiels</li>
<li>Watermark exclusion code fix</li>
</ul>
=9.4=
<ul>
<li>New mode added, called (opposite mode) to only protect some pages and keep all other pages unprotected</li>
<li>Watermarking code fix</li>
<li>PHP notices new fix</li>
<li>Smart mode code fix</li>
</ul>
=9.3=
<ul>
<li>Code fix for video protection</li>
<li>Watermarking code fix</li>
</ul>
=9.2=
<ul>
<li>Code fix version 9.1 updates</li>
</ul>
=9.1=
<ul>
<li>This update is happen because of help, alot of help from Kenedy Torcatt https://wordpress.org/support/users/kenedyt/, So many thanks to him forever</li>
<li>Code fix for wccp_pro_get_current_user_roles() function</li>
</ul>
=8.9=
<ul>
<li>Code fix for video protection</li>
</ul>
=8.8=
<ul>
<li>Code fix for IE</li>
<li>Code fix for watermarking set time limit function</li>
<li>Htaccess exclusion fix</li>
<li>Code fix for right-click on links</li>
</ul>
=8.7=
<ul>
<li>Videos protection is now stronger than any other plugin</li>
<li>New feature, For the first time! watermarked is not out of exclusion anymore. Any excluded page will be excluded from image watermarking too</li>
<li>New feature, Wordpress media library is now excluded from image watermarking</li>
<li>New feature, Posts & Pages editor are also excluded from image watermarking</li>
<li>Fix bug for CTRL+(p,s,u) with editable text boxes</li>
<li>Fix bug with image smart protection CSS</li>
<li>New feature, Exclude registered images sizes from watermarking</li>
<li>New feature, Exclude images by name & size (manually) from watermarking</li>
<li>New feature, to enable/disable drag & drop. This feature is needed for LMS ,quizing and e-learning systems</li>
<li>New feature, Developer Mode</li>
<li>Selection Exclude by class name bug fix</li>
<li>Exclude online services bug fix</li>
<li>Exclude by user type feature improved to list all user types</li>
<li>Disable special keys function improvment</li>
<li>All editable text inputs are now allowed to copy/paste</li>
<li>Selection issue fixed for SmartPhones</li>
<li>Update to the new bootstrap version</li>
<li>Use RTL-bootstrap version for RTL languages</li>
</ul>
=8.5=
<ul>
<li>Admin panel new theme, responsive & light</li>
<li>Drag and drop function is now separated as an option</li>
<li>Video protection is now better and improved</li>
<li>Full screen video protection still not supported, still trying to work around this issue</li>
<li>Exclude by user type function improved to get all user types</li>
<li>Improvments to be more compatible with Learning Managmant Systems LMS</li>
</ul>
=8.4=
<ul>
<li>Fix Exclusion by class name settings code</li>
</ul>
=8.3=
<ul>
<li>Fix laguages & translation issues</li>
</ul>
=8.2=
<ul>
<li>Remove a hidden field , It was used to make print screen protection function better but now we don't need it</li>
<li>Fix the function that remember which tab is last clicked</li>
<li>Fix jQuery errors and replace all old ($) with function (jQuery)</li>
<li>New button to clear cache for watermarked images</li>
</ul>
=8.1=
<ul>
<li>separate between selection functions and hotkey functions</li>
<li>New option to stop CTRL + A</li>
<li>New option to stop CTRL + C</li>
<li>New option to stop CTRL + V</li>
<li>New option to stop CTRL + S</li>
<li>New option to stop CTRL + X</li>
<li>New option to stop CTRL + U</li>
<li>New option to stop CTRL + P</li>
<li>New option to stop F12</li>
<li>Update on option Ctrl + P</li>
<li>Fix for inputs and any content editable filed selection exclusion</li>
<li>Check with the last wodpress version 5.3.2</li>
</ul>
=7.2=
<ul>
<li>Class exclusion issue fixed</li>
</ul>
=7.1=
<ul>
<li>Watermark caching added</li>
</ul>
=6.9.2=
<ul>
<li>Improve CDN watermarking exclusion</li>
</ul>

=6.9.1=
<ul>
<li>Improve Selection Exclude by class name</li>
</ul>

=6.9=
<ul>
<li>Sanitizing: Cleaning User Input data</li>
<li>Escaping: Securing Output all output data</li>
<li>Multisite installation supported now</li>
<li>Fix error generated during activation on some websites</li>
<li>Remove the option to exclude admin from protection from custom settings tab</li>
<li>Include new 5 options to exclude from protection by user type</li>
<li>Adding a checking message to know if The htaccess file is writable or not</li>
<li>Adding a function to report any error during activation</li>
</ul>

=6.8.2=
<ul>
<li>Fix function name duplication</li>
</ul>

=6.8.1=
<ul>
<li>Fix undefined index issue shows with 6.8 update</li>
<li>Now, Your browser will still remember the last opened tab inside the plugin admin panel</li>
</ul>

=6.8=
<ul>
<li>New feature added to exclude users by type from protection, you can find this feature options under the exclusion tab</li>
</ul>

=6.7=
<ul>
<li>Fix preview alert mesage button inside admin panel</li>
</ul>

=6.6=
<ul>
<li>Fix error with cutom CSS settings</li>
</ul>
=6.5=
<ul>
<li>Fix a big with apostrophe as it was replace every single qutation with '/ and if you go again in settings it will be '\\\\ etc..., this is fixed now</li>
<li>Check compatapility with wordpress 5.2.2</li>
</ul>

=6.4=
<ul>
<li>Improve Smart protection techniques using new jQuery functions</li>
<li>Fix to show mouse pointer as a hand pointer over links</li>
</ul>

=6.3.1=
<ul>
<li>Fix issue with mac os CMD button and right click</li>
<li>Protect your pages from the chrome extension called (Allow Select And Copy)</li>
<li>Protect your pages from the chrome extension called (Simple Allow Copy)</li>
</ul>

=6.2.3=
<ul>
<li>DropDown menu CSS fix</li>
</ul>

=6.2.2=
<ul>
<li>Fix error (undefined mesage) showin after update</li>
</ul>

=6.2.1=
<ul>
<li>fix php-update checker</li>
<li>Change old style with new one</li>
<li>Update interface to be 100% responsive</li>
<li>Replace JavaScript tabs with pure CSS tabs</li>
<li>Enhance online bots exclusion</li>
<li>PHP7 compatibility fix</li>
<li>Watermark find website url function fix</li>
</ul>

=5.0.0.1=
Bug fix
some style fixes
Fix watermark issues

==4.0.0.6==
Fix exclude urls problem

==4.0.0.5==
Fix alert when using hotkeys with textboxes

==4.0.0.4==
Fix confliction when activate the plugin without deactivating the free version

==4.0.0.2==
Fix watermarking home_path null value
Fix transparent image absulute url and make it relative

==4.0.0.1==
Add disable pritscreen option "works good with some browsers
Add option to enable or disable Ctrl+P option
Add option to enable or disable Ctrl+S option
Allow Message Show Time to be have zero value

=3.0.0.13=
Bug fix

=3.0.0.11=
Bug fix

=3.0.0.10=
Make watermarking image url without shown parameters

=3.0.0.9=
Prevent print screen with firefox

=3.0.0.8=
Fix transparent images watermarking problem

=3.0.0.7=
Fix Division by zero in error inside watermark.php file

=3.0.0.6=
Fix the scrollbar issue with safari

=3.0.0.4=
Fix the relative images path problem
Fix allow_url_fopen which is blocked by some servers

=3.0.0.3=
Admin can disable copy protection for logged in/registered users
disable the possible shortcut keys for copying the Text
You can also choose where this Plugin should work like All Pages (including Home Page and all other Pages & Posts) or Home Page or Custom Pages/Posts using the Settings Page options.
Multiple Text and Image Protection methods

=3.0.0.2=
Advanced Image Protection using Responsive Lightbox
Protect your Text and Images by Disabling the Mouse Right Click and Possible Shortcut Keys for Cut (CTRL+x), Copy (CTRL+c), Paste (CTRL+v), Select All(CTRL+a), View Source (CTRL+u) etc.

=3.0.0.1=
control the protection to be on users only (if admin here dont protect)
Option to Display Alert Message on Mouse Right Click.
Enable Right Click on Hyperlink Option Added
Right click problem fixed on static pages
New flat interface

=2.0.0.4=
<ul>
<li>Compatible with the new 4.2.1 version</li>
<li>Add coloring settins to colorize the alert message</li>
<li>Add Restore defaults Button</li>
</ul>
= 2.0.0.3 =
<ul>
<li>Adding adminbar link and icon redirecting you to the plugin settings page</li>
<li>Adding settings link into the plugins list page</li>
</ul>
= 2.0.0.2 =
<ul>
<li>Adding isset() function to all variables</li>
<li>Improving alert message</li>
<li>Fixing CTRL + U issue</li>
<li>Fixing CSS tricks</li>
</ul>
= 1.5.0.1 =
<ul>
<li>Fixing error (Warning: join(): Invalid arguments passed in /home/retailmakeover/public_html/wp-includes/post-template.php on line 478)</li>
</ul>
= 2.0.0.1 =
<ul>
<li>Admin can disable copy protection for logged in/admin users</li>
<li>disable the possible shortcut keys for copying the Text</li>
<li>You can also choose where this Plugin should work like All Pages (including Home Page and all other Pages & Posts) or Home Page or Custom Pages/Posts using the Settings Page options.</li>
<li>Multiple Text and Image Protection methods</li>
<li>Advanced Image Protection using Responsive Lightbox</li>
<li>Protect your Text and Images by Disabling the Mouse Right Click and Possible Shortcut Keys for Cut (CTRL+x), Copy (CTRL+c), Paste (CTRL+v), Select All(CTRL+a), View Source (CTRL+u) etc.</li>
<li>control the protection to be on users only (if admin here dont protect)</li>
<li>Option to Display Alert Message on Mouse Right Click.</li>
<li>Enable Right Click on Hyperlink Option Added</li>
<li>Right click problem fixed on static pages</li>
<li>New flat interface</li>
</ul>
= 1.0 =
<ul>
<li>initial version</li>
<li>static pages bug fixed</li>
<li>home page problem fixed</li>
<li>Add new Style</li>
</ul>