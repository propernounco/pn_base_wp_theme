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

**1. Update The Theme Directory**
The first thing you'll want to do is change the name of the theme's directory from 'base_theme' to whatever it is you're going to call the theme. 

**2. Update Styles.css With Theme Name**
WordPress will pull the name of the theme itself from the styles.css file. You'll find this file in the root of your theme. Just open it in a text editor and update the details you see accordingly. **I don't actually suggest using this file for styling your theme.** 

**3. Add Screenshot.png**
The 'screenshot.png' file is what will be used for the theme's thumbnail in the WordPress appearance settings. You can upload anything you'd like here, just make sure it's named 'screenshot.png'.

**4. Enable Plugins**
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

**5. Add A Home Page and Update Settings**
Next you'll want to click on "Pages" and then click "Add New". Type "Home Page" into the title, select "Home Page" from the custom template dropdown, and then click save.

Now, hover over Settings and click on "Reading".  Now select "A Static Page" for "Your Homepage Displays" settings, and select the home page you just created as the "Homepage".

**6. Reset permalinks**
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

**1. Update Scripts Settings**
The gulp file comes configured to use a couple of JavaScript libraries for common website utilities. The basic file includes:

- [iziModal](http://izimodal.marcelodolza.com/) for clean, attractive website modals.
- [Feather Icons](https://feathericons.com/) for easy to use website icons 
- [Waypoints](http://imakewebthings.com/waypoints/) is a helpful JS library that allows you to trigger JS functions as elements enter or leave the view.
- [Slick](https://kenwheeler.github.io/slick/) is a slider library for things like home page sliders, testimonial carousels, product carousels, or anything else you want to turn into a slider.

You don't have to use any of these in your build.

The Gulp file also includes three JavaScript files that are specific to the theme: util-scripts.js, core-js.js and theme-js.js. 

Util-scripts.js includes a function that will identify the browser and browser version that a user is browsing from.  If it's a browser with known compatibility issues, it will apply special classes to the website body as well as several website components so that they can be modified for older browsers as needed.

Core-js.js sets up a variety of core theme functions. These include things like intiializing feather icons, creating interactive navigation dropdowns, handling mobile navigation triggers, and more. You can look through the file itself to get a better idea of what it includes.  You can also feel free to make changes to the file if you feel it's necessary. 

**2. Update Theme JS File**
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

3. **'.image-contain'**  

This class works similarly to the '.image-cover' class, but instead of 'object-fit:cover' it applies the property 'object-fit:contain'. 


### Animations

### Grid System

### Typography

### Mobile Navigation

### CSS Components

### Forms
Gravity forms classes (half-field, clear-multi)


## Basic UI Components


### Sliders


### Modals


### Accordions


## Page Templates


## Page Partials / Reusable Components


## Custom Post Types


## Page Specific/Conditional CSS Loading


## WP Theme Functions File


## WP Util File

