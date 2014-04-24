/*------------------------------------------------------------------------------------------

File: store.js
Summary: Javascript for Store support
	  
Javascript functions for Sitemason Store support.  Called from store/detail.head.php and
store/list.head.php.
  
Copyright (C) 2013 Sitemason, Inc. All Rights Reserved. 
 
------------------------------------------------------------------------------------------*/

function productAddedToCart() {
	$.fancybox.open({
		href: '#foxycart-cart',
		padding: 5,
		autoSize: false,
		width: "600px",
		height: "80%"
	});
	return false;
}