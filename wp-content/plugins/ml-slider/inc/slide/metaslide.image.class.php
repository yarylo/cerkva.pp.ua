<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // disable direct access
}

/**
 * Generic Slider super class. Extended by library specific classes.
 */
class MetaImageSlide extends MetaSlide {

    /**
     * Register slide type
     */
    public function __construct() {

        parent::__construct();

        add_filter( 'metaslider_get_image_slide', array( $this, 'get_slide' ), 10, 2 );
        add_action( 'metaslider_save_image_slide', array( $this, 'save_slide' ), 5, 3 );
        add_action( 'wp_ajax_create_image_slide', array( $this, 'ajax_create_slide' ) );
        add_action( 'wp_ajax_resize_image_slide', array( $this, 'ajax_resize_slide' ) );

    }

    /**
     * Create a new slide and echo the admin HTML
     */
    public function ajax_create_slide() {
        // security check
        if ( ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'metaslider_addslide' ) ) {
            echo "<tr><td colspan='2'>" . __( "Security check failed. Refresh page and try again.", 'ml-slider' ) . "</td></tr>";
            wp_die();
        }

        $slider_id = absint( $_POST['slider_id'] );
        $selection = $_POST['selection'];

        if ( is_array( $selection ) && count( $selection ) && $slider_id > 0 ) {

            foreach ( $selection as $slide_id ) {

                $this->set_slide( $slide_id );
                $this->set_slider( $slider_id );

                if ( $this->slide_exists_in_slideshow( $slider_id, $slide_id ) ) {

                    echo "<tr><td colspan='2'>ID: {$slide_id} \"" . get_the_title( $slide_id ) . "\" - " . __( "Failed to add slide. Slide already exists in slideshow.", 'ml-slider' ) . "</td></tr>";

                } else if ( ! $this->slide_is_unassigned_or_image_slide( $slider_id, $slide_id ) ) {

                    echo "<tr><td colspan='2'>ID: {$slide_id} \"" . get_the_title( $slide_id ) . "\" - " . __( "Failed to add slide. Slide is not of type 'image'.", 'ml-slider' ) . "</td></tr>";

                } else if ( ! wp_attachment_is_image( $slide_id ) ) {

                    echo "<tr><td colspan='2'>ID: {$slide_id} \"" . get_the_title( $slide_id ) . "\" - " . __( "Failed to add slide. Slide is not an image.", 'ml-slider' ) . "</td></tr>";

                } else {

                    $this->tag_slide_to_slider();
                    $this->add_or_update_or_delete_meta( $slide_id, 'type', 'image' );

                    // override the width and height to kick off the AJAX image resizing on save
                    $this->settings['width'] = 0;
                    $this->settings['height'] = 0;

                    echo $this->get_admin_slide();

                }
            }
        }

