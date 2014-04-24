<?php

/*------------------------------------------------------------------------------------------

File: gallery/list.php 
Summary: The Gallery view
Version: 6.0
	
  
Copyright (C) 2013 Sitemason, Inc. All Rights Reserved. 
 
------------------------------------------------------------------------------------------*/

?>

<div class="gallery">
	<?php
		// Tool title
		if ($smCurrentTool->getTitle()) {
			echo '<h1 class="gallery-title">'. $smCurrentTool->getTitle() .'</h1>';
		}
	?>
	<div class="gallery-content">
	<?php
		$items = $smCurrentTool->getItems();
		foreach ($items as $item) {
			$thumbnail = $item->getThumbnailImageSize();
			$large = $item->getLargeImageSize();
			
			// Here we're choosing to display the caption and copyright beneath the photo... substitute these with other properties if you wish.
			echo '<a class="gallery-image-link" copyright="'. $thumbnail->getCopyright() .'" title="'. $thumbnail->getCaption() .'" href="'. $large->getURL() .'">';
			echo '	<img class="gallery-image-thumb" src="'. $thumbnail->getURL() .'" alt="'. $thumbnail->getAlt() .'" />';
			echo '</a>';
		}
	?>
		
		
	</div>
</div>