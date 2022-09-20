<?php
// base/default response
$response = array(
    'baseURL' => $this->conf['baseURL'],
    'request' => $this->route['request'],
    'dataBakedOn' => microtime(true),
);






// process requests
// route vars 'get' and 'id' are set for sure since since we validate each request route first
switch ($this->route['var']['get']) {
    case 'audio':
        $r = $this->getAudioByID($this->route['var']['id']);
        break;

    case 'visual':
        $r = $this->getVisual('byID', array('id' => $this->route['var']['id']));

        if ($r) {
            $meta = array(
                'link' => sprintf('%1$svisual/id:%2$s', $this->conf['baseURL'], $r['id']),
                'thumb' => sprintf('%1$sfile/visual/%2$s-tn.jpg', $this->conf['baseURL'], $r['id']),
            );

            foreach ($r['media'] as $k => $v) {
                $r['media'][$k]['url'] = sprintf('%1$s%2$s', $this->conf['baseURL'], $v['slug']);
                unset($r['media'][$k]['slug']);
            }

            $r = array_merge($meta, $r);
        }
        break;
}





if ($r) {
    $response['data'] = $r;
}
else {
    $response['error'] = 'request returned no data';
}







// output response
$response = jsonEncode($response);
print($response);






















// $response = [
//     'baseURL' => $this->conf['baseURL'],
//     'request' => $this->route['request'],
//     'error' => [],
//     'data' => false,
// ];
// // $responseData = false;


// if (!isset($this->route['var']['get'])) return;



// switch ($this->route['var']['get']) {
//     case 'audioRelease':
//         if (
//             !isset($this->route['var']['id']) ||
//             ctype_digit($this->route['var']['id'])
//         ) {
//             $response['error'][] = 'invalid request';
//             break;
//         }

//         $q = 'SELECT id, releaseName FROM audioRelease WHERE id = :id;';
//         $v = [
//             ['id', $this->route['var']['id'], SQLITE3_INTEGER]
//         ];
//         $r = $this->DB->query($q, $v);
//         if ($r) $response['data'] = $r;
//         break;
// }



// if (!$responseData) {
//     $response['error'][] = 'failed to fetch responseData';
// }



// $response = jsonEncode([
//     'baseURL' => $this->conf['baseURL'],
//     'request' => $this->route['request'],
//     'data' => $responseData,
// ]);




// print($response);
