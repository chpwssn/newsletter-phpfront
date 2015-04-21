<pre>
<?php
include "config.php";
$mbox = imap_open ("{localhost:143/novalidate-cert}INBOX", $imap_user, $imap_pass);
    
	if(isset($_GET['mailno'])){
		$num = $_GET['mailno'];
//		echo imap_headerinfo($mbox,$num)."<br/>";
		echo imap_body($mbox,$num)."<br/>";
//		echo strip_tags(imap_fetchbody($mbox,$num,1))."<br/>";
//		echo strip_tags(imap_fetchbody($mbox,$num,2))."<br/>";
//		echo strip_tags(imap_fetchbody($mbox,$num,3))."<br/>";
//		echo strip_tags(imap_fetchbody($mbox,$num,4))."<br/>";
	} else {
$status = imap_status($mbox, "{mail2.newsletter.nerds.io/novalidate-cert}INBOX", SA_ALL);
if ($status) {
  echo "Messages:   " . $status->messages    . "<br />\n";
  echo "Recent:     " . $status->recent      . "<br />\n";
  echo "Unseen:     " . $status->unseen      . "<br />\n";
  echo "UIDnext:    " . $status->uidnext     . "<br />\n";
  echo "UIDvalidity:" . $status->uidvalidity . "<br />\n";
} else {
  echo "imap_status failed: " . imap_last_error() . "\n";
}		$headers = imap_headers($mbox);
		if ($headers == false) {
		    echo "Call failed<br />\n";
		} else {
			//rsort($headers);
		    foreach ($headers as $val) {
				preg_match("/[\sUN]*(\d+)\)/", $val,$matches, PREG_OFFSET_CAPTURE, 3);
		        echo $val ." <a href='?mailno=".$matches[1][0]."'>view</a>\n";
				//echo "<br/>";
		    }
		}
	}
imap_close($mbox);

?></pre>
