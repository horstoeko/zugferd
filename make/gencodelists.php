<?php

use horstoeko\stringmanagement\PathUtils;

require __DIR__ . "/../vendor/autoload.php";

define('DOWNLOADDEF_KEY_ENABLED', 'enabled');
define('DOWNLOADDEF_LIB_NAME', 'libname');
define('DOWNLOADDEF_LIB_TITLE', 'libtitle');
define('DOWNLOADDEF_KEY_URL', 'url');
define('DOWNLOADDEF_KEY_URL_HP', 'urlhp');
define('DOWNLOADDEF_KEY_TOFILE', 'filename');
define('DOWNLOADDEF_KEY_CLASSNAME', 'classname');
define('DOWNLOADDEF_KEY_CLASSNAMESPACE', 'classnamespace');
define('DOWNLOADDEF_KEY_TITLE', 'title');
define('DOWNLOADDEF_KEY_TITLE_LIST', 'titlelist');
define('DOWNLOADDEF_KEY_SHORTIDENTIFIERS', 'shortidentifiers');
define('DOWNLOADDEF_KEY_SHORTIDENTIFIERS_LENGTH', 'shortidentifierslength');
define('DOWNLOADDEF_KEY_ADDMETHODS', 'addmethods');
define('DOWNLOADDEF_KEY_ADDMETHODS_DEFAULT', false);
define('DOWNLOADDEF_KEY_DATA_CODEINDEX', 'codeindex');
define('DOWNLOADDEF_KEY_DATA_DESCINDEX', 'descindex');
define('DOWNLOADDEF_KEY_DATA_DESCLONGINDEX', 'desclongindex');
define('DOWNLOADDEF_KEY_DATA_SORTINDEX', 'sortindex');
define('DOWNLOADDEF_KEY_CLASSCREATORFUNC', 'classcreatorfunc');
define('DOWNLOADDEF_KEY_CLASSCREATORFUNC_DEFAULT', 'createCodeClassFromKositJson');
define('DOWNLOADDEF_KEY_CLASSCONSTANT_PREFIX', 'createconstantprefix');

/**
 * Script for downloading and generating code lists
 */

set_time_limit(0);

/**
 * Handle german umlauts
 *
 * @param  string $str
 * @return string
 */
function handleUmlauts(string $str): string
{
    $str = str_replace("Ö", "Oe", $str);
    $str = str_replace("Ä", "Ae", $str);
    $str = str_replace("Ü", "Ue", $str);
    $str = str_replace("ö", "oe", $str);
    $str = str_replace("ä", "ae", $str);
    $str = str_replace("ü", "ue", $str);
    return str_replace("Å", "A", $str);
}

/**
 * Handle comment string
 *
 * @param  string $str
 * @return string
 */
function strComment(string $str): string
{
    $str = handleUmlauts($str);
    $str = str_replace("\n", "", $str);
    $str = str_replace("\r", "", $str);
    $str = str_replace("\t", "", $str);
    $str = preg_replace('/\s+/', ' ', $str);
    return wordwrap($str);
}

/**
 * Create an identifier
 *
 * @param  string  $str
 * @param  boolean $shortIdentifier
 * @param  integer $partLength
 * @return string
 */
function strIdentifier(string $str, bool $shortIdentifier, int $partLength = 4): string
{
    $strNew = "";
    $str = handleUmlauts($str);
    $str = str_replace("\n", "", $str);
    $str = str_replace("\r", "", $str);
    $str = str_replace("\t", "", $str);
    $str = strtoupper($str);
    $str = preg_replace("/[^A-Za-z0-9\s]/", "", $str);

    $strArray = explode(" ", $str);
    if (count($strArray) == 1) {
        $strNew = $strArray[0];
    } else {
        foreach ($strArray as $item) {
            if ($strNew !== "") {
                $strNew .= "_";
            }

            if ($shortIdentifier) {
                $strNew .= substr($item, 0, $partLength);
            } else {
                $strNew .= $item;
            }
        }
    }

    $strNew = preg_replace('/__+/', '_', $strNew);
    $strNew = preg_replace('~\d~', '', $strNew, 5);
    return rtrim(ltrim($strNew, "_"), "_");
}

/**
 * Returns a clean string
 *
 * @param  string $str
 * @return string
 */
function strDesc(string $str): string
{
    $str = handleUmlauts($str);
    $str = str_replace("'", "\'", $str);
    $str = str_replace("\n", " ", $str);
    $str = str_replace("\r", " ", $str);
    $str = str_replace("\t", " ", $str);
    return preg_replace('/\s+/', ' ', $str);
}

/**
 * Output line on screen
 *
 * @param  string $str
 * @return void
 */
function outputLine(string $str): void
{
    echo $str . PHP_EOL;
}

/**
 * Function to download a codelist
 *
 * @param  array $fileToDownload
 * @return void
 */
function downloadList(array $fileToDownload): void
{
    foreach ($fileToDownload[DOWNLOADDEF_KEY_URL] as $idx => $dummy) {
        $downloadFromUrl = $fileToDownload[DOWNLOADDEF_KEY_URL][$idx];
        $saveToFile = $fileToDownload[DOWNLOADDEF_KEY_TOFILE][$idx];
        $saveToDirectory = dirname($saveToFile);

        if (!is_file($saveToDirectory)) {
            @mkdir($saveToDirectory);
        }

        outputLine(sprintf("Downloading from\n   %s\nand saving to file\n   %s...", $downloadFromUrl, $saveToFile));

        if (file_exists($saveToFile)) {
            continue;
        }

        $downloadedContent = file_get_contents($downloadFromUrl);

        if ($downloadedContent=== false) {
            throw new \Exception('Failed to download the file.');
        }

        if (file_put_contents($saveToFile, $downloadedContent) === false) {
            throw new \Exception('Failed saved the downloaded file.');
        }
    }
}

/**
 * Download a bunch of files
 *
 * @param  array $filesToDownload
 * @return void
 */
function downloadLists(array $filesToDownload): void
{
    foreach ($filesToDownload as $fileToDownload) {
        downloadList($fileToDownload);
    }
}

/**
 * Create a code class
 *
 * @return void
 */
