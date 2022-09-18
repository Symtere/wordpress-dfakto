<?php
    ob_start();
    $slider = get_field('slider_slide');

    if ( $slider ) : ?>
        <div id="main-slider" class="ms-container swiper-container swiper-is-loading">
            <div class="swiper-wrapper">
                <?php $i = 0; foreach ($slider as $slide) :
                    $img = check_array('img',$slide) ? $slide['img'] : false;
                    $img_url = $img ? ' style="background-image: url('. esc_url($img['url']).');"' : '';
                    $img_alt = $img ? esc_attr($img['alt']) : '';
                    $bg_color = $slide['bg_color'] ? ' style="background-color: '. esc_attr($slide['bg_color']) . ';"' : '';

                    $btn = check_array('btn',$slide) ? $slide['btn'] : false;
                    $btn_url = $btn ? esc_url($btn['url']) : false;
                    $btn_title = $btn ? esc_attr($btn['title'] ): '';
                    $btn_target = $btn ? esc_attr(' target="'. $btn['target'] . '"') : '';

                    $title = check_array('title', $slide) ? esc_attr($slide['title']) : false;
                    $title_tag = (is_home() || is_front_page() && $i == 0) ? 'h1' : 'div';
                    $description = check_array('description', $slide) ? wp_kses_post($slide['description']) : false;
                ?>
                    <div class="ms-slide swiper-slide"<?php echo $img_url; ?>>
                        <div class="ms-slide-bg-color"<?php echo $bg_color; ?>>
                            <div class="ms-item d-flex align-items-center">
                                <div class="container">
                                    <?php echo $title ? sprintf('<%2$s class="ms-title h1">%1$s</%2$s>',$title,$title_tag) : ''; ?>
                                    <?php echo $description ? sprintf('<div class="ms-description">%s</div>',$description) : ''; ?>
                                    <?php echo $btn_url ? sprintf('<a class="ms-btn btn btn-primary" href="%1$s" title="%2$s"%3$s>%4$s</a>',$btn_url,$btn_title,$btn_target,$btn_title) : ''; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php $i++; endforeach; ?>
            </div>
            <div class="swiper-pagination swiper-ms-pagination white-pagination"></div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', (event) => {

                const mainSlider = document.getElementById('main-slider');
                if ( mainSlider != null ) {
                    const mainSliderSwiper = new Swiper(mainSlider, {
                        lazyLoading: true,
                        autoplay: {
                            delay: 5000,
                            pauseOnMouseEnter: true,
                            disableOnInteraction: false,
                        },
                        pagination: {
                            el: '.swiper-ms-pagination',
                            type: 'bullets',
                            clickable:  true,
                        },
                        on: {
                            afterInit: (e) => {
                                e.el.classList.remove('swiper-is-loading');
                            },
                        },
                    });
                }
            });
        </script>
    <?php endif; ?>

    <?php
        $content = ob_get_clean();
        set_block_content( $block, $content, 'main-slider' );
