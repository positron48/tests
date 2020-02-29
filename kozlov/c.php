<?php

class Autoload
{
    const TYPE_DEFAULT = 'default';
    const TYPE_CAMEL = 'camel';
    const TYPE_LOWER = 'lower';
    const TYPE_SNAKE = 'snake';

    protected $baseDir;
    protected $namespace;
    protected $type;

    public function __construct(array $json)
    {
        $this->baseDir = $json['base_dir'];
        $this->namespace = $json['namespace'] . '\\';
        $this->type = $json['type'];

        //поиск происхождит в папке
        if ('/' !== substr($this->baseDir, -1)) {
            $this->baseDir .= '/';
        }
    }

    /**
     * @param string $filename
     *
     * @return string|false
     */
    public function getAutoloadPath(string $filename)
    {
        if (!$this->isMatchNamespace($filename)) {
            return false;
        }

        $filename = substr($filename, strlen($this->namespace));
        $filenameParts = explode('\\', $filename);
        foreach ($filenameParts as &$filenamePart) {
            $filenamePart = $this->convertFilename($filenamePart);
        }

        $newFilename = implode('/', $filenameParts);

        return $this->baseDir . $newFilename . '.php';
    }

    protected function isMatchNamespace(string $filename): bool
    {
        return 0 === strpos($filename, $this->namespace);
    }

    protected function convertFilename(string $filename)
    {
        switch ($this->type) {
            case self::TYPE_CAMEL:
                $filename = lcfirst($filename);
                break;

            case self::TYPE_LOWER:
                $filename = strtolower($filename);
                break;

            case self::TYPE_SNAKE:
                $filename = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $filename));
                break;

            case self::TYPE_DEFAULT:
            default:
                //do nothing;
        }

        return $filename;
    }
}

$input = fopen($argv[1], 'r');

$rulesRaw = json_decode(trim(fgets($input)), true);

/** @var Autoload[] $rules */
$rules = [];

foreach ($rulesRaw as $ruleRaw) {
    $rules[] = new Autoload($ruleRaw);
}

while (false !== ($inputLine = fgets($input))) {
    $inputLine = trim($inputLine);
    if (empty($inputLine)) {
        break;
    }
    echo $inputLine . "\n";
    foreach ($rules as $rule) {
        if ($autoloadResult = $rule->getAutoloadPath($inputLine)) {
            echo $autoloadResult . "\n";
        }
    }
    echo "\n";
}

fclose($input);