function createCodeClassFromKositJson(array $fileToDownload): void
{
    // Define some internal variables

    $classGenerationEnabled = $fileToDownload[DOWNLOADDEF_KEY_ENABLED] ?? false;
    $classNamespace = $fileToDownload[DOWNLOADDEF_KEY_CLASSNAMESPACE];
    $className = $fileToDownload[DOWNLOADDEF_KEY_CLASSNAME];
    $classDir = PathUtils::combineAllPaths(__DIR__, "classes");
    $classTitle = $fileToDownload[DOWNLOADDEF_KEY_TITLE];
    $classTitleList = $fileToDownload[DOWNLOADDEF_KEY_TITLE_LIST];
    $classHomepageUrls = is_array($fileToDownload[DOWNLOADDEF_KEY_URL_HP]) ? $fileToDownload[DOWNLOADDEF_KEY_URL_HP] : [$fileToDownload[DOWNLOADDEF_KEY_URL_HP]];
    $classShortIdentifiers = $fileToDownload[DOWNLOADDEF_KEY_SHORTIDENTIFIERS];
    $classShortIdentifiersLength = $fileToDownload[DOWNLOADDEF_KEY_SHORTIDENTIFIERS_LENGTH] ?? 4;
    $classFilename = PathUtils::combinePathWithFile($classDir, sprintf('%s.php', $className));
    $classConstantPrefixes = is_array($fileToDownload[DOWNLOADDEF_KEY_CLASSCONSTANT_PREFIX]) ? $fileToDownload[DOWNLOADDEF_KEY_CLASSCONSTANT_PREFIX] : [$fileToDownload[DOWNLOADDEF_KEY_CLASSCONSTANT_PREFIX]];

    $dataCodeIndex = $fileToDownload[DOWNLOADDEF_KEY_DATA_CODEINDEX] ?? 0;
    $dataDescIndex = $fileToDownload[DOWNLOADDEF_KEY_DATA_DESCINDEX] ?? 1;
    $dataDescLongIndex = $fileToDownload[DOWNLOADDEF_KEY_DATA_DESCLONGINDEX] ?? 2;
    $dataSortIndex = $fileToDownload[DOWNLOADDEF_KEY_DATA_SORTINDEX] ?? ($fileToDownload[DOWNLOADDEF_KEY_DATA_CODEINDEX] ?? 0);

    $libName = $fileToDownload[DOWNLOADDEF_LIB_NAME];
    $libTitle = $fileToDownload[DOWNLOADDEF_LIB_TITLE];

    // Check enabled

    if ($classGenerationEnabled !== true) {
        outputline(sprintf("Generating class %s is disabled", $className));
        return;
    }

    // Logging

    outputline(sprintf("Generating class %s", $className));

    // Check destination directory

    if (!is_file($classDir)) {
        @mkdir($classDir);
    }

    // Remove existing class file

    if (file_exists($classFilename)) {
        @unlink($classFilename);
    }

    // Create PHP Printer

    $phpPrinter = new Nette\PhpGenerator\Printer;

    // Create PHP File

    $phpFile = new Nette\PhpGenerator\PhpFile;
    $phpFile->addComment(sprintf("This file is a part of horstoeko/%s.\n\nFor the full copyright and license information, please view the LICENSE\nfile that was distributed with this source code.", $libName));

    // Create PHP Class

    $phpClass = $phpFile->addNamespace($classNamespace)->addClass($className);
    $phpClass->addComment(sprintf("Class representing %s\nName of list: %s\n\n@category %s\n@package  %s\n@author   D. Erling <horstoeko@erling.com.de>\n@license  https://opensource.org/licenses/MIT MIT\n@link     https://github.com/horstoeko/zugferd", $classTitle, $classTitleList, $libTitle, $libTitle));
    foreach ($classHomepageUrls as $classHomepageUrl) {
        $phpClass->addComment(sprintf("@see      %s", $classHomepageUrl));
    }

    // Fill PHP Class

    foreach ($fileToDownload[DOWNLOADDEF_KEY_TOFILE] as $idx => $dummy) {
        $downloadedContent = file_get_contents($fileToDownload[DOWNLOADDEF_KEY_TOFILE][$idx]);
        $downloadedContentObject = json_decode($downloadedContent, true);
        $downloadedContentObjectData = $downloadedContentObject["daten"];
        $constantPrefix = $classConstantPrefixes[$idx] ?? "";

        usort(
            $downloadedContentObjectData,
            function ($a, $b) use ($dataSortIndex) {
                return strcasecmp($a[$dataSortIndex], $b[$dataSortIndex]);
            }
        );

        foreach ($downloadedContentObjectData as $line) {
            $phpClass
                ->addConstant(sprintf('%s%s', $constantPrefix, strIdentifier($line[$dataDescIndex], $classShortIdentifiers, $classShortIdentifiersLength)), $line[$dataCodeIndex])
                ->addComment("\n" . (strComment($line[$dataDescIndex] ?? "")) . " (" . (strComment($line[$dataCodeIndex] ?? "")) . ")")
                ->addComment("\n" . strComment($line[$dataDescLongIndex] ?? ($line[$dataDescIndex] ?? "")));
        }
    }

    // Should methods be added

    if ($fileToDownload[DOWNLOADDEF_KEY_ADDMETHODS] === true) {
        // Add method which returns a list of all codes to generated class

        $phpClassMethod = $phpClass->addMethod('getAllCodes');
        $phpClassMethod->setFinal();
        $phpClassMethod->setStatic();
        $phpClassMethod->setReturnType('array');
        $phpClassMethod->addComment("Returns an array of all available codes\n");
        $phpClassMethod->addComment("@return array");
        $phpClassMethod->addComment("@codeCoverageIgnore");
        $phpClassMethod->addBody('return [');

        foreach ($fileToDownload[DOWNLOADDEF_KEY_TOFILE] as $idx => $dummy) {
            $downloadedContent = file_get_contents($fileToDownload[DOWNLOADDEF_KEY_TOFILE][$idx]);
            $downloadedContentObject = json_decode($downloadedContent, true);
            $downloadedContentObjectData = $downloadedContentObject["daten"];
            $constantPrefix = $classConstantPrefixes[$idx] ?? "";

            usort(
                $downloadedContentObjectData,
                function ($a, $b) use ($dataSortIndex) {
                    return strcasecmp($a[$dataSortIndex], $b[$dataSortIndex]);
                }
            );

            foreach ($downloadedContentObjectData as $line) {
                $phpClassMethod->addBody(sprintf("    static::%s%s,", $constantPrefix, strIdentifier($line[$dataDescIndex], $classShortIdentifiers, $classShortIdentifiersLength)));
            }
        }

        $phpClassMethod->addBody('];');

        // Add method which returns an associate array for code => description

        $phpClassMethod = $phpClass->addMethod('getAllCodeDescriptions');
        $phpClassMethod->setFinal();
        $phpClassMethod->setStatic();
        $phpClassMethod->setReturnType('array');
        $phpClassMethod->addComment("Returns an array of code descriptions indexed by code\n");
        $phpClassMethod->addComment("@return array");
        $phpClassMethod->addComment("@codeCoverageIgnore");
        $phpClassMethod->addBody('return [');

        foreach ($fileToDownload[DOWNLOADDEF_KEY_TOFILE] as $idx => $dummy) {
            $downloadedContent = file_get_contents($fileToDownload[DOWNLOADDEF_KEY_TOFILE][$idx]);
            $downloadedContentObject = json_decode($downloadedContent, true);
            $downloadedContentObjectData = $downloadedContentObject["daten"];
            $constantPrefix = $classConstantPrefixes[$idx] ?? "";

            usort(
                $downloadedContentObjectData,
                function ($a, $b) use ($dataSortIndex) {
                    return strcasecmp($a[$dataSortIndex], $b[$dataSortIndex]);
                }
            );

            foreach ($downloadedContentObjectData as $line) {
                $phpClassMethod->addBody(sprintf("    static::%s%s => '%s',", $constantPrefix, strIdentifier($line[$dataDescIndex], $classShortIdentifiers, $classShortIdentifiersLength), strDesc($line[$dataDescIndex])));
            }
        }

        $phpClassMethod->addBody('];');

        // Add method which returns an boolean true when code exists otherwise false

        $phpClassMethod = $phpClass->addMethod('checkCodeExists');
        $phpClassMethod->setFinal();
        $phpClassMethod->setStatic();
        $phpClassMethod->setReturnType('bool');
        $phpClassMethod->addComment("Returns true if a code exists in the list, otherwise false\n");
        $phpClassMethod->addComment("@param string \$code");
        $phpClassMethod->addComment("@return boolean");
        $phpClassMethod->addComment("@codeCoverageIgnore");
        $phpClassMethod->addParameter('code')->setType("string");
        $phpClassMethod->addBody('return isset(static::getAllCodes()[$code]);');

        // Add method which returns the description of a code

        $phpClassMethod = $phpClass->addMethod('getCodeDescription');
        $phpClassMethod->setFinal();
        $phpClassMethod->setStatic();
        $phpClassMethod->setReturnType('string');
        $phpClassMethod->addComment("Returns the description of a code. If code is not found an empty string is returned\n");
        $phpClassMethod->addComment("@param string \$code");
        $phpClassMethod->addComment("@return string");
        $phpClassMethod->addComment("@codeCoverageIgnore");
        $phpClassMethod->addParameter('code')->setType("string");
        $phpClassMethod->addBody('if (static::checkCodeExists($code) === true) {');
        $phpClassMethod->addBody('    return static::getAllCodeDescriptions()[$code];');
        $phpClassMethod->addBody('}');
        $phpClassMethod->addBody('');
        $phpClassMethod->addBody('return "";');
    }

    // Save generated class to file

    outputLine(sprintf("Saving class to directory\n  %s", $classFilename));

    file_put_contents($classFilename, $phpPrinter->printFile($phpFile));
}


