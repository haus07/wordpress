<?php
/**
 * Testimonials Section
 * 
 * slug: t-shirt-printing-shop/testimonials-section
 * title: Testimonials Section
 * categories: t-shirt-printing-shop
 */

return array(
    'title'      =>__( 'Testimonials Section', 't-shirt-printing-shop' ),
    'categories' => array( 't-shirt-printing-shop' ),
    'content'    => '<!-- wp:group {"className":"testimonials-section","style":{"spacing":{"blockGap":"var:preset|spacing|20","padding":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|20"}}},"backgroundColor":"fourthaccent","layout":{"type":"constrained","contentSize":"80%"}} -->
    <div class="wp-block-group testimonials-section has-fourthaccent-background-color has-background" style="padding-top:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--20)"><!-- wp:spacer {"height":"60px"} -->
    <div style="height:60px" aria-hidden="true" class="wp-block-spacer"></div>
    <!-- /wp:spacer -->

    <!-- wp:paragraph {"align":"center","style":{"elements":{"link":{"color":{"text":"var:preset|color|accent"}}},"typography":{"fontStyle":"normal","fontWeight":"400"}},"textColor":"accent","fontSize":"upper-heading","fontFamily":"bebas-neue"} -->
    <p class="has-text-align-center has-accent-color has-text-color has-link-color has-bebas-neue-font-family has-upper-heading-font-size" style="font-style:normal;font-weight:400">'. esc_html__('Testimonials','t-shirt-printing-shop').'</p>
    <!-- /wp:paragraph -->
    
    <!-- wp:heading {"textAlign":"center","style":{"typography":{"fontStyle":"normal","fontWeight":"600","fontSize":"26px"},"elements":{"link":{"color":{"text":"var:preset|color|primary"}}},"spacing":{"margin":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|30"}}},"textColor":"primary","fontFamily":"poppins"} -->
    <h2 class="wp-block-heading has-text-align-center has-primary-color has-text-color has-link-color has-poppins-font-family" style="margin-top:var(--wp--preset--spacing--30);margin-bottom:var(--wp--preset--spacing--30);font-size:26px;font-style:normal;font-weight:600">'. esc_html__('What Say Clients','t-shirt-printing-shop').'</h2>
    <!-- /wp:heading -->
    
    <!-- wp:columns {"className":"test-prev-next"} -->
    <div class="wp-block-columns test-prev-next"><!-- wp:column -->
    <div class="wp-block-column"><!-- wp:buttons {"className":"swiper-test-button","style":{"spacing":{"blockGap":{"top":"0"}}},"layout":{"type":"flex","justifyContent":"space-between"}} -->
    <div class="wp-block-buttons swiper-test-button"><!-- wp:button {"backgroundColor":"sixthaccent","className":"testimonial-swiper-button-prev","style":{"spacing":{"padding":{"left":"15px","right":"17px","top":"10px","bottom":"10px"}},"border":{"radius":"26px"}}} -->
    <div class="wp-block-button testimonial-swiper-button-prev"><a class="wp-block-button__link has-sixthaccent-background-color has-background wp-element-button" style="border-radius:26px;padding-top:10px;padding-right:17px;padding-bottom:10px;padding-left:15px"><img class="wp-image-132" style="width: 8px;" src="'.esc_url(get_template_directory_uri()) .'/assets/images/prev.png" alt=""></a></div>
    <!-- /wp:button -->
    
    <!-- wp:button {"backgroundColor":"sixthaccent","className":"testimonial-swiper-button-next","style":{"spacing":{"padding":{"left":"14px","right":"10px","top":"13px","bottom":"10px"}},"border":{"radius":"26px"},"typography":{"lineHeight":"1.1"}}} -->
    <div class="wp-block-button testimonial-swiper-button-next"><a class="wp-block-button__link has-sixthaccent-background-color has-background wp-element-button" style="border-radius:26px;padding-top:13px;padding-right:10px;padding-bottom:10px;padding-left:14px;line-height:1.1"><img class="wp-image-131" style="width: 16px;" src="'.esc_url(get_template_directory_uri()) .'/assets/images/next.png" alt=""></a></div>
    <!-- /wp:button --></div>
    <!-- /wp:buttons --></div>
    <!-- /wp:column --></div>
    <!-- /wp:columns -->
    
    <!-- wp:group {"className":"testimonial-swiper-slider mySwiper","style":{"spacing":{"margin":{"top":"var:preset|spacing|40"}}},"layout":{"type":"constrained","contentSize":"100%"}} -->
    <div class="wp-block-group testimonial-swiper-slider mySwiper" style="margin-top:var(--wp--preset--spacing--40)"><!-- wp:group {"className":"testimonials-slider swiper-wrapper","style":{"spacing":{"margin":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"},"blockGap":"0"}},"layout":{"type":"constrained","contentSize":"100%","wideSize":"100%"}} -->
    <div class="wp-block-group testimonials-slider swiper-wrapper" style="margin-top:var(--wp--preset--spacing--50);margin-bottom:var(--wp--preset--spacing--50)"><!-- wp:group {"className":"testimonials-slider-block swiper-slide","style":{"spacing":{"blockGap":"var:preset|spacing|30","padding":{"right":"var:preset|spacing|50","left":"var:preset|spacing|50","top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"}}},"backgroundColor":"background","layout":{"type":"constrained"}} -->
    <div class="wp-block-group testimonials-slider-block swiper-slide has-background-background-color has-background" style="padding-top:var(--wp--preset--spacing--50);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50);padding-left:var(--wp--preset--spacing--50)"><!-- wp:paragraph {"align":"center","style":{"typography":{"lineHeight":"1.7","fontStyle":"normal","fontWeight":"400"},"elements":{"link":{"color":{"text":"var:preset|color|primary"}}}},"textColor":"primary","fontSize":"extra-small"} -->
    <p class="has-text-align-center has-primary-color has-text-color has-link-color has-extra-small-font-size" style="font-style:normal;font-weight:400;line-height:1.7">'. esc_html__('Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown prpoppins took a galley of type and scrambled it to make a type specimen book.','t-shirt-printing-shop').'</p>
    <!-- /wp:paragraph -->
    
    <!-- wp:heading {"textAlign":"center","className":"testimonial-author-name","style":{"elements":{"link":{"color":{"text":"var:preset|color|primary"}}},"typography":{"fontStyle":"normal","fontWeight":"600"},"spacing":{"margin":{"top":"var:preset|spacing|40","bottom":"0"}}},"textColor":"primary","fontSize":"upper-heading"} -->
    <h2 class="wp-block-heading has-text-align-center testimonial-author-name has-primary-color has-text-color has-link-color has-upper-heading-font-size" style="margin-top:var(--wp--preset--spacing--40);margin-bottom:0;font-style:normal;font-weight:600">'. esc_html__('Jean Kalvin','t-shirt-printing-shop').'</h2>
    <!-- /wp:heading -->
    
    <!-- wp:paragraph {"align":"center","style":{"elements":{"link":{"color":{"text":"var:preset|color|primary"}}},"typography":{"fontStyle":"normal","fontWeight":"500"},"spacing":{"margin":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|20"}}},"textColor":"primary","fontSize":"extra-small"} -->
    <p class="has-text-align-center has-primary-color has-text-color has-link-color has-extra-small-font-size" style="margin-top:var(--wp--preset--spacing--20);margin-bottom:var(--wp--preset--spacing--20);font-style:normal;font-weight:500">'. esc_html__('Manager','t-shirt-printing-shop').'</p>
    <!-- /wp:paragraph --></div>
    <!-- /wp:group -->
    
    <!-- wp:group {"className":"testimonials-slider-block swiper-slide","style":{"spacing":{"blockGap":"var:preset|spacing|30","padding":{"right":"var:preset|spacing|50","left":"var:preset|spacing|50","top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"}}},"backgroundColor":"background","layout":{"type":"constrained"}} -->
    <div class="wp-block-group testimonials-slider-block swiper-slide has-background-background-color has-background" style="padding-top:var(--wp--preset--spacing--50);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50);padding-left:var(--wp--preset--spacing--50)"><!-- wp:paragraph {"align":"center","style":{"typography":{"lineHeight":"1.7","fontStyle":"normal","fontWeight":"400"},"elements":{"link":{"color":{"text":"var:preset|color|primary"}}}},"textColor":"primary","fontSize":"extra-small"} -->
    <p class="has-text-align-center has-primary-color has-text-color has-link-color has-extra-small-font-size" style="font-style:normal;font-weight:400;line-height:1.7">'. esc_html__('Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown prpoppins took a galley of type and scrambled it to make a type specimen book.','t-shirt-printing-shop').'</p>
    <!-- /wp:paragraph -->
    
    <!-- wp:heading {"textAlign":"center","className":"testimonial-author-name","style":{"elements":{"link":{"color":{"text":"var:preset|color|primary"}}},"typography":{"fontStyle":"normal","fontWeight":"600"},"spacing":{"margin":{"top":"var:preset|spacing|40","bottom":"0"}}},"textColor":"primary","fontSize":"upper-heading"} -->
    <h2 class="wp-block-heading has-text-align-center testimonial-author-name has-primary-color has-text-color has-link-color has-upper-heading-font-size" style="margin-top:var(--wp--preset--spacing--40);margin-bottom:0;font-style:normal;font-weight:600">'. esc_html__('Alex Morgan','t-shirt-printing-shop').'</h2>
    <!-- /wp:heading -->
    
    <!-- wp:paragraph {"align":"center","style":{"elements":{"link":{"color":{"text":"var:preset|color|primary"}}},"typography":{"fontStyle":"normal","fontWeight":"500"},"spacing":{"margin":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|20"}}},"textColor":"primary","fontSize":"extra-small"} -->
    <p class="has-text-align-center has-primary-color has-text-color has-link-color has-extra-small-font-size" style="margin-top:var(--wp--preset--spacing--20);margin-bottom:var(--wp--preset--spacing--20);font-style:normal;font-weight:500">'. esc_html__('CEO','t-shirt-printing-shop').'</p>
    <!-- /wp:paragraph --></div>
    <!-- /wp:group -->
    
    <!-- wp:group {"className":"testimonials-slider-block swiper-slide","style":{"spacing":{"blockGap":"var:preset|spacing|30","padding":{"right":"var:preset|spacing|50","left":"var:preset|spacing|50","top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"}}},"backgroundColor":"background","layout":{"type":"constrained"}} -->
    <div class="wp-block-group testimonials-slider-block swiper-slide has-background-background-color has-background" style="padding-top:var(--wp--preset--spacing--50);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50);padding-left:var(--wp--preset--spacing--50)"><!-- wp:paragraph {"align":"center","style":{"typography":{"lineHeight":"1.7","fontStyle":"normal","fontWeight":"400"},"elements":{"link":{"color":{"text":"var:preset|color|primary"}}}},"textColor":"primary","fontSize":"extra-small"} -->
    <p class="has-text-align-center has-primary-color has-text-color has-link-color has-extra-small-font-size" style="font-style:normal;font-weight:400;line-height:1.7">'. esc_html__('Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown prpoppins took a galley of type and scrambled it to make a type specimen book.','t-shirt-printing-shop').'</p>
    <!-- /wp:paragraph -->
    
    <!-- wp:heading {"textAlign":"center","className":"testimonial-author-name","style":{"elements":{"link":{"color":{"text":"var:preset|color|primary"}}},"typography":{"fontStyle":"normal","fontWeight":"600"},"spacing":{"margin":{"top":"var:preset|spacing|40","bottom":"0"}}},"textColor":"primary","fontSize":"upper-heading"} -->
    <h2 class="wp-block-heading has-text-align-center testimonial-author-name has-primary-color has-text-color has-link-color has-upper-heading-font-size" style="margin-top:var(--wp--preset--spacing--40);margin-bottom:0;font-style:normal;font-weight:600">'. esc_html__('Jordan Blake','t-shirt-printing-shop').'</h2>
    <!-- /wp:heading -->
    
    <!-- wp:paragraph {"align":"center","style":{"elements":{"link":{"color":{"text":"var:preset|color|primary"}}},"typography":{"fontStyle":"normal","fontWeight":"500"},"spacing":{"margin":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|20"}}},"textColor":"primary","fontSize":"extra-small"} -->
    <p class="has-text-align-center has-primary-color has-text-color has-link-color has-extra-small-font-size" style="margin-top:var(--wp--preset--spacing--20);margin-bottom:var(--wp--preset--spacing--20);font-style:normal;font-weight:500">'. esc_html__('Director','t-shirt-printing-shop').'</p>
    <!-- /wp:paragraph --></div>
    <!-- /wp:group -->
    
    <!-- wp:group {"className":"testimonials-slider-block swiper-slide","style":{"spacing":{"blockGap":"var:preset|spacing|30","padding":{"right":"var:preset|spacing|50","left":"var:preset|spacing|50","top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"}}},"backgroundColor":"background","layout":{"type":"constrained"}} -->
    <div class="wp-block-group testimonials-slider-block swiper-slide has-background-background-color has-background" style="padding-top:var(--wp--preset--spacing--50);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50);padding-left:var(--wp--preset--spacing--50)"><!-- wp:paragraph {"align":"center","style":{"typography":{"lineHeight":"1.7","fontStyle":"normal","fontWeight":"400"},"elements":{"link":{"color":{"text":"var:preset|color|primary"}}}},"textColor":"primary","fontSize":"extra-small"} -->
    <p class="has-text-align-center has-primary-color has-text-color has-link-color has-extra-small-font-size" style="font-style:normal;font-weight:400;line-height:1.7">'. esc_html__('Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown prpoppins took a galley of type and scrambled it to make a type specimen book.','t-shirt-printing-shop').'</p>
    <!-- /wp:paragraph -->
    
    <!-- wp:heading {"textAlign":"center","className":"testimonial-author-name","style":{"elements":{"link":{"color":{"text":"var:preset|color|primary"}}},"typography":{"fontStyle":"normal","fontWeight":"600"},"spacing":{"margin":{"top":"var:preset|spacing|40","bottom":"0"}}},"textColor":"primary","fontSize":"upper-heading"} -->
    <h2 class="wp-block-heading has-text-align-center testimonial-author-name has-primary-color has-text-color has-link-color has-upper-heading-font-size" style="margin-top:var(--wp--preset--spacing--40);margin-bottom:0;font-style:normal;font-weight:600">'. esc_html__('Taylor Reed','t-shirt-printing-shop').'</h2>
    <!-- /wp:heading -->
    
    <!-- wp:paragraph {"align":"center","style":{"elements":{"link":{"color":{"text":"var:preset|color|primary"}}},"typography":{"fontStyle":"normal","fontWeight":"500"},"spacing":{"margin":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|20"}}},"textColor":"primary","fontSize":"extra-small"} -->
    <p class="has-text-align-center has-primary-color has-text-color has-link-color has-extra-small-font-size" style="margin-top:var(--wp--preset--spacing--20);margin-bottom:var(--wp--preset--spacing--20);font-style:normal;font-weight:500">'. esc_html__('Product Manager','t-shirt-printing-shop').'</p>
    <!-- /wp:paragraph --></div>
    <!-- /wp:group -->
    
    <!-- wp:group {"className":"testimonials-slider-block swiper-slide","style":{"spacing":{"blockGap":"var:preset|spacing|30","padding":{"right":"var:preset|spacing|50","left":"var:preset|spacing|50","top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"}}},"backgroundColor":"background","layout":{"type":"constrained"}} -->
    <div class="wp-block-group testimonials-slider-block swiper-slide has-background-background-color has-background" style="padding-top:var(--wp--preset--spacing--50);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50);padding-left:var(--wp--preset--spacing--50)"><!-- wp:paragraph {"align":"center","style":{"typography":{"lineHeight":"1.7","fontStyle":"normal","fontWeight":"400"},"elements":{"link":{"color":{"text":"var:preset|color|primary"}}}},"textColor":"primary","fontSize":"extra-small"} -->
    <p class="has-text-align-center has-primary-color has-text-color has-link-color has-extra-small-font-size" style="font-style:normal;font-weight:400;line-height:1.7">'. esc_html__('Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown prpoppins took a galley of type and scrambled it to make a type specimen book.','t-shirt-printing-shop').'</p>
    <!-- /wp:paragraph -->
    
    <!-- wp:heading {"textAlign":"center","className":"testimonial-author-name","style":{"elements":{"link":{"color":{"text":"var:preset|color|primary"}}},"typography":{"fontStyle":"normal","fontWeight":"600"},"spacing":{"margin":{"top":"var:preset|spacing|40","bottom":"0"}}},"textColor":"primary","fontSize":"upper-heading"} -->
    <h2 class="wp-block-heading has-text-align-center testimonial-author-name has-primary-color has-text-color has-link-color has-upper-heading-font-size" style="margin-top:var(--wp--preset--spacing--40);margin-bottom:0;font-style:normal;font-weight:600">'. esc_html__('Testimonials','t-shirt-printing-shop').'</h2>
    <!-- /wp:heading -->
    
    <!-- wp:paragraph {"align":"center","style":{"elements":{"link":{"color":{"text":"var:preset|color|primary"}}},"typography":{"fontStyle":"normal","fontWeight":"500"},"spacing":{"margin":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|20"}}},"textColor":"primary","fontSize":"extra-small"} -->
    <p class="has-text-align-center has-primary-color has-text-color has-link-color has-extra-small-font-size" style="margin-top:var(--wp--preset--spacing--20);margin-bottom:var(--wp--preset--spacing--20);font-style:normal;font-weight:500">'. esc_html__('Operations Manager','t-shirt-printing-shop').'</p>
    <!-- /wp:paragraph --></div>
    <!-- /wp:group -->
    
    <!-- wp:group {"className":"testimonials-slider-block swiper-slide","style":{"spacing":{"blockGap":"var:preset|spacing|30","padding":{"right":"var:preset|spacing|50","left":"var:preset|spacing|50","top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"}}},"backgroundColor":"background","layout":{"type":"constrained"}} -->
    <div class="wp-block-group testimonials-slider-block swiper-slide has-background-background-color has-background" style="padding-top:var(--wp--preset--spacing--50);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50);padding-left:var(--wp--preset--spacing--50)"><!-- wp:paragraph {"align":"center","style":{"typography":{"lineHeight":"1.7","fontStyle":"normal","fontWeight":"400"},"elements":{"link":{"color":{"text":"var:preset|color|primary"}}}},"textColor":"primary","fontSize":"extra-small"} -->
    <p class="has-text-align-center has-primary-color has-text-color has-link-color has-extra-small-font-size" style="font-style:normal;font-weight:400;line-height:1.7">'. esc_html__('Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown prpoppins took a galley of type and scrambled it to make a type specimen book.','t-shirt-printing-shop').'</p>
    <!-- /wp:paragraph -->
    
    <!-- wp:heading {"textAlign":"center","className":"testimonial-author-name","style":{"elements":{"link":{"color":{"text":"var:preset|color|primary"}}},"typography":{"fontStyle":"normal","fontWeight":"600"},"spacing":{"margin":{"top":"var:preset|spacing|40","bottom":"0"}}},"textColor":"primary","fontSize":"upper-heading"} -->
    <h2 class="wp-block-heading has-text-align-center testimonial-author-name has-primary-color has-text-color has-link-color has-upper-heading-font-size" style="margin-top:var(--wp--preset--spacing--40);margin-bottom:0;font-style:normal;font-weight:600">'. esc_html__('Nikita Kalvin','t-shirt-printing-shop').'</h2>
    <!-- /wp:heading -->
    
    <!-- wp:paragraph {"align":"center","style":{"elements":{"link":{"color":{"text":"var:preset|color|primary"}}},"typography":{"fontStyle":"normal","fontWeight":"500"},"spacing":{"margin":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|20"}}},"textColor":"primary","fontSize":"extra-small"} -->
    <p class="has-text-align-center has-primary-color has-text-color has-link-color has-extra-small-font-size" style="margin-top:var(--wp--preset--spacing--20);margin-bottom:var(--wp--preset--spacing--20);font-style:normal;font-weight:500">'. esc_html__('CEO','t-shirt-printing-shop').'</p>
    <!-- /wp:paragraph --></div>
    <!-- /wp:group --></div>
    <!-- /wp:group --></div>
    <!-- /wp:group -->
    
    <!-- wp:spacer {"height":"65px"} -->
    <div style="height:65px" aria-hidden="true" class="wp-block-spacer"></div>
    <!-- /wp:spacer --></div>
    <!-- /wp:group -->',
);