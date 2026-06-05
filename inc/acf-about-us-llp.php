<?php
/**
 * About Us page — child overrides for parent ACF fields.
 *
 * @package Live_Life_Prizes
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Tagline: WYSIWYG so editors can add links; Shift+Enter for line breaks within the block.
 */
add_filter('acf/load_field/key=field_about_hero_tagline', function ($field) {
    $field['type']         = 'wysiwyg';
    $field['tabs']         = 'all';
    $field['toolbar']      = 'basic';
    $field['media_upload'] = 0;
    $field['delay']        = 1;
    $field['instructions'] = __(
        'Use the link button to add links. For a new line within the tagline (same block), press Shift+Enter. Press Enter only if you want a separate paragraph (adds more vertical space).',
        'live-life-prizes',
    );

    return $field;
});
