<?php

/**
 *
 * This is the router file (SEF) for jobgroklist
 *
 * Created: June 13, 2014, 1:18 am
 *
 * Subversion Details
 * $Date: 2013-09-19 10:33:21 -0500 (Thu, 19 Sep 2013) $
 * $Revision: 5490 $
 * $Author: jobgrok $
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

jimport( 'joomla.html.parameter');
function JobgroklistBuildRoute(& $query) {
    $segments = array();
    if (isset($query['view'])) {
        $segments[] = $query['view'];
        unset($query['view']);
    }
    if (isset($query['id'])) {
        $vals = explode(':', $query['id']);
        if (count($vals) > 1) {
            list($id, $title) = $vals;
            $segments[] = (int)$id;
            $segments[] = $title;
        } else {
            $segments[] = $vals[0];
        }
        //list($id, $title) = explode(':', $query['id'], 2);
        //$segments[] = (int)$id;
        //$segments[] = $title;
        unset($query['id']);
    };
    /*
    if (isset($query['layout'])) {
        $segments[] = $query['layout'];
        unset($query['layout']);
    }
     */
    return $segments;
}

function JobgroklistParseRoute($segments) {
    $vars = array();
    switch ($segments[0]) {
        case 'postings':
            $vars['view'] = 'postings';
            break;
        case 'posting':
            $vars['view'] = 'posting';
            $vars['id'] = $segments[1];/*
            if (count($segments) == 2) {
                // $vars['layout'] = $segments[1];
            } else if (count($segments) == 3) {
                // $vars['layout'] = $segments[2];
                $vars['id'] = (int)$segments[1];
            } else {
                $id = explode(':', $segments[1]);
                $vars['id'] = (int) $segments[0];
            }*/
            break;
        default:
            break;        
    }
    return $vars;
}

?>
