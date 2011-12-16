<?php
/**
* print html meta
*/
function wp_idea_stream_posted_on() {
	$get_idea_guest_name = get_post_meta(get_the_ID(), 'ideastream_guest_name', true);
	if(!empty($get_idea_guest_name)) {
		printf( __( '<span class="%1$s">Posted on</span> %2$s <span class="meta-sep">by</span> %3$s', 'wp-idea-stream' ),
			'meta-prep meta-prep-author',
			sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>',
				get_permalink(),
				esc_attr( get_the_time() ),
				get_the_date()
			),
			sprintf( '<span class="author vcard">%1$s</a></span>',
				$get_idea_guest_name
			)
		);
	}
	else {
		printf( __( '<span class="%1$s">Posted on</span> %2$s <span class="meta-sep">by</span> %3$s', 'wp-idea-stream' ),
			'meta-prep meta-prep-author',
			sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>',
				get_permalink(),
				esc_attr( get_the_time() ),
				get_the_date()
			),
			sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
				get_author_idea_url( get_the_idea_author_meta( 'ID' ) ),
				sprintf( esc_attr__( 'View all ideas by %s', 'wp-idea-stream' ), get_idea_author() ),
				get_idea_author()
			)
		);
	}
}

function wp_idea_stream_desc_edit(){
	?>
	<form action="" method="post">
	<textarea id="ideastream_desc_content" name="_ideastream_desc_content" style="width:98%"><?php if ( get_displayed_idea_author_meta( 'description' ) ) : displayed_idea_author_meta( 'description' ); endif; ?></textarea>
	<?php wp_nonce_field('wp-ideastream-desc-check-referrer','wp-ideastream-desc-check');?>
	<input type="submit" name="_ideastream_desc_save" value="<?php _e('Save this description','wp-idea-stream');?>"/>
	</form>
	<?php
}

function wp_idea_stream_new_form(){
	return get_bloginfo('siteurl').'/feedback/new-idea/';
}

function wp_idea_stream_posted_in_cat(){
	echo get_the_term_list( get_the_ID(), 'category-ideas');
}

function wp_idea_stream_posted_in_tag(){
	return get_the_term_list( get_the_ID(), 'tag-ideas', __('with ', 'wp-idea-stream'), ', ',' ');
}

/* idea author tags */

function get_author_idea_url($id){
	$user_info = get_userdata($id);
	$link = get_bloginfo('siteurl').'/feedback/idea-author/'.$user_info->user_login.'/';
	return $link;
}

function get_the_idea_author_meta( $field ){
	global $authordata;
	return $authordata->$field;
}

function get_idea_author(){
	global $authordata;
	return $authordata->display_name;
}

function the_idea_author_meta( $field ){
	echo get_the_idea_author_meta( $field );
}

function wp_idea_stream_get_the_author($user_slug){
	$user = get_userdatabylogin($user_slug);
	return $user->ID;
}

function wp_idea_stream_loggedin_user_displayed($noidea = false){
	global $current_user, $user_slug;
	if(!$noidea){
		if($current_user->user_login==get_the_idea_author_meta('user_login')) return true;
		else return false;
	}
	else{
		if($current_user->user_login == $user_slug) return true;
		else return false;
	}
}

function get_displayed_idea_author_meta($field){
	global $user_slug;
	$user = get_userdatabylogin($user_slug);
	return $user->$field;
}
function displayed_idea_author_meta($field){
	echo get_displayed_idea_author_meta($field);
}
function get_displayed_idea_author(){
	global $user_slug;
	$user = get_userdatabylogin($user_slug);
	return $user->display_name;
}

function wp_idea_stream_paginate_link($paged = false){
	global $idea_meta;
	$pagid = 1;
	if(isset($_GET['pagid']) && !$paged){
		$pagid = intval($_GET['pagid']);
	}
	elseif(get_query_var('paged')){
		$pagid = get_query_var('paged');
	}
	$offset = $idea_meta['per_page'] * ($pagid - 1);
	
	$max_pages = ceil($idea_meta['all_count'] / $idea_meta['per_page']);
	
	if($max_pages > 1){
		if(!$paged){
			$page_links = paginate_links( array(
		        'base' => add_query_arg( 'pagid', '%#%' ),
		        'format' => '',
		        'prev_text' => __('&laquo;'),
		        'next_text' => __('&raquo;'),
		        'total' => $max_pages,
		        'current' => $pagid
		     ));
		}
		else{
			$page_links = paginate_links( array(
		        'base' => add_query_arg( 'paged', '%#%' ),
		        'format' => '',
		        'prev_text' => __('&laquo;'),
		        'next_text' => __('&raquo;'),
		        'total' => $max_pages,
		        'current' => $pagid
		     ));
		}
			
		
 		if ( $page_links ) { ?>
			<div class="nav-previous"><?php $page_links_text = sprintf( __( 'Page : ' ) . '%s',
			$page_links
		); echo $page_links_text."</div>";

		}
	}
}
function wp_idea_stream_number_ideas(){
	global $idea_meta;
	return $idea_meta['all_count'];
}

