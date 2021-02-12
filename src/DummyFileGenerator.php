<?php

namespace CodeCauldron\Tools\File;

class DummyFileGenerator
{

    const MAX_SIZE = 200 * 1024 * 1024; // 200MB

    const B = 0;

    const KB = 1;

    const MB = 2;

    const GB = 3;

    /**
     * Creates a dummy file of a defined size
     *
     * @param int $size
     * @param int $unit 0=B, 1=kB, 2=MB (default), 3=GB
     */
    public function generateFile(int $size, int $unit = 2): void
    {
        $size = floor($size * pow(1024, $unit));

        if ($size >= 0 && $size <= DummyFileGenerator::MAX_SIZE) {
            if (! file_exists("$size.txt.gz")) {
                $this->writeDummyFile($size);
                $this->writeZipFile($size);

                unlink("$size.txt"); // remove the original dummy file after finished compression
            }
            $this->download($size);
        }
    }

    /**
     * Create the a dummy file on disk
     *
     * @param int $size
     *
     * @return void
     */
    private function writeDummyFile(int $size): void
    {
        $fp = fopen("$size.txt", "w");

        // Put a character at the end (the size in bytes - 1) of the file
        fseek($fp, $size - 1, SEEK_CUR);
        fwrite($fp, 'a');

        fclose($fp);
    }

    /**
     * Compress the dummy file to make it take up far less disk space
     *
     * @param int $size
     */
    private function writeZipFile(int $size): void
    {
        $data           = implode("", file("$size.txt")); // Read data from the dummy file
        $compressedData = gzencode($data, 9); // Use maximum compression level

        //Write the compressed data
        $fp = fopen("$size.txt.gz", "w");
        fwrite($fp, $compressedData);

        fclose($fp);
    }

    /**
     * Send the file to the browser
     *
     * @param int $size
     */
    private function download(int $size): void
    {
        $type = mime_content_type("$size.txt.gz");

        // Send file headers
        header("Content-type: $type");
        header("Content-Disposition: attachment;filename=\"$size.txt.gz\"");
        header("Content-Transfer-Encoding: binary");
        header("Pragma: no-cache");
        header("Expires: 0");
        // Send the file contents.
        set_time_limit(0);
        readfile("$size.txt.gz");
    }
}
