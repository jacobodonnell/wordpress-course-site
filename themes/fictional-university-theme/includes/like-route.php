<?php

function createLike($data) {
  if (is_user_logged_in()) {
    $professor = sanitize_text_field($data['professorId']);

    $existQuery = new WP_Query([
      'author' => get_current_user_id(),
      'post_type' => 'like',
      'meta_query' => [
        [
          'key' => 'liked_professor_id',
          'compare' => '=',
          'value' => $professor
        ]
      ],
    ]);

    get_the_title($professor);


    if ($existQuery->found_posts == 0 && get_post_type($professor) === 'professor') {
      // create new like post
      return wp_insert_post([
        'post_type' => 'like',
        'post_status' => 'publish',
        'post_title' => wp_get_current_user()->display_name . ' liked ' . get_the_title($professor),
        'meta_input' => [
          'liked_professor_id' => $professor
        ]
      ]);
    } else {
      die("Invalid professor id");
    }
  } else {
    die("only logged in users can create a like.");
  }
}

function deleteLike($data) {
  $likeId = sanitize_text_field($data['like']);

  if (get_current_user_id() === intval(get_post_field('post_author', $likeId)) && get_post_type($likeId) === 'like') {
    wp_delete_post($likeId, true);
    return 'Congrats, like deleted';
  } else {
    die("You do not have permission to delete that. Current User Id: " . get_current_user_id() . " Post user id: " . get_post_field('post_author', $likeId) . "Post type: " . get_post_type($likeId));
  }
}

function universityLikeRoutes() {
  register_rest_route('university/v1', 'manageLike', [
    'methods' => 'POST',
    'callback' => 'createLike',
  ]);

  register_rest_route('university/v1', 'manageLike', [
    'methods' => 'DELETE',
    'callback' => 'deleteLike',
  ]);
};

add_action('rest_api_init', 'universityLikeRoutes');
