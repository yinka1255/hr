<?php
    if ( ! defined( 'ABSPATH' ) ) {
        exit;
    }
    /**
     * The template for the main content of the panel.
     * Override this template by specifying the path where it is stored (templates_path) in your Redux config.
     *
     * @author      Redux Framework
     * @package     ReduxFramework/Templates
     * @version:    3.5.4.18
     */
?>
<!-- Header Block -->
<?php $this->get_template( 'header.tpl.php' ); ?>

<!-- Intro Text -->
<?php if ( isset( $this->parent->args['intro_text'] ) ) { ?>
    <div id="redux-intro-text"><?php echo wp_kses_post( $this->parent->args['intro_text'] ); ?></div>
<?php } ?>

<?php $this->get_template( 'menu_container.tpl.php' ); ?>

<div class="redux-main">
    <!-- Stickybar -->
    <?php $this->get_template( 'header_stickybar.tpl.php' ); ?>
    <div id="redux_ajax_overlay">&nbsp;</div>
    <?php
        foreach ($this->parent->sections as $k => $section) {
        if ( isset( $section['customizer_only'] ) && $section['customizer_only'] == true ) {
            continue;
        }

        $section['class'] = isset( $section['class'] ) ? ' ' . $section['class'] : '';
        echo '<div id="' . $k . '_section_group' . '" class="redux-group-tab' . esc_attr( $section['class'] ) . '" data-rel="' . $k . '">';

        // Don't display in the
        $display = true;
        if ( isset( $_GET['page'] ) && $_GET['page'] == $this->parent->args['page_slug'] ) {
            if ( isset( $section['panel'] ) && $section['panel'] == "false" ) {
                $display = false;
            }
        }

        if ( $display ) {
            do_action( "redux/page/{$this->parent->args['opt_name']}/section/before", $section );
            $this->output_section( $k );
            do_action( "redux/page/{$this->parent->args['opt_name']}/section/after", $section );
        }
    ?></div><?php
    }

    /**
     * action 'redux/page-after-sections-{opt_name}'
     *
     * @deprecated
     *
     * @param object $this ReduxFramework
     */
    do_action( "redux/page-after-sections-{$this->parent->args['opt_name']}", $this ); 

    /**
     * action 'redux/page/{opt_name}/sections/after'
     *
     * @param object $this ReduxFramework
     */
    do_action( "redux/page/{$this->parent->args['opt_name']}/sections/after", $this );
?>
<div class="clear"></div>
<!-- Footer Block -->
<?php $this->get_template( 'footer.tpl.php' ); ?>
<div id="redux-sticky-padder" style="display: none;">&nbsp;</div>
</div>
<div class="clear"></div>