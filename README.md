# ACF Typography Field

Typography with Google Fonts Field for Advanced Custom Fields

![ACF Typography Field](https://raw.githubusercontent.com/reyhoun/acf-typography/master/screenshot.png "ACF Typography sample field")

## Subfields
* Google Font Family
* Google Font Weight
* Backup Font Family
* Text Align
* Text Direction
* Font Style
* Font Size
* Line Height
* and Live Preview Fonts

-----------------------

## Compatibility

This ACF field type is compatible with:
* ACF 5

## Installation

1. Copy the `acf-typography` folder into your `wp-content/plugins` folder
2. Activate the Advanced Custom Field: Typography plugin via the plugins admin page
3. Create a new field via ACF and select the Typography type
4. Please refer to the description for more info regarding the field type settings
5. If you would like the list to be pulled from the Google API you will need to define your API key. 
	You can do this in the 	theme's function file for example.

	`define( 'YOUR_API_KEY', '**your_google_api_key**' );`

 	just head on over to the [Google API Console](http://cloud.google.com/console), create a new project and get a browser api key.

## Changelog

#### 0.6.4
* Improve markup of preview iframe

#### 0.6.3
* Bug fix: load font-family(move preview to an iframe)
* Clean Codes & 50 jshint.com warning fixed

#### 0.6.2
* Bug fix: default font-weight return 'regular'
* Remove letter-spacing from required check

#### 0.6.0
* Add required check

#### 0.5.0
* Compatible with [Github Updater](https://github.com/afragen/github-updater)
* add language pot file
* add changelog file
* add required check

#### 0.4.0
* Add letter spacing
* bug fix: Font Style
* bug fix: API KEY
* Some bug fixes

#### 0.3.1
* Some bug fixes

#### 0.3.0
*Add: Color Picker

#### 0.2.0
* Add: Style for display fields 

#### 0.1.2
* bug fix : When Load more than one typography field in a page
* bug fix : Font Size label show display
* bug fix : 400 to place regular in Font Weight
* bug fix : Change font style label
* bug fix : Add font style field

#### 0.1.1
* Some bug fixes
* Clean Files & Codes.

#### 0.1.0
* Initial Release.