# Universal Keyword Search

If you liked [Safari Keyword Search](https://github.com/arnemart/SafariKeywordSearch) but are disappointed that it doesn't work in Safari 5.2, here's a solution. That is, if you don't mind some light hacking.

Keyword search is a simple but powerful feature that, for example, lets you search Amazon for iPad cases by typing `a ipad cases` in the address bar. The following search engines are included, and you can easily add and edit as much as you want:

 * **a**: Amazon
 * **down**: Down for Everyone or Just Me
 * **e**: eBay
 * **imdb**: IMDB
 * **p**: Pinboard (searches your bookmarks only)
 * **rt**: Rotten Tomatoes
 * **so**: Stack Overflow
 * **w**: myweather.com local forecast
 * **wi**: Wikipedia
 * **wo**: Wolfram Alpha
 * **y**: YouTube

## How it works

Universal Keyword Search is just a PHP script that looks for keywords (such as 'a' for Amazon) at the beginning of your search string, and sends the rest of the query to the appropriate site (such as amazon.com's search page).

Since you can't add custom search engines in Safari, a little trickery is needed. Universal Keyword Search employs the `hosts` file to map `http://search.yahoo.com` to a local web server that's hosting it's PHP script. This way, all you have to do is set Safari (or any other browser on your system) to use Yahoo search. No browser hacks or extensions needed.

**Note:** this means that you can't use the actual Yahoo! search at all. I don't expect this to be a big deal since Yahoo! is now powered by Bing anyway.

## Why not use ____?

There are other ways to use a search engine other than Google, Bing, or Yahoo and enable keyword functionality. For example [DuckDuckGo](http://duckduckgo.com/) suggests several options to use their search engine in Safari:

*1. Install [a Safari] extension (adds a small toolbar).*

I don't need another toolbar, and you probably don't either.

*2. Install Glims, which can add search engines.*

While [Glims](http://www.machangout.com/) may work fine for you, there's no getting around the fact that it's [hacking Safari](http://macjournals.com/blog/2008/03/19/input-managers-are-not-plug-ins/). At best, this means some things will break with every new Safari release, and at worst it will cause stability problems. I try to avoid this sort of stuff if I can.

*3. Install GlimmerBlocker and use the DuckDuckGo filter.*

This is definitely a better way to go, but [Glimmer Blocker](http://glimmerblocker.org/) effectively disables [Little Snitch](http://www.obdev.at/products/littlesnitch/index.html) so it doesn't work for me.

*4. If you know what you're doing, [hack the binary](http://hints.macworld.com/article.php?story=20030514035516436)!*

The simplest and probably most benign option, but you're still stuck with DuckDuckGo's keywords ([!bang syntax](https://duckduckgo.com/bang.html)), you'll have to re-hack the binary after every update, and no one knows how long the hack will keep working.

Universal Keyword Search gives you full control over your default search engine and keywords, and applies the same settings across all browsers on your machine. Since it's not an add-on, extension, or plugin, browser upgrades will never break it so long as they allow you to set Yahoo! as your default search engine.

## Installation

*Note that configuring Universal Keyword Search currently requires an unreasonable amount of command-line work. If you're not ready for that, check back later and hopefully I'll have streamlined this. The good news is that if you do take the plunge, you only have to do it once (per computer).*

Universal Keyword Search works on any Mac (or any other UNIX-like OS, for that matter) and needs a web server, such as Apache, running on your local machine with PHP enabled in order to function.

Assuming you don't already have such a server running, here's how to set up Universal Keyword Search using Mac OS X's built-in Apache server. *Skip to step 3 if you already have a local server that can run PHP (and substitute your server's document root if needed).*
 
 1. Edit the Apache config file. For example, in Terminal run:

        mate /etc/apache2/httpd.conf

    At line 50, uncomment & change:
    
        #Listen 12.34.56.78:80
    
    to:
    
        Listen 127.0.0.1:80
    
    This prevents access to the server from outside your local machine.
    
    Then uncomment line 111 to enable PHP:
    
        LoadModule php5_module libexec/apache2/libphp5.so
    
 2. Open 'System Preferences' and go to 'Sharing', then check the 'Web Sharing' box to start Apache. (If it was already running, uncheck then recheck the box so the above configuration changes take effect.)
 
 3. Clone the Universal Keyword Search repo into the server's root:

        cd /Library/WebServer/Documents
        sudo mkdir search
        sudo chown <your-username> search
        sudo chgrp staff search
        git clone git://github.com/lhagan/universal-keyword-search.git search
     
 4. Test that everything's working so far by visiting [http://localhost/search?p=test](http://localhost/search?p=test) in your browser. You should see some search results for `test` come up.

 5. Modify your `hosts` file to redirect `search.yahoo.com` to the server you just setup:

        sudo sh -c 'echo "127.0.0.1\tsearch.yahoo.com" >> /etc/hosts'
    
    (If you'd prefer, you could `mate /etc/hosts` and manually add `127.0.0.1  search.yahoo.com` after the last line instead.)

 6. In Safari Preferences, change your default search engine to Yahoo!.
 
 7. Try searching for something using Safari's location bar. You should get results from Ixquick's [Start Page](https://startpage.com/) instead of Yahoo!. Congratulations, you made it!
 
 8. You can modify the default search engine and keywords by editing the PHP file to suit your needs.
 
        mate /Library/WebServer/Documents/search/index.php
