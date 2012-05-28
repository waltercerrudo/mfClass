<?php
/**
 * TMYFILES
 *
 * PHP version 5
 * 
 * MEDIAFIREAPI es una implementaci&oacute;n de las API de MediaFire, 
 * orientada a objetos que facilita la interacci&oacute;n con MediaFire, 
 * pudiendo obtener y actualizar informaci&oacute;n de los archivos almacenados
 * en una cuenta a la cual tengamos acceso, como as&iacute;
 * tambi&eacute;n obtener el link de descarga correspondiente.
 *
 * MEDIAFIREAPI is free software: you can redistribute it and/or modify it under the
 * terms of the GNU Lesser General Public License as published by the Free
 * Software Foundation, either version 3 of the License, or (at your option)
 * any later version.
 *
 * MEDIAFIREAPI is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU Lesser General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with MEDIAFIREAPI. If not, see <http://www.gnu.org/licenses/>.
 *
 * @category   API
 * @package    MEDIAFIRE
 * @subpackage TMYFILES
 * @author     Walter Cerrudo <waltercerrudo@gmail.com>
 * @copyright  2012 Walter Cerrudo
 * @license    http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @version    GIT: $Id$
 * @link       http://lawebdewalterio.com.ar
 */

require_once '../folder.class.php';

/**
 * TMYFILESMF
 *
 * Clase que maneja archivos y carpetas de MediaFire
 *
 * @category   API
 * @package    MEDIAFIRE
 * @subpackage TMYFILES
 * @author     Walter Cerrudo <waltercerrudo@gmail.com>
 * @copyright  2012 Walter Cerrudo
 * @license    http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @version    Release: 0.9
 * @link       http://www.lawebdewalterio.com.ar
 */

class TMyFilesMF
{

    /**
     * Cantidad de archivos
     *
     * @var  integer Cantidad de archivos
     */
    private $_fileCount;

    /**
     * Revision
     *
     * @var  integer Revision
     */
    private $_revision;

    /**
     * Epoch
     *
     * @var  integer Epoch
     */
    private $_epoch;

    /**
     * Arreglo que contiene las Carpetas del directorio raiz
     *
     * @var  Array Arreglo de TFolderMF
     */
    private $_folders; //Array de TFolderMF

    /**
     * [PROPERTY SHORT DESCRIPTION
     *
     * [PROPERTY LONG DESCRIPTION]
     *
     * @var  [TYPE] [DESCRIPTION]
     */
    private $_out;

    /**
     * Directorio raiz
     *
     * @var  TFolderMF Directorio raiz
     */
    public $rootFolder;

    /**
     * TMyFilesMF::setRootFolder()
     *
     * Establecer directorio raiz
     *
     * @param TFolderMF $varRootFolder Directorio raiz
     *
     * @return NULL
     */
    function setRootFolder(TFolderMF $varRootFolder)
    {
        $this->_rootFolder = $varRootFolder;
    }

    /**
     * TMyFilesMF:getFolders()
     *
     * Funcion recursiva que obtiene la estructura de archivos
     * y carpetas de la carpeta actual.
     *
     * @param string    $varMyFiles Estructura XML
     * @param integer   $n          Indica el nivel de recursividad
     * @param TFolderMF $currFolder Carpeta actual
     *
     * @return NULL
     */
    function getFolders($varMyFiles, $n, TFolderMF $currFolder)
    {
        if (count($varMyFiles['folders']) <> 0) {
            for ($i = 0; $i < count($varMyFiles['folders']); $i++) {
                $n++;
                $x = new TFolderMF;
                $x->xml2TFolderMF($varMyFiles['folders'][$i]);
                $currFolder->addFolder($x);
                $this->getFolders(
                    $varMyFiles['folders'][$i],
                    $n,
                    $currFolder->getLastFolder()
                );
                $n--;
            }
        }
        if (count($varMyFiles['files']) <> 0) {
            for ($i = 0; $i < count($varMyFiles['files']); $i++) {
                $f = new TFileMF;
                $f->xml2TFileMF($varMyFiles['files'][$i]);
                $currFolder->addFile($f);
            }
        }
    }

    /**
     * TMyFilesMF:getMyFile()
     *
     * Funcion que obtiene la estructura de archivos
     * y carpetas completa de MediaFire.
     *
     * @param string $varMyFiles Estructura XML
     *
     * @return NULL
     */
    function getMyFile($varMyFiles)
    {
        if (count($varMyFiles['folders']) <> 0) {
            $this->getFolders($varMyFiles, 0, $this->_rootFolder);
        }
    }
    
    /**
     * TUsuarioMF::getRootFolder()
     *
     * Devuelve el valor del atributo _RootFolder
     *
     * @return [TYPE] [DESCRIPTION]
     * @throws [EXCEPTION TYPE] [DESCRIPTION]
     * @link       [EXTERNAL REFERENCE]
     * @see        [INTERNAL REFERENCE] 
     * @since      Method available since Release [RELEASE VERSION]
     * @deprecated Method deprecated in Release [RELEASE VERSION]
     * @todo       [TODO ITEM]
     */
    function getRootFolder() 
    {
        return $this->_rootFolder;
    }
    
    /**
     * TUsuarioMF::getArrayFolders()
     *
     * Devuelve el valor del atributo _ArrayFolders
     *
     * @return [TYPE] [DESCRIPTION]
     * @throws [EXCEPTION TYPE] [DESCRIPTION]
     * @link       [EXTERNAL REFERENCE]
     * @see        [INTERNAL REFERENCE] 
     * @since      Method available since Release [RELEASE VERSION]
     * @deprecated Method deprecated in Release [RELEASE VERSION]
     * @todo       [TODO ITEM]
     */
    function getArrayFolders() 
    {
        return $this->_folders;
    }
    
   
}

?>