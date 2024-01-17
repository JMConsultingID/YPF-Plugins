<?php
add_action( 'init', function() {
	register_post_type( 'tooltips-table', array(
	'labels' => array(
		'name' => 'YPF Tooltips',
		'singular_name' => 'YPF Tooltips',
		'menu_name' => 'YPF Tooltips',
		'all_items' => 'All YPF Tooltips',
		'edit_item' => 'Edit YPF Tooltips',
		'view_item' => 'View YPF Tooltips',
		'view_items' => 'View YPF Tooltips',
		'add_new_item' => 'Add New YPF Tooltips',
		'add_new' => 'Add New YPF Tooltips',
		'new_item' => 'New YPF Tooltips',
		'parent_item_colon' => 'Parent YPF Tooltips:',
		'search_items' => 'Search YPF Tooltips',
		'not_found' => 'No YPF Tooltips found',
		'not_found_in_trash' => 'No YPF Tooltips found in Trash',
		'archives' => 'YPF Tooltips Archives',
		'attributes' => 'YPF Tooltips Attributes',
		'insert_into_item' => 'Insert into YPF tooltips',
		'uploaded_to_this_item' => 'Uploaded to this YPF tooltips',
		'filter_items_list' => 'Filter YPF tooltips list',
		'filter_by_date' => 'Filter YPF tooltips by date',
		'items_list_navigation' => 'YPF Tooltips list navigation',
		'items_list' => 'YPF Tooltips list',
		'item_published' => 'YPF Tooltips published.',
		'item_published_privately' => 'YPF Tooltips published privately.',
		'item_reverted_to_draft' => 'YPF Tooltips reverted to draft.',
		'item_scheduled' => 'YPF Tooltips scheduled.',
		'item_updated' => 'YPF Tooltips updated.',
		'item_link' => 'YPF Tooltips Link',
		'item_link_description' => 'A link to a YPF tooltips.',
	),
	'public' => true,
	'publicly_queryable' => false,
	'show_in_rest' => true,
	'menu_position' => 99,
	'menu_icon' => 'dashicons-marker',
	'supports' => array(
		0 => 'title',
	),
	'rewrite' => array(
		'with_front' => false,
	),
	'delete_with_user' => false,
) );
} );
?>