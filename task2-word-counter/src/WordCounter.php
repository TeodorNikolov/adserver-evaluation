<?php

class WordCounter
{
    private string $storageFile;

    public function __construct(string $storageFile)
    {
        $this->storageFile = $storageFile;

        $directory = dirname($storageFile);

        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }
    }

    public function addText(string $text): void
    {
        $fp = fopen($this->storageFile, 'c+');

        if ($fp === false) {
            throw new RuntimeException('Unable to open storage file.');
        }

        try {
            if (!flock($fp, LOCK_EX)) {
                throw new RuntimeException('Unable to lock storage file.');
            }

            $contents = stream_get_contents($fp);

            $data = $contents
                ? json_decode($contents, true)
                : [];

            if (!is_array($data)) {
                $data = [];
            }

            preg_match_all(
                '/[\p{L}\p{N}]+/u',
                mb_strtolower($text),
                $matches
            );

            foreach ($matches[0] as $word) {
                $data[$word] = ($data[$word] ?? 0) + 1;
            }

            ksort($data);

            rewind($fp);
            ftruncate($fp, 0);

            fwrite(
                $fp,
                json_encode(
                    $data,
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
                )
            );

            fflush($fp);
            flock($fp, LOCK_UN);
        } finally {
            fclose($fp);
        }
    }

    public function getAll(): array
    {
        return $this->load();
    }

    public function getCount(string $word): int
    {
        $data = $this->load();

        return $data[mb_strtolower($word)] ?? 0;
    }

    private function load(): array
    {
        if (!file_exists($this->storageFile)) {
            return [];
        }

        $fp = fopen($this->storageFile, 'r');

        if ($fp === false) {
            return [];
        }

        try {
            flock($fp, LOCK_SH);

            $contents = stream_get_contents($fp);

            flock($fp, LOCK_UN);

            if ($contents === false || trim($contents) === '') {
                return [];
            }

            $data = json_decode($contents, true);

            return is_array($data) ? $data : [];
        } finally {
            fclose($fp);
        }
    }
}
