<?php
if ( !defined( 'ABSPATH' ) ) exit;

if ( !function_exists( 'hestia_child_parent_css' ) ){
    function hestia_child_parent_css() {
        wp_enqueue_style( 'hestia_child_parent', trailingslashit( get_template_directory_uri() ) . 'style.css', array( 'bootstrap' ) );
	if( is_rtl() ) {
		wp_enqueue_style( 'hestia_child_parent_rtl', trailingslashit( get_template_directory_uri() ) . 'style-rtl.css', array( 'bootstrap' ) );
	}

    }
}
add_action( 'wp_enqueue_scripts', 'hestia_child_parent_css');

// customcss.css をWP追加CSSより後に出力（priority 999 = 追加CSSのpriority 101より後）
function custom_load_customcss() {
    $ver = filemtime( get_stylesheet_directory() . '/customcss.css' );
    $url = esc_url( get_stylesheet_directory_uri() . '/customcss.css?v=' . $ver );
    echo '<link rel="stylesheet" href="' . $url . '">' . "\n";
}
add_action( 'wp_head', 'custom_load_customcss', 999 );

/**
 * Import options from Hestia
 *
 * @since 1.0.0
 */
function hestia_child_get_lite_options() {
	$hestia_mods = get_option( 'theme_mods_hestia' );
	if ( ! empty( $hestia_mods ) ) {
		foreach ( $hestia_mods as $hestia_mod_k => $hestia_mod_v ) {
			set_theme_mod( $hestia_mod_k, $hestia_mod_v );
		}
	}
}
add_action( 'after_switch_theme', 'hestia_child_get_lite_options' );



function getNewItems($atts) {
	extract(shortcode_atts(array(
		"num" => '',	//最新記事リストの取得数
		"cat" => ''	//表示する記事のカテゴリー指定
	), $atts));
	global $post;
	$oldpost = $post;
	$myposts = get_posts('numberposts='.$num.'&order=DESC&orderby=post_date&category='.$cat);
	$retHtml='<ul class="news_list">';
	foreach($myposts as $post) :
	$cat = get_the_category();
	$catname = $cat[0]->cat_name;
	$catslug = $cat[0]->slug;
		setup_postdata($post);
		$retHtml.='<li>';
		$retHtml.='<span class="news_date">'.get_post_time( get_option( 'date_format' )).'</span>';
		$retHtml.='<span class="cat '.$catslug.'">'.$catname.'</span>';
		$retHtml.='<span class="news_title"><a href="'.get_permalink().'">'.the_title("","",false).'</a></span>';
		$retHtml.='</li>';
	endforeach;
	$retHtml.='</ul>';
	$post = $oldpost;
	wp_reset_postdata();
	return $retHtml;
}
add_shortcode("news", "getNewItems");


add_filter("pre_site_transient_update_core", "__return_null");
add_filter("pre_site_transient_update_plugins", "__return_null");
add_filter("pre_site_transient_update_themes", "__return_null");


// functions.phpに追記
function custom_post_slider_shortcode() {
    ob_start(); // 出力バッファリング開始

    $default_img_url = get_template_directory_uri() . '/path/to/default.jpg'; // デフォルト画像のURLに変更してね

    // 投稿クエリ
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 10, // 表示する投稿数（調整してOK）
        'category_name' => '2025aw', // ← ここでカテゴリを限定
    );
    $the_query = new WP_Query($args);

    if ($the_query->have_posts()) : 
    ?>

    <div class="custom-post-slider swiper"> <!-- 独自クラス名 -->
        <div class="swiper-wrapper">
            <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
                <div class="swiper-slide">
                    <a href="<?php the_permalink(); ?>" class="custom-post-link">
                        <div class="custom-post-slide flex">
                            <div class="custom-post-thumb">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('medium'); ?>
                                <?php else : ?>
                                    <img src="<?php echo esc_url($default_img_url); ?>" alt="no image">
                                <?php endif; ?>
                            </div>
                            <div class="custom-post-text">
                                <div class="custom-post-meta flex">
                                    <span class="custom-post-date"><?php echo get_the_date('Y.m.d'); ?></span>
                                    <span class="custom-post-cats">
                                        <?php 
                                        $categories = get_the_category();
                                        if ($categories) {
                                            foreach ($categories as $category) {
                                                echo esc_html($category->name) . ' ';
                                            }
                                        }
                                        ?>
                                    </span>
                                </div>
								<div class="custom-post-title">
									<?php echo esc_html( mb_strimwidth( get_the_title(), 0, 55, '…', 'UTF-8' ) ); ?>
								</div>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endwhile; ?>
        </div>

        <!-- ナビボタン（必要なら追加） -->
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
        <div class="swiper-pagination"></div>

    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        new Swiper('.custom-post-slider', {
            slidesPerView: 1,
            spaceBetween: 30,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
			autoplay: {
				delay: 3000, // 3秒ごとにスライド
				
				disableOnInteraction: false, // ユーザー操作後もオートプレイを継続
			},
			speed: 1500, // ← 1000ミリ秒 = 1秒かけて次のスライドに移動
            breakpoints: {
                768: {
                    slidesPerView: 4.5,
                }
            },
        });
    });
    </script>

    <?php
    endif;
    wp_reset_postdata();
    return ob_get_clean(); // 出力バッファリング終了
}
add_shortcode('custom_post_slider', 'custom_post_slider_shortcode');

function archive_page_css_switch() {
  if ( is_page('nigiwaifesta-2025-spring') ) {
    // 元のCSSを外す（ハンドル名に注意！）
    wp_dequeue_style('so-css-hestia-css');
    wp_deregister_style('so-css-hestia-css');

    // アーカイブ用CSSを読み込む
    wp_enqueue_style(
      'so-css-hestia-2025spring',
      content_url('/uploads/so-css/so-css-hestia-2025_spring.css'),
      array(),
      null
    );
  }
}
add_action('wp_enqueue_scripts', 'archive_page_css_switch', 99);
