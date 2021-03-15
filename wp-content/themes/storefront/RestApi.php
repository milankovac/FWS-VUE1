<?php

/**
 * Class RestApi
 */
class RestApi
{
    /**
     * RestApi constructor.
     */
    public function __construct()
    {
        add_action('rest_api_init', array($this, 'on_rest_api_init'));
    }

    /**
     * Create rest Api point
     */
    public function on_rest_api_init()
    {
        register_rest_route('wp/v2', '/custom_product', array(
            'methods' => 'GET',
            'callback' => array($this, 'generate_data')
        ));
    }

    /**
     * Generate Rest Api Data
     * @return array
     */
    public function generate_data()
    {
        $all_data=array();
        $atribute_and_value=array();
        $args = array(
            'post_type'      => 'product',
            'posts_per_page' => -1,
        );

        $loop = new WP_Query( $args );
        while ( $loop->have_posts() ) : $loop->the_post();
            global $product;
          $gallery_id=$product->get_gallery_image_ids();
          $gallery_url=array();
          if(count($gallery_id)>0)
          {
              for($i=0;count($gallery_id)>$i;$i++)
              {
                 array_push($gallery_url,wp_get_attachment_url($gallery_id[$i]));
              }

          }
            array_push($all_data,array(
                'title'=>$product->get_title(),
                'category'=>get_the_category_by_ID($product->get_category_ids()),
                'main_image'=>wp_get_attachment_url($product->get_image_id()),
                'gallery_images'=>$gallery_url,
                'sku'=>$product->get_sku(),
                'regular_price'=>$product->get_regular_price(),
                'sale_price'=>$product->get_sale_price(),
                'atributes'=>$product->get_attributes(),

            ));

        endwhile;

        wp_reset_query();

        return $all_data;
    }

}