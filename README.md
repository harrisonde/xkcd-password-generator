# xkcd password generator
This is the main repository for all things xkcd - passwords. 

## What is an xkcd password generator?
The [xkcd password generator](http://xkcd.com/936/) strings together commonly used words in a random sequence. The goal is to create a unique password that is easy to recall from memory but difficult to guess.

## How's it all work?
The password generator builds unique passwords from a internal dictionary or user defined list ( please see user defined list below). Words are randomly selected from the dictionary and return to the form via AJAX. Optionally, a series of arguments can be provided by the user to produce an even more complex password. 

### User defined list
If specified by a user, a dictionary can be created by scraping text from a webpage. To build said dictionary, a URL must be provided with a the protocol and fully qualified domain. If  a URL is not found an error is thrown.

## How can I use this in my project?
Well, just get the project source and enjoy! 