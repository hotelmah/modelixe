<?php

/* Licence et conditions d'utilisations---------------------------------------------------------------------------------

-English----------------------------------------------------------------------------------------------------------------
Copyright (C) 2001
AUTHOR: ANDRE thierry
ADDING:
- VILDAY Laurent.
- MOULRON Diogene.
- DELVILLE Romain.
- BOUCHERY Frederic.
- PERRICHOT Florian.
- RODIER Phillipe.
- HOUZE Sebastien.
- DECLEE Frederic.
- HORDEAUX Sebastien.
- LELARGE Guillaume.
- GAUTHIER Jeremy.
- CASANOVA Matthieu.
- KELLER Christophe.
- MARK HUMPHREYS Aidan.
- KELLUM Patrick.
- DE CORNUAUD Sebastien.
- PIEL Regis.
- LE LOARER Loec.

UPDATE October 2024 Version 2

This library is free software; you can redistribute it and/or modify it under the terms of the GNU Lesser General
Public License as published by the Free Software Foundation; either version 2.1 of the License, or (at your option)
any later version.

This library is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied
warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser General Public License for more
details.

You should have received a copy of the GNU Lesser General Public License along with this library; if not, write to :

Free Software Foundation,
Inc., 59 Temple Place,
Suite 330, Boston,
MA 02111-1307, Etats-Unis.
------------------------------------------------------------------------------------------------------------------------

-Francais---------------------------------------------------------------------------------------------------------------
ModeliXe est distribue sous licence LGPL, merci de laisser cette en-tete, gage et garantie de cette licence.
ModeliXe est un moteur de template destine a etre utilise par des applications ecrites en PHP.
ModeliXe peut etre utilise dans des scripts vendus des tiers aux titres de la licence LGPL. ModeliXe n'en reste
pas moins OpenSource et libre de droits en date du 23 Aout 2001.

Copyright (C) 2001
Auteur: ANDRE thierry
Ajouts:
- VILDAY Laurent.
- MOULRON Diogene.
- DELVILLE Romain.
- BOUCHERY Frederic.
- PERRICHOT Florian.
- RODIER Phillipe.
- HOUZE Sebastien.
- DECLEE Frederic.
- HORDEAUX Sebastien.
- LELARGE Guillaume.
- GAUTHIER Jeremy.
- CASANOVA Matthieu.
- KELLER Christophe.
- MARK HUMPHREYS Aidan.
- KELLUM Patrick.
- DE CORNUAUD S�bastien.
- PIEL Regis.
- LE LOARER Loec.

Cette biblioth�que est libre, vous pouvez la redistribuer et/ou la modifier selon les termes de la Licence Publique
G�n�rale GNU Limit�e publi�e par la Free Software Foundation version 2.1 et ult�rieure.

Cette biblioth�que est distribu�e car potentiellement utile, mais SANS AUCUNE GARANTIE, ni explicite ni implicite,
y compris les garanties de commercialisation ou d'adaptation dans un but sp�cifique. Reportez-vous � la Licence
Publique G�n�rale GNU Limit�e pour plus de d�tails.

Vous devez avoir re�u une copie de la Licence Publique G�n�rale GNU Limit�e en m�me temps que cette biblioth�que;
si ce n'est pas le cas, �crivez �:

Free Software Foundation,
Inc., 59 Temple Place,
Suite 330, Boston,
MA 02111-1307, Etats-Unis.

Pour tout renseignements mailez � modelixe@free.fr ou thierry.andre@freesbee.fr
------------------------------------------------------------------------------------------------------------------------ */

namespace ModeliXe;

/* ===================================================================================================================== */

// Including the configuration file and Error Manager
require_once('ModeliXe.config.php');
require_once('ErrorManager.php');

/* ===================================================================================================================== */

class ModeliXe extends ErrorManager
{
    private string $template = '';
    private string $absolutePath = '';
    private string $relativePath = '';
    private string $sessionParameter = '';
    private string $mXParameterFile = '';
    private string $mXTemplatePath = '';
    private string $mXCachePath = '';
    private string $mXUrlKey = '';

    private string $outputSystem = '/>';
    private string $flagSystem = 'classical';
    private string $adressSystem = 'relative';
    private string $mXVersion = '1.0';

    private int $mXCacheDelay = 0;
    private float $debut = 0;
    private int $fin = 0;
    private int $ExecutionTime = 0;

    // by default no cache
    private bool $ok_cache = false;

    private bool $mXcompress = false;
    private bool $mXsetting = false;
    private bool $mXmodRewrite = false;
    private bool $performanceTracer = false;
    private bool $mXoutput = false;

    private bool $mXsignature = false;
    private bool $isTemplateFile = true;

    private array $templateContent = array();
    private array $sheetBuilding = array();
    private array $deleted = array();
    private array $replacement = array();
    private array $loop = array();
    private array $IsALoop = array();
    private array $xPattern = array();
    private array $formField = array();
    private array $checker = array();
    private array $attribut = array();
    private array $attributKey = array();
    private array $htmlAtt = array();
    private array $select = array();
    private array $hidden = array();
    private array $image = array();
    private array $text = array();
    private array $father = array();
    private array $son = array();
    private array $plugInMethods = array();

    private array $flagArray = array(0 => 'hidden', 1 => 'select', 2 => 'image', 3 => 'text', 4 => 'checker', 5 => 'formField');
    private array $attributArray = array(0 => 'attribut');

    //MX Generator----------------------------------------------------------------------------------------------------

    //ModeliXe Constructor
    /* ===================================================================================================================== */
    public function __construct($template, $sessionParameter = '', $templateFileParameter = '', $cacheDelay = -1, $ok_cache = false)
    {
        $this -> ok_cache = $ok_cache;

        // $this -> ErrorManager();
        parent::__construct();

        $time = explode(' ', microtime());
        $this -> debut = $time[1] + $time[0];

        // Managing Default Settings
        // Definition of the compression system
        if (defined('MX_COMPRESS')) {
            $this -> setMxCompress(MX_COMPRESS);
        }

        // Activation du mode rewrite
        if (defined('MX_REWRITEURL')) {
            $this -> setMxModRewrite(MX_REWRITEURL);
        }

        // Signature activation
        if (defined('MX_SIGNATURE')) {
            $this -> setMxSignature(MX_SIGNATURE);
        }

        // Setting the template directory
        if (defined('MX_TEMPLATE_PATH')) {
            $this -> setMxTemplatePath(MX_TEMPLATE_PATH);
        }

        // Setting the configuration file
        if (defined('MX_DEFAULT_PARAMETER') && !$templateFileParameter) {
            $this -> setMxFileParameter(MX_DEFAULT_PARAMETER);
        } elseif ($templateFileParameter != '') {
            $this -> setMxFileParameter($templateFileParameter);
        }

        // Defining the markup type
        if (defined('MX_FLAGS_TYPE')) {
            $this -> setMxFlagsType(MX_FLAGS_TYPE);
        }

        // Setting the output markup type
        if (defined('MX_OUTPUT_TYPE')) {
            $this -> setMxOutputType(MX_OUTPUT_TYPE);
        }

        // Setting the cache directory
        if (defined('MX_CACHE_PATH')) {
            $this -> setMxCachePath(MX_CACHE_PATH);
        }

        if (defined('MX_CACHE_DELAY')) {
            $this -> setMxCacheDelay(MX_CACHE_DELAY);
        }

        if ($cacheDelay >= 0 && $cacheDelay != '') {
            $this -> setMxCacheDelay($cacheDelay);
        }

        // Enabling the performance tracker
        if (defined('MX_PERFORMANCE_TRACER') && MX_PERFORMANCE_TRACER == 'on') {
            $this -> performanceTracer = true;
        }

        // Managing session settings
        if ($sessionParameter) {
            $this -> sessionParameter = $sessionParameter;
        }

        // Instantiating the templates resource
        if (is_file($this -> mXTemplatePath . $template)) {
            $this -> template = $template;
        } elseif (isset($template)) {
            $this -> template = $template;
            $this -> isTemplateFile = false;
        } else {
            $this -> errorTracker(5, 'No template file defined.', 'ModeliXe', __FILE__, __LINE__);
        }

        // Assigning the original path
        if ($this -> errorChecker()) {
            $this -> absolutePath = substr(basename($this -> template), 0, strpos(basename($this -> template), '.'));
            $this -> relativePath = $this -> absolutePath;
        }
    }
    /* ===================================================================================================================== */

