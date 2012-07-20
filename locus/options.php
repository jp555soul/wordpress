<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 * 
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet (lowercase and without spaces)
	$themename = get_theme_data(STYLESHEETPATH . '/style.css');
	$themename = $themename['Name'];
	$themename = preg_replace("/\W/", "", strtolower($themename) );
	
	$optionsframework_settings = get_option('optionsframework');
	$optionsframework_settings['id'] = $themename;
	update_option('optionsframework', $optionsframework_settings);
	
	// echo $themename;
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the "id" fields, make sure to use all lowercase and no spaces.
 *  
 */

function optionsframework_options() {
	
	// Test data
	$skin_array = array("light" => "Light","darklight" => "Darklight","dark" => "Dark");
	$bg_array = array("bg1.jpg" => "Background 1","bg2.jpg" => "Background 2","bg3.jpg" => "Background 3");
	
	// Pull all the categories into an array
	$options_categories = array();  
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
    	$options_categories[$category->cat_ID] = $category->cat_name;
	}
	
	// Pull all the pages into an array
	$options_pages = array();  
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
    	$options_pages[$page->ID] = $page->post_title;
	}
		
	// If using image radio buttons, define a directory path
	$imagepath =  get_stylesheet_directory_uri() . '/admin/images/';
		
	$options = array();
		
	$options[] = array( "name" => "General",
						"type" => "heading");
							
	$options[] = array( "name" => "Logo Image",
						"desc" => "Upload your logo image.",
						"id" => "logo",
						"type" => "upload");
						
	$options[] = array( "name" => "Favicon",
						"desc" => "Upload your favicon.",
						"id" => "favicon",
						"type" => "upload");
	
	$options[] = array( "name" => "Header Height",
						"desc" => "Enter a height for the header. This value also effects the space between the menu and sections.",
						"id" => "header_height",
						"std" => "150",
						"type" => "text");
	
	$options[] = array( "name" => "Tracking Code",
						"desc" => "Paste your Google Analytics (or other) tracking code here.",
						"id" => "tracking_code",
						"std" => "",
						"type" => "textarea"); 
	
	$options[] = array( "name" => "Footer Text",
						"desc" => "Enter text for footer.",
						"id" => "footer_text",
						"std" => "",
						"type" => "textarea"); 
						
	$options[] = array( "name" => "Styling",
						"type" => "heading");
						
	$options[] = array( "name" => "Preset Skins",
						"desc" => "Available skins",
						"id" => "skin_select",
						"std" => "light",
						"type" => "select",
						"class" => "mini", //mini, tiny, small
						"options" => $skin_array);	
	
	$options[] = array( "name" => "Available Backgrounds",
						"desc" => "Each skin has 3 different backgrounds available.",
						"id" => "bg_select",
						"std" => "",
						"type" => "select",
						"class" => "mini", //mini, tiny, small
						"options" => $bg_array);	
	
	$options[] = array( "name" => "Custom CSS",
						"desc" => "Quickly add some CSS to your theme by adding it to this block.",
						"id" => "custom_css",
						"std" => "",
						"type" => "textarea");
			
	$options[] = array( "name" => "Social Media",
						"type" => "heading");
	
	$options[] = array( "name" => "Twitter Username",
						"desc" => "Enter your Twitter Username to show your latest tweet.",
						"id" => "twitter_username",
						"std" => "",
						"class" => "mini",
						"type" => "text");
	
	$options[] = array( "name" => "Facebook URL",
						"desc" => "Enter your Facebook URL",
						"id" => "social_facebook",
						"std" => "",
						"class" => "mini",
						"type" => "text");
	
	$options[] = array( "name" => "Flickr URL",
						"desc" => "Enter your Flickr URL",
						"id" => "social_flickr",
						"std" => "",
						"class" => "mini",
						"type" => "text");
	
	$options[] = array( "name" => "Twitter URL",
						"desc" => "Enter your Twitter URL",
						"id" => "social_twitter",
						"std" => "",
						"class" => "mini",
						"type" => "text");
	
	$options[] = array( "name" => "Google+ URL",
						"desc" => "Enter your Google+ URL",
						"id" => "social_google",
						"std" => "",
						"class" => "mini",
						"type" => "text");
						
	$options[] = array( "name" => "LinkedIn URL",
						"desc" => "Enter your LinkedIn URL",
						"id" => "social_linkedin",
						"std" => "",
						"class" => "mini",
						"type" => "text");	
	
	$options[] = array( "name" => "Dribbble URL",
						"desc" => "Enter your Dribbble URL",
						"id" => "social_dribbble",
						"std" => "",
						"class" => "mini",
						"type" => "text");
	
	$options[] = array( "name" => "Deviantart URL",
						"desc" => "Enter your Deviantart URL",
						"id" => "social_deviantart",
						"std" => "",
						"class" => "mini",
						"type" => "text");
						
	$options[] = array( "name" => "Tumblr URL",
						"desc" => "Enter your Tumblr URL",
						"id" => "social_tumblr",
						"std" => "",
						"class" => "mini",
						"type" => "text");	
	
	$options[] = array( "name" => "StumbleUpon URL",
						"desc" => "Enter your StumbleUpon URL",
						"id" => "social_stumble",
						"std" => "",
						"class" => "mini",
						"type" => "text");					
											
	$options[] = array( "name" => "Form",
                    "type" => "heading");
	
	$options[] = array( "name" => "Include IP",
						"desc" => "Check to include the users IP address in the email",
						"id" => "include_ip",
						"type" => "checkbox",
						"std" => "");
					
	$options[] = array( "name" => "Include URL",
						"desc" => "Check to include the page URL in the email",
						"id" => "include_url",
						"type" => "checkbox",
						"std" => "");

	$options[] = array( "name" => "Email Address",
                    	"desc" => "Enter your email address to receive messages sent through the contact form",
                    	"id" => "emailto",
                    	"std" => "",
                    	"type" => "text");
	
	$options[] = array( "name" => "Email Subject",
                    	"desc" => "Enter your a subject for the emails sent through the contact form",
                    	"id" => "email_subject",
                    	"std" => "Locus Contact Form",
                    	"type" => "text");
	
	$options[] = array( "name" => "Label for Name",
                    	"desc" => "Enter a label for Name",
                    	"id" => "label_name",
                    	"std" => "Name",
                    	"type" => "text");
                    	
	$options[] = array( "name" => "Label for Email",
                    	"desc" => "Enter a label for Email",
                    	"id" => "label_email",
                    	"std" => "Email",
                    	"type" => "text");
	
	$options[] = array( "name" => "Label for Subject",
                    	"desc" => "Enter a label for Subject",
                    	"id" => "label_subject",
                    	"std" => "Subject",
                    	"type" => "text");
	
	$options[] = array( "name" => "Label for Message",
                    	"desc" => "Enter a label for Message",
                    	"id" => "label_message",
                    	"std" => "Message",
                    	"type" => "text");
	
	$options[] = array( "name" => "Label for Submit Button",
                    	"desc" => "Enter a label for Submit Button",
                    	"id" => "label_button",
                    	"std" => "Submit",
                    	"type" => "text");
	
	$options[] = array( "name" => "Message - Required",
                    	"desc" => "Enter the validation message for a required field",
                    	"id" => "valid_error",
                    	"std" => "Required",
                    	"type" => "text");
					
	$options[] = array( "name" => "Message - Email Address",
                    	"desc" => "Enter the validation message for an email address field",
                    	"id" => "valid_email",
                    	"std" => "Enter a valid email",
                    	"type" => "text");
					
	$options[] = array( "name" => "Response - Message Sent",
                    	"desc" => "Enter the message returned when the form is successfully submitted",
                    	"id" => "response_sent",
                    	"std" => "Thank you. Your comments have been received.",
                    	"type" => "text");
					
	$options[] = array( "name" => "Use SMTP",
						"desc" => "Check to use SMTP to send email",
						"id" => "mail_smtp",
						"type" => "checkbox",
						"std" => "");
					
	$options[] = array( "name" => "SMTP Server",
                    	"desc" => "Enter the smtp server",
                    	"id" => "smtp_server",
                    	"std" => "",
                    	"type" => "text");
					
	$options[] = array( "name" => "SMTP Port",
                    	"desc" => "Enter the smtp port (if unsure use 25)",
                    	"id" => "smtp_port",
                    	"std" => "25",
                    	"type" => "text");
					
	$options[] = array( "name" => "SMTP Username",
                    	"desc" => "Enter the email account username - this must be the same account as used in 'Email From'",
                    	"id" => "smtp_user",
                    	"std" => "",
                    	"type" => "text");
					
	$options[] = array( "name" => "SMTP Password",
                    	"desc" => "Enter the email account password",
                    	"id" => "smtp_password",
                    	"std" => "",
                    	"type" => "text");
				
	return $options;
}