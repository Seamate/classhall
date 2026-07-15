# Classhall Light Pages

Lightweight shortcode pages and a basic Elementor data renderer for Classhall.

## Why this exists

Elementor is heavy for pages that only need headings, text, images, buttons, lists, FAQs, videos, shortcodes, and simple sections. This plugin renders those common layouts without loading Elementor's frontend CSS and JavaScript.

## How to use it

Upload and activate `classhall-light-pages`.

If Elementor is disabled, normal pages that still have `_elementor_data` saved in the database will be rendered by this plugin automatically.

While Elementor is still active, editors can preview the lightweight output by adding this to a page URL:

```text
?ch_light_pages=1
```

The preview only works for users who can edit that page.

## Supported Elementor widgets

- Heading
- Text Editor
- Image
- Button
- Icon List
- Accordion
- Toggle
- Shortcode
- Divider
- Spacer
- Video

Other Elementor widgets are ignored so the page stays fast and does not break.

## Shortcodes for new lightweight pages

```text
[ch_page]
[ch_hero title="Online learning for junior secondary students" text="Clear lessons, questions, and revision content." image="123" primary_text="View subjects" primary_url="/subjects/"]

[ch_section title="Popular subjects" intro="Start with any subject and continue at your own pace."]
[ch_subjects limit="6"]
[/ch_section]

[ch_section title="Plans" tone="soft"]
[ch_pricing]
[ch_price name="1 month" price="From ₦500.00" features="Access all first term, second term and third term content anytime|Get carefully curated and regularly updated e-notes, evaluation and examination questions" excluded="Copy or print content" button_text="Subscribe" button_url="/checkout/"]
[ch_price name="4 months" price="From ₦500.00" features="Access all first term, second term and third term content anytime|Get carefully curated and regularly updated e-notes, evaluation and examination questions" excluded="Copy or print content" button_text="Subscribe" button_url="/checkout/"]
[ch_price name="1 year" price="From ₦500.00" features="Access all first term, second term and third term content anytime|Get carefully curated and regularly updated e-notes, evaluation and examination questions|Copy or print content" button_text="Subscribe" button_url="/checkout/"]
[/ch_pricing]
[/ch_section]
[/ch_page]
```

## Practical migration path

1. Activate this plugin while Elementor is still active.
2. Preview key Elementor pages with `?ch_light_pages=1`.
3. If the page looks acceptable, test with Elementor disabled on staging.
4. Keep pages that use unsupported Elementor widgets on Elementor until they are rebuilt with shortcodes or normal WordPress blocks.
