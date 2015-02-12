<?php
/**
 *
 *
 * This is the view.feed.php file for jobgroklist
 *
 * Created: June 13, 2014, 1:18 am
 *
 * Subversion Details
 * $Date: 2014-05-04 19:21:09 -0500 (Sun, 04 May 2014) $
 * $Revision: 6049 $
 * $Author: bobsteen $
 *
 * @author TK Tek, LLC. info@jobgrok.com
 * @version 3.1-1.2.57
 * @package com_jobgroklist
 *
 * @copyright Copyright {c} 2008-2014
 * @license GNU Public License Version 2
 *
 * This file is part of JobGrok.
 *
 * JobGrok is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * (at your option) any later version.
 *
 * JobGrok is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with JobGrok.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');
jimport('joomla.application.component.helper');

/**
 *
 * Posting View
 *
 */
class JobgroklistViewPostings extends JViewLegacy

{
/**
 *
 * Renders the View
 *
 */
    function display($tpl = null)
    {

        $app        = JFactory::getApplication();
        $document   = JFactory::getDocument();
        $menu       = $app->getMenu();
        $menuItem   = $menu->getItems('id', JRequest::getVar('Itemid',''), true);
        $params = $app->getPageParameters();

        $document->setLink(JRoute::_('index.php?option=com_jobgroklist&amp;view=postings'));
        $document->setTitle($params->get('feed_title'));
        $document->setDescription($params->get('feed_description'));

        $db = JFactory::getDBO();
        $query = $this->get('FeedQuery');
        $db->setQuery($query);
        $rows = $db->loadObjectList();

        $Itemid = JRequest::getVar('Itemid','');
        
        $row = null;
        foreach ($rows as $row)
        {
            $title = JApplication::stringURLSafe(JHTML::_('jobgroklist.posting',$row->id,true));
            
            $item = new JFeedItem();

            $item->author = $params->get('feed_author');
            $item->category = $params->get('feed_category');
            $item->comments = $params->get('feed_comments');

            $rss_layout = JHTML::_('jobgroklist.getRSSLayout', $row, 'feed');
            $summary = preg_replace("/\{[^}]+\}/","",$row->summary);
            
            $item->date = date('r', strtotime($row->posting_date));
            $item->description = "<em>".$summary."</em><br/><table>".$rss_layout."</table>";
            $item->link = JRoute::_('index.php?option=com_jobgroklist&view=posting&id='.$row->id.':'.$title.'&Itemid='.$Itemid,true);

            $item->pubDate = date('r');
            $item->title = $title;
            // $item->title = $row->job_title;

            $document->addItem($item);
        }

    }
}
?>