    //Setting ModeliXe -------------------------------------------------------------------------------------------

    // Method of instantiating the template
    public function setModeliXe($out = ''): void
    {
        if ($this -> mXsetting) {
            $this -> errorTracker(4, 'You can\'t re-use this method after instanciate ModeliXe once time.', 'setModeliXe', __FILE__, __LINE__);
        }

        if ($out) {
            $this -> mXoutput = true;
        }

        // Cache test and possible insertion
        if ($this -> mXCacheDelay > 0) {
            $this -> mXUrlKey = $this -> getMD5UrlKey();

            if ($this -> mxCheckCache()) {
                $this -> mxGetCache();
            }
        }

        // Class initialization
        $this -> getMxFile();

        if ($this -> errorChecker()) {
            $this -> mxParsing($this -> templateContent[$this -> absolutePath]);
        }

        $this -> mXsetting = true;
    }

    // Instantiation of compression
    private function setMxCompress($arg = ''): bool
    {
        if ($arg != 'on') {
            $this -> mXcompress = false;
        } else {
            $this -> mXcompress = true;
        }

        return $this -> mXcompress;
    }

    // Instantiating rewrite mode
    private function setMxModRewrite($arg = ''): bool
    {
        if ($arg != 'on') {
            $this -> mXmodRewrite = false;
        } else {
            $this -> mXmodRewrite = true;
        }

        return $this -> mXmodRewrite;
    }

    // Signature instantiation
    private function setMxSignature($arg = ''): bool
    {
        if ($arg != 'on') {
            $this -> mXsignature = false;
        } else {
            $this -> mXsignature = true;
        }

        return $this -> mXsignature;
    }

    // Instantiating the template path NOTE: This was commented out.
    private function setMxTemplatePath($arg = ''): string
    {
        if ($this -> mXsetting) {
            $this -> errorTracker(1, 'You can\'t use this method after instanciate ModeliXe with setModeliXe method, it will be without effects.', 'setMxTemplatePath', __FILE__, __LINE__);
        } else {
            if (!empty($arg)) {
                if ($arg[strlen($arg) - 1] != '/' && $arg) {
                    $arg .= '/';
                }
                if (! is_dir($arg)) {
                    $this -> errorTracker(5, 'The MX_TEMPLATE_PATH (<b>' . $arg . '</b>) is not a directory.', 'setMxTemplatePath', __FILE__, __LINE__);
                } else {
                    $this -> mXTemplatePath = $arg;
                }
            }
        }

        return $this -> mXTemplatePath;
    }

    // Instantiating the parameter file
    private function setMxFileParameter($arg = ''): string
    {
        if ($arg != '' && !is_file($arg)) {
            $this -> errorTracker(1, 'The parameter\'s file path (<b>' . $arg . '</b>) does not exist.', 'setMxFileParameter', __FILE__, __LINE__);
        } else {
            $this -> mXParameterFile = $arg;
        }

        return $this -> mXParameterFile;
    }

    // Instantiating the template markup
    private function setMxFlagsType($arg): string
    {
        if ($this -> mXsetting) {
            $this -> errorTracker(1, 'You can\'t use this method after instanciate ModeliXe with setModeliXe method, it will be without effects.', 'setMxFlagsType', __FILE__, __LINE__);
        } else {
            switch (strtolower($arg)) {
                case 'classical':
                    $this -> flagSystem = 'classical';
                    break;
                case 'pear':
                    $this -> flagSystem = 'classical';
                    break;
                case 'xml':
                    $this -> flagSystem = 'xml';
                    break;
                default:
                    $this -> errorTracker(2, 'This type of flag system (' . $arg . ') is unrecognized.', 'setMxFlagsType', __FILE__, __LINE__);
            }
        }

        return $this -> flagSystem;
    }

    // Instantiating the output markup
    private function setMxOutputType($arg): string
    {
        if ($this -> mXsetting) {
            $this -> errorTracker(1, 'You can\'t use this method after instanciate ModeliXe with setModeliXe method, it will be without effects.', 'setMxOutputType', __FILE__, __LINE__);
        } else {
            switch (strtolower($arg)) {
                case 'xhtml':
                    $this -> outputSystem = '/>';
                    break;
                case 'html':
                    $this -> outputSystem = '>';
                    break;
                default:
                    $this -> errorTracker(2, 'This type of output flag system (' . $arg . ') is unrecognized.', 'setMxOutputType', __FILE__, __LINE__);
            }
        }

        return $arg;
    }

    // Instantiating the cache directory, NOTE: This was Commented out
    private function setMxCachePath($arg)
    {
        if ($this -> mXsetting) {
            $this -> errorTracker(1, 'You can\'t use this method after instanciate ModeliXe with setModeliXe method, it will be without effects.', 'setMxCachePath', __FILE__, __LINE__);
        } else {
            if ($arg != '') {
                if ($arg[strlen($arg) - 1] != '/') {
                    $arg .= '/';
                }
            }

            // if (!is_dir($arg)) {
            //     mkdir($arg);
            // }

            if (!is_dir($arg) && $arg != '') {
                $this -> errorTracker(5, 'The MxCachePath (<b>' . $arg . '</b>) is not a directory.', 'setMxCachePath', __FILE__, __LINE__);
            } elseif ($arg) {
                $this -> mXCachePath = $arg;
            }
        }

        return $this -> mXCachePath;
    }

    // Instantiating the cache delay
    private function setMxCacheDelay($arg): int
    {
        if ($this -> mXsetting) {
            $this -> errorTracker(1, 'You can\'t use this method after instanciate ModeliXe with setModeliXe method, it will be without effects.', 'setMxCachePath', __FILE__, __LINE__);
        } elseif ($arg >= 0) {
            $this -> mXCacheDelay = (int)$arg;
        }

        return $this -> mXCacheDelay;
    }

    // Instantiating Session Parameters
    private function setMxSession($arg): void
    {
        $this -> sessionParameter = $arg;
    }

    // Setting tools ---------------------------------------------------------------------------------------------------

    // Search for template files
    private function getMxFile($source = '')
    {
        if (!$source) {
            $source = $this -> mXTemplatePath . $this -> template;
        }

        if (!$read = fopen($source, 'r')) {
            $this -> errorTracker(3, 'Can\'t open this template file (<b>' . $source . '</b>) in read, see for change the read modalities.', 'getMxFile', __FILE__, __LINE__);
        } elseif (!$result = fread($read, filesize($source))) {
            $this -> errorTracker(3, 'Can\'t read the template file (<b>' . $source . '</b>), see for file format and integrity.', 'getMxFile', __FILE__, __LINE__);
            fclose($read);
        }

        if (empty($result)) {
            $result = '[no parsing, template file not found or invalid]';
        }

        if ($this -> mXsignature && $source != $this -> mXTemplatePath . $this -> template) {
            $result = "\n<!--[ModeliXe " . $this -> mXVersion . ']-- [StartOf' . 'dyn' . 'Inclusion : ' . $source . "] -->\n\n" . $result . "\n\n<!--[ModeliXe " . $this -> mXVersion . ']-- [EndOf' . 'dyn' . 'Inclusion : ' . $source . "] -->\n";
        }

        // Assigning the original path and the template content
        if ($source == $this -> mXTemplatePath . $this -> template) {
            $this -> templateContent[$this -> absolutePath] = $result;
        } else {
            return $result;
        }
    }

