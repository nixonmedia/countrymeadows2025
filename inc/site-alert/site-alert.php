<?php
function display_notice()
{
    ob_start();

?>
    <?php
    global $post;
    $community = get_the_title(); //page title
    $subcommunity = get_the_title($post->post_parent); //get the parent of the page
    $parentID = "";
    $parentID = wp_get_post_parent_id(get_the_id(), false);
    $parent = "";
    $parent = $post->post_parent;
    $grandparent = get_ancestors($parent, 'page');
    // $isHome = is_page('7');
    $grandparent_title ="";
    if ($grandparent) {
        $grandparentID = $grandparent[0];
        $grandparent_title = get_the_title($grandparentID); //get the ancester
    }
    $parent_title = get_the_title($parentID);
    $front_page_id = get_option('page_on_front');
    if (is_page($front_page_id)) {
        $args = array(
            'post_type' => 'site_alerts',
            'orderby' => 'date',
            'number_posts' => '3',
            'order'   => 'ASC',
            'tax_query' => array(
                'relation' => 'AND',
                array(
                    'taxonomy' => 'site_alert_categories',
                    'field' => 'slug',
                    'terms' => array('home-page-only'),
                ),
            ),
        );
    } else {
        $args = array(
            'post_type' => 'site_alerts',
            'orderby' => 'date',
            'number_posts' => '3',
            'order'   => 'ASC',
            'tax_query' => array(
                'relation' => 'AND',
                array(
                    'taxonomy' => 'site_alert_categories',
                    'field' => 'slug',
                    'terms' => array($community, $subcommunity, $grandparent_title, 'sitewide'),
                ),
            ),
        );
    }
    $custom_posts = get_posts($args);
    foreach ($custom_posts as $post) : setup_postdata($post);
        // if this specific notification has been closed before...
        $nID = get_the_id();
    ?>
    <?php endforeach; ?>
    <?php wp_reset_postdata(); ?>
    <!-- TODO: This JavaScript should be in a seperate file. -->
    <script type="text/javascript">
        var ajax_url = "<?= admin_url('admin-ajax.php'); ?>";
        jQuery.post(ajax_url, {
            'action': 'cookie_display_notice'
        }, function(response) {
            jQuery('#notice').html(response);
            //console.log('cookie response: '+response);
        });
    </script>
    <script>
        jQuery('body').on('click', '.close', function(e) {
            e.preventDefault();

            const $alert = jQuery(this).closest('.alert');
            const cname = $alert.data('cname');

            // set cookie
            Cookies.set(cname, cname, {
                expires: 7,
                path: '/'
            });

            // close alert visually
            $alert.fadeOut(300, function() {
                jQuery(this).remove();
            });

            // optional: remove notice container state
            jQuery('#notice').removeClass('active-notice');

            console.log('cookie set and alert closed:', cname);
        });
    </script>
    <?php
    return ob_get_clean();
}

add_shortcode('display_notice', 'display_notice');

function cookie_display_notice()
{

    //echo 'notice';

    $page_id = isset($_POST['page_id']) ? intval($_POST['page_id']) : 0;

    // global $post;


    $community = get_the_title($page_id); //page title
    $postt = get_post($page_id);
    // echo $community.' page';
    $subcommunity = get_the_title($postt->post_parent); //get the parent of the page
    // echo $subcommunity.' parent page';
    $parentID = "";
    $parentID = wp_get_post_parent_id($page_id, false);
    $parent = "";
    $parent = $post->post_parent;
    $grandparent = get_ancestors($parent, 'page');

    // $isHome = is_page('7');




    if ($grandparent) {
        $grandparentID = $grandparent[0];
        $grandparent_title = get_the_title($grandparentID); //get the ancester
    }


    $parent_title = get_the_title($parentID);

    if (is_page($front_page_id)) {


        //echo 'ihp';

        $args = array(
            'post_type' => 'site_alerts',
            'orderby' => 'date',
            'number_posts' => '3',
            'order'   => 'ASC',
            'tax_query' => array(
                'relation' => 'AND',
                array(
                    'taxonomy' => 'site_alert_categories',
                    'field' => 'slug',
                    'terms' => array('home-page-only'),
                    //'terms' => array($community, $subcommunity, $grandparent_title, 'sitewide', 'home-page-only'),
                ),
            ),
        );
    } else {
        //echo 'nhp';
        $args = array(
            'post_type' => 'site_alerts',
            'orderby' => 'date',
            'number_posts' => '3',
            'order'   => 'ASC',
            'tax_query' => array(
                'relation' => 'AND',
                array(
                    'taxonomy' => 'site_alert_categories',
                    'field' => 'slug',
                    'terms' => array($community, $subcommunity, $grandparent_title, 'sitewide'),
                ),
            ),
        );
    }

    $custom_posts = get_posts($args);
    foreach ($custom_posts as $post) : setup_postdata($post);
        // if this specific notification has been closed before...
        $nID = get_the_id();
        // echo 'looking for cookie '.$nID;
        if (!isset($_COOKIE['n-' . $nID])) {
            //setcookie('n-'.$nID,'n-'.$nID, 7, "/");

            echo '<script>console.log("n-' . $nID . ' cookie not found");</script>';


    ?>
            <?php

            $priority = get_field('priority');
            $alert_link = get_field('alert_button_link');
            $alert_link_internal = get_field('alert_button_link_internal');

            ?>


            <?php if ($post):
                // var_dump($post); 
            ?>

                <div data-cname="<?php echo 'n-' . $nID; ?>" class="alert notice-alert <?php echo get_field('priority'); ?> alert-dismissable">
                    <div class="container-fluid">

                        <div class="col-md-12">


                            <a href="#" class="close notice-alert-close" data-dismiss="alert" aria-label="close">&times;</a>

                            <strong><?php echo $post->post_title; ?></strong><span><?php echo $post->post_content; ?></span>

                            <?php
                            $alert_link = get_field('alert_button_link');
                            $alert_link_internal = get_field('alert_button_link_internal');
                            //echo 'alert id = ' . $post->ID;
                            ?>



                            <?php if ($alert_link) { ?>

                                <a target="_blank" href="<?php echo $alert_link; ?>"><?php echo get_field('alert_button_label'); ?></a>
                            <?php } elseif ($alert_link_internal) { ?>

                                <a href="<?php echo $alert_link_internal; ?>"><?php echo get_field('alert_button_label'); ?></a>

                            <?php } ?>


                        </div><!--col-md-12-->

                    </div><!--/container-->
                </div><!--/alert-->
<?php
            endif;
        }

    endforeach;
    wp_die();
}


add_action('wp_ajax_nopriv_cookie_display_notice', 'cookie_display_notice');
add_action('wp_ajax_cookie_display_notice', 'cookie_display_notice');
