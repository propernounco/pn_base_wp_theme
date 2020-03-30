<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->
**Table of Contents** 

- [Configuring The Theme](#configuring-the-theme)
	- [Installing The Latest Version of WordPress](#installing-the-latest-version-of-wordpress)
	- [Installing the WP Barebones Files](#installing-the-wp-barebones-files)
	- [Starting Configuration](#starting-configuration)
	- [Install Node Modules](#install-node-modules)
	- [Gulp File Configuration](#gulp-file-configuration)
	- [Assets File / Directory Configuration](#assets-file--directory-configuration)
	- [Update lib/css-js.php](#update-libcss-jsphp)
	- [ACF Default Fields Configuration](#acf-default-fields-configuration)
- [Icons](#icons)
- [WP Barebones Basic SCSS Framework](#wp-barebones-basic-scss-framework)
	- [Variables](#variables)
	- [Mixins](#mixins)
	- [Utility Classes / Helper Classes](#utility-classes--helper-classes)
	- [Animations](#animations)
  		- [Animations Triggered By Page Scroll](#animations-triggered-by-page-scroll)
  		- [Animation Delays](#animation-delays)
	- [Grid System](#grid-system)
	- [Containers & Breakpoints](#containers--breakpoints)
	- [Typography](#typography)
	- [Mobile Navigation](#mobile-navigation)
	- [CSS Components File](#css-components-file)
	- [Forms](#forms)
- [Basic UI Components](#basic-ui-components)
	- [Sliders / Carousels](#sliders--carousels)
	- [Modals](#modals)
- [Page Templates](#page-templates)
- [Page Partials / Reusable Components](#page-partials--reusable-components)
- [WP Barebones Functional Updates](#wp-barebones-functional-updates)
	- [Custom Post Types](#custom-post-types)
	- [WP Utility Functions](#wp-utility-functions)
	- [Page Specific/Conditional CSS Loading](#page-specificconditional-css-loading)
	- [WP Theme Functions File](#wp-theme-functions-file)
	

<!-- END doctoc generated TOC please keep comment here to allow auto update -->

# WP Barebones Base WordPress Theme & Framework Documentation

Thanks for checking out my base WordPress which has come to be known as WP Barebones. This has been a work in progress over the past several years, but I think it's become useful enough for me that it would probably be useful to other WordPress website developers. It includes a basic CSS framework that utilizes CSS grid, a variety of custom WP utility functions, it's already setup to use prefix, compile, and minify SASS and JS using Gulp, it comes with a suite of utility plugins, and quite a bit more. You will need to use the command line a bit to get the full benefit of this theme.

As I continue to develop themes and plugins for WordPress, I'm sure WP Barebones will continue to evolve as well. If you'd like to get access to the updates, WP Barebones support, our mastermind group, the freelance jobs board, and more, signup for a monthly or yearly subscription at https://www.getwpbarebones.com

## Configuring The Theme
OK the first thing you'll want to do is get WordPress installed and then get the theme setup. 

If you already have WordPress setup and configured in your local environment or on a server, you can skip down to installing the WP Barebones files. If you don't here are some terminal commands you can run to download the latest WordPress package.

### Installing The Latest Version of WordPress

First, change to the directory you plan to develop your theme in
```
cd /dirname
```

Now download the latest version of WordPress using cURL
```
curl -L http://wordpress.org/latest.zip > wp.zip
```
Now just unzip the package and move the files back into the root.
```
mv wordpress/* ./
```
You can also remove the zip file and empty directory with
```
rmdir wordpress/ && rm wp.zip
```
Now you'll just need to update the wp-config file to point to your empty database. 

### Installing the WP Barebones Files

Now that you have WordPress installed, you can download WP Barebones from Github and setup the files with the following commands.

```
git clone https://github.com/propernounco/pn_base_wp_theme.git
```

```
mv pn_base_wp_theme/plugins/* ./plugins/
```

```
mv pn_base_wp_theme/themes/* ./themes/
```

### Starting Configuration
Alright, you've got WordPress installed and configured, you've downloaded WP Barebones and placed everything in the correct directories, now it's time to setup the theme with the theme-specific details.

1. **Update The Theme Directory**  

The first thing you'll want to do is change the name of the theme's directory from 'base_theme' to whatever it is you're going to call the theme. 

2. **Update Styles.css With Theme Name**  

WordPress will pull the name of the theme itself from the styles.css file. You'll find this file in the root of your theme. Just open it in a text editor and update the details you see accordingly. **I don't actually suggest using this file for styling your theme.** 

3. **Add Screenshot.png**  

The 'screenshot.png' file is what will be used for the theme's thumbnail in the WordPress appearance settings. You can upload anything you'd like here, just make sure it's named 'screenshot.png'.

4. **Enable Plugins**  

WP Barebones comes with a variety of utility plugins that you may find useful in your website build.  These include:
- Classic Editor
- Advanced Custom Fields Pro (License Required)
- Gravity Forms (License Required)
- ShortPixel Image Optimizer
- W3 Total Cache 
- SEOPress & SEOPress Pro (No License Required For General Plugin. License Required For Pro.)

You do not need to enable any of these plugins for WP Barebones to work, they are just helpful in the development of a custom WordPress theme.

You will also find some basic media plugins and WP All Import if you need to import any data from an existing website or CSV file. 

To enable the plugins just login to the backend of WordPress, click plugins, and activate all of the plugins you plan to use.

5. **Add A Home Page and Update Settings**  

Next you'll want to click on "Pages" and then click "Add New". Type "Home Page" into the title, select "Home Page" from the custom template dropdown, and then click save.

Now, hover over Settings and click on "Reading".  Now select "A Static Page" for "Your Homepage Displays" settings, and select the home page you just created as the "Homepage".

6. **Reset permalinks**  

OK the last thing you'll want to do to finish setting up WordPress is to reset the permalinks so you don't get any 404 pages. 

### Install Node Modules
Now that WordPress is configured, you'll want to install all of the dependencies required to compile, compress, and minify your CSS and Javascript files. WP Barebones uses Gulp for this but if you prefer using another compiler you can. To start you'll need to install NodeJS if you haven't already. I suggest installing NVM (Node Version Manager) so that you can use any version of NodeJS you'd like. You can either use cURL or Wget for this:

```
curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.35.3/install.sh | bash
```

```
wget -qO- https://raw.githubusercontent.com/nvm-sh/nvm/v0.35.3/install.sh | bash
```

Now run the code below to load NVM

```
export NVM_DIR="$([ -z "${XDG_CONFIG_HOME-}" ] && printf %s "${HOME}/.nvm" || printf %s "${XDG_CONFIG_HOME}/nvm")"
[ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh" # This loads nvm
```

For full installation and configuration details, you can visit the repo: https://github.com/nvm-sh/nvm

Once you have everything with NVM configured, choose the version of Node you'd like to run - I suggest version 9.X for the dependencies included in the package. To do this run:
```
nvm use 9
```

and then to install all of the dependencies in the package.json file:
```
npm install
```

### Gulp File Configuration
Now, open up the gulp file (gulpfile.js) that is located in the root of your theme. 

1. **Update Scripts Settings**  

The gulp file comes configured to use a couple of JavaScript libraries for common website utilities. The basic file includes:

- [iziModal](http://izimodal.marcelodolza.com/) for clean, attractive website modals.
- [Feather Icons](https://feathericons.com/) for easy to use website icons 
- [Waypoints](http://imakewebthings.com/waypoints/) is a helpful JS library that allows you to trigger JS functions as elements enter or leave the view.
- [Slick](https://kenwheeler.github.io/slick/) is a slider library for things like home page sliders, testimonial carousels, product carousels, or anything else you want to turn into a slider.

You don't have to use any of these in your build.

The Gulp file also includes three JavaScript files that are specific to the theme: util-scripts.js, core-js.js and theme-js.js. 

Util-scripts.js includes a function that will identify the browser and browser version that a user is browsing from.  If it's a browser with known compatibility issues, it will apply special classes to the website body as well as several website components so that they can be modified for older browsers as needed.

Core-js.js sets up a variety of core theme functions. These include things like intiializing feather icons, creating interactive navigation dropdowns, handling mobile navigation triggers, and more. You can look through the file itself to get a better idea of what it includes.  You can also feel free to make changes to the file if you feel it's necessary. 

2. **Update Theme JS File**  

Theme-js.js is the file you should put all of your theme specific JavaScript in. You should modify the name of this file from Theme-js.js to whatever your theme is called, i.e. 'theme-name-here'-js.js.

**Make sure to update the name of the output file as well from theme-js.dist.js to 'thene-name-here'-js.dist.js**

### Assets File / Directory Configuration
Configure the files in the assets directory to match the filenames you've setup in the gulp file. You'll find 'theme-js.js' in 'assets/js' and 'theme-styles.scss' in 'assets/sass'.  Update both of these files to reflect the theme name you set in the gulp file.

### Update lib/css-js.php

1. **Setting Up Style & Script Enqueue**  

WP Barebones comes with a series of functional files that are stored in the 'lib' directory. Each of these files is loaded through the functions.php file, so think of them as extensions of your themes primary functions file. One of these files is used to enqueue the theme's CSS and JavaScript files. 

Start by opening 'lib/css-js.php' and replacing 'theme-styles.css' and 'theme-js.dist.js' with your theme CSS and JS files. 

You'll notice there's also a block of code below where you enqueue the theme styles that will dynamically load CSS files. 

This code is already setup to find and load css files that are named to match custom post type template names and single post template names for custom post types.  

The template name is the name set at the top of the template files, for example a template named programs would look like this:

```
/** Template Name: Programs */  
```
If you wanted to load a CSS file specifically for this template, you would just create a new file in '/assets/sass' named 'programs.scss' without the leading underscore.

You can also copy and paste this same code block into the script enqueue and follow the same logic if you wanted to conditionally load JavaScript files.

2. **Dynamic Loading Explanation**  

If you're unfamiliar with the concept of dynamically loading CSS files on specific pages, this is a way to keep your CSS file size down and your website loading as quickly as possible.

For example, let's say there are certain elements, components, JS functions, or styles that will only be required on one page, then it doesn't really make sense to add all of that additional code to a "global" CSS or JavaScript file.  

By moving this code to page specific files, you're able to keep the overall size of your CSS and JavaScript files as small as possible without having to make compromises when it comes to your designs or functionality. 

3. **JavaScript Explanations**  

Along with the enqueue script function you'll see inside of 'wpbb_enqueue_script', there's also a '$php_array' that is defined. 

This array is used to a) localize your theme's JS file and b) establish a variety of variables that can be used in your JS file. 

Localizing the script allows for it to access these variables from your JavaScript file as well as make Ajax requests to your theme's functional files. 

For example, if you were to use store 'php_array.base_url' in a variable called 'base_url' in your main JavaScript file and then log the variable, you would see the result of 'get_home_url()' or your websites root domain.

### ACF Default Fields Configuration
WP Barebones comes with Advanced Custom Fields, or ACF, already installed. You can use the free version without a license, or simply purchase a license to unlock all of the features.

In the root of your theme, you'll see a file called 'acf-export.json'. This file has a number of pre-configured custom field settings such as page 'hero' settings (or main banner settings), header settings, global website settings and more that are typically useful in WordPress website setups.

You don't have to use this file and can start from scratch, but as there are a couple of these fields built into the base theme files, you'll want to either install the basic fields or update the hero, header, and contact templates to remove the calls to those fields.

To install the custom fields, hover over "Custom Fields" in the left hand navigation and click on "Tools". Now simply drop the import file on to the file field where it asks for the import file.

## Icons
WP Barebones includes a lightweight, easy-to-use icon pack called Feather Icons. 

You can get a list of all of the available icons on their website, [Feather Icons](https://feathericons.com/). 

To use the icons, you'll want to include the specific icon like so:

```
<i data-feather="circle"></i>
```

Feather Icons uses JavaScript to use the name set in the 'data-feather' attribute to replace the icon with an SVG. Feather Icons are initialized in the core-js.js file, but if you are not using this file, you can initialize it by adding the below JS into your main theme js file:

```
feather.replace()
```

## WP Barebones Basic SCSS Framework
WP Barebones also includes a basic SCSS framework to help facilitate more rapid theme development. The framework includes many of the features that frameworks like Bootstrap might include, however is considerably more lightweight and flexible. 

Here are is a run down on all of the frameworks features.

### Variables
All of the theme's SASS variables can be found in 'assets/sass/base/variables'.  

Some of the variables that come included with WP Barebones are color variables, font variables, container size variables and breakpoint variables. 

It also includes a "base_height" variable that controls height increments that will be used throughout the theme. 

For example, the helper class "topmargin-5" would be the equivalent of a top padding on the element in question of 5 times the "base_height" or (5 * 6px).  If you were to change the "base_height" to 5 it would change the padding of that same element from 30px to 25px.  

You can set any other variables that you may need to set for use throughout your SASS files in this file.

### Mixins
In addition to SASS variables, there are also a number of SASS mixins that come with WP Barebones. 

1. **@include breakpoint()**  

The "breakpoint" mixin is used for "mobile-first" development.  These breakpoints will be set as "min-width" media queries.  

If you plan to develop your theme to be "mobile first" you should use this mixin throughout your sass files.

The function accepts parameters "mobile-s", "mobile", "xs", "s", "dz", "m", "l", "xl" and "xxl".

You can view and set the sizes for these parameters in the 'variables' file.

2. **@include max-breakpoint()**  

The "max-breakpoint" is the opposite of the "breakpoint" mixin. Instead of a 'min-width' media query, it will set a max-width media query. 

The function accepts parameters "mobile-s", "mobile", "xs", "s", "dz", "m", "l", "xl" and "xxl".

You can view and set the sizes for these parameters in the 'variables' file.

3. **@include font-size()**  

This mixin is used to create responsive font sizes throughout your theme.

Instead of setting your font sizes in static pixels, i.e 'font-size:18px', this will allow you to set your font size in 'rems' with a pixel fallback.

The base font size (62.5%) is set in the 'global.scss' on the "html" settings. file and all font sizes set in "rems" will use this as it's base size. A size of 62.5% will make it so that a font size of "1.6rem" is about the same as a font size of "16px".

To use the mixin, you would use "@include font-size(1.6)" instead of "font-size:16px".

You can then make all of your font sizes smaller as the screensize changes by reducing the global font size from 62.5% as necessary.

4. **@include minmax()**  

The 'minmax' mixin is used for setting the width, min-width, and max-width of an element. This can be especially useful with flexbox layouts to make sure that elements are not condensed.

To use it you would simply write "@include minmax(300px)" which would ouptut: 

```
.class{
	width:300px;
	min-width:300px;
	max-width:300px;
}
```

5. **@include animation()**  

This mixin is more of a utility mixin that is used in the file 'assets/sass/base/animations'.  We will explain the animation options in a bit more detail below.

6. **@include fancy_scroller() and @include fancy_scroller_small()**  

Sometimes the standard browser scrollbars simply won't cut it.  WP Barebones allows you to override the browsers standard scrollbar with a mode sleek, modern-looking scroll bar. 

You can use the mixin "fancy_scroller()" to updated the scroll bar on the window or a specific div with scrollable overflow content.  You can also use "fancy_scroller_small()" if you'd like to use a smaller scroller.

7. **@include hide_scroller()**  

Similar to the "fancy_scroller()" mixin, this mixin is also used to modify the browsers native scrollbar. However instead of changing the look and feel of the scroller, it will just remove the scroll bar entirely.


### Utility Classes / Helper Classes
There are a number of utlity classes and helper classes that come with WP Barebones.  You can review this file at 'assets/sass/base/helpers'. Here is a breakdown of all of the classes.

1. **'.responsive-img'**  

On the first line of the helpers file, WP Barebones sets all images to be "responsive" by default in that the img element is set to:

```
img{
	max-width:100%;
	height:auto;
}
```

If you choose to remove this styling though and instead use the "responsive-img" class, you can simply apply the class to any image and it will have the same style.

2. **'.image-cover'**  

This class will set the image to have a minimum width of 100%, a minimum height of 100% and will set the "object-fit" property to cover which will allow the image to maintain it's aspect ratio. This class will allow an image to behave similarly to a background image with a background size set to "cover".

If you're unfamiliar with the object-fit property [you can read more on it here](https://developer.mozilla.org/en-US/docs/Web/CSS/object-fit)


3. **'.image-contain'**  

This class works similarly to the '.image-cover' class, but instead of 'object-fit:cover' it applies the property 'object-fit:contain'. 

The 'contain' property will ensure that the image will fill up the full width and height of a container without while keeping the image fully within the container and maintaining the aspect ratio. 

If you're unfamiliar with the object-fit property [you can read more on it here](https://developer.mozilla.org/en-US/docs/Web/CSS/object-fit)


4. **Visibility & Display Helpers**  

There are a number of classes that control an elements visibility and display in various ways.

Display Helpers  
```
.none { display: none; }
.block { display: block; }
.inline-block { display: inline-block; }
.inline { display: inline; }
```
Show and Hide Helpers
```
.opaque{ opacity:0; }
.hide{ display:none; }
.show{ display:block; }
```

5. **Flex Box Helpers**  

WP Barebones comes with a number of flex helpers that can be applied to elements and containers. Flex elements also work great in conjunction with CSS grid for perfectly balanced elements.

```
.flex { display: flex; }
.flex-row { flex-direction: row; }
.flex-column { flex-direction: column; }
.flex-space-around { justify-content: space-around; }
.flex-space-between { justify-content: space-between; }
.flex-start { justify-content: flex-start; }
.flex-center { justify-content: center; }
.flex-end { justify-content: flex-end; }
.flex-wrap { flex-wrap: wrap; }
.flex-nowrap { flex-wrap: nowrap; }
.flex-eq-col{
  width:auto;
  flex-grow:1;
  max-width:100%;
}
```

Example usage of these classes might be something like the code below to create four equal columns.:

```
<div class="flex flex-items-center flex-center">
	<div class="item flex-eq-col">
		1.
	</div>
	<div class="item flex-eq-col">
		2. 
	</div>
	<div class="item flex-eq-col">
		3.
	</div>
	<div class="item flex-eq-col">
		4.
	</div>
</div>
```

6. **Margin Helpers**  

WP Barebones also comes with margin and padding helpers that can be applied to the top and bottom of any block elements in a template. If you wanted to add helpers for the left and right of an element, simply copy and paste one of the existing mixins and modify the code accordingly.  

You'll see the "space count" variable is defined before the mixins. This is the value that controls how many helper classes will be available. 

For example, if you were to change the value to 18, the class topmargin-18 would work, but topmargin-19 would not.

The integers on the classes, i.e. topmargin-'10', are multipled by the 'base height' variable that is set in the 'assets/scss/base/variables' file. In this case, the value is 6px. 

This means that '.topmargin-10' would add a 60px margin to the top of an element.


```
//Margin Helpers
$spaceCount: 20;

//VERTICAL RHYTHM MARGIN TOP HELPERS (6PX INCREMENTS). Margin Top from 0 - 20 * Base Height
@mixin vr-topmargin{
  @for $i from 0 through $spaceCount {    
    $size: $i;
      .topmargin-#{$size} {         
          margin-top: calc(#{$base_height} * #{$size});
      }
      @media (max-width:$container-m){
        .topmargin-#{$size}-t {         
          margin-top: calc(#{$base_height} * #{$size});
        }
      }
      @media (max-width:$container-s){
        .topmargin-#{$size}-m {         
          margin-top: calc(#{$base_height} * #{$size});
        }
      }
  }
}

@include vr-topmargin;

@mixin vr-bottommargin {
  @for $i from 0 through $spaceCount {
    $size: $i;
      .bottommargin-#{$size} {         
          margin-bottom: calc(#{$base_height} * #{$size});
      }
      @media (max-width:$container-m){
        .bottommargin-#{$size}-t {         
          margin-bottom: calc(#{$base_height} * #{$size});
        }
      }
      @media (max-width:$container-s){
        .bottommargin-#{$size}-m {         
          margin-bottom: calc(#{$base_height} * #{$size});
        }
      }
  }
}

@include vr-bottommargin;

@mixin vr-toppad {
  @for $i from 0 through $spaceCount {
    $size: $i;
      .toppad-#{$size} {         
          padding-top: calc(#{$base_height} * #{$size});
      }
      @media (max-width:$container-m){
        .toppad-#{$size}-t {         
          padding-top: calc(#{$base_height} * #{$size});
        }
      }
      @media (max-width:$container-s){
        .toppad-#{$size}-m {         
          padding-top: calc(#{$base_height} * #{$size});
        }
      }
  }
}

@include vr-toppad;

@mixin vr-bottompad {
  @for $i from 0 through $spaceCount {
    $size: $i;
      .bottompad-#{$size} {         
          padding-bottom: calc(#{$base_height} * #{$size});
      }
      @media (max-width:$container-m){
        .bottompad-#{$size}-t {         
          padding-bottom: calc(#{$base_height} * #{$size});
        }
      }
      @media (max-width:$container-s){
        .bottompad-#{$size}-m {         
          padding-bottom: calc(#{$base_height} * #{$size});
        }
      }
  }
}

@include vr-bottompad;
```

Here is some example usage of the helper classes being used in a simple text block to space out the text elements:

```
	<div class="toppad-10 bottompad-10">
		<div class="text text-center">
			<h2>This Is A Section Title</h2>
			<p class="topmargin-2">
				Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsum dolorem, ad enim magni dolorum quas omnis quisquam quam, neque corrupti similique, reiciendis corporis. Consectetur accusamus, quisquam blanditiis repudiandae iusto velit!
			</p>
		</div>
	</div>
``` 

You can continue to add in helper classes as your theme requires them here or in theme specific files.


### Animations
WP Barebones also comes with a number of clean animations that can be applied to just about any element in a theme.

To start, you'll want to add the classes '.animation' and '.opaque' to any element you plan to apply an animation to. 

For example:

```
	<div class="animation opaque">
		<h2>Title Goes Here</h2>
		<p class="topmargin-2">
			Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nemo autem hic odio iure veniam officia, beatae quam atque dignissimos consectetur! Soluta vero distinctio quae atque sequi nostrum, eveniet dolorum, placeat.
		</p>
	</div>
```

There are a then a number of animation options that can be applied depending on the effect you're looking for. Each of the classes describe the effect you will see when applied.

```
.fade-in { animation-name: fadeIn; }

.fade-in-down { animation-name: fadeInDown; }

.fade-in-down-big { animation-name: fadeInDownBig; }

.fade-in-left { animation-name: fadeInLeft; }

.fade-in-left-big { animation-name: fadeInLeftBig; }

.fade-in-right { animation-name: fadeInRight; }

.fade-in-right-big { animation-name: fadeInRightBig; }

.fade-in-up { animation-name: fadeInUp; }

.fade-in-up-big { animation-name: fadeInUpBig; }
```

For example:

```
	<div class="animation opaque fade-in-up-big">
		<h2>Title Goes Here</h2>
		<p class="topmargin-2">
			Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nemo autem hic odio iure veniam officia, beatae quam atque dignissimos consectetur! Soluta vero distinctio quae atque sequi nostrum, eveniet dolorum, placeat.
		</p>
	</div>
```

These classes can be used in any of the template files you choose and can also be used in conjunction with any JavaScript functionality you plan to use. 

#### Animations Triggered By Page Scroll
WP Barebones also includes several helper classes that work in conjunction with Waypoints.js. When these classes are applied, the animations won't be triggered until the elements scroll into the viewport. This is a great way to quickly add in animations to a template that add some interactivity to the site.

These classes are 'fade-in-content', 'fade-in-content-left', 'fade-in-content-right'. For example:
```
<div class="fade-in-content animation opaque"></div>
<div class="fade-in-content-left animation opaque"></div>
<div class="fade-in-content-right animation opaque"></div>

or

<div class="flex flex-items-center flex-content-center">
	<div class="item animation opaque fade-in-content-left">
		Left Info
	</div>
	<div class="item animation opaque fade-in-content-right">
		Right Info
	</div>
</div>
```

#### Animation Delays
There are also classes that will allow you to delay, or stagger, the animation triggers. This allows you to make the animation of items in a set a bit more fluid. 

For example:
```
<div class="flex flex-items-center flex-content-center">
	<div class="item flex-eq-col animation opaque fade-in-content">
		Left Info
	</div>
	<div class="item flex-eq-col animation opaque fade-in-content animation-delay-1">
		Left Info
	</div>
	<div class="item flex-eq-col animation opaque fade-in-content animation-delay-2">
		Left Info
	</div>
</div>
```

The helper includes 5 levels of delay, but can be extended to add more as needed.

```
.animation-delay-1{
  animation-delay: .2s;
}
.animation-delay-2{
  animation-delay: .3s;
}
.animation-delay-3{
  animation-delay: .4s;
}
.animation-delay-4{
  animation-delay: .5s;
}
.animation-delay-5{
  animation-delay: .6s;
}
```

### Grid System
WP Barebones includes an easy to use grid system that has a similar usage to that of the Bootstrap grid stystem. The main difference is that this grid system is built in CSS Grid as opposed to using floats or flex box. 

Basic Grid Example: 
```
<div class="grid col-4">
	<div class="item">
	Column
	</div>

	<div class="item">
	Column
	</div>

	<div class="item">
	Column
	</div>

	<div class="item">
	Column
	</div>
</div>
```

The basic grid settings in 'assets/scss/base/grid' have a base grid gap set by the 'variables' file. 

```
$grid-margin:                                   12px !default;
$grid-margin-m:                                 12px !default;
$grid-margin-s:									12px !default;
```

If you want to increase the size of the grid gap though, you can use the utility classes 'xl-gap', and 'xxl-gap' to increase the size of the gap:
```
<div class="grid col-4 xl-gap">
	<div class="item">
	Column
	</div>

	<div class="item">
	Column
	</div>

	<div class="item">
	Column
	</div>

	<div class="item">
	Column
	</div>
</div>

<div class="grid col-4 xxl-gap">
	<div class="item">
	Column
	</div>

	<div class="item">
	Column
	</div>

	<div class="item">
	Column
	</div>

	<div class="item">
	Column
	</div>
</div>
```

The grid also has a number of responsive classes that you can use to change up your grid columns as the screen size changes. The responsive classes are built to be mobile first, so the classes utilize a 'min-width' breakpoint. 

So if you wanted a grid that would have 4 columns in desktop, 2 columns all the way down to the mobile breakpoint, and then a single column at the mobile breakpoint, it would look like this:

```
<div class="grid col-1 col-2-mobile col-4 xxl-gap">
	<div class="item">
	Column
	</div>

	<div class="item">
	Column
	</div>

	<div class="item">
	Column
	</div>

	<div class="item">
	Column
	</div>
</div>
```

### Containers & Breakpoints 

**Containers**  

WP Barebones includes a 'container' class that is used the same way as the container class in other CSS frameworks. 

In addition to the main container, there are also classes for 'large-contain', 'med-contain', and 'small contain'. These classes are not meant to be used in place of the 'container' class, but instead inside of the container class to create variation between the width of elements. 

For example, you may want to display a text element that's more condensed than an image block below it. That would look like this:

```
<section class="section">
	<div class="container">
		<div class="text text-center small-contain">
			<h2>Title Goes Here</h2>
			<p class="topmargin-2">
			Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dignissimos, perferendis reiciendis magni praesentium facere, fugit error velit. 
			</p>
		</div>
		<div class="image">
			<img src="/assets/images/image-url.jpg" alt="image name" class="responsive-img">
		</div>
	</div>
</section>
```

**Breakpoints**  

The responsive breakpoints for your theme are defined in the file '/assets/sass/base/variables'.  As you update the various container sizes, the breakpoints will update along with them. 

```
$container_pad: 								90px !default;

//Responsive Grid BP's
$container:                                     100% !default;
$container-mobile-s:							320px !default;
$container-mobile:								480px !default;
$container-xs:									690px !default;
$container-s:									768px !default;
$container-dz:									860px !default;
$container-m:                                   1024px !default;
$container-l:                                   1120px !default;
$container-xl:                                  1240px !default;
$container-xxl:                                 1440px !default;

// Responsive Breakpoints
$breakpoint-mobile-s:                           ($container-mobile-s + $container_pad) !default;
$breakpoint-mobile:                             ($container-mobile + $container_pad) !default;
$breakpoint-xs:                                 ($container-xs + $container_pad) !default;
$breakpoint-s:                                  ($container-s + $container_pad) !default;
$breakpoint-m:                                  ($container-m + $container_pad) !default;
$breakpoint-dz:                                 ($container-dz + $container_pad) !default;
$breakpoint-l:                                  ($container-l + $container_pad) !default;
$breakpoint-xl:                                 ($container-xl + $container_pad) !default;
$breakpoint-xxl:                                ($container-xxl + $container_pad) !default;
```

### Typography
All of the typography settings for WP Barebones can be found in '/assets/scss/base/typography'.  It includes general styling for all of the basic text elements including header elements (h1 - h6), paragraph, link, and span elements. 

There are also a number of typography related helper classes available. 

```
// Bold and Strong
b, strong, .strong { font-weight: 700; }

// Italics
em, .em { font-style: italic; }

.underline{
	text-decoration: underline;
}


.underline-title{
	@include font-size(1.8);
	text-transform: uppercase;
	letter-spacing: .5px;
	display: block;
	padding: 6px 12px;
	text-align: left;
	border-bottom:1px solid #e0e0e0;
	font-family:$body_font;
	font-weight:bold;
}

// Font Weights
.font-100 { font-weight: 100; }
.font-200 { font-weight: 200; }
.font-300 { font-weight: 300; }
.font-400 { font-weight: 400; }
.font-500 { font-weight: 500; }
.font-600 { font-weight: 600; }
.font-700 { font-weight: 700; }
.font-800 { font-weight: 800; }
.font-900 { font-weight: 900; }

// Font Styles
.font-normal { font-style: normal; }
.font-italic { font-style: italic; }

// Text Modifications
.uppercase { text-transform: uppercase; }
.lowercase { text-transform: lowercase; }
.capitalize { text-transform: capitalize; }

// Text Alignments
.text-left { text-align: left; }
.text-right { text-align: right; }
.text-center { text-align: center; }
.text-justify { text-align: justify; }
```

You can also use the typography file to define specific typography classes for 'page-title', 'pretitle', 'section-title', and 'subtitle'.  

### Mobile Navigation
WP Barebones includes a basic mobile navigation setup that is controlled in the files '/assets/blocks/header' and '/assets/js/core-js'. 

You can demo the out-of-the-box mobile navigation on the theme and make modifications to it as necessary. You can also remove it entirely by commenting out the related javascript and scss. 

### CSS Components File
The components file, '/assets/sass/blocks/components' has a number of utility components included that can be used globally. Some of these components are pure CSS and others utilize a mix of CSS and JavaScript.  

1. **Accordion**  

WP Barebones includes a basic accordion component that can be used to create collapsible content for things like FAQ's, services descriptions, and more. 

```
<div class="accordion">
	<div class="accordion-step active">
		<div class="title">
			Title Can Go In Here
		</div>
		<div class="content">
			Title Can Go In Here
		</div>
	</div>

	<div class="accordion-step">
		<div class="title">
			Title Can Go In Here
		</div>
		<div class="content">
			Title Can Go In Here
		</div>
	</div>

	<div class="accordion-step">
		<div class="title">
			Title Can Go In Here
		</div>
		<div class="content">
			Title Can Go In Here
		</div>
	</div>
</div>
```

2. **Split Blocks**

WP Barebones includes a "split blocks" component that will allow you to create offset grid layouts. The "split blocks" allow you to float images and content to the left and right of each other where the text will slightly overlay the images. 

If you wanted to float an image to the left with a content block to the right, the code would look like this:

```
<section class="section">
	<div class="container">
		<div class="split-blocks image-left">
			<div class="block-image">
				<img src="/assets/images/some-image.jpg" alt="some image">
			</div>
			<div class="block-content">
				<h2>Some Content Goes Here</h2>
				<p>
					Lorem ipsum dolor sit amet, consectetur adipisicing elit. Odio culpa placeat reprehenderit, earum ex fugit, illum, nam possimus soluta delectus dolorum blanditiis. Ab laboriosam neque, quis ex omnis est aspernatur.
				</p>
			</div>
		</div>
	</div>
</section>
```

3. **Split Sections**

"Split Sections" are similar to "Split Blocks", but they do not have any overlap. The split sections are configured to have a 40/60 split, so that the image will take up 40% of the width of the container and the content would take up 60%. 

If you wanted to float an image to the left with a content block to the right, the code would look like this:

```
<section class="section">
	<div class="container">
		<div class="split-section">
			<div class="image">
				<img src="/assets/images/some-image.jpg" alt="some image">
			</div>
			<div class="split-content">
				<h2>Some Content Goes Here</h2>
				<p>
					Lorem ipsum dolor sit amet, consectetur adipisicing elit. Odio culpa placeat reprehenderit, earum ex fugit, illum, nam possimus soluta delectus dolorum blanditiis. Ab laboriosam neque, quis ex omnis est aspernatur.
				</p>
			</div>
		</div>
	</div>
</section>
```

You can also modify the component so that the image and content blocks are each 50% by adding the class "even" to the "split-section" container element.

4. **Card Elements**
WP Barebones includes a number of card components that can be utilized.

**Basic Card**
```
<div class="card">
	<h2 class="card-title">Title Here</h2>
	<p>
		Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sed, labore, aliquid. Sunt voluptatibus corrupti et corporis excepturi sint autem? Blanditiis dicta, aut esse. Minus nihil nostrum, saepe magni voluptates beatae!
	</p>
</div>
```

**Image Card**
```
<div class="image-card">
	<div class="image">
		<img src="/assets/images/image.jpg" alt="image">
	</div>
	<div class="card-content">
		<h2 class="card-title">Title Here</h2>
		<p>
			Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sed, labore, aliquid. Sunt voluptatibus corrupti et corporis excepturi sint autem? Blanditiis dicta, aut esse. Minus nihil nostrum, saepe magni voluptates beatae!
		</p>
	</div>
</div>
```

**Horizontal Image Card**
```
<div class="horizontal-image-card">
	<div class="image">
		<img src="/assets/images/image.jpg" alt="image">
	</div>
	<div class="card-content">
		<h2 class="card-title">Title Here</h2>
		<p>
			Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sed, labore, aliquid. Sunt voluptatibus corrupti et corporis excepturi sint autem? Blanditiis dicta, aut esse. Minus nihil nostrum, saepe magni voluptates beatae!
		</p>
	</div>
</div>
```

### Forms
There are some very basic form and input styles that are setup in the file '/assets/sass/base/forms'.  I've left the styling here fairly minimal though so that it's not too complicated to customize the look and feel of your forms as needed.

As WP Barebones is setup to use Gravity Forms, there are also some basic styles included to update the look of the standard gravity forms output. 

You can also modify the layout of a Gravity Forms form by adding a few helper classes directly to the fields through the gravity form settings. 

These classes include: 'half-field' to make a field take up about 50% of the container, and 'clear-multi' which will allow for fields to float in a row using flex box.

## Basic UI Components
In addition to the CSS components, there are also a number of JavaScript based components that are integrated into WP Barebones.

### Sliders / Carousels
WP Barebones includes the Slick.js slider library that makes it easy to include sliders / carousels anywhere in your theme. Here is a basic example of how to include a slick slider:

```
<div class="slick-slider">
  <div><h3>1</h3></div>
  <div><h3>2</h3></div>
  <div><h3>3</h3></div>
  <div><h3>4</h3></div>
  <div><h3>5</h3></div>
</div>

<script>
$('.slick-slider').slick();
</script>
```

Slick can be initialized in the PHP file within a script tag, or in your theme's JavaScript file.

There are a number of properties that can be passed to the slick slider in an object. For example:

```
$('.slick-slider').slick({
	dots: true,
  	infinite: true,
  	speed: 300,
  	slidesToShow: 1,
  	centerMode: true,
  	variableWidth: true
});

```
For a full list of all of the different options available, you can read the [full Slick documentation here](https://kenwheeler.github.io/slick/)

**Responsive Sliders**
Sliders can also be built to be responsive so that the number of slides shown at any given time can change depending on the screensize. 

```
$('.slick-slider').slick({
  centerMode: true,
  centerPadding: '60px',
  slidesToShow: 3,
  responsive: [
    {
      breakpoint: 768,
      settings: {
        arrows: false,
        centerMode: true,
        centerPadding: '40px',
        slidesToShow: 3
      }
    },
    {
      breakpoint: 480,
      settings: {
        arrows: false,
        centerMode: true,
        centerPadding: '40px',
        slidesToShow: 1
      }
    }
  ]
});
```

### Modals
In addition to Slick.js, WP Barebones also includes a lightweight modal library called [iziModal](http://izimodal.marcelodolza.com/). 

You can [read the full documentation on iziModal here](http://izimodal.marcelodolza.com/), but here is a basic example of how it can be used.

**Template File**
```
<div id="modal" class="modal iziModal">  
    <div class="modal-content">
    	Content Here
    </div>
</div>
```

**Initialize The Modal In A JavaScript File**  
```
$("#modal").iziModal();
```

Now the modal can be triggered via data attributes being added to link or button elements, or it can be triggered via a JavaScript event.

**Data Attributes**
```
<a href="#" data-izimodal-open="#modal" data-izimodal-transitionin="fadeInDown">Modal</a>
```

**Click Events**
```
$(document).on('click', '.trigger-element', function (event) {
    event.preventDefault();    
    $('#modal').iziModal('open');
});
```

**Timeout Events**
```
setTimeout(function(){
	$('#modal').iziModal('open');
}, 1000)
```

## Custom Page Templates
Including custom template files in your theme is straightforward with WP Barebones. 

It's as easy as creating a new file inside of the '/page-templates' folder with a name like 'template-PAGENAME.php' where page name is a descriptive name for your template.

Within the template file place the following code to get started:

```
<?php 
/** Template Name: NAME GOES HERE */  
get_header(); 
?>
<div class="page">
	
</div>
<?php get_footer(); ?>
``` 

Now you can place all of your custom template code within the "page" div element (or replace this element with one of your choosing).

Now when you open a page within the WordPress CMS you will see the new template available within your "Custom Template" options. 

WP Barebones comes with a few basic page templates already setup and ready to go.  These include:

- Home Page
- Contact Page
- FAQs page
- Blog Index Page
- Single Post Page
- General Content Page

You do not need to use any of these page layouts though if you don't want to. You can find all of the styling for these pages within '/assets/scss/pages/base-pages'

## Custom Page Partials / Page Components
In addition to the page templates, WP Barebones also includes a number of template parts or "global components".  These include:

- Base Hero component
- FAQs Accordion component
- Testimonials Slider component

These components can be included inside of any page by including:

```
<?php echo get_template_part('partials/COMPONENT-NAME'); ?>		

For Example:

<?php echo get_template_part('partials/base-hero'); ?>		
```

As you develop modular blocks/global components that are to be used across multiple pages, you can include them as template parts to keep your codebase smaller and make it easier to make global changes to your theme.

# WP Barebones Functional Updates
In addition to all of the CSS & JavaScript helpers and components, WP Barebones also includes a number of functional improvements to make theme development a little bit easier.

## Custom Post Type Creation
Creating new custom post types is something that you'll inevitably need to do when developing a WordPress theme. Instead of including all of that bulky code within the main functions file, there is a file located at '/lib/cpt.php' that's specifically for this.

The file already includes a few common custom post types and custom taxonomies that can be used, modified or removed.

If you're unfamiliar with what a custom post type is, read up: (https://www.smashingmagazine.com/2012/11/complete-guide-custom-post-types/)


## Page Specific/Conditional CSS Loading

There is a block of code below where you enqueue the theme styles that will dynamically load CSS files. 

This code is already setup to find and load css files that are named to match custom post type template names and single post template names for custom post types.  

The template name is the name set at the top of the template files, for example a template named programs would look like this:

```
/** Template Name: Programs */  
```
If you wanted to load a CSS file specifically for this template, you would just create a new file in '/assets/sass' named 'programs.scss' without the leading underscore.

You can also copy and paste this same code block into the script enqueue and follow the same logic if you wanted to conditionally load JavaScript files.

2. **Dynamic Loading Explanation**  

If you're unfamiliar with the concept of dynamically loading CSS files on specific pages, this is a way to keep your CSS file size down and your website loading as quickly as possible.

For example, let's say there are certain elements, components, JS functions, or styles that will only be required on one page, then it doesn't really make sense to add all of that additional code to a "global" CSS or JavaScript file.  

By moving this code to page specific files, you're able to keep the overall size of your CSS and JavaScript files as small as possible without having to make compromises when it comes to your designs or functionality. 

3. **JavaScript Explanations**  

Along with the enqueue script function you'll see inside of 'wpbb_enqueue_script', there's also a '$php_array' that is defined. 

This array is used to a) localize your theme's JS file and b) establish a variety of variables that can be used in your JS file. 

Localizing the script allows for it to access these variables from your JavaScript file as well as make Ajax requests to your theme's functional files. 

For example, if you were to use store 'php_array.base_url' in a variable called 'base_url' in your main JavaScript file and then log the variable, you would see the result of 'get_home_url()' or your websites root domain.

## WP Utility Functions
WP Barebones a number of utility functions that simply create a shorthand for bulkier WordPress operations. Some of the functions in this file exist to support other functions, so it's not advised you make any direct modifications to this file. 

If you don't want to load it for whatever reason, you can comment the entire file out in the file 'lib/functions'. 

**Here are some of the useful functions**

1. **page_nav('menu_name')**  

This function can be used to include a menu from the WordPress CMS. To include the menu you just pass the name of the menu as a parameter to the function.

You can build the menus to go up to three levels deep and the function will output all of the links with clean HTML that is easy to style as needed.

```
<?php page_nav('main_menu'); ?>
```

2. **get_asset_url($file)**  

WordPress includes a function that outputs a URL relative to your template root, but this can become cumbersome when having to write out the full function name and then the path to the file.

"get_asset_url()" provides a direct path to the asset directory. It also allows you to pass the file path as a parameter to the function as opposed to having to write it out after the function. 

**For example:**
```
get_asset_url('images/image-name.png');
```


3. **get_image($imageObject)**  

Getting an image object and converting it to the image in the size that you want it in can require 8-10+ lines of code to return what you're looking for. 

With WP Barebones you can pass an image object to the 'get_image()' function and it will return an array of data. 

**For example this will return an entire image element:**
```
//"<img src='image.jpg' alt='alt' title='title' width='1800px' height='420px' >";
get_image($image, 'full')->elem;
```
**This will return an image url that can be used in an element:**
```
//path to uploaded file URL for the given size
get_image($image, 'full')->img;
```

Here's the full array that the function returns:

```
return array(
	'alt' => $alt,
	'title' => $title, 
	'img' => $thumb,
	'width' => $width,
	'height' => $height,
	'elem' => $elem
);
```


## WP Theme Functions File

In addition to the other functional files, there's also an empty functions file that you can include custom theme functions in.  

You can put all of your themes functions in this file, or create additional function files and require them in the file '/lib/functions.php'.