    // Reading the configuration file and parsing it
    private function getParameterParsing($template): string
    {
        $Line = '';
        $signal = '';

        if (!$read = fopen($this -> mXParameterFile, 'r')) {
            $this -> errorTracker(4, 'The mXParameterFile (<b>' . $this -> mXParameterFile . '</b>) can\'t be open, the first parsing can\'t be do.', 'getParameterParsing', __FILE__, __LINE__);
        }

        for ($multi = false; !feof($read) && $this -> errorChecker(); $Line = trim(fgets($read, 1200))) {
            if (strlen($Line)) {
                if ($Line[0] == '#' && $Line[1] != '#') {
                    // State change for parameters
                    switch (strtolower($Line)) {
                        case '#flag':
                            $signal = 'flag';
                            break;
                        case '#attribut':
                            $signal = 'attribut';
                            break;
                        default:
                            $this -> errorTracker(3, '<b>' . $Line . ' </b> is not a valid section parameter type', 'getParameterParsing', __FILE__, __LINE__);
                            break;
                    }
                } else {
                    if ($Line[0] == '#') {
                        $Line = substr($Line, 1);
                    }

                    if (!$multi) {
                        $keyC = chop(substr($Line, 0, strpos($Line, '=') - 1));

                        // Multiline management, start of a value on several lines
                        if (($content = ltrim(substr($Line, strpos($Line, '=') + 1))) && substr($content, 0, 3) == '"""') {
                            $multi = true;
                            $content = substr($content, 3);
                        }
                    } else {
                        // Multiline management, end of a value on several lines
                        if (substr($Line, strlen($Line) - 3) == '"""') {
                            $multi = false;
                            $content = ' ' . substr($Line, 0, strpos($Line, '"""'));
                        } else {
                            $content = ' ' . $Line;
                        }
                    }

                    // If we are not in a multi-line value (full value)
                    if (!$multi) {
                        switch ($this -> flagSystem) {
                            case 'xml':
                                $flagRegexp = '<mx:preformating id="' . $keyC . '"/>';
                                $attRegexp = 'mXpreformating="' . $keyC . '"';
                                break;
                            case 'classical':
                                $flagRegexp = '{preformating id="' . $keyC . '"}';
                                $attRegexp = '{preformatingAtt id="' . $keyC . '"}';
                                break;
                        }

                        if ($signal == 'flag') {
                            $template = str_replace($flagRegexp, $content, $template);
                        }

                        if ($signal == 'attribut') {
                            $template = str_replace($attRegexp, $content, $template);
                        }
                    }
                } // end first else
            }
        } // end for

        if ($read) {
            fclose($read);
        }

        return $template;
    }

    // MX Builder-------------------------------------------------------------------------------------------------------
    /* ===================================================================================================================== */
    public function mxBloc($index, $mod, $value = ''): void
    {
        $mod = substr(strtolower($mod), 0, 4);

        if ($this -> adressSystem == 'relative') {
            if ($index) {
                $index = $this -> relativePath . '.' . $index;
            } else {
                $index = $this -> relativePath;
            }
        } else {
            $index = $this -> absolutePath . '.' . $index;
        }

        $fat = $this -> father[$index];
        if (!$fat && $index != $this -> absolutePath) {
            $this -> errorTracker(2, 'The current path (<b>' . $index . '</b>) does not exist, or was deleting, him or his father, before.', 'mxBloc', __FILE__, __LINE__);
        }

        switch ($mod) {
            // Looping
            case 'loop':
                $this -> mxLoopBuilder($index);
                break;

            // Deleting
            case 'dele':
                $this -> sheetBuilding[$index] = '   ';
                $this -> loop[$index] = '';
                $this -> deleted[$index] = true;
                break;

            // Concatenating
            case 'appe':
                if (is_file($value)) {
                    $value = $this -> getMxFile($value);
                }

                $this -> templateContent[$index] .= $value;
                $this -> mxParsing($value, $index, $this -> father[$index]);
                break;

            // Replacing
            case 'repl':
                if (is_file($value)) {
                    $value = $this -> getMxFile($value);
                }

                $this -> sheetBuilding[$index] = $value;
                $this -> replacement[$index] = true;
                break;

            // Modify template references of this bloc
            case 'modi':
                $this -> sheetBuilding[$index] = '';
                $this -> loop[$index] = '';

                if (is_file($value)) {
                    $value = $this -> getMxFile($value);
                }

                $this -> templateContent[$index] = $value;
                $this -> mxParsing($value, $index, $this -> father[$index]);
                break;

            // Reset, destroy all references
            case 'rese':
                $this -> sheetBuilding[$index] = '';
                $this -> loop[$index] = '';
                $this -> templateContent[$index] = '';
                $ind = substr($index, strrpos($index, '.') + 1);
                $this -> templateContent[$fat] = str_replace('<mx:inclusion id="' . $ind . '"/>', '', $this -> templateContent[$fat]);
                $this -> deleted[$index] = true;
                $this -> xPattern['inclusion'][$index] = '';
                break;
        }
    }

    public function mxFormField($index, $type, $name, $value, $attribut = ''): void
    {
        if ($this -> adressSystem == 'relative') {
            $index = $this -> relativePath . '.' . $index;
        }

        $end = $this -> outputSystem;

        switch (strtolower($type)) {
            case 'text':
                $replace = '<input type="text" name="' . $name . '" value="' . $value . '" ' . $attribut . ' ' . $this -> htmlAtt[$index] . $end;
                break;
            case 'password':
                $replace = '<input type="password" name="' . $name . '" value="' . $value . '" ' . $attribut . ' ' . $this -> htmlAtt[$index] . $end;
                break;
            case 'textarea':
                $replace = '<textarea name="' . $name . '" ' . $attribut . ' ' . $this -> htmlAtt[$index] . ' >' . $value . '</textarea>';
                break;
            case 'file':
                $replace = '<input type="file" name="' . $name . '" value="' . $value . '" ' . $attribut . ' ' . $this -> htmlAtt[$index] . $end;
                break;
            case 'submit':
                $replace = '<input type="submit" name="' . $name . '" value="' . $value . '" ' . $attribut . ' ' . $this -> htmlAtt[$index] . $end;
                break;
            case 'reset':
                $replace = '<input type="reset" name="' . $name . '" value="' . $value . '" ' . $attribut . ' ' . $this -> htmlAtt[$index] . $end;
                break;
            case 'button':
                $replace = '<input type="button" name="' . $name . '" value="' . $value . '" ' . $attribut . ' ' . $this -> htmlAtt[$index] . $end;
                break;
            case 'image':
                $replace = '<input type="image" name="' . $name . '" ' . $attribut . ' ' . $this -> htmlAtt[$index] . $end;
                break;
            default:
                $this -> errorTracker(3, 'This type (<b>' . $type . '</b>) is unknown for this formField manager.', 'mxFormField', __FILE__, __LINE__);
        }

        $this -> formField[$index] = $replace;
    }


    public function mxImage($index, $imag, $title = '', $attribut = '', $size = false): void
    {
        if ($this -> adressSystem == 'relative') {
            $index = $this -> relativePath . '.' . $index;
        }

        $end = $this -> outputSystem;

        if (($ima = '<img src="' . $imag . '"') && ! $size) {
            $size = getimagesize($imag);
            $ima .= ' ' . $size[3];
        }

        if ($title == 'no') {
            $ima .= ' ';
        } elseif ($title) {
            $ima .= ' alt="' . $title . '" ';
        } else {
            $ima .= ' alt="no title - source : ' . basename($imag) . '" ';
        }

        if ($attribut) {
            $ima .= $attribut;
        }

        $ima .= ' ' . $this -> htmlAtt[$index] . $end;

        $this -> image[$index] = $ima;
    }


    public function mxText($index, $att): void
    {
        if ($this -> adressSystem == 'relative') {
            $index = $this -> relativePath . '.' . $index;
        }

        $this -> text[$index] = $att;
    }


