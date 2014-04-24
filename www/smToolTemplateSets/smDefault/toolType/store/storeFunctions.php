<?php
	// Function to add foxycart.js and store.js to the bottom of any page the Mini Cart and Add to Cart forms appear. 
	// Appears in /smToolTemplateSets/smDefault/toolType/store/list.last.php and /smToolTemplateSets/smDefault/toolType/store/detail.last.php of the default Tool Template Set
	function printFoxyCartSitemasonJavascript($smCurrentTool) {
		global $storeAddItems;
		$n = "\n";
		# In Footer 
		echo '<script src="https://cdn.foxycart.com/' . $smCurrentTool->getFoxyCartSubdomain() . '/foxycart.js" type="text/javascript" charset="utf-8"></script>'.$n;
		echo '	<script type="text/javascript">'.$n;
		if (count($storeAddItems) > 0) {
			echo '		var smStoreSettings = { storeName: \'' . $smCurrentTool->getFoxyCartSubdomain() . '\', items: ['.$n;
			$cnt = 0;
			foreach ($storeAddItems as $item) {
				$cnt++;
				echo '			{ id: \'' . $item['id'] . '\', ref: \'' . $item['ref'] . '\', basePrice: \'' . $item['price'] . '\' }';
				if ($cnt < count($storeAddItems)) { echo ','; }
				echo $n;
			}
			echo '		] };'.$n;
		} else {
			echo '		var smStoreSettings = { storeName: \'' . $smCurrentTool->getFoxyCartSubdomain() . '\' };'.$n;
		}
		echo '	</script>'.$n;
		echo '	<script src="/.sm/scripts/sitemason.com/store.js" type="text/javascript"></script>'.$n;
	}



	// function that generates the Add to Cart form HTML. Used in /smToolTemplateSets/smDefault/toolType/store/detail.php of the default Tool Template Set
	function getStoreAddHTML($storeName, $hostname, $storeId, $baseUrl, $options = null, $item = null) {
		global $storeAddItems; 

		$n = "\n";
	
		if (!isset($storeAddCount)) {
			$storeAddCount = 1;
			$storeAddItems = array();
		}
		$ref = $storeAddCount;
	
		$add_html = '<div itemprop="offers" itemscope itemtype="http://schema.org/Offer">'.$n;
		if ($item->shouldTrackQuantity() && $item->shouldPreventBackorder() && ((int)$item->getCurrentQuantity() < 1)) {
			if ($item->getProductAvailabiltyMessage()) { $add_html .= '<div class="smWarning smStoreWarning smStoreAddWarning smStoreAddAvailability" itemprop="availability">' . $item->getProductAvailabiltyMessage() . '</div>'.$n; }
		} else if ($item->shouldTrackQuantity() && $item->shouldPreventBackorder() && $item->getMinimumQuantityAllowedInCart() && ((int)$item->getCurrentQuantity() < (int)$item->getMinimumQuantityAllowedInCart())) {
			if ($item->getProductAvailabiltyMessage()) { $add_html .= '<div class="smWarning smStoreWarning smStoreAddWarning smStoreAddAvailability" itemprop="availability">' . $item->getProductAvailabiltyMessage() . '</div>'.$n; }
		} else {
			if ($options['store_form_tag_html']) {
				$add_html .= $options['store_form_tag_html'];
			} else {
				$add_html .= '<form id="smStoreAddForm_' . $ref . '" class="smStoreAdd smStoreAddForm" accept-charset="utf-8" action="https://' . $storeName . '.foxycart.com/cart" method="post">'.$n;
			}
			if ($item->getProductCode()) {
				$add_html .= '	<input name="h:' . $item->getProductCode() . '-id" type="hidden" value="' . $item->getId() . '" />'.$n;
			}
			$add_html .= '	<input name="h:instance_id" type="hidden" value="' . $storeId . '" />'.$n;
			$add_html .= '	<input name="h:hostname" type="hidden" value="' . $hostname . '" />'.$n;
			$add_html .= '	<input name="h:store_url" type="hidden" value="' . $baseUrl . '" />'.$n;
			$title = preg_replace('/"/', '', $item->getTitle());
			$add_html .= '	<input name="name" type="hidden" value="' . $title . '" />'.$n;
			$price = '0.00';
			if ($item->getPrice()) { $price = $item->getPrice(); }
			$add_html .= '	<input name="price" type="hidden" value="' . $price . '" />'.$n;
/*
			# Example using a subscription instead of one-time payment. More Info here: http://www.foxycart.com/features/feature/products/subscriptions
			if ($item->getCustomFieldWithKey('1')) { $frequency = $item->getCustomFieldWithKey('1'); }
			if ($item->getCustomFieldWithKey('2')) { $altPrice = $item->getCustomFieldWithKey('2'); }
			$add_html .= '	<select id="sub_frequency" name="sub_frequency">   
						         <option value="' . $frequency . 'm">Monthly ($' . $frequency . '/mo)</option>  
						         <option value="1y{p:' . $altPrice . '}">Yearly ($' . $altPrice . '/yr, save 10%!)</option>   
						    </select>';
*/
			if ($item->getThumbnailImageSize()) { $add_html .= '	<input name="image" type="hidden" value="' . $item->getThumbnailImageSize()->getUrl() . '" />'.$n; }
			$add_html .= '	<input name="url" type="hidden" value="' . $item->getUrl() . '" />'.$n;
			if ($item->getProductCode()) { $add_html .= '	<input name="code" type="hidden" value="' . $item->getProductCode() . '" />'.$n; }
			if ($item->getShippingAndDiscountCategory()) { $add_html .= '	<input name="category" type="hidden" value="' . $item->getShippingAndDiscountCategory() . '" />'.$n; }
			if ($item->getWeight()) { $add_html .= '	<input name="weight" type="hidden" value="' . $item->getWeight() . '" />'.$n; }
		
			if ($item->shouldTrackQuantity()) {
				if ($item->shouldPreventBackorder() && $item->getMaximumQuantityAllowedInCart() && ((int)$item->getCurrentQuantity() < (int)$item->getMaximumQuantityAllowedInCart())) {
					$add_html .= '	<input name="quantity_max" type="hidden" value="' . $item->getCurrentQuantity() . '" />'.$n;
				} else if ($item->shouldPreventBackorder() && !$item->getMaximumQuantityAllowedInCart()) {
					$add_html .= '	<input name="quantity_max" type="hidden" value="' . $item->getCurrentQuantity() . '" />'.$n;
				} else if ($item->getMaximumQuantityAllowedInCart()) {
					$add_html .= '	<input name="quantity_max" type="hidden" value="' . $item->getMaximumQuantityAllowedInCart() . '" />'.$n;
				}
				if ($item->getMinimumQuantityAllowedInCart()) { $add_html .= '	<input name="quantity_min" type="hidden" value="' . $item->getMinimumQuantityAllowedInCart() . '" />'.$n; }
				if ($item->getProductAvailabiltyMessage() && ($item->getCurrentQuantity() < 1)) {
					$add_html .= '<div class="smWarning smStoreWarning smStoreAddWarning smStoreAddAvailability" itemprop="availability">' . $item->getProductAvailabiltyMessage() . '</div>'.$n;
				}
			}
		
			# Attributes
			if ($options['store_attribute_html']) {
				$add_html .= $options['store_attribute_html'];
			} elseif ($item->getProductAttributes()) {
				$modifies_price = false;
				$item_attributes = explode("\n", $item->getProductAttributes());
				$store_attributes = explode("\n", null);
				$attributes = array_merge($item_attributes, $store_attributes);
			
				$full_attributes_html = '';
				foreach ($attributes as $attribute) {
					$attribute_html = '';
					$label_modifier = '';
					$type = '';
					$pair = explode(":", $attribute, 2);
					$label = $fieldname = $attribute;
					if ($pair[0]) { $label = $fieldname = $pair[0]; }
					$label = preg_replace('/_/', ' ', $label);
					if ($pair[1]) {
						$values = explode(";", $pair[1]);
						if (count($values) > 1) {
							$type = 'Menu';
							$attribute_html .= '		<select name="' . $fieldname . '" class="smMenu smStoreMenu smStoreAddMenu smStoreAddAttributeMenu smStoreAddAttributeValue">'.$n;
							foreach ($values as $value) {
								if ($value) {
									preg_match('/^(.+?)\{(.*?)\}$/', $value, $parts);
									if ($parts[2]) {
										$olabel = $parts[1];
										$modifiers = explode("\|", $parts[2]);
										foreach ($modifiers as $modifier) {
											preg_match('/^([pwcy])([\:\+\-])([\d\.]+)/i', $modifier, $mod_parts);
											if ($mod_parts[1] == 'p') {
												$modifies_price = true;
												if ($mod_parts[2] == ':') {
													$olabel .= ' [$' . money_format('%i', (float) $mod_parts[3]) . ']';
												} else {
													$olabel .= ' [' . $mod_parts[2] . '$' . money_format('%i', (float) $mod_parts[3]) . ']';
												}
											}
										}
										$attribute_html .= '			<option value="' . $value . '">' . $olabel . '</option>'.$n;
									} else {
										$attribute_html .= '			<option value="' . $value . '">' . $value . '</option>'.$n;
									}
								}
							}
							$attribute_html .= '		</select>'.$n;
						} else {
							$type = 'Checkbox';
							$label_modifier = '';
							preg_match('/^(.+?)\{(.*?)\}$/', $values[0], $parts);
							if ($parts[2]) {
								$modifiers = explode("\|", $parts[2]);
								foreach ($modifiers as $modifier) {
									preg_match('/^([pwcy])([\:\+\-])([\d\.]+)/i', $modifier, $mod_parts);
									if ($mod_parts[1] == 'p') {
										$modifies_price = true;
										if ($mod_parts[2] == ':') {
											$label_modifier .= ' [$' . money_format('%i', (float) $mod_parts[3]) . ']';
										} else {
											$label_modifier .= ' [' . $mod_parts[2] . '$' . money_format('%i', (float) $mod_parts[3]) . ']';
										}
									}
								}
							}
							$attribute_html .= '		<input type="checkbox" name="' . $fieldname . '" value="' . $values[0] . '" class="smCheckbox smStoreCheckbox smStoreAddCheckbox smStoreAddAttributeCheckbox smStoreAddAttributeValue" />'.$n;
						}
					} elseif ($label) {
						$type = 'Textbox';
						$attribute_html .= '		<input type="text" name="' . $fieldname . '" class="smInput smInputTextbox smStoreInput smStoreInputTextbox smStoreAddInput smStoreAddInputTextbox smStoreAddAttributeInput smStoreAddAttributeTextbox smStoreAddAttributeValue" />'.$n;
					}
					if ($attribute_html) {
						$full_attributes_html .= '	<div id="smStoreAddAttribute_' . $fieldname . '" class="smStoreAddContainer smStoreAddAttributeContainer smStoreAddAttribute' . $type . 'Container">'.$n;
						$full_attributes_html .= '		<label class="smLabel smStoreLabel smStoreAddLabel smStoreAddAttributeLabel" for="' . $fieldname . '">' . $label . $label_modifier . ':</label>'.$n;
						$full_attributes_html .= $attribute_html;
						$full_attributes_html .= '	</div>'.$n;
					}
				}
				if ($modifies_price) {
					$add_html .= '	<div id="smStoreAddBaseContainer_' . $ref . '" class="smStoreAddContainer smStoreAddBaseContainer">'.$n;
					$add_html .= '		<span class="smLabel smStoreLabel smStoreAddLabel smStoreAddBaseLabel">Base price:</span>&nbsp;';
					$add_html .= '<span id="smStoreAddBasePrice_' . $ref . '" class="smPrice smStorePrice smStoreAddPrice smStoreAddBasePrice" itemprop="price">$' . $price . '</span>&nbsp;'.$n;
					$add_html .= '	</div>'.$n;
				}
				$add_html .= $full_attributes_html;
			}
		
			if ($options['store_quantity_html']) {
				$add_html .= $options['store_quantity_html'];
			} else {
				$add_html .= '	<div id="smStoreAddTotalContainer_' . $ref . '" class="smStoreAddContainer smStoreAddTotalContainer">'.$n;
				$add_html .= '		<span class="smLabel smStoreLabel smStoreAddLabel smStoreAddTotalLabel">Total price:</span>&nbsp;';
				$add_html .= '<span id="smStoreAddTotalPrice_' . $ref . '" class="smPrice smStorePrice smStoreAddPrice smStoreAddTotalPrice" itemprop="price">$' . $price . '</span>&nbsp;'.$n;
				$add_html .= '	</div>'.$n;
				$add_html .= '	<div id="smStoreAddQtyContainer_' . $ref . '" class="smStoreAddContainer smStoreAddQtyContainer">'.$n;
				$add_html .= '		<label for="quantity" class="smLabel smQtyLabel smStoreLabel smStoreQtyLabel smStoreAddLabel smStoreAddQtyLabel">Quantity:</label>'.$n;
				$add_html .= '		<input name="quantity" type="text" value="1" class="smInput smInputTextbox smInputNumber smInputQty smStoreInput smStoreInputTextbox smStoreInputNumber smStoreInputQty smStoreAddInput smStoreAddInputTextbox smStoreAddInputNumber smStoreAddInputQty" />'.$n;
				$add_html .= '	</div>'.$n;
			}
			if ($options['store_submit_html']) {
				$add_html .= $options['store_submit_html'];
			} else {
				$add_html .= '	<div id="smStoreAddButtonContainer_' . $ref . '" class="smStoreAddContainer smStoreAddButtonContainer">'.$n;
				$add_html .= '		<input id="smStoreAddButtonSubmit_' . $ref . '" class="smButton smButtonSubmit smStoreButton smStoreButtonSubmit smStoreAddButton smStoreAddButtonSubmit" type="submit" value="Add to cart" />'.$n;
				$add_html .= '	</div>'.$n;
			}
			$add_html .= '</form>'.$n;
		
			array_push($storeAddItems, array(
				id		=> (string) $item->getId(),
				price	=> (string) $price,
				ref		=> (string) $ref
			));
			$storeAddCount++;
		}
		$add_html .= '</div>'.$n;
		return $add_html;
	}


	// Generates the Mini Cart on store pages. Used in /smTemplate/inc/layouts/sidebar.php of the boilerplate template
	function getStoreCartHTML($storeName, $options = null) {
		$n = "\n";
		
		$cart_title = 'Shopping Cart';
		if ($options['cartTitle']) { $cart_title = $options['cartTitle']; }
		$checkout_text = 'View Cart and Check Out';
		if ($options['checkoutButtonText']) { $checkout_text = $options['checkoutButtonText']; }
		
		$cart_html = '	<div id="smStoreCart" class="smStoreCart smStoreCartEmpty">'.$n;
		$cart_html .= '		<h3>' . $cart_title . '</h3>'.$n;
		$cart_html .= '		<ul id="smStoreCartList" class="smList smStoreList smStoreCartList">'.$n;
		$cart_html .= '			<li class="smListOdd smStoreCartListOdd">No items in cart</li>'.$n;
		$cart_html .= '		</ul>'.$n;
		$cart_html .= '		<div class="smStoreCartTotal">'.$n;
		$cart_html .= '			<span class="smLabel smStoreLabel smStoreCartLabel smStoreCartTotalLabel">Subtotal:</span> '.$n;
		$cart_html .= '			<span id="smStoreCartTotalPrice" class="smPrice smStorePrice smStoreCartPrice smStoreCartTotalPrice">$0.00</span>'.$n;
		$cart_html .= '		</div>'.$n;
		$cart_html .= '		<div class="smStoreCartCheckout">'.$n;
		$cart_html .= '			<a id="smStoreCartCheckout" href="#" onclick="window.location=\'https://' . $storeName . '.foxycart.com/cart\'; return false;">' . $checkout_text . '</a>'.$n;
		$cart_html .= '		</div>'.$n;
		$cart_html .= '	</div>'.$n;
		return $cart_html;
	}

?>