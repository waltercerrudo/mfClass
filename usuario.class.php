<?php
/**
 * [CLASS SHORT DESCRIPTION]
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
 * @subpackage TUSUARIOMF
 * @author     Walter Cerrudo <waltercerrudo@gmail.com>
 * @copyright  2012 Walter Cerrudo
 * @license    http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @version    GIT: $Id$
 * @link       http://lawebdewalterio.com.ar
 */

require_once '../folder.class.php';

/**
 * TUsuarioMF
 *
 * Clase de Usuario de MediaFire
 *
 * @category   API
 * @package    MEDIAFIRE
 * @subpackage TUSUARIOMF
 * @author     Walter Cerrudo <waltercerrudo@gmail.com>
 * @copyright  2012 Walter Cerrudo
 * @license    http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @version    Release: 0.9
 * @link       http://www.lawebdewalterio.com.ar
 */

class TUsuarioMF
{

    /**
     * Correo electronico del usuario
     *
     * @var  string correo electronico
     * @todo Validar
     */
    private $_email;

    /**
     * Password del usuario
     *
     * @var  string Password
     */
    private $_pass;

    /**
     * Primer nombre del Usuario
     *
     * @var  string Primer Nombre
     */
    private $_firstName;

    /**
     * Apellido del usuario
     *
     * @var  string Apellido
     */
    private $_lastName;

    /**
     * Nombre del usuario a mostrar
     *
     * @var  string Nombre a mostrar
     */
    private $_displayName;

    /**
     * Fecha de cumplea&ntilde;os
     *
     * @var string Fecha
     */
    private $_birthDate;

    /**
     * Genero del usuario
     *
     * @var string Genero
     */
    private $_gender;

    /**
     * Sitio web del usuario
     *
     * @var  string Sitio web
     */
    private $_website;

    /**
     * Ubicacion del usuario
     *
     * @var string Ubicacion
     */
    private $_location;

    /**
     * Determina si enviar newsletter al usuario o no
     *
     * @var boolean Enviar newsletter?
     */
    private $_newsletter;

    /**
     * Uso principal del usuario
     *
     * @var  string Uso principal., 'home', 'work', 'school', 'none'
     */
    private $_primary_usage;

    /**
     * Es una cuenta premium?
     *
     * @var  boolean Es premium?
     */
    private $_premium;

    /**
     * Ancho de banda de descarga
     *
     * @var integer Ancho de banda
     */
    private $_bandwidth;

    /**
     * Fecha de creacion de la cuenta
     *
     * @var string Fecha de creacion
     */
    private $_created;

    /**
     * Tama o que puede tener el archivo a subir, en kb
     *
     * @var integer Dimension maximo
     */
    private $_maxUploadSize;

    /**
     * Maximo Instant Upload
     *
     * @var  integer Maximo Instant Upload
     */
    private $_maxInstantUpload;

    /**
     * Cuenta validada
     *
     * @var  boolean Cuenta validada?
     */
    private $_validated;

    /**
     * TUsuarioMF::__construct()
     *
     * M&eacute;todo que crea una nueva instancia de TUsuarioMF
     * e inicializa los valores de email y password
     * requeridos para el login
     *
     * @param string $varEmail Email de login en la cuenta de MediaFire
     * @param string $varPass  Password de login en la cuenta de MediaFire
     *
     * @return TUsuarioMF Instancia de TUsuarioMF
     */
    function __construct($varEmail, $varPass)
    {
        $this->_email = $varEmail;
        $this->_pass = $varPass;
    }

    /**
     * TUsuarioMF::setPrimaryUsage()
     *
     * Establece el valor para PrimaryUsage (Tipo de uso de Mediafire)
     * 'home' | 'work' | 'school' | 'none'
     *
     * @param string $varPrimaryUsage Uso
     *
     * @return NULL
     */
    function setPrimaryUsage($varPrimaryUsage)
    {
        $this->_created = $varPrimaryUsage;
    }

