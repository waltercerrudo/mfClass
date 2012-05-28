<?php
/**
 * TFOLDERMF
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
 * @subpackage TFOLDERMF
 * @author     Walter Cerrudo <waltercerrudo@gmail.com>
 * @copyright  2012 Walter Cerrudo
 * @license    http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @version    GIT: $Id$
 * @link       http://lawebdewalterio.com.ar
 */

require_once '../file.class.php';

/**
 * TFolderMF
 *
 * [CLASS LONG DESCRIPTION]
 *
 * @category   API
 * @package    MEDIAFIRE
 * @subpackage TFOLDERMF
 * @author     Walter Cerrudo <waltercerrudo@gmail.com>
 * @copyright  2012 Walter Cerrudo
 * @license    http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @version    Release: 0.9
 * @link       http://www.lawebdewalterio.com.ar
 */

class TFolderMF
{

    /**
     * Clave de Identificacion de la carpeta
     *
     * @var  string Identificacion de la carpeta
     */
    private $_folderKey;

    /**
     * Carpeta padre
     *
     * @var  TFolderMF Carpeta
     * @todo Es necesaria? Sirve de algo? a que apunta?
     */
    private $_parentFolder;

    /**
     * Nombre de la carpeta
     *
     * @var  string Nombre de la cadena
     */
    private $_name;

    /**
     * Descripcion de la carpeta
     *
     * @var  string Nombre de la carpeta
     */
    private $_description;

    /**
     * Tags asociados a la carpeta, separados por coma
     *
     * @var  string Lista de tags
     */
    private $_tags;

    /**
     * Fecha de creacion
     *
     * @var  string Fecha de creacion de la carpeta
     * @todo En que formato esta la fecha
     */
    private $_created;

    /**
     * &Aacute;mbito de privacidad de la carpeta
     *
     * @var  string Privacidad de la carpeta.
     *              Solo admite los valores 'public' (Publica) o 'private' Privada.
     */
    private $_privacy;

    /**
     * Revision de la carpeta
     *
     * @var  string Revision
     */
    private $_revision;

    /**
     * Epoch
     *
     * @var  string Epoch de la carpeta
     */
    private $_epoch;

    /**
     * DropBox enabled;
     *
     * @var  [TYPE] [DESCRIPTION]
     */
    private $_dropboxEnabled;

    /**
     * Flag
     *
     * @var  string Flags
     */
    private $_flag;

    /**
     * Arreglo de Carpetas hijas
     *
     * @var  array Arreglo de TFolderMF
     */
    private $_folders;

    /**
     * Cantidad de carpetas hijas
     *
     * @var  integer Numero de subcarpetas
     */
    private $_folderCount;

    /**
     * Arreglo de archivos contenidos en la carpeta
     *
     * @var  array Arreglo de TFileMF
     */
    private $_files;

    /**
     * Cantidad de archivos contenidos en la carpeta
     *
     * @var  integer Cantidad de archivos
     */
    private $_filesCount;

    /**
     * Carpeta
     *
     * @var  [TYPE] [DESCRIPTION]
     * @todo Para que sirve? q pito toca?
     */
    private $_folder;

    /**
     * TFolderMF::addFolder()
     *
     * Agrega una nueva carpeta al arreglo
     *
     * @param TFolderMF $varFolder Nueva carpeta a agregar
     *
     * @return NULL
     */
    function addFolder(TFolderMF $varFolder)
    {
        $this->_folders[] = $varFolder;
    }

    /**
     * TFolderMF::getFirstFolder()
     *
     * Devuelve la primera carpeta del arreglo
     *
     * @return TFolderMF Primera carpeta del arreglo
     * @todo       Validar. Verificar que existe la carpeta.
     */
    function getFirstFolder()
    {
        return $this->_folders[0];
    }

    /**
     * TFolderMF::getLastFolder
     *
     * Devuelve la ultima carpeta del arreglo
     *
     * @return TFolderMF Instancia de Carpeta
     */
    function getLastFolder()
    {
        end($this->_folders);
        return current($this->_folders);
    }

    /**
     * TFolderMF::getFolderByIndex()
     *
     * Devuelve la $index carpeta.
     *
     * @param integer $index Numero de carpeta a devolver
     *
     * @return TFolderMF Intancia de Carpeta
     */
    function getFolderByIndex($index)
    {
        return $this->_folders[$index];
    }

    /**
     * TFolderMF::getCountFolders()
     *
     * Devuelve la cantidad de carpetas incluidas en el arreglo
     *
     * @return integer Cantidad de carpetas
     */
    function getCountFolders()
    {
        return sizeof($this->_folders);
    }

    /**
     * TFolderMF::addFile()
     *
     * Agrega un archivo al arreglo
     *
     * @param TFileMF $varFile Archivo a agregar al arreglo
     *
     * @return NULL
     */
    function addFile(TFileMF $varFile)
    {
        $this->_files[] = $varFile;
    }

