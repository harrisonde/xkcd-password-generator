# xkcd password generator
This is the main repository for all things xkcd - passwords. [See it here](http://p2.harrisondestefano.com)

![xkcd image](https://raw.githubusercontent.com/harrisonde/xkcd-password-generator/master/images/comic.png "xkcd")

## What is an xkcd password generator?
The [xkcd password generator](http://xkcd.com/936/) strings together commonly used words in a random sequence. The goal is to create a unique password that is easy to recall from memory but difficult to guess.

## How's it all work?
The password generator builds unique passwords from a internal dictionary or user defined dictionary ( please see user defined dictionary below). Words are randomly selected from the dictionary and return to the form via AJAX. Optionally, a series of arguments can be provided by modifying the form configuration to produce an even more complex password.

### Built-in dictionary
The application generates password phrases from an internal dictionary of words. The dictionary currently holds 2,091 common english words.

### User defined dictionary
If specified by a modification of the form configuration, a custom dictionary can be created by scraping text from a webpage. To build said dictionary, a URL must be provided with a the protocol and fully qualified domain. If  a URL is not found an error is thrown.

##User Interface
### HTML, CSS, and JavaScript
The applicaion is constructed with HTML5, CSS3 and JavaScript. All the really fancy goodies are driven by Bourbon, Neat, Bitters, and Refils. Big thanks to the thoughtbot for maintaining and funding the project. Don't know where the development community would be without folks like these!

####Requirements
The application is written to work with all modern browsers that enable support for HTML5 and CSS3. The following minimum requirements must be met for the application to run:

* PHP 5.3.23 (min)
* jQuery 10.1.2 (min)
* HTML5
* CSS3

## How can I use this in my project?
Well, get the project source and enjoy!