    /**
     * TUsuarioMF::getPrimaryUsage()
     *
     * Obtener el valor para PrimaryUsage (Tipo de uso de MediaFire)
     *
     * @return NULL
     */
    function getPrimaryUsage()
    {
        return $this->_primary_usage;
    }

    /**
     * TUsuarioMF::setCreated()
     *
     * Establece el atributo _created
     *
     * @param string $varCreated Fecha de creacion
     *
     * @return NULL
     */
    function setCreated($varCreated)
    {
        $this->_created = $varCreated;
    }

    /**
     * TUsuarioMF::getCreated()
     *
     * M&eacute;todo que devuelve la fecha de creacion de la cuenta
     *
     * @return string Fecha de creacion
     */
    function getCreated()
    {
        return $this->_created;
    }

    /**
     * TUsuarioMF::setPremium()
     *
     * Establece el valor del atributo _premium
     *
     * @param boolean $varPremium Cuenta premium?
     *
     * @return NULL
     */
    function setPremium($varPremium)
    {
        $this->_premium = $varPremium;
    }

    /**
     * TUsuarioMF::getPremium()
     *
     * M&eacute;todo que devuelve el valor del atributo _premium
     *
     * @return Boolean Devuelve true si la cuenta es premium
     */
    function getPremium()
    {
        return $this->_premium;
    }

    /**
     * TUsuarioMF::setBandWidth()
     *
     * Establece el valor para el atributo _bandwidth
     *
     * @param integer $varBandWidth Ancho de banda de descarga
     *
     * @return NULL
     */

    function setBandWidth($varBandWidth)
    {
        $this->_bandwidth = $varBandWidth;
    }

    /**
     * TUsuarioMF::getBandWidth()
     *
     * M&eacute;todo que devuelve el valor del atributo _BandWidth
     *
     * @return integer Ancho de banda de descarga
     */
    function getBandWidth()
    {
        return $this->_bandwidth;
    }

    /**
     * TUsuarioMF::setNewsLetter
     *
     * M&eacute;todo que establece el valor del atributo _newsletter
     *
     * @param boolean $varNewsletter Si es true se envia el newsletter
     *                               Si es false no se envia el newsletter
     *
     * @return NULL
     */
    function setNewsletter($varNewsletter)
    {
        $this->_newsletter = $varNewsletter;
    }

    /**
     * TUsuarioMF::getNewsLetter
     *
     * Devuelve el valor del atributo _newsLetter
     *
     * @return boolean $varNewsletter Si es true se envia el newsletter
     *                                Si es false no se envia el newsletter
     */
    function getNewsletter()
    {
        return $this->_newsletter;
    }

    /**
     * TUsuarioMF::setLocation()
     *
     * M&eacute;todo que establece el valor del atributo _location
     *
     * @param string $varLocation Valor a asignar al atributo _location
     *
     * @return NULL
     */
    function setLocation($varLocation)
    {
        $this->_location = $varLocation;
    }

    /**
     * TUsuarioMF::getLocation
     *
     * Devuelve el valor del atributo _location
     *
     * @return string Ubicacion del usuario
     */
    function getLocation()
    {
        return $this->_location;
    }

    /**
     * TUsuarioMF::setWebSite
     *
     * M&eacute;todo que establece el valor del atributo _webSite
     *
     * @param [TYPE] $varWebSite Sitio web del usuario
     *
     * @return NULL
     */
    function setWebSite($varWebSite)
    {
        $this->_website = $varWebSite;
    }

    /**
     * TUsuarioMF::getWebSite
     *
     * Devuelve el valor del atributo _webSite
     *
     * @return string Sitio web del usuario
     */
    function getWebSite()
    {
        return $this->_website;
    }

    /**
     * TUsuarioMF::setGender()
     *
     * M&eacute;todo que establece el valor del atributo _gender
     *
     * @param string $varGender Genero del usuario
     *
     * @return NULL
     */
    function setGender($varGender)
    {
        $this->_gender = $varGender;
    }

