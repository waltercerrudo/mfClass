<?php
/**
 * MediaFireAPI
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
 * @subpackage TFILEMF
 * @author     Walter Cerrudo <waltercerrudo@gmail.com>
 * @copyright  2012 Walter Cerrudo
 * @license    http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @version    SVN: $Id$
 * @link       http://lawebdewalterio.com.ar
 */

/**
 * TFILEMF
 *
 * Clase que maneja los archivos de MediaFire
 *
 * @category   API
 * @package    MEDIAFIRE
 * @subpackage TFILEMF
 * @author     Walter Cerrudo <waltercerrudo@gmail.com>
 * @copyright  2012 Walter Cerrudo
 * @license    http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @version    Release: 0.9
 * @link       http://www.lawebdewalterio.com.ar
 */
 
class TFileMF
{
    /**
     * Identificador �nico de cada carpeta
     *
     * @var  string Identificador unico de cada carpeta
     */
    private $_quickKey;

    /**
     * Nombre del archivo
     *
     * @var  string Nombre del archivo
     */
    private $_filename;

    /**
     * Lista de tags
     *
     * @var  string tags
     */
    private $_tags;

    /**
     * Descripci&oacute; del archivo
     *
     * @var  string Descripci&oacute; del archivo
     */
    private $_description;

    /**
     * Fecha en la que el archivo fue creado
     *
     * @var  string Fecha de creaci&oacute;n
     */
    private $_created;

    /**
     * Cantidad de veces que ha sido descargado el archivo desde MediaFire
     *
     * @var  integer Cantidad de descargas
     */
    private $_downloads;

    /**
     * Descripci&oacute;n del archivo
     *
     * @var  string Descripci&oacute;n del archivo
     */
    private $_desc;

    /**
     * Tama&ntilde;o del archivo expresado en bytes
     *
     * @var  integer Tama&ntilde;o del archivo
     */
    private $_size;

    /**
     * Privacidad del archivo
     *
     * @var  string Privacidad del archivo.
     *              Solo admite los valores 'public' o 'private'
     */
    private $_privacy;

    /**
     * Asunto de la nota de archivo
     *
     * @var string Asunto de la nota de archivo
     */
    private $_noteSubject;

    /**
     * Descripci&oacute;n de la nota de archivo
     *
     * @var  string Descripci&oacute;n de la nota
     */
    private $_noteDescription;

    /**
     * Carpeta del archivo
     *
     * @var  string Carpeta del archivo
     */
    private $_folder;

    /**
     * Password del archivo
     *
     * @var  string Password del archivo
     */
    private $_password;


    /**
     * URL de descarga del archivo
     * 
     * @var  string URL
     */
    private $_link;
    
    /**
     * TFileMF::setQuickKey()
     *
     * M&eacute;todo que establece el valor de la propiedad
     *
     * @param string $varQuickKey QuickKey que identifica el archivo
     *
     * @return NULL
     */
    function setQuickKey($varQuickKey)
    {
        $this->_quickKey = $varQuickKey;
    }

    /**
     *  TFileMF::getQuickKey()
     *
     * M&eacute;todo que devuelve el valor del Identificador del Archivo
     *
     * @return string Identificador del archivo
     */
    function getQuickKey()
    {
        return $this->_quickKey;
    }

    /**
     * TFileMF::setFileName()
     *
     * M&eacute;todo que establece el nombre del archivo
     *
     * @param mixed $varFileName Nombre del archivo
     *
     * @return NULL
     */
    function setFileName($varFileName)
    {
        $this->_filename = $varFileName;
    }

    /**
     * TFileMF::getFileName()
     *
     * M&eacute;todo que devuelve el nombre del archivo
     *
     * @return string Nombre del archivo
     */
    function getFileName()
    {
        return $this->_filename;
    }

    /**
     * TFileMF::setTags()
     *
     * M&eacute;todo que establece los tags del archivo
     *
     * @param string $varTags Tags del archivo
     *
     * @return NULL
     */
    function setTags($varTags)
    {
        $this->_tags = $varTags;
    }

    /**
     * TFileMF::getTags()
     *
     * M&eacute;todo que devuelve los tags del archivo
     *
     * @return string tags del archivo
     */
    function getTags()
    {
        return $this->_tags = $varTags;
    }


    /**
     * TFileMF::setDescription()
     *
     * M&eacute;todo que establece la Descripci&oacute;n del archivo
     *
     * @param string $varDescription Dscripci&oacute;n del archivo
     *
     * @return NULL
     */
    function setDescription($varDescription)
    {
        $this->_description = $varDescription;
    }

    /**
     * TFileMF::getDescription()
     *
     * M&eacute;todo que devuelve la descripcion del archivo
     *
     * @return string Descripcion del Archivo
     */
    function getDescription()
    {
        return $this->_description;
    }

    /**
     * TFileMF::setCreated()
     *
     * M&eacute;todo que establece la fecha de creacion del archivo
     *
     * @param string $varCreated Fecha de creacion del archivo
     *
     * @return NULL
     */
    function setCreated($varCreated)
    {
        $this->_created = $varCreated;
    }

    /**
     * TFileMF::getCreated()
     *
     * M&eacute;todo que obtiene la fecha de creacion del archivo
     *
     * @return string Fecha de creacion del archivo
     */
    function getCreated()
    {
        return $this->_created;
    }

    /**
     * TFileMF::setDownloads()
     *
     * M&eacute;todo que establece la cantidad de descargas del archivo
     *
     * @param integer $varDownloads Cantidad de descargas
     *
     * @return NULL
     */
    function setDownloads($varDownloads)
    {
        $this->_downloads = $varDownloads;
    }

