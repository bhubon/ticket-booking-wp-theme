<?php

class BEM_Sponsors extends \Elementor\Widget_Base {

    public function get_name() {
        return 'bem-sponsors';
    }

    public function get_title() {
        return esc_html__('BEM Sponsors', 'elementor-addon');
    }

    public function get_icon() {
        return 'eicon-code';
    }

    public function get_categories() {
        return ['basic'];
    }

    public function get_keywords() {
        return ['hello', 'world'];
    }

    protected function render() {
        $q = new WP_Query([
            'post_type' => 'sponsor',
            'posts_per_page' => -1,
            'order' => 'ASC',
            'orderby' => 'menu_order'
        ]);

?>
        <div class="flex mx-4 justify-center">
            <?php
            if ($q->have_posts()) :
                while ($q->have_posts()) :
                    $q->the_post();
            ?>
                    <div class="px-4 w-1/4">
                        <div data-ajax_url="<?php echo admin_url('admin-ajax.php'); ?>" data-id="<?php echo get_the_ID(); ?>" class="sponsor-logo-wrapper">
                            <div class="sponsor-logo">
                                <?php the_post_thumbnail(); ?>
                            </div>
                        </div>
                    </div>
            <?php
                endwhile;
            endif;
            wp_reset_query();
            ?>
        </div>
    <?php
    }
}



class BEM_Speakers extends \Elementor\Widget_Base {

    public function get_name() {
        return 'bem-speakers';
    }

    public function get_title() {
        return esc_html__('BEM Speakers', 'elementor-addon');
    }

    public function get_icon() {
        return 'eicon-code';
    }

    public function get_categories() {
        return ['basic'];
    }

    public function get_keywords() {
        return ['hello', 'world'];
    }

    protected function render() {
        $q = new WP_Query([
            'post_type' => 'speaker',
            'posts_per_page' => -1,
            'order' => 'ASC',
            'orderby' => 'menu_order'
        ]);

        $speaker_categories = get_terms([
            'taxonomy' => 'speaker_cat',
            'hide_empty' => true
        ]);

    ?>

        <div class="flex">
            <?php
            foreach ($speaker_categories as $speaker_category) :
            ?>
                <button class="speaker-category" data-ajax_url="<?php echo admin_url('admin-ajax.php'); ?>" data-id="<?php echo $speaker_category->term_id; ?>"><?php echo $speaker_category->name; ?></button>

            <?php
            endforeach;
            ?>
        </div>
        <div class="flex mx-4 justify-center" id="speakers">
            <?php
            if ($q->have_posts()) :
                while ($q->have_posts()) :
                    $q->the_post();
            ?>
                    <div class="px-4 w-1/4">
                        <div class="speaker-image-wrapper">
                            <div class="speaker-image">
                                <?php the_post_thumbnail(); ?>
                            </div>
                        </div>
                        <h3><?php the_title(); ?></h3>
                    </div>
            <?php
                endwhile;
            endif;
            wp_reset_query();
            ?>
        </div>
<?php
    }
}
