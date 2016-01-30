<?php
/**
 * This file is part of the Signature MVC-Framework.
 * @copyright Sven Erens <sven@signature-framework.com>
 */

namespace Signature\ViewHelper\Format;

use Signature\ViewHelper\ArgumentDescription;

/**
 * Class CropViewHelper
 * @package Signature\ViewHelper\Format
 */
class CropViewHelper extends \Signature\ViewHelper\AbstractViewHelper
{
    /**
     * Creates the argument descriptions for this view helper.
     */
    public function __construct()
    {
        $this->argumentDescriptions = [
            'subject' => new ArgumentDescription(true),
            'length'  => new ArgumentDescription(true, 'int'),
            'suffix'  => new ArgumentDescription(false, 'string', '...'),
        ];

        parent::__construct();
    }

    /**
     * @return string
     */
    public function render()
    {
        $suffix = $this->getArgument('suffix') ?: $this->getArgumentDescription('suffix')->getDefault();

        return substr($this->getArgument('subject'), 0, $this->getArgument('length')) . $suffix;
    }
}