    public function mxAttribut($index, $att): void
    {
        if ($this -> adressSystem == 'relative') {
            $index = $this -> relativePath . '.' . $index;
        }

        $Marker = '';

        // Managing mailto and javascripts in hrefs
        if (strtolower($this -> attributKey[$index]) == 'mailto' || strtolower($this -> attributKey[$index]) == 'javascript') {
            $Marker = ' href="';
        }

        // Multi-attribute management
        if (!((isset($this -> attribut[$index])) ? chop($this -> attribut[$index]) : false)) {
            if ($Marker) {
                $this -> attribut[$index] = $Marker . $this -> attributKey[$index] . ':' . $att . '"';
            } else {
                $this -> attribut[$index] = $this -> attributKey[$index] . '="' . $att . '"';
            }
        } else {
            if (empty($this -> attribut[$this -> attribut[$index]])) {
                if ($Marker) {
                    $this -> attribut[$this -> attribut[$index]] = ' ' . $Marker . $this -> attributKey[$index] . ':' . $att . '"';
                } else {
                    $this -> attribut[$this -> attribut[$index]] = ' ' . $this -> attributKey[$index] . '="' . $att . '"';
                }
            } else {
                if ($Marker) {
                    $this -> attribut[$this -> attribut[$index]] .= $Marker . $this -> attributKey[$index] . ':' . $att . '"';
                } else {
                    $this -> attribut[$this -> attribut[$index]] .= ' ' . $this -> attributKey[$index] . '="' . $att . '"';
                }
            }
        }
    }

    public function mxSelect($index, $id, $name, $value, $arrayArg, $defaut = '', $multiple = '', $javascript = ''): void
    {
        if ($this -> adressSystem == 'relative') {
            $index = $this -> relativePath . '.' . $index;
        }

        $sel = '';

        if ($multiple && $multiple > 0) {
            $attribut = 'size="' . $multiple . '" multiple="multiple" ';
            $post = '[]';
        } else {
            $attribut = '';
            $post = '';
        }

        // Build of a select tag from an array
        if (is_array($arrayArg)) {
            $sel = "\n" . '<select id="' . $id . '" name="' . $name . '"';

            if ($attribut) {
                $sel .= $attribut . ' ';
            }

            if ($javascript) {
                $sel .= $javascript;
            }

            if (!empty($this -> htmlAtt[$index])) {
                $sel .= ' ' . $this -> htmlAtt[$index] . ">\n";
            } else {
                $sel .= ">\n";
            }

            if (isset($defaut) && $defaut) {
                $sel .= "\t" . '<option value="#">' . $defaut . '</option>' . "\n";
            }

            $debut = 0;
            $fin = count($arrayArg);

            reset($arrayArg);

            foreach ($arrayArg as $Key => $Avalue) {
                $test = 0;

                // Build of multiple choice select from a value array
                if (is_array($value) && $multiple > 0) {
                    reset($value);

                    foreach ($value as $Vcle => $Vvalue) {
                        if ($Key == $Vvalue && $Vvalue != '') {
                            $sel .= "\t" . '<option value="' . $Key . '" selected="selected">' . $Avalue . '</option>' . "\n";
                            $test = 1;
                            break;
                        }
                    }

                    if ($test == 0) {
                        $sel .= "\t" . '<option value="' . $Key . '">' . $Avalue . '</option>' . "\n";
                    }
                } else {
                    // Simple select
                    if ($value != '' && $Key == $value) {
                        $sel .= "\t" . '<option value="' . $Key . '" selected="selected">' . $Avalue . '</option>' . "\n";
                    } else {
                            $sel .= "\t" . '<option value="' . $Key . '">' . $Avalue . '</option>' . "\n";
                    }
                }
            }
        } else {
            $this -> errorTracker(2, 'This function need an Array in fourth argument to build the select <b>' . $index . '</b>.', 'mxSelect', __FILE__, __LINE__);
            $sel = '<select name="' . $name . '">' . "\n\t" . '<option value="null">No record found</option>' . "\n";
        }

        $sel .= '</select>';

        $this -> select[$index] = $sel;
    }


    public function mxUrl($index, $urlArg, $param = '', $noSid = false, $attribut = ''): void
    {
        if ($this -> adressSystem == 'relative') {
            $index = $this -> relativePath . '.' . $index;
        }

        $ok = false;

        // Added session parameters in case of cache or not
        if ($this -> sessionParameter && !$noSid) {
            if ($this -> mXCacheDelay > 0) {
                $urlArg .= '?<mx:session />';
            } else {
                $urlArg .= '?' . $this -> sessionParameter;
            }

            $ok = true;
        }

        // Building the link
        if (is_string($param) && $param) {
            $param = explode('&', $param);
            for ($i = 0; $i < count($param) && $param[$i]; $i++) {
                $Key = explode('=', $param[$i]);
                if (!$this -> mXmodRewrite) {
                    $urlArg .= ($i == 0 && !$ok) ? '?' . urlencode($Key[0]) . '=' . urlencode($Key[1]) : '&' . urlencode($Key[0]) . '=' . urlencode($Key[1]);
                } else {
                    $urlArg .= '/' . urlencode($Key[0]) . '/' . urlencode($Key[1]);
                }
            }
        } elseif (is_array($param)) {
            reset($param);
            if ($this->mXmodRewrite) {
                foreach ($param as $Key => $valeur) {
                    $urlArg .= '/' . urlencode($Key) . '/' . urlencode($valeur);
                }
            } else {
                foreach ($param as $Key => $valeur) {
                    if (!$ok) {
                        $urlArg .= '?' . urlencode($Key) . '=' . urlencode($valeur);
                        $ok = true;
                    } else {
                        $urlArg .= '&' . urlencode($Key) . '=' . urlencode($valeur);
                    }
                }
            }
        } elseif ($param) {
            $this -> errorTracker(3, 'The third argument must be a queryString or an array.', 'mxUrl', __FILE__, __LINE__);
        }

        // Adding possible additional attributes dynamically
        $lien = ($attribut) ? ' href="' . $urlArg . '" ' . $attribut : ' href="' . $urlArg . '"';

        // Multi-attribute management
        if (!((isset($this -> attribut[$index])) ? chop($this -> attribut[$index]) : false)) {
            $this -> attribut[$index] = ' href="' . $urlArg . '"';
        } else {
            if (empty($this -> attribut[$this -> attribut[$index]])) {
                $this -> attribut[$this -> attribut[$index]] = ' href="' . $urlArg . '"';
            } else {
                $this -> attribut[$this -> attribut[$index]] .= ' href="' . $urlArg . '"';
            }
        }
    }


    public function mxHidden($index, $param): void
    {
        if ($this -> adressSystem == 'relative') {
            $index = $this -> relativePath . '.' . $index;
        }

        $end = $this -> outputSystem;
        $hidden = '';

        if ($this -> mXCacheDelay == 0 && $this -> sessionParameter) {
            $param .= '&' . $this -> sessionParameter;
        }

        if (is_string($param)) {
            $param = explode('&', $param);
        } else {
            $this -> errorTracker(3, 'The second argument must be a queryString.', 'mxHidden', __FILE__, __LINE__);
        }

        if (!empty($param)) {
            for ($i = 0; $i < count($param); $i++) {
                if ($param[$i]) {
                    $Key = explode('=', $param[$i]);
                    $hidden .= '<input type="hidden" name="' . $Key[0] . '" value="' . $Key[1] . '" ' . $end . "\n";
                }
            }
        }

        if ($this -> mXCacheDelay > 0) {
            $hidden .= '<mx:hiddenSession />';
        }

        $this -> hidden[$index] = $hidden;
    }


    public function mxCheckerField($index, $type, $name, $value, $checked = false, $attribut = ''): void
    {
        if ($this -> adressSystem == 'relative') {
            $index = $this -> relativePath . '.' . $index;
        }

        $end = $this -> outputSystem;

        $type = strtolower($type);

        if ($type != "checkbox" && $type != "radio") {
            $this -> errorTracker(2, 'This type (<b>' . $type . '</b>) is unknown for this CheckerField manager.', 'mxCheckerField', __FILE__, __LINE__);
        }

        $replace = '<input type="' . $type . '" name="' . $name . '" value="' . $value . '"';

        if ($checked) {
            $replace .= ' checked="checked"';
        }

        if ($attribut) {
            $replace .= ' ' . $attribut;
        }

        $replace .= ' ' . $this -> htmlAtt[$index] . $end;

        $this -> checker[$index] = $replace;
    }