/**
 * Create a code class
 *
 * @return void
 */
function createCodeClassFromCsv(array $fileToDownload): void
{
    // Define some internal variables

    $classGenerationEnabled = $fileToDownload[DOWNLOADDEF_KEY_ENABLED] ?? false;
    $classNamespace = $fileToDownload[DOWNLOADDEF_KEY_CLASSNAMESPACE];
    $className = $fileToDownload[DOWNLOADDEF_KEY_CLASSNAME];
    $classDir = PathUtils::combineAllPaths(__DIR__, "classes");
    $classTitle = $fileToDownload[DOWNLOADDEF_KEY_TITLE];
    $classTitleList = $fileToDownload[DOWNLOADDEF_KEY_TITLE_LIST];
    $classHomepageUrls = is_array($fileToDownload[DOWNLOADDEF_KEY_URL_HP]) ? $fileToDownload[DOWNLOADDEF_KEY_URL_HP] : [$fileToDownload[DOWNLOADDEF_KEY_URL_HP]];
    $classShortIdentifiers = $fileToDownload[DOWNLOADDEF_KEY_SHORTIDENTIFIERS];
    $classShortIdentifiersLength = $fileToDownload[DOWNLOADDEF_KEY_SHORTIDENTIFIERS_LENGTH] ?? 4;
    $classFilename = PathUtils::combinePathWithFile($classDir, sprintf('%s.php', $className));
    $classConstantPrefixes = is_array($fileToDownload[DOWNLOADDEF_KEY_CLASSCONSTANT_PREFIX]) ? $fileToDownload[DOWNLOADDEF_KEY_CLASSCONSTANT_PREFIX] : [$fileToDownload[DOWNLOADDEF_KEY_CLASSCONSTANT_PREFIX]];

    $dataCodeIndex = $fileToDownload[DOWNLOADDEF_KEY_DATA_CODEINDEX] ?? 0;
    $dataDescIndex = $fileToDownload[DOWNLOADDEF_KEY_DATA_DESCINDEX] ?? 1;
    $dataDescLongIndex = $fileToDownload[DOWNLOADDEF_KEY_DATA_DESCLONGINDEX] ?? 2;
    $dataSortIndex = $fileToDownload[DOWNLOADDEF_KEY_DATA_SORTINDEX] ?? ($fileToDownload[DOWNLOADDEF_KEY_DATA_CODEINDEX] ?? 0);

    $libName = $fileToDownload[DOWNLOADDEF_LIB_NAME];
    $libTitle = $fileToDownload[DOWNLOADDEF_LIB_TITLE];

    // Check enabled

    if ($classGenerationEnabled !== true) {
        outputline(sprintf("Generating class %s is disabled", $className));
        return;
    }

    // Logging

    outputline(sprintf("Generating class %s", $className));

    // Check destination directory

    if (!is_file($classDir)) {
        @mkdir($classDir);
    }

    // Remove existing class file

    if (file_exists($classFilename)) {
        @unlink($classFilename);
    }

    // Create PHP Printer

    $phpPrinter = new Nette\PhpGenerator\Printer;

    // Create PHP File

    $phpFile = new Nette\PhpGenerator\PhpFile;
    $phpFile->addComment(sprintf("This file is a part of horstoeko/%s.\n\nFor the full copyright and license information, please view the LICENSE\nfile that was distributed with this source code.", $libName));

    // Create PHP Class

    $phpClass = $phpFile->addNamespace($classNamespace)->addClass($className);
    $phpClass->addComment(sprintf("Class representing %s\nName of list: %s\n\n@category %s\n@package  %s\n@author   D. Erling <horstoeko@erling.com.de>\n@license  https://opensource.org/licenses/MIT MIT\n@link     https://github.com/horstoeko/zugferd", $classTitle, $classTitleList, $libTitle, $libTitle));
    foreach ($classHomepageUrls as $classHomepageUrl) {
        $phpClass->addComment(sprintf("@see      %s", $classHomepageUrl));
    }

    // Fill PHP Class

    foreach ($fileToDownload[DOWNLOADDEF_KEY_TOFILE] as $idx => $dummy) {
        $downloadedContentObjectData = [];

        if (($handle = fopen($fileToDownload[DOWNLOADDEF_KEY_TOFILE][$idx], "r")) !== false) {
            while (($row = fgetcsv($handle, null, "|")) !== false) {
                $downloadedContentObjectData[] = $row;
            }
            
            fclose($handle);
        } else {
            echo "Die Datei konnte nicht geöffnet werden.";
        }

        $constantPrefix = $classConstantPrefixes[$idx] ?? "";

        usort(
            $downloadedContentObjectData,
            function ($a, $b) use ($dataSortIndex) {
                return strcasecmp($a[$dataSortIndex], $b[$dataSortIndex]);
            }
        );

        foreach ($downloadedContentObjectData as $line) {
            $phpClass
                ->addConstant(sprintf('%s%s', $constantPrefix, strIdentifier($line[$dataDescIndex], $classShortIdentifiers, $classShortIdentifiersLength)), $line[$dataCodeIndex])
                ->addComment("\n" . (strComment($line[$dataDescIndex] ?? "")) . " (" . (strComment($line[$dataCodeIndex] ?? "")) . ")")
                ->addComment("\n" . strComment($line[$dataDescLongIndex] ?? ($line[$dataDescIndex] ?? "")));
        }
    }

    // Should methods be added

    if ($fileToDownload[DOWNLOADDEF_KEY_ADDMETHODS] === true) {
        // Add method which returns a list of all codes to generated class

        $phpClassMethod = $phpClass->addMethod('getAllCodes');
        $phpClassMethod->setFinal();
        $phpClassMethod->setStatic();
        $phpClassMethod->setReturnType('array');
        $phpClassMethod->addComment("Returns an array of all available codes\n");
        $phpClassMethod->addComment("@return array");
        $phpClassMethod->addComment("@codeCoverageIgnore");
        $phpClassMethod->addBody('return [');

        foreach ($fileToDownload[DOWNLOADDEF_KEY_TOFILE] as $idx => $dummy) {
            $downloadedContentObjectData = [];

            if (($handle = fopen($fileToDownload[DOWNLOADDEF_KEY_TOFILE][$idx], "r")) !== false) {
                while (($row = fgetcsv($handle, null, "|")) !== false) {
                    $downloadedContentObjectData[] = $row;
                }
                
                fclose($handle);
            } else {
                echo "Die Datei konnte nicht geöffnet werden.";
            }

            $constantPrefix = $classConstantPrefixes[$idx] ?? "";

            usort(
                $downloadedContentObjectData,
                function ($a, $b) use ($dataSortIndex) {
                    return strcasecmp($a[$dataSortIndex], $b[$dataSortIndex]);
                }
            );

            foreach ($downloadedContentObjectData as $line) {
                $phpClassMethod->addBody(sprintf("    static::%s%s,", $constantPrefix, strIdentifier($line[$dataDescIndex], $classShortIdentifiers, $classShortIdentifiersLength)));
            }
        }

        $phpClassMethod->addBody('];');

        // Add method which returns an associate array for code => description

        $phpClassMethod = $phpClass->addMethod('getAllCodeDescriptions');
        $phpClassMethod->setFinal();
        $phpClassMethod->setStatic();
        $phpClassMethod->setReturnType('array');
        $phpClassMethod->addComment("Returns an array of code descriptions indexed by code\n");
        $phpClassMethod->addComment("@return array");
        $phpClassMethod->addComment("@codeCoverageIgnore");
        $phpClassMethod->addBody('return [');

        foreach ($fileToDownload[DOWNLOADDEF_KEY_TOFILE] as $idx => $dummy) {
            $downloadedContentObjectData = [];

            if (($handle = fopen($fileToDownload[DOWNLOADDEF_KEY_TOFILE][$idx], "r")) !== false) {
                while (($row = fgetcsv($handle, null, "|")) !== false) {
                    $downloadedContentObjectData[] = $row;
                }
                
                fclose($handle);
            } else {
                echo "Die Datei konnte nicht geöffnet werden.";
            }

            $constantPrefix = $classConstantPrefixes[$idx] ?? "";

            usort(
                $downloadedContentObjectData,
                function ($a, $b) use ($dataSortIndex) {
                    return strcasecmp($a[$dataSortIndex], $b[$dataSortIndex]);
                }
            );

            foreach ($downloadedContentObjectData as $line) {
                $phpClassMethod->addBody(sprintf("    static::%s%s => '%s',", $constantPrefix, strIdentifier($line[$dataDescIndex], $classShortIdentifiers, $classShortIdentifiersLength), strDesc($line[$dataDescIndex])));
            }
        }

        $phpClassMethod->addBody('];');

        // Add method which returns an boolean true when code exists otherwise false

        $phpClassMethod = $phpClass->addMethod('checkCodeExists');
        $phpClassMethod->setFinal();
        $phpClassMethod->setStatic();
        $phpClassMethod->setReturnType('bool');
        $phpClassMethod->addComment("Returns true if a code exists in the list, otherwise false\n");
        $phpClassMethod->addComment("@param string \$code");
        $phpClassMethod->addComment("@return boolean");
        $phpClassMethod->addComment("@codeCoverageIgnore");
        $phpClassMethod->addParameter('code')->setType("string");
        $phpClassMethod->addBody('return isset(static::getAllCodes()[$code]);');

        // Add method which returns the description of a code

        $phpClassMethod = $phpClass->addMethod('getCodeDescription');
        $phpClassMethod->setFinal();
        $phpClassMethod->setStatic();
        $phpClassMethod->setReturnType('string');
        $phpClassMethod->addComment("Returns the description of a code. If code is not found an empty string is returned\n");
        $phpClassMethod->addComment("@param string \$code");
        $phpClassMethod->addComment("@return string");
        $phpClassMethod->addComment("@codeCoverageIgnore");
        $phpClassMethod->addParameter('code')->setType("string");
        $phpClassMethod->addBody('if (static::checkCodeExists($code) === true) {');
        $phpClassMethod->addBody('    return static::getAllCodeDescriptions()[$code];');
        $phpClassMethod->addBody('}');
        $phpClassMethod->addBody('');
        $phpClassMethod->addBody('return "";');
    }

    // Save generated class to file

    outputLine(sprintf("Saving class to directory\n  %s", $classFilename));

    file_put_contents($classFilename, $phpPrinter->printFile($phpFile));
}

