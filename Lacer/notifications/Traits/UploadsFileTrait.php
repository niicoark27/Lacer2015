<?php
/**
 * Created by PhpStorm.
 * User: kwabenaboadu
 * Date: 5/22/15
 * Time: 7:02 AM
 */

namespace App\Vasoft\Traits;


trait UploadsFileTrait {

    /**
     * @throws Exception
     */
    protected function validateFile() {
        if (!$this->file->isValid()) {
            throw new Exception($this->translator->get(self::NO_FILE_UPLOADED));
        }
    }

    /**
     * Returns the file upload path
     * @param $path
     * @return string
     */
    protected function getUploadPath($path) {
        if (!file_exists($path)) {
            mkdir($path, 0755, TRUE);
        }

        return $path;
    }

    /**
     * Returns the name of the file
     * @param $filename
     * @return string
     * @throws Exception
     */
    protected function getFilename($filename) {
        return hash('md5', uniqid($filename)) . '.' . $this->getFileExtension();
    }

    /**
     * Returns the file extension
     * @return null|string
     * @throws Exception
     */
    protected function getFileExtension() {
        $extension = $this->file->getExtension();
        if (empty($extension)) {
            $extension = $this->file->guessExtension();
        }
        if (empty($extension)) {
            $extension = $this->file->getClientOriginalExtension();
        }

        if (empty($extension)) {
            throw new Exception($this->translator->get(self::FILE_EXT_ERROR));
        }

        return $extension;
    }

    /**
     * Delete the existing file
     * @param $file_path
     */
    protected function deleteExistingFile($file_path) {
        if (empty($file_path)) {
            return;
        }

        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }
}