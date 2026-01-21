<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>> <?php wp_body_open(); ?>
    <div id="main-content" class="position-relative overflow-hidden">
        <header class="site-header position-relative">
            <div class="container-fluid">
                <div class="primary-bar">
                    <div class="row align-items-end align-items-lg-center">
                        <?php $logo = get_field("header_logo", "option"); ?>
                        <?php if ($logo): ?>
                        <div class="col-9 col-lg-4">
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="navbar-brand">
                                <img src="<?php echo esc_url($logo['url']); ?>" <?php if ($logo['alt']): ?>alt="<?php echo esc_attr($logo['alt']); ?>"<?php endif; ?> class="img-fluid w-100">
                            </a>
                        </div>
                        <?php endif; ?>
                        <div class="col-3 col-lg-6 offset-lg-2 text-end">
                            <button class="navbar-toggler d-lg-none" type="button" id="navbar-button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                <img src="<?php echo get_stylesheet_directory_uri( );?>/assets/images/burger-icon.svg" class="open-btn img-fluid" alt="Menu Open Icon">
                                <span class="menu-text fw-medium text-blue d-block text-center mt-2">Menu</span>
                            </button>
                            <?php
                                wp_nav_menu(array(
                                    'theme_location' => 'secondary',
                                    'container'      => 'ul',
                                    'menu_class'     => 'top-menu list-unstyled d-none d-lg-flex justify-content-end fw-medium mb-3 pb-3 flex-wrap',
                                    'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
                                    'menu_id'        => 'secondary-menu',
                                ));
                            ?>
                            <div class="d-none d-lg-flex gap-3 flex-wrap justify-content-end">
                                <?php $header_button = get_field("header_button", "option"); 
                                $button = $header_button['button'] ?? ''; 
                                $button_icon = $header_button['button_icon'] ?? ''; 
                                if($button): ?>
                                    <a href="<?php echo $button['url']; ?>" class="top-header-button" target="<?php echo $button['target']; ?>">
                                        <?php echo $button_icon; ?>
                                        <?php echo $button['title']; ?>
                                    </a>
                                <?php endif; ?>
                                <div class="search-button header-search-form">
                                    <?php echo do_shortcode('[searchwp_modal_search_form template="My Custom Template"]') ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <nav class="main-menu navbar navbar-expand-lg">
                            <div class="d-none d-lg-block">
                                <div class="collapse navbar-collapse">
                                    <?php if (function_exists('max_mega_menu_is_enabled') && max_mega_menu_is_enabled('primary')) : ?>
                                        <?php wp_nav_menu(array('theme_location' => 'primary')); ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="d-lg-none mobile-menu-navbar" id="navbarSupportedContent">
                                <div class="mobile-top-menu d-lg-none d-flex gap-3 flex-wrap position-relative">
                                    <?php $header_button = get_field("header_button", "option"); 
                                        $button = $header_button['button']; 
                                        $button_icon = $header_button['button_icon']; 
                                        if($button): ?>
                                            <a href="<?php echo $button['url']; ?>" class="top-header-button" target="<?php echo $button['target']; ?>">
                                                <?php echo $button_icon; ?>
                                                <?php echo $button['title']; ?>
                                            </a>
                                        <?php endif; ?>
                                    <div class="search-button header-search-form">
                                        <?php echo do_shortcode('[searchwp_modal_search_form template="My Custom Template"]') ?>
                                    </div>
                                    <button class="navbar-toggler close-button d-lg-none" type="button" id="navbar-button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                        <img src="<?php echo get_stylesheet_directory_uri( );?>/assets/images/close-icon.svg" class="close-btn img-fluid" alt="Menu Open Icon">
                                        <span class="menu-text fw-medium text-blue d-block text-center mt-2">Menu</span>
                                    </button>
                                </div>
                                <?php
                                    wp_nav_menu(array(
                                        'theme_location' => 'mobile_menu',
                                        'container'      => 'ul',
                                        'menu_class'     => 'navbar-nav list-unstyled mb-0 d-block',
                                        'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
                                        'menu_id'        => 'mobile-menu',
                                    ));
                                ?>
                                <?php
                                    wp_nav_menu(array(
                                        'theme_location' => 'secondary',
                                        'container'      => 'ul',
                                        'menu_class'     => 'top-menu list-unstyled d-lg-none justify-content-end fw-medium mt-4 flex-wrap',
                                        'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
                                        'menu_id'        => 'secondary-menu',
                                    ));
                                ?>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </header>
        <main>
        <!-- main is here  -->
        <!-- Help ToolBars -->
        <?php 
        $disable_this_floating_cta_sitewide = get_field('disable_this_floating_cta_sitewide', 'option'); 
        if (!$disable_this_floating_cta_sitewide): 
            $help_toolbars     = get_field('help_toolbars');
            $help_tool_post    = $help_toolbars['help_tool'] ?? null;
            $disable_help_tool = $help_toolbars['disable_help_tool'] ?? false;
            // If relationship returns array → take first post
            if (is_array($help_tool_post)) {
                $help_tool_post = $help_tool_post[0] ?? null;
            }
            // If nothing selected, fall back to "General Help" post by title
            if (!$help_tool_post) {
                $general_posts = get_posts([
                    'post_type'      => 'help_toolbar',
                    'title'          => 'General Help', // fetch post with this exact title
                    'posts_per_page' => 1,
                ]);
                if (!empty($general_posts)) {
                    $help_tool_post = $general_posts[0];
                }
            }
            // Stop if disabled or still nothing found
            if ($disable_help_tool || !$help_tool_post) {
                return;
            }
            // Fetch ACF fields
            $heading        = get_field('help_toolbar_heading', $help_tool_post->ID);
            $main_content   = get_field('help_toolbar_main', $help_tool_post->ID);
            $standard_links = get_field('help_toolbar_standard_links', $help_tool_post->ID);
            $icon_links     = get_field('help_toolbar_icon_links', $help_tool_post->ID);
        ?>
        <?php if($disable_help_tool == false):
        if ($heading || $main_content || (!empty($standard_links) && is_array($standard_links)) || (!empty($icon_links) && is_array($icon_links))) : ?>
            <section class="help-toolbars">
                <div class="container-fluid px-md-2 px-xxl-3">
                    <div class="row flex-column-reverse flex-md-row">
                        <div class="col-md-12 float-img-col">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/CM-float.svg" class="img-fluid help-tool-float">
                        </div>
                        <div class="col-md-12">
                            <div class="help-toolbars-content">
                                <div class="row">
                                    <!-- Close / Icon -->
                                    <div class="col-md-1 pe-0">
                                        <span class="close-float mb-2 pb-1 d-inline-block">
                                            <i class="fa-solid fa-circle-xmark text-white opacity-50"></i>
                                        </span>
                                        <div class="text-center text-md-left help-logo pb-3 pb-md-0">
                                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/float-title.svg" class="img-fluid" alt="">
                                        </div>
                                    </div>
                                    <?php if($heading || $main_content): ?>
                                    <!-- Heading + Main -->
                                        <div class="col-md-3 col-lg-2 text-center pt-2 pb-5 mb-2 pb-md-0 mb-md-0">
                                            <?php if ($heading) : ?>
                                                <h2 class="text-white font-xm mb-0 mb-md-1 mb-xl-2">
                                                    <?php echo esc_html($heading); ?>
                                                </h2>
                                            <?php endif; ?>
                                            <?php if ($main_content) : ?>
                                                <div class="mb-0">
                                                    <a href="<?php echo $main_content['url']; ?>" <?php if($main_content['target']): ?>target="<?php echo $main_content['target']; ?>"<?php endif; ?>><?php echo $main_content['title']; ?></a>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; 
                                    if (!empty($standard_links) && is_array($standard_links)) : ?>
                                    <!-- Standard Links -->
                                        <div class="col-md-8 col-lg-9 pb-5 pb-md-0 d-md-flex help-menus-wrapper">
                                            <?php $count = 0;
                                                $total = count($standard_links);
                                            ?>
                                            <div class="help-float-menu-wrapper">
                                                <ul class="help-float-menu list-unstyled mb-0 text-center text-md-start px-md-2 px-lg-3">
                                                    <?php foreach ($standard_links as $index => $row) :
                                                        $link = $row['link'] ?? null;
                                                        if (!$link) continue;

                                                        $count++;
                                                    ?>
                                                        <li>
                                                            <a href="<?php echo esc_url($link['url']); ?>"
                                                            target="<?php echo esc_attr($link['target'] ?: '_self'); ?>">
                                                                <?php echo esc_html($link['title']); ?>
                                                            </a>
                                                        </li>
                                                        <?php
                                                        // Close and reopen UL after every 3 items (except last)
                                                        if ($count % 3 === 0 && $count < $total) :
                                                        ?>
                                                            </ul>
                                                            <ul class="help-float-menu list-unstyled mb-0 text-center text-md-start px-md-2 px-lg-3">
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>
                                            <!-- Icon Links -->
                                            <?php if (!empty($icon_links) && is_array($icon_links)) : ?>
                                                <ul class="help-float-icon-menu list-unstyled mb-0 mt-5 mt-md-0">
                                                    <?php foreach($icon_links as $row) :
                                                        $link = $row['link'] ?? null;
                                                        $icon = $row['link_icon'] ?? null;
                                                        if ($link):
                                                    ?>
                                                        <li class="d-flex gap-2">
                                                            <?php if ($icon) : ?>
                                                                <span><?php echo $icon; ?></span>
                                                            <?php endif; ?>
                                                            <a href="<?php echo esc_url($link['url']); ?>"
                                                            target="<?php echo esc_attr($link['target'] ?: '_self'); ?>">
                                                                <?php echo esc_html($link['title']); ?>
                                                            </a>
                                                        </li>
                                                    <?php endif; endforeach; ?>
                                                </ul>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; endif; ?>
        <?php endif; ?>
        <!-- End Here Help Toolbars -->