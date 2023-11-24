# WineWPMenuWalker

```PHP
 /* Installation */
 composer require phpwine/wpmenuwalker

 /* required version *v2.0 */
 composer require phpwine/optimizedhtml v2.0
```

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
// namespace
 use \PHPWineWPWalker\WineWPMenuWalker;

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

```HTML

<nav class="menu-wine">
    <ul class="p-wine wine" id="primary-menu">
        <li id="item_25" class="item-25"><a href="#" class="link-25">Home</a></li>
        <li id="item_24" class="course-title-class">
            <a href="#" class="link-24">Courses</a>
            <ul class="sub_menu"> <!-- first child -->
                <li id="item_27" class="item-27">
                    <a href="#" class="link-27">English</a>
                    <ul class="sub_menu t_child"> <!-- second child -->
                        <li id="item_26" class="item-26"><a href="#" class="link-26">Submit a bug</a></li>
                    </ul>
                </li>
                <li id="item_28" class="item-28"></li>
            </ul>
        </li>
        <li id="item_23" class="item-23"><a href="#" class="link-23">Showcase</a></li>
        <li id="item_22" class="item-22"><a href="#" class="link-22">Blog</a></li>
        <li id="item_21" class="item-21"><a href="#" class="link-21">Buy me coffee?</a></li>
    </ul>
</nav>

```

```PHP
 // Hooks sub-menu child parent [ assigned to depth]
 function one_sub_menut_child( $depth, $args ) { /***/ }

 // Hooks Replace Content menu specific item
 function item_24Courses( $item, $depth, $args, $id ) { /***/ }
  
 // Hooks insert element top and bottom from item
 function top_Courses( $item, $depth, $args, $id ) { /***/ }
 function bottom_Courses( $item, $depth, $args, $id ) { /***/ }

```
