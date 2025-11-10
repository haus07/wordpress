<?php
/**
 * Vlog Section
 * 
 * slug: t-shirt-printing-shop/vlog-section
 * title: Vlog Section
 * categories: t-shirt-printing-shop
 */

 $t_shirt_printing_shop_plugins_list = get_option('active_plugins');
  $t_shirt_printing_shop_woocommerce_plugin = 'woocommerce/woocommerce.php';
 $t_shirt_printing_shop_results = in_array($t_shirt_printing_shop_woocommerce_plugin, $t_shirt_printing_shop_plugins_list) ;
 
 if ($t_shirt_printing_shop_results) {
    return array(
        'title'      =>__( 'Vlog Section', 't-shirt-printing-shop' ),
        'categories' => array( 't-shirt-printing-shop' ),
        'content'    => '<!-- wp:spacer {"height":"40px"} -->
<div style="height:40px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<!-- wp:group {"layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group"><!-- wp:heading {"textAlign":"left","className":"heading-product","style":{"elements":{"link":{"color":{"text":"var:preset|color|accent"}}},"typography":{"fontSize":"29px"},"spacing":{"padding":{"right":"var:preset|spacing|50"}}},"textColor":"accent","fontFamily":"bebas-neue"} -->
<h2 class="wp-block-heading has-text-align-left heading-product has-accent-color has-text-color has-link-color has-bebas-neue-font-family" style="padding-right:var(--wp--preset--spacing--50);font-size:29px">'. esc_html__('Our Best-Selling Bulk T-Shirts','t-shirt-printing-shop').'</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"var:preset|color|tertiary"}}}},"textColor":"tertiary","fontSize":"medium"} -->
<p class="has-tertiary-color has-text-color has-link-color has-medium-font-size">'. esc_html__('Choose from our most popular styles, perfect for large group orders and corporate events.','t-shirt-printing-shop').'</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:woocommerce/product-collection {"queryId":0,"query":{"perPage":4,"pages":0,"offset":0,"postType":"product","order":"asc","orderBy":"title","search":"","exclude":[],"inherit":false,"taxQuery":[],"isProductCollectionBlock":true,"featured":false,"woocommerceOnSale":false,"woocommerceStockStatus":["instock","outofstock","onbackorder"],"woocommerceAttributes":[],"woocommerceHandPickedProducts":[],"filterable":true,"relatedBy":{"categories":true,"tags":true}},"tagName":"div","displayLayout":{"type":"flex","columns":4,"shrinkColumns":true},"dimensions":{"widthType":"fill"},"queryContextIncludes":["collection"],"forcePageReload":true,"__privatePreviewState":{"isPreview":false,"previewMessage":"Actual products will vary depending on the page being viewed."},"className":"dynamic-product-section  wow zoomIn"} -->
<div class="wp-block-woocommerce-product-collection dynamic-product-section  wow zoomIn"><!-- wp:woocommerce/product-template {"className":"product-static-col"} -->
<!-- wp:group {"className":"product-image-group","style":{"spacing":{"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group product-image-group" style="margin-top:0;margin-bottom:0"><!-- wp:woocommerce/product-image {"showSaleBadge":false,"imageSizing":"thumbnail","isDescendentOfQueryLoop":true} /--></div>
<!-- /wp:group -->

<!-- wp:group {"className":"product-content-group","style":{"spacing":{"padding":{"right":"var:preset|spacing|30","left":"var:preset|spacing|30","top":"var:preset|spacing|30","bottom":"var:preset|spacing|30"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group product-content-group" style="padding-top:var(--wp--preset--spacing--30);padding-right:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--30);padding-left:var(--wp--preset--spacing--30)"><!-- wp:post-title {"textAlign":"left","isLink":true,"style":{"spacing":{"margin":{"bottom":"0.75rem","top":"0"}},"typography":{"lineHeight":"1.4","fontStyle":"normal","fontWeight":"500"},"elements":{"link":{"color":{"text":"var:preset|color|tertiary"}}}},"textColor":"tertiary","fontSize":"medium","__woocommerceNamespace":"woocommerce/product-collection/product-title"} /-->

<!-- wp:woocommerce/product-summary {"isDescendentOfQueryLoop":true,"showDescriptionIfEmpty":true,"summaryLength":14,"textColor":"tertiary","style":{"elements":{"link":{"color":{"text":"var:preset|color|tertiary"}}}}} /-->

<!-- wp:woocommerce/product-specifications {"showWeight":false,"showDimensions":false} /-->

<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20","margin":{"top":"0","bottom":"0"}}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
<div class="wp-block-group" style="margin-top:0;margin-bottom:0"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","flexWrap":"wrap"}} -->
<div class="wp-block-group"><!-- wp:heading {"style":{"elements":{"link":{"color":{"text":"var:preset|color|primary"}}},"typography":{"fontStyle":"normal","fontWeight":"500"}},"textColor":"primary","fontSize":"medium"} -->
<h2 class="wp-block-heading has-primary-color has-text-color has-link-color has-medium-font-size" style="font-style:normal;font-weight:500">Reviews :</h2>
<!-- /wp:heading -->

<!-- wp:woocommerce/product-rating {"isDescendentOfQueryLoop":true,"style":{"color":{"text":"#ffc107"},"elements":{"link":{"color":{"text":"#ffc107"}}},"spacing":{"padding":{"right":"0","left":"0"},"margin":{"right":"0","left":"0"}}}} /--></div>
<!-- /wp:group -->

<!-- wp:woocommerce/product-button {"textAlign":"center","isDescendentOfQueryLoop":true,"fontSize":"small"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
<!-- /wp:woocommerce/product-template --></div>
<!-- /wp:woocommerce/product-collection -->

<!-- wp:spacer {"height":"40px"} -->
<div style="height:40px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->',
    );

} else {
    return array(
        'title'      =>__( 'Vlog Section', 't-shirt-printing-shop' ),
        'categories' => array( 't-shirt-printing-shop' ),
        'content'    => '<!-- wp:spacer {"height":"40px"} -->
<div style="height:40px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<!-- wp:group {"layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group"><!-- wp:heading {"textAlign":"left","className":"heading-product","style":{"elements":{"link":{"color":{"text":"var:preset|color|accent"}}},"typography":{"fontSize":"29px"},"spacing":{"padding":{"right":"var:preset|spacing|50"}}},"textColor":"accent","fontFamily":"bebas-neue"} -->
<h2 class="wp-block-heading has-text-align-left heading-product has-accent-color has-text-color has-link-color has-bebas-neue-font-family" style="padding-right:var(--wp--preset--spacing--50);font-size:29px">'. esc_html__('Our Best-Selling Bulk T-Shirts','t-shirt-printing-shop').'</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"var:preset|color|tertiary"}}}},"textColor":"tertiary","fontSize":"medium"} -->
<p class="has-tertiary-color has-text-color has-link-color has-medium-font-size">'. esc_html__('Choose from our most popular styles, perfect for large group orders and corporate events.','t-shirt-printing-shop').'</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:columns {"verticalAlignment":null,"className":"static-product-section-inner wow zoomIn","style":{"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"margin":{"top":"var:preset|spacing|50"}}}} -->
<div class="wp-block-columns static-product-section-inner wow zoomIn" style="margin-top:var(--wp--preset--spacing--50);padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:column {"className":"static-product-col","style":{"spacing":{"blockGap":"0"},"border":{"width":"7px"}},"borderColor":"background"} -->
<div class="wp-block-column static-product-col has-border-color has-background-border-color" style="border-width:7px"><!-- wp:group {"className":"static-product-group01","layout":{"type":"constrained"}} -->
<div class="wp-block-group static-product-group01"><!-- wp:image {"id":80,"sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full"><img src="'.esc_url(get_template_directory_uri()) .'/assets/images/product01.png" alt="" class="wp-image-80"/></figure>
<!-- /wp:image --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"static-product-group02","style":{"border":{"top":{"color":"var:preset|color|background","width":"7px"},"right":[],"bottom":[],"left":[]},"spacing":{"padding":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|20","left":"var:preset|spacing|20","right":"var:preset|spacing|20"},"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group static-product-group02" style="border-top-color:var(--wp--preset--color--background);border-top-width:7px;padding-top:var(--wp--preset--spacing--20);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--20);padding-left:var(--wp--preset--spacing--20)"><!-- wp:heading {"style":{"elements":{"link":{"color":{"text":"var:preset|color|tertiary"}}},"typography":{"fontStyle":"normal","fontWeight":"500"}},"textColor":"tertiary","fontSize":"small"} -->
<h2 class="wp-block-heading has-tertiary-color has-text-color has-link-color has-small-font-size" style="font-style:normal;font-weight:500">'. esc_html__('Motivational Vibes Tee','t-shirt-printing-shop').'</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"typography":{"fontStyle":"normal","fontWeight":"400"}},"fontSize":"small"} -->
<p class="has-small-font-size" style="font-style:normal;font-weight:400">'. esc_html__('Soft cotton tee with a retro beach .','t-shirt-printing-shop').'</p>
<!-- /wp:paragraph -->

<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","flexWrap":"wrap"}} -->
<div class="wp-block-group"><!-- wp:heading {"style":{"elements":{"link":{"color":{"text":"var:preset|color|primary"}}}},"textColor":"primary","fontSize":"medium"} -->
<h2 class="wp-block-heading has-primary-color has-text-color has-link-color has-medium-font-size">'. esc_html__('Add Quantity','t-shirt-printing-shop').'</h2>
<!-- /wp:heading -->

<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","flexWrap":"wrap"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"className":"quantity-value","style":{"layout":{"selfStretch":"fit","flexSize":null},"elements":{"link":{"color":{"text":"var:preset|color|accent"}}},"spacing":{"padding":{"top":"5px","bottom":"5px","left":"8px","right":"8px"}},"border":{"radius":"50%"}},"backgroundColor":"background","textColor":"accent"} -->
<p class="quantity-value has-accent-color has-background-background-color has-text-color has-background has-link-color" style="border-radius:50%;padding-top:5px;padding-right:8px;padding-bottom:5px;padding-left:8px">'. esc_html__('25','t-shirt-printing-shop').'</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"quantity-value","style":{"layout":{"selfStretch":"fit","flexSize":null},"elements":{"link":{"color":{"text":"var:preset|color|accent"}}},"spacing":{"padding":{"top":"5px","bottom":"5px","left":"8px","right":"8px"}},"border":{"radius":"50%"}},"backgroundColor":"background","textColor":"accent"} -->
<p class="quantity-value has-accent-color has-background-background-color has-text-color has-background has-link-color" style="border-radius:50%;padding-top:5px;padding-right:8px;padding-bottom:5px;padding-left:8px">'. esc_html__('50','t-shirt-printing-shop').'</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"quantity-value","style":{"layout":{"selfStretch":"fit","flexSize":null},"elements":{"link":{"color":{"text":"var:preset|color|accent"}}},"spacing":{"padding":{"top":"5px","bottom":"5px","left":"11px","right":"11px"}},"border":{"radius":"50%"}},"backgroundColor":"background","textColor":"accent"} -->
<p class="quantity-value has-accent-color has-background-background-color has-text-color has-background has-link-color" style="border-radius:50%;padding-top:5px;padding-right:11px;padding-bottom:5px;padding-left:11px">'. esc_html__('75','t-shirt-printing-shop').'</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
<div class="wp-block-group"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","flexWrap":"wrap"}} -->
<div class="wp-block-group"><!-- wp:heading {"style":{"elements":{"link":{"color":{"text":"var:preset|color|primary"}}},"typography":{"fontStyle":"normal","fontWeight":"400"}},"textColor":"primary","fontSize":"medium"} -->
<h2 class="wp-block-heading has-primary-color has-text-color has-link-color has-medium-font-size" style="font-style:normal;font-weight:400">'. esc_html__('Reviews :','t-shirt-printing-shop').'</h2>
<!-- /wp:heading -->

<!-- wp:image {"id":101,"width":"95px","height":"auto","sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full is-resized"><img src="'.esc_url(get_template_directory_uri()) .'/assets/images/star.png" alt="" class="wp-image-101" style="width:95px;height:auto"/></figure>
<!-- /wp:image --></div>
<!-- /wp:group -->

<!-- wp:buttons {"className":"static-buy-now","style":{"spacing":{"margin":{"top":"0","bottom":"0"}}}} -->
<div class="wp-block-buttons static-buy-now" style="margin-top:0;margin-bottom:0"><!-- wp:button {"backgroundColor":"secaccent","textColor":"background","style":{"elements":{"link":{"color":{"text":"var:preset|color|background"}}},"spacing":{"padding":{"left":"var:preset|spacing|40","right":"var:preset|spacing|40","top":"var:preset|spacing|20","bottom":"var:preset|spacing|20"}},"border":{"radius":"20px","width":"1px"}},"fontSize":"small","borderColor":"background"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-background-color has-secaccent-background-color has-text-color has-background has-link-color has-border-color has-background-border-color has-small-font-size has-custom-font-size wp-element-button" style="border-width:1px;border-radius:20px;padding-top:var(--wp--preset--spacing--20);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--20);padding-left:var(--wp--preset--spacing--40)">'. esc_html__('Select Options','t-shirt-printing-shop').'<img class="wp-image-116" style="width: 14px;" src="'.esc_url(get_template_directory_uri()) .'/assets/images/cart.png" alt=""></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"className":"static-product-col","style":{"spacing":{"blockGap":"0"},"border":{"width":"7px"}},"borderColor":"background"} -->
<div class="wp-block-column static-product-col has-border-color has-background-border-color" style="border-width:7px"><!-- wp:group {"className":"static-product-group01","layout":{"type":"constrained"}} -->
<div class="wp-block-group static-product-group01"><!-- wp:image {"id":81,"sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full"><img src="'.esc_url(get_template_directory_uri()) .'/assets/images/product02.png" alt="" class="wp-image-81"/></figure>
<!-- /wp:image --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"static-product-group02","style":{"border":{"top":{"color":"var:preset|color|background","width":"7px"},"right":[],"bottom":[],"left":[]},"spacing":{"padding":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|20","left":"var:preset|spacing|20","right":"var:preset|spacing|20"},"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group static-product-group02" style="border-top-color:var(--wp--preset--color--background);border-top-width:7px;padding-top:var(--wp--preset--spacing--20);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--20);padding-left:var(--wp--preset--spacing--20)"><!-- wp:heading {"style":{"elements":{"link":{"color":{"text":"var:preset|color|tertiary"}}},"typography":{"fontStyle":"normal","fontWeight":"500"}},"textColor":"tertiary","fontSize":"small"} -->
<h2 class="wp-block-heading has-tertiary-color has-text-color has-link-color has-small-font-size" style="font-style:normal;font-weight:500">'. esc_html__('Classic Crewneck Tee','t-shirt-printing-shop').'</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"typography":{"fontStyle":"normal","fontWeight":"400"}},"fontSize":"small"} -->
<p class="has-small-font-size" style="font-style:normal;font-weight:400">'. esc_html__('Soft cotton tee with a retro beach .','t-shirt-printing-shop').'</p>
<!-- /wp:paragraph -->

<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","flexWrap":"wrap"}} -->
<div class="wp-block-group"><!-- wp:heading {"style":{"elements":{"link":{"color":{"text":"var:preset|color|primary"}}}},"textColor":"primary","fontSize":"medium"} -->
<h2 class="wp-block-heading has-primary-color has-text-color has-link-color has-medium-font-size">'. esc_html__('Add Quantity','t-shirt-printing-shop').'</h2>
<!-- /wp:heading -->

<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","flexWrap":"wrap"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"className":"quantity-value","style":{"layout":{"selfStretch":"fit","flexSize":null},"elements":{"link":{"color":{"text":"var:preset|color|accent"}}},"spacing":{"padding":{"top":"5px","bottom":"5px","left":"8px","right":"8px"}},"border":{"radius":"50%"}},"backgroundColor":"background","textColor":"accent"} -->
<p class="quantity-value has-accent-color has-background-background-color has-text-color has-background has-link-color" style="border-radius:50%;padding-top:5px;padding-right:8px;padding-bottom:5px;padding-left:8px">'. esc_html__('25','t-shirt-printing-shop').'</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"quantity-value","style":{"layout":{"selfStretch":"fit","flexSize":null},"elements":{"link":{"color":{"text":"var:preset|color|accent"}}},"spacing":{"padding":{"top":"5px","bottom":"5px","left":"8px","right":"8px"}},"border":{"radius":"50%"}},"backgroundColor":"background","textColor":"accent"} -->
<p class="quantity-value has-accent-color has-background-background-color has-text-color has-background has-link-color" style="border-radius:50%;padding-top:5px;padding-right:8px;padding-bottom:5px;padding-left:8px">'. esc_html__('50','t-shirt-printing-shop').'</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"quantity-value","style":{"layout":{"selfStretch":"fit","flexSize":null},"elements":{"link":{"color":{"text":"var:preset|color|accent"}}},"spacing":{"padding":{"top":"5px","bottom":"5px","left":"11px","right":"11px"}},"border":{"radius":"50%"}},"backgroundColor":"background","textColor":"accent"} -->
<p class="quantity-value has-accent-color has-background-background-color has-text-color has-background has-link-color" style="border-radius:50%;padding-top:5px;padding-right:11px;padding-bottom:5px;padding-left:11px">'. esc_html__('75','t-shirt-printing-shop').'</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
<div class="wp-block-group"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","flexWrap":"wrap"}} -->
<div class="wp-block-group"><!-- wp:heading {"style":{"elements":{"link":{"color":{"text":"var:preset|color|primary"}}},"typography":{"fontStyle":"normal","fontWeight":"400"}},"textColor":"primary","fontSize":"medium"} -->
<h2 class="wp-block-heading has-primary-color has-text-color has-link-color has-medium-font-size" style="font-style:normal;font-weight:400">'. esc_html__('Reviews :','t-shirt-printing-shop').'</h2>
<!-- /wp:heading -->

<!-- wp:image {"id":101,"width":"95px","height":"auto","sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full is-resized"><img src="'.esc_url(get_template_directory_uri()) .'/assets/images/star.png" alt="" class="wp-image-101" style="width:95px;height:auto"/></figure>
<!-- /wp:image --></div>
<!-- /wp:group -->

<!-- wp:buttons {"className":"static-buy-now","style":{"spacing":{"margin":{"top":"0","bottom":"0"}}}} -->
<div class="wp-block-buttons static-buy-now" style="margin-top:0;margin-bottom:0"><!-- wp:button {"backgroundColor":"secaccent","textColor":"background","style":{"elements":{"link":{"color":{"text":"var:preset|color|background"}}},"spacing":{"padding":{"left":"var:preset|spacing|40","right":"var:preset|spacing|40","top":"var:preset|spacing|20","bottom":"var:preset|spacing|20"}},"border":{"radius":"20px","width":"1px"}},"fontSize":"small","borderColor":"background"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-background-color has-secaccent-background-color has-text-color has-background has-link-color has-border-color has-background-border-color has-small-font-size has-custom-font-size wp-element-button" style="border-width:1px;border-radius:20px;padding-top:var(--wp--preset--spacing--20);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--20);padding-left:var(--wp--preset--spacing--40)">'. esc_html__('Select Options ','t-shirt-printing-shop').'<img class="wp-image-116" style="width: 14px;" src="'.esc_url(get_template_directory_uri()) .'/assets/images/cart.png" alt=""></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"className":"static-product-col","style":{"spacing":{"blockGap":"0"},"border":{"width":"7px"}},"borderColor":"background"} -->
<div class="wp-block-column static-product-col has-border-color has-background-border-color" style="border-width:7px"><!-- wp:group {"className":"static-product-group01","layout":{"type":"constrained"}} -->
<div class="wp-block-group static-product-group01"><!-- wp:image {"id":82,"sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full"><img src="'.esc_url(get_template_directory_uri()) .'/assets/images/product03.png" alt="" class="wp-image-82"/></figure>
<!-- /wp:image --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"static-product-group02","style":{"border":{"top":{"color":"var:preset|color|background","width":"7px"},"right":[],"bottom":[],"left":[]},"spacing":{"padding":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|20","left":"var:preset|spacing|20","right":"var:preset|spacing|20"},"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group static-product-group02" style="border-top-color:var(--wp--preset--color--background);border-top-width:7px;padding-top:var(--wp--preset--spacing--20);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--20);padding-left:var(--wp--preset--spacing--20)"><!-- wp:heading {"style":{"elements":{"link":{"color":{"text":"var:preset|color|tertiary"}}},"typography":{"fontStyle":"normal","fontWeight":"500"}},"textColor":"tertiary","fontSize":"small"} -->
<h2 class="wp-block-heading has-tertiary-color has-text-color has-link-color has-small-font-size" style="font-style:normal;font-weight:500">'. esc_html__('Everyday Comfort Tee','t-shirt-printing-shop').'</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"typography":{"fontStyle":"normal","fontWeight":"400"}},"fontSize":"small"} -->
<p class="has-small-font-size" style="font-style:normal;font-weight:400">'. esc_html__('Soft cotton tee with a retro beach .','t-shirt-printing-shop').'</p>
<!-- /wp:paragraph -->

<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","flexWrap":"wrap"}} -->
<div class="wp-block-group"><!-- wp:heading {"style":{"elements":{"link":{"color":{"text":"var:preset|color|primary"}}}},"textColor":"primary","fontSize":"medium"} -->
<h2 class="wp-block-heading has-primary-color has-text-color has-link-color has-medium-font-size">'. esc_html__('Add Quantity','t-shirt-printing-shop').'</h2>
<!-- /wp:heading -->

<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","flexWrap":"wrap"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"className":"quantity-value","style":{"layout":{"selfStretch":"fit","flexSize":null},"elements":{"link":{"color":{"text":"var:preset|color|accent"}}},"spacing":{"padding":{"top":"5px","bottom":"5px","left":"8px","right":"8px"}},"border":{"radius":"50%"}},"backgroundColor":"background","textColor":"accent"} -->
<p class="quantity-value has-accent-color has-background-background-color has-text-color has-background has-link-color" style="border-radius:50%;padding-top:5px;padding-right:8px;padding-bottom:5px;padding-left:8px">'. esc_html__('25','t-shirt-printing-shop').'</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"quantity-value","style":{"layout":{"selfStretch":"fit","flexSize":null},"elements":{"link":{"color":{"text":"var:preset|color|accent"}}},"spacing":{"padding":{"top":"5px","bottom":"5px","left":"8px","right":"8px"}},"border":{"radius":"50%"}},"backgroundColor":"background","textColor":"accent"} -->
<p class="quantity-value has-accent-color has-background-background-color has-text-color has-background has-link-color" style="border-radius:50%;padding-top:5px;padding-right:8px;padding-bottom:5px;padding-left:8px">'. esc_html__('50','t-shirt-printing-shop').'</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"quantity-value","style":{"layout":{"selfStretch":"fit","flexSize":null},"elements":{"link":{"color":{"text":"var:preset|color|accent"}}},"spacing":{"padding":{"top":"5px","bottom":"5px","left":"11px","right":"11px"}},"border":{"radius":"50%"}},"backgroundColor":"background","textColor":"accent"} -->
<p class="quantity-value has-accent-color has-background-background-color has-text-color has-background has-link-color" style="border-radius:50%;padding-top:5px;padding-right:11px;padding-bottom:5px;padding-left:11px">'. esc_html__('75','t-shirt-printing-shop').'</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
<div class="wp-block-group"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","flexWrap":"wrap"}} -->
<div class="wp-block-group"><!-- wp:heading {"style":{"elements":{"link":{"color":{"text":"var:preset|color|primary"}}},"typography":{"fontStyle":"normal","fontWeight":"400"}},"textColor":"primary","fontSize":"medium"} -->
<h2 class="wp-block-heading has-primary-color has-text-color has-link-color has-medium-font-size" style="font-style:normal;font-weight:400">'. esc_html__('Reviews :','t-shirt-printing-shop').'</h2>
<!-- /wp:heading -->

