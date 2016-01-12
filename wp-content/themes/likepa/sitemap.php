<?php
/**
 * Template Name: Sitemap
 * Description: Displays an HTML-based sitemap for your site.
 *
 * @since likepa 1.0
 */

get_header(); ?>
<?php get_sidebar(); ?>

		<section id="primary">
			<div id="content" role="main">
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="entry-header">
						<h1 class="entry-title"><?php the_title(); ?></h1>
					</header><!-- .entry-header -->
					<div class="likepa-sitemap-heading">
						<h3>Pages</h3>
					</div>
					<div class="likepa-sitemap-body">
						<ul><?php wp_list_pages("title_li=" ); ?></ul>
					</div>
					<div class="likepa-sitemap-heading">
						<h3>Feeds</h3>
					</div>
					<div class="likepa-sitemap-body">
						<ul>
							<li><a title="Full content" href="feed:<?php bloginfo('rss2_url'); ?>">Main RSS</a></li>
							<li><a title="Comment Feed" href="feed:<?php bloginfo('comments_rss2_url'); ?>">Comment Feed</a></li>
						</ul>
					</div>
					<div class="likepa-sitemap-heading">
						<h3>Categories</h3>
					</div>
					<div class="likepa-sitemap-body">
						<ul><?php wp_list_categories('sort_column=name&optioncount=1&hierarchical=0'); ?></ul>
					</div>
					<div class="likepa-sitemap-heading">
						<h3>Blog Posts:</h3>
					</div>
					<div class="likepa-sitemap-body">
						<ul><?php $archive_query = new WP_Query('showposts=1000&cat=-8');
							while ($archive_query->have_posts()) : $archive_query->the_post(); ?>
								<li>
									<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a>
									(<?php comments_number('0', '1', '%'); ?>)
								</li>
							<?php endwhile; ?>
						</ul>
					</div>
					<div class="likepa-sitemap-heading">
						<h3>Archives</h3>
					</div>
					<div class="likepa-sitemap-body">
						<ul>
							<?php wp_get_archives('type=monthly&show_post_count=true'); ?>
						</ul>
					</div>
					<footer class="entry-meta">
						<?php edit_post_link( __( 'Edit', 'likepa' ), '<span class="edit-link">', '</span>' ); ?>
					</footer><!-- .entry-meta -->	
				</article><!-- #post-<?php the_ID(); ?> -->
			</div><!-- #content -->
		</section><!-- #primary -->

<?php get_sidebar('1'); ?>
<?php get_footer(); ?>