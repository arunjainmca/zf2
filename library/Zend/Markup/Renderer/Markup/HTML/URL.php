<?php
/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 * @package    Zend_Markup
 * @subpackage Renderer_Markup_Html
 * @copyright  Copyright (c) 2005-2010 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id$
 */

/**
 * @namespace
 */
namespace Zend\Markup\Renderer\Markup\HTML;
use Zend\Markup\Token;

/**
 * URL markup for HTML
 *
 * @uses       \Zend\Markup\Renderer\HTML
 * @uses       \Zend\Markup\Renderer\Markup\HTML\HTMLAbstract
 * @uses       \Zend\Markup\Token
 * @category   Zend
 * @package    Zend_Markup
 * @subpackage Renderer_Markup_Html
 * @copyright  Copyright (c) 2005-2010 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class URL extends HTMLAbstract
{

    /**
     * Convert the token
     *
     * @param \Zend\Markup\Token $token
     * @param string $text
     *
     * @return string
     */
    public function __invoke(Token $token, $text)
    {
        if ($token->hasAttribute('url')) {
            $uri = $token->getAttribute('url');
        } else {
            $uri = $text;
        }

        if (!preg_match('/^([a-z][a-z+\-.]*):/i', $uri)) {
            $uri = 'http://' . $uri;
        }

        // check if the URL is valid
        // TODO: use the new Zend\URI for this
        if (!\Zend\Markup\Renderer\HTML::isValidUri($uri)) {
            return $text;
        }

        $attributes = $this->renderAttributes($token);

        // run the URI through htmlentities
        $uri = htmlentities($uri, ENT_QUOTES, $this->getEncoding());

        return "<a href=\"{$uri}\"{$attributes}>{$text}</a>";
    }
}
