<?php

/*
  Plugin Name: Are You Paying Attention Quiz
  Description: Give your readers a multiple choice question.
  Version 1.0
  Author: Jacob
*/

if (! defined('ABSPATH')) exit; // Exit if access direction

class AreYouPayingAttention {
  function __construct() {
    add_action('init', array($this, 'adminAssets'));
  }

  function adminAssets() {
    register_block_type(__DIR__, [
      'render_callback' => [$this, 'theHTML']
    ]);
  }

  function theHTML($attributes) {
    ob_start(); ?>
    <div class="paying-attention-update-me">
      <pre style="display: none"><?php echo wp_json_encode($attributes) ?></pre>
    </div>
<?php return ob_get_clean();
  }
}


$areYouPayingAttention = new AreYouPayingAttention();
