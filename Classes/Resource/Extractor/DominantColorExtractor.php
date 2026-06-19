<?php
namespace MiniFranske\LazyLoadPlaceholder\Resource\Extractor;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Resource\FileType;
use TYPO3\CMS\Core\Resource\Index\ExtractorInterface;
use ColorThief\ColorThief;
use ColorThief\Exception\Exception as ColorThiefException;

/**
 * Class DominantColorExtractor
 * @package MiniFranske\LazyLoadPlaceholder\Resource\Extractor
 */
class DominantColorExtractor implements ExtractorInterface
{
    /**
     * @return array
     */
    public function getFileTypeRestrictions()
    {
        return [FileType::IMAGE->value];
    }

    /**
     * @return array
     */
    public function getDriverRestrictions()
    {
        return [];
    }

    /**
     * @return int
     */
    public function getPriority()
    {
        return 10;
    }

    /**
     * @return int
     */
    public function getExecutionPriority()
    {
        return 10;
    }

    /**
     * @param File $file
     * @return bool
     */
    public function canProcess(File $file)
    {
        return in_array($file->getExtension(), ['jpg', 'jpeg', 'gif', 'png'], true);
    }

    /**
     * @param File $file
     * @param array $previousExtractedData
     * @return array
     */
    public function extractMetaData(File $file, array $previousExtractedData = [])
    {
        $metaData = [];
        try {
            $color = ColorThief::getColor($file->getContents());
        } catch (ColorThiefException $exception) {
            return $metaData;
        }
        if ($color) {
            $metaData['dominant_color'] = sprintf('#%02x%02x%02x', $color[0], $color[1], $color[2]);
        }
        return $metaData;
    }
}
