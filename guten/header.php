<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="shortcut icon" href="<?php echo \guten\Theme::asset('favicon.png'); ?>" />

	<?php wp_head(); ?>

	<title><?php wp_title(''); ?></title>
</head>

<body <?php body_class(); ?>>

    <header id="header">
        <div class="container">
            <a class="logo" href="<?php echo home_url('/'); ?>">
                LOGO
            </a>

            <div>
                <nav id="nav">
                    <?php wp_nav_menu(['theme_location' => 'main']); ?>
                </nav>

                <div>
                    <?php dynamic_sidebar('header-sidebar'); ?>

                    <span class="nav-trigger"><span></span></span>
                </div>
            </div>
        </div>
    </header>

    <div id="main">

