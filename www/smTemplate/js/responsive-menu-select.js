<!-- RESPONSIVE MENU SELECT  -->

// DOM ready
jQuery(document).ready(function(){

// Create the dropdown base
jQuery("<select />").appendTo("#topmenu");

// Create default option "Go to..."
jQuery("<option />", {
 "selected": "selected",
 "value"   : "",
 "text"    : "Menu Selection..."
}).appendTo("#topmenu select");

// Populate dropdown with menu items
jQuery("#topmenu a").each(function() {
var el = jQuery(this);
jQuery("<option />", {
   "value"   : el.attr("href"),
   "text"    : el.text()
}).appendTo("#topmenu select");
});

// To make dropdown actually work
// To make more unobtrusive: http://css-tricks.com/4064-unobtrusive-page-changer/
jQuery("#topmenu select").change(function() {
window.location = jQuery(this).find("option:selected").val();
});

});