    //MX Extender----------------------------------------------------------------------------------------
    /* ===================================================================================================================== */
    public function addMxPlugIn($name, $type, $fonction)
    {
        if (!$name) {
            $this -> errorTracker(2, 'You must give a name to identify the plug-in.', 'AddMxPlugIn', __FILE__, __LINE__);
        }

        if (! $type) {
            $this -> errorTracker(2, 'The type of the plug-in is necessary to instanciate it.', 'AddMxPlugIn', __FILE__, __LINE__);
        }

        if (! $fonction || ! function_exists($fonction)) {
            $this -> errorTracker(3, 'The method addMxPlugin need the name of a function in third argument.', 'AddMxPlugIn', __FILE__, __LINE__);
        }

        if ($this -> errorChecker()) {
            switch ($type) {
                case 'flag':
                    for ($i = 0; $i < count($this -> flagArray); $i++) {
                        if ($name == $this -> flagArray[$i]) {
                            $this -> errorTracker(2, 'This plug-in (<b>' . $name . '</b>) has got the same pattern as the native pattern of a ModeliXe flag.', 'AddMxPlugIn', __FILE__, __LINE__);
                        }
                    }
                    $this -> flagArray[count($this -> flagArray)] = $name;
                    break;
                case 'attribut':
                    for ($i = 0; $i < count($this -> attributArray); $i++) {
                        if ($name == $this -> attributArray[$i]) {
                            $this -> errorTracker(2, 'This plug-in (<b>' . $name . '</b>) has got the same pattern as the native pattern of a ModeliXe attribut.', 'AddMxPlugIn', __FILE__, __LINE__);
                        }
                    }
                    $this -> attributArray[count($this -> attributArray)] = $name;
                    break;
                default:
                    $this -> errorTracker(2, 'This type of plug-in (<b>' . $type . '</b>) is unrecognized.', 'AddMxPlugIn', __FILE__, __LINE__);
            }
        }

        $this -> $name = array();
        $this -> plugInMethods[$name] = $fonction;
    }

    public function setMxPlugIn($name, $index, $arguments)
    {
        if ($this -> adressSystem == 'relative') {
            $index = $this -> relativePath . '.' . $index;
        }

        if (isset($arguments) && ! is_array($arguments)) {
            $this -> errorTracker(2, 'You must give an array of arguments for the plug-in function.', 'SetMxPlugIn', __FILE__, __LINE__);
        } else {
            $tab = &$this -> $name;
            $tab[$index] = call_user_func($this -> plugInMethods[$name], $arguments);
        }
    }
    /* ===================================================================================================================== */

    // MX tools ------------------------------------------------------------------------------------------------------------
    /* ===================================================================================================================== */

    // Check for the existence of a block
    public function ismxBloc($index)
    {
        if ($this -> adressSystem == 'relative') {
            $index = $this -> relativePath . '.' . $index;
        }

        $fat = $this -> father[$index];

        if (! $fat && $index != $this -> absolutePath) {
            return false;
        } else {
            return true;
        }
    }

    // Check for the existence of a tag
    public function isMxFlag($index, $type)
    {
        if ($this -> adressSystem == 'relative') {
            $index = $this -> relativePath . '.' . $index;
        }

        $tab = $this -> $type;

        if (!isset($tab[$index])) {
            return false;
        } else {
            return $tab[$index];
        }
    }

    // Check for the existence of an attribute
    public function isMxAttribut($index)
    {
        if ($this -> adressSystem == 'relative') {
            $index = $this -> relativePath . '.' . $index;
        }

        if (!isset($this -> attributKey[$index])) {
            return false;
        } else {
            if (preg_match('/;/', $this -> attribut[$index])) {
                return $this -> attribut[$this -> attribut[$index]];
            } else {
                return $this -> attribut[$index];
            }
        }
    }

    // Returns the entire contents of a block
    public function getmxBloc($index)
    {
        if ($this -> adressSystem == 'relative') {
            $index = $this -> relativePath . '.' . $index;
        }

        if ($this -> sheetBuilding[$index]) {
            return $this -> sheetBuilding[$index];
        } else {
            return $this -> templateContent[$index];
        }
    }

    // Building a queryString
    public function getQueryString($keyString, $null = 1)
    {
        $queryString = array();

        if (is_array($keyString)) {
            reset($keyString);

            foreach ($keyString as $Akey => $value) {
                if (is_array($value)) {
                    foreach ($value as $k => $v) {
                        array_push($queryString, urlencode($Akey . '[' . $k . ']') . '=' . urlencode($v));
                    }
                } elseif ($null || strlen($value)) {
                    array_push($queryString, urlencode($Akey) . '=' . urlencode($value));
                }
            }
            return implode('&', $queryString);
        } else {
            $this -> errorTracker(3, 'The argument for this function must be an associative array.', 'GetQueryString', __FILE__, __LINE__);
        }
    }
    /* ===================================================================================================================== */

    // Simplified addressing
    public function withMxPath($path = '', $origine = '')
    {
        if (! $origine) {
            $origine = $this -> adressSystem;
        } else {
            switch ($origine) {
                case 'relative':
                    break;
                case 'absolute':
                    break;
                default:
                    $origine = 'relative';
                    break;
            }
        }

        // If we do not specify a path we return to the original path
        if (empty($path)) {
            $this -> relativePath = $this -> absolutePath;

            if ($origine == 'absolute') {
                $this -> adressSystem = 'absolute';
            } elseif ($origine == 'relative') {
                $this -> adressSystem = 'relative';
            }
        }

        // Otherwise, in absolute terms we are located in this path, in relative terms we are located in relation to the relative path
        if ($path) {
            if ($origine == 'relative') {
                // We go down the hierarchy to the path mentioned�
                if (($test = explode('../', $path)) && count($test) > 1) {
                    $path = substr($path, strrpos($path, '/') + 1);
                    $this -> relativePath = substr($this -> relativePath, 0, strlen($this -> relativePath) - strlen(strstr($this -> relativePath, $path)) - 1);
                    if (! $this -> relativePath) {
                        $this -> errorTracker(3, 'This path (<b>' . $path . '</b>) does not exist, ModeliXe can\'t build relativePath.', 'withMxPath', __FILE__, __LINE__);
                    }
                }

                $this -> relativePath .= '.' . $path;

                $this -> adressSystem = 'relative';
            } elseif ($origine == 'absolute') {
                $this -> relativePath = $path;
                $this -> adressSystem = 'absolute';
            }
        }
    }

    // Informations de licence
    /* ===================================================================================================================== */
    public function aboutModeliXe($out = '')
    {
        $texte = "\nLicence et conditions d'utilisations-----------------------------------------------------------------------------\n";
        $texte .= 'ModeliXe ' . $this -> mXVersion . "\nModeliXe est distribu� sous licence LGPL, merci de laisser cette en-t�te, gage et garantie de cette licence.\n";
        $texte .= "ModeliXe est un moteur de template destin� � �tre utilis� par des applications �crites en PHP.\n";
        $texte .= " \n";
        $texte .= "Copyright(c) 26 Juin 2001 - ANDRE Thierry (aka Th�o)\n";
        $texte .= " \n";
        $texte .= "Pour tout renseignements mailez � modelixe@free.fr ou thierry.andre@freesbee.fr\n";
        $texte .= "------------------------------------------------------------------------------------------------------------------\n";

        if ($out) {
            return $texte;
        } else {
            print('<pre>' . $texte . '</pre>');
        }
    }

    // Version number
    public function getMxVersion()
    {
        return $this -> mXVersion;
    }

    // Refreshment
    public function mxRefresh($query = '')
    {
        $this -> mxClearCache('this', $query);
    }

    public function mxRefreshAll()
    {
        $this -> mxClearCache();
    }
    /* ===================================================================================================================== */

