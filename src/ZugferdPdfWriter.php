<?php

/**
 * This file is a part of horstoeko/zugferd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\zugferd;

use setasign\Fpdi\Fpdi as PdfFpdi;

/**
 * Class representing some tools for pdf generation
 *
 * @category Zugferd
 * @package  Zugferd
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/zugferd
 */
class ZugferdPdfWriter extends PdfFpdi
{
    /**
     * Contains all attached files
     *
     * @var array
     */
    protected $files = [];

    /**
     * Contains meta data
     *
     * @var array
     */
    protected $metaDataDescriptions = [];

    /**
     * Contains meta data
     *
     * @var array
     */
    protected $metaDataInfos = [];

    /**
     * Internal index
     *
     * @var integer
     */
    protected $fileSpecDictionnaryIndex = 0;

    /**
     * Internal index
     *
     * @var integer
     */
    protected $descriptionIndex = 0;

    /**
     * Internal index
     *
     * @var integer
     */
    protected $outputIntentIndex = 0;

    /**
     * Internal index
     *
     * @var integer
     */
    protected $filesIndex;

    /**
     * Internal flag that indicates that the attachment
     * pane should be shown by default
     *
     * @var boolean
     */
    protected $openAttachmentPane = false;

    /**
     * Internal flag deterministic mode. This mode should only be used
     * for testing purposes
     *
     * @var boolean
     */
    protected $deterministicModeEnabled = false;

    /**
     * Set the PDF version.
     *
     * @param  string $version     Contains the PDF version number.
     * @param  bool   $binary_data This is true for binary data
     * @return void
     */
    public function setPdfVersion($version = '1.3', $binary_data = false): void
    {
        $this->PDFVersion = sprintf('%.1F', $version);

        if (true == $binary_data) {
            if ($this->deterministicModeEnabled === true) {
                $this->PDFVersion .= "\n" . '%' . chr(128) . chr(129) . chr(130) . chr(131);
            } else {
                $this->PDFVersion .= "\n" . '%' . chr(random_int(128, 255)) . chr(random_int(128, 255)) . chr(random_int(128, 255)) . chr(random_int(128, 255));
            }
        }
    }

    /**
     * Attach file to PDF.
     *
     * @param  mixed  $file
     * Data to embed to the pdf
     * @param  string $name
     * The visible attachment filename
     * @param  string $desc
     * The description for the attached file
     * @param  string $relationship
     * The type of the relationship of the attached file
     * @param  string $mimetype
     * The url-encoded mimetype of the attached file
     * @param  bool   $isUTF8
     * Set to true, if the attached file is UTF-8 encoded
     * @return void
     */
    public function attach($file, $name = '', $desc = '', $relationship = 'Unspecified', $mimetype = '', $isUTF8 = false): void
    {
        if ('' == $name) {
            $p = strrpos($file, '/');
            if (false === $p) {
                $p = strrpos($file, '\\');
            }

            $name = false !== $p ? substr($file, $p + 1) : $file;
        }

        if (!$isUTF8) {
            $desc = mb_convert_encoding($desc, 'UTF-8', mb_list_encodings());
        }

        if ('' == $mimetype) {
            $mimetype = mime_content_type($file);
            if ($mimetype === '' || $mimetype === '0' || $mimetype === false) {
                $mimetype = 'application/octet-stream';
            }
        }

        $mimetype = str_replace('/', '#2F', $mimetype);
        $this->files[] = ['file' => $file, 'name' => $name, 'desc' => $desc, 'relationship' => $relationship, 'subtype' => $mimetype];
    }

    /**
     * Open attachment panel on PDF.
     *
     * @return void
     */
    public function openAttachmentPane(): void
    {
        $this->openAttachmentPane = true;
    }

    /**
     * Add metadata description node.
     *
     * @param  string $description
     * The description of the metadata
     * @return void
     */
    public function addMetadataDescriptionNode($description): void
    {
        $this->metaDataDescriptions[] = $description;
    }

    /**
     * Set PDF metadata infos.
     *
     * @param  array $metaDataInfos
     * The array with metadata information applied to the pdf
     * @return void
     */
    public function setPdfMetadataInfos(array &$metaDataInfos): void
    {
        if ($this->deterministicModeEnabled === true) {
            $metaDataInfos['createdDate'] = date('Y-m-d\TH:i:s', strtotime("2000-01-01 23:59:59"));
            $metaDataInfos['modifiedDate'] = date('Y-m-d\TH:i:s', strtotime("2000-01-01 23:59:59"));
        }

        $this->metaDataInfos = $metaDataInfos;
    }

