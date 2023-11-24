# WineWPMenuWalker

```PHP

  // Register custom navigation menu
  add_action( 'init', 'nielsoffice_nav_menus' );
  function nielsoffice_nav_menus() {

   $locations = array(
    'main-menu' => __( 'Primary menu', 'nielsoffice' )
   );
   register_nav_menus( $locations );
 }

```

```PHP

// init custom menu 
 wp_nav_menu( array(
   'theme_location'  => 'main-menu',
   'menu_id'         => 'primary-menu',

  'container' 	    => 'nav',
  'container_class' => 'menu-wine',   // %1$s
  'menu_class' 	    => 'wine', // %2$s .... %3$s = list items.
  'add_li_class'    => 'pwine',
  'items_wrap' 	    => '<ul class="p-wine %2$s" id="%1$s">%3$s</ul>',
  'walker' => new WineWPMenuWalker()
  )
);


```
