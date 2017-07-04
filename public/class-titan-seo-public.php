<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       www.titandigital.com.au
 * @since      1.0.0
 *
 * @package    Titan_Seo
 * @subpackage Titan_Seo/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Titan_Seo
 * @subpackage Titan_Seo/public
 * @author     Buks Saayman <buks@titandigital.com.au>
 */
class Titan_Seo_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Titan_Seo_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Titan_Seo_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/titan-seo-public.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Titan_Seo_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Titan_Seo_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/titan-seo-public.js', array('jquery'), $this->version, false);
	}

	public function titanSeoAddWoocommerceMetaDescription($term_obj) {
		$term_meta = get_option("product_cat_meta_$term_obj->term_id");
		?>  
		<tr class="form-field">  
			<th scope="row" valign="top">  
				<label for="presenter_id"><?php _e('Meta Description'); ?></label>  
			</th>  
			<td>  
				<textarea class="postform" id="metadescription" name="titanseocatpagemetadescription"><?php echo $term_meta ?></textarea>
			</td>  
		</tr>  
		<?php
	}

	public function titanSeoSaveWoocommerceMetaDescription($termID) {
		if (isset($_POST['titanseocatpagemetadescription'])) {
			$option_name = 'product_cat_meta_' . $termID;
			update_option($option_name, $_POST['titanseocatpagemetadescription']);
		}
	}

	public function titanSeoHead() {
		//add meta description for woo category page to header
		if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
			if (is_product_category()) {
				global $wp_query;
				$page_id = $wp_query->queried_object->term_id;
				$prod_cat_meta = get_option("product_cat_meta_$page_id");
				echo "<meta name='description' value='$prod_cat_meta'>";
			}
		}
	}

	public function titanSeoPageFilter($html) {

		if (empty($html)) {
			return $html;
		}

		$doc = new DOMDocument();
		@$doc->loadHTML($html);

		$tags = $doc->getElementsByTagName('img');

		foreach ($tags as $tag) {
			if (empty($tag->getAttribute('alt'))) {

				$alt = '';
				$caption = str_replace('[/caption]', '', $tag->nextSibling->nodeValue);

				if (!empty($caption)) {
					$alt = $caption;
				} else if (!empty($tag->getAttribute('title'))) {
					$alt = $tag->getAttribute('title');
				} else {
					$alt = get_the_title();
				}

				$tag->setAttribute('alt', $alt);
			}
		}
		$html = $doc->saveHTML();
		return $html;
	}

	public function titanSeoCallback($buffer) {
		return $this->titanSeoPageFilter($buffer);
	}

	public function titanSeoBufferStart() {
		ob_start(array(&$this, 'titanSeoCallback'));
	}

	public function titanSeoBufferEnd() {
		ob_end_flush();
	}

}
