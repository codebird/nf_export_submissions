### Sending SMS when ninja forms is submitted ###

I needed to send the user who submits some of my ninja forms an SMS. I didn't have time to fiddle with ninja forms code. So I figured I can create this.

How it works:

	1- Run both sql commands in commands .sql
	     a- Insert last_sub for your form so that you don't miss the first submission
	     b- create table that will hold new submissions data

	2- Run trigger.sql
		 a- create a trigger which tracks new submissions and inserts them into the above created table.

	3- update cron_job.php 
		 a- Update field mapping to reflect your fields.
		 b- Update the bottom commands with code that does what you want, in my case it was calling an api with the info to send an sms to the user who submitted the ninja form.

Hope this helps...