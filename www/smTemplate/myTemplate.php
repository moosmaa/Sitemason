<?

    /*-------------------------------------------------------------------------------------
        Sitemason, Inc.
        www.sitemason.com

        Boilerplate example Sitemason® template

        This template is dropped into new Sitemason accounts by default and serves two 
        purposes: 1) It gives new users something to see and allows them to mess around 
        with Sitemason.  2) It serves as a basic example of how to make a Sitemason PHP
        template.

        If you're reading this, then odds are that you're more-interested in #2.  We have
        attempted to be verbose with the comments throughout this code.  If you have
        questions, please post them to our developer forum (and be sure to note the
        version of this Boilerplate template):

        http://support.sitemason.com/forums/279544-Developer-Help


        We will expand this example over time, so check our developer website to get the 
        most current version of this template.


        History:
        20130801	6.0 (initial release)

    -------------------------------------------------------------------------------------*/



    /*

        Notes on Sitemason Objects

        We'll reference a few objects throughout this example template, so here are a few
        notes on those.  If you're looking for a more in-depth discussion and/or documentation
        on the various classes used in this development library, please visit the Sitemason 
        Developer website:

        http://www.sitemason.com/developers

        The purpose of the Sitemason Devlopment Library (SMDevLib) is to transform the data 
        stored in Sitemason CMS (the text, photos, videos, and content that you enter into 
        Sitemason CMS) into objects that you can use to present that data to the user.  You 
        could use the objects to create HTML (which we're doing in this template).  
        Alternatively, you might choose to present data via a JSON or XML feed (useful for 
        sending data to mobile apps) or some other purpose.  For this example (and since this 
        is a template), we're only focusing on generating HTML.

        Your hostname folder (most likely "www") contains its own copy of the SMDevLib,
        which is stored in the following location:

        ~/www/.sitemason/SMLibPHP/[the version]

        You'll also notice a few other files in the .sitemason folder: "config.json" and
        "templateLoader.php." When you visit any page in your website, templateLoader.php
        gets called automatically and 1) loads the SMDevLib (based on the verison stated in that
        file and contained in the SMLibPHP folder), 2) creates a few objects automatically,
        and 3) calls this template (based on settings in config.json).  We're going to focus on 
        step 2: the objects that get created.

        There are three main objects that get created automatically and are stored in three
        variables: $smCurrentSite, $smCurrentFolder, and $smCurrentTool.  These three objects
        are based on the page of your website that you (or your site visitor) are currently
        viewing.  It's helpful to look at these in reverse order:

        $smCurrentPage: this is an SMTool object representing the page that you're currently
        viewing.  For example, if your website includes a news page (a News tool in
        Sitemason) at http://www.sitemason.com/news and you're viewing that page, $smCurrentPage 
        would be an SMTool object representing that News tool.  It would contain multiple articles
        (SMItem objects) and each of those might contain images (SMImage objects), tags (SMTag
        objects), and other data.

        $smCurrentFolder: this is the SMFolder containing $smCurrentPage.  If your website
        has no folders or the $smCurrentPage in question is at the root level, then
        $smCurrentFolder is identical to $smCurrentSite (and you'll notice that SMFolder is a
        subclass of SMSite).  $smCurrentFolder is probably the least-used of the big three
        objects.

        $smCurrentSite: this is an SMFolder object representing the entire website.
        You would call methods on this object for navigation and/or to access any of the
        website's properties.

        For more information, see the Sitemason Developer site:
        http://www.sitemason.com/developers/

    */
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
            /*
                This method includes any scripts that are required in the HEAD section by the 
                currently-displayed tool, as dictated in the selected Tool Template Set
            */
            $smCurrentTool->printHTMLHead();


            /*
                include this Site Template's CSS.  $smTemplateFolder is "/smTemplate" in this case,
                because this template's path in config.json is "smTemplate/boilerplate.php"
            */
            echo '<link rel="stylesheet" href="'. $smTemplateFolder .'/css/smBoilerplate.css">';
            echo '<link rel="stylesheet" href="'. $smTemplateFolder .'/css/main.css">';
            echo '<link rel="stylesheet" href="'. $smTemplateFolder .'css/jquery.fancybox.css">';
            echo '<link rel="stylesheet" media="print" href="'. $smTemplateFolder .'css/print.css">';

            /* Google Fonts */
            echo '<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,400italic,700,700italic">';
        ?>
    </head>
	
    <body>
        <header id="page_header">

            <div class="page_width clearfix">

                <div id="top_logo"><a href="#"><img src="smTemplate/img/TCV-logo-horizontal.png" alt="logo" /></a></div>

                <section class="social">
                    <ul class="icons clearfix">
                        <li><a href="#"><img src="smTemplate/img/social-youtube-large.png"  height="33" width="33" alt="Youtube"  /></a></li>
                        <li><a href="#"><img src="smTemplate/img/social-twitter-large.png"  height="33" width="33" alt="twitter"  /></a></li>
                        <li><a href="#"><img src="smTemplate/img/social-facebook-large.png" height="33" width="33" alt="facebook" /></a></li>                
                    </ul>
                </section><!-- End of social -->

                <div id="searchbox">
                    <form role="search" method="get" id="searchform" action="#">
                        <span class="searchme"></span><input type="text" value="search" name="s"  onblur="if(this.value == '') { this.value = 'search'; }" onfocus="if(this.value == 'search') { this.value = ''; }" />
                    </form>
                </div><!-- End of searchbox -->

                <div class="homenewsletter">
                    <form action="yourscript.php" method="post" id="contactform">
                        <input type="text" size="40" value="" name="your-email" placeholder="Sign up for e-mail updates" />
                        <input class="news-submit" type="submit" value="Send"  />
                    </form>
                </div><!--End of home newsletter-->

                <!--Navigation Menu at the Top-->
                <nav id="topmenu" class="clearfix">
                    <ul class="sf-menu clearfix">
                    <?php
                        /*
                            Here we want to display the pages (and folders) for the root Folder (the website itself).
                            We'll call getNavigationTools() on $smCurrentSite to give us an array of SMTool and SMFolder
                            objects (with child SMTool objects) representing all Tools and Folders with the "Include in 
                            Navigation" setting toggled.

                            Since this is the primary navigation, we only care about the top level, so we won't traverse
                            any SMFolder objects that we may find.
                        */
                        $pages = $smCurrentSite->getNavigationTools();
                        foreach ($pages as $page) {
                            $class = '';
                            if ($page->isCurrentlyDisplayed()) {
                                    $class = 'active';
                            }

                            echo '<li><a class="'. $class .'" href="'. $page->getPath() .'">'. $page->getTitle() .'</a></li>';
                        }
                    ?>
                    </ul>
                </nav>
            </div>
        </header>

        <section role="main" class="content">
            <div class="content-main">
                <?php

                    /*
                        MAIN CONTENT

                        Here is where the main content's HTML will be rendered.  We have a few options: 1) We can use
                        the Tool Template Set's layouts as-is, 2) we can modify the Tool Template Set (which would affect
                        all layouts for a particular tool and view), or 3) we can define our own layout right here within
                        the Site Template and apply that to one or more Tools.

                        For this site, the "smDefault" Tool Template Set works well for pretty much everything except for
                        the sidebar tools (we'll get to those later) and the Presidents page, where we want to customize
                        the presentation of that list.

                        It's up to you whether to split any custom layouts into their own PHP files, but we're doing it here
                        because it's generally a good idea, because it keeps the code clean, since the layouts usually get 
                        pretty lengthy.

                    */

                    /* 
                        We want a custom layout for the Presidents page (and only the President's page), so switching by 
                        slug is a good option.  If we had multiple pages using the same layout, we might want to create a
                        Layout ("Layouts" tab under the Developer panel in the Sitemason interface) and then call getLayout()
                        for the Tool to see if there is a match.

                        Specifically, we'll want TWO layouts for the Presidents page: one for the listing of all Presidents
                        and another for an individual President's profile.
                    */
                    if ($smCurrentTool->getSlug() == 'presidents') {

                        // the list view (all Presidents)
                        if ($smCurrentTool->getView() == 'list') {
                                require_once('inc/layouts/presidents.list.php');
                        }

                        // the detail view (one President)
                        else {
                                require_once('inc/layouts/presidents.detail.php');
                        }

                    }

                    // For everything else, we'll use the Tool Template Set's layouts
                    else {
                        $smCurrentTool->printHTML();	
                    }

                ?>	
            </div>

            <div class="content-sidebar">
                <?php 
                    /*
                        SIDE CALLOUT

                        We're going to keep the sidebar's code in its own file as well, which keeps things clean.
                    */
                    require_once('inc/layouts/sidebar.php'); 
                ?>
            </div>
        </section>


        <footer class="site-footer">
                <div class="content-footer">
                    <small class="footer-copyright">
                    <?php
                        /*
                            Display the current Folder's Copyright data here.  It's good practice to call getCopyright
                            on $smCurrentFolder (as opposed to $smCurrentSite) because if we're on a subfolder with its
                            own Copyright, that data will take priority over the site's Copyright setting.  However, if
                            that subfolder does not have anything in its Copyright field, it will look up the site's
                            Copyright setting anyway.
                        */
                        echo 'copyright: '. $smCurrentFolder->getCopyright();
                    ?>
                    </small>
                    <small class="footer-promo">
                    <?php
                        // Display the Footer data
                        echo $smCurrentFolder->getFooter();
                    ?>
                    </small>
                </div>
        </footer>

        <?php
            $smCurrentTool->printHTMLBodyLast();
        ?>
    </body>
</html>