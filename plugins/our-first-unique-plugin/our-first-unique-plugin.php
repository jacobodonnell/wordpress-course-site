<?php

/*
  Plugin Name: Our Test Plugin
  Description: A truly amazing plugin.
  Version: 1.0
  Author: Jacob
  Author URI: https://jacobodonnell.me
  Text Domain: wcpdomain
  Domain Path: /languages
*/

class WordCountAndTimePlugin {
  function __construct() {
    add_action('admin_menu', [$this, 'adminPage']);
    add_action('admin_init', [$this, 'settings']);
    add_filter('the_content', [$this, 'ifWrap']);
    add_action('init', [$this, 'languages']);
  }

  function languages() {
    load_plugin_textdomain('wcpdomain', false, dirname(plugin_basename(__FILE__)) . '/languages');
  }

  function ifWrap($content) {
    if (
      is_main_query() && is_single() &&
      (
        get_option('wcp_wordcount', 1) ||
        get_option('wcp_charactercount', 1) ||
        get_option('wcp_readtime', 1)
      )
    ) {
      return $this->createHTML($content);
    }
    return $content;
  }

  function createHTML($content) {
    $html = '<h3>' . esc_html(get_option('wcp_headline', 'Post Statistics')) . '</h3><p>';

    // get word count once because both wordcount and read time will need it.
    if (get_option('wcp_wordcount', '1') || get_option('wcp_readtime', '1')) {
      $wordCount = str_word_count(strip_tags($content));
    }

    if (get_option('wcp_wordcount', '1')) {
      $html .= __('This post has', 'wcpdomain') . ' ' .  $wordCount . ' ' . __('words', 'wcpdomain') . '.<br>';
    }

    if (get_option('wcp_charactercount', '1')) {
      $html .= 'This post has ' . strlen(strip_tags($content)) . ' characters.<br>';
    }

    if (get_option('wcp_readtime', '1')) {
      $readTime = (int) ceil($wordCount / 225);
      $html .= 'This post will take about ' . $readTime . ' minute' . (($readTime === 1) ? '' : 's') .  ' to read.<br>';
    }

    $html .= '</p>';

    if (get_option('wcp_location', '0') == '0') {
      return $html . $content;
    } else {
      return $content . $html;
    }
  }

  function settings() {
    add_settings_section('wcp_first_section', null, null, 'word-count-settings-page');

    add_settings_field('wcp_location', 'Display Location', [$this, 'locationHTML'], 'word-count-settings-page', 'wcp_first_section');
    register_setting('wordcountplugin', 'wcp_location', [
      'sanitize_callback' => [$this, 'sanitizeLocation'],
      'default' => '0'
    ]);

    add_settings_field('wcp_headline', 'Headline Text', [$this, 'headlineHTML'], 'word-count-settings-page', 'wcp_first_section');
    register_setting('wordcountplugin', 'wcp_headline', [
      'sanitize_callback' => 'sanitize_text_field',
      'default' => 'Post Statistics'
    ]);

    add_settings_field('wcp_wordcount', 'Word Count', [$this, 'checkboxHTML'], 'word-count-settings-page', 'wcp_first_section', ['theName' => 'wcp_wordcount']);
    register_setting('wordcountplugin', 'wcp_wordcount', [
      'sanitize_callback' => 'sanitize_text_field',
      'default' => '1'
    ]);

    add_settings_field('wcp_charactercount', 'Character Count', [$this, 'checkboxHTML'], 'word-count-settings-page', 'wcp_first_section', ['theName' => 'wcp_charactercount']);
    register_setting('wordcountplugin', 'wcp_charactercount', [
      'sanitize_callback' => 'sanitize_text_field',
      'default' => '1'
    ]);

    add_settings_field('wcp_readtime', 'Read time', [$this, 'checkboxHTML'], 'word-count-settings-page', 'wcp_first_section', ['theName' => 'wcp_readtime']);
    register_setting('wordcountplugin', 'wcp_readtime', [
      'sanitize_callback' => 'sanitize_text_field',
      'default' => '1'
    ]);
  }

  function sanitizeLocation($input) {
    if ($input != '0' && $input != '1') {
      add_settings_error('wcp_location', 'wcp_location_error', 'Display location must be either beginning or end');
      return get_option('wcp_location');
    }
    return $input;
  }

  function locationHTML() { ?>
    <select name="wcp_location">
      <option value="0" <?php selected(get_option('wcp_location', 0)) ?>>Beginning of post</option>
      <option value="1" <?php selected(get_option('wcp_location', 1)) ?>>End of post</option>
    </select>
  <?php
  }

  function headlineHTML() { ?>
    <input type="text" name="wcp_headline" value="<?php echo esc_attr(get_option('wcp_headline')) ?>">
  <?php
  }

  /*
  function wordCountHTML() { ?>
    <input type="checkbox" name="wcp_wordcount" value="1" <?php checked(get_option('wcp_wordcount'), 1) ?>>
  <?php
  }

  function characterCountHTML() { ?>
    <input type="checkbox" name="wcp_charactercount" value="1" <?php checked(get_option('wcp_charactercount'), 1) ?>>
  <?php
  }

  function readTimeHTML() { ?>
    <input type="checkbox" name="wcp_readtime" value="1" <?php checked(get_option('wcp_readtime'), 1) ?>>
  <?php
  }
  */

  function checkboxHTML($args) { ?>
    <input type="checkbox" name="<?php echo $args['theName'] ?>" value="1" <?php checked(get_option($args['theName']), 1) ?>>
  <?php }


  function adminPage() {
    add_options_page('Word Count Settings', __('Word Count', 'wcpdomain'), 'manage_options', 'word-count-settings-page', [$this, 'ourHTML']);
  }

  function ourHTML() { ?>
    <div class="wrap">
      <h1>Word Count Settings</h1>
      <form action="options.php" method="POST">
        <?php
        settings_fields('wordcountplugin');
        do_settings_sections('word-count-settings-page');
        submit_button();
        ?>
      </form>
    </div>
<?php
  }
}

$wordCountAndTimePlugin = new WordCountAndTimePlugin();