    /**
     * TFolderMF::getFirstFIle
     *
     * Devuelve el primer archivo del arreglo
     *
     * @return TFileMF Instancia de archivo
     */
    function getFirstFile()
    {
        return $this->_files[0];
    }

    /**
     * TFolderMF::getLastFile
     *
     * Devuelve el ultimo archivo del arreglo
     *
     * @return TFileMF Instancia de archivo
     */
    function getLastFile()
    {
        end($this->_files);
        return current($this->_files);
    }

    /**
     * TFolderMF::getFileByIndex()
     *
     * Devuelve el archivo numero $index
     *
     * @param integer $index Numero de archivo a devolver
     *
     * @return TFileMF Archivo numero $index
     */
    function getFileByIndex($index)
    {
        return $this->_files[$index];
    }

    /**
     * TFolderMF:getCountFiles()
     *
     * Devuelve la cantidad de archivos
     *
     * @return integer Cantidad de archivos
     */
    function getCountFiles()
    {
        return sizeof($this->_files);
    }

    /**
     * TFolderMF::setFolderKey()
     *
     * Establece el valor FolderKey de la carpeta actual
     *
     * @param string $varFolderKey Clave de la carpeta
     *
     * @return NULL
     */
    function setFolderKey($varFolderKey)
    {
        $this->_folderKey = $varFolderKey;
    }

    /**
     * TFolderMF::getFolderKey()
     *
     * Devuelve el valor de la carpeta ctual
     *
     * @return string Identificador de la carpeta
     */
    function getFolderKey()
    {
        return $this->_folderKey;
    }

    /**
     * TFolderMF::setParentFolder()
     *
     * Establece el nombre de la carpeta padre
     *
     * @param string $varParentFolder Nombre de la carpeta padre
     *
     * @return NULL
     * @todo       Devuelve nombre? TFolderMF?
     */
    function setParentFolder($varParentFolder)
    {
        $this->_parentFolder = $varParentFolder;
    }

    /**
     * TFolderMF::getParentFolder()
     *
     * Devuelve la carpeta padre
     *
     * @return string Nombre de la carpeta
     * @todo       Que devuelve? nombre) TFOlderMF?
     */
    function getParentFolder()
    {
        return $this->_parentFolder;
    }

    /**
     * TFolderMF::setName()
     *
     * Establece el nombre a la carpeta actual
     *
     * @param string $varName NOmbre de ka caroeta
     *
     * @return NULL
     */
    function setName($varName)
    {
        $this->_name = $varName;
    }

    /**
     * TFolderMF::getName()
     *
     * Obtiene el nombre de la carpeta actual
     *
     * @return string Nombre de la carpeta
     */
    function getName()
    {
        return $this->_name;
    }

    /**
     * TFolderMF::setDescription()
     *
     * Establece la descripcion de la carpeta actual
     *
     * @param string $varDescription Descripcion de la carpeta
     *
     * @return NULL
     */
    function setDescription($varDescription)
    {
        $this->_description = $varDescription;
    }

    /**
     * TFolderMF::getDesc()
     *
     * Obtiene la descripcion de la carpeta ctual
     *
     * @return string Descripcion de la carpeta
     */
    function getDesc()
    {
        return $this->_description;
    }

    /**
     * TFolderMF::setTags()
     *
     * Establece las tags de la carpeta
     *
     * @param string $varTags Lista de tags separadas por coma.
     *
     * @return NULL
     */
    function setTags($varTags)
    {
        $this->_tags = $varTags;
    }

    /**
     * TFolderMF::getTags
     *
     * [FUNCTION LONG DESCRIPTION]
     *
     * @return string Tags separados por coma
     */
    function getTags()
    {
        return $this->_tags = $varTags;
    }

    /**
     * TFolderMF::setCreated()
     *
     * Establecer fecha de creacion de la carpeta
     *
     * @param string $varCreated Fecha de cracion
     *
     * @return NULL
     */
    function setCreated($varCreated)
    {
        $this->_created = $varCreated;
    }

    /**
     * TFolderMF::getCreated
     *
     * Obtener fecha de creacion de la carpeta
     *
     * @return string Fecha de creacion de la carpeta
     */
    function getCreated()
    {
        return $this->_created;
    }

    /**
     * TFolderMF::setPrivacy()
     *
     * Establecer privacidad de la carpeta
     *
     * @param string $varPrivacy Privacidad de la carpeta
     *
     * @return NULL
     */
    function setPrivacy($varPrivacy)
    {
        $this->_privacy = $varPrivacy;
    }

    /**
     * TFolderMF::getPrivacy()
     *
     * Obtener privacidad de la carpeta
     *
     * @return string Privacidad de la carpeta
     */
    function getPrivacy()
    {
        return $this->_privacy;
    }

