<?php get_header(); ?>


<?php
if ( get_option( 'show_on_front' ) == 'page' ) {
    ?>
	<div class="clear"></div>

	</header> <!-- / END HOME SECTION  -->



		<div id="content" class="site-content">

	<div class="container">



	<div class="content-left-wrap col-md-9">



		<div id="primary" class="content-area">

			<main id="main" class="site-main" role="main">



			<?php if ( have_posts() ) : ?>



				<?php /* Start the Loop */ ?>

				<?php while ( have_posts() ) : the_post(); ?>



					<?php

						/* Include the Post-Format-specific template for the content.

						 * If you want to override this in a child theme, then include a file

						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.

						 */

						get_template_part( 'content', get_post_format() );

					?>



				<?php endwhile; ?>



				<?php zerif_paging_nav(); ?>



			<?php else : ?>



				<?php get_template_part( 'content', 'none' ); ?>



			<?php endif; ?>



			</main><!-- #main -->

		</div><!-- #primary -->



	</div><!-- .content-left-wrap -->



	<div class="sidebar-wrap col-md-3 content-left-wrap">

		<?php get_sidebar(); ?>

	</div><!-- .sidebar-wrap -->



	</div><!-- .container -->
	<?php
}else {

	if(isset($_POST['submitted'])) :


			/* recaptcha */
			
			$zerif_contactus_sitekey = get_theme_mod('zerif_contactus_sitekey');

			$zerif_contactus_secretkey = get_theme_mod('zerif_contactus_secretkey');
			
			$zerif_contactus_recaptcha_show = get_theme_mod('zerif_contactus_recaptcha_show');

			if( isset($zerif_contactus_recaptcha_show) && $zerif_contactus_recaptcha_show != 1 && !empty($zerif_contactus_sitekey) && !empty($zerif_contactus_secretkey) ) :

		        $captcha;

		        if( isset($_POST['g-recaptcha-response']) ){

		          $captcha=$_POST['g-recaptcha-response'];

		        }

		        if( !$captcha ){

		          $hasError = true;    
		          
		        }

		        $response = wp_remote_get( "https://www.google.com/recaptcha/api/siteverify?secret=".$zerif_contactus_secretkey."&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR'] );

		        if($response['body'].success==false) {

		        	$hasError = true;

		        }

	        endif;



			/* name */


			if(trim($_POST['myname']) === ''):


				$nameError = __('* Please enter your name.','zerif-lite');


				$hasError = true;


			else:


				$name = trim($_POST['myname']);


			endif;


			/* email */


			if(trim($_POST['myemail']) === ''):


				$emailError = __('* Please enter your email address.','zerif-lite');


				$hasError = true;


			elseif (!preg_match("/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", trim($_POST['myemail']))) :


				$emailError = __('* You entered an invalid email address.','zerif-lite');


				$hasError = true;


			else:


				$email = trim($_POST['myemail']);


			endif;


			/* subject */


			if(trim($_POST['mysubject']) === ''):


				$subjectError = __('* Please enter a subject.','zerif-lite');


				$hasError = true;


			else:


				$subject = trim($_POST['mysubject']);


			endif;


			/* message */


			if(trim($_POST['mymessage']) === ''):


				$messageError = __('* Please enter a message.','zerif-lite');


				$hasError = true;


			else:


				$message = stripslashes(trim($_POST['mymessage']));


			endif;





			/* send the email */

			if(!isset($hasError)):


				$zerif_contactus_email = get_theme_mod('zerif_contactus_email');
				
				if( empty($zerif_contactus_email) ):
				
					$emailTo = get_theme_mod('zerif_email');
				
				else:
					
					$emailTo = $zerif_contactus_email;
				
				endif;


				if(isset($emailTo) && $emailTo != ""):

					if( empty($subject) ):
						$subject = 'From '.$name;
					endif;

					$body = "Name: $name \n\nEmail: $email \n\n Subject: $subject \n\n Message: $message";


					$headers = 'From: '.$name.' <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;


					wp_mail($emailTo, $subject, $body, $headers);


					$emailSent = true;


				else:


					$emailSent = false;


				endif;


			endif;


		endif;



	$zerif_bigtitle_show = get_theme_mod('zerif_bigtitle_show');

	if( isset($zerif_bigtitle_show) && $zerif_bigtitle_show != 1 ):

		include get_template_directory() . "/sections/big_title.php";
	endif;


?>


</header> <!-- / END HOME SECTION  -->


<div id="content" class="site-content">



<?php

	/* OUR FOCUS SECTION */

	$zerif_ourfocus_show = get_theme_mod('zerif_ourfocus_show');

	if( isset($zerif_ourfocus_show) && $zerif_ourfocus_show != 1 ):
		include get_template_directory() . "/sections/our_focus.php";
	endif;


	/* RIBBON WITH BOTTOM BUTTON */


	include get_template_directory() . "/sections/ribbon_with_bottom_button.php";







	/* ABOUT US */

	$zerif_aboutus_show = get_theme_mod('zerif_aboutus_show');

	if( isset($zerif_aboutus_show) && $zerif_aboutus_show != 1 ):

		include get_template_directory() . "/sections/about_us.php";
	endif;


	/* OUR TEAM */

	$zerif_ourteam_show = get_theme_mod('zerif_ourteam_show');

	if( isset($zerif_ourteam_show) && $zerif_ourteam_show != 1 ):

		include get_template_directory() . "/sections/our_team.php";
	endif;


	/* TESTIMONIALS */

	$zerif_testimonials_show = get_theme_mod('zerif_testimonials_show');

	if( isset($zerif_testimonials_show) && $zerif_testimonials_show != 1 ):

		include get_template_directory() . "/sections/testimonials.php";
	endif;




	/* RIBBON WITH RIGHT SIDE BUTTON */


	include get_template_directory() . "/sections/ribbon_with_right_button.php";



	/* LATEST NEWS */
	$zerif_latestnews_show = get_theme_mod('zerif_latestnews_show');

	if( isset($zerif_latestnews_show) && $zerif_latestnews_show != 1 ):

		include get_template_directory() . "/sections/latest_news.php";

	endif;



	/* CONTACT US */
	$zerif_contactus_show = get_theme_mod('zerif_contactus_show');

	if( isset($zerif_contactus_show) && $zerif_contactus_show != 1 ):
		?>
		<section class="contact-us" id="contact">
			<div class="container">
				<!-- SECTION HEADER -->
				<div class="section-header">
					
					<?php
					
						$zerif_contactus_title = get_theme_mod('zerif_contactus_title','Get in touch');
						if ( !empty($zerif_contactus_title) ):
							echo '<h2 class="white-text">'.$zerif_contactus_title.'</h2>';
						endif;
					
						$zerif_contactus_subtitle = get_theme_mod('zerif_contactus_subtitle');
						if(isset($zerif_contactus_subtitle) && $zerif_contactus_subtitle != ""):
							echo '<h6 class="white-text">'.$zerif_contactus_subtitle.'</h6>';
						endif;
					?>
				</div>
				<!-- / END SECTION HEADER -->

				<!-- CONTACT FORM-->
				<div class="row">
					<?php 
						echo do_shortcode('[contact-form-7 id="780" title="Main contact form" html_class="contact-form"]');
					?>					
				</div>

				<!-- / END CONTACT FORM-->

			</div> <!-- / END CONTAINER -->

		</section> <!-- / END CONTACT US SECTION-->
		<?php
	endif;

}
get_footer(); ?>