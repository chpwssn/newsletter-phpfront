<pre>
<?php

/*
*   Ghetto IMAP frontend by chip
*   This page connects to the local postfix server via IMAP and either:
*   * Displays the header info of all of the messages in the inbox if no mail ID is defined
*   * Displays the body of a particular message if the mail ID is defined
*
*   Todo:
*   Figure out a way to display the emails correctly
*   Figure out a way to display attachments without possibly causing harm to the end user (malicious attachments etc)
*/
//Include the username and password for the IMAP account
include "config.php";
//Open an IMAP stream (how we interact with the mail server)
$mbox = imap_open ("{localhost:143/novalidate-cert}INBOX", $imap_user, $imap_pass);

if(isset($_GET['mailno'])){
		$num = $_GET['mailno'];
		//Print the header info
		//echo imap_headerinfo($mbox,$num)."<br/>";
		
		//Print the body of the email designated in mailno get key
		echo imap_body($mbox,$num)."<br/>";
		
		//Print sections of the body with the tags stripped out
		//echo strip_tags(imap_fetchbody($mbox,$num,1))."<br/>";
		//echo strip_tags(imap_fetchbody($mbox,$num,2))."<br/>";
		//echo strip_tags(imap_fetchbody($mbox,$num,3))."<br/>";
		//echo strip_tags(imap_fetchbody($mbox,$num,4))."<br/>";
} else {
	//Get our current IMAP mailbox status
	$status = imap_status($mbox, "{mail2.newsletter.nerds.io/novalidate-cert}INBOX", SA_ALL);
	
    //Make sure we were able to fetch IMAP mailbox status
	if ($status) {
      //Echo out our mailbox status
	  echo "Messages:   " . $status->messages	. "<br />\n";
	  echo "Recent:	 " . $status->recent	  . "<br />\n";
	  echo "Unseen:	 " . $status->unseen	  . "<br />\n";
	  echo "UIDnext:	" . $status->uidnext	 . "<br />\n";
	  echo "UIDvalidity:" . $status->uidvalidity . "<br />\n";
	} else {
	  echo "imap_status failed: " . imap_last_error() . "\n";
	}		
    //Collect all of the message headers
	$headers = imap_headers($mbox);
	if ($headers == false) {
		echo "Call failed<br />\n";
	} else {
		//rsort($headers);
        //Print out each message header and a link to the view page
		foreach ($headers as $val) {
			preg_match("/[\sUN]*(\d+)\)/", $val,$matches, PREG_OFFSET_CAPTURE, 3);
			echo $val ." <a href='?mailno=".$matches[1][0]."'>view</a>\n";
			//echo "<br/>";
		}
	}
}
imap_close($mbox);

?></pre>