<!-- wp:image {"id":101,"width":"95px","height":"auto","sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full is-resized"><img src="'.esc_url(get_template_directory_uri()) .'/assets/images/star.png" alt="" class="wp-image-101" style="width:95px;height:auto"/></figure>
<!-- /wp:image --></div>
<!-- /wp:group -->

<!-- wp:buttons {"className":"static-buy-now","style":{"spacing":{"margin":{"top":"0","bottom":"0"}}}} -->
<div class="wp-block-buttons static-buy-now" style="margin-top:0;margin-bottom:0"><!-- wp:button {"backgroundColor":"secaccent","textColor":"background","style":{"elements":{"link":{"color":{"text":"var:preset|color|background"}}},"spacing":{"padding":{"left":"var:preset|spacing|40","right":"var:preset|spacing|40","top":"var:preset|spacing|20","bottom":"var:preset|spacing|20"}},"border":{"radius":"20px","width":"1px"}},"fontSize":"small","borderColor":"background"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-background-color has-secaccent-background-color has-text-color has-background has-link-color has-border-color has-background-border-color has-small-font-size has-custom-font-size wp-element-button" style="border-width:1px;border-radius:20px;padding-top:var(--wp--preset--spacing--20);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--20);padding-left:var(--wp--preset--spacing--40)">'. esc_html__('Select Options ','t-shirt-printing-shop').'<img class="wp-image-116" style="width: 14px;" src="'.esc_url(get_template_directory_uri()) .'/assets/images/cart.png" alt=""></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"className":"static-product-col","style":{"spacing":{"blockGap":"0"},"border":{"width":"7px"}},"borderColor":"background"} -->
<div class="wp-block-column static-product-col has-border-color has-background-border-color" style="border-width:7px"><!-- wp:group {"className":"static-product-group01","layout":{"type":"constrained"}} -->
<div class="wp-block-group static-product-group01"><!-- wp:image {"id":83,"sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full"><img src="'.esc_url(get_template_directory_uri()) .'/assets/images/product04.png" alt="" class="wp-image-83"/></figure>
<!-- /wp:image --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"static-product-group02","style":{"border":{"top":{"color":"var:preset|color|background","width":"7px"},"right":[],"bottom":[],"left":[]},"spacing":{"padding":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|20","left":"var:preset|spacing|20","right":"var:preset|spacing|20"},"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group static-product-group02" style="border-top-color:var(--wp--preset--color--background);border-top-width:7px;padding-top:var(--wp--preset--spacing--20);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--20);padding-left:var(--wp--preset--spacing--20)"><!-- wp:heading {"style":{"elements":{"link":{"color":{"text":"var:preset|color|tertiary"}}},"typography":{"fontStyle":"normal","fontWeight":"500"}},"textColor":"tertiary","fontSize":"small"} -->
<h2 class="wp-block-heading has-tertiary-color has-text-color has-link-color has-small-font-size" style="font-style:normal;font-weight:500">'. esc_html__('Premium Cotton T-Shirt','t-shirt-printing-shop').'</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"typography":{"fontStyle":"normal","fontWeight":"400"}},"fontSize":"small"} -->
<p class="has-small-font-size" style="font-style:normal;font-weight:400">'. esc_html__('Soft cotton tee with a retro beach .','t-shirt-printing-shop').'</p>
<!-- /wp:paragraph -->

<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","flexWrap":"wrap"}} -->
<div class="wp-block-group"><!-- wp:heading {"style":{"elements":{"link":{"color":{"text":"var:preset|color|primary"}}}},"textColor":"primary","fontSize":"medium"} -->
<h2 class="wp-block-heading has-primary-color has-text-color has-link-color has-medium-font-size">'. esc_html__('Add Quantity','t-shirt-printing-shop').'</h2>
<!-- /wp:heading -->

<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","flexWrap":"wrap"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"className":"quantity-value","style":{"layout":{"selfStretch":"fit","flexSize":null},"elements":{"link":{"color":{"text":"var:preset|color|accent"}}},"spacing":{"padding":{"top":"5px","bottom":"5px","left":"8px","right":"8px"}},"border":{"radius":"50%"}},"backgroundColor":"background","textColor":"accent"} -->
<p class="quantity-value has-accent-color has-background-background-color has-text-color has-background has-link-color" style="border-radius:50%;padding-top:5px;padding-right:8px;padding-bottom:5px;padding-left:8px">'. esc_html__('25','t-shirt-printing-shop').'</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"quantity-value","style":{"layout":{"selfStretch":"fit","flexSize":null},"elements":{"link":{"color":{"text":"var:preset|color|accent"}}},"spacing":{"padding":{"top":"5px","bottom":"5px","left":"8px","right":"8px"}},"border":{"radius":"50%"}},"backgroundColor":"background","textColor":"accent"} -->
<p class="quantity-value has-accent-color has-background-background-color has-text-color has-background has-link-color" style="border-radius:50%;padding-top:5px;padding-right:8px;padding-bottom:5px;padding-left:8px">'. esc_html__('50','t-shirt-printing-shop').'</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"quantity-value","style":{"layout":{"selfStretch":"fit","flexSize":null},"elements":{"link":{"color":{"text":"var:preset|color|accent"}}},"spacing":{"padding":{"top":"5px","bottom":"5px","left":"11px","right":"11px"}},"border":{"radius":"50%"}},"backgroundColor":"background","textColor":"accent"} -->
<p class="quantity-value has-accent-color has-background-background-color has-text-color has-background has-link-color" style="border-radius:50%;padding-top:5px;padding-right:11px;padding-bottom:5px;padding-left:11px">'. esc_html__('75','t-shirt-printing-shop').'</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
<div class="wp-block-group"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","flexWrap":"wrap"}} -->
<div class="wp-block-group"><!-- wp:heading {"style":{"elements":{"link":{"color":{"text":"var:preset|color|primary"}}},"typography":{"fontStyle":"normal","fontWeight":"400"}},"textColor":"primary","fontSize":"medium"} -->
<h2 class="wp-block-heading has-primary-color has-text-color has-link-color has-medium-font-size" style="font-style:normal;font-weight:400">'. esc_html__('Reviews :','t-shirt-printing-shop').'</h2>
<!-- /wp:heading -->

