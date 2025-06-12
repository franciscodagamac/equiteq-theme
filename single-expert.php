<?php

get_header();
$id = get_the_ID();
$expert = get_expert($id);
// $industry_expertises = maybe_unserialize($expert->industry_expertise);
?>


<section class="single-expert-wrapper">
    <div class="container no-pad-gutters">
        <div class="row">
            <div class="col-lg-12">
                <div class="back mb-5">
                    <i class="fa fa-caret-left align-bottom" style="font-size: 22px;" aria-hidden="true"></i>
                    <a href="/our-team" class="btn-outline-success text-uppercase px-0 ml-2">Back to team</a>
                </div>

                <!--May implement the expert's profile here -->
                <div class="details-single">
                    
                    <?php

                        if (have_posts()) :
                            while (have_posts()) : the_post();

                                // Get ACF fields
                                $profile_image = get_field('profile_image');
                                $title = get_field('title');
                                $location = get_field('location');
                                $email = get_field('email');
                                $contact_no = get_field('contact_no');
                                $linkedin = get_field('linkedin');
                        ?>

                        <section class="single-expert-profile container">
                            <div class="row">
                                <div class="col-lg-4 col-md-6 col-sm-12 text-center mb-5">
                                    <?php if ($profile_image): ?>
                                        <img class="img-profile" src="<?php echo esc_url($profile_image['url']); ?>" alt="<?php echo esc_attr($profile_image['alt']); ?>" height="284" width="284" />
                                    <?php endif; ?>
                                </div>
                                <div class="col-lg-8 col-md-6 col-sm-12">
                                    <h1 class="expert-name mb-3"><?php the_title(); ?></h1>

                                    <?php if ($title): ?>
                                        <p class="expert-position mb-4"><?php echo esc_html($title); ?></p>
                                    <?php endif; ?>

                                    <?php if ($location): ?>
                                        <p class="expert-location"><i class="fa fa-map-marker fa-lg text-green" aria-hidden="true"></i> <?php echo esc_html($location->post_title); ?></p>
                                    <?php endif; ?>


                                    <div class='soc-med-wrapper'>
                                        <?php if ($email): ?>
                                            <a href="mailto:<?php echo esc_attr($email); ?>"><i class="fa fa-envelope" aria-hidden="true"></i></a>
                                        <?php endif; ?>

                                        <?php if ($contact_no): ?>
                                            <a href="tel:<?php echo esc_attr($contact_no); ?>"><i class="fa fa-phone" aria-hidden="true"></i></a>
                                        <?php endif; ?>

                                        <?php if ($linkedin): ?>
                                            <a href="<?php echo esc_url($linkedin); ?>" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                                        <?php endif; ?>
                                    </div>

                                    <p><?php the_content(); ?> </p>
                                </div>
                            </div>
                        </section>

                        <?php
                            endwhile;
                        endif;

                    ?>


                </div>
            </div>
        </div>
    </div>
</section>


<!--May implement the expert's industry expertise here -->

<?php
get_footer();