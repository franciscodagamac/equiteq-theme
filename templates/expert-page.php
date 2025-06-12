<?php
/* Template Name: Expert Page */
get_header();
$id = get_the_ID();
$page = get_post($id);
?>

<section class="bg-dark-blue">
    <div class="container text-white no-pad-gutters">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-title text-uppercase mb-2"><?php echo $page->post_title ?></h3>
                <?php echo $page->post_content ?>
            </div>
        </div>

        <!--May implement the search and filter here-->

        <div class="row">
            <div class="col-lg-12">
                <form method="get" class="expert-filter-form">
                        
                        <div class="row g-3">
                            <div class="col-lg-4  col-md-12 col-sm-12 mb-2">
                                <input type="text" name="expert_name" value="<?php echo esc_attr($_GET['expert_name'] ?? '') ?>" class="form-control" placeholder="Search by name">
                            </div>
                            <div class="col-lg-4  col-md-12 col-sm-12 mb-2">
                                <select name="field-location" class="form-select">
                                    <option value="">All Locations</option>
                                    <?php
                                    $locations = get_posts(['post_type' => 'location', 'numberposts' => -1]);
                                    foreach ($locations as $location) {
                                        $selected = selected($_GET['field-location'] ?? '', $location->ID, false);
                                        echo "<option value='{$location->ID}' $selected>{$location->post_title}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-lg-4  col-md-12 col-sm-12 mb-2">
                                <select name="field-industry" class="form-select">
                                    <option value="">All Industries</option>
                                    <?php
                                    $industries = get_posts(['post_type' => 'industry', 'numberposts' => -1]);
                                    foreach ($industries as $industry) {
                                        $selected = selected($_GET['field-industry'] ?? '', $industry->ID, false);
                                        echo "<option value='{$industry->ID}' $selected>{$industry->post_title}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-light">Filter</button>
                        </div>
                </form>
            </div>
        </div>


    </div>
</section>

<div class="expert-list">
    <div class="container">
        <div class="row">
            <?php
                $args = [
                    'post_type' => 'expert',
                    'posts_per_page' => -1,
                    'meta_query' => [],
                ];

                if (!empty($_GET['expert_name'])) {
                    $args['s'] = sanitize_text_field($_GET['expert_name']);
                }

                if (!empty($_GET['field-location'])) {
                    $args['meta_query'][] = [
                        'key' => 'location',
                        'value' => (int) $_GET['field-location'],
                        'compare' => '=',
                    ];
                }

                if (!empty($_GET['field-industry'])) {
                    $args['meta_query'][] = [
                        'key' => 'industry_expertise',
                        'value' => (int) $_GET['field-industry'],
                        'compare' => '=',
                    ];
                }

                $expert_query = new WP_Query($args);

                if ($expert_query->have_posts()) :
                    while ($expert_query->have_posts()) : $expert_query->the_post();

                        echo '<div class="col-lg-3 col-md-6 col-sm-6 col-6 single-expert">';

                        // Profile Image (ACF image field)
                        $profile_image = get_field('profile_image');
                        if ($profile_image) {
                            echo '<a href="' . get_permalink() . '">';
                            echo '<img src="' . esc_url($profile_image['url']) . '" alt="' . esc_attr($profile_image['alt']) . '" height="175" width="175"/>';
                            echo "</a>";
                        }

                        echo '<h2 class="expert-name"><a href="' . get_permalink() . '">' . get_the_title() . '</a></h2>';

                        if ($f_title = get_field('title')) {
                            echo "<p class='expert-position'>". $f_title ."</p>";
                        }

                        if ($f_location = get_field('location')) {
                            echo "<p class='expert-location'>". $f_location->post_title ."</p>";
                        }

                        echo "<div class='soc-med-wrapper'>";
                            
                        if ($f_email = get_field('email')) {
                            echo '<a href="mailto:' . $f_email . '"><i class="fa fa-envelope" aria-hidden="true"></i></a>';
                        }

                        if ($f_contact_no = get_field('contact_no')) {
                            echo '<a href="tel:' . $f_contact_no . '"><i class="fa fa-phone" aria-hidden="true"></i></a>';
                        }

                        if ($f_linkedin = get_field('linkedin')) {
                            echo '<a href="' . $f_linkedin . '" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a>';
                        }
                        echo "</div>";
                        echo '</div>';

                    endwhile;
                    wp_reset_postdata();
                else :
                    ?>
                    <div class="col-12 mt-5 text-center py-5">
                        <h4 class="text-muted">No team members found.</h4>
                        <p>Please check back later or adjust your filters.</p>
                    </div>
                    <?php
                endif;

            ?>
        </div>
    </div>
</div>

<?php
get_footer();
?>