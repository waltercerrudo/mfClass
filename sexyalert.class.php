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
 * @subpackage TSexyAlert
 * @author     Walter Cerrudo <waltercerrudo@gmail.com>
 * @copyright  2012 Walter Cerrudo
 * @license    http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @version    GIT: $Id$
 * @link       http://lawebdewalterio.com.ar
 */

/**
 * TSexyAlert
 *
 * Clase para mensajes de alerta
 *
 * @category   API
 * @package    MEDIAFIRE
 * @subpackage TSEXYALERT
 * @author     Walter Cerrudo <waltercerrudo@gmail.com>
 * @copyright  2012 Walter Cerrudo
 * @license    http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @version    Release: 0.9
 * @link       http://www.lawebdewalterio.com.ar
 */
class TSexyAlertMF
{
    /**
     * Titulo del mensaje a mostrar. Puede incluir HTML.
     *
     * @var  string Titulo
     */
    private $_title;

    /**
     * Subtitulo a mostrar. Puede incluir HTML.
     *
     * @var  string Subtitulo
     */
    private $_subTitle;

    /**
     * Mensaje personalizado a mostrar. Puede incluir HTML
     *
     * @var string Mensaje personalizado.
     */
    private $_msg;

    /**
     * Numero de error
     *
     * @var  integer Numero de error
     */
    private $_errorNo;

    private $_cns1JQRYGOOGLE;
    private $_cns2JQRYEASING;
    private $_cns3SEXYALERT;
    private $_cns4SXYALRTCSS;
    private $_cns5INISCRPT;
    private $_cns6FINSCRPT;

    /**
     * TSexyAlertMF::__construct()
     *
     * Crea una instancia con los datos de la respuesta del servidor.
     *
     * @param mixed $varXMLResponse Respuesta del servidor en formato XML
     *
     * @return TSexyAlertMF Instancia de TSexyAlertMF
     */
    public function __construct($varXMLResponse)
    {
        if (array_key_exists('error', $varXMLResponse)) { 
            $this->_setErrorNo($varXMLResponse['error']);
        } else {
            $this->_setErrorNo('');
        }
        if (array_key_exists('message', $varXMLResponse)) { 
            $this->_setErrorNo($varXMLResponse['message']);
        } else {
            $this->_setErrorNo('');
        }        
        if (array_key_exists('action', $varXMLResponse)) { 
            $this->_setErrorNo($varXMLResponse['action']);
        } else {
            $this->_setErrorNo('');
        }        
        $this->_setTitle('MediaFire');
        $this->_cns1JQRYGOOGLE = '<script type="text/javascript" ';
        $this->_cns1JQRYGOOGLE .= 'src="./msg/jquery-1.3.2.min.js"></script>';
        $this->_cns2JQRYEASING = '<script type="text/javascript" ';
        $this->_cns2JQRYEASING .= 'src="./msg/jquery.easing.1.3.js"></script>';
        $this->_cns3SEXYALERT = '<script type="text/javascript" src="';
        $this->_cns3SEXYALERT .= './msg/sexyalertbox.v1.2.jquery.js"></script>';
        $this->_cns4SXYALRTCSS = '<link rel="stylesheet" type="text/css" ';
        $this->_cns4SXYALRTCSS.= 'media="all" href="./msg/sexyalertbox.css"/>';
        $this->_cns5INISCRPT = '<script type="text/javascript">function test() {';
        $this->_cns6FINSCRPT = '}</script>';
    }

    /**
     * TSexyAlertMF::_setTitle()
     *
     * Establece el Titulo del Mensaje
     *
     * @param string $varTitle Titulo del Mensaje
     *
     * @return NULL
     */
    private function _setTitle($varTitle)
    {
        $this->title = $varTitle;
    }

    /**
     * TSexyAlertMF::_setSubTitle()
     *
     * Establece el Subtitulo el Mensaje
     *
     * @param string $varSubTitle Subtitulo del mensaje
     *
     * @return NULL
     */
    private function _setSubTitle($varSubTitle)
    {
        $this->_subTitle = $varSubTitle;
    }

    /**
     * TSexyAlertMF::_setMsg()
     *
     * Establece el texto del Mensaje
     *
     * @param string $varMsg Texto del mensaje
     *
     * @return NULL
     */
    private function _setMsg($varMsg)
    {
        $this->_msg = $varMsg;
    }

    /**
     * TSexyAlertMF::_setErrorNo()
     *
     * Establece el Nro de error
     *
     * @param string $varErrorNo N&uacute;mero de Error
     *
     * @return [TYPE] [DESCRIPTION]
     */
    private function _setErrorNo($varErrorNo)
    {
        $this->_errorNo = $varErrorNo;
    }

    /**
     * TSexyAlertMF::showAlert()
     *
     * Llama a a funci&oacute; TSexyAlertMF::showMsg()
     * a fin de mistrar un mensaje de alerta incluyendo
     * el texto pasado por $varCustomTxt
     *
     * @param string $varCustomTxt Texto persnalizado a mostrar.
     *
     * @return NULL
     */
    public function showAlert($varCustomTxt = "  ")
    {
        $this->_showMsg('alert', $varCustomTxt);
    }

    /**
     * TSexyAlertMF::showInfo()
     *
     * Llama a a funci&oacute; TSexyAlertMF::showMsg() a fin de mostrar
     * un mensaje de advertencia incluyendo el texto pasado por $varCustomTxt
     *
     * @param string $varCustomTxt Texto personalizado a mostrar.
     *
     * @return NULL
     */
    public function showInfo($varCustomTxt = "  ")
    {
        $this->_showMsg('info', $varCustomTxt);
    }

    /**
     * TSexyAlertMF::showError()
     *
     * Llama a a funci&oacute; TSexyAlertMF::showMsg() a fin de mostrar
     * un mensaje de error incluyendo el texto pasado por $varCustomTxt
     *
     * @param string $varCustomTxt Texto personalizado a mostrar.
     *
     * @return NULL
     */
    public function showError($varCustomTxt = "  ")
    {
        $this->_showMsg('error', 'Error N°: '.$this->_errorNo.'. '.$varCustomTxt);
    }

    /**
     * TSexyAlertMF::_showMsg()
     *
     * Muestra un mensaje
     *
     * @param string $varTMsg      Tipo de mensaje a mostrar.
     *                             'info' para mensaje de informaci&oacute;n;
     *                             'error' para mensaje de error
     *                             'alert' para mensaje de advertencia.
     * @param string $varCustomTxt Texto personalizado a mostrar.
     *
     * @return NULL
     */
    private function _showMsg($varTMsg, $varCustomTxt = " ")
    {
        $res = $this->_cns1JQRYGOOGLE;
        $res .= $this->_cns2JQRYEASING;
        $res .= $this->_cns3SEXYALERT;
        $res .= $this->_cns4SXYALRTCSS;
        $res .= $this->_cns5INISCRPT;
        $res .= "Sexy." . $varTMsg . "(\"</h1><em>" . $this->_subTitle .
        $res .= "</em><br/><p>".$this->_msg."</p><p>".$varCustomTxt."</p>\")";
        $res .= $this->_cns6FINSCRPT;
        echo $res;
    }
}

?>