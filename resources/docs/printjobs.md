#Print Jobs

Print Jobs in Volta will give you a deep dive insight in all the print jobs made with your registered 3D printers. You can easily search for print jobs that have failed for a particular printer, or when it was the last time you printed that 3DBenchy for example.

![Print Jobs](../images/docs/volta_printjobs.png "Print Jobs")

There is no particular setup or configuration needed. All print job information is automatically recorded via the OctoPrint Plugin. The only requirement is that you need to have the latest version (>= v0.2.0) of the OctoPrint plugin installed on your OctoPrint instance.

The print job page consists of three main elements:

###1. Success Rate Metric
A simple donut chart showing you the success rate (successful vs failed prints) of all your print jobs in the last year.

![Print Jobs - Success Rate](../images/docs/volta_printjobs_successrate.png "Print Jobs - Success Rate")

_Note: The Success Rate metric is not real-time, meaning that completed/failed print jobs in the background are not immediately reflected. You can refresh the Success Rate by clicking on the little circle icon in the top right hand corner._

###2. Heat Map
A different way of seeing what day of the week or month of the year you print the most (or the least) is presented by the heat map. Hovering over the map shows you little more details about the number of print jobs that day.

![Print Jobs - Heat Map](../images/docs/volta_printjobs_heatmap.png "Print Jobs - Heat Map")

_Note: The print job heat map is not real-time, meaning that completed/failed print jobs in the background are not immediately reflected. You can refresh the heat map by clicking on the little circle icon in the top right hand corner._

###3. Print Job History
An interactive table allowing to quickly navigate and search in all of the print jobs ever made, for all of your registered printers.

![Print Jobs - History](../images/docs/volta_printjobs_history.png "Print Jobs - History")

####Filters
The print job table has 3 filters that helps quickly search to your print job history:

1. **Search**: Use this field to find a print job by name or its Job ID
2. **Result**: Use these buttons to filter print jobs of a particular result (i.e. 'Successful', 'Failed', or 'In Progress) 
3. **Printer**: Use the drop down menu to show print jobs of one of your registered printers.

####Sorting
The print job table allows to sort on most of its columns, simply by clicking on the column header names. By default the print job table is sorted by the print job start date (with the latest on top).

####Navigation
If you have a lot of print jobs made, you can also navigate through the list by using the navigation arrows at the bottom of the table.

####Actions
You can perform some actions on each print job. Click on the three dots in the last column of the table for a particular print job you can:

- **Delete** a print job: If you believe the print job should not be listed, you can simply delete it. 
- **Mark as Successful**: In case you feel that print job registered as being failed is incorrect,
you can mark it as successful.
- **Mark as Failed**: In case you feel that a successful print job is in fact not, you can mark it as failed.

Please note the following:

- The statistics (success rate and heat map) are not immediately reflected by either one of the aforementioned actions. 
- In progress jobs will not have any option to take an action. Only once a print job has been completed (success or failed), you can use one of the aforementioned actions. 

