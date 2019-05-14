#Changelog

An overview of all noteworthy changes in chronological order (newest on top)

####2019/04/??
- A minor makeover of the general styling (a new font) and revisit of the home page. The print job success rate pie chart and heatmap
  are now relocated to the home page. The Equipment and Filament Statistics card have been removed to allow for more space for newer content.
- Introducing two new info cards on the home page. 
  First, a card that shows the latest 3D Printing news coming from 3DPrint.com. 
  Secondly, to inspire you for a next project, a card showing Thingiverse's 5 most popular thingies in a visual carousel.

  ![3D Printing News](../images/docs/volta_home_news.png "3D Printing News")
  
  ![Thingiverse](../images/docs/volta_home_thingiverse.png "Thingiverse")

- The Print Jobs table now shows totals for the used filament and print time. The totals are calculated automatically depending on your filter settings.

  ![Print Job Totals](../images/docs/volta_printjobs_subtotal.png "Print Job Totals")

- Changed the table caption of the Print Jobs table to indicate the number of print jobs found/filtered.

  ![Print Job Caption](../images/docs/volta_printjobs_caption.png "Print Job Caption")

- Added the Prusa MK2.5, MK2.5S and MK3S to the list of machines. 

####2019/02/18
- Added the ANYCUBIC product range to the list of machines. 
- Changed structure and loading of the UI (JavaScript), so that it will automatically load parts of the code only when they are actually needed. This will reduce the loading times (i.e. enhance performance).
- Internal work performed to improve deployment to production.

####2019/02/06
- Added requirement that newly registered users need to perform an e-mail verification.
  An e-mail will be sent to the user's registered email address to confirm his/hers address.

####2019/02/02
- A new feature has been added: Print Jobs (Tracking and managing print jobs from all registered printers).
  Check out the [Print Jobs](/docs/printjobs) documentation for more details.

####2019/01/22
- The Printer Widget will now show the print job details once a print has been completed. Before it would immediately show "Ready" after print completion.

  ![Print Job Finished](../images/docs/volta_octoprint_finished_job.png "Print Job Finished")

- The extruder and heat bed temperatures will only be displayed during the printing phase. During other phases (e.g. "Ready", "Paused", etc.) temperature readings are not yet being retrieved and would otherwise show inaccurate numbers on the widgets. 
- Styling corrections made in various pages (Login, Registration, Equipment, etc.) to be in line with the latest Bootstrap CSS framework version.

####2019/01/17
- Increased the limit of printers visible on the Dashboard to **6**. Printers are displayed in the left 2 columns and 3 rows in an alternating fashion, and in the order they have been registered through the Volta OctoPrint plugin.
- The welcome message (Participation of the Alpha Test) for newly registered users is now shown as a popup.
- Upgraded Server OS to Ubuntu 18.04LTS and backend application framework for better performance (and necessary security updates). 

####2019/01/13
- The main navigation stays now fixed at the top of the page so important items such as the dashboard, documentation, etc. are always within reach.
- Minor redesign of the page layout where the main navigation items are now available on the left side. This navigation sidebar on the left has more space for future items.
- The welcome message on the home page is only shown after the registration.
- Fixed an issue where the clock would not get displayed when a user just has registered. Default preferences are now set correctly, which can of course be altered as needed.  

####2019/01/09
- The equipment screen has a new column showing the current status of the printer. If you have multiple printers paired, you can quickly get an actual indication what each printer is doing.

    - ![Printing](../images/docs/volta_equipment_status_printing.png "Printing") Green pulsating indicator showing a print is in progress.
    
    - ![Offline](../images/docs/volta_equipment_status_offline.png "Offline") Red indicator showing the printer is Offline or Disconnected.
    
    - ![Paused](../images/docs/volta_equipment_status_paused.png "Paused") Orange indicator showing the current printjob has been paused.
    
    - ![Ready](../images/docs/volta_equipment_status_ready.png "Ready") Blue indicator showing the printer is operational. 
    
    - ![Unknown](../images/docs/volta_equipment_status_unknown.png "Unknown") Gray indicator showing the status is unknown.   
  
  Hover your mouse pointer over the indicator to see a description of the status. 
  
  The Equipment screen is checking every 20 seconds for the status of the paired printers. The intention of the status indicator is not to give a real-time update, only a high level status indication.
- Ensured all widgets will get populated after the browser cache is cleared. For the printer widget, if - for whatever reason - no updates have been received after 5 hours while printing, the printer is assumed to be offline/non-operational.

####2019/01/07
- Added printer models for LulzBot, Prusa, and Creality3D.
- Fixed the order of the names in model drop down list on the Equipment form (Add/Edit).
- To better see the current hour / minute, ticks marking the hour have been added to the analog clock.
- The name of the printer widget is now a hyperlink, allowing you to open the OctoPrint instance on which that printer is running on.

####2019/01/03
- Added a page to the documentation section showing all the requested new features.

####2018/12/20
- Minor improvement done to the Slicer and Firmware widgets. A better visual aid (little green pill) to show that a new release was published.
- Although you don't need it, editing your printer from the Equipment is now possible (previously rendered an error).
- The temperature in the Weather Widget can be displayed in Fahrenheit as well.
- The Clock Widget is now also available in a digital version.
- User settings can now be adjusted/saved in the new Preferences page.
