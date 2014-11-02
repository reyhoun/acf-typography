# ACF Typography Field

Typography with Google Fonts Field for Advanced Custom Fields

![Alt text](http://reyhoun.com/lab/acf-typography.png "Optional title")

-----------------------

### Compatibility

This ACF field type is compatible with:
* ACF 5

### Installation

1. Copy the `acf-typography` folder into your `wp-content/plugins` folder
2. Activate the Advanced Custom Field: Typography plugin via the plugins admin page
3. Create a new field via ACF and select the Typography type
4. Please refer to the description for more info regarding the field type settings

-----------------------

5. If you would like the list to be pulled from the Google API you will need to define your API key. 
	You can do this in the 	theme's function file for example.

	`define( 'YOUR_API_KEY', '**your_google_api_key**' );`

 	just head on over to the [Google API Console](http://cloud.google.com/console), create a new project and get a browser api key.

### Subfields
* Google Font Family
* Google Font Weight
* Backup Font Family
* Text Align
* Text Direction
* Font Style
* Font Size
* Line Height
* and Live Preview Fonts