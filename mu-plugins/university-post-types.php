<?php

function university_post_types() {
  // Campus Post Type
  register_post_type('campus', [
    'capability_type' => 'campus',
    'map_meta_cap' => true,
    'supports' => ['title', 'editor', 'excerpt'],
    'rewrite' => ['slug' => 'campuses'],
    'has_archive' => true,
    'public' => true,
    'show_in_rest' => true,
    'labels' => [
      'name' => 'Campuses',
      'add_new_item' => 'Add New Campus',
      'edit_item' => 'Edit Campus',
      'all_items' => 'All Campuses',
      'singular_name' => 'Campus',
      'add_new' => 'Add New Campus'
    ],
    'menu_icon' => 'dashicons-location-alt'
  ]);

  // Event Post Type
  register_post_type('event', [
    'capability_type' => 'event',
    'map_meta_cap' => true,
    'supports' => ['title', 'editor', 'excerpt'],
    'rewrite' => ['slug' => 'events'],
    'has_archive' => true,
    'public' => true,
    'show_in_rest' => true,
    'labels' => [
      'name' => 'Events',
      'add_new_item' => 'Add New Event',
      'edit_item' => 'Edit Event',
      'all_items' => 'All Events',
      'singular_name' => 'Event',
      'add_new' => 'Add New Event'
    ],
    'menu_icon' => 'dashicons-calendar'
  ]);


  // Program Post Type
  register_post_type('program', [
    'supports' => ['title'],
    'rewrite' => ['slug' => 'programs'],
    'has_archive' => true,
    'public' => true,
    'show_in_rest' => true,
    'labels' => [
      'name' => 'Programs',
      'add_new_item' => 'Add New Program',
      'edit_item' => 'Edit Program',
      'all_items' => 'All Programs',
      'singular_name' => 'Program',
      'add_new' => 'Add New Program'
    ],
    'menu_icon' => 'dashicons-awards'
  ]);

  // Professor Post Type
  register_post_type('professor', [
    'supports' => ['title', 'editor', 'thumbnail'],
    'public' => true,
    'show_in_rest' => true,
    'labels' => [
      'name' => 'Professors',
      'add_new_item' => 'Add New Professor',
      'edit_item' => 'Edit Professor',
      'all_items' => 'All Professors',
      'singular_name' => 'Professor',
      'add_new' => 'Add New Professor'
    ],
    'menu_icon' => 'dashicons-welcome-learn-more'
  ]);

  // Note Post Type
  register_post_type('note', [
    'capability_type' => 'note',
    'map_meta_cap' => true,
    'supports' => ['title', 'editor'],
    'public' => false,
    'show_ui' => true,
    'show_in_rest' => true,
    'labels' => [
      'name' => 'Notes',
      'add_new_item' => 'Add New Note',
      'edit_item' => 'Edit Note',
      'all_items' => 'All Notes',
      'singular_name' => 'Note',
      'add_new' => 'Add New Note'
    ],
    'menu_icon' => 'dashicons-welcome-write-blog'
  ]);

  // Like Post Type
  register_post_type('like', [
    'supports' => ['title',],
    'public' => false,
    'show_ui' => true,
    'labels' => [
      'name' => 'Likes',
      'add_new_item' => 'Add New Like',
      'edit_item' => 'Edit Like',
      'all_items' => 'All Likes',
      'singular_name' => 'Like',
      'add_new' => 'Add New Like'
    ],
    'menu_icon' => 'dashicons-heart'
  ]);
}

add_action('init', 'university_post_types');
