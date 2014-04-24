<?php

/*------------------------------------------------------------------------------------------

File: store/detail.head.php 
Summary: Store detail <HEAD> section
Version: 6.0
	  
If store/detail.php requires anything in the document HEAD section, put it here and,
assuming the Site Template is configured properly, it will be included.
  
Copyright (C) 2013 Sitemason, Inc. All Rights Reserved. 
 
------------------------------------------------------------------------------------------*/

include_once('storeFunctions.php');

?>
<!-- Fancbox support -->
<script src="<?php echo $smToolTemplateSetPath; ?>/js/vendor/fancybox/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" href="<?php echo $smToolTemplateSetPath; ?>/js/vendor/fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />

<!-- Store support -->
<script src="<?php echo $smToolTemplateSetPath; ?>/js/store.js"></script>