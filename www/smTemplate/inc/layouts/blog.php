<?php
    echo '<section id="main" class="page_width">

        <div class="content_left">';
	

		$news = $smCurrentSite->getToolWithSlug('news');
		
		// since we only want five articles, we can limit them with getItemsWithLimitAndOffset()
		$articles = $news->getItemsWithLimitAndOffset(5,0);
		
		foreach ($articles as $article) {
                    echo '<article class="blog_wrapper">';
                    // TO DO: IMAGE
                    echo '<div class="featured_image">
                            <img src="img/image1.jpg" alt="blog slide 1" />
                        </div> End of featured image ';
                    
                    $startTime = new DateTime($article->getStartTimestamp());
                    $image = $article->getImage();

                    echo '<div class="posted_details">
                            <div class="datepic"></div>
                            <div class="post_content">'.$startTime->format('F j, Y').'</div>
                        </div><!-- End of posted details -->
                        <br />
                        <div class="hrr"></div>
                        <h1><a href="#">'.$article->getTitle().'</a></h1>
                        <div class="featured_text_full">
                            <p></p>
                            <div class="social_share_wrapper">

                            <div class="socialpic"></div>

                                <div class="social_share_links">
                                    <a class="socialsharing" target="_blank" href="http://www.facebook.com/share.php?u='.$article->getURL().'">facebook</a>
                                    <a class="socialsharing" target="_blank" href="https://plus.google.com/share?url='.$article->getURL().'">google</a>
                                    <a class="socialsharing" target="_blank" href="http://twitter.com/home?status='.$article->getURL().'">twitter</a>
                                    <a class="socialsharing" target="_blank" href="http://pinterest.com/pin/create/button/?url='.$article->getURL().'">pinterest</a>
                                </div><!-- End of social share links -->

                            </div><!-- End of social share wrapper -->
                        </div>
                        <div class="clear"></div>
                        </article>';
                    
//                    echo '<li><div class="headline"><a href="'. $article->getURL() .'">'. $article->getTitle() .'</a></div><div class="date">'. $startTime->format('F j, Y') .'</div></li>';
		}

//		echo '	</ul>';
//		echo '</div>';
	

?>

<!--<section id="main" class="page_width">

        <div class="content_left">

            <article class="blog_wrapper">

                <div class="featured_image">
                    <img src="img/image1.jpg" alt="blog slide 1" />
                </div> End of featured image 

                <div class="posted_details">
                    <div class="datepic"></div>
                    <div class="post_content">August 7th, 2012</div>
                </div> End of posted details 

                <br />

                <div class="hrr"></div>

                <h1><a href="#">Gallery Post Format</a></h1>

                <div class="featured_text_full">

                    <p>Example of a Post Type of Gallery in WordPress – this will automatically gather any attached images to a post and display them as a slider both here on the blog index page and also the individual post page – also note that if your category for the homepage loop is chosen, your gallery images</p>

                    <a class="forward" href="#">read more</a>

                    <div class="social_share_wrapper">

                        <div class="socialpic"></div>

                        <div class="social_share_links">
                            <a class="socialsharing" target="_blank" href="http://www.facebook.com/share.php?u=yoururlgoeshere">facebook</a>
                            <a class="socialsharing" target="_blank" href="https://plus.google.com/share?url=yoururlgoeshere">google</a>
                            <a class="socialsharing" target="_blank" href="http://twitter.com/home?status=yoururlgoeshere">twitter</a>
                            <a class="socialsharing" target="_blank" href="http://pinterest.com/pin/create/button/?url=yoururlgoeshere">pinterest</a>
                        </div> End of social share links 

                    </div> End of social share wrapper 

                </div> End of featured text blog 

                <div class="clear"></div>

            </article> End of blog wrapper 


            <article class="blog_wrapper">

                <div class="featured_image">
                    <img src="img/mountains.jpg" alt="featured image" />
                </div> End of featured image 

                <div class="posted_details">
                    <div class="datepic"></div>
                    <div class="post_content">August 7th, 2012</div>
                </div> End of posted details 

                <br />

                <div class="hrr"></div>

                <h1><a href="#">Blog Title 1</a></h1>

                <div class="featured_text_full">

                    <p>Welcome to the good ol' standard post format – you can add a featured image or not, type your post and link to articles and even place inline images or a fancy lightbox powered standard wordpress gallery to your post.</p>

                    <a class="forward" href="#">read more</a>

                    <div class="social_share_wrapper">
                        <div class="socialpic"></div>
                        <div class="social_share_links">
                            <a class="socialsharing" target="_blank" href="http://www.facebook.com/share.php?u=yoururlgoeshere">facebook</a>
                            <a class="socialsharing" target="_blank" href="https://plus.google.com/share?url=yoururlgoeshere">google</a>
                            <a class="socialsharing" target="_blank" href="http://twitter.com/home?status=yoururlgoeshere">twitter</a>
                            <a class="socialsharing" target="_blank" href="http://pinterest.com/pin/create/button/?url=yoururlgoeshere">pinterest</a>
                        </div> End of social share links 
                    </div> End of social share wrapper 

                </div> End of featured text blog 

                <div class="clear"></div>

            </article> End of blog wrapper 

            <hr />

            <a class="forward" href="#">More Blog Articles</a>

        </div> End of content left -->