    /**
     * TUsuarioMF::getGender
     *
     * Devuelve el valor del atributo _gender
     *
     * @return [TYPE] [DESCRIPTION]
     */
    function getGender()
    {
        return $this->_gender;
    }

    /**
     * TUsuarioMF::setBirthDay()
     *
     * M&eacute;todo que establece el valor del atributo _birthDay
     *
     * @param string $varBirthDate Valor a asignar al atributo _birthDay
     *
     * @return NULL
     */
    function setBirthDate($varBirthDate)
    {
        $this->_birthDate = $varBirthDate;
    }

    /**
     * TUsuarioMF::getBirthDate()
     *
     * Devuelve el valor del atributo _birthDate
     *
     * @return string Fecha de cumplea&ntilde;os
     */
    function getBirthDate()
    {
        return $this->_birthDate;
    }

    /**
     * TUsuarioMF::setEmail()
     *
     * M&eacute;todo que establece el valor del atributo _email
     *
     * @param [TYPE] $varEmail Correo electronico
     *
     * @return boolean True si la direccion tiene formato correcto
     *                 False si la direccion de correo tiene un formato incorrecto
     * @todo       Validar direccion de correo
     */
    function setEmail($varEmail)
    {
        if (filter_var($varEmail, FILTER_VALIDATE_EMAIL)) {
            $this->_email = $varEmail;
            $res = true;
        } else {
            $res = false;
        }
        return $res;
    }

    /**
     * TUsuarioMF::getEmail()
     *
     * Devuelve el valor del atributo _Email
     *
     * @return string Correo electronico del usuario
     */
    function getEmail()
    {
        return $this->_email;
    }

    /**
     * TUsuarioMF::setPass()
     *
     * M&eacute;todo que establece el valor del atributo _pass
     *
     * @param [TYPE] $varPass Password del usuario
     *
     * @return NULL
     */
    function setPass($varPass)
    {
        $this->_pass = $varPass;
    }

    /**
     * TUsuarioMF::getPass()
     *
     * Devuelve el valor del atributo _pass
     *
     * @return string Password del usuario
     * @todo       Es util este M&eacute;todo?
     */
    function getPass()
    {
        return $this->_pass;
    }

    /**
     * TUsuarioMF::setFirstName()
     *
     * M&eacute;todo que establece el valor del atributo _firstName
     *
     * @param [TYPE] $varFirstName Primer nombre del usuario
     *
     * @return NULL
     */
    function setFirstName($varFirstName)
    {
        $this->_firstName = $varFirstName;
    }

    /**
     * TUsuarioMF::getFirstName()
     *
     * Devuelve el valor del atributo _FirstName
     *
     * @return [TYPE] [DESCRIPTION]
     */
    function getFirstName()
    {
        return $this->_firstName;
    }

    /**
     * TUsuarioMF::setLastName()
     *
     * @param mixed $varLastName
     * @return
     */
    /**
     * TUsuarioMF::setLastName()
     *
     * M&eacute;todo que establece el valor del atributo _lastName
     *
     * @param [TYPE] $varLastName Valor a asignar al atributo LastName
     *
     * @return NULL
     */
    function setLastName($varLastName)
    {
        $this->_lastName = $varLastName;
    }

    /**
     * TUsuarioMF::getLastName()
     *
     * Devuelve el valor del atributo _lastName
     *
     * @return string Apellido del Usuario
     */
    function getLastName()
    {
        return $this->_lastName;
    }

    /**
     * TUsuarioMF::setDisplayName()
     *
     * M&eacute;todo que establece el valor del atributo _displayName
     *
     * @param [TYPE] $varDisplayName Nombre del usuario a mostrar
     *
     * @return NULL
     */
    function setDisplayName($varDisplayName)
    {
        $this->_displayName = $varDisplayName;
    }

