#Frequently Asked Questions

The documentation is hopefully clear enough, however you might still have some questions. 
Below you can find some answers to frequently asked questions.

####I am stuck and something is broken. What can I do?
There are no 'official' support channels yet. However in case something is not working or if you have a question, you can reach me here:

- [Facebook Group: Volta Dashboard - Alpha Test](https://www.facebook.com/groups/307684149856586/)
- [Email: volta@sachatelgenhof.com](mailto:volta@sachatelgenhof.com)

####Why is Volta a Cloud based solution and not a standalone one?
Volta - and in particular the Dashboard - use some technologies that would require pretty extensive expertise in installing and configuring Volta. 

Having Volta available online means anyone can use it immediately without any complicated or cumbersome installation procedure. 

Another reason is that the Dashboard uses information in realtime and common information can be pushed to all connected users immediately without the need to refresh the page.

####Can Volta be installed locally?
Although technically possible, at the moment it is not ready for that yet. At least not easy. The first step is to see if Volta works well as a prototype.

####I can't find the OctoPrint Volta plugin in Octoprint's Plugin manager. Where can I get it?
The OctoPrint Volta plugin is not (yet) released publicly to the Octoprint Plugin repository. Once the software reached proper stability, it will be possible to install it through the plugin manager.

You can use this URL when installing the plugin through OctoPrint's Plugin Manager: "https://github.com/azuyalabs/OctoPrint-Volta/archive/develop.zip"

####Is Volta Open Source?
The OctoPrint plugin is. The server part is not released (yet). I am still considering whether it should be or not. :)

####I've connected one of my printers but it's not showing up
If that printer is your seventh one, then indeed it will not show up. As a precaution (performance), each user is limited to a maximum of 6 printers.

####The printer I've added isn't showing on the Dashboard at all
Assuming the API token was added correctly on your OctoPrint instance, you may need to refresh the Dashboard page (F5/Ctrl-R). At the moment newly added printers will only appear after the page is reloaded. (I'm working on a solution where a refresh isn't needed).

####Where can I request a new feature / enhancement?
Please checkout the [Wishlist](/docs/wishlist) page to see what has been requested already and how you can submit a new one.