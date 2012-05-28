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
 * @subpackage TMEDIAFIRE
 * @author     Walter Cerrudo <waltercerrudo@gmail.com>
 * @copyright  2012 Walter Cerrudo
 * @license    http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @version    SVN: $Id$
 * @link       http://lawebdewalterio.com.ar
 */

require_once '/usuario.class.php';
require_once '/file.class.php';
require_once '/folder.class.php';
require_once '/myfiles.class.php';
require_once '/sexyalert.class.php';

/**
 * TMediaFire
 *
 * Clase principal para el acceso a MediaFire
 *
 * @category   API
 * @package    MEDIAFIRE
 * @subpackage TMEDIAFIRE
 * @author     Walter Cerrudo <waltercerrudo@gmail.com>
 * @copyright  2012 Walter Cerrudo
 * @license    http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @version    Release: 0.9
 * @link       http://lawebdewalterio.com.ar
 */

class TMediafire
{

    /**
     * Identificador de la Apicaci&oacute; dado por MediaFire
     *
     *
     * @var  string Identificador de la Apicaci&oacute; dado por MediaFire
     */
    private $_appid;
    /**
     * Clave API dada por MediaFire
     *
     * @var  string Clave API dada por MediaFire
     */
    private $_apikey;
    /**
     * Formato de la respuesta
     *
     * @var  string Formato de la respuesta
     */
    private $_response_format; // string (xml o json)
    /**
    * Versi&oacute;n API utilizada
    *
    * @var  string Versi&oacute;n API utilizada
    */
    private $_version;
    /**
     * Instancia de TUsuarioMF
     *
     * @var  TUsuarioMF Instancia de TUsuarioMF con datos del Usuario actual
     */
    private $_usuario; // TUsuarioMF
    /**
    * Mostrar errores?
    *
    * @var  boolean Si es Verdadero se muestran los errores, de lo contrario
    *               no se muestran.
    */
    private $_showError;

    /**
     * Mediafire::__construct()
     *
     * Este m&eacute;todo requiere como par&aacute;metros una variable TUsuarioMF
     * donde deben haberse ingresado el mail y el nombre del usuario.
     *
     * @param TUsuarioMF $varUser           Instancia de la clase TUsuario.
     * @param string     $varResponseFormat Formato en que es devuelta la
     *                                      informaci&oacute;n desde MediaFire.
     *                                      Por defecto es json
     * @param string     $varVersion        Versi&oacute;n de API.
     * @param string     $varAppId          Identificador de la Aplicaci&aacute;n
     *                                      brindado por Mediafire. Valor por
     *                                      defecto para probar el funcionamiento
     *                                      en cuenta creada para tal fin.
     * @param string     $varAPIKey         Clave API brindada por mediafire.
     *                                      Valor por defecto para probar el
     *                                      funcionamiento en cuenta creada
     *                                      para tal fin.
     *
     * @return TMediafire Instancia de acceso
     */
    function __construct(
        TUsuarioMF $varUser,
        $varResponseFormat = 'json',
        $varVersion = '2.3',
        $varAppId = '4458',
        $varAPIKey = '7nxabmt58ztmd0lw8y0fr7xelvqh3adkwhlub0hx'
    ) {
        $this->_usuario = $varUser;
        $this->_appid = $varAppId;
        $this->_apikey = $varAPIKey;
        $this->_version = $varVersion;
        $this->_response_format = $varResponseFormat;
        $this->_showError = false;
    }

    /**
     * Mediafire::test()
     *
     * Funci&oacute;n que verifica la conecci&oacute; con MediaFire
     *
     * @return boolean Informa si se logro la conecci&oacute; o no.
     */
    function test()
    {
        $url = 'https://www.mediafire.com/api/user/get_session_token.php?email=' .
                $this->_usuario->getEmail() . '&password=' .
                $this->_usuario->getPass() . '&application_id=' .
                $this->_appid . '&signature=' .
                $this->_signature($this->_usuario) . '&response_format=' .
                $this->_response_format . '&version=' .
                $this->_version;
        $response = $this->curlSsl($url);
        if ($this->_response_format == 'json') {
            $response = json_decode($response, true);
        }

        if (is_array($response)) {
            $msg = new TSexyAlertMF($response);
            $msg->showInfo('<h3>Conecci&oacute;n exitosa</h3>');
            $res = true;
        } else {
            $msg = new TSexyAlertMF($response);
            $msg->showError('No se ha podido conectar con MediaFire');
            $res = false;
        }
        return $res;
    }

