<?php

namespace App\Services\SendingProcess\Telecom\SMPP\Server\Command;

use App\Services\SendingProcess\Telecom\SMPP\Server\Command;

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * SMPP v3.4 bind_receiver_resp command class
 *
 * PHP versions 4 and 5
 *
 * LICENSE: This source file is subject to version 3.0 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_0.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category   Networking
 * @package    Net_SMPP
 * @author     Silospen <silospen@silospen.com>
 * @copyright  Portions of the documentation (c) Copyright 1999 SMPP Developers
 *             Forum.
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    SVN: $Id$
 * @since      Release
 * @link       http://pear.php.net/package/Net_SMPP
 */

// Place includes, constant defines and $_GLOBAL settings here.

/**
 * bind_receiver_resp class
 *
 * This holds the data sent back from the SMSC after sending a bind_transmitter
 * command.
 *
 * @category   Networking
 * @package    Net_SMPP
 * @author     Silospen <silospen@silospen.com>
 * @copyright  Portions of the documentation (c) Copyright 1999 SMPP Developers
 *             Forum.
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    Release: @package_version@
 * @since      Release
 * @link       http://pear.php.net/package/Net_SMPP
 */
class BindReceiverResp extends Command
{
    /**
     * SMSC identifier.
     *
     * Identifies the SMSC to the ESME.
     *
     * @var  string
     */
    var $system_id;

    /**
     * SMPP version supported by SMSC
     *
     * @var  int
     */
    var $sc_interface_version;

    /**
     * Paramater definitions
     *
     * @var     array
     * @access  protected
     * @see     Net_SMPP_Command::$_defs
     */
    var $_defs = array(
        'system_id' => array(
            'type' => 'string',
            'max' => 16
        ),
        // Optional paramaters
        'sc_interface_version' => array(
            'type' => 'int',
            'size' => 1
        )
    );
}
