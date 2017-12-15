<?php

$articleRoot = '.';
$category = ['HOME'];
$cateList = [
    'HOME' => [],
];

$allRootFiles = scandir($articleRoot);

// 获取所有md文件
foreach ($allRootFiles as $file) {
    if ($file == '.' || $file == '..' || !is_dir($file)) {
        continue;
    }
    $subDir = $articleRoot . '/' . $file;
    $subMdFiles = glob($subDir . '/*.md');

    if (count($subMdFiles)) {
        array_push($category, $file);
        $mdListInfo = [];
        foreach ($subMdFiles as $mdName) {
            $mdContent = file_get_contents($mdName);
            $notes = getNoteArr($mdContent);

            // 如果没有写创建时间，则获取文件的创建时间
            if (count($notes) == 0 || !$notes['date']) {
                $cTime = filectime($mdName);
                $notes['date'] = date('Y-m-d', $cTime);
            }

            $notes['dateS'] = explode('-', $notes['date']);

            $mdListInfo[] = [
                'name' => mb_substr(basename($mdName), 0, -3),
                'notes' => $notes,
                'cate' => $file
            ];
        }

        $cateList[$file] = $mdListInfo;
    }
}

// file_put_contents('./category.json', json_encode($category));

// 对md文件排序
$newList = [];
foreach ($cateList as $key => $mdList) {
    if (count($mdList) > 0) {
        $mdList = sortList($mdList);
        $cateList[$key] = $mdList;
        file_put_contents('./' . $key . '.json', json_encode($mdList));

        // 获取每个分类最新的8个文章
        $topEight = array_slice($mdList, 0, 8);
        $newList = array_merge($newList, $topEight);
    }
}


// 对newList 排序
$newList = sortList($newList);
file_put_contents('./' . $category[0] . '.json', json_encode(array_slice($newList, 0, 8)));


function getNoteArr($mdContent)
{

    $noteArr = [];

    $note = [];
    $note = explode('--END', $mdContent);
    $note = $note[0];
    $note = explode('[^_^]:', $note);
    $note = $note[1];
    $note = explode("\n", $note);

    foreach ($note as $value) {
        if ($value != '') {
            $exArr = explode(':', $value);

            if (count($exArr) >= 2) {
                $k = trim($exArr[0]);
                $v = trim($exArr[1]);
                $noteArr[$k] = $v;
            }
        }
    }

    return $noteArr;
}

function sortList($mdList)
{
    $len = count($mdList);

    for($k=1; $k<$len; $k++){

        for($j=0; $j<$len-$k; $j++){
            $timeA = strtotime($mdList[$j]['notes']['date']);
            $timeB = strtotime($mdList[$j+1]['notes']['date']);

            if($timeA < $timeB){
                $temp = $mdList[$j+1];
                $mdList[$j+1] = $mdList[$j];
                $mdList[$j] = $temp;
            }
        }

    }

    return $mdList;
}