    // Performance measurement
    private function getExecutionTime()
    {
        $time = explode(' ', microtime());
        $fin = $time[1] + $time[0];
        $this -> ExecutionTime = intval(10000 * ((double)$fin - (double)$this -> debut)) / 10000;

        return($this -> ExecutionTime);
    }


    //MX Parsing Engine------------------------------------------------------------------------------------------------------------
    /* ===================================================================================================================== */
    private function mxParsing($doc = '', $path = '', $father = ''): void
    {
        $countPath = array();

        // Initialisation
        if (! $path) {
            $original = true;
            $path = $this -> absolutePath;
        } else {
            $original = false;
        }

        $this -> father[$path] = $father;
        $this -> IsALoop[$path] = false;

        // Block tag parsing, sub-block extraction
        $ok = true;

        switch ($this -> flagSystem) {
            case 'xml':
                $blocRegexp = '/<mx:bloc(?:[ ]+ref="([^"]+)")?[ ]+id="([^"]+)"[ ]*>/S';
                break;
            case 'classical':
                $blocRegexp = '/{start(?:[ ]+ref="([^"]+)")?[ ]+id="([^"]+)"[ ]*}/S';
                break;
        }

        if (preg_match_all($blocRegexp, $doc, $inclusion)) {
            for ($i = 0; $ok; $i++) {
                // Extraction of the different information extracted by the regex
                $id = $inclusion[2][0];
                $ref = $inclusion[1][0];
                $pattern = $inclusion[0][0];

                // Calculation of the limits of the processed block
                switch ($this -> flagSystem) {
                    case 'xml':
                        $regexp = '</mx:bloc id="' . $id . '">';
                        break;
                    case 'classical':
                        $regexp = '{end id="' . $id . '"}';
                        break;
                }

                $startOfIntrons = strpos($doc, $pattern) + strlen($pattern);
                $endOfIntrons = strpos($doc, $regexp);
                $length = $endOfIntrons - $startOfIntrons;

                if (!$endOfIntrons) {
                    $this -> errorTracker(4, 'The end of the "<b>' . $id . '</b>" bloc is not found, this bloc can\'t be generate. Verify that the end of bloc\'s flag exists and has a good form, like this pattern <b>' . htmlentities($regexp) . '</b>.', 'mxParsing', __FILE__, __LINE__);
                }

                // We test if the current block has a reference to another template
                if (!$ref) {
                    $this -> templateContent[$path . '.' . $id] = substr($doc, $startOfIntrons, $length);
                } else {
                    if ($this -> mXTemplatePath) {
                         $ref = $this -> mXTemplatePath . $ref;
                    }

                    $this -> templateContent[$path . '.' . $id] = $this -> getMxFile($ref);
                }

                // Creation of the pattern of the treated block
                $this -> xPattern['inclusion'][$path . '.' . $id] = '<mx:inclusion id="' . $id . '"/>';
                $this -> deleted[$path . '.' . $id] = false;
                $this -> replacement[$path . '.' . $id] = false;

                // Extracting the contents of the block to reconstruct the current block
                $doc = substr($doc, 0, $startOfIntrons - strlen($pattern)) . '<mx:inclusion id="' . $id . '"/>' . substr($doc, $endOfIntrons + strlen($regexp));
                $this -> templateContent[$path] = $doc;

                // Building the reference to this block for recursion
                $countPath[$i] = $path . '.' . $id;

                // Increment the number of threads for the current block
                if (!empty($this -> son[$path][0])) {
                     $compt = $this -> son[$path][0];
                } else {
                    $compt = 0;
                    $this -> son[$path][0] = 0;
                }

                // Building the reference to the child of the parsed block for the current block
                $this -> son[$path][++$compt] = $path . '.' . $id;
                $this -> son[$path][0] ++;

                // End of loop test
                $ok = preg_match_all($blocRegexp, $doc, $inclusion);
            }
        }

        // Parsing ModeliXe tags
        reset($this -> flagArray);

        foreach ($this->flagArray as $Akey => $value) {
            switch ($this -> flagSystem) {
                case 'xml':
                    $regexp = '/<mx:' . $value . '(?:[ ]+(?:ref|info)="(?:[^"]+)")?[ ]+id="([^"]+)"(([^>])*(?=\/>))\/>/S';
                    break;
                case 'classical':
                    $regexp = '/{' . $value . '(?:[ ]+(?:ref|info)="(?:[^"]+)")?[ ]+id="([^"]+)"[ ]*(?i:htmlAtt\[([^\]]*)\])?}/S';
                    break;
            }

            if (preg_match_all($regexp, $doc, $flag)) {
                for ($i = 0; $i < 200; $i++) {
                    if (empty($flag[0][$i])) {
                        break;
                    }

                    // Construction of the pattern and default values ​​of these tags
                    $this -> xPattern[$value][$path . '.' . $flag[1][$i]] = $flag[0][$i];

                    // Modification Guillaume Lelarge PHP3 compatibility
                    /*
                    <PHP3>
                        $ref = $this -> $value;
                        $ref[$path.'.'.$flag[1][$i]] = '   ';
                        $this -> $value = $ref;
                        $this -> htmlAtt[$path.'.'.$flag[1][$i]] = $flag[2][$i];
                    </PHP3>
                    */

                    $ref = &$this -> $value;
                    $ref[$path . '.' . $flag[1][$i]] = '   ';
                    $this -> htmlAtt[$path . '.' . $flag[1][$i]] = $flag[2][$i];
                }
            }
        }

        // Parsing ModeliXe attributes
        switch ($this -> flagSystem) {
            case 'xml':
                $regexp = '/mXattribut="([^"]{3,})"/Si';
                $separateur = ':';
                break;
            case 'classical':
                $regexp = '/{attribut ([^\}]+)}/Si';
                $separateur = '=';
                break;
        }

        if (preg_match_all($regexp, $doc, $flag)) {
            for ($i = 0; $k = 0; $i++) {
                if (empty($flag[0][$i])) {
                    break;
                }

                $pattern = $flag[0][$i];
                $motif = $flag[1][$i];
                $k = 0;

                // Managing multiple key-value pairs in attributes
                $tabVal = explode(';', $motif);
                for ($j = 0; $j < count($tabVal); $j++) {
                    $tabKey = explode($separateur, trim($tabVal[$j]));
                    $patternKey[++$k] = trim($tabKey[0]);
                    $indexValue[$k] = trim($tabKey[1]);

                    // Multi-attribute management
                    if (count($tabVal) > 1) {
                        $this -> attribut[$path . '.' . $indexValue[$k]] = $path . '.' . $indexValue[1] . ';';

                        if ($k == 1) {
                            $this -> xPattern['attribut'][$path . '.' . $indexValue[1]  . ';'] = $pattern;
                        }
                    } else {
                        $this -> attribut[$path . '.' . $indexValue[$k]] = '  ';
                        $this -> xPattern['attribut'][$path . '.' . $indexValue[$k]] = $pattern;
                    }

                    if ($patternKey[$k] != 'url') {
                        $this -> attributKey[$path . '.' . $indexValue[$k]] = $patternKey[$k];
                    }
                }
            }
        }

        for ($i = 0; $i < count($countPath); $i++) {
            $this -> mxParsing($this -> templateContent[$countPath[$i]], $countPath[$i], $path);
        }
    }
    /* ===================================================================================================================== */

