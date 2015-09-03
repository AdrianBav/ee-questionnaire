<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Layout Class
 *
 * @package     CodeIgniter
 * @subpackage  Libraries
 * @category    Layout
 * @author      Adrian Bavister
 */
class Layout
{
    // Declared class variables
    public $CI;
    public $layout;
    public $layout_data;

    public $page_title;
    public $meta_description;
    public $meta_keywords;
    public $body_attributes;

    public $stylesheets = array();
    public $css = array();
    public $javascripts = array();
    public $scripts = array();

    // Checks if HTML <head> data has been outputted
    public $headers_sent = FALSE;

    // Tracks the order in which stylesheets/javascripts and inline scripts were added for header/footer includes
    private $_css_order = array();
    private $_header_js_order = array();
    private $_footer_js_order = array();


    /**
     * Layout Constructor
     *
     * The constructor loads an instance and sets the default layout.
     */
    function __construct()
    {
        $this->CI =& get_instance();

        $this->layout = 'layouts/default';
        $this->layout_data = array();
    }

    // --------------------------------------------------------------------

    /**
     * Set Layout
     *
     * Specifies a layout to use other than the default
     *
     * @param string
     * @return object
     */
    function set_layout($layout)
    {
        if ( ! empty($layout))
        {
            $this->layout = $layout;
        }

        return $this;
    }

    // --------------------------------------------------------------------

    /**
     * Set Layout Data
     *
     * Used to set data used in the template
     *
     * @param string
     * @return object
     */
    function set_layout_data($data)
    {
        if ( ! empty($data))
        {
            $this->layout_data = $data;
        }

        return $this;
    }

    // --------------------------------------------------------------------

    /**
     * Set Meta Title
     *
     * Specifies the page title used in the metadata output
     *
     * @param string
     * @return object
     */
    function set_page_title($title)
    {
        if ( ! empty($title))
        {
            $this->page_title = $title;
        }

        return $this;
    }

    // --------------------------------------------------------------------

    /**
     * Set Description
     *
     * Specifies the page description used in the metadata output
     *
     * @param string
     * @return object
     */
    function set_meta_description($description)
    {
        if ( ! empty($description))
        {
            $this->meta_description = $description;
        }

        return $this;
    }

    // --------------------------------------------------------------------

    /**
     * Set Keywords
     *
     * Specifies the page keywords used in the metadata output
     *
     * @param string
     * @return object
     */
    function set_meta_keywords($keywords)
    {
        if ( ! empty($keywords))
        {
            $this->meta_keywords = $keywords;
        }

        return $this;
    }

    // --------------------------------------------------------------------

    /**
     * Set Body Attributes
     *
     * Specifies attributes to be applied to the body tag
     *
     * @param string
     * @return object
     */
    function set_body_attributes($attributes)
    {
        if ( ! empty($attributes))
        {
            $this->body_attributes = $attributes;
        }

        return $this;
    }

    // --------------------------------------------------------------------

    /**
     * Add Stylesheet
     *
     * This function is used to build an array of external stylesheets to include
     *
     * @param string or array
     * @return object
     */
    function add_stylesheet($stylesheets)
    {
        $this->CI->load->helper('url');

        if ( ! is_array($stylesheets))
        {
            $stylesheets = (array) $stylesheets;
        }

        foreach ($stylesheets as $stylesheet)
        {
            // [-ab] $stylesheet = (strpos($stylesheet, 'http') === 0 ? $stylesheet : site_url($stylesheet));

            if ( ! in_array($stylesheet, $this->stylesheets))
            {
                $this->stylesheets[] = $stylesheet;
                $index = end(array_keys($this->stylesheets));

                // Keep track of the order in which stylesheets and css are added
                $this->_css_order[] = array(
                        'array' => 'stylesheets',
                        'index' => $index,
                    );
            }
        }

        return $this;
    }

    // --------------------------------------------------------------------

    /**
     * Add CSS Code
     *
     * Used to build an array of internal css code to include
     *
     * @param string or array
     * @return object
     */
    function add_css_code($css)
    {
        if ( ! is_array($css))
        {
            $css = (array) $css;
        }

        foreach ($css as $style)
        {
            $this->css[] = $style;
            $index = end(array_keys($this->css));

            // Keep track of the order in which stylesheets and css are added
            $this->_css_order[] = array(
                    'array' => 'css',
                    'index' => $index,
                );
        }

        return $this;
    }

    // --------------------------------------------------------------------

    /**
     * Add script
     *
     * Used to build an array of external javascripts to include
     *
     * @param string or array
     * @return object
     */
    function add_script($javascripts, $foot = FALSE)
    {
        $this->CI->load->helper('url');

        if ( ! is_array($javascripts))
        {
            $javascripts = (array) $javascripts;
        }

        foreach ($javascripts as $javascript)
        {
            // If HTTP not in javascript uri add prepend site_url
            // [-ab] $javascript = (strpos($javascript, 'http') === 0 ? $javascript : site_url($javascript));

            if ( ! in_array($javascript, $this->javascripts))
            {
                $this->javascripts[] = $javascript;
                $index = end(array_keys($this->javascripts));

                // Determine where this script needs to be included
                // and keep track of the order in which javascripts and scripts are added
                if ($foot || $this->headers_sent)
                {
                    $this->_footer_js_order[] = array(
                        'array' => 'javascripts',
                        'index' => $index,
                    );
                }
                else
                {
                    $this->_header_js_order[] = array(
                        'array' => 'javascripts',
                        'index' => $index,
                    );
                }
            }
        }

        return $this;
    }

