<?php 

namespace PHPWineWPWalker;

use \Walker_Nav_Menu;

/**
* @copyright (c) 2023 WineWPMenuWalker Cooked by nielsoffice
*
* MIT License
*
* WineWPMenuWalker free software: you can redistribute it and/or modify.
* Permission is hereby granted, free of charge, to any person obtaining a copy
* of this software and associated documentation files (the "Software"), to deal
* in the Software without restriction, including without limitation the rights
* to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the Software is
* furnished to do so, subject to the following conditions:
*
* The above copyright notice and this permission notice shall be included in all
* copies or substantial portions of the Software.
*
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
* OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
* SOFTWARE.
*
* @category  WP Custom Menu class / WineWPMenuWalker 
*
*
* @author    Leinner Zednanref <nielsoffice.wordpress.php@gmail.com>
* @license   MIT License
* @link      https://github.com/PHPWine/WineWPMenuWalker
* @link      https://github.com/PHPWine/PHPWine/README.md
* @version   v1.3.5
* @since     11.24.2023
*
*/

class WineWPMenuWalker extends Walker_Nav_Menu {

   /**
     * --------------------------------------------------------------------------------------------
     * @var String 
     * @property
     * -------------------------------------------------------------------------------------------- 
     * Property Wlaker elements into output for menu lists items
     * 
     * @Defined : propert html for append menu walker for lists items and links
     * @since: v2.0 wine
     * DT: 11.24.2023 */
      
    /**
     * -----------------------------------------------------------------
     * @Defined Walker: UL &/Closing tag html opening tag for parent and sub menu child
     * ----------------------------------------------------------------- */
    protected $UL  = "<ul";
    protected $ULx = "</ul>";

    /**
     * -----------------------------------------------------------------
     * @Defined Walker: LI html opening tag for parent and sub menu child
     * ----------------------------------------------------------------- */
    protected $LI  = "<li"; 
    protected $LIx = "</li>"; 

    /**
     * -----------------------------------------------------------------
     * @Defined Walker: Concat end element opening html both for list and ul tag
     * ----------------------------------------------------------------- */
    protected $x_ = ">"; 

    /**
     * --------------------------------------------------------------------------------------------
     * @method https://developer.wordpress.org/reference/classes/walker/start_lvl/ 
     * -------------------------------------------------------------------------------------------- **/
    public function start_lvl(&$output, $depth = 0, $args = null) {
        
      // assigned class to child menu
      if( $depth == 0 ) {
         $depth     = '00_';
         $tmp_class = 'sub-menu';
         $tmp_class = str_replace('-', '_',$tmp_class);
         $hook_tmp_class  = $this->valid_hook($depth.$tmp_class);
    /**
     * -----------------------------------------------------------------
     * @Defined $depth: if this child is third child then update class 
     * you can easily identify which child is this base on depth
     * ----------------------------------------------------------------- */  
      }else if( $depth == 1 ) {

        $depth     = '01_';
        $tmp_class = 'sub-menu t-child';
        $tmp_class = str_replace('-', '_',$tmp_class);
        $hook_tmp_class  = $this->valid_hook($depth.$tmp_class);
     }
      
     /**
      * -----------------------------------------------------------------
      * @Defined Walker: hook top base on class and depth 
      * "01_sub_menut_child"
      * ----------------------------------------------------------------- */
      $output .= $this->appendTo('',$hook_tmp_class, $args);

     /**
      * -----------------------------------------------------------------
      * @Defined Walker: first output of UL begin
      * ----------------------------------------------------------------- */
      $output .= $this->UL ." class='". $tmp_class ."'" . $this->x_;

    }

