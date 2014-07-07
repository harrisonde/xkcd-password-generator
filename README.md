# xkcd password generator
This is the main repository for all things xkcd - passwords. 

## What is an xkcd password generator?
The [xkcd password generator](http://xkcd.com/936/) strings together commonly used words in a random sequence. The goal is to create a unique password that is easy to recall from memory but difficult to guess.

## How's it all work?
The password generator builds unique passwords from a internal dictionary file or user defined list ( please see user defined list below). Words are randomly selected from the dictionary and return to the from via AJAX. Optionally a series of configuration options ( arguments ) can be provided by the user to produce an even more complex password. 

### User defined list
If specified by a user, a custom dictionary of words can be created on the fly. To build said list, a URL must be provided with a the protocol and fully qualified domain. The dictionary items (words) are created by scraping raw HTML from the URL, tags are removed and a raw string is returned and parsed. If  a URL is not found an error is thrown.

## How can I use this in my project?
Well, just get the project source and enjoy! 