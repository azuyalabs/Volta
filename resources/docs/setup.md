#Setup

With the registration completed, please follow these steps to have everything setup and configured to use the Volta Dashboard.

###1. User profile
Navigate to your Volta [profile](/profile) and take note of your settings.

Name
:   Your full name as you registered it. You can change this any time.

E-Mail Address
:   This is your username is only used for signing in. You can change this any time.

API Token
:   Your unique Volta API Token. This token is needed for the OctoPrint plugin (See #2 'Install the OctoPrint Plugin). Please keep it safe!

Language
:   *Disabled* At the moment only English is supported. In the future other translations will be made available.

City
:   The city field is used for retrieving your local weather, which will be displayed on the Dashboard.

Country
:   Your location on this rock. The country field is used to display related content such as public holidays.

Main Currency
:   The default currency for your business in Volta. (Future use).

###2. Install the OctoPrint Plugin
Next step is to install the Volta OctoPrint plugin. This plugin will communicate with the Volta server so your printer events and statistics are updated in real-time.

####Install the plugin
On your Octoprint instance, navigate to '**Settings > Plugin Manager**'. In the Plugin Manager screen, click on the "**Get More**" button to allow for manual installation of plugins. The following screen will open:

![Install new plugin](../images/docs/volta_octoprint_plugin.png "Install new plugin")

Copy and paste the the following URL of the plugin in the '**...from URL**' field: "https://github.com/azuyalabs/OctoPrint-Volta/archive/v0.2.0.zip"

Octoprint will try to install the Volta OctoPrint Plugin now. It may take a bit of time as the plugin depends on some large libraries.

Once completed, you will see a new item "**Volta**" in the **Plugins** section on the left hand side of Octoprint's Settings.

####Upgrade the plugin
Upgrading the plugin takes the same steps as installing the plugin.  

Simply copy and paste the the following URL of the plugin in the '**...from URL**' field: "https://github.com/azuyalabs/OctoPrint-Volta/archive/v0.2.0.zip" in the Plugin Manager screen of OctoPrint's Plugin Manager (See previous section for details).

####Configuration
Click on the "**Volta**" item in the **Plugins** section on the left hand side of Octoprint's Settings. The Volta Configuration screen will open:

![Configure Volta Octoprint plugin](../images/docs/volta_octoprint_config.png "Configure Volta Octoprint plugin")

In the **API Token** field, enter (copy/paste) your Volta API Token. You can find yours in your Volta [profile](/profile).


All is done! Repeat these steps for every Octoprint instance you have, using the same API Token. (Note: your account is currently limited to 6 printers only).

###3. Open your Dashboard
Finally you can open your Volta Dashboard by clicking the ![!Live](../images/docs/volta_dashboard_link.png "!Live") button on top of the page.

Your dashboard should be up and running. Keep in mind that the status of your connected printers only start to appear once you start a printjob. Other information, like the Slicer releases widget for example, work immediately and will get updates automatically.

Although I've tested Volta extensively, issues will likely occur. Please have a look at the [FAQ](/docs/faq) page where you can also find details how to contact me.

Enjoy!