/**
 * Create code classes
 *
 * @param  array $filesToDownload
 * @return void
 */
function createCodeClasses(array $filesToDownload): void
{
    foreach ($filesToDownload as $fileToDownload) {
        $classCreatorFunc = $fileToDownload[DOWNLOADDEF_KEY_CLASSCREATORFUNC] ?? DOWNLOADDEF_KEY_CLASSCREATORFUNC_DEFAULT;
        $classCreatorFunc($fileToDownload);
    }
}

/* ----------------------------------------------------------------------------------------------------------
   Main
   ---------------------------------------------------------------------------------------------------------- */

$filesToDownload = [
    [
        DOWNLOADDEF_KEY_ENABLED => true,
        DOWNLOADDEF_LIB_NAME => 'zugferd',
        DOWNLOADDEF_LIB_TITLE => 'Zugferd',
        DOWNLOADDEF_KEY_URL => [
            "https://www.xrepository.de/api/xrepository/urn:xoev-de:kosit:codeliste:untdid.7161_3/download/UNTDID_7161_3.json",
            "https://www.xrepository.de/api/xrepository/urn:xoev-de:kosit:codeliste:untdid.5189_3/download/UNTDID_5189_3.json",
        ],
        DOWNLOADDEF_KEY_TOFILE => [
            PathUtils::combinePathWithFile(PathUtils::combineAllPaths(__DIR__, "download"), "UNTDID_7161.json"),
            PathUtils::combinePathWithFile(PathUtils::combineAllPaths(__DIR__, "download"), "UNTDID_5189.json"),
        ],
        DOWNLOADDEF_KEY_URL_HP => "https://www.xrepository.de/details/urn:xoev-de:kosit:codeliste:untdid.7161",
        DOWNLOADDEF_KEY_CLASSNAMESPACE => "horstoeko\zugferd\codelists",
        DOWNLOADDEF_KEY_CLASSNAME => "ZugferdAllowanceChargeCodes",
        DOWNLOADDEF_KEY_TITLE => "list of allowance and charge identification codes",
        DOWNLOADDEF_KEY_TITLE_LIST => "UNTDID 7161 Special service description code, UNTDID 5189 Allowance or charge identification code",
        DOWNLOADDEF_KEY_SHORTIDENTIFIERS => true,
        DOWNLOADDEF_KEY_ADDMETHODS => DOWNLOADDEF_KEY_ADDMETHODS_DEFAULT,
        DOWNLOADDEF_KEY_DATA_SORTINDEX => 1,
        DOWNLOADDEF_KEY_CLASSCONSTANT_PREFIX => [],
    ],
    [
        DOWNLOADDEF_KEY_ENABLED => true,
        DOWNLOADDEF_LIB_NAME => 'zugferd',
        DOWNLOADDEF_LIB_TITLE => 'Zugferd',
        DOWNLOADDEF_KEY_URL => [
            "https://www.xrepository.de/api/xrepository/urn:xoev-de:kosit:codeliste:country-codes_8/download/Country_Codes_8.json",
        ],
        DOWNLOADDEF_KEY_TOFILE => [
            PathUtils::combinePathWithFile(PathUtils::combineAllPaths(__DIR__, "download"), "ISO_COUNTRY_CODES.json"),
        ],
        DOWNLOADDEF_KEY_URL_HP => "https://www.xrepository.de/details/urn:xoev-de:kosit:codeliste:country-codes",
        DOWNLOADDEF_KEY_CLASSNAMESPACE => "horstoeko\zugferd\codelists",
        DOWNLOADDEF_KEY_CLASSNAME => "ZugferdCountryCodes",
        DOWNLOADDEF_KEY_TITLE => "list of country codes",
        DOWNLOADDEF_KEY_TITLE_LIST => "ISO",
        DOWNLOADDEF_KEY_SHORTIDENTIFIERS => true,
        DOWNLOADDEF_KEY_ADDMETHODS => DOWNLOADDEF_KEY_ADDMETHODS_DEFAULT,
        DOWNLOADDEF_KEY_DATA_CODEINDEX => 0,
        DOWNLOADDEF_KEY_DATA_DESCINDEX => 2,
        DOWNLOADDEF_KEY_DATA_DESCLONGINDEX => 0,
        DOWNLOADDEF_KEY_DATA_SORTINDEX => 2,
        DOWNLOADDEF_KEY_CLASSCONSTANT_PREFIX => [],
    ],
    [
        DOWNLOADDEF_KEY_ENABLED => true,
        DOWNLOADDEF_LIB_NAME => 'zugferd',
        DOWNLOADDEF_LIB_TITLE => 'Zugferd',
        DOWNLOADDEF_KEY_URL => [
            "https://www.xrepository.de/api/xrepository/urn:xoev-de:kosit:codeliste:currency-codes_3/download/Currency_Codes_3.json",
        ],
        DOWNLOADDEF_KEY_TOFILE => [
            PathUtils::combinePathWithFile(PathUtils::combineAllPaths(__DIR__, "download"), "ISO_CURRENCY_CODES.json"),
        ],
        DOWNLOADDEF_KEY_URL_HP => "https://www.xrepository.de/details/urn:xoev-de:kosit:codeliste:currency-codes",
        DOWNLOADDEF_KEY_CLASSNAMESPACE => "horstoeko\zugferd\codelists",
        DOWNLOADDEF_KEY_CLASSNAME => "ZugferdCurrencyCodes",
        DOWNLOADDEF_KEY_TITLE => "list of currency codes",
        DOWNLOADDEF_KEY_TITLE_LIST => "ISO",
        DOWNLOADDEF_KEY_SHORTIDENTIFIERS => false,
        DOWNLOADDEF_KEY_ADDMETHODS => DOWNLOADDEF_KEY_ADDMETHODS_DEFAULT,
        DOWNLOADDEF_KEY_DATA_CODEINDEX => 0,
        DOWNLOADDEF_KEY_DATA_DESCINDEX => 1,
        DOWNLOADDEF_KEY_DATA_DESCLONGINDEX => 1,
        DOWNLOADDEF_KEY_DATA_SORTINDEX => 1,
        DOWNLOADDEF_KEY_CLASSCONSTANT_PREFIX => [],
    ],
    [
        DOWNLOADDEF_KEY_ENABLED => true,
        DOWNLOADDEF_LIB_NAME => 'zugferd',
        DOWNLOADDEF_LIB_TITLE => 'Zugferd',
        DOWNLOADDEF_KEY_URL => [
            "https://www.xrepository.de/api/xrepository/urn:xoev-de:kosit:codeliste:untdid.5305_3/download/UNTDID_5305_3.json",
        ],
        DOWNLOADDEF_KEY_TOFILE => [
            PathUtils::combinePathWithFile(PathUtils::combineAllPaths(__DIR__, "download"), "UNTDID_5305.json"),
        ],
        DOWNLOADDEF_KEY_URL_HP => "https://www.xrepository.de/details/urn:xoev-de:kosit:codeliste:untdid.5305",
        DOWNLOADDEF_KEY_CLASSNAMESPACE => "horstoeko\zugferd\codelists",
        DOWNLOADDEF_KEY_CLASSNAME => "ZugferdDutyTaxFeeCategories",
        DOWNLOADDEF_KEY_TITLE => "list of duty or tax or fee category codes",
        DOWNLOADDEF_KEY_TITLE_LIST => "UNTDID 5305 Duty or tax or fee category code",
        DOWNLOADDEF_KEY_SHORTIDENTIFIERS => false,
        DOWNLOADDEF_KEY_ADDMETHODS => DOWNLOADDEF_KEY_ADDMETHODS_DEFAULT,
        DOWNLOADDEF_KEY_DATA_CODEINDEX => 0,
        DOWNLOADDEF_KEY_DATA_DESCINDEX => 1,
        DOWNLOADDEF_KEY_DATA_DESCLONGINDEX => 1,
        DOWNLOADDEF_KEY_DATA_SORTINDEX => 1,
        DOWNLOADDEF_KEY_CLASSCONSTANT_PREFIX => [],
    ],
    [
        DOWNLOADDEF_KEY_ENABLED => true,
        DOWNLOADDEF_LIB_NAME => 'zugferd',
        DOWNLOADDEF_LIB_TITLE => 'Zugferd',
        DOWNLOADDEF_KEY_URL => [
            "https://www.xrepository.de/api/xrepository/urn:xoev-de:kosit:codeliste:untdid.1001_4/download/UNTDID_1001_4.json",
        ],
        DOWNLOADDEF_KEY_TOFILE => [
            PathUtils::combinePathWithFile(PathUtils::combineAllPaths(__DIR__, "download"), "UNTDID_1001.json"),
        ],
        DOWNLOADDEF_KEY_URL_HP => "https://www.xrepository.de/details/urn:xoev-de:kosit:codeliste:untdid.1001",
        DOWNLOADDEF_KEY_CLASSNAMESPACE => "horstoeko\zugferd\codelists",
        DOWNLOADDEF_KEY_CLASSNAME => "ZugferdDocumentType",
        DOWNLOADDEF_KEY_TITLE => "list of document name codes",
        DOWNLOADDEF_KEY_TITLE_LIST => "UNTDID 1001 Document name code",
        DOWNLOADDEF_KEY_SHORTIDENTIFIERS => false,
        DOWNLOADDEF_KEY_ADDMETHODS => DOWNLOADDEF_KEY_ADDMETHODS_DEFAULT,
        DOWNLOADDEF_KEY_DATA_SORTINDEX => 1,
        DOWNLOADDEF_KEY_CLASSCONSTANT_PREFIX => [],
    ],
    [
        DOWNLOADDEF_KEY_ENABLED => true,
        DOWNLOADDEF_LIB_NAME => 'zugferd',
        DOWNLOADDEF_LIB_TITLE => 'Zugferd',
        DOWNLOADDEF_KEY_URL => [
            "https://www.xrepository.de/api/xrepository/urn:xoev-de:kosit:codeliste:untdid.7143_4/download/UNTDID_7143_4.json",
        ],
        DOWNLOADDEF_KEY_TOFILE => [
            PathUtils::combinePathWithFile(PathUtils::combineAllPaths(__DIR__, "download"), "UNTDID_7143.json"),
        ],
        DOWNLOADDEF_KEY_URL_HP => "https://www.xrepository.de/details/urn:xoev-de:kosit:codeliste:untdid.7143",
        DOWNLOADDEF_KEY_CLASSNAMESPACE => "horstoeko\zugferd\codelists",
        DOWNLOADDEF_KEY_CLASSNAME => "ZugferdItemTypeIdentificationCodes",
        DOWNLOADDEF_KEY_TITLE => "list of item type identification codes",
        DOWNLOADDEF_KEY_TITLE_LIST => "UNTDID 7143 Item type identification code",
        DOWNLOADDEF_KEY_SHORTIDENTIFIERS => true,
        DOWNLOADDEF_KEY_ADDMETHODS => DOWNLOADDEF_KEY_ADDMETHODS_DEFAULT,
        DOWNLOADDEF_KEY_DATA_SORTINDEX => 1,
        DOWNLOADDEF_KEY_CLASSCONSTANT_PREFIX => [],
    ],
    [
        DOWNLOADDEF_KEY_ENABLED => true,
        DOWNLOADDEF_LIB_NAME => 'zugferd',
        DOWNLOADDEF_LIB_TITLE => 'Zugferd',
        DOWNLOADDEF_KEY_URL => [
            "https://www.xrepository.de/api/xrepository/urn:xoev-de:xrechnung:codeliste:untdid.4461_3/download/UNTDID_4461_3.json",
        ],
        DOWNLOADDEF_KEY_TOFILE => [
            PathUtils::combinePathWithFile(PathUtils::combineAllPaths(__DIR__, "download"), "UNTDID_4461.json"),
        ],
        DOWNLOADDEF_KEY_URL_HP => "https://www.xrepository.de/details/urn:xoev-de:xrechnung:codeliste:untdid.4461",
        DOWNLOADDEF_KEY_CLASSNAMESPACE => "horstoeko\zugferd\codelists",
        DOWNLOADDEF_KEY_CLASSNAME => "ZugferdPaymentMeans",
        DOWNLOADDEF_KEY_TITLE => "list of payment means codes",
        DOWNLOADDEF_KEY_TITLE_LIST => "UNTDID 4461 Payment means code",
        DOWNLOADDEF_KEY_SHORTIDENTIFIERS => true,
        DOWNLOADDEF_KEY_ADDMETHODS => DOWNLOADDEF_KEY_ADDMETHODS_DEFAULT,
        DOWNLOADDEF_KEY_DATA_SORTINDEX => 1,
        DOWNLOADDEF_KEY_CLASSCONSTANT_PREFIX => [],
    ],
    [
        DOWNLOADDEF_KEY_ENABLED => true,
        DOWNLOADDEF_LIB_NAME => 'zugferd',
        DOWNLOADDEF_LIB_TITLE => 'Zugferd',
        DOWNLOADDEF_KEY_URL => [
            "https://www.xrepository.de/api/xrepository/urn:xoev-de:kosit:codeliste:untdid.1153_3/download/UNTDID_1153_3.json",
        ],
        DOWNLOADDEF_KEY_TOFILE => [
            PathUtils::combinePathWithFile(PathUtils::combineAllPaths(__DIR__, "download"), "UNTDID_1153.json"),
        ],
        DOWNLOADDEF_KEY_URL_HP => "https://www.xrepository.de/details/urn:xoev-de:kosit:codeliste:untdid.1153",
        DOWNLOADDEF_KEY_CLASSNAMESPACE => "horstoeko\zugferd\codelists",
        DOWNLOADDEF_KEY_CLASSNAME => "ZugferdReferenceCodeQualifiers",
        DOWNLOADDEF_KEY_TITLE => "list of reference code qualifiers",
        DOWNLOADDEF_KEY_TITLE_LIST => "UNTDID 1153 Reference code qualifier",
        DOWNLOADDEF_KEY_SHORTIDENTIFIERS => true,
        DOWNLOADDEF_KEY_ADDMETHODS => DOWNLOADDEF_KEY_ADDMETHODS_DEFAULT,
        DOWNLOADDEF_KEY_DATA_SORTINDEX => 1,
        DOWNLOADDEF_KEY_CLASSCONSTANT_PREFIX => [],
    ],
    [
        DOWNLOADDEF_KEY_ENABLED => true,
        DOWNLOADDEF_LIB_NAME => 'zugferd',
        DOWNLOADDEF_LIB_TITLE => 'Zugferd',
        DOWNLOADDEF_KEY_URL => [
            "https://www.xrepository.de/api/xrepository/urn:xoev-de:kosit:codeliste:untdid.4451_4/download/UNTDID_4451_4.json",
        ],
        DOWNLOADDEF_KEY_TOFILE => [
            PathUtils::combinePathWithFile(PathUtils::combineAllPaths(__DIR__, "download"), "UNTDID_4451.json"),
        ],
        DOWNLOADDEF_KEY_URL_HP => "https://www.xrepository.de/details/urn:xoev-de:kosit:codeliste:untdid.4451",
        DOWNLOADDEF_KEY_CLASSNAMESPACE => "horstoeko\zugferd\codelists",
        DOWNLOADDEF_KEY_CLASSNAME => "ZugferdTextSubjectCodeQualifiers",
        DOWNLOADDEF_KEY_TITLE => "list of text subject code qualifiers",
        DOWNLOADDEF_KEY_TITLE_LIST => "UNTDID 4451 Text subject code qualifier",
        DOWNLOADDEF_KEY_SHORTIDENTIFIERS => true,
        DOWNLOADDEF_KEY_ADDMETHODS => DOWNLOADDEF_KEY_ADDMETHODS_DEFAULT,
        DOWNLOADDEF_KEY_DATA_SORTINDEX => 1,
        DOWNLOADDEF_KEY_CLASSCONSTANT_PREFIX => [],
    ],
    [
        DOWNLOADDEF_KEY_ENABLED => true,
        DOWNLOADDEF_LIB_NAME => 'zugferd',
        DOWNLOADDEF_LIB_TITLE => 'Zugferd',
        DOWNLOADDEF_KEY_URL => [
            "https://www.xrepository.de/api/xrepository/urn:xoev-de:kosit:codeliste:icd_5/download/ICD_5.json",
        ],
        DOWNLOADDEF_KEY_TOFILE => [
            PathUtils::combinePathWithFile(PathUtils::combineAllPaths(__DIR__, "download"), "ICD_5.json"),
        ],
        DOWNLOADDEF_KEY_URL_HP => "https://www.xrepository.de/details/urn:xoev-de:kosit:codeliste:icd",
        DOWNLOADDEF_KEY_CLASSNAMESPACE => "horstoeko\zugferd\codelists",
        DOWNLOADDEF_KEY_CLASSNAME => "ZugferdSchemeIdentifiers",
        DOWNLOADDEF_KEY_TITLE => "list of codes for the identification of organizations and organization parts",
        DOWNLOADDEF_KEY_TITLE_LIST => "ISO/IEC 17 6523 - Identifier scheme code (ICD)",
        DOWNLOADDEF_KEY_SHORTIDENTIFIERS => true,
        DOWNLOADDEF_KEY_ADDMETHODS => DOWNLOADDEF_KEY_ADDMETHODS_DEFAULT,
        DOWNLOADDEF_KEY_DATA_SORTINDEX => 1,
        DOWNLOADDEF_KEY_CLASSCONSTANT_PREFIX => [],
    ],
    [
        DOWNLOADDEF_KEY_ENABLED => true,
        DOWNLOADDEF_LIB_NAME => 'zugferd',
        DOWNLOADDEF_LIB_TITLE => 'Zugferd',
        DOWNLOADDEF_KEY_URL => [
            "https://www.xrepository.de/api/xrepository/urn:xoev-de:kosit:codeliste:rec20_3/download/UN_ECE_Recommendation_N_20_3.json",
            "https://www.xrepository.de/api/xrepository/urn:xoev-de:kosit:codeliste:rec21_3/download/UN_ECE_Recommendation_N_21_3.json",
        ],
        DOWNLOADDEF_KEY_TOFILE => [
            PathUtils::combinePathWithFile(PathUtils::combineAllPaths(__DIR__, "download"), "UNECE_REC_20.json"),
            PathUtils::combinePathWithFile(PathUtils::combineAllPaths(__DIR__, "download"), "UNECE_REC_21.json"),
        ],
        DOWNLOADDEF_KEY_URL_HP => [
            "https://www.xrepository.de/details/urn:xoev-de:kosit:codeliste:rec20",
            "https://www.xrepository.de/details/urn:xoev-de:kosit:codeliste:rec21",
        ],
        DOWNLOADDEF_KEY_CLASSNAMESPACE => "horstoeko\zugferd\codelists",
        DOWNLOADDEF_KEY_CLASSNAME => "ZugferdUnitCodes",
        DOWNLOADDEF_KEY_TITLE => "list of codes for units of measure used in international trade",
        DOWNLOADDEF_KEY_TITLE_LIST => "UN/ECE Recommendation N°20 and N°21",
        DOWNLOADDEF_KEY_SHORTIDENTIFIERS => true,
        DOWNLOADDEF_KEY_ADDMETHODS => DOWNLOADDEF_KEY_ADDMETHODS_DEFAULT,
        DOWNLOADDEF_KEY_DATA_SORTINDEX => 1,
        DOWNLOADDEF_KEY_CLASSCONSTANT_PREFIX => ["REC20_", "REC21_"],
    ],
    [
        DOWNLOADDEF_KEY_ENABLED => true,
        DOWNLOADDEF_LIB_NAME => 'zugferd',
        DOWNLOADDEF_LIB_TITLE => 'Zugferd',
        DOWNLOADDEF_KEY_URL => [
            "https://www.xrepository.de/api/xrepository/urn:xoev-de:kosit:codeliste:untdid.5305_3/download/UNTDID_5305_3.json",
        ],
        DOWNLOADDEF_KEY_TOFILE => [
            PathUtils::combinePathWithFile(PathUtils::combineAllPaths(__DIR__, "download"), "UNTDID_5305.json"),
        ],
        DOWNLOADDEF_KEY_URL_HP => "https://www.xrepository.de/details/urn:xoev-de:kosit:codeliste:untdid.5305_3",
        DOWNLOADDEF_KEY_CLASSNAMESPACE => "horstoeko\zugferd\codelists",
        DOWNLOADDEF_KEY_CLASSNAME => "ZugferdVatCategoryCodes",
        DOWNLOADDEF_KEY_TITLE => "list of duty or tax or fee category codes",
        DOWNLOADDEF_KEY_TITLE_LIST => "UNTDID 5305 Duty or tax or fee category code",
        DOWNLOADDEF_KEY_SHORTIDENTIFIERS => true,
        DOWNLOADDEF_KEY_ADDMETHODS => DOWNLOADDEF_KEY_ADDMETHODS_DEFAULT,
        DOWNLOADDEF_KEY_DATA_SORTINDEX => 1,
        DOWNLOADDEF_KEY_CLASSCONSTANT_PREFIX => [],
    ],
    [
        DOWNLOADDEF_KEY_ENABLED => true,
        DOWNLOADDEF_LIB_NAME => 'zugferd',
        DOWNLOADDEF_LIB_TITLE => 'Zugferd',
        DOWNLOADDEF_KEY_URL => [
            PathUtils::combinePathWithFile(PathUtils::combineAllPaths(__DIR__, "download"), "UNTDID_1229.csv"),
        ],
        DOWNLOADDEF_KEY_TOFILE => [
            PathUtils::combinePathWithFile(PathUtils::combineAllPaths(__DIR__, "download"), "UNTDID_1229.csv"),
        ],
        DOWNLOADDEF_KEY_URL_HP => "https://service.unece.org/trade/untdid/d05a/tred/tred1229.htm",
        DOWNLOADDEF_KEY_CLASSNAMESPACE => "horstoeko\zugferd\codelists",
        DOWNLOADDEF_KEY_CLASSNAME => "ZugferdLineStatusCodes",
        DOWNLOADDEF_KEY_TITLE => "list of codes specifying an action request/notification",
        DOWNLOADDEF_KEY_TITLE_LIST => "UNTDID 1229 Action request/notification description code",
        DOWNLOADDEF_KEY_SHORTIDENTIFIERS => true,
        DOWNLOADDEF_KEY_SHORTIDENTIFIERS_LENGTH => 6,
        DOWNLOADDEF_KEY_ADDMETHODS => DOWNLOADDEF_KEY_ADDMETHODS_DEFAULT,
        DOWNLOADDEF_KEY_DATA_SORTINDEX => 0,
        DOWNLOADDEF_KEY_CLASSCONSTANT_PREFIX => [],
        DOWNLOADDEF_KEY_CLASSCREATORFUNC => 'createCodeClassFromCsv',
    ],
];

outputLine("\n\nCodelist Generator v1.0\n----------------------------------------\n");

downloadLists($filesToDownload);
createCodeClasses($filesToDownload);

outputLine("\n");