    /**
     * Mediafire::curlSsl()
     *
     * Funci&oacute;n que realiza la consulta mediante una conecci&oacute;n segura
     * al servidor de MediaFire.
     * Es una versi&oacute;n personalizada de curl_exec()
     *
     * @param string $url URL API de consulta al servidor MediaFire
     *
     * @return array Respuesta del servidor devuelta en formato xml
     */
    function curlSsl($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    /**
     * Mediafire::_signature()
     *
     * Crea la Firma requerida por MediaFire para acceder a los servicios.
     *
     * @return string Firma para acceder a las API de Mediafire
     */
    private function _signature()
    {
        $res = $this->_usuario->getEmail();
        $res .= $this->_usuario->getPass();
        $res .= $this->_appid;
        $res .= $this->_apikey;
        return hash('sha1', $res);
    }

    /**
     * Mediafire::getSessionToken()
     *
     * Genera un token de acceso v&aacute;lido durante 10 minutos
     * para relizar las consultas API.
     *
     * @return string Token de la sesi&oacute;n a actual
     * @link       https://www.mediafire.com/api/user/getSessionToken.php
     */
    function getSessionToken()
    {
        $url = 'https://www.mediafire.com/api/user/get_session_token.php?email=' .
                $this->_usuario->getEmail() . '&password=' .
                $this->_usuario->getPass() . '&application_id=' .
                $this->_appid . '&signature=' .
                $this->_signature($this->_usuario) . '&response_format=' .
                $this->_response_format . '&version=' .
                $this->_version;
        $response = $this->curlSsl($url);
        
        if ($this->_response_format == 'json') {
            $response = json_decode($response, true);
        }
        $response = $response['response'];
        
        if ($response['result'] == 'Success') {
            $res = $response['session_token'];
        } else {
            if ($this->_showError) {
                $msg = new TSexyAlertMF($response);
                $msg->showError('<h3>Get Session Token</h3>');
            }
            $res = false;
            $this->showError = false;
        }
        return $res;
    }


    //Usuarios
    /**
    * Mediafire::renewSessionToken()
    *
    * Extiende la valid&eacute;z del token de la sesi&oacute;n
    * por otros 10 minutos.
    * Si el token de la sesi&oacute;n tiene una vida menor a 5 minutos
    * no es regenerado, y el mismo  token es devuelto. Si tiene mas de
    * 5 minutos entonces, dependiendo de la configuraci&oacute;n de la
    * aplicaci&oacute;n, el token puede ser generado nuevamente o no.
    *
    * @return string Token de la sesi&oacute;n a actual
    * @link       https://www.mediafire.com/api/user/renew_session_token.php
    */
    function renewSessionToken()
    {
        $url = 'https://www.mediafire.com/api/user/renew_session_token.php?email=' .
                $this->_usuario->getEmail() . '&password=' .
                $this->_usuario->getPass() . '&application_id=' .
                $this->_appid . '&signature=' .
                $this->_signature() . '&response_format=' .
                $this->_response_format . '&version=' .
                $this->_version;
        $response = $this->curlSsl($url);
        if ($this->_response_format == 'json') {
            $response = json_decode($response, true);
        }
        $response = $response['response'];
        if ($response['result'] == 'Success') {
            $res = $response['session_token'];
        } else {
            if ($this->showError) {
                $msg = new TSexyAlertMF($response);
                $msg->showError('<h3>Get Session Token</h3>');
            }
            $res = false;
            $this->showError = false;
        }
        return $res;
    }

    /**
     * Mediafire::getLoginToken()
     *
     * Genera un token de login durante 60 segundos usado por el desarrollador
     * la logearse directamente a MediFire.
     * Requiere conecci&oacute;n mediante ssl
     *
     * @return string Token de login de la session
     * @link       https://www.mediafire.com/api/user/get_login_token.php
     */
    function getLoginToken()
    {
        $url = 'https://www.mediafire.com/api/user/get_login_token.php?email=' .
                $this->_usuario->getEmail() . '&password=' .
                $this->_usuario->getPass() . '&application_id=' .
                $this->_appid . '&signature=' .
                $this->_signature() . '&response_format=' .
                $this->_response_format . '&version=' .
                $this->_version;
        $response = $this->curlSsl($url);
        if ($this->_response_format == 'json') {
            $response = json_decode($response, true);
        }
        $response = $response['response'];
        if ($response['result'] == 'Success') {
            $res = $response['session_token'];
        } else {
            if ($this->showError) {
                $msg = new TSexyAlertMF($response);
                $msg->showError('<h3>Get Session Token</h3>');
            }
            $res = false;
            $this->showError = false;
        }
        return $res;
    }

    /**
     * Mediafire::register()
     *
     * Crea una nueva cuenta en MediaFire
     * Requiere conecci&oacute;n mediante ssl
     *
     * @return boolean Resultado de la funci&oacute;n
     * @link       https://www.mediafire.com/api/user/register.php
     */
    function register()
    {
        $url = 'https://www.mediafire.com/api/user/register.php?application_id=' .
                $this->_apiid . '&email=' .
                $this->_usuario->getEmail() . '&password=' .
                $this->_usuario->getPass() . '&response_format=' .
                $this->_response_format . '&version=' .
                $this->_version;
        $url = $url . '&first_name=' . $this->_usuario->getFirstName();
        $url = $url . '&last_name=' . $this->_usuario->getLastName();
        $url = $url . '&display_name=' . $this->_usuario->getDisplayName();
        $response = $this->curlSsl($url);
        if ($this->_response_format == 'json') {
            $response = json_decode($response, true);
        }
        $response = $response['response'];
        if ($response['result'] == 'Success') {
            $res = $response['session_token'];
        } else {
            if ($this->showError) {
                $msg = new TSexyAlertMF($response);
                $msg->showError('<h3>Get Session Token</h3>');
            }
            $res = false;
            $this->showError = false;
        }
        return $res;
    }

    /**
     * Mediafire::getUserInfo()
     *
     * Devuelve informaci&oacute;n del usuario que ha iniciado sesi&oacute;n.
     *
     * @return boolean $res Resultado de la funci&oacute;n
     * @link       http://www.mediafire.com/api/user/get_info.php
     */
    function getUserInfo()
    {
        $url = 'https://www.mediafire.com/api/user/get_info.php?session_token=' .
                $this->getSessionToken() . '&response_format=' .
                $this->_response_format . '&version=' .
                $this->_version;
        $response = $this->curlSsl($url);
        if ($this->_response_format == 'json') {
            $response = json_decode($response, true);
        }
        $response = $response['response'];
        if ($response['result'] == 'Success') {
            $response = $response['user_info'];
            $this->_usuario->xml2TUsuarioMF($response);
            $res = true;
        } else {
            if ($this->showError) {
                $msg = new TSexyAlertMF($response);
                $msg->showError('<h3>Get User Info</h3>');
            }
            $res = false;
            $this->showError = false;
        }
        return $res;
    }

    /**
     * Mediafire::userUpdate()
     *
     * Actualiza la informaci&oacute;n del usuario
     *
     * @return boolean Resultado de la funci&oacute;n
     * @link       http://www.mediafire.com/api/user/update.php
     */
    function userUpdate()
    {
        $url = 'https://www.mediafire.com/api/user/update.php?session_token=' .
                $this->getSessionToken() . '&response_format=' .
                $this->_response_format . '&version=' .
                $this->_version;
        $url = $url . '&display_name=' . $this->_usuario->getDisplayName();
        $url = $url . '&first_name=' . $this->_usuario->getFirstName();
        $url = $url . '&last_name=' . $this->_usuario->getLastName();
        $url = $url . '&birth_date=' . $this->_usuario->getBirthDate();
        $url = $url . '&gender=' . $this->_usuario->getGender();
        $url = $url . '&website=' . $this->_usuario->getWebSite();
        $url = $url . '&location=' . $this->_usuario->getLocation();
        $url = $url . '&newsletter=' . $this->_usuario->getNewsletter();
        $url = $url . '&primary_usage=' . $this->_usuario->getPrimaryUsage();
        $url = $url . '&display_name=' . $this->_usuario->getDisplayName();
        $response = $this->curlSsl($url);
        if ($this->_response_format == 'json') {
            $response = json_decode($response, true);
        }
        $response = $response['response'];
        if ($response['result'] == 'Success') {
            $res = true;
        } else {
            if ($this->showError) {
                $msg = new TSexyAlertMF($response);
                $msg->showError('<h3></h3>');
            }
            $res = false;
            $this->showError = false;
        }
        return $res;
    }

    /**
     * Mediafire::myFiles()
     *
     * Devuelve un listado con los item del usuario actual.
     * La lista puede contener, carpetas, archivos o ambos,
     * segun los par&aacute;metros.
     *
     * @param string $filter    Filtro, 'files' (devuelve solo los archivos),
     *                          'folders' (devuelve solo carpetas) y 'all'
     *                          (devuelve archivos y carpetas)
     * @param string $format    Formato en que es devuelta la informaci&oacute;n,
     *                          'tree' en formato &aacute;rbol o 'list'
     *                          para listado. Si $filter esta definido como
     *                          'files', este par&aacute;metro es igonardo y el
     *                          contenido es devuelto como una lista.
     * @param string $recursive Admite los valores 'yes' o 'no'. Si es yes entonces
     *                          todas las subcarpetas y subarchivos son devueltos.
     *                          De lo contrario solo son devueltos los archivos y
     *                          carpetas del directorio ra&iacute;z.
     * @param string $start     Posici&oacute;n desde la cual se devuelven
     *                          los archivos.
     * @param string $limit     N&uacute;mero m&aacute;ximo de reultados devueltos.
     *
     * @return boolean Resultado de la llamada API
     * @link       http://www.mediafire.com/api/user/myfiles.php
     */

    function myFiles(
        $filter = 'all',
        $format = 'tree',
        $recursive = 'yes',
        $start = '',
        $limit = '9999999'
    ) {
        $url = 'https://www.mediafire.com/api/user/myfiles.php?content_filter=' .
                $filter . '&content_format=' .
                $format . '&session_token=' .
                $this->getSessionToken() . '&recursive=' .
                $recursive . '&start=' .
                $start . '&limit=' .
                $limit . '&response_format=' .
                $this->_response_format . '&version=' .
                $this->_version; 
        $response = $this->curlSsl($url);
        if ($this->_response_format == 'json') {
            $response = json_decode($response, true);
        }
        $response = $response['response'];
        if ($response['result'] == 'Success') {
            $this->myFiles = new TMyFilesMF;
            $response = $response['myfiles'];
            $root = new TFolderMF;
            $this->myFiles->setRootFolder($root);
            $this->myFiles->getMyFile($response);
            $res = $response;
        } else {
            if ($this->showError) {
                $msg = new TSexyAlertMF($response);
                $msg->showError('<h3></h3>');
            }
            $res = false;
            $this->showError = false;
        }
        return $res;
    }

    /**
     * Mediafire::myFilesRevision()
     *
     * Ni Idea
     *
     * @return null Nada
     */
    function myFilesRevision()
    {
        return null;
    }

    /**
     * Mediafire::getFilesInfo()
     *
     * Devuelve informaci&oacute;n de un archivo
     *
     * @param TFileMF $varFile Instancia Archivo
     *
     * @return boolean Resultado de la llamada API
     * @link       http://www.mediafire.com/api/file/get_info.php
     */
    function getFilesInfo(TFileMF $varFile)
    {
        $url = 'https://www.mediafire.com/api/file/get_info.php?session_token=' .
                $this->getSessionToken($this->_usuario) . '&quick_key=' .
                $varFile->getQuickKey() . '&response_format=' .
                $this->_response_format . '&version=' .
                $this->_version;
        $response = $this->curlSsl($url);
        if ($this->_response_format == 'json') {
            $response = json_decode($response, true);
        }
        $response = $response['response']['file_info'];
        $varFile->xml2TFileMF($response);
        if ($response['result'] == 'Success') {
            $res = true;
        } else {
            if ($this->showError) {
                $msg = new TSexyAlertMF($response);
                $msg->showError('<h3></h3>');
            }
            $res = false;
            $this->showError = false;
        }
        return $res;
    }

    /**
     * Mediafire::fileDelete()
     *
     * Elimina un archivo
     *
     * @param TFileMF $varFile Archivo a eliminar
     *
     * @return boolean Resultado de la llamada API
     * @link       http://www.mediafire.com/api/file/delete.php
     */
    function fileDelete(TFileMF $varFile)
    {
        $url = 'https://www.mediafire.com/api/file/delete.php?session_token=' .
                $this->getSessionToken($this->_usuario) . '&quick_key=' .
                $varFile->getQuickKey() . '&response_format=' .
                $this->_response_format . '&version=' .
                $this->_version;
        $response = $this->curlSsl($url);
        if ($this->_response_format == 'json') {
            $response = json_decode($response, true);
        }
        $response = $response['response'];
        if ($response['result'] == 'Success') {
            $res = true;
        } else {
            if ($this->showError) {
                $msg = new TSexyAlertMF($response);
                $msg->showError('<h3></h3>');
            }
            $res = false;
            $this->showError = false;
        }
        return $res;
    }

    /**
     * Mediafire::fileMove()
     *
     * Mueve un archivo de una carpeta a otra
     *
     * @param TFileMF $varFile Instancia de Archivo
     *
     * @return boolean Resultado de la llamada API
     * @link       http://www.mediafire.com/api/file/move.php
     */
    function fileMove(TFileMF $varFile)
    {
        $url = 'http://www.mediafire.com/api/file/move.php?session_token=' .
                $this->getSessionToken($this->_usuario) . '&folder_key=' .
                $varFile->getFolder() . '&quick_key=' .
                $varFile->getQuickKey() . '&response_format=' .
                $this->_response_format . '&version=' .
                $this->_version;
        $response = $this->curlSsl($url);
        if ($this->_response_format == 'json') {
            $response = json_decode($response, true);
        }
        $response = $response['response'];
        if ($response['result'] == 'Success') {
            $res = true;
        } else {
            if ($this->showError) {
                $msg = new TSexyAlertMF($response);
                $msg->showError('<h3></h3>');
            }
            $res = false;
            $this->showError = false;
        }
        return $res;
    }

    /**
     * Mediafire::fileUpdate()
     *
     * Actualiza la informaci&oacute;n de un archivo.
     *
     * @param TFileMF $varFile Archivo al cual se desea modificar el password
     *
     * @return boolean Resultado de la llamada API
     * @link       http://www.mediafire.com/api/file/update.php
     */
    function fileUpdate(TFileMF $varFile)
    {
        $url = 'https://www.mediafire.com/api/file/update.php?session_token=' .
                $this->getSessionToken($this->_usuario) . '&quick_key=' .
                $varFile->getfolderkey() .  '&response_format=' .
                $this->_response_format . '&version=' .
                $this->_version;
        $url = $url + '&desc=' . $varFile->getdesc();
        $url = $url + '&name=' . $varFile->getname();
        $url = $url + '&tags=' . $varFile->getTags();
        $url = $url + '&created=' . $varFile->getcreated();
        $url = $url + '&note_subject=' . $varFile->getfoldercount();
        $url = $url + '&note_desc=' . $varFile->getfilecount();
        $response = $this->curlSsl($url);
        if ($this->_response_format == 'json') {
            $response = json_decode($response, true);
        }
        $response = $response['response'];

        if ($response['result'] == 'Success') {
            $res = true;
        } else {
            if ($this->showError) {
                $msg = new TSexyAlertMF($response);
                $msg->showError('<h3></h3>');
            }
            $res = false;
            $this->showError = false;
        }
        return $res;
    }

    /**
     * Mediafire::updateFilePassword()
     *
     * Actualiza el password del archivo pasado por par&aacute;metro
     *
     * @param TFileMF $varFile Archivo al cual se le desea modificar el password
     *
     * @return boolean Resultado de la llamada API
     * @link       http://www.mediafire.com/api/file/update_password.php
     */
    function updateFilePassword(TFileMF $varFile)
    {
        $url = 'https://www.mediafire.com/api/file/update_password.php?password=' .
                $varFile->getPassword() . 'session_token=' .
                $this->getSessionToken($this->_usuario) . '&quick_key=' .
                $varFile->getQuickKey() . '&response_format=' .
                $this->_response_format . '&version=' .
                $this->_version;
        $response = $this->curlSsl($url);
        if ($this->_response_format == 'json') {
            $response = json_decode($response, true);
        }
        $response = $response['response'];


        if ($response['result'] == 'Success') {
            $token = true;
        } else {
            if ($this->showError) {
                $msg = new TSexyAlertMF($response);
                $msg->showError('<h3></h3>');
            }
            $res = false;
            $this->showError = false;
        }
        return $token;
    }

    //Folder

    /**
     * Mediafire::get_folder_info()
     *
     * Devuelve informaci&oacute;n de una carpeta
     *
     * @param TFolderMF $folder Carpeta de la que se desea obtener informaci&oacute;n
     *
     * @return boolean Resultado de la llamada API
     * @link       http://www.mediafire.com/api/folder/get_info.php
     */
    function getFolderInfo(TFolderMF $folder)
    {
        $url = 'https://www.mediafire.com/api/folder/get_info.php?folder_key=' .
                $folder->getFolderKey() . '&session_token=' .
                $this->getSessionToken($this->_usuario) . '&response_format=' .
                $this->_response_format . '&version=' .
                $this->_version;
        $response = $this->curlSsl($url);
        if ($this->_response_format == 'json') {
            $response = json_decode($response, true);
        }
        $response = $response['response'];
        if ($response['result'] == 'Success') {
            $res = $response['session_token'];
        } else {
            if ($this->showError) {
                $msg = new TSexyAlertMF($response);
                $msg->showError('<h3></h3>');
            }
            $res = false;
            $this->showError = false;
        }
        return $res;
    }

    /**
     * Mediafire::folderDelete()
     *
     * Elimina una carpeta en MediaFire
     *
     * @return boolean Resultado de la llamada API
     * @link       http://www.mediafire.com/api/folder/delete.php
     */
    function folderDelete()
    {
        $url = 'http://www.mediafire.com/api/folder/delete.php?folder_key=' .
                $folder->getFolderKey() . '&session_token=' .
                $this->getSessionToken($this->_usuario) . '&response_format=' .
                $this->_response_format . '&version=' .
                $this->_version;
        $response = $this->curlSsl($url);
        if ($this->_response_format == 'json') {
            $response = json_decode($response, true);
        }
        $response = $response['response'];
        if ($response['result'] == 'Success') {
            $res = true;
        } else {
            if ($this->showError) {
                $msg = new TSexyAlertMF($response);
                $msg->showError('<h3></h3>');
            }
            $res = false;
            $this->showError = false;
        }
        return $res;
    }

    /**
     * Mediafire::folderMove()
     *
     * Este m&eacute;todo mueve la carpeta a una nueva carpeta
     *
     * @param TFolderMF $folder_key_dst Carpeta destino
     *
     * @return boolean Resultado de la llamada API
     * @link       http://www.mediafire.com/api/folder/move.php
     * @todo       mover a TFolderMF?
     */
    function folderMove(TFolderMF $folder_key_dst)
    {
        $url = 'http://www.mediafire.com/api/folder/move.php?folder_key=' .
                $folder->getFolderKey() . '&session_token=' .
                $this->getSessionToken($this->_usuario) . '&response_format=' .
                $this->_response_format . '&version=' .
                $this->_version;
        if ($folder_key_dst->getFolderKey() <> '') {
            $url = $url . '&folder_key_dst=' . $folder_key_dst->getFolderKey();
        }
        $response = $this->curlSsl($url);
        if ($this->_response_format == 'json') {
            $response = json_decode($response, true);
        }
        $response = $response['response'];
        if ($response['result'] == 'Success') {
            $res = true;
        } else {
            if ($this->showError) {
                $msg = new TSexyAlertMF($response);
                $msg->showError('<h3></h3>');
            }
            $res = false;
            $this->showError = false;
        }

        return $res;
    }

    /**
     * Mediafire::folder_create()
     *
     * Crea una nueva carpeta en MdiaFire llamada $varFolderName
     *
     * @param string    $varFolderName  Nombre de la nueva carpeta
     * @param TFolderMF $folder_key_dst Nombre de la carpeta destino.
     *                                  Por defecto es la carpeta Raiz
     *
     * @return boolean Resultado de la llamada API
     * @link       http://www.mediafire.com/api/folder/create.php
     */
    function folderCreate($varFolderName, TFolderMF $folder_key_dst = null)
    {
        $url = 'http://www.mediafire.com/api/folder/create.php?session_token=' .
                $this->getSessionToken($varUsuario) . '&foldername=' .
                $varFolderName . '&response_format=' .
                $this->_response_format . '&version=' .
                $this->_version;

        $response = $this->curlSsl($url);
        if ($this->_response_format == 'json') {
            $response = json_decode($response, true);
        }
        $response = $response['response'];
        if ($response['result'] == 'Success') {
            $res = true;
        } else {
            if ($this->showError) {
                $msg = new TSexyAlertMF($response);
                $msg->showError('<h3></h3>');
            }
            $res = false;
            $this->showError = false;
        }
        return $res;
    }

    /**
     * Mediafire::folder_update()
     *
     * Actualizar informaci&oacute;n de una carpeta
     *
     * @param TFolderMF $varFolder Carpeta con los datos a actualizar
     *
     * @return boolean Resultado de la llamada API
     * @link       http://www.mediafire.com/api/folder/update.php
     */
    function folderUpdate(TFolderMF $varFolder)
    {
        $url = 'http://www.mediafire.com/api/folder/update.php?folder_key=' .
                $folder->getFolderKey() . '&session_token=' .
                $this->getSessionToken($varUsuario). '&response_format=' .
                $this->_response_format . '&version=' .
                $this->_version;
        $url .= '&foldername=' . $varFolder->getName();
        $url .= '&description=' . $varFolder->getDesc();
        $url .= '&tags=' . $varFolder->getTags();
        $url .= '&privacy=' . $varFolder->getPrivacy();
        $response = json_decode($response, true);
        $response = $response['response'];
        if ($response['result'] == 'Success') {
            $res = true;
        } else {
            if ($this->showError) {
                $msg = new TSexyAlertMF($response);
                $msg->showError('<h3></h3>');
            }
            $res = false;
            $this->showError = false;
        }
        return $res;
    }

    /**
     * Mediafire::attachForeign()
     *
     * Agregar carpetas compartidas a una cuenta MediaFire
     *
     * @return boolean Resultado de la llamada API
     * @link       http://www.mediafire.com/api/folder/attach_foreign.php
     */
    function attachForeign()
    {
        $url = 'http://www.mediafire.com/api/folder/attach_foreign.php?folder_key='.
                $folder->getFolderKey() . '&session_token=' .
                $this->getSessionToken($varUsuario). '&response_format=' .
                $this->_response_format . '&version=' .
                $this->_version;
        $response = $this->curlSsl($url);
        if ($this->_response_format == 'json') {
            $response = json_decode($response, true);
        }
        $response = $response['response'];
        if ($response['result'] == 'Success') {
            $res = true;
        } else {
            if ($this->showError) {
                $msg = new TSexyAlertMF($response);
                $msg->showError('<h3></h3>');
            }
            $res = false;
            $this->showError = false;
        }
        return $res;
    }

    /**
     * Mediafire::detachForeign()
     *
     * Quitar carpetas compartidas a una cuenta MediaFire
     *
     * @return boolean Resultado de la llamada API
     * @link       http://www.mediafire.com/api/folder/attach_foreign.php
     */
    function detachForeign()
    {
        $url = 'http://www.mediafire.com/api/folder/detach_foreign.php?folder_key=' .
                $folder->getFolderKey() . '&session_token=' .
                $this->getSessionToken($varUsuario). '&response_format=' .
                $this->_response_format . '&version=' .
                $this->_version;
        $response = $this->curlSsl($url);
        if ($this->_response_format == 'json') {
            $response = json_decode($response, true);
        }
        $response = $response['response'];
        if ($response['result'] == 'Success') {
            $res = true;
        } else {
            if ($this->showError) {
                $msg = new TSexyAlertMF($response);
                $msg->showError('<h3></h3>');
            }
            $res = false;
            $this->showError = false;
        }
        return $res;
    }

    /**
     * Mediafire::getRevision()
     *
     * Obtiene la versi&oacute;n de la carpeta
     *
     * @return boolean Resultado de la llamada API
     * @link       http://www.mediafire.com/api/folder/get_revision.php
     */
    function getRevision()
    {
        $url = 'http://www.mediafire.com/api/folder/get_revision.php?folder_key=' .
                $folder->getFolderKey() . '&response_format=' .
                $this->_response_format . '&version=' .
                $this->_version;
        $response = $this->curlSsl($url);
        if ($this->_response_format == 'json') {
            $response = json_decode($response, true);
        }
        $response = $response['response'];
        if ($response['result'] == 'Success') {
            $res = true;
        } else {
            if ($this->showError) {
                $msg = new TSexyAlertMF($response);
                $msg->showError('<h3></h3>');
            }
            $res = false;
            $this->showError = false;
        }
        return $res;
    }

    /**
     * Mediafire::getUsuario()
     *
     * Devuelve el usuario actual
     *
     * @return TUsuarioMF Usuario
     */
    function getUsuario()
    {
        return $this->_usuario;
    }
    
    /**
     * TUsuarioMF::getDirectLink()
     *
     * Devuelve la URL para descarga directa
     *
     * @param TFileMF $varFile Archivo del cual se obtendr&aacute; el link
     *
     * @return string URL
     */
    function getDirectLink(TFileMF $varFile) 
    {
        
        $url = 'http://www.mediafire.com/dynamic/dlget.php?qk=' . 
            $varFile->getQuickKey();
        $response = $this->curlSsl($url);
        if ($this->_response_format == 'json') {
            $response = json_decode($response, true);
        }
        $response = $response['response'];
        if ($response['result'] == 'Success') {
            $res = stripslashes($response['dllink']);
        } else {
            if ($this->showError) {
                $msg = new TSexyAlertMF($response);
                $msg->showError('<h3></h3>');
            }
            $res = 'error';
            $this->showError = false;
        }
        return $res;
    }
    
    /**
     * TUsuarioMF::getLink()
     *
     * Devuelve el enlace para la descarga
     *
     * @param TFileMF $varFile Archivo del cual se obtendr&aacute; el link
     *
     * @return string URL
     */
    function getLink(TFileMF $varFile)
    {
        $url = 'http://www.mediafire.com/?'.$varFile->getQuickKey();
        // $url = '<a href=\"'.$url.'\" target="_blank">';
        // $url .= $varFile->getFileName().'</a>';

        return $res;
    }
}

?>