    /**
     * TUsuarioMF::getDisplayName()
     *
     * Devuelve el valor del atributo _displayName
     *
     * @return string Nombre del usuario a mostrar
     */
    function getDisplayName()
    {
        return $this->_displayName;
    }

    /**
     * TUsuarioMF::setUploadSize()
     *
     * M&eacute;todo que establece el valor del atributo _uploadSize
     *
     * @param integer $varUploadSize Subida maxima
     *
     * @return NULL
     */
    function setMaxUploadSize($varUploadSize)
    {
        $this->_maxUploadSize = $varUploadSize;
    }
    /**
     * TUsuarioMF::getMaxUploadSize()
     *
     * Devuelve el valor del atributo _maxUploadSize
     *
     * @return integer Tama&ntilde;o maximo del archivo a subir
     */
    function getMaxUploadSize()
    {
        return $this->_maxUploadSize;
    }

    /**
     * TUsuarioMF::setMaxInstantUpload()
     *
     * M&eacute;todo que establece el valor del atributo _instantUpload
     *
     * @param boolean $varInstantUpload Ni idea que es :(
     *
     * @return NULL
     */
    function setMaxInstantUpload($varInstantUpload)
    {
        $this->_maxInstantUpload = $varInstantUpload;
    }


    /**
     * TUsuarioMF::getMaxInstantSize()
     *
     * Devuelve el valor del atributo _maxInstantSize
     *
     * @return integer Tama&ntilde;o maximo del archivo
     */
    function getMaxInstantSize()
    {
        return $this->_maxInstantSize;
    }

    /**
     * TUsuarioMF::setValidated()
     *
     * M&eacute;todo que establece el valor del atributo _validated
     *
     * @param boolean $varValidated Cuenta validada?
     *
     * @return NULL
     */
    function setValidated($varValidated)
    {
        $this->_validated = $varValidated;
    }

    /**
     * TUsuarioMF::getValidated()
     *
     * Devuelve el valor del atributo _validated
     *
     * @return boolean true si la cuenta esta validada
     *                 false si la cuenta no esta validada
     */
    function getValidated()
    {
        return $this->_validated;
    }

    /**
     * TUsuarioMF::xml2TUsuarioMF
     *
     * Asigna los atributos a una instancia de TUsuarioMF
     * a partir de la informacion estructurada en formato XML
     *
     * @param string $varUsuarioXML Datos del Usuario en formato XML
     *
     * @return NULL
     */
    function xml2TUsuarioMF($varUsuarioXML)
    {
        $this->setEmail($varUsuarioXML['email']);
        $this->setFirstName($varUsuarioXML['first_name']);
        $this->setLastName($varUsuarioXML['last_name']);
        $this->setDisplayName($varUsuarioXML['display_name']);
        $this->setGender($varUsuarioXML['gender']);
        $this->setBirthDate($varUsuarioXML['birth_date']);
        $this->setWebSite($varUsuarioXML['website']);
        $this->setPremium($varUsuarioXML['premium']);
        $this->setBandWidth($varUsuarioXML['bandwidth']);
        $this->setCreated($varUsuarioXML['created']);
        $this->setMaxUploadSize($varUsuarioXML['max_upload_size']);
        $this->setMaxInstantUpload($varUsuarioXML['max_instant_upload_size']);
        $this->setValidated($varUsuarioXML['validated']);
    }

    /**
     * TUsuarioMF::json2TUsuarioMF
     *
     * Asigna los atributos a una instancia de TUsuarioMF
     * a partir de la informacion estructurada en formato json
     *
     * @param string $varUsuarioJson Datos del Usuario en formato json
     *
     * @return NULL
     */
    function json2TUsuarioMF($varUsuarioJson)
    {
        $varUsuarioXml = json_decode($varUsuarioJson, true);
        $this->xml2TUsuarioMF($varUsuarioXml);
    }
}

?>