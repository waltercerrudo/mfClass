<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html>

<head>
    <title>TMediaFire - Ejemplo</title>

    <link rel="StyleSheet" href="./tree/dtree.css" type="text/css" />
    <link rel="StyleSheet" href="./tree/dd.css" type="text/css" />
    <script type="text/javascript" src="./tree/dtree.js"></script>
    
<!--Stylesheets-->
<link rel="stylesheet" type="text/css" 
    href="http://media1.juggledesign.com/qtip2/css/master.css" />
<link rel="stylesheet" type="text/css" 
    href="./tree/jquery.qtip.min.css" />
<link rel="stylesheet" type="text/css" 
    href="http://media1.juggledesign.com/qtip2/css/demos.css" />

<!--JavaScript-->
<script type="text/javascript" src="./tree/jquery.js"></script>
<script type="text/javascript" src="./tree/jquery.qtip.js"></script>
</head>

<style type="text/css">
.ui-tooltip-wiki{
    max-width: 440px;
}

    .ui-tooltip-wiki .ui-tooltip-content{
        padding: 10px;
        
        line-height: 12.5px;
    }

    .ui-tooltip-wiki h1{
        margin: 0 0 7px;

        font-size: 1.5em;
        line-height: 1em;
    }

    .ui-tooltip-wiki img{ padding: 0 10px 0 0; }
    
    .ui-tooltip-wiki p{ margin-bottom: 9px; }
    .ui-tooltip-wiki .note{ margin-bottom: 0; font-style: italic; color: #888; }
</style>

<body class="demo-ajax">

<div id="content" class="preview">

<script type="text/javascript">
d = new dTree('d');
d.add(0,-1,'root','test','','','tree/img/root.png');
<?php
    /**
     * Test
     *
     * PHP version 5
     *
     * JANUS is free software: you can redistribute it and/or modify it under the
     * terms of the GNU Lesser General Public License as published by the Free
     * Software Foundation, either version 3 of the License, or (at your option)
     * any later version.
     *
     * JANUS is distributed in the hope that it will be useful, but WITHOUT ANY
     * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
     * FOR A PARTICULAR PURPOSE. See the GNU Lesser General Public License for more
     * details.
     *
     * You should have received a copy of the GNU Lesser General Public License
     * along with JANUS. If not, see <http://www.gnu.org/licenses/>.
     *
     * @category   API
     * @package    MEDIAFIRE
     * @subpackage Test
     * @author     Walter Cerrudo <waltercerrudo@gmail.com>
     * @copyright  2012 Walter Cerrudo
     * @license    http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
     * @version    GIT: $Id$
     * @link       http://lawebdewalterio.com.ar
     * @see        [INTERNAL REFERENCE]
     * @since      File available since Release [RELEASE VERSION]
     * @deprecated File deprecated in Release [RELEASE VERSION]
     */
    require_once './mediafire.class.php';
    $GLOBALS['paso'] = 0;
    $GLOBALS['folder'] = 0;
    
    
/**
 * Funcion recursiva
 *
 * @param integer   $n               [DESCRIPTION]
 * @param TFolderMF $currFolder      [DESCRIPTION]
 * @param integer   $ParentFolderInd [DESCRIPTION]
 *
 * @return NULL
 */
function getFoldersTree($n, TFolderMF $currFolder, $ParentFolderInd)
{
    if ($currFolder->getFolderCount() <> 0) {
        for ($i = 0; $i < $currFolder->getFolderCount(); $i++) {
            $n++;
            $GLOBALS['paso']++;
            $str = "d.add(".$GLOBALS['paso'].",";
            $str .= $ParentFolderInd.",'";
            $str .= $currFolder->getFolderByIndex($i)->getName()."','";
            $str .= "','','',";
            $str .= "'tree/img/folder.png','tree/img/folderopen.png'";
            $str .= ");\n";
            echo $str;
            getFoldersTree(
                $n,
                $currFolder->getFolderByIndex($i),
                $GLOBALS['paso']
            );
            $n--;
        }
    }
    if ($currFolder->getCountFiles() <> 0) {
        for ($i = 0; $i < $currFolder->getCountFiles(); $i++) {
            $GLOBALS['paso']++;
            $str = "d.add(".$GLOBALS['paso'].",";
            $str .= $ParentFolderInd.",'";
            $str .= $currFolder->getFileByIndex($i)->getFileName()."','";
            $str .= $currFolder->getFileByIndex($i)->getLink()."','";
            $str .= $currFolder->getFileByIndex($i)->getDescription()."',";
            $str .= "'blank',";
            $flname = $currFolder->getFileByIndex($i)->getFileName();
            $ext = substr(strrchr($flname, '.'), 1);
            $str .= "'tree/img/". $ext .".png',";
            $str .= "'www.google.com.ar'";
            $str .= ");\n";
            echo $str;
        }
    }
}
    
    $us = new TUsuarioMF('mfapiclass@gmail.com', 'probando'); //Instancia Usuario
    $mf = new TMediafire($us); //Instancia MediaFire
    $mf->getUserInfo();
    $mf->myFiles();
    getFoldersTree(-1, $mf->myFiles->_rootFolder, 0);
?>
    document.write(d);
    </script>

<script type="text/javascript">
//Create the tooltips only on document load
$(document).ready(function()
{
    $('a[rel*="file"]').each(function()
    {
        $(this).qtip(
        {
            content: {
                text: '<img class="throbber" src="./throbber.gif" alt="" />',
                ajax: {
                    url: $(this).attr('rel') 
                },
                title: {
                    text: 'Wikipedia - ' + $(this).text(), 
                    button: true
                }
            },
            position: {
                at: 'bottom center', 
                my: 'top center',
                viewport: $(window), 
                effect: false 
            },
            show: {
                event: 'mouseenter',
                solo: true // Only show one tooltip at a time
            },
            hide: 'unfocus',
            style: {
                classes: 'ui-tooltip-wiki ui-tooltip-light ui-tooltip-shadow'
            }
        });
    })
    .click(function(event) { event.preventDefault(); });
});
</script>
</div>
</body>
</html>