<!-- wp:image {"id":101,"width":"95px","height":"auto","sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full is-resized"><img src="'.esc_url(get_template_directory_uri()) .'/assets/images/star.png" alt="" class="wp-image-101" style="width:95px;height:auto"/></figure>
<!-- /wp:image --></div>
<!-- /wp:group -->

<!-- wp:buttons {"className":"static-buy-now","style":{"spacing":{"margin":{"top":"0","bottom":"0"}}}} -->
<div class="wp-block-buttons static-buy-now" style="margin-top:0;margin-bottom:0"><!-- wp:button {"backgroundColor":"secaccent","textColor":"background","style":{"elements":{"link":{"color":{"text":"var:preset|color|background"}}},"spacing":{"padding":{"left":"var:preset|spacing|40","right":"var:preset|spacing|40","top":"var:preset|spacing|20","bottom":"var:preset|spacing|20"}},"border":{"radius":"20px","width":"1px"}},"fontSize":"small","borderColor":"background"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-background-color has-secaccent-background-color has-text-color has-background has-link-color has-border-color has-background-border-color has-small-font-size has-custom-font-size wp-element-button" style="border-width:1px;border-radius:20px;padding-top:var(--wp--preset--spacing--20);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--20);padding-left:var(--wp--preset--spacing--40)">'. esc_html__('Select Options ','t-shirt-printing-shop').'<img class="wp-image-116" style="width: 14px;" src="'.esc_url(get_template_directory_uri()) .'/assets/images/cart.png" alt=""></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:spacer {"height":"40px"} -->
<div style="height:40px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->',
    );
}
    