    /**
     * TFolderMF::setFileCount()
     *
     * Establecer la cantidad de archivos dentro de la carpeta
     *
     * @param integer $varFileCount Cantidad de archivos
     *
     * @return NULL
     */
    function setFileCount($varFileCount)
    {
        $this->_fileCount = $varFileCount;
    }

    /**
     * TFolderMF::getFileCount()
     *
     * Obtener cantidad de archivos de la carpeta
     *
     * @return integer Cantidad de archivos
     */
    function getFileCount()
    {
        return $this->_filecount;
    }

    /**
     * TFolderMF::setRevision()
     *
     * Establecer la revision del archivo
     *
     * @param integer $varRevision Revision del archivo
     *
     * @return NULL
     */
    function setRevision($varRevision)
    {
        $this->_revision = $varRevision;
    }

    /**
     * TFolderMF::getRevision()
     *
     * Obtener revision del archivo
     *
     * @return integer revision del archivo
     */
    function getRevision()
    {
        return $this->_revision;
    }

    /**
     * TFolderMF::setEpoch()
     *
     * Establece el valor de la carpeta actual
     *
     * @param string $varEpoch Valor epoch de la carpeta
     *
     * @return NULL
     */
    function setPoch($varEpoch)
    {
        $this->_epoch = $varEpoch;
    }

    /**
     * TFolderMF::getEpoch
     *
     * Obtiene el calor epoch de la carpeta actual
     *
     * @return string Valor epoch de la carpeta actual
     */
    function getEpoch()
    {
        return $this->_epoch;
    }

    /**
     * TFolderMF::setDropBoxEnabled()
     *
     * Establece si DropBox esta habilitado
     *
     * @param boolean $varDropBoxEnabled Habilitacion
     *
     * @return NULL
     */
    function setDropBoxEnabled($varDropBoxEnabled)
    {
        $this->_dropboxEnabled = $varDropBoxEnabled;
    }

    /**
     * TFolderMF::getDropBoxEnabled
     *
     * Obtiene el valor DropBoxEnabled
     *
     * @return boolean DropBoxHabilitado?
     * @todo       Para q sirve?
     */
    function getDropBoxEnabled()
    {
        return $this->_dropboxEnabled;
    }

    /**
     * TFolderMF::setFlag()
     *
     * Establece el valor de las banderas de la carpeta actual
     *
     * @param string $varFlag Banderas
     *
     * @return NULL
     */
    function setFlag($varFlag)
    {
        $this->_flag = $varFlag;
    }

    /**
     * TFolderMF::getFlags()
     *
     * Obtiene las banderas de la carpeta actual
     *
     * @return string Banderas de la carpeta actual.
     */
    function getFlag()
    {
        return $this->_flag;
    }

    /**
     * TFolderMF
     *
     * Devuelve el arreglo de carpetas hijas
     *
     * @return array Arreglo de carpetas hijas.
     */
    function getFolders()
    {
        return $this->_folders;
    }

    /**
     * TFolderMF::getFolderCount
     *
     * [FUNCTION LONG DESCRIPTION]
     *
     * @return integer Cantidad de carpetas hijas
     */
    function getFolderCount()
    {
        return count($this->_folders);
    }

    /**
     * TFolderMF::xml2TFolderMF()
     *
     * Establece los valores a una instancia de TFolderMF
     * a partir de una estructura XML
     *
     * @param string $varFolderXML Estructura XML con informacion
     *                             devuelta por MediaFire
     *
     * @return NULL
     */
    function xml2TFolderMF($varFolderXML)
    {
        $this->setFolderKey($varFolderXML['folderkey']);
        $this->setName($varFolderXML['name']);
        $this->setDescription($varFolderXML['description']);
        $this->setTags($varFolderXML['tags']);
        $this->setPrivacy($varFolderXML['privacy']);
        $this->setRevision($varFolderXML['revision']);
        //$this->setepoch($varFolderXML['epoch']);
        $this->setDropBoxEnabled($varFolderXML['dropbox_enabled']);
        $this->setCreated($varFolderXML['created']);
        $this->setFlag($varFolderXML['flag']);
        //$this->setFolderCount($varFolderXML['folder_count']);
        $this->setFileCount($varFolderXML['file_count']);
    }

    /**
     * TFolderMF::xml2TFolderMF()
     *
     * Establece los valores a una instancia de TFolderMF
     * a partir de una estructura XML
     *
     * @param string $varFolderJson Estructura json con informacion
     *                              devuelta por MediaFire
     *
     * @return NULL
     */
    function json2TFolderMF($varFolderJson)
    {
        $varFolderXml = json_decode($response, true);
        $this->xml2TFolderMF($varFolderXml);
    }
}

?>