<?php

$data = getDataFromFile('data.txt');
printTree($data);

/**
 * @param string $filename
 * @return array
 */
function getDataFromFile(string $filename): array
{
    $data = [];

    $handle = fopen($filename, 'r');

    if ($handle) {
        while (($buffer = fgets($handle)) !== false) {
            $buffer = trim($buffer);

            if (strlen($buffer)) {
                list($id, $parentId, $name) = explode('|', $buffer);
                $data[intval(trim($id))] = ['parent_id' => intval(trim($parentId)), 'name' => trim($name)];
            }
        }

        if (!feof($handle)) {
            echo 'End of file error!';
        }

        fclose($handle);
    }

    return $data;
}

/**
 * @param array $data
 * @param int $level
 * @param int $parentId
 */
function printTree(array &$data, $level = 0, $parentId = 0): void
{
    foreach ($data as $id => $item) {
        if ($parentId === $item['parent_id']) {
            printTreeItem($item['name'], $level);
            unset($data[$id]);
            printTree($data, $level + 1, $id);
        }
    }
}

/**
 * @param $name
 * @param int $indent
 */
function printTreeItem($name, $indent = 0): void
{
    echo str_repeat('-', $indent) . "$name" . PHP_EOL;
}