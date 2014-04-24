/*

	Sitemason® Custom Interface
	presidents.js
	
	The interface file for the "Presidents" tool used in the Sitemason
	Boilerplate template.
	
	Sitemason has no "Presidents Database" Tool, so we're going to make one out of a News Tool.
	A News Tool is a good choice because it is very flexible - it has many fields - but the
	fields are set up for publishing news articles or a blog - not a database of Presidents of the
	USA.
	
	We could leave things as-is, but that would require making sure to tell the content editors
	to make sure they use the Title field for the Last Name, the Summary field for the First Name,
	ignore a TON of fields that we won't use, etc, etc.  It would be a whole lot nicer if we tailored
	the interface for our needs, which we can do with this file.
	
	Our strategy for re-tasking a News Tool for our Presidents Database Tool is as follows:
	
	Content Tab: enter the first name, last name, and bio.  We want to keep the first and last names
	in separate fields because we may end up doing some sorting on the front-end.
	
	Picture Tab: the President's photo.
	
	Publish Tab: the start and end dates of the President's term in office
	
	Tags: we'll use a Tag to designate political party
	
	Location: the President's home state.
	
	For each of those tabs, we'll re-label, add, and remove fields as needed to keep the interface
	clean and easy for the content editors to use - the field labels will make it very logical for
	the content editors to know what needs to go where.
	
*/


/*
	Modify the Tool verbiage to suit our purpose
*/
modifyLabels( {
   toolLabel: 'President Database',
   toolLabelPlural: 'President Databases',
   itemLabel: 'President',
   itemLabelPlural: 'Presidents'
} );


/*
	Modify the Tool-level panel.  This is what the editor sees when first tapping on this Tool.
	In this case, since we're using News, which is a list-based Tool, this panel is a listing of Items.
	
	We want the columns to be:
	
	- Start Date
	- Last Name
	- First Name
	- Tags

*/
modifyConf('toolPanel', function() {

	// we don't need the Subscriptions tab, so remove it
	this.getTab('subscriptionsTab').remove();

	// modify the Items tab (itemsTab)
	var itemsTab = this.getTab('itemsTab');

	// if you want to see a list of all of the stock column names, un-comment this
	/*
		var columnNames = itemsTab.getListColumnNames();
		console.info('Items tab\'s column names:'); console.dir(columnNames);
	*/
	
	// we don't care about these fields, so remove them
	itemsTab.getListColumn('is_approved').remove();
	itemsTab.getListColumn('is_important').remove();
	
	// rename the start_time column.  We want to use this field for the start date
	itemsTab.getListColumn('start_time').set('label','Start Date');
	
	// rename the title column (different way to go about it than above).  We want to use this field for the President's last name
	var titleColumn = itemsTab.getListColumn('title');
	titleColumn.set('label', 'Last Name');
	
	/*
		we want a separate field for the President's first name.  There is no "first_name" field, so we're choosing to
		re-task subtitle to hold the first name.  There is no subtitle field amongst the "columnNames" (the stock set of
		columns for the News Tool), so we need to add it.  To actually add the column, we'll use the addListColumnAfter
		method to add it after the "title" field (which is being used to hold the President's last name).
	*/
	titleColumn.addListColumnAfter({
		label: 'First Name',
		name: 'subtitle'
	});
} );



/*

	Modify the Item-level panel.  This is what the editor will see after tapping on an existing President (to edit that	record) or 
	adding a new President.  In this Tool, each President is represented by a Sitemason Item, so we'll want to change a variety of 
	labels and fields to be appropriate for the use of this Tool.

	We want the fields (Content Items) to be:

	- last name (title)
	- first name (subtitle)
	- bio (body)
	- Vice President(s)

*/
modifyConf('itemPanel', function() {

	// List all of the tabs' names in the stock itemPanel
	/*
		var tabNames = this.getTabNames();
		console.info('Item panel\'s tabs:'); console.dir(tabNames);
	*/

	// get rid of tabs that we don't need: details, media, location, custom
	this.removeTab('detailsTab');		// one way to remove a tab: use the Panel's removeTab() method
	this.getTab('mediaTab').remove();	// an alternate way to remove a tab: get the mediaTab by using the Panel's getTab() method, then call Tab's remove() method
	this.getTab('customTab').remove();


	/*---------------------
		CONTENT TAB: the "Content" tab (the first tab) us where we're going to store the name and bio fields.
	*/
	
	var contentTab = this.getTab('contentTab');
	
	// if you want to see a list of all of the contentTab's Content Item names, uncomment this.
	/*
		var contentItemNames = contentTab.getContentItemNames();
		console.info('contentTab\'s Content Item names:'); console.dir(contentItemNames);
	*/

	// Get the field named "title" and change it's label to to "Last Name"
	var titleItem = contentTab.getContentItem('title');
	titleItem.set('label', 'Last Name');

	// Change Subtitle (subtitle) to "First Name"
	contentTab.getContentItem('subtitle').set('label', 'First Name');

	// Remove summary
	contentTab.getContentItem('summary').remove();
	
	/*
		We also want to include the Vice President's name.  Sometimes there are multiple Vice Presidents under a President's term, so we
		need to have something flexible enough to hold multiple records within a field.
		
		For this task, we'll use the "MultiRow" content type, which allows us to place a virtually-unlimited number of Vice Presidents into
		one custom field.  We'll call that field "vicePresidents" (and we can use SMItem's getCustomFieldWithKey('vicePresidents') to access
		the VPs.
	*/
	
	contentTab.getContentItem('description').addContentItemAfter({
		type:	'multiRow',
		name:	'custom_field_json.vicePresidents',
		label:	'Vice President(s)',
		content:	[{
			type:	'field',
			name:	'name',
			label:	'Name',
			width:	'200px'
		}]
	});
	


	/*---------------------
		PICTURE TAB: we're using this one.  We don't really need the other fields, but we can't get rid of those in this case - they're fixed to the "file" mechanism.
	*/
	
	
	/*---------------------
		PUBLISH TAB: this will store the in-office start and end date.  Let's re-label the tab.  When it comes to modifying the contents, we really only care about
		the start date.  We need an end date, which isn't here.  We don't care about the other fields that News provides.  So, we'll completel replace this tab's
		content items.
	*/
	
	var publishTab = this.getTab('publishTab');
	publishTab.replace({
		label:	'Dates in Office',
		name:	'publishTab',
		icon:	'events',
		content:[
			{
				type:	'header',
				value:	'Dates in Office'
			}, {
				type:	'content',
				name:	'item_time',
				content: [
					{
						type:		'datetime',
						label:		'Start Time',
						name:		'start_time',
						width:		20,
						validate:	'datetime',
						rangeMaxName:	'end_time',
						timeRound:	5,
						help:		'This is the date the President took office.'
					}, {
						type:		'datetime',
						label:		'End Time',
						name:		'end_time',
						width:		20,
						validate:	'datetime',
						rangeMaxName:	'start_time',
						timeRound:	5,
						help:		'This is the date the President left office.'
					}, {
						type:		'hidden',
						name:		'is_all_day',
						value:		true,
						label:		'Is all day?'
					}
				]
			}
		]
	});	
	
	
	/*---------------------
		LOCATION TAB: rename to Home State (though we don't care about the rest of the fields in this tab, we can't do anything about those because it's one content item)
	*/
	
	var locationTab = this.getTab('locationTab');
	locationTab.set('label','Home State')
	
} );



