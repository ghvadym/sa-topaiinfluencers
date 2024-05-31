# WOP lab Default theme
## Gulp.js usage
- Open dev folder in the terminal
- Install packages: **npm i** *(do it once)*
- Run gulp file: *npm run start*

## Styles
### Fonts connections
Just add new line with font settings to the **$icons** array
```scss
$icons: (
    'Gotham' 'GothamPro-Bold' 600 normal,
    'Lato' 'Lato-Italic' 400 italic
);
```

### Creating new style file
Create new file e.g. '/assets/scss/pages/front-page.scss'

Go to the app.scss and connect them
```scss
@import "pages/front-page";
```

## Backend
Write the code in the files which suitable for your aims, if it's needed to create new ones and connect them in the **init.php** file *( inc/init.php )*
```php
$files = [
    'add new file name here'
];
```
p.s. Take care of the correct order.

### Helper functions
Write backend logic in separated files. Use functions from the **inc** folder in order to make your code cleaner. Create new functions in the suitable files.

### Templates parts

Use template parts to move the code to a separated templates
```php
//Standard
get_template_part('template-parts/cards/card/card', 'post', $post);

//OR

//Custom function
get_template_part_var('template-parts/cards/card/card-post', [
    'post' => $post
]);
```

### Avoid critical errors via checking data on existing and empty before using them

```php
//Connected template parts

//Example for get_template_part
if (empty($args)) {
    return;
}

//Example for get_template_part_var
if (empty($post)) {
    return;
}

//Example for functions
function get_thumbnail_url(int $post_id = 0, string $size = 'large'): string
{
    if (!$post_id) {
        return '';
    }
    //code
}
```

Create understandable names for variables and functions in order to avoid unnecessary comments with descriptions.

## Functions

### get_svg()

Getting svg file by name

```php
get_svg('icon_name');
```

### _get_field()
This function do check and return html, if the field has value.
```php
$fields = get_post_meta($post->ID);
// OR $fields = get_fields($post->ID);

$subtitle = get_post_meta($post->ID, 'default_post_subtitle', true);
//OR $subtitle = get_field('default_post_subtitle', $post->ID);
//OR $subtitle = $fields['default_post_subtitle']);

_get_field($subtitle, 'card__footer');
```

```html
<!--Result-->
<div class="card__footer">
    $subtitle value
</div>
<!--Or empty value if $subtitle is empty-->
```

## _get_posts() and _get_terms()
These functions contain default arguments, you should add/overwrite them by adding yours in the argument.
```php
$posts = _get_posts([
    'post_status' => ['publish', 'draft'],
    'numberposts' => 1
]);

$product_cat = _get_terms([
    'taxonomy' => 'product_cat',
    'number'   => 1
]);
```

## register_ajax()
Use this function for registering ajax. You just must add title to the array in the function argument.
```php
register_ajax([
    'get_posts_request'
]);

function get_posts_request()
{
    //Processing ajax request 
}
```
Add action argument to your ajax request
```javascript
$.ajax({
    //Arguments
    data : {
        'action' : 'get_posts_request'
    }
    //Processing
});
```

### get_widgets()
Add titles of created widgets for output them
```php
get_widgets([
    'Footer nav 1',
    'Footer nav 2',
    'Footer nav 3'
]);
```
### insert_log_data()
This function writing data to the file in the root ot theme.
```php
insert_log_data($response_api->items);
```

### cut_str()
Cutting string, removing tags, spaces and encoding to UTF-8.
```php
cut_str($post->post_content, 200);
```

### get_thumbnail_url()
Get the post thumbnail url and replace it with the default image url if it does not exist.
```php
get_thumbnail_url($post->ID, 'medium');
```

### img_url()
Get image url by name. The image must be in the folder **assets/img**.
```php
img_url('arrow.svg');
```

### base64_file()
Generating base46 file by path.
```php
base64_file(get_stylesheet_directory() . '/assets/img/certificate.jpeg');
```

### load_file_by_url()
Upload a new attachment by url.
```php
load_file_by_url($file_url);
```

### save_file()
Upload a new attachment using $_FILES.
```php
$img = $_FILES['post-img'] ?? '';
$img_id = save_file($img);
```

