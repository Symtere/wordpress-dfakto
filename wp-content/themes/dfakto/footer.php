        </main>

        <footer id="footer" class="footer">
            <div class="container">
                <div class="sup-footer d-flex justify-content-md-between justify-content-center">
                    <div class="ft-menu">
                        <?php //echo function_exists('get_acf_logo_footer') ? '<div class="ft-brand-img">' . get_acf_logo_footer() . '</div>' : '';
                        ?>
                        <?php //echo function_exists('get_brand_informations') ? get_brand_informations() : '';
                        ?>
                        <?php echo function_exists('footer_nav') ? footer_nav() : ''; ?>
                    </div>

                    <?php $adresses = get_field_option('adresses') ? get_field_option('adresses') : '';
                    foreach ($adresses as $key => $address) { ?>
                        <div class="ft-col-adress">
                            <div class="menu-nav-title"><?php echo $address['title'] ?></div>
                            <div class="ft-address"><?php echo $address['address'] ?></div>
                            <div class="ft-addr-phone"><a href="<?php echo 'tel:' . $address['phone']; ?>"><?php echo $address['phone'] ?></a></div>
                        </div>
                    <?php } ?>

                    <div class="ft-rsx-scx">
                        <?php echo function_exists('get_social_items') ? sprintf('<div class="menu-nav-title">Suivez nous sur les réseau sociaux</div>%s', get_social_items()) : ''; ?>
                    </div>
                </div>
            </div>
            <div class="sub-footer">
                <div class="container">
                    <div class="d-md-flex align-items-center justify-content-between">
                        <div class="sf-links mb-3 mb-md-0">
                            <?php echo esc_attr(get_bloginfo('name')); ?> <?php echo date('Y'); ?><?php echo function_exists('rgpd_nav') ? rgpd_nav() : ''; ?>
                        </div>
                        <div class="d-flex flex-wrap ft-copyright align-items-center">
                            <div class="pe-2">
                                Mis à flot par <a target="_blank" href="https://www.pilot-in.com/">Pilot’in</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

        <?php get_template_part('template-parts/aside-menu'); ?>

        <?php wp_footer(); ?>
        </div>

        </body>

        </html>