    /**
     * --------------------------------------------------------------------------------------------
     * @method https://developer.wordpress.org/reference/classes/walker/start_el/ 
     * -------------------------------------------------------------------------------------------- **/
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
    {

      /**
       * -----------------------------------------------------------------
       * @Defined Walker: first output of UL begin
       * ----------------------------------------------------------------- */
        $replace_content = "item_".$item->ID.$item->title?? false;

     /**
      * -----------------------------------------------------------------
      * @Defined Walker: hook top base on followed by ID and title 
      * "top_English"
      * ----------------------------------------------------------------- */
        $output .= $this->appendTo('',$item, $depth, $args, $id);

       /**
        * -----------------------------------------------------------------
        * @Defined Walker: check and accpet only valid class
        * ----------------------------------------------------------------- */
        if(isset($item->classes[0]) && !empty($item->classes[0])) { 
          $classes = $item->classes[0]; 
        } else { 
          $classes = 'item-'.$item->ID; 
        }

       /**
        * -----------------------------------------------------------------
        * @Defined Walker: check ID for child
        * ----------------------------------------------------------------- */
        $output .= $this->LI ." id='item_".$item->ID."' class='".$classes."'" . $this->x_;
        
       /**
        * -----------------------------------------------------------------
        * @Defined Walker: hook for replace content item 
        * "item_28Tagalog"
        * ----------------------------------------------------------------- */
        if(function_exists($replace_content)) {

       /**
        * -----------------------------------------------------------------
        * @Defined Walker: execute later hook
        * ----------------------------------------------------------------- */
          $replace_content = $this->valid_hook($replace_content);
          $output .= later($replace_content,$item, $depth, $args, $id);

        } else {

        /**
         * -----------------------------------------------------------------
         * @Defined Walker: check valid URL
         * ----------------------------------------------------------------- */
          $wp_url_menu_list = sanitize_url( $item->url, array( 'http', 'https' ) );

          // Return links and menu title
          $output .= wine(a, 
            $item->title,[
             href    => esc_url($wp_url_menu_list),
             classes => 'link-'.$item->ID
           ]
          );

        }
       
       /**
        * -----------------------------------------------------------------
        * @Defined Walker: hook append to end
        * "bottom_English"
        * ----------------------------------------------------------------- */
        $output .= $this->appendTo('end',$item, $depth, $args, $id);

    }

    /**
     * -----------------------------------------------------------------
     * @Defined Walker: End of element hook
     * https://developer.wordpress.org/reference/classes/walker/end_el/
     * ----------------------------------------------------------------- */
    public function end_el(&$output, $item, $depth = 0, $args = null) {
        $output .= $this->LIx;
    }

    /**
     * -----------------------------------------------------------------
     * @Defined Walker: End of element hook
     * https://developer.wordpress.org/reference/classes/walker/end_lvl/
     * ----------------------------------------------------------------- */
    public function end_lvl( &$output, $depth = 0, $args = array() ) {

        $output .=  $this->ULx;

    }

   /**
     * --------------------------------------------------------------------------------------------
     * @method  appendTo
     * -------------------------------------------------------------------------------------------- 
     * Assigned a hook for content menu list items
     * 
     * @since: v2.0 wine
     * DT: 11.24.2023 */
    public function appendTo(string $assigd, $item, $depth = 0, $args = null, $id = 0) {

        $hooked = $this->valid_hook($item->title?? false);

        switch ($assigd) {
         case 'end':
            return later('bottom_'.$hooked, $item, $depth, $args, $id);
            break;
        
         default:
            return later('top_'.$hooked, $item, $depth, $args, $id);
            break;
        }
    }

   /**
     * --------------------------------------------------------------------------------------------
     * @method  valid_hook
     * -------------------------------------------------------------------------------------------- 
     * removed extrass to make valid function callable
     * 
     * @since: v2.0 wine
     * DT: 11.24.2023 */
    private function valid_hook( string $item) : string {
    
       $hooked = preg_replace('/\s+/','',$item);
       $hooked = preg_replace('/[^a-zA-Z0-9_ -]/s','',$hooked);

       return (string) $hooked;
    }
    
}