    /**
     * TFileMF::getDownloads()
     *
     * Obtiene la cantidad de descargas del archivo
     *
     * @return integer Cantidad de descargas
     */
    function getDownloads()
    {
        return $this->_downloads;
    }

    /**
     * TFileMF::setDesc()
     *
     * M&eacute;todo que establece la descripcion del archivo
     *
     * @param string $varDesc Descripcion del archivo
     *
     * @return NULL
     */
    function setDesc($varDesc)
    {
        $this->_desc = $varDesc;
    }

    /**
     * TFileMF::getDesc()
     *
     * M&eacute;todo para obtener la descripcion del archivo
     *
     * @return string Descripcion del archivo
     */
    function getDesc()
    {
        return $this->_desc;
    }

    /**
     * TFileMF::setSize()
     *
     * M&eacute;todo qe establece el tama&ntilde;o del archivo
     *
     * @param integer $varSize Tama&ntilde;o del archivo
     *
     * @return NULL
     */
    function setSize($varSize)
    {
        $this->_size = $varSize;
    }

    /**
     * TFileMF::getSize()
     *
     * M&eacute;todo que obtiene el tama&ntilde;o del archivo
     *
     * @return integer Tama&ntilde;o del archivo
     */
    function getSize()
    {
        return $this->_size;
    }

    /**
     * TFileMF::setPrivacy()
     *
     * M&eacute;todo que establece la privacidad del archivo
     *
     * @param string $varPrivacy Privacidad del archivo
     *
     * @return NULL
     */
    function setPrivacy($varPrivacy)
    {
        $this->_privacy = $varPrivacy;
    }

    /**
     * TFileMF::getPrivacy()
     *
     * @return string Devuelve el &aacute;mbito de aplicaci&oacute;n
     */
    /**
     * TFileMF::getPrivacy()
     *
     * M&eacute;todo que obtiene la privacidad del archivo
     *
     * @return string Privacidad del archivo
     */
    function getPrivacy()
    {
        return $this->_privacy;
    }

    /**
     * TFileMF::setNoteSubject()
     *
     * M&eacute;todo que establece el Asunto de la Nota del Archivo
     *
     * @param string $varNoteSubject Asunto de la nota del archivo
     *
     * @return NULL
     */
    function setNoteSubject($varNoteSubject)
    {
        $this->_noteSubject = $varNoteSubject;
    }

    /**
     * TFileMF::getNoteSubject()
     *
     * M&eacute;todo que devuelve el Asunto de la nota del archivo
     *
     * @return string Asunto de la nota del archivo
     */
    function getNoteSubject()
    {
        return $this->_noteSubject;
    }

    /**
     * TFileMF::setNoteDescription()
     *
     * M&eacute;todo que establece la Descripcion de la nota del archivo
     *
     * @param string $varDescription Descripcion de la nota del archivo
     *
     * @return NULL
     */
    function setNoteDescription($varDescription)
    {
        $this->_noteDescription = $varDescription;
    }

    /**
     * TFileMF::getNoteDescription()
     *
     * M&eacute;todo que obtiene la descripcion de la nota del archivo
     *
     * @return string Descripcion de la nota del archivo
     */
    function getNoteDescription()
    {
        return $this->_noteDescription;
    }

    /**
     *  TFileMF::setFolder()
     *
     * M&eacute;todo que establece el nombre de la carpeta
     *
     * @param string $varFolder Nombre de la carpeta
     *
     * @return NULL
     */
    function setFolder($varFolder)
    {
        $this->_noteDescription = $varFolder;
    }

    /**
     * TFileMF::getFolder()
     *
     * M&eacute;todo que devuelve la carpeta del archivo
     *
     * @return string Identificador de la carpeta
     * @todo       Chequear si es el nombre de la carpeta o si es TFolderMF
     */
    function getFolder()
    {
        return $this->_folder;
    }

    /**
     * TFileMF::setPassword()
     *
     * M&eacute;todo que establece el password del archivo
     *
     * @param string $varPassword Password del archivo
     *
     * @return NULL
     */
    function setPassword($varPassword)
    {
        $this->_password = $varPassword;
    }

    /**
     * TFileMF::getPassword()
     *
     * Devuelve el password del archivo
     *
     * @return string Password del archivo
     */
    function getPassword()
    {
        return $this->_password;
    }
    
    /**
     * TUsuarioMF::getLink()
     *
     * Devuelve el link de descarga del archivo
     *
     * @return string Link de descarga
     */
    function getLink()
    {
        return 'http://www.mediafire.com/?'. $this->_quickKey;
    }
    
    /**
     * TFileMF::xml2TFileMF()
     *
     * Este M&eacute;todo pasa de formato XML a TFileMF
     *
     * @param string $varFileXML Datos de usuario en formato XML
     *
     * @return NULL
     */
    function xml2TFileMF($varFileXML)
    {
        $this->setQuickKey($varFileXML['quickkey']);
        $this->setFileName($varFileXML['filename']);
        $this->setTags($varFileXML['tags']);
        $this->setDescription($varFileXML['description']);
        $this->setCreated($varFileXML['created']);
        $this->setDownloads($varFileXML['downloads']);
        $this->setSize($varFileXML['size']);
        $this->setPrivacy($varFileXML['privacy']);
    }

    /**
     * TFileMF::json2TFileMF()
     *
     * Este M&eacute;todo pasa de formato json a TFileMF
     *
     * @param string $varFileJson Datos de usuario en formato json
     *
     * @return NULL
     */
    function json2TFileMF($varFileJson)
    {
        $varFileXml = json_decode($varFileJson, true);
        $this->xml2TFileMF($varFileXml);
    }

}

?>