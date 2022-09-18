<?php
    $title = $args && array_key_exists('title',$args) && $args['title'] ? esc_attr($args['title']) : '';
    $class_name = $args && array_key_exists('class_name',$args) && $args['class_name'] ? ' ' . esc_attr($args['class_name']) : '';
    $share_img_url = $args && array_key_exists('share_img_url',$args) && $args['share_img_url'] ? esc_attr($args['share_img_url']) : '';
    $mailto = $args && array_key_exists('mailto',$args) && $args['mailto'] ? esc_attr($args['mailto']) : '';
?>

<div class="share-this-list<?php echo $class_name; ?>">
    <?php echo $title ? sprintf('<span>%s</span>',$title) : ''; ?>
    <?php /* <div class="sharethis-inline-share-buttons"></div> */ ?>
    <div data-network="facebook" class="stl-btn st-custom-button" data-url="<?php echo get_the_permalink(); ?>"<?php $share_img_url ? sprintf('data-image="%s"',$share_img_url) : ''; ?>>
        <i class="fab fa-facebook-f"></i>
    </div>
    <div data-network="linkedin" class="stl-btn st-custom-button" data-url="<?php echo get_the_permalink(); ?>"<?php $share_img_url ? sprintf('data-image="%s"',$share_img_url) : ''; ?>>
        <i class="fab fa-linkedin-in"></i>
    </div>
    <a data-network="email" class="stl-btn st-custom-button" href="mailto:<?php echo $mailto; ?>?subject=<?php echo get_the_title(); ?>&body=<?php echo get_the_permalink(); ?>">
        <i class="fas fa-envelope"></i>
    </a>
</div>
