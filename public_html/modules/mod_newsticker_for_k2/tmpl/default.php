<?php
/**
* @title			Newsticker for K2
* @version   		3.x
* @copyright   		Copyright (C) 2011-2014 Minitek, All rights reserved.
* @license   		GNU General Public License version 3 or later.
* @author url   	http://www.minitek.gr/
* @author email   	info@minitek.gr
* @developers   	Minitek.gr
*/

// no direct access
defined('_JEXEC') or die('Restricted access');
?>

<ul id="<?php echo $newstickerk2; ?>"> 

	<?php foreach($items as $key=>$item) { ?>
    
        <li class="news-item">
        	
            <a href="<?php echo $item->link; ?>"><?php echo $item->shorttitle; ?></a>
                                
        </li>
    
    <?php } ?>
    
</ul>