    /**
     * Set the status of the deterministic mode. This mode should only be used
     * for testing purposes
     *
     * @param  bool $deterministicModeEnabled
     * @return void
     */
    public function setDeterministicModeEnabled(bool $deterministicModeEnabled): void
    {
        $this->deterministicModeEnabled = $deterministicModeEnabled;
    }

    /**
     * Put files.
     *
     * @return void
     *
     * @codingStandardsIgnoreStart
     */
    protected function _putfiles(): void
    {
        foreach ($this->files as &$info) {
            $this->putFileSpecification($info);
            $info['file_index'] = $this->n;
            $this->putFileStream($info);
        }

        $this->putFileDictionary();
    }

    /**
     * Put file attachment specification.
     *
     * @param array $file_info
     * @return void
     */
    protected function putFileSpecification(array $file_info): void
    {
        $this->_newobj();
        $this->fileSpecDictionnaryIndex = $this->n;
        $this->_put('<<');
        $this->_put('/F (' . $this->_escape($file_info['name']) . ')');
        $this->_put('/Type /Filespec');
        $this->_put('/UF ' . $this->_textstring(mb_convert_encoding($file_info['name'], 'UTF-8', mb_list_encodings())));
        if ($file_info['relationship']) {
            $this->_put('/AFRelationship /' . $file_info['relationship']);
        }

        if ($file_info['desc']) {
            $this->_put('/Desc ' . $this->_textstring($file_info['desc']));
        }

        $this->_put('/EF <<');
        $this->_put('/F ' . ($this->n + 1) . ' 0 R');
        $this->_put('/UF ' . ($this->n + 1) . ' 0 R');
        $this->_put('>>');
        $this->_put('>>');
        $this->_put('endobj');
    }

    /**
     * Put file stream.
     *
     * @param array $file_info
     */
    protected function putFileStream(array $file_info): void
    {
        $this->_newobj();
        $this->_put('<<');
        $this->_put('/Filter /FlateDecode');
        if ($file_info['subtype']) {
            $this->_put('/Subtype /' . $file_info['subtype']);
        }

        $this->_put('/Type /EmbeddedFile');
        if (is_string($file_info['file']) && @is_file($file_info['file'])) {
            $fc = file_get_contents($file_info['file']);
        } else {
            $stream = $file_info['file']->getStream();
            \fseek($stream, 0);
            $fc = stream_get_contents($stream);
        }

        if (false === $fc) {
            $this->Error('Cannot open file: ' . $file_info['file']);
        }

        if ($this->deterministicModeEnabled === true) {
            $md = @date('YmdHis', strtotime("2000-01-01 23:59:59"));
        } elseif (is_string($file_info['file'])) {
            $md = @date('YmdHis', filemtime($file_info['file']));
        } else {
            $md = @date('YmdHis');
        }

        $fc = gzcompress($fc);
        $this->_put('/Length ' . strlen($fc));
        $this->_put(sprintf('/Params <</ModDate (D:%s)>>', $md));
        $this->_put('>>');
        $this->_putstream($fc);
        $this->_put('endobj');
    }

    /**
     * Put file dictionnary.
     *
     * @return void
     */
    protected function putFileDictionary(): void
    {
        $this->_newobj();
        $this->filesIndex = $this->n;
        $this->_put('<<');
        $s = '';
        $files = $this->files;
        usort($files, function ($a, $b) { // Sorting files in name order as PDF specs (if not, issue with Acrobat Reader when trying to download attachments)
            return strcmp($a['name'], $b['name']);
        });
        foreach ($files as $info) {
            $s .= sprintf('%s %s 0 R ', $this->_textstring($info['name']), $info['file_index']);
        }

        $this->_put(sprintf('/Names [%s]', $s));
        $this->_put('>>');
        $this->_put('endobj');
    }

    /**
     * Put metadata descriptions.
     *
     * @return void
     */
    protected function putMetadataDescriptions(): void
    {
        $s = '<?xpacket begin="" id="W5M0MpCehiHzreSzNTczkc9d"?>' . "\n";
        $s .= '<x:xmpmeta xmlns:x="adobe:ns:meta/">' . "\n";
        $s .= '<rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#">' . "\n";
        $this->_newobj();
        $this->descriptionIndex = $this->n;
        foreach ($this->metaDataDescriptions as $desc) {
            $s .= $desc . "\n";
        }

        $s .= '</rdf:RDF>' . "\n";
        $s .= '</x:xmpmeta>' . "\n";
        $s .= '<?xpacket end="w"?>';
        $this->_put('<<');
        $this->_put('/Length ' . strlen($s));
        $this->_put('/Type /Metadata');
        $this->_put('/Subtype /XML');
        $this->_put('>>');
        $this->_putstream($s);
        $this->_put('endobj');
    }

