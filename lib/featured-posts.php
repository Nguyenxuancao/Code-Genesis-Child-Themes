<?php
/**
 * Featured Posts List.
 *
 * This file adds Featured Posts List to the Code Genesis Child Theme.
 *
 * @package Code Genesis Child
 * @author  LongViet
 * @license GPL-2.0-or-later
 * @link    https://longvietweb.com/
 */
 
// Admin Setting
add_action('admin_menu', 'posts_add_pages');
function posts_add_pages() {
	// Add new menu in Setting:
	add_submenu_page('edit.php','Featured Posts List', 'Featured Posts List', 8, 'postsoptions', 'posts_options_page');
}

// Main function to diplay on front end
add_action( 'genesis_before_content', 'featuredpostsList' );
function featuredpostsList() {
	global $post, $wpdb, $posts_settings;
	if( is_home()){
		// posts_id from database
		$posts_id = $posts_settings['posts_id'];
		?><div class="featured-posts-container"><?php
			if($posts_id): $i = 0;
			 
				$posts_idarray = explode(',',$posts_id);
				 
				foreach ($posts_idarray as $list){
				$post = new WP_Query('p='.$list.'');
				$post->the_post();
				$categories = get_the_category();
				?>	<div class="featured-posts list-<?php echo $i; ?>" style="background-image:url('<?php echo wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>')">
						<div class="featured-posts-content">
						<div class="featured-posts-cat"><a href="<?php echo get_category_link( $categories[0]->term_id ); ?>"><?php echo esc_html( $categories[0]->name );?></a></div>
						<h2><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
						<div class="featured-posts-time"><?php the_time('M j, Y') ?></div>
						</div>
					</div><?php $i ++; ?>
				<?php } else : ?>
					<p><?php _e( 'Sorry, no Featured Post List to display. Please set in the Setting', 'genesis-child' );?></p>
			<?php endif; 
		?></div><?php
	}
}
$posts_settings = get_option('posts_settings');
	$data = array(
	'posts_id' => ''
	);
	$ol_flash = '';

/* Functions */
function posts_options_page() {
	global $ol_flash, $posts_settings, $_POST, $wp_rewrite;
	if (isset($_POST['posts_id'])) {
		$posts_settings['posts_id'] = $_POST['posts_id'];
		update_option('posts_settings',$posts_settings);
		$ol_flash = __('Your Featured List has been saved.', 'genesis-child');
	}
	if ($ol_flash != '') echo '<div id="message"class="updated fade"><p>' . $ol_flash . '</p></div>';
	?> 
	<div class="wrap">
		<h2><?php _e('Add Posts ID to Create Featured Post List','genesis-child') ?></h2>
		<form action="" method="post">
			<table class="optiontable form-table">
				<tr><h3><?php _e('Display Featured Post List to your site.','genesis-child') ?></h3></tr>
				<tr>
					<th><?php _e('Post ID :','genesis-child') ?></th>
						<td>
							<input type="text" name="posts_id" placeholder="1, 2, 3" value="<?php echo htmlentities($posts_settings['posts_id']); ?>" size="50%" /></th><br />
							<label for="disabled"><?php _e('To Add Multiple Post IDs use " , " for exmple : " 1, 2, 3"','genesis-child') ?></label>
						</td>
				</tr>
			</table>
			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e('Save Featured Post List','genesis-child') ?>" />
			</p>
		</form>
	</div>
	<?php
}/* 
 1, 736, 725, 691 */