<?php
    ob_start();
    $block_class_name = 'accordion-section';
    $items = get_field('accordion_content');
    $numbers = get_field('accordion_numbers');
    $always_open = true; // close open others => false

    if ( !empty($items) ) :
        $title = get_field('accordion_title') ? esc_attr(get_field('accordion_title')) : false;
        $accordion_id = uniqid();
    ?>

    <div class="accordion-section-group">

        <?php echo $title ? sprintf('<h2 class="%s-title">%s</h2>',$block_class_name,$title) : ''; ?>

        <div class="accordion" id="acc-<?php echo $accordion_id; ?>">
            <?php $i = 1; foreach ( $items as $item ) :
                $item_title = check_array('title',$item) ? esc_attr($item['title']) : false;
                //$item_subtitle = check_array('subtitle',$item) ? esc_attr($item['subtitle']) : false;
                $item_content = check_array('content',$item) ? $item['content'] : false;
                $item_content2 = check_array('content_2',$item) ? $item['content_2'] : false;

                if ( $item_title ) :
                    $loop_id = $accordion_id . '-' . $i;
                    $acc_header_id = 'ah-' . $loop_id;
                    $acc_collapse_id = 'ac-' . $loop_id;
                ?>
                <div class="accordion-item">
                    <div class="accordion-header" id="<?php echo $acc_header_id; ?>">
                        <button class="accordion-button<?php echo $i == 1 ? '' : ' collapsed'; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo $acc_collapse_id; ?>" aria-expanded="<?php echo $i == 1 ? 'true' : 'false'; ?>" aria-controls="<?php echo $acc_collapse_id; ?>">
                            <span class="ai-header d-flex">
                                <?php if ( $numbers ) : ?>
                                    <span class="ai-header-nb flex-shrink-0" data-number="<?php echo $i; ?>">
                                        <span><?php echo $i; ?></span>
                                    </span>
                                <?php endif; ?>
                                <span class="ai-header-content flex-grow-1">
                                    <span class="ai-header-title"><?php echo $item_title; ?></span>
                                    <?php /*?>
                                    <span class="ai-header-subtitle"><?php echo $item_subtitle; ?></span>
                                    <?php */?>
                                </span>
                            </span>
                        </button>
                    </div>
                    <div id="<?php echo $acc_collapse_id; ?>" class="accordion-collapse collapse<?php echo $i == 1 ? ' show' : ''; ?>" aria-labelledby="<?php echo $acc_header_id; ?>"<?php echo $always_open ? '' : ' data-bs-parent="#acc-'.$accordion_id; ?>">
                        <div class="ai-content accordion-body">
                            <?php if ( $item_content2 ) : ?>
                                <div class="row">
                                    <div class="col-lg">
                                        <?php echo $item_content; ?>
                                    </div>
                                    <div class="col-lg">
                                        <?php echo $item_content2; ?>
                                    </div>
                                </div>
                            <?php else : ?>
                                <?php echo $item_content; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endif; $i++; endforeach; ?>
        </div>

    </div>

    <?php endif; ?>

<?php
    $content = ob_get_clean();
    set_block_content( $block, $content, $block_class_name );
?>