    /**
     * Put resources including files and metadata descriptions.
     *
     * @return void
     * @codingStandardsIgnoreStart
     */
    protected function _putresources(): void
    {
        parent::_putresources();

        if ($this->files !== []) {
            $this->_putfiles();
        }

        $this->_putoutputintent();

        if (!empty($this->metaDataDescriptions)) {
            $this->putMetadataDescriptions();
        }
    }

    /**
     * Put output intent with ICC profile.
     *
     * @return void
     * @codingStandardsIgnoreStart
     */
    protected function _putoutputintent(): void
    {
        $this->_newobj();
        $this->_put('<<');
        $this->_put('/Type /OutputIntent');
        $this->_put('/S /GTS_PDFA1');
        $this->_put('/OuputCondition (sRGB)');
        $this->_put('/OutputConditionIdentifier (Custom)');
        $this->_put('/DestOutputProfile ' . ($this->n + 1) . ' 0 R');
        $this->_put('/Info (sRGB V4 ICC)');
        $this->_put('>>');
        $this->_put('endobj');
        $this->outputIntentIndex = $this->n;

        $icc = file_get_contents(ZugferdSettings::getFullIccProfileFilename());
        $icc = gzcompress($icc);

        $this->_newobj();
        $this->_put('<<');
        $this->_put('/Length ' . strlen($icc));
        $this->_put('/N 3');
        $this->_put('/Filter /FlateDecode');
        $this->_put('>>');
        $this->_putstream($icc);
        $this->_put('endobj');
    }

    /**
     * Put catalog node, including associated files.
     *
     * @return void
     * @codingStandardsIgnoreStart
     */
    protected function _putcatalog(): void
    {
        parent::_putcatalog();

        if ($this->files !== []) {
            if (is_array($this->files)) {
                $files_ref_str = '';
                foreach ($this->files as $file) {
                    if ('' !== $files_ref_str) {
                        $files_ref_str .= ' ';
                    }

                    $files_ref_str .= sprintf('%s 0 R', $file['file_index']);
                }

                $this->_put(sprintf('/AF [%s]', $files_ref_str));
            } else {
                $this->_put(sprintf('/AF %s 0 R', $this->filesIndex));
            }
        }

        if (0 != $this->descriptionIndex) {
            $this->_put(sprintf('/Metadata %s 0 R', $this->descriptionIndex));
        }

        if ($this->files !== []) {
            $this->_put('/Names <<');
            $this->_put('/EmbeddedFiles ');
            $this->_put(sprintf('%s 0 R', $this->filesIndex));
            $this->_put('>>');
        }

        if (0 != $this->outputIntentIndex) {
            $this->_put(sprintf('/OutputIntents [%s 0 R]', $this->outputIntentIndex));
        }

        if ($this->openAttachmentPane) {
            $this->_put('/PageMode /UseAttachments');
        }
    }

    /**
     * Put trailer including ID.
     *
     * @return void
     * @codingStandardsIgnoreStart
     */
    protected function _puttrailer(): void
    {
        parent::_puttrailer();

        $created_id = md5($this->generateMetadataString("created"));
        $modified_id = md5($this->generateMetadataString("modified"));

        $this->_put(sprintf('/ID [<%s><%s>]', $created_id, $modified_id));
    }

    /**
     * Put general information
     *
     * @return void
     */
    protected function _putinfo(): void
    {
        if ($this->deterministicModeEnabled === true) {
            $this->CreationDate = strtotime("2000-01-01 23:59:59");
        }

        parent::_putinfo();
    }

    /**
     * Generate metadata string.
     *
     * @param string|null $dateType
     * The type of the metadata date
     * @return string
     * @codingStandardsIgnoreStart
     */
    protected function generateMetadataString(?string $dateType = null)
    {
        $dateType = $dateType ?? "created";
        $metaDataString = '';

        if (isset($this->metaDataInfos['title'])) {
            $metaDataString .= $this->metaDataInfos['title'];
        }

        if (isset($this->metaDataInfos['subject'])) {
            $metaDataString .= $this->metaDataInfos['subject'];
        }

        if ($dateType === "modified" && isset($this->metaDataInfos['modifiedDate'])) {
            $metaDataString .= $this->metaDataInfos['modifiedDate'];
        }

        if ($dateType === "created" && isset($this->metaDataInfos['createdDate'])) {
            $metaDataString .= $this->metaDataInfos['createdDate'];
        }

        return $metaDataString;
    }
}