        wp_die();
    }

    /**
     * Create a new slide and echo the admin HTML
     */
    public function ajax_resize_slide() {

        check_admin_referer( 'metaslider_resize' );

        $slider_id = absint( $_POST['slider_id'] );
        $slide_id = absint( $_POST['slide_id'] );

        $this->set_slide( $slide_id );
        $this->set_slider( $slider_id );

        $settings = get_post_meta( $slider_id, 'ml-slider_settings', true );

        // create a copy of the correct sized image
        $imageHelper = new MetaSliderImageHelper(
            $slide_id,
            $settings['width'],
            $settings['height'],
            isset( $settings['smartCrop'] ) ? $settings['smartCrop'] : 'false',
            $this->use_wp_image_editor()
        );

        $url = $imageHelper->get_image_url( true );

        echo $url . " (" . $settings['width'] . 'x' . $settings['height'] . ")";

        do_action( "metaslider_ajax_resize_image_slide", $slide_id, $slider_id, $settings );

        wp_die();
    }


    /**
     * Return the HTML used to display this slide in the admin screen
     *
     * @return string slide html
     */
    protected function get_admin_slide() {

        // get some slide settings
        $imageHelper = new MetaSliderImageHelper( $this->slide->ID, 150, 150, 'false', $this->use_wp_image_editor() );
        $thumb       = $imageHelper->get_image_url();
        $slide_label = apply_filters( "metaslider_image_slide_label", __( "Image Slide", "ml-slider" ), $this->slide, $this->settings );

        // slide row HTML
        $row  = "<tr class='slide image flex responsive nivo coin'>
                    <td class='col-1'>
                        <div class='thumb' style='background-image: url({$thumb})'>
                            " . $this->get_delete_button_html() . "
                            " . $this->get_change_image_button_html() . "
                            <span class='slide-details'>{$slide_label}</span>
                        </div>
                    </td>
                    <td class='col-2'>
                        " . $this->get_admin_slide_tabs_html() . "
                        <input type='hidden' name='attachment[{$this->slide->ID}][type]' value='image' />
                        <input type='hidden' class='menu_order' name='attachment[{$this->slide->ID}][menu_order]' value='{$this->slide->menu_order}' />
                        <input type='hidden' name='resize_slide_id' data-slide_id='{$this->slide->ID}' data-width='{$this->settings['width']}' data-height='{$this->settings['height']}' />
                    </td>
                </tr>";

        return $row;

    }

    /**
     * Build an array of tabs and their titles to use for the admin slide.
     */
    public function get_admin_tabs() {

        $slide_id = absint( $this->slide->ID);
        $alt = esc_attr( get_post_meta( $slide_id, '_wp_attachment_image_alt', true ) );
        $url = esc_attr( get_post_meta( $slide_id, 'ml-slider_url', true ) );
        $title = esc_attr( get_post_meta( $slide_id, 'ml-slider_title', true ) );
        $target = get_post_meta( $slide_id, 'ml-slider_new_window', true ) ? 'checked=checked' : '';
        $caption = esc_textarea( $this->slide->post_excerpt );

        $general_tab = "<textarea name='attachment[{$slide_id}][post_excerpt]' placeholder='" . __( "Caption", "ml-slider" ) . "'>{$caption}</textarea>
                        <input class='url' type='text' name='attachment[{$slide_id}][url]' placeholder='" . __( "URL", "ml-slider" ) . "' value='{$url}' />
                        <div class='new_window'>
                        <label>" . __( "New Window", "ml-slider" ) . "<input type='checkbox' name='attachment[{$slide_id}][new_window]' {$target} /></label>
                        </div>";

        if ( ! $this->is_valid_image() ) {
            $message = __( "Warning: Image data does not exist. Please re-upload the image.", "ml-slider" );

            $general_tab = "<div class='warning'>{$message}</div>" . $general_tab;
        }

        $seo_tab = "<div class='row'><label>" . __( "Image Title Text", "ml-slider" ) . "</label></div>
                    <div class='row'><input type='text' size='50' name='attachment[{$slide_id}][title]' value='{$title}' /></div>
                    <div class='row'><label>" . __( "Image Alt Text", "ml-slider" ) . "</label></div>
                    <div class='row'><input type='text' size='50' name='attachment[{$slide_id}][alt]' value='{$alt}' /></div>";

        $tabs = array(
            'general' => array(
                'title' => __( "General", "ml-slider" ),
                'content' => $general_tab
            ),
            'seo' => array(
                'title' => __( "SEO", "ml-slider" ),
                'content' => $seo_tab
            )
        );

        if ( version_compare( get_bloginfo('version'), 3.9, '>=' ) ) {

            $crop_position = get_post_meta( $slide_id, 'ml-slider_crop_position', true);

            if ( ! $crop_position ) {
                $crop_position = 'center-center';
            }

            $crop_tab = "<div class='row'><label>" . __( "Crop Position", "ml-slider" ) . "</label></div>
                        <div class='row'>
                            <select class='crop_position' name='attachment[{$slide_id}][crop_position]'>
                                <option value='left-top' " . selected( $crop_position, 'left-top', false ) . ">" . __( "Top Left", "ml-slider" ) . "</option>
                                <option value='center-top' " . selected( $crop_position, 'center-top', false ) . ">" . __( "Top Center", "ml-slider" ) . "</option>
                                <option value='right-top' " . selected( $crop_position, 'right-top', false ) . ">" . __( "Top Right", "ml-slider" ) . "</option>
                                <option value='left-center' " . selected( $crop_position, 'left-center', false ) . ">" . __( "Center Left", "ml-slider" ) . "</option>
                                <option value='center-center' " . selected( $crop_position, 'center-center', false ) . ">" . __( "Center Center", "ml-slider" ) . "</option>
                                <option value='right-center' " . selected( $crop_position, 'right-center', false ) . ">" . __( "Center Right", "ml-slider" ) . "</option>
                                <option value='left-bottom' " . selected( $crop_position, 'left-bottom', false ) . ">" . __( "Bottom Left", "ml-slider" ) . "</option>
                                <option value='center-bottom' " . selected( $crop_position, 'center-bottom', false ) . ">" . __( "Bottom Center", "ml-slider" ) . "</option>
                                <option value='right-bottom' " . selected( $crop_position, 'right-bottom', false ) . ">" . __( "Bottom Right", "ml-slider" ) . "</option>
                            </select>
                        </div>";

            $tabs['crop'] = array(
                'title' => __( "Crop", "ml-slider" ),
                'content' => $crop_tab
            );

        }

        return apply_filters("metaslider_image_slide_tabs", $tabs, $this->slide, $this->slider, $this->settings);

    }


    /**
     * Check to see if metadata exists for this image. Assume the image is
     * valid if metadata and a size exists for it (generated during initial
     * upload to WordPress).
     *
     * @return bool, true if metadata and size exists.
     */
    public function is_valid_image() {

        $meta = wp_get_attachment_metadata( $this->slide->ID );

        $is_valid = isset( $meta['width'], $meta['height'] );

        return apply_filters( 'metaslider_is_valid_image', $is_valid, $this->slide );
    }


    /**
     * Disable/enable image editor
     *
     * @return bool
     */
    public function use_wp_image_editor() {

        return apply_filters( 'metaslider_use_image_editor', $this->is_valid_image(), $this->slide );

    }

    /**
     * Returns the HTML for the public slide
     *
     * @return string slide html
     */
    protected function get_public_slide() {

        // get the image url (and handle cropping)
        // disable wp_image_editor if metadata does not exist for the slide
        $imageHelper = new MetaSliderImageHelper(
            $this->slide->ID,
            $this->settings['width'],
            $this->settings['height'],
            isset( $this->settings['smartCrop'] ) ? $this->settings['smartCrop'] : 'false',
            $this->use_wp_image_editor()
        );

        $thumb = $imageHelper->get_image_url();

        // store the slide details
        $slide = array(
            'id' => $this->slide->ID,
            'url' => __( get_post_meta( $this->slide->ID, 'ml-slider_url', true ) ),
            'title' => __( get_post_meta( $this->slide->ID, 'ml-slider_title', true ) ),
            'target' => get_post_meta( $this->slide->ID, 'ml-slider_new_window', true ) ? '_blank' : '_self',
            'src' => $thumb,
            'thumb' => $thumb, // backwards compatibility with Vantage
            'width' => $this->settings['width'],
            'height' => $this->settings['height'],
            'alt' => __( get_post_meta( $this->slide->ID, '_wp_attachment_image_alt', true ) ),
            'caption' => __( html_entity_decode( do_shortcode( $this->slide->post_excerpt ), ENT_NOQUOTES, 'UTF-8' ) ),
            'caption_raw' => __( do_shortcode( $this->slide->post_excerpt ) ),
            'class' => "slider-{$this->slider->ID} slide-{$this->slide->ID}",
            'rel' => "",
            'data-thumb' => ""
        );

        // fix slide URLs
        if ( strpos( $slide['url'], 'www.' ) === 0 ) {
            $slide['url'] = 'http://' . $slide['url'];
        }

        $slide = apply_filters( 'metaslider_image_slide_attributes', $slide, $this->slider->ID, $this->settings );

        // return the slide HTML
        switch ( $this->settings['type'] ) {
            case "coin":
                return $this->get_coin_slider_markup( $slide );
            case "flex":
                return $this->get_flex_slider_markup( $slide );
            case "nivo":
                return $this->get_nivo_slider_markup( $slide );
            case "responsive":
                return $this->get_responsive_slides_markup( $slide );
            default:
                return $this->get_flex_slider_markup( $slide );
        }

    }

    /**
     * Generate nivo slider markup
     *
     * @return string slide html
     */
    private function get_nivo_slider_markup( $slide ) {

        $attributes = apply_filters( 'metaslider_nivo_slider_image_attributes', array(
                'src' => $slide['src'],
                'height' => $slide['height'],
                'width' => $slide['width'],
                'data-title' => htmlentities( $slide['caption_raw'], ENT_QUOTES, 'UTF-8' ),
                'data-thumb' => $slide['data-thumb'],
                'title' => $slide['title'],
                'alt' => $slide['alt'],
                'rel' => $slide['rel'],
                'class' => $slide['class']
            ), $slide, $this->slider->ID );

        $html = $this->build_image_tag( $attributes );

        $anchor_attributes = apply_filters( 'metaslider_nivo_slider_anchor_attributes', array(
                'href' => $slide['url'],
                'target' => $slide['target']
            ), $slide, $this->slider->ID );

        if ( strlen( $anchor_attributes['href'] ) ) {
            $html = $this->build_anchor_tag( $anchor_attributes, $html );
        }

        return apply_filters( 'metaslider_image_nivo_slider_markup', $html, $slide, $this->settings );

    }

    /**
     * Generate flex slider markup
     *
     * @return string slide html
     */
    private function get_flex_slider_markup( $slide ) {

        $image_attributes = array(
            'src' => $slide['src'],
            'height' => $slide['height'],
            'width' => $slide['width'],
            'alt' => $slide['alt'],
            'rel' => $slide['rel'],
            'class' => $slide['class'],
            'title' => $slide['title']
        );

        if ( $this->settings['smartCrop'] == 'disabled_pad') {

            $image_attributes['style'] = $this->flex_smart_pad( $image_attributes, $slide );

        }

        $attributes = apply_filters( 'metaslider_flex_slider_image_attributes', $image_attributes, $slide, $this->slider->ID );

        $html = $this->build_image_tag( $attributes );

        $anchor_attributes = apply_filters( 'metaslider_flex_slider_anchor_attributes', array(
                'href' => $slide['url'],
                'target' => $slide['target']
            ), $slide, $this->slider->ID );

        if ( strlen( $anchor_attributes['href'] ) ) {
            $html = $this->build_anchor_tag( $anchor_attributes, $html );
        }

        // add caption
        if ( strlen( $slide['caption'] ) ) {
            $html .= '<div class="caption-wrap"><div class="caption">' . $slide['caption'] . '</div></div>';
        }

        $attributes = apply_filters( 'metaslider_flex_slider_list_item_attributes', array(
                'data-thumb' => isset($slide['data-thumb']) ? $slide['data-thumb'] : "",
                'style' => "display: none; width: 100%;",
                'class' => "slide-{$this->slide->ID} ms-image"
            ), $slide, $this->slider->ID );

        $li = "<li";

        foreach ( $attributes as $att => $val ) {
            if ( strlen( $val ) ) {
                $li .= " " . $att . '="' . esc_attr( $val ) . '"';
            }
        }

        $li .= ">" . $html . "</li>";

        $html = $li;


        return apply_filters( 'metaslider_image_flex_slider_markup', $html, $slide, $this->settings );

    }

    /**
     * Calculate the correct width (for vertical alignment) or top margin (for horizontal alignment)
     * so that images are never stretched above the height set in the slideshow settings
     */
    private function flex_smart_pad( $atts, $slide ) {

        $meta = wp_get_attachment_metadata( $slide['id'] );

        if ( isset( $meta['width'], $meta['height'] ) ) {

            $image_width = $meta['width'];
            $image_height = $meta['height'];
            $container_width = $this->settings['width'];
            $container_height = $this->settings['height'];

            $new_image_height = $image_height * ( $container_width / $image_width );

            if ( $new_image_height < $container_height ) {

                $margin_top_in_px = ( $container_height - $new_image_height ) / 2;

                $margin_top_in_percent = ( $margin_top_in_px / $container_width ) * 100;

                return 'margin-top: ' . $margin_top_in_percent . '%';

            } else {

                return 'margin: 0 auto; width: ' . ( $container_height / $new_image_height ) * 100 . '%';

            }

        }

        return "";

    }


    /**
     * Generate coin slider markup
     *
     * @return string slide html
     */
    private function get_coin_slider_markup( $slide ) {

        $attributes = apply_filters( 'metaslider_coin_slider_image_attributes', array(
                'src' => $slide['src'],
                'height' => $slide['height'],
                'width' => $slide['width'],
                'alt' => $slide['alt'],
                'rel' => $slide['rel'],
                'class' => $slide['class'],
                'title' => $slide['title'],
                'style' => 'display: none;'
            ), $slide, $this->slider->ID );

        $html = $this->build_image_tag( $attributes );

        if ( strlen( $slide['caption'] ) ) {
            $html .= "<span>{$slide['caption']}</span>";
        }

        $attributes = apply_filters( 'metaslider_coin_slider_anchor_attributes', array(
                'href' => strlen( $slide['url'] ) ? $slide['url'] : 'javascript:void(0)'
            ), $slide, $this->slider->ID );

        $html = $this->build_anchor_tag( $attributes, $html );

        return apply_filters( 'metaslider_image_coin_slider_markup', $html, $slide, $this->settings );

    }

    /**
     * Generate responsive slides markup
     *
     * @return string slide html
     */
    private function get_responsive_slides_markup( $slide ) {

        $attributes = apply_filters( 'metaslider_responsive_slider_image_attributes', array(
                'src' => $slide['src'],
                'height' => $slide['height'],
                'width' => $slide['width'],
                'alt' => $slide['alt'],
                'rel' => $slide['rel'],
                'class' => $slide['class'],
                'title' => $slide['title']
            ), $slide, $this->slider->ID );

        $html = $this->build_image_tag( $attributes );

        if ( strlen( $slide['caption'] ) ) {
            $html .= '<div class="caption-wrap"><div class="caption">' . $slide['caption'] . '</div></div>';
        }

        $anchor_attributes = apply_filters( 'metaslider_responsive_slider_anchor_attributes', array(
                'href' => $slide['url'],
                'target' => $slide['target']
            ), $slide, $this->slider->ID );

        if ( strlen( $anchor_attributes['href'] ) ) {
            $html = $this->build_anchor_tag( $anchor_attributes, $html );
        }

        return apply_filters( 'metaslider_image_responsive_slider_markup', $html, $slide, $this->settings );

    }

    /**
     * Save
     */
    protected function save( $fields ) {

        // update the slide
        wp_update_post( array(
                'ID' => $this->slide->ID,
                'post_excerpt' => $fields['post_excerpt'],
                'menu_order' => $fields['menu_order']
            ) );

        // store the URL as a meta field against the attachment
        $this->add_or_update_or_delete_meta( $this->slide->ID, 'url', $fields['url'] );

        $this->add_or_update_or_delete_meta( $this->slide->ID, 'title', $fields['title'] );

        $this->add_or_update_or_delete_meta( $this->slide->ID, 'crop_position', $fields['crop_position'] );

        if ( isset( $fields['alt'] ) ) {
            update_post_meta( $this->slide->ID, '_wp_attachment_image_alt', $fields['alt'] );
        }

        // store the 'new window' setting
        $new_window = isset( $fields['new_window'] ) && $fields['new_window'] == 'on' ? 'true' : 'false';

        $this->add_or_update_or_delete_meta( $this->slide->ID, 'new_window', $new_window );

    }
}