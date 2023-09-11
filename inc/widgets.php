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
                        <div class="sponsor-logo-wrapper">
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
