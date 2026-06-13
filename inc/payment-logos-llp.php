<?php
/**
 * Live Life Prizes — payment method logos for cart / checkout trust footer.
 *
 * @package Live_Life_Prizes
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Brand image markup (official assets in child theme).
 */
function llp_payment_logo_img(string $filename, string $name, string $slug): string
{
    $path = get_stylesheet_directory() . '/assets/images/payment/' . $filename;
    if (!is_readable($path)) {
        return '';
    }

    $url = get_stylesheet_directory_uri() . '/assets/images/payment/' . $filename;

    return sprintf(
        '<img src="%s" alt="%s" class="llp-payment-logo llp-payment-logo--%s" loading="lazy" decoding="async" />',
        esc_url($url),
        esc_attr($name),
        esc_attr($slug),
    );
}

/**
 * Official payment logos supplied for Live Life Prizes (full colour).
 *
 * @return array<int, array{name: string, slug: string, markup: string}>
 */
function llp_get_payment_logos(): array
{
    $definitions = [
        ['name' => 'Visa', 'slug' => 'visa', 'file' => 'visa.png'],
        ['name' => 'Mastercard', 'slug' => 'mastercard', 'file' => 'mastercard.webp'],
        ['name' => 'Apple Pay', 'slug' => 'apple-pay', 'file' => 'apple-pay.webp'],
        ['name' => 'Google Pay', 'slug' => 'google-pay', 'file' => 'google-pay.webp'],
        ['name' => 'PayPal', 'slug' => 'paypal', 'file' => 'paypal.png'],
    ];

    $out = [];
    foreach ($definitions as $logo) {
        $markup = llp_payment_logo_img($logo['file'], $logo['name'], $logo['slug']);
        if ($markup === '') {
            continue;
        }

        $out[] = [
            'name'   => $logo['name'],
            'slug'   => $logo['slug'],
            'markup' => $markup,
            // Legacy key used by trust-elements.
            'svg'    => $markup,
        ];
    }

    return $out;
}