function wp_idea_stream_allowed_html_tags(){
	$allowedideatags = array(
		'a' => array(
			'class' => array (),
			'href' => array (),
			'id' => array (),
			'title' => array (),
			'rel' => array (),
			'rev' => array (),
			'name' => array (),
			'target' => array()),
		'b' => array(),
		'big' => array(),
		'blockquote' => array(
			'id' => array (),
			'cite' => array (),
			'class' => array(),
			'lang' => array(),
			'xml:lang' => array()),
		'br' => array (
			'class' => array ()),
		'del' => array(
			'datetime' => array ()),
		'em' => array(),
		'font' => array(
			'color' => array (),
			'face' => array (),
			'size' => array ()),
		'h1' => array(
			'align' => array (),
			'class' => array (),
			'id'    => array (),
			'style' => array ()),
		'h2' => array (
			'align' => array (),
			'class' => array (),
			'id'    => array (),
			'style' => array ()),
		'h3' => array (
			'align' => array (),
			'class' => array (),
			'id'    => array (),
			'style' => array ()),
		'h4' => array (
			'align' => array (),
			'class' => array (),
			'id'    => array (),
			'style' => array ()),
		'h5' => array (
			'align' => array (),
			'class' => array (),
			'id'    => array (),
			'style' => array ()),
		'h6' => array (
			'align' => array (),
			'class' => array (),
			'id'    => array (),
			'style' => array ()),
		'hr' => array (
			'align' => array (),
			'class' => array (),
			'noshade' => array (),
			'size' => array (),
			'width' => array ()),
		'i' => array(),
		'img' => array(
			'alt' => array (),
			'align' => array (),
			'border' => array (),
			'class' => array (),
			'height' => array (),
			'hspace' => array (),
			'longdesc' => array (),
			'vspace' => array (),
			'src' => array (),
			'style' => array (),
			'width' => array ()),
		'li' => array (
			'align' => array (),
			'class' => array ()),
		'p' => array(
			'class' => array (),
			'align' => array (),
			'dir' => array(),
			'lang' => array(),
			'style' => array (),
			'xml:lang' => array()),
		'span' => array (
			'class' => array (),
			'dir' => array (),
			'align' => array (),
			'lang' => array (),
			'style' => array (),
			'title' => array (),
			'xml:lang' => array()),
		'strike' => array(),
		'strong' => array(),
		'table' => array(
			'align' => array (),
			'bgcolor' => array (),
			'border' => array (),
			'cellpadding' => array (),
			'cellspacing' => array (),
			'class' => array (),
			'dir' => array(),
			'id' => array(),
			'rules' => array (),
			'style' => array (),
			'summary' => array (),
			'width' => array ()),
		'tbody' => array(
			'align' => array (),
			'char' => array (),
			'charoff' => array (),
			'valign' => array ()),
		'td' => array(
			'abbr' => array (),
			'align' => array (),
			'axis' => array (),
			'bgcolor' => array (),
			'char' => array (),
			'charoff' => array (),
			'class' => array (),
			'colspan' => array (),
			'dir' => array(),
			'headers' => array (),
			'height' => array (),
			'nowrap' => array (),
			'rowspan' => array (),
			'scope' => array (),
			'style' => array (),
			'valign' => array (),
			'width' => array ()),
		'tfoot' => array(
			'align' => array (),
			'char' => array (),
			'class' => array (),
			'charoff' => array (),
			'valign' => array ()),
		'th' => array(
			'abbr' => array (),
			'align' => array (),
			'axis' => array (),
			'bgcolor' => array (),
			'char' => array (),
			'charoff' => array (),
			'class' => array (),
			'colspan' => array (),
			'headers' => array (),
			'height' => array (),
			'nowrap' => array (),
			'rowspan' => array (),
			'scope' => array (),
			'valign' => array (),
			'width' => array ()),
		'thead' => array(
			'align' => array (),
			'char' => array (),
			'charoff' => array (),
			'class' => array (),
			'valign' => array ()),
		'tr' => array(
			'align' => array (),
			'bgcolor' => array (),
			'char' => array (),
			'charoff' => array (),
			'class' => array (),
			'style' => array (),
			'valign' => array ()),
		'u' => array(),
		'ul' => array (
			'class' => array (),
			'style' => array (),
			'type' => array ()),
		'ol' => array (
			'class' => array (),
			'start' => array (),
			'style' => array (),
			'type' => array ())
			);
	return $allowedideatags;
}

function is_user_allowed_to_feature_ideas(){
	global $current_user;
	$ideastream_allowed_featuring_members = get_option('_ideastream_allowed_featuring_members');
	if(current_user_can('manage_options')) return true;
	elseif($ideastream_allowed_featuring_members!="" && count($ideastream_allowed_featuring_members)>0 && in_array($current_user->ID, $ideastream_allowed_featuring_members)) return true;
	else return false;
}

function is_new_idea(){
	if(ereg('feedback/new-idea', $_SERVER['REQUEST_URI'])){
		return true;
	}
	else return false;
}

function is_all_ideas(){
	if(ereg('feedback/all-ideas', $_SERVER['REQUEST_URI'])){
		return true;
	}
	else return false;
}

function is_featured_ideas(){
	if(ereg('feedback/featured-ideas', $_SERVER['REQUEST_URI'])){
		return true;
	}
	else return false;
}

function is_idea_author(){
	if(ereg('feedback/idea-author', $_SERVER['REQUEST_URI'])){
		return true;
	}
	else return false;
}

function is_best_ideas(){
	if(ereg('feedback/best-ideas', $_SERVER['REQUEST_URI'])){
		return true;
	}
	else return false;
}

function get_vote_it_up_button() {
	$ideastream_allow_guests = get_option('_ideastream_allow_guests');
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	if(is_plugin_active('vote-it-up/voteitup.php')) {
		if(($ideastream_allow_guests == 0 && is_user_logged_in()) || $ideastream_allow_guests == 1) {
			return DisplayVotes(get_the_ID());
		}
		else return false;
	}
	else return false;
}

function detect_author_idea() {
	$get_idea_guest_name = get_post_meta(get_the_ID(), 'ideastream_guest_name', true);
	if(!empty($get_idea_guest_name)) {
		return $get_idea_guest_name;
	}
	else {
		return get_idea_author();
	}
}

?>