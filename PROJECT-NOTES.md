# GP Strategies Theme - Project Notes

## Tech Stack

- **Theme:** Custom WordPress theme (`gp-strategies`)
- **Page Builder:** Elementor / Elementor Pro
- **Additional:** Unlimited Elements Pro (possibly)
- **Legacy Content:** ACF / ACF Pro + Custom Gutenberg blocks

## Architecture Decisions

### Fonts
- **Primary Font:** Poppins (Google Fonts)
- **Loading Method:** Direct link in `header.php`
- Elementor has built-in Google Fonts - it will use Poppins when selected
- Legacy Gutenberg/ACF content uses the globally declared font

### Colors
- Full color palette defined in `theme.json`
- 10 color scales (Mint, Grey, Blue, Aqua, Berry, Purple, Green, Orange, Yellow)
- 11 shades each (50-950)
- 2 GP brand colors (GP Soft Mint, GP Deep Blue)
- CSS variables: `var(--wp--preset--color--{slug})`

### Custom Post Types
- All CPTs defined in `/inc/cpt.php`
- Migrated from old theme (`gpstrategies-2023`)
- CPTs: Solutions, Events, News, Podcasts, Webinars, Resources, Case Studies, Training Courses, Leadership (ACAB)
- Global taxonomies: Industry, Topic

## Content Strategy

### New Content (Elementor)
- All new pages/posts built with Elementor Pro
- Use theme.json color palette for consistency
- Elementor templates for CPT archives/singles as needed

### Legacy Content
- ACF-based blocks and templates remain unchanged
- Custom Gutenberg blocks preserved
- Minimal design changes to legacy content
- May need template files for CPT single/archive views

## File Structure

```
gp-strategies/
├── inc/
│   ├── cpt.php          # Custom Post Types & Taxonomies
│   ├── core.php         # Theme setup
│   ├── scripts.php      # Scripts & styles enqueue
│   ├── widgets.php      # Widget areas
│   └── ...
├── theme.json           # WP theme settings (colors, spacing, etc.)
├── header.php           # Includes Google Fonts
├── functions.php        # Main functions file
└── ...
```

## Reference Theme

- Old theme location: `/~references/gpstrategies-2023/`
- Used for CPT structure reference
- Contains legacy block templates in `/gp-blocks/`

## TODO / Future Considerations

- [ ] Consider moving Google Fonts to `wp_enqueue_style()` for better caching control
- [ ] Create Elementor templates for CPT archives
- [ ] Review legacy Gutenberg blocks for compatibility
- [ ] Set up Elementor Global Colors to match theme.json palette
- [ ] Consider local font hosting for GDPR compliance (if serving EU)

## Notes

- Theme uses `declare(strict_types=1)` per coding standards
- OOP approach for CPT registration (class-based)
- WordPress 6.7+ theme.json schema (version 3)