    // --------------------------------------------------------------------

    /**
     * Add Javascript Code
     *
     * Used to include internal javascript code in the template
     *
     * @param string or array
     * @return object
     */
    function add_javascript_code($scripts, $foot = FALSE)
    {
        if ( ! is_array($scripts))
        {
            $scripts = (array) $scripts;
        }

        foreach ($scripts as $javascript)
        {
            $this->scripts[] = $javascript;
            $index = end(array_keys($this->scripts));

            // Determine where this script needs to be included
            // and keep track of the order in which javascripts and scripts are added
            if ($foot || $this->headers_sent)
            {
                $this->_footer_js_order[] = array(
                    'array' => 'scripts',
                    'index' => $index,
                );
            }
            else
            {
                $this->_header_js_order[] = array(
                    'array' => 'scripts',
                    'index' => $index,
                );
            }
        }

        return $this;
    }

    // --------------------------------------------------------------------

    /**
     * View
     *
     * Loads a specified view wrapped in the default theme
     *
     * @param string
     * @param array
     * @param bool
     * @return string
     */
    function view($view, $data=null, $return=false)
    {
    	$site_name = $this->CI->config->item('site_name');
    	$site_version = $this->CI->config->item('site_version');

    	if (is_logged_in())
    	{
    		$nav_data = array('site_name' => $site_name, 'user_name' => user_name());
    		$page_nav = $this->CI->load->view('partials/admin_nav', $nav_data, true);
    	}
    	else
    	{
    		$page_nav = '';
    	}

    	$footer_data = array('site_name' => $site_name, 'site_version' => $site_version);

        $this->layout_data['page_title'] = "{$site_name} - {$this->page_title}";
        $this->layout_data['body_attributes'] = $this->body_attributes;
        $this->layout_data['page_nav'] = $page_nav;
        $this->layout_data['page_content'] = $this->CI->load->view($view, $data, true);
        $this->layout_data['page_footer'] = $this->CI->load->view('partials/footer', $footer_data, true);

        if ($return)
        {
            $output = $this->CI->load->view($this->layout, $this->layout_data, true);
            return $output;
        }
        else
        {
            $this->CI->load->view($this->layout, $this->layout_data, false);
        }
    }

    // --------------------------------------------------------------------

    /**
     * Metadata
     *
     * Commonly used in the header.php template file
     * Outputs title, description, and keyword metadata
     *
     * @return string
     */
    function metadata()
    {
        $metadata = '';

        if ( ! empty($this->meta_description))
        {
            $metadata .= '<meta name="description" content="' . $this->meta_description . '" />' . "\r\n";
        }

        if ( ! empty($this->meta_keywords))
        {
            $metadata .= '<meta name="keywords" content="' . $this->meta_keywords . '" />' . "\r\n";
        }

        $this->headers_sent = TRUE;

        return $metadata;
    }

    // --------------------------------------------------------------------

    /**
     * Stylesheets
     *
     * Commonly used in the HTML <head> of template files
     * Outputs stylesheets includes from the stylesheet array
     *
     * @return string
     */
    function stylesheets()
    {
        $css_includes = '';

        foreach ($this->_css_order as $css_order)
        {
            if ($css_order['array'] == 'stylesheets')
            {
                $css_includes .=  "\n\t<link href=\"" . $this->stylesheets[$css_order['index']] . "\" rel=\"stylesheet\" type=\"text/css\" />";
            }
            else if ($css_order['array'] == 'css')
            {
                $style = $this->css[$css_order['index']];

                // Check if css has the script tags included
                if (stripos(trim($style), '<stle') === 0)
                {
                    $css_includes .=  "\n" . $style;
                }
                else
                {
                    $css_includes .=  "\n\t<style type=\"text/css\">" . $style . "</style>";
                }
            }
        }

        $this->headers_sent = TRUE;

        return $css_includes;
    }

    // --------------------------------------------------------------------

    /**
     * scripts
     *
     * Commonly used in the HTML <head> of template files
     * Outputs javascript includes from the javascript array
     *
     * @return string
     */
    function scripts($foot = FALSE)
    {
        $this->CI->load->helper('url');

        if ($foot)
        {
            $js_order_array = '_footer_js_order';
        }
        else
        {
            $js_order_array = '_header_js_order';
        }

        $js_includes = "\n\t<script>var BASE_HREF=\"" . base_url() . "\"</script>";

        foreach ($this->$js_order_array as $js_order)
        {
            if ($js_order['array'] == 'javascripts')
            {
                $js_includes .=  "\n\t<script type=\"text/javascript\" src=\"" . $this->javascripts[$js_order['index']] . "\"></script>";
            }
            else if ($js_order['array'] == 'scripts')
            {
                $script = $this->scripts[$js_order['index']];

                // Check if script has the script tags included
                if (stripos(trim($script), '<script') === 0)
                {
                    $js_includes .=  "\n" . $script;
                }
                else
                {
                    $js_includes .=  "\n\t<script type=\"text/javascript\">" . $script . "</script>";
                }
            }
        }

        if ( ! $foot)
        {
            $this->headers_sent = TRUE;
        }

        return $js_includes;
    }

    // --------------------------------------------------------------------

    /**
     * Foot Scripts
     *
     * Commonly used in the foot of the template file immediately before the closing </body> tag
     * Outputs the foot javascripts
     *
     * @return string
     */
    function foot_scripts()
    {
        $return = '';
        $return .= $this->scripts(TRUE);

        return $return;
    }

}
