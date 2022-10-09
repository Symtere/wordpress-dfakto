<?php
ob_start();

$testimonials = get_field('testimonials');

if ($testimonials) :

?>
    <div class="row-testimonials">
        <div class="swiper-wrapper">
            <?php foreach ($testimonials as $testimonial) :
                $logo = $testimonial['logo'] ? $testimonial['logo'] : "";
                $logo_url = $logo ? $logo['url'] : "";
                $logo_alt = $logo ? $logo['alt'] : "";
                $author = $testimonial['author'] ? $testimonial['author'] : "";
                $content = $testimonial['content'] ? $testimonial['content'] : "";
            ?>
                <div class="testimonial-col swiper-slide">
                    <div class="testimonial">
                        <div class="testimonial-logo">
                            <img src="<?php echo $logo_url; ?>" alt="<?php echo $logo_alt; ?>">
                        </div>
                        <div class="h5 testimonial-author">
                            <?php echo $author; ?>
                        </div>
                        <div class="h4 testimonial-content">
                            <?php echo $content; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="testimonials-arrows">
            <div class="testimonials-button-prev"><i class="fa-thin fa-arrow-left"></i></div>
            <div class="testimonials-button-next"><i class="fa-thin fa-arrow-right"></i></i></div>
        </div>

        <div class="testimonials-slider-pagination"></div>
    </div>

<?php endif;

$content = ob_get_clean();
set_block_content($block, $content, 'testimonials');
