<?php
/**
 *
 *
 * This is the view.app.php file for jobgroklist
 *
 * Created: June 13, 2014, 1:18 am
 *
 * Subversion Details
 * $Date: 2014-04-29 20:37:31 -0500 (Tue, 29 Apr 2014) $
 * $Revision: 6012 $
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
class JobgroklistViewPostings extends JViewLegacy {

    /**
     *
     * Renders the View
     *
     */
    function display($tpl = null) {

        $app = JFactory::getApplication();
        $document = JFactory::getDocument();
        $menu = $app->getMenu();
        $menuItem = $menu->getItems('id', JRequest::getVar('Itemid', ''), true);
        $params = $app->getPageParameters();
        
        $document->setLink(JRoute::_('index.php?option=com_jobgroklist&amp;view=postings'));
        $document->setTitle($params->get('feed_title'));
        $document->setDescription($params->get('feed_description'));

        $db = JFactory::getDBO();
        $query = $this->get('FeedQuery');
        $db->setQuery($query);
        $rows = $db->loadObjectList();

        $Itemid = JRequest::getVar('Itemid', '');

        $this->render($data, $params, $rows);
        
        $data->title = $params->get('feed_title');
        $data->description = $params->get('feed_description');
        $data->link = JRoute::_('index.php?option=com_jobgroklist&amp;view=postings');
        $data->generator = 'JobGrok App Feeder';
        $data->image = null; // 1 image consists of $image->url, title, link, width, height, description
        $data->language = '';
        $data->copyright = '';
        $data->editorEmail = '';
        $data->editor = '';
        $data->webmaster = '';
        $data->pubDate = '';
        $data->category = $params->get('feed_category');
        $data->docs = '';
        $data->ttl = '';
        $data->rating = '';
        $data->skipHours = '';
        $data->skipDays = '';
        $data->items = array(); // multiple items[] each consists of $item->title, link, guid, description, authorEmail, author,
                              // category, comments, pubDate and enclosue which consists of $enclosure->url, type, length
       
        foreach ($rows as $row) {
            // $item = new JFeedItem();
            $i = null;
            $i->title = JApplication::stringURLSafe(JHTML::_('jobgroklist.posting', $row->id, true));

            $i->author = '';
            $i->category = '';
            $i->comments = '';

            $rss_layout = JHTML::_('jobgroklist.getRSSLayout', $row, 'app');
            $summary = preg_replace("/\{[^}]+\}/","",$row->summary);

            $i->pubDate = date('r', strtotime($row->posting_date));
            $i->description = "<em>".$summary."</em><br/><table>".$rss_layout."</table>";
            $i->link = JRoute::_('index.php?option=com_jobgroklist&view=posting&id=' . $row->id . ':' . $title . '&Itemid=' . $Itemid, true);

            $i->pubDate = date('r');
            $i->enclosure = null;
            // $i->title = $row->job_title;
            $i->row = $row;
            $data->items[] = $i;
        }
        
        $document->setMimeEncoding('application/rss+xml');
        echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
        echo $this->render($data, $params);
    }

    private function render($data, $params, $content = null) {
        $app = JFactory::getApplication();

        // Gets and sets timezone offset from site configuration
        $tz = new DateTimeZone($app->getCfg('offset'));
        $now = JFactory::getDate();
        $now->setTimeZone($tz);

        // $data = $this->_doc;

        $uri = JUri::getInstance();
        $url = $uri->toString(array('scheme', 'user', 'pass', 'host', 'port'));
        $syndicationURL = JRoute::_('&format=feed&type=rss');

        if ($app->getCfg('sitename_pagetitles', 0) == 1) {
            $title = JText::sprintf('JPAGETITLE', $app->getCfg('sitename'), $data->title);
        } elseif ($app->getCfg('sitename_pagetitles', 0) == 2) {
            $title = JText::sprintf('JPAGETITLE', $data->title, $app->getCfg('sitename'));
        } else {
            $title = $data->title;
        }

        $feed_title = htmlspecialchars($title, ENT_COMPAT, 'UTF-8');

        $feed = "<rss version=\"2.0\" xmlns:atom=\"http://www.w3.org/2005/Atom\">\n";
        $feed .= "      <channel>\n";
        $feed .= "              <title>" . $feed_title . "</title>\n";
        $feed .= "              <description><![CDATA[" . $data->description . "]]></description>\n";
        $feed .= "              <link>" . str_replace(' ', '%20', $url . $data->link) . "</link>\n";
        $feed .= "              <lastBuildDate>" . htmlspecialchars($now->toRFC822(true), ENT_COMPAT, 'UTF-8') . "</lastBuildDate>\n";
        $feed .= "              <generator>" . $data->generator . "</generator>\n";
        $feed .= '              <atom:link rel="self" type="application/rss+xml" href="' . str_replace(' ', '%20', $url . $syndicationURL) . "\"/>\n";

        if ($data->image != null) {
            $feed .= "              <image>\n";
            $feed .= "                      <url>" . $data->image->url . "</url>\n";
            $feed .= "                      <title>" . htmlspecialchars($data->image->title, ENT_COMPAT, 'UTF-8') . "</title>\n";
            $feed .= "                      <link>" . str_replace(' ', '%20', $data->image->link) . "</link>\n";
            if ($data->image->width != "") {
                $feed .= "                      <width>" . $data->image->width . "</width>\n";
            }
            if ($data->image->height != "") {
                $feed .= "                      <height>" . $data->image->height . "</height>\n";
            }
            if ($data->image->description != "") {
                $feed .= "                      <description><![CDATA[" . $data->image->description . "]]></description>\n";
            }
            $feed .= "              </image>\n";
        }
        if ($data->language != "") {
            $feed .= "              <language>" . $data->language . "</language>\n";
        }
        if ($data->copyright != "") {
            $feed .= "              <copyright>" . htmlspecialchars($data->copyright, ENT_COMPAT, 'UTF-8') . "</copyright>\n";
        }
        if ($data->editorEmail != "") {
            $feed .= "              <managingEditor>" . htmlspecialchars($data->editorEmail, ENT_COMPAT, 'UTF-8') . ' ('
                    . htmlspecialchars($data->editor, ENT_COMPAT, 'UTF-8') . ")</managingEditor>\n";
        }
        if ($data->webmaster != "") {
            $feed .= "              <webMaster>" . htmlspecialchars($data->webmaster, ENT_COMPAT, 'UTF-8') . "</webMaster>\n";
        }
        if ($data->pubDate != "") {
            $pubDate = JFactory::getDate($data->pubDate);
            $pubDate->setTimeZone($tz);
            $feed .= "              <pubDate>" . htmlspecialchars($pubDate->toRFC822(true), ENT_COMPAT, 'UTF-8') . "</pubDate>\n";
        }
        if (empty($data->category) === false) {
            if (is_array($data->category)) {
                foreach ($data->category as $cat) {
                    $feed .= "              <category>" . htmlspecialchars($cat, ENT_COMPAT, 'UTF-8') . "</category>\n";
                }
            } else {
                $feed .= "              <category>" . htmlspecialchars($data->category, ENT_COMPAT, 'UTF-8') . "</category>\n";
            }
        }
        if ($data->docs != "") {
            $feed .= "              <docs>" . htmlspecialchars($data->docs, ENT_COMPAT, 'UTF-8') . "</docs>\n";
        }
        if ($data->ttl != "") {
            $feed .= "              <ttl>" . htmlspecialchars($data->ttl, ENT_COMPAT, 'UTF-8') . "</ttl>\n";
        }
        if ($data->rating != "") {
            $feed .= "              <rating>" . htmlspecialchars($data->rating, ENT_COMPAT, 'UTF-8') . "</rating>\n";
        }
        if ($data->skipHours != "") {
            $feed .= "              <skipHours>" . htmlspecialchars($data->skipHours, ENT_COMPAT, 'UTF-8') . "</skipHours>\n";
        }
        if ($data->skipDays != "") {
            $feed .= "              <skipDays>" . htmlspecialchars($data->skipDays, ENT_COMPAT, 'UTF-8') . "</skipDays>\n";
        }

        for ($i = 0, $count = count($data->items); $i < $count; $i++) {
            if ((strpos($data->items[$i]->link, 'http://') === false) && (strpos($data->items[$i]->link, 'https://') === false)) {
                $data->items[$i]->link = str_replace(' ', '%20', $url . $data->items[$i]->link);
            }
            $feed .= "              <item>\n";
            $feed .= "                      <title>" . htmlspecialchars(strip_tags($data->items[$i]->title), ENT_COMPAT, 'UTF-8') . "</title>\n";
            $feed .= "                      <link>" . str_replace(' ', '%20', $data->items[$i]->link) . "</link>\n";

            if (empty($data->items[$i]->guid) === true) {
                $feed .= "                      <guid isPermaLink=\"true\">" . str_replace(' ', '%20', $data->items[$i]->link) . "</guid>\n";
            } else {
                $feed .= "                      <guid isPermaLink=\"false\">" . htmlspecialchars($data->items[$i]->guid, ENT_COMPAT, 'UTF-8') . "</guid>\n";
            }

            $feed .= "                      <description><![CDATA[" . $this->_relToAbs($data->items[$i]->description) . "]]></description>\n";

            if ($data->items[$i]->authorEmail != "") {
                $feed .= "                      <author>"
                        . htmlspecialchars($data->items[$i]->authorEmail . ' (' . $data->items[$i]->author . ')', ENT_COMPAT, 'UTF-8') . "</author>\n";
            }

            /*
             * @todo: On hold
             * if ($data->items[$i]->source!="") {
             *   $data.= "                  <source>".htmlspecialchars($data->items[$i]->source, ENT_COMPAT, 'UTF-8')."</source>\n";
             * }
             */

            if (empty($data->items[$i]->category) === false) {
                if (is_array($data->items[$i]->category)) {
                    foreach ($data->items[$i]->category as $cat) {
                        $feed .= "                      <category>" . htmlspecialchars($cat, ENT_COMPAT, 'UTF-8') . "</category>\n";
                    }
                } else {
                    $feed .= "                      <category>" . htmlspecialchars($data->items[$i]->category, ENT_COMPAT, 'UTF-8') . "</category>\n";
                }
            }
            if ($data->items[$i]->comments != "") {
                $feed .= "                      <comments>" . htmlspecialchars($data->items[$i]->comments, ENT_COMPAT, 'UTF-8') . "</comments>\n";
            }
            if ($data->items[$i]->date != "") {
                $itemDate = JFactory::getDate($data->items[$i]->date);
                $itemDate->setTimeZone($tz);
                $feed .= "                      <pubDate>" . htmlspecialchars($itemDate->toRFC822(true), ENT_COMPAT, 'UTF-8') . "</pubDate>\n";
            }
            if ($data->items[$i]->enclosure != null) {
                $feed .= "                      <enclosure url=\"";
                $feed .= $data->items[$i]->enclosure->url;
                $feed .= "\" length=\"";
                $feed .= $data->items[$i]->enclosure->length;
                $feed .= "\" type=\"";
                $feed .= $data->items[$i]->enclosure->type;
                $feed .= "\"/>\n";
            }

            $allow = array ( "company", "job_title", "location", "loc_description", "loc_address", "summary", "posting_date", "closing_date", 
                                "job_code", "category", "department", "shift", "job_type", "education", "pay_rate", "pay_range", "duration",
                                "travel", "job_description", "preferred_skills");
            
            $feed .= "                      <jobgrokData>\n";
            foreach ($data->items[$i]->row as $k => $v) {
                if (in_array($k, $allow) && 
                    in_array($params->get('rss_'.$k,'1'), array('2','3')) ) {
                    $feed .= "                          <".$k.">" . htmlspecialchars($v, ENT_COMPAT, 'UTF-8') . "</".$k.">\n";
                }
            }
            $feed .= "                      </jobgrokData>\n";
            
            $feed .= "              </item>\n";            
        }
        $feed .= "      </channel>\n";
        $feed .= "</rss>\n";
        return $feed;
    }

    public function _relToAbs($text)
    {
            $base = JURI::base();
            $text = preg_replace("/(href|src)=\"(?!http|ftp|https|mailto)([^\"]*)\"/", "$1=\"$base\$2\"", $text);

            return $text;
    }
    
}
?>
