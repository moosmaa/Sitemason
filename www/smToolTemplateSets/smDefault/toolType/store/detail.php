<?php

/*------------------------------------------------------------------------------------------

File: store/detail.php 
Summary: Detail (individual item) view for the Store tool
Version: 6.0
	  

  
Copyright (C) 2013 Sitemason, Inc. All Rights Reserved. 

------------------------------------------------------------------------------------------*/

	$item = $smCurrentTool->getItem();

	echo '<h1 class="store-title">'. $item->getTitle() .'</h1>';

	echo '<div class="store-meta">';
	echo '	<div class="productCode">Product Code: '. $item->getProductCode() .'</div>';
	echo '	<div class="weight">Weight: '. $item->getWeight() .'</div>';
	if ($item->getMaximumQuantityAllowedInCart()) {
		echo '	<div class="maxQuantity">Max Quantity: '. $item->getMaximumQuantityAllowedInCart() .'</div>';
	}
	echo '</div>';

	//
	// Main Image
	//
	
	$image = $item->getLargeImageSize();
	if ($image) {
		echo '<div class="store-image image-full image-right">';
		
		// Image
		echo '	<img class="image" src="'. $image->getURL() .'" width="'. $image->getWidth() .'" height="'. $image->getHeight() .'" alt="'. $image->getAlt() .'" />';
		
		// Caption
		$caption = $image->getCaption();
		if ($caption) {
			echo '<p class="image-caption">'. $image->getCaption() .'</p>';	
		}
		
		echo '</div>';
	}

	//
	// Body
	//
	
	echo $item->getBody();
	
	//
	// Add to Cart form
	//
	
	$fcSubdomain = $smCurrentTool->getFoxyCartSubdomain(); // FoxyCart Subdomain from Store->Store Settings->FoxyCart Settings
	$productCode = $item->getProductCode();	// Product code of the item for sale
	$storePath = $smCurrentTool->getUrl(); // Stores path, usually "store"
	$fcAPIKey = $smCurrentTool->getFoxyCartAPIKey(); // FoxyCart API Key from Store->Store Settings->FoxyCart Settings
	$siteUrl = parse_url($smCurrentSite->getUrl());
	$hostname = $siteUrl['host']; // Hostname of site to pass to getStoreAddHtml()
	
	
	// FC subdomain and productCode are required!
	if ($fcSubdomain && $productCode) {
		// Call function to generate Add to Cart form from /smToolTemplateSets/smDefault/toolType/store/storeFunctions.php 
		echo getStoreAddHTML($fcSubdomain, $hostname, $productCode, $storePath, $options, $item);	
	} else {
		echo '<form class="cart-add" action="https://'. $fcSubdomain .'.foxycart.com/cart" method="post" target="foxycart-cart" onSubmit="productAddedToCart();">'."\n";
		#echo '	<label class="form-label" for="quantity">Quantity:</label>'."\n";
		#echo '	<input class="form-text" name="quantity" type="number" value="1" min="'. $item->getMinimumQuantityAllowedInCart() .'" max="'. $item->getMaximumQuantityAllowedInCart() .'" disabled="true" />'."\n";
		#echo '	<input name="name" type="hidden" value="'. $item->getTitle() .'" />'."\n";
		#echo '	<input name="price" type="hidden" value="'. $item->getPrice() .'" />'."\n";
		#echo '	<input class="form-submit form-add" type="submit" value="Add to cart" disabled="true" />'."\n";
		echo '	<div class="cart-total">Total price: '. $item->getFormattedPrice('USD') .'</div>'."\n";
		echo '</form>';
	}
	
	
	
?>