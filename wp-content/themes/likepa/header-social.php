
<?php

// Social

global $options;
$options = get_option('likepa_theme_options');
?>
	<div class="likepa-social">

		<ul class="likepa-social">

			<?php // Pinterest
			if ( isset ($options['likepa_pinterest_id']) &&  ($options['likepa_pinterest_id']!="") ) {
				$output = '<li><a target="_blank" href="http://pinterest.com/'."";
				$output .= $options['likepa_pinterest_id'] ."";
				$output .= '" id="likepa-pinterest" title="Pinterest"></a></li>'."";
				echo stripslashes($output);
			} // Youtube
			if ( isset ($options['likepa_youtube_id']) &&  ($options['likepa_youtube_id']!="") ) {
				$output = '<li><a target="_blank" href="http://youtube.com/user/'."";
				$output .= $options['likepa_youtube_id'] ."";
				$output .= '" id="likepa-youtube" title="Youtube"></a></li>'."";
				echo stripslashes($output);
			} // Vimeo
			if ( isset ($options['likepa_vimeo_id']) &&  ($options['likepa_vimeo_id']!="") ) {
				$output = '<li><a target="_blank" href="http://vimeo.com/'."";
				$output .= $options['likepa_vimeo_id'] ."";
				$output .= '" id="likepa-buzz" title="Vimeo"></a></li>'."";
				echo stripslashes($output);
			} // Google Plus
			if ( isset ($options['likepa_google_plus_id']) &&  ($options['likepa_google_plus_id']!="") ) {
				$output = '<li><a target="_blank" href="http://plus.google.com/'."";
				$output .= $options['likepa_google_plus_id'] ."";
				$output .= '" id="likepa-plus" title="Google Plus"></a></li>'."";
				echo stripslashes($output);
			} // Twitter
			if ( isset ($options['likepa_twitter_id']) &&  ($options['likepa_twitter_id']!="") ) {
				$output = '<li><a target="_blank" href="http://twitter.com/'."";
				$output .= $options['likepa_twitter_id'] ."";
				$output .= '" id="likepa-twitter" title="Twitter"></a></li>'."";
				echo stripslashes($output);
			} // Facebook
			if ( isset ($options['likepa_facebook_id']) &&  ($options['likepa_facebook_id']!="") ) {
				$output = '<li><a target="_blank" href="http://facebook.com/'."";
				$output .= $options['likepa_facebook_id'] ."";
				$output .= '" id="likepa-facebook" title="Facebook"></a></li>'."";
				echo stripslashes($output);
			} // Rss
			if ( isset ($options['likepa_rss_feed']) &&  ($options['likepa_rss_feed']!="") ) {
				echo ('<li><a target="_blank" href="');
				echo ( bloginfo( 'rss_url'));
				echo ('" id="likepa-rss" title="RSS"></a></li>');	
			}
			?>
		</ul>
	</div><!-- .likepa-social -->