    //MX Compression System ------------------------------------------------------------------------------------------------
    // Check if compression is possible and its type
    private function mxCheckCompress($file)
    {
        // global $HTTP_SERVER_VARS;

        if ((!$this -> mXcompress) || (!extension_loaded("zlib")) || (headers_sent()) || (strlen($file) / 1000 < 8)) {
            return false;
        }

        if (strstr($_SERVER['HTTP_ACCEPT_ENCODING'], 'x-gzip')) {
            return "x-gzip";
        }

        if (strstr($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) {
            return "gzip";
        }

        return false;
    }

    // Data compression for the browser
    private function mxSetCompress($filecontent)
    {
        if ($encoding = $this -> mxCheckCompress($filecontent)) {
            header('Content-Encoding: ' . $encoding);
            $gzfilecontent =  "\x1f\x8b\x08\x00\x00\x00\x00\x00";
            $size = strlen($filecontent);
            $crc32 = crc32($filecontent);
            $gzfilecontent .= gzcompress($filecontent, 9);
            $gzfilecontent .= substr($gzfilecontent, 0, strlen($gzfilecontent) - 4);
            $gzfilecontent .= pack('V', $crc32);
            $gzfilecontent .= pack('V', $size);

            return $gzfilecontent;
        } else {
             return $filecontent;
        }
    }


    //MX Cache system ------------------------------------------------------------------------------------------------------
    /* ===================================================================================================================== */
    // Returns a unique key for POST and GET arguments other than session parameters
    private function getMD5UrlKey($query = ''): string
    {
        global $HTTP_POST_VARS, $HTTP_GET_VARS;

        if (!$query) {
            $get = $HTTP_GET_VARS;
        } else {
            $get = $query;
        }

        if (! $query) {
            $post = $HTTP_POST_VARS;
        } else {
            $post = $query;
        }

        // Integrating the name of the calling php file
        $uri = getenv('REQUEST_URI');
        $uri = substr($uri, 0, strpos($uri, '?'));

        // Removing session parameters in GET
        $chaine = '';
        $this -> deleteSessionKey($chaine, $get);

        // Deleting session parameters in POST
        $this -> deleteSessionKey($chaine, $post);

        return (md5($chaine . $uri));
    }


    private function deleteSessionKey(&$chaine, $httpvar): void
    {
        $param = explode('&', $this -> sessionParameter);

        // Sorting tables to have them in the same order
        if (is_array($httpvar)) {
            asort($httpvar);
        } else {
            $tempVal = $httpvar;
            unset($httpvar);
            $httpvar = array();
            $httpvar[] = $tempVal;
        }

        if (is_array($param)) {
            asort($param);
        }

        // pr is a marker to avoid going through all session parameter values ​​if they have already all been deleted
        $pr = 0;

        // removing session parameters (get or post); cle means key
        for (reset($httpvar); $Key = key($httpvar); next($httpvar)) {
            $ok = false;
            $compt = count($param);
            for ($i = 0; $i < $compt && ($pr != $compt); $i++) {
                if (($cleU = explode('=', $param[$i])) && $cleU[0] == $Key) {
                    $ok = true;
                    $pr++;
                    break;
                }
            }
            if (!$ok) {
                $chaine .= $Key . '=' . $httpvar[$Key];
            }
        }
    }

    // Clearing the cache
    private function mxClearCache($file = '', $query = ''): void
    {
        if (!$open = opendir($this -> mXCachePath)) {
            $this -> errorTracker(3, 'Can\'t open cache directory (<b>' . $this -> mXCachePath . '</b>) to clear old files.', 'mxClearCache', __FILE__, __LINE__);
        } else {
            while ($Catalog = readdir($open)) {
                if ($Catalog != '.' && $Catalog != '..') {
                    if (!$file) {
                        if (($currentTime = filemtime($this -> mXCachePath . $Catalog)) && time() - $currentTime > $this -> mXCacheDelay) {
                            if (!unlink($this -> mXCachePath . $Catalog)) {
                                $this -> errorTracker(3, 'Can\'t unlink this file "<b>' . $Catalog . '</b>" in cache directory.', 'mxClearCache', __FILE__, __LINE__);
                            }
                        }
                    } else {
                        // Specifically delete the file from the current template
                        $ana = explode('~', $Catalog);
                        if ($ana[1] == $this -> template) {
                            // Handling queryString-specific deletions
                            if ($query && $this -> getMD5UrlKey($query) == $ana[0]) {
                                if (!unlink($this -> mXCachePath . $Catalog)) {
                                    $this -> errorTracker(3, 'Can\'t unlink this file "<b>' . $Catalog . '</b>" in cache directory.', 'mxClearCache', __FILE__, __LINE__);
                                }
                            } elseif (!unlink($this -> mXCachePath . $Catalog)) {
                                $this -> errorTracker(3, 'Can\'t unlink this file "<b>' . $Catalog . '</b>" in cache directory.', 'mxClearCache', __FILE__, __LINE__);
                            }
                        }
                    }
                }
            }

            closedir($open);
        }
    }

    // Cache initialization
    private function mxSetCache($filecontent): void
    {
        if ($this -> ok_cache) {
            $this -> mxClearCache('this');

            if (! $cache = fopen($this -> mXCachePath . $this -> mXUrlKey . '~' . $this -> template, 'w')) {
                $this -> errorTracker(4, 'Can\'t open in writing the cache file on "<b>' . $this -> mXCachePath . '/' . $this -> template . '</b>" path.', 'mxSetCache', __FILE__, __LINE__);
            }

            // Saving Content
            if ($this -> errorChecker()) {
                if (!$write = fputs($cache, $filecontent)) {
                    $this -> errorTracker(5, 'Can\'t wite the cache file on "<b>' . $this -> mXCachePath . $this -> mXUrlKey . '~' . $this -> template . '</b>" path.', 'mxSetCache', __FILE__, __LINE__);
                }

                fclose($cache);
            }
        }
    }

    // Returns the cache file
    private function mxGetCache(): string
    {
        $cache_file = $this -> mXCachePath . $this -> mXUrlKey . '~' . $this -> template;

        if (!$open = fopen($cache_file, 'r')) {
            $this -> errorTracker(5, 'Can\'t open the cache file on "<b>' . $cache_file . '</b>" path.', 'mxGetCache');
        }

        if (!$read = fread($open, filesize($cache_file))) {
            $this -> errorTracker(5, 'Can\'t read the cache file on "<b>' . $cache_file . '</b>" path.', 'mxGetCache', __FILE__, __LINE__);
        }

        fclose($open);

        // Parsing session parameters
        $read = $this -> mxSessionParameterParsing($read);

        // If we seek to measure the performance of ModeliXe
        if ($this -> performanceTracer) {
            $read = str_replace('<mx:performanceTracer />', $this -> getExecutionTime() . ' [cache]', $read);
        }

        // If there is compression support, send corresponding headers
        $this -> errorChecker();

        if ($this -> mXoutput) {
            return $read;
        } else {
            print($this -> mxSetCompress($read));
        }

        exit();
    }

    // Tests if the cache file exists and its expiry date
    private function mxCheckCache(): bool
    {
        $TempBool = false;

        $cache_file = $this -> mXCachePath . $this -> mXUrlKey . '~' . $this -> template;

        if (is_file($cache_file)) {
            if (($currentTime = filemtime($cache_file)) && (((time() - $currentTime) < $this -> mXCacheDelay && filemtime($this -> mXTemplatePath . $this -> template) < $currentTime))) {
                $TempBool = true;
            } else {
                $TempBool = false;
            }
        }
        return $TempBool;
    }

    // MX Template Fusion Engine --------------------------------------------------------------------------------------------------
    private function mxSessionParameterParsing(string $content): string
    {
        $hidden = '';

        $param = $this -> sessionParameter;

        if ($param) {
            $content = str_replace('<mx:session />', $param, $content);

            $param = explode('&', $this -> sessionParameter);

            for ($i = 0; $i < count($param); $i++) {
                if ($param[$i]) {
                    $Key = explode('=', $param[$i]);
                    $hidden .= '<input type="hidden" name="' . $Key[0] . '" value="' . $Key[1] . '" />' . "\n";
                }
            }

            $content = str_replace('<mx:hiddenSession />', $hidden, $content);
        }

        return $content;
    }

    // Replaces the contents of templates passed as arguments
    private function mxReplace(string $path): string
    {
        if (!empty($this -> sheetBuilding[$path])) {
            $Target = $this -> sheetBuilding[$path];
        } else {
            $Target = $this -> templateContent[$path];
        }

        // Replacing all ModeliXe attributes with the values ​​that were instantiated or their default values
        reset($this -> attributArray);

        foreach ($this->attributArray as $Key => $Fkey) {
            $Farray = &$this -> $Fkey;

            if (is_array($Farray)) {
                reset($Farray);

                foreach ($Farray as $Pkey => $value) {
                    if ($path == substr($Pkey, 0, strrpos($Pkey, '.'))) {
                        if (isset($this -> xPattern[$Fkey][$Pkey])) {
                            $pattern = $this -> xPattern[$Fkey][$Pkey];
                            $Target = str_replace($pattern, $value, $Target);
                            unset($Farray[$Pkey]);
                        }
                    }
                }
            }
        }

        // Replacing all ModeliXe tags with the values ​​that were instantiated or their default values
        reset($this -> flagArray);

        foreach ($this->flagArray as $Key => $Fkey) {
            $Farray = &$this -> $Fkey;

            if (is_array($Farray)) {
                reset($Farray);

                foreach ($Farray as $Pkey => $value) {
                    if ($path == substr($Pkey, 0, strrpos($Pkey, '.'))) {
                        if (isset($this -> xPattern[$Fkey][$Pkey])) {
                            $pattern = $this -> xPattern[$Fkey][$Pkey];

                            if (is_null($value)) {
                                $value = "";
                            }

                            $Target = str_replace($pattern, $value, $Target);
                            unset($Farray[$Pkey]);
                        }
                    }
                }
            }
        }

        return $Target;
    }

    // Builds blocks and associates child blocks with parent blocks
    private function mxBlocBuilder(string $path = ''): void
    {
        $ordre = array();
        $hierarchie = 1;

        if (!$path) {
            $path = $this -> absolutePath;
        }

        $chemin = $path;

        // Sort all path children from closest to furthest
        $base = count(explode('.', $path));
        $k = 1;
        $l = 1;
        $j = 1;

        while (true) {
            // If there is a son, we take him
            if (!empty($this -> son[$chemin][$j])) {
                $fils = $this -> son[$chemin][$j];
            } else {
                $fils = '';
            }

            // If it exists, we consider the last record found preceding this one.
            if (!empty($ordre[$hierarchie])) {
                $ancien = $ordre[$hierarchie][count($ordre[$hierarchie])];
            } else {
                $ancien = false;
            }

            if ($fils == $ancien) {
                break;
            }

            // If there are no more threads, we move on to the next node
            if (empty($fils)) {
                $j = 1;

                if (! empty($ordre[$k][$l])) {
                    $chemin = $ordre[$k][$l];
                    $l++;
                } else {
                    $l = 1;
                    $k++;

                    if (!empty($ordre[$k][$l])) {
                        $chemin = $ordre[$k][$l++];
                    } else {
                        break;
                    }
                }
            } else {
                $j++;

                // If the son has not been destroyed he is considered
                if ($this -> templateContent[$fils]) {
                    // hierarchy counts the number of blocks from the base block
                    $hierarchie = count(explode('.', $fils)) - $base;

                    if (empty($ordre[$hierarchie])) {
                        $ordre[$hierarchie] = array();
                    }

                    $ordre[$hierarchie][count($ordre[$hierarchie]) + 1] = $fils;
                }
            }
        }

        // Inserting the furthest wires into the nearest wires up to the path
        for ($i = count($ordre); $i > 0; $i--) {
            for ($j = 1; $j <= count($ordre[$i]); $j++) {
                $fils = $ordre[$i][$j];
                $pattern = $this -> xPattern['inclusion'][$fils];
                $pere = $this -> father[$ordre[$i][$j]];

                // Inserting the wire block into the meadow
                if ($pere == $path && $this -> IsALoop[$path]) {
                    if ($this -> IsALoop[$fils]) {
                        if ($this -> deleted[$fils]) {
                            $rem = ' ';
                            $this -> deleted[$fils] = false;
                        } else {
                            $rem = $this -> loop[$fils];
                        }

                        $this -> loop[$pere] = str_replace($pattern, $rem, $this -> loop[$pere]);
                        $this -> loop[$fils] = '';
                    } else {
                        if ($this -> deleted[$fils]) {
                            $rem = ' ';
                            $this -> deleted[$fils] = false;
                        } else {
                            $rem = $this -> mxReplace($fils);
                        }

                        $this -> loop[$pere] = str_replace($pattern, $rem, $this -> loop[$pere]);
                        $this -> sheetBuilding[$fils] = '';
                    }
                } else {
                    if (! empty($this -> sheetBuilding[$pere])) {
                        $source = $this -> sheetBuilding[$pere];
                    } else {
                        $source = $this -> templateContent[$pere];
                    }

                    if ($this -> IsALoop[$fils]) {
                        if ($this -> deleted[$fils]) {
                            $rem = ' ';
                            $this -> deleted[$fils] = false;
                        } else {
                            $rem = $this -> loop[$fils];
                        }

                        $this -> sheetBuilding[$pere] = str_replace($pattern, $rem, $source);
                        $this -> loop[$fils] = '';
                    } else {
                        if ($this -> deleted[$fils]) {
                            $rem = ' ';
                            $this -> deleted[$fils] = false;
                        } else {
                            $rem = $this -> mxReplace($fils);
                        }

                        $this -> sheetBuilding[$pere] = str_replace($pattern, $rem, $source);
                        $this -> sheetBuilding[$fils] = '';
                    }
                }
            }
        }
    }

    // Match the loops
    private function mxLoopBuilder(string $path = ''): void
    {
        if (!$path) {
            $path = $this -> absolutePath;
        }

        $father = $this -> father[$path];
        $pattern = $this -> xPattern['inclusion'][$path];

        // We skip the destroyed blocks
        if ($pattern) {
            $this -> IsALoop[$path] = true;

            if (empty($this -> loop[$path])) {
                $this -> loop[$path] = '';
            }

            // Block management temporarily replace
            if ($this -> replacement[$path]) {
                $this -> loop[$path] .= $this -> mxReplace($path);
                $this -> replacement[$path] = false;
                $this -> sheetBuilding[$path] = '';
            } else {
                // Managing classic loops
                $this -> sheetBuilding[$path] = '';
                if (empty($this -> loop[$path])) {
                    $this -> loop[$path] = '';
                }

                $this -> loop[$path] .= $this -> mxReplace($path);
            }
        }

        // Inserting children from $path into $path
        $this -> mxBlocBuilder($path);
    }

    // Mx Output -------------------------------------------------------------------------------------------------------------------

    // Output of the generated HTML file
    public function mxWrite(bool $SendBack = false)
    {
        if (!$this -> mXsetting) {
            $this -> errorTracker(5, 'You d\'ont intialize ModeliXe with setModeliXe method, there is no data to write.', 'mxWrite', __FILE__, __LINE__);
        }

        // Assembly of all the wire blocks
        $this -> mxBlocBuilder();

        if ($this -> mXsignature) {
            $Willful = '<!--[ModeliXe ' . $this -> mXVersion . '] -- ' . (($this -> isTemplateFile) ? '[TemplateFile : ' . $this -> mXTemplatePath . $this -> template . ']' : '[Template : ' . $this -> template . ']') . ' -- [date ' . date('j/m/Y H:i:s') . "]-->\n";
        } else {
            $Willful = '';
        }

        if ($this -> errorChecker()) {
            $filecontent = (($Willful) ? str_replace('<head>', '<head>' . "\n" . $Willful, $filecontent = $this -> mxReplace($this -> absolutePath)) : $filecontent = $this -> mxReplace($this -> absolutePath));

            // Replacing parameter tags
            if ($this -> mXParameterFile) {
                $filecontent = $this -> getParameterParsing($filecontent);
            }

            // Caching the generated page without session parameters
            if ($this -> mXCacheDelay > 0) {
                $this -> mxSetCache($filecontent);

                // Parsing session parameters
                $filecontent = $this -> mxSessionParameterParsing($filecontent);
            }

            // If we seek to measure the performance of ModeliXe
            if ($this -> performanceTracer) {
                $filecontent = str_replace('<mx:performanceTracer />', $this -> getExecutionTime(), $filecontent);
            }

            if ($this -> mXoutput || $SendBack) {
                return $filecontent;
            } else {
                print($this -> mxSetCompress($filecontent));
            }
        